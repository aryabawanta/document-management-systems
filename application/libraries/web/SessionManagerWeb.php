<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// inisialisasi
session_start();

class SessionManagerWeb {

    const INDEX = 'sakti';

    /**
     * Mendapatkan data session
     * @param string $index
     * @return mixed
     */
    protected static function get($index) {
        return $_SESSION[self::INDEX][$index];
    }

    /**
     * Mengubah data session
     * @param string $index
     * @param mixed $data
     */
    protected static function set($index, $data) {
        return $_SESSION[self::INDEX][$index] = $data;
    }

    public function add($index, $data){
        foreach ($data as $key => $value) {
            $_SESSION[self::INDEX][$index][$key] = $value;
        }
        return $_SESSION[self::INDEX][$index];
    }

    /**
     * Menghapus data session
     */
    public static function destroy() {
        unset($_SESSION[self::INDEX]);
    }

    /**
     * Mengambil data flash
     * @return mixed
     */
    public static function getFlash() {
        $flash = $_SESSION[self::INDEX]['flash'];
        unset($_SESSION[self::INDEX]['flash']);

        return $flash;
    }

    /**
     * Menyimpan data untuk di-flash kemudian
     * @param mixed $data
     */
    public static function setFlash($data) {
        $_SESSION[self::INDEX]['flash'] = $data;
    }

    /**
     * Cek apakah sudah login
     * @return bool
     */
    public static function isAuthenticated() {
        $auth = self::get('auth');

        return empty($auth['isauthenticated']) ? false : true;
    }

    public function removeAuthenticated(){
        unset($_SESSION[self::INDEX]['auth']['isauthenticated']);
        unset($_SESSION[self::INDEX]['auth']['userid']);
    }

    public function getIndex(){
        return self::INDEX;
    }

    /**
     * Mendapatkan userid
     * @return string
     */
    public static function getUserID() {
        $auth = self::get('auth');

        return $auth['userid'];
    }

    /**
     * Mendapatkan username
     * @return string
     */
    public static function getUserName() {
        $auth = self::get('auth');

        return $auth['username'];
    }

    /**
     * Mendapatkan name
     * @return string
     */
    public static function getName() {
        $auth = self::get('auth');

        return $auth['name'];
    }

    public static function getRole() {
        $auth = self::get('auth');

        return $auth['role'];
    }

    /**
     * Mendapatkan unit kerja
     * @return string
     */
    public static function isStaffCamatKuta() {
        $auth = self::get('auth');

        return ($auth['workunit_id'] == 1 or $auth['unitkerja_id'] == 1) ? true : false;
    }

    public static function isAdministrator(){
        $auth = self::get('auth');

        return ($auth['role'] == Role::ADMINISTRATOR) ? true : false;
    }

    public static function isUser(){
        $auth = self::get('auth');

        return ($auth['role'] == Role::USER) ? true : false;
    }

    /**
     * Mendapatkan foto
     * @return string
     */
    public static function getPhoto($size='48') {
        // $foto = self::get('photo');
        // if (strstr($foto, 'nopic.png'))
        //     return $foto;
        // else
        //     return $foto .'/' . $size;
        return self::get('photo');
    }

    public static function getApplicationName() {
        $auth = self::get('auth');
        return $auth['application_name'];
    }

    /**
     * Menyimpan data user
     * @param array $user
     */
    public static function setUser($user) {
        $data = array();
        $data['userid'] = $user['id'];
        $data['username'] = $user['username'];
        $data['name'] = $user['name'];
        $data['email'] = $user['email'];
        $data['whatsapp'] = $user['whatsapp'];
        // $data['workunit_id'] = $user['workunit_id'];
        $data['isauthenticated'] = true;
        $data['role'] = $user['role'];
        self::set('auth', $data);

        // sekalian foto
        self::setPhoto($user);
    }

    public function setLoginAs($user){
        self::set('init_auth', self::get('auth'));
        self::set('init_photo', self::get('photo'));
        self::setUser($user);
        self::set('is_login_as', true);
    }

    public function removeLoginAs(){
        self::set('auth', self::get('init_auth'));
        self::set('photo', self::get('init_photo'));
        
        unset($_SESSION[self::INDEX]['init_auth']);
        unset($_SESSION[self::INDEX]['init_photo']);
        unset($_SESSION[self::INDEX]['is_login_as']);
    }

    public static function isLoginAs(){
        $is_login_as = self::get('is_login_as');

        return (isset($is_login_as)) ? true : false;
    }

    public function setUserName($username=''){
        $data = array();
        $data['username'] = $username;
        self::set('auth', $data);
    }

    public static function addAuthenticated($data) {
        self::set('auth', $data);
    }

    public static function setApplicationName($application_name) {
        $_SESSION[self::INDEX]['auth']['application_name'] = $application_name;
    }

    public static function setVariables($variables=NULL, $index=null) {
        if (!empty($index))
            $_SESSION[self::INDEX]['auth']['variables'][$index] = $variables;
        else
            $_SESSION[self::INDEX]['auth']['variables'] = $variables;
    }

    public static function getVariables($index=null) {
        $auth = self::get('auth');
        return (empty($index) ? $auth['variables'] : $auth['variables'][$index] ) ;
    }

    public static function removeVariables($index=null){
        if (empty($index))
            unset($_SESSION[self::INDEX]['auth']['variables']);
        else
            unset($_SESSION[self::INDEX]['auth']['variables'][$index]);
    }

    /**
     * Menyimpan data foto
     * @param array $user
     */
    public static function setPhoto($user) {
        if (isset($user['photo'])){
            // $data = site_url(WEB_Controller::CTL_PATH.'thumb/watermark/'.$user['id']);
            $data = $user['photo'][strtolower(Image::IMAGE_ORIGINAL)]['link'];
        }
        else{
            $data = base_url('assets/uploads/users/photos/nopic.png');
        }

        self::set('photo', $data);
    }

    /**
     * Menyimpan data pesan setelah aksi untuk di-flash
     * @param bool $ok
     * @param string $msg
     */
    public static function setFlashMsg($ok, $msg) {
        $data = array();
        $data['srvok'] = $ok;
        $data['srvmsg'] = $msg;

        self::setFlash($data);
    }
}

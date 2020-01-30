<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class User_log_model extends AppModel {
        const TYPE_ACCESS = 'A'; // login logout
        const TYPE_PROFILE = 'P'; // ganti profil
        const TYPE_PASSWORD = 'Q'; // ganti password
        const TYPE_SETTING = 'S'; // unit kerja

        const STATUS_SUCCESS = 'S';
        const STATUS_FAILED = 'F';
        const STATUS_NO_STATUS = '-';

        protected $_table = 'user_logs';

        public function __construct() {
            parent::__construct();
        }

        public function resetParameters(){
            parent::resetParameters();
            $this->_table = 'user_logs';
        }

        public function getType($type=null, $with_color=false){
            $types = array(
                        self::TYPE_ACCESS => "Accessing",
                        self::TYPE_PROFILE => "Change Profile",
                        self::TYPE_PASSWORD => "Change Password",
                        self::TYPE_SETTING => "Setting"
                    );
            if ($with_color){
                $types = array(
                        self::TYPE_ACCESS => array(
                                                "name" => "Accessing",
                                                "color" => "amber"
                                            ),
                        self::TYPE_PROFILE => array(
                                                "name" => "Profile",
                                                "color" => "purple"
                                            ),
                        self::TYPE_PASSWORD => array(
                                                "name" => "Password",
                                                "color" => "red"
                                            ),
                        self::TYPE_SETTING => array(
                                                "name" => "Setting",
                                                "color" => "black"
                                            )
                    );
            }
            return ($type==null) ? $types : $types[$type];
        }

        public function getStatus($stat=null, $with_color=false){
            $status = array(
                        self::STATUS_SUCCESS => "Success",
                        self::STATUS_FAILED => "Failed",
                        self::STATUS_NO_STATUS => "Tanpa Status"
                    );
            if ($with_color){
                $status = array(
                        self::STATUS_SUCCESS => array(
                                                "name" => "Success",
                                                "color" => "green"
                                            ),
                        self::STATUS_FAILED => array(
                                                "name" => "Failed",
                                                "color" => "red"
                                            ),
                        self::STATUS_NO_STATUS => array(
                                                "name" => "Tanpa Status",
                                                "color" => "grey"
                                            )
                    );
            }
            return ($stat==null) ? $status : $status[$type];
        }
    }
?>
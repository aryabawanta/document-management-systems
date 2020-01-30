<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class System {

    public $token;
    public $message;
    public $code;
    public $validation;
    public $notification;

    public function __construct($code = NULL, $message = NULL, $validation = NULL, $notification = 0) {
        $this->setData($code, $message, $validation, $notification);
    }

    public function setData($code = NULL, $message = NULL, $validation = NULL, $notification = 0) {
        $this->code = $code;
        $this->message = $message;
        $this->validation = $validation;
        // $this->notification = $notification;
    }

}

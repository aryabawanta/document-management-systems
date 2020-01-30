<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ResponseStatus {

    const SUCCESS = 0; //Request success
    const ERROR = 1; //Error rerquest
    const UNAUTHORIZED = 2; //Invalid token
    const NOT_FOUND = 3; //URL Not Found
    const VALIDATION_ERROR = 4;
    const NO_RESPONSE = 5;

}

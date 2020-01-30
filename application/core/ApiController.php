<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class ApiController extends AppController {

    protected function setSystem($errorCode = NULL, $errorMessage = NULL, $infos = NULL, $validation = NULL) {
        if (empty($errorCode)) {
            $errorCode = ResponseStatus::SUCCESS;
        }
        $this->systemResponse->setData($errorCode, $errorMessage, $infos, $validation);
        return $this->systemResponse;
    }

    protected function setResponse($system, $data = array()) {
        if (empty($data)) {
            $data = $this->data;
        }
        $response = new Response();
        $response->setData($system, $data);
        $response->render();
    }

}

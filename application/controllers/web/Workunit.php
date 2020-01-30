<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Workunit extends WEB_Controller {

    protected $title = 'Unit Kerja';
    protected $class_name = "Unit Kerja";

    public function index() {
        if (!SessionManagerWeb::isAdministrator()){
            SessionManagerWeb::setFlashMsg(false, "Anda tidak mempunyai hak untuk mengakses halaman ini.");
            redirect('web/user_application');
        }
        $this->data['class_name'] = $this->class_name;
        $this->data['method_name'] = $this->data['title'] = "Daftar Unit Kerja";

        $workunits = json_encode($this->model->getStructures());

        $this->data['workunits'] = $workunits;
        $this->template->viewDefault($this->view, $this->data);
    }
}
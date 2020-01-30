<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class PrivateWebController extends WebController {

    protected $page;
    protected $userLoggedIn;

    public function __construct() {
        parent::__construct();

        if (SessionManager::getUserData('LOGGEDIN') !== TRUE) {
            SessionManager::destroy();
            SessionManager::setFlashMessage(FALSE, 'Anda tidak dapat mengakses halaman ini.');
            redirect('login');
        }

        $this->page = $this->uri->segment(4, 0);

        $this->template->setLayout('layout/activity');
        $this->template->setStylesheet(base_url() . 'assets/css/bootstrap-drawer.min.css');
        $this->template->setJavascript(base_url() . 'assets/js/drawer.min.js');

        $this->userLoggedIn = $this->data['userLoggedIn'] = SessionManager::getUserData('USER');
    }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends WEB_Controller {

    protected $title = 'Pengguna';

    public function index() {
        if (!SessionManagerWeb::isAdministrator())
            redirect($this->ctl . '/me');

        $filter = 'where 1=1 ';
        $filter_is_delete = " and u.is_delete=0 ";
        if ($_GET){
            $param = $this->input->get("search", true);
            if ($param!=NULL and $param!=''){
                $filter .= "and (lower(u.username) ilike '%{$param}%' or lower(u.name) ilike '%{$param}%')";
            }
            
            $role = $this->input->get("role", true);
            if ($role!=NULL and $role!=''){
                $filter .= " and role=upper('{$role}') ";
            }

            $is_active = $this->input->get('is_active', true);
            if ($is_active!=NULL and $is_active!=''){
                if ($is_active=='on'){
                    $filter_is_delete = "";
                }
            }
        }
        $filter .= $filter_is_delete;

        $this->data['data'] = $this->model->show_sql(false)
                                          ->column("u.*")
                                          ->table("users u")
                                          ->filter($filter)
                                          ->order("order by u.name")
                                          ->limit_offset("limit 50 offset 0")
                                          ->getAll();
        
        // get variables
        $variables = SessionManagerWeb::getVariables();

        // roles
        $this->data['variables']['roles'] = $variables['roles'];
        $this->data['variables']['roles'][''] = "Pilih Role....";

        $this->data['title'] = $this->data['method_name'] = 'Daftar Pengguna';
        $this->data['class_name'] = "Pengguna";

        $this->template->viewDefault($this->view, $this->data);
    }

    /**
     * Logout
     */
    public function logout() {
        AuthManagerWeb::logout();
        foreach ($_SESSION as $key => $value) {
            $_SESSION[$key] = null;
        }
        redirect($this->config->item("app_url"));
    }
    public function changeApplication() {
        $app_url = $this->config->item("app_url");
        header("Location: $app_url");
        exit;
    }
}
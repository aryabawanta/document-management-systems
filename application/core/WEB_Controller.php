<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class WEB_Controller extends CI_Controller {

    const CTL_PATH = 'web/';
    const LIB_PATH = 'web/';
    const VIEW_PATH = 'web/';

    protected $class;
    protected $ctl;
    protected $data;
    protected $ispublic = 0;
    protected $method;
    protected $model;
    protected $postData;
    protected $template;
    protected $title = 'Management';
    protected $view;

    protected $uri_segments = array();

    /**
     * Constructor
     */
    public function __construct() {

        parent::__construct();

        // library
        $this->load->library(static::LIB_PATH . 'AuthManagerWeb');
        $this->load->library(static::LIB_PATH . 'FormatterWeb');
        $this->load->library(static::LIB_PATH . 'SessionManagerWeb');
        $this->load->library(static::LIB_PATH . 'TemplateManagerWeb');

        // model
        //$this->load->model('Notification_user_model');

        //cek login
        if (empty($this->ispublic) and ! SessionManagerWeb::isAuthenticated()) {
            SessionManagerWeb::setFlash(array('errmsg' => array('Anda harus login terlebih dahulu')));
            redirect($this->getCTL('site/index'));
        }
        
        // inisialisasi atribut
        $this->class = $this->router->class;
        $this->ctl = $this->getCTL();
        $this->method = ($this->router->class == $this->router->method) ? 'index' : $this->router->method;
        $this->template = new TemplateManagerWeb();
        $this->view = $this->class . (empty($this->method) ? '' : '_' . $this->method);

        // inisialisasi model
        $model = ucfirst($this->class . '_model');
        if (file_exists(APPPATH . 'models/' . $model . EXT)) {
            $this->load->model($model);
            $this->model = new $model();
        }

        // inisialisasi post
        $post = $this->input->post();
        if (!empty($post)) {
            foreach ($post as $k => $v) {
                if (!is_array($v) and ! is_object($v) and strlen($v) == 0)
                    $post[$k] = NULL;
            }

            $this->postData = $post;
        } else
            $this->postData = array();

        // inisialisasi data
        $data = array();
        $data['path'] = static::CTL_PATH;
        $data['class'] = $this->class;
        $data['method'] = $this->method;
        $data['title'] = $this->title;
        $data['arrmenu'] = $this->getMenu();
        $data['nopic'] = base_url('assets/uploads/users/photos/nopic.png');
        $data['jmlnotif'] = 0;
        $data['class_name'] = "Aplikasi";
        $data['method_name'] = "Pilih Aplikasi";

        $this->data = $data;

        $this->load->model("Classification_model");
        $classifications = $this->Classification_model->filter("where is_delete=0")->order("order by code")->getAll();
        $list_classifications = array();
        $list_classifications[''] = "Pilih Kode Klasifikasi . . .";
        foreach ($classifications as $classification) {
            $list_classifications[$classification['id']] = $classification['code']." - ".$classification['name'];
        }
        $this->data['variables']['classifications'] = $list_classifications;

        $this->load->model("Workunit_model");
        $workunits = $this->Workunit_model->filter("where is_delete=0")->order("order by name")->getAll();
        $list_workunits = array();
        $list_workunits[''] = "Pilih Unit Kerja . . .";
        foreach ($workunits as $workunit) {
            $list_workunits[$workunit['id']] = $workunit['name'];
        }
        $this->data['variables']['workunits'] = $list_workunits;
        
        foreach (SessionManagerWeb::getFlash() as $k => $v)
            $this->data[$k] = $v;
    }

    /**
     * Mendapatkan nama controller untuk redirect
     * @param string $ctl
     */
    protected function getCTL($ctl = null) {
        if (!isset($ctl))
            $ctl = $this->class;

        return $this::CTL_PATH . $ctl;
    }

    /**
     * Mendapatkan menu
     * @return array
     */
    protected function getMenu() {
        $menu = array();

        $menu[] = array('namamenu' => 'Portal', 'levelmenu' => 0, 'faicon' => 'desktop');
        $menu[] = array('namamenu' => 'Publik', 'namafile' => $this->getCTL('post'), 'levelmenu' => 1, 'faicon' => 'home');
        $menu[] = array('namamenu' => 'Pribadi', 'namafile' => $this->getCTL('post/me'), 'levelmenu' => 1, 'faicon' => 'user');
        $menu[] = array('namamenu' => 'Grup', 'namafile' => $this->getCTL('group/list_me'), 'levelmenu' => 1, 'faicon' => 'comments-o');

        $menu[] = array('namamenu' => 'Task', 'levelmenu' => 0, 'faicon' => 'line-chart');
        $menu[] = array('namamenu' => 'To Do', 'namafile' => $this->getCTL('todo/for_new'), 'levelmenu' => 1, 'faicon' => 'calendar');

        $menu[] = array('namamenu' => 'KM', 'namafile' => $this->getCTL('knowledge_management'), 'levelmenu' => 0, 'faicon' => 'home');

        $menu[] = array('namamenu' => 'Edit Profil', 'namafile' => $this->getCTL('user/me'), 'levelmenu' => 1, 'faicon' => 'user');
        // if (SessionManagerWeb::isAdministrator() || SessionManagerWeb::isManagemement())
        //     $menu[] = array('namamenu' => 'Pengguna', 'namafile' => $this->getCTL('user'), 'levelmenu' => 1, 'faicon' => 'users');

        return $menu;
    }

    /**
     * Redirect, biasanya setelah tambah atau hapus data
     */
    protected function redirect() {
        $back = $this->postData['referer'];
        if (empty($back))
            redirect($this->ctl);
        else
            header('Location: ' . $back);
    }

    /**
     * Halaman detail data
     * @param int $id
     */
    public function detail($id) {
        // tombol
        $buttons = array();
        $buttons['back'] = array('label' => 'Kembali', 'type' => 'primary', 'icon' => 'chevron-left', 'click' => 'goBack()');
        // $buttons['edit'] = array('label' => 'Edit', 'type' => 'success', 'icon' => 'pencil', 'click' => 'goEdit()');
        $buttons['delete'] = array('label' => 'Hapus', 'type' => 'danger', 'icon' => 'trash-o', 'click' => 'goDelete()');

        $this->data['id'] = $id;
        $this->data['buttons'] = $buttons;
        $this->data['title'] = 'Detail ' . $this->data['title'];
    }

    /**
     * Halaman tambah data
     */
    public function add() {
        $this->edit();
    }

    /**
     * Halaman edit data
     * @param int $id
     */
    public function edit($id = null) {
        // sementara disable edit, kecuali beberapa...
        if (isset($id) and ! in_array($this->class, array('classification')))
            redirect($this->getCTL() . '/detail/' . $id);

        $this->data['id'] = $id;

        // judul
        if (empty($this->data['title']))
            $this->data['title'] = (isset($id) ? 'Edit' : 'Tambah') . ' ' . $this->data['title'];

        // tombol
        if (empty($this->data['buttons'])) {
            $buttons = array();
            $buttons['back'] = array('label' => 'Kembali', 'type' => 'primary', 'icon' => 'chevron-left', 'click' => 'goBack()');
            $buttons['save'] = array('label' => 'Simpan', 'type' => 'success', 'icon' => 'save', 'click' => 'goSave()');

            $this->data['buttons'] = $buttons;
        }

        // bila add
        if ($this->method == 'add')
            $this->view = $this->class . '_edit';
    }

    public function setSessionVariables(){
        // load model
        $this->load->model("Workunit_model");

        $variables = array();

        // Unit Kerja
        $workunits = $this->Workunit_model->filter("where is_delete=0")->getAll();
        $variables['workunits'] = $workunits;

        // Roles
        $variables['roles'] = Role::getRoles();

        SessionManagerWeb::setVariables($variables);
    }

    function fileUpload($folder='documents/')  {
        $folder_ori = $folder;

        if ($_FILES['file_upload']['name']) {
            $files_arr = array();

            $id = md5(SessionManagerWeb::getUserID() . $this->config->item('encryption_key'));

            $folder .= '/' . $id;
            $ciConfig = $this->config->item('utils');
            $path = $ciConfig['full_upload_dir'] . $folder . '/';
            if (!is_dir($path)) {
               mkdir($path);         
            }
            foreach($_FILES['file_upload']['name'] as $key=>$val){

                $name = $_FILES['file_upload']['name'][$key];
                
                $_FILES['userfile']['name']= $_FILES['file_upload']['name'][$key];
                $_FILES['userfile']['type']= $_FILES['file_upload']['type'][$key];
                $_FILES['userfile']['tmp_name']= $_FILES['file_upload']['tmp_name'][$key];
                $_FILES['userfile']['error']= $_FILES['file_upload']['error'][$key];
                $_FILES['userfile']['size']= $_FILES['file_upload']['size'][$key];

                $file_name = File::getFileName($id, $name);
                unlink($path . $file_name);

                File::uploadFile('userfile', $id, $name, $folder);
                $link = File::generateLink($id, $name, $folder);
                $files_arr = $link;
                
                $_SESSION['sigap']['draft_post'] = 1;
            }  

            $str = $this->_getdraftfiles($folder_ori);
            die($str);
        }    
        exit;
    }
}

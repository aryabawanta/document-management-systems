<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends WEB_Controller {

    protected $title = 'Locations';
    protected $class_name = "Locations";

    public function index() {
        if (!SessionManagerWeb::isAdministrator()){
            SessionManagerWeb::setFlashMsg(false, "Anda tidak mempunyai hak untuk mengakses halaman ini.");
            redirect('web/user_application');
        }
        $this->data['class_name'] = $this->class_name;
        $this->data['method_name'] = $this->data['title'] = "Daftar Unit Kerja";

        $buttons = array();
        $buttons['add'] = array('label' => ' Add', 'type' => 'success', 'icon' => 'plus', 'click' => 'goAdd()');
        $this->data['buttons'] = $buttons;

        $data = json_encode($this->model->getStructures());

        $this->data['data'] = $data;
        $this->template->viewDefault($this->view, $this->data);
    }

    /**
     * Halaman edit user
     * @param int $id
     */
    public function edit($id = null) {
        if (!SessionManagerWeb::isAdministrator()){
            SessionManagerWeb::setFlashMsg(false, "Anda tidak mempunyai hak untuk mengakses halaman ini.");
            redirect($this->getCTL());
        }
        $this->data['class_name'] = $this->class_name;

        $this->data['title'] = "Add ".$this->title;
        if ($id!=null){
            $this->data['title'] = "Change ".$this->title;
        }
        $this->data['method_name'] = $this->data['title'];


        parent::edit($id);

        // Locations
        $locations = Util::toMap($this->model->show_sql(false)->filter("where is_delete=0")->getAll(), 'id', 'name');
        $locations[0] = "Tidak ada - Merupakan Lokasi Tertinggi";
        ksort($locations);

        // get data
        if (isset($id)){
            $data = $this->model->show_sql(false)->column("*")->filter("where id='$id'")->getBy();
            unset($workunits[$id]);
        }
        else
            $data = array();
        
        $this->data['data'] = $data;
        ksort($workunits);
        $this->data['variables']['locations'] = $locations;

        $this->template->viewDefault($this->view, $this->data);
    }

    /**
     * Edit data user
     * @param int $id jika tidak ada dianggap data pribadi
     */
    public function update($id = null) {
        if (!SessionManagerWeb::isAdministrator()){
            SessionManagerWeb::setFlashMsg(false, "Anda tidak mempunyai hak untuk mengakses halaman ini.");
            redirect($this->getCTL());
        }
        // untuk log
        $this->load->model("User_log_model");
        $record_log = array();
        $record_log['type'] = User_log_model::TYPE_SETTING;
        $record_log['user_id'] = SessionManagerWeb::getUserID();
        $record_log['username'] = SessionManagerWeb::getUserName();

        $data = $this->input->post(null,true);
        if ($data['is_use_code']=='on')
            $data['is_use_code'] = 1;
        else
            $data['is_use_code'] = 0;

        $record_log['description'] = "Merubah data Lokasi '".$data['name']."'";
        
            

        $update = $this->model->save($id, $data);
        if ($update === true) {
            $ok = true;
            $msg = 'Berhasil mengubah Lokasi ' .$data['name'];

            $record_log['status'] = User_log_model::STATUS_SUCCESS;
            $this->User_log_model->create($record_log, false, false);
            SessionManagerWeb::setFlashMsg($ok, $msg);
            redirect($this->ctl);
        } else {
            $ok = false;
            if (!is_string($update)) {
                $validation = $this->model->getErrorValidate();
                if (empty($validation))
                    $msg = 'Gagal mengubah Lokasi '.$data['name'];
                else
                    $msg = implode('<br />', $validation);
            } else
                $msg = $update; 
        }
        $record_log['status'] = User_log_model::STATUS_FAILED;
        $this->User_log_model->create($record_log, false, false);

        SessionManagerWeb::setFlashMsg($ok, $msg);
        redirect($this->ctl . '/edit/' . $id);
    }

    public function create() {
        if (!SessionManagerWeb::isAdministrator()){
            SessionManagerWeb::setFlashMsg(false, "Anda tidak mempunyai hak untuk mengakses halaman ini.");
            redirect($this->getCTL());
        }
        // untuk log
        $this->load->model("User_log_model");
        $record_log = array();
        $record_log['type'] = User_log_model::TYPE_SETTING;
        $record_log['user_id'] = SessionManagerWeb::getUserID();
        $record_log['username'] = SessionManagerWeb::getUserName();

        $data = $this->input->post(null, true);
        if ($data['is_use_code']=='on')
            $data['is_use_code'] = 1;
        else
            $data['is_use_code'] = 0;

        $record_log['description'] = "Menambah Lokasi '".$data['name']."'";

        $insert = $this->model->create($data, TRUE, TRUE);
        if ($insert) {
            $ok = true;
            $msg = 'Berhasil menambah Lokasi';
            SessionManagerWeb::setFlashMsg($ok, $msg);

            $record_log['status'] = User_log_model::STATUS_SUCCESS;
            $this->User_log_model->create($record_log, false, false);

            redirect($this->ctl);
        } else {
            $ok = false;
            if (!is_string($insert)) {
                $validation = $this->model->getErrorValidate();
                if (empty($validation))
                    $msg = 'Gagal menambah Lokasi';
                else
                    $msg = implode('<br />', $validation);
            } else
                $msg = $insert;            
        }

        $record_log['status'] = User_log_model::STATUS_FAILED;
        $this->User_log_model->create($record_log, false, false);
        echo $msg;

        SessionManagerWeb::setFlashMsg($ok, $msg);
        redirect($this->ctl . '/add/' . $insert);
    }

    public function delete($id){
        if (!SessionManagerWeb::isAdministrator() or true){
            SessionManagerWeb::setFlashMsg(false, "Anda tidak mempunyai hak untuk mengakses halaman ini.");
            redirect($this->getCTL());
        }
        // untuk log
        $this->load->model("User_log_model");
        $record_log = array();
        $record_log['type'] = User_log_model::TYPE_SETTING;
        $record_log['user_id'] = SessionManagerWeb::getUserID();
        $record_log['username'] = SessionManagerWeb::getUserName();

        $data = array('is_delete' => 1 );

        $record_log['description'] = "Menghapus Unit Kerja '".$this->model->column('name')->filter("where id=$id")->getOne()."'";
        
        $update = $this->model->save($id, $data);
        if ($update === true) {
            $ok = true;
            $msg = 'Berhasil menghapus Unit Kerja ' .$data['name'];

            $record_log['status'] = User_log_model::STATUS_SUCCESS;
            $this->User_log_model->create($record_log, false, false);
            SessionManagerWeb::setFlashMsg($ok, $msg);
            redirect($this->ctl);
        } else {
            $ok = false;
            if (!is_string($update)) {
                $validation = $this->model->getErrorValidate();
                if (empty($validation))
                    $msg = 'Gagal menghapus Unit Kerja '.$data['name'];
                else
                    $msg = implode('<br />', $validation);
            } else
                $msg = $update; 
        }
        $record_log['status'] = User_log_model::STATUS_FAILED;
        $this->User_log_model->create($record_log, false, false);

        SessionManagerWeb::setFlashMsg($ok, $msg);
        redirect($this->ctl . '/edit/' . $id);
    }

    function detail($id) {
        if (!SessionManagerWeb::isAdministrator() or true){
            SessionManagerWeb::setFlashMsg(false, "Anda tidak mempunyai hak untuk mengakses halaman ini.");
            redirect($this->getCTL());
        }

        /* WORKUNIT */
            $buttons = array();
            $buttons['edit'] = array('label' => ' Edit', 'type' => 'warning', 'icon' => 'pencil-alt', 'click' => 'goEdit('.$id.')');
            $buttons['back'] = array('label' => ' Kembali', 'type' => 'secondary', 'icon' => 'chevron-left', 'click' => 'goBack()');
            $this->data['buttons'] = $buttons;

            $data = $this->model->filter("where id=$id")->getBy();

            $data['parent_name'] = "Tidak Ada - Merupakan Unit Kerja Tertinggi";
            // parent 0 tertinggi
            if ($data['parent']>0){
                $data['parent_name'] = $this->model->column("name")->filter("where id={$data['parent']}")->getOne();
            } 
            $this->data['data'] = $data;
        /* END WORKUNIT */

        /* POSITION */
            $this->load->model('Position_model');
            $this->data['position']['title'] = "Posisi di Unit Kerja";

            $positions = $this->Position_model->filter("where workunit_id=$id and is_delete=0")->order("order by is_chief desc")->getAll();
            $superior = 0;
            foreach ($positions as $key => $position) {
                if ($position['is_chief']==1 and $superior==0){
                    $superior = $position['id'];
                }
                $positions[$key]['superior_position_name'] = $this->Position_model->show_sql(false)->column('name')->filter("where id={$position['superior_position_id']}")->getOne();
                if (empty($positions[$key]['superior_position_name'])){
                    $positions[$key]['superior_position_name'] = "Tidak Ada - Merupakan Posisi Tertinggi";
                }
            }
            $this->data['positions'] = $positions;

            /* Button */
                $buttons = array();
                $buttons['edit'] = array('label' => ' Tambah Posisi di Unit Kerja ini', 'type' => 'success', 'icon' => 'plus', 'click' => "goAddPosition($id,$superior)");
                // $buttons['back'] = array('label' => ' Kembali', 'type' => 'secondary', 'icon' => 'chevron-left', 'click' => 'goBack()');
                $this->data['position']['buttons'] = $buttons;
            /* End Button */
        /* END POSITION */

        /* User's Workunit */
            $this->load->model('User_position_model');
            $this->data['user_workunit']['title'] = "User di Unit Kerja";

            $position_list = "'" . implode ( "', '",  Util::toList($positions, 'id') ) . "'";
            $user_workunits = $this->User_position_model->column('u.*')
                                                        ->table("user_position up")
                                                        ->join("left join users u on u.id=up.user_id")
                                                        ->filter("where up.position_id in ($position_list)")
                                                        ->getAll();

            $this->data['user_workunit']['data'] = $user_workunits;
            
            /* Button */
                $buttons = array();
                if (!empty($user_workunits)){
                    $buttons['setting'] = array('label' => ' Pengaturan User', 'type' => 'inverse', 'icon' => 'account', 'click' => "goManageUser($id)");
                }                
                $this->data['user_workunit']['buttons'] = $buttons;
            /* End Button */
        /* End User's Workunit */

        $this->template->viewDefault($this->view, $this->data);
    }
}
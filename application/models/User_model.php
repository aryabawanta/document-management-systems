<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends AppModel {
    protected $_table = 'users';

    public function __construct() {
        parent::__construct();
    }

    public function resetParameters(){
        parent::resetParameters();
        $this->_table = 'users';
    }    

    public function getPhoto($id=NULL, $photo=NULL){
        $data = Image::getImage($id, $photo, 'users/photos');
        return $data;
    }

    public function save($primary_value, $data = array(), $skip_validation = FALSE) {
        $this->_database->trans_begin();
        // $update = parent::save($primary_value, $data, $skip_validation);
        $update = $this->filter("id='".$primary_value."'")->update($data);
        
        if ($update) {
            $upload = TRUE;
            if (isset($_FILES['photo']) && !empty($_FILES['photo'])) {
                $upload = Image::upload('photo', $primary_value, $_FILES['photo']['name'], 'users/photos');
            }
            if ($upload === TRUE) {
                return $this->_database->trans_commit();
            } else {
                $this->_database->trans_rollback();
                return $upload;
            }
        }
        $this->_database->trans_rollback();
        return FALSE;
    }

    public function insert($data, $skip_validation = FALSE, $return = TRUE) {     
        $create = dbInsert("users", $data);
        if ($create) {
            if($return)
                return $data['id'];
            else
                return true;
        }
        return FALSE;
    }

    public function delete($id=null,$soft_delete=1){
        if (parent::delete($id, $soft_delete)){
            $record = array(
                        'updated_at' => date("Y-m-d H:i:s"),
                        'status' => Status::INACTIVE
                    );
            return $this->show_sql(true)->filter("id=$id")->update($record);
        } else {
            return false;
        }
    }

    public function activate($id=null){
        $record = array(
                    'updated_at' => date("Y-m-d H:i:s"),
                    'status' => Status::ACTIVE,
                    'is_delete'=>0
                );
        return dbUpdate("$this->_table", $record, "id=$id");
    }

    public function syncUserService(){
        $app_id = "service";
        $db = $this->load->database("service",true);

        $this->load->model("Workunit_model");

        // insert unitkerja 
        $unitkerja = $this->Workunit_model->getAll();
        dbQuery("delete from unitkerja", $db);
        foreach ($unitkerja as $record) {
            dbInsert("unitkerja", $record, $db);
        }

        // $users = $this->column("u.id, u.name, u.username, u.email, u.photo, u.workunit_id as unitkerja_id, ua.role")
        $users = $this->column("u.id, u.name, u.username, u.email, u.photo, ua.role")
                      ->table("user_application ua left join users u on u.id=ua.user_id")
                      ->filter("where application_id='{$app_id}' and is_delete=0")
                      ->getAll();
        $user_ids = array();
        foreach ($users as $user) {
            $user['is_delete'] = 0;
            $user_ids[] = "'".$user['id']."'";
            $is_exist = dbGetOne("select 1 from users where id='".$user['id']."'", $db);
            if ($is_exist){
                dbUpdate('users',$user,"id='".$user['id']."'", $db);
            } else {
                dbInsert('users',$user, $db);
            }
        }
        // update user yang tidak ada
        $record = array();
        $record['is_delete'] = 1;
        dbUpdate("users", $record, "id not in (".implode(',', $user_ids).")", $db);
    }

    public function syncUserHelpdesk(){
        $app_id = "helpdesk";
        $db = $this->load->database("helpdesk",true);

        $users = $this->column("u.id, u.name, u.username, u.email, u.photo, ua.role")
                      ->table("user_application ua left join users u on u.id=ua.user_id")
                      ->filter("where application_id='{$app_id}' and u.is_delete=0")
                      ->getAll();
        $user_ids = array();
        foreach ($users as $user) {
            // $user['is_delete'] = 0;
            $user_ids[] = "'".$user['id']."'";
            $is_exist = dbGetOne("select 1 from users where id='".$user['id']."'", $db);
            if ($is_exist){
                dbUpdate('users',$user,"id='".$user['id']."'", $db);
            } else {
                dbInsert('users',$user, $db);
            }
        }
         // update user yang tidak ada
        $record = array();
        $record['is_delete'] = 1;
        dbUpdate("users", $record, "id not in (".implode(',', $user_ids).")", $db);
    }

    public function syncUserPersuratan(){
        $app_id = "persuratan";
        $db = $this->load->database("persuratan",true);

        // $users = $this->column("u.id as username, u.name, u.password, u.password_salt as salt, ua.role, u.workunit_id as unitkerja_id")
        $users = $this->column("u.id as username, u.name, u.password, u.password_salt as salt, ua.role")
                      ->table("user_application ua left join users u on u.id=ua.user_id")
                      ->filter("where application_id='{$app_id}' and is_delete=0")
                      ->getAll();
        $user_ids = array();
        foreach ($users as $user) {
            $user_ids[] = "'".$user['username']."'";
            $data = array();
            $data['username'] = $user['username'];
            $data['isactive'] = 1;
            $data['nama'] = $user['name'];
            $data['password'] = $user['password'];
            $data['salt'] = $user['salt'];
            $sql = "select 1 from users where lower(username)='".strtolower($data['username'])."'";
            if (dbGetOne($sql, $db)){
                $sql = "select iduser from users where lower(username)='".strtolower($data['username'])."'";
                $user_id = dbGetOne($sql, $db);
                dbUpdate("users", $data, "iduser=$user_id", $db);

                // check apakah sudah ada data rolenya
                $sql = "select 1 from userrole where iduser=$user_id";
                $userrole = array();
                if (dbGetOne($sql,$db)){
                    $userrole['idrole'] = (int)$user['role'];
                    dbUpdate("userrole", $userrole, "iduser=$user_id", $db);
                } else {
                    $userrole = array();
                    $userrole["iduser"] = $user_id;
                    $userrole['idjabatan'] = 0 ;
                    $userrole['idrole'] = (int)$user['role'];
                    dbInsert("userrole", $userrole, $db);
                }
                
            } else {
                dbInsert("users", $data, $db);

                $sql = "select iduser from users where lower(username)='".strtolower($data['username'])."'";
                $user_id = dbGetOne($sql, $db);
                $userrole = array();
                $userrole["iduser"] = $user_id;
                $userrole['idjabatan'] = 0 ;
                $userrole['idrole'] = (int)$user['role'];
                dbInsert("userrole", $userrole, $db);
            }
        }
        // update user yang tidak ada
        $record = array();
        $record['isactive'] = 0;
        dbUpdate("users", $record, "username not in (".implode(',', $user_ids).")", $db);
    }

    public function syncUserEoffice(){
        $app_id = "eoffice";
        $db = $this->load->database("eoffice",true);
        $this->load->model('User_position_model');
        $this->load->model('Position_model');

        $users = $this->column("u.name, u.username,u.status, u.password, u.password_salt, u.email, u.photo, ua.role")
                      ->table("user_application ua left join users u on u.id=ua.user_id")
                      ->filter("where application_id='{$app_id}' and is_delete=0")
                      ->getAll();
        $user_ids = array();
        foreach ($users as $user) {
            $user_ids[] = "'".$user['username']."'";
            $is_exist = dbGetOne("select 1 from users where username='".$user['username']."'", $db);
            if ($is_exist){
                dbUpdate('users',$user,"username='".$user['username']."'", $db);
            } else {
                dbInsert('users',$user, $db);
            }

            /* DAILY REPORT USERS */
                $user_positions = Util::toList($this->User_position_model->column("position_id")->filter("where user_id='{$user['username']}'")->getAll(),'position_id');
                $superior_positions = Util::toList($this->Position_model->column("superior_position_id")->filter("where id in (".implode(',',$user_positions).")")->getAll(),'superior_position_id');
                $superiors = Util::toList($this->User_position_model->column("user_id")->filter("where position_id in (".implode(',', $superior_positions).")")->getAll(), 'user_id');

                $user_id = dbGetOne("select id from users where username='".$user['username']."'", $db);
                if (!empty($user_id)){
                    dbQuery("delete from daily_report_users where user_id=$user_id", $db);
                }
                foreach ($superiors as $superior) {
                    if (empty($superior))
                        continue;
                    $superior_id = dbGetOne("select id from users where username='".$superior."'", $db);
                    if (!empty($superior_id)){
                        $record = array();
                        $record['user_id'] = $user_id;
                        $record['user_default'] = $superior_id;
                        dbInsert('daily_report_users', $record, $db);
                    }
                }
            /* DAILY REPORT USERS */
        }
        // update user yang tidak ada
        $record = array();
        $record['status'] = 'I';
        dbUpdate("users", $record, "username not in (".implode(',', $user_ids).")", $db);
    }

    public function syncUserDms(){
        return true;
    }
}
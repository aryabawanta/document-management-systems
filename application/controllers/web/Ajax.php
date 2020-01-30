<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Ajax extends WEB_Controller {
        public function getDocument($document_id=null){
            if (empty($document_id)){
                echo false;
                die();
            }
            $this->load->model("Document_model");
            $this->load->model("Document_log_model");
            $this->load->model("Classification_model");
            $this->load->model("User_model");
            $this->load->model("Workunit_model");


            $data = array();
            
            $document = $this->Document_model->filter("where is_delete=0 and id='".$document_id."'")->getBy();
            $classification = $this->Classification_model->filter("where id=".$document['classification_id'])->getBy();
            $document['classification_code'] = $classification['code'].' - '.$classification['name'];
            $document['workunit_name'] = $this->Workunit_model->column('name')->filter("where id=".$document['workunit_id'])->getOne();
            $data['document'] = $document;
            
            $histories = $this->Document_log_model->filter("where type='".Document_log_model::TYPE_HISTORY."' and document_id='".$document_id."'")->order("order by created_at desc")->getAll();
            foreach ($histories as $key => $history) {
                $user = $this->User_model->filter("where id='".$history['user_id']."'")->getBy();
                $histories[$key]['user_name'] = $user['name'];
                $histories[$key]['datetime'] = date("d M Y H:i",strtotime($history['created_at']));
            }
            $data['history'] = $histories;

            $activities = $this->Document_log_model->filter("where type='".Document_log_model::TYPE_ACTIVITY."' and document_id='".$document_id."'")->order("order by created_at desc")->getAll();
            foreach ($activities as $key => $activity) {
                $user = $this->User_model->filter("where id='".$activity['user_id']."'")->getBy();
                $activities[$key]['user_name'] = $user['name'];
                $activities[$key]['datetime'] = date("d M Y H:i",strtotime($activity['created_at']));
            }
            $data['activity'] = $activities;

            $data_json = json_encode($data);
            echo $data_json;
        }

        public function getClassification($id=null){
            if (empty($id)){
                echo false;
                die();
            }

            $this->load->model("Classification_model");
            $code = $this->Classification_model->column("code")->filter("where id=$id")->getOne();
            if (!empty($code))
            	echo $code;
            else
            	echo false;
            die;
        }

        public function changeDocumentFile($document_id){
            $this->load->model("File_model");
            $record = $this->input->post(null, true);
            $record['document_id'] = $document_id;
            $record['type'] = File_model::TYPE_CLOUD;
            if ($record['type']==false){
                $record['type'] = File_model::TYPE_LOCAL;
            }
            
            $param = array();
            $param['user_id'] = SessionManagerWeb::getUserID();
            if (!$this->File_model->insertOrUpdate($document_id,$record, $param)){
                echo false;
                die;
            } 
            echo true;
        }
    }
?>
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Document extends WEB_Controller {

    protected $title = 'Documents';

    private function _getFilter($variables){
        $data = array();
        $filter = '';
        $filtered_by = array();
        $filter_count = 0;
        if (!empty($variables['search'])){
            $param = $variables['search'];
            $data['name'] = $param;
            $filter.= " and (lower(name) ilike '%".strtolower($param)."%')";
            $filtered_by[] = "Nama";
            $filter_count++;
        } else {
            unset($variables['search']);
        }

        if (!empty($variables['filter_name'])){
            $param = $variables['filter_name'];
            $data['name'] = $param;
            $filter.= " and (lower(name) ilike '%".strtolower($param)."%')";
            $filtered_by[] = "Nama";
            $filter_count++;
        } else {
            unset($variables['filter_name']);
        }

        if (!empty($variables['filter_classification_id'])){
            $param = $variables['filter_classification_id'];
            $data['classification_id'] = $param;
            $filter.= " and (classification_id=$param)";
            $filtered_by[] = "Klasifikasi";
            $filter_count++;
        } else {
            unset($variables['filter_classification_id']);
        }

        if (!empty($variables['filter_workunit_id'])){
            $param = $variables['filter_workunit_id'];
            $data['workunit_id'] = $param;
            $filter.= " and (workunit_id=$param)";
            $filtered_by[] = "Unit Kerja";
            $filter_count++;
        } else {
            unset($variables['filter_workunit_id']);
        }

        if (!empty($variables['filter_year'])){
            $param = $variables['filter_year'];
            $data['year'] = $param;
            $filter.= " and (lower(year) ilike '%".strtolower($param)."%')";
            $filtered_by[] = "Tahun";
            $filter_count++;
        } else {
            unset($variables['filter_year']);
        }

        if (!empty($variables['filter_archive_number'])){
            $param = $variables['filter_archive_number'];
            $data['archive_number'] = $param;
            $filter.= " and (lower(archive_number) ilike '%".strtolower($param)."%')";
            $filtered_by[] = "No Arsip";
            $filter_count++;
        } else {
            unset($variables['filter_archive_number']);
        }

        if (!empty($variables['filter_envelope_code'])){
            $param = $variables['filter_envelope_code'];
            $data['envelope_code'] = $param;
            $filter.= " and (lower(envelope_code) ilike '%".strtolower($param)."%')";
            $filtered_by[] = "Sampul";
            $filter_count++;
        } else {
            unset($variables['filter_envelope_code']);
        }

        if (!empty($variables['filter_box_code'])){
            $param = $variables['filter_box_code'];
            $data['box_code'] = $param;
            $filter.= " and (lower(box_code) ilike '%".strtolower($param)."%')";
            $filtered_by[] = "Box";
            $filter_count++;
        } else {
            unset($variables['filter_box_code']);
        }                

        if (!empty($variables['filter_rack_code'])){
            $param = $variables['filter_rack_code'];
            $data['rack_code'] = $param;
            $filter.= " and (lower(rack_code) ilike '%".strtolower($param)."%')";
            $filtered_by[] = "Rak";
            $filter_count++;
        } else {
            unset($variables['filter_rack_code']);
        }

        if (!empty($variables['filter_block_code'])){
            $param = $variables['filter_block_code'];
            $data['block_code'] = $param;
            $filter.= " and (lower(block_code) ilike '%".strtolower($param)."%')";
            $filtered_by[] = "Blok";
            $filter_count++;
        } else {
            unset($variables['filter_block_code']);
        }
        $return = array(
            'data' => $data,
            'filter' => $filter,
            'filtered_by' => $filtered_by,
            'filter_count' => $filter_count
        );
        return $return;
    }

    public function clearFilter(){
        unset($_SESSION['filter']);
        redirect($this->getCTL());
    }

    private function getDocumentDetail($documents=null){
        if ($documents==null)
            return null;
        $this->load->model("File_model");
        $this->load->model("Workunit_model");
        foreach ($documents as $key => $value) {
            /* Image */
                $documents[$key]['image'] = base_assets().'/images/document/file.png';
                $file = $this->File_model->filter("where document_id='".$value['id']."'")->getBy();
                if (!empty($file)){
                    if ($file['type']==File_model::TYPE_CLOUD){
                         $documents[$key]['image'] = base_assets().'/images/document/file-exist.png';
                    }
                }
            /* End Image */

            /* Work Unit */
                $documents[$key]['workunit_name'] = $this->Workunit_model->column('name')->filter("where id=".$value['workunit_id'])->getOne();
            /* End Work Unit */
        }
        return $documents;
    }

    public function index($page=1) {
        $buttons = array();
        $buttons['filter'] = array('label' => ' Filter', 'type' => 'outline-info btn-rounded', 'icon' => 'filter', 'click' => 'goFilter()');
        if ($_POST){
            $data_filter = $this->_getFilter($this->input->post(null, true));

            $this->data['filter'] = $data_filter['data'];
            $_SESSION['filter'] = $data_filter['data'];

            $filter = $data_filter['filter'];
            $filtered_by = $data_filter['filtered_by'];
            $filter_count = $data_filter['filter_count'];

            if (!empty($filtered_by)){
                $this->data['title'] = $this->title." Search Result";  
                $this->data['filtered_by'] = implode(', ',$filtered_by);
                $buttons['filter']['type'] = 'info btn-rounded';
                $this->data['filter_col'] = floor(($filter_count+7)/3);
            }
        } elseif ($_SESSION['filter']) {
            $variables = array();
            foreach ($_SESSION['filter'] as $key => $value) {
                $variables['filter_'.$key] = $value;
            }
            $data_filter = $this->_getFilter($variables);

            $this->data['filter'] = $data_filter['data'];
            $filter = $data_filter['filter'];
            $filtered_by = $data_filter['filtered_by'];
            $filter_count = $data_filter['filter_count'];

            if (!empty($filtered_by)){
                $this->data['title'] = $this->title." Search Result";  
                $this->data['filtered_by'] = implode(', ',$filtered_by);
                $buttons['filter']['type'] = 'info btn-rounded';
                $this->data['filter_col'] = floor(($filter_count+7)/3);
            }
        }
        $this->data['buttons'] = $buttons;

        $limit = 20;
        $offset = ($page-1)*$limit;
    	$data = $this->model->filter("where is_delete=0 ".$filter)->limit_offset("limit $limit offset $offset")->order("order by created_at desc, year desc")->getAll();
        $data = $this->getDocumentDetail($data);
        
        /* COUNTER */

            $counter = $this->model->getTotalDocuments($filter);
            $counter['page_document'] = ($offset+1).' ... '.($offset+$limit);

            if ($counter['documents']<($offset+$limit))
                $counter['page_document'] = ($offset+1).' ... '.$counter['documents'];

            if ($counter['documents']<=0){
                $counter['page_document'] = '0 ... 0';
            }

            $this->data['counter'] = $counter;
        /* END COUNTER*/

        /* PAGINATION */
            $max_page = ceil($counter['documents']/$limit);
            $this->data['max_page'] = $max_page;
            $this->data['page'] = $page;
        /* END PAGINATION */

    	$this->data['data'] = $data;
        $this->template->viewDefault($this->view, $this->data);
    }

    public function detail($id=null){
        if (empty($id)){
            redirect();
        }
        $this->load->model("Document_log_model");
        $this->load->model("Classification_model");
        $this->load->model("User_model");
        $this->load->model("Workunit_model");

        $data = $this->model->filter("where id='{$id}'")->getBy();
        $classification = $this->Classification_model->filter("where id=".$data['classification_id'])->getBy();
        $data['classification_code'] = $classification['code'].' - '.$classification['name'];
        $data['workunit_name'] = $this->Workunit_model->column('name')->filter("where id=".$data['workunit_id'])->getOne();

        $histories = $this->Document_log_model->filter("where type='".Document_log_model::TYPE_HISTORY."' and document_id='".$id."'")->order("order by created_at desc")->getAll();
        foreach ($histories as $key => $history) {
            $user = $this->User_model->filter("where id='".$history['user_id']."'")->getBy();
            $histories[$key]['user_name'] = $user['name'];
            $histories[$key]['datetime'] = date("d M Y H:i",strtotime($history['created_at']));
        }
        $data['history'] = $histories;

        $activities = $this->Document_log_model->filter("where type='".Document_log_model::TYPE_ACTIVITY."' and document_id='".$id."'")->order("order by created_at desc")->getAll();
        foreach ($activities as $key => $activity) {
            $user = $this->User_model->filter("where id='".$activity['user_id']."'")->getBy();
            $activities[$key]['user_name'] = $user['name'];
            $activities[$key]['datetime'] = date("d M Y H:i",strtotime($activity['created_at']));
        }
        $data['activity'] = $activities;

        $this->data['data'] = $data;
        $this->template->viewDefault($this->view, $this->data);
    }

    public function ajaxGetFile($document_id=null){
        if (empty($document_id) or !SessionManagerWeb::isAuthenticated()){
            echo false;
            die;
        }

        $posts = $this->input->post(null, true);

        $this->load->model('Document_model');

        $this->load->model("File_model");
        $file = $this->File_model->show_sql(false)->filter("where document_id='$document_id'")->getBy();

        if (!empty($file)){

            if ($file['type']==File_model::TYPE_LOCAL){

            }

            $file['document_name'] = $this->Document_model->column("name")->filter("where id='$document_id'")->getOne();
            if ($posts['with_user']){
                $file['user'] = SessionManagerWeb::getName();
            }
            if ($posts['with_date']){
                $file['date'] = date("d M Y");
            }

            $this->load->model("Document_log_model");
            $record = array(
                'document_id' => $document_id,
                'user_id' => SessionManagerWeb::getUserID(),
                'text' => "Mendownload / Melihat dokumen ini.",
                'type' => Document_log_model::TYPE_ACTIVITY
            );

            if (!empty($posts['log_text'])){
                $record['text'] = $posts['log_text'];
            }
            $this->Document_log_model->insert($record, false, false);
            echo json_encode($file);
        } else {
            echo false;
            die;
        }
    }

    public function ajaxGetDocumentWithFile($document_id=null){
        if (empty($document_id) or !SessionManagerWeb::isAuthenticated()){
            echo false;
            die;
        }

        $this->load->model('Document_model');

        $document = $this->Document_model->filter("where id='$document_id'")->getBy();
        if (!empty($document)){
            $document['file'] = '';

            $this->load->model("File_model");
            $file = $this->File_model->filter("where document_id='$document_id'")->getBy();
            if (!empty($file)){
                if ($file['type']==File_model::TYPE_CLOUD){
                    $document['file'] = $file['file'];
                }
            }
            echo json_encode($document);
        } else {
            echo false;
            die;
        }
    }

    public function ajaxCreate(){
    	$record = $this->input->post(null, true);
    	$record['user_id'] = SessionManagerWeb::getUserID();
    	$document_id = $this->model->insert($record, false, true);
        if (!$document_id){
            echo false;
            die;
        } 

        $this->load->model("Document_log_model");
        $record = array(
        	'document_id' => $document_id,
        	'user_id' => SessionManagerWeb::getUserID(),
        	'text' => "Added this document"
        );
        $this->Document_log_model->insert($record, false, false);
        echo true;
    }

    public function ajaxUpdate($document_id){
        $record = $this->input->post(null, true);
        $param = array();
        $param['user_id'] = SessionManagerWeb::getUserID();
        if (!$this->model->update($document_id,$record, $param)){
            echo false;
            die;
        } 
        echo true;
    }

    public function ajaxGetDocument($document_id=null){
        if (empty($document_id)){
            echo false;
            die();
        }
        $this->load->model("Document_model");
        $this->load->model("Document_log_model");
        $this->load->model("Classification_model");
        $this->load->model("User_model");


        $data = array();
        
        $document = $this->Document_model->filter("where is_delete=0 and id='".$document_id."'")->getBy();
        $classification = $this->Classification_model->filter("where id=".$document['classification_id'])->getBy();
        $document['classification_code'] = $classification['code'].' - '.$classification['name'];
        $data = $document;
        
        $data_json = json_encode($data);
        echo $data_json;
    }
}
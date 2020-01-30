<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Document_model extends AppModel {
    protected $_table = 'documents';

    public function __construct() {
        parent::__construct();
    }

    public function resetParameters(){
        parent::resetParameters();
        $this->_table = 'documents';
    }

    public function insert($data, $skip_validation = FALSE, $return = TRUE) {     
        $create = dbInsert($this->_table, $data);
        if ($create) {
            if($return)
                return dbGetOne("select id from $this->_table where file_name='".$data['file_name']."'");
            else
                return true;
        }
        return FALSE;
    }

    public function update($id, $data, $param){
        if ($data==NULL or $id==null){
            return false;
        }

        if (!dbUpdate($this->_table, $data, "id='{$id}'")){
            return false;
        }
        $this->load->model("Document_log_model");
        $record = array(
            'document_id' => $id,
            'user_id' => $param['user_id'],
            'text' => "Edited this document"
        );
        $this->Document_log_model->insert($record, false, false);
        return true;
        
    }

    // public function delete($id=null,$soft_delete=1){
    //     if (parent::delete($id, $soft_delete)){
    //         $record = array(
    //                     'updated_at' => date("Y-m-d H:i:s"),
    //                     'status' => Status::INACTIVE
    //                 );
    //         return $this->show_sql(true)->filter("id=$id")->update($record);
    //     } else {
    //         return false;
    //     }
    // }

    public function getTotalDocuments($filter=''){
        /* Get Total */
            $blocks = $this->column("block_code")->filter("where is_delete=0 ".$filter)->group_by("group by block_code")->getAll();
            $racks = $this->column("block_code, rack_code")->filter("where is_delete=0 ".$filter)->group_by("group by block_code, rack_code")->getAll();
            $boxes = $this->column("block_code, rack_code, box_code")->filter("where is_delete=0 ".$filter)->group_by("group by block_code, rack_code,box_code")->getAll();
            $envelopes = $this->column("block_code, rack_code, box_code, envelope_code")->filter("where is_delete=0 ".$filter)->group_by("group by block_code, rack_code, box_code, envelope_code")->getAll();
        /* End Get Total */

        /* Checking and Setting */
            $counter = array(
                'blocks' => (!empty($blocks)) ? count($blocks) : 0,
                'racks' => (!empty($racks)) ? count($racks) : 0,
                'boxes' => (!empty($boxes)) ? count($boxes) : 0,
                'envelopes' => (!empty($envelopes)) ? count($envelopes) : 0,
                'documents' => $this->column("count(1)")->filter("where is_delete=0 ".$filter)->getOne(),
            );
        /* End Checking and Setting */

        $total = $counter;
        return $total;
    }
}
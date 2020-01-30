<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class File_model extends AppModel {
    protected $_table = 'files';

    const TYPE_LOCAL = 'L';
    const TYPE_CLOUD = 'C';

    public function __construct() {
        parent::__construct();
    }

    public function resetParameters(){
        parent::resetParameters();
        $this->_table = 'files';
    }

    public function getTypes($type){
        $types = array(
            self::TYPE_LOCAL => 'Local',
            self::TYPE_CLOUD => 'Cloud',
        );
        return empty($type) ? '-' : $types[$type];
    }

    public function insertOrUpdate($document_id, $data, $param){
        if ($data==NULL or $document_id==null){
            return false;
        }

        $is_exist = $this->filter("where document_id='$document_id'")->getOne();
        if ($is_exist){
            if (!dbUpdate($this->_table, $data, "document_id='{$document_id}'")){
                return false;
            }
        } else {
            if (!dbInsert($this->_table, $data)){
                return false;
            }
        }
        
        $this->load->model("Document_log_model");
        $record = array(
            'document_id' => $document_id,
            'user_id' => $param['user_id'],
            'text' => "Mengubah File dari Dokumen ini"
        );
        $this->Document_log_model->insert($record, false, false);
        return true;
        
    }
}
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Document_log_model extends AppModel {
    protected $_table = 'document_logs';

    const TYPE_HISTORY = 'H';
    const TYPE_ACTIVITY = 'A';

    public function __construct() {
        parent::__construct();
    }

    public function resetParameters(){
        parent::resetParameters();
        $this->_table = 'document_logs';
    }   

    public function insert($data, $skip_validation = FALSE, $return = TRUE) {     
        $create = dbInsert($this->_table, $data);
        if ($create) {
            if($return)
                return dbGetOne("select max(id) from $this->_table");
            else
                return true;
        }
        return FALSE;
    }
}
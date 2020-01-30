<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Location_model extends AppModel {
    protected $_table = 'locations';

    public function __construct() {
        parent::__construct();
        $this->_table = 'locations';
    }

    public function resetParameters(){
        parent::resetParameters();
        $this->_table = 'locations';
    }

    public function getStructures($parent=0, $use_json=true){
        $sql = "select id, name as text, code from $this->_table where parent=$parent and is_delete=0 order by name";
        $rows = dbGetRows($sql);
        if (!empty($rows)){
            foreach ($rows as $key => $value) {
                $rows[$key]['text'] = $value['code'].' - '.$value['text'];
                unset($rows[$key]['code']);
                if ($use_json){
                    $rows[$key]['href'] = '#'.$value['id'];
                    $rows[$key]['nodes'] = self::getStructures($value['id']);
                    if (empty($rows[$key]['nodes']))
                        unset($rows[$key]['nodes']);
                    $rows[$key]['tags'] = array(count($rows[$key]['nodes']));
                } else {
                    $rows[$key]['child'] = self::getStructures($value['id'], false);
                    if (empty($rows[$key]['child']))
                        unset($rows[$key]['child']);
                }
                
            }
        } 
        return $rows;
    }

    public function create($data, $skip_validation = FALSE, $return = TRUE) {     
        $create = dbInsert("$this->_table", $data);
        if ($create) {
            return true;
        }
        return FALSE;
    }

    public function save($primary_value, $data = array(), $skip_validation = FALSE) {
        $this->_database->trans_begin();
        $update = $this->filter("id='".$primary_value."'")->update($data);
        
        if ($update) {
            return $this->_database->trans_commit();
        }
        $this->_database->trans_rollback();
        return FALSE;
    }
}
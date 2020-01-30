<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class AppModel extends BehaviorModel {

    /**
     * Initialize Behaviour Model 
     */
    protected $return_type = 'array';
    protected $protected_attributes = array('hash');
    protected $before_create = array('created_at', 'updated_at');
    protected $before_update = array('updated_at');
    protected $soft_data = NULL;
    protected $mapper = array();
    protected $label = array();
    protected $validation = array();
    protected $after_get = array('mapper', 'property');
    protected $before_get = array('join_or_where');
    protected $show_all = FALSE;
    protected $fields = array();

    /* CUSTOM */
        protected $_column = '*';
        protected $_table = '';
        protected $_join = '';
        protected $_filter = '';
        protected $_limit = '';
        protected $_offset = '';
        protected $_group_by = '';
        protected $_order_by = '';
        protected $_show_sql = false;
    /* END CUSTOM */

    public function __construct() {
        parent::__construct();

        $this->setLabel();

        $this->setValidation();

        $this->setField();
    }

    protected function setField() {
        
    }

    protected function setLabel() {
        $label = array();
        foreach ($this->label as $key => $val) {
            if (is_numeric($key)) {
                $label[$val] = humanize($val);
            } else {
                $label[$key] = $val;
            }
        }
        $this->label = $label;
    }

    public function getLabel($field) {
        return $this->label[$field];
    }

    protected function setValidation() {
        foreach ($this->validation as $key => $val) {
            $this->validate[] = array(
                'field' => $key,
                'label' => (isset($this->label[$key]) ? $this->label[$key] : humanize($key)),
                'rules' => $val
            );
        }
    }

    public function getErrorValidate() {
        $error = array();
        foreach ($this->validation as $key => $val) {
            $err = form_error($key);
            if (!empty($err)) {
                $error[camelize($key)] = $err;
            }
        }
        return $error;
    }

    public function getErrorManualValidation($fields = array()) {
        $error = array();
        foreach ($fields as $field) {
            $err = form_error($field);
            if (!empty($err)) {
                $error[camelize($field)] = $err;
            }
        }
        return $error;
    }

    public function mapper($row) {
        $newRow = array();
        foreach ($row as $key => $val) {
            //MAPPER ATRIBUTE
            if (is_null($this->soft_data) || in_array($key, $this->soft_data) || $this->show_all) {
                // $newKey = key_exists($key, $this->mapper) ? $this->mapper[$key] : camelize($key);
                $newKey = key_exists($key, $this->mapper) ? $this->mapper[$key] : $key;
                $newRow[$newKey] = $val;
            }
        }
        return $newRow;
    }

    public function getClassName() {
        return str_replace(' ', '', humanize(singular(preg_replace('/(_m|_model)?$/', '', get_class($this)))));
    }

    public function setFieldDB($data = array(), $fields = array()) {
        if (empty($fields)) {
            if (empty($this->fields)) {
                $fields = $this->_database->list_fields($this->_table);
            } else {
                $fields = $this->fields;
            }
		}
		$mapperData = array();
        foreach ($data as $field => $value) {
			$field = Util::camelizeToUnderscore($field);

            if (in_array($field, $fields)) {
                $mapperData[$field] = $value;
            }
        }
		return $mapperData;
    }

    public function create($data, $skip_validation = FALSE, $return = TRUE) {
        return $this->insert($this->setFieldDB($data), $skip_validation, $return);
    }

    public function defaultCreate($data, $skip_validation = FALSE, $return = TRUE) {
        return $this->insert($this->setFieldDB($data), $skip_validation, $return);
    }

    public function save($primary_value, $data = array(), $skip_validation = FALSE) {
//        foreach ($this->validate as $key => $validate) {
//            $this->validate[$key]['rules'] = str_replace('is_unique', 'is_unique_exclude', $validate['field']);
//        }
        return $this->update($primary_value, $this->setFieldDB($data), $skip_validation);
    }

    protected function property($row) {
        return $row;
    }

    protected function join_or_where($row) {
        return $row;
    }

    public function show_all($show_all = FALSE) {
        $this->show_all = $show_all;
        return $this;
    }

    public function validateRequired($data, $validation = array()) {
        foreach ($validation as $key => $val) {
            if (!isset($data[$key]) || (isset($data[$key]) && empty($data[$key]))) {
                return $val;
            }
        }
        return TRUE;
    }


    protected function generateRandomString($length = 64) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /* CUSTOM  */
        public function resetParameters(){
            $this->_column = '*';
            // $this->_table = '';
            $this->_join = '';
            $this->_filter = '';
            $this->_limit_offset = '';
            $this->_group_by = '';
            $this->_order_by = '';
            $this->_show_sql = false;
        }

        public function column($column='*'){
            $this->_column = $column;
            return $this;
        }

         public function table($table=''){
            $this->_table = $table;
            return $this;
        }

        public function join($join=''){
            $this->_join = $join;
            return $this;
        }

        public function filter($filter){
            $this->_filter = $filter;
            return $this;
        }

        public function group_by($group_by=''){
            $this->_group_by = $group_by;
            return $this;
        }

        public function order($order_by=''){
            $this->_order_by = $order_by;
            return $this;
        }

        // public function limit($limit=''){
        //     $this->_limit = $limit;
        //     return $this;
        // }

        // public function offset($offset=''){
        //     $this->_offset = $offset;
        //     return $this;
        // }

        public function limit_offset($limit_offset=''){
            $this->_limit_offset = $limit_offset;
            return $this;
        }

        public function show_sql($show_sql=false){
            $this->_show_sql = $show_sql;
            return $this;
        }

        public function getAll(){
            $sql = "select $this->_column from $this->_table $this->_join $this->_filter $this->_group_by $this->_order_by $this->_limit_offset";
            if ($this->_show_sql){
                echo ($sql);
                die();
            }
            $rows = dbGetRows($sql);
            self::resetParameters();
            return $rows;
        }

        public function getBy(){
            $sql = "select $this->_column from $this->_table $this->_join $this->_filter $this->_group_by $this->_order_by $this->_limit_offset";
            if ($this->_show_sql){
                echo ($sql);
                die();
            }
            $row = dbGetRow($sql);
            self::resetParameters();
            return $row;
        }

        public function getOne(){
            $sql = "select $this->_column from $this->_table $this->_join $this->_filter $this->_group_by $this->_order_by $this->_limit_offset";
            if ($this->_show_sql){
                echo ($sql);
                die();
            }
            $col = dbGetOne($sql);
            self::resetParameters();
            return $col;
        }   

        public function delete($id=null,$soft_delete=1){
            if ($id==null){
                return false;
            }
            if ($soft_delete){
                $data = array(
                    'is_delete' => 1
                );
                return dbUpdate("$this->_table", $data, "id=$id");
            } else {
                $sql = "delete from $this->_table where id=$id";
                return dbQuery($sql);
            }
        }

        public function update($data=NULL){
            if ($data==NULL){
                return false;
            }
            
            // $this->filter without where
            return dbUpdate($this->_table, $data, $this->_filter);
        }

        public function isExist($filter=''){
            $is_exist = $this->column('1')->filter($filter)->getOne();
            return $is_exist;
        }

    /* END CUSTOM */

}

<?php

/* Function Summary */
    /*
        add()                           =>  Tampilan nambah dokumen yang akan di import
        migrate()                       =>  Untuk handling migrasinya
        _appendErrorDatas()             =>  Mengisi error - error migrasi
        _checkDocumentExist()           =>  Ngecek dokumen ada atau tidak, dilihat dari nama file nya
        _generateError()                =>  Generate Error
        _getOverwriteMigrationData()    =>  Get data dari excel per kolomnya
        _insertLog()                    =>  Masukin log
        _overwrite()                    =>  Memproses migrasi overwrite
        _readFile()                     =>  Read file excel yang di upload
    */
/* End Function Summary */

class Migration extends WEB_Controller {
    protected $title = 'Migration';

    public function add($type='documents') {
        if (!SessionManagerWeb::isAdministrator()){
            redirect();
        }

        $this->data['title'] = 'Data Migration Excel File';
        switch ($type) {
            case 'documents':
                $this->data['title'] = 'Data Migration Excel File';
            break;
            
            case 'classifications':
                $this->data['title'] = 'Migrate Classifications';
            break;

            case 'overwrite':
                $this->data['title'] = 'Overwrite / Update Documents Migration';
            break;
        }
        $this->data['type']=$type;
        $this->template->viewDefault($this->view, $this->data);
    }

    public function migrate($type="documents")  {
        $redirect = 'web/migration/add/'.$type;

        if (empty($_FILES['file'])) {
            SessionManagerWeb::setFlashMsg(false, 'File tidak ditemukan, mohon ulangi beberapa saat lagi');
            redirect($redirect);
        }
        $folder ="migration/".$type;
        
        /* Uploading */
            $CI = & get_instance();
            $user_id = SessionManagerWeb::getUserID();

            $ciConfig = $this->config->item('utils');
            $path = $ciConfig['full_upload_dir'] . $folder . '/';
            if (!is_dir($path)) {
               mkdir($path);         
            }

            $file_names = explode(".",$_FILES['file']['name']);
            $ext = end($file_names);

            $config = array();
            $config['upload_path'] = $path = $ciConfig['full_upload_dir'] . $folder . '/';
            $config['allowed_types'] = 'xls|xlsx';
            $config['file_name'] = $file = $user_id.".".$ext;
            $CI->load->library('upload');

            $upload = new CI_Upload($config);
            $upload->overwrite = true;
            if (!$upload->do_upload('file')){
                SessionManagerWeb::setFlashMsg(false, 'Upload file Gagal, mohon ulangi beberapa saat lagi');
                redirect($redirect);
            }
        /* End Uploading */

        /* Migrating */
            switch ($type) {
                /* Migrating Documents Metadata */
                    case 'documents':
                        $this->load->model("Classification_model");
                        $this->load->model("Workunit_model");
                        $this->load->model("Document_model");
                        $this->load->model("Document_log_model");
                        $this->load->library('Libexcel');

                        $tmpfname = $path.$file;

                        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
                        $worksheetData = $excelReader->listWorksheetInfo($tmpfname);
                        $excelObj = $excelReader->load($tmpfname);
                        $worksheet = $excelObj->getSheet(0);
                        $lastRow = $worksheet->getHighestRow();
                        $column = array();
                        $error_datas = array();
                        $error_idx = 0;
                        for ($row = 2; $row <= $worksheetData[0]['totalRows']; $row++) {
                            $is_error = false;
                            $error_reasons = array();
                            $data = array();
                            for ($col = 0 ; $col < $worksheetData[0]['totalColumns']; $col++){
                                $colString = PHPExcel_Cell::stringFromColumnIndex($col);
                                $value =  $worksheet->getCell($colString.$row)->getValue();
                                switch($col){
                                    case 0:
                                        if (!empty($value)){
                                            $data['name'] = $value;
                                        } else {
                                            $is_error = true;
                                            $error_reasons[] = "Nama Kosong";
                                        }
                                    break;
                                    case 1:
                                        if (!empty($value)){
                                            $classification_id = $this->Classification_model->column("id")->filter("where code='{$value}'")->getOne();
                                            if (!empty($classification_id)){
                                                $data['classification_id'] = (int)$classification_id;
                                                $classification_code = $value;
                                            } else {
                                                $is_error = true;
                                                $error_reasons[] = "Kode Klasifikasi tidak ditemukan di Sistem";
                                            }
                                        } else {
                                            $is_error = true;
                                            $error_reasons[] = "Klasifikasi Kosong";
                                        }
                                    break;
                                    case 2:
                                        if (!empty($value)){
                                            $workunit_exist = $this->Workunit_model->column("1")->filter("where id={$value}")->getOne();
                                            if (!empty($workunit_exist)){
                                                $data['workunit_id'] = (int)$value;
                                            } else {
                                                $is_error = true;
                                                $error_reasons[] = "Kode Unit Kerja tidak ditemukan di Sistem";
                                            }
                                        } else {
                                            $is_error = true;
                                            $error_reasons[] = "Klasifikasi Kosong";
                                        }
                                        
                                    break;
                                    case 3:
                                        if (!empty($value)){
                                            $data['year'] = (string)$value;
                                        } else {
                                            $is_error = true;
                                            $error_reasons[] = "Tahun Kosong";
                                        }
                                    break;
                                    case 4:
                                        if (!empty($value)){
                                            $data['archive_number'] = (string)$value; 
                                        } else {
                                            $is_error = true;
                                            $error_reasons[] = "No Arsip Kosong";
                                        }
                                    break;
                                    case 5:
                                        if (!empty($value)){
                                            $data['envelope_code'] = (string)$value; 
                                        } else {
                                            $is_error = true;
                                            $error_reasons[] = "Kode Sampul Kosong";
                                        }                            
                                    break;
                                    case 6:
                                        if (!empty($value)){
                                            $data['box_code'] = (string)$value;
                                        } else {
                                            $is_error = true;
                                            $error_reasons[] = "Kode Box Kosong";
                                        }
                                    break;
                                    case 7:
                                        if (!empty($value)){
                                            $data['rack_code'] = (string)$value; 
                                        } else {
                                            $is_error = true;
                                            $error_reasons[] = "Kode Rak Kosong";
                                        }
                                    break;
                                    case 8:
                                        if (!empty($value)){
                                            $data['block_code'] = (string)$value; 
                                        } else {
                                            $is_error = true;
                                            $error_reasons[] = "Kode Blok Kosong";
                                        }
                                    break;
                                    case 9:
                                        if (!empty($value)){
                                            $data['condition'] = (string)$value; 
                                        } else {
                                            $is_error = true;
                                            $error_reasons[] = "Kondisi Kosong";
                                        }
                                    break;
                                }
                            }

                            $data['user_id'] = SessionManagerWeb::getUserID();
                            $data['location_code'] = "B.".$data['block_code'].".R.".$data['rack_code'].".".$data['box_code'];
                            $data['file_name'] = $classification_code."_".$data['year']."_".$data['block_code']."_".$data['rack_code']."_".$data['box_code']."_".$data['envelope_code']."_".$data['archive_number'];
                            $data['folder_name'] = $classification_code."_".$data['box_code']."_".$data['envelope_code']."_".$data['year'];

                            // check document exist
                            $is_document_exist = $this->Document_model->column("1")->filter("where file_name='".$data['file_name']."'")->getOne();
                            if ($is_document_exist){
                                $is_error = true;
                                $error_reasons[] = "Dokumen sudah ada di Sistem";
                            }

                            if ($is_error){
                                $error_datas[$error_idx] = $data;
                                $error_datas[$error_idx]['classification_code'] = $classification_code;
                                $error_datas[$error_idx]['error'] = implode(",\n", $error_reasons);
                                $error_datas[$error_idx]['row'] = $row;
                                $error_idx++;
                                continue;
                            }
                            
                            if (!$this->Document_model->insert($data, false, false)){
                                $error_datas[$error_idx] = $data;
                                $error_datas[$error_idx]['classification_code'] = $classification_code;
                                $error_datas[$error_idx]['error'] = "Gagal memasukkan data, coba kembali";
                                $error_datas[$error_idx]['row'] = $row;
                                $error_idx++;
                            } else {
                                $document_id = $this->Document_model->column("id")->filter("where file_name='".$data['file_name']."'")->getOne();
                                $record = array(
                                    'document_id' => $document_id,
                                    'user_id' => SessionManagerWeb::getUserID(),
                                    'text' => "Menambahkan dokumen ini lewat migrasi data"
                                );
                                $this->Document_log_model->insert($record, false, false);
                            }
                        }
                    break;
                /* End Migrating Documents Metadata */

                /* Migration Overwrite Metadata */
                    case 'overwrite':
                        $file_location = $path.$file;
                        $migration = $this->_overwrite($file_location);
                        $error_datas = $migration['error_datas'];
                        $error_idx = $migration['error_idx'];
                    break;
                /* Migration Overwrite Metadata */

                /* Import Classifications */
                    case 'classifications':
                        $this->load->model("Classification_model");
                        $this->load->library('Libexcel');

                        $tmpfname = $path.$file;

                        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
                        $worksheetData = $excelReader->listWorksheetInfo($tmpfname);
                        $excelObj = $excelReader->load($tmpfname);
                        $worksheet = $excelObj->getSheet(0);
                        $lastRow = $worksheet->getHighestRow();
                        $column = array();
                        $error_datas = array();
                        $error_idx = 0;
                        for ($row = 2; $row <= $worksheetData[0]['totalRows']; $row++) {
                            $is_error = false;
                            $error_reasons = array();
                            $data = array();
                            for ($col = 0 ; $col < $worksheetData[0]['totalColumns']; $col++){
                                $colString = PHPExcel_Cell::stringFromColumnIndex($col);
                                $value =  $worksheet->getCell($colString.$row)->getValue();
                                switch($col){
                                    case 0:
                                        if (!empty($value)){
                                            $data['code'] = $value;
                                            $is_exist = $this->Classification_model->column("1")->filter("where code='{$value}'")->getOne();
                                            if ($is_exist){
                                                $is_error = true;
                                                $error_reasons[] = "Kode Klasifikasi sudah ada di Sistem";
                                            }
                                        } else {
                                            $is_error = true;
                                            $error_reasons[] = "Kode Klasifikasi Kosong";
                                        }
                                    break;
                                    case 1:                                    
                                        if (!empty($value)){
                                            $data['name'] = $value;
                                        } else {
                                            $is_error = true;
                                            $error_reasons[] = "Nama Kosong";
                                        }
                                    break;
                                    case 2:
                                        $value=trim($value," ");
                                        if ($value!=null and $value!=''){
                                            $value=str_pad($value,3, "0", STR_PAD_LEFT);
                                            $classification_id = $this->Classification_model->column("id")->filter("where code='{$value}'")->getOne();
                                            if (!empty($classification_id)){
                                                $data['parent'] = $classification_id;
                                            } else {
                                                $is_error = true;
                                                $error_reasons[] = "Parent tidak ditemukan di Sistem";
                                            }
                                        } else {
                                            $data['parent'] = null;
                                        }
                                    break;
                                }
                            }
                            if ($is_error){
                                // $error_datas[$error_idx] = $data;
                                $error_datas[$error_idx]['name'] = '<b>['.$data['code'].']</b> '.$data['name'];
                                $error_datas[$error_idx]['error'] = implode(",\n", $error_reasons);
                                $error_datas[$error_idx]['row'] = $row;
                                $error_idx++;
                                continue;
                            }
                            
                            if (!$this->Classification_model->create($data, false, false)){
                                // $error_datas[$error_idx] = $data;
                                $error_datas[$error_idx]['name'] = '<b>['.$data['code'].']</b> '.$data['name'];
                                $error_datas[$error_idx]['error'] = "Gagal memasukkan data, coba kembali";
                                $error_datas[$error_idx]['row'] = $row;
                                $error_idx++;
                            }
                        }
                    break;
                /* End Import Classifications */
            }
        /* End Migrating */

        

        $this->data['error_datas'] = $error_datas;
        $this->data['error_total'] = $error_idx;
        $this->data['type']=$type;

        $buttons = array();
        $buttons['download'] = array('label' => ' Download', 'type' => 'primary', 'icon' => 'download', 'click' => 'goDownload()');
        $this->data['buttons'] = $buttons;
        SessionManagerWeb::setVariables($error_datas, 'migration_errors');
        
        $this->template->viewDefault($this->class . '_errors', $this->data);
    }

    private function _appendErrorDatas($row, $data, $error_reasons, &$error_datas, &$error_idx){
        $error_datas[$error_idx] = $data;
        $error_datas[$error_idx]['error'] = implode(",\n", $error_reasons);
        $error_datas[$error_idx]['row'] = $row;
        $error_idx++;
    }

    private function _checkDocumentExist($data=array()){
        $is_document_exist = $this->Document_model->column("1")->filter("where file_name='".$data['file_name']."'")->getOne();
        if ($is_document_exist)
            return true;
        return false;
    }

    private function _generateError($error_msg='Error', &$is_error, &$error_reasons){
        $is_error = true;
        $error_reasons[] = $error_msg;
    }

    private function _getOverwriteMigrationData($row, $php_excel, &$data, &$is_error, &$error_reasons){
        $max_column = 'K';
        $first_row = 1;
        $is_next_done = false;
        for ($col = 0 ; $col < $php_excel['worksheet_data'][0]['totalColumns']; $col++){
            if ($is_next_done)
                break;

            $colString = PHPExcel_Cell::stringFromColumnIndex($col);
            if ($colString==$max_column){
                $is_next_done = true;
            }


            $value =  $php_excel['worksheet']->getCell($colString.$row)->getValue();

            /* Check Value Kosong */
                if (empty($value)){
                    $column_name = $php_excel['worksheet']->getCell($colString.$first_row)->getValue();
                    $this->_generateError($column_name.' Kosong', $is_error, $error_reasons);
                    continue;
                }
            /* End Check Value Kosong */

            switch($col){
                case 0:
                    if (!$this->Document_model->isExist("where file_name='{$value}'")){
                        $this->_generateError("Dokumen dengan kode '$value' tidak ditemukan", $is_error, $error_reasons);
                        continue;
                    }
                    $data['document_id'] = $this->Document_model->column("id")->filter("where file_name='{$value}'")->getOne();
                break;
                case 1:
                    $data['name'] = $value;
                break;
                case 2:
                    $classification_id = $this->Classification_model->column("id")->filter("where code='{$value}'")->getOne();
                    if (empty($classification_id)){
                        $this->_generateError('Kode Klasifikasi tidak ditemukan di Sistem', $is_error, $error_reasons);
                        continue;
                    }

                    $data['classification_id'] = (int)$classification_id;
                    $classification_code = $value;
                break;
                case 3:
                    if (!$this->Workunit_model->isExist("where id={$value}")){
                        $this->_generateError("Kode Unit Kerja tidak ditemukan di Sistem", $is_error, $error_reasons);
                        continue;
                    }

                    $data['workunit_id'] = (int)$value;
                break;
                case 4:
                    $data['year'] = (string)$value;
                break;
                case 5:
                    $data['archive_number'] = (string)$value;
                break;
                case 6:
                    $data['envelope_code'] = (string)$value;                        
                break;
                case 7:
                    $data['box_code'] = (string)$value;
                break;
                case 8:
                    $data['rack_code'] = (string)$value;
                break;
                case 9:
                    $data['block_code'] = (string)$value;
                break;
                case 10:
                    $data['condition'] = (string)$value;
                break;
            }
        }

        $data['user_id'] = SessionManagerWeb::getUserID();
        $data['location_code'] = "B.".$data['block_code'].".R.".$data['rack_code'].".".$data['box_code'];
        $data['file_name'] = $classification_code."_".$data['year']."_".$data['block_code']."_".$data['rack_code']."_".$data['box_code']."_".$data['envelope_code']."_".$data['archive_number'];
        $data['folder_name'] = $classification_code."_".$data['box_code']."_".$data['envelope_code']."_".$data['year'];
    }

    private function _insertLog($data = array(), $msg = ''){
        $document_id = $this->Document_model->column("id")->filter("where file_name='".$data['file_name']."'")->getOne();
        $record = array(
            'document_id' => $document_id,
            'user_id' => SessionManagerWeb::getUserID(),
            'text' => $msg
        );
        $this->Document_log_model->insert($record, false, false);
    }


    /* Memproses migrasi overwrite */
    private function _overwrite($file_location=''){
        /* Load Model */
            $this->load->model("Classification_model");
            $this->load->model("Workunit_model");
            $this->load->model("Document_model");
            $this->load->model("Document_log_model");
        /* End Load Model */

        /* Load Library */
            $this->load->library('Libexcel');
        /* End Load Library */

        /* Read Data */
            /* Get Excel Components */
                $php_excel = $this->_readFile($file_location);
            /* End Get Excel Components */

            /* Read Data from Excel */
                $column = array();
                $error_datas = array();
                $error_idx = 0;
                for ($row = 2; $row <= $php_excel['worksheet_data'][0]['totalRows']; $row++) {
                    /* Get Excel Data with Check Errors */
                        $is_error = false;
                        $error_reasons = array();
                        $data = array();
                        $this->_getOverwriteMigrationData($row, $php_excel, $data, $is_error, $error_reasons);
                    /* End Get Excel Data with Check Errors */

                    /* Error Summary */
                        if ($is_error){
                            $this->_appendErrorDatas($row, $data, $error_reasons, $error_datas, $error_idx);
                            continue;
                        }
                    /* End Error Summary */
                    
                    /* Update Document */
                        $document_id = $data['document_id'];
                        unset($data['document_id']);
                        $param = array('user_id'=>SessionManagerWeb::getUserID());
                        if (!$this->Document_model->update($document_id, $data, $param)){
                            $errors = array("Gagal mengubah data, coba kembali");
                            $this->_appendErrorDatas($row, $data, $errors, $error_datas, $error_idx);
                            continue;
                        }
                    /* End Update Document */
                    
                    /* Insert Log */
                        $this->_insertLog($data, "Mengubah metadata dokumen ini lewat migrasi overwrite metadata");
                    /* End Insert Log */
                }
            /* End Read Data from Excel */
        /* End Read Data */

        /* Returns */
            $migration = array(
                'error_datas' => $error_datas,
                'error_idx' => $error_idx
            );
            return $migration;
        /* End Returns */
    }

    private function _readFile($file){
        $excelReader = PHPExcel_IOFactory::createReaderForFile($file);
        $excelObj = $excelReader->load($file);

        $php_excel = array(
            'worksheet_data' => $excelReader->listWorksheetInfo($file),
            'worksheet' => $excelObj->getSheet(0)
        );

        return $php_excel;
    }
}
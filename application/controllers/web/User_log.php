<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_log extends WEB_Controller {

    protected $title = 'Akses Aplikasi';

    public function index() {
        if (!SessionManagerWeb::isAdministrator()){
            SessionManagerWeb::setFlashMsg(false, "Anda tidak mempunyai akses ke halaman tersebut.");
            redirect('web/user_application');
        }
        $this->data['title'] = $this->data['method_name'] = 'Informasi';
        $this->data['class_name'] = "Akses Aplikasi";

        // variables
        $types = $this->model->getType(null, true);
        $this->data['variables']['types'] = $types;
        $status = $this->model->getStatus(null, true);
        $this->data['variables']['status'] = $status;

        // filter
        $filter = 'where 1=1';

        // buttons
        $buttons = array();
        if ($_POST){
            $buttons['clear'] = array('label' => 'Bersihkan Filter', 'type' => 'warning', 'icon' => 'close', 'click' => 'goClear()');

            $this->data['filter'] = array();

            // date
            if (!empty($this->input->post('date_start', true))) {
                $start = date("Y-m-d",strtotime($this->input->post('date_start', true)));
                $end = date("Y-m-d",strtotime($this->input->post('date_end', true)."+1 day"));

                $this->data['filter']['date']['start'] = $this->input->post('date_start', true);
                $this->data['filter']['date']['end'] = $this->input->post('date_end', true); 
                            
                $this->data['filter']['filtered_by'][] = "Tanggal";
                $filter .="and ul.created_at between '".$start."' and '".$end."'";
            }

            // name
            if (!empty($this->input->post('keyword', true))) {
                $keyword = strtolower($this->input->post('keyword', true));

                $this->data['filter']['keyword'] = $this->input->post('keyword', true);

                $this->data['filter']['filtered_by'][] = "Keyword";

                $filter .="and (lower(u.name) ilike '%".$keyword."%' or lower(ul.description) ilike '%".$keyword."%' or lower(ul.username) ilike '".$keyword."')";
            }

            // tipe
            $filter_type = array();
            foreach ($this->data['variables']['types'] as $key => $value) {
                if (!empty($this->input->post('type-'.$key, true))) {
                    $type = strtolower($this->input->post('type-'.$key, true));

                    if ($type=='on'){
                        $filter_type[] = "'".$key."'";
                        $this->data['variables']['types'][$key]['checked'] = "checked";
                    } else {
                        $this->data['variables']['types'][$key]['checked'] = "";
                    }
                }
            }
            if (!empty($filter_type)){
                $this->data['filter']['filtered_by'][] = "Tipe";

                $filter .="and ul.type in (".implode(',', $filter_type).")";
            }
            

            // status
            $filter_status = array();
            foreach ($this->data['variables']['status'] as $key => $value) {
                if (!empty($this->input->post('status-'.$key, true))) {
                    $status = strtolower($this->input->post('status-'.$key, true));

                    if ($status=='on'){
                        $filter_status[] = "'".$key."'";
                        $this->data['variables']['status'][$key]['checked'] = "checked";
                    } else {
                        $this->data['variables']['status'][$key]['checked'] = "";
                    }
                }
            }
            if (!empty($filter_status)){
                $this->data['filter']['filtered_by'][] = "Status";

                $filter .="and ul.status in (".implode(',', $filter_status).")";
            }

            // filtered by
            $this->data['filter']['filtered_by'] = implode(', ', $this->data['filter']['filtered_by']);

            // check filter null
            if (empty($this->data['filter']) or $this->data['filter']['filtered_by']==null){
                unset($buttons['clear']);
                unset($this->data['filter']['filtered_by']);
            }
        } else {
            $start = date("Y-m-d");
            $end = date("Y-m-d",strtotime($start."+1 day"));
            
            $this->data['filter']['date']['start'] = date("d M Y");
            $this->data['filter']['date']['end'] = date("d M Y");

            $filter .="and ul.created_at between '".$start."' and '".$end."'";
        }
        $buttons['filter'] = array('label' => 'Filter', 'type' => 'info', 'icon' => 'filter', 'click' => 'goFilter()');
        $this->data['buttons'] = $buttons; 


        // load model
        $this->load->model("User_model");

        $datas = $this->model->show_sql(false)
                             ->column("ul.*, u.name")
                             ->table("user_logs ul")
                             ->join("left join users u on u.username=ul.username")
                             ->filter($filter)
                             ->order("order by id desc")
                             ->getAll();
        foreach ($datas as $key => $data) {
            $datas[$key]['datetime'] = date("d M Y H:i:s",strtotime($data['created_at']));
            if ($data['user_id']=='-'){
                $datas[$key]['name'] = '-';
            }
            $datas[$key]['status_name'] = '-';
            if ($data['status']==User_log_model::STATUS_SUCCESS){
                $datas[$key]['status_name'] = "<span class='label label-success'>Success</span>";
            } elseif ($data['status']==User_log_model::STATUS_FAILED){
                $datas[$key]['status_name'] = "<span class='label label-danger'>Failed</span>";
            } else {
                $datas[$key]['status_name'] = "<span class='label label-inverse'>Tanpa Status</span>";
            }
        }

        $this->data['data'] = $datas;

        $this->template->viewDefault($this->view, $this->data);
    }
}
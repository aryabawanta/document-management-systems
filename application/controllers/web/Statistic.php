<?php

class Statistic extends WEB_Controller {
    protected $title = 'Statistics';

    function __construct() {
        parent::__construct();
    }

    public function existingCondition(){
        $this->data['title'] = 'Existing Condition '.$this->title;

        $this->load->model('Document_model');

        $this->data['data']['total'] = $this->Document_model->getTotalDocuments();

        $this->template->viewDefault($this->class.'_existing', $this->data);
    }

    public function capacity(){
        $this->data['title'] = 'Capacity '.$this->title;

        $this->data['data'] = array(
            'label' => '["01","02","03","04","05", "06", "07", "08", "09", "10", "11", "12", "13", "14","15","16","17","18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28"]',
            'capacity' => "[35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 35, 108, 108, 108, 108]",
            'filled' => "[35,35,35,14,2,0,3,3,35,35,7,0,0,0,0,0,35,35,35,7,0,0,0,0,108,59,0,0]",
            'reality' => "[35,35,35,14,2,0,3,3,35,35,7,0,0,0,0,0,35,35,35,7,0,0,0,0,108,59,0,0]",
        );

        $this->template->viewDefault($this->view, $this->data);
    }

    public function growth(){
        $this->data['title'] = 'Documents Growth';

        $this->load->model('File_model');
        $this->load->model("Document_model");

        $this->data['data']['document'] = array(
            'label' => '["2002","2003","2004","2005","2006","2007","2008","2009","2010","2011","2012","2013","2014","2015", "2016", "2017"]',
            'data' => '[2,0,0,2,67,413,466,667,1222,1792,2132,1013,1015,571,1636,58]'
        );

        $this->data['data']['digitalized'] = array(
            'digitalized' => $this->File_model->column("count(1)")->getOne(),
            'total_document' => $this->Document_model->column("count(1)")->filter("where is_delete=0")->getOne()
        );

        $this->data['data']['digitalized']['hardcopy'] = $this->data['data']['digitalized']['total_document'] - $this->data['data']['digitalized']['digitalized'];


        $this->template->viewDefault($this->view, $this->data);
    }

    public function popular(){
        $this->data['title'] = 'Popular '.$this->title;

        $this->load->model("Classification_model");
        
        $popular_classifications = $this->_getPopularClassifications();
        $classification_code = array();
        foreach ($popular_classifications as $key => $classification) {
            $classification_code[] = $this->Classification_model->column("code")->filter("where id=".$classification['classification_id'])->getOne(); 
        }
        $this->data['data']['classification'] = array(
            'label' => '["'.implode('","', $classification_code).'"]',
            'data' => '['.implode(',', Util::toList($popular_classifications, 'total')).']'
        );

        $this->data['data']['search'] = array(
            'label' => '["Block: 01","Nama: Pengadaaan","Block: 02","Rack: 01","Box: 001"]',
            'data' => '[90,80,70,50,40]'
        );

        $this->template->viewDefault($this->view, $this->data);
    }

    private function _getPopularClassifications(){
        $this->load->model("Document_model");

        $data = $this->Document_model->column("count(1) as total, classification_id")->filter("where is_delete=0")->group_by("group by classification_id")->order("order by total desc")->limit_offset("limit 5 offset 0")->getAll();

        return $data;
    }
}
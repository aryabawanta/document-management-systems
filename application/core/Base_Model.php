<?php

class Base_Model extends CI_Model
{
    public $table;
    public $id;
	public $sort;
	public $filter;

    function __construct() {
		$this->load->database();
	
		$this->table = $this->config->item('db_pre') . $this->table;
        parent::__construct();
    }

    function getList($limit=0, $offset=0) {
        $sql = "select * from $this->table where 1=1 ";
		$sql .= $this->filter;
		$sql .= " order by $this->sort ";

		if ($limit || $offset)
			$sql .= " limit $limit offset $offset ";

        return dbGetRows($sql);
    }
	
	function getCount() {
        $sql = "select count(*) from $this->table where 1=1 ";
		$sql .= $this->filter;

        return dbGetOne($sql);
	}

    function getRow($id) {
		if (!$id)
			return false;
		
		$id = pg_escape_string($id);
		$sql = "select * from $this->table where $this->id='$id' ";

		return dbGetRow($sql);
    }

    function add($record) {
		$ret = dbInsert($this->table, $record);
		if ($ret) 
			return dbGetOne("select max($this->id) from $this->table ");
		return false;
	}
	
    function update($record, $id) {
		$id = pg_escape_string($id);
		
		return dbUpdate($this->table, $record, "$this->id='$id'");
    }

    function delete($id) {
		$id = pg_escape_string($id);
		
		$sql = "delete from $this->table where $this->id=$id ";
		return dbQuery($sql);
    }

	function getID() {
		return $this->id;
	}
	
	function setFilter($filter) {
		if (!empty($filter))
			$this->filter = $filter;
	}

	function addFilter($filter) {
		$this->filter .= $filter;
	}

	function getFilter() {
		return	$this->filter;
	}

	function setSort($sort) {
		if (!empty($sort))
			$this->sort = $sort;
	}

	function getSort() {
		return $this->sort;
	}

	function getSuratIDs($surats) {
		$arr = array();
		foreach ($surats as $surat) {
			$arr[] = $surat['idsurat'];
		}
		return implode(',', $arr);
	}

	function getDisposisiIDs($disposisis) {
		$arr = array();
		foreach ($disposisis as $disposisi) {
			$arr[] = $disposisi['iddisposisi'];
		}
		return implode(',', $arr);
	}

	function setSuratPenerimaArray(&$surats, $ids) {
		$sql = "select p.*, s.nama as statuspenerima, s.bgcolor, s.color, t.tipe from suratpenerima p, suratpenerimastatus s, surat t ".
			"where p.idsuratpenerimastatus=s.idsuratpenerimastatus and p.idsurat=t.idsurat and p.idsurat in ($ids) order by p.penerima_int_text, penerima_int";
		$temp = dbGetRows($sql);
		$list = array();
		foreach ($temp as $row) {
			$list[$row['idsurat']][] = $row;
		}
		foreach ($surats as &$surat) {
			$surat['penerima_list'] = $list[$surat['idsurat']];
		}
	}

	function setDisposisiPenerimaArray(&$disposisis, $ids) {
	        if (!$ids)
	    	    return false;
	    	    
		$sql = "select p.*, s.nama as status, s.bgcolor, s.color from disposisistatus s, disposisipenerima p ".
			"where p.iddisposisistatus=s.iddisposisistatus and p.iddisposisi in ($ids)";

		$temp = dbGetRows($sql);
		$list = array();
		foreach ($temp as $row) {
			$list[$row['iddisposisi']][] = $row;
		}
		foreach ($disposisis as &$disposisi) {
			$disposisi['penerima_list'] = $list[$disposisi['iddisposisi']];
		}
		
	}
	
}

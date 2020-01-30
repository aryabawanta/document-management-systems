<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Publ1c extends WEB_Controller {
		protected $ispublic = true;


		public function importClassifications($is_local=true){
			die();
	        $CI = & get_instance();
	        $this->load->database();

	        $path_source = "C:/xampp/htdocs/sakti/dms/";
	        if (!$is_local)
	        	$path_source = "/var/www/html/dprd/dms/";

	        $file = $path_source."perihal_surat.xlsx";

	        $full_path = $path_source;
	        $this->load->library('Libexcel');

	        $tmpfname = $file;

	        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
	        $worksheetData = $excelReader->listWorksheetInfo($tmpfname);
	        $excelObj = $excelReader->load($tmpfname);
	        $worksheet = $excelObj->getSheet(0);
	        $lastRow = $worksheet->getHighestRow();
	        echo "FAILED DOCUMENTS MIGRATIONS : <br><br>";
	        echo "<table style='border: 1px solid'>";
	        echo "<td style='border: 1px solid'>";
	        echo "Kode Perihal";
	        echo "</td>";
	        echo "<td style='border: 1px solid'>";
	        echo "Perihal";
	        echo "</td>";
	        echo "<td style='border: 1px solid'>";
	        echo "Gagal?";
	        echo "</td>";

	        // clear data
	        $sql = "truncate classifications cascade";
	        dbQuery($sql);

	        $column = array();
	        for ($row = 1; $row <= $worksheetData[0]['totalRows']; $row++) {
	        	
	            $data = array();
	            echo "<tr style='border: 1px solid'>";
	            for ($col = 0 ; $col < $worksheetData[0]['totalColumns']; $col++){
	                $colString = PHPExcel_Cell::stringFromColumnIndex($col);
	                $value =  $worksheet->getCell($colString.$row)->getValue();
	                switch($col){
	                    case 0:
	                    	$arr_value = explode('.', $value);
	                    	$arr_value[0] = str_pad($arr_value[0], 3, '0', STR_PAD_LEFT);
	                        $data['code'] = implode('.', $arr_value);
	                        echo "<td style='border: 1px solid'>";
					        echo $data['code'];
					        echo "</td>";
	                    break;
	                    case 1:
	                        $data['name'] = $value;
	                        echo "<td style='border: 1px solid'>";
					        echo $value;
					        echo "</td>";
	                    break;
	                }
	            }       
	            echo "<td style='border: 1px solid'>";
	            if (!dbInsert('classifications', $data)){
	                
	                echo 'YA';
	            } else {
	                echo  '-';
	            }
	            echo "</td>";
	            echo '</tr>';
	        }
	        echo "</table>";
	    }

	    public function testGoogleDrive(){
	    	echo '<iframe src="https://docs.google.com/viewer?srcid=1O4l1T6IcN2JrjgOm57RO-pjyEIDjuede&pid=explorer&efh=false&a=v&chrome=false&embedded=true" frameborder="0" height="100%" allowfullscreen width="100%"></iframe>';
	    }
    }
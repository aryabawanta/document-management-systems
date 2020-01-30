<?php

class Export extends WEB_Controller {
    protected $title = 'Export';

    function __construct() {
        parent::__construct();
        $this->load->helper('text');
    }

    public function migrationErrors() {
        $data = SessionManagerWeb::getVariables('migration_errors');

        $filename = date("Y_m_d")."_"."migration_errors";  
        $file_ending = "xls";

        //header info for browser
        header("Content-Type: application/vnd.ms-excel; charset=utf-8");    
        header("Content-Disposition: attachment; filename=$filename.xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        echo strip_tags('<table style="table-layout:fixed;overflow:hidden;" align="center" width="1000" height="300">');
        // echo strip_tags("<tr></tr>\n");
        // echo strip_tags("<tr><td colspan=4 style='font-weight:bold'>Migration Errors</td></tr>\n");
        // echo strip_tags("<tr></tr>\n");
        // echo strip_tags("<tr><td>Migrasi Tanggal</td><td>\t".date("d M Y")."</td></tr>\n");
        // echo strip_tags("<tr><td>Migrasi Oleh</td><td colspan=3>\t".SessionManagerWeb::getName()."</td></tr>\n");
        // echo strip_tags("<tr></tr>\n");

        $column_names = array(
            "row" => "Row",
            "name" => "Nama",
            "error" => "Error"
        );

        /*******Start of Formatting for Excel*******/   
        $sep = "\t"; 
        
        $header_insert = '<tr>'; 
        foreach ($data as $k_data => $v_data) {

            $schema_insert = "<tr>";
            foreach ($column_names as $k => $v) {
                if ($k_data==0){
                    $header_insert .= "<td style='border: 1px solid black;background-color:yellow;font-weight:bold;max-height:300px;overflow:hidden'>$v</td>".$sep;
                    // $header_insert .= "$v".$sep;
                    // echo "<b>$v</b>".$sep;
                }
                $schema_insert .= "<td style='border: 1px solid black;text-overflow: ellipsis;white-space: nowrap;max-height:300px;overflow:hidden'>$v_data[$k]</td>".$sep;

                // $schema_insert .= "$v_data[$k]".$sep;
            }
            if ($k_data==0){
                $header_insert = str_replace($sep."$", "", $header_insert);
                $header_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $header_insert);
                $header_insert .= "\t";
                $header_insert = strip_tags($header_insert);
                print(trim($header_insert));
                echo strip_tags('</tr>');
                print("\n");
            }
            $schema_insert = str_replace($sep."$", "", $schema_insert);
            $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
            $schema_insert .= "\t";
            $schema_insert = strip_tags($schema_insert);
            print(trim($schema_insert));
            $schema_insert .= "</tr>";
            print "\n";
        }
        if ($data!=NULL and $data!=false)
            print strip_tags("\n\n<tr></tr><tr></tr>");
        // print "\n\n";

        echo strip_tags('</table>');
    }
}
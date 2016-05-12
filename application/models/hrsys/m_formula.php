<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_formula  extends Main_Model {

	function __construct() {
        parent::__construct();
    }

    public function getValue($consultant_code,$name){
        $row=$this->db->where(array("consultant_code"=>$consultant_code,'name'=>$name))->get("hrsys_formula")->row_array();		
		return $row["value"];
    }
}

?>
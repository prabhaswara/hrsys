<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_Employee extends Main_Model {

    function __construct() {
        parent::__construct();
    }
    
    
    function get($id){
        return $this->db->where("employee_id",$id)->get("hrsys_employee")->row_array();
    }
    
    public function saveOrUpdate($datafrm,$user) {
    
        
    }
    
    public function validate($datafrm) {
        
     
    }
    
}

?>
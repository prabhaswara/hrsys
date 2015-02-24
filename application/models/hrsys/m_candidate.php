<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_candidate extends Main_Model {

   

    function __construct() {
        parent::__construct();
    }
    
    function get($id){
        return $this->db->where("candidate_id",$id)->get("hrsys_candidate")->row_array();
    }
    
    
}

?>
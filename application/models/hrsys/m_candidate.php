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
    
    public function validate($datafrm, $isEdit) {
        $return = array(
            'status' => true,
            'message' => array()
        );

        if (!empty($datafrm)) {

            if (cleanstr($datafrm["name"]) == "") {
                $return["status"] = false;
                $return["message"]["name"] = "Candidate Name cannot be empty";
            }
            
        }

        return $return;
    }
    
    public function saveOrUpdate($data, $sessionData) {
        $candidate=$data["meeting"];
        
        $candidate_id = $candidate["candidate_id"];    
        
        
        if($candidate_id=="" ||$candidate_id==0){ //baru
            $candidate_id=$this->uniqID();
            
            
        }
        
        $this->db->trans_start(TRUE);
        
    }
    
}

?>
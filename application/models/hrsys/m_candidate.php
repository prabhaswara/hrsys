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
            
            if(isset($_FILES["cv"]["type"])&& !in_array($_FILES["cv"]["type"], array("application/pdf","text/pdf")) ){
                $return["message"]["cv"] = "Curriculum vitae must pdf file ";
            }
            
        }

        return $return;
    }
    public function saveOrUpdate($data, $sessionData,&$candidate_id) {
        $vacancy_id=$data["vacancy_id"];
        
        $candidate=$data["candidate"];
        $expertise=$data["expertise"]; 
        $candidate_id = $candidate["candidate_id"];    
        $candidate["status"]=candidate_stat_open;
        
        if(cleanstr($candidate["birthdate"])!=""){
            $candidate["birthdate"]=  balikTgl($candidate["birthdate"]);
        }
        
        $this->db->trans_start(TRUE);
        
        if($candidate_id==0){
            
            $candidate_id=$this->uniqID();
            $candidate["candidate_id"]=$candidate_id;
           
            $this->db->set('dateupdate', 'NOW()', FALSE);
            $this->db->set('userupdate', $sessionData["user"]["user_id"]);
            $this->db->set('datecreate', 'NOW()', FALSE);
            $this->db->set('usercreate', $sessionData["user"]["user_id"]);             
          
            
            $this->db->insert('hrsys_candidate', $candidate);
            
            if($vacancy_id!=0){
                $vacancycandidate["vacancycandidate_id"]=$this->uniqID();
                $vacancycandidate["candidate_id"]=$candidate_id;
                $vacancycandidate["vacancy_id"]=$vacancy_id;
                $vacancycandidate["applicant_stat"]=applicant_stat_shortlist;
                
                $this->db->set('dateupdate', 'NOW()', FALSE);
                $this->db->set('userupdate', $sessionData["user"]["user_id"]);
                $this->db->set('datecreate', 'NOW()', FALSE);
                $this->db->set('usercreate', $sessionData["user"]["user_id"]);             
            
                $this->db->insert('hrsys_vacancycandidate', $vacancycandidate);
            }
            
        }
        else{
           
        }
        
        $this->db->delete( 'hrsys_candidate_skill', array( 'candidate_id' => $candidate_id ) );
        if(!empty($expertise)){
            foreach ($expertise as $row){
                $this->db->insert('hrsys_candidate_skill', array( 'candidate_id' => $candidate_id,'skill'=>$row["skill"])); 
            }            
        } 
        
        
        $this->db->trans_complete();

        return $this->db->trans_status();
    }
    
}

?>
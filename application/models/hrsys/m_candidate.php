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
    
    function getExperties($candidate_id){
        return $this->db->where("candidate_id",$candidate_id)->order_by("skill")->get("hrsys_candidate_skill")->result_array();
    }
    function getDetail($id){
       $sql = "SELECT c.candidate_id,lksat.display_text status, c.name, c.email, c.phone ,c.expectedsalary " .
               ", lksex.display_text sex,c.birthdate,YEAR(now())-YEAR(c.birthdate) age ".
               ", ms.skill skill ".
               "from hrsys_candidate c " .
               "left join tpl_lookup lksat on lksat.type='candidate_stat' and c.status=lksat.value " .
               "left join tpl_lookup lksex on lksex.type='sex' and c.sex=lksex.value " .
               "left join (select candidate_id ,group_concat(skill separator', ') skill from hrsys_candidate_skill group by candidate_id order by skill) ms on ms.candidate_id=c.candidate_id ".
               "WHERE c.candidate_id='$id'";
       
       return $this->db->query($sql)->row_array();
       
       
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
    
    public function addCandidateToVacancy($candidate_id,$vacancy_id,$sessionData){
        $this->load->model('m_vacancy');
        $this->load->model('m_client');
        
        $return=false;
        $chek=$this->db
                ->where("vacancy_id",$vacancy_id)
                ->where("candidate_id",$candidate_id)
                ->get("hrsys_vacancycandidate")->row_array();
        if(empty($chek)){
            
            $vacancy=$this->m_vacancy->get($vacancy_id);
            $client=$this->m_client->get($vacancy["cmpyclient_id"]);
            
            $this->db->trans_start(TRUE);
            $vacancycandidate=array();
            $vacancycandidate["vacancycandidate_id"] = $this->generateID("vacancycandidate_id", "hrsys_vacancycandidate");
            $vacancycandidate["candidate_id"] = $candidate_id;
            $vacancycandidate["vacancy_id"] = $vacancy_id;
            $vacancycandidate["applicant_stat"] = applicant_stat_shortlist;
            
            $this->db->set('candidate_manager', $sessionData["employee"]["emp_id"]);
            $this->db->set('dateupdate', 'NOW()', FALSE);
            $this->db->set('userupdate', $sessionData["user"]["user_id"]);
            $this->db->set('datecreate', 'NOW()', FALSE);
            $this->db->set('usercreate', $sessionData["user"]["user_id"]);
            $this->db->insert('hrsys_vacancycandidate', $vacancycandidate);
            
            $this->db->set('datecreate', 'NOW()', FALSE);
            $this->db->set('usercreate', $sessionData["user"]["user_id"]);
            $this->db->insert('hrsys_candidate_trl', array(
                "candidate_trl_id"=>$this->generateID("candidate_trl_id", "hrsys_candidate_trl"),
                "candidate_id"=>$candidate_id,       
                "vacancy_id"=>$vacancy_id,
                "description"=>"Add to Shortlist ".$vacancy["name"]." ".$client["name"]
                
            ));
            $this->db->trans_complete();

            $return = $this->db->trans_status();
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
            
            $candidate_id=$this->generateID("candidate_id", "hrsys_candidate");
            $candidate["candidate_id"]=$candidate_id;
           
            $this->db->set('dateupdate', 'NOW()', FALSE);
            $this->db->set('userupdate', $sessionData["user"]["user_id"]);
            $this->db->set('datecreate', 'NOW()', FALSE);
            $this->db->set('usercreate', $sessionData["user"]["user_id"]);           
            $this->db->insert('hrsys_candidate', $candidate);       

        }
        else{
            $this->db->set('dateupdate', 'NOW()', FALSE);
            $this->db->set('userupdate', $sessionData["user"]["user_id"]);
            
            $this->db->update('hrsys_candidate', $candidate,array('candidate_id'=>$candidate_id));
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
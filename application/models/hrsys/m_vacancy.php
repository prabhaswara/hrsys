<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_vacancy extends Main_Model {

   

    function __construct() {
        parent::__construct();
    }
    
    function listOpenVacancy($emp_id,$user_id,$selectAll){
        
        $dataReturn=array();
        if($selectAll){
            $dataReturn=$this->db
                    ->where("status","1")
                    ->order_by("name")
                    ->get("hrsys_vacancy")->row_array();
        }else{
            $sql="select v.* from hrsys_vacancy v left join "
                ."hrsys_vacancyuser vc on vc.vacancy_id=v.vacancy_id and vc.user_id='$user_id' "
                ."where v.account_manager='$emp_id' or vc.user_id is not null ";
            $dataReturn = $this->db->query($sql)->result_array();
        }       
      
        return $dataReturn;
    }
    
    function get($id){
        return $this->db->where("vacancy_id",$id)->get("hrsys_vacancy")->row_array();
    }
    
    function getVCIdName($vacancy_id){
        $sql="select c.candidate_id id,c.name text from hrsys_vacancycandidate vc ".
             "join hrsys_candidate c on vc.candidate_id=c.candidate_id where vc.vacancy_id='$vacancy_id' order by c.name asc";
        return $this->db->query($sql)->result_array();
    }
    
    function getVacancyCandidate($vacancy_id,$candidate_id){
        return $this->db->where(array("vacancy_id"=>$vacancy_id,"candidate_id"=>$candidate_id))->get("hrsys_vacancycandidate")->row_array();
    }
    
    function getHeaderTrail($vacancycandidate){
        $sql="select lk.display_text as state, from hrsys_vacancy_trl trl join tpl_lookup lk on trl.applicant_stat_id=lk.value and lk.type='applicant_stat' " ;
        return $this->db->query($sql)->result_array();
        
    }
    
    function getDetails($id){
        $dataReturn=array();
        
        $sql="select vc.*,emp.fullname emp_am, lk.display_text status_text,lksex.display_text sex_text from hrsys_vacancy vc  ".
             "left join tpl_lookup lk on lk.type='vacancy_stat' and vc.status=lk.value ".
             "left join tpl_lookup lksex on lksex.type='sex' and vc.sex=lksex.value ".
             "left join hrsys_employee emp on vc.account_manager=emp.emp_id ".
             "where vc.vacancy_id='$id'";
        
        //$vacancy= $this->db->query($sql)->row_array();
        
       // $dataReturn["vacancy"]= $vacancy;
  
        
        return $this->db->query($sql)->row_array();
        
    }
    
    
    public function saveOrUpdate($data, $sessionData) {
        
        $vacancy=$data["vacancy"];
        $shareMaintance=$data["shareMaintance"]; 
        $expertise=$data["expertise"]; 
        
        $userInsert = (isset($sessionData["employee"]["fullname"]) && !empty($sessionData["employee"]["fullname"])) ? $sessionData["employee"]["fullname"] :
        $sessionData["user"]["username"];
        
        $vacancy_id = $vacancy["vacancy_id"];    
        $this->db->trans_start(TRUE);

        if($vacancy["opendate"]!=""){
            $vacancy["opendate"]=  balikTgl($vacancy["opendate"]);
        }
       
        if($vacancy_id==""){
            // insert vacancy
            $vacancy_id=$this->uniqID();
            $vacancy["vacancy_id"]=$vacancy_id;
            $vacancy["status"]="1";
            $this->db->set('dateupdate', 'NOW()', FALSE);
            $this->db->set('userupdate', $sessionData["user"]["user_id"]);
            $this->db->set('datecreate', 'NOW()', FALSE);
            $this->db->set('usercreate', $sessionData["user"]["user_id"]);
            $this->db->insert('hrsys_vacancy', $vacancy);                
            
            
            // insert trail
            $dataTrl["cmpyclient_trl_id"] = $this->uniqID();
            $dataTrl["cmpyclient_id"] = $vacancy["cmpyclient_id"];
            $dataTrl["description"] = "Created Vacancy ".$vacancy["name"];
            $dataTrl["type"] = "vacancy";
            $dataTrl["value"] = $vacancy_id;
            
            $this->db->set('datecreate', 'NOW()', FALSE);
            $this->db->set('usercreate', $sessionData["user"]["user_id"]);
            $this->db->insert('hrsys_cmpyclient_trl', $dataTrl);
                    
        }else{
             // update vacancy   
            $this->db->set('dateupdate', 'NOW()', FALSE);
            $this->db->set('userupdate', $sessionData["user"]["user_id"]);
            $this->db->update('hrsys_vacancy', $vacancy, array('vacancy_id' => $vacancy_id));
           
           
            // update trail        
            $dataTrl["description"] = $userInsert." Create Vacancy ".$vacancy["name"];
            $this->db->update('hrsys_cmpyclient_trl', $dataTrl, array('value' => $vacancy_id,'type'=>'vacancy'));       
             
        }
        
        $this->db->delete( 'hrsys_vacancyuser', array( 'vacancy_id' => $vacancy_id ) );        
        $this->db->insert('hrsys_vacancyuser', array( 'vacancy_id' => $vacancy_id,'user_id'=>$sessionData["user"]["user_id"] )); 
        if(!empty($shareMaintance)){
            foreach ($shareMaintance as $row){
                $this->db->insert('hrsys_vacancyuser', array( 'vacancy_id' => $vacancy_id,'user_id'=>$row["user_id"] )); 
            }            
        }     
        $this->db->delete( 'hrsys_vacancy_skill', array( 'vacancy_id' => $vacancy_id ) );
        if(!empty($expertise)){
            foreach ($expertise as $row){
                $this->db->insert('hrsys_vacancy_skill', array( 'vacancy_id' => $vacancy_id,'skill'=>$row["skill"])); 
            }            
        }     
        
        $this->db->trans_complete();

        return $this->db->trans_status();
    }
    
    
    public function validate($datafrm, $isEdit) {
        $return = array(
            'status' => true,
            'message' => array()
        );

        if (!empty($datafrm)) {

            if (cleanstr($datafrm["opendate"]) == "") {
                $return["status"] = false;
                $return["message"]["opendate"] = "Open Date cannot be empty";
            }
            if (cleanstr($datafrm["name"]) == "") {
                $return["status"] = false;
                $return["message"]["name"] = "Job Name cannot be empty";
            }
            if (cleanstr($datafrm["account_manager"]) == "") {
                $return["status"] = false;
                $return["message"]["account_manager"] = "PIC cannot be empty";
            }
            
        }

        return $return;
    }
    
}

?>
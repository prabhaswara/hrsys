<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_vacancy extends Main_Model {

   

    function __construct() {
        parent::__construct();
    }
    
    function get($id){
        return $this->db->where("vacancy_id",$id)->get("hrsys_vacancy")->row_array();
    }
    
    function getDetails($id){
        $dataReturn=array();
        
        $sql="select vc.*,emp.fullname emp_pic, lk.display_text status_text from hrsys_vacancy vc  ".
             "left join tpl_lookup lk on lk.type='vacancy_stat' and vc.status=lk.value ".
             "left join hrsys_employee emp on vc.pic=emp.emp_id ".
             "where vc.vacancy_id='$id'";
        $vacancy= $this->db->query($sql)->row_array();
        
        $dataReturn["vacancy"]= $vacancy;
  
        
        return $dataReturn;
        
    }
    
    
    public function saveOrUpdate($data, $sessionData) {
        
        $vacancy=$data["vacancy"];
        $shareMaintance=$data["shareMaintance"]; 
        
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
            $dataTrl["cmpyvcient_trl_id"] = $this->uniqID();
            $dataTrl["cmpyvcient_id"] = $vacancy["cmpyvcient_id"];
            $dataTrl["description"] = $userInsert." Create Vacancy ".$vacancy["name"];
            $dataTrl["type"] = "vacancy";
            $dataTrl["value"] = $vacancy_id;
            
            $this->db->set('datecreate', 'NOW()', FALSE);
            $this->db->set('usercreate', $sessionData["user"]["user_id"]);
            $this->db->insert('hrsys_cmpyvcient_trl', $dataTrl);
                    
        }else{
             // update vacancy   
            $this->db->set('dateupdate', 'NOW()', FALSE);
            $this->db->set('userupdate', $sessionData["user"]["user_id"]);
            $this->db->update('hrsys_vacancy', $vacancy, array('vacancy_id' => $vacancy_id));
           
           
            // update trail        
            $dataTrl["description"] = $userInsert." Create Vacancy ".$vacancy["name"];
            $this->db->update('hrsys_cmpyvcient_trl', $dataTrl, array('value' => $vacancy_id,'type'=>'vacancy'));       
             
        }
        
        $this->db->delete( 'hrsys_vacancyuser', array( 'vacancy_id' => $vacancy_id ) );
        
        $this->db->insert('hrsys_vacancyuser', array( 'vacancy_id' => $vacancy_id,'user_id'=>$sessionData["user"]["user_id"] )); 
        if(!empty($shareMaintance)){
            foreach ($shareMaintance as $row){
                $this->db->insert('hrsys_vacancyuser', array( 'vacancy_id' => $vacancy_id,'user_id'=>$row["user_id"] )); 
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

            if (vceanstr($datafrm["opendate"]) == "") {
                $return["status"] = false;
                $return["message"]["opendate"] = "Open Date cannot be empty";
            }
            if (vceanstr($datafrm["name"]) == "") {
                $return["status"] = false;
                $return["message"]["name"] = "Job Name cannot be empty";
            }
            if (vceanstr($datafrm["pic"]) == "") {
                $return["status"] = false;
                $return["message"]["pic"] = "PIC cannot be empty";
            }
            
        }

        return $return;
    }
    
}

?>
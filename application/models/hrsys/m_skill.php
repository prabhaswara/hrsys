<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_skill extends Main_Model {

    var $skill_id;

    function __construct() {
        parent::__construct();
    }

   function searchSkill($search){
        return $this->db->like("skill",$search)->get("hrsys_skill")->result_array();
    }
    
    function expertise($skill_id_list){
        $dataReturn = array();
        $this->db->select("skill_id,skill");
        $this->db->where_in("skill_id",$skill_id_list);
        $this->db->order_by("skill");
        $dataSkill =$this->db->get("hrsys_skill")->result_array();
        //echo $this->db->last_query();
        return $dataSkill;
    }
    function getExpertiseVacancy($vacancy_id){
       $sql="select s.* from hrsys_vacancy_skill vs ".
             "join hrsys_skill s on vs.skill_id=s.skill_id ".            
             "where vs.vacancy_id='$vacancy_id' "
            ;
        $dataResult=$this->db->query($sql)->result_array();
        return $dataResult;
    }
    public function addSkill($skill) {
        $datafrm=$this->db->where("skill",$skill)->get("hrsys_skill")->row_array();
        
        if(empty($datafrm)){
            $datafrm=$this->db->where("skill_id",$skill)->get("hrsys_skill")->row_array();
            if(empty($datafrm)){
                $datafrm["skill_id"] = $this->generateID("skill_id", "hrsys_skill");
                $datafrm["skill"] = $skill;
                $this->db->insert('hrsys_skill', $datafrm);
            }           
        }        

        return $datafrm;
    }

}

?>
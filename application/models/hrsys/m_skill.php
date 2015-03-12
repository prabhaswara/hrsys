<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_skill extends Main_Model {

    function __construct() {
        parent::__construct();
    }

    function searchSkill($search,$limit=10) {
        return $this->db->like("skill", $search)->limit($limit)->get("hrsys_skill")->result_array();
    }

    function getExpertiseVacancy($vacancy_id) {
        return $this->db->where("vacancy_id", $vacancy_id)->get("hrsys_vacancy_skill")->result_array();
    }
function expertise($skill_list){
        $dataReturn = array();
        foreach($skill_list as $skill){
            $dataReturn[]=array("skill"=>$skill);
        }
        return $dataReturn;
    }
    
    public function addSkill($skill) {
        $skill=  cleanstr($skill);
        $datafrm = $this->db->where("skill", $skill)->get("hrsys_skill")->row_array();

        if (empty($datafrm)) {
            $datafrm["skill"] = $skill;
            $this->db->insert('hrsys_skill', $datafrm);
        }

        return $datafrm;
    }

}

?>
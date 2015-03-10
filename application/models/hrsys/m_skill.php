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
    public function addSkill($skill) {
        $datafrm=array();
        $datafrm["skill_id"] = $this->generateID("skill_id", "hrsys_skill");
        $datafrm["skill"] = $skill;
        
        $this->db->insert('hrsys_cmpyclient', $datafrm);

        return $datafrm;
    }

}

?>
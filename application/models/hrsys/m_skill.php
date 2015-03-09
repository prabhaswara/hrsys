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

}

?>
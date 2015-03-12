<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of skill
 *
 * @author prabhaswara
 */
class skill extends Main_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('hrsys/m_skill', 'admin/m_lookup'));
    }
    
    public function searchSkill(){
                
        $name="";
        if(isset($_GET["filter"]["filters"][0]["value"])){
            $name=$_GET["filter"]["filters"][0]["value"];       
        }
        
        $data=$this->m_skill->searchSkill($name);
        header("Content-Type: application/json;charset=utf-8");
        echo json_encode($data);
    }
    
    public function addSkill(){
        $data=$this->m_skill->addSkill($_POST["skill_name"]);
        header("Content-Type: application/json;charset=utf-8");
        echo json_encode($data);
    }
}

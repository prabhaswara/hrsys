<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @author prabhaswara
 */
class employee extends Main_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('hrsys/m_employee', 'admin/m_lookup'));
    }
    
    public function sharewith(){
        
        
        $name="";
        if(isset($_GET["filter"]["filters"][0]["value"])){
            $name=$_GET["filter"]["filters"][0]["value"];
       
        }
        
        $data=$this->m_employee->sharewith($name);
        header("Content-Type: application/json;charset=utf-8");
        echo json_encode($data);
    }
    
}

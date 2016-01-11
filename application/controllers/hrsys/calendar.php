<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @author prabhaswara
 */
class calendar extends Main_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array( 'admin/m_lookup',"hrsys/m_schedule"));
    }
    
    public function index(){
        $this->user_id;
        
        $dataParse = array(  
                );
        $this->loadContent('hrsys/calendar/calendar', $dataParse);
    }
    
   public function showDetail($id){
       $cal=$this->m_schedule->get($id);
       
       if(!empty($cal)){
           switch ($cal["type"]) {
            case "meeting":
                redirect("hrsys/meeting/showDetail/".$cal["value"]."?gridReload=calendar");
            break;
           }
       }
       return "";
   }
   public function json_event(){
       header("Content-Type: application/json;charset=utf-8");
       
       $print=array();
       $result=$this->m_schedule->getByRange($_GET["start"],$_GET["end"],$this->user_id);
       if(!empty($result))
       foreach($result as $row){
           $print[]=array(
               "id"=>$row["schedule_id"],
               "start"=>$row["scheduletime"],
               "title"=>$row["description"],
               
           );
       }
        echo json_encode($print);
   }
  
}

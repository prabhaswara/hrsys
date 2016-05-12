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
			case "interview":
			
				redirect("hrsys/vacancy/detailTrail/".$cal["value"]."");
			break;
           }
       }
       return "";
   }
   
    public function json_nextschedule($user_id,$type){
        if (!isset($_POST["sort"])){            
                 $_POST["sort"][0]['direction'] ='asc';
                 $_POST["sort"][0]['field'] ='sche.scheduletime';      
            }
            
         $sql = "select sche.schedule_id recid,sche.description,CONCAT(DAYNAME(sche.scheduletime),CONCAT(', ', DATE_FORMAT(sche.scheduletime,'%d-%m-%Y %H:%i'))) scheduletime ".
                "from hrsys_schedule sche ".
                "join hrsys_scheduleuser schuser on sche.schedule_id=schuser.schedule_id ".
                "WHERE schuser.user_id='$user_id' and type='$type' and sche.scheduletime>=CURDATE() ".
				"and ~search~ ORDER BY ~sort~";
	
            $data = $this->m_menu->w2grid($sql, $_POST);           
            header("Content-Type: application/json;charset=utf-8");
            echo json_encode($data);
            exit();
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

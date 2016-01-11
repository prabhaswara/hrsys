<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_schedule extends Main_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get($id){
        return $this->db->where("schedule_id",$id)->get("hrsys_schedule")->row_array();
    }
	
	function getByType($type,$value)
	{
		return $this->db->where(array("type"=>$type,"value"=>$value))->get("hrsys_schedule")->row_array();
    }
	
    
    function getByRange($start,$end,$user_id)
    {
        $start=$start." 00:00";
        $end=$end." 23:59";
        $return =$this->db->select("s.*")
                ->where("s.scheduletime > '$start' and s.scheduletime < '$end' ", null, false)
                ->from("hrsys_schedule as s")
                ->join('hrsys_scheduleuser as su', 's.schedule_id=su.schedule_id')
                ->where('su.user_id',$user_id)
                ->get()->result_array();              
      
       
        return $return;  
    }
    
    
}
?>

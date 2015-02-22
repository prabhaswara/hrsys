<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_Employee extends Main_Model {

    function __construct() {
        parent::__construct();
    }
    
    
    function get($id){
        return $this->db->where("employee_id",$id)->get("hrsys_employee")->row_array();
    }
    function getByUserId($user_id){
        $return =$this->db->where("user_id",$user_id)->get("hrsys_employee")->row_array();
      
        return $return;
    }
    function isiComboPIC($id){
        
        $dataDB= $this->db->where("emp_id",$id)->get("hrsys_employee")->row();
        if(!empty($dataDB)){
            $dataReturn[$dataDB->emp_id] = $dataDB->fullname . " (" . $dataDB->emp_id . ")";
            
        }
        return $dataReturn;
    }
    function comboPIC() {

        $dataReturn = array();
        $dataEmployee = $this->db->select("emp_id,fullname")->order_by("fullname")->get("hrsys_employee")->result();


        if (!empty($dataEmployee)) {
            foreach ($dataEmployee as $emp) {

                $dataReturn[$emp->emp_id] = $emp->fullname . " (" . $emp->emp_id . ")";
            }
        }

        return $dataReturn;
    }
    
    function sharewith($where,$user_login) {

        $dataReturn = array();
        $this->db->select("emp_id,fullname,user_id")
                ->where("(user_id IS NOT NULL or user_id!='') and user_id != '$user_login'", null, false) ;               
                

        if(is_array($where)){
            $this->db->where_in('user_id',$where);            
        }else{
            $this->db->like('fullname', $where, 'after');
        }
        $this->db->order_by("fullname");
        $dataEmployee =$this->db->get("hrsys_employee")->result();
        //echo $this->db->last_query();exit;
        if (!empty($dataEmployee)) {
            foreach ($dataEmployee as $emp) {
                
                $dataReturn[]=array(
                    "user_id"=>$emp->user_id,
                    "name"=>$emp->fullname . " (" . $emp->emp_id . ")"
                );
                
            }
        }

        return $dataReturn;
    }
    function pic($name) {

        $dataReturn = array();
        $this->db->select("emp_id,fullname,user_id");      
        $this->db->like('fullname', $name, 'after');
        
        $this->db->order_by("fullname");
        $dataEmployee =$this->db->get("hrsys_employee")->result();
        //echo $this->db->last_query();exit;
        if (!empty($dataEmployee)) {
            foreach ($dataEmployee as $emp) {
                
                $dataReturn[]=array(
                    "emp_id"=>$emp->emp_id,
                    "name"=>$emp->fullname . " (" . $emp->emp_id . ")"
                );
                
            }
        }

        return $dataReturn;
    }
    
    public function shareWithByMeet($meet_id,$user_login){
        $sql="select emp.user_id,emp.emp_id,emp.fullname from hrsys_cmpyclient_meet meet ".
             "join hrsys_schedule sch on meet.meet_id=sch.value and sch.type='meeting' ".
             "join hrsys_scheduleuser schuser on sch.schedule_id= schuser.schedule_id ".
             "join hrsys_employee emp on schuser.user_id=emp.user_id ". 
             "where meet.meet_id='$meet_id' and (emp.user_id IS NOT NULL or emp.user_id!='') and emp.user_id != '$user_login'"
            ;
        $dataReturn=array();
        $dataResult=$this->db->query($sql)->result();
        if (!empty($dataResult)) {
            foreach ($dataResult as $emp) {
                
                $dataReturn[]=array(
                    "user_id"=>$emp->user_id,
                    "name"=>$emp->fullname . " (" . $emp->emp_id . ")"
                );
                
            }
        }
        return $dataReturn;
    }
    
}

?>
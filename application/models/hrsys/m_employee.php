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
    
    
}

?>
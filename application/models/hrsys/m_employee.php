<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_Employee extends Main_Model {

    function __construct() {
        parent::__construct();
    }
    
    function getById($id){	
        return $this->db->where("id",$id)->get("hrsys_employee")->row_array();
    }
    function getByEmpId($id,$consultant_code){	
        return $this->db->where(array("employee_code"=>$id,"consultant_code"=>$consultant_code))->get("hrsys_employee")->row_array();
    }
    function getByUserId($user_id){
        $return =$this->db->where("user_id",$user_id)->get("hrsys_employee")->row_array();
      
        return $return;
    }
    function isiComboAM($id){
        
        $dataDB= $this->db->where("id",$id)->get("hrsys_employee")->row();
        if(!empty($dataDB)){
            $dataReturn[$dataDB->id] = $dataDB->fullname . " (" . $dataDB->employee_code . ")";
            
        }
        return $dataReturn;
    }
    function comboAM() {
        
        $dataReturn = array();
        $dataEmployee = $this->db->select("employee_code,fullname")->order_by("fullname")
                ->where("active_non",1)
                ->get("hrsys_employee")
                ->result();


        if (!empty($dataEmployee)) {
            foreach ($dataEmployee as $emp) {

                $dataReturn[$emp->employee_code] = $emp->fullname . " (" . $emp->employee_code . ")";
            }
        }

        return $dataReturn;
    }
    
    function sharewith($where,$user_login,$active=null) {
		
		$user=$this->getByUserId($user_login);
		
        $dataReturn = array();
        $this->db->select("employee_code,fullname,user_id")
                ->where("(user_id IS NOT NULL or user_id!='') and user_id != '$user_login' and consultant_code='".$user['consultant_code']."'", null, false) ;               
           
        if($active!=null){
  
            $this->db->where('active_non',1); 
        }

        if(is_array($where)){
            $this->db->where_in('user_id',$where);            
        }else{
            $this->db->like('fullname', $where, 'after');
        }
        $this->db->order_by("fullname");
        $dataEmployee =$this->db->get("hrsys_employee")->result();
        
        if (!empty($dataEmployee)) {
            foreach ($dataEmployee as $emp) {
                
                $dataReturn[]=array(
                    "user_id"=>$emp->user_id,
                    "name"=>$emp->fullname . " (" . $emp->employee_code . ")"
                );
                
            }
        }

        return $dataReturn;
    }
    function account_manager($name,$consultant_code) {

        $dataReturn = array();
        $this->db->select("id,employee_code,fullname,user_id");      
        $this->db->like('fullname', $name, 'after');
        $this->db->where('consultant_code',$consultant_code);
        $this->db->order_by("fullname");
        $dataEmployee =$this->db->get("hrsys_employee")->result();
        //echo $this->db->last_query();exit;
        if (!empty($dataEmployee)) {
            foreach ($dataEmployee as $emp) {
                
                $dataReturn[]=array(
					"id"=>$emp->id,
                    "employee_code"=>$emp->employee_code,
                    "name"=>$emp->fullname . " (" . $emp->employee_code . ")"
                );
                
            }
        }

        return $dataReturn;
    }
    
    public function shareWithByMeet($meet_id,$user_login){
	
	
		$user=$this->getByUserId($user_login);
	
           
        $sql="select emp.user_id,emp.employee_code,emp.fullname from hrsys_cmpyclient_meet meet ".
             "join hrsys_schedule sch on meet.meet_id=sch.value and sch.type='meeting' ".
             "join hrsys_scheduleuser schuser on sch.schedule_id= schuser.schedule_id ".
             "join hrsys_employee emp on schuser.user_id=emp.user_id ". 
             "where meet.meet_id='$meet_id' and (emp.user_id IS NOT NULL or emp.user_id!='') and emp.user_id != '$user_login' ".
			 "and emp.consultant_code='".$user['consultant_code']."'"
            ;
        $dataReturn=array();
        $dataResult=$this->db->query($sql)->result();
        if (!empty($dataResult)) {
            foreach ($dataResult as $emp) {
                
                $dataReturn[]=array(
                    "user_id"=>$emp->user_id,
                    "name"=>$emp->fullname . " (" . $emp->employee_code . ")"
                );
                
            }
        }
        return $dataReturn;
    }
    public function maintainceByVacancy($vacancy_id,$userCreate){
        $sql="select emp.user_id,emp.employee_code,emp.fullname from hrsys_vacancyuser vu ".
             "join hrsys_employee emp on vu.user_id =emp.user_id ".
             "where vu.vacancy_id='$vacancy_id' and emp.user_id!='$userCreate'";
                
        $dataReturn=array();
        $dataResult=$this->db->query($sql)->result();
        if (!empty($dataResult)) {
            foreach ($dataResult as $emp) {
                
                $dataReturn[]=array(
                    "user_id"=>$emp->user_id,
                    "name"=>$emp->fullname . " (" . $emp->employee_code . ")"
                );
                
            }
        }
        return $dataReturn;
    }
    
    public function shareVacantById($vacancy_id,$user_login,$idOnly=false){
        $sql="select emp.user_id,emp.employee_code,emp.fullname from hrsys_vacancyuser vu ".
             "join hrsys_employee emp on vu.user_id=emp.user_id ". 
             "where vu.vacancy_id='$vacancy_id' and (emp.user_id IS NOT NULL or emp.user_id!='') and emp.user_id != '$user_login'"
            ;
        $dataReturn=array();
        $dataResult=$this->db->query($sql)->result();
        if (!empty($dataResult)) {
            foreach ($dataResult as $emp) {
                
                $dataReturn[]=array(
                    "user_id"=>$emp->user_id,
                    "name"=>$emp->fullname . " (" . $emp->employee_code . ")"
                );
                
            }
        }
		if($idOnly){
			$dataTemp=$dataReturn;
			$dataReturn=array();
			if (!empty($dataReturn)) {
				foreach ($dataReturn as $temp) {
					$dataReturn[]=$dataReturn["user_id"];
				}
			}
		}
        return $dataReturn;
    }
	
	public function validate($user_id,$datafrm,$isEdit=false) {
        $return = array(
            'status' => true,
            'message' => array()
        );

        if (!empty($datafrm)) {
			$empoyeeExist=$this->getByEmpId($datafrm["employee_code"],$datafrm["consultant_code"]);
			$empByUser=$this->getByUserId($user_id);
			
			if ($datafrm["employee_code"] == "") {
				$return["status"] = false;
				$return["message"]["employee_code"] = "Employee Number cannot be empty";
			}
			else if($isEdit && !empty ($empoyeeExist) && $empoyeeExist["employee_code"]!=$empByUser["employee_code"])
			{
				$return["status"] = false;
                $return["message"]["username"] = "Employee Number is not available";
			}
			else if(!$isEdit && !empty ($empoyeeExist)){              
                $return["message"]["username"] = "Employee Number is not available";
                $return["status"] = false;
               
			}
			if ($datafrm["fullname"] == "") {
				$return["status"] = false;
				$return["message"]["fullname"] = "Employee Name cannot be empty";
			}
						
			
            
                      
           
        }

        return $return;
    }
    
}


?>
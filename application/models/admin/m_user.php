<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_user extends Main_Model {

    var $error_message="";
    
    
    function __construct() {
        parent::__construct();
    }
    function get($id){
        return $this->db->where("user_id",$id)->get("tpl_user")->row_array();
    }
    
    function getRoleUser($id){
        $roles= $this->db->select("role_id")->where("user_id",$id)->get("tpl_user_role")->result_array();
    
        $return=array();
        if(!empty($roles))
        foreach($roles as $role){
            $return[]=$role["role_id"];
        }
        return $return;
        
    }
    
    function getByUsername($username){
        return $this->db->where("username",$username)->get("tpl_user")->row_array();
    }
    
	function setLastLogin($user_id){
	
		$this->db->set('last_login', 'NOW()', FALSE);  
		$this->db->update('tpl_user', array(),array('user_id' => $user_id));
	
	}
    
    function getDataLogin($username,$password){
        
        $dataReturn=array();
        $password=  $this->encrypt($password);
        $dataUser= $this->db->where(array("username"=>$username,"password"=>$password))->get("tpl_user")->row_array();
        
        if(!empty($dataUser)){
            
            unset($dataUser["password"]);
            $dataEmployee=$this->db->where("user_id",$dataUser['user_id'])->get("hrsys_employee")->row_array();
            $dataConsultant=$this->db->where("consultant_code",$dataEmployee['consultant_code'])->get("hrsys_consultant")->row_array();
            
            $dataRole=$this->getRoleUser($dataUser['user_id']);
            $dataReturn["user"]=$dataUser;
            $dataReturn["roles"]=$dataRole;
            $dataReturn["employee"]=$dataEmployee;
			$dataReturn["employee"]["consultant_name"]=(empty($dataConsultant)?"":$dataConsultant["name"]);
			
        }
        
        return $dataReturn;    
        
        
    }
    
	
    
    public function saveOrUpdate($dataSave,$user) {
        
               
        $dataUser=$dataSave["user"];
        $user_id = $dataUser["user_id"];
        unset($dataUser["user_id"]);
        
		
		$this->db->trans_start(TRUE);
        $this->db->set('dateupdate', 'NOW()', FALSE); 
        
        
        if ($user_id == "") {    
            $user_id=$this->uniqID();
            $dataUser["user_id"]=$user_id;
            $dataUser["password"]=$this->encrypt($dataUser["password"]);
            $this->db->set('datecreate', 'NOW()', FALSE);  
            $this->db->set('usercreate',$user);
            $this->db->insert('tpl_user', $dataUser);
        } else {      
            
            
            if(cleanstr($dataUser["password"])==""){
                unset($dataUser["password"]);
            }else{
              
                $dataUser["password"]=$this->encrypt($dataUser["password"]);
            }
            $this->db->set('userupdate',$user);
            $this->db->update('tpl_user', $dataUser, array('user_id' => $user_id));
        }
         
        $this->db->delete( 'tpl_user_role', array( 'user_id' => $user_id ) );
        
        if(!empty($dataSave["role"]))
        foreach($dataSave["role"] as $role){
            $this->db->insert('tpl_user_role', array("user_id"=>$user_id,"role_id"=>$role));
        }
        if(!empty($dataSave["employee"]) && $dataSave["employee"]["consultant_code"]!="" )
		{
			$dataSave["employee"]["id"]=$user_id;
			$dataSave["employee"]["user_id"]=$user_id;			
			$dataSave["employee"]["active_non"]=$dataUser["active_non"];
			$employee= $this->db->where("user_id",$user_id)->get("hrsys_employee")->result_array();
			if(empty($employee))
			{
				$this->db->insert('hrsys_employee', $dataSave["employee"]);
			}else
			{
				$this->db->update('hrsys_employee', $dataSave["employee"], array('user_id' => $user_id));
			}
			
		}
		
        
        $this->db->trans_complete(); 
       
        return $this->db->trans_status();
    }
    
    public function delete($selected){
        foreach($selected as $id){
            $this->db->trans_start(TRUE);
            $this->db->delete( 'hrsys_employee', array( 'user_id' => $id ) );
			 $this->db->delete( 'tpl_user_role', array( 'user_id' => $id ) );
            $this->db->delete( 'tpl_user', array( 'user_id' => $id ) );
            $this->db->trans_complete(); 
        }
    }
    public function changePwd($dataSave)
	{
		$this->db->set('dateupdate', 'NOW()', FALSE);  
        $this->db->set('userupdate',$dataSave["user_id"]);
		$newPwd=$this->encrypt($dataSave["newPassword"]);
		$this->db->update('tpl_user', array('password'=>$newPwd),
		array('user_id' => $dataSave["user_id"]));
		
	}
    public function validateChangePwd($datafrm)
	{
		$return = array(
            'status' => true,
            'message' => array()
        );
		$user=$this->get($datafrm["user_id"]);
	
		if(cleanstr($datafrm["oldPassword"])=="")
		{
			$return["status"] = false;
            $return["message"]["username"] = "OldPassword cannot be empty";
		}else if($this->encrypt($datafrm["oldPassword"])!=$user["password"])
		{
			$return["status"] = false;
            $return["message"]["username"] = "OldPassword is not match";
		}
		
		if(cleanstr($datafrm["newPassword"])=="")
		{
			$return["status"] = false;
            $return["message"]["newPassword"] = "New Password cannot be empty";
		}else if(cleanstr($datafrm["repeatNewPassword"])=="")
		{
			$return["status"] = false;
            $return["message"]["repeatNewPassword"] = "Repeat New Password cannot be empty";
		}
		
		if ($datafrm["newPassword"]!=$datafrm["repeatNewPassword"]) {
            $return["status"] = false;
            $return["message"]["repeatNewPassword"] = "Password And Repeat Password not match";
        }
			
		
		return $return;
	}

    public function validate($datafrm,$isEdit=false) {
        $return = array(
            'status' => true,
            'message' => array()
        );

        if (!empty($datafrm)) {

            $userExist=$this->getByUsername($datafrm["username"]);
             if (cleanstr($datafrm["username"]) == "") {
                $return["status"] = false;
                $return["message"]["username"] = "Username cannot be empty";
            }
            
            
            
            if(!$isEdit){                
                if(!empty ($userExist)){
                    $return["status"] = false;
                    $return["message"]["username"] = "Username is not available";
                }

                if ($datafrm["password_1"] == "") {
                $return["status"] = false;
                $return["message"]["password_1"] = "Password cannot be empty";
                }
                if ($datafrm["password_2"] == "") {
                    $return["status"] = false;
                    $return["message"]["password_2"] = "Repeat Password cannot be empty";
                }
            }
           
            if ($datafrm["password_1"]!=$datafrm["password_2"]) {
                $return["status"] = false;
                $return["message"]["password_2"] = "Password And Repeat Password not match";
            }
           
           
        }

        return $return;
    }
    
    function set_error_message($string){
        $this->error_message=$string;
    }
    function get_error_message(){
        return $this->error_message;
    }

}

?>
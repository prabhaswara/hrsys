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
    
    
    function getDataLogin($username,$password){
        
        $dataReturn=array();
        $password=  $this->encrypt($password);
        $dataUser= $this->db->where(array("username"=>$username,"password"=>$password))->get("tpl_user")->row_array();
        
        if(!empty($dataUser)){
            
            unset($dataUser["password"]);
            $dataEmployee=$this->db->where("user_id",$dataUser['user_id'])->get("hrsys_employee")->row_array();
            
            $dataRole=$this->getRoleUser($dataUser['user_id']);
            $dataReturn["user"]=$dataUser;
            $dataReturn["roles"]=$dataRole;
            $dataReturn["employee"]=$dataEmployee;
        }
        
        return $dataReturn;    
        
        
    }
    
    
    public function saveOrUpdate($dataSave,$user) {
        $this->db->trans_start(TRUE);
               
        $dataUser=$dataSave["user"];
        $user_id = $dataUser["user_id"];
        unset($dataUser["user_id"]);
        
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
        
        $this->db->trans_complete(); 
       
        return $this->db->trans_status();
    }
    
    public function delete($selected){
        foreach($selected as $id){
            $this->db->trans_start(TRUE);
            $this->db->delete( 'tpl_user_role', array( 'user_id' => $id ) );
            $this->db->delete( 'tpl_user', array( 'user_id' => $id ) );
            $this->db->trans_complete(); 
        }
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
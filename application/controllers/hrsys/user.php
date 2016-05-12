<?php

class User extends Main_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('admin/m_user','admin/m_lookup','admin/m_role','hrsys/m_employee'));
    }
    
	public function showForm($id=0) {     
        
        $message="";
        $session_message=$this->session->userdata(SES_MSG);
        if($session_message!=null){
            $this->session->unset_userdata(SES_MSG);
            
            $message=  showMessage($session_message[0],$session_message[1]);
        }
        
        $postUser=isset($_POST['frm'])?$_POST['frm']:array();
        $postUserRole=isset($_POST['role'])?$_POST['role']:array();
		$postEmployee=isset($_POST['employee'])?$_POST['employee']:array();
		
        $create_edit="Edit";
        $isEdit=true;
        if($id==0){
             $create_edit="Create";
                $isEdit=false;
        }
        
        
        if(!empty($postUser)){
			$postEmployee["consultant_code"]=$this->sessionUserData["employee"]["consultant_code"];
            $validate=$this->m_user->validate($postUser,$isEdit);
			$validateEmployee=$this->m_employee->validate($id,$postEmployee,$isEdit);
			
            if($validate["status"]&&$validateEmployee["status"]){
                $dataSave["user"]=$postUser;
                $dataSave["user"]["password"]=$postUser["password_1"];
                unset($dataSave["user"]["password_1"]);
                unset($dataSave["user"]["password_2"]);              
                
                $dataSave["role"]=$postUserRole;
				$dataSave["employee"]=$postEmployee;
				
               $result=$this->m_user->saveOrUpdate($dataSave,$this->user_id);
               
               if($result){
                   $this->session->set_userdata(SES_MSG,array("Data Saved","success"));
                   redirect("hrsys/user/showForm");
               }
               
            }
            $error_message= array_merge($validate["message"], $validateEmployee["message"]);
            if(!empty($error_message)){
                $message=  showMessage($error_message);
            }
            
        }elseif($id!="0"&& empty($postUser)){
            $this->load->model('hrsys/m_employee');
            $postUser=$this->m_user->get($id);
            $postUserRole=$this->m_user->getRoleUser($id);
			$postEmployee=$this->m_employee->getById($id);        
        }
        $activeNonList=$this->m_lookup->comboLookup("active_non");
        $dataParse=array(
            'create_edit'=>$create_edit,
            'activeNonList'=>$activeNonList,
            'postUser'=>$postUser,
			'postEmployee'=>$postEmployee,
            'postUserRole'=>$postUserRole,
            'roles'=>$this->m_role->roleHrsys(),
            'message'=>$message,
            'base_url'=>  base_url(),
            'site_url'=> site_url()
            );
        $this->parser->parse('hrsys/user/form', $dataParse);
       
    }
    

    public function json_list() {
        if(isset($_POST["sort"])&& !empty($_POST["sort"]))
            foreach($_POST["sort"] as $key=>$value){
                $_POST["sort"][$key]=  str_replace("_sp_", ".", $value);
            }
        
        
        if(isset($_POST["search"])&& !empty($_POST["search"]))
        foreach($_POST["search"] as $key=>$value){
            $_POST["search"][$key]=  str_replace("_sp_", ".", $value);
        }
        
        $sql="SELECT 
			us.user_id us_sp_user_id,
			us.username us_sp_username,
			DATE_FORMAT(us.last_login,'%d-%m-%Y %i:%S') us_sp_last_login ,
			emp.fullname emp_sp_fullname,
			emp.employee_code emp_sp_employee_code,
			lk.display_text lk_sp_display_text,GROUP_CONCAT(rl.name SEPARATOR ', ')rl_sp_role_name 
			FROM tpl_user us 
			join hrsys_employee emp on us.user_id=emp.user_id
			left join tpl_lookup lk on lk.value=us.active_non and lk.type='active_non' 
			left join tpl_user_role  ur on us.user_id=ur.user_id 
			left join tpl_role rl on ur.role_id=rl.role_id  
			WHERE ~search~ and emp.consultant_code='".$this->sessionUserData["employee"]["consultant_code"]."' group by us.user_id ,us.username ,us.last_login  ,lk.display_text  ORDER BY ~sort~";
        
		$data = $this->m_menu->w2grid($sql,$_POST);
        header("Content-Type: application/json;charset=utf-8");
        echo json_encode($data);
    }

    public function index() {     
	
       $this->loadContent('hrsys/user/list');     
    }
	
    
}

?>
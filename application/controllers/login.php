<?php

class login extends CI_Controller {

    public function __construct() {
       parent::__construct();
       $this->load->model('admin/m_user');
       $this->load->helper('gn_frm','gn_str');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect("login");
    }
    
    public function chek(){
        $dt=$this->session->userdata(SES_USERDT);
        if(empty($dt)){
            echo 0;
        }
        else{
            echo 1;
        }
    }
    
    public function relogin(){
        $message="";
        if(!empty($_POST)){
            $dataRegister=$this->m_user->getDataLogin($_POST["username"],$_POST["password"]);
            
            if(empty($dataRegister)){
               echo 0;
            }
            else{
                $this->session->set_userdata(SES_USERDT,$dataRegister);
                echo 1;
            }
        }
        exit;
    }

    public function index() {
        
        if($this->session->userdata(SES_USERDT)!=null){
             redirect("site");
        }
        
        $message="";
        if(!empty($_POST)){
            $dataRegister=$this->m_user->getDataLogin($_POST["username"],$_POST["password"]);
           
            if(empty($dataRegister)){
               $message= showMessage("username or password not match");
            }
            else{
				 $this->m_user->setLastLogin($dataRegister["user"]["user_id"]);
                $this->session->set_userdata(SES_USERDT,$dataRegister);
                redirect("site");
            }
        }
        
        $dataParse['base_url'] = base_url();
        $dataParse['site_url'] = site_url();
        $dataParse['message'] = $message;
        
        
        $this->parser->parse('template/login', $dataParse);
    }
     
    
    
    
}

?>
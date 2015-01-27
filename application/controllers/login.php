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
    public function index() {
        
        if($this->session->userdata('userdata')!=null){
             redirect("home");
        }
        
        $message="";
        if(!empty($_POST)){
            $dataRegister=$this->m_user->getDataLogin($_POST["username"],$_POST["password"]);
            
            if(empty($dataRegister)){
               $message= showMessage("username or password not match");
            }
            else{
                $this->session->set_userdata("userdata",$dataRegister);
                redirect("home");
            }
        }
        
        $dataParse['base_url'] = base_url();
        $dataParse['site_url'] = site_url();
        $dataParse['message'] = $message;
        
        
        $this->parser->parse('template/login', $dataParse);
    }
     
    
    
    
}

?>
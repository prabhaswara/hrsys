<?php

class Consultant extends Main_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/m_consultant');
    }

    public function json_list() {
        $data = $this->m_consultant->w2grid("SELECT * FROM hrsys_consultant WHERE ~search~ ORDER BY ~sort~", $_POST);
        header("Content-Type: application/json;charset=utf-8");
        echo json_encode($data);
    }

    public function index() {
       
       
        $this->loadContent('admin/consultant/list');
     
    }
    public function showForm($code=0) {
        
        $postform=isset($_POST['frm'])?$_POST['frm']:array();
        $message="";
                    
       
        if(!empty($postform)){
            $validate=$this->m_consultant->validate($postform);
            if($validate["status"] && $this->m_consultant->saveOrUpdate($postform,$this->user_id)){
                echo "close_popup";exit;
            }
            $error_message= isset($validate["message"])?$validate["message"]:array();
            if(!empty($error_message)){
                $message=  showMessage($error_message);
            }
            
        }elseif($code!="0"&& empty($postform)){
            
            $postform=$this->m_consultant->get($code);
        
        }
        $dataParse=array(
            'post'=>$postform,
            'message'=>$message,
            'base_url'=>  base_url(),
            'site_url'=> site_url()
            );
        $this->parser->parse('admin/consultant/form', $dataParse);
       
    }
    
    
    public function delete() {
        if(isset($_POST["selected"]))
        $validate=$this->m_consultant->delete($_POST["selected"]);
       
        $this->json_list();
    }
    
}

?>
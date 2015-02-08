<?php

class Role extends Main_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/m_role');
    }

    public function json_list() {
        $data = $this->m_role->w2grid("SELECT * FROM tpl_role WHERE ~search~ ORDER BY ~sort~", $_POST);
        header("Content-Type: application/json;charset=utf-8");
        echo json_encode($data);
    }

    public function index() {
       
       
        $this->loadContent('admin/role/list');
     
    }
    public function showForm($id=0) {
        
        $postform=isset($_POST['frm'])?$_POST['frm']:array();
        $message="";
                    
       
        if(!empty($postform)){
            $validate=$this->m_role->validate($postform);
            if($validate["status"] && $this->m_role->saveOrUpdate($postform,$this->user_id)){
                echo "close_popup";exit;
            }
            $error_message= isset($validate["message"])?$validate["message"]:array();
            if(!empty($error_message)){
                $message=  showMessage($error_message);
            }
            
        }elseif($id!="0"&& empty($postform)){
            
            $postform=$this->m_role->get($id);
        
        }
        $dataParse=array(
            'post'=>$postform,
            'message'=>$message,
            'base_url'=>  base_url(),
            'site_url'=> site_url()
            );
        $this->parser->parse('admin/role/form', $dataParse);
       
    }
    
    
    public function delete() {
        if(isset($_POST["selected"]))
        $validate=$this->m_role->delete($_POST["selected"]);
       
        $this->json_list();
    }
    
}

?>
<?php

class Menu extends Main_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('admin/m_menu','admin/m_lookup','admin/m_role'));
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
        
        $sql="SELECT * FROM tpl_menu mn left join tpl_menu pp on mn.parent_id=pp.menu_id left join tpl_lookup lk on lk.value=mn.active_non and lk.type='active_non' left join tpl_role rl on mn.role_id=rl.role_id    WHERE ~search~ ORDER BY ~sort~";
        $data = $this->m_menu->w2grid(
        str_replace("*", "mn.menu_id mn_menu_id,pp.menu_title pp_sp_menu_title,mn.menu_title mn_sp_menu_title,mn.url mn_sp_url,mn.attributes mn_sp_attributes,lk.display_text lk_sp_display_text,mn.order_num mn_sp_order_num,rl.name rl_sp_name", $sql), 
        $_POST,
        str_replace("*","mn.parent_id" , $sql));
        header("Content-Type: application/json;charset=utf-8");
        echo json_encode($data);
    }

    public function index() {      
       
        $this->loadContent('admin/menu/list');     
    }
    public function showForm($id=0) {
        
        $postform=isset($_POST['frm'])?$_POST['frm']:array();
        $message="";
        if(!empty($postform)){
            $validate=$this->m_menu->validate($postform);
            if($validate["status"] && $this->m_menu->saveOrUpdate($postform,$this->username)){
                echo "close_popup";exit;
            }
            $error_message= isset($validate["message"])?$validate["message"]:array();
            if(!empty($error_message)){
                $message=  showMessage($error_message);
            }            
        }elseif($id!="0"&& empty($postform)){            
            $postform=$this->m_menu->get($id);        
            
        }
        $parentList=$this->m_menu->comboParent();
        $parentList=array_merge(array("0"=>"Root"),$parentList);        
        $activeNonList=$this->m_lookup->comboLookup("active_non");
        
        
        $roles=$this->m_role->comboRole();
        $roles=array_merge(array(""=>""),$roles); 
                
        $dataParse=array(
            'parentList'=>$parentList,
            'activeNonList'=>$activeNonList,
            'post'=>$postform,
            'roles'=>$roles,
            'message'=>$message,
            'base_url'=>  base_url(),
            'site_url'=> site_url()
            );
        $this->parser->parse('admin/menu/form', $dataParse);
       
    }
    
    public function delete() {
        if(isset($_POST["selected"]))
        $validate=$this->m_menu->delete($_POST["selected"]);
       
        $this->json_list();
    }
    
}

?>
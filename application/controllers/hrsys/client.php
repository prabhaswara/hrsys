<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * control client
 * - general
 * - history client
 * - set meeting
 * - set vacancy
 * = set
 * @author prabhaswara
 */
class client extends Main_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('hrsys/m_client','hrsys/m_employee', 'admin/m_lookup'));
    }
    

    public function detclient($id, $frompage = "home") {

        $client = $this->m_client->get($id);
        $breadcrumb = array();
        $site_url=  site_url();
        switch ($frompage) {
            case "home":
                $breadcrumb[]=array("link"=>"$site_url/home/main_home","text"=>"Home");
                break;
            case "allclient":
                $breadcrumb[]=array("link"=>"$site_url/hrsys/client/allclient","text"=>"All Client");
                break;
            case "prospect":
                $breadcrumb[]=array("link"=>"$site_url/hrsys/client/prospect","text"=>"Prospect Client");
                break;
            case "myclient":
                $breadcrumb[]=array("link"=>"$site_url/hrsys/client/myclient","text"=>"My Client");             
                break;
            
            case "addEditClient":
                $breadcrumb[]=array("link"=>"$site_url/hrsys/client/addEditClient","text"=>"New Client");             
                break;
        }
         $breadcrumb[]=array("link"=>"#","text"=>$client["name"]);  
     
         
        $canedit=false;
        if ($client["status"]=='0' ||$client["pic"] == $this->emp_id || in_array("hrsys_allclient", $this->ses_roles)) {
            $canedit=true;
           
        }
        
        $dataParse = array(
            "id"=> $id,
            "canedit"=>$canedit,
            "breadcrumb" => $breadcrumb,
            "client" =>$client,            
            "frompage"=>$frompage
        );
        $this->loadContent('hrsys/client/detclient', $dataParse);
    }

    public function prospect() {
        $this->loadContent('hrsys/client/prospect');
    }
    public function infClient($id) {
       $client = $this->m_client->get($id);   
      
       
       if(
        $this->user_id==$client["usercreate"]||
        $this->emp_id==$client["pic"]
               ){
           $canEdit=true;
       }
       $canedit=false;
        if ($client["status"]=='0' ||$client["pic"] == $this->user_id || in_array("hrsys_allclient", $this->ses_roles)) {
            $canedit=true;
           
        }
       $dataParse = array("client"=> $client,
           "canEdit"=>$canEdit
               
               );
       $this->loadContent('hrsys/client/infClient', $dataParse);
        
    }
   
    public function infoperation($id) {
       $client = $this->m_client->get($id);        
       $dataParse = array(
           "canDelete"=>true,
           "client"=> $client
               );
       $this->loadContent('hrsys/client/infoperation', $dataParse);
    }
    public function changePICJoinDate($id,$method) {
        
       $postForm = isset($_POST['frm']) ? $_POST['frm'] : array();
       $client=$this->m_client->get($id);  
     
        $comboPIC = array('' => '');
        $message = "";
        if (!empty($postForm)) {
            $postForm["cmpyclient_id"]=$id;
                if ($this->m_client->editClient($postForm, $this->sessionUserData,$method)) {
                    echo "close_popup";
                    exit;
                }
        }else{
            
            $postForm=$client;          
            $postForm["datejoin"]=  balikTgl($postForm["datejoin"]);
            if($postForm["datejoin"]=="00-00-0000")
                 $postForm["datejoin"]="";
        }
        
        if(isset($postForm["pic"]) && cleanstr($postForm["pic"])!=""){
                
                $isiComboPIC=$this->m_employee->comboPIC($postForm["pic"]);
                if(!empty($isiComboPIC))
                    $comboPIC +=$isiComboPIC;
                
            }
       
        

        $dataParse = array(
            'client'=>$client,
            'method'=>$method,
            'postForm' => $postForm,
            'message' => $message,          
            'comboPIC' => $comboPIC,
        );
        
       $this->loadContent('hrsys/client/changePICJoinDate', $dataParse);
    }
    public function infHistory($id) {

        if(!empty($_POST)&&$_POST["pg_action"]=="json"){
            
            if(!isset($_POST["sort"]))
            {
                $_POST["sort"]["0"]["direction"]="desc";
                $_POST["sort"]["0"]["field"]="datecreate";
            }

             $data = $this->m_client->w2grid("SELECT description,DATE_FORMAT(datecreate,'%d-%m-%Y %H:%i') datecreate  FROM hrsys_cmpyclient_trl WHERE cmpyclient_id='$id' and ~search~  ORDER BY ~sort~", $_POST);
            header("Content-Type: application/json;charset=utf-8");
            echo json_encode($data);exit;
        }     

        $this->loadContent('hrsys/client/infHistory',array("client_id"=>$id));
    }

    public function allclient() {
        $this->loadContent('hrsys/client/allclient');
    }

    public function myclient() {
        $this->loadContent('hrsys/client/myclient');
        
    }
    
    
    public function json_listClientByPIC($pic) {

        if (isset($_POST["sort"]) && !empty($_POST["sort"]))
            foreach ($_POST["sort"] as $key => $value) {
                $_POST["sort"][$key] = str_replace("_sp_", ".", $value);
            }


        if (isset($_POST["search"]) && !empty($_POST["search"]))
            foreach ($_POST["search"] as $key => $value) {
                $_POST["search"][$key] = str_replace("_sp_", ".", $value);
            }

        $where = "1=1";
        
         $where = "cl.pic='$pic'";
         

        $sql = "SELECT cl.cmpyclient_id cl_sp_cmpyclient_id,cl.name cl_sp_name,cl.cp_name cl_sp_cp_name,cl.cp_phone cl_sp_cp_phone, " .
                "emp.fullname emp_sp_fullname, lk.display_text lk_sp_display_text " .
                "from hrsys_cmpyclient cl " .
                "left join tpl_lookup lk on lk.type='cmpyclient_stat' and cl.status=lk.value " .
                "left join hrsys_employee emp on cl.pic=emp.emp_id " .
                "WHERE ~search~ and $where  ORDER BY ~sort~";


        $data = $this->m_menu->w2grid($sql, $_POST);
        header("Content-Type: application/json;charset=utf-8");
        echo json_encode($data);
    }
    
    public function json_listClient($status) {

        if (isset($_POST["sort"]) && !empty($_POST["sort"]))
            foreach ($_POST["sort"] as $key => $value) {
                $_POST["sort"][$key] = str_replace("_sp_", ".", $value);
            }


        if (isset($_POST["search"]) && !empty($_POST["search"]))
            foreach ($_POST["search"] as $key => $value) {
                $_POST["search"][$key] = str_replace("_sp_", ".", $value);
            }

        $where = "1=1";
        if ($status == 'all') {
            
        } elseif ($status == "prospect") {
            $where = "cl.status='0'";
        } elseif ($status == "my") {
            $where = "cl.pic='" . (isset($this->sessionUserData["employee"]["emp_id"]) ? $this->sessionUserData["employee"]["emp_id"] : "") . "'";
        }

        $sql = "SELECT cl.cmpyclient_id cl_sp_cmpyclient_id,cl.name cl_sp_name,cl.cp_name cl_sp_cp_name,cl.cp_phone cl_sp_cp_phone, " .
                "emp.fullname emp_sp_fullname, lk.display_text lk_sp_display_text " .
                "from hrsys_cmpyclient cl " .
                "left join tpl_lookup lk on lk.type='cmpyclient_stat' and cl.status=lk.value " .
                "left join hrsys_employee emp on cl.pic=emp.emp_id " .
                "WHERE ~search~ and $where  ORDER BY ~sort~";


        $data = $this->m_menu->w2grid($sql, $_POST);
        header("Content-Type: application/json;charset=utf-8");
        echo json_encode($data);
    }

    public function addEditClient($id = 0) {

        $postForm = isset($_POST['frm']) ? $_POST['frm'] : array();

        $create_edit = "Edit";
        $isEdit = true;
        if ($id == 0) {
            $create_edit = "New";
            $isEdit = false;
        }
        $comboPIC = array('' => '');
        $message = "";
        if (!empty($postForm)) {
            $validate = $this->m_client->validate($postForm, $isEdit);
            if ($validate["status"]) {
                if ($isEdit) {
                    
                    if ($this->m_client->editClient($postForm, $this->sessionUserData)) {
                         echo "close_popup";
                            exit;
                    }
                   
                } else {

                    if ($this->m_client->newClient($postForm, $this->sessionUserData)) {
                        redirect("hrsys/client/detclient/" . $this->m_client->cmpyclient_id."/addEditClient");
                    }
                }
            }

            $error_message = isset($validate["message"]) ? $validate["message"] : array();
            if (!empty($error_message)) {
                $message = showMessage($error_message);
            }
        }
        
        if($isEdit && empty($postForm)){
            $postForm=$this->m_client->get($id);
            
           
        }
        if(isset($postForm["pic"]) && cleanstr($postForm["pic"])!=""){
                
                $isiComboPIC=$this->m_employee->comboPIC($postForm["pic"]);
                if(!empty($isiComboPIC))
                    $comboPIC +=$isiComboPIC;
                
            }
        $stat_list = $this->m_lookup->comboLookup("cmpyclient_stat");

        

        $dataParse = array(
            'isEdit' => $isEdit,
            'postForm' => $postForm,
            'message' => $message,
            'stat_list' => $stat_list,
            'comboPIC' => $comboPIC,
        );
        $this->loadContent('hrsys/client/addEditClient', $dataParse);
    }

}

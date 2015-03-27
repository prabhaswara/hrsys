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
         $breadcrumb[]=array("link"=>"$site_url/hrsys/client/detclient/$id/$frompage","text"=>$client["name"]);  
     
         
        $canedit=false;
        if ($client["status"]=='0' ||$client["account_manager"] == $this->emp_id || in_array("hrsys_allclient", $this->ses_roles)) {
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
    public function formContract($client_id=0,$cmpyclient_ctrk_id =0) {
     
        $ds=DIRECTORY_SEPARATOR;
        
        $postForm = isset($_POST['frm']) ? $_POST['frm'] : array();
       
        $create_edit = "Edit";
        $isEdit = true;
        if ($cmpyclient_ctrk_id  == 0 ) {           
            $create_edit = "New";
            $isEdit = false;
             
        }
     

        $message = "";
        if (!empty($postForm) ) {
            $folder=$this->dir_client.$client_id;
            $postfile=$_FILES["doc_url"];
            
            $validate = $this->m_client->validateContract($postForm,$postfile,$folder);
            if ($validate["status"]) {
                
               if(!empty($postfile) && cleanstr($postfile["name"])!=""){
                    $postForm["doc_url"]=$postfile["name"];
               }
               $postForm["cmpyclient_id"]=$client_id;
               $oldContract=$this->m_client->getContract($cmpyclient_ctrk_id);
               if ($this->m_client->saveUpdateContract($postForm, $this->sessionUserData,$cmpyclient_ctrk_id)) {
                   
                   $newContract=$this->m_client->getContract($cmpyclient_ctrk_id);
                   
                   if(!empty($oldContract)&&!empty($postfile)&&$oldContract["doc_url"]!=$newContract["doc_url"]&&file_exists($folder.$ds.$oldContract["doc_url"])){
                        unlink($folder.$ds.$oldContract["doc_url"]);
                   }
                   
                   if(!empty($postfile) && cleanstr($postfile["name"])!=""){
                        $ds=DIRECTORY_SEPARATOR;
                        $filename=$folder.$ds.$postfile["name"];
                        $this->upload_file("doc_url",$filename);
                       
                    }
                    
                    echo "close_popup";
                    exit;
               }
            }
            
            $error_message = isset($validate["message"]) ? $validate["message"] : array();
            if (!empty($error_message)) {
                $message = showMessage($error_message);
            }
        }
        

        if($isEdit && empty($postForm)){
           $postForm=$this->m_client->getContract($cmpyclient_ctrk_id);
            $postForm["contractdate_1"]=  balikTgl($postForm["contractdate_1"]);
            $postForm["contractdate_2"]=  balikTgl($postForm["contractdate_2"]);
            $postForm["cmpyclient_ctrk_id"]=  $cmpyclient_ctrk_id;
            
        }
  
        $client = $this->m_client->get($client_id);    
        $dataParse = array(
            "isEdit"=>$isEdit,
            "message"=>$message,
            "postForm"=>$postForm,           
            "client"=> $client
                );
        $this->loadContent('hrsys/client/formContract', $dataParse);
        
    }
    public function viewContract($client_id) {
        
    }
    public function infContract($client_id) {
        
      $client=$this->m_client->get($client_id);
        $user_id=$this->user_id;
        $where="";
        if(!empty($_POST)&&$_POST["pg_action"]=="json"){
            
            if (isset($_POST["sort"]) && !empty($_POST["sort"])){
                foreach ($_POST["sort"] as $key => $value) {
                    $_POST["sort"][$key] = str_replace("_sp_", ".", $value);
                }                
            }else{
                $_POST["sort"][0]['direction'] ='desc';
                 $_POST["sort"][0]['field'] ='contractdate_2 '; 
            }
            if (isset($_POST["search"]) && !empty($_POST["search"]))
                foreach ($_POST["search"] as $key => $value) {
                    $_POST["search"][$key] = str_replace("_sp_", ".", $value);
                }       
         
            
            $where.="cmpyclient_id ='$client_id' and ";
            
            $sql = "SELECT *".
                   "from hrsys_cmpyclient_ctrk " .
                   "WHERE ~search~ and $where 1=1 ORDER BY ~sort~";


            $data = $this->m_menu->w2grid($sql, $_POST);
            header("Content-Type: application/json;charset=utf-8");
            echo json_encode($data);
            exit();
        
        }
        
        $canedit=false;
        if ($client["account_manager"] == $this->emp_id || in_array("hrsys_allvacancies", $this->ses_roles)) {
            $canedit=true;
        }

        $dataParse = array("client_id"=> $client_id,
            "canedit"=>$canedit
            );
       $this->loadContent('hrsys/client/infContract', $dataParse);
    }
    public function infClient($id) {
      $client = $this->m_client->get($id);   
      $canEdit=false;
       
       if(
        $this->user_id==$client["usercreate"]||
        $this->emp_id==$client["account_manager"]
               ){
           $canEdit=true;
       }
       $canedit=false;
        if ($client["status"]=='0' ||$client["account_manager"] == $this->user_id || in_array("hrsys_allclient", $this->ses_roles)) {
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
     
        $comboAM = array('' => '');
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
        
        if(isset($postForm["account_manager"]) && cleanstr($postForm["account_manager"])!=""){
                
                $isiComboPIC=$this->m_employee->comboAM($postForm["account_manager"]);
                if(!empty($isiComboPIC))
                    $comboAM +=$isiComboPIC;
                
            }
       
        

        $dataParse = array(
            'client'=>$client,
            'method'=>$method,
            'postForm' => $postForm,
            'message' => $message,          
            'comboAM' => $comboAM,
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
    
    
    public function json_listClientByPIC($account_manager) {

        if (isset($_POST["sort"]) && !empty($_POST["sort"]))
            foreach ($_POST["sort"] as $key => $value) {
                $_POST["sort"][$key] = str_replace("_sp_", ".", $value);
            }


        if (isset($_POST["search"]) && !empty($_POST["search"]))
            foreach ($_POST["search"] as $key => $value) {
                $_POST["search"][$key] = str_replace("_sp_", ".", $value);
            }

        $where = "1=1";
        
         $where = "cl.account_manager='$account_manager'";
         

        $sql = "SELECT cl.cmpyclient_id cl_sp_cmpyclient_id,cl.name cl_sp_name,cl.cp_name cl_sp_cp_name,cl.cp_phone cl_sp_cp_phone, " .
                "emp.fullname emp_sp_fullname, lk.display_text lk_sp_display_text " .
                "from hrsys_cmpyclient cl " .
                "left join tpl_lookup lk on lk.type='cmpyclient_stat' and cl.status=lk.value " .
                "left join hrsys_employee emp on cl.account_manager=emp.emp_id " .
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
            $where = "cl.account_manager='" . (isset($this->sessionUserData["employee"]["emp_id"]) ? $this->sessionUserData["employee"]["emp_id"] : "") . "'";
        }

        $sql = "SELECT cl.cmpyclient_id cl_sp_cmpyclient_id,cl.name cl_sp_name,cl.cp_name cl_sp_cp_name,cl.cp_phone cl_sp_cp_phone, " .
                "emp.fullname emp_sp_fullname, lk.display_text lk_sp_display_text " .
                "from hrsys_cmpyclient cl " .
                "left join tpl_lookup lk on lk.type='cmpyclient_stat' and cl.status=lk.value " .
                "left join hrsys_employee emp on cl.account_manager=emp.emp_id " .
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
        $comboAM = array('' => '');
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
        if(isset($postForm["account_manager"]) && cleanstr($postForm["account_manager"])!=""){
                
                $isiComboPIC=$this->m_employee->comboAM($postForm["account_manager"]);
                if(!empty($isiComboPIC))
                    $comboAM +=$isiComboPIC;
                
            }
        $stat_list = $this->m_lookup->comboLookup("cmpyclient_stat");

        

        $dataParse = array(
            'isEdit' => $isEdit,
            'postForm' => $postForm,
            'message' => $message,
            'stat_list' => $stat_list,
            'comboAM' => $comboAM,
        );
        $this->loadContent('hrsys/client/addEditClient', $dataParse);
    }

}

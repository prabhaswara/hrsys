<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * control meeting
 * - general
 * - history meeting
 * - set meeting
 * - set vacancy
 * = set
 * @author prabhaswara
 */
class vacancy extends Main_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('hrsys/m_client','hrsys/m_vacancy','hrsys/m_employee', 'admin/m_lookup'));
    }
    
    public function infVacancy($client_id) {
     
        $where="";
        if(!empty($_POST)&&$_POST["pg_action"]=="json"){
            if (isset($_POST["sort"]) && !empty($_POST["sort"])){
                foreach ($_POST["sort"] as $key => $value) {
                    $_POST["sort"][$key] = str_replace("_sp_", ".", $value);
                }                
            }else{
                $_POST["sort"][0]['direction'] ='desc';
                 $_POST["sort"][0]['field'] ='vac.opendate'; 
            }


            if (isset($_POST["search"]) && !empty($_POST["search"]))
                foreach ($_POST["search"] as $key => $value) {
                    $_POST["search"][$key] = str_replace("_sp_", ".", $value);
                }
            
           if(isset($_POST["typesearch"])&&$_POST["typesearch"]=="open"){
                $where.="vac.status='1' and ";
            }
            
            $where.="vac.cmpyclient_id ='$client_id' and ";
            
            $sql = "SELECT  vac.vacancy_id recid,vac.name vac_sp_name,DATE_FORMAT(vac.opendate,'%d-%m-%Y') vac_sp_opendate" .
                   ",lkstat.display_text lkstat_sp_display_text,vac.usercreate vac_sp_usercreate ".
                   "from hrsys_vacancy vac " .
                   "left join tpl_lookup lkstat on lkstat.type='vacancy_stat' and vac.status=lkstat.value " .
                   "WHERE ~search~ and $where 1=1 ORDER BY ~sort~";


            $data = $this->m_menu->w2grid($sql, $_POST);
            header("Content-Type: application/json;charset=utf-8");
            echo json_encode($data);
            exit();
        
        }
        $dataParse = array("client_id"=> $client_id);
        $this->loadContent('hrsys/vacancy/infVacancy', $dataParse);
        
    }
    
   
    public function delete($id){
        
    }
    
    public function contentVacancy($id,$frompage=""){
        
        $vacancyData=$this->m_vacancy->getDetails($id);
        $vacancy=$vacancyData["vacancy"];
        
        $client=$this->m_client->get($vacancy["cmpyclient_id"]);     
        
        $site_url=  site_url();
        
        switch ($frompage) {
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
         $breadcrumb[]=array("link"=>"$site_url/hrsys/client/detclient/".$client["cmpyclient_id"]."/".$frompage,"text"=>$client["name"]); 
         $breadcrumb[]=array("link"=>"$site_url/hrsys/vacancy/contentVacancy/".$vacancy["vacancy_id"]."/".$frompage,"text"=>$vacancy["name"]); 
         
        
        
        
        $dataParse = array(
            "vacancyData"=> $vacancyData,
            "client"=> $client,
            "frompage"=>$frompage,    
            "breadcrumb"=>$breadcrumb,    
                );
        $this->loadContent('hrsys/vacancy/contentVacancy', $dataParse);
    }
    public function detailVacancy(){
        
    }
    public function showForm($client_id=0,$vacancy_id=0) {
            
        $postForm = isset($_POST['frm']) ? $_POST['frm'] : array();
        $postShareMaintance = isset($_POST['shareMaintance']) ? $this->m_employee->sharewith($_POST['shareMaintance'],$this->user_id) : array();
        
        $comboPIC=array(''=>'');
        $create_edit = "Edit";
        $isEdit = true;
        if ($vacancy_id == 0 ) {           
            $create_edit = "New";
            $isEdit = false;
             
        }

        $message = "";
        if (!empty($postForm)) {
            $validate = $this->m_vacancy->validate($postForm, $isEdit);
            if ($validate["status"]) {
                $postForm["cmpyclient_id"]=$client_id;
                
                $dataSave["vacancy"]=$postForm;
                $dataSave["shareMaintance"]=$postShareMaintance;
                if ($this->m_vacancy->saveOrUpdate($dataSave, $this->sessionUserData)) {
                    echo "close_popup";
                    exit;
                }
            }

            $error_message = isset($validate["message"]) ? $validate["message"] : array();
            if (!empty($error_message)) {
                $message = showMessage($error_message);
            }
            
          
        }
        
        if (empty($postForm) && !$isEdit){
            $postForm["pic"]=$this->emp_id;
            $postForm["opendate"]=  today();
        }
        
        if(isset($postForm["pic"]) && cleanstr($postForm["pic"])!=""){
                
                $isiComboPIC=$this->m_employee->isiComboPIC($postForm["pic"]);
                if(!empty($isiComboPIC))
                    $comboPIC +=$isiComboPIC;
                
            }
            
        
        $client = $this->m_client->get($client_id);    
        $dataParse = array(
            "isEdit"=>$isEdit,
            "postForm"=>$postForm,
            "postShareMaintance"=>$postShareMaintance,
            "client"=>$client,
            "comboPIC"=>$comboPIC,
            "message"=>$message
                );
        $this->loadContent('hrsys/vacancy/showform', $dataParse);
        
    }
    
}

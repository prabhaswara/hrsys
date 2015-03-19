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
        $this->load->model(array('hrsys/m_client','hrsys/m_vacancy','hrsys/m_employee','hrsys/m_skill', 'admin/m_lookup'));
    }
    
    public function infVacancy($client_id) {
     
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
                   ",lkstat.display_text lkstat_sp_display_text,vac.usercreate vac_sp_usercreate".
                    ",vu.user_id vu_sp_user_id ".
                   "from hrsys_vacancy vac " .
                   "left join tpl_lookup lkstat on lkstat.type='vacancy_stat' and vac.status=lkstat.value " .
                   "left join hrsys_vacancyuser vu on vu.vacancy_id=vac.vacancy_id and vu.user_id='$user_id' ".
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
        $this->loadContent('hrsys/vacancy/infVacancy', $dataParse);
        
    }
    
   
    public function delete($id){
        
    }
    
    public function contentVacancy($vacancy_id,$frompage="home"){
        
        $vacancy=$this->m_vacancy->getDetails($vacancy_id);
        
        $shareVacant=$this->m_employee->shareVacantById($vacancy_id,$vacancy["usercreate"]);
        
        $shareName=array();
        if(!empty($shareVacant)){
            foreach ($shareVacant as $row){
                $shareName[]=$row["name"];
            }
            $shareVacant=  implode(", ", $shareName);
        }
        else{
            $shareVacant="";
        }
        
        $expertise =$this->m_skill->getExpertiseVacancy($vacancy_id);
        $skill=array();
        if(!empty($expertise)){
            foreach ($expertise as $row){
                $skill[]=$row["skill"];
            }
            $expertise=  implode(", ", $skill);
        }
        else{
            $expertise="";
        }        
        
        
        $client=$this->m_client->get($vacancy["cmpyclient_id"]);     
        
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
         $breadcrumb[]=array("link"=>"$site_url/hrsys/client/detclient/".$client["cmpyclient_id"]."/".$frompage,"text"=>$client["name"]); 
         $breadcrumb[]=array("link"=>"$site_url/hrsys/vacancy/contentVacancy/".$vacancy["vacancy_id"]."/".$frompage,"text"=>$vacancy["name"]); 
         
        
        
        $sidebarCandidate=json_encode($this->m_vacancy->getVCIdName($vacancy_id));
       
        
        $dataParse = array(
            "vacancy"=> $vacancy,
            "client"=> $client,
            "shareVacant"=>$shareVacant,
            "expertise"=>$expertise,
            "sidebarCandidate"=>$sidebarCandidate,
            "frompage"=>$frompage,    
            "breadcrumb"=>$breadcrumb,    
                );
        $this->loadContent('hrsys/vacancy/contentVacancy', $dataParse);
    }
    public function jsonVacancyCandidate($vacancy_id) {

        $where = "";

        if (isset($_POST["sort"]) && !empty($_POST["sort"])) {
            foreach ($_POST["sort"] as $key => $value) {
                $_POST["sort"][$key] = str_replace("_sp_", ".", $value);
            }
        } else {
            $_POST["sort"][0]['direction'] = 'desc';
            $_POST["sort"][0]['field'] = 'vc.dateupdate';
        }


        if (isset($_POST["search"]) && !empty($_POST["search"]))
            foreach ($_POST["search"] as $key => $value) {
                $_POST["search"][$key] = str_replace("_sp_", ".", $value);
            }

        $where="vc.vacancy_id='$vacancy_id' and ";
        if(isset($_POST["typesearch"])&&$_POST["typesearch"]!=""){
                $where.="vc.applicant_stat='".$_POST["typesearch"]."' and";
        }

        $sql = "SELECT  vc.vacancycandidate_id recid,c.candidate_id c_sp_candidate_id ,c.name c_sp_name,c.phone c_sp_phone,vc.expectedsalary vc_sp_expectedsalary,klstate.display_text klstate_sp_display_text,cm.fullname cm_sp_fullname " .
               "from hrsys_vacancycandidate vc " .
               "join hrsys_candidate c on vc.candidate_id=c.candidate_id ".
               "left join hrsys_employee cm on vc.candidate_manager=cm.emp_id ".
               "left join tpl_lookup klstate on klstate.type='applicant_stat' and vc.applicant_stat=klstate.value " .
               "WHERE ~search~ and $where 1=1 ORDER BY ~sort~";


        $data = $this->m_menu->w2grid($sql, $_POST);
        header("Content-Type: application/json;charset=utf-8");
        echo json_encode($data);
        exit();
    }
    
    public function cvCandidates($vacancy_id){
        
        $vacancy=$this->m_vacancy->get($vacancy_id);
      
        $dataParse = array(
            "vacancy"=> $vacancy,       
                );
        $this->loadContent('hrsys/vacancy/cvCandidates', $dataParse);
    }
    public function showForm($client_id=0,$vacancy_id=0,$frompage="") {
            
        $postForm = isset($_POST['frm']) ? $_POST['frm'] : array();
        $postShareMaintance = isset($_POST['shareMaintance']) ? $this->m_employee->sharewith($_POST['shareMaintance'],$this->user_id) : array();
        $postExpertise = isset($_POST['expertise']) ? $this->m_skill->expertise($_POST['expertise']) : array();
        $client = $this->m_client->get($client_id);    
     
        
        $comboAM=array(''=>'');
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
                $dataSave["expertise"]=$postExpertise;
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
            $postForm["account_manager"]=$this->emp_id;
            $postForm["opendate"]=  today();
            $postForm["num_position"]=  1;
            $postForm["fee"]= cleanstr($client["ck_fee"]);
        }
        else if (empty($postForm) && $isEdit){
            $postForm=$this->m_vacancy->get($vacancy_id);
            $postShareMaintance =$this->m_employee->maintainceByVacancy($vacancy_id,$postForm["usercreate"]);
            $postExpertise =$this->m_skill->getExpertiseVacancy($vacancy_id);
            $postForm["opendate"]=  balikTgl($postForm["opendate"]);
        }
        if(isset($postForm["account_manager"]) && cleanstr($postForm["account_manager"])!=""){
                
                $isiComboAM=$this->m_employee->isiComboAM($postForm["account_manager"]);
                if(!empty($isiComboAM))
                    $comboAM +=$isiComboAM;
                
            }
            
        
        $sex_list=array(""=>"")+$this->m_lookup->comboLookup("sex");
        $dataParse = array(
            "isEdit"=>$isEdit,
            "postForm"=>$postForm,
            "postShareMaintance"=>$postShareMaintance,
            "postExpertise"=>$postExpertise,
            "client"=>$client,
            "comboAM"=>$comboAM,
            "sex_list"=>$sex_list,
            "frompage"=>$frompage,
            "message"=>$message
                );
        $this->loadContent('hrsys/vacancy/showform', $dataParse);
        
    }
    
    public function jsonDetVac($vacancy_id){
        header("Content-Type: application/json;charset=utf-8");
        echo json_encode($this->m_vacancy->getDetails($vacancy_id));
        exit();
    }
    
    public function jsonListVacOpenByPIC($account_manager) {

        $where = "";

        if (isset($_POST["sort"]) && !empty($_POST["sort"])) {
            foreach ($_POST["sort"] as $key => $value) {
                $_POST["sort"][$key] = str_replace("_sp_", ".", $value);
            }
        } else {
            $_POST["sort"][0]['direction'] = 'desc';
            $_POST["sort"][0]['field'] = 'vac.opendate';
        }


        if (isset($_POST["search"]) && !empty($_POST["search"]))
            foreach ($_POST["search"] as $key => $value) {
                $_POST["search"][$key] = str_replace("_sp_", ".", $value);
            }

        
        $where.="vac.status='1' and vac.account_manager ='$account_manager' and ";

        $sql = "SELECT  vac.vacancy_id recid,client.name client_sp_name,vac.name vac_sp_name,DATE_FORMAT(vac.opendate,'%d-%m-%Y') vac_sp_opendate" .
                ",lkstat.display_text lkstat_sp_display_text,vac.usercreate vac_sp_usercreate " .
                "from hrsys_vacancy vac " .
                "join hrsys_cmpyclient client on vac.cmpyclient_id=client.cmpyclient_id ".
                "left join tpl_lookup lkstat on lkstat.type='vacancy_stat' and vac.status=lkstat.value " .
                "WHERE ~search~ and $where 1=1 ORDER BY ~sort~";


        $data = $this->m_menu->w2grid($sql, $_POST);
        header("Content-Type: application/json;charset=utf-8");
        echo json_encode($data);
        exit();
    }

}

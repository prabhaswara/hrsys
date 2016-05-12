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
        $this->load->model(array('hrsys/m_client','hrsys/m_schedule','hrsys/m_vacancy','hrsys/m_candidate','hrsys/m_employee','hrsys/m_skill', 'admin/m_lookup'));
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
        if ($client["active_non"]=='1' and($client["account_manager"] == $this->employee_id || in_array("hrsys_allvacancies", $this->ses_roles))) {
            $canedit=true;
        }
		
        $dataParse = array("client_id"=> $client_id,
            "canedit"=>$canedit
            );
        $this->loadContent('hrsys/vacancy/infVacancy', $dataParse);
        
    }
    
	
	
	public function closeVancany($vacancy_id)
	{
		$this->m_vacancy->closeVancany($vacancy_id);
		exit;
	}
	
	public function deleteVancany($vacancy_id)
	{
		$this->m_vacancy->deleteVancany($vacancy_id);
		exit;
	}
    public function deleteVacantTrail($vacancy_trl_id){
        
		echo $this->m_vacancy->deleteVacantTrail($vacancy_trl_id);
		exit;
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
			case "inactive":
                $breadcrumb[]=array("link"=>"$site_url/hrsys/client/inactive","text"=>"Inactive Client");             
                break;
        }
         $breadcrumb[]=array("link"=>"$site_url/hrsys/client/detclient/".$client["cmpyclient_id"]."/".$frompage."/vacancies","text"=>$client["name"]); 
         $breadcrumb[]=array("link"=>"$site_url/hrsys/vacancy/contentVacancy/".$vacancy["vacancy_id"]."/".$frompage,"text"=>$vacancy["name"]); 
         
        
       $vcdidname=$this->m_vacancy->getVCIdName($vacancy_id); 
       $sidebarCandidate=json_encode($vcdidname);
       $canedit=false;
	   $candelete=false;
	   if ($client["account_manager"] == $this->employee_id || in_array("hrsys_allvacancies", $this->ses_roles)) {
            $canedit=true;
			if(empty($vcdidname))
			{
				$candelete=true;
			}
        }
		$message="";
        if(isset($_GET["status"]))
		{
			if($_GET["status"]=="remove_candidate")
			{
				$message = showMessage("Candidate Removed","success");
			}
		}
        $dataParse = array(
            "vacancy"=> $vacancy,
            "client"=> $client,
            "shareVacant"=>$shareVacant,
            "expertise"=>$expertise,
            "sidebarCandidate"=>$sidebarCandidate,
            "frompage"=>$frompage,    
            "breadcrumb"=>$breadcrumb, 
			"canedit"=>$canedit,
			"candelete"=>$candelete,
			"message"=>$message
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

        $sql = "SELECT  vc.vacancycandidate_id recid,c.candidate_id c_sp_candidate_id ,c.name c_sp_name,c.phone c_sp_phone,vc.expectedsalary vc_sp_expectedsalary,vc.approvedsalary vc_sp_approvedsalary,klstate.display_text klstate_sp_display_text,cm.fullname cm_sp_fullname " .
               "from hrsys_vacancycandidate vc " .
               "join hrsys_candidate c on vc.candidate_id=c.candidate_id ".
               "left join hrsys_employee cm on vc.candidate_manager=cm.id ".
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
            $postForm["account_manager"]=$this->employee_id;
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
            "message"=>$message,
			"listCCY"=>$this->m_lookup->comboLookup("ccy")
                );
        $this->loadContent('hrsys/vacancy/showform', $dataParse);
        
    }
    
    public function jsonDetVac($vacancy_id){
        header("Content-Type: application/json;charset=utf-8");
        $data=$this->m_vacancy->getDetails($vacancy_id);
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
        $data["expertise"]=$expertise;
        echo json_encode($data);
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
    
    public function processCandidate($vacancy_id,$candidate_id){
        
        $trail=$this->m_vacancy->getActiveTrlByVacCan($vacancy_id,$candidate_id);  
		$trl_id=$trail["trl_id"];
		$canedit=false;
		$shareVacant=$this->m_employee->shareVacantById($vacancy_id,$vacancy["usercreate"],true);
		
		
		$postForm = isset($_POST['frm']) ? $_POST['frm'] : array();
		$message = "";
        if (!empty($postForm)) {	
			$action=(isset($_POST["action"])?$_POST["action"]:"save");
			$validate=$this->m_vacancy->validateProcess($_POST);
			
			if($validate["status"])
			{
				if($this->m_vacancy->updateVacancyTrl($action,$_POST, $this->sessionUserData))
				{
					$message = showMessage("Data Saved","success");
					$trail=$this->m_vacancy->getActiveTrlByVacCan($vacancy_id,$candidate_id); 					
					$postForm=$this->m_vacancy->getVacancyTrl($trail["trl_id"]);
				
				}	
			}
			else
			{
				$message = showMessage($validate["message"]); 
			}
				
			
        }
		else{
			$postForm=$this->m_vacancy->getVacancyTrl($trl_id);
			if(isset($_GET["status"]))
			{
				if($_GET["status"]=="delete_trail")
				{
					$message = showMessage("Process Deleted","success");
				}
			}
		}
		
        
        $vacancyCandidate=$this->m_vacancy->getVacancyCandidateByid($trail["vacancycandidate_id"]);
		$vacancy=$this->m_vacancy->getDetails($vacancyCandidate["vacancy_id"]);
        $candidate=$this->m_candidate->get($vacancyCandidate["candidate_id"]);         
        $headerTrail=$this->m_vacancy->getHeaderTrail($vacancy["vacancy_id"]);
        
        $listNextState=$this->m_vacancy->listNextState($trail["applicant_stat_id"]);
		
     
        $dataParse = array(
            "candidate"=>$candidate,
            "vacancy"=>$vacancy,
			"message"=>$message,
            "vacancyCandidate"=>$vacancyCandidate,
            "listNextState"=>$listNextState,
            "trail"=>$trail,
            "headerTrail"=>$headerTrail,
            "postForm"=>$postForm,

            );
			
		switch ($vacancyCandidate["applicant_stat"]) {
			case applicant_stat_processinterview:
				$dataParse["timeList"] = array(""=>"")+$this->m_lookup->comboTime();
				$dataParse["interview_type"]=$this->m_lookup->comboLookup("interview_type");
				$temp=$this->m_vacancy->getInterview($trl_id);
				
				$schedule=  explode(" ",balikTglDate($temp["schedule"], true,false)) ;
				$dataParse["interviewForm"]["schedule_d"]=$schedule[0];
                $dataParse["interviewForm"]["schedule_t"]=$schedule[1];
                if($dataParse["interviewForm"]["schedule_t"]=="00:00"){
                    $dataParse["interviewForm"]["schedule_t"]="";
                }
				$schedule=$this->m_schedule->getByType("interview",$trl_id);
				if(!empty($schedule))
				{
					$dataParse["interviewForm"]["remider"]='1';
					$dataParse["interviewForm"]["remider_desc"]=$schedule["description"];
				}
				$dataParse["interviewForm"]["type"]=$temp["type"];
				
			break;
			case applicant_stat_processtoclient:
			break;
			case applicant_stat_offeringsalary:			
				$dataParse["listCCY"]=$this->m_lookup->comboLookup("ccy");
				$dataParse["offeringsalaryForm"]=$this->m_vacancy->getOfferingSalary($trl_id);
				
			break;
			case applicant_stat_rejectedfromcandidate:
			break;
			case applicant_stat_rejectedfromclient:
			break;
			case applicant_stat_notqualified:
			break;
			case applicant_stat_placemented:
				$dataParse["listCCY"]=$this->m_lookup->comboLookup("ccy");
				$dataParse["placementedForm"]=$this->m_vacancy->getPlacemented($trl_id);
				
				$dataParse["placementedForm"]["date_join"]=balikTgl($dataParse["placementedForm"]["date_join"]);

				
			break;
				
		}
			
		
		
        $this->loadContent('hrsys/vacancy/processCandidate', $dataParse);
		
    }
    function detailTrail($trail_id)
	{
		$dataTrail= $this->m_vacancy->getVacancyTrl($trail_id);
		$dataTrail["applicant_stat"]=$this->m_lookup->getDisplaytext("applicant_stat",$dataTrail["applicant_stat_id"]);
		$dataTrail["applicant_stat_next_t"]=$this->m_lookup->getDisplaytext("applicant_stat",$dataTrail["applicant_stat_next"]);
		
		
		$vacancyCandidate=$this->m_vacancy->getVacancyCandidateByid($dataTrail["vacancycandidate_id"]);
        $candidate=$this->m_candidate->get($vacancyCandidate["candidate_id"]);  
		
		
		
		
		$dataParse["dataTrail"] = $dataTrail;		
		$dataParse["vacname"] = $this->m_vacancy->getClientNmVacNm($vacancyCandidate["vacancy_id"]);
		$dataParse["vacancyCandidate"] = $vacancyCandidate;
		$dataParse["candidate"] = $candidate;		
		$dataParse["candidate"]=$this->m_candidate->get($vacancyCandidate["candidate_id"]);   
		switch ($dataParse["dataTrail"]["applicant_stat_id"]) {
			case applicant_stat_processinterview:
				$interview=$this->m_vacancy->getInterview($trail_id);
				$interview["type_t"]=$this->m_lookup->getDisplaytext("interview_type",$interview["type"]);
				
				$interview["schedule"]=balikTglDate($interview["schedule"], true,false) ;
				
				//
				$schedule=$this->m_schedule->getByType("interview",$trail_id);
				$interview["remider"]='No';
				$interview["remider_desc"]="";
				if(!empty($schedule))
				{
					$interview["remider"]='Yes';
					$interview["remider_desc"]=$schedule["description"];
				}
				//
				$dataParse["interview"]=$interview;
				
				
				
			break;
			case applicant_stat_processtoclient:
			break;
			case applicant_stat_offeringsalary:			
				$dataParse["offeringsalary"]=$this->m_vacancy->getOfferingSalary($trail_id);
				
			break;
			case applicant_stat_rejectedfromcandidate:
			break;
			case applicant_stat_rejectedfromclient:
			break;
			case applicant_stat_notqualified:
			break;
			case applicant_stat_placemented:
				$dataParse["placemented"]=$this->m_vacancy->getPlacemented($trail_id);
				
				$dataParse["placemented"]["date_join"]=balikTglDate($dataParse["placemented"]["date_join"]) ;
			break;
				
		}
		$this->loadContent('hrsys/vacancy/detailTrail', $dataParse);
	
	}
   
    

}

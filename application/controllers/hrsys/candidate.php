<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @author prabhaswara
 */
class candidate extends Main_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('admin/m_lookup', "hrsys/m_candidate", "hrsys/m_vacancy", "hrsys/m_client", "hrsys/m_skill"));
    }

    function addCandidate($candidate_id,$vacancy_id,$frompage="allclient"){
        
        $this->m_candidate->addCandidateToVacancy($candidate_id,$vacancy_id,$this->sessionUserData);
        redirect("hrsys/vacancy/contentVacancy/$vacancy_id/$frompage");
    }
    
    public function addEditCandidate($candidate_id = 0, $vacancy_id = "", $frompage = "") {
        $ds=DIRECTORY_SEPARATOR;
        $site_url=  site_url();
        $postForm = isset($_POST['frm']) ? $_POST['frm'] : array();
        $postExpertise = isset($_POST['expertise']) ? $this->m_skill->expertise($_POST['expertise']) : array();
        $candidate="";
        
		$comboCM=array(''=>'');
		
        $message="";
        $create_edit = "Edit";
        $isEdit = true;
        if ($candidate_id == 0 ) {           
            $create_edit = "New";
            $isEdit = false;
        }
        $vacancy=$this->m_vacancy->get($vacancy_id);
        $breadcrumb=$this->setBreedcum($vacancy_id, $frompage);
        
        if($isEdit){
            $candidate=$this->m_candidate->get($candidate_id);
            $breadcrumb[] = array("link" => "$site_url/hrsys/candidate/listCandidate/$vacancy_id/$frompage", "text" => "Search Candidate");
            $breadcrumb[] = array("link" => "$site_url/hrsys/candidate/detcandidate/$candidate_id/$vacancy_id/$frompage", "text" => $candidate["name"]);
        
        }
        
        $breadcrumb[] = array("link" => "$site_url/hrsys/candidate/addEditCandidate/$candidate_id/$vacancy_id/$frompage", "text" => "$create_edit Candidate");
        
        if (!empty($postForm)) {
           
            $validate = $this->m_candidate->validate($postForm, $isEdit);
            if ($validate["status"]) {
                $dataSave["candidate"]=$postForm;
                $dataSave["vacancy_id"]=$vacancy_id;
                $dataSave["expertise"]=$postExpertise;
                
				$photoName="";
				$photoThumb="";
				if(isset($_FILES["photo"])&&!empty($_FILES["photo"]) && cleanstr($_FILES["photo"]["name"])!=""){
					
					$ext=explode(".",$_FILES["photo"]["name"]);
					$ext=$ext[count($ext)-1];
					
					$photoName="photo.".$ext;
					$photoThumb="photoThumb.".$ext;
					$dataSave["candidate"]["photo"]=$photoName;
				}
                if ($this->m_candidate->saveOrUpdate($dataSave, $this->sessionUserData,$candidate_id)) {
                
                    if(isset($_FILES["cv"])&&!empty($_FILES["cv"]) && cleanstr($_FILES["cv"]["name"])!=""){
                        $ds=DIRECTORY_SEPARATOR;
                        $filename=$this->dir_candidate.$candidate_id.$ds."main_cv.pdf";
                        $this->upload_file("cv",$filename);
                       
                    }
					if(isset($_FILES["photo"])&&!empty($_FILES["photo"]) && cleanstr($_FILES["photo"]["name"])!=""){
                        $ds=DIRECTORY_SEPARATOR;
						$this->mkpath($this->dir_candidate.$candidate_id);
						
                        $this->uploadResizeImage("photo",$this->dir_candidate.$candidate_id.$ds.$photoName,400);
						$this->uploadResizeImage("photo",$this->dir_candidate.$candidate_id.$ds.$photoThumb,200);
					
                    }
                    
                    redirect( "hrsys/candidate/detCandidate/$candidate_id/$vacancy_id/$frompage");
                }
                else{
                    echo "error system save candidate";exit;
                }
            }

            $error_message = isset($validate["message"]) ? $validate["message"] : array();
            if (!empty($error_message)) {
                $message = showMessage($error_message);
            }
           
          
        }
        
        if (empty($postForm) && $isEdit){
            $postForm=$candidate;
            
            $postForm["birthdate"]=  balikTgl($postForm["birthdate"]);
            $postExpertise=$this->m_candidate->getExperties($candidate_id);
        }
		 $this->load->model("hrsys/m_employee");
      //  print_r($postForm);exit;
		if(isset($postForm["candidate_manager"]) && cleanstr($postForm["candidate_manager"])!=""){
               
                $isiComboCM=$this->m_employee->isiComboAM($postForm["candidate_manager"]);
                if(!empty($isiComboCM))
                    $comboCM +=$isiComboCM;
                
            }
			
        $sex_list=array(""=>"")+$this->m_lookup->comboLookup("sex");
        
        $dataParse = array(
			"comboCM"=>$comboCM,
            "message"=>$message,
            "isEdit"=>$isEdit,
            "postForm"=>$postForm,
            "postExpertise"=>$postExpertise,
            "vacancy_id"=>$vacancy_id,
            "vacancy"=>$vacancy,
            "frompage"=>$frompage,    
            "breadcrumb"=>$breadcrumb,
            "sex_list"=>$sex_list,
			"listCCY"=>$this->m_lookup->comboLookup("ccy")
        );
        $this->loadContent('hrsys/candidate/addEditCandidate', $dataParse);
    }
        
    public function listCandidate($vacancy_id = "", $frompage = "") {
        $vacancy=$this->m_vacancy->get($vacancy_id);
        $breadcrumb=$this->setBreedcum($vacancy_id, $frompage);
        $site_url = site_url();
        
        $breadcrumb[] = array("link" => "$site_url/hrsys/candidate/listCandidate/$vacancy_id/$frompage", "text" => "Search Candidate");
        $postForm =array();
		$postForm['salary_1']=$vacancy['salary_1'];
		$postForm['salary_2']=$vacancy['salary_2'];
		$postForm['salary_ccy']=$vacancy['salary_ccy'];
		$postForm['age_1']=$vacancy['age_1'];
		$postForm['age_2']=$vacancy['age_2'];
		$postForm['sex']=$vacancy['sex'];
		
		$postExpertise=$this->m_vacancy->getExperties($vacancy_id);
		
        $sex_list=array(""=>"")+$this->m_lookup->comboLookup("sex");
        
		 
		
        $dataParse = array(            
            "vacancy_id"=>$vacancy_id,
            "postForm"=>$postForm,
            "sex_list"=>$sex_list,
            "vacancy"=>$vacancy,
            "frompage"=>$frompage,  
			"postExpertise"=>$postExpertise,
			"listCCY"=>array(""=>"")+$this->m_lookup->comboLookup("ccy"),
            "breadcrumb"=>$breadcrumb,
        );
        $this->loadContent('hrsys/candidate/listCandidate', $dataParse);
    }
    
    public function jsonListCandidate() {
       $where = "";

        if (isset($_POST["sort"]) && !empty($_POST["sort"])) {
            foreach ($_POST["sort"] as $key => $value) {
                $_POST["sort"][$key] = str_replace("_sp_", ".", $value);
            }
        } else {
         //   $_POST["sort"][0]['direction'] = 'asc';
         //   $_POST["sort"][0]['field'] = 'c.name';
        }


        if (isset($_POST["search"]) && !empty($_POST["search"]))
            foreach ($_POST["search"] as $key => $value) {
                $_POST["search"][$key] = str_replace("_sp_", ".", $value);
            }
			
			$search_salary_1=cleanNumber($_POST["salary_1"]);
			$search_salary_2=cleanNumber($_POST["salary_2"]);
			$search_age_1=cleanNumber($_POST["age_1"]);
			$search_age_2=cleanNumber($_POST["age_2"]);
			$search_sex=cleanstr($_POST["sex"]);
			
			if($search_salary_1>0 && $search_salary_2>0)
			{
				$where.=" c.expectedsalary BETWEEN $search_salary_1 and $search_salary_2 and";
			}
			else
			{
				if($search_salary_1>0)
				{
					$where.=" c.expectedsalary >=$search_salary_1 and";
				}
				if($search_salary_2>0)
				{
					$where.=" c.expectedsalary <= $search_salary_2 and";
				}
			}
			
			$yearNow=date("Y");
			
			if($search_age_1>0 && $search_age_2>0)
			{
				$search_age_1=$yearNow-$search_age_1;
				$search_age_2=$yearNow-$search_age_2;				
				$where.=" YEAR(c.birthdate) BETWEEN $search_age_2 and $search_age_1 and";
			}
			else
			{
				
				if($search_age_1>0)
				{
					$search_age_1=$yearNow-$search_age_1;
					$where.=" YEAR(c.birthdate) <= $search_age_1 and";
				}
				if($search_age_2>0)
				{
					$search_age_2=$yearNow-$search_age_2;
					$where.=" YEAR(c.birthdate) >= $search_age_2 and";
				}
			}
			
			if($search_sex!="")
			{
				$where.=" c.sex ='$search_sex' and";
			}
			if(isset($_POST["expertise"]) && count($_POST["expertise"])>0)
			{
				foreach($_POST["expertise"] as $expertise)
				{  
					$where.=" EXISTS (select null from hrsys_candidate_skill hsk where c.candidate_id=hsk.candidate_id and hsk.skill='$expertise') and ";
				}
			}
			

        $sql = "SELECT c.candidate_id recid,lksat.display_text lksat_sp_display_text, c.name c_sp_name, c.phone c_sp_phone,c.expectedsalary c_sp_expectedsalary " .
               ", lksex.display_text lksex_sp_display_text,YEAR(now())-YEAR(c.birthdate) c_sp_age ".
               ", c.skill c_sp_skill,cm.fullname cm_sp_fullname ".
               "from hrsys_candidate c " .
			   "left join hrsys_employee cm on cm.id=c.candidate_manager ".
               "left join tpl_lookup lksat on lksat.type='candidate_stat' and c.status=lksat.value " .
               "left join tpl_lookup lksex on lksex.type='sex' and c.sex=lksex.value " .
               "WHERE c.consultant_code='".$this->sessionUserData["employee"]["consultant_code"]."' and ~search~ and $where 1=1 ORDER BY ~sort~";


        $data = $this->m_menu->w2grid($sql, $_POST);
        header("Content-Type: application/json;charset=utf-8");
        echo json_encode($data);
        exit();
    }
    
    public function detcandidate($candidate_id,$vacancy_id=0,$frompage=""){   
        $vacancy=$this->m_vacancy->get($vacancy_id);
        $candidate=$this->m_candidate->get($candidate_id);
        $breadcrumb=$this->setBreedcum($vacancy_id, $frompage);
        $site_url = site_url();
        
        $breadcrumb[] = array("link" => "$site_url/hrsys/candidate/listCandidate/$vacancy_id/$frompage", "text" => "Search Candidate");
        $breadcrumb[] = array("link" => "$site_url/hrsys/candidate/detcandidate/$candidate_id/$vacancy_id/$frompage", "text" => $candidate["name"]);
        
        $postForm = isset($_POST['frm']) ? $_POST['frm'] : array();
        $sex_list=array(""=>"")+$this->m_lookup->comboLookup("sex");
        
        $dataParse = array(            
            "candidate"=>$candidate,
            "vacancy_id"=>$vacancy_id,
            "postForm"=>$postForm,        
            "vacancy"=>$vacancy,
            "frompage"=>$frompage,    
            "breadcrumb"=>$breadcrumb,
        );
        $this->loadContent('hrsys/candidate/detcandidate', $dataParse);
        
    }
    public function infoCandidate($candidate_id,$vacancy_id=0,$showAddVac="hide"){   
        $candidate=$this->m_candidate->getDetail($candidate_id);
        $vacancy=$this->m_vacancy->getDetails($vacancy_id);
      
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
        
        if(empty($candidate)) exit;
        
       // print_r($this->sessionUserData);
      
        $listVact=$this->m_vacancy->listOpenVacancy($this->employee_code,$this->user_id,in_array("hrsys_allclient", $this->ses_roles));
       
        
        $listVacany=array();
        if(!empty($listVact)){
            foreach ($listVact as $vac){             
               $listVacany[$vac["vacancy_id"]]=$vac["name"]; 
            }
        }  
        
        ///
        $ds = DIRECTORY_SEPARATOR;        
        $folder=$this->dir_candidate . $candidate_id . $ds."doc".$ds;
        
        
        $listFile=array();
        if (is_dir($folder)) {
            if ($dh = opendir($folder)) {
                while (($file = readdir($dh)) !== false) {                    
                    if(!is_dir($folder.$file))
                        $listFile[]=$file;
                }
                closedir($dh);
            }
        }
        
        $cv=file_exists($this->dir_candidate . $candidate_id . $ds."main_cv.pdf");
        
        $canedit=$showAddVac=="show"?true:false;
       
        $dataParse = array(            
            "candidate"=>$candidate,       
            "listVacany"=>$listVacany,       
            "vacancy"=>$vacancy,
            "expertise"=>$expertise,
            "showAddVac"=>$showAddVac,
            "canedit"=>$canedit,
            "listFile"=>$listFile,
            "cv"=>$cv
        );
        $this->loadContent('hrsys/candidate/infoCandidate', $dataParse);
        
    }
   
    
    public function cvCandidate($candidate_id){
        
        $ds=DIRECTORY_SEPARATOR;
        $filepath=$this->dir_candidate.$candidate_id.$ds."main_cv.pdf";
        if(file_exists($filepath))
        {
            $hrefPDF=$this->site_candidate.$candidate_id."/main_cv.pdf";
            echo "<iframe src='$hrefPDF' width='100%' style='height:100%;border:none' align='right'>[Your browser does <em>not</em> support <code>iframe</code>,or has been configured not to display inline frames.You can access <a href='$hrefPDF'>the document</a>via a link though.]</iframe>";
        }
        
    }
	public function getPhoto($candidate_id,$photo){
        
		$split=explode(".",$photo);
		$ext=$split[1];
		
        $ds=DIRECTORY_SEPARATOR;
        $path=$this->dir_candidate.$candidate_id.$ds."photo.".$ext;
		
		
        if(file_exists($path))
        {
            header("Content-Type: image/".$ext );
			header("Content-Length:".filesize($path) );
			readfile( $path );
        }
        
    }
	public function getphotoThumb($candidate_id,$photo){
        
		$split=explode(".",$photo);
		$ext=$split[1];
		
        $ds=DIRECTORY_SEPARATOR;
        $path=$this->dir_candidate.$candidate_id.$ds."photoThumb.".$ext;
		
		
        if(file_exists($path))
        {
            header("Content-Type: image/".$ext );
			header("Content-Length:".filesize($path) );
			readfile( $path );
        }
        
    }
	
    public function historyCandidate($candidate_id,$vacancy_id=0){
        
        if (!empty($_POST) && $_POST["pg_action"] == "json") {
            if (isset($_POST["sort"]) && !empty($_POST["sort"])) {
                foreach ($_POST["sort"] as $key => $value) {
                    $_POST["sort"][$key] = str_replace("_sp_", ".", $value);
                }
            } else {
                $_POST["sort"][0]['direction'] = 'desc';
                $_POST["sort"][0]['field'] = 'ct.datecreate';
            }


            if (isset($_POST["search"]) && !empty($_POST["search"]))
                foreach ($_POST["search"] as $key => $value) {
                    $_POST["search"][$key] = str_replace("_sp_", ".", $value);
                }

            $where = "ct.candidate_id ='$candidate_id' and ";
            
            if($vacancy_id!=0){
                $where .= "ct.vacancy_id ='$vacancy_id' and ";
            }

            $sql = "SELECT ct.candidate_trl_id, c.name c_sp_name,v.name v_sp_name, DATE_FORMAT(ct.datecreate,'%d-%m-%Y') ct_sp_datecreate,ct.description ct_sp_description " .
                    "from hrsys_candidate_trl ct " .
                    "left join hrsys_vacancy v on ct.vacancy_id=v.vacancy_id ".
                    "left join hrsys_cmpyclient c on c.cmpyclient_id=v.cmpyclient_id ".
                    "WHERE ~search~ and $where 1=1 ORDER BY ~sort~";
           
           
            $data = $this->m_menu->w2grid($sql, $_POST);            
                     
            header("Content-Type: application/json;charset=utf-8");
            echo json_encode($data);
            exit();
        }
        
        
        $candidate=$this->m_candidate->get($candidate_id);      
        
        if(empty($candidate)) exit;
        
      
         $dataParse = array(
            "candidate_id"=>$candidate_id,
            "vacancy_id"=>$vacancy_id         
           
        );
        $this->loadContent('hrsys/candidate/infHistory', $dataParse);
        
    }
    
    private function setBreedcum($vacancy_id, $frompage) {

        $breadcrumb = array();
        if ($vacancy_id != "" && $frompage != "") {


            $vacancy = $this->m_vacancy->get($vacancy_id);
            $client = $this->m_client->get($vacancy["cmpyclient_id"]);

            $site_url = site_url();

            switch ($frompage) {
                case "home":
                    $breadcrumb[] = array("link" => "$site_url/home/main_home", "text" => "Home");
                    break;
                case "allclient":
                    $breadcrumb[] = array("link" => "$site_url/hrsys/client/allclient", "text" => "All Client");
                    break;
                case "prospect":
                    $breadcrumb[] = array("link" => "$site_url/hrsys/client/prospect", "text" => "Prospect Client");
                    break;
                case "myclient":
                    $breadcrumb[] = array("link" => "$site_url/hrsys/client/myclient", "text" => "My Client");
                    break;
            }
            $breadcrumb[] = array("link" => "$site_url/hrsys/client/detclient/" . $client["cmpyclient_id"] . "/" . $frompage."/vacancies", "text" => $client["name"]);
            $breadcrumb[] = array("link" => "$site_url/hrsys/vacancy/contentVacancy/" . $vacancy["vacancy_id"] . "/" . $frompage, "text" => $vacancy["name"]);
        }
        return $breadcrumb;
    }
    
    public function maintenanceDoc($candidate_id = 0, $vacancy_id = "", $frompage = "") {
        $ds = DIRECTORY_SEPARATOR;
        $site_url=  site_url();
        
        $vacancy = $this->m_vacancy->get($vacancy_id);
        $breadcrumb = $this->setBreedcum($vacancy_id, $frompage);
        
        $folder=$this->dir_candidate . $candidate_id . $ds."doc".$ds;
        
        
        if (isset($_FILES["filedoc"]) && !empty($_FILES["filedoc"]) && cleanstr($_FILES["filedoc"]["name"]) != "") {
            $ds = DIRECTORY_SEPARATOR;
            $filename = $folder . $_FILES["filedoc"]["name"];
            $this->upload_file("filedoc", $filename);
        }
        
        $listFile=array();
        if (is_dir($folder)) {
            if ($dh = opendir($folder)) {
                while (($file = readdir($dh)) !== false) {                    
                    if(!is_dir($folder.$file))
                        $listFile[]=$file;
                }
                closedir($dh);
            }
        }

        $candidate = $this->m_candidate->get($candidate_id);
        $breadcrumb[] = array("link" => "$site_url/hrsys/candidate/listCandidate/$vacancy_id/$frompage", "text" => "Search Candidate");
        $breadcrumb[] = array("link" => "$site_url/hrsys/candidate/detcandidate/$candidate_id/$vacancy_id/$frompage", "text" => $candidate["name"]);
        $breadcrumb[] = array("link" => "$site_url/hrsys/candidate/maintenanceDoc/$candidate_id/$vacancy_id/$frompage", "text" => "Maintenance DOC");

        $dataParse = array(
            "candidate"=>$candidate,
            "vacancy_id"=>$vacancy_id,
            "vacancy"=>$vacancy,
            "frompage"=>$frompage,    
            "breadcrumb"=>$breadcrumb,
            "listFile"=>$listFile
           
        );
        $this->loadContent('hrsys/candidate/maintenanceDoc', $dataParse);
    }
    public function deleteDoc($filename,$candidate_id, $vacancy_id = "", $frompage = "") {
        $ds = DIRECTORY_SEPARATOR;
        $site_url=  site_url();
        $filepath=$this->dir_candidate . $candidate_id . $ds."doc".$ds.$filename;        
        if(file_exists($filepath)) unlink($filepath);
        
        redirect("hrsys/candidate/maintenanceDoc/$candidate_id/$vacancy_id/$frompage");
        
    }
    public function downloadCV($candidate_id) {
        $ds = DIRECTORY_SEPARATOR;
        $site_url=  site_url();
        $filepath=$this->dir_candidate . $candidate_id . $ds."main_cv.pdf"; 
        
        $candidate=$this->m_candidate->get($candidate_id);
        
        $filename=  str_replace(" ", "_", $candidate["name"].".pdf");
        /*
        header("Content-type: ".mime_content_type($filepath)); 
        header("Content-disposition: attachment; filename=cv_".$filename);        
		*/
		header("Content-Description: File Transfer"); 
		header("Content-Type: application/octet-stream"); 
		 header("Content-disposition: attachment; filename=cv_".$filename); 
        readfile($filepath);          
        exit();
        
        
    }
    
    public function downloadDoc($filename,$candidate_id) {
        $ds = DIRECTORY_SEPARATOR;
        $site_url=  site_url();
        $filepath=$this->dir_candidate . $candidate_id . $ds."doc".$ds.$filename; 
        
       header("Content-Description: File Transfer"); 
		header("Content-Type: application/octet-stream"); 
        header("Content-disposition: attachment; filename=$filename");                             
        readfile($filepath);          
        exit();
        
        
    }

	public function detailTrail($candidate_trl_id)
	{
		$candidateTrl=$this->m_candidate->getCandidateTrl($candidate_trl_id);
		switch ($candidateTrl["type"]) {
			case "vacancy_trl_id":
				redirect("hrsys/vacancy/detailTrail/".$candidateTrl["value"]);
			break;
        }
		   
	
		exit;
	}
    

}

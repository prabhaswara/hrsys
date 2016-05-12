<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_vacancy extends Main_Model {

   

    function __construct() {
        parent::__construct();
    }
    
    function listOpenVacancy($employee_code,$user_id,$selectAll){
        
        $dataReturn=array();
        if($selectAll){
            $dataReturn=$this->db
                    ->where("status","1")
                    ->order_by("name")
                    ->get("hrsys_vacancy")->row_array();
        }else{
            $sql="select v.* from hrsys_vacancy v left join "
                ."hrsys_vacancyuser vc on vc.vacancy_id=v.vacancy_id and vc.user_id='$user_id' "
                ."where v.account_manager='$employee_code' or vc.user_id is not null ";
            $dataReturn = $this->db->query($sql)->result_array();
        }       
      
        return $dataReturn;
    }
    
    function get($id){
        return $this->db->where("vacancy_id",$id)->get("hrsys_vacancy")->row_array();
    }
    
    function getVCIdName($vacancy_id){
        $sql="select c.candidate_id id,c.name text from hrsys_vacancycandidate vc ".
             "join hrsys_candidate c on vc.candidate_id=c.candidate_id where vc.vacancy_id='$vacancy_id' order by c.name asc";
        return $this->db->query($sql)->result_array();
    }
    function getInterview($trail_id){
        return $this->db->where("vacancy_trl_id",$trail_id)->get("hrsys_vac_interview")->row_array();
    }
	function getOfferingSalary($trail_id){
        return $this->db->where("vacancy_trl_id",$trail_id)->get("hrsys_vac_offeringsallary")->row_array();
    }
	function getPlacemented($trail_id){
        return $this->db->where("vacancy_trl_id",$trail_id)->get("hrsys_vac_placemented")->row_array();
    }
	
    function getClientNmVacNm($vacancy_id)
	{
		$sql="select vac.name vacancy_name,cli.name client_name from hrsys_vacancy vac join hrsys_cmpyclient cli on vac.cmpyclient_id= cli.cmpyclient_id where vac.vacancy_id='$vacancy_id'";
		 return $this->db->query($sql)->row_array();
	}
    
    function getDetails($id){
        $dataReturn=array();
        
        $sql="select vc.*,emp.fullname emp_am, lk.display_text status_text,lksex.display_text sex_text from hrsys_vacancy vc  ".
             "left join tpl_lookup lk on lk.type='vacancy_stat' and vc.status=lk.value ".
             "left join tpl_lookup lksex on lksex.type='sex' and vc.sex=lksex.value ".
             "left join hrsys_employee emp on vc.account_manager=emp.id ".
             "where vc.vacancy_id='$id'";
        
        //$vacancy= $this->db->query($sql)->row_array();
        
       // $dataReturn["vacancy"]= $vacancy;
  
        
        return $this->db->query($sql)->row_array();
        
    }
   
    public function updateVacancyTrl($action,$postData, $sessionData) {
		
		$trailData=$postData['frm'];
		
		$updateCurrentTrl=array(
			"applicant_stat_next"=>$trailData["applicant_stat_next"],
			"description"=>$trailData["description"]
		);
		$currentTrl=$this->getVacancyTrl($trailData["trl_id"]);
		$vacancycandidate_id=$currentTrl["vacancycandidate_id"];		
		
		$vacancycandidate=$this->getVacancyCandidateByid($vacancycandidate_id);
		$vacancy=$this->get($vacancycandidate["vacancy_id"]);
		$dataVacCandUpdate=array();			
	
		if($action=="nextProcess")
		{
			$updateCurrentTrl["active_non"]=0;
		}
		
		$this->db->trans_start(TRUE);
		$this->db->set('dateupdate', 'NOW()', FALSE);
        $this->db->set('userupdate', $sessionData["user"]["user_id"]);          
        $this->db->update('hrsys_vacancy_trl', $updateCurrentTrl,array('trl_id'=>$trailData["trl_id"]));
		
	
		switch ($currentTrl["applicant_stat_id"]) {
			case applicant_stat_processinterview:	
		
				$temp=$postData['interview'];			
				$dataInterview["type"]=$temp["type"];					
				if($temp["schedule_d"]!=""){
					$dataInterview["schedule"]=  balikTgl($temp["schedule_d"]).($temp["schedule_t"]!=""?" ".$temp["schedule_t"]:"");
				}
				if(empty($this->db->where("vacancy_trl_id",$trailData['trl_id'])->get("hrsys_vac_interview")->row_array()))
				{
					$dataInterview["vacancy_trl_id"]=$trailData['trl_id'];	
					$this->db->insert('hrsys_vac_interview', $dataInterview);
				}else{						
					$this->db->update('hrsys_vac_interview', $dataInterview,array('vacancy_trl_id'=>$trailData['trl_id']));
				
				}
				
				if(isset($postData['interview']["remider"]))
				{
					$scheduleData=$this->db->where(array("type"=>"interview","value"=>$trailData['trl_id']))->get("hrsys_schedule")->row_array();
					$schedule_id="";
					if(empty($scheduleData)){
						//insert schedule
						$schedule_id=$this->generateID("schedule_id", "hrsys_schedule");
						$this->db->set('dateupdate', 'NOW()', FALSE);
						$this->db->set('userupdate', $sessionData["user"]["user_id"]);
						$this->db->set('datecreate', 'NOW()', FALSE);
						$this->db->set('usercreate', $sessionData["user"]["user_id"]);
						$scheduleData["description"]=$postData['interview']["remider_desc"];
						$scheduleData["scheduletime"]=$dataInterview["schedule"];  
						$scheduleData["schedule_id"]=$schedule_id;
						$scheduleData["type"] = "interview";
						$scheduleData["value"] = $trailData['trl_id'];                       
            
						$this->db->insert('hrsys_schedule', $scheduleData);
						
					}else{
						$this->db->set('dateupdate', 'NOW()', FALSE);
						$this->db->set('userupdate', $sessionData["user"]["user_id"]);
						$scheduleData["description"]=$postData['interview']["remider_desc"];
						$scheduleData["scheduletime"]=$dataInterview["schedule"];           
						$this->db->update('hrsys_schedule', $scheduleData, array('value' => $trailData['trl_id'],'type'=>'interview'));
						$schedule_id=$scheduleData["schedule_id"];
					}
					$this->db->delete( 'hrsys_scheduleuser', array( 'schedule_id' => $schedule_id ) );
				
					$this->db->insert('hrsys_scheduleuser', array( 'schedule_id' => $schedule_id,'user_id'=>$this->sessionUserData["employee"]["id"] )); 
					
				
				}
				else{
					$schedule=$this->db->where(array("type"=>"interview","value"=>$trailData['trl_id']))->get("hrsys_schedule")->row_array();
					if(!empty($schedule))
					{
						$this->db->delete( 'hrsys_scheduleuser', array( 'schedule_id' => $schedule["schedule_id"] ) );
						$this->db->delete( 'hrsys_schedule', array( 'schedule_id' => $schedule["schedule_id"]  ) );
			
					}
					
				}
			break;		
			case applicant_stat_offeringsalary:	
				$dataOffering=$postData['offeringsalary'];							
				
				
				if(empty($this->db->where("vacancy_trl_id",$trailData['trl_id'])->get("hrsys_vac_offeringsallary")->row_array()))
				{
					$dataOffering["vacancy_trl_id"]=$trailData['trl_id'];	
					$this->db->insert('hrsys_vac_offeringsallary', $dataOffering);
				}else{						
					$this->db->update('hrsys_vac_offeringsallary', $dataOffering,array('vacancy_trl_id'=>$trailData['trl_id']));
				
				}
				
				$this->db->set('dateupdate', 'NOW()', FALSE);
				$this->db->set('userupdate', $sessionData["user"]["user_id"]);
				$this->db->update('hrsys_vacancycandidate', array(
				"expectedsalary"=>$dataOffering["expected_salary"],
				"expectedsalary_ccy"=>$dataOffering["expected_ccy"]
				),array('vacancycandidate_id'=>$vacancycandidate_id));
			
				$this->db->set('dateupdate', 'NOW()', FALSE);
				$this->db->set('userupdate', $sessionData["user"]["user_id"]);
				$this->db->update('hrsys_candidate', array(
				"expectedsalary"=>$dataOffering["expected_salary"],
				"expectedsalary_ccy"=>$dataOffering["expected_ccy"]
				),array('candidate_id'=>$vacancycandidate["candidate_id"]));
				
				$dataVacCandUpdate["expectedsalary"]=$dataOffering["expected_salary"];
				$dataVacCandUpdate["expectedsalary_ccy"]=$dataOffering["expected_ccy"];
					
			break;
			
			case applicant_stat_placemented:	
				$dataPlacemented=$postData['placemented'];							
				
				if($dataPlacemented["date_join"]!=""){
					$dataPlacemented["date_join"]=  balikTgl($dataPlacemented["date_join"]);
				}				
				if(empty($this->db->where("vacancy_trl_id",$trailData['trl_id'])->get("hrsys_vac_placemented")->row_array()))
				{
					$dataPlacemented["vacancy_trl_id"]=$trailData['trl_id'];	
					$this->db->insert('hrsys_vac_placemented', $dataPlacemented);
				}else{						
					$this->db->update('hrsys_vac_placemented', $dataPlacemented,array('vacancy_trl_id'=>$trailData['trl_id']));

				}
				
				if($action=="closeProcess"){
		
					$dataVacCandUpdate["approvedsalary"]=$dataPlacemented["salary"];
					$dataVacCandUpdate["approvedsalary_ccy"]=$dataPlacemented["salary_ccy"];
					$dataVacCandUpdate["date_join"]=$dataPlacemented["date_join"];
					$dataVacCandUpdate["closed"]=1; 						
				}
				
			break;
		}
		

		if($action=="nextProcess" ){
			$this->load->model('m_client');
			
			//vacancy process
			$vacancy_trl_id=$this->generateID("trl_id", "hrsys_vacancy_trl");
			$this->db->set('datecreate', 'NOW()', FALSE);
			$this->db->set('usercreate', $sessionData["user"]["user_id"]);
			$this->db->set('dateupdate', 'NOW()', FALSE);
			$this->db->set('userupdate', $sessionData["user"]["user_id"]);
			$this->db->insert('hrsys_vacancy_trl', array(
				"trl_id"=>$vacancy_trl_id,
				"vacancycandidate_id"=>$vacancycandidate_id,       
				"applicant_stat_id"=>$updateCurrentTrl["applicant_stat_next"],
				"order_num"=>($currentTrl["order_num"]+1),
				"active_non"=>1
				
			));
			
			
			
			//candidate history
			$vacancycandidate=$this->db
				->where("vacancycandidate_id",$vacancycandidate_id)
				->get("hrsys_vacancycandidate")->row_array();			
			$vacancy=$this->get($vacancycandidate["vacancy_id"]);
            $client=$this->m_client->get($vacancy["cmpyclient_id"]);
			
			$description="";
			switch ($updateCurrentTrl["applicant_stat_next"]) {
				case applicant_stat_processinterview:				
					$description="Processs Of Interview: Vacancy=".$vacancy["name"].",Client=".$client["name"];
							
				break;
				case applicant_stat_processtoclient:
					$description="Processs To Client: Vacancy=".$vacancy["name"].",Client=".$client["name"];
				break;
				case applicant_stat_offeringsalary:
					$description="Offering Salary: Vacancy=".$vacancy["name"].",Client=".$client["name"];
				break;
				case applicant_stat_rejectedfromcandidate:
					$description="Candidate Rejected: Vacancy=".$vacancy["name"].",Client=".$client["name"];
				break;
				case applicant_stat_rejectedfromclient:
					$description="Client Rejected Candidate: Vacancy=".$vacancy["name"].",Client=".$client["name"];
				break;
				case applicant_stat_notqualified:
					$description="Not Qualified : Vacancy=".$vacancy["name"].",Client=".$client["name"];
				break;
				case applicant_stat_placemented:
					$description="Placemented : Vacancy=".$vacancy["name"].",Client=".$client["name"];
				break;
					
			}
			
			$this->db->set('datecreate', 'NOW()', FALSE);
			$this->db->set('usercreate', $sessionData["user"]["user_id"]);
			$this->db->set('dateupdate', 'NOW()', FALSE);
			$this->db->set('userupdate', $sessionData["user"]["user_id"]);
			$this->db->insert('hrsys_candidate_trl', array(
				"candidate_trl_id"=>$this->generateID("candidate_trl_id", "hrsys_candidate_trl"),
				"candidate_id"=>$vacancycandidate["candidate_id"],       
				"vacancy_id"=>$vacancycandidate["vacancy_id"],
				"applicant_stat"=>$updateCurrentTrl["applicant_stat_next"],
				"type"=>"vacancy_trl_id",
				"value"=>$vacancy_trl_id,
				"description"=>$description
			  )); 

			
			
			$dataVacCandUpdate["applicant_stat"]=$updateCurrentTrl["applicant_stat_next"];
		}
		//update vacancy candidate
			
			
		$this->db->set('dateupdate', 'NOW()', FALSE);
        $this->db->set('userupdate', $sessionData["user"]["user_id"]);
		$this->db->update('hrsys_vacancycandidate',$dataVacCandUpdate ,
		array('vacancycandidate_id' => $vacancycandidate_id));  

		$this->db->trans_complete();
        return $this->db->trans_status();
		
	}
	
    public function saveOrUpdate($data, $sessionData) {
        
        $vacancy=$data["vacancy"];
        $shareMaintance=$data["shareMaintance"]; 
        $expertise=$data["expertise"]; 
        
        $userInsert = (isset($sessionData["employee"]["fullname"]) && !empty($sessionData["employee"]["fullname"])) ? $sessionData["employee"]["fullname"] :
        $sessionData["user"]["username"];
        
        $vacancy_id = $vacancy["vacancy_id"];    
        $this->db->trans_start(TRUE);

        if($vacancy["opendate"]!=""){
            $vacancy["opendate"]=  balikTgl($vacancy["opendate"]);
        }
       
        if($vacancy_id==""){
            // insert vacancy
            $vacancy_id=$this->generateID("vacancy_id","hrsys_vacancy");
            $vacancy["vacancy_id"]=$vacancy_id;
            $vacancy["status"]="1";
            $this->db->set('dateupdate', 'NOW()', FALSE);
            $this->db->set('userupdate', $sessionData["user"]["user_id"]);
            $this->db->set('datecreate', 'NOW()', FALSE);
            $this->db->set('usercreate', $sessionData["user"]["user_id"]);
            $this->db->insert('hrsys_vacancy', $vacancy);                
            
            
            // insert trail
            $dataTrl["cmpyclient_trl_id"] = $this->generateID("cmpyclient_trl_id","hrsys_cmpyclient_trl");
            $dataTrl["cmpyclient_id"] = $vacancy["cmpyclient_id"];
            $dataTrl["description"] = "Created Vacancy ".$vacancy["name"];
            $dataTrl["type"] = "vacancy";
            $dataTrl["value"] = $vacancy_id;
            
            $this->db->set('datecreate', 'NOW()', FALSE);
            $this->db->set('usercreate', $sessionData["user"]["user_id"]);
            $this->db->insert('hrsys_cmpyclient_trl', $dataTrl);
                    
        }else{
             // update vacancy   
            $this->db->set('dateupdate', 'NOW()', FALSE);
            $this->db->set('userupdate', $sessionData["user"]["user_id"]);
            $this->db->update('hrsys_vacancy', $vacancy, array('vacancy_id' => $vacancy_id));
           
           
            // update trail        
            $dataTrl["description"] = $userInsert." Create Vacancy ".$vacancy["name"];
            $this->db->update('hrsys_cmpyclient_trl', $dataTrl, array('value' => $vacancy_id,'type'=>'vacancy'));       
             
        }
        
        $this->db->delete( 'hrsys_vacancyuser', array( 'vacancy_id' => $vacancy_id ) );        
        $this->db->insert('hrsys_vacancyuser', array( 'vacancy_id' => $vacancy_id,'user_id'=>$sessionData["user"]["user_id"] )); 
        if(!empty($shareMaintance)){
            foreach ($shareMaintance as $row){
                $this->db->insert('hrsys_vacancyuser', array( 'vacancy_id' => $vacancy_id,'user_id'=>$row["user_id"] )); 
            }            
        }     
        $this->db->delete( 'hrsys_vacancy_skill', array( 'vacancy_id' => $vacancy_id ) );
        if(!empty($expertise)){
            foreach ($expertise as $row){
                $this->db->insert('hrsys_vacancy_skill', array( 'vacancy_id' => $vacancy_id,'skill'=>$row["skill"])); 
            }            
        }     
        
        $this->db->trans_complete();

        return $this->db->trans_status();
    }
    
    
	public function validateProcess($post) {
        $return = array(
            'status' => true,
            'message' => array()
        );	
	
		
        if ($post["action"]=="nextProcess") {		          

            if (cleanstr($post["frm"]["applicant_stat_next"]) == "") {
			
	
                $return["status"] = false;
                $return["message"]["applicant_stat_next"] = "Next State cannot be empty";
            }
           
        }
        return $return;
    }
	
    public function validate($datafrm, $isEdit) {
        $return = array(
            'status' => true,
            'message' => array()
        );

        if (!empty($datafrm)) {

            if (cleanstr($datafrm["opendate"]) == "") {
                $return["status"] = false;
                $return["message"]["opendate"] = "Open Date cannot be empty";
            }
            if (cleanstr($datafrm["name"]) == "") {
                $return["status"] = false;
                $return["message"]["name"] = "Job Name cannot be empty";
            }
            if (cleanstr($datafrm["account_manager"]) == "") {
                $return["status"] = false;
                $return["message"]["account_manager"] = "PIC cannot be empty";
            }
            
        }

        return $return;
    }
    function getHeaderTrail($vacancycandidate){
        $sql="select lk.display_text as state from hrsys_vacancy_trl trl join tpl_lookup lk on trl.applicant_stat_id=lk.value and lk.type='applicant_stat' " ;
        return $this->db->query($sql)->result_array();
        
    }
    function getActiveTrlByVacCan($vacancy_id,$candidate_id){
        $sql="select trl.* from hrsys_vacancycandidate vc, hrsys_vacancy_trl trl where ".
             "vc.vacancy_id='$vacancy_id' and vc.candidate_id='$candidate_id' ".
             "and trl.vacancycandidate_id=vc.vacancycandidate_id and active_non=1  ";
         return $this->db->query($sql)->row_array();
    }
    function  getVacancyTrl($trl_id){
        return $this->db->where("trl_id",$trl_id)->get("hrsys_vacancy_trl")->row_array();
    }
    function getVacancyCandidate($vacancy_id,$candidate_id){
        $sql="select vc.*,lk.display_text applicant_stat_t from hrsys_vacancycandidate vc ".
             "join tpl_lookup lk on vc.applicant_stat=lk.value and lk.type='applicant_stat' where vc.vacancy_id ='$vacancy_id' and  vc.candidate_id ='$candidate_id' ";
        $data= $this->db->query($sql)->row_array();
		
		return $data;
	}
    
    function getVacancyCandidateByid($vacancycandidate_id ){
        
        $sql="select vc.*,lk.display_text applicant_stat_t from hrsys_vacancycandidate vc ".
             "join tpl_lookup lk on vc.applicant_stat=lk.value and lk.type='applicant_stat' where vc.vacancycandidate_id='$vacancycandidate_id' ";
        $data= $this->db->query($sql)->row_array();
		
		return $data;
    }
    
	
    
    
    function listNextState($applicant_stat){
        $return=array();
        
        $sql="select lk.display_text,lk.value from hrsys_applicantstat_nxt vc  ".
             "join tpl_lookup lk on vc.applicant_stat_next=lk.value and lk.type='applicant_stat' ".
             "where vc.consultant_code='".$this->sessionUserData["employee"]["consultant_code"]."' and vc.applicant_stat_id='$applicant_stat'";
       
        $array= $this->db->query($sql)->result_array();        
       
        
        if(!empty($array))
        foreach($array as $row){          
            $return[$row["value"]]=$row["display_text"];
        }
     
        return $return;
        
        
    }
	
	function  listVacancyTrlByVC($vacancycandidate_id){
        return $this->db->where("vacancycandidate_id",$vacancycandidate_id)
		->order_by("order_num","desc")
		->get("hrsys_vacancy_trl")->result_array();
    }
	function deleteVancany($vacancy_id)
	{	
	
		$this->db->trans_start(TRUE);
        $this->db->delete( 'hrsys_cmpyclient_trl', array( 'type' => 'vacancy','value'=>$vacancy_id ) );
		$this->db->delete( 'hrsys_vacancy', array( 'vacancy_id' => $vacancy_id ) );
        $this->db->trans_complete();
	}
	
	function closeVancany($vacancy_id)
	{	
		$this->db->update('hrsys_vacancy', array("status"=>0), array('vacancy_id' => $vacancy_id));
			
	}
	
	
	
	
	function deleteVacantTrail($vacancy_trl_id)
	{
		$kembali="";
		$vacancyTrl=$this->getVacancyTrl($vacancy_trl_id);
		$vacancycandidate_id=$vacancyTrl["vacancycandidate_id"];
		
		$listVacancyTrl=$this->listVacancyTrlByVC($vacancycandidate_id);
		
		if(count($listVacancyTrl)==1 && $vacancyTrl["applicant_stat_id"]==applicant_stat_shortlist){
			//delete all
			$this->db->trans_start(TRUE);
			
			$this->db->delete( 'hrsys_vacancy_trl', array( 'trl_id' => $vacancy_trl_id ) );
			$this->db->delete( 'hrsys_candidate_trl', array( 'value' => $vacancy_trl_id,'type' => "vacancy_trl_id" ) );
			$this->db->delete( 'hrsys_vacancycandidate', array( 'vacancycandidate_id' => $vacancycandidate_id ) );
			
			$this->db->trans_complete();
	
			if($this->db->trans_status())
			{
				$kembali="delete_all";
			}
			
			
		}
		else if (count($listVacancyTrl)>1 ){
			// remove one 
			
			if($vacancyTrl["applicant_stat_id"]==applicant_stat_processinterview)
			{
				$this->db->delete( 'hrsys_schedule', array( 'value' => $vacancy_trl_id,'type' => "interview" ) );
			}
			
			$this->db->trans_start(TRUE);
			$this->db->delete( 'hrsys_vacancy_trl', array( 'trl_id' => $vacancy_trl_id ) );
			$this->db->delete( 'hrsys_candidate_trl', array( 'value' => $vacancy_trl_id,'type' => "vacancy_trl_id" ) );
			
			 // update trail        
			$this->db->set('dateupdate', 'NOW()', FALSE);
            $this->db->set('userupdate', $sessionData["user"]["user_id"]);
            $this->db->update('hrsys_vacancy_trl', array("active_non"=>"1"),array('trl_id' => $listVacancyTrl[1]["trl_id"]));       
            //update vacancy candidate
			$this->db->set('dateupdate', 'NOW()', FALSE);
            $this->db->set('userupdate', $sessionData["user"]["user_id"]);
			$this->db->update('hrsys_vacancycandidate', 
			array("applicant_stat"=>$listVacancyTrl[1]["applicant_stat_id"]),
			array('vacancycandidate_id' => $listVacancyTrl[1]["vacancycandidate_id"]));       
             
			
			$this->db->trans_complete();
	
			if($this->db->trans_status())
			{
				$kembali="remove_one";
			}
			
		
		}
		return $kembali;
	}
	
	function getExperties($vacancy_id){
        return $this->db->where("vacancy_id",$vacancy_id)->order_by("skill")->get("hrsys_vacancy_skill")->result_array();
    }
}

?>
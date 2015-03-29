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
class meeting extends Main_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('hrsys/m_meeting','hrsys/m_client','hrsys/m_employee', 'admin/m_lookup'));
    }
    
    public function infMeeting($client_id) {
     
        $client=$this->m_client->get($client_id);     
        if(!empty($_POST)&&$_POST["pg_action"]=="json"){
            if (isset($_POST["sort"]) && !empty($_POST["sort"])){
                foreach ($_POST["sort"] as $key => $value) {
                    $_POST["sort"][$key] = str_replace("_sp_", ".", $value);
                }                
            }else{
                $_POST["sort"][0]['direction'] ='desc';
                 $_POST["sort"][0]['field'] ='met.meettime'; 
            }


            if (isset($_POST["search"]) && !empty($_POST["search"]))
                foreach ($_POST["search"] as $key => $value) {
                    $_POST["search"][$key] = str_replace("_sp_", ".", $value);
                }
            
            $where="met.cmpyclient_id ='$client_id' and ";
            if(isset($_POST["typesearch"])&&$_POST["typesearch"]=="active"){
                $where.="( met.outcome ='' || met.outcome is null) and ";
            }

            $sql = "SELECT  met.meet_id recid,lktype.display_text lktype_sp_display_text, " .
                   "met.description met_sp_description, DATE_FORMAT(met.meettime,'%d-%m-%Y %H:%i') met_sp_meettime, ".
                   "lkout.display_text lkout_sp_display_text,met.outcome_desc met_sp_outcome_desc, met.usercreate met_sp_usercreate ".
                    ",DATEDIFF(date(met.meettime),date(now())) datediff ".
                   "from hrsys_cmpyclient_meet met " .
                   "left join tpl_lookup lktype on lktype.type='meet_type' and met.type=lktype.value " .
                   "left join tpl_lookup lkout on lkout.type='meet_outcome' and met.outcome=lkout.value " .
                   "WHERE ~search~ and $where 1=1 ORDER BY ~sort~";


            $data = $this->m_menu->w2grid($sql, $_POST);
            
            $dataReturn=array();
            foreach ( $data['records'] as $row){
                $row["canedit"]="0";                
                if( $client["account_manager"]==$this->user_id||$row["met_sp_usercreate"]==$this->user_id || in_array("hrsys_allmeeting", $this->ses_roles))
                {
                    $row["canedit"]="1";
                    
                }
                $row["lewat"]="0";
                        
                if(cleanstr($row["lkout_sp_display_text"])=="" && cleanstr($row["datediff"]) <0 ){
                    $row["lewat"]="1";
                }
                
                $dataReturn[]=$row;
            }
            $data['records']=$dataReturn;
            header("Content-Type: application/json;charset=utf-8");
            echo json_encode($data);
            exit();
        
        }
        $canedit = false;

        if ($client["account_manager"] == $this->emp_id || in_array("hrsys_allmeeting", $this->ses_roles)) {
            $canedit=true;
        }
        $dataParse = array(
            "client_id"=> $client_id,
            "canedit"=>$canedit
                );
        $this->loadContent('hrsys/meeting/infMeeting', $dataParse);
        
    }
    
    public function showDetail($meet_id){
        $dataMeet= $this->m_meeting->getDetails($meet_id);
        $shareSchedule=$this->m_employee->shareWithByMeet($meet_id,$dataMeet["usercreate"]);
        $type=cleanstr($dataMeet["type"])==""?"":$this->m_lookup->getDisplaytext("meet_type",$dataMeet["type"]);
        $outcome=cleanstr($dataMeet["outcome"])==""?"":$this->m_lookup->getDisplaytext("meet_outcome",$dataMeet["outcome"]);
        
        $dataEmp=$this->m_employee->getByUserId($dataMeet["usercreate"]);
      
        $dataParse = array(              
            "data"=>$dataMeet,
            "shareSchedule"=>$shareSchedule,              
            "type"=>$type,
            "outcome"=>$outcome,
            "createBy"=>isset($dataEmp["fullname"])?$dataEmp["fullname"]:"",
                );
        $this->loadContent('hrsys/meeting/showDetail', $dataParse);
    }
    public function delete($id){
        $this->m_meeting->delete($id);
    }
    public function showForm($client_id=0,$meet_id=0) {
     
        $postForm = isset($_POST['frm']) ? $_POST['frm'] : array();
        $postOutcome = isset($_POST['outcome']) ? $_POST['outcome'] : array();
        $postShareSchedule = isset($_POST['shareSchedule']) ? $this->m_employee->sharewith($_POST['shareSchedule'],$this->user_id) : array();
        
        $create_edit = "Edit";
        $isEdit = true;
        if ($meet_id == 0 ) {           
            $create_edit = "New";
            $isEdit = false;
             
        }
    

        $message = "";
        if (!empty($postForm) && $_POST["do"]=="schedule") {
            $validate = $this->m_meeting->validate($postForm, $isEdit);
            if ($validate["status"]) {
               $postForm["cmpyclient_id"]=$client_id;
                $dataSave["meeting"]=$postForm;
                $dataSave["shareWith"]=$postShareSchedule;
               
                if ($this->m_meeting->saveOrUpdate($dataSave, $this->sessionUserData)) {
                    echo "close_popup";
                    exit;
                }
            }

            $error_message = isset($validate["message"]) ? $validate["message"] : array();
            if (!empty($error_message)) {
                $message = showMessage($error_message);
            }
        }
        
        if (!empty($postOutcome) && $_POST["do"] == "outcome") {
            if ($this->m_meeting->updateOutCome($postOutcome, $this->sessionUserData)) {
                echo "close_popup";
                exit;
            }
        }

        if($isEdit){
           
            $dataMeet= $this->m_meeting->get($meet_id);
            if( empty($postForm)){
                $postForm=$dataMeet;
                if(cleanstr($postForm["meettime"])!=""){
                    $meettime=  explode(" ",balikTglDate($postForm["meettime"], true,false)) ;                

                    $postForm["meettime_d"]=$meettime[0];
                    $postForm["meettime_t"]=$meettime[1];
                    if($postForm["meettime_t"]=="00:00"){
                        $postForm["meettime_t"]="";
                    }
                }
            }
            if(empty($postOutcome)){
                $postOutcome=$dataMeet;
            }
            if(empty($postShareSchedule)){                
                $postShareSchedule=$this->m_employee->shareWithByMeet($meet_id,$dataMeet["usercreate"]);
            }
            
        }
        $typeList = $this->m_lookup->comboLookup("meet_type");
        $outcomeList = $this->m_lookup->comboLookup("meet_outcome");
        $timeList = array(""=>"")+$this->m_lookup->comboTime();
        $client = $this->m_client->get($client_id);    
        $dataParse = array(
            "isEdit"=>$isEdit,
            "message"=>$message,
            "postForm"=>$postForm,
            "postShareSchedule"=>$postShareSchedule,
            "postOutcome"=>$postOutcome,
            "client"=> $client,
            "timeList"=>$timeList,
            "typeList"=> $typeList,
            'outcomeList'=>$outcomeList
                );
        $this->loadContent('hrsys/meeting/showform', $dataParse);
        
    }
    
    public function json_nextmeeting($user_id){
        if (!isset($_POST["sort"])){            
                 $_POST["sort"][0]['direction'] ='asc';
                 $_POST["sort"][0]['field'] ='met.meettime';      
            }
            
         $sql = "select met.meet_id recid,met.outcome,CONCAT(DAYNAME(met.meettime),CONCAT(', ', DATE_FORMAT(met.meettime,'%d-%m-%Y %H:%i'))) meetime ".
                ",DATEDIFF(date(met.meettime),date(now())) datediff,met.description,met.person,met.place,client.name client from hrsys_cmpyclient_meet met ".
                "join hrsys_cmpyclient client on met.cmpyclient_id=client.cmpyclient_id ".
                "join hrsys_schedule sch on sch.type='meeting' and sch.value=met.meet_id ".
                "join hrsys_scheduleuser schuser on sch.schedule_id=schuser.schedule_id ".
                "WHERE ( met.outcome ='' || met.outcome is null) and schuser.user_id='$user_id'  and ~search~ ORDER BY ~sort~";


            $data = $this->m_menu->w2grid($sql, $_POST);
            
            $dataReturn=array();
            foreach ( $data['records'] as $row){
                
                $row["lewat"]="0";
                        
                if(cleanstr($row["outcome"])=="" && $row["datediff"] <0 ){
                    $row["lewat"]="1";
                }
                
                $dataReturn[]=$row;
            }
            $data['records']=$dataReturn;
            header("Content-Type: application/json;charset=utf-8");
            echo json_encode($data);
            exit();
    }
   
  
}

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
     
        if(!empty($_POST)&&$_POST["pg_action"]=="json"){
            if (isset($_POST["sort"]) && !empty($_POST["sort"]))
            foreach ($_POST["sort"] as $key => $value) {
                $_POST["sort"][$key] = str_replace("_sp_", ".", $value);
            }


            if (isset($_POST["search"]) && !empty($_POST["search"]))
                foreach ($_POST["search"] as $key => $value) {
                    $_POST["search"][$key] = str_replace("_sp_", ".", $value);
                }
            
            $where="met.cmpyclient_id ='$client_id' ";

            $sql = "SELECT  met.meet_id recid,lktype.display_text lktype_sp_display_text, " .
                   "met.description met_sp_description, DATE_FORMAT(met.meettime,'%d-%m-%Y %H:%i') met_sp_meettime, ".
                   "lkout.display_text lkout_sp_display_text,met.outcome_desc met_sp_outcome_desc ".
                   "from hrsys_cmpyclient_meet met " .
                   "left join tpl_lookup lktype on lktype.type='meet_type' and met.type=lktype.value " .
                   "left join tpl_lookup lkout on lkout.type='meet_outcome' and met.outcome=lkout.value " .
                   "WHERE ~search~ and $where  ORDER BY ~sort~";


            $data = $this->m_menu->w2grid($sql, $_POST);
            header("Content-Type: application/json;charset=utf-8");
            echo json_encode($data);
            exit();
        
        }
        $dataParse = array("client_id"=> $client_id);
        $this->loadContent('hrsys/meeting/infMeeting', $dataParse);
        
    }
    
    public function showForm($client_id=0,$meet_id=0) {
     
        $postForm = isset($_POST['frm']) ? $_POST['frm'] : array();
        $postShareSchedule = isset($_POST['shareSchedule']) ? $this->m_employee->sharewith($_POST['shareSchedule'],$this->user_id) : array();
        
        $create_edit = "Edit";
        $isEdit = true;
        if ($meet_id == 0 ) {           
            $create_edit = "New";
            $isEdit = false;
             
        }
    

        $message = "";
        if (!empty($postForm)) {
            $validate = $this->m_meeting->validate($postForm, $isEdit);
            if ($validate["status"]) {
               // echo "<pre>";  print_r($postForm);  exit;
                
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
        
        if($isEdit && empty($postForm)){
           
            $postForm= $this->m_meeting->get($meet_id);
            if(cleanstr($postForm["meettime"])!=""){
                $meettime=  explode(" ",balikTglDate($postForm["meettime"], true,false)) ;                
                
                $postForm["meettime_d"]=$meettime[0];
                $postForm["meettime_t"]=$meettime[1];
                if($postForm["meettime_t"]=="00:00"){
                    $postForm["meettime_t"]="";
                }
            }
            $postShareSchedule=$this->m_employee->shareWithByMeet($meet_id,$this->user_id);
            
        }
        $typeList = $this->m_lookup->comboLookup("meet_type");
        $timeList = array(""=>"")+$this->m_lookup->comboTime();
        $client = $this->m_client->get($client_id);    
        $dataParse = array(
            "isEdit"=>$isEdit,
            "message"=>$message,
            "postForm"=>$postForm,
            "postShareSchedule"=>$postShareSchedule,
            "client"=> $client,
            "timeList"=>$timeList,
            "typeList"=> $typeList
                );
        $this->loadContent('hrsys/meeting/showform', $dataParse);
        
    }
   
  
}

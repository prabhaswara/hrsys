<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_meeting extends Main_Model {

   

    function __construct() {
        parent::__construct();
    }
    
    function get($id){
        return $this->db->where("meet_id",$id)->get("hrsys_cmpyclient_meet")->row_array();
    }
    function getDetails($id){
        $sql="select met.*,c.name client_name from hrsys_cmpyclient_meet met  ".
             "left join hrsys_cmpyclient c on c.cmpyclient_id=met.cmpyclient_id ".
             "where met.meet_id='$id'";
        return $this->db->query($sql)->row_array();
        
    }
    
    public function updateOutCome($dataOutcome, $sessionData) {
        // update meeting   
        $return=false;
        $meet_id = $dataOutcome["meet_id"];
        unset($dataOutcome["meet_id"]);
        
        $this->db->set('dateupdate', 'NOW()', FALSE);
        $this->db->set('userupdate', $sessionData["user"]["user_id"]);
        $return=$this->db->update('hrsys_cmpyclient_meet', $dataOutcome, array('meet_id' => $meet_id));
        
       return $return;
        
    }

    public function saveOrUpdate($data, $sessionData) {
        
        $meeting=$data["meeting"];
        $shareWith=$data["shareWith"];      
        
        $meet_id = $meeting["meet_id"];    
        $this->db->trans_start(TRUE);

        if($meeting["meettime_d"]!=""){
            $meeting["meettime"]=  balikTgl($meeting["meettime_d"]).($meeting["meettime_d"]!=""?" ".$meeting["meettime_t"]:"");
        }
        unset($meeting["meettime_d"]);  
        unset($meeting["meettime_t"]); 
       
        $schedule_id="";
      
         
        if($meet_id==""){
            // insert meeting
            $meet_id=$this->generateID("meet_id", "hrsys_cmpyclient_meet");
            $meeting["meet_id"]=$meet_id;
            $this->db->set('dateupdate', 'NOW()', FALSE);
            $this->db->set('userupdate', $sessionData["user"]["user_id"]);
            $this->db->set('datecreate', 'NOW()', FALSE);
            $this->db->set('usercreate', $sessionData["user"]["user_id"]);
            $this->db->insert('hrsys_cmpyclient_meet', $meeting);    
            
            //insert schedule
            $schedule_id=$this->generateID("schedule_id", "hrsys_schedule");
            $this->db->set('dateupdate', 'NOW()', FALSE);
            $this->db->set('userupdate', $sessionData["user"]["user_id"]);
            $this->db->set('datecreate', 'NOW()', FALSE);
            $this->db->set('usercreate', $sessionData["user"]["user_id"]);
            $scheduleData["description"]=$meeting["description"];
            $scheduleData["scheduletime"]=$meeting["meettime"];  
            $scheduleData["schedule_id"]=$schedule_id;
            $scheduleData["type"] = "meeting";
            $scheduleData["value"] = $meet_id;
                        
            
            $this->db->insert('hrsys_schedule', $scheduleData);   
            
            // insert trail
            $dataTrl["cmpyclient_trl_id"] = $this->generateID("cmpyclient_trl_id", "hrsys_cmpyclient_trl");
            $dataTrl["cmpyclient_id"] = $meeting["cmpyclient_id"];
            $dataTrl["description"] = $meeting["description"];
            $dataTrl["type"] = "meeting";
            $dataTrl["value"] = $meet_id;
            
            $this->db->set('datecreate', 'NOW()', FALSE);
            $this->db->set('usercreate', $sessionData["user"]["user_id"]);
            $this->db->insert('hrsys_cmpyclient_trl', $dataTrl);
                    
        }else{
             // update meeting   
            $this->db->set('dateupdate', 'NOW()', FALSE);
            $this->db->set('userupdate', $sessionData["user"]["user_id"]);
            $this->db->update('hrsys_cmpyclient_meet', $meeting, array('meet_id' => $meet_id));
           
            // update schedule
            $this->db->set('dateupdate', 'NOW()', FALSE);
            $this->db->set('userupdate', $sessionData["user"]["user_id"]);
            $scheduleData["description"]=$meeting["description"];
            $scheduleData["scheduletime"]=$meeting["meettime"];            
            $this->db->update('hrsys_schedule', $scheduleData, array('value' => $meet_id,'type'=>'meeting'));
            
            
            
            $schedule_id=$this->db->where(array('value' => $meet_id,'type'=>'meeting'))->get("hrsys_schedule")->row()->schedule_id;
            
            // update trail        
            $dataTrl["description"] = $meeting["description"];
            $this->db->update('hrsys_cmpyclient_trl', $dataTrl, array('value' => $meet_id,'type'=>'meeting'));       
             
        }
        
        $this->db->delete( 'hrsys_scheduleuser', array( 'schedule_id' => $schedule_id ) );
        
        $this->db->insert('hrsys_scheduleuser', array( 'schedule_id' => $schedule_id,'user_id'=>$sessionData["user"]["user_id"] )); 
        if(!empty($shareWith)){
            foreach ($shareWith as $row){
                $this->db->insert('hrsys_scheduleuser', array( 'schedule_id' => $schedule_id,'user_id'=>$row["user_id"] )); 
            }            
        }
     
        
        $this->db->trans_complete();

        return $this->db->trans_status();
    }
    public function delete($meet_id ){
        $this->db->trans_start(TRUE);
        
        $this->db->delete( 'hrsys_cmpyclient_trl', array( 'type'=>'meeting','value' => $meet_id ) );        
        $sched=$this->db->where(array( 'type'=>'meeting','value' => $meet_id ))
                ->get("hrsys_schedule")->row_array();
        if(!empty($sched)){
           
            $this->db->delete( 'hrsys_scheduleuser', array( 'schedule_id' => $sched["schedule_id"] ) );
            $this->db->delete( 'hrsys_schedule', array( 'schedule_id' => $sched["schedule_id"] ) );
        }
        $this->db->delete( 'hrsys_cmpyclient_meet', array( 'meet_id' => $meet_id ) );
        $this->db->trans_complete();
    }
    
    public function validate($datafrm, $isEdit) {
        $return = array(
            'status' => true,
            'message' => array()
        );

        if (!empty($datafrm)) {

            if (cleanstr($datafrm["person"]) == "") {
                $return["status"] = false;
                $return["message"]["person"] = "Meet with cannot be empty";
            }
            if (cleanstr($datafrm["description"]) == "") {
                $return["status"] = false;
                $return["message"]["description"] = "Description cannot be empty";
            }
            if (cleanstr($datafrm["meettime_d"]) == "") {
                $return["status"] = false;
                $return["message"]["meettime_d"] = "Date cannot be empty";
            }
        }

        return $return;
    }

}

?>
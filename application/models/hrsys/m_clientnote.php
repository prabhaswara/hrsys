<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_clientnote extends Main_Model {

   

    function __construct() {
        parent::__construct();
    }
    
    function get($id){
        return $this->db->where("note_id",$id)->get("hrsys_cmpyclient_note")->row_array();
    }
    public function validate($datafrm, $isEdit) {
        $return = array(
            'status' => true,
            'message' => array()
        );

        if (!empty($datafrm)) {

            if (cleanstr($datafrm["description"]) == "") {
                $return["status"] = false;
                $return["message"]["description"] = "Cannot be empty";
            }
            
        }

        return $return;
    }
    
     public function saveOrUpdate($dataFrm,$sessionData){
        
        $return=false;
        $note_id=$dataFrm["note_id"];
        unset($dataFrm["note_id"]);
        
        $this->db->trans_start(TRUE);
        
        $this->db->set('datecreate', 'NOW()', FALSE);
        $this->db->set('usercreate', $sessionData["user"]["user_id"]);
        if($note_id==""||$note_id=="0"){
            
            $note_id=$this->generateID("note_id", "hrsys_cmpyclient_note");
            
            $dataFrm["note_id"]=$note_id;
            $this->db->insert('hrsys_cmpyclient_note', $dataFrm); 
            
            // insert trail
            $dataTrl["cmpyclient_trl_id"] = $this->generateID("cmpyclient_trl_id", "hrsys_cmpyclient_trl");
            $dataTrl["cmpyclient_id"] = $dataFrm["cmpyclient_id"];
            $dataTrl["description"] = $dataFrm["description"];
            $dataTrl["type"] = "note";
            $dataTrl["value"] = $note_id;
            
            $this->db->set('datecreate', 'NOW()', FALSE);
            $this->db->set('usercreate', $sessionData["user"]["user_id"]);
            
            $this->db->insert('hrsys_cmpyclient_trl', $dataTrl);
            
            
           }else{
             
           $this->db->set('dateupdate', 'NOW()', FALSE);
           $this->db->set('userupdate', $sessionData["user"]["user_id"]);            
           $this->db->update('hrsys_cmpyclient_note', $dataFrm, array('note_id' => $note_id));
          
        
           // update trail        
            $dataTrl["description"] =  $dataFrm["description"];
            $this->db->update('hrsys_cmpyclient_trl', $dataTrl, array(
                'value' => $note_id,'type'=>'note'));       
             
            
           }
           
        
        $this->db->trans_complete();

        return $this->db->trans_status();
        
    }
    
    function delete($note_id){
        $this->db->trans_start(TRUE);
        $this->db->delete( 'hrsys_cmpyclient_trl', array( 'type'=>'note','value' => $note_id ) ); 
        $this->db->delete( 'hrsys_cmpyclient_note', array( 'note_id' => $note_id ) );
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
   

}

?>
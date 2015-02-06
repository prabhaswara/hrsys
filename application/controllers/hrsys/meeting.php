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
        $this->load->model(array('hrsys/m_meeting','hrsys/m_client', 'admin/m_lookup'));
    }
    
    public function infMeeting($client_id) {
     
        $dataParse = array("client_id"=> $client_id);
        $this->loadContent('hrsys/meeting/infMeeting', $dataParse);
        
    }
    
    public function showForm($client_id) {
     
        $typeList = $this->m_lookup->comboLookup("meet_type");
        $timeList = $this->m_lookup->comboTime();
        
        $dataParse = array(
            "client_id"=> $client_id,
            "timeList"=>$timeList,
            "typeList"=> $typeList
                );
        $this->loadContent('hrsys/meeting/showform', $dataParse);
        
    }
   

    
}
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * control client
 * - general
 * - history client
 * - set meeting
 * - set vacancy
 * = set
 * @author prabhaswara
 */
class dashboard extends Main_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('hrsys/m_client','hrsys/m_employee', 'admin/m_lookup'));
    }
    
    public function myDasboard(){
        $dataParse=array();
        $this->loadContent('hrsys/dasboard/myDasboard', $dataParse);
    }
    public function executiveDasboard(){
        $dataParse=array();
        $this->loadContent('hrsys/dasboard/executiveDasboard', $dataParse);
    }
}

<?php

class Main_Controller extends CI_Controller {

    public $template = "w2layout";

    var $sessionUserData="";   
    var $username="";
    var $user_id="";
    var $emp_id="";
    var $ses_roles="";

    function __construct() {
       
        parent::__construct();
        if($this->session->userdata(SES_USERDT)==null){
             redirect("site/sessionexpired");
        }
        $this->sessionUserData=$this->session->userdata(SES_USERDT);
        $this->username=$this->sessionUserData["user"]["username"];
        $this->user_id=$this->sessionUserData["user"]["user_id"];
        $this->emp_id=isset($this->sessionUserData["employee"]["emp_id"])?$this->sessionUserData["employee"]["emp_id"]:"";
        $this->ses_roles=$this->sessionUserData["roles"];
        $this->load->helper('gn_frm','gn_str');
        $this->load->model('admin/m_menu');
        
    }

    function loadContent($content, $dataMain = array()) {
       
     
        $dataMain['ses_userdata'] = $this->sessionUserData["user"];
        $dataMain['ses_roles'] = $this->sessionUserData["roles"];
        
        $dataMain['base_url'] = base_url();
        $dataMain['site_url'] = site_url();
      
        $this->parser->parse($content, $dataMain);
    }
    
    function loadview($content, $dataContent = array()) {
       
        $dataContent['site_url'] = site_url();
        $dataContent['base_url'] = base_url();
        
        $dataMain['maincontent'] = $this->parser->parse($content, $dataContent, TRUE);
        $dataMain['base_url'] = base_url();
        $dataMain['site_url'] = site_url();
        
        $sessionUserData=$this->session->userdata(SES_USERDT);
        $dataMain['ses_userdata'] = $sessionUserData["user"];
        $dataMain['ses_roles'] = $sessionUserData["roles"];
        
        $sideMenu=$this->m_menu->strArrayMenuw2ui($this->m_menu->generateMenu($sessionUserData["roles"]));
        $sideMenu=  substr($sideMenu, 0,  strlen($sideMenu)-1);        
        $dataMain["sideMenu"]=$sideMenu;
        
        $this->parser->parse('template/' . $this->template, $dataMain);
    }

}

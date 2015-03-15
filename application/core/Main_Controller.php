<?php

class Main_Controller extends CI_Controller {

    public $template = "w2layout";

    var $sessionUserData="";   
    var $username="";
    var $user_id="";
    var $emp_id="";
    var $ses_roles="";
    var $dir_candidate;

    function mkpath($path)
    {
      if(@mkdir($path) or file_exists($path)) return true;
      return ($this->mkpath(dirname($path)) and mkdir($path, 0755, true));
    }
    function upload_file($name,$filepath){
        $ds=DIRECTORY_SEPARATOR;
        
        $array=  explode($ds, $filepath);
        array_pop($array );
        $path=  implode($ds, $array);
        
        $this->mkpath($path);
        if(file_exists($filepath)) unlink($filepath);
        if(move_uploaded_file($_FILES[$name]['tmp_name'], $filepath)) {
           return true;
        } else{
           return false;
        }
        
    }
    
    function __construct() {
       
        parent::__construct();
        if($this->session->userdata(SES_USERDT)==null){
             redirect("site/sessionexpired");
        }
        
        $ds=DIRECTORY_SEPARATOR;
        $this->dir_candidate="fl".$ds."candidates".$ds;
                
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

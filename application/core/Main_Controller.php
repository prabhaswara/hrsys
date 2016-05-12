<?php

class Main_Controller extends CI_Controller {

    public $template = "w2layout";

    var $sessionUserData="";   
    var $username="";
    var $user_id="";
    var $employee_code="";
	var $employee_id="";	
    var $ses_roles="";
    var $dir_candidate;
    var $site_candidate;
    var $dir_client;
    var $site_client;
	var $dir_template;
	var $site_template;
	
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
    
	function uploadResizeImage($img_name,$new_image,$maxwidth=100){
		$this->load->library('image_lib');
		list($width, $height) = getimagesize($_FILES[$img_name]['tmp_name']);
		
		if($width >= $maxwidth)
		{
			$ratio=$maxwidth/$width;
			$height=ceil($height*$ratio);
			$width=$maxwidth;
			
		}else if($height >= $maxwidth)
		{
			$ratio=$maxwidth/$height;
			$width=ceil($width*$ratio);
			$height=$maxwidth;
		}
		$config['image_library'] = 'gd2';
		$config['source_image']  = $_FILES[$img_name]['tmp_name'];
		$config['new_image'] = $new_image;		
		$config['width']  = $width;
		$config['height']    = $height;
		$this->image_lib->initialize($config);
	
		if($this->image_lib->resize()) return true;
		else return false;
	}

    function __construct() {
      
        parent::__construct();
		
        if($this->session->userdata(SES_USERDT)==null){
             redirect("site/sessionexpired");
        }
		$this->sessionUserData=$this->session->userdata(SES_USERDT);

        
        $ds=DIRECTORY_SEPARATOR;
        $this->dir_candidate="fl".$ds.$this->sessionUserData["employee"]["consultant_code"].$ds."candidates".$ds;
        $this->site_candidate= base_url()."fl/".$this->sessionUserData["employee"]["consultant_code"]."/candidates/";
        
        $this->dir_client="fl".$ds.$this->sessionUserData["employee"]["consultant_code"].$ds."client".$ds;
        $this->site_client= base_url()."fl/".$this->sessionUserData["employee"]["consultant_code"]."/client/";
        

		$this->dir_template="fl".$ds.$this->sessionUserData["employee"]["consultant_code"].$ds."template".$ds;
        $this->site_template= base_url()."fl/".$this->sessionUserData["employee"]["consultant_code"]."/template/";
         
        
        $this->username=$this->sessionUserData["user"]["username"];
        $this->user_id=$this->sessionUserData["user"]["user_id"];
        $this->employee_code=isset($this->sessionUserData["employee"]["employee_code"])?$this->sessionUserData["employee"]["employee_code"]:"";
        $this->employee_id=isset($this->sessionUserData["employee"]["id"])?$this->sessionUserData["employee"]["id"]:"";
        
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

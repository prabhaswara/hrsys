<?php

class site extends CI_Controller {

    public $template = "w2layout";
    
    public function __construct() {
        parent::__construct();
        $this->load->model('admin/m_menu');
    }
    public function sessionexpired()
    {
        echo "session expired";
    }

    public function redirect($menu_id) {
        $menu = $this->m_menu->get($menu_id);
        if (isset($menu['url']) && cleanstr($menu['url']) != "") {
            redirect($menu['url']);
        }
    }
 
     
    public function index() {       
      
        $dataContent['site_url'] = site_url();
        $dataContent['base_url'] = base_url();
        
        $dataMain['maincontent'] = $this->parser->parse("home", $dataContent, TRUE);
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

?>
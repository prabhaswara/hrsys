<?php

class home extends Main_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/m_menu');
    }

    public function redirect($menu_id) {
        $menu = $this->m_menu->get($menu_id);
        if (isset($menu['url']) && cleanstr($menu['url']) != "") {
            redirect($menu['url']);
        }
    }

    public function main_home(){
        $this->loadContent('home');
    }
    public function index() {
       
      
        $this->loadview('home');
    }
    
    

}

?>
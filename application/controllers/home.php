<?php

class home extends Main_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/m_menu');
    }

    
    

    public function main_home(){
        $this->loadContent('home');
    }
    public function index() {         
       exit;
    }
    
    

}

?>
<?php

class home extends Main_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/m_menu');
    }

    
    

    public function main_home(){
        $params=array(
            "user_id"=>$this->user_id,
            "emp_id"=>$this->emp_id
        );
        $this->loadContent('home',$params);
    }
    public function index() {         
       exit;
    }
    
    

}

?>
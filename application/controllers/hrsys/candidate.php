<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @author prabhaswara
 */
class candidate extends Main_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('admin/m_lookup', "hrsys/m_candidate", "hrsys/m_vacancy", "hrsys/m_client"));
    }

    public function addEditCandidate($candidate_id = 0, $vacancy_id = "", $frompage = "") {
        $postForm = isset($_POST['frm']) ? $_POST['frm'] : array();
        $message="";
        $create_edit = "Edit";
        $isEdit = true;
        if ($candidate_id == 0 ) {           
            $create_edit = "New";
            $isEdit = false;
             
        }
        $vacancy=$this->m_vacancy->get($vacancy_id);
        $breadcrumb=$this->setBreedcum($vacancy_id, $frompage);
        
        $breadcrumb[] = array("link" => "#", "text" => "$create_edit Candidate");
        
        if (!empty($postForm)) {
            $validate = $this->m_candidate->validate($postForm, $isEdit);
            if ($validate["status"]) {
                $dataSave["candidate"]=$postForm;
                $dataSave["vacancy_id"]=$vacancy_id;
                
                if ($this->m_candidate->saveOrUpdate($dataSave, $this->sessionUserData)) {
                  
                    if($frompage==""){
                        redirect("hrsys/candidate/addEditCandidate/");
                    }
                    else{
                        redirect("hrsys/vacancy/contentVacancy/$vacancy_id/$frompage");
                    }
                    exit;
                }
                else{
                    echo "wew";exit;
                }
            }

            $error_message = isset($validate["message"]) ? $validate["message"] : array();
            if (!empty($error_message)) {
                $message = showMessage($error_message);
            }
            
          
        }
        
        if (empty($postForm) && !$isEdit){
            
        }
        
            
        $dataParse = array(
            "message"=>$message,
            "isEdit"=>$isEdit,
            "postForm"=>$postForm,
            "vacancy_id"=>$vacancy_id,
            "vacancy"=>$vacancy,
            "frompage"=>$frompage,    
            "breadcrumb"=>$breadcrumb,
        );
        $this->loadContent('hrsys/candidate/addEditCandidate', $dataParse);
    }

    private function setBreedcum($vacancy_id, $frompage) {

        $breadcrumb = array();
        if ($vacancy_id != "" && $frompage != "") {


            $vacancy = $this->m_vacancy->get($vacancy_id);
            $client = $this->m_client->get($vacancy["cmpyclient_id"]);

            $site_url = site_url();

            switch ($frompage) {
                case "home":
                    $breadcrumb[] = array("link" => "$site_url/home/main_home", "text" => "Home");
                    break;
                case "allclient":
                    $breadcrumb[] = array("link" => "$site_url/hrsys/client/allclient", "text" => "All Client");
                    break;
                case "prospect":
                    $breadcrumb[] = array("link" => "$site_url/hrsys/client/prospect", "text" => "Prospect Client");
                    break;
                case "myclient":
                    $breadcrumb[] = array("link" => "$site_url/hrsys/client/myclient", "text" => "My Client");
                    break;
            }
            $breadcrumb[] = array("link" => "$site_url/hrsys/client/detclient/" . $client["cmpyclient_id"] . "/" . $frompage, "text" => $client["name"]);
            $breadcrumb[] = array("link" => "$site_url/hrsys/vacancy/contentVacancy/" . $vacancy["vacancy_id"] . "/" . $frompage, "text" => $vacancy["name"]);
        }
        return $breadcrumb;
    }

    public function listCandidate() {
        $this->user_id;

        $dataParse = array(
        );
        $this->loadContent('hrsys/candidate/listCandidate', $dataParse);
    }

}

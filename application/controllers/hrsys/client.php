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
class client extends Main_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('hrsys/m_client', 'admin/m_lookup'));
    }

    public function detclient($id, $frompage = "") {

        $client = $this->m_client->get($id);
        $breadcrumb = array();
        $site_url=  site_url();
        switch ($frompage) {
            case "allclient":
                $breadcrumb[]=array("link"=>"$site_url/hrsys/client/allclient","text"=>"All Client");
                break;
            case "prospect":
                $breadcrumb[]=array("link"=>"$site_url/hrsys/client/prospect","text"=>"Prospect Client");
                break;
            case "myclient":
                $breadcrumb[]=array("link"=>"$site_url/hrsys/client/myclient","text"=>"My Client");             
                break;
        }
         $breadcrumb[]=array("link"=>"#","text"=>$client["name"]);  
     
         
        $dataParse = array(
            "client"=> $client,
            "breadcrumb" => $breadcrumb
        );
        $this->loadContent('hrsys/client/detclient', $dataParse);
    }

    public function prospect() {
        $this->loadContent('hrsys/client/prospect');
    }
    public function detMeeting() {
       echo "detMeeting";
    }
    public function detVacancies() {
       echo "detVacancies";
    }
    public function detHistory() {
      
      echo "det histori";
    }

    public function allclient() {
        $this->loadContent('hrsys/client/allclient');
    }

    public function myclient() {
        $this->loadContent('hrsys/client/myclient');
        
    }

    public function json_listClient($status) {

        if (isset($_POST["sort"]) && !empty($_POST["sort"]))
            foreach ($_POST["sort"] as $key => $value) {
                $_POST["sort"][$key] = str_replace("_sp_", ".", $value);
            }


        if (isset($_POST["search"]) && !empty($_POST["search"]))
            foreach ($_POST["search"] as $key => $value) {
                $_POST["search"][$key] = str_replace("_sp_", ".", $value);
            }

        $where = "1=1";
        if ($status == 'all') {
            
        } elseif ($status == "prospect") {
            $where = "cl.status='0'";
        } elseif ($status == "my") {
            $where = "cl.status='1' and cl.pic='" . (isset($this->sessionUserData["employee"]["emp_id"]) ? $this->sessionUserData["employee"]["emp_id"] : "") . "'";
        }

        $sql = "SELECT cl.cmpyclient_id cl_sp_cmpyclient_id,cl.name cl_sp_name,cl.cp_name cl_sp_cp_name,cl.cp_phone cl_sp_cp_phone, " .
                "emp.fullname emp_sp_fullname, lk.display_text lk_sp_display_text " .
                "from hrsys_cmpyclient cl " .
                "left join tpl_lookup lk on lk.type='cmpyclient_stat' and cl.status=lk.value " .
                "left join hrsys_employee emp on cl.pic=emp.emp_id " .
                "WHERE ~search~ and $where  ORDER BY ~sort~";


        $data = $this->m_menu->w2grid($sql, $_POST);
        header("Content-Type: application/json;charset=utf-8");
        echo json_encode($data);
    }

    public function addclient($id = 0) {

        $postForm = isset($_POST['frm']) ? $_POST['frm'] : array();

        $create_edit = "Edit";
        $isEdit = true;
        if ($id == 0) {
            $create_edit = "New";
            $isEdit = false;
        }

        $message = "";
        if (!empty($postForm)) {
            $validate = $this->m_client->validate($postForm, $isEdit);
            if ($validate["status"]) {
                if ($isEdit) {
                    
                } else {

                    if ($this->m_client->newClient($postForm, $this->sessionUserData)) {
                        redirect("hrsys/client/detclient/" . $this->m_client->cmpyclient_id);
                    }
                }
            }

            $error_message = isset($validate["message"]) ? $validate["message"] : array();
            if (!empty($error_message)) {
                $message = showMessage($error_message);
            }
        }

        $stat_list = $this->m_lookup->comboLookup("cmpyclient_stat");

        $comboPIC = array('' => '') + $this->m_client->comboPIC();

        $dataParse = array(
            'isEdit' => $isEdit,
            'postForm' => $postForm,
            'message' => $message,
            'stat_list' => $stat_list,
            'comboPIC' => $comboPIC,
        );
        $this->loadContent('hrsys/client/addclient', $dataParse);
    }

}

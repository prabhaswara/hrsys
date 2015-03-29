<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class clientnote extends Main_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('hrsys/m_clientnote', 'hrsys/m_client', 'hrsys/m_employee', 'admin/m_lookup'));
    }

    public function infNote($client_id) {

        $client = $this->m_client->get($client_id);
        if (!empty($_POST) && $_POST["pg_action"] == "json") {
            if (isset($_POST["sort"]) && !empty($_POST["sort"])) {
                foreach ($_POST["sort"] as $key => $value) {
                    $_POST["sort"][$key] = str_replace("_sp_", ".", $value);
                }
            } else {
                $_POST["sort"][0]['direction'] = 'desc';
                $_POST["sort"][0]['field'] = 'datecreate';
            }


            if (isset($_POST["search"]) && !empty($_POST["search"]))
                foreach ($_POST["search"] as $key => $value) {
                    $_POST["search"][$key] = str_replace("_sp_", ".", $value);
                }

            $where = "cmpyclient_id ='$client_id' and ";

            $sql = "SELECT  * " .
                    "from hrsys_cmpyclient_note note " .
                    "WHERE ~search~ and $where 1=1 ORDER BY ~sort~";


            $data = $this->m_menu->w2grid($sql, $_POST);
            
            $dataReturn=array();
            foreach ( $data['records'] as $row){
                $row["canedit"]="0";                
                if( $client["account_manager"]==$this->user_id||$row["usercreate"]==$this->user_id || in_array("hrsys_allmeeting", $this->ses_roles))
                {
                    $row["canedit"]="1";
                    
                }
                
                $dataReturn[]=$row;
            }
            $data['records']=$dataReturn;
            
            
            header("Content-Type: application/json;charset=utf-8");
            echo json_encode($data);
            exit();
        }
        $canedit = false;

        if ($client["account_manager"] == $this->emp_id || in_array("hrsys_allmeeting", $this->ses_roles)) {
            $canedit = true;
        }
        $dataParse = array(
            "client_id" => $client_id,
            "canedit" => $canedit
        );
        $this->loadContent('hrsys/clientnote/infNote', $dataParse);
    }

    public function showForm($client_id = 0, $note_id = 0) {

        $postForm = isset($_POST['frm']) ? $_POST['frm'] : array();

        $create_edit = "Edit";
        $isEdit = true;
        if ($note_id == 0) {
            $create_edit = "New";
            $isEdit = false;
        }


        $message = "";
        if (!empty($postForm) && $_POST["do"] == "schedule") {
            $validate = $this->m_clientnote->validate($postForm, $isEdit);
            if ($validate["status"]) {
                $postForm["cmpyclient_id"] = $client_id;


                if ($this->m_clientnote->saveOrUpdate($postForm, $this->sessionUserData)) {
                    echo "close_popup";
                    exit;
                }
            }

            $error_message = isset($validate["message"]) ? $validate["message"] : array();
            if (!empty($error_message)) {
                $message = showMessage($error_message);
            }
        }


        if ($isEdit) {
            $postForm = $this->m_clientnote->get($note_id);
        }


        $client = $this->m_client->get($client_id);
        $dataParse = array(
            "isEdit"=>$isEdit,
            "message" => $message,
            "postForm" => $postForm,
            "client" => $client
        );
        $this->loadContent('hrsys/clientnote/showform', $dataParse);
    }

    public function delete($note_id) {
        $postForm = $this->m_clientnote->delete($note_id);
    }

}

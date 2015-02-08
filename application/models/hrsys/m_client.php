<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_client extends Main_Model {

    var $cmpyclient_id;

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        $sql="select cl.*,emp.fullname emp_pic, lk.display_text status_text from hrsys_cmpyclient cl  ".
             "left join tpl_lookup lk on lk.type='cmpyclient_stat' and cl.status=lk.value ".
             "left join hrsys_employee emp on cl.pic=emp.emp_id ".
             "where cl.cmpyclient_id='$id'";
        return $this->db->query($sql)->row_array();
    }

    
    public function editClient($datafrm, $sessionData) {
        
        $cmpyclient_id=$datafrm["cmpyclient_id"];
        unset($datafrm["cmpyclient_id"]);
        $this->db->trans_start(TRUE);

     
        $this->db->set('dateupdate', 'NOW()', FALSE);
        $this->db->set('usercreate', $sessionData["user"]["username"]);
        $this->db->update('hrsys_cmpyclient', $datafrm,array('cmpyclient_id'=>$cmpyclient_id));

        $userInsert = (isset($sessionData["employee"]["fullname"]) && !empty($sessionData["employee"]["fullname"])) ? $sessionData["employee"]["fullname"] :
        $sessionData["user"]["username"];


        $dataTrl["cmpyclient_trl_id"] = $this->uniqID();
        $dataTrl["cmpyclient_id"] = $cmpyclient_id;
        $dataTrl["description"] = "$userInsert Update Info " . $datafrm["name"];
        $this->db->set('datecreate', 'NOW()', FALSE);
        $this->db->set('usercreate', $sessionData["user"]["username"]);
        $this->db->insert('hrsys_cmpyclient_trl', $dataTrl);
        $this->db->trans_complete();
        
       
        return $this->db->trans_status();
    }

    public function newClient($datafrm, $sessionData) {
        unset($datafrm["cmpyclient_id"]);
        $this->db->trans_start(TRUE);

        $this->cmpyclient_id = $this->uniqID();
        $this->db->set('cmpyclient_id', $this->cmpyclient_id);
        $this->db->set('datecreate', 'NOW()', FALSE);
        $this->db->set('usercreate', $sessionData["user"]["user_id"]);
        $this->db->set('dateupdate', 'NOW()', FALSE);
        $this->db->set('usercreate', $sessionData["user"]["user_id"]);
        $this->db->insert('hrsys_cmpyclient', $datafrm);

        $userInsert = (isset($sessionData["employee"]["fullname"]) && !empty($sessionData["employee"]["fullname"])) ? $sessionData["employee"]["fullname"] :
        $sessionData["user"]["username"];


        $dataTrl["cmpyclient_trl_id"] = $this->uniqID();
        $dataTrl["cmpyclient_id"] = $this->cmpyclient_id;
        $dataTrl["description"] = "$userInsert Created " . $datafrm["name"];
        $this->db->set('datecreate', 'NOW()', FALSE);
        $this->db->set('usercreate', $sessionData["user"]["user_id"]);
        $this->db->insert('hrsys_cmpyclient_trl', $dataTrl);
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function validate($datafrm, $isEdit) {
        $return = array(
            'status' => true,
            'message' => array()
        );

        if (!empty($datafrm)) {

            if (cleanstr($datafrm["name"]) == "") {
                $return["status"] = false;
                $return["message"]["name"] = "Company Name cannot be empty";
            }
            if (!$isEdit && cleanstr($datafrm["status"]) == "1" && cleanstr($datafrm["pic"]) == "") {
                $return["status"] = false;
                $return["message"]["pic"] = "PIC cannot be empty";
            }
        }

        return $return;
    }

}

?>
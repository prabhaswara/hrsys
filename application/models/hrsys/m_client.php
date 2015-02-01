<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_client extends Main_Model {

    var $cmpyclient_id;

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        return $this->db->where("cmpyclient_id", $id)->get("hrsys_client")->row_array();
    }

    function comboPIC() {

        $dataReturn = array();
        $dataEmployee = $this->db->select("emp_id,fullname")->order_by("fullname")->get("hrsys_employee")->result();


        if (!empty($dataEmployee)) {
            foreach ($dataEmployee as $emp) {

                $dataReturn[$emp->emp_id] = $emp->fullname . " (" . $emp->emp_id . ")";
            }
        }

        return $dataReturn;
    }

    public function newClient($datafrm, $sessionData) {
        unset($datafrm["cmpyclient_id"]);
        $this->db->trans_start(TRUE);

        $this->cmpyclient_id = $this->uniqID();
        $this->db->set('cmpyclient_id', $this->cmpyclient_id);
        $this->db->set('datecreate', 'NOW()', FALSE);
        $this->db->set('usercreate', $sessionData["user"]["username"]);
        $this->db->set('dateupdate', 'NOW()', FALSE);
        $this->db->set('usercreate', $sessionData["user"]["username"]);
        $this->db->insert('hrsys_cmpyclient', $datafrm);

        $userInsert = (isset($sessionData["employee"]["fullname"]) && !empty($sessionData["employee"]["fullname"])) ? $sessionData["employee"]["fullname"] :
        $sessionData["user"]["username"];


        $dataTrl["cmpyclient_trl_id"] = $this->uniqID();
        $dataTrl["cmpyclient_id"] = $this->cmpyclient_id;
        $dataTrl["desc"] = "$userInsert Created " . $datafrm["name"];
        $this->db->set('datecreate', 'NOW()', FALSE);
        $this->db->set('usercreate', $sessionData["user"]["username"]);
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
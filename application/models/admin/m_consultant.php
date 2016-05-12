<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_consultant extends Main_Model {

    function __construct() {
        parent::__construct();
    }
    function get($code){
        return $this->db->where("consultant_code",$code)->get("hrsys_consultant")->row_array();
    }
    
    function allconsultant(){
        return $this->db->select("consultant_code,name")->get("hrsys_consultant")->result_array();
    }
    
    function comboConsultant(){
        $data=$this->allconsultant();
        $return=array();
        foreach($data as $row){
            $return[$row["consultant_code"]]=$row["name"];
        }
        return $return;
    }
    
  

    public function saveOrUpdate($datafrm,$user) {
        $return=false;
        $consultant_code = $datafrm["consultant_code"];
      
        
        $this->db->set('dateupdate', 'NOW()', FALSE); 
        
        $dataChek=$this->get($consultant_code);
        
        if (empty($dataChek)) {      
            $this->db->set('datecreate', 'NOW()', FALSE);             
            $this->db->set('usercreate',$user);
            $return=$this->db->insert('hrsys_consultant', $datafrm);
        } else {        
            $this->db->set('userupdate',$user);
            $return=$this->db->update('hrsys_consultant', $datafrm, array('consultant_code' => $consultant_code));
        }
      
        return $return;
    }
    
    public function delete($selected){
        foreach($selected as $code){
            $this->db->delete( 'hrsys_consultant', array( 'consultant_code' => $code ) );
        }
    }

    public function validate($datafrm) {
        $return = array(
            'status' => true,
            'message' => array()
        );

        if (!empty($datafrm)) {

             if (cleanstr($datafrm["consultant_code"]) == "") {
                $return["status"] = false;
                $return["message"]["consultant_code"] = "Code cannot be empty";
            }
            if (cleanstr($datafrm["name"]) == "") {
                $return["status"] = false;
                $return["message"]["name"] = "Name cannot be empty";
            }

           
           
        }

        return $return;
    }

}

?>
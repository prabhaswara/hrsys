<?php

class Main_Model extends CI_Model {

    function __construct() {

        parent::__construct();
        $this->load->helper('gn_str');
    }

    function generateID($field,$table){
        $id=$this->uniqID();
        $this->db;

        $row=$this->db->where($field,$id)->get($table)->row_array();
        while (!empty($row)){
            $row=$this->db->where($field,$id)->get($table)->row_array();
            $id=$this->uniqID();
        }
        return $id;
    }
    function encrypt($string){
        return md5($string);
    }
    function uniqID(){
        return uniqid(time());   
    }
    function w2grid($sql, $request,$cql="") {
        $db = $this->db;
        // prepare search
        $str = "";
        if (isset($request['search']) && is_array($request['search'])) {
            foreach ($request['search'] as $s => $search) {
                if ($str != "") $str .= " ".$request['searchLogic']." ";
                $field = $search['field'];
                switch (strtolower($search['operator'])) {

                    case 'begins':
                        $operator = "LIKE";
                        $value    = "'".$search['value']."%'";
                        break;

                    case 'ends':
                        $operator = "LIKE";
                        $value    = "'%".$search['value']."'";
                        break;

                    case 'contains':
                        $operator = "LIKE";
                        $value    = "'%".$search['value']."%'";
                        break;

                    case 'is':
                        $operator = "=";
                        if (!is_int($search['value']) && !is_float($search['value'])) {
                            $field = "LOWER($field)";
                            $value = "LOWER('".$search['value']."')";
                        } else {
                            $value = "'".$search['value']."'";
                        }
                        break;

                    case 'between':
                        $operator = "BETWEEN";
                        $value    = "'".$search['value'][0]."' AND '".$search['value'][1]."'";
                        break;

                    case 'in':
                        $operator = "IN";
                        $value    = "(".$search['value'].")";
                        break;

                    default:
                        $operator = "=";
                        $value    = "'".$search['value']."'";
                }
                $str .= $field." ".$operator." ".$value;
            }
        }
        if ($str == "") $str = " 1=1 ";

        // prepare sort
        $str2 = "";
        if (isset($request['sort']) && is_array($request['sort'])) {
            foreach ($request['sort'] as $s => $sort) {
                if ($str2 != "") $str2 .= ", ";
                $str2 .= $sort['field']." ".$sort['direction'];
            }
        }
        if ($str2 == "") $str2 = "1=1";

        // build sql
        $sql = str_ireplace("~search~", $str, $sql);       
        $sql = str_ireplace("~sort~", $str2, $sql);

        // build cql (for counging)
        if ($cql == null || $cql == "") {
            $cql = "SELECT count(1) rows FROM ($sql) as grid_list_1";
        }else{
            if(strpos($cql, "~search~")){
                $cql = str_ireplace("~search~", $str, $cql);    
                $cql = str_ireplace("~sort~", $str2, $cql);
                $cql = "SELECT count(1) rows FROM ($cql) as grid_list_1";
            }
           
        }
        if (!isset($request['limit']))  $request['limit']  = 50;
        if (!isset($request['offset'])) $request['offset'] = 0;

        $sql .= " LIMIT ".$request['limit']." OFFSET ".$request['offset'];

        $data = Array();        

        // count records
   
        $data['status'] = 'success';
        $data['total']  = $db->query($cql)->first_row()->rows;

//       echo $sql;exit;
        // execute sql
        $rs = $db->query($sql)->result_array();
       

        // check for error
//        if ($db->res_errMsg != '') {
//            $data = Array();
//            $data['status'] = 'error';
//            $data['message'] = $db->res_errMsg;
//            return $data;
//        }
        $data['records'] = array();
       
        $len = 0;
        foreach($rs as $rowDt){
            $data['records'][$len]['recid']=reset($rowDt);
            foreach($rowDt as $k=>$v){
                $data['records'][$len][$k]=$v;
            }
            $len++;
        }
       
       
        return $data;
    }

    
}

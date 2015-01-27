<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_menu extends Main_Model {

    function __construct() {
        parent::__construct();
    }
    function get($id){
        return $this->db->where("menu_id",$id)->get("tpl_menu")->row_array();
    }
    
    function comboParent(){
        $data= $this->db->select("menu_id,menu_title")->get("tpl_menu")->result_array();
        $return=array();
        foreach($data as $row){
            $return[$row["menu_id"]]=$row["menu_title"];
        }
        return $return;
    }
    
    public function saveOrUpdate($datafrm,$user) {
        $return=false;
        $menu_id = $datafrm["menu_id"];
        unset($datafrm["menu_id"]);
        
        $this->db->set('dateupdate', 'NOW()', FALSE); 
        if ($menu_id == "") {      
            $this->db->set('datecreate', 'NOW()', FALSE); 
            $this->db->set('usercreate',$user);
            $return=$this->db->insert('tpl_menu', $datafrm);
        } else {        
            $this->db->set('userupdate',$user);
            $return=$this->db->update('tpl_menu', $datafrm, array('menu_id' => $menu_id));
        }
        return $return;
    }
    
    public function delete($selected){
        foreach($selected as $id){
            $this->db->delete( 'tpl_menu', array( 'menu_id' => $id ) );
        }
    }

    public function validate($datafrm) {
        $return = array(
            'status' => true,
            'message' => array()
        );

        if (!empty($datafrm)) {

            if (cleanstr($datafrm["menu_title"]) == "") {
                $return["status"] = false;
                $return["message"]["menu_title"] = "Menu Title cannot be empty";
            }

//            if (cleanstr($datafrm["url"]) == "") {
//                $return["status"] = false;
//                $return["message"]["url"] = "Url cannot be empty";
//            }

          
        }
     
        return $return;
    }
    
    function strArrayMenuw2ui($arrayMenu){
       
        $string="[";
        foreach($arrayMenu as $key=>$val){
            
            $punyaAnak=isset($val['child'])&& !empty($val['child']);
            $punyaImg=strpos($val["attributes"],"img");
            $url=  cleanstr($val['url']);
            
            if($punyaAnak && !$punyaImg){
                $val["attributes"].=" , img: 'icon-folder'";
            }
          
            if($punyaAnak || $url!=""){
                $string.="{id:'".$val["menu_id"]."', text:'".$val["menu_title"]."' ".$val["attributes"];
            }
            if($punyaAnak){
                $string.=", nodes:".$this->strArrayMenuw2ui($val['child']);
                $string=  substr($string, 0,  strlen($string)-1);
            } 
            if($punyaAnak || $url!=""){
                $string.=" },";
            }
        }
        $string=  substr($string, 0,  strlen($string)-1);
        $string.="],";
        return $string;
        
    }
    
    
    function generateMenu($roles){
         
        $where="(role_id=null or role_id=''";
        if(!empty($roles)){
            $where.="or role_id in('".(implode("','", $roles))."')";
        }
        $where.=")";
        $dataMentah=$this->db->where("active_non",'1')
                ->where($where, NULL, FALSE)
                ->get("tpl_menu")->result_array();
        
        
        $dataKeyParent=array();
        foreach($dataMentah as $row){
            $dataKeyParent[$row['parent_id']][$row['order_num']]=$row;
        }
           
       
        $menujadi=$this->loopMenu("0",$dataKeyParent);
        return $menujadi;
    }
    
            
    function loopMenu($parent_id,$dataKeyParent){
        $datareturn=array();
               
        if(isset($dataKeyParent[$parent_id]))
            foreach($dataKeyParent[$parent_id] as $order=>$dataMenu){
         
                $datareturn[$order]=$dataMenu;
                $datareturn[$order]['child']=$this->loopMenu($dataMenu["menu_id"],$dataKeyParent);
                if(empty($datareturn[$order]['child'])){
                    unset($datareturn[$order]['child']);
                }
            }
        ksort($datareturn);
        return $datareturn;
        
    }
    
    

}

?>
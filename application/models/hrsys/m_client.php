<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_client extends Main_Model {

    var $cmpyclient_id;

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        $sql="select cl.*,emp.fullname emp_am, lk.display_text status_text,empcrt.fullname empcrt_fullname,ck.fee ck_fee  from hrsys_cmpyclient cl  ".
             "left join tpl_lookup lk on lk.type='cmpyclient_stat' and cl.status=lk.value ".
             "left join hrsys_employee emp on cl.account_manager=emp.id ".
             "left join tpl_user user on cl.usercreate=user.user_id ".
             "left join hrsys_employee empcrt on user.user_id=empcrt.user_id ".
             "left join hrsys_cmpyclient_ctrk ck on cl.cmpyclient_id=ck.cmpyclient_id and ck.active_non=1 ".
             "where cl.cmpyclient_id='$id'";
        return $this->db->query($sql)->row_array();
    }

    public function editClient($datafrm, $sessionData) {
       
        $cmpyclient_id=$datafrm["cmpyclient_id"];
        $dtLama=$this->get($cmpyclient_id);
        
        unset($datafrm["cmpyclient_id"]);
        $this->db->trans_start(TRUE);
        
        $this->db->set('dateupdate', 'NOW()', FALSE);
        $this->db->set('userupdate', $sessionData["user"]["user_id"]);
        $this->db->update('hrsys_cmpyclient', $datafrm,array('cmpyclient_id'=>$cmpyclient_id));

        
        $this->db->trans_complete();
        
       
        return $this->db->trans_status();
    }
    
    public function updateStatusPIC($datafrm, $sessionData,$method="editinfo") {
       
	 
        $cmpyclient_id=$datafrm["cmpyclient_id"];
        $dtLama=$this->get($cmpyclient_id);
        
        unset($datafrm["cmpyclient_id"]);
        $this->db->trans_start(TRUE);
        
        $this->load->model('m_employee');
        $picLama=array();
        
        $picBaru=$this->m_employee->getById($datafrm["account_manager"],$this->sessionUserData["employee"]["consultant_code"]); 
        $picBaru=isset($picBaru["fullname"])?$picBaru["fullname"]:"";
        
        if(!empty($dtLama)&& isset($dtLama["account_manager"])){
            $picLama=$this->m_employee->getById($dtLama["account_manager"],$this->sessionUserData["employee"]["consultant_code"]);            
            $picLama=isset($picLama["fullname"])?$picLama["fullname"]:"";
        }
        
        
        $dataTrl["cmpyclient_trl_id"] = $this->generateID("cmpyclient_trl_id","hrsys_cmpyclient_trl");
        $dataTrl["cmpyclient_id"] = $cmpyclient_id;        
        $dataTrl["description"] = "Change AM from $picLama to $picBaru";
        if($method=="changeToClient"){
            $datafrm["status"] ="1";
            $dataTrl["description"] = "Change status from prospect to client AM is ".$picBaru;
        }
     
        $this->db->set('dateupdate', 'NOW()', FALSE);
        $this->db->set('userupdate', $sessionData["user"]["user_id"]);
        $this->db->update('hrsys_cmpyclient', $datafrm,array('cmpyclient_id'=>$cmpyclient_id));

        
        $this->db->set('datecreate', 'NOW()', FALSE);
        $this->db->set('usercreate', $sessionData["user"]["user_id"]);
        $this->db->insert('hrsys_cmpyclient_trl', $dataTrl);
        $this->db->trans_complete();
        
       
        return $this->db->trans_status();
    }

    
    public function newClient($datafrm, $sessionData) {
	
		$datafrm['active_non']=1;
        unset($datafrm["cmpyclient_id"]);
        $this->db->trans_start(TRUE);

        $this->cmpyclient_id = $this->generateID("cmpyclient_id","hrsys_cmpyclient");
        $this->db->set('cmpyclient_id', $this->cmpyclient_id);
        $this->db->set('datecreate', 'NOW()', FALSE);
        $this->db->set('usercreate', $sessionData["user"]["user_id"]);
        $this->db->set('dateupdate', 'NOW()', FALSE);
        $this->db->set('usercreate', $sessionData["user"]["user_id"]);
		$datafrm["consultant_code"]=$sessionData["employee"]["consultant_code"];
        
        if(isset($datafrm["datejoin"])&& cleanstr($datafrm["datejoin"])!=""){
            $datafrm["datejoin"]=  balikTgl($datafrm["datejoin"]);
        }
         $this->db->insert('hrsys_cmpyclient', $datafrm);

        $userInsert = (isset($sessionData["employee"]["fullname"]) && !empty($sessionData["employee"]["fullname"])) ? $sessionData["employee"]["fullname"] :
        $sessionData["user"]["username"];


        $dataTrl["cmpyclient_trl_id"] = $this->generateID("cmpyclient_trl_id","hrsys_cmpyclient_trl");
        $dataTrl["cmpyclient_id"] = $this->cmpyclient_id;
        $dataTrl["description"] = "Created " . $datafrm["name"];
        
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
            if (!$isEdit && cleanstr($datafrm["status"]) == "1" && cleanstr($datafrm["account_manager"]) == "") {
                $return["status"] = false;
                $return["message"]["account_manager"] = "PIC cannot be empty";
            }
        }

        return $return;
    }
    
    public function validateContract($datafrm,$file,$folder) {
        $return = array(
            'status' => true,
            'message' => array()
        );
        $cmpyclient_ctrk_id=$datafrm["cmpyclient_ctrk_id"];

        if (!empty($datafrm)) {
            
            

            if (cleanstr($datafrm["contract_num"]) == "") {
                $return["status"] = false;
                $return["message"]["contract_num"] = "Contract Number cannot be empty";
            }
            if (cleanstr($datafrm["contractdate_1"]) == "") {
                $return["status"] = false;
                $return["message"]["contractdate_1"] = "Begin Date cannot be empty";
            }
            if (cleanstr($datafrm["contractdate_2"]) == "") {
                $return["status"] = false;
                $return["message"]["contractdate_2"] = "End Date cannot be empty";
            }
            if(isset($file["name"])&&$file["name"]!=""){
                
                $filename=$file["name"];
                $filetype=$file["type"];
                
                $fileExist=file_exists($folder.DIRECTORY_SEPARATOR.$filename);
              
                if(!in_array($filetype, array("application/pdf","text/pdf"))){
                     $return["message"]["doc_url"] = "Document must pdf file ";
                }else if($fileExist){                    
                    $contract=$this->getContract($cmpyclient_ctrk_id);
//                    echo "fileexist=".$fileExist."<br>";
//                    echo "filename=".$filename."<br>";
//                    echo "doc_url=".$contract["doc_url"]."<br>";
//                    
                    if($cmpyclient_ctrk_id=="0"||$cmpyclient_ctrk_id==""||
                       ($contract!=null && $fileExist && $filename!=$contract["doc_url"])     
                    ){
                         $return["message"]["doc_url"] = "File is exists";
                    }
                                 
                }         
            }          
           
        }

        return $return;
    }
    
    
    function setstatusContract($cmpyclient_id){
        
        $this->db->update('hrsys_cmpyclient_ctrk', array("active_non"=>"0"), 
                    array('cmpyclient_id' => $cmpyclient_id));
                
                
        $contract=$this->db->where("cmpyclient_id",$cmpyclient_id)
                ->order_by("contractdate_2","desc")
                ->limit(1)
                ->get("hrsys_cmpyclient_ctrk")->row_array();
        if($contract!=null){
            $this->db->update('hrsys_cmpyclient_ctrk', array("active_non"=>"1"), 
                    array('cmpyclient_ctrk_id' => $contract["cmpyclient_ctrk_id"]));
        }
                
    }
    
    public function deleteContract($cmpyclient_ctrk_id){
        $contract=$this->getContract($cmpyclient_ctrk_id);
        $this->db->trans_start(TRUE);
        
        
        $this->db->delete( 'hrsys_cmpyclient_trl', array( 'type'=>'contract','value' => $cmpyclient_ctrk_id ) ); 
        
        $this->db->delete( 'hrsys_cmpyclient_ctrk', array( 'cmpyclient_ctrk_id' => $cmpyclient_ctrk_id ) );
        $this->setstatusContract($contract["cmpyclient_id"]);
        
        
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function getContract($cmpyclient_ctrk_id){
        return $this->db->where("cmpyclient_ctrk_id",$cmpyclient_ctrk_id)->get("hrsys_cmpyclient_ctrk")->row_array();
    }
    public function saveUpdateContract($dataFrm,$sessionData,$cmpyclient_ctrk_id){
        
        $return=false;
        $dataFrm["contractdate_1"]=  balikTgl($dataFrm["contractdate_1"]);
        $dataFrm["contractdate_2"]=  balikTgl($dataFrm["contractdate_2"]);
        
       
        unset($dataFrm["cmpyclient_ctrk_id"]);
        
        $this->db->trans_start(TRUE);
        
        $this->db->set('datecreate', 'NOW()', FALSE);
        $this->db->set('usercreate', $sessionData["user"]["user_id"]);
        if($cmpyclient_ctrk_id==""||$cmpyclient_ctrk_id=="0"){
            
            $cmpyclient_ctrk_id=$this->generateID("cmpyclient_ctrk_id", "hrsys_cmpyclient_ctrk");
            
            $dataFrm["cmpyclient_ctrk_id"]=$cmpyclient_ctrk_id;
            $this->db->insert('hrsys_cmpyclient_ctrk', $dataFrm); 
            
            // insert trail
            $dataTrl["cmpyclient_trl_id"] = $this->generateID("cmpyclient_trl_id", "hrsys_cmpyclient_trl");
            $dataTrl["cmpyclient_id"] = $dataFrm["cmpyclient_id"];
            $dataTrl["description"] = "Created Contract ".$dataFrm["contract_num"];
            $dataTrl["type"] = "contract";
            $dataTrl["value"] = $cmpyclient_ctrk_id;
            
            $this->db->set('datecreate', 'NOW()', FALSE);
            $this->db->set('usercreate', $sessionData["user"]["user_id"]);
            
            $this->db->insert('hrsys_cmpyclient_trl', $dataTrl);
            
            
           }else{
             
           $this->db->set('dateupdate', 'NOW()', FALSE);
           $this->db->set('userupdate', $sessionData["user"]["user_id"]);            
           $this->db->update('hrsys_cmpyclient_ctrk', $dataFrm, array('cmpyclient_ctrk_id' => $cmpyclient_ctrk_id));
          
        
           // update trail        
            $dataTrl["description"] = "Create Contract ".$dataFrm["contract_num"];
            $this->db->update('hrsys_cmpyclient_trl', $dataTrl, array(
                'value' => $cmpyclient_ctrk_id,'type'=>'contract'));       
             
            
           }
        $this->setstatusContract($dataFrm["cmpyclient_id"]);
        
        $this->db->trans_complete();

        return $this->db->trans_status();
        
    }
    public function canDeleteClient($cmpyclient_id){
        $contract=$this->db->where("cmpyclient_id",$cmpyclient_id)->limit(1)->get("hrsys_cmpyclient_ctrk")->row_array();
        $meet=$this->db->where("cmpyclient_id",$cmpyclient_id)->limit(1)->get("hrsys_cmpyclient_meet")->row_array();
        $note=$this->db->where("cmpyclient_id",$cmpyclient_id)->limit(1)->get("hrsys_cmpyclient_note")->row_array();
     
        
        
        return (empty($note) &&empty($meet) &&empty($contract));
    }
    public function deleteClient($cmpyclient_id){
        
        $this->db->trans_start(TRUE);
        $this->db->delete( 'hrsys_cmpyclient_trl', array( 'cmpyclient_id' => $cmpyclient_id ) ); 
        $this->db->delete( 'hrsys_cmpyclient', array( 'cmpyclient_id' => $cmpyclient_id ) );
        $this->db->trans_complete();

        return $this->db->trans_status();
    }
	
	public function comboClientByUser($user_id){		
		$where="";			 
        $countRole= $this->db->query("select count(1) c from tpl_user_role role where user_id='$user_id' and role_id='hrsys_allvacancies' ")->row_array();
		if($countRole["c"]=="0")
		{
			$where.="cli.account_manager='$user_id'";
		}
		$sql ="select cmpyclient_id,name from hrsys_cmpyclient cli where $where 1=1 order by name";
		
		$result=array();
		$array=$this->db->query($sql)->result_array();
		if(!empty($array))
		{
			foreach($array as $row){          
				$result[$row["cmpyclient_id"]]=$row["name"];
			}			
		}
		return $result;
	}

}

?>
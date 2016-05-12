<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_invoice  extends Main_Model {

	function __construct() {
        parent::__construct();
    }

	function get($invoice_id)
	{
		$sql = "SELECT inv.*,cli.name as cmpyclient_name from hrsys_invoice inv
					join hrsys_cmpyclient cli on inv.cmpyclient_id=cli.cmpyclient_id where invoice_id='$invoice_id'";
		$data= $this->db->query($sql)->row_array();
		return $data;
	}
	
	function getItemByInvoice($invoice_id)
	{
		$sql = "SELECT invoice_id recid,invoice_id,vacancycandidate_id,vacancy_name,candidate_name,DATE_FORMAT(join_date,'%d-%m-%Y') join_date,approvedsalary,fee,bill  from hrsys_invoice_item inv where invoice_id='$invoice_id'";
		$data= $this->db->query($sql)->result_array();
		return $data;
	}
   function getAddItemInvoice($vacancycandidate_id ){
        
        $sql = 	"SELECT vc.vacancycandidate_id vc_sp_vacancycandidate_id, v.name v_sp_name,c.name c_sp_name,DATE_FORMAT(vc.date_join,'%d-%m-%Y') vc_sp_date_join,".
				"vc.approvedsalary vc_sp_approvedsalary,vc.approvedsalary_ccy vc_sp_approvedsalary_ccy, ".
				"v.fee v_sp_fee ".
				"FROM hrsys_vacancy v ".
				"JOIN hrsys_vacancycandidate vc on v.vacancy_id=vc.vacancy_id ".
				"JOIN hrsys_candidate c on c.candidate_id=vc.candidate_id ".
				"WHERE vacancycandidate_id='$vacancycandidate_id'";
		$data= $this->db->query($sql)->row_array();
		
		return $data;
    }
	
	public function setPaidDate($data,$sessionData)
	{	
        $this->db->set('dateupdate', 'NOW()', FALSE);
        $this->db->set('userupdate', $sessionData["user"]["user_id"]);
		$this->db->update('hrsys_invoice', array("paid_date"=>balikTgl($data["paid_date"])), array('invoice_id' => $data["invoice_id"]));
		
	}
	public function deleteInvoice($invoice_id)
	{	
		 $this->db->trans_start(TRUE);
        $this->db->delete( 'hrsys_invoice_item', array( 'invoice_id' => $invoice_id ) ); 
        $this->db->delete( 'hrsys_invoice', array( 'invoice_id' => $invoice_id ) );
        $this->db->trans_complete();

        return $this->db->trans_status();
		
	}
	
	
	public function saveOrUpdate($post, $sessionData) {
		
		$datafrm=$post["frm"];
		$dataitem=($post["item"]==null)?array():$post["item"];
		$datafrm["consultant_code"]=$sessionData["employee"]["consultant_code"];
		$invoice_id = $datafrm["invoice_id"];
		
		
		$datafrm["invoice_date"]=balikTgl($datafrm["invoice_date"]);
		$datafrm["due_date"]=balikTgl($datafrm["due_date"]);
		
		$this->db->trans_start(TRUE);
        $this->db->set('dateupdate', 'NOW()', FALSE);
        $this->db->set('userupdate', $sessionData["user"]["user_id"]);
		
		$total_bill=0;
		foreach ($dataitem as $row){
			$total_bill+=$row["bill"];
		}
		$datafrm["total_bill"]=$total_bill;
		if($invoice_id==""){
			$this->db->set('datecreate', 'NOW()', FALSE);
			$this->db->set('usercreate', $sessionData["user"]["user_id"]);
			$invoice_id= $this->generateID("invoice_id","hrsys_invoice");
			
			$datafrm["invoice_id"]=$invoice_id;			
			$this->db->insert('hrsys_invoice', $datafrm);
		}
		else
		{
			unset($datafrm["invoice_id"]);
			$this->db->update('hrsys_invoice', $datafrm, array('invoice_id' => $invoice_id)); 
        }
		$this->db->delete( 'hrsys_invoice_item', array( 'invoice_id' => $invoice_id ) );
		foreach ($dataitem as $row){
			$row["vacancycandidate_id"]=$row["recid"];
			$row["join_date"]=balikTgl($row["join_date"]);
			$row["invoice_id"]=$invoice_id;
			
			unset($row["recid"]);
			unset($row["expanded"]);
			$this->db->insert('hrsys_invoice_item', $row);
			
        }
		$this->db->trans_complete();
		
		return $invoice_id;
	}
	public function validate($post, $isEdit) {
		
        $return = array(
            'status' => true,
            'message' => array()
        );
		
		$datafrm=$post["frm"];
		$dataitem=($post["item"]==null)?array():$post["item"];
		
		

       
        if (cleanstr($datafrm["invoice_num"]) == "") {
            $return["status"] = false;
            $return["message"]["invoice_num"] = "Invoice Number with cannot be empty";
        }
        if (cleanstr($datafrm["invoice_date"]) == "") {
            $return["status"] = false;
            $return["message"]["invoice_date"] = "Invoice Date cannot be empty";
        }
        if (cleanstr($datafrm["due_date"]) == "") {
            $return["status"] = false;
            $return["message"]["due_date"] = "Due Date cannot be empty";
        }
		if (empty($dataitem)) {
            $return["status"] = false;
            $return["message"]["item"] = "Item cannot be empty";
        }
        return $return;
    }
}

?>
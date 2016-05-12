<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @author prabhaswara
 */
class invoice extends Main_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array(  "hrsys/m_invoice", "hrsys/m_client", "hrsys/m_formula"));
    }
	public function create_invoice($invoice_id = 0) {
        $site_url=  site_url();
        $postForm = isset($_POST['frm']) ? $_POST['frm'] : array();
		$postItem = isset($_POST['item']) ? $_POST['item'] : array();
		$message="";
        $create_edit = "Edit";
        $isEdit = true;
		
		if ($invoice_id == 0 ) {          
           $breadcrumb[]=array("link"=>"$site_url/hrsys/invoice/create_invoice/".$invoice_id,"text"=>"Create Invoice");
		
            $isEdit = false;
             
        }else{
			$breadcrumb[]=array("link"=>"$site_url/hrsys/invoice/list_invoice","text"=>"Search Invoice");
			$breadcrumb[]=array("link"=>"$site_url/hrsys/invoice/det_invoice/".$invoice_id,"text"=>"Detail Invoice");
			$breadcrumb[]=array("link"=>"$site_url/hrsys/invoice/create_invoice/".$invoice_id,"text"=>"Edit Invoice");
		
			$postForm=$this->m_invoice->get($invoice_id);
			$postForm["invoice_date"]=balikTgl($postForm["invoice_date"]);
			$postForm["due_date"]=balikTgl($postForm["due_date"]);
			
			$postItem = $this->m_invoice->getItemByInvoice($invoice_id);
			
		}
		
		if(!empty($_POST))
		{
			$validate = $this->m_invoice->validate($_POST, $isEdit);
			
			
			if ($validate["status"]) {             
				$invoice_id=$this->m_invoice->saveOrUpdate($_POST, $this->sessionUserData);
				echo "save_ok".$invoice_id;
				exit;  
			
            }
			$error_message = isset($validate["message"]) ? $validate["message"] : array();
            if (!empty($error_message)) {
                $message = showMessage($error_message);
            } 
		
		}
		
		 $dataParse = array(
            "message"=>$message,
			"client_list"=>$this->m_client->comboClientByUser($this->employee_id),
            "isEdit"=>$isEdit,
            "postForm"=>$postForm,
			"postItem"=>$postItem,  
            "breadcrumb"=>$breadcrumb,
			"message"=>$message
        );
        $this->loadContent('hrsys/invoice/create_invoice', $dataParse);
	}
	
	public function setPaidDate()
	{	
		if($_POST["paid_date"]==""){
			echo "Date cannot be empty";
		}
		else{
			$this->m_invoice->setPaidDate($_POST,$this->sessionUserData);
		}
	}
	
	public function deleteInvoice()
	{
		$this->m_invoice->deleteInvoice($_POST["invoice_id"]);
	}
	public function jsonListAddItem($cmpyclient_id) {

        $where = "";

        if (isset($_POST["sort"]) && !empty($_POST["sort"])) {
            foreach ($_POST["sort"] as $key => $value) {
                $_POST["sort"][$key] = str_replace("_sp_", ".", $value);
            }
        } else {
            $_POST["sort"][0]['direction'] = 'desc';
            $_POST["sort"][0]['field'] = 'v.dateupdate';
        }
		
        if (isset($_POST["search"]) && !empty($_POST["search"]))
            foreach ($_POST["search"] as $key => $value) {
                $_POST["search"][$key] = str_replace("_sp_", ".", $value);
            }
        
        $where.="v.cmpyclient_id='$cmpyclient_id' and ";
        $sql = 	"SELECT vc.vacancycandidate_id vc_sp_vacancycandidate_id, v.name v_sp_name,c.name c_sp_name,DATE_FORMAT(vc.date_join,'%d-%m-%Y') vc_sp_date_join,".
				"vc.approvedsalary vc_sp_approvedsalary,vc.approvedsalary_ccy vc_sp_approvedsalary_ccy ".
				"FROM hrsys_vacancy v ".
				"JOIN hrsys_vacancycandidate vc on v.vacancy_id=vc.vacancy_id ".
				"JOIN hrsys_candidate c on c.candidate_id=vc.candidate_id ".
				"WHERE ~search~ and $where v.status=1 and vc.closed=1 ORDER BY ~sort~";


        $data = $this->m_menu->w2grid($sql, $_POST);
        header("Content-Type: application/json;charset=utf-8");
        echo json_encode($data);
        exit();
    }
	
	public function jsonAddItem($vacancycandidate_id){
		$this->load->helper('evalmath');
		$evalMath= new EvalMath();
		
		$return=$this->m_invoice->getAddItemInvoice($vacancycandidate_id);
	
		
		$formula=$this->m_formula->getValue($this->sessionUserData["employee"]["consultant_code"],"invoice");


		$formula=str_replace("[salary]",$return["vc_sp_approvedsalary"],$formula);
	
		$formula=str_replace("[fee]",$return["v_sp_fee"],$formula);
		$return["bill"]=$evalMath->evaluate($formula);
	
		echo json_encode($return);		
	}
	public function det_invoice($invoice_id)
	{
		$site_url=  site_url();
		$breadcrumb[]=array("link"=>"$site_url/hrsys/invoice/list_invoice","text"=>"Search Invoice");
		$breadcrumb[]=array("link"=>"$site_url/hrsys/invoice/det_invoice/".$invoice_id,"text"=>"Detail Invoice");
		
		 $dataParse = array(
            "message"=>$message,
            "isEdit"=>$isEdit,
            "data"=>$this->m_invoice->get($invoice_id),
			"dataItem"=>$this->m_invoice->getItemByInvoice($invoice_id),  
            "breadcrumb"=>$breadcrumb,
			"message"=>$message
        );
        $this->loadContent('hrsys/invoice/det_invoice', $dataParse);
	}
	
	public function donwloadInvoice($invoice_id)
	{
		require_once APPPATH."/third_party/PHPWord/PHPWord.php"; 
		$PHPWord = new PHPWord();

		$data=$this->m_invoice->get($invoice_id);
		$items=$this->m_invoice->getItemByInvoice($invoice_id);
		$client=$this->m_client->get($data["cmpyclient_id"]);
			
		// New portrait section
		/*
		$section = $PHPWord->createSection();		
		$table = $section->addTable();
		$table->addRow();
		$table->addCell(5000)->addText("kri");
		$table->addCell(4000)->addText("Kanan");
		*/
		$path=$this->dir_template."report".DIRECTORY_SEPARATOR."template_invoice.docx";
		$path="template_invoice.docx";
		$document = $PHPWord->loadTemplate($path);
		//echo $path;
		//print_r($document);exit;
		
		
		$document->setValue('invoice_num', $data["invoice_num"]);
		$document->setValue('invoice_date', balikTgl($data["invoice_date"]));
		$document->setValue('invoice_due_date', balikTgl($data["due_date"]));		
		$document->setValue('cmpyclient_name', $client["name"]);		
		$document->setValue('cmpyclient_address', $client["address"]);
		

		/*
		$filename="Invoice ".$data["invoice_num"].'.docx'; //save our document as this file name
		header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
*/
		//$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
		$document->save('test.docx');

	}
	public function list_invoice()
	{
		
		$dataParse=array();
		 $this->loadContent('hrsys/invoice/list_invoice', $dataParse);

	}
	
	public function json_listInvoice()
	{
		if (isset($_POST["sort"]) && !empty($_POST["sort"])){
			foreach ($_POST["sort"] as $key => $value) {
                $_POST["sort"][$key] = str_replace("_sp_", ".", $value);
            }
		}else {
            $_POST["sort"][0]['direction'] = 'desc';
            $_POST["sort"][0]['field'] = 'inv.datecreate';
        }
            


        if (isset($_POST["search"]) && !empty($_POST["search"]))
            foreach ($_POST["search"] as $key => $value) {
                $_POST["search"][$key] = str_replace("_sp_", ".", $value);
            }

		$where="1=1 ";	
		

		
        $sql = "select inv.invoice_id rec_id,inv.invoice_num inv_sp_invoice_num,acc_manager.fullname acc_manager_sp_fullname,cli.name cli_sp_name,inv.invoice_date inv_sp_date,inv.due_date as inv_sp_due_date, inv.total_bill inv_sp_total_bill,inv.paid_date inv_sp_pay_day ".
		"from hrsys_invoice inv  ".
		"join hrsys_cmpyclient cli on inv.cmpyclient_id=cli.cmpyclient_id ".
		"left join hrsys_employee acc_manager on cli.account_manager=acc_manager.id ".
		"WHERE cli.consultant_code='".$this->sessionUserData["employee"]["consultant_code"]."' and ~search~ and $where  ORDER BY ~sort~";


        $data = $this->m_menu->w2grid($sql, $_POST);
        header("Content-Type: application/json;charset=utf-8");
        echo json_encode($data);
	}

}

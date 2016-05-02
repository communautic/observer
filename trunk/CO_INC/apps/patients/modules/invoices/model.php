<?php

class PatientsInvoicesModel extends PatientsModel {
	
	public function __construct() {  
     	parent::__construct();
		//$this->_phases = new PatientsPhasesModel();
		$this->_contactsmodel = new ContactsModel();
		$this->_treatmentsmodel = new PatientsTreatmentsModel();
	}


	function getList($id,$sort) {
		global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("patients-invoices-sort-status",$id);
		  if(!$sortstatus) {
				$order = "order by item_date DESC";
				$sortcur = '1';
		  } else {
			  switch($sortstatus) {
				  case "1":
				  		$order = "order by item_date DESC";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by item_date ASC";
							$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("patients-invoices-sort-order",$id);
				  		if(!$sortorder) {
								$order = "order by item_date DESC";
								$sortcur = '1';
						  } else {
								$order = "order by field(id,$sortorder)";
								$sortcur = '3';
						  }
				  break;	
			  }
		  }
	  } else {
		  switch($sort) {
				  case "1":
				  		$order = "order by item_date DESC";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by item_date ASC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("patients-invoices-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by item_date DESC";
								$sortcur = '1';
						  } else {
								$order = "order by field(id,$sortorder)";
								$sortcur = '3';
						  }
				  break;	
			  }
		}
	  
		$perm = $this->getPatientAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access_invoice = '1' ";
		}
		
		//$q = "SELECT a.*,CONCAT(b.lastname,', ',b.firstname) as title FROM " . CO_TBL_PATIENTS_TREATMENTS . " as a, co_users as b where a.tookpart='1' and a.cid=b.id and a.pid = '$id' and a.bin='0' and b.bin='0' ORDER BY title ASC";
		$q = "select id,title,item_date,access_invoice,status_invoice,checked_out,checked_out_user from " . CO_TBL_PATIENTS_TREATMENTS . " where pid = '$id' and (status='2' or status='3') and bin != '1' " . $sql . $order;
		$this->setSortStatus("patients-invoices-sort-status",$sortcur,$id);
		$result = mysql_query($q, $this->_db->connection);
		$items = mysql_num_rows($result);
		
		$invoices = "";
		
		while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			// access
			$accessstatus = "";
			if($perm !=  "guest") {
				if($array["access_invoice"] == 1) {
					$accessstatus = " module-access-active";
				}
			}
			$array["accessstatus"] = $accessstatus;
			// status
			$itemstatus = "";
			if($array["status_invoice"] == 0) {
				$itemstatus = " module-item-active-trial";
			}
			if($array["status_invoice"] == 1) {
				$itemstatus = " module-item-active-circle";
				//$itemstatus = " module-item-active-trial";
			}
			//if($array["status_invoice"] == 2) {
				//$itemstatus = " module-item-active-circle";
			//}
			if($array["status_invoice"] == 3) {
				$itemstatus = " module-item-active-storno";
			}
			$array["itemstatus"] = $itemstatus;
			
			$invoices[] = new Lists($array);
	  }
		
	  $arr = array("invoices" => $invoices, "items" => $items, "sort" => $sortcur, "perm" => $perm);
	  return $arr;
	}


	function getNavNumItems($id) {
		$perm = $this->getPatientAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access_invoice = '1' ";
		}
		$q = "select count(*) as items from " . CO_TBL_PATIENTS_TREATMENTS . " where pid = '$id' and (status='2' or status='3') and bin != '1'" . $sql;
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		$items = $row['items'];
		return $items;
	}


	function getDetails($id, $option = "") {
		global $session, $lang, $system;
		
		$this->_documents = new PatientsDocumentsModel();
		
		$q = "SELECT a.*,(SELECT MIN(item_date) FROM " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " as b WHERE b.mid=a.id and b.bin='0') as treatment_start,(SELECT MAX(item_date) FROM " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " as b WHERE b.mid=a.id and b.bin='0' and b.status='1') as treatment_end FROM " . CO_TBL_PATIENTS_TREATMENTS . "  as a where a.id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
		
		$patientid = $array["pid"];
		
		$q = "SELECT a.number,a.number_insurer,a.insurer, a.insurance, b.id as patient_id, b.lastname,b.firstname,b.title as ctitle,b.title2,b.position,b.phone1,b.email,b.address_line1,b.address_line2,b.address_town,b.address_postcode,b.bank_name,b.sort_code, b.account_number, b.bic, b.iban FROM " . CO_TBL_PATIENTS . " as a, co_users as b where a.cid=b.id and a.id = '$patientid'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}	
		$array['patient'] = $array['lastname'] . ' ' . $array['firstname'];
		$array['patient_address'] = $array['address_line1'] . ', ' . $array['address_postcode'] . ' ' . $array['address_town'];
		$array["perms"] = $this->getPatientAccess($array["pid"]);
		$array["canedit"] = false;
		$array["showCheckout"] = false;
		
		if($array["insurance"] != '') {
				$insurance_id = $array["insurance"];
				$insurance_q = "SELECT name, text from " . CO_TBL_PATIENTS_DIALOG_PATIENTS . " where id = '$insurance_id'";
				$result_insurance = mysql_query($insurance_q, $this->_db->connection);
				while($row_insurance = mysql_fetch_array($result_insurance)) {
					$array['insurance_name'] = $row_insurance['name'];
					$insurance_address = explode('</div>',$row_insurance['text']);
					$array['insurance_address_line_1'] = str_replace('<div class="regular">','',$insurance_address[0]);
					$array['insurance_address_line_2'] = str_replace('<div class="regular">','',$insurance_address[1]);
				}
				
		}
		
		if($array["perms"] == "sysadmin" || $array["perms"] == "admin") {
			$array["canedit"] = true;
		}
		
		$array["specialcanedit"] = false;
		
		$array["status_planned_active"] = "";
		$array["status_inprogress_active"] = "";
		$array["status_finished_active"] = "";
		$array["status_storno_active"] = "";
		//$array["status_date"] = $this->_date->formatDate($array["status_date"],CO_DATE_FORMAT);
		//$array["status_date"] = "";
		$array["status_text_time"] = "";
		switch($array["status_invoice"]) {
			case "0":
				$array["status_text"] = $lang["PATIENT_TREATMENT_STATUS_PLANNED"];
				$array["status_text_time"] = $lang["PATIENT_INVOICE_STATUS_PLANNED_TIME"];
				$array["status_planned_active"] = " active";
				//$array["status_date"] = $array["status_date"];
			break;
			case "1":
				$array["status_text"] = $lang["PATIENT_TREATMENT_STATUS_INPROGRESS"];
				$array["status_text_time"] = $lang["PATIENT_INVOICE_STATUS_INPROGRESS_TIME"];
				$array["status_inprogress_active"] = " active";
				//$array["status_date"] = $array["invoice_inprogress_date"];
			break;
			case "2":
				$array["status_text"] = $lang["PATIENT_TREATMENT_STATUS_FINISHED"];
				$array["status_text_time"] = $lang["PATIENT_INVOICE_STATUS_FINISHED_TIME"];
				$array["status_finished_active"] = " active";
				//$array["status_date"] = $array["invoice_finished_date"];
				$array["canedit"] = false;
				$array["specialcanedit"] = true;
			break;
			case "3":
				$array["status_text"] = $lang["PATIENT_INVOICE_STATUS_STORNO"];
				$array["status_text_time"] = $lang["PATIENT_INVOICE_STATUS_STORNO_TIME"];
				$array["status_storno_active"] = " active";
				//$array["status_date"] = $array["invoice_finished_date"];
				$array["canedit"] = false;
				$array["specialcanedit"] = true;
			break;
		}
		$array["status_date"] = $this->_date->formatDate($array["status_invoice_date"],CO_DATE_FORMAT);
		
		
		if($array['invoice_address'] == 0) {
			//$array['invoiceaddress'] = $array['patient'];
			//$array['invoiceaddress'] = $this->_contactsmodel->getUserListPlain($this->getPatientField($array["pid"],'insurer'),'invoice_address', "", $array["canedit"]);
			$array["invoiceaddress"] = $this->_contactsmodel->getUserList($array['insurer'], "invoice_address", "", $array["canedit"]);
		} else {
			$alt_invoice = $array['invoice_address'];
			$array["invoiceaddress_print"] = $this->_contactsmodel->getUserListPlain($array['invoice_address']);
			$array["invoiceaddress"] = $this->_contactsmodel->getUserList($array['invoice_address'],'invoice_address', "", $array["canedit"]);
			$q_alt = "SELECT lastname,firstname,title as ctitle,title2,position,phone1,email,address_line1,address_line2,address_town,address_postcode,bank_name, sort_code, account_number, bic, iban FROM co_users WHERE id = '$alt_invoice'";
			$result_alt = mysql_query($q_alt, $this->_db->connection);
			$row_alt = mysql_fetch_array($result_alt);
			foreach($row_alt as $key => $val) {
				$array[$key] = $val;
			}
		}
		
		//insurer field 
		$array["insurer"] = $this->_contactsmodel->getUserListPlain($array['insurer'],'insurer', "", $array["canedit"]);
		
		// dates
		$array["item_date"] = $this->_date->formatDate($array["item_date"],CO_DATE_FORMAT);
		$array["treatment_start"] = $this->_date->formatDate($array["treatment_start"],CO_DATE_FORMAT);
		$array["treatment_end"] = $this->_date->formatDate($array["treatment_end"],CO_DATE_FORMAT);
		$array["invoice_date"] = $this->_date->formatDate($array["invoice_date"],CO_DATE_FORMAT);
		$array["invoice_date_sent"] = $this->_date->formatDate($array["invoice_date_sent"],CO_DATE_FORMAT);
		$array["payment_reminder"] = $this->_date->formatDate($array["payment_reminder"],CO_DATE_FORMAT);
		//$array["invoice_carrier"] = $this->_contactsmodel->getUserListPlain($this->getPatientField($array["invoice_carrier"],'invoice_carrier'));
		$array["beleg_nummer"] = $system->formatBelegNummer($array["beleg_nummer"]);
		$array["beleg_datum"] = $this->_date->formatDate($array["beleg_datum"],CO_DATE_FORMAT);
		$array["beleg_time"] = $this->_date->formatDate($array["beleg_time"],CO_TIME_FORMAT);
		
		
		// time
		$array["today"] = $this->_date->formatDate("now",CO_DATE_FORMAT);
		
		$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		$array["current_user"] = $session->uid;
		
		
		if($array["invoice_carrier"] == 0) {
			$management_print = $this->getPatientField($array["pid"],'management');
		} else {
			//$array["invoice_carrier"] = $this->_contactsmodel->getUserList($array['invoice_carrier'],'invoice_carrier', "", $array["canedit"]);
			$management_print = $array["invoice_carrier"];
		}
		$q = "SELECT lastname as m_lastname,firstname as m_firstname,title2 as m_title, phone1 as m_phone, email as m_email, email_alt as m_email_alt, fax as m_fax, company as m_company, position as m_position, address_postcode as m_plz, address_town as m_town, address_line1 as m_street, company_no as m_co_no, company_reg_loc as m_legal, vat_no as m_vat, bank_name as m_bank, sort_code as m_sort_code, account_number as m_account_number, bic as m_bic, iban as m_iban, dvr as m_dvr FROM co_users where id = '$management_print'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		
		$array["management"] = $this->_contactsmodel->getUserListPlain($this->getPatientField($array["pid"],'management'));
		if($array["invoice_carrier"] == 0) {
			$array["invoice_carrier"] = $array["management"];
		} else {
			$array["invoice_carrier"] = $this->_contactsmodel->getUserList($array['invoice_carrier'],'invoice_carrier', "", $array["canedit"]);
		}
		
		$array["doctor_print"] = $this->_contactsmodel->getUserListPlain($array["doctor"]);
		$array["doctor"] = $this->_contactsmodel->getUserList($array['doctor'],'patientsdoctor', "", $array["canedit"]);
		$array["doctor_ct"] = empty($array["doctor_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['doctor_ct'];
		$array["documents"] = $this->_documents->getDocListFromIDs($array['documents'],'documents');
		$array["method"] = $this->_treatmentsmodel->getTreamentIdDetails($array["method"]);
		
		switch($array["access_invoice"]) {
			case "0":
				$array["access_text"] = $lang["GLOBAL_ACCESS_INTERNAL"];
				$array["access_footer"] = "";
			break;
			case "1":
				$array["access_text"] = $lang["GLOBAL_ACCESS_PUBLIC"];
				$array["access_user_invoice"] = $this->_users->getUserFullname($array["access_user"]);
				$array["access_date_invoice"] = $this->_date->formatDate($array["access_date"],CO_DATETIME_FORMAT);
				$array["access_footer"] = $lang["GLOBAL_ACCESS_FOOTER"] . " " . $array["access_user"] . ", " .$array["access_date"];
			break;
		}
		
		
		
		// checkpoint
		$array["checkpoint"] = 0;
		$array["checkpoint_date"] = "";
		$array["checkpoint_note"] = "";
		$q = "SELECT date,note FROM " . CO_TBL_USERS_CHECKPOINTS . " where uid='$session->uid' and app = 'patients' and module = 'invoices' and app_id = '$id' LIMIT 1";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			while ($row = mysql_fetch_assoc($result)) {
			$array["checkpoint"] = 1;
			$array["checkpoint_date"] = $this->_date->formatDate($row['date'],CO_DATE_FORMAT);
			$array["checkpoint_note"] = $row['note'];
			}
		}
		
		// get the tasks
		$array['totalcosts'] = 0;
		$task = array();
		$q = "SELECT * FROM " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " where status='1' and mid = '$id' and bin='0' ORDER BY item_date ASC";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$tasks[$key] = $val;
			}
			$tasks["time"] = $this->_date->formatDate($tasks["item_date"],CO_TIME_FORMAT);
			$tasks["item_date"] = $this->_date->formatDate($tasks["item_date"],CO_DATE_FORMAT);
			$tasks["team"] = $this->_contactsmodel->getUserList($tasks['team'],'task_team_'.$tasks["id"], "", $array["canedit"]);
			$tasks["team_ct"] = empty($tasks["team_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $tasks['team_ct'];
			if($tasks["type"] == '') {
				$tasks["min"] = 0;
				$tasks["costs"] = 0;
				$tasks["type"] = '';
			} else {
				
				$tasks["min"] = $this->_treatmentsmodel->getTreatmentTypeMin($tasks["type"]);
				$tasks["costs"] = $this->_treatmentsmodel->getTreatmentTypeCosts($tasks["type"]);
				$tasks["type"] = $this->_treatmentsmodel->getTreatmentArrayInvoice($tasks['type'],'task_treatmenttype_'.$tasks["id"], "", $array["canedit"]);
			}
			$tasks["place"] = $this->_contactsmodel->getPlaceList($tasks['place'],'place', $array["canedit"]);
			$array['totalcosts'] += $tasks["costs"];
			$task[] = new Lists($tasks);
		}
		if($array['discount'] != 0) {
			$array['discount_costs'] = ($array['totalcosts']/100)*$array['discount'];
			$array['discount_costs'] = number_format($array['discount_costs'],2,',','.');
			$array['totalcosts'] = $array['totalcosts']-(($array['totalcosts']/100)*$array['discount']);
		}
		if($array['vat'] != 0) {
			$array['vat_costs'] = ($array['totalcosts']/100)*$array['vat'];
			$array['vat_costs'] = number_format($array['vat_costs'],2,',','.');
			$array['totalcosts'] = $array['totalcosts']+(($array['totalcosts']/100)*$array['vat']);
		}
		$array['totalcosts'] = number_format($array['totalcosts'],2,',','.');
		
		// get the diagnoses
		/*$diagnose = array();
		$q = "SELECT * FROM " . CO_TBL_PATIENTS_TREATMENTS_DIAGNOSES . " where mid = '$id' and bin='0' ORDER BY sort";
		$result = mysql_query($q, $this->_db->connection);
		$array["diagnoses"] = mysql_num_rows($result);
		while($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$diagnoses[$key] = $val;
			}
			
			//$diagnoses['canvas'] = base64_encode($diagnoses['canvas']);
			//$diagnoses['canvas'] = str_replace('+',' ',$diagnoses['canvas']);
			$coord = explode('x',$diagnoses["xy"]);
			$diagnoses['x'] = $coord[0];
			$diagnoses['y'] = $coord[1];
			
			$diagnose[] = new Lists($diagnoses);
		}*/
		
		$sendto = $this->getSendtoDetails("patients_invoices",$id);

		$invoice = new Lists($array);
		$arr = array("invoice" => $invoice, "task" => $task, "sendto" => $sendto, "access" => $array["perms"]);
		return $arr;
   }

   function setDetails($pid,$id,$invoice_carrier,$invoice_date,$invoice_date_sent,$invoice_address,$payment_type,$invoice_number,$beleg_datum,$beleg_time,$payment_reminder,$protocol_payment_reminder,$protocol,$documents,$invoice_access,$invoice_access_orig) {
		global $session, $lang;
		$now = gmdate("Y-m-d H:i:s");
		$invoice_date = $this->_date->formatDate($invoice_date);
		$invoice_date_sent = $this->_date->formatDate($invoice_date_sent);
		$payment_reminder = $this->_date->formatDate($payment_reminder);
		
		$beleg_time = $this->_date->formatDateGMT( $beleg_time . " " . $end);
		$beleg_datum = $this->_date->formatDate($beleg_datum);
		
		
		if($invoice_access == $invoice_access_orig) {
			$accesssql = "";
		} else {
			$invoice_access_date = "";
			if($invoice_access == 1) {
				$invoice_access_date = $now;
			}
			$accesssql = ", access_invoice='$invoice_access', access_date_invoice='$invoice_access_date', access_invoice_user = '$session->uid'";
		}
		
		
		$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS . " set invoice_carrier='$invoice_carrier',invoice_date='$invoice_date', invoice_date_sent='$invoice_date_sent', invoice_address='$invoice_address', payment_type='$payment_type', invoice_number='$invoice_number',  beleg_datum='$beleg_datum', beleg_time='$beleg_time', payment_reminder='$payment_reminder', protocol_payment_reminder='$protocol_payment_reminder', protocol_invoice='$protocol', documents = '$documents'$accesssql where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return $id;
		}
   }
	 
	 function setBar($id) {
		global $session, $lang, $system;

		// patient id
		$q = "SELECT pid FROM " . CO_TBL_PATIENTS_TREATMENTS . " WHERE id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$pid = mysql_result($result,0);
		
		// manager id
		$q = "SELECT management FROM " . CO_TBL_PATIENTS . " WHERE id = '$pid'";
		$result = mysql_query($q, $this->_db->connection);
		$manager = mysql_result($result,0);
		
		$q = "SELECT MAX(beleg_nummer) FROM co_patients_treatments as a, co_patients as b WHERE b.management = '$manager' and a.pid=b.id;";
		$result = mysql_query($q, $this->_db->connection);
		$nummer = mysql_result($result,0);
		$nummer_neu = $nummer+1;
		
		$now = gmdate("Y-m-d H:i:s");
		$time = gmdate("Y-m-d H:i");

		$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS . " set payment_type='Barzahlung', beleg_nummer='$nummer_neu', beleg_datum='$now', beleg_time='$time' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);

		if ($result) {
			$array["beleg_nummer"] = $system->formatBelegNummer($nummer_neu);
			$array["beleg_datum"] = $this->_date->formatDate($now,CO_DATE_FORMAT);
			$array["beleg_time"] = $this->_date->formatDate($time,CO_TIME_FORMAT);
			return $array;
		}
   }
	 
	 function removeBar($id) {
		global $session, $lang;
		$now = gmdate("Y-m-d H:i:s");
		//$invoice_date = $this->_date->formatDate($invoice_date);

		$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS . " set payment_type='Überweisung', beleg_nummer='0', beleg_datum='0', beleg_time='0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return $id;
		}
   }


	function updateStatus($id,$date,$status) {
		global $session, $lang;
		
		$date = $this->_date->formatDate($date);
		$now = gmdate("Y-m-d H:i:s");
		
		$sql = "";
		if($status == 2) {
			$sql = ", payment_reminder = ''";
		}
		
		$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS . " set status_invoice = '$status', status_invoice_date = '$date', edited_user = '$session->uid', edited_date = '$now' $sql where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			$arr = array("id" => $id, "what" => "edit");
		}
		return $arr;
	}
	
	
	function newCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "INSERT INTO " . CO_TBL_USERS_CHECKPOINTS . " SET uid = '$session->uid', date = '$date', app = 'patients', module = 'invoices', app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

 	function updateCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "UPDATE " . CO_TBL_USERS_CHECKPOINTS . " SET date = '$date', status='0' WHERE uid = '$session->uid' and app = 'patients' and module = 'invoices' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

 	function deleteCheckpoint($id){
		global $session;
		$q = "DELETE FROM " . CO_TBL_USERS_CHECKPOINTS . " WHERE uid = '$session->uid'and app = 'patients' and module = 'invoices' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

	function updateCheckpointText($id,$text){
		global $session;
		$q = "UPDATE " . CO_TBL_USERS_CHECKPOINTS . " SET note = '$text' WHERE uid = '$session->uid' and app = 'patients' and module = 'invoices' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }
   
   function getCheckpointDetails($id){
		global $lang;
		$row = "";
		$q = "SELECT a.pid,a.title,b.folder FROM " . CO_TBL_PATIENTS_TREATMENTS . " as a, " . CO_TBL_PATIENTS . " as b WHERE a.pid = b.id and a.id='$id' and a.bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		if(mysql_num_rows($result) > 0) {
			$row['checkpoint_app_name'] = $lang["PATIENT_INVOICE_TITLE"];
			$row['app_id'] = $row['pid'];
			$row['app_id_app'] = $id;
		}
		return $row;
   }
	

    function updateQuestion($id,$field,$val){
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_PATIENTS_MEMBERS . " set $field = '$val' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		return true;
   }


}
?>
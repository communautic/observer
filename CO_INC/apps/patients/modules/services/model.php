<?php

class PatientsServicesModel extends PatientsModel {
	
	public function __construct() {  
     	parent::__construct();
		//$this->_phases = new PatientsPhasesModel();
		$this->_contactsmodel = new ContactsModel();
	}


	function getList($id,$sort) {
		global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("patients-services-sort-status",$id);
		  if(!$sortstatus) {
				$order = "order by title ASC";
				$sortcur = '1';
		  } else {
			  switch($sortstatus) {
				  case "1":
				  		$order = "order by title ASC";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by title DESC";
							$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("patients-services-sort-order",$id);
				  		if(!$sortorder) {
								$order = "order by title ASC";
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
				  		$order = "order by title ASC";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by title DESC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("patients-services-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by title ASC";
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
			$sql = " and access = '1' ";
		}
		
		$q = "select id,title,access,status,checked_out,checked_out_user from " . CO_TBL_PATIENTS_SERVICES . " where pid = '$id' and bin != '1' " . $sql . $order;
		$this->setSortStatus("patients-services-sort-status",$sortcur,$id);
		$result = mysql_query($q, $this->_db->connection);
		$items = mysql_num_rows($result);
		
		$services = "";
		while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			
			// access
			$accessstatus = "";
			if($perm !=  "guest") {
				if($array["access"] == 1) {
					$accessstatus = " module-access-active";
				}
			}
			$array["accessstatus"] = $accessstatus;
			// status
			$itemstatus = "";
			if($array["status"] == 2) {
				$itemstatus = " module-item-active";
			}
			if($array["status"] == 3) {
				$itemstatus = " module-item-active-stopped";
			}
			$array["itemstatus"] = $itemstatus;
			
			$checked_out_status = "";
			if($perm !=  "guest" && $array["checked_out"] == 1 && $array["checked_out_user"] != $session->uid) {
				if($session->checkUserActive($array["checked_out_user"])) {
					$checked_out_status = "icon-checked-out-active";
				} else {
					$this->checkinServiceOverride($id);
				}
			}
			$array["checked_out_status"] = $checked_out_status;
			
			
			$services[] = new Lists($array);
	  }
		
	  $arr = array("services" => $services, "items" => $items, "sort" => $sortcur, "perm" => $perm);
	  return $arr;
	}


	function getNavNumItems($id) {
		$perm = $this->getPatientAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		$q = "select count(*) as items from " . CO_TBL_PATIENTS_SERVICES . " where pid = '$id' and bin != '1' " . $sql;
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		$items = $row['items'];
		return $items;
	}
	

	function checkoutService($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_PATIENTS_SERVICES . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function checkinService($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_PATIENTS_SERVICES . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_PATIENTS_SERVICES . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}
	
	function checkinServiceOverride($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PATIENTS_SERVICES . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	

	function getDetails($id, $option = "") {
		global $session, $lang;
		
		$this->_documents = new PatientsDocumentsModel();
		
		$q = "SELECT * FROM " . CO_TBL_PATIENTS_SERVICES . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			
			
			
		$array["perms"] = $this->getPatientAccess($array["pid"]);
		$array["canedit"] = false;
		$array["showCheckout"] = false;
		$array["checked_out_user_text"] = $this->_contactsmodel->getUserListPlain($array['checked_out_user']);

		if($array["perms"] == "sysadmin" || $array["perms"] == "admin") {
			//if($array["checked_out"] == 1 && $session->checkUserActive($array["checked_out_user"])) {
			if($array["checked_out"] == 1) {
				if($array["checked_out_user"] == $session->uid) {
					$array["canedit"] = true;
				} else if(!$session->checkUserActive($array["checked_out_user"])) {
					$array["canedit"] = $this->checkoutService($id);
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
		$array["checked_out_user_phone1"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
		$array["checked_out_user_email"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");

				}
			} else {
				$array["canedit"] = $this->checkoutService($id);
			}
		}
		if($array["status"] == 2) {
			$q_invoice = "SELECT status_invoice FROM co_patients_treatments where service_id='$id'";
			$result_invoice = mysql_query($q_invoice, $this->_db->connection);
			$invoice_status = mysql_result($result_invoice,0);
		if($invoice_status == 2 || $invoice_status == 3) {
				$array["canedit"] = false;
				$array["specialcanedit"] = true;
		}
		}
		
		$array["invoice_no"] = CO_INVOICE_START;
		$q_invoice_no = "SELECT invoice_no FROM co_patients_treatments where service_id='$id'";
		$result_invoice_no = mysql_query($q_invoice_no, $this->_db->connection);
		if(mysql_num_rows($result_invoice_no) > 0) {
			$array["invoice_no"] = mysql_result($result_invoice_no,0);
		}
		
		$array["invoice_carrier"] = '';
		
		$q_invoice_no = "SELECT invoice_carrier FROM co_patients_treatments where service_id='$id'";
		$result_invoice_no = mysql_query($q_invoice_no, $this->_db->connection);
		if(mysql_num_rows($result_invoice_no) > 0) {
			$invoice_carrier = mysql_result($result_invoice_no,0);
			if($invoice_carrier != 0) {
				$qc = "SELECT invoice_addon FROM co_users where id = '$invoice_carrier'";
				$resultc = mysql_query($qc, $this->_db->connection);
				$array["invoice_carrier"] = mysql_result($resultc,0);
			}
		}
		
		$array["invoice_year"] = '';
		$q_invoice_no = "SELECT invoice_year FROM co_patients_treatments where service_id='$id'";
		$result_invoice_no = mysql_query($q_invoice_no, $this->_db->connection);
		if(mysql_num_rows($result_invoice_no) > 0) {
			$array["invoice_year"] = mysql_result($result_invoice_no,0);
		}

		$array["documents"] = $this->_documents->getDocListFromIDs($array['documents'],'documents');
		$array["copies"] = $this->getPatientTitleFromServiceIDs(explode(",",$array['copies']),'services');
		
		$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		$array["current_user"] = $session->uid;
		
		switch($array["access"]) {
			case "0":
				$array["access_text"] = $lang["GLOBAL_ACCESS_INTERNAL"];
				$array["access_footer"] = "";
			break;
			case "1":
				$array["access_text"] = $lang["GLOBAL_ACCESS_PUBLIC"];
				$array["access_user"] = $this->_users->getUserFullname($array["access_user"]);
				$array["access_date"] = $this->_date->formatDate($array["access_date"],CO_DATETIME_FORMAT);
				$array["access_footer"] = $lang["GLOBAL_ACCESS_FOOTER"] . " " . $array["access_user"] . ", " .$array["access_date"];
			break;
		}
		$array["status_planned_active"] = "";
		$array["status_inprogress_active"] = "";
		$array["status_finished_active"] = "";
		$array["status_stopped_active"] = "";
		$array["status_date"] = $this->_date->formatDate($array["status_date"],CO_DATE_FORMAT);
		switch($array["status"]) {
			case "0":
				$array["status_text"] = $lang["GLOBAL_STATUS_INPREPARATION"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_INPREPARATION_TIME"];
				$array["status_planned_active"] = " active";
			break;
			case "1":
				$array["status_date"] = "";
				$array["status_text"] = $lang["GLOBAL_STATUS_INPROGRESS"];
				$array["status_text_time"] = "";
				$array["status_inprogress_active"] = " active";
			break;
			case "2":
				$array["status_text"] = $lang["GLOBAL_STATUS_FINISHED"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_FINISHED_TIME"];
				$array["status_finished_active"] = " active";
				break;
			case "3":
				$array["status_text"] = $lang["GLOBAL_STATUS_STOPPED"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_STOPPED_TIME"];
				$array["status_stopped_active"] = " active";
			break;
		}
		
		// checkpoint
		$array["checkpoint"] = 0;
		$array["checkpoint_date"] = "";
		$array["checkpoint_note"] = "";
		$q = "SELECT date,note FROM " . CO_TBL_USERS_CHECKPOINTS . " where uid='$session->uid' and app = 'patients' and module = 'services' and app_id = '$id' LIMIT 1";
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
		$bar_compare_array = array();
		$task_bar = array();
		
		$q = "SELECT * FROM " . CO_TBL_PATIENTS_SERVICES_TASKS . " where mid = '$id' and bin='0' ORDER BY sort";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
		foreach($row as $key => $val) {
				$tasks[$key] = $val;
			}
			$tid = $tasks['id'];
			$tasks['taskcosts'] = 0;
			$tasks["menge"] = $tasks["menge"];
			
			$preiscalc = $tasks["preis"];
			$tasks['taskcosts'] = $tasks["menge"]*$preiscalc;
			$bar_compare_array[$tid]['title'] = $tasks["title"];
			$bar_compare_array[$tid]['costs'] = $tasks["taskcosts"];
			$tasks['preis_pretty'] = number_format($tasks["preis"], 2, ',', '.'); 
			$array['totalcosts'] += $tasks['taskcosts'];
			
			//$tasks["preis"] = $tasks["preis"],2,',','.');
			$task[] = new Lists($tasks);
		}
		
		// get tasks barzahlungen
		$q = "SELECT * FROM co_patients_services_tasks_bar WHERE sid='$id' ORDER BY id ASC";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
				foreach($row as $key => $val) {
					$tasks_bar[$key] = $val;
				}
				$task_bar[] = new Lists($tasks_bar);
		}
		
		if($array['discount'] != 0) {
			$array['totalcosts'] = $array['totalcosts']-(($array['totalcosts']/100)*$array['discount']);
		}
		if($array['vat'] != 0) {
			$array['totalcosts'] = $array['totalcosts']+(($array['totalcosts']/100)*$array['vat']);
		}
		
		$array['totalcosts'] = number_format($array['totalcosts'],2,',','.');
		
		$sendto = $this->getSendtoDetails("patients_services",$id);

		$service = new Lists($array);
		$arr = array("service" => $service, "task" => $task, "task_bar" => $task_bar, "bar_compare_array" => $bar_compare_array,"sendto" => $sendto, "access" => $array["perms"]);
		return $arr;
   }


   function setDetails($pid,$id,$title,$discount,$vat,$task_id,$task_title,$task_text2,$task_text3, $task,$task_sort,$documents,$service_access,$service_access_orig) {
		global $session, $lang;
		
		/*$start = $this->_date->formatDateGMT($servicedate . " " . $start);
		$end = $this->_date->formatDateGMT( $servicedate . " " . $end);
		$servicedate = $this->_date->formatDate($servicedate);
		$participants = $this->_contactsmodel->sortUserIDsByName($participants);
		$management = $this->_contactsmodel->sortUserIDsByName($management);*/

		$now = gmdate("Y-m-d H:i:s");

		
		if($service_access == $service_access_orig) {
			$accesssql = "";
		} else {
			$service_access_date = "";
			if($service_access == 1) {
				$service_access_date = $now;
			}
			$accesssql = "access='$service_access', access_date='$service_access_date', access_user = '$session->uid',";
		}
		
		$q = "UPDATE " . CO_TBL_PATIENTS_SERVICES . " set title = '$title', discount='$discount', vat='$vat', documents = '$documents', access='$service_access', $accesssql edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		// check for invoice
		$qi = "SELECT * FROM co_patients_treatments where service_id='$id'";
		$resulti = mysql_query($qi, $this->_db->connection);
		if(mysql_num_rows($resulti) > 0) {
			$qi = "UPDATE co_patients_treatments set title = '$title', discount = '$discount', vat = '$vat', edited_user = '$session->uid', edited_date = '$now' WHERE service_id='$id'";
			$resulti = mysql_query($qi, $this->_db->connection);
		}
		
		// do existing tasks
		$task_size = sizeof($task_id);
		$tasks_checked_size = sizeof($task);
		$servicestatus = $this->getStatus($id);
		$changeServiceStatus = 0; // 1 = st to planned 2 = set to complete
		// if only one see if phase is in progress or not
		if($task_size > 0) {
			if($servicestatus != 1 && $tasks_checked_size == 1) {
				$changeServiceStatus = 1;
			}
			if($servicestatus != 2 && $tasks_checked_size == $task_size) {
				$changeServiceStatus = 2;
			}
		}
		
		foreach ($task_id as $key => $value) {
			if (is_array($task)) {
				if (in_array($task_id[$key], $task) == true) {
					$checked_items[$key] = '1';
				} else {
					$checked_items[$key] = '0';
				}
			} else {
				$checked_items[$key] = '0';
			}
			
			//$preis = number_format((float)($task_text3[$key]), 2, '.', ''); 
			//echo $preis;
			$preis = str_replace('.', "", $task_text3[$key]);
			$preis = str_replace(',', ".", $preis);
			$preis = (float)$preis;
			
			$q = "UPDATE " . CO_TBL_PATIENTS_SERVICES_TASKS . " set status = '$checked_items[$key]', title = '$task_title[$key]', menge = '$task_text2[$key]', preis = '$preis' WHERE id='$task_id[$key]'";
			$result = mysql_query($q, $this->_db->connection);
		}
		$detailsFix = $this->getDetails($id);
		$service = $detailsFix['service'];
		if ($result) {
			//return $id;
			$arr = array("id" => $id, "totalcosts" => $service->totalcosts, "changeServiceStatus" => $changeServiceStatus);
			return $arr;
		}
   }
	 
	 function getStatus($id) {
		$q = "SELECT status FROM " . CO_TBL_PATIENTS_SERVICES . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		return mysql_result($result,0);
	}


   function updateStatus($id,$date,$status) {
		global $session, $lang;
		
		$date = $this->_date->formatDate($date);
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_PATIENTS_SERVICES . " set status = '$status', status_date = '$date', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			$arr = array("id" => $id, "what" => "edit");
		}

		$q = "SELECT invoice_no FROM co_patients_treatments WHERE service_id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			$invoice_no = $invoice_no = mysql_result($result,0);
			$num_sql = "";
			if($invoice_no == CO_INVOICE_START) {
				
				$q = "SELECT pid FROM " . CO_TBL_PATIENTS_SERVICES . " WHERE id = '$id'";
				$result = mysql_query($q, $this->_db->connection);
				$pid = mysql_result($result,0);
				
				$q = "SELECT management FROM " . CO_TBL_PATIENTS . " WHERE id = '$pid'";
				$result = mysql_query($q, $this->_db->connection);
				$manager = mysql_result($result,0);
				
				$nummer_neu = $this->generateInvoiceNo($manager);
				$num_sql = "invoice_no='$nummer_neu', payment_type='Barzahlung',";
			}
			//invoice exists so update the data
			$qs = "SELECT * FROM " . CO_TBL_PATIENTS_SERVICES . " where id = '$id'";
			$results = mysql_query($qs, $this->_db->connection);
			if(mysql_num_rows($results) < 1) {
				return false;
			}
			$rows = mysql_fetch_array($results);
			foreach($rows as $key => $val) {
					$array[$key] = $val;
				}
				
				$title = $array['title'];
				$discount = $array['discount'];
				$vat = $array['vat'];

		
			$qu = "UPDATE co_patients_treatments set title = '$title', discount = '$discount', vat = '$vat', $num_sql edited_user = '$session->uid', edited_date = '$now' WHERE service_id='$id'";
			$resultu = mysql_query($qu, $this->_db->connection);
			$this->checkinService($id);
			$arr = array("id" => $id, "what" => "reload");
			
			
		} else {
			//$invoice_no = mysql_result($result,0);
			if($status == 2) {
				
				$q = "SELECT pid FROM " . CO_TBL_PATIENTS_SERVICES . " WHERE id = '$id'";
				$result = mysql_query($q, $this->_db->connection);
				$pid = mysql_result($result,0);
				$this->generateInvoice($pid,$id);
			}
			
		}
		
		
		
			/*$q = "SELECT * FROM co_patients_treatments where service_id='$id'";
			$result = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result) > 0) {
				
				$q = "DELETE FROM co_patients_treatments where service_id='$id'";
				$result = mysql_query($q, $this->_db->connection);
			}
		*/
		
		
			return $arr;
		
		
		//$this->checkinService($id);
		// move to invoices / treatments
		/*if($status == 2) {
			
			$q = "SELECT * FROM " . CO_TBL_PATIENTS_SERVICES . " where id = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result) < 1) {
				return false;
			}
			$row = mysql_fetch_array($result);
			foreach($row as $key => $val) {
					$array[$key] = $val;
				}
				
				$pid = $array['pid'];
				$title = $array['title'];
				$discount = $array['discount'];
				$vat = $array['vat'];
				
				$q = "INSERT INTO co_patients_treatments set title = '$title', discount = '$discount', vat = '$vat',item_date='$now', pid = '$pid', invoice_type='1', service_id='$id',status = '2', status_date = '$now', status_invoice_date = '$now', invoice_date ='$now', payment_type='Überweisung', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
			$result = mysql_query($q, $this->_db->connection);

				
			$arr = array("id" => $id, "what" => "reload");
		} else {

			$arr = array("id" => $id, "what" => "reload");

		}

		return $arr;*/
	}


   function createNew($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		$time = gmdate("Y-m-d H");
		
		$q = "INSERT INTO " . CO_TBL_PATIENTS_SERVICES . " set title = '" . $lang["PATIENT_SERVICE_NEW"] . "', pid = '$id', status = '0', status_date = '$now', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		
		$task = $this->addTask($id,0,0);
		
		if ($result) {
			return $id;
		}
   }
   

   	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		// service
		$q = "INSERT INTO " . CO_TBL_PATIENTS_SERVICES . " (pid,title,vat,status_date,created_date,created_user,edited_date,edited_user) SELECT pid,CONCAT(title,' " . $lang["GLOBAL_DUPLICAT"] . "'),vat,'$now','$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_PATIENTS_SERVICES . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		// tasks
		$qt = "INSERT INTO " . CO_TBL_PATIENTS_SERVICES_TASKS . " (mid,status,title,menge,preis,sort) SELECT $id_new,'0',title,menge,preis,sort FROM " . CO_TBL_PATIENTS_SERVICES_TASKS . " where mid='$id' and bin='0'";
		$resultt = mysql_query($qt, $this->_db->connection);
		if ($result) {
			return $id_new;
		}
	}


   function binService($id) {
		global $session;
		//delete invoice
		$q = "DELETE FROM co_patients_treatments where service_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$q = "UPDATE " . CO_TBL_PATIENTS_SERVICES . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function restoreService($id) {
		$q = "UPDATE " . CO_TBL_PATIENTS_SERVICES . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deleteService($id) {
		$q = "SELECT id FROM " . CO_TBL_PATIENTS_SERVICES_TASKS . " WHERE mid = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$tid = $row["id"];
			$this->deleteServiceTask($tid);
		}
		
		$q = "DELETE FROM co_log_sendto WHERE what='patients_services' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_USERS_CHECKPOINTS . " WHERE app = 'patients' and module = 'services' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_PATIENTS_SERVICES . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function toggleIntern($id,$status) {
		global $session;
		$q = "UPDATE " . CO_TBL_PATIENTS_SERVICES . " set intern = '$status' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function addTask($mid,$num,$sort) {
		global $session, $lang;
		
		$q = "INSERT INTO " . CO_TBL_PATIENTS_SERVICES_TASKS . " set mid='$mid', status = '0', title = '" . $lang["PATIENT_SERVICE_TASK_NEW"] . "', menge='1', preis = '0.00', sort='$sort'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		
		$task = array();
		$q = "SELECT * FROM " . CO_TBL_PATIENTS_SERVICES_TASKS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$tasks[$key] = $val;
			}
			$tasks['preis_pretty'] = number_format($tasks["preis"], 2, ',', '.'); 
			$task[] = new Lists($tasks);
		}
		
		  	return $task;
   }


	function sortItems($task) {
		foreach($task as $key => $val) {
			$q = "UPDATE " . CO_TBL_PATIENTS_SERVICES_TASKS . " set sort = '$key' WHERE id='$val'";
			$result = mysql_query($q, $this->_db->connection);
		}
		return "true";
   }


   function deleteTask($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PATIENTS_SERVICES_TASKS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }
   
   function restoreServiceTask($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PATIENTS_SERVICES_TASKS . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }
   
   function deleteServiceTask($id) {
		global $session;
		$q = "DELETE FROM " . CO_TBL_PATIENTS_SERVICES_TASKS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }

	function newCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "INSERT INTO " . CO_TBL_USERS_CHECKPOINTS . " SET uid = '$session->uid', date = '$date', app = 'patients', module = 'services', app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

 	function updateCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "UPDATE " . CO_TBL_USERS_CHECKPOINTS . " SET date = '$date', status='0' WHERE uid = '$session->uid' and app = 'patients' and module = 'services' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

 	function deleteCheckpoint($id){
		global $session;
		$q = "DELETE FROM " . CO_TBL_USERS_CHECKPOINTS . " WHERE uid = '$session->uid'and app = 'patients' and module = 'services' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

	function updateCheckpointText($id,$text){
		global $session;
		$q = "UPDATE " . CO_TBL_USERS_CHECKPOINTS . " SET note = '$text' WHERE uid = '$session->uid' and app = 'patients' and module = 'services' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

    function getCheckpointDetails($id){
		global $lang;
		$row = "";
		$q = "SELECT a.pid,a.title,b.folder FROM " . CO_TBL_PATIENTS_SERVICES . " as a, " . CO_TBL_PATIENTS . " as b WHERE a.pid = b.id and a.id='$id' and a.bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		if(mysql_num_rows($result) > 0) {
			$row['checkpoint_app_name'] = $lang["PATIENT_SERVICE_TITLE"];
			$row['app_id'] = $row['pid'];
			$row['app_id_app'] = $id;
		}
		return $row;
   }


	function copyService($pid,$mid) {
		global $session, $lang;
		$now = gmdate("Y-m-d H:i:s");
		// service
		$q = "INSERT INTO " . CO_TBL_PATIENTS_SERVICES . " (pid,title,item_date,start,end,location,location_ct,length,management,management_ct,participants,participants_ct,status,status_date,documents,access,access_date,access_user,created_date,created_user,edited_date,edited_user) SELECT '$pid',title,item_date,start,end,location,location_ct,length,management,management_ct,participants,participants_ct,status,status_date,documents,access,access_date,access_user,'$now','$session->uid',edited_date,edited_user FROM " . CO_TBL_PATIENTS_SERVICES . " where id='$mid'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		// tasks
		$qt = "INSERT INTO " . CO_TBL_PATIENTS_SERVICES_TASKS . " (mid,status,title,text,sort) SELECT $id_new,status,title,text,sort FROM " . CO_TBL_PATIENTS_SERVICES_TASKS . " where mid='$mid' and bin='0'";
		$resultt = mysql_query($qt, $this->_db->connection);
		// update copies of service
		$qc = "SELECT copies FROM " . CO_TBL_PATIENTS_SERVICES . " where id='$mid'";
		$resultc = mysql_query($qc, $this->_db->connection);
		$copies = mysql_result($resultc,0);
		if($copies != "") {
			$copies .= ",";
		}
		$copies .= $id_new;
		$qc = "UPDATE " . CO_TBL_PATIENTS_SERVICES . " SET copies = '$copies' where id='$mid'";
		$resultc = mysql_query($qc, $this->_db->connection);
		
		if ($result) {
			$pro = array();
			$pro['title'] = $this->getPatientTitle($pid);
			$pro['titlelink'] = $this->getPatientTitleFromServiceIDs(explode(",",$id_new),'services');
			return $pro;
		}
	}
	
	
	function generateInvoiceNo($manager) {
		$q = "SELECT MAX(invoice_no) FROM co_patients_treatments as a, co_patients as b WHERE b.management = '$manager' and a.pid=b.id;";
		$result = mysql_query($q, $this->_db->connection);
		$nummer = mysql_result($result,0);
		$nummer_neu = $nummer+1;
		return $nummer_neu;
		
	}
	
	function generateInvoice($pid,$sid) {
		global $session, $lang, $system;
		
		// manager id
		$q = "SELECT management FROM " . CO_TBL_PATIENTS . " WHERE id = '$pid'";
		$result = mysql_query($q, $this->_db->connection);
		$manager = mysql_result($result,0);
		
		/*$q = "SELECT MAX(invoice_no) FROM co_patients_treatments as a, co_patients as b WHERE b.management = '$manager' and a.pid=b.id;";
		$result = mysql_query($q, $this->_db->connection);
		$nummer = mysql_result($result,0);
		$nummer_neu = $nummer+1;*/
		
		$nummer_neu = $this->generateInvoiceNo($manager);
		
		$now = gmdate("Y-m-d H:i:s");
		$time = gmdate("Y-m-d H:i");
		$year = date("Y");
		
		$q = "SELECT * FROM " . CO_TBL_PATIENTS_SERVICES . " where id = '$sid'";
			$result = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result) < 1) {
				return false;
			}
			$row = mysql_fetch_array($result);
			foreach($row as $key => $val) {
					$array[$key] = $val;
				}
				
				$pid = $array['pid'];
				$title = $array['title'];
				$discount = $array['discount'];
				$vat = $array['vat'];

		//$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS . " set invoice_carrier='$manager', status_invoice='0', status_invoice_date='$now', payment_type='Barzahlung', invoice_no='$nummer_neu', invoice_year='$year' where id='$id'";
		//$result = mysql_query($q, $this->_db->connection);

		
		$q = "INSERT INTO co_patients_treatments set title = '$title', discount = '$discount', vat = '$vat',item_date='$now', pid = '$pid', invoice_type='1', service_id='$sid',invoice_carrier='$manager', status='1', status_date='$now', status_invoice='0', status_invoice_date='$now', invoice_date='$now', payment_type='Barzahlung', invoice_no='$nummer_neu', invoice_year='$year', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
			$result = mysql_query($q, $this->_db->connection);

		if ($result) {
			$array["invoice_no"] = $system->formatInvoiceNumber($nummer_neu,$manager, $year);
			/*$array["beleg_datum"] = $this->_date->formatDate($now,CO_DATE_FORMAT);
			$array["beleg_time"] = $this->_date->formatDate($time,CO_TIME_FORMAT);*/
			//$array = array();
			return $array;
		}
   }
	 
	 
	 function getBarServiceTasks($id) {
		 
		 $q = "SELECT * FROM " . CO_TBL_PATIENTS_SERVICES_TASKS . " where mid = '$id' and bin='0' ORDER BY sort";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
		 
		 // get all calendar tasks
			/*$q = "SELECT a.id,a.bar,a.mid,a.status,a.type,a.text,a.item_date, b.eventlocation,b.eventlocationuid,b.startdate,b.enddate, b.id as eventid, c.id as calendarid, c.displayname, d.couid FROM " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " as a, oc_clndr_objects as b, oc_clndr_calendars as c, oc_users as d where a.mid = '$id' and b.calendarid = c.id and c.userid=d.uid and a.bin='0' and b.eventid = a.id ORDER BY b.startdate ASC";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				foreach($row as $key => $val) {
					$array[$key] = $val;
					
				}*/
				$tasks[] = new Lists($array); 
			}
			//$tasks[] = new Lists($task);
			//$array["tasks"] = $field;
		
		$arr = array("tasks" => $tasks);
	  return $arr;

	 }
	 
	 function generateBarzahlung($sid,$tasks) {
		 
		$tasks = json_decode($tasks);
		 
		// generate Barzahlung
		$bar_ids = '';
		foreach($tasks as $key => $val) {
			$bar_ids .= $val.',';
		}
		 
		$bar_ids = rtrim($bar_ids, ",");
		 
		$q = "insert into co_patients_services_tasks_bar set sid='$sid', task_ids='$bar_ids'";
		$result = mysql_query($q, $this->_db->connection);
			
		if ($result) {
			// now save bar to tasks
			foreach($tasks as $key => $val) {
				$task_id = $val;
				$q = "UPDATE " . CO_TBL_PATIENTS_SERVICES_TASKS . " set bar='1' where id='$task_id'";
				$result = mysql_query($q, $this->_db->connection);

		}
		}
		
		return true;

	}
	
	
	function deleteBarBeleg($id) {
		 
		$q = "select * FROM co_patients_services_tasks_bar where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			$beleg = mysql_fetch_assoc($result);
			$task_ids = explode(',', $beleg['task_ids']);
													
			foreach($task_ids as $key => $val) {
				$qt = "UPDATE " . CO_TBL_PATIENTS_SERVICES_TASKS . " set bar='0' where id='$val'";
				$resultt = mysql_query($qt, $this->_db->connection);
			}
			
			$q = "delete FROM co_patients_services_tasks_bar where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		return $task_ids;
		
		}
		 
			
		/*if ($result) {
			foreach($tasks as $key => $val) {
				$task_id = $val;
				$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " set bar='1' where id='$task_id'";
				$result = mysql_query($q, $this->_db->connection);

		}
		}*/
		
		//return true;

	}


}
?>
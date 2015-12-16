<?php

class PatientsReportsModel extends PatientsModel {
	
	public function __construct() {  
     	parent::__construct();
		$this->_contactsmodel = new ContactsModel();
		$this->_treatmentsmodel = new PatientsTreatmentsModel();
	}


	function getList($id,$sort) {
		global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("patients-reports-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("patients-reports-sort-order",$id);
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
				  		$sortorder = $this->getSortOrder("patients-reports-sort-order",$id);
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
			$sql = " and access = '1' ";
		}
		
		$q = "select id,title,item_date,access,checked_out,checked_out_user from " . CO_TBL_PATIENTS_REPORTS . " where pid = '$id' and bin != '1' " . $sql . $order;
		$this->setSortStatus("patients-reports-sort-status",$sortcur,$id);
		$result = mysql_query($q, $this->_db->connection);
		$items = mysql_num_rows($result);
		
		$reports = "";
		while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			
			// dates
			$array["item_date"] = $this->_date->formatDate($array["item_date"],CO_DATE_FORMAT);
			
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
			$array["itemstatus"] = $itemstatus;
			
			$checked_out_status = "";
			if($perm !=  "guest" && $array["checked_out"] == 1 && $array["checked_out_user"] != $session->uid) {
				if($session->checkUserActive($array["checked_out_user"])) {
					$checked_out_status = "icon-checked-out-active";
				} else {
					$this->checkinReportOverride($id);
				}
			}
			$array["checked_out_status"] = $checked_out_status;
			
			$reports[] = new Lists($array);
	  }
		
	  $arr = array("reports" => $reports, "items" => $items, "sort" => $sortcur, "perm" => $perm);
	  return $arr;
	}

	function getNavNumItems($id) {
		$perm = $this->getPatientAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		$q = "select count(*) as items from " . CO_TBL_PATIENTS_REPORTS . " where pid = '$id' and bin != '1' " . $sql;
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		$items = $row['items'];
		return $items;
	}

	function checkoutReport($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_PATIENTS_REPORTS . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function checkinReport($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_PATIENTS_REPORTS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_PATIENTS_REPORTS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}


	function checkinReportOverride($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PATIENTS_REPORTS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	

	function getDetails($id, $option = "") {
		global $session, $lang;
		
		$this->_documents = new PatientsDocumentsModel();
		
		$q = "SELECT * FROM " . CO_TBL_PATIENTS_REPORTS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		$patientid = $array["pid"];
		
		$q = "SELECT b.id as patient_id, b.lastname,b.firstname,b.title as ctitle,b.title2,b.position,b.phone1,b.email,b.address_line1,b.address_line2,b.address_town,b.address_postcode, b.company, b.position, a.* FROM " . CO_TBL_PATIENTS . " as a, co_users as b where a.cid=b.id and a.id = '$patientid'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			if($key != 'id' && $key != 'protocol') {
				$array[$key] = $val;
			}
		}	
		$array['patient'] = $array['lastname'] . ' ' . $array['firstname'];
		$array["dob"] = $this->_date->formatDate($array["dob"],CO_DATE_FORMAT);
		
		//$array["insurer"] = $this->_contactsmodel->getUserList($array['insurer'],'patientsinsurer', "", false);
		$array["insurer"] = trim($this->_users->getUserFullname($array["insurer"]));	
		$array["insurer_ct"] = empty($array["insurer_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['insurer_ct'];
		$array["insurance"] = $this->getPatientIdDetails($array["insurance"],"patientsinsurance");
			
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
					$array["canedit"] = $this->checkoutReport($id);
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
					$array["checked_out_user_phone1"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
					$array["checked_out_user_email"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");
				}
			} else {
				$array["canedit"] = $this->checkoutReport($id);
			}
		}
		
		// dates
		$array["item_date"] = $this->_date->formatDate($array["item_date"],CO_DATE_FORMAT);
		$recipient_print = $array["recipient"];
		$array["recipient"] = $this->_contactsmodel->getUserList($array['recipient'],'patientsrecipient', "", $array["canedit"]);
		$array["recipient_ct"] = empty($array["recipient_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['recipient_ct'];
		
		$array['r_title'] = '';
		$array['r_title2'] = '';
		$array['r_lastname'] = '';
		$array['r_firstname'] = '';
		$array['r_address_line1'] = '';
		$array['r_address_postcode'] = '';
		$array['r_address_town'] = '';
		
		if($recipient_print != "") {
			$qr = "SELECT lastname as r_lastname,firstname as r_firstname,title as r_title, title2 as r_title2, address_line1 as r_address_line1, address_postcode as r_address_postcode, address_town as r_address_town FROM co_users where id = '$recipient_print'";
			$resultr = mysql_query($qr, $this->_db->connection);
			$rowr = mysql_fetch_array($resultr);
			foreach($rowr as $key => $val) {
				$array[$key] = $val;
			}
		}

		/*if($option = 'prepareSendTo') {
			$array["sendtoTeam"] = $this->_contactsmodel->checkUserListEmail($array["management"],'patientsmanagement', "", $array["canedit"]);
			$array["sendtoTeamNoEmail"] = $this->_contactsmodel->checkUserListEmail($array["management"],'patientsmanagement', "", $array["canedit"], 0);
			$array["sendtoError"] = false;
		}*/
		$array["documents"] = $this->_documents->getDocListFromIDs($array['documents'],'documents');
		
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
		
		$sendto = $this->getSendtoDetails("patients_reports",$id);
		
		// get treatment info
		$array["treatment_title"] = '';
		$array["treatment_patient"] = '';
		$array["treatment_diagnose"] = '';
		$array["treatment_method"] = '';
		$array["treatment_date"] = '';
		$array["treatment_management"] = '';
		$array["treatment_doctor"] = '';
		$array["treatment_doctor_ct"] = '';
		$array["treatment_treats"] = '';
		
		
		$tid = $array["tid"];
		$qt = "SELECT * FROM co_patients_treatments where id = '$tid'";
		$resultt = mysql_query($qt, $this->_db->connection);
		if(mysql_num_rows($resultt) > 0) {
			$rowt = mysql_fetch_object($resultt);
			$array["treatment_title"] = $rowt->title;
			$array["treatment_diagnose"] = $rowt->protocol;
			$array["treatment_date"] = $this->_date->formatDate($rowt->item_date,CO_DATE_FORMAT);
			$array["treatment_doctor"] = trim($this->_users->getUserFullname($rowt->doctor));
			$array["treatment_doctor_ct"] = empty($rowt->doctor_ct) ? "" : $lang["TEXT_NOTE"] . " " . $rowt->doctor_ct;
			$array["treatment_treats"] = $rowt->protocol2;
			$array["treatment_method"] = $this->_treatmentsmodel->getTreamentIdDetails($rowt->method);
		}
		
		$pid = $array["pid"];
		$qu = "SELECT a.management,CONCAT(b.lastname,' ',b.firstname) as patient FROM co_patients as a, co_users as b where a.cid=b.id and a.id = '$pid'";
		$resultu = mysql_query($qu, $this->_db->connection);
		if(mysql_num_rows($resultu) > 0) {
			$rowu = mysql_fetch_object($resultu);
			$array["treatment_patient"] = $rowu->patient;
			$management_print = $rowu->management;
			$array["treatment_management"] = $this->_users->getUserFullname($rowu->management);
		}
		
		$q = "SELECT lastname as m_lastname,firstname as m_firstname,title2 as m_title, phone1 as m_phone, email as m_email, email_alt as m_email_alt, fax as m_fax, address_town as m_address_town FROM co_users where id = '$management_print'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
	
		$report = new Lists($array);
		$arr = array("report" => $report, "sendto" => $sendto, "access" => $array["perms"]);
		return $arr;
   }


function setDetailsTitle($pid,$id,$title,$reportdate) {
		global $session, $lang;
		
		$reportdate = $this->_date->formatDate($reportdate);
		$now = gmdate("Y-m-d H:i:s");

		$q = "UPDATE " . CO_TBL_PATIENTS_REPORTS . " set title = '$title', item_date = '$reportdate' , edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			$arr = array("id" => $id, "what" => "edit");
		}

		return $arr;
   }


   function setDetails($pid,$id,$title,$reportdate,$recipient,$recipient_ct,$protocol,$documents,$report_access,$report_access_orig) {
		global $session, $lang;
		
		$reportdate = $this->_date->formatDate($reportdate);

		$now = gmdate("Y-m-d H:i:s");
		
		if($report_access == $report_access_orig) {
			$accesssql = "";
		} else {
			$report_access_date = "";
			if($report_access == 1) {
				$report_access_date = $now;
			}
			$accesssql = "access='$report_access', access_date='$report_access_date', access_user = '$session->uid',";
		}

		$q = "UPDATE " . CO_TBL_PATIENTS_REPORTS . " set title = '$title', item_date = '$reportdate', recipient = '$recipient', recipient_ct = '$recipient_ct', protocol = '$protocol', documents = '$documents', access='$report_access', $accesssql edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
		$arr = array("id" => $id, "what" => "edit");
		}

		return $arr;
   }


   function createNew($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		$time = gmdate("Y-m-d H");
		
		$q = "INSERT INTO " . CO_TBL_PATIENTS_REPORTS . " set title = '" . $lang["PATIENT_REPORT_NEW"] . "', item_date='$now', pid = '$id',  created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
				
		if ($result) {
			return $id;
		}
   }
   

   	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		// report
		$q = "INSERT INTO " . CO_TBL_PATIENTS_REPORTS . " (pid,tid,title,item_date,protocol,protocol2,feedback,created_date,created_user,edited_date,edited_user) SELECT pid,tid,CONCAT(title,' " . $lang["GLOBAL_DUPLICAT"] . "'),'$now',protocol,protocol2,feedback,'$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_PATIENTS_REPORTS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		if ($result) {
			return $id_new;
		}
	}


   function binReport($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PATIENTS_REPORTS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function restoreReport($id) {
		$q = "UPDATE " . CO_TBL_PATIENTS_REPORTS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deleteReport($id) {
		
		$q = "DELETE FROM co_log_sendto WHERE what='patients_reports' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_PATIENTS_REPORTS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function toggleIntern($id,$status) {
		global $session;
		$q = "UPDATE " . CO_TBL_PATIENTS_REPORTS . " set intern = '$status' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function getReportsTreatmentsDialog($field,$sql) {
		global $session;
		$str = '<div class="dialog-text">';
		$q ="select id, title, item_date from co_patients_treatments WHERE pid='$sql' ORDER BY item_date DESC";
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$date = $this->_date->formatDate($row["item_date"],CO_DATE_FORMAT);
			$str .= '<a href="#" class="insertFromDialog" title="' . $row["title"] . '" field="'.$field.'" gid="'.$row["id"].'">' . $date . ' - ' . $row["title"] . '</a>';
		}
		$str .= '</div>';	
		return $str;
	 }


 	function setTreatmentID($pid,$tid) {
		global $session, $lang;

		$now = gmdate("Y-m-d H:i:s");

		$q = "UPDATE " . CO_TBL_PATIENTS_REPORTS . " set tid = '$tid', edited_user = '$session->uid', edited_date = '$now' where id='$pid'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}

	 }


}
?>
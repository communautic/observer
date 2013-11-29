<?php
//include_once(CO_PATH_BASE . "/model.php");
//include_once(dirname(__FILE__)."/model/folders.php");
//include_once(dirname(__FILE__)."/model/patients.php");

class PatientsModel extends Model {
	
	// Get all Patient Folders
   function getFolderList($sort) {
      global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("patients-folder-sort-status");
		  if(!$sortstatus) {
		  	$order = "order by a.title";
			$sortcur = '1';
		  } else {
			  switch($sortstatus) {
				  case "1":
				  		$order = "order by a.title";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by a.title DESC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("patients-folder-sort-order");
				  		if(!$sortorder) {
						  	$order = "order by a.title";
							$sortcur = '1';
						  } else {
							$order = "order by field(a.id,$sortorder)";
							$sortcur = '3';
						  }
				  break;
			  }
		  }
	  } else {
		  switch($sort) {
				  case "1":
				  		$order = "order by a.title";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by a.title DESC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("patients-folder-sort-order");
				  		if(!$sortorder) {
						  	$order = "order by a.title";
							$sortcur = '1';
						  } else {
							$order = "order by field(a.id,$sortorder)";
							$sortcur = '3';
						  }
				  break;	
			  }
	  }
	  
		if(!$session->isSysadmin()) {
			$q ="select a.id, a.title from " . CO_TBL_PATIENTS_FOLDERS . " as a where a.status='0' and a.bin = '0' and (SELECT count(*) FROM co_patients_access as b, co_patients as c WHERE (b.admins REGEXP '[[:<:]]" . $session->uid . "[[:>:]]' or b.guests REGEXP '[[:<:]]" . $session->uid . "[[:>:]]') and c.folder=a.id and b.pid=c.id) > 0 " . $order;
		} else {
			$q ="select a.id, a.title from " . CO_TBL_PATIENTS_FOLDERS . " as a where a.status='0' and a.bin = '0' " . $order;
		}
		
	  $this->setSortStatus("patients-folder-sort-status",$sortcur);
      $result = mysql_query($q, $this->_db->connection);
	  $folders = "";
	  while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
				if($key == "id") {
				$array["numPatients"] = $this->getNumPatients($val);
				}
			}
			$folders[] = new Lists($array);
		  
	  }
	  
	  $perm = "guest";
	  if($session->isSysadmin()) {
		  $perm = "sysadmin";
	  }
	  
	  $arr = array("folders" => $folders, "sort" => $sortcur, "access" => $perm);
	  
	  return $arr;
   }


  /**
   * get details for the patient folder
   */
   function getFolderDetails($id) {
		global $session, $contactsmodel, $patientsControllingModel, $lang;
		$q = "SELECT * FROM " . CO_TBL_PATIENTS_FOLDERS . " where id = '$id'";
		
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_assoc($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		$array["allpatients"] = $this->getNumPatients($id);
		$array["plannedpatients"] = $this->getNumPatients($id, $status="0");
		$array["activepatients"] = $this->getNumPatients($id, $status="1");
		$array["inactivepatients"] = $this->getNumPatients($id, $status="2");
		//$array["stoppedpatients"] = $this->getNumPatients($id, $status="3");
		
		/*$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);*/
		$array["today"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		
		
		$array["canedit"] = true;
		$array["access"] = "sysadmin";
 		if(!$session->isSysadmin()) {
			$array["canedit"] = false;
			$array["access"] = "guest";
		}
		
		$folder = new Lists($array);
		
		// get patient details
		$access="";
		if(!$session->isSysadmin()) {
			$access = " and a.id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
	  	}
		
		 $sortstatus = $this->getSortStatus("patients-sort-status",$id);
		if(!$sortstatus) {
		  	$order = "order by title";
		  } else {
			  switch($sortstatus) {
				  case "1":
				  		$order = "order by title";
				  break;
				  case "2":
				  		$order = "order by title DESC";
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("patients-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by title";
						  } else {
							$order = "order by field(a.id,$sortorder)";
						  }
				  break;	
			  }
		  }
		
		
		$q = "SELECT a.*,CONCAT(b.lastname,' ',b.firstname) as title FROM " . CO_TBL_PATIENTS . " as a, co_users as b WHERE a.folder='$id' and a.bin='0' and a.cid=b.id" . $access . " " . $order;
		$result = mysql_query($q, $this->_db->connection);
	  	$patients = "";
	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$patient[$key] = $val;
			}
			//$patient["management"] = $contactsmodel->getUserListPlain($patient['management']);
			$patient["perm"] = $this->getPatientAccess($patient["id"]);
			
		/*switch($patient["status"]) {
			case "0":
				$patient["status_text"] = $lang["GLOBAL_STATUS_TRIAL"];
				$patient["status_text_time"] = $lang["GLOBAL_STATUS_TRIAL_TIME"];
				$patient["status_date"] = $this->_date->formatDate($patient["planned_date"],CO_DATE_FORMAT);
			break;
			case "1":
				$patient["status_text"] = $lang["GLOBAL_STATUS_ACTIVE"];
				$patient["status_text_time"] = $lang["GLOBAL_STATUS_ACTIVE_TIME"];
				$patient["status_date"] = $this->_date->formatDate($patient["inprogress_date"],CO_DATE_FORMAT);
			break;
			case "2":
				$patient["status_text"] = $lang["GLOBAL_STATUS_MATERNITYLEAVE"];
				$patient["status_text_time"] = $lang["GLOBAL_STATUS_MATERNITYLEAVE_TIME"];
				$patient["status_date"] = $this->_date->formatDate($patient["finished_date"],CO_DATE_FORMAT);
			break;
			case "3":
				$patient["status_text"] = $lang["GLOBAL_STATUS_LEAVE"];
				$patient["status_text_time"] = $lang["GLOBAL_STATUS_LEAVE_TIME"];
				$patient["status_date"] = $this->_date->formatDate($patient["stopped_date"],CO_DATE_FORMAT);
			break;
		}*/
		
		
		switch($patient["status"]) {
			case "0":
				$patient["status_text"] = $lang["PATIENT_STATUS_PLANNED"];
				$patient["status_text_time"] = $lang["PATIENT_STATUS_PLANNED_TIME"];
				$patient["status_date"] = $this->_date->formatDate($patient["planned_date"],CO_DATE_FORMAT);
			break;
			case "1":
				$patient["status_text"] = $lang["PATIENT_STATUS_FINISHED"];
				$patient["status_text_time"] = $lang["PATIENT_STATUS_FINISHED_TIME"];
				$patient["status_date"] = $this->_date->formatDate($patient["finished_date"],CO_DATE_FORMAT);
			break;
			case "2":
				$patient["status_text"] = $lang["PATIENT_STATUS_STOPPED"];
				$patient["status_text_time"] = $lang["PATIENT_STATUS_STOPPED_TIME"];
				$patient["status_date"] = $this->_date->formatDate($patient["stopped_date"],CO_DATE_FORMAT);
			break;
		}
		
			
			$patients[] = new Lists($patient);
	  	}
		
		$access = "guest";
		  if($session->isSysadmin()) {
			  $access = "sysadmin";
		  }
		
		$arr = array("folder" => $folder, "patients" => $patients, "access" => $access);
		return $arr;
   }
   
   
   
     function getFolderDetailsInvoices($id, $view) {
		global $session, $contactsmodel, $patientsControllingModel, $lang;
		
		switch($view) {
			case 'Timeline':
				$order = "a.invoice_date DESC";
			break;
			case 'Patient':
				$order = "patient ASC";
			break;
			case 'Status':
				$order = "status_invoice ASC";
			break;
		}
		
		$q = "SELECT a.id,a.title,a.invoice_date,a.invoice_number,a.status_invoice, b.id as pid, b.management, CONCAT(c.lastname,' ',c.firstname) as patient FROM " . CO_TBL_PATIENTS_TREATMENTS . " as a, " . CO_TBL_PATIENTS . " as b, co_users as c WHERE a.status='2' and a.pid=b.id and b.folder='$id' and b.cid=c.id and a.bin='0' and b.bin='0' ORDER BY " . $order;
		
		
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		while($row = mysql_fetch_array($result)) {
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		$id = $array["id"];
		$array["invoice_date"] = $this->_date->formatDate($array["invoice_date"],CO_DATE_FORMAT);
		$array["management"] = $contactsmodel->getUserListPlain($array['management']);
		
		switch($array["status_invoice"]) {
			case 2:
				$array["status_invoice_class"] = 'barchart_color_finished';
			break;
			case 1:
				$array["status_invoice_class"] = 'barchart_color_inprogress';
				
			break;
			default:
				$array["status_invoice_class"] = 'barchart_color_planned';
		}
		
		// get the tasks
		$array['totalcosts'] = 0;
		$qt = "SELECT type FROM " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " where mid = '$id' and bin='0' ORDER BY item_date ASC";
		$resultt = mysql_query($qt, $this->_db->connection);
		$PatientsTreatmentsModel = new PatientsTreatmentsModel();
		if(mysql_num_rows($resultt) > 0) {
		while($rowt = mysql_fetch_array($resultt)) {
			if($rowt["type"] == '') {
				$costs = 0;
			} else {
				$costs = $PatientsTreatmentsModel->getTreatmentTypeCosts($rowt["type"]);
			}
			$array['totalcosts'] += $costs;
		}
		}
		/*if($array['discount'] != 0) {
			$array['discount_costs'] = ($array['totalcosts']/100)*$array['discount'];
			$array['discount_costs'] = number_format($array['discount_costs'],2,',','.');
			$array['totalcosts'] = $array['totalcosts']-(($array['totalcosts']/100)*$array['discount']);
		}*/
		$array['totalcosts'] = number_format($array['totalcosts'],2,',','.');
		
		
		$invoices[] = new Lists($array);
		
		}
		
				
		
		
		
		$access = "guest";
		  if($session->isSysadmin()) {
			  $access = "sysadmin";
		  }
		
		$arr = array("invoices" => $invoices, "access" => $access);
		return $arr;
   }
	
	
	function getFolderDetailsRevenueResults($id,$who,$start,$end) {
		global $session, $contactsmodel, $patientsControllingModel, $lang;
		
		$start = $this->_date->formatDate($start, "Y-m-d");
		$end = $this->_date->formatDate($end, "Y-m-d");
		$calctotal = 0;
		$management = "b.management='$who' and ";
		if($who == 0) {
			$management = '';
		}
		$folder = "b.folder='$id' and ";
		if($id == 0) {
			$folder = '';
		}
		
		$q = "SELECT a.id,a.title,a.invoice_date,a.status_invoice, b.id as pid, b.folder, b.management, CONCAT(c.lastname,' ',c.firstname) as patient FROM " . CO_TBL_PATIENTS_TREATMENTS . " as a, " . CO_TBL_PATIENTS . " as b, co_users as c WHERE $management $folder a.invoice_date >= '$start' and a.invoice_date <= '$end' and a.status='2' and a.pid=b.id and b.cid=c.id and a.bin='0' and b.bin='0'";
		
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		while($row = mysql_fetch_array($result)) {
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		$id = $array["id"];
		$array["invoice_date"] = $this->_date->formatDate($array["invoice_date"],CO_DATE_FORMAT);
		$array["management"] = $contactsmodel->getUserListPlain($array['management']);
		$manager = $array["management"];
		$array["showmanagertoitem"] = false;
		if($who == 0) {
			//$array["management"] = "";
			$manager = "";
			$array["showmanagertoitem"] = true;
		}
		switch($array["status_invoice"]) {
			case 2:
				$array["status_invoice_class"] = 'barchart_color_finished';
			break;
			case 1:
				$array["status_invoice_class"] = 'barchart_color_inprogress';
				
			break;
			default:
				$array["status_invoice_class"] = 'barchart_color_planned';
		}
		
		// get the tasks
		$array['totalcosts'] = 0;
		$qt = "SELECT type FROM " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " where mid = '$id' and bin='0' ORDER BY item_date ASC";
		$resultt = mysql_query($qt, $this->_db->connection);
		$PatientsTreatmentsModel = new PatientsTreatmentsModel();
		if(mysql_num_rows($resultt) > 0) {
		while($rowt = mysql_fetch_array($resultt)) {
			if($rowt["type"] == '') {
				$costs = 0;
			} else {
				$costs = $PatientsTreatmentsModel->getTreatmentTypeCosts($rowt["type"]);
			}
			$array['totalcosts'] += $costs;
		}
		}
		/*if($array['discount'] != 0) {
			$array['discount_costs'] = ($array['totalcosts']/100)*$array['discount'];
			$array['discount_costs'] = number_format($array['discount_costs'],2,',','.');
			$array['totalcosts'] = $array['totalcosts']-(($array['totalcosts']/100)*$array['discount']);
		}*/
		$calctotal += $array['totalcosts'];
		$array['totalcosts'] = number_format($array['totalcosts'],2,',','.');
		
		$invoices[] = new Lists($array);
		
		}
		$calctotal = number_format($calctotal,2,',','.');
		
		$access = "guest";
		  if($session->isSysadmin()) {
			  $access = "sysadmin";
		  }
		
		$arr = array("calctotal" => $calctotal, "invoices" => $invoices, "access" => $access, "manager" => $manager);
		return $arr;
	}
	
	

   /**
   * get details for the patient folder
   */
   function setFolderDetails($id,$title,$patientstatus) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_PATIENTS_FOLDERS . " set title = '$title', status = '$patientstatus', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }


   /**
   * create new patient folder
   */
	function newFolder() {
		global $session, $lang;
		$now = gmdate("Y-m-d H:i:s");
		$title = $lang["PATIENT_FOLDER_NEW"];
		
		$q = "INSERT INTO " . CO_TBL_PATIENTS_FOLDERS . " set title = '$title', status = '0', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	$id = mysql_insert_id();
			return $id;
		}
	}


   /**
   * delete patient folder
   */
   function binFolder($id) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_PATIENTS_FOLDERS . " set bin = '1', bintime = '$now', binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   
   function restoreFolder($id) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_PATIENTS_FOLDERS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deleteFolder($id) {
		$q = "SELECT id FROM " . CO_TBL_PATIENTS . " where folder = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$pid = $row["id"];
			$this->deletePatient($pid);
		}
		
		$q = "DELETE FROM " . CO_TBL_PATIENTS_FOLDERS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


  /**
   * get number of patients for a patient folder
   * status: 0 = all, 1 = active, 2 = abgeschlossen
   */   
   function getNumPatients($id, $status="") {
		global $session;
		
		$access = "";
		 if(!$session->isSysadmin()) {
			$access = " and id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
		  }
		
		if($status == "") {
			$q = "select id from " . CO_TBL_PATIENTS . " where folder='$id' " . $access . " and bin != '1'";
		} else {
			$q = "select id from " . CO_TBL_PATIENTS . " where folder='$id' " . $access . " and status = '$status' and bin != '1'";
		}
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_num_rows($result);
		return $row;
	}


	function getPatientTitle($id){
		global $session;
		//$q = "SELECT title FROM " . CO_TBL_PATIENTS . " where id = '$id'";
		$q = "SELECT CONCAT(b.lastname,' ',b.firstname) as title FROM " . CO_TBL_PATIENTS . " as a, co_users as b  where a.id = '$id' and a.cid=b.id";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		return $title;
   }


   	function getPatientTitleFromIDs($array){
		//$string = explode(",", $string);
		$total = sizeof($array);
		$data = '';
		
		if($total == 0) { 
			return $data; 
		}
		
		// check if patient is available and build array
		$arr = array();
		foreach ($array as &$value) {
			$q = "SELECT id,title FROM " . CO_TBL_PATIENTS . " where id = '$value' and bin='0'";
			//$q = "SELECT id, firstname, lastname FROM ".CO_TBL_USERS." where id = '$value' and bin='0'";
			$result = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result) > 0) {
				while($row = mysql_fetch_assoc($result)) {
					$arr[$row["id"]] = $row["title"];		
				}
			}
		}
		$arr_total = sizeof($arr);
		
		// build string
		$i = 1;
		foreach ($arr as $key => &$value) {
			$data .= $value;
			if($i < $arr_total) {
				$data .= ', ';
			}
			$data .= '';	
			$i++;
		}
		return $data;
   }


	function getPatientTitleLinkFromIDs($array,$target){
		$total = sizeof($array);
		$data = '';
		if($total == 0) { 
			return $data; 
		}
		$arr = array();
		$i = 0;
		foreach ($array as &$value) {
			$q = "SELECT a.id,a.folder,CONCAT(b.lastname,' ',b.firstname) as title FROM " . CO_TBL_PATIENTS . " as a, co_users as b  where a.id = '$value' and a.cid=b.id and a.bin='0' and b.bin='0'";
			$result = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result) > 0) {
				while($row = mysql_fetch_assoc($result)) {
					$arr[$i]["id"] = $row["id"];
					$arr[$i]["title"] = $row["title"];
					$arr[$i]["folder"] = $row["folder"];
					$i++;
				}
			}
		}
		$arr_total = sizeof($arr);
		$i = 1;
		foreach ($arr as $key => &$value) {
			$data .= '<a class="externalLoadThreeLevels" rel="' . $target. ','.$value["folder"].','.$value["id"].',1,patients">' . $value["title"] . '</a>';
			if($i < $arr_total) {
				$data .= '<br />';
			}
			$data .= '';	
			$i++;
		}
		return $data;
   }


function getPatientTitleFromMeetingIDs($array,$target, $link = 0){
		$total = sizeof($array);
		$data = '';
		if($total == 0) { 
			return $data; 
		}
		$arr = array();
		$i = 0;
		foreach ($array as &$value) {
			$qm = "SELECT pid,created_date FROM " . CO_TBL_PATIENTS_MEETINGS . " where id = '$value' and bin='0'";
			$resultm = mysql_query($qm, $this->_db->connection);
			if(mysql_num_rows($resultm) > 0) {
				$rowm = mysql_fetch_row($resultm);
				$pid = $rowm[0];
				$date = $this->_date->formatDate($rowm[1],CO_DATETIME_FORMAT);
				$q = "SELECT a.id,a.folder,CONCAT(b.lastname,' ',b.firstname) as title FROM " . CO_TBL_PATIENTS . " as a, co_users as b  where a.id = '$pid' and a.cid=b.id and a.bin='0' and b.bin='0'";
				$result = mysql_query($q, $this->_db->connection);
				if(mysql_num_rows($result) > 0) {
					while($row = mysql_fetch_assoc($result)) {
						$arr[$i]["id"] = $row["id"];
						$arr[$i]["item"] = $value;
						$arr[$i]["access"] = $this->getPatientAccess($row["id"]);
						$arr[$i]["title"] = $row["title"];
						$arr[$i]["folder"] = $row["folder"];
						$arr[$i]["date"] = $date;
						$i++;
					}
				}
			}
		}
		$arr_total = sizeof($arr);
		$i = 1;
		foreach ($arr as $key => &$value) {
			if($value["access"] == "" || $link == 0) {
				$data .= $value["title"] . ', ' . $value["date"];
			} else {
				$data .= '<a class="externalLoadThreeLevels" rel="' . $target. ','.$value["folder"].','.$value["id"].',' . $value["item"] . ',patients">' . $value["title"] . '</a>';
			}
			if($i < $arr_total) {
				$data .= '<br />';
			}
			$data .= '';	
			$i++;
		}
		return $data;
   }

   	function getPatientField($id,$field){
		global $session;
		$q = "SELECT $field FROM " . CO_TBL_PATIENTS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		return $title;
   }


  /**
   * get the list of patients for a patient folder
   */ 
   function getPatientList($id,$sort) {
      global $session,$contactsmodel;
	  
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("patients-sort-status",$id);
		  if(!$sortstatus) {
		  	$order = "order by title";
			$sortcur = '1';
		  } else {
			  switch($sortstatus) {
				  case "1":
				  		$order = "order by title";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by title DESC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("patients-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by title";
							$sortcur = '1';
						  } else {
							$order = "order by field(a.id,$sortorder)";
							$sortcur = '3';
						  }
				  break;	
			  }
		  }
	  } else {
		  switch($sort) {
				  case "1":
				  		$order = "order by title";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by title DESC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("patients-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by title";
							$sortcur = '1';
						  } else {
							$order = "order by field(a.id,$sortorder)";
							$sortcur = '3';
						  }
				  break;	
			  }
	  }
	  
	  $access = "";
	  if(!$session->isSysadmin()) {
		$access = " and a.id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
	  }
	  $q ="select a.id,CONCAT(b.lastname,' ',b.firstname) as title,a.status,a.checked_out,a.checked_out_user from " . CO_TBL_PATIENTS . " as a, co_users as b where a.cid=b.id and a.folder='$id' and a.bin = '0' " . $access . $order;

	  $this->setSortStatus("patients-sort-status",$sortcur,$id);
      $result = mysql_query($q, $this->_db->connection);
	  $patients = "";
	  while ($row = mysql_fetch_array($result)) {
		foreach($row as $key => $val) {
			$array[$key] = $val;
			if($key == "id") {
				if($this->getPatientAccess($val) == "guest") {
					$array["access"] = "guest";
					$array["iconguest"] = ' icon-guest-active"';
					$array["checked_out_status"] = "";
				} else {
					$array["iconguest"] = '';
					$array["access"] = "";
				}
			}
			
		}
		
		// status
		$itemstatus = "";
		switch($array["status"]) {
			case 0:
				$itemstatus = " module-item-active-trial";
			break;
			case 1:
				$itemstatus = " module-item-active-circle";
			break;
			case 2:
				$itemstatus = "";
			break;
	  	}
		$array["itemstatus"] = $itemstatus;
		
		$checked_out_status = "";
		if($array["access"] != "guest" && $array["checked_out"] == 1 && $array["checked_out_user"] != $session->uid) {
			if($session->checkUserActive($array["checked_out_user"])) {
				$checked_out_status = "icon-checked-out-active";
			} else {
				$this->checkinPatientOverride($id);
			}
		}
		$array["checked_out_status"] = $checked_out_status;
		
		$patients[] = new Lists($array);
	  }
	  $arr = array("patients" => $patients, "sort" => $sortcur);
	  return $arr;
   }
	
	
	function checkoutPatient($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_PATIENTS . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function checkinPatient($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_PATIENTS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_PATIENTS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}
	
	function checkinPatientOverride($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_PATIENTS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	

   function getPatientDetails($id,$option = "") {
		global $session, $contactsmodel, $lang;
		$this->_documents = new PatientsDocumentsModel();
		$q = "SELECT a.*,CONCAT(b.lastname,' ',b.firstname) as title,b.title as ctitle,b.title2,b.position,b.phone1,b.email FROM " . CO_TBL_PATIENTS . " as a, co_users as b where a.cid=b.id and a.id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		// perms
		$array["access"] = $this->getPatientAccess($id);
		if($array["access"] == "guest") {
			// check if this user is admin in some other patient
			$canEdit = $this->getEditPerms($session->uid);
			if(!empty($canEdit)) {
					$array["access"] = "guestadmin";
			}
		}
		$array["canedit"] = false;
		$array["showCheckout"] = false;
		$array["checked_out_user_text"] = $contactsmodel->getUserListPlain($array['checked_out_user']);

		if($array["access"] == "sysadmin" || $array["access"] == "admin") {
			//if($array["checked_out"] == 1 && $session->checkUserActive($array["checked_out_user"])) {
			if($array["checked_out"] == 1) {
				if($array["checked_out_user"] == $session->uid) {
					$array["canedit"] = true;
				} else if(!$session->checkUserActive($array["checked_out_user"])) {
					$array["canedit"] = $this->checkoutPatient($id);
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
					$array["checked_out_user_phone1"] = $contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
					$array["checked_out_user_email"] = $contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");
				}
			} else {
				$array["canedit"] = $this->checkoutPatient($id);
			}
		} // EOF perms
		
		// dates
		$array["avatar"] = $contactsmodel->_users->getAvatar($array["cid"]);
		$array["dob"] = $this->_date->formatDate($array["dob"],CO_DATE_FORMAT);
		$array["management_print"] = $contactsmodel->getUserListPlain($array['management']);
		$array["management"] = $contactsmodel->getUserList($array['management'],'patientsmanagement', "", $array["canedit"]);
		$array["management_ct"] = empty($array["management_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['management_ct'];

		$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
		
		// other functions
		$array["folder"] = $this->getPatientFolderDetails($array["folder"],"folder");		
		$array["insurance"] = $this->getPatientIdDetails($array["insurance"],"patientsinsurance");
		$array["documents"] = $this->_documents->getDocListFromIDs($array['documents'],'documents');
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		$array["current_user"] = $session->uid;
		
		$array["status_planned_active"] = "";
		$array["status_finished_active"] = "";
		$array["status_stopped_active"] = "";
		switch($array["status"]) {
			case "0":
				$array["status_text"] = $lang["PATIENT_STATUS_PLANNED"];
				$array["status_text_time"] = $lang["PATIENT_STATUS_PLANNED_TIME"];
				$array["status_planned_active"] = " active";
				$array["status_date"] = $this->_date->formatDate($array["planned_date"],CO_DATE_FORMAT);
			break;
			case "1":
				$array["status_text"] = $lang["PATIENT_STATUS_FINISHED"];
				$array["status_text_time"] = $lang["PATIENT_STATUS_FINISHED_TIME"];
				$array["status_finished_active"] = " active";
				$array["status_date"] = $this->_date->formatDate($array["finished_date"],CO_DATE_FORMAT);
			break;
			case "2":
				$array["status_text"] = $lang["PATIENT_STATUS_STOPPED"];
				$array["status_text_time"] = $lang["PATIENT_STATUS_STOPPED_TIME"];
				$array["status_stopped_active"] = " active";
				$array["status_date"] = $this->_date->formatDate($array["stopped_date"],CO_DATE_FORMAT);
			break;
		}
		
		// checkpoint
		$array["checkpoint"] = 0;
		$array["checkpoint_date"] = "";
		$array["checkpoint_note"] = "";
		$q = "SELECT date,note FROM " . CO_TBL_USERS_CHECKPOINTS . " where uid='$session->uid' and app = 'patients' and module = 'patients' and app_id = '$id' LIMIT 1";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			while ($row = mysql_fetch_assoc($result)) {
			$array["checkpoint"] = 1;
			$array["checkpoint_date"] = $this->_date->formatDate($row['date'],CO_DATE_FORMAT);
			$array["checkpoint_note"] = $row['note'];
			}
		}
		
		$patient = new Lists($array);
		
		$sql="";
		if($array["access"] == "guest") {
			$sql = " and a.access = '1' ";
		}
				
		$sendto = $this->getSendtoDetails("patients",$id);
		
		$arr = array("patient" => $patient, "sendto" => $sendto, "access" => $array["access"]);
		return $arr;
   }


   // Create patient folder title
	function getPatientFolderDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			$q = "SELECT id, title from " . CO_TBL_PATIENTS_FOLDERS . " where id = '$value'";
			$result_user = mysql_query($q, $this->_db->connection);
			while($row_user = mysql_fetch_assoc($result_user)) {
				$users .= '<span class="listmember" uid="' . $row_user["id"] . '">' . $row_user["title"] . '</span>';
				if($i < $users_total) {
					$users .= ', ';
				}
			}
			$i++;
		}
		return $users;
   }
   
   
   	function getPatientIdDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			if($field == "patientsinsurance") {
				$q = "SELECT id, name, text from " . CO_TBL_PATIENTS_DIALOG_PATIENTS . " where id = '$value'";
				$result_user = mysql_query($q, $this->_db->connection);
				while($row_user = mysql_fetch_assoc($result_user)) {
					$users .= '<span class="listmember-outer"><a class="listmemberInsurance" uid="' . $row_user["id"] . '">' . $row_user["name"] . '</a></div>';
					if($i < $users_total) {
						$users .= ', ';
					}
				}
			} else {
				$q = "SELECT id, name from " . CO_TBL_PATIENTS_DIALOG_PATIENTS . " where id = '$value'";
				$result_user = mysql_query($q, $this->_db->connection);
				while($row_user = mysql_fetch_assoc($result_user)) {
					$users .= '<span class="listmember" uid="' . $row_user["id"] . '">' . $row_user["name"] . '</span>';
					if($i < $users_total) {
						$users .= ', ';
					}
				}
			}
			$i++;
			
		}
		return $users;
   }

	
	function getInsuranceContext($id,$field){
		//$q = "SELECT id, firstname, lastname, company, position,phone1,phone2,fax,address_line1, address_town, address_postcode,email FROM ".CO_TBL_USERS." where id = '$id'";
		$q = "SELECT id, name, text from " . CO_TBL_PATIENTS_DIALOG_PATIENTS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		$array["field"] = $field;
		
		$context = new Lists($array); 
	  	return $context;
	}

   /**
   * get details for the patient folder
   */
   function setPatientDetails($id,$folder,$management,$management_ct,$protocol,$number,$insurance,$insuranceadd,$dob,$coo,$documents) {
		global $session, $contactsmodel;
		$dob = $this->_date->formatDate($dob);
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_PATIENTS . " set folder = '$folder', management='$management', management_ct='$management_ct', protocol = '$protocol', number = '$number', insurance = '$insurance', insurance_add = '$insuranceadd', dob = '$dob', coo = '$coo', documents = '$documents', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}



   function updateStatus($id,$date,$status) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		if($date == '') {
				$date = $now;
		} else {
			$date = $this->_date->formatDate($date);
		}		
		switch($status) {
			case "0":
				$sql = "planned_date";
			break;
			case "1":
				$sql = "finished_date";
			break;
			case "2":
				$sql = "stopped_date";
			break;
		}
		$q = "UPDATE " . CO_TBL_PATIENTS . " set status = '$status', $sql = '$date', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}


	function newPatient($id,$cid) {
		global $session, $contactsmodel, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		//$title = $lang["PATIENT_NEW"];
		$insurance_add = $lang["GLOBAL_NO"];
		
		$q = "INSERT INTO " . CO_TBL_PATIENTS . " set folder = '$id', cid='$cid', status = '0', planned_date = '$now',  management='$session->uid', insurance_add='$insurance_add', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			$id = mysql_insert_id();
			// if admin insert him to access
			if(!$session->isSysadmin()) {
				$patientsAccessModel = new PatientsAccessModel();
				$patientsAccessModel->setDetails($id,$session->uid,"");
			}
			return $id;
		}
	}
	
	
	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		// patient
		$q = "INSERT INTO " . CO_TBL_PATIENTS . " (folder,cid,management,management_ct,insurance,insurance_add,number,protocol,dob,coo,status,planned_date,created_date,created_user,edited_date,edited_user) SELECT folder,cid,management,management_ct,insurance,insurance_add,number,protocol,dob,coo,'0','$now','$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_PATIENTS . " where id='$id'";

		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		
		if(!$session->isSysadmin()) {
			$patientsAccessModel = new PatientsAccessModel();
			$patientsAccessModel->setDetails($id_new,$session->uid,"");
		}
		
		// documents_folder
		$patientsDocumentsModel = new PatientsDocumentsModel();
		$qd ="select id FROM " . CO_TBL_PATIENTS_DOCUMENTS_FOLDERS . " where pid = '$id' and bin='0'";
		$resultd = mysql_query($qd, $this->_db->connection);
		while ($rowd = mysql_fetch_array($resultd)) {
			$did = $rowd["id"];
			$patientsDocumentsModel->createDuplicate($did,$id_new);
		}
		
			
		// processes
		/*$q = "SELECT id FROM " . CO_TBL_PATIENTS_GRIDS . " WHERE pid = '$id' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$gridid = $row["id"];
		
			$qg = "INSERT INTO " . CO_TBL_PATIENTS_GRIDS . " (pid,title,owner,owner_ct,management,management_ct,team,team_ct,created_date,created_user,edited_date,edited_user) SELECT '$id_new',title,owner,owner_ct,management,management_ct,team,team_ct,'$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_PATIENTS_GRIDS . " where id='$gridid'";
			$resultg = mysql_query($qg, $this->_db->connection);
			$gridid_new = mysql_insert_id();
		
			// cols
			$qc = "SELECT * FROM " . CO_TBL_PATIENTS_GRIDS_COLUMNS . " WHERE pid = '$gridid' and bin='0'";
			$resultc = mysql_query($qc, $this->_db->connection);
			while($rowc = mysql_fetch_array($resultc)) {
				$colID = $rowc["id"];
				$sort = $rowc['sort'];
				$days = $rowc['days'];
				$qcn = "INSERT INTO " . CO_TBL_PATIENTS_GRIDS_COLUMNS . " set pid = '$gridid_new', sort='$sort', days='$days'";
				$resultcn = mysql_query($qcn, $this->_db->connection);
				$colID_new = mysql_insert_id();
				
				$qn = "SELECT * FROM " . CO_TBL_PATIENTS_GRIDS_NOTES . " where cid = '$colID' and bin='0'";
				$resultn = mysql_query($qn, $this->_db->connection);
				$num_notes[] = mysql_num_rows($resultn);
				$items = array();
				while($rown = mysql_fetch_array($resultn)) {
					$note_id = $rown["id"];
					$sort = $rown["sort"];
					$istitle = $rown["istitle"];
					$isstagegate = $rown["isstagegate"];
					$title = mysql_real_escape_string($rown["title"]);
					$text = mysql_real_escape_string($rown["text"]);
					//$ms = $rown["ms"];
					$qnn = "INSERT INTO " . CO_TBL_PATIENTS_GRIDS_NOTES . " set cid='$colID_new', sort = '$sort', istitle = '$istitle', isstagegate = '$isstagegate', title = '$title', text = '$text', created_date='$now',created_user='$session->uid',edited_date='$now',edited_user='$session->uid'";
					$resultnn = mysql_query($qnn, $this->_db->connection);
				}
			}
		}*/
		
		//vdocs
		/*$q = "SELECT id FROM " . CO_TBL_PATIENTS_VDOCS . " WHERE pid = '$id' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$vdocid = $row["id"];
			$qv = "INSERT INTO " . CO_TBL_PATIENTS_VDOCS . " (pid,title,content) SELECT '$id_new',title,content FROM " . CO_TBL_PATIENTS_VDOCS . " where id='$vdocid'";
			$resultv = mysql_query($qv, $this->_db->connection);
		}*/
		
		if ($result) {
			return $id_new;
		}
	}


	function binPatient($id) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_PATIENTS . " set bin = '1', bintime = '$now', binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	function restorePatient($id) {
		$q = "UPDATE " . CO_TBL_PATIENTS . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	function deletePatient($id) {
		global $patients;
		
		$active_modules = array();
		foreach($patients->modules as $module => $value) {
			if(CONSTANT('patients_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
			}
		}
		
		if(in_array("treatments",$active_modules)) {
			$patientsTreatmentsModel = new PatientsTreatmentsModel();
			$q = "SELECT id FROM co_patients_treatments where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$mid = $row["id"];
				$patientsTreatmentsModel->deleteTreatment($mid);
			}
		}
		
		if(in_array("reports",$active_modules)) {
			$patientsReportsModel = new PatientsReportsModel();
			$q = "SELECT id FROM co_patients_reports where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$mid = $row["id"];
				$patientsReportsModel->deleteReport($mid);
			}
		}
		
		if(in_array("meetings",$active_modules)) {
			$patientsMeetingsModel = new PatientsMeetingsModel();
			$q = "SELECT id FROM co_patients_meetings where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$mid = $row["id"];
				$patientsMeetingsModel->deleteMeeting($mid);
			}
		}
		
		if(in_array("documents",$active_modules)) {
			$patientsDocumentsModel = new PatientsDocumentsModel();
			$q = "SELECT id FROM co_patients_documents_folders where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$did = $row["id"];
				$patientsDocumentsModel->deleteDocument($did);
			}
		}
		
		if(in_array("comments",$active_modules)) {
			$patientsCommentsModel = new PatientsCommentsModel();
			$q = "SELECT id FROM co_patients_comments where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$pcid = $row["id"];
				$patientsCommentsModel->deleteComment($pcid);
			}
		}



		$q = "DELETE FROM co_log_sendto WHERE what='patients' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_USERS_CHECKPOINTS . " WHERE app = 'patients' and module = 'patients' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM co_patients_access WHERE pid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_PATIENTS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
		  	return true;
		}
		
	}


   function movePatient($id,$startdate,$movedays) {
		global $session, $contactsmodel;
		
		$startdate = $this->_date->formatDate($_POST['startdate']);
		
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_PATIENTS . " set startdate = '$startdate', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
			$qt = "SELECT id, startdate, enddate FROM " . CO_TBL_PATIENTS_PHASES_TASKS . " where pid='$id'";
			$resultt = mysql_query($qt, $this->_db->connection);
			while ($rowt = mysql_fetch_array($resultt)) {
				$tid = $rowt["id"];
				$startdate = $this->_date->addDays($rowt["startdate"],$movedays);
				$enddate = $this->_date->addDays($rowt["enddate"],$movedays);
				$qtk = "UPDATE " . CO_TBL_PATIENTS_PHASES_TASKS . " set startdate = '$startdate', enddate = '$enddate' where id='$tid'";
				$retvaltk = mysql_query($qtk, $this->_db->connection);
			}
		if ($result) {
			return true;
		}
	}


	function getPatientFolderDialog($field,$title) {
		global $session;
		$str = '<div class="dialog-text">';
		//$q ="select id, title from " . CO_TBL_PATIENTS_FOLDERS . " where status='0' and bin = '0' ORDER BY title";
		if(!$session->isSysadmin()) {
			$q ="select a.id, a.title from " . CO_TBL_PATIENTS_FOLDERS . " as a where a.status='0' and a.bin = '0' and (SELECT count(*) FROM co_patients_access as b, co_patients as c WHERE (b.admins REGEXP '[[:<:]]" . $session->uid . "[[:>:]]' or b.guests REGEXP '[[:<:]]" . $session->uid . "[[:>:]]') and c.folder=a.id and b.pid=c.id) > 0 ORDER BY title";
		} else {
			$q ="select id, title from " . CO_TBL_PATIENTS_FOLDERS . " where status='0' and bin = '0' ORDER BY title";
		}
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$str .= '<a href="#" class="insertPatientFolderfromDialog" title="' . $row["title"] . '" field="'.$field.'" gid="'.$row["id"].'">' . $row["title"] . '</a>';
		}
		$str .= '</div>';	
		return $str;
	 }


	function getPatientDialog($field,$sql) {
		global $session;
		$str = '<div class="dialog-text">';
		$q ="select id, name from " . CO_TBL_PATIENTS_DIALOG_PATIENTS . " WHERE cat = '$sql' ORDER BY name ASC";
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$str .= '<a href="#" class="insertFromDialog" title="' . $row["name"] . '" field="'.$field.'" gid="'.$row["id"].'">' . $row["name"] . '</a>';
		}
		$str .= '</div>';	
		return $str;
	 }


	// STATISTIKEN
   
   
	function numPhases($id,$status = 0, $sql="") {
	   //$sql = "";
	   if ($status == 2) {
		   $sql .= "and status='2'";
	   }
	   $q = "SELECT COUNT(id) FROM " .  CO_TBL_PATIENTS_PHASES. " WHERE pid='$id' $sql and bin='0'";
	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function numPhasesOnTime($id) {
	   //$q = "SELECT COUNT(id) FROM " .  CO_TBL_PATIENTS_PHASES. " WHERE pid='$id' $sql and bin='0'";
	   $q = "SELECT a.id,(SELECT MAX(enddate) FROM " . CO_TBL_PATIENTS_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as enddate FROM " . CO_TBL_PATIENTS_PHASES . " as a where a.pid= '$id' and a.status='2' and a.finished_date <= enddate";

	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function numPhasesTasks($id,$status = 0,$sql="") {
	   //$sql = "";
	   if ($status == 1) {
		   $sql .= " and status='1' ";
	   }
	   $q = "SELECT COUNT(id) FROM " .  CO_TBL_PATIENTS_PHASES_TASKS. " WHERE pid='$id' $sql and bin='0'";
	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function getRest($value) {
		return round(100-$value,2);
   }


   function getBin() {
		global $patients;
		
		$bin = array();
		$bin["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		$arr = array();
		$arr["bin"] = $bin;
		
		$arr["folders"] = "";
		$arr["pros"] = "";
		$arr["files"] = "";
		$arr["tasks"] = "";
		
		$active_modules = array();
		foreach($patients->modules as $module => $value) {
			if(CONSTANT('patients_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
				$arr[$module . "_cols"] = "";
				$arr[$module . "_diags"] = "";
			}
		}
		
		//foreach($active_modules as $module) {
							//$name = strtoupper($module);
							//$mod = new $name . "Model()";
							//include("modules/meetings/controller.php");
							//${$name} = new $name("$module");
							
						//}
		
		$q ="select id, title, bin, bintime, binuser from " . CO_TBL_PATIENTS_FOLDERS;
		$result = mysql_query($q, $this->_db->connection);
	  	while ($row = mysql_fetch_array($result)) {
			$id = $row["id"];
			if($row["bin"] == "1") { // deleted folders
				foreach($row as $key => $val) {
					$folder[$key] = $val;
				}
				$folder["bintime"] = $this->_date->formatDate($folder["bintime"],CO_DATETIME_FORMAT);
				$folder["binuser"] = $this->_users->getUserFullname($folder["binuser"]);
				$folders[] = new Lists($folder);
				$arr["folders"] = $folders;
			} else { // folder not binned
				
				$qp ="select a.id, a.bin, a.bintime, a.binuser, CONCAT(b.lastname,' ',b.firstname) as title from " . CO_TBL_PATIENTS . " as a, co_users as b WHERE a.folder = '$id' and a.cid=b.id";
				$resultp = mysql_query($qp, $this->_db->connection);
				while ($rowp = mysql_fetch_array($resultp)) {
					$pid = $rowp["id"];
					if($rowp["bin"] == "1") { // deleted patients
					foreach($rowp as $key => $val) {
						$pro[$key] = $val;
					}
					$pro["bintime"] = $this->_date->formatDate($pro["bintime"],CO_DATETIME_FORMAT);
					$pro["binuser"] = $this->_users->getUserFullname($pro["binuser"]);
					$pros[] = new Lists($pro);
					$arr["pros"] = $pros;
					} else {

						
						
						
						// objectives
						if(in_array("objectives",$active_modules)) {
							$qm ="select id, title, bin, bintime, binuser from " . CO_TBL_PATIENTS_OBJECTIVES . " where pid = '$pid'";
							$resultm = mysql_query($qm, $this->_db->connection);
							while ($rowm = mysql_fetch_array($resultm)) {
								$mid = $rowm["id"];
								if($rowm["bin"] == "1") { // deleted meeting
									foreach($rowm as $key => $val) {
										$objective[$key] = $val;
									}
									$objective["bintime"] = $this->_date->formatDate($objective["bintime"],CO_DATETIME_FORMAT);
									$objective["binuser"] = $this->_users->getUserFullname($objective["binuser"]);
									$objectives[] = new Lists($objective);
									$arr["objectives"] = $objectives;
								} else {
									// meetings_tasks
									$qmt ="select id, title, bin, bintime, binuser from " . CO_TBL_PATIENTS_OBJECTIVES_TASKS . " where mid = '$mid'";
									$resultmt = mysql_query($qmt, $this->_db->connection);
									while ($rowmt = mysql_fetch_array($resultmt)) {
										if($rowmt["bin"] == "1") { // deleted phases
											foreach($rowmt as $key => $val) {
												$objectives_task[$key] = $val;
											}
											$objectives_task["bintime"] = $this->_date->formatDate($objectives_task["bintime"],CO_DATETIME_FORMAT);
											$objectives_task["binuser"] = $this->_users->getUserFullname($objectives_task["binuser"]);
											$objectives_tasks[] = new Lists($objectives_task);
											$arr["objectives_tasks"] = $objectives_tasks;
										}
									}
								}
							}
						}
						
						
						// treatments
						if(in_array("treatments",$active_modules)) {
							$qm ="select id, title, bin, bintime, binuser from " . CO_TBL_PATIENTS_TREATMENTS . " where pid = '$pid'";
							$resultm = mysql_query($qm, $this->_db->connection);
							while ($rowm = mysql_fetch_array($resultm)) {
								$mid = $rowm["id"];
								if($rowm["bin"] == "1") { // deleted meeting
									foreach($rowm as $key => $val) {
										$treatment[$key] = $val;
									}
									$treatment["bintime"] = $this->_date->formatDate($treatment["bintime"],CO_DATETIME_FORMAT);
									$treatment["binuser"] = $this->_users->getUserFullname($treatment["binuser"]);
									$treatments[] = new Lists($treatment);
									$arr["treatments"] = $treatments;
								} else {
									// treatments_disgnoses
									$qmt ="select id, text, bin, bintime, binuser from " . CO_TBL_PATIENTS_TREATMENTS_DIAGNOSES . " where mid = '$mid'";
									$resultmt = mysql_query($qmt, $this->_db->connection);
									while ($rowmt = mysql_fetch_array($resultmt)) {
										if($rowmt["bin"] == "1") { // deleted phases
											foreach($rowmt as $key => $val) {
												$treatments_diag[$key] = $val;
											}
											$treatments_diag["bintime"] = $this->_date->formatDate($treatments_diag["bintime"],CO_DATETIME_FORMAT);
											$treatments_diag["binuser"] = $this->_users->getUserFullname($treatments_diag["binuser"]);
											$treatments_diags[] = new Lists($treatments_diag);
											$arr["treatments_diags"] = $treatments_diags;
										}
									}
									
									
									// treatments_tasks
									$qmt ="select id, title, bin, bintime, binuser from " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " where mid = '$mid'";
									$resultmt = mysql_query($qmt, $this->_db->connection);
									while ($rowmt = mysql_fetch_array($resultmt)) {
										if($rowmt["bin"] == "1") { // deleted phases
											foreach($rowmt as $key => $val) {
												$treatments_task[$key] = $val;
											}
											$treatments_task["bintime"] = $this->_date->formatDate($treatments_task["bintime"],CO_DATETIME_FORMAT);
											$treatments_task["binuser"] = $this->_users->getUserFullname($treatments_task["binuser"]);
											$treatments_tasks[] = new Lists($treatments_task);
											$arr["treatments_tasks"] = $treatments_tasks;
										}
									}
								}
							}
						}
	
						
						
						// reports
						if(in_array("reports",$active_modules)) {
							$qpc ="select id, title, bin, bintime, binuser from " . CO_TBL_PATIENTS_REPORTS . " where pid = '$pid'";
							$resultpc = mysql_query($qpc, $this->_db->connection);
							while ($rowpc = mysql_fetch_array($resultpc)) {
								if($rowpc["bin"] == "1") {
								$idp = $rowpc["id"];
									foreach($rowpc as $key => $val) {
										$report[$key] = $val;
									}
									$report["bintime"] = $this->_date->formatDate($report["bintime"],CO_DATETIME_FORMAT);
									$report["binuser"] = $this->_users->getUserFullname($report["binuser"]);
									$reports[] = new Lists($report);
									$arr["reports"] = $reports;
								}
							}
						}
						
	
						// meetings
						if(in_array("meetings",$active_modules)) {
							$qm ="select id, title, bin, bintime, binuser from " . CO_TBL_PATIENTS_MEETINGS . " where pid = '$pid'";
							$resultm = mysql_query($qm, $this->_db->connection);
							while ($rowm = mysql_fetch_array($resultm)) {
								$mid = $rowm["id"];
								if($rowm["bin"] == "1") { // deleted meeting
									foreach($rowm as $key => $val) {
										$meeting[$key] = $val;
									}
									$meeting["bintime"] = $this->_date->formatDate($meeting["bintime"],CO_DATETIME_FORMAT);
									$meeting["binuser"] = $this->_users->getUserFullname($meeting["binuser"]);
									$meetings[] = new Lists($meeting);
									$arr["meetings"] = $meetings;
								} else {
									// meetings_tasks
									$qmt ="select id, title, bin, bintime, binuser from " . CO_TBL_PATIENTS_MEETINGS_TASKS . " where mid = '$mid'";
									$resultmt = mysql_query($qmt, $this->_db->connection);
									while ($rowmt = mysql_fetch_array($resultmt)) {
										if($rowmt["bin"] == "1") { // deleted phases
											foreach($rowmt as $key => $val) {
												$meetings_task[$key] = $val;
											}
											$meetings_task["bintime"] = $this->_date->formatDate($meetings_task["bintime"],CO_DATETIME_FORMAT);
											$meetings_task["binuser"] = $this->_users->getUserFullname($meetings_task["binuser"]);
											$meetings_tasks[] = new Lists($meetings_task);
											$arr["meetings_tasks"] = $meetings_tasks;
										}
									}
								}
							}
						}
						

						
						
						// documents_folder
						if(in_array("documents",$active_modules)) {
							$qd ="select id, title, bin, bintime, binuser from " . CO_TBL_PATIENTS_DOCUMENTS_FOLDERS . " where pid = '$pid'";
							$resultd = mysql_query($qd, $this->_db->connection);
							while ($rowd = mysql_fetch_array($resultd)) {
								$did = $rowd["id"];
								if($rowd["bin"] == "1") { // deleted meeting
									foreach($rowd as $key => $val) {
										$documents_folder[$key] = $val;
									}
									$documents_folder["bintime"] = $this->_date->formatDate($documents_folder["bintime"],CO_DATETIME_FORMAT);
									$documents_folder["binuser"] = $this->_users->getUserFullname($documents_folder["binuser"]);
									$documents_folders[] = new Lists($documents_folder);
									$arr["documents_folders"] = $documents_folders;
								} else {
									// files
									$qf ="select id, filename, bin, bintime, binuser from " . CO_TBL_PATIENTS_DOCUMENTS . " where did = '$did'";
									$resultf = mysql_query($qf, $this->_db->connection);
									while ($rowf = mysql_fetch_array($resultf)) {
										if($rowf["bin"] == "1") { // deleted phases
											foreach($rowf as $key => $val) {
												$file[$key] = $val;
											}
											$file["bintime"] = $this->_date->formatDate($file["bintime"],CO_DATETIME_FORMAT);
											$file["binuser"] = $this->_users->getUserFullname($file["binuser"]);
											$files[] = new Lists($file);
											$arr["files"] = $files;
										}
									}
								}
							}
						}
						
						// comments
						if(in_array("comments",$active_modules)) {
							$qpc ="select id, title, bin, bintime, binuser from " . CO_TBL_PATIENTS_COMMENTS . " where pid = '$pid'";
							$resultpc = mysql_query($qpc, $this->_db->connection);
							while ($rowpc = mysql_fetch_array($resultpc)) {
								if($rowpc["bin"] == "1") {
								$idp = $rowpc["id"];
									foreach($rowpc as $key => $val) {
										$comment[$key] = $val;
									}
									$comment["bintime"] = $this->_date->formatDate($comment["bintime"],CO_DATETIME_FORMAT);
									$comment["binuser"] = $this->_users->getUserFullname($comment["binuser"]);
									$comments[] = new Lists($comment);
									$arr["comments"] = $comments;
								}
							}
						}
	

					}
				}
			}
	  	}
		
		//print_r($arr);
		//$mod = new Lists($mods);

		return $arr;
   }
   
   
   function emptyBin() {
		global $patients;
		
		$bin = array();
		$bin["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		$arr = array();
		$arr["bin"] = $bin;
		
		$arr["folders"] = "";
		$arr["pros"] = "";
		$arr["files"] = "";
		$arr["tasks"] = "";
		
		$active_modules = array();
		foreach($patients->modules as $module => $value) {
			if(CONSTANT('patients_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
				$arr[$module . "_cols"] = "";
				$arr[$module . "_diags"] = "";
			}
		}
		
		$q ="select id, title, bin, bintime, binuser from " . CO_TBL_PATIENTS_FOLDERS;
		$result = mysql_query($q, $this->_db->connection);
	  	while ($row = mysql_fetch_array($result)) {
			$id = $row["id"];
			if($row["bin"] == "1") { // deleted folders
				$this->deleteFolder($id);
			} else { // folder not binned
				
				$qp ="select a.id, a.bin, a.bintime, a.binuser, CONCAT(b.lastname,' ',b.firstname) as title from " . CO_TBL_PATIENTS . " as a, co_users as b WHERE a.folder = '$id' and a.cid=b.id";
				$resultp = mysql_query($qp, $this->_db->connection);
				while ($rowp = mysql_fetch_array($resultp)) {
					$pid = $rowp["id"];
					if($rowp["bin"] == "1") { // deleted patients
						$this->deletePatient($pid);
					} else {
						
						
						
						// objectives
						if(in_array("objectives",$active_modules)) {
							$patientsObjectivesModel = new PatientsObjectivesModel();
							$qm ="select id, title, bin, bintime, binuser from " . CO_TBL_PATIENTS_OBJECTIVES . " where pid = '$pid'";
							$resultm = mysql_query($qm, $this->_db->connection);
							while ($rowm = mysql_fetch_array($resultm)) {
								$mid = $rowm["id"];
								if($rowm["bin"] == "1") { // deleted meeting
									$patientsObjectivesModel->deleteObjective($mid);
									$arr["objectives"] = "";
								} else {
									// objectives_tasks
									$qmt ="select id, title, bin, bintime, binuser from " . CO_TBL_PATIENTS_OBJECTIVES_TASKS . " where mid = '$mid'";
									$resultmt = mysql_query($qmt, $this->_db->connection);
									while ($rowmt = mysql_fetch_array($resultmt)) {
										if($rowmt["bin"] == "1") { // deleted phases
											$mtid = $rowmt["id"];
											$patientsObjectivesModel->deleteObjectiveTask($mtid);
											$arr["objectives_tasks"] = "";
										}
									}
								}
							}
						}
						
						
						// treatments
						if(in_array("treatments",$active_modules)) {
							$patientsTreatmentsModel = new PatientsTreatmentsModel();
							$qm ="select id, title, bin, bintime, binuser from " . CO_TBL_PATIENTS_TREATMENTS . " where pid = '$pid'";
							$resultm = mysql_query($qm, $this->_db->connection);
							while ($rowm = mysql_fetch_array($resultm)) {
								$mid = $rowm["id"];
								if($rowm["bin"] == "1") { // deleted meeting
									$patientsTreatmentsModel->deleteTreatment($mid);
									$arr["treatments"] = "";
								} else {
									// treatments_disgnoses
									$qmt ="select id, text, bin, bintime, binuser from " . CO_TBL_PATIENTS_TREATMENTS_DIAGNOSES . " where mid = '$mid'";
									$resultmt = mysql_query($qmt, $this->_db->connection);
									while ($rowmt = mysql_fetch_array($resultmt)) {
										if($rowmt["bin"] == "1") { // deleted phases
											$mtid = $rowmt["id"];
											$patientsTreatmentsModel->deleteTreatmentDiagnose($mtid);
											$arr["objectives_diags"] = "";
										}
									}
									// treatments_tasks
									$qmt ="select id, title, bin, bintime, binuser from " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " where mid = '$mid'";
									$resultmt = mysql_query($qmt, $this->_db->connection);
									while ($rowmt = mysql_fetch_array($resultmt)) {
										if($rowmt["bin"] == "1") { // deleted phases
											$mtid = $rowmt["id"];
											$patientsTreatmentsModel->deleteTreatmentTask($mtid);
											$arr["treatments_tasks"] = "";
										}
									}
								}
							}
						}
	
						// reports
						if(in_array("reports",$active_modules)) {
							$patientsReportsModel = new PatientsReportsModel();
							$qpc ="select id, title, bin, bintime, binuser from " . CO_TBL_PATIENTS_REPORTS . " where pid = '$pid'";
							$resultpc = mysql_query($qpc, $this->_db->connection);
							while ($rowpc = mysql_fetch_array($resultpc)) {
								$mid = $rowpc["id"];
								if($rowpc["bin"] == "1") {
									$patientsReportsModel->deleteReport($mid);
									$arr["reports"] = "";
								}
							}
						}

						// meetings
						if(in_array("meetings",$active_modules)) {
							$patientsMeetingsModel = new PatientsMeetingsModel();
							$qm ="select id, title, bin, bintime, binuser from " . CO_TBL_PATIENTS_MEETINGS . " where pid = '$pid'";
							$resultm = mysql_query($qm, $this->_db->connection);
							while ($rowm = mysql_fetch_array($resultm)) {
								$mid = $rowm["id"];
								if($rowm["bin"] == "1") { // deleted meeting
									$patientsMeetingsModel->deleteMeeting($mid);
									$arr["meetings"] = "";
								} else {
									// meetings_tasks
									$qmt ="select id, title, bin, bintime, binuser from " . CO_TBL_PATIENTS_MEETINGS_TASKS . " where mid = '$mid'";
									$resultmt = mysql_query($qmt, $this->_db->connection);
									while ($rowmt = mysql_fetch_array($resultmt)) {
										if($rowmt["bin"] == "1") { // deleted phases
											$mtid = $rowmt["id"];
											$patientsMeetingsModel->deleteMeetingTask($mtid);
											$arr["meetings_tasks"] = "";
										}
									}
								}
							}
						}


						// documents_folder
						if(in_array("documents",$active_modules)) {
							$patientsDocumentsModel = new PatientsDocumentsModel();
							$qd ="select id, title, bin, bintime, binuser from " . CO_TBL_PATIENTS_DOCUMENTS_FOLDERS . " where pid = '$pid'";
							$resultd = mysql_query($qd, $this->_db->connection);
							while ($rowd = mysql_fetch_array($resultd)) {
								$did = $rowd["id"];
								if($rowd["bin"] == "1") { // deleted meeting
									$patientsDocumentsModel->deleteDocument($did);
									$arr["documents_folders"] = "";
								} else {
									// files
									$qf ="select id, filename, bin, bintime, binuser from " . CO_TBL_PATIENTS_DOCUMENTS . " where did = '$did'";
									$resultf = mysql_query($qf, $this->_db->connection);
									while ($rowf = mysql_fetch_array($resultf)) {
										if($rowf["bin"] == "1") { // deleted phases
											$fid = $rowf["id"];
											$patientsDocumentsModel->deleteFile($fid);
											$arr["files"] = "";
										}
									}
								}
							}
						}
	
	
						// comments
						if(in_array("comments",$active_modules)) {
							$patientsCommentsModel = new PatientsCommentsModel();
							$qc ="select id, title, bin, bintime, binuser from " . CO_TBL_PATIENTS_COMMENTS . " where pid = '$pid'";
							$resultc = mysql_query($qc, $this->_db->connection);
							while ($rowc = mysql_fetch_array($resultc)) {
								$cid = $rowc["id"];
								if($rowc["bin"] == "1") {
									$patientsCommentsModel->deleteComment($cid);
									$arr["comments"] = "";
								}
							}
						}



					}
				}
			}
	  	}
		return $arr;
   }


	// User Access
	function getEditPerms($id) {
		global $session;
		$perms = array();
		$q = "SELECT a.pid FROM co_patients_access as a, co_patients as b WHERE a.pid=b.id and b.bin='0' and a.admins REGEXP '[[:<:]]" . $id . "[[:>:]]' ORDER by b.cid ASC";
      	$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$perms[] = $row["pid"];
		}
		return $perms;
   }


   function getViewPerms($id) {
		global $session;
		$perms = array();
		$q = "SELECT a.pid FROM co_patients_access as a, co_patients as b WHERE a.pid=b.id and b.bin='0' and a.guests REGEXP '[[:<:]]" . $id. "[[:>:]]' ORDER by b.cid ASC";
      	$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$perms[] = $row["pid"];
		}
		return $perms;
   }


   function canAccess($id) {
	   global $session;
	   return array_merge($this->getViewPerms($id),$this->getEditPerms($id));
   }


   function getPatientAccess($pid) {
		global $session;
		$access = "";
		if(in_array($pid,$this->getViewPerms($session->uid))) {
			$access = "guest";
		}
		if(in_array($pid,$this->getEditPerms($session->uid))) {
			$access = "admin";
		}
		/*if($this->isOwnerPerms($pid,$session->uid)) {
			$access = "owner";
		}*/
		if($session->isSysadmin()) {
			$access = "sysadmin";
		}
		return $access;
   }
   
   
   function setContactAccessDetails($id, $cid, $username, $password) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$pwd = md5($password);
		
		$q = "INSERT INTO " . CO_TBL_PATIENTS_ORDERS_ACCESS . "  set uid = '$id', cid = '$cid', username = '$username', password = '$pwd', access_user = '$session->uid', access_date = '$now', access_status=''";
		
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	
	function removeAccess($id,$cid) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "DELETE FROM " . CO_TBL_PATIENTS_ORDERS_ACCESS . " where uid='$id' and cid = '$cid'";
		
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
  
  
 	function getNavModulesNumItems($id) {
		global $patients;
		$active_modules = array();
		foreach($patients->modules as $module => $value) {
			$active_modules[] = $module;
		}
		if(in_array("grids",$active_modules)) {
			$patientsGridsModel = new PatientsGridsModel();
			$data["patients_grids_items"] = $patientsGridsModel->getNavNumItems($id);
		}
		if(in_array("forums",$active_modules)) {
			$patientsForumsModel = new PatientsForumsModel();
			$data["patients_forums_items"] = $patientsForumsModel->getNavNumItems($id);
		}
		if(in_array("objectives",$active_modules)) {
			$patientsObjectivesModel = new PatientsObjectivesModel();
			$data["patients_objectives_items"] = $patientsObjectivesModel->getNavNumItems($id);
		}
		if(in_array("treatments",$active_modules)) {
			$patientsTreatmentsModel = new PatientsTreatmentsModel();
			$data["patients_treatments_items"] = $patientsTreatmentsModel->getNavNumItems($id);
		}
		if(in_array("reports",$active_modules)) {
			$patientsReportsModel = new PatientsReportsModel();
			$data["patients_reports_items"] = $patientsReportsModel->getNavNumItems($id);
		}
		if(in_array("invoices",$active_modules)) {
			$patientsInvoicesModel = new PatientsInvoicesModel();
			$data["patients_invoices_items"] = $patientsInvoicesModel->getNavNumItems($id);
		}
		if(in_array("meetings",$active_modules)) {
			$patientsMeetingsModel = new PatientsMeetingsModel();
			$data["patients_meetings_items"] = $patientsMeetingsModel->getNavNumItems($id);
		}
		if(in_array("phonecalls",$active_modules)) {
			$patientsPhonecallsModel = new PatientsPhonecallsModel();
			$data["patients_phonecalls_items"] = $patientsPhonecallsModel->getNavNumItems($id);
		}
		if(in_array("documents",$active_modules)) {
			$patientsDocumentsModel = new PatientsDocumentsModel();
			$data["patients_documents_items"] = $patientsDocumentsModel->getNavNumItems($id);
		}
		if(in_array("vdocs",$active_modules)) {
			$patientsVDocsModel = new PatientsVDocsModel();
			$data["patients_vdocs_items"] = $patientsVDocsModel->getNavNumItems($id);
		}
		if(in_array("comments",$active_modules)) {
			$patientsCommentsModel = new PatientsCommentsModel();
			$data["patients_comments_items"] = $patientsCommentsModel->getNavNumItems($id);
		}
		return $data;
	}


	function newCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "INSERT INTO " . CO_TBL_USERS_CHECKPOINTS . " SET uid = '$session->uid', date = '$date', app = 'patients', module = 'patients', app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

 	function updateCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "UPDATE " . CO_TBL_USERS_CHECKPOINTS . " SET date = '$date', status='0' WHERE uid = '$session->uid' and app = 'patients' and module = 'patients' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

 	function deleteCheckpoint($id){
		$q = "DELETE FROM " . CO_TBL_USERS_CHECKPOINTS . " WHERE app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

	function updateCheckpointText($id,$text){
		global $session;
		$q = "UPDATE " . CO_TBL_USERS_CHECKPOINTS . " SET note = '$text' WHERE uid = '$session->uid' and app = 'patients' and module = 'patients' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

    function getCheckpointDetails($app,$module,$id){
		global $lang, $session, $patients;
		$row = "";
		if($app =='patients' && $module == 'patients') {
			//$q = "SELECT folder FROM " . CO_TBL_PATIENTS . " WHERE id='$id' and bin='0'";
			$q = "SELECT a.folder,CONCAT(b.lastname,' ',b.firstname) as title FROM " . CO_TBL_PATIENTS . " as a, co_users as b where a.cid=b.id and a.id = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			$row = mysql_fetch_array($result);
			if(mysql_num_rows($result) > 0) {
				$row['checkpoint_app_name'] = $lang["PATIENT_TITLE"];
				$row['app_id_app'] = '0';
			}
			return $row;
		} else {
			$active_modules = array();
			foreach($patients->modules as $m => $v) {
					$active_modules[] = $m;
			}
			if($module == 'treatments' && in_array("treatments",$active_modules)) {
				include_once("modules/".$module."/config.php");
				include_once("modules/".$module."/lang/" . $session->userlang . ".php");
				include_once("modules/".$module."/model.php");
				$patientsTreatmentsModel = new PatientsTreatmentsModel();
				$row = $patientsTreatmentsModel->getCheckpointDetails($id);
				return $row;
			}
			if($module == 'meetings' && in_array("meetings",$active_modules)) {
				include_once("modules/".$module."/config.php");
				include_once("modules/".$module."/lang/" . $session->userlang . ".php");
				include_once("modules/".$module."/model.php");
				$patientsMeetingsModel = new PatientsMeetingsModel();
				$row = $patientsMeetingsModel->getCheckpointDetails($id);
				return $row;
			}
			if($module == 'invoices' && in_array("invoices",$active_modules)) {
				include_once("modules/treatments/config.php");
				include_once("modules/treatments/lang/" . $session->userlang . ".php");
				include_once("modules/treatments/model.php");
				include_once("modules/treatments/controller.php");
				include_once("modules/".$module."/config.php");
				include_once("modules/".$module."/lang/" . $session->userlang . ".php");
				include_once("modules/".$module."/model.php");
				$patientsInvoicesModel = new PatientsInvoicesModel();
				$row = $patientsInvoicesModel->getCheckpointDetails($id);
				return $row;
			}
		}
   }


	function getGlobalSearch($term){
		global $system, $session, $patients;
		$num=0;
		//$term = utf8_decode($term);
		$access=" ";
		if(!$session->isSysadmin()) {
			$access = " and id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
	  	}
		$rows = array();
		$r = array();
		
		// get all active modules
		$active_modules = array();
		foreach($patients->modules as $m => $v) {
			$active_modules[] = $m;
		}
		
		$q = "SELECT a.id, a.folder, CONCAT(b.lastname,' ',b.firstname) as title FROM " . CO_TBL_PATIENTS . " as a, co_users as b WHERE (b.lastname like '%$term%' or b.firstname like '%$term%') and  a.bin='0' and a.cid=b.id" . $access ."ORDER BY title";
		$result = mysql_query($q, $this->_db->connection);
		//$num=mysql_affected_rows();
		while($row = mysql_fetch_array($result)) {
			 $rows['value'] = htmlspecialchars_decode($row['title']);
			 $rows['id'] = 'patients,' .$row['folder']. ',' . $row['id'] . ',0,patients';
			 $r[] = $rows;
		}
		// loop through
		$q = "SELECT id, folder FROM " . CO_TBL_PATIENTS . " WHERE bin='0'" . $access ."ORDER BY id";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$pid = $row['id'];
			$folder = $row['folder'];
			$sql = "";
			$perm = $this->getPatientAccess($pid);
			if($perm == 'guest') {
				$sql = "and access = '1'";
			}
			
			// Objectives
			if(in_array("objectives",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_PATIENTS_OBJECTIVES . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'objectives,' .$folder. ',' . $pid . ',' .$rowp['id'].',patients';
					$r[] = $rows;
				}
				// Meeting Tasks
				$qp = "SELECT b.id,CONVERT(a.title USING latin1) as title FROM " . CO_TBL_PATIENTS_OBJECTIVES_TASKS . " as a, " . CO_TBL_PATIENTS_OBJECTIVES . " as b WHERE b.pid = '$pid' and a.mid = b.id and a.bin = '0' and b.bin = '0' $sql and a.title like '%$term%' ORDER BY a.title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'objectives,' .$folder. ',' . $pid . ',' .$rowp['id'].',patients';
					$r[] = $rows;
				}
			}
			
			// Treatments
			if(in_array("treatments",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_PATIENTS_TREATMENTS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'treatments,' .$folder. ',' . $pid . ',' .$rowp['id'].',patients';
					$r[] = $rows;
				}
				// Treatments Diags
				$qp = "SELECT b.id,CONVERT(a.text USING latin1) as title FROM " . CO_TBL_PATIENTS_TREATMENTS_DIAGNOSES . " as a, " . CO_TBL_PATIENTS_TREATMENTS . " as b WHERE b.pid = '$pid' and a.mid = b.id and a.bin = '0' and b.bin = '0' $sql and a.text like '%$term%' ORDER BY a.text";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'treatments,' .$folder. ',' . $pid . ',' .$rowp['id'].',patients';
					$r[] = $rows;
				}
				// Treatments Tasks
				$qp = "SELECT b.id,CONVERT(a.title USING latin1) as title FROM " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " as a, " . CO_TBL_PATIENTS_TREATMENTS . " as b WHERE b.pid = '$pid' and a.mid = b.id and a.bin = '0' and b.bin = '0' $sql and a.title like '%$term%' ORDER BY a.title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'treatments,' .$folder. ',' . $pid . ',' .$rowp['id'].',patients';
					$r[] = $rows;
				}
			}
			
			
			// Reports
			if(in_array("reports",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_PATIENTS_REPORTS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'reports,' .$folder. ',' . $pid . ',' .$rowp['id'].',patients';
					$r[] = $rows;
				}
			}
			
			// Meetings
			if(in_array("meetings",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_PATIENTS_MEETINGS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'meetings,' .$folder. ',' . $pid . ',' .$rowp['id'].',patients';
					$r[] = $rows;
				}
				// Meeting Tasks
				$qp = "SELECT b.id,CONVERT(a.title USING latin1) as title FROM " . CO_TBL_PATIENTS_MEETINGS_TASKS . " as a, " . CO_TBL_PATIENTS_MEETINGS . " as b WHERE b.pid = '$pid' and a.mid = b.id and a.bin = '0' and b.bin = '0' $sql and a.title like '%$term%' ORDER BY a.title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'meetings,' .$folder. ',' . $pid . ',' .$rowp['id'].',patients';
					$r[] = $rows;
				}
			}
			
			// Doc Folders
			if(in_array("documents",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_PATIENTS_DOCUMENTS_FOLDERS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'documents,' .$folder. ',' . $pid . ',' .$rowp['id'].',patients';
					$r[] = $rows;
				}
				// Documents
				$qp = "SELECT b.id,CONVERT(a.filename USING latin1) as title FROM " . CO_TBL_PATIENTS_DOCUMENTS . " as a, " . CO_TBL_PATIENTS_DOCUMENTS_FOLDERS . " as b WHERE b.pid = '$pid' and a.did = b.id and a.bin = '0' and b.bin = '0' and a.filename like '%$term%' ORDER BY a.filename";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'documents,' .$folder. ',' . $pid . ',' .$rowp['id'].',patients';
					$r[] = $rows;
				}
			}
			// Comments
			if(in_array("comments",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_PATIENTS_COMMENTS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'comments,' .$folder. ',' . $pid . ',' .$rowp['id'].',patients';
					$r[] = $rows;
				}
			}
			
		}
		return json_encode($r);
	}
	
	
	function getChartPerformance($id, $what, $image = 1) { 
		global $lang;
		switch($what) {
			case 'happiness':
				$q = "SELECT * FROM " . CO_TBL_PATIENTS_OBJECTIVES . " WHERE pid = '$id' and status = '1' and bin = '0' ORDER BY item_date DESC LIMIT 0,1";
				$result = mysql_query($q, $this->_db->connection);
				$num = mysql_num_rows($result);
				$i = 1;
				while($row = mysql_fetch_assoc($result)) {
					// Tab 1 questios
					$tab1result = 0;
					if(!empty($row["tab1q1"])) { $tab1result += $row["tab1q1"]; }
					if(!empty($row["tab1q2"])) { $tab1result += $row["tab1q2"]; }
					if(!empty($row["tab1q3"])) { $tab1result += $row["tab1q3"]; }
					if(!empty($row["tab1q4"])) { $tab1result += $row["tab1q4"]; }
					if(!empty($row["tab1q5"])) { $tab1result += $row["tab1q5"]; }
					$tab1result = round(100/50* $tab1result,0);
				}
					
				if($num == 0) {
					$chart["real"] = 0;
				} else {
					$chart["real"] = $tab1result;
				}
				
				$today = date("Y-m-d");
				
				$chart["tendency"] = "tendency_positive.png";
				
				$q2 = "SELECT * FROM " . CO_TBL_PATIENTS_OBJECTIVES . " WHERE pid = '$id' and status = '1' and bin = '0' ORDER BY item_date DESC LIMIT 1,1";
				$result2 = mysql_query($q2, $this->_db->connection);
				$num2 = mysql_num_rows($result2);
				$i = 1;
				while($row2 = mysql_fetch_array($result2)) {
					// Tab 1 questios
					$tab1result2 = 0;
					if(!empty($row2["tab1q1"])) { $tab1result2 += $row2["tab1q1"]; }
					if(!empty($row2["tab1q2"])) { $tab1result2 += $row2["tab1q2"]; }
					if(!empty($row2["tab1q3"])) { $tab1result2 += $row2["tab1q3"]; }
					if(!empty($row2["tab1q4"])) { $tab1result2 += $row2["tab1q4"]; }
					if(!empty($row2["tab1q5"])) { $tab1result2 += $row2["tab1q5"]; }
					$tab1result2 = round(100/50* $tab1result2,0);
				}
				if($num2 == 0) {
					$chart["tendency"] = "tendency_positive.png";
				} else {
					if($tab1result >= $tab1result2) {
						$chart["tendency"] = "tendency_positive.png";
					} else {
						$chart["tendency"] = "tendency_negative.png";
					}
				}
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = 'MA-Zufriedenheit';
				$chart["img_name"] = "ma_" . $id . "_happiness.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,E5E5E5';
				if($image == 1) {
					$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				}
			break;
			case 'performance':
				$chart["real"] = 0;
				$q = "SELECT * FROM " . CO_TBL_PATIENTS_OBJECTIVES . " WHERE pid = '$id' and status = '1' and bin = '0' ORDER BY item_date DESC LIMIT 0,1";
				$result = mysql_query($q, $this->_db->connection);
				$num = mysql_num_rows($result);
				$i = 1;
				while($row = mysql_fetch_assoc($result)) {
					// Tab 2 questios
					$tab2result = 0;
					if(!empty($row["tab2q1"])) { $tab2result += $row["tab2q1"]; }
					if(!empty($row["tab2q2"])) { $tab2result += $row["tab2q2"]; }
					if(!empty($row["tab2q3"])) { $tab2result += $row["tab2q3"]; }
					if(!empty($row["tab2q4"])) { $tab2result += $row["tab2q4"]; }
					if(!empty($row["tab2q5"])) { $tab2result += $row["tab2q5"]; }
					if(!empty($row["tab2q6"])) { $tab2result += $row["tab2q6"]; }
					if(!empty($row["tab2q7"])) { $tab2result += $row["tab2q7"]; }
					if(!empty($row["tab2q8"])) { $tab2result += $row["tab2q8"]; }
					if(!empty($row["tab2q9"])) { $tab2result += $row["tab2q9"]; }
					if(!empty($row["tab2q10"])) { $tab2result += $row["tab2q10"]; }
					$tab2result = $tab2result;
				}
					
				if($num == 0) {
					$chart["real"] = 0;
				} else {
					$chart["real"] = $tab2result;
				}
				
				$today = date("Y-m-d");
				
				$chart["tendency"] = "tendency_positive.png";
				
				$q2 = "SELECT * FROM " . CO_TBL_PATIENTS_OBJECTIVES . " WHERE pid = '$id' and status = '1' and bin = '0' ORDER BY item_date DESC LIMIT 1,1";
				$result2 = mysql_query($q2, $this->_db->connection);
				$num2 = mysql_num_rows($result2);
				$i = 1;
				// Tab 2 questios
					$tab2result2 = 0;
				while($row2 = mysql_fetch_array($result2)) {
					
					if(!empty($row2["tab2q1"])) { $tab2result2 += $row2["tab2q1"]; }
					if(!empty($row2["tab2q2"])) { $tab2result2 += $row2["tab2q2"]; }
					if(!empty($row2["tab2q3"])) { $tab2result2 += $row2["tab2q3"]; }
					if(!empty($row2["tab2q4"])) { $tab2result2 += $row2["tab2q4"]; }
					if(!empty($row2["tab2q5"])) { $tab2result2 += $row2["tab2q5"]; }
					if(!empty($row2["tab2q6"])) { $tab2result2 += $row2["tab2q6"]; }
					if(!empty($row2["tab2q7"])) { $tab2result2 += $row2["tab2q7"]; }
					if(!empty($row2["tab2q8"])) { $tab2result2 += $row2["tab2q8"]; }
					if(!empty($row2["tab2q9"])) { $tab2result2 += $row2["tab2q9"]; }
					if(!empty($row2["tab2q10"])) { $tab2result2 += $row2["tab2q10"]; }
					$tab2result2 = $tab2result2;
				}
				$chart["real_old"] =  $tab2result2;
				if($num2 == 0) {
					$chart["tendency"] = "tendency_positive.png";
				} else {
					if($chart["real"] >= $tab2result2) {
						$chart["tendency"] = "tendency_positive.png";
					} else {
						$chart["tendency"] = "tendency_negative.png";
					}
				}
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = 'Leistungsbewertung';
				$chart["img_name"] = "ma_" . $id . "_performance.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,E5E5E5';
				if($image == 1) {
					$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				}
			break;
			case 'goals':
				$chart["real"] = 0;
				$q = "SELECT id FROM " . CO_TBL_PATIENTS_OBJECTIVES . " WHERE pid = '$id' and status = '1' and bin = '0' ORDER BY item_date DESC LIMIT 0,1";
				$result = mysql_query($q, $this->_db->connection);
				if(mysql_num_rows($result) > 0) {
					$mid = mysql_result($result,0);
					$q = "SELECT answer FROM " . CO_TBL_PATIENTS_OBJECTIVES_TASKS . "  WHERE mid='$mid' and bin = '0'";
					$result = mysql_query($q, $this->_db->connection);
					$num = mysql_num_rows($result)*10;
					$tab3result = 0;
					while($row = mysql_fetch_assoc($result)) {
						if(!empty($row["answer"])) { $tab3result += $row["answer"]; }
					}
					if($tab3result == 0) {
						$chart["real"] = 0;
					} else {
						$chart["real"] =  round(100/$num* $tab3result,0);
					}
				}
				
				$chart["tendency"] = "tendency_positive.png";
				
				$tab3result2 = 0;
				$q = "SELECT id FROM " . CO_TBL_PATIENTS_OBJECTIVES . " WHERE pid = '$id' and status = '1' and bin = '0' ORDER BY item_date DESC LIMIT 1,1";
				$result = mysql_query($q, $this->_db->connection);
				if(mysql_num_rows($result) > 0) {
					$mid = mysql_result($result,0);
					$q = "SELECT answer FROM " . CO_TBL_PATIENTS_OBJECTIVES_TASKS . "  WHERE mid='$mid' and bin = '0'";
					$result = mysql_query($q, $this->_db->connection);
					$num2 = mysql_num_rows($result)*10;
					
					while($row = mysql_fetch_assoc($result)) {
						if(!empty($row["answer"])) { $tab3result2 += $row["answer"]; }
					}
					$tab3result2 = round(100/$num2* $tab3result2,0);
				}
				
				$chart["real_old"] =  $tab3result2;
				
				if($tab3result2 == 0) {
					$chart["tendency"] = "tendency_positive.png";
				} else {
					if($chart["real"] >= $tab3result2) {
						$chart["tendency"] = "tendency_positive.png";
					} else {
						$chart["tendency"] = "tendency_negative.png";
					}
				}
				
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = 'Zielerreichung';
				$chart["img_name"] = "ma_" . $id . "_goals.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,E5E5E5';
				if($image == 1) {
					$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				}
			break;
			case 'totals':
				$chart = $this->getChartPerformance($id,'performance',0);
				$performance = $chart["real"];
				$performance_old = $chart["real_old"];
				$chart = $this->getChartPerformance($id,'goals',0);
				$goals = $chart["real"]*3;
				$goals_old = $chart["real_old"]*3;
				
				$total = $performance+$goals;
				$chart["real"] = round(100/400*$total,0);
				
				
				$chart["tendency"] = "tendency_positive.png";
				
				$total_old = round(100/400*($performance_old+$goals_old),0);
				
				if($total >= $total_old) {
					$chart["tendency"] = "tendency_positive.png";
				} else {
					$chart["tendency"] = "tendency_negative.png";
				}
				
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = 'Gesamtergebnis';
				$chart["img_name"] = "ma_" . $id . "_totals.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=87461e&chf=bg,s,E5E5E5';
				if($image == 1) {
					$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				}
			break;
			}
		
		return $chart;
   }


	function getInlineSearch($term){
		global $system, $session;
		$num=0;
		$access=" ";
		if(!$session->isSysadmin()) {
			$access = " and a.id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
	  	}
		
		//$q = "SELECT a.id,CONCAT(b.lastname,' ',b.firstname) as label FROM " . CO_TBL_PATIENTS . " as a, co_users as b WHERE a.id != '$exclude' and a.cid=b.id and (lastname like '%$term%' or firstname like '%$term%') and  a.bin='0'" . $access ."ORDER BY lastname, firstname ASC";
		
		$q = "SELECT id,CONCAT(lastname,' ',firstname) as label FROM co_users WHERE (lastname like '%$term%' or firstname like '%$term%') and  bin='0'" . $access ."ORDER BY lastname, firstname ASC";
		
		$result = mysql_query($q, $this->_db->connection);
		$num=mysql_affected_rows();
		$rows = array();
		$r = array();
		/*while($r = mysql_fetch_assoc($result)) {
			 $rows[] = $r;
		}*/
		while($row = mysql_fetch_array($result)) {
			$rows['value'] = htmlspecialchars_decode($row['label']);
			$rows['id'] = $row['id'];
			$r[] = $rows;
		}
		return json_encode($r);
	}
	
	
	function getPatientsSearch($term,$exclude){
		global $system, $session;
		$num=0;
		$access=" ";
		if(!$session->isSysadmin()) {
			$access = " and a.id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
	  	}
		
		$q = "SELECT a.id,CONCAT(b.lastname,' ',b.firstname) as label FROM " . CO_TBL_PATIENTS . " as a, co_users as b WHERE a.id != '$exclude' and a.cid=b.id and (lastname like '%$term%' or firstname like '%$term%') and  a.bin='0'" . $access ."ORDER BY lastname, firstname ASC";
		
		$result = mysql_query($q, $this->_db->connection);
		$num=mysql_affected_rows();
		$rows = array();
		$r = array();
		/*while($r = mysql_fetch_assoc($result)) {
			 $rows[] = $r;
		}*/
		while($row = mysql_fetch_array($result)) {
			$rows['value'] = htmlspecialchars_decode($row['label']);
			$rows['id'] = $row['id'];
			$r[] = $rows;
		}
		return json_encode($r);
	}

	
	function getPatientArray($string){
		$string = explode(",", $string);
		$total = sizeof($string);
		$items = '';
		
		if($total == 0) { 
			return $items; 
		}
		
		// check if user is available and build array
		$items_arr = "";
		foreach ($string as &$value) {
			//$q = "SELECT id, title FROM ".CO_TBL_PATIENTS." where id = '$value' and bin='0'";
			$q = "SELECT a.id,CONCAT(b.lastname,' ',b.firstname) as title FROM ".CO_TBL_PATIENTS." as a, co_users as b where a.cid=b.id and a.id = '$value' and a.bin='0'";
			$result = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result) > 0) {
				while($row = mysql_fetch_assoc($result)) {
					$items_arr[] = array("id" => $row["id"], "title" => $row["title"]);		
				}
			}
		}

		return $items_arr;
}
	
	function getLast10Patients() {
		global $session;
		$patients = $this->getPatientArray($this->getUserSetting("last-used-patients"));
	  return $patients;
	}
	
	
	function saveLastUsedPatients($id) {
		global $session;
		$string = $id . "," .$this->getUserSetting("last-used-patients");
		$string = rtrim($string, ",");
		$ids_arr = explode(",", $string);
		$res = array_unique($ids_arr);
		foreach ($res as $key => $value) {
			$ids_rtn[] = $value;
		}
		array_splice($ids_rtn, 7);
		$str = implode(",", $ids_rtn);
		
		$this->setUserSetting("last-used-patients",$str);
	  return true;
	}
	
	
	
	function existUserPatientsWidgets() {
		global $session;
		$q = "select count(*) as num from " . CO_TBL_PATIENTS_DESKTOP_SETTINGS . " where uid='$session->uid'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_assoc($result);
		if($row["num"] < 1) {
			return false;
		} else {
			return true;
		}
	}
	
	
	function getUserPatientsWidgets() {
		global $session;
		$q = "select * from " . CO_TBL_PATIENTS_DESKTOP_SETTINGS . " where uid='$session->uid'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_assoc($result);
		return $row;
	}
	
	
	 function getWidgetAlerts() {
		global $session, $date;
	  	
		$now = new DateTime("now");
		$today = $date->formatDate("now","Y-m-d");
		$tomorrow = $date->addDays($today, 1);
		$string = "";
		
		$access = "";
		$skip = 0;
		if(!$session->isSysadmin()) {
			// check if admin
			$editperms = $this->getEditPerms($session->uid);
			if(empty($editperms)) {
				$skip = 1;
			}
			$access = " and c.id IN (" . implode(',', $editperms) . ") ";

		}

		$reminders = "";
		if($skip == 0) {
			$q ="select b.folder,a.pid,a.id, a.title as text, CONCAT(c.lastname,' ',c.firstname) as title from " . CO_TBL_PATIENTS_TREATMENTS . " as a, " . CO_TBL_PATIENTS . " as b, co_users as c WHERE a.status='2' and a.status_invoice='0' and a.pid = b.id and b.cid=c.id and a.bin = '0' and b.bin = '0' and c.bin='0'" . $access;
			$result = mysql_query($q, $this->_db->connection);
			$reminders = "";
			while ($row = mysql_fetch_array($result)) {
				foreach($row as $key => $val) {
					$array[$key] = $val;
				}
				$string .= $array["folder"] . "," . $array["pid"] . "," . $array["id"] . ",";
				$reminders[] = new Lists($array);
			}
		}

		$alerts = "";
		$array = "";
		if($skip == 0) {
			$q ="select b.folder,a.pid,a.id, a.title as text, CONCAT(c.lastname,' ',c.firstname) as title from " . CO_TBL_PATIENTS_TREATMENTS . " as a, " . CO_TBL_PATIENTS . " as b, co_users as c WHERE a.status_invoice='1' and a.pid = b.id and b.cid=c.id and a.bin = '0' and b.bin = '0'  and c.bin='0' and a.payment_reminder <= '$tomorrow'" . $access;
			$result = mysql_query($q, $this->_db->connection);
			while ($row = mysql_fetch_array($result)) {
				foreach($row as $key => $val) {
					$array[$key] = $val;
				}
				$string .= $array["folder"] . "," . $array["pid"] . "," . $array["id"] . ",";
				$alerts[] = new Lists($array);
			}
		}

		if(!$this->existUserPatientsWidgets()) {
			$q = "insert into " . CO_TBL_PATIENTS_DESKTOP_SETTINGS . " set uid='$session->uid', value='$string'";
			$result = mysql_query($q, $this->_db->connection);
			$widgetaction = "open";
		} else {
			$row = $this->getUserPatientsWidgets();
			$id = $row["id"];
			if($string == $row["value"]) {
				$widgetaction = "";
			} else {
				$widgetaction = "open";
			}
			$q = "UPDATE " . CO_TBL_PATIENTS_DESKTOP_SETTINGS . " set value='$string' WHERE id = '$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		
		$arr = array("reminders" => $reminders, "alerts" => $alerts, "widgetaction" => $widgetaction);
		return $arr;
   }





}

$patientsmodel = new PatientsModel(); // needed for direct calls to functions eg echo $patientsmodel ->getPatientTitle(1);
?>
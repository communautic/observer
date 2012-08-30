<?php
//include_once(CO_PATH_BASE . "/model.php");
//include_once(dirname(__FILE__)."/model/folders.php");
//include_once(dirname(__FILE__)."/model/employees.php");

class EmployeesModel extends Model {
	
	// Get all Employee Folders
   function getFolderList($sort) {
      global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("employees-folder-sort-status");
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
				  		$sortorder = $this->getSortOrder("employees-folder-sort-order");
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
				  		$sortorder = $this->getSortOrder("employees-folder-sort-order");
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
			$q ="select a.id, a.title from " . CO_TBL_EMPLOYEES_FOLDERS . " as a where a.status='0' and a.bin = '0' and (SELECT count(*) FROM co_employees_access as b, co_employees as c WHERE (b.admins REGEXP '[[:<:]]" . $session->uid . "[[:>:]]' or b.guests REGEXP '[[:<:]]" . $session->uid . "[[:>:]]') and c.folder=a.id and b.pid=c.id) > 0 " . $order;
		} else {
			$q ="select a.id, a.title from " . CO_TBL_EMPLOYEES_FOLDERS . " as a where a.status='0' and a.bin = '0' " . $order;
		}
		
	  $this->setSortStatus("employees-folder-sort-status",$sortcur);
      $result = mysql_query($q, $this->_db->connection);
	  $folders = "";
	  while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
				if($key == "id") {
				$array["numEmployees"] = $this->getNumEmployees($val);
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
   * get details for the employee folder
   */
   function getFolderDetails($id) {
		global $session, $contactsmodel, $employeesControllingModel, $lang;
		$q = "SELECT * FROM " . CO_TBL_EMPLOYEES_FOLDERS . " where id = '$id'";
		
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_assoc($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		$array["allemployees"] = $this->getNumEmployees($id);
		$array["plannedemployees"] = $this->getNumEmployees($id, $status="0");
		$array["activeemployees"] = $this->getNumEmployees($id, $status="1");
		$array["inactiveemployees"] = $this->getNumEmployees($id, $status="2");
		$array["stoppedemployees"] = $this->getNumEmployees($id, $status="3");
		
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
		
		// get employee details
		$access="";
		if(!$session->isSysadmin()) {
			$access = " and id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
	  	}
		
		 $sortstatus = $this->getSortStatus("employees-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("employees-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by title";
						  } else {
							$order = "order by field(id,$sortorder)";
						  }
				  break;	
			  }
		  }
		
		
		$q = "SELECT a.*,CONCAT(b.lastname,' ',b.firstname) as title FROM " . CO_TBL_EMPLOYEES . " as a, co_users as b WHERE a.folder='$id' and a.bin='0' and a.cid=b.id" . $access . " " . $order;
		$result = mysql_query($q, $this->_db->connection);
	  	$employees = "";
	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$employee[$key] = $val;
			}
			//$employee["management"] = $contactsmodel->getUserListPlain($employee['management']);
			$employee["perm"] = $this->getEmployeeAccess($employee["id"]);
			
		switch($employee["status"]) {
			case "0":
				$employee["status_text"] = $lang["GLOBAL_STATUS_TRIAL"];
				$employee["status_text_time"] = $lang["GLOBAL_STATUS_TRIAL_TIME"];
				$employee["status_date"] = $this->_date->formatDate($employee["planned_date"],CO_DATE_FORMAT);
			break;
			case "1":
				$employee["status_text"] = $lang["GLOBAL_STATUS_ACTIVE"];
				$employee["status_text_time"] = $lang["GLOBAL_STATUS_ACTIVE_TIME"];
				$employee["status_date"] = $this->_date->formatDate($employee["inprogress_date"],CO_DATE_FORMAT);
			break;
			case "2":
				$employee["status_text"] = $lang["GLOBAL_STATUS_MATERNITYLEAVE"];
				$employee["status_text_time"] = $lang["GLOBAL_STATUS_MATERNITYLEAVE_TIME"];
				$employee["status_date"] = $this->_date->formatDate($employee["finished_date"],CO_DATE_FORMAT);
			break;
			case "3":
				$employee["status_text"] = $lang["GLOBAL_STATUS_LEAVE"];
				$employee["status_text_time"] = $lang["GLOBAL_STATUS_LEAVE_TIME"];
				$employee["status_date"] = $this->_date->formatDate($employee["stopped_date"],CO_DATE_FORMAT);
			break;
		}
			
			$employees[] = new Lists($employee);
	  	}
		
		$access = "guest";
		  if($session->isSysadmin()) {
			  $access = "sysadmin";
		  }
		
		$arr = array("folder" => $folder, "employees" => $employees, "access" => $access);
		return $arr;
   }


   /**
   * get details for the employee folder
   */
   function setFolderDetails($id,$title,$employeestatus) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_EMPLOYEES_FOLDERS . " set title = '$title', status = '$employeestatus', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }


   /**
   * create new employee folder
   */
	function newFolder() {
		global $session, $lang;
		$now = gmdate("Y-m-d H:i:s");
		$title = $lang["EMPLOYEE_FOLDER_NEW"];
		
		$q = "INSERT INTO " . CO_TBL_EMPLOYEES_FOLDERS . " set title = '$title', status = '0', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	$id = mysql_insert_id();
			return $id;
		}
	}


   /**
   * delete employee folder
   */
   function binFolder($id) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_EMPLOYEES_FOLDERS . " set bin = '1', bintime = '$now', binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   
   function restoreFolder($id) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_EMPLOYEES_FOLDERS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deleteFolder($id) {
		$q = "SELECT id FROM " . CO_TBL_EMPLOYEES . " where folder = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$pid = $row["id"];
			$this->deleteEmployee($pid);
		}
		
		$q = "DELETE FROM " . CO_TBL_EMPLOYEES_FOLDERS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


  /**
   * get number of employees for a employee folder
   * status: 0 = all, 1 = active, 2 = abgeschlossen
   */   
   function getNumEmployees($id, $status="") {
		global $session;
		
		$access = "";
		 if(!$session->isSysadmin()) {
			$access = " and id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
		  }
		
		if($status == "") {
			$q = "select id from " . CO_TBL_EMPLOYEES . " where folder='$id' " . $access . " and bin != '1'";
		} else {
			$q = "select id from " . CO_TBL_EMPLOYEES . " where folder='$id' " . $access . " and status = '$status' and bin != '1'";
		}
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_num_rows($result);
		return $row;
	}


	function getEmployeeTitle($id){
		global $session;
		$q = "SELECT title FROM " . CO_TBL_EMPLOYEES . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		return $title;
   }


   	function getEmployeeTitleFromIDs($array){
		//$string = explode(",", $string);
		$total = sizeof($array);
		$data = '';
		
		if($total == 0) { 
			return $data; 
		}
		
		// check if employee is available and build array
		$arr = array();
		foreach ($array as &$value) {
			$q = "SELECT id,title FROM " . CO_TBL_EMPLOYEES . " where id = '$value' and bin='0'";
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


	function getEmployeeTitleLinkFromIDs($array,$target){
		$total = sizeof($array);
		$data = '';
		if($total == 0) { 
			return $data; 
		}
		$arr = array();
		$i = 0;
		foreach ($array as &$value) {
			$q = "SELECT id,folder,title FROM " . CO_TBL_EMPLOYEES . " where id = '$value' and bin='0'";
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
			$data .= '<a class="loadModuleAccess" rel="' . $target. ','.$value["folder"].','.$value["id"].',1,employees">' . $value["title"] . '</a>';
			if($i < $arr_total) {
				$data .= '<br />';
			}
			$data .= '';	
			$i++;
		}
		return $data;
   }


   	function getEmployeeField($id,$field){
		global $session;
		$q = "SELECT $field FROM " . CO_TBL_EMPLOYEES . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		return $title;
   }


  /**
   * get the list of employees for a employee folder
   */ 
   function getEmployeeList($id,$sort) {
      global $session,$contactsmodel;
	  
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("employees-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("employees-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by title";
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
				  		$order = "order by title";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by title DESC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("employees-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by title";
							$sortcur = '1';
						  } else {
							$order = "order by field(id,$sortorder)";
							$sortcur = '3';
						  }
				  break;	
			  }
	  }
	  
	  $access = "";
	  if(!$session->isSysadmin()) {
		$access = " and id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
	  }
	  $q ="select a.id,CONCAT(b.lastname,' ',b.firstname) as title,a.status,a.checked_out,a.checked_out_user from " . CO_TBL_EMPLOYEES . " as a, co_users as b where a.cid=b.id and a.folder='$id' and a.bin = '0' " . $access . $order;

	  $this->setSortStatus("employees-sort-status",$sortcur,$id);
      $result = mysql_query($q, $this->_db->connection);
	  $employees = "";
	  while ($row = mysql_fetch_array($result)) {
		foreach($row as $key => $val) {
			$array[$key] = $val;
			if($key == "id") {
				if($this->getEmployeeAccess($val) == "guest") {
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
			case 2:
				$itemstatus = " module-item-active-maternity";
			break;
			case 3:
				$itemstatus = " module-item-active-leave";
			break;
			
	  	}
		$array["itemstatus"] = $itemstatus;
		
		$checked_out_status = "";
		if($array["access"] != "guest" && $array["checked_out"] == 1 && $array["checked_out_user"] != $session->uid) {
			if($session->checkUserActive($array["checked_out_user"])) {
				$checked_out_status = "icon-checked-out-active";
			} else {
				$this->checkinEmployeeOverride($id);
			}
		}
		$array["checked_out_status"] = $checked_out_status;
		
		$employees[] = new Lists($array);
	  }
	  $arr = array("employees" => $employees, "sort" => $sortcur);
	  return $arr;
   }
	
	
	function checkoutEmployee($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_EMPLOYEES . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function checkinEmployee($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_EMPLOYEES . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_EMPLOYEES . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}
	
	function checkinEmployeeOverride($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_EMPLOYEES . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	

   function getEmployeeDetails($id,$option = "") {
		global $session, $contactsmodel, $lang;
		$q = "SELECT a.*,CONCAT(b.lastname,' ',b.firstname) as title,b.title as ctitle,b.title2,b.position,b.phone1,b.email FROM " . CO_TBL_EMPLOYEES . " as a, co_users as b where a.cid=b.id and a.id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		// perms
		$array["access"] = $this->getEmployeeAccess($id);
		if($array["access"] == "guest") {
			// check if this user is admin in some other employee
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
					$array["canedit"] = $this->checkoutEmployee($id);
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
					$array["checked_out_user_phone1"] = $contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
					$array["checked_out_user_email"] = $contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");
				}
			} else {
				$array["canedit"] = $this->checkoutEmployee($id);
			}
		} // EOF perms
		
		// dates
		
		$today = date("Y-m-d");
		if($today < $array["startdate"]) {
			$today = $array["startdate"];
		}
		$array["avatar"] = $contactsmodel->_users->getAvatar($array["cid"]);
		$array["startdate"] = $this->_date->formatDate($array["startdate"],CO_DATE_FORMAT);
		$array["enddate"] = $this->_date->formatDate($array["enddate"],CO_DATE_FORMAT);
		$array["dob"] = $this->_date->formatDate($array["dob"],CO_DATE_FORMAT);

		$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
		
		// other functions
		$array["folder"] = $this->getEmployeeFolderDetails($array["folder"],"folder");		
		$array["kind"] = $this->getEmployeeIdDetails($array["kind"],"employeeskind");
		$array["area"] = $this->getEmployeeIdDetails($array["area"],"employeesarea");
		$array["department"] = $this->getEmployeeIdDetails($array["department"],"employeesdepartment");
		$array["education"] = $this->getEmployeeIdDetails($array["education"],"employeeseducation");
		
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		$array["current_user"] = $session->uid;
		
		$array["status_planned_active"] = "";
		$array["status_inprogress_active"] = "";
		$array["status_finished_active"] = "";
		$array["status_stopped_active"] = "";
		switch($array["status"]) {
			case "0":
				$array["status_text"] = $lang["GLOBAL_STATUS_TRIAL"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_TRIAL_TIME"];
				$array["status_planned_active"] = " active";
				$array["status_date"] = $this->_date->formatDate($array["planned_date"],CO_DATE_FORMAT);
			break;
			case "1":
				$array["status_text"] = $lang["GLOBAL_STATUS_ACTIVE"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_ACTIVE_TIME"];
				$array["status_inprogress_active"] = " active";
				$array["status_date"] = $this->_date->formatDate($array["inprogress_date"],CO_DATE_FORMAT);
			break;
			case "2":
				$array["status_text"] = $lang["GLOBAL_STATUS_MATERNITYLEAVE"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_MATERNITYLEAVE_TIME"];
				$array["status_finished_active"] = " active";
				$array["status_date"] = $this->_date->formatDate($array["finished_date"],CO_DATE_FORMAT);
			break;
			case "3":
				$array["status_text"] = $lang["GLOBAL_STATUS_LEAVE"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_LEAVE_TIME"];
				$array["status_stopped_active"] = " active";
				$array["status_date"] = $this->_date->formatDate($array["stopped_date"],CO_DATE_FORMAT);
			break;
		}
		
		// checkpoint
		$array["checkpoint"] = 0;
		$array["checkpoint_date"] = "";
		$array["checkpoint_note"] = "";
		$q = "SELECT date,note FROM " . CO_TBL_USERS_CHECKPOINTS . " where uid='$session->uid' and app = 'employees' and module = 'employees' and app_id = '$id' LIMIT 1";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			while ($row = mysql_fetch_assoc($result)) {
			$array["checkpoint"] = 1;
			$array["checkpoint_date"] = $this->_date->formatDate($row['date'],CO_DATE_FORMAT);
			$array["checkpoint_note"] = $row['note'];
			}
		}
		
		$employee = new Lists($array);
		
		$sql="";
		if($array["access"] == "guest") {
			$sql = " and a.access = '1' ";
		}
				
		$sendto = $this->getSendtoDetails("employees",$id);
		
		$arr = array("employee" => $employee, "sendto" => $sendto, "access" => $array["access"]);
		return $arr;
   }


   // Create employee folder title
	function getEmployeeFolderDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			$q = "SELECT id, title from " . CO_TBL_EMPLOYEES_FOLDERS . " where id = '$value'";
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
   
   
   	function getEmployeeIdDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			$q = "SELECT id, name from " . CO_TBL_EMPLOYEES_DIALOG_EMPLOYEES . " where id = '$value'";
			$result_user = mysql_query($q, $this->_db->connection);
			while($row_user = mysql_fetch_assoc($result_user)) {
				$users .= '<span class="listmember" uid="' . $row_user["id"] . '">' . $row_user["name"] . '</span>';
				if($i < $users_total) {
					$users .= ', ';
				}
			}
			$i++;
		}
		return $users;
   }


   /**
   * get details for the employee folder
   */
   function setEmployeeDetails($id,$startdate,$enddate,$protocol,$protocol2,$protocol3,$folder,$number,$kind,$area,$department,$dob,$coo,$languages,$street_private,$city_private,$zip_private,$phone_private,$email_private,$education) {
		global $session, $contactsmodel;
		
		$startdate = $this->_date->formatDate($startdate);
		$enddate = $this->_date->formatDate($enddate);
		$dob = $this->_date->formatDate($dob);

		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_EMPLOYEES . " set folder = '$folder', startdate='$startdate', enddate='$enddate',  protocol = '$protocol',  protocol2 = '$protocol2',  protocol3 = '$protocol3', number = '$number', kind = '$kind', area = '$area', department = '$department', dob = '$dob', coo = '$coo', languages = '$languages', street_private = '$street_private', city_private = '$city_private', zip_private = '$zip_private', phone_private = '$phone_private', email_private = '$email_private', education = '$education', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}



   function updateStatus($id,$date,$status) {
		global $session;
		
		$date = $this->_date->formatDate($date);
		
		switch($status) {
			case "0":
				$sql = "planned_date";
			break;
			case "1":
				$sql = "inprogress_date";
			break;
			case "2":
				$sql = "finished_date";
			break;
			case "3":
				$sql = "stopped_date";
			break;
		}

		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_EMPLOYEES . " set status = '$status', $sql = '$date', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}


	function newEmployee($id,$cid) {
		global $session, $contactsmodel, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		$title = $lang["EMPLOYEE_NEW"];
		
		$q = "INSERT INTO " . CO_TBL_EMPLOYEES . " set folder = '$id', cid='$cid', status = '0', planned_date = '$now', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			$id = mysql_insert_id();
			// if admin insert him to access
			if(!$session->isSysadmin()) {
				$employeesAccessModel = new EmployeesAccessModel();
				$employeesAccessModel->setDetails($id,$session->uid,"");
			}
			return $id;
		}
	}
	
	
	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		// employee
		$q = "INSERT INTO " . CO_TBL_EMPLOYEES . " (folder,title,startdate,ordered_by,management,team,employee,employee_more,employee_cat,employee_cat_more,product,product_desc,charge,number,protocol,planned_date,created_date,created_user,edited_date,edited_user) SELECT folder,CONCAT(title,' ".$lang["GLOBAL_DUPLICAT"]."'),'$now',ordered_by,management,team,employee,employee_more,employee_cat,employee_cat_more,product,product_desc,charge,number,protocol,'$now','$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_EMPLOYEES . " where id='$id'";

		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		
		if(!$session->isSysadmin()) {
			$employeesAccessModel = new EmployeesAccessModel();
			$employeesAccessModel->setDetails($id_new,$session->uid,"");
		}
			
		// processes
		$q = "SELECT id FROM " . CO_TBL_EMPLOYEES_GRIDS . " WHERE pid = '$id' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$gridid = $row["id"];
		
			$qg = "INSERT INTO " . CO_TBL_EMPLOYEES_GRIDS . " (pid,title,owner,owner_ct,management,management_ct,team,team_ct,created_date,created_user,edited_date,edited_user) SELECT '$id_new',title,owner,owner_ct,management,management_ct,team,team_ct,'$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_EMPLOYEES_GRIDS . " where id='$gridid'";
			$resultg = mysql_query($qg, $this->_db->connection);
			$gridid_new = mysql_insert_id();
		
			// cols
			$qc = "SELECT * FROM " . CO_TBL_EMPLOYEES_GRIDS_COLUMNS . " WHERE pid = '$gridid' and bin='0'";
			$resultc = mysql_query($qc, $this->_db->connection);
			while($rowc = mysql_fetch_array($resultc)) {
				$colID = $rowc["id"];
				$sort = $rowc['sort'];
				$days = $rowc['days'];
				$qcn = "INSERT INTO " . CO_TBL_EMPLOYEES_GRIDS_COLUMNS . " set pid = '$gridid_new', sort='$sort', days='$days'";
				$resultcn = mysql_query($qcn, $this->_db->connection);
				$colID_new = mysql_insert_id();
				
				$qn = "SELECT * FROM " . CO_TBL_EMPLOYEES_GRIDS_NOTES . " where cid = '$colID' and bin='0'";
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
					$qnn = "INSERT INTO " . CO_TBL_EMPLOYEES_GRIDS_NOTES . " set cid='$colID_new', sort = '$sort', istitle = '$istitle', isstagegate = '$isstagegate', title = '$title', text = '$text', created_date='$now',created_user='$session->uid',edited_date='$now',edited_user='$session->uid'";
					$resultnn = mysql_query($qnn, $this->_db->connection);
				}
			}
		}
		
		//vdocs
		$q = "SELECT id FROM " . CO_TBL_EMPLOYEES_VDOCS . " WHERE pid = '$id' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$vdocid = $row["id"];
			$qv = "INSERT INTO " . CO_TBL_EMPLOYEES_VDOCS . " (pid,title,content) SELECT '$id_new',title,content FROM " . CO_TBL_EMPLOYEES_VDOCS . " where id='$vdocid'";
			$resultv = mysql_query($qv, $this->_db->connection);
		}
		
		if ($result) {
			return $id_new;
		}
	}


	function binEmployee($id) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_EMPLOYEES . " set bin = '1', bintime = '$now', binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	function restoreEmployee($id) {
		$q = "UPDATE " . CO_TBL_EMPLOYEES . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	function deleteEmployee($id) {
		global $employees;
		
		$active_modules = array();
		foreach($employees->modules as $module => $value) {
			if(CONSTANT('employees_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
			}
		}
		
		if(in_array("grids",$active_modules)) {
			$employeesGridsModel = new EmployeesGridsModel();
			$q = "SELECT id FROM co_employees_grids where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$mid = $row["id"];
				$employeesGridsModel->deleteGrid($mid);
			}
		}

		if(in_array("forums",$active_modules)) {
			$employeesForumsModel = new EmployeesForumsModel();
			$q = "SELECT id FROM co_employees_forums where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$pid = $row["id"];
				$employeesForumsModel->deleteForum($pid);
			}
		}
		
		
		if(in_array("meetings",$active_modules)) {
			$employeesMeetingsModel = new EmployeesMeetingsModel();
			$q = "SELECT id FROM co_employees_meetings where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$mid = $row["id"];
				$employeesMeetingsModel->deleteMeeting($mid);
			}
		}
		
		if(in_array("objectives",$active_modules)) {
			$employeesObjectivesModel = new EmployeesObjectivesModel();
			$q = "SELECT id FROM co_employees_objectives where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$mid = $row["id"];
				$employeesObjectivesModel->deleteObjective($mid);
			}
		}

		if(in_array("phonecalls",$active_modules)) {
			$employeesPhonecallsModel = new EmployeesPhonecallsModel();
			$q = "SELECT id FROM co_employees_phonecalls where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$pcid = $row["id"];
				$employeesPhonecallsModel->deletePhonecall($pcid);
			}
		}

		if(in_array("documents",$active_modules)) {
			$employeesDocumentsModel = new EmployeesDocumentsModel();
			$q = "SELECT id FROM co_employees_documents_folders where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$did = $row["id"];
				$employeesDocumentsModel->deleteDocument($did);
			}
		}

		if(in_array("vdocs",$active_modules)) {
			$employeesVDocsmodel = new EmployeesVDocsModel();
			$q = "SELECT id FROM co_employees_vdocs where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$vid = $row["id"];
				$employeesVDocsmodel->deleteVDoc($vid);
			}
		}


		$q = "DELETE FROM co_log_sendto WHERE what='employees' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_USERS_CHECKPOINTS . " WHERE app = 'employees' and module = 'employees' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM co_employees_access WHERE pid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_EMPLOYEES . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
		  	return true;
		}
		
	}


   function moveEmployee($id,$startdate,$movedays) {
		global $session, $contactsmodel;
		
		$startdate = $this->_date->formatDate($_POST['startdate']);
		
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_EMPLOYEES . " set startdate = '$startdate', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
			$qt = "SELECT id, startdate, enddate FROM " . CO_TBL_EMPLOYEES_PHASES_TASKS . " where pid='$id'";
			$resultt = mysql_query($qt, $this->_db->connection);
			while ($rowt = mysql_fetch_array($resultt)) {
				$tid = $rowt["id"];
				$startdate = $this->_date->addDays($rowt["startdate"],$movedays);
				$enddate = $this->_date->addDays($rowt["enddate"],$movedays);
				$qtk = "UPDATE " . CO_TBL_EMPLOYEES_PHASES_TASKS . " set startdate = '$startdate', enddate = '$enddate' where id='$tid'";
				$retvaltk = mysql_query($qtk, $this->_db->connection);
			}
		if ($result) {
			return true;
		}
	}


	function getEmployeeFolderDialog($field,$title) {
		global $session;
		$str = '<div class="dialog-text">';
		//$q ="select id, title from " . CO_TBL_EMPLOYEES_FOLDERS . " where status='0' and bin = '0' ORDER BY title";
		if(!$session->isSysadmin()) {
			$q ="select a.id, a.title from " . CO_TBL_EMPLOYEES_FOLDERS . " as a where a.status='0' and a.bin = '0' and (SELECT count(*) FROM co_employees_access as b, co_employees as c WHERE (b.admins REGEXP '[[:<:]]" . $session->uid . "[[:>:]]' or b.guests REGEXP '[[:<:]]" . $session->uid . "[[:>:]]') and c.folder=a.id and b.pid=c.id) > 0 ORDER BY title";
		} else {
			$q ="select id, title from " . CO_TBL_EMPLOYEES_FOLDERS . " where status='0' and bin = '0' ORDER BY title";
		}
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$str .= '<a href="#" class="insertEmployeeFolderfromDialog" title="' . $row["title"] . '" field="'.$field.'" gid="'.$row["id"].'">' . $row["title"] . '</a>';
		}
		$str .= '</div>';	
		return $str;
	 }


	function getEmployeeDialog($field,$sql) {
		global $session;
		$str = '<div class="dialog-text">';
		$q ="select id, name from " . CO_TBL_EMPLOYEES_DIALOG_EMPLOYEES . " WHERE cat = '$sql' ORDER BY name ASC";
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
	   $q = "SELECT COUNT(id) FROM " .  CO_TBL_EMPLOYEES_PHASES. " WHERE pid='$id' $sql and bin='0'";
	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function numPhasesOnTime($id) {
	   //$q = "SELECT COUNT(id) FROM " .  CO_TBL_EMPLOYEES_PHASES. " WHERE pid='$id' $sql and bin='0'";
	   $q = "SELECT a.id,(SELECT MAX(enddate) FROM " . CO_TBL_EMPLOYEES_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as enddate FROM " . CO_TBL_EMPLOYEES_PHASES . " as a where a.pid= '$id' and a.status='2' and a.finished_date <= enddate";

	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function numPhasesTasks($id,$status = 0,$sql="") {
	   //$sql = "";
	   if ($status == 1) {
		   $sql .= " and status='1' ";
	   }
	   $q = "SELECT COUNT(id) FROM " .  CO_TBL_EMPLOYEES_PHASES_TASKS. " WHERE pid='$id' $sql and bin='0'";
	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function getRest($value) {
		return round(100-$value,2);
   }


   function getBin() {
		global $employees;
		
		$bin = array();
		$bin["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		$arr = array();
		$arr["bin"] = $bin;
		
		$arr["folders"] = "";
		$arr["pros"] = "";
		$arr["files"] = "";
		$arr["tasks"] = "";
		
		$active_modules = array();
		foreach($employees->modules as $module => $value) {
			if(CONSTANT('employees_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
				$arr[$module . "_cols"] = "";
			}
		}
		
		//foreach($active_modules as $module) {
							//$name = strtoupper($module);
							//$mod = new $name . "Model()";
							//include("modules/meetings/controller.php");
							//${$name} = new $name("$module");
							
						//}
		
		$q ="select id, title, bin, bintime, binuser from " . CO_TBL_EMPLOYEES_FOLDERS;
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
				
				$qp ="select a.id, a.bin, a.bintime, a.binuser, CONCAT(b.lastname,' ',b.firstname) as title from " . CO_TBL_EMPLOYEES . " as a, co_users as b WHERE a.folder = '$id' and a.cid=b.id";
				$resultp = mysql_query($qp, $this->_db->connection);
				while ($rowp = mysql_fetch_array($resultp)) {
					$pid = $rowp["id"];
					if($rowp["bin"] == "1") { // deleted employees
					foreach($rowp as $key => $val) {
						$pro[$key] = $val;
					}
					$pro["bintime"] = $this->_date->formatDate($pro["bintime"],CO_DATETIME_FORMAT);
					$pro["binuser"] = $this->_users->getUserFullname($pro["binuser"]);
					$pros[] = new Lists($pro);
					$arr["pros"] = $pros;
					} else {

						
						
						// grids
						if(in_array("grids",$active_modules)) {
							$qf ="select id, title, bin, bintime, binuser from " . CO_TBL_EMPLOYEES_GRIDS . " where pid = '$pid'";
							$resultf = mysql_query($qf, $this->_db->connection);
							while ($rowf = mysql_fetch_array($resultf)) {
								$fid = $rowf["id"];
								if($rowf["bin"] == "1") { // deleted phases
									foreach($rowf as $key => $val) {
										$forum[$key] = $val;
									}
									$forum["bintime"] = $this->_date->formatDate($forum["bintime"],CO_DATETIME_FORMAT);
									$forum["binuser"] = $this->_users->getUserFullname($forum["binuser"]);
									$forums[] = new Lists($forum);
									$arr["grids"] = $forums;
								} else {
									// columns
									
									$qc ="select id, bin, bintime, binuser from " . CO_TBL_EMPLOYEES_GRIDS_COLUMNS . " where pid = '$fid'";
									$resultc = mysql_query($qc, $this->_db->connection);
									while ($rowc = mysql_fetch_array($resultc)) {
										$cid = $rowc["id"];
										if($rowc["bin"] == "1") { // deleted phases
											foreach($rowc as $key => $val) {
												$grids_col[$key] = $val;
											}
											
											$items = '';
											$qn = "SELECT title FROM " . CO_TBL_EMPLOYEES_GRIDS_NOTES . " where cid = '$cid' and bin='0' ORDER BY sort";
											$resultn = mysql_query($qn, $this->_db->connection);
											while($rown = mysql_fetch_object($resultn)) {
												$items .= $rown->title . ', ';
													//$items_used[] = $rown->id;
											}
											$grids_col["items"] = rtrim($items,", ");
											
											
											$grids_col["bintime"] = $this->_date->formatDate($grids_col["bintime"],CO_DATETIME_FORMAT);
											$grids_col["binuser"] = $this->_users->getUserFullname($grids_col["binuser"]);
											$grids_cols[] = new Lists($grids_col);
											$arr["grids_cols"] = $grids_cols;
										} else {
											// notes
											$qt ="select id, title, bin, bintime, binuser from " . CO_TBL_EMPLOYEES_GRIDS_NOTES . " WHERE cid = '$cid' ORDER BY sort";
											$resultt = mysql_query($qt, $this->_db->connection);
											while ($rowt = mysql_fetch_array($resultt)) {
												if($rowt["bin"] == "1") { // deleted phases
													foreach($rowt as $key => $val) {
														$grids_task[$key] = $val;
													}
													$grids_task["bintime"] = $this->_date->formatDate($grids_task["bintime"],CO_DATETIME_FORMAT);
													$grids_task["binuser"] = $this->_users->getUserFullname($grids_task["binuser"]);
													$grids_tasks[] = new Lists($grids_task);
													$arr["grids_tasks"] = $grids_tasks;
												} 
											}
										}
									}
								}
							}
						}		

	
						// forums
						if(in_array("forums",$active_modules)) {
							$q ="select id, title, bin, bintime, binuser from " . CO_TBL_EMPLOYEES_FORUMS . " where pid = '$pid'";
							$result = mysql_query($q, $this->_db->connection);
							while ($row = mysql_fetch_array($result)) {
								$id = $row["id"];
								if($row["bin"] == "1") { // deleted forum
									foreach($row as $key => $val) {
										$forum[$key] = $val;
									}
									$forum["bintime"] = $this->_date->formatDate($forum["bintime"],CO_DATETIME_FORMAT);
									$forum["binuser"] = $this->_users->getUserFullname($forum["binuser"]);
									$forums[] = new Lists($forum);
									$arr["forums"] = $forums;
								} else {
									// forums_tasks
									$qmt ="select id, text, bin, bintime, binuser from " . CO_TBL_EMPLOYEES_FORUMS_POSTS . " where pid = '$id'";
									$resultmt = mysql_query($qmt, $this->_db->connection);
									while ($rowmt = mysql_fetch_array($resultmt)) {
										if($rowmt["bin"] == "1") { // deleted phases
											foreach($rowmt as $key => $val) {
												$forums_task[$key] = $val;
											}
											$forums_task["bintime"] = $this->_date->formatDate($forums_task["bintime"],CO_DATETIME_FORMAT);
											$forums_task["binuser"] = $this->_users->getUserFullname($forums_task["binuser"]);
											$forums_tasks[] = new Lists($forums_task);
											$arr["forums_tasks"] = $forums_tasks;
										}
									}
								}
							}
						}
	
						// meetings
						if(in_array("meetings",$active_modules)) {
							$qm ="select id, title, bin, bintime, binuser from " . CO_TBL_EMPLOYEES_MEETINGS . " where pid = '$pid'";
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
									$qmt ="select id, title, bin, bintime, binuser from " . CO_TBL_EMPLOYEES_MEETINGS_TASKS . " where mid = '$mid'";
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
						

						// phonecalls
						if(in_array("phonecalls",$active_modules)) {
							$qpc ="select id, title, bin, bintime, binuser from " . CO_TBL_EMPLOYEES_PHONECALLS . " where pid = '$pid'";
							$resultpc = mysql_query($qpc, $this->_db->connection);
							while ($rowpc = mysql_fetch_array($resultpc)) {
								if($rowpc["bin"] == "1") {
								$idp = $rowpc["id"];
									foreach($rowpc as $key => $val) {
										$phonecall[$key] = $val;
									}
									$phonecall["bintime"] = $this->_date->formatDate($phonecall["bintime"],CO_DATETIME_FORMAT);
									$phonecall["binuser"] = $this->_users->getUserFullname($phonecall["binuser"]);
									$phonecalls[] = new Lists($phonecall);
									$arr["phonecalls"] = $phonecalls;
								}
							}
						}
						
						// documents_folder
						if(in_array("documents",$active_modules)) {
							$qd ="select id, title, bin, bintime, binuser from " . CO_TBL_EMPLOYEES_DOCUMENTS_FOLDERS . " where pid = '$pid'";
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
									$qf ="select id, filename, bin, bintime, binuser from " . CO_TBL_EMPLOYEES_DOCUMENTS . " where did = '$did'";
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
	
	
						// vdocs
						if(in_array("vdocs",$active_modules)) {
							$qv ="select id, title, bin, bintime, binuser from " . CO_TBL_EMPLOYEES_VDOCS . " where pid = '$pid' and bin='1'";
							$resultv = mysql_query($qv, $this->_db->connection);
							while ($rowv = mysql_fetch_array($resultv)) {
								$vid = $rowv["id"];
									foreach($rowv as $key => $val) {
										$vdoc[$key] = $val;
									}
									$vdoc["bintime"] = $this->_date->formatDate($vdoc["bintime"],CO_DATETIME_FORMAT);
									$vdoc["binuser"] = $this->_users->getUserFullname($vdoc["binuser"]);
									$vdocs[] = new Lists($vdoc);
									$arr["vdocs"] = $vdocs;
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
		global $employees;
		
		$bin = array();
		$bin["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		$arr = array();
		$arr["bin"] = $bin;
		
		$arr["folders"] = "";
		$arr["pros"] = "";
		$arr["files"] = "";
		$arr["tasks"] = "";
		
		$active_modules = array();
		foreach($employees->modules as $module => $value) {
			if(CONSTANT('employees_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
				$arr[$module . "_cols"] = "";
			}
		}
		
		$q ="select id, title, bin, bintime, binuser from " . CO_TBL_EMPLOYEES_FOLDERS;
		$result = mysql_query($q, $this->_db->connection);
	  	while ($row = mysql_fetch_array($result)) {
			$id = $row["id"];
			if($row["bin"] == "1") { // deleted folders
				$this->deleteFolder($id);
			} else { // folder not binned
				
				$qp ="select a.id, a.bin, a.bintime, a.binuser, CONCAT(b.lastname,' ',b.firstname) as title from " . CO_TBL_EMPLOYEES . " as a, co_users as b WHERE a.folder = '$id' and a.cid=b.id";
				$resultp = mysql_query($qp, $this->_db->connection);
				while ($rowp = mysql_fetch_array($resultp)) {
					$pid = $rowp["id"];
					if($rowp["bin"] == "1") { // deleted employees
						$this->deleteEmployee($pid);
					} else {
						
						
						// grids
					if(in_array("grids",$active_modules)) {
						$employeesGridsModel = new EmployeesGridsModel();
						$qf ="select id, title, bin, bintime, binuser from " . CO_TBL_EMPLOYEES_GRIDS . " where pid = '$pid'";
						$resultf = mysql_query($qf, $this->_db->connection);
						while ($rowf = mysql_fetch_array($resultf)) {
							$fid = $rowf["id"];
							if($rowf["bin"] == "1") { // deleted phases
								$employeesGridsModel->deleteGrid($fid);
								$arr["grids"] = "";
							} else {
								// columns
								
								$qc ="select id,bin from " . CO_TBL_EMPLOYEES_GRIDS_COLUMNS . " where pid = '$fid'";
								$resultc = mysql_query($qc, $this->_db->connection);
								while ($rowc = mysql_fetch_array($resultc)) {
									$cid = $rowc["id"];
									if($rowc["bin"] == "1") { // deleted phases
										$employeesGridsModel->deleteGridColumn($cid);
										$arr["grids_cols"] = "";
									} else {
										// notes
										$qt ="select id,bin from " . CO_TBL_EMPLOYEES_GRIDS_NOTES . " where cid = '$cid'";
										$resultt = mysql_query($qt, $this->_db->connection);
										while ($rowt = mysql_fetch_array($resultt)) {
											if($rowt["bin"] == "1") { // deleted phases
												$tid = $rowt["id"];
												$employeesGridsModel->deleteGridTask($tid);
												$arr["grids_tasks"] = "";
											} 
										}
									}
								}
							}
						}
					}
						
						
						
						
						// forums
						if(in_array("forums",$active_modules)) {
							$employeesForumsModel = new EmployeesForumsModel();
							$q ="select id, title, bin, bintime, binuser from " . CO_TBL_EMPLOYEES_FORUMS . " where pid = '$pid'";
							$result = mysql_query($q, $this->_db->connection);
							while ($row = mysql_fetch_array($result)) {
								$id = $row["id"];
								if($row["bin"] == "1") { // deleted forum
									$employeesForumsModel->deleteForum($id);
									$arr["forums"] = "";
								} else {
									// forums_tasks
									$qmt ="select id, text, bin, bintime, binuser from " . CO_TBL_EMPLOYEES_FORUMS_POSTS . " where pid = '$id'";
									$resultmt = mysql_query($qmt, $this->_db->connection);
									while ($rowmt = mysql_fetch_array($resultmt)) {
										if($rowmt["bin"] == "1") { // deleted phases
											$mtid = $rowmt["id"];
											$employeesForumsModel->deleteItem($mtid);
											$arr["forums_tasks"] = "";
										}
									}
								}
							}
						}


						// meetings
						if(in_array("meetings",$active_modules)) {
							$employeesMeetingsModel = new EmployeesMeetingsModel();
							$qm ="select id, title, bin, bintime, binuser from " . CO_TBL_EMPLOYEES_MEETINGS . " where pid = '$pid'";
							$resultm = mysql_query($qm, $this->_db->connection);
							while ($rowm = mysql_fetch_array($resultm)) {
								$mid = $rowm["id"];
								if($rowm["bin"] == "1") { // deleted meeting
									$employeesMeetingsModel->deleteMeeting($mid);
									$arr["meetings"] = "";
								} else {
									// meetings_tasks
									$qmt ="select id, title, bin, bintime, binuser from " . CO_TBL_EMPLOYEES_MEETINGS_TASKS . " where mid = '$mid'";
									$resultmt = mysql_query($qmt, $this->_db->connection);
									while ($rowmt = mysql_fetch_array($resultmt)) {
										if($rowmt["bin"] == "1") { // deleted phases
											$mtid = $rowmt["id"];
											$employeesMeetingsModel->deleteMeetingTask($mtid);
											$arr["meetings_tasks"] = "";
										}
									}
								}
							}
						}
						
						
						// phonecalls
						if(in_array("phonecalls",$active_modules)) {
							$employeesPhoncallsModel = new EmployeesPhonecallsModel();
							$qc ="select id, title, bin, bintime, binuser from " . CO_TBL_EMPLOYEES_PHONECALLS . " where pid = '$pid'";
							$resultc = mysql_query($qc, $this->_db->connection);
							while ($rowc = mysql_fetch_array($resultc)) {
								$cid = $rowc["id"];
								if($rowc["bin"] == "1") {
									$employeesPhoncallsModel->deletePhonecall($cid);
									$arr["phonecalls"] = "";
								}
							}
						}


						// documents_folder
						if(in_array("documents",$active_modules)) {
							$employeesDocumentsModel = new EmployeesDocumentsModel();
							$qd ="select id, title, bin, bintime, binuser from " . CO_TBL_EMPLOYEES_DOCUMENTS_FOLDERS . " where pid = '$pid'";
							$resultd = mysql_query($qd, $this->_db->connection);
							while ($rowd = mysql_fetch_array($resultd)) {
								$did = $rowd["id"];
								if($rowd["bin"] == "1") { // deleted meeting
									$employeesDocumentsModel->deleteDocument($did);
									$arr["documents_folders"] = "";
								} else {
									// files
									$qf ="select id, filename, bin, bintime, binuser from " . CO_TBL_EMPLOYEES_DOCUMENTS . " where did = '$did'";
									$resultf = mysql_query($qf, $this->_db->connection);
									while ($rowf = mysql_fetch_array($resultf)) {
										if($rowf["bin"] == "1") { // deleted phases
											$fid = $rowf["id"];
											$employeesDocumentsModel->deleteFile($fid);
											$arr["files"] = "";
										}
									}
								}
							}
						}
	
	
						// vdocs
						if(in_array("vdocs",$active_modules)) {
							$qv ="select id, title, bin, bintime, binuser from " . CO_TBL_EMPLOYEES_VDOCS . " where pid = '$pid'";
							$resultv = mysql_query($qv, $this->_db->connection);
							while ($rowv = mysql_fetch_array($resultv)) {
								$vid = $rowv["id"];
								if($rowv["bin"] == "1") {
								$vdocsmodel = new VDocsModel();
								$vdocsmodel->deleteVDoc($vid);
								$arr["vdocs"] = "";
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
		$q = "SELECT a.pid FROM co_employees_access as a, co_employees as b WHERE a.pid=b.id and b.bin='0' and a.admins REGEXP '[[:<:]]" . $id . "[[:>:]]' ORDER by b.cid ASC";
      	$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$perms[] = $row["pid"];
		}
		return $perms;
   }


   function getViewPerms($id) {
		global $session;
		$perms = array();
		$q = "SELECT a.pid FROM co_employees_access as a, co_employees as b WHERE a.pid=b.id and b.bin='0' and a.guests REGEXP '[[:<:]]" . $id. "[[:>:]]' ORDER by b.cid ASC";
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


   function getEmployeeAccess($pid) {
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
		
		$q = "INSERT INTO " . CO_TBL_EMPLOYEES_ORDERS_ACCESS . "  set uid = '$id', cid = '$cid', username = '$username', password = '$pwd', access_user = '$session->uid', access_date = '$now', access_status=''";
		
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	
	function removeAccess($id,$cid) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "DELETE FROM " . CO_TBL_EMPLOYEES_ORDERS_ACCESS . " where uid='$id' and cid = '$cid'";
		
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
  
  
 	function getNavModulesNumItems($id) {
		global $employees;
		$active_modules = array();
		foreach($employees->modules as $module => $value) {
			$active_modules[] = $module;
		}
		if(in_array("grids",$active_modules)) {
			$employeesGridsModel = new EmployeesGridsModel();
			$data["employees_grids_items"] = $employeesGridsModel->getNavNumItems($id);
		}
		if(in_array("forums",$active_modules)) {
			$employeesForumsModel = new EmployeesForumsModel();
			$data["employees_forums_items"] = $employeesForumsModel->getNavNumItems($id);
		}
		if(in_array("objectives",$active_modules)) {
			$employeesObjectivesModel = new EmployeesObjectivesModel();
			$data["employees_objectives_items"] = $employeesObjectivesModel->getNavNumItems($id);
		}
		if(in_array("meetings",$active_modules)) {
			$employeesMeetingsModel = new EmployeesMeetingsModel();
			$data["employees_meetings_items"] = $employeesMeetingsModel->getNavNumItems($id);
		}
		if(in_array("phonecalls",$active_modules)) {
			$employeesPhonecallsModel = new EmployeesPhonecallsModel();
			$data["employees_phonecalls_items"] = $employeesPhonecallsModel->getNavNumItems($id);
		}
		if(in_array("documents",$active_modules)) {
			$employeesDocumentsModel = new EmployeesDocumentsModel();
			$data["employees_documents_items"] = $employeesDocumentsModel->getNavNumItems($id);
		}
		if(in_array("vdocs",$active_modules)) {
			$employeesVDocsModel = new EmployeesVDocsModel();
			$data["employees_vdocs_items"] = $employeesVDocsModel->getNavNumItems($id);
		}
		if(in_array("comments",$active_modules)) {
			$employeesCommentsModel = new EmployeesCommentsModel();
			$data["employees_comments_items"] = $employeesCommentsModel->getNavNumItems($id);
		}
		return $data;
	}


	function newCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "INSERT INTO " . CO_TBL_USERS_CHECKPOINTS . " SET uid = '$session->uid', date = '$date', app = 'employees', module = 'employees', app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

 	function updateCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "UPDATE " . CO_TBL_USERS_CHECKPOINTS . " SET date = '$date' WHERE uid = '$session->uid' and app = 'employees' and module = 'employees' and app_id='$id'";
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
		$q = "UPDATE " . CO_TBL_USERS_CHECKPOINTS . " SET note = '$text' WHERE uid = '$session->uid' and app = 'employees' and module = 'employees' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

    function getCheckpointDetails($app,$module,$id){
		global $lang, $session, $employees;
		$row = "";
		if($app =='employees' && $module == 'employees') {
			$q = "SELECT title,folder FROM " . CO_TBL_EMPLOYEES . " WHERE id='$id' and bin='0'";
			$result = mysql_query($q, $this->_db->connection);
			$row = mysql_fetch_array($result);
			if(mysql_num_rows($result) > 0) {
				$row['checkpoint_app_name'] = $lang["EMPLOYEE_TITLE"];
				$row['app_id_app'] = '0';
			}
			return $row;
		} else {
			$active_modules = array();
			foreach($employees->modules as $m => $v) {
					$active_modules[] = $m;
			}
			if($module == 'meetings' && in_array("meetings",$active_modules)) {
				include_once("modules/".$module."/config.php");
				include_once("modules/".$module."/lang/" . $session->userlang . ".php");
				include_once("modules/".$module."/model.php");
				$employeesMeetingsModel = new EmployeesMeetingsModel();
				$row = $employeesMeetingsModel->getCheckpointDetails($id);
				return $row;
			}
		}
   }


	function getGlobalSearch($term){
		global $system, $session, $employees;
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
		foreach($employees->modules as $m => $v) {
			$active_modules[] = $m;
		}
		
		$q = "SELECT a.id, a.folder, CONCAT(b.lastname,' ',b.firstname) as title FROM " . CO_TBL_EMPLOYEES . " as a, co_users as b WHERE (b.lastname like '%$term%' or b.firstname like '%$term%') and  a.bin='0' and a.cid=b.id" . $access ."ORDER BY title";
		$result = mysql_query($q, $this->_db->connection);
		//$num=mysql_affected_rows();
		while($row = mysql_fetch_array($result)) {
			 $rows['value'] = htmlspecialchars_decode($row['title']);
			 $rows['id'] = 'employees,' .$row['folder']. ',' . $row['id'] . ',0,employees';
			 $r[] = $rows;
		}
		// loop through
		$q = "SELECT id, folder FROM " . CO_TBL_EMPLOYEES . " WHERE bin='0'" . $access ."ORDER BY id";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$pid = $row['id'];
			$folder = $row['folder'];
			$sql = "";
			$perm = $this->getEmployeeAccess($pid);
			if($perm == 'guest') {
				$sql = "and access = '1'";
			}
			
			// Meetings
			if(in_array("objectives",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_EMPLOYEES_OBJECTIVES . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'objectives,' .$folder. ',' . $pid . ',' .$rowp['id'].',employees';
					$r[] = $rows;
				}
				// Meeting Tasks
				$qp = "SELECT b.id,CONVERT(a.title USING latin1) as title FROM " . CO_TBL_EMPLOYEES_OBJECTIVES_TASKS . " as a, " . CO_TBL_EMPLOYEES_OBJECTIVES . " as b WHERE b.pid = '$pid' and a.mid = b.id and a.bin = '0' and b.bin = '0' $sql and a.title like '%$term%' ORDER BY a.title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'objectives,' .$folder. ',' . $pid . ',' .$rowp['id'].',employees';
					$r[] = $rows;
				}
			}
			
			// Meetings
			if(in_array("meetings",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_EMPLOYEES_MEETINGS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'meetings,' .$folder. ',' . $pid . ',' .$rowp['id'].',employees';
					$r[] = $rows;
				}
				// Meeting Tasks
				$qp = "SELECT b.id,CONVERT(a.title USING latin1) as title FROM " . CO_TBL_EMPLOYEES_MEETINGS_TASKS . " as a, " . CO_TBL_EMPLOYEES_MEETINGS . " as b WHERE b.pid = '$pid' and a.mid = b.id and a.bin = '0' and b.bin = '0' $sql and a.title like '%$term%' ORDER BY a.title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'meetings,' .$folder. ',' . $pid . ',' .$rowp['id'].',employees';
					$r[] = $rows;
				}
			}
			
			// Doc Folders
			if(in_array("documents",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_EMPLOYEES_DOCUMENTS_FOLDERS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'documents,' .$folder. ',' . $pid . ',' .$rowp['id'].',employees';
					$r[] = $rows;
				}
				// Documents
				$qp = "SELECT b.id,CONVERT(a.filename USING latin1) as title FROM " . CO_TBL_EMPLOYEES_DOCUMENTS . " as a, " . CO_TBL_EMPLOYEES_DOCUMENTS_FOLDERS . " as b WHERE b.pid = '$pid' and a.did = b.id and a.bin = '0' and b.bin = '0' $sql and a.filename like '%$term%' ORDER BY a.filename";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'documents,' .$folder. ',' . $pid . ',' .$rowp['id'].',employees';
					$r[] = $rows;
				}
			}
			// Comments
			if(in_array("comments",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_EMPLOYEES_COMMENTS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'comments,' .$folder. ',' . $pid . ',' .$rowp['id'].',employees';
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
				$q = "SELECT * FROM " . CO_TBL_EMPLOYEES_OBJECTIVES . " WHERE pid = '$id' and status = '1' and bin = '0' ORDER BY item_date DESC LIMIT 0,1";
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
				
				$q2 = "SELECT * FROM " . CO_TBL_EMPLOYEES_OBJECTIVES . " WHERE pid = '$id' and status = '1' and bin = '0' ORDER BY item_date DESC LIMIT 1,1";
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
				$q = "SELECT * FROM " . CO_TBL_EMPLOYEES_OBJECTIVES . " WHERE pid = '$id' and status = '1' and bin = '0' ORDER BY item_date DESC LIMIT 0,1";
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
				
				$q2 = "SELECT * FROM " . CO_TBL_EMPLOYEES_OBJECTIVES . " WHERE pid = '$id' and status = '1' and bin = '0' ORDER BY item_date DESC LIMIT 1,1";
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
				$q = "SELECT id FROM " . CO_TBL_EMPLOYEES_OBJECTIVES . " WHERE pid = '$id' and status = '1' and bin = '0' ORDER BY item_date DESC LIMIT 0,1";
				$result = mysql_query($q, $this->_db->connection);
				if(mysql_num_rows($result) > 0) {
					$mid = mysql_result($result,0);
					$q = "SELECT answer FROM " . CO_TBL_EMPLOYEES_OBJECTIVES_TASKS . "  WHERE mid='$mid' and bin = '0'";
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
				$q = "SELECT id FROM " . CO_TBL_EMPLOYEES_OBJECTIVES . " WHERE pid = '$id' and status = '1' and bin = '0' ORDER BY item_date DESC LIMIT 1,1";
				$result = mysql_query($q, $this->_db->connection);
				if(mysql_num_rows($result) > 0) {
					$mid = mysql_result($result,0);
					$q = "SELECT answer FROM " . CO_TBL_EMPLOYEES_OBJECTIVES_TASKS . "  WHERE mid='$mid' and bin = '0'";
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


}

$employeesmodel = new EmployeesModel(); // needed for direct calls to functions eg echo $employeesmodel ->getEmployeeTitle(1);
?>
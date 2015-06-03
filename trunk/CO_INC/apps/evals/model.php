<?php
//include_once(CO_PATH_BASE . "/model.php");
//include_once(dirname(__FILE__)."/model/folders.php");
//include_once(dirname(__FILE__)."/model/evals.php");

class EvalsModel extends Model {
	
	// Get all Eval Folders
   function getFolderList($sort) {
      global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("evals-folder-sort-status");
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
				  		$sortorder = $this->getSortOrder("evals-folder-sort-order");
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
				  		$sortorder = $this->getSortOrder("evals-folder-sort-order");
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
			$q ="select a.id, a.title from " . CO_TBL_EVALS_FOLDERS . " as a where a.status='0' and a.bin = '0' and (SELECT count(*) FROM co_evals_access as b, co_evals as c WHERE (b.admins REGEXP '[[:<:]]" . $session->uid . "[[:>:]]' or b.guests REGEXP '[[:<:]]" . $session->uid . "[[:>:]]') and c.folder=a.id and b.pid=c.id) > 0 " . $order;
		} else {
			$q ="select a.id, a.title from " . CO_TBL_EVALS_FOLDERS . " as a where a.status='0' and a.bin = '0' " . $order;
		}
		
	  $this->setSortStatus("evals-folder-sort-status",$sortcur);
      $result = mysql_query($q, $this->_db->connection);
	  $folders = "";
	  while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
				if($key == "id") {
				$array["numEvals"] = $this->getNumEvals($val);
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
   * get details for the eval folder
   */
   function getFolderDetails($id) {
		global $session, $contactsmodel, $evalsControllingModel, $lang;
		$q = "SELECT * FROM " . CO_TBL_EVALS_FOLDERS . " where id = '$id'";
		
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_assoc($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		$array["allevals"] = $this->getNumEvals($id);
		$array["plannedevals"] = $this->getNumEvals($id, $status="0");
		$array["activeevals"] = $this->getNumEvals($id, $status="1");
		$array["inactiveevals"] = $this->getNumEvals($id, $status="2");
		$array["stoppedevals"] = $this->getNumEvals($id, $status="3");
		
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
		
		// get eval details
		$access="";
		if(!$session->isSysadmin()) {
			$access = " and a.id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
	  	}
		
		 $sortstatus = $this->getSortStatus("evals-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("evals-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by title";
						  } else {
							$order = "order by field(a.id,$sortorder)";
						  }
				  break;	
			  }
		  }
		
		
		$q = "SELECT a.*,CONCAT(b.lastname,' ',b.firstname) as title FROM " . CO_TBL_EVALS . " as a, co_users as b WHERE a.folder='$id' and a.bin='0' and a.cid=b.id" . $access . " " . $order;
		$result = mysql_query($q, $this->_db->connection);
	  	$evals = "";
	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$eval[$key] = $val;
			}
			//$eval["management"] = $contactsmodel->getUserListPlain($eval['management']);
			$eval["perm"] = $this->getEvalAccess($eval["id"]);
			
		switch($eval["status"]) {
			case "0":
				$eval["status_text"] = $lang["GLOBAL_STATUS_INPREPARATION"];
				$eval["status_text_time"] = $lang["GLOBAL_STATUS_INPREPARATION_TIME"];
				$eval["status_date"] = $this->_date->formatDate($eval["planned_date"],CO_DATE_FORMAT);
			break;
			case "1":
				$eval["status_text"] = $lang["GLOBAL_STATUS_FIRSTEVAL"];
				$eval["status_text_time"] = $lang["GLOBAL_STATUS_FIRSTEVAL_TIME"];
				$eval["status_date"] = $this->_date->formatDate($eval["inprogress_date"],CO_DATE_FORMAT);
			break;
			case "2":
				$eval["status_text"] = $lang["GLOBAL_STATUS_INEVALUATION"];
				$eval["status_text_time"] = $lang["GLOBAL_STATUS_INEVALUATION_TIME"];
				$eval["status_date"] = $this->_date->formatDate($eval["finished_date"],CO_DATE_FORMAT);
			break;
			case "3":
				$eval["status_text"] = $lang["GLOBAL_STATUS_FINISHED"];
				$eval["status_text_time"] = $lang["GLOBAL_STATUS_FINISHED_TIME"];
				$eval["status_date"] = $this->_date->formatDate($eval["stopped_date"],CO_DATE_FORMAT);
			break;
		}
			
			$evals[] = new Lists($eval);
	  	}
		
		$access = "guest";
		  if($session->isSysadmin()) {
			  $access = "sysadmin";
		  }
		
		$arr = array("folder" => $folder, "evals" => $evals, "access" => $access);
		return $arr;
   }


   /**
   * get details for the eval folder
   */
   function setFolderDetails($id,$title,$evalstatus) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_EVALS_FOLDERS . " set title = '$title', status = '$evalstatus', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }


   /**
   * create new eval folder
   */
	function newFolder() {
		global $session, $lang;
		$now = gmdate("Y-m-d H:i:s");
		$title = $lang["EVAL_FOLDER_NEW"];
		
		$q = "INSERT INTO " . CO_TBL_EVALS_FOLDERS . " set title = '$title', status = '0', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	$id = mysql_insert_id();
			return $id;
		}
	}


   /**
   * delete eval folder
   */
   function binFolder($id) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_EVALS_FOLDERS . " set bin = '1', bintime = '$now', binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   
   function restoreFolder($id) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_EVALS_FOLDERS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deleteFolder($id) {
		$q = "SELECT id FROM " . CO_TBL_EVALS . " where folder = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$pid = $row["id"];
			$this->deleteEval($pid);
		}
		
		$q = "DELETE FROM " . CO_TBL_EVALS_FOLDERS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


  /**
   * get number of evals for a eval folder
   * status: 0 = all, 1 = active, 2 = abgeschlossen
   */   
   function getNumEvals($id, $status="") {
		global $session;
		
		$access = "";
		 if(!$session->isSysadmin()) {
			$access = " and id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
		  }
		
		if($status == "") {
			$q = "select id from " . CO_TBL_EVALS . " where folder='$id' " . $access . " and bin != '1'";
		} else {
			$q = "select id from " . CO_TBL_EVALS . " where folder='$id' " . $access . " and status = '$status' and bin != '1'";
		}
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_num_rows($result);
		return $row;
	}


	function getEvalTitle($id){
		global $session;
		//$q = "SELECT title FROM " . CO_TBL_EVALS . " where id = '$id'";
		$q = "SELECT CONCAT(b.lastname,' ',b.firstname) as title FROM " . CO_TBL_EVALS . " as a, co_users as b  where a.id = '$id' and a.cid=b.id";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		return $title;
   }


   	function getEvalTitleFromIDs($array){
		//$string = explode(",", $string);
		$total = sizeof($array);
		$data = '';
		
		if($total == 0) { 
			return $data; 
		}
		
		// check if eval is available and build array
		$arr = array();
		foreach ($array as &$value) {
			$q = "SELECT id,title FROM " . CO_TBL_EVALS . " where id = '$value' and bin='0'";
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

	function getEvalTitleLinkFromIDs($array,$target){
		$total = sizeof($array);
		$data = '';
		if($total == 0) { 
			return $data; 
		}
		$arr = array();
		$i = 0;
		foreach ($array as &$value) {
			$q = "SELECT a.id,a.folder,CONCAT(b.lastname,' ',b.firstname) as title FROM " . CO_TBL_EVALS . " as a, co_users as b  where a.id = '$value' and a.cid=b.id and a.bin='0' and b.bin='0'";
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
			$data .= '<a class="externalLoadThreeLevels" rel="' . $target. ','.$value["folder"].','.$value["id"].',1,evals">' . $value["title"] . '</a>';
			if($i < $arr_total) {
				$data .= '<br />';
			}
			$data .= '';	
			$i++;
		}
		return $data;
   }


function getEvalTitleFromMeetingIDs($array,$target, $link = 0){
		$total = sizeof($array);
		$data = '';
		if($total == 0) { 
			return $data; 
		}
		$arr = array();
		$i = 0;
		foreach ($array as &$value) {
			$qm = "SELECT pid,created_date FROM " . CO_TBL_EVALS_MEETINGS . " where id = '$value' and bin='0'";
			$resultm = mysql_query($qm, $this->_db->connection);
			if(mysql_num_rows($resultm) > 0) {
				$rowm = mysql_fetch_row($resultm);
				$pid = $rowm[0];
				$date = $this->_date->formatDate($rowm[1],CO_DATETIME_FORMAT);
				$q = "SELECT a.id,a.folder,CONCAT(b.lastname,' ',b.firstname) as title FROM " . CO_TBL_EVALS . " as a, co_users as b  where a.id = '$pid' and a.cid=b.id and a.bin='0' and b.bin='0'";
				$result = mysql_query($q, $this->_db->connection);
				if(mysql_num_rows($result) > 0) {
					while($row = mysql_fetch_assoc($result)) {
						$arr[$i]["id"] = $row["id"];
						$arr[$i]["item"] = $value;
						$arr[$i]["access"] = $this->getEvalAccess($row["id"]);
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
				$data .= '<a class="externalLoadThreeLevels" rel="' . $target. ','.$value["folder"].','.$value["id"].',' . $value["item"] . ',evals">' . $value["title"] . '</a>';
			}
			if($i < $arr_total) {
				$data .= '<br />';
			}
			$data .= '';	
			$i++;
		}
		return $data;
   }

   	function getEvalField($id,$field){
		global $session;
		$q = "SELECT $field FROM " . CO_TBL_EVALS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		return $title;
   }


  /**
   * get the list of evals for a eval folder
   */ 
   function getEvalList($id,$sort) {
      global $session,$contactsmodel;
	  
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("evals-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("evals-sort-order",$id);
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
				  		$sortorder = $this->getSortOrder("evals-sort-order",$id);
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
	  $q ="select a.id,CONCAT(b.lastname,' ',b.firstname) as title,a.status,a.checked_out,a.checked_out_user from " . CO_TBL_EVALS . " as a, co_users as b where a.cid=b.id and a.folder='$id' and a.bin = '0' " . $access . $order;

	  $this->setSortStatus("evals-sort-status",$sortcur,$id);
      $result = mysql_query($q, $this->_db->connection);
	  $evals = "";
	  while ($row = mysql_fetch_array($result)) {
		foreach($row as $key => $val) {
			$array[$key] = $val;
			if($key == "id") {
				if($this->getEvalAccess($val) == "guest") {
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
				$this->checkinEvalOverride($id);
			}
		}
		$array["checked_out_status"] = $checked_out_status;
		
		$evals[] = new Lists($array);
	  }
	  $arr = array("evals" => $evals, "sort" => $sortcur);
	  return $arr;
   }
	
	
	function checkoutEval($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_EVALS . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function checkinEval($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_EVALS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_EVALS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}
	
	function checkinEvalOverride($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_EVALS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	

   function getEvalDetails($id,$option = "") {
		global $session, $contactsmodel, $lang;
		$q = "SELECT a.*,CONCAT(b.lastname,', ',b.firstname) as title,b.title as ctitle,b.title2,b.position,b.phone1,b.email FROM " . CO_TBL_EVALS . " as a, co_users as b where a.cid=b.id and a.id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		// perms
		$array["access"] = $this->getEvalAccess($id);
		if($array["access"] == "guest") {
			// check if this user is admin in some other eval
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
					$array["canedit"] = $this->checkoutEval($id);
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
					$array["checked_out_user_phone1"] = $contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
					$array["checked_out_user_email"] = $contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");
				}
			} else {
				$array["canedit"] = $this->checkoutEval($id);
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
		$array["folder_id"] = $array["folder"];
		$array["folder"] = $this->getEvalFolderDetails($array["folder"],"folder");		
		$array["kind"] = $this->getEvalIdDetails($array["kind"],"evalskind");
		$array["area"] = $this->getEvalIdDetails($array["area"],"evalsarea");
		$array["department"] = $this->getEvalIdDetails($array["department"],"evalsdepartment");
		$array["family"] = $this->getEvalIdDetails($array["family"],"evalsfamily");
		$array["education"] = $this->getEvalIdDetails($array["education"],"evalseducation");
		
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		$array["current_user"] = $session->uid;
		
		$array["status_planned_active"] = "";
		$array["status_inprogress_active"] = "";
		$array["status_finished_active"] = "";
		$array["status_stopped_active"] = "";
		switch($array["status"]) {
			case "0":
				$array["status_text"] = $lang["GLOBAL_STATUS_INPREPARATION"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_INPREPARATION_TIME"];
				$array["status_planned_active"] = " active";
				$array["status_date"] = $this->_date->formatDate($array["planned_date"],CO_DATE_FORMAT);
			break;
			case "1":
				$array["status_text"] = $lang["GLOBAL_STATUS_FIRSTEVAL"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_FIRSTEVAL_TIME"];
				$array["status_inprogress_active"] = " active";
				$array["status_date"] = $this->_date->formatDate($array["inprogress_date"],CO_DATE_FORMAT);
			break;
			case "2":
				$array["status_text"] = $lang["GLOBAL_STATUS_INEVALUATION"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_INEVALUATION_TIME"];
				$array["status_finished_active"] = " active";
				$array["status_date"] = $this->_date->formatDate($array["finished_date"],CO_DATE_FORMAT);
			break;
			case "3":
				$array["status_text"] = $lang["GLOBAL_STATUS_FINISHED"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_FINISHED_TIME"];
				$array["status_stopped_active"] = " active";
				$array["status_date"] = $this->_date->formatDate($array["stopped_date"],CO_DATE_FORMAT);
			break;
		}
		
		// checkpoint
		$array["checkpoint"] = 0;
		$array["checkpoint_date"] = "";
		$array["checkpoint_note"] = "";
		$q = "SELECT date,note FROM " . CO_TBL_USERS_CHECKPOINTS . " where uid='$session->uid' and app = 'evals' and module = 'evals' and app_id = '$id' LIMIT 1";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			while ($row = mysql_fetch_assoc($result)) {
			$array["checkpoint"] = 1;
			$array["checkpoint_date"] = $this->_date->formatDate($row['date'],CO_DATE_FORMAT);
			$array["checkpoint_note"] = $row['note'];
			}
		}
		
		$leistungen = array();
		$ql = "SELECT * FROM " . CO_TBL_EVALS_OBJECTIVES . " where pid = '$id' and bin='0' ORDER BY item_date DESC";
		$result = mysql_query($ql, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$leistung[$key] = $val;
			}
			$lid = $leistung['id'];
			$leistung["item_date"] = $this->_date->formatDate($leistung["item_date"],CO_DATE_FORMAT);
			$tab2result = 0;
			if(!empty($leistung["tab2q1"])) { $tab2result += $leistung["tab2q1"]; }
			if(!empty($leistung["tab2q2"])) { $tab2result += $leistung["tab2q2"]; }
			if(!empty($leistung["tab2q3"])) { $tab2result += $leistung["tab2q3"]; }
			if(!empty($leistung["tab2q4"])) { $tab2result += $leistung["tab2q4"]; }
			if(!empty($leistung["tab2q5"])) { $tab2result += $leistung["tab2q5"]; }
			if(!empty($leistung["tab2q6"])) { $tab2result += $leistung["tab2q6"]; }
			if(!empty($leistung["tab2q7"])) { $tab2result += $leistung["tab2q7"]; }
			if(!empty($leistung["tab2q8"])) { $tab2result += $leistung["tab2q8"]; }
			if(!empty($leistung["tab2q9"])) { $tab2result += $leistung["tab2q9"]; }
			if(!empty($leistung["tab2q10"])) { $tab2result += $leistung["tab2q10"]; }
			if(!empty($leistung["tab2q11"])) { $tab2result += $leistung["tab2q11"]; }
			if(!empty($leistung["tab2q12"])) { $tab2result += $leistung["tab2q12"]; }
			if(!empty($leistung["tab2q13"])) { $tab2result += $leistung["tab2q13"]; }
			if(!empty($leistung["tab2q14"])) { $tab2result += $leistung["tab2q14"]; }
			if(!empty($leistung["tab2q15"])) { $tab2result += $leistung["tab2q15"]; }
			if(!empty($leistung["tab2q16"])) { $tab2result += $leistung["tab2q16"]; }
			if(!empty($leistung["tab2q17"])) { $tab2result += $leistung["tab2q17"]; }
			$tab2result = round(100/170* $tab2result,0);
			$performance = $tab2result;
			
			$qt = "SELECT answer FROM " . CO_TBL_EVALS_OBJECTIVES_TASKS . "  WHERE mid='$lid' and bin = '0'";
			$resultt = mysql_query($qt, $this->_db->connection);
			$num = mysql_num_rows($resultt)*10;
			$tab3result = 0;
			while($rowt = mysql_fetch_assoc($resultt)) {
				if(!empty($rowt["answer"])) { $tab3result += $rowt["answer"]; }
			}
			if($tab3result == 0) {
				$goals = 0;
			} else {
				$goals =  round(100/$num* $tab3result,0)*3;
			}
			/*$chart = $this->getChartPerformance($id,'performance',0);
			$performance = $chart["real"];
			$chart = $this->getChartPerformance($id,'goals',0);
			$goals = $chart["real"]*3;*/
			$total = $performance+$goals;
			$leistung["total"] = round(100/400*$total,0);
			
			$leistungen[] = new Lists($leistung);
		}
		
		$eval = new Lists($array);
		
		$sql="";
		if($array["access"] == "guest") {
			$sql = " and a.access = '1' ";
		}
				
		$sendto = $this->getSendtoDetails("evals",$id);
		
		$arr = array("eval" => $eval, "leistungen" => $leistungen, "sendto" => $sendto, "access" => $array["access"]);
		return $arr;
   }

	function getEvalTrainingsDetails($id){
		$trainings = array();
		$q = "SELECT b.*,c.title,c.folder,c.id as trainingid,c.costs,c.date1,c.date2,c.date3,c.training FROM co_evals as a, co_trainings_members as b, co_trainings as c, co_trainings_folders as d WHERE a.cid=b.cid and b.pid=c.id and b.tookpart='1' and c.folder=d.id and b.bin='0' and c.bin='0' and d.bin='0' and c.status='2' and a.id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_assoc($result)) {
				foreach($row as $key => $val) {
					$array[$key] = $val;
				}
				$array["costs"] = number_format($array["costs"],0,',','.');
				$array["dates_display"] = "";
			switch($array["training"]) {
				case '1': // Vortrag
					$array["date1"] = $this->_date->formatDate($array["date1"],CO_DATE_FORMAT);
					$array["dates_display"] = $array["date1"];
				break;
				case '2': // Vortrag & Coaching
					$array["date1"] = $this->_date->formatDate($array["date1"],CO_DATE_FORMAT);
					$array["date2"] = $this->_date->formatDate($array["date2"],CO_DATE_FORMAT);
					$array["dates_display"] = $array["date1"] . ' - ' . $array["date2"];
				break;
				case '3': // e-training
					$array["date1"] = $this->_date->formatDate($array["date1"],CO_DATE_FORMAT);
					$array["date3"] = $this->_date->formatDate($array["date3"],CO_DATE_FORMAT);
					$array["dates_display"] = $array["date1"] . ' - ' . $array["date3"];
				break;
				case '4': // e-training & Coaching
					$array["date1"] = $this->_date->formatDate($array["date1"],CO_DATE_FORMAT);
					$array["date2"] = $this->_date->formatDate($array["date2"],CO_DATE_FORMAT);
					$array["dates_display"] = $array["date1"] . ' - ' . $array["date2"];
				break;
				case '5': // einzelcoaching
					$array["date1"] = $this->_date->formatDate($array["date1"],CO_DATE_FORMAT);
					$array["dates_display"] = $array["date1"];
				break;
				case '6': // workshop
					$array["date1"] = $this->_date->formatDate($array["date1"],CO_DATE_FORMAT);
					$array["dates_display"] = $array["date1"];
				break;
				case '7': // veranstaltungsreihe
					$array["date1"] = $this->_date->formatDate($array["date1"],CO_DATE_FORMAT);
					$array["date2"] = $this->_date->formatDate($array["date2"],CO_DATE_FORMAT);
					$array["dates_display"] = $array["date1"] . ' - ' . $array["date2"];
				break;
			}
				
				
			$total_result = 0;
			$array["q1_result"] = 0;
			$array["q2_result"] = 0;
			$array["q3_result"] = 0;
			$array["q4_result"] = 0;
			$array["q5_result"] = 0;
			if(!empty($array["feedback_q1"])) { $array["q1_result"] = $array["feedback_q1"]*20; $total_result += $array["feedback_q1"]; }
			if(!empty($array["feedback_q2"])) { $array["q2_result"] = $array["feedback_q2"]*20; $total_result += $array["feedback_q2"]; }
			if(!empty($array["feedback_q3"])) { $array["q3_result"] = $array["feedback_q3"]*20; $total_result += $array["feedback_q3"]; }
			if(!empty($array["feedback_q4"])) { $array["q4_result"] = $array["feedback_q4"]*20; $total_result += $array["feedback_q4"]; }
			if(!empty($array["feedback_q5"])) { $array["q5_result"] = $array["feedback_q5"]*20; $total_result += $array["feedback_q5"]; }
			
			$array["total_result"] = round(100/25* $total_result,0);
			
			$trainings[] = new Lists($array);
			}
			
			return $trainings;
	}
   // Create eval folder title
	function getEvalFolderDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			$q = "SELECT id, title from " . CO_TBL_EVALS_FOLDERS . " where id = '$value'";
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
   
   
   	function getEvalIdDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			$q = "SELECT id, name from " . CO_TBL_EVALS_DIALOG_EVALS . " where id = '$value'";
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
   * get details for the eval folder
   */
   function setEvalDetails($id,$startdate,$enddate,$protocol,$protocol2,$protocol3,$protocol4,$protocol5,$protocol6,$folder,$number,$kind,$area,$department,$dob,$coo,$family,$languages,$languages_foreign,$street_private,$city_private,$zip_private,$phone_private,$email_private,$education) {
		global $session, $contactsmodel;
		
		$startdate = $this->_date->formatDate($startdate);
		$enddate = $this->_date->formatDate($enddate);
		$dob = $this->_date->formatDate($dob);

		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_EVALS . " set folder = '$folder', startdate='$startdate', enddate='$enddate',  protocol = '$protocol',  protocol2 = '$protocol2', protocol3 = '$protocol3',  protocol4 = '$protocol4',  protocol5 = '$protocol5',  protocol6 = '$protocol6', number = '$number', kind = '$kind', area = '$area', department = '$department', dob = '$dob', coo = '$coo', family = '$family', languages = '$languages', languages_foreign = '$languages_foreign', street_private = '$street_private', city_private = '$city_private', zip_private = '$zip_private', phone_private = '$phone_private', email_private = '$email_private', education = '$education', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
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
		
		$q = "UPDATE " . CO_TBL_EVALS . " set status = '$status', $sql = '$date', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}


	function newEval($id,$cid) {
		global $session, $contactsmodel, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		$title = $lang["EVAL_NEW"];
		
		$q = "INSERT INTO " . CO_TBL_EVALS . " set folder = '$id', cid='$cid', status = '0', startdate = '$now', planned_date = '$now', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			$id = mysql_insert_id();
			// if admin insert him to access
			if(!$session->isSysadmin()) {
				$evalsAccessModel = new EvalsAccessModel();
				$evalsAccessModel->setDetails($id,$session->uid,"");
			}
			return $id;
		}
	}
	
	
	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		// eval
		$q = "INSERT INTO " . CO_TBL_EVALS . " (folder,title,startdate,ordered_by,management,team,eval,eval_more,eval_cat,eval_cat_more,product,product_desc,charge,number,protocol,planned_date,created_date,created_user,edited_date,edited_user) SELECT folder,CONCAT(title,' ".$lang["GLOBAL_DUPLICAT"]."'),'$now',ordered_by,management,team,eval,eval_more,eval_cat,eval_cat_more,product,product_desc,charge,number,protocol,'$now','$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_EVALS . " where id='$id'";

		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		
		if(!$session->isSysadmin()) {
			$evalsAccessModel = new EvalsAccessModel();
			$evalsAccessModel->setDetails($id_new,$session->uid,"");
		}
			
		// processes
		$q = "SELECT id FROM " . CO_TBL_EVALS_GRIDS . " WHERE pid = '$id' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$gridid = $row["id"];
		
			$qg = "INSERT INTO " . CO_TBL_EVALS_GRIDS . " (pid,title,owner,owner_ct,management,management_ct,team,team_ct,created_date,created_user,edited_date,edited_user) SELECT '$id_new',title,owner,owner_ct,management,management_ct,team,team_ct,'$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_EVALS_GRIDS . " where id='$gridid'";
			$resultg = mysql_query($qg, $this->_db->connection);
			$gridid_new = mysql_insert_id();
		
			// cols
			$qc = "SELECT * FROM " . CO_TBL_EVALS_GRIDS_COLUMNS . " WHERE pid = '$gridid' and bin='0'";
			$resultc = mysql_query($qc, $this->_db->connection);
			while($rowc = mysql_fetch_array($resultc)) {
				$colID = $rowc["id"];
				$sort = $rowc['sort'];
				$days = $rowc['days'];
				$qcn = "INSERT INTO " . CO_TBL_EVALS_GRIDS_COLUMNS . " set pid = '$gridid_new', sort='$sort', days='$days'";
				$resultcn = mysql_query($qcn, $this->_db->connection);
				$colID_new = mysql_insert_id();
				
				$qn = "SELECT * FROM " . CO_TBL_EVALS_GRIDS_NOTES . " where cid = '$colID' and bin='0'";
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
					$qnn = "INSERT INTO " . CO_TBL_EVALS_GRIDS_NOTES . " set cid='$colID_new', sort = '$sort', istitle = '$istitle', isstagegate = '$isstagegate', title = '$title', text = '$text', created_date='$now',created_user='$session->uid',edited_date='$now',edited_user='$session->uid'";
					$resultnn = mysql_query($qnn, $this->_db->connection);
				}
			}
		}
		
		//vdocs
		$q = "SELECT id FROM " . CO_TBL_EVALS_VDOCS . " WHERE pid = '$id' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$vdocid = $row["id"];
			$qv = "INSERT INTO " . CO_TBL_EVALS_VDOCS . " (pid,title,content) SELECT '$id_new',title,content FROM " . CO_TBL_EVALS_VDOCS . " where id='$vdocid'";
			$resultv = mysql_query($qv, $this->_db->connection);
		}
		
		if ($result) {
			return $id_new;
		}
	}


	function binEval($id) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_EVALS . " set bin = '1', bintime = '$now', binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	function restoreEval($id) {
		$q = "UPDATE " . CO_TBL_EVALS . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	function deleteEval($id) {
		global $evals;
		
		$active_modules = array();
		foreach($evals->modules as $module => $value) {
			if(CONSTANT('evals_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
			}
		}
		
		if(in_array("objectives",$active_modules)) {
			$evalsObjectivesModel = new EvalsObjectivesModel();
			$q = "SELECT id FROM co_evals_objectives where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$mid = $row["id"];
				$evalsObjectivesModel->deleteObjective($mid);
			}
		}
		
		if(in_array("meetings",$active_modules)) {
			$evalsMeetingsModel = new EvalsMeetingsModel();
			$q = "SELECT id FROM co_evals_meetings where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$mid = $row["id"];
				$evalsMeetingsModel->deleteMeeting($mid);
			}
		}
		
		if(in_array("documents",$active_modules)) {
			$evalsDocumentsModel = new EvalsDocumentsModel();
			$q = "SELECT id FROM co_evals_documents_folders where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$did = $row["id"];
				$evalsDocumentsModel->deleteDocument($did);
			}
		}
		
		if(in_array("comments",$active_modules)) {
			$evalsCommentsModel = new EvalsCommentsModel();
			$q = "SELECT id FROM co_evals_comments where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$pcid = $row["id"];
				$evalsCommentsModel->deleteComment($pcid);
			}
		}



		$q = "DELETE FROM co_log_sendto WHERE what='evals' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_USERS_CHECKPOINTS . " WHERE app = 'evals' and module = 'evals' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM co_evals_access WHERE pid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_EVALS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
		  	return true;
		}
		
	}


   function moveEval($id,$startdate,$movedays) {
		global $session, $contactsmodel;
		
		$startdate = $this->_date->formatDate($_POST['startdate']);
		
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_EVALS . " set startdate = '$startdate', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
			$qt = "SELECT id, startdate, enddate FROM " . CO_TBL_EVALS_PHASES_TASKS . " where pid='$id'";
			$resultt = mysql_query($qt, $this->_db->connection);
			while ($rowt = mysql_fetch_array($resultt)) {
				$tid = $rowt["id"];
				$startdate = $this->_date->addDays($rowt["startdate"],$movedays);
				$enddate = $this->_date->addDays($rowt["enddate"],$movedays);
				$qtk = "UPDATE " . CO_TBL_EVALS_PHASES_TASKS . " set startdate = '$startdate', enddate = '$enddate' where id='$tid'";
				$retvaltk = mysql_query($qtk, $this->_db->connection);
			}
		if ($result) {
			return true;
		}
	}


	function getEvalFolderDialog($field,$title) {
		global $session;
		$str = '<div class="dialog-text">';
		//$q ="select id, title from " . CO_TBL_EVALS_FOLDERS . " where status='0' and bin = '0' ORDER BY title";
		if(!$session->isSysadmin()) {
			$q ="select a.id, a.title from " . CO_TBL_EVALS_FOLDERS . " as a where a.status='0' and a.bin = '0' and (SELECT count(*) FROM co_evals_access as b, co_evals as c WHERE (b.admins REGEXP '[[:<:]]" . $session->uid . "[[:>:]]' or b.guests REGEXP '[[:<:]]" . $session->uid . "[[:>:]]') and c.folder=a.id and b.pid=c.id) > 0 ORDER BY title";
		} else {
			$q ="select id, title from " . CO_TBL_EVALS_FOLDERS . " where status='0' and bin = '0' ORDER BY title";
		}
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$str .= '<a href="#" class="insertEvalFolderfromDialog" title="' . $row["title"] . '" field="'.$field.'" gid="'.$row["id"].'">' . $row["title"] . '</a>';
		}
		$str .= '</div>';	
		return $str;
	 }


	function getEvalDialog($field,$sql) {
		global $session;
		$str = '<div class="dialog-text">';
		$q ="select id, name from " . CO_TBL_EVALS_DIALOG_EVALS . " WHERE cat = '$sql' ORDER BY name ASC";
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
	   $q = "SELECT COUNT(id) FROM " .  CO_TBL_EVALS_PHASES. " WHERE pid='$id' $sql and bin='0'";
	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function numPhasesOnTime($id) {
	   //$q = "SELECT COUNT(id) FROM " .  CO_TBL_EVALS_PHASES. " WHERE pid='$id' $sql and bin='0'";
	   $q = "SELECT a.id,(SELECT MAX(enddate) FROM " . CO_TBL_EVALS_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as enddate FROM " . CO_TBL_EVALS_PHASES . " as a where a.pid= '$id' and a.status='2' and a.finished_date <= enddate";

	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function numPhasesTasks($id,$status = 0,$sql="") {
	   //$sql = "";
	   if ($status == 1) {
		   $sql .= " and status='1' ";
	   }
	   $q = "SELECT COUNT(id) FROM " .  CO_TBL_EVALS_PHASES_TASKS. " WHERE pid='$id' $sql and bin='0'";
	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function getRest($value) {
		return round(100-$value,2);
   }


   function getBin() {
		global $evals;
		
		$bin = array();
		$bin["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		$arr = array();
		$arr["bin"] = $bin;
		
		$arr["folders"] = "";
		$arr["pros"] = "";
		$arr["files"] = "";
		$arr["tasks"] = "";
		
		$active_modules = array();
		foreach($evals->modules as $module => $value) {
			if(CONSTANT('evals_'.$module.'_bin') == 1) {
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
		
		$q ="select id, title, bin, bintime, binuser from " . CO_TBL_EVALS_FOLDERS;
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
				
				$qp ="select a.id, a.bin, a.bintime, a.binuser, CONCAT(b.lastname,' ',b.firstname) as title from " . CO_TBL_EVALS . " as a, co_users as b WHERE a.folder = '$id' and a.cid=b.id";
				$resultp = mysql_query($qp, $this->_db->connection);
				while ($rowp = mysql_fetch_array($resultp)) {
					$pid = $rowp["id"];
					if($rowp["bin"] == "1") { // deleted evals
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
							$qm ="select id, title, bin, bintime, binuser from " . CO_TBL_EVALS_OBJECTIVES . " where pid = '$pid'";
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
									$qmt ="select id, title, bin, bintime, binuser from " . CO_TBL_EVALS_OBJECTIVES_TASKS . " where mid = '$mid'";
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
	
						
	
						// meetings
						if(in_array("meetings",$active_modules)) {
							$qm ="select id, title, bin, bintime, binuser from " . CO_TBL_EVALS_MEETINGS . " where pid = '$pid'";
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
									$qmt ="select id, title, bin, bintime, binuser from " . CO_TBL_EVALS_MEETINGS_TASKS . " where mid = '$mid'";
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
							$qd ="select id, title, bin, bintime, binuser from " . CO_TBL_EVALS_DOCUMENTS_FOLDERS . " where pid = '$pid'";
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
									$qf ="select id, filename, bin, bintime, binuser from " . CO_TBL_EVALS_DOCUMENTS . " where did = '$did'";
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
							$qpc ="select id, title, bin, bintime, binuser from " . CO_TBL_EVALS_COMMENTS . " where pid = '$pid'";
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
		global $evals;
		
		$bin = array();
		$bin["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		$arr = array();
		$arr["bin"] = $bin;
		
		$arr["folders"] = "";
		$arr["pros"] = "";
		$arr["files"] = "";
		$arr["tasks"] = "";
		
		$active_modules = array();
		foreach($evals->modules as $module => $value) {
			if(CONSTANT('evals_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
				$arr[$module . "_cols"] = "";
			}
		}
		
		$q ="select id, title, bin, bintime, binuser from " . CO_TBL_EVALS_FOLDERS;
		$result = mysql_query($q, $this->_db->connection);
	  	while ($row = mysql_fetch_array($result)) {
			$id = $row["id"];
			if($row["bin"] == "1") { // deleted folders
				$this->deleteFolder($id);
			} else { // folder not binned
				
				$qp ="select a.id, a.bin, a.bintime, a.binuser, CONCAT(b.lastname,' ',b.firstname) as title from " . CO_TBL_EVALS . " as a, co_users as b WHERE a.folder = '$id' and a.cid=b.id";
				$resultp = mysql_query($qp, $this->_db->connection);
				while ($rowp = mysql_fetch_array($resultp)) {
					$pid = $rowp["id"];
					if($rowp["bin"] == "1") { // deleted evals
						$this->deleteEval($pid);
					} else {
						
						
						
						// objectives
						if(in_array("objectives",$active_modules)) {
							$evalsObjectivesModel = new EvalsObjectivesModel();
							$qm ="select id, title, bin, bintime, binuser from " . CO_TBL_EVALS_OBJECTIVES . " where pid = '$pid'";
							$resultm = mysql_query($qm, $this->_db->connection);
							while ($rowm = mysql_fetch_array($resultm)) {
								$mid = $rowm["id"];
								if($rowm["bin"] == "1") { // deleted meeting
									$evalsObjectivesModel->deleteObjective($mid);
									$arr["objectives"] = "";
								} else {
									// objectives_tasks
									$qmt ="select id, title, bin, bintime, binuser from " . CO_TBL_EVALS_OBJECTIVES_TASKS . " where mid = '$mid'";
									$resultmt = mysql_query($qmt, $this->_db->connection);
									while ($rowmt = mysql_fetch_array($resultmt)) {
										if($rowmt["bin"] == "1") { // deleted phases
											$mtid = $rowmt["id"];
											$evalsObjectivesModel->deleteObjectiveTask($mtid);
											$arr["objectives_tasks"] = "";
										}
									}
								}
							}
						}

						// meetings
						if(in_array("meetings",$active_modules)) {
							$evalsMeetingsModel = new EvalsMeetingsModel();
							$qm ="select id, title, bin, bintime, binuser from " . CO_TBL_EVALS_MEETINGS . " where pid = '$pid'";
							$resultm = mysql_query($qm, $this->_db->connection);
							while ($rowm = mysql_fetch_array($resultm)) {
								$mid = $rowm["id"];
								if($rowm["bin"] == "1") { // deleted meeting
									$evalsMeetingsModel->deleteMeeting($mid);
									$arr["meetings"] = "";
								} else {
									// meetings_tasks
									$qmt ="select id, title, bin, bintime, binuser from " . CO_TBL_EVALS_MEETINGS_TASKS . " where mid = '$mid'";
									$resultmt = mysql_query($qmt, $this->_db->connection);
									while ($rowmt = mysql_fetch_array($resultmt)) {
										if($rowmt["bin"] == "1") { // deleted phases
											$mtid = $rowmt["id"];
											$evalsMeetingsModel->deleteMeetingTask($mtid);
											$arr["meetings_tasks"] = "";
										}
									}
								}
							}
						}


						// documents_folder
						if(in_array("documents",$active_modules)) {
							$evalsDocumentsModel = new EvalsDocumentsModel();
							$qd ="select id, title, bin, bintime, binuser from " . CO_TBL_EVALS_DOCUMENTS_FOLDERS . " where pid = '$pid'";
							$resultd = mysql_query($qd, $this->_db->connection);
							while ($rowd = mysql_fetch_array($resultd)) {
								$did = $rowd["id"];
								if($rowd["bin"] == "1") { // deleted meeting
									$evalsDocumentsModel->deleteDocument($did);
									$arr["documents_folders"] = "";
								} else {
									// files
									$qf ="select id, filename, bin, bintime, binuser from " . CO_TBL_EVALS_DOCUMENTS . " where did = '$did'";
									$resultf = mysql_query($qf, $this->_db->connection);
									while ($rowf = mysql_fetch_array($resultf)) {
										if($rowf["bin"] == "1") { // deleted phases
											$fid = $rowf["id"];
											$evalsDocumentsModel->deleteFile($fid);
											$arr["files"] = "";
										}
									}
								}
							}
						}
	
	
						// comments
						if(in_array("comments",$active_modules)) {
							$evalsCommentsModel = new EvalsCommentsModel();
							$qc ="select id, title, bin, bintime, binuser from " . CO_TBL_EVALS_COMMENTS . " where pid = '$pid'";
							$resultc = mysql_query($qc, $this->_db->connection);
							while ($rowc = mysql_fetch_array($resultc)) {
								$cid = $rowc["id"];
								if($rowc["bin"] == "1") {
									$evalsCommentsModel->deleteComment($cid);
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
		$q = "SELECT a.pid FROM co_evals_access as a, co_evals as b WHERE a.pid=b.id and b.bin='0' and a.admins REGEXP '[[:<:]]" . $id . "[[:>:]]' ORDER by b.cid ASC";
      	$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$perms[] = $row["pid"];
		}
		return $perms;
   }


   function getViewPerms($id) {
		global $session;
		$perms = array();
		$q = "SELECT a.pid FROM co_evals_access as a, co_evals as b WHERE a.pid=b.id and b.bin='0' and a.guests REGEXP '[[:<:]]" . $id. "[[:>:]]' ORDER by b.cid ASC";
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


   function getEvalAccess($pid) {
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
		
		$q = "INSERT INTO " . CO_TBL_EVALS_ORDERS_ACCESS . "  set uid = '$id', cid = '$cid', username = '$username', password = '$pwd', access_user = '$session->uid', access_date = '$now', access_status=''";
		
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	
	function removeAccess($id,$cid) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "DELETE FROM " . CO_TBL_EVALS_ORDERS_ACCESS . " where uid='$id' and cid = '$cid'";
		
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
  
  
 	function getNavModulesNumItems($id) {
		global $evals;
		$active_modules = array();
		foreach($evals->modules as $module => $value) {
			$active_modules[] = $module;
		}
		if(in_array("grids",$active_modules)) {
			$evalsGridsModel = new EvalsGridsModel();
			$data["evals_grids_items"] = $evalsGridsModel->getNavNumItems($id);
		}
		if(in_array("forums",$active_modules)) {
			$evalsForumsModel = new EvalsForumsModel();
			$data["evals_forums_items"] = $evalsForumsModel->getNavNumItems($id);
		}
		if(in_array("objectives",$active_modules)) {
			$evalsObjectivesModel = new EvalsObjectivesModel();
			$data["evals_objectives_items"] = $evalsObjectivesModel->getNavNumItems($id);
		}
		if(in_array("meetings",$active_modules)) {
			$evalsMeetingsModel = new EvalsMeetingsModel();
			$data["evals_meetings_items"] = $evalsMeetingsModel->getNavNumItems($id);
		}
		if(in_array("phonecalls",$active_modules)) {
			$evalsPhonecallsModel = new EvalsPhonecallsModel();
			$data["evals_phonecalls_items"] = $evalsPhonecallsModel->getNavNumItems($id);
		}
		if(in_array("documents",$active_modules)) {
			$evalsDocumentsModel = new EvalsDocumentsModel();
			$data["evals_documents_items"] = $evalsDocumentsModel->getNavNumItems($id);
		}
		if(in_array("vdocs",$active_modules)) {
			$evalsVDocsModel = new EvalsVDocsModel();
			$data["evals_vdocs_items"] = $evalsVDocsModel->getNavNumItems($id);
		}
		if(in_array("comments",$active_modules)) {
			$evalsCommentsModel = new EvalsCommentsModel();
			$data["evals_comments_items"] = $evalsCommentsModel->getNavNumItems($id);
		}
		return $data;
	}


	function newCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "INSERT INTO " . CO_TBL_USERS_CHECKPOINTS . " SET uid = '$session->uid', date = '$date', app = 'evals', module = 'evals', app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

 	function updateCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "UPDATE " . CO_TBL_USERS_CHECKPOINTS . " SET date = '$date', status='0' WHERE uid = '$session->uid' and app = 'evals' and module = 'evals' and app_id='$id'";
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
		$q = "UPDATE " . CO_TBL_USERS_CHECKPOINTS . " SET note = '$text' WHERE uid = '$session->uid' and app = 'evals' and module = 'evals' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

    function getCheckpointDetails($app,$module,$id){
		global $lang, $session, $evals;
		$row = "";
		if($app =='evals' && $module == 'evals') {
			//$q = "SELECT title,folder FROM " . CO_TBL_EVALS . " WHERE id='$id' and bin='0'";
			$q = "SELECT a.folder,CONCAT(b.lastname,' ',b.firstname) as title FROM " . CO_TBL_EVALS . " as a, co_users as b where a.cid=b.id and a.id = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			$row = mysql_fetch_array($result);
			if(mysql_num_rows($result) > 0) {
				$row['checkpoint_app_name'] = $lang["EVAL_TITLE"];
				$row['app_id_app'] = '0';
			}
			return $row;
		} else {
			$active_modules = array();
			foreach($evals->modules as $m => $v) {
					$active_modules[] = $m;
			}
			if($module == 'meetings' && in_array("meetings",$active_modules)) {
				include_once("modules/".$module."/config.php");
				include_once("modules/".$module."/lang/" . $session->userlang . ".php");
				include_once("modules/".$module."/model.php");
				$evalsMeetingsModel = new EvalsMeetingsModel();
				$row = $evalsMeetingsModel->getCheckpointDetails($id);
				return $row;
			}
		}
   }


	function getGlobalSearch($term){
		global $system, $session, $evals;
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
		foreach($evals->modules as $m => $v) {
			$active_modules[] = $m;
		}
		
		$q = "SELECT a.id, a.folder, CONCAT(b.lastname,' ',b.firstname) as title FROM " . CO_TBL_EVALS . " as a, co_users as b WHERE (b.lastname like '%$term%' or b.firstname like '%$term%') and  a.bin='0' and a.cid=b.id" . $access ."ORDER BY title";
		$result = mysql_query($q, $this->_db->connection);
		//$num=mysql_affected_rows();
		while($row = mysql_fetch_array($result)) {
			 $rows['value'] = htmlspecialchars_decode($row['title']);
			 $rows['id'] = 'evals,' .$row['folder']. ',' . $row['id'] . ',0,evals';
			 $r[] = $rows;
		}
		// loop through
		$q = "SELECT id, folder FROM " . CO_TBL_EVALS . " WHERE bin='0'" . $access ."ORDER BY id";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$pid = $row['id'];
			$folder = $row['folder'];
			$sql = "";
			$perm = $this->getEvalAccess($pid);
			if($perm == 'guest') {
				$sql = "and access = '1'";
			}
			
			// Objectives
			if(in_array("objectives",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_EVALS_OBJECTIVES . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'objectives,' .$folder. ',' . $pid . ',' .$rowp['id'].',evals';
					$r[] = $rows;
				}
				// Meeting Tasks
				$qp = "SELECT b.id,CONVERT(a.title USING latin1) as title FROM " . CO_TBL_EVALS_OBJECTIVES_TASKS . " as a, " . CO_TBL_EVALS_OBJECTIVES . " as b WHERE b.pid = '$pid' and a.mid = b.id and a.bin = '0' and b.bin = '0' $sql and a.title like '%$term%' ORDER BY a.title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'objectives,' .$folder. ',' . $pid . ',' .$rowp['id'].',evals';
					$r[] = $rows;
				}
			}
			
			// Meetings
			if(in_array("meetings",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_EVALS_MEETINGS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'meetings,' .$folder. ',' . $pid . ',' .$rowp['id'].',evals';
					$r[] = $rows;
				}
				// Meeting Tasks
				$qp = "SELECT b.id,CONVERT(a.title USING latin1) as title FROM " . CO_TBL_EVALS_MEETINGS_TASKS . " as a, " . CO_TBL_EVALS_MEETINGS . " as b WHERE b.pid = '$pid' and a.mid = b.id and a.bin = '0' and b.bin = '0' $sql and a.title like '%$term%' ORDER BY a.title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'meetings,' .$folder. ',' . $pid . ',' .$rowp['id'].',evals';
					$r[] = $rows;
				}
			}
			
			// Doc Folders
			if(in_array("documents",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_EVALS_DOCUMENTS_FOLDERS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'documents,' .$folder. ',' . $pid . ',' .$rowp['id'].',evals';
					$r[] = $rows;
				}
				// Documents
				$qp = "SELECT b.id,CONVERT(a.filename USING latin1) as title FROM " . CO_TBL_EVALS_DOCUMENTS . " as a, " . CO_TBL_EVALS_DOCUMENTS_FOLDERS . " as b WHERE b.pid = '$pid' and a.did = b.id and a.bin = '0' and b.bin = '0' and a.filename like '%$term%' ORDER BY a.filename";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'documents,' .$folder. ',' . $pid . ',' .$rowp['id'].',evals';
					$r[] = $rows;
				}
			}
			// Comments
			if(in_array("comments",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_EVALS_COMMENTS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'comments,' .$folder. ',' . $pid . ',' .$rowp['id'].',evals';
					$r[] = $rows;
				}
			}
			
		}
		return json_encode($r);
	}
	
	
	function getObjectives($id) {
		$q = "SELECT * FROM " . CO_TBL_EVALS_OBJECTIVES . " WHERE pid = '$id' and status = '1' and bin = '0' ORDER BY item_date DESC";
		$result = mysql_query($q, $this->_db->connection);
		$num = mysql_num_rows($result);
		return $num;
	}
	
	function getChartPerformance($id, $what, $image = 1, $tendency = 1, $offset = 0) { 
		global $lang;
		//echo $offset;
		if($offset != 0) {
			$offsetNext = $offset-1;
		} else {
			$offsetNext = $offset;
		}
		switch($what) {
			case 'happiness':
				$q = "SELECT * FROM " . CO_TBL_EVALS_OBJECTIVES . " WHERE pid = '$id' and status = '1' and bin = '0' ORDER BY item_date ASC LIMIT $offset,1";
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
					if(!empty($row["tab1q6"])) { $tab1result += $row["tab1q6"]; }
					if(!empty($row["tab1q7"])) { $tab1result += $row["tab1q7"]; }
					if(!empty($row["tab1q8"])) { $tab1result += $row["tab1q8"]; }
					if(!empty($row["tab1q9"])) { $tab1result += $row["tab1q9"]; }
					if(!empty($row["tab1q10"])) { $tab1result += $row["tab1q10"]; }
					if(!empty($row["tab1q11"])) { $tab1result += $row["tab1q11"]; }
					if(!empty($row["tab1q12"])) { $tab1result += $row["tab1q12"]; }
					if(!empty($row["tab1q13"])) { $tab1result += $row["tab1q13"]; }
					if(!empty($row["tab1q14"])) { $tab1result += $row["tab1q14"]; }
					if(!empty($row["tab1q15"])) { $tab1result += $row["tab1q15"]; }
					if(!empty($row["tab1q16"])) { $tab1result += $row["tab1q16"]; }
					if(!empty($row["tab1q17"])) { $tab1result += $row["tab1q17"]; }
					$tab1result = round(100/170* $tab1result,0);
				}
					
				if($num == 0) {
					$chart["real"] = 0;
				} else {
					$chart["real"] = $tab1result;
				}
				
				$today = date("Y-m-d");
				
				$chart["tendency"] = "tendency_positive.png";
				
				$q2 = "SELECT * FROM " . CO_TBL_EVALS_OBJECTIVES . " WHERE pid = '$id' and status = '1' and bin = '0' ORDER BY item_date ASC LIMIT $offsetNext,1";
				$result2 = mysql_query($q2, $this->_db->connection);
				$num2 = mysql_num_rows($result2);
				$i = 1;
				$tab1result2 = 0;
				while($row2 = mysql_fetch_array($result2)) {
					// Tab 1 questios
					$tab1result2 = 0;
					if(!empty($row2["tab1q1"])) { $tab1result2 += $row2["tab1q1"]; }
					if(!empty($row2["tab1q2"])) { $tab1result2 += $row2["tab1q2"]; }
					if(!empty($row2["tab1q3"])) { $tab1result2 += $row2["tab1q3"]; }
					if(!empty($row2["tab1q4"])) { $tab1result2 += $row2["tab1q4"]; }
					if(!empty($row2["tab1q5"])) { $tab1result2 += $row2["tab1q5"]; }
					if(!empty($row2["tab1q6"])) { $tab1result2 += $row2["tab1q6"]; }
					if(!empty($row2["tab1q7"])) { $tab1result2 += $row2["tab1q7"]; }
					if(!empty($row2["tab1q8"])) { $tab1result2 += $row2["tab1q8"]; }
					if(!empty($row2["tab1q9"])) { $tab1result2 += $row2["tab1q9"]; }
					if(!empty($row2["tab1q10"])) { $tab1result2 += $row2["tab1q10"]; }
					if(!empty($row2["tab1q11"])) { $tab1result2 += $row2["tab1q11"]; }
					if(!empty($row2["tab1q12"])) { $tab1result2 += $row2["tab1q12"]; }
					if(!empty($row2["tab1q13"])) { $tab1result2 += $row2["tab1q13"]; }
					if(!empty($row2["tab1q14"])) { $tab1result2 += $row2["tab1q14"]; }
					if(!empty($row2["tab1q15"])) { $tab1result2 += $row2["tab1q15"]; }
					if(!empty($row2["tab1q16"])) { $tab1result2 += $row2["tab1q16"]; }
					if(!empty($row2["tab1q17"])) { $tab1result2 += $row2["tab1q17"]; }
					$tab1result2 = round(100/170* $tab1result2,0);
				}
				$chart["real_old"] =  $tab1result2;
				if($num2 == 0) {
					$chart["tendency"] = "tendency_positive.png";
				} else {
					if($tab1result >= $tab1result2) {
						$chart["tendency"] = "tendency_positive.png";
					} else {
						$chart["tendency"] = "tendency_negative.png";
					}
				}
				
				if($tendency == 0) { $chart["tendency"] = "pixel.gif"; }
				
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = 'Kommunikation';
				$chart["img_name"] = "eval_" . $id . "_" . $offset . "_happiness.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,E5E5E5';
				if($image == 1) {
					$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				}
			break;
			case 'performance':
				$chart["real"] = 0;
				$q = "SELECT * FROM " . CO_TBL_EVALS_OBJECTIVES . " WHERE pid = '$id' and status = '1' and bin = '0' ORDER BY item_date ASC LIMIT $offset,1";
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
					if(!empty($row["tab2q11"])) { $tab2result += $row["tab2q11"]; }
					if(!empty($row["tab2q12"])) { $tab2result += $row["tab2q12"]; }
					if(!empty($row["tab2q13"])) { $tab2result += $row["tab2q13"]; }
					if(!empty($row["tab2q14"])) { $tab2result += $row["tab2q14"]; }
					if(!empty($row["tab2q15"])) { $tab2result += $row["tab2q15"]; }
					if(!empty($row["tab2q16"])) { $tab2result += $row["tab2q16"]; }
					if(!empty($row["tab2q17"])) { $tab2result += $row["tab2q17"]; }
					$tab2result = round(100/170* $tab2result,0);
				}
					
				if($num == 0) {
					$chart["real"] = 0;
				} else {
					$chart["real"] = $tab2result;
				}
				
				$today = date("Y-m-d");
				
				$chart["tendency"] = "tendency_positive.png";
				
				$q2 = "SELECT * FROM " . CO_TBL_EVALS_OBJECTIVES . " WHERE pid = '$id' and status = '1' and bin = '0' ORDER BY item_date ASC LIMIT $offsetNext,1";
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
					if(!empty($row2["tab2q11"])) { $tab2result2 += $row2["tab2q11"]; }
					if(!empty($row2["tab2q12"])) { $tab2result2 += $row2["tab2q12"]; }
					if(!empty($row2["tab2q13"])) { $tab2result2 += $row2["tab2q13"]; }
					if(!empty($row2["tab2q14"])) { $tab2result2 += $row2["tab2q14"]; }
					if(!empty($row2["tab2q15"])) { $tab2result2 += $row2["tab2q15"]; }
					if(!empty($row2["tab2q16"])) { $tab2result2 += $row2["tab2q16"]; }
					if(!empty($row2["tab2q17"])) { $tab2result2 += $row2["tab2q17"]; }
					//$tab2result2 = $tab2result2;
					$tab2result2 = round(100/170* $tab2result2,0);
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
				if($tendency == 0) { $chart["tendency"] = "pixel.gif"; }
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = 'Projektmanagement';
				$chart["img_name"] = "eval_" . $id . "_" . $offset . "_performance.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,E5E5E5';
				if($image == 1) {
					$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				}
			break;
			case 'legal':
				$chart["real"] = 0;
				$q = "SELECT * FROM " . CO_TBL_EVALS_OBJECTIVES . " WHERE pid = '$id' and status = '1' and bin = '0' ORDER BY item_date ASC LIMIT $offset,1";
				$result = mysql_query($q, $this->_db->connection);
				$num = mysql_num_rows($result);
				$i = 1;
				while($row = mysql_fetch_assoc($result)) {
					// Tab 2 questios
					$tab3result = 0;
					if(!empty($row["tab3q1"])) { $tab3result += $row["tab3q1"]; }
					if(!empty($row["tab3q2"])) { $tab3result += $row["tab3q2"]; }
					if(!empty($row["tab3q3"])) { $tab3result += $row["tab3q3"]; }
					if(!empty($row["tab3q4"])) { $tab3result += $row["tab3q4"]; }
					if(!empty($row["tab3q5"])) { $tab3result += $row["tab3q5"]; }
					if(!empty($row["tab3q6"])) { $tab3result += $row["tab3q6"]; }
					if(!empty($row["tab3q7"])) { $tab3result += $row["tab3q7"]; }
					if(!empty($row["tab3q8"])) { $tab3result += $row["tab3q8"]; }
					if(!empty($row["tab3q9"])) { $tab3result += $row["tab3q9"]; }
					if(!empty($row["tab3q10"])) { $tab3result += $row["tab3q10"]; }
					if(!empty($row["tab3q11"])) { $tab3result += $row["tab3q11"]; }
					if(!empty($row["tab3q12"])) { $tab3result += $row["tab3q12"]; }
					if(!empty($row["tab3q13"])) { $tab3result += $row["tab3q13"]; }
					if(!empty($row["tab3q14"])) { $tab3result += $row["tab3q14"]; }
					if(!empty($row["tab3q15"])) { $tab3result += $row["tab3q15"]; }
					if(!empty($row["tab3q16"])) { $tab3result += $row["tab3q16"]; }
					if(!empty($row["tab3q17"])) { $tab3result += $row["tab3q17"]; }
					$tab3result = round(100/170* $tab3result,0);
				}
					
				if($num == 0) {
					$chart["real"] = 0;
				} else {
					$chart["real"] = $tab3result;
				}
				
				$today = date("Y-m-d");
				
				$chart["tendency"] = "tendency_positive.png";
				
				$q2 = "SELECT * FROM " . CO_TBL_EVALS_OBJECTIVES . " WHERE pid = '$id' and status = '1' and bin = '0' ORDER BY item_date ASC LIMIT $offsetNext,1";
				$result2 = mysql_query($q2, $this->_db->connection);
				$num2 = mysql_num_rows($result2);
				$i = 1;
				// Tab 2 questios
				$tab3result2 = 0;
				while($row2 = mysql_fetch_array($result2)) {
					
					if(!empty($row2["tab3q1"])) { $tab3result2 += $row2["tab3q1"]; }
					if(!empty($row2["tab3q2"])) { $tab3result2 += $row2["tab3q2"]; }
					if(!empty($row2["tab3q3"])) { $tab3result2 += $row2["tab3q3"]; }
					if(!empty($row2["tab3q4"])) { $tab3result2 += $row2["tab3q4"]; }
					if(!empty($row2["tab3q5"])) { $tab3result2 += $row2["tab3q5"]; }
					if(!empty($row2["tab3q6"])) { $tab3result2 += $row2["tab3q6"]; }
					if(!empty($row2["tab3q7"])) { $tab3result2 += $row2["tab3q7"]; }
					if(!empty($row2["tab3q8"])) { $tab3result2 += $row2["tab3q8"]; }
					if(!empty($row2["tab3q9"])) { $tab3result2 += $row2["tab3q9"]; }
					if(!empty($row2["tab3q10"])) { $tab3result2 += $row2["tab3q10"]; }
					if(!empty($row2["tab3q11"])) { $tab3result2 += $row2["tab3q11"]; }
					if(!empty($row2["tab3q12"])) { $tab3result2 += $row2["tab3q12"]; }
					if(!empty($row2["tab3q13"])) { $tab3result2 += $row2["tab3q13"]; }
					if(!empty($row2["tab3q14"])) { $tab3result2 += $row2["tab3q14"]; }
					if(!empty($row2["tab3q15"])) { $tab3result2 += $row2["tab3q15"]; }
					if(!empty($row2["tab3q16"])) { $tab3result2 += $row2["tab3q16"]; }
					if(!empty($row2["tab3q17"])) { $tab3result2 += $row2["tab3q17"]; }
					//$tab3result2 = $tab3result2;
					$tab3result2 = round(100/170* $tab3result2,0);
				}
				$chart["real_old"] =  $tab3result2;
				if($num2 == 0) {
					$chart["tendency"] = "tendency_positive.png";
				} else {
					if($chart["real"] >= $tab3result2) {
						$chart["tendency"] = "tendency_positive.png";
					} else {
						$chart["tendency"] = "tendency_negative.png";
					}
				}
				if($tendency == 0) { $chart["tendency"] = "pixel.gif"; }
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = 'Recht & Wirtschaft';
				$chart["img_name"] = "eval_" . $id . "_" . $offset . "_legal.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,E5E5E5';
				if($image == 1) {
					$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				}
			break;
			case 'goals':
				$chart["real"] = 0;
				$q = "SELECT id FROM " . CO_TBL_EVALS_OBJECTIVES . " WHERE pid = '$id' and status = '1' and bin = '0' ORDER BY item_date ASC LIMIT $offset,1";
				$result = mysql_query($q, $this->_db->connection);
				if(mysql_num_rows($result) > 0) {
					$mid = mysql_result($result,0);
					$q = "SELECT answer FROM " . CO_TBL_EVALS_OBJECTIVES_TASKS . "  WHERE mid='$mid' and bin = '0'";
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
				$q = "SELECT id FROM " . CO_TBL_EVALS_OBJECTIVES . " WHERE pid = '$id' and status = '1' and bin = '0' ORDER BY item_date ASC LIMIT $offsetNext,1";
				$result = mysql_query($q, $this->_db->connection);
				if(mysql_num_rows($result) > 0) {
					$mid = mysql_result($result,0);
					$q = "SELECT answer FROM " . CO_TBL_EVALS_OBJECTIVES_TASKS . "  WHERE mid='$mid' and bin = '0'";
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
				$chart["title"] = 'Recht & Wirtschaft';
				$chart["img_name"] = "ma_" . $id . "_goals.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,E5E5E5';
				if($image == 1) {
					$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				}
			break;
			case 'totals':
				$chart = $this->getChartPerformance($id,'happiness',0,1,$offset);
				$happiness = $chart["real"];
				$happiness_old = $chart["real_old"];
				$chart = $this->getChartPerformance($id,'performance',0,1,$offset);
				$performance = $chart["real"];
				$performance_old = $chart["real_old"];
				$chart = $this->getChartPerformance($id,'legal',0,1,$offset);
				$legal = $chart["real"];
				$legal_old = $chart["real_old"];
				
				
				$chart = $this->getChartPerformance($id,'goals',0);
				$goals = $chart["real"]*3;
				$goals_old = $chart["real_old"]*3;
				
				$total = $happiness+$performance+$legal;
				$chart["real"] = round(100/300*$total,0);
				
				
				$chart["tendency"] = "tendency_positive.png";
				
				$total_old = round(100/300*($happiness_old+$performance_old+$legal_old),0);
				
				if($total >= $total_old) {
					$chart["tendency"] = "tendency_positive.png";
				} else {
					$chart["tendency"] = "tendency_negative.png";
				}
				if($tendency == 0) { $chart["tendency"] = "pixel.gif"; }
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = 'Gesamtergebnis';
				$chart["img_name"] = "eval_" . $id . "_" . $offset . "_totals.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=87461e&chf=bg,s,E5E5E5';
				if($image == 1) {
					$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				}
			break;
			}
		
		return $chart;
   }


	function getEvalsSearch($term,$exclude){
		global $system, $session;
		$num=0;
		$access=" ";
		if(!$session->isSysadmin()) {
			$access = " and a.id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
	  	}
		
		$q = "SELECT a.id,CONCAT(b.lastname,' ',b.firstname) as label FROM " . CO_TBL_EVALS . " as a, co_users as b WHERE a.id != '$exclude' and a.cid=b.id and (lastname like '%$term%' or firstname like '%$term%') and  a.bin='0'" . $access ."ORDER BY lastname, firstname ASC";
		
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

	
	function getEvalArray($string){
		$string = explode(",", $string);
		$total = sizeof($string);
		$items = '';
		
		if($total == 0) { 
			return $items; 
		}
		
		// check if user is available and build array
		$items_arr = "";
		foreach ($string as &$value) {
			$q = "SELECT a.id,CONCAT(b.lastname,' ',b.firstname) as title FROM ".CO_TBL_EVALS." as a, co_users as b where a.cid=b.id and a.id = '$value' and a.bin='0'";
			$result = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result) > 0) {
				while($row = mysql_fetch_assoc($result)) {
					$items_arr[] = array("id" => $row["id"], "title" => $row["title"]);		
				}
			}
		}

		return $items_arr;
}
	
	function getLast10Evals() {
		global $session;
		$evals = $this->getEvalArray($this->getUserSetting("last-used-evals"));
	  return $evals;
	}
	
	
	function saveLastUsedEvals($id) {
		global $session;
		$string = $id . "," .$this->getUserSetting("last-used-evals");
		$string = rtrim($string, ",");
		$ids_arr = explode(",", $string);
		$res = array_unique($ids_arr);
		foreach ($res as $key => $value) {
			$ids_rtn[] = $value;
		}
		array_splice($ids_rtn, 7);
		$str = implode(",", $ids_rtn);
		
		$this->setUserSetting("last-used-evals",$str);
	  return true;
	}




}

$evalsmodel = new EvalsModel(); // needed for direct calls to functions eg echo $evalsmodel ->getEvalTitle(1);
?>
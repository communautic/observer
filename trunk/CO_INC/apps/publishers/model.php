<?php
//include_once(CO_PATH_BASE . "/model.php");
//include_once(dirname(__FILE__)."/model/folders.php");
//include_once(dirname(__FILE__)."/model/publishers.php");

class PublishersModel extends Model {
	
	// Get all Publisher Folders
   function getFolderList($sort) {
      global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("publishers-folder-sort-status");
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
				  		$sortorder = $this->getSortOrder("publishers-folder-sort-order");
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
				  		$sortorder = $this->getSortOrder("publishers-folder-sort-order");
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
			$q ="select a.id, a.title from " . CO_TBL_PUBLISHERS_FOLDERS . " as a where a.status='0' and a.bin = '0' and (SELECT count(*) FROM co_publishers_access as b, co_publishers as c WHERE (b.admins REGEXP '[[:<:]]" . $session->uid . "[[:>:]]' or b.guests REGEXP '[[:<:]]" . $session->uid . "[[:>:]]') and c.folder=a.id and b.pid=c.id) > 0 " . $order;
		} else {
			$q ="select a.id, a.title from " . CO_TBL_PUBLISHERS_FOLDERS . " as a where a.status='0' and a.bin = '0' " . $order;
		}
		
	  $this->setSortStatus("publishers-folder-sort-status",$sortcur);
      $result = mysql_query($q, $this->_db->connection);
	  $folders = "";
	  while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
				if($key == "id") {
				$array["numPublishers"] = $this->getNumPublishers($val);
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
   * get details for the publisher folder
   */
   function getFolderDetails($id) {
		global $session, $contactsmodel, $publishersControllingModel, $lang;
		$q = "SELECT * FROM " . CO_TBL_PUBLISHERS_FOLDERS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_assoc($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		$array["allpublishers"] = $this->getNumPublishers($id);
		$array["plannedpublishers"] = $this->getNumPublishers($id, $status="0");
		$array["activepublishers"] = $this->getNumPublishers($id, $status="1");
		$array["inactivepublishers"] = $this->getNumPublishers($id, $status="2");
		$array["stoppedpublishers"] = $this->getNumPublishers($id, $status="3");
		
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
		
		// get publisher details
		$access="";
		if(!$session->isSysadmin()) {
			$access = " and a.id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
	  	}
		
		 $sortstatus = $this->getSortStatus("publishers-sort-status",$id);
		if(!$sortstatus) {
		  	$order = "order by a.title";
		  } else {
			  switch($sortstatus) {
				  case "1":
				  		$order = "order by a.title";
				  break;
				  case "2":
				  		$order = "order by a.title DESC";
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("publishers-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by a.title";
						  } else {
							$order = "order by field(a.id,$sortorder)";
						  }
				  break;	
			  }
		  }
		
		
		$q = "SELECT a.title,a.id,a.management,a.status, (SELECT MIN(startdate) FROM " . CO_TBL_PUBLISHERS_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as startdate ,(SELECT MAX(enddate) FROM " . CO_TBL_PUBLISHERS_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as enddate FROM " . CO_TBL_PUBLISHERS . " as a where a.folder='$id' and a.bin='0'" . $access . " " . $order;

		$result = mysql_query($q, $this->_db->connection);
	  	$publishers = "";
	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$publisher[$key] = $val;
			}
			$publisher["startdate"] = $this->_date->formatDate($publisher["startdate"],CO_DATE_FORMAT);
			$publisher["enddate"] = $this->_date->formatDate($publisher["enddate"],CO_DATE_FORMAT);
			$publisher["realisation"] = $publishersControllingModel->getChart($publisher["id"], "realisation", 0);
			$publisher["management"] = $contactsmodel->getUserListPlain($publisher['management']);
			$publisher["perm"] = $this->getPublisherAccess($publisher["id"]);
			
			switch($publisher["status"]) {
				case "0":
					$publisher["status_text"] = $lang["PUBLISHER_STATUS_PLANNED_TEXT"];
				break;
				case "1":
					$publisher["status_text"] = $lang["PUBLISHER_STATUS_INPROGRESS_TEXT"];
				break;
				case "2":
					$publisher["status_text"] = $lang["PUBLISHER_STATUS_FINISHED_TEXT"];
				break;
				case "3":
					$publisher["status_text"] = $lang["PUBLISHER_STATUS_STOPPED_TEXT"];
				break;
			}
			
			$publishers[] = new Lists($publisher);
	  	}
		
		$access = "guest";
		  if($session->isSysadmin()) {
			  $access = "sysadmin";
		  }
		
		$arr = array("folder" => $folder, "publishers" => $publishers, "access" => $access);
		return $arr;
   }


   /**
   * get details for the publisher folder
   */
   function setFolderDetails($id,$title,$publisherstatus) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_PUBLISHERS_FOLDERS . " set title = '$title', status = '$publisherstatus', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }


   /**
   * create new publisher folder
   */
	function newFolder() {
		global $session, $lang;
		$now = gmdate("Y-m-d H:i:s");
		$title = $lang["PUBLISHER_FOLDER_NEW"];
		
		$q = "INSERT INTO " . CO_TBL_PUBLISHERS_FOLDERS . " set title = '$title', status = '0', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	$id = mysql_insert_id();
			return $id;
		}
	}


   /**
   * delete publisher folder
   */
   function binFolder($id) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_PUBLISHERS_FOLDERS . " set bin = '1', bintime = '$now', binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   
   function restoreFolder($id) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_PUBLISHERS_FOLDERS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deleteFolder($id) {
		$q = "SELECT id FROM " . CO_TBL_PUBLISHERS . " where folder = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$pid = $row["id"];
			$this->deletePublisher($pid);
		}
		
		$q = "DELETE FROM " . CO_TBL_PUBLISHERS_FOLDERS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


  /**
   * get number of publishers for a publisher folder
   * status: 0 = all, 1 = active, 2 = abgeschlossen
   */   
   function getNumPublishers($id, $status="") {
		global $session;
		
		$access = "";
		 if(!$session->isSysadmin()) {
			$access = " and id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
		  }
		
		if($status == "") {
			$q = "select id from " . CO_TBL_PUBLISHERS . " where folder='$id' " . $access . " and bin != '1'";
		} else {
			$q = "select id from " . CO_TBL_PUBLISHERS . " where folder='$id' " . $access . " and status = '$status' and bin != '1'";
		}
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_num_rows($result);
		return $row;
	}


	function getPublisherTitle($id){
		global $session;
		$q = "SELECT title FROM " . CO_TBL_PUBLISHERS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		return $title;
   }


   	function getPublisherTitleFromIDs($array){
		//$string = explode(",", $string);
		$total = sizeof($array);
		$data = '';
		
		if($total == 0) { 
			return $data; 
		}
		
		// check if publisher is available and build array
		$arr = array();
		foreach ($array as &$value) {
			$q = "SELECT id,title FROM " . CO_TBL_PUBLISHERS . " where id = '$value' and bin='0'";
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


   	function getPublisherField($id,$field){
		global $session;
		$q = "SELECT $field FROM " . CO_TBL_PUBLISHERS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		return $title;
   }


  /**
   * get the list of publishers for a publisher folder
   */ 
   function getPublisherList($id,$sort) {
      global $session;
	  
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("publishers-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("publishers-sort-order",$id);
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
				  		$sortorder = $this->getSortOrder("publishers-sort-order",$id);
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
	  $q ="select id,title,status,checked_out,checked_out_user from " . CO_TBL_PUBLISHERS . " where folder='$id' and bin = '0' " . $access . $order;

	  $this->setSortStatus("publishers-sort-status",$sortcur,$id);
      $result = mysql_query($q, $this->_db->connection);
	  $publishers = "";
	  while ($row = mysql_fetch_array($result)) {
		foreach($row as $key => $val) {
			$array[$key] = $val;
			if($key == "id") {
				if($this->getPublisherAccess($val) == "guest") {
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
		if($array["status"] == 2) {
			$itemstatus = " module-item-active";
		}
		if($array["status"] == 3) {
			$itemstatus = " module-item-active-stopped";
		}
		$array["itemstatus"] = $itemstatus;
		
		$checked_out_status = "";
		if($array["access"] != "guest" && $array["checked_out"] == 1 && $array["checked_out_user"] != $session->uid) {
			if($session->checkUserActive($array["checked_out_user"])) {
				$checked_out_status = "icon-checked-out-active";
			} else {
				$this->checkinPublisherOverride($id);
			}
		}
		$array["checked_out_status"] = $checked_out_status;
		
		$publishers[] = new Lists($array);
	  }
	  $arr = array("publishers" => $publishers, "sort" => $sortcur);
	  return $arr;
   }
	
	
	function checkoutPublisher($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_PUBLISHERS . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function checkinPublisher($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_PUBLISHERS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_PUBLISHERS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}
	
	function checkinPublisherOverride($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_PUBLISHERS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	

   function getPublisherDetails($id) {
		global $session, $contactsmodel, $lang;
		$q = "SELECT a.*,(SELECT MAX(enddate) FROM " . CO_TBL_PUBLISHERS_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as enddate FROM " . CO_TBL_PUBLISHERS . " as a where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		// perms
		$array["access"] = $this->getPublisherAccess($id);
		//$canEdit = $this->getEditPerms($session->uid);
	  	/*if(!empty($canEdit)) {
				$array["access"] = "admin";
		}*/
		/*if($array["access"] == "admin") {
			// check if owner
			if($this->isOwnerPerms($id,$session->uid)) {
				$array["access"] = "owner";
			}
		}*/
		if($array["access"] == "guest") {
			// check if this user is admin in some other publisher
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
					$array["canedit"] = $this->checkoutPublisher($id);
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
					$array["checked_out_user_phone1"] = $contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
					$array["checked_out_user_email"] = $contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");
				}
			} else {
				$array["canedit"] = $this->checkoutPublisher($id);
			}
		} // EOF perms
		
		// dates
		$array["startdate"] = $this->_date->formatDate($array["startdate"],CO_DATE_FORMAT);
		$array["enddate"] = $this->_date->formatDate($array["enddate"],CO_DATE_FORMAT);
		$array["ordered_on"] = $this->_date->formatDate($array["ordered_on"],CO_DATE_FORMAT);
		$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
		
		// other functions
		$array["folder"] = $this->getPublisherFolderDetails($array["folder"],"folder");
		$array["management"] = $contactsmodel->getUserList($array['management'],'publishersmanagement', "", $array["canedit"]);
		$array["management_ct"] = empty($array["management_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['management_ct'];
		$array["team"] = $contactsmodel->getUserList($array['team'],'publishersteam', "", $array["canedit"]);
		$array["team_ct"] = empty($array["team_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['team_ct'];
		$array["ordered_by"] = $contactsmodel->getUserList($array['ordered_by'],'publishersordered_by', "", $array["canedit"]);
		$array["ordered_by_ct"] = empty($array["ordered_by_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['ordered_by_ct'];
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		$array["current_user"] = $session->uid;
		
		switch($array["status"]) {
			case "0":
				$array["status_text"] = $lang["PUBLISHER_STATUS_PLANNED"];
				$array["status_date"] = $this->_date->formatDate($array["planned_date"],CO_DATE_FORMAT);
			break;
			case "1":
				$array["status_text"] = $lang["PUBLISHER_STATUS_INPROGRESS"];
				$array["status_date"] = $this->_date->formatDate($array["inprogress_date"],CO_DATE_FORMAT);
			break;
			case "2":
				$array["status_text"] = $lang["PUBLISHER_STATUS_FINISHED"];
				$array["status_date"] = $this->_date->formatDate($array["finished_date"],CO_DATE_FORMAT);
			break;
			case "3":
				$array["status_text"] = $lang["PUBLISHER_STATUS_STOPPED"];
				$array["status_date"] = $this->_date->formatDate($array["stopped_date"],CO_DATE_FORMAT);
			break;
		}
		
		
		
		$publisher = new Lists($array);
		
		$sql="";
		if($array["access"] == "guest") {
			$sql = " and a.access = '1' ";
		}
		
		// get phase details
		$q = "select a.title,a.id,a.access,a.status,(SELECT MIN(startdate) FROM " . CO_TBL_PUBLISHERS_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as startdate,(SELECT MAX(enddate) FROM " . CO_TBL_PUBLISHERS_PHASES_TASKS . " WHERE phaseid=a.id) as enddate from " . CO_TBL_PUBLISHERS_PHASES . " as a where a.pid = '$id' and a.bin != '1' " . $sql . " order by startdate";
		$result = mysql_query($q, $this->_db->connection);
	  	$phases = "";
	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$phase[$key] = $val;
			}
			$phase["startdate"] = $this->_date->formatDate($phase["startdate"],CO_DATE_FORMAT);
			$phase["enddate"] = $this->_date->formatDate($phase["enddate"],CO_DATE_FORMAT);
			$phaseid = $phase["id"];
			// status
			switch($phase["status"]) {
				case "0":
					$phase["status_text"] = $lang["PUBLISHER_STATUS_PLANNED_TEXT"];
				break;
				case "1":
					$phase["status_text"] = $lang["PUBLISHER_STATUS_INPROGRESS_TEXT"];
				break;
				case "2":
					$phase["status_text"] = $lang["PUBLISHER_STATUS_FINISHED_TEXT"];
				break;
			}
			
			$qs = "SELECT COUNT(id) FROM " .  CO_TBL_PUBLISHERS_PHASES_TASKS. " WHERE phaseid='$phaseid' and bin='0'";
		   	$results = mysql_query($qs, $this->_db->connection);
		   	$allTasks = mysql_result($results,0);
			
			$qd = "SELECT COUNT(id) FROM " .  CO_TBL_PUBLISHERS_PHASES_TASKS. " WHERE phaseid='$phaseid' and status = '1' and bin='0'";
		   	$resultd = mysql_query($qd, $this->_db->connection);
		   	$doneTasks = mysql_result($resultd,0);
			
			if($allTasks == 0) {
				$phase["realisation"] = 0;
			} else {
				$phase["realisation"] = round((100/$allTasks)*$doneTasks,2);
			}
			
			$phases[] = new Lists($phase);
	  	}
		// generate phase numbering
		$num = "";
		$qn = "select a.id,(SELECT MIN(startdate) FROM " . CO_TBL_PUBLISHERS_PHASES_TASKS . " WHERE phaseid=a.id and bin='0') as startdate from " . CO_TBL_PUBLISHERS_PHASES . " as a where a.pid = '$id' and a.bin != '1' " . $sql . " order by startdate";
		$resultn = mysql_query($qn, $this->_db->connection);
		$i = 1;
		while ($rown = mysql_fetch_array($resultn)) {
			$num[$rown["id"]] = $i;
			$i++;
		}
		
		$sendto = $this->getSendtoDetails("publishers",$id);
		
		$arr = array("publisher" => $publisher, "phases" => $phases, "num" => $num, "sendto" => $sendto, "access" => $array["access"]);
		return $arr;
   }


   function getDates($id) {
		global $session, $contactsmodel;
		$q = "SELECT a.startdate,(SELECT MAX(enddate) FROM " . CO_TBL_PUBLISHERS_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as enddate FROM " . CO_TBL_PUBLISHERS . " as a where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		// dates
		$array["startdate"] = $this->_date->formatDate($array["startdate"],CO_DATE_FORMAT);
		$array["enddate"] = $this->_date->formatDate($array["enddate"],CO_DATE_FORMAT);

		$publisher = new Lists($array);
		return $publisher;
	}


   // Create publisher folder title
	function getPublisherFolderDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			$q = "SELECT id, title from " . CO_TBL_PUBLISHERS_FOLDERS . " where id = '$value'";
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


   /**
   * get details for the publisher folder
   */
   function setPublisherDetails($id,$title,$startdate,$ordered_by,$ordered_by_ct,$management,$management_ct,$team,$team_ct,$protocol,$folder,$status,$status_date) {
		global $session, $contactsmodel;
		
		$startdate = $this->_date->formatDate($_POST['startdate']);
		$status_date = $this->_date->formatDate($status_date);
		
		// user lists
		$ordered_by = $contactsmodel->sortUserIDsByName($ordered_by);
		$management = $contactsmodel->sortUserIDsByName($management);
		$team = $contactsmodel->sortUserIDsByName($team);
		
		switch($status) {
			case "0":
				$sql = "planned_date";
			break;
			case "1":
				$sql = "inprogress_date";
			break;
			case "2":
				$sql = "finished_date";
				$this->setAllPhasesFinished($id,$status_date);
			break;
			case "3":
				$sql = "stopped_date";
			break;
		}

		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_PUBLISHERS . " set title = '$title', folder = '$folder', startdate = '$startdate', ordered_by = '$ordered_by', ordered_by_ct = '$ordered_by_ct', management = '$management', management_ct = '$management_ct', team='$team', team_ct = '$team_ct', protocol = '$protocol', status = '$status', $sql = '$status_date', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	function setAllPhasesFinished($id,$status_date) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_PUBLISHERS_PHASES . " set status = '2', finished_date = '$status_date', edited_user = '$session->uid', edited_date = '$now' WHERE pid = '$id'";
		$result = mysql_query($q, $this->_db->connection);
	}


	function newPublisher($id) {
		global $session, $contactsmodel, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		$title = $lang["PUBLISHER_NEW"];
		
		$q = "INSERT INTO " . CO_TBL_PUBLISHERS . " set folder = '$id', title = '$title', startdate = '$now', enddate = '$now', status = '0', planned_date = '$now', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			$id = mysql_insert_id();
			// if admin insert him to access
			if(!$session->isSysadmin()) {
				$publishersAccessModel = new PublishersAccessModel();
				$publishersAccessModel->setDetails($id,$session->uid,"");
			}
			return $id;
		}
	}
	
	
	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		// publisher
		$q = "INSERT INTO " . CO_TBL_PUBLISHERS . " (folder,title,startdate,ordered_by,management,team,protocol,status,planned_date,emailed_to,created_date,created_user,edited_date,edited_user) SELECT folder,CONCAT(title,' ".$lang["GLOBAL_DUPLICAT"]."'),startdate,ordered_by,management,team,protocol,'0','$now',emailed_to,'$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_PUBLISHERS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		
		if(!$session->isSysadmin()) {
				$publishersAccessModel = new PublishersAccessModel();
				$publishersAccessModel->setDetails($id_new,$session->uid,"");
			}
		
		// phases
		$q = "SELECT id,title,protocol,team,management FROM " . CO_TBL_PUBLISHERS_PHASES . " WHERE pid = '$id' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$phaseid = $row["id"];
			$title = mysql_real_escape_string($row["title"]);
			$protocol = mysql_real_escape_string($row["protocol"]);
			$team = $row["team"];
			$management = $row["management"];
			
			$qp = "INSERT INTO " . CO_TBL_PUBLISHERS_PHASES . " set pid='$id_new',title='$title',protocol='$protocol',team='$team',management='$management',created_date='$now',created_user='$session->uid',edited_date='$now',edited_user='$session->uid'";
			$rp = mysql_query($qp, $this->_db->connection);
			$id_p_new = mysql_insert_id();
			// tasks
			$qt = "SELECT id,dependent,cat,text,protocol,startdate,enddate FROM " . CO_TBL_PUBLISHERS_PHASES_TASKS . " where phaseid='$phaseid' and bin='0' ORDER BY id ASC";		
			$resultt = mysql_query($qt, $this->_db->connection);
			while($rowt = mysql_fetch_array($resultt)) {
				$id = $rowt["id"];
				$cat = $rowt["cat"];
				$text = mysql_real_escape_string($rowt["text"]);
				$protocol = mysql_real_escape_string($rowt["protocol"]);
				$startdate = $rowt["startdate"];
				$enddate = $rowt["enddate"];
				$dependent = $rowt["dependent"];
				$qtn = "INSERT INTO " . CO_TBL_PUBLISHERS_PHASES_TASKS . " set pid = '$id_new', phaseid = '$id_p_new', dependent = '$dependent', cat = '$cat',status = '0',text = '$text',protocol = '$protocol', startdate = '$startdate',enddate = '$enddate'";
				$rpn = mysql_query($qtn, $this->_db->connection);
				$id_t_new = mysql_insert_id();
				// BUILD OLD NEW TASK ID ARRAY
				$t[$id] = $id_t_new;
			}
			
		}
		// Updates Dependencies for new tasks
			$qt = "SELECT id,dependent FROM " . CO_TBL_PUBLISHERS_PHASES_TASKS . " where pid='$id_new' and bin='0' ORDER BY id ASC";		
			$resultt = mysql_query($qt, $this->_db->connection);
			while($rowtt = mysql_fetch_array($resultt)) {
				$id = $rowtt["id"];
				$dep = 0;
				$dependent = "";
				if($rowtt["dependent"] != 0) {
					$dependent = $rowtt["dependent"];
					//if(in_array($dependent,$t)) {
					$dep = $t[$dependent];
					//}
				}
				$qtn = "UPDATE " . CO_TBL_PUBLISHERS_PHASES_TASKS . " set dependent = '$dep' WHERE id='$id'";
				$rpn = mysql_query($qtn, $this->_db->connection);
			}
		
		if ($result) {
			return $id_new;
		}
	}


	function binPublisher($id) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_PUBLISHERS . " set bin = '1', bintime = '$now', binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	function restorePublisher($id) {
		$q = "UPDATE " . CO_TBL_PUBLISHERS . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	function deletePublisher($id) {
		global $publishers;
		
		$active_modules = array();
		foreach($publishers->modules as $module => $value) {
			if(CONSTANT('publishers_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
			}
		}
		
		if(in_array("vdocs",$active_modules)) {
			$vdocsmodel = new VDocsModel();
			$q = "SELECT id FROM co_publishers_vdocs where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$vid = $row["id"];
				$vdocsmodel->deleteVDoc($vid);
			}
		}
		
		if(in_array("phonecalls",$active_modules)) {
			$publishersPhonecallsModel = new PublishersPhonecallsModel();
			$q = "SELECT id FROM co_publishers_phonecalls where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$pcid = $row["id"];
				$publishersPhonecallsModel->deletePhonecall($pcid);
			}
		}
		
		if(in_array("documents",$active_modules)) {
			$publishersDocumentsModel = new PublishersDocumentsModel();
			$q = "SELECT id FROM co_publishers_documents_folders where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$did = $row["id"];
				$publishersDocumentsModel->deleteDocument($did);
			}
		}
		
		if(in_array("meetings",$active_modules)) {
			$publishersMeetingsModel = new PublishersMeetingsModel();
			$q = "SELECT id FROM co_publishers_meetings where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$mid = $row["id"];
				$publishersMeetingsModel->deleteMeeting($mid);
			}
		}
		
		if(in_array("phases",$active_modules)) {
			$publishersPhasesModel = new PublishersPhasesModel();
			$q = "SELECT id FROM co_publishers_phases where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$pid = $row["id"];
				$publishersPhasesModel->deletePhase($pid);
			}
		}
		
		$q = "DELETE FROM co_log_sendto WHERE what='publishers' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM co_publishers_access WHERE pid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_PUBLISHERS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
		  	return true;
		}
		
	}


   function movePublisher($id,$startdate,$movedays) {
		global $session, $contactsmodel;
		
		$startdate = $this->_date->formatDate($_POST['startdate']);
		
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_PUBLISHERS . " set startdate = '$startdate', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
			$qt = "SELECT id, startdate, enddate FROM " . CO_TBL_PUBLISHERS_PHASES_TASKS . " where pid='$id'";
			$resultt = mysql_query($qt, $this->_db->connection);
			while ($rowt = mysql_fetch_array($resultt)) {
				$tid = $rowt["id"];
				$startdate = $this->_date->addDays($rowt["startdate"],$movedays);
				$enddate = $this->_date->addDays($rowt["enddate"],$movedays);
				$qtk = "UPDATE " . CO_TBL_PUBLISHERS_PHASES_TASKS . " set startdate = '$startdate', enddate = '$enddate' where id='$tid'";
				$retvaltk = mysql_query($qtk, $this->_db->connection);
			}
		if ($result) {
			return true;
		}
	}


	function getPublisherFolderDialog($field,$title) {
		global $session;
		$str = '<div class="dialog-text">';
		//$q ="select id, title from " . CO_TBL_PUBLISHERS_FOLDERS . " where status='0' and bin = '0' ORDER BY title";
		if(!$session->isSysadmin()) {
			$q ="select a.id, a.title from " . CO_TBL_PUBLISHERS_FOLDERS . " as a where a.status='0' and a.bin = '0' and (SELECT count(*) FROM co_publishers_access as b, co_publishers as c WHERE (b.admins REGEXP '[[:<:]]" . $session->uid . "[[:>:]]' or b.guests REGEXP '[[:<:]]" . $session->uid . "[[:>:]]') and c.folder=a.id and b.pid=c.id) > 0 ORDER BY title";
		} else {
			$q ="select id, title from " . CO_TBL_PUBLISHERS_FOLDERS . " where status='0' and bin = '0' ORDER BY title";
		}
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$str .= '<a href="#" class="insertPublisherFolderfromDialog" title="' . $row["title"] . '" field="'.$field.'" gid="'.$row["id"].'">' . $row["title"] . '</a>';
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
	   $q = "SELECT COUNT(id) FROM " .  CO_TBL_PUBLISHERS_PHASES. " WHERE pid='$id' $sql and bin='0'";
	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function numPhasesOnTime($id) {
	   //$q = "SELECT COUNT(id) FROM " .  CO_TBL_PUBLISHERS_PHASES. " WHERE pid='$id' $sql and bin='0'";
	   $q = "SELECT a.id,(SELECT MAX(enddate) FROM " . CO_TBL_PUBLISHERS_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as enddate FROM " . CO_TBL_PUBLISHERS_PHASES . " as a where a.pid= '$id' and a.status='2' and a.finished_date <= enddate";

	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function numPhasesTasks($id,$status = 0,$sql="") {
	   //$sql = "";
	   if ($status == 1) {
		   $sql .= " and status='1' ";
	   }
	   $q = "SELECT COUNT(id) FROM " .  CO_TBL_PUBLISHERS_PHASES_TASKS. " WHERE pid='$id' $sql and bin='0'";
	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function getRest($value) {
		return round(100-$value,2);
   }


	function getChartFolder($id, $what) { 
		global $publishersControllingModel, $lang;
		switch($what) {
			case 'stability':
				$chart = $this->getChartFolder($id, 'timeing');
				$timeing = $chart["real"];
				
				$chart = $this->getChartFolder($id, 'tasks');
				$tasks = $chart["real"];
				
				$chart["real"] = round(($timeing+$tasks)/2,0);
				$chart["title"] = $lang["PUBLISHER_FOLDER_CHART_STABILITY"];
				$chart["img_name"] = $id . "_stability.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?chs=150x90&cht=gm&chd=t:' . $chart["real"];
				
				$chart["tendency"] = "tendency_negative.png";
				if($chart["real"] >= 50) {
					$chart["tendency"] = "tendency_positive.png";
				}
				
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				
			break;
			case 'realisation':
				$realisation = 0;
				$id_array = "";
				
				$q = "SELECT id FROM " . CO_TBL_PUBLISHERS. " WHERE folder = '$id' and status != '0' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$num = mysql_num_rows($result);
				$i = 1;
				while($row = mysql_fetch_assoc($result)) {
					$pid = $row["id"];
					$calc = $publishersControllingModel->getChart($pid,'realisation',0);
					$realisation += $calc["real"];

					if($i == 1) {
						$id_array .= " and (pid='".$pid."'";
					} else {
						$id_array .= " or pid='".$pid."'";
					}
					if($i == $num) {
						$id_array .= ")";
					}
					//$id_array .= " and pid='".$pid."'";
					$i++;
				}
				if($num == 0) {
					$chart["real"] = 0;
				} else {
					$chart["real"] = round(($realisation)/$num,0);
				}
				$chart["tendency"] = "tendency_negative.png";
				$qt = "SELECT MAX(donedate) as dt,enddate FROM " . CO_TBL_PUBLISHERS_PHASES_TASKS. " WHERE status='1' $id_array and bin='0'";
				$resultt = mysql_query($qt, $this->_db->connection);
				$ten = mysql_fetch_assoc($resultt);
				if($ten["dt"] <= $ten["enddate"]) {
					$chart["tendency"] = "tendency_positive.png";
				}
				
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = $lang["PUBLISHER_FOLDER_CHART_REALISATION"];
				$chart["img_name"] = $id . "_realisation.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
				
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
			break;
			

			case 'timeing':
				$realisation = 0;
				$id_array = "";
				
				$q = "SELECT id FROM " . CO_TBL_PUBLISHERS. " WHERE folder = '$id' and status != '0' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$num = mysql_num_rows($result);
				$i = 1;
				while($row = mysql_fetch_assoc($result)) {
					$pid = $row["id"];
					$calc = $publishersControllingModel->getChart($pid,'timeing',0);
					$realisation += $calc["real"];

					if($i == 1) {
						$id_array .= " and (pid='".$pid."'";
					} else {
						$id_array .= " or pid='".$pid."'";
					}
					if($i == $num) {
						$id_array .= ")";
					}
					//$id_array .= " and pid='".$pid."'";
					$i++;
				}
					
				if($num == 0) {
					$chart["real"] = 0;
				} else {
					$chart["real"] = round(($realisation)/$num,0);
				}
				
				$today = date("Y-m-d");
				
				$chart["tendency"] = "tendency_positive.png";
				$qt = "SELECT COUNT(id) FROM " . CO_TBL_PUBLISHERS_PHASES_TASKS. " WHERE status='0' and startdate <= '$today' and enddate >= '$today' $id_array and bin='0'";
				$resultt = mysql_query($qt, $this->_db->connection);
				$tasks_active = mysql_result($resultt,0);
				
				$qo = "SELECT COUNT(id) FROM " . CO_TBL_PUBLISHERS_PHASES_TASKS. " WHERE status='0' and enddate < '$today' $id_array and bin='0'";
				$resulto = mysql_query($qo, $this->_db->connection);
				$tasks_overdue = mysql_result($resulto,0);
				if($tasks_active + $tasks_overdue == 0) {
					$tendency = 0;
				} else {
					$tendency = round((100/($tasks_active + $tasks_overdue)) * $tasks_overdue,2);
				}
				
				if($tendency > 10) {
					$chart["tendency"] = "tendency_negative.png";
				}
				
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = $lang["PUBLISHER_FOLDER_CHART_ADHERANCE"];
				$chart["img_name"] = $id . "_timeing.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
			
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
			break;
			
			case 'tasks':
				$realisation = 0;
				$id_array = "";
				
				$q = "SELECT id FROM " . CO_TBL_PUBLISHERS. " WHERE folder = '$id' and status != '0' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$num = mysql_num_rows($result);
				$i = 1;
				while($row = mysql_fetch_assoc($result)) {
					$pid = $row["id"];
					$calc = $publishersControllingModel->getChart($pid,'tasks',0);
					$realisation += $calc["real"];

					if($i == 1) {
						$id_array .= " and (pid='".$pid."'";
					} else {
						$id_array .= " or pid='".$pid."'";
					}
					if($i == $num) {
						$id_array .= ")";
					}
					$i++;
				}
				if($num == 0) {
					$chart["real"] = 0;
				} else {
					$chart["real"] = round(($realisation)/$num,0);
				}
				
				$today = date("Y-m-d");
				
				$chart["tendency"] = "tendency_positive.png";
				$qt = "SELECT status,donedate,enddate FROM " . CO_TBL_PUBLISHERS_PHASES_TASKS. " WHERE enddate < '$today' $id_array and bin='0' ORDER BY enddate DESC LIMIT 0,1";
				$resultt = mysql_query($qt, $this->_db->connection);
				$rowt = mysql_fetch_assoc($resultt);
				if(mysql_num_rows($resultt) != 0) {
					$status = $rowt["status"];
					$enddate = $rowt["enddate"];
					$donedate = $rowt["donedate"];
					if($status == "1" && $donedate > $enddate) {
						$chart["tendency"] = "tendency_negative.png";
					}
					if($status == "0") {
						$chart["tendency"] = "tendency_negative.png";
					}
				}
				
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = $lang["PUBLISHER_FOLDER_CHART_TASKS"];
				$chart["img_name"] = $id . "_tasks.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
			
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				
			break;
			case 'status':

				// all
				$q = "SELECT id FROM " . CO_TBL_PUBLISHERS. " WHERE folder = '$id' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$all = mysql_num_rows($result);
				
				// planned
				$q = "SELECT id FROM " . CO_TBL_PUBLISHERS. " WHERE folder = '$id' and status = '0' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$planned = mysql_num_rows($result);
				$chart["planned"] = 0;
				if($planned != 0) {
					$chart["planned"] = round((100/$all)*$planned,0);
				}
				
				// inprogress
				$q = "SELECT id FROM " . CO_TBL_PUBLISHERS. " WHERE folder = '$id' and status = '1' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$inprogress = mysql_num_rows($result);
				$chart["inprogress"] = 0;
				if($inprogress != 0) {
					$chart["inprogress"] = round((100/$all)*$inprogress,0);
				}
				// finished
				$q = "SELECT id FROM " . CO_TBL_PUBLISHERS. " WHERE folder = '$id' and status = '2' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$finished = mysql_num_rows($result);
				$chart["finished"] = 0;
				if($finished != 0) {
					$chart["finished"] = round((100/$all)*$finished,0);
				}
				
				// stopped
				$q = "SELECT id FROM " . CO_TBL_PUBLISHERS. " WHERE folder = '$id' and status = '3' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$stopped = mysql_num_rows($result);
				$chart["stopped"] = 0;
				if($stopped != 0) {
					$chart["stopped"] = round((100/$all)*$stopped,0);
				}				

				$chart["title"] = $lang["PUBLISHER_FOLDER_CHART_STATUS"];
				$chart["img_name"] = 'publishers_' . $id . "_status.png";
				if($all == 0) {
					$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:0,100&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
				} else {
					$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["planned"]. ',' .$chart["inprogress"] . ',' .$chart["finished"] . ',' .$chart["stopped"] . '&chs=150x90&chco=4BA0C8|FFD20A|82AA0B|7F7F7F&chf=bg,s,FFFFFF';
				}
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
			break;
		}
		
		return $chart;
   }


   function getBin() {
		global $publishers;
		
		$bin = array();
		$bin["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		$arr = array();
		$arr["bin"] = $bin;
		
		$active_modules = array();
		foreach($publishers->modules as $module => $value) {
			if(CONSTANT('publishers_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
			}
		}
		
		// menues
		if(in_array("menues",$active_modules)) {
			$qpc ="select id, title, bin, bintime, binuser from " . CO_TBL_PUBLISHERS_MENUES . " where bin = '1'";
			$resultpc = mysql_query($qpc, $this->_db->connection);
			while ($rowpc = mysql_fetch_array($resultpc)) {
				$idp = $rowpc["id"];
					foreach($rowpc as $key => $val) {
						$menue[$key] = $val;
					}
					$menue["bintime"] = $this->_date->formatDate($menue["bintime"],CO_DATETIME_FORMAT);
					$menue["binuser"] = $this->_users->getUserFullname($menue["binuser"]);
					$menues[] = new Lists($menue);
					$arr["menues"] = $menues;
			}
		}

		return $arr;
   }
   
   
   function emptyBin() {
		global $publishers;
		
		$bin = array();
		$bin["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		$arr = array();
		$arr["bin"] = $bin;
		
		$active_modules = array();
		foreach($publishers->modules as $module => $value) {
			if(CONSTANT('publishers_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
			}
		}
		
		// menues
		if(in_array("menues",$active_modules)) {
			$publishersMenuesModel = new PublishersMenuesModel();
			$q ="select id from " . CO_TBL_PUBLISHERS_MENUES . " where bin = '1'";
			$result = mysql_query($q, $this->_db->connection);
			while ($row = mysql_fetch_array($result)) {
				$id = $row["id"];
				$publishersMenuesModel->deleteMenue($id);
				$arr["menues"] = "";
			}
		}

		return $arr;
   }


	// User Access
	function getEditPerms($id) {
		global $session;
		$perms = array();
		$q = "SELECT * FROM co_publishers_access where admins REGEXP '[[:<:]]" . $id . "[[:>:]]'";
      	$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$perms[] = true;
		}
		return $perms;
   }


   function getViewPerms($id) {
		global $session;
		$perms = array();
		$q = "SELECT * FROM co_publishers_access where guests REGEXP '[[:<:]]" . $id. "[[:>:]]'";
      	$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$perms[] = true;
		}
		return $perms;
   }


   function canAccess($id) {
	   global $session;
	   return array_merge($this->getViewPerms($id),$this->getEditPerms($id));
   }


   function getPublisherAccess() {
		global $session;
		$access = "";
		if($this->getViewPerms($session->uid)) {
			$access = "guest";
		}
		if($this->getEditPerms($session->uid)) {
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
   
   
   /*function isOwnerPerms($id,$uid) {
	   	$q = "SELECT id FROM co_publishers where id = '$id' and created_user ='$uid'";
      	$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			return true;
		} else {
			return false;
		}
   }*/
   
   /*function isPublisherOwner($uid) {
	   	$q = "SELECT id FROM co_publishers where created_user = '$uid'";
      	$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			return true;
		} else {
			return false;
		}
   }*/
   

}

$publishersmodel = new PublishersModel(); // needed for direct calls to functions eg echo $publishersmodel ->getPublisherTitle(1);
?>
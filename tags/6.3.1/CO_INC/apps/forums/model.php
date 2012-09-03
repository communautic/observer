<?php
class ForumsModel extends Model {
	
	// Get all Forum Folders
   function getFolderList($sort) {
      global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("forums-folder-sort-status");
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
				  		$sortorder = $this->getSortOrder("forums-folder-sort-order");
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
				  		$sortorder = $this->getSortOrder("forums-folder-sort-order");
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
			$q ="select a.id, a.title from " . CO_TBL_FORUMS_FOLDERS . " as a where a.status='0' and a.bin = '0' and (SELECT count(*) FROM co_forums_access as b, co_forums as c WHERE (b.admins REGEXP '[[:<:]]" . $session->uid . "[[:>:]]' or b.guests REGEXP '[[:<:]]" . $session->uid . "[[:>:]]') and c.folder=a.id and b.pid=c.id) > 0 " . $order;
		} else {
			$q ="select a.id, a.title from " . CO_TBL_FORUMS_FOLDERS . " as a where a.status='0' and a.bin = '0' " . $order;
		}
		
	  $this->setSortStatus("forums-folder-sort-status",$sortcur);
      $result = mysql_query($q, $this->_db->connection);
	  $folders = "";
	  while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
				if($key == "id") {
				$array["numForums"] = $this->getNumForums($val);
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
   * get details for the forum folder
   */
   function getFolderDetails($id) {
		global $session, $contactsmodel, $forumsControllingModel, $lang;
		$q = "SELECT * FROM " . CO_TBL_FORUMS_FOLDERS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_assoc($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		/*$array["allforums"] = $this->getNumForums($id);
		$array["plannedforums"] = $this->getNumForums($id, $status="0");
		$array["activeforums"] = $this->getNumForums($id, $status="1");
		$array["inactiveforums"] = $this->getNumForums($id, $status="2");
		$array["stoppedforums"] = $this->getNumForums($id, $status="3");*/
		
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
		
		// get forum details
		$access="";
		if(!$session->isSysadmin()) {
			$access = " and id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
	  	}
		
		 $sortstatus = $this->getSortStatus("forums-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("forums-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by title";
						  } else {
							$order = "order by field(id,$sortorder)";
						  }
				  break;	
			  }
		  }
		
		
		//$q = "SELECT a.title,a.id,a.management,a.status, (SELECT MIN(startdate) FROM " . CO_TBL_FORUMS_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as startdate ,(SELECT MAX(enddate) FROM " . CO_TBL_FORUMS_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as enddate FROM " . CO_TBL_FORUMS . " as a where a.folder='$id' and a.bin='0'" . $access . " " . $order;
		$q = "SELECT * FROM " . CO_TBL_FORUMS . " where folder='$id' and bin='0'" . $access . " " . $order;
		$result = mysql_query($q, $this->_db->connection);
	  	$forums = "";
	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$forum[$key] = $val;
			}
			/*$forum["startdate"] = $this->_date->formatDate($forum["startdate"],CO_DATE_FORMAT);
			$forum["enddate"] = $this->_date->formatDate($forum["enddate"],CO_DATE_FORMAT);
			$forum["realisation"] = $forumsControllingModel->getChart($forum["id"], "realisation", 0);
			$forum["management"] = $contactsmodel->getUserListPlain($forum['management']);
			$forum["perm"] = $this->getForumAccess($forum["id"]);*/
			
			$forum["created_user"] = $contactsmodel->getUserListPlain($forum['created_user']);
			
			switch($forum["status"]) {
			case "0":
				$forum["status_text"] = $lang["GLOBAL_STATUS_PLANNED"];
				$forum["status_text_time"] = $lang["GLOBAL_STATUS_PLANNED_TIME"];
				$forum["status_date"] = $this->_date->formatDate($forum["planned_date"],CO_DATE_FORMAT);
			break;
			case "1":
				$forum["status_text"] = $lang["GLOBAL_STATUS_DISCUSSION"];
				$forum["status_text_time"] = $lang["GLOBAL_STATUS_DISCUSSION_TIME"];
				$forum["status_date"] = $this->_date->formatDate($forum["inprogress_date"],CO_DATE_FORMAT);
			break;
			case "2":
				$forum["status_text"] = $lang["GLOBAL_STATUS_FINISHED"];
				$forum["status_text_time"] = $lang["GLOBAL_STATUS_FINISHED_TIME"];
				$forum["status_date"] = $this->_date->formatDate($forum["finished_date"],CO_DATE_FORMAT);
			break;
			case "3":
				$forum["status_text"] = $lang["GLOBAL_STATUS_STOPPED"];
				$forum["status_text_time"] = $lang["GLOBAL_STATUS_STOPPED_TIME"];
				$forum["status_date"] = $this->_date->formatDate($forum["stopped_date"],CO_DATE_FORMAT);
			break;
		}
			
			
			
			$forums[] = new Lists($forum);
	  	}
		
		$access = "guest";
		  if($session->isSysadmin()) {
			  $access = "sysadmin";
		  }
		
		$arr = array("folder" => $folder, "forums" => $forums, "access" => $access);
		return $arr;
   }


   /**
   * get details for the forum folder
   */
   function setFolderDetails($id,$title,$forumstatus) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_FORUMS_FOLDERS . " set title = '$title', status = '$forumstatus', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }


   /**
   * create new forum folder
   */
	function newFolder() {
		global $session, $lang;
		$now = gmdate("Y-m-d H:i:s");
		$title = $lang["FORUM_FOLDER_NEW"];
		
		$q = "INSERT INTO " . CO_TBL_FORUMS_FOLDERS . " set title = '$title', status = '0', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	$id = mysql_insert_id();
			return $id;
		}
	}


   /**
   * delete forum folder
   */
   function binFolder($id) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_FORUMS_FOLDERS . " set bin = '1', bintime = '$now', binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   
   function restoreFolder($id) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_FORUMS_FOLDERS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deleteFolder($id) {
		$q = "SELECT id FROM " . CO_TBL_FORUMS . " where folder = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$pid = $row["id"];
			$this->deleteForum($pid);
		}
		
		$q = "DELETE FROM " . CO_TBL_FORUMS_FOLDERS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


  /**
   * get number of forums for a forum folder
   * status: 0 = all, 1 = active, 2 = abgeschlossen
   */   
   function getNumForums($id, $status="") {
		global $session;
		
		$access = "";
		 if(!$session->isSysadmin()) {
			$access = " and id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
		  }
		
		if($status == "") {
			$q = "select id from " . CO_TBL_FORUMS . " where folder='$id' " . $access . " and bin != '1'";
		} else {
			$q = "select id from " . CO_TBL_FORUMS . " where folder='$id' " . $access . " and status = '$status' and bin != '1'";
		}
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_num_rows($result);
		return $row;
	}


	function getForumTitle($id){
		global $session;
		$q = "SELECT title FROM " . CO_TBL_FORUMS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		return $title;
   }


   	function getForumTitleFromIDs($array){
		//$string = explode(",", $string);
		$total = sizeof($array);
		$data = '';
		
		if($total == 0) { 
			return $data; 
		}
		
		// check if forum is available and build array
		$arr = array();
		foreach ($array as &$value) {
			$q = "SELECT id,title FROM " . CO_TBL_FORUMS . " where id = '$value' and bin='0'";
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


	function getForumTitleLinkFromIDs($array,$target){
		$total = sizeof($array);
		$data = '';
		if($total == 0) { 
			return $data; 
		}
		$arr = array();
		$i = 0;
		foreach ($array as &$value) {
			$q = "SELECT id,folder,title FROM " . CO_TBL_FORUMS . " where id = '$value' and bin='0'";
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
			$data .= '<a class="externalLoadThreeLevels" rel="' . $target. ','.$value["folder"].','.$value["id"].',1,forums">' . $value["title"] . '</a>';
			if($i < $arr_total) {
				$data .= '<br />';
			}
			$data .= '';	
			$i++;
		}
		return $data;
   }


   	function getForumField($id,$field){
		global $session;
		$q = "SELECT $field FROM " . CO_TBL_FORUMS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		return $title;
   }


  /**
   * get the list of forums for a forum folder
   */ 
   function getForumList($id,$sort) {
      global $session;
	  
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("forums-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("forums-sort-order",$id);
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
				  		$sortorder = $this->getSortOrder("forums-sort-order",$id);
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
	  //$q ="select id,title,status,checked_out,checked_out_user from " . CO_TBL_FORUMS . " where folder='$id' and bin = '0' " . $access . $order;
	  $q = "select a.title,a.id,a.access,a.status from " . CO_TBL_FORUMS . " as a where a.folder = '$id' and a.bin != '1' " . $access . $order;

	  $this->setSortStatus("forums-sort-status",$sortcur,$id);
      $result = mysql_query($q, $this->_db->connection);
	  $forums = "";
	  while ($row = mysql_fetch_array($result)) {
		foreach($row as $key => $val) {
			$array[$key] = $val;
			if($key == "id") {
				if($this->getForumAccess($val) == "guest") {
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
		
		/*$checked_out_status = "";
		if($array["access"] != "guest" && $array["checked_out"] == 1 && $array["checked_out_user"] != $session->uid) {
			if($session->checkUserActive($array["checked_out_user"])) {
				$checked_out_status = "icon-checked-out-active";
			} else {
				$this->checkinForumOverride($id);
			}
		}
		$array["checked_out_status"] = $checked_out_status;*/
		
		$forums[] = new Lists($array);
	  }
	  $arr = array("forums" => $forums, "sort" => $sortcur);
	  return $arr;
   }
	
	
	function checkoutForum($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_FORUMS . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function checkinForum($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_FORUMS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_FORUMS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}
	
	function checkinForumOverride($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_FORUMS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	

   function getForumDetails($id) {
		global $session, $contactsmodel, $lang;
		//$q = "SELECT a.*,(SELECT MAX(enddate) FROM " . CO_TBL_FORUMS_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as enddate FROM " . CO_TBL_FORUMS . " as a where id = '$id'";
		
		//$this->_documents = new ForumsDocumentsModel();
		
		$q = "SELECT * FROM " . CO_TBL_FORUMS . " where id = '$id'";
		
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		// perms
		$array["access"] = $this->getForumAccess($id);
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
		$array["canedit"] = false;
		if($array["access"] == "guest") {
			// check if this user is admin in some other forum
			$canEdit = $this->getEditPerms($session->uid);
			
			if(!empty($canEdit)) {
					$array["access"] = "guestadmin";
			}
		} else {
		$array["canedit"] = true;
		}
		//$array["showCheckout"] = false;
		//$array["checked_out_user_text"] = $contactsmodel->getUserListPlain($array['checked_out_user']);

		/*if($array["access"] == "sysadmin" || $array["access"] == "admin") {
			if($array["checked_out"] == 1) {
				if($array["checked_out_user"] == $session->uid) {
					$array["canedit"] = true;
				} else if(!$session->checkUserActive($array["checked_out_user"])) {
					$array["canedit"] = $this->checkoutForum($id);
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
					$array["checked_out_user_phone1"] = $contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
					$array["checked_out_user_email"] = $contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");
				}
			} else {
				$array["canedit"] = $this->checkoutForum($id);
			}
		}*/ // EOF perms
		
		$array["folder"] = $this->getForumFolderDetails($array["folder"],"folder");
		// dates
		$today = date("Y-m-d");

		$array["today"] = $this->_date->formatDate("now",CO_DATE_FORMAT);
		$array["planned_date"] = $this->_date->formatDate($array["planned_date"],CO_DATE_FORMAT);
		$array["inprogress_date"] = $this->_date->formatDate($array["inprogress_date"],CO_DATE_FORMAT);
		$array["finished_date"] = $this->_date->formatDate($array["finished_date"],CO_DATE_FORMAT);
		$array["stopped_date"] = $this->_date->formatDate($array["stopped_date"],CO_DATE_FORMAT);

		$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);

		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		$array["current_user"] = $session->uid;
		
		// status
		$array["status_planned_active"] = "";
		$array["status_inprogress_active"] = "";
		$array["status_finished_active"] = "";
		$array["status_stopped_active"] = "";
		$array["startdate"] = "";
		$array["enddate"] = "";
		switch($array["status"]) {
			case "0":
				$array["status_text"] = $lang["GLOBAL_STATUS_PLANNED"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_PLANNED_TIME"];
				$array["status_planned_active"] = " active";
				$array["status_date"] = $array["planned_date"];
				$array["startdate"] = $array["planned_date"];
				//$array["enddate"] = $this->_date->formatDate($today,CO_DATE_FORMAT);
			break;
			case "1":
				$array["status_text"] = $lang["GLOBAL_STATUS_DISCUSSION"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_DISCUSSION_TIME"];
				$array["status_inprogress_active"] = " active";
				$array["status_date"] = $array["inprogress_date"];
				$array["startdate"] = $array["inprogress_date"];
				//$array["enddate"] = $this->_date->formatDate($today,CO_DATE_FORMAT);
			break;
			case "2":
				$array["status_text"] = $lang["GLOBAL_STATUS_FINISHED"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_FINISHED_TIME"];
				$array["status_finished_active"] = " active";
				$array["status_date"] = $array["finished_date"];
				if($array["inprogress_date"] == '') {
					$array["startdate"] = $array["planned_date"];
				} else {
					$array["startdate"] = $array["inprogress_date"];
				}
				$array["enddate"] = $array["finished_date"];
			break;
			case "3":
				$array["status_text"] = $lang["GLOBAL_STATUS_STOPPED"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_STOPPED_TIME"];
				$array["status_stopped_active"] = " active";
				$array["status_date"] = $array["stopped_date"];
				if($array["inprogress_date"] == '') {
					$array["startdate"] = $array["planned_date"];
				} else {
					$array["startdate"] = $array["inprogress_date"];
				}
				$array["enddate"] = $array["stopped_date"];
			break;
		}
		
		
		
		$forum = new Lists($array);
		
		$sql="";
		if($array["access"] == "guest") {
			$sql = " and a.access = '1' ";
		}
		
// get the posts
		$post= array();
		$answer= array();
		/*
		LINEAR
		if($view == 0) {
			$qt = "SELECT * FROM " . CO_TBL_BRAINSTORMS_FORUMS_POSTS . " where pid = '$id' and bin='0' ORDER BY id";
			$resultt = mysql_query($qt, $this->_db->connection);
			$num = 1;
			while($rowt = mysql_fetch_array($resultt)) {
				foreach($rowt as $key => $val) {
					$posts[$key] = $val;
					
				}
				
				$posts["user"] = $this->_users->getUserFullname($posts["user"]);
				$posts["datetime"] = $this->_date->formatDate($posts["datetime"],CO_DATETIME_FORMAT);
				
				if($posts["status"] == 1) {
					$answer[] = new Lists($posts);
				}
				
				$posts["num"] = $num;
				
				$post[] = new Lists($posts);
				
				$num++;
			}
		} */
			$qt = "SELECT * FROM " . CO_TBL_FORUMS_POSTS . " where pid = '$id' and bin='0' ORDER BY id";
			$resultt = mysql_query($qt, $this->_db->connection);
			$num = 1;
			while($rowt = mysql_fetch_array($resultt)) {
				foreach($rowt as $key => $val) {
					$posts[$key] = $val;
					if ($key == "id") {
						$postid = $val;
					}
				}
				
				$posts["avatar"] = $this->_users->getAvatar($posts["user"]);
				$posts["user"] = $this->_users->getUserFullname($posts["user"]);
				
				$posts["datetime"] = $this->_date->formatDate($posts["datetime"],CO_DATETIME_FORMAT);
				$posts["children"] = array();
				
				if($posts["status"] == 1) {
					$answer[] = new Lists($posts);
				}
				$posts["num"] = $num;
				$post[$postid] = new Lists($posts);
				
				$num++;
			}
			foreach ($post as $p) {
				if($p->replyid != 0) {
					if(array_key_exists($p->replyid,$post)) {
						$post[$p->replyid]->children[] = $post[$p->id];
					} else {
						$p->replyid =0;
					}
				}
			}
			
			$post = array_filter($post, create_function('$p', 'return !$p->replyid;'));

		//$sendto = $this->getSendtoDetails("brainstorms_forums",$id);
		
		$arr = array("forum" => $forum, "posts" => $post, "answers" => $answer, "access" => $array["access"]);
		
		//$sendto = $this->getSendtoDetails("forums",$id);
		
		//$arr = array("forum" => $forum, "phases" => $phases, "num" => $num, "sendto" => $sendto, "access" => $array["access"]);
		return $arr;
   }


   function getDates($id) {
		global $session, $contactsmodel;
		$q = "SELECT a.startdate,(SELECT MAX(enddate) FROM " . CO_TBL_FORUMS_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as enddate FROM " . CO_TBL_FORUMS . " as a where id = '$id'";
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

		$forum = new Lists($array);
		return $forum;
	}


   // Create forum folder title
	function getForumFolderDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			$q = "SELECT id, title from " . CO_TBL_FORUMS_FOLDERS . " where id = '$value'";
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
   * get details for the forum folder
   */
   function setForumDetails($id,$folder,$title,$protocol) {
		global $session, $contactsmodel;
		
		/*$status_date = $this->_date->formatDate($status_date);
		
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
		}*/
		
		$now = gmdate("Y-m-d H:i:s");
		
		//$q = "UPDATE " . CO_TBL_BRAINSTORMS_FORUMS . " set title = '$title', protocol = '$protocol', documents = '$documents', $accesssql status = '$forum_status', $sql = '$forum_status_date', edited_user = '$session->uid', edited_date = '$now' where id='$id'";

		
		$q = "UPDATE " . CO_TBL_FORUMS . " set title = '$title', folder = '$folder', protocol = '$protocol', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			$arr = array("id" => $id, "status" => "2");
			return $arr;
			//return true;
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
		
		$q = "UPDATE " . CO_TBL_FORUMS . " set status = '$status', $sql = '$date', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}

	
	function setAllPhasesFinished($id,$status_date) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_FORUMS_PHASES . " set status = '2', finished_date = '$status_date', edited_user = '$session->uid', edited_date = '$now' WHERE pid = '$id'";
		$result = mysql_query($q, $this->_db->connection);
	}


	function newForum($id) {
		global $session, $contactsmodel, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		$title = $lang["FORUM_NEW"];
		
		$q = "INSERT INTO " . CO_TBL_FORUMS . " set folder = '$id', title = '$title', status = '0', planned_date = '$now', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			$id = mysql_insert_id();
			// if admin insert him to access
			if(!$session->isSysadmin()) {
				$forumsAccessModel = new ForumsAccessModel();
				$forumsAccessModel->setDetails($id,$session->uid,"");
			}
			return $id;
		}
	}
	
	
	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		// forum
		$q = "INSERT INTO " . CO_TBL_FORUMS . " (folder,title,protocol,planned_date,created_date,created_user,edited_date,edited_user) SELECT folder,CONCAT(title,' ".$lang["GLOBAL_DUPLICAT"]."'),protocol,'$now','$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_FORUMS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		// tasks
		$qt = "SELECT id,replyid,user,datetime,text,status FROM " . CO_TBL_FORUMS_POSTS . " where pid='$id' and bin='0' ORDER BY id";		
		$resultt = mysql_query($qt, $this->_db->connection);
		while($rowt = mysql_fetch_array($resultt)) {
			$id = $rowt["id"];
			$replyid = $rowt["replyid"];
			$user = $rowt["user"];
			$datetime = $rowt["datetime"];
			$text = mysql_real_escape_string($rowt["text"]);
			$status = $rowt["status"];
			$qtn = "INSERT INTO " . CO_TBL_FORUMS_POSTS . " set pid = '$id_new', replyid = '$replyid', user = '$user', datetime = '$datetime', text = '$text', status = '$status'";
			$rpn = mysql_query($qtn, $this->_db->connection);
			$id_t_new = mysql_insert_id();
			// BUILD OLD NEW TASK ID ARRAY
			$t[$id] = $id_t_new;
		}
		// Updates Dependencies for new tasks
		$qt = "SELECT id,replyid FROM " . CO_TBL_FORUMS_POSTS . " where pid='$id_new' and bin='0'";		
		$resultt = mysql_query($qt, $this->_db->connection);
		while($rowt = mysql_fetch_array($resultt)) {
			$id = $rowt["id"];
			$dep = 0;
			if($rowt["replyid"] != 0) {
				$dependent = $rowt["replyid"];
				$dep = $t[$dependent];
			}
			$qtn = "UPDATE " . CO_TBL_FORUMS_POSTS . " set replyid = '$dep' WHERE id='$id'";
			$rpn = mysql_query($qtn, $this->_db->connection);
		}
	
		if ($result) {
			return $id_new;
		}
	}


	function binForum($id) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_FORUMS . " set bin = '1', bintime = '$now', binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	function restoreForum($id) {
		$q = "UPDATE " . CO_TBL_FORUMS . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	function deleteForum($id) {
		global $forums;
		
		$active_modules = array();
		foreach($forums->modules as $module => $value) {
			if(CONSTANT('forums_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
			}
		}
		
		if(in_array("documents",$active_modules)) {
			$forumsDocumentsModel = new ForumsDocumentsModel();
			$q = "SELECT id FROM co_forums_documents_folders where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$did = $row["id"];
				$forumsDocumentsModel->deleteDocument($did);
			}
		}
		
		
		if(in_array("vdocs",$active_modules)) {
			$forumsVDocsmodel = new ForumsVDocsModel();
			$q = "SELECT id FROM co_forums_vdocs where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$vid = $row["id"];
				$forumsVDocsmodel->deleteVDoc($vid);
			}
		}
		
		$q = "DELETE FROM co_log_sendto WHERE what='forums' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM co_forums_access WHERE pid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM co_forums_desktop WHERE pid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_FORUMS_POSTS . " WHERE pid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_FORUMS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
		  	return true;
		}
		
	}


   function moveForum($id,$startdate,$movedays) {
		global $session, $contactsmodel;
		
		$startdate = $this->_date->formatDate($_POST['startdate']);
		
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_FORUMS . " set startdate = '$startdate', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
			$qt = "SELECT id, startdate, enddate FROM " . CO_TBL_FORUMS_PHASES_TASKS . " where pid='$id'";
			$resultt = mysql_query($qt, $this->_db->connection);
			while ($rowt = mysql_fetch_array($resultt)) {
				$tid = $rowt["id"];
				$startdate = $this->_date->addDays($rowt["startdate"],$movedays);
				$enddate = $this->_date->addDays($rowt["enddate"],$movedays);
				$qtk = "UPDATE " . CO_TBL_FORUMS_PHASES_TASKS . " set startdate = '$startdate', enddate = '$enddate' where id='$tid'";
				$retvaltk = mysql_query($qtk, $this->_db->connection);
			}
		if ($result) {
			return true;
		}
	}


	function getForumFolderDialog($field,$title) {
		global $session;
		$str = '<div class="dialog-text">';
		//$q ="select id, title from " . CO_TBL_FORUMS_FOLDERS . " where status='0' and bin = '0' ORDER BY title";
		if(!$session->isSysadmin()) {
			$q ="select a.id, a.title from " . CO_TBL_FORUMS_FOLDERS . " as a where a.status='0' and a.bin = '0' and (SELECT count(*) FROM co_forums_access as b, co_forums as c WHERE (b.admins REGEXP '[[:<:]]" . $session->uid . "[[:>:]]' or b.guests REGEXP '[[:<:]]" . $session->uid . "[[:>:]]') and c.folder=a.id and b.pid=c.id) > 0 ORDER BY title";
		} else {
			$q ="select id, title from " . CO_TBL_FORUMS_FOLDERS . " where status='0' and bin = '0' ORDER BY title";
		}
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$str .= '<a href="#" class="insertForumFolderfromDialog" title="' . $row["title"] . '" field="'.$field.'" gid="'.$row["id"].'">' . $row["title"] . '</a>';
		}
		$str .= '</div>';	
		return $str;
	 }


	function addForumItem($id,$text,$replyid,$num) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "INSERT INTO " . CO_TBL_FORUMS_POSTS . " set pid='$id', replyid='$replyid', user ='$session->uid', status = '0', text = '$text', datetime = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		$iid = mysql_insert_id();

		$task["id"] = $iid;
		$task["num"] = $num;
		$task["user"] = $this->_users->getUserFullname($session->uid);
		$task["avatar"] = $this->_users->getAvatar($session->uid);
		$task["datetime"] = $this->_date->formatDate($now,CO_DATETIME_FORMAT);
		$task["text"] = stripslashes($text);
		$tasks = new Lists($task);
	
		$this->writeNewPostsWidgetAlert($id);
		
		return $tasks;

	}
	
	
	
	function writeNewPostsWidgetAlert($pid) {
		global $session;
		$users = "";
		// select all users that have reminders for this forum
		$q = "SELECT admins,guests FROM co_forums_access where pid='$pid'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			if($row['admins'] != "") {
				$users .= $row['admins'] . ',';
			}
			if($row['guests'] != "") {
				$users .= $row['guests'] . ',';
			}
		}
		
		$q = "SELECT a.created_user FROM " . CO_TBL_FORUMS_FOLDERS . " as a, " . CO_TBL_FORUMS . " as b where b.folder = a.id and b.id='$pid'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			if($row['created_user'] != "") {
				$users .= $row['created_user'] . ',';
			}
		}
		$users = rtrim($users, ",");
		if($users != "") {
			$users = explode(",",$users);
		} else {
			$users = array();
		}
		foreach($users as $user) {
			if($user != $session->uid) {
				$q = "INSERT INTO " . CO_TBL_FORUMS_DESKTOP . " set pid='$pid', uid = '$user', newpost='1'";
				$result = mysql_query($q, $this->_db->connection);
			}
		}
		
   }

	
	
	function setItemStatus($id,$status) {
		
		$q = "UPDATE " . CO_TBL_FORUMS_POSTS . " set status = '$status' WHERE id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
	}


	function binForumItem($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_FORUMS_POSTS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if($result) {
			return true;
		}
	}
	
	function restoreItem($id) {
		$q = "UPDATE " . CO_TBL_FORUMS_POSTS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
  
   	function deleteItem($id) {
		$q = "DELETE FROM " . CO_TBL_FORUMS_POSTS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function getBin() {
		global $forums;
		
		$bin = array();
		$bin["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		$arr = array();
		$arr["bin"] = $bin;
		
		$arr["folders"] = "";
		$arr["pros"] = "";
		$arr["files"] = "";
		$arr["tasks"] = "";
		
		$active_modules = array();
		foreach($forums->modules as $module => $value) {
			if(CONSTANT('forums_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
			}
		}
		
		//foreach($active_modules as $module) {
							//$name = strtoupper($module);
							//$mod = new $name . "Model()";
							//include("modules/meetings/controller.php");
							//${$name} = new $name("$module");
							
						//}
		
		$q ="select id, title, bin, bintime, binuser from " . CO_TBL_FORUMS_FOLDERS;
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
				
				$qp ="select id, title, bin, bintime, binuser from " . CO_TBL_FORUMS . " where folder = '$id'";
				$resultp = mysql_query($qp, $this->_db->connection);
				while ($rowp = mysql_fetch_array($resultp)) {
					$pid = $rowp["id"];
					if($rowp["bin"] == "1") { // deleted forums
					foreach($rowp as $key => $val) {
						$pro[$key] = $val;
					}
					$pro["bintime"] = $this->_date->formatDate($pro["bintime"],CO_DATETIME_FORMAT);
					$pro["binuser"] = $this->_users->getUserFullname($pro["binuser"]);
					$pros[] = new Lists($pro);
					$arr["pros"] = $pros;
					} else {
						
						
						
						// posts
						$qt ="select id, text, bin, bintime, binuser from " . CO_TBL_FORUMS_POSTS . " where pid = '$pid'";
						$resultt = mysql_query($qt, $this->_db->connection);
						while ($rowt = mysql_fetch_array($resultt)) {
							if($rowt["bin"] == "1") { // deleted phases
								foreach($rowt as $key => $val) {
									$task[$key] = $val;
								}
								$task["bintime"] = $this->_date->formatDate($task["bintime"],CO_DATETIME_FORMAT);
								$task["binuser"] = $this->_users->getUserFullname($task["binuser"]);
								$tasks[] = new Lists($task);
								$arr["tasks"] = $tasks;
							} 
						}
						
												
						// documents_folder
						if(in_array("documents",$active_modules)) {
							$qd ="select id, title, bin, bintime, binuser from " . CO_TBL_FORUMS_DOCUMENTS_FOLDERS . " where pid = '$pid'";
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
									$qf ="select id, filename, bin, bintime, binuser from " . CO_TBL_FORUMS_DOCUMENTS . " where did = '$did'";
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
							$qv ="select id, title, bin, bintime, binuser from " . CO_TBL_FORUMS_VDOCS . " where pid = '$pid' and bin='1'";
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
		global $forums;
		
		$bin = array();
		$bin["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		$arr = array();
		$arr["bin"] = $bin;
		
		$arr["folders"] = "";
		$arr["pros"] = "";
		$arr["files"] = "";
		$arr["tasks"] = "";
		
		$active_modules = array();
		foreach($forums->modules as $module => $value) {
			if(CONSTANT('forums_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
			}
		}
		
		$q ="select id, title, bin, bintime, binuser from " . CO_TBL_FORUMS_FOLDERS;
		$result = mysql_query($q, $this->_db->connection);
	  	while ($row = mysql_fetch_array($result)) {
			$id = $row["id"];
			if($row["bin"] == "1") { // deleted folders
				$this->deleteFolder($id);
			} else { // folder not binned
				
				$qp ="select id, title, bin, bintime, binuser from " . CO_TBL_FORUMS . " where folder = '$id'";
				$resultp = mysql_query($qp, $this->_db->connection);
				while ($rowp = mysql_fetch_array($resultp)) {
					$pid = $rowp["id"];
					if($rowp["bin"] == "1") { // deleted forums
						$this->deleteForum($pid);
					} else {
						
						// posts
						$qt ="select id, text, bin, bintime, binuser from " . CO_TBL_FORUMS_POSTS . " where pid = '$pid'";
						$resultt = mysql_query($qt, $this->_db->connection);
						while ($rowt = mysql_fetch_array($resultt)) {
							$tid = $rowt["id"];
							if($rowt["bin"] == "1") { // deleted phases
								$this->deleteItem($tid);
								$arr["tasks"] = "";
							} 
						}


						// documents_folder
						if(in_array("documents",$active_modules)) {
							$forumsDocumentsModel = new ForumsDocumentsModel();
							$qd ="select id, title, bin, bintime, binuser from " . CO_TBL_FORUMS_DOCUMENTS_FOLDERS . " where pid = '$pid'";
							$resultd = mysql_query($qd, $this->_db->connection);
							while ($rowd = mysql_fetch_array($resultd)) {
								$did = $rowd["id"];
								if($rowd["bin"] == "1") { // deleted meeting
									$forumsDocumentsModel->deleteDocument($did);
									$arr["documents_folders"] = "";
								} else {
									// files
									$qf ="select id, filename, bin, bintime, binuser from " . CO_TBL_FORUMS_DOCUMENTS . " where did = '$did'";
									$resultf = mysql_query($qf, $this->_db->connection);
									while ($rowf = mysql_fetch_array($resultf)) {
										if($rowf["bin"] == "1") { // deleted phases
											$fid = $rowf["id"];
											$forumsDocumentsModel->deleteFile($fid);
											$arr["files"] = "";
										}
									}
								}
							}
						}
						
						// vdocs
						if(in_array("vdocs",$active_modules)) {
							$forumsVDocsModel = new ForumsVDocsModel();
							$qv ="select id, title, bin, bintime, binuser from " . CO_TBL_FORUMS_VDOCS . " where pid = '$pid'";
							$resultv = mysql_query($qv, $this->_db->connection);
							while ($rowv = mysql_fetch_array($resultv)) {
								$vid = $rowv["id"];
								if($rowv["bin"] == "1") {
									$forumsVDocsModel->deleteVDoc($vid);
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
		$q = "SELECT a.pid FROM co_forums_access as a, co_forums as b WHERE a.pid=b.id and b.bin='0' and a.admins REGEXP '[[:<:]]" . $id . "[[:>:]]' ORDER by b.title ASC";
      	$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$perms[] = $row["pid"];
		}
		return $perms;
   }


   function getViewPerms($id) {
		global $session;
		$perms = array();
		$q = "SELECT a.pid FROM co_forums_access as a, co_forums as b WHERE a.pid=b.id and b.bin='0' and a.guests REGEXP '[[:<:]]" . $id. "[[:>:]]' ORDER by b.title ASC";
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


   function getForumAccess($pid) {
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
   
   
   /*function isOwnerPerms($id,$uid) {
	   	$q = "SELECT id FROM co_forums where id = '$id' and created_user ='$uid'";
      	$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			return true;
		} else {
			return false;
		}
   }*/
   
   /*function isForumOwner($uid) {
	   	$q = "SELECT id FROM co_forums where created_user = '$uid'";
      	$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			return true;
		} else {
			return false;
		}
   }*/
	   


     function existUserForumsWidgets() {
		global $session;
		$q = "select count(*) as num from " . CO_TBL_FORUMS_DESKTOP_SETTINGS . " where uid='$session->uid'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_assoc($result);
		if($row["num"] < 1) {
			return false;
		} else {
			return true;
		}
	}
	
	
	function getUserForumsWidgets() {
		global $session;
		$q = "select * from " . CO_TBL_FORUMS_DESKTOP_SETTINGS . " where uid='$session->uid'";
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
		
		// reminders = neue posts für initiator und admins
		//$q ="select c.folder,c.id as pid,c.title as title from  " . CO_TBL_FORUMS . " as c where c.status='1' and c.bin = '0' " . $access;
		$reminders = "";
		$q ="select a.id as pid,a.folder,a.title as forumtitle from " . CO_TBL_FORUMS . " as a,  " . CO_TBL_FORUMS_DESKTOP . " as b where a.id = b.pid and b.newpost = '1' and a.bin = '0' and b.uid = '$session->uid' GROUP BY pid ORDER BY b.id DESC";
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			$string .= $array["folder"] . "," . $array["pid"] . ",";
			$reminders[] = new Lists($array);
		}

		
		// notices for this user
		$q ="select a.id as pid,a.folder,a.title as brainstormtitle,b.perm from " . CO_TBL_FORUMS . " as a,  " . CO_TBL_FORUMS_DESKTOP . " as b where a.id = b.pid and a.bin = '0' and b.uid = '$session->uid' and b.status = '0' and newpost!='1'";
		$result = mysql_query($q, $this->_db->connection);
		$notices = "";
		$array = "";
		while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			$string .= $array["folder"] . "," . $array["pid"] . ",";
			$notices[] = new Lists($array);
		}
		

		if(!$this->existUserForumsWidgets()) {
			$q = "insert into " . CO_TBL_FORUMS_DESKTOP_SETTINGS . " set uid='$session->uid', value='$string'";
			$result = mysql_query($q, $this->_db->connection);
			$widgetaction = "open";
		} else {
			$row = $this->getUserForumsWidgets();
			$id = $row["id"];
			if($string == $row["value"]) {
				$widgetaction = "";
			} else {
				$widgetaction = "open";
			}
			$q = "UPDATE " . CO_TBL_FORUMS_DESKTOP_SETTINGS . " set value='$string' WHERE id = '$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		
		$arr = array("reminders" => $reminders, "notices" => $notices, "widgetaction" => $widgetaction);
		return $arr;
   }

   
	function markNoticeRead($pid) {
		global $session, $date;
		
		$q ="UPDATE " . CO_TBL_FORUMS_DESKTOP . " SET status = '1' WHERE uid = '$session->uid' and pid = '$pid' and newpost='0'";
		$result = mysql_query($q, $this->_db->connection);
		return true;

	}


	function markNewPostRead($pid) {
		global $session, $date;
		
		$q ="DELETE FROM " . CO_TBL_FORUMS_DESKTOP . " WHERE uid = '$session->uid' and pid = '$pid' and newpost='1'";
		$result = mysql_query($q, $this->_db->connection);
		return true;

	}


	function getNavModulesNumItems($id) {
		global $forums;
		$active_modules = array();
		foreach($forums->modules as $module => $value) {
			$active_modules[] = $module;
		}
		if(in_array("documents",$active_modules)) {
			$forumsDocumentsModel = new ForumsDocumentsModel();
			$data["forums_documents_items"] = $forumsDocumentsModel->getNavNumItems($id);
		}
		
		if(in_array("vdocs",$active_modules)) {
			$forumsVDocsModel = new ForumsVDocsModel();
			$data["forums_vdocs_items"] = $forumsVDocsModel->getNavNumItems($id);
		}
		
		return $data;
	}

	function getGlobalSearch($term){
		global $system, $session, $forums;
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
		foreach($forums->modules as $m => $v) {
			$active_modules[] = $m;
		}
		
		$q = "SELECT id, folder, CONVERT(title USING latin1) as title, CONVERT(protocol USING latin1) as protocol FROM " . CO_TBL_FORUMS . " WHERE (title like '%$term%' || protocol like '%$term%') and  bin='0'" . $access ."ORDER BY title";
		$result = mysql_query($q, $this->_db->connection);
		//$num=mysql_affected_rows();
		while($row = mysql_fetch_array($result)) {
			 $rows['value'] = htmlspecialchars_decode($row['title']);
			 $rows['id'] = 'forums,' .$row['folder']. ',' . $row['id'] . ',0,forums';
			 $r[] = $rows;
		}
		// loop through forums
		$q = "SELECT id, folder FROM " . CO_TBL_FORUMS . " WHERE bin='0'" . $access ."ORDER BY title";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$pid = $row['id'];
			$folder = $row['folder'];
			$sql = "";
			$perm = $this->getForumAccess($pid);
			if($perm == 'guest') {
				$sql = "and access = '1'";
			}
			// Doc Folders
			if(in_array("documents",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_FORUMS_DOCUMENTS_FOLDERS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'documents,' .$folder. ',' . $pid . ',' .$rowp['id'].',forums';
					$r[] = $rows;
				}
				// Documents
				$qp = "SELECT b.id,CONVERT(a.filename USING latin1) as title FROM " . CO_TBL_FORUMS_DOCUMENTS . " as a, " . CO_TBL_FORUMS_DOCUMENTS_FOLDERS . " as b WHERE b.pid = '$pid' and a.did = b.id and a.bin = '0' and b.bin = '0' $sql and a.filename like '%$term%' ORDER BY a.filename";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'documents,' .$folder. ',' . $pid . ',' .$rowp['id'].',forums';
					$r[] = $rows;
				}
			}
			// vDocs
			if(in_array("vdocs",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_FORUMS_VDOCS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'vdocs,' .$folder. ',' . $pid . ',' .$rowp['id'].',forums';
					$r[] = $rows;
				}
			}
			
		}
		return json_encode($r);
	}


}

$forumsmodel = new ForumsModel(); // needed for direct calls to functions eg echo $forumsmodel ->getForumTitle(1);
?>
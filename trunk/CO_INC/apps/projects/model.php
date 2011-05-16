<?php
//include_once(CO_PATH_BASE . "/model.php");
//include_once(dirname(__FILE__)."/model/folders.php");
//include_once(dirname(__FILE__)."/model/projects.php");

class ProjectsModel extends Model {
	
	// Get all Project Folders
   function getFolderList($sort) {
      global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("folder-sort-status");
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
				  		$sortorder = $this->getSortOrder("folder-sort-order");
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
				  		$sortorder = $this->getSortOrder("folder-sort-order");
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
			$q ="select a.id, a.title from " . CO_TBL_PROJECTS_FOLDERS . " as a where a.status='0' and a.bin = '0' and (SELECT count(*) FROM co_projects_access as b, co_projects as c WHERE (b.admins REGEXP '[[:<:]]" . $session->uid . "[[:>:]]' or b.guests REGEXP '[[:<:]]" . $session->uid . "[[:>:]]') and c.projectfolder=a.id and b.pid=c.id) > 0 " . $order;
		} else {
			$q ="select a.id, a.title from " . CO_TBL_PROJECTS_FOLDERS . " as a where a.status='0' and a.bin = '0' " . $order;
		}
		
	  $this->setSortStatus("folder-sort-status",$sortcur);
      $result = mysql_query($q, $this->_db->connection);
	  $folders = "";
	  while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
				if($key == "id") {
				$array["numProjects"] = $this->getNumProjects($val);
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
   * get details for the project folder
   */
   function getFolderDetails($id) {
		global $session, $contactsmodel, $controllingmodel;
		$q = "SELECT * FROM " . CO_TBL_PROJECTS_FOLDERS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_assoc($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		$array["allprojects"] = $this->getNumProjects($id);
		$array["plannedprojects"] = $this->getNumProjects($id, $status="0");
		$array["activeprojects"] = $this->getNumProjects($id, $status="1");
		$array["inactiveprojects"] = $this->getNumProjects($id, $status="2");
		
		$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		
		$array["canedit"] = true;
		$array["access"] = "sysadmin";
 		if(!$session->isSysadmin()) {
			$array["canedit"] = false;
			$array["access"] = "guest";
		}
		
		$folder = new Lists($array);
		
		// get project details
		$access="";
		if(!$session->isSysadmin()) {
			$access = " and a.id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
	  	}
		
		 $sortstatus = $this->getSortStatus("project-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("project-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by a.title";
						  } else {
							$order = "order by field(a.id,$sortorder)";
						  }
				  break;	
			  }
		  }
		
		
		$q = "SELECT a.title,a.id,a.management, (SELECT MIN(startdate) FROM " . CO_TBL_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as startdate ,(SELECT MAX(enddate) FROM " . CO_TBL_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as enddate FROM " . CO_TBL_PROJECTS . " as a where a.projectfolder='$id' and a.bin='0'" . $access . " " . $order;

		//$q = "select a.title,a.id,a.access,a.status,(SELECT MIN(startdate) FROM " . CO_TBL_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as startdate,(SELECT MAX(enddate) FROM " . CO_TBL_PHASES_TASKS . " WHERE phaseid=a.id) as enddate from " . CO_TBL_PHASES . " as a where a.pid = '$id' and a.bin != '1' order by startdate";
		$result = mysql_query($q, $this->_db->connection);
	  	$projects = "";
	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$project[$key] = $val;
			}
			$project["startdate"] = $this->_date->formatDate($project["startdate"],CO_DATE_FORMAT);
			$project["enddate"] = $this->_date->formatDate($project["enddate"],CO_DATE_FORMAT);
			$project["realisation"] = $controllingmodel->getChart($project["id"], "realisation", 0);
			$project["management"] = $contactsmodel->getUserListPlain($project['management']);
			$projects[] = new Lists($project);
	  	}
		
		$access = "guest";
		  if($session->isSysadmin()) {
			  $access = "sysadmin";
		  }
		
		$arr = array("folder" => $folder, "projects" => $projects, "access" => $access);
		return $arr;
   }


   /**
   * get details for the project folder
   */
   function setFolderDetails($id,$title,$projectstatus) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_PROJECTS_FOLDERS . " set title = '$title', status = '$projectstatus', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }


   /**
   * create new project folder
   */
	function newFolder() {
		global $session, $lang;
		$now = gmdate("Y-m-d H:i:s");
		$title = $lang["PROJECT_FOLDER_NEW"];
		
		$q = "INSERT INTO " . CO_TBL_PROJECTS_FOLDERS . " set title = '$title', status = '0', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	$id = mysql_insert_id();
			return $id;
		}
	}


   /**
   * delete project folder
   */
   function binFolder($id) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_PROJECTS_FOLDERS . " set bin = '1', bintime = '$now', binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   
   function restoreFolder($id) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_PROJECTS_FOLDERS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deleteFolder($id) {
		$q = "SELECT id FROM " . CO_TBL_PROJECTS . " where projectfolder = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$pid = $row["id"];
			$this->deleteProject($pid);
		}
		
		$q = "DELETE FROM " . CO_TBL_PROJECTS_FOLDERS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


  /**
   * get number of projects for a project folder
   * status: 0 = all, 1 = active, 2 = abgeschlossen
   */   
   function getNumProjects($id, $status="0") {
		global $session;
		
		$access = "";
		 if(!$session->isSysadmin()) {
			$access = " and id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
		  }
		
		switch($status) {
			case "0":
				$q = "select id from " . CO_TBL_PROJECTS . " where projectfolder='$id' " . $access . " and bin != '1'";
			break;
			case "1":
				$q = "select id from " . CO_TBL_PROJECTS . " where projectfolder='$id' " . $access . " and status = '1' and bin != '1'";
			break;
			case "2":
				$q = "select id from " . CO_TBL_PROJECTS . " where projectfolder='$id' " . $access . " and status = '2' and bin != '1'";
			break;
		}
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_num_rows($result);
		return $row;
	}


	function getProjectTitle($id){
		global $session;
		$q = "SELECT title FROM " . CO_TBL_PROJECTS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		return $title;
   }


   	function getProjectTitleFromIDs($array){
		//$string = explode(",", $string);
		$total = sizeof($array);
		$data = '';
		
		if($total == 0) { 
			return $data; 
		}
		
		// check if project is available and build array
		$arr = array();
		foreach ($array as &$value) {
			$q = "SELECT id,title FROM " . CO_TBL_PROJECTS . " where id = '$value' and bin='0'";
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


   	function getProjectField($id,$field){
		global $session;
		$q = "SELECT $field FROM " . CO_TBL_PROJECTS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		return $title;
   }


  /**
   * get the list of projects for a project folder
   */ 
   function getProjectList($id,$sort) {
      global $session;
	  
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("project-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("project-sort-order",$id);
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
				  		$sortorder = $this->getSortOrder("project-sort-order",$id);
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
	  $q ="select id,title,status,checked_out,checked_out_user from " . CO_TBL_PROJECTS . " where projectfolder='$id' and bin = '0' " . $access . $order;

	  $this->setSortStatus("project-sort-status",$sortcur,$id);
      $result = mysql_query($q, $this->_db->connection);
	  $projects = "";
	  while ($row = mysql_fetch_array($result)) {
		foreach($row as $key => $val) {
			$array[$key] = $val;
			if($key == "id") {
				if($this->getProjectAccess($val) == "guest") {
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
		$array["itemstatus"] = $itemstatus;
		
		$checked_out_status = "";
		if($array["access"] != "guest" && $array["checked_out"] == 1 && $array["checked_out_user"] != $session->uid) {
			$checked_out_status = "icon-checked-out-active";
		}
		$array["checked_out_status"] = $checked_out_status;
		
		$projects[] = new Lists($array);
	  }
	  $arr = array("projects" => $projects, "sort" => $sortcur);
	  return $arr;
   }
	
	
	function checkoutProject($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_PROJECTS . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function checkinProject($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_PROJECTS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_PROJECTS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}
	

   function getProjectDetails($id) {
		global $session, $contactsmodel, $lang;
		$q = "SELECT a.*,(SELECT MAX(enddate) FROM " . CO_TBL_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as enddate FROM " . CO_TBL_PROJECTS . " as a where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		// perms
		$array["access"] = $this->getProjectAccess($id);
		$array["canedit"] = false;
		$array["showCheckout"] = false;
		$array["checked_out_user_text"] = $contactsmodel->getUserListPlain($array['checked_out_user']);

		if($array["access"] == "sysadmin" || $array["access"] == "admin") {
			if($array["checked_out"] == 1 && $session->checkUserActive($array["checked_out_user"])) {
				if($array["checked_out_user"] == $session->uid) {
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
					$array["checked_out_user_phone1"] = $contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
					$array["checked_out_user_email"] = $contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");
				}
			} else {
				$array["canedit"] = $this->checkoutProject($id);
			}
		} // EOF perms
		
		// dates
		$array["startdate"] = $this->_date->formatDate($array["startdate"],CO_DATE_FORMAT);
		$array["enddate"] = $this->_date->formatDate($array["enddate"],CO_DATE_FORMAT);
		$array["ordered_on"] = $this->_date->formatDate($array["ordered_on"],CO_DATE_FORMAT);
		$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
		
		// other functions
		$array["projectfolder"] = $this->getProjectFolderDetails($array["projectfolder"],"projectfolder");
		$array["management"] = $contactsmodel->getUserList($array['management'],'management', "", $array["canedit"]);
		$array["management_ct"] = empty($array["management_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['management_ct'];
		$array["team"] = $contactsmodel->getUserList($array['team'],'team', "", $array["canedit"]);
		$array["team_ct"] = empty($array["team_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['team_ct'];
		$array["ordered_by"] = $contactsmodel->getUserList($array['ordered_by'],'ordered_by', "", $array["canedit"]);
		$array["ordered_by_ct"] = empty($array["ordered_by_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['ordered_by_ct'];
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		$array["current_user"] = $session->uid;
		
		switch($array["status"]) {
			case "0":
				$array["status_text"] = $lang["PROJECT_STATUS_PLANNED"];
				$array["status_date"] = $this->_date->formatDate($array["planned_date"],CO_DATE_FORMAT);
			break;
			case "1":
				$array["status_text"] = $lang["PROJECT_STATUS_INPROGRESS"];
				$array["status_date"] = $this->_date->formatDate($array["inprogress_date"],CO_DATE_FORMAT);
			break;
			case "2":
				$array["status_text"] = $lang["PROJECT_STATUS_FINISHED"];
				$array["status_date"] = $this->_date->formatDate($array["finished_date"],CO_DATE_FORMAT);
			break;
		}
		
		
		
		$project = new Lists($array);
		
		$sql="";
		if($array["access"] == "guest") {
			$sql = " and a.access = '1' ";
		}
		
		// get phase details
		$q = "select a.title,a.id,a.access,a.status,(SELECT MIN(startdate) FROM " . CO_TBL_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as startdate,(SELECT MAX(enddate) FROM " . CO_TBL_PHASES_TASKS . " WHERE phaseid=a.id) as enddate from " . CO_TBL_PHASES . " as a where a.pid = '$id' and a.bin != '1' " . $sql . " order by startdate";
		$result = mysql_query($q, $this->_db->connection);
	  	$phases = "";
	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$phase[$key] = $val;
			}
			$phase["startdate"] = $this->_date->formatDate($phase["startdate"],CO_DATE_FORMAT);
			$phase["enddate"] = $this->_date->formatDate($phase["enddate"],CO_DATE_FORMAT);
			$phases[] = new Lists($phase);
	  	}
		// generate phase numbering
		$num = "";
		$qn = "select a.id,(SELECT MIN(startdate) FROM " . CO_TBL_PHASES_TASKS . " WHERE phaseid=a.id) as startdate from " . CO_TBL_PHASES . " as a where a.pid = '$id' and a.bin != '1' " . $sql . " order by startdate";
		$resultn = mysql_query($qn, $this->_db->connection);
		$i = 1;
		while ($rown = mysql_fetch_array($resultn)) {
			$num[$rown["id"]] = $i;
			$i++;
		}
		
		$sendto = $this->getSendtoDetails("projects",$id);
		
		$arr = array("project" => $project, "phases" => $phases, "num" => $num, "sendto" => $sendto, "access" => $array["access"]);
		return $arr;
   }


   function getDates($id) {
		global $session, $contactsmodel;
		$q = "SELECT a.startdate,(SELECT MAX(enddate) FROM " . CO_TBL_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as enddate FROM " . CO_TBL_PROJECTS . " as a where id = '$id'";
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

		$project = new Lists($array);
		return $project;
	}


   // Create project folder title
	function getProjectFolderDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			$q = "SELECT id, title from " . CO_TBL_PROJECTS_FOLDERS . " where id = '$value'";
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
   * get details for the project folder
   */
   function setProjectDetails($id,$title,$startdate,$ordered_by,$ordered_by_ct,$management,$management_ct,$team,$team_ct,$protocol,$projectfolder,$status,$status_date) {
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
		}

		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_PROJECTS . " set title = '$title', projectfolder = '$projectfolder', startdate = '$startdate', ordered_by = '$ordered_by', ordered_by_ct = '$ordered_by_ct', management = '$management', management_ct = '$management_ct', team='$team', team_ct = '$team_ct', protocol = '$protocol', status = '$status', $sql = '$status_date', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	function setAllPhasesFinished($id,$status_date) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_PHASES . " set status = '2', finished_date = '$status_date', edited_user = '$session->uid', edited_date = '$now' WHERE pid = '$id'";
		$result = mysql_query($q, $this->_db->connection);
	}


	function newProject($id) {
		global $session, $contactsmodel, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		$title = $lang["PROJECT_NEW"];
		
		$q = "INSERT INTO " . CO_TBL_PROJECTS . " set projectfolder = '$id', title = '$title', startdate = '$now', enddate = '$now', status = '0', planned_date = '$now', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			$id = mysql_insert_id();
			return $id;
		}
	}
	
	
	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		// project
		$q = "INSERT INTO " . CO_TBL_PROJECTS . " (projectfolder,title,startdate,ordered_by,management,team,protocol,status,planned_date,emailed_to,created_date,created_user,edited_date,edited_user) SELECT projectfolder,CONCAT(title,' ".$lang["GLOBAL_DUPLICAT"]."'),startdate,ordered_by,management,team,protocol,'0','$now',emailed_to,'$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_PROJECTS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		// phases
		$q = "SELECT id,title,team,management FROM " . CO_TBL_PHASES . " WHERE pid = '$id' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$phaseid = $row["id"];
			$title = $row["title"];
			$team = $row["team"];
			$management = $row["management"];
			
			$qp = "INSERT INTO " . CO_TBL_PHASES . " set pid='$id_new',title='$title',team='$team',management='$management'";
			$rp = mysql_query($qp, $this->_db->connection);
			$id_p_new = mysql_insert_id();
			// tasks
			$qt = "SELECT id,dependent,cat,text,startdate,enddate FROM " . CO_TBL_PHASES_TASKS . " where phaseid='$phaseid' and bin='0' ORDER BY startdate,status";		
			$resultt = mysql_query($qt, $this->_db->connection);
			while($rowt = mysql_fetch_array($resultt)) {
				$id = $rowt["id"];
				$cat = $rowt["cat"];
				$text = $rowt["text"];
				$startdate = $rowt["startdate"];
				$enddate = $rowt["enddate"];
				$dependent = $rowt["dependent"];
				$qtn = "INSERT INTO " . CO_TBL_PHASES_TASKS . " set pid = '$id_new', phaseid = '$id_p_new', dependent = '$dependent', cat = '$cat',status = '0',text = '$text',startdate = '$startdate',enddate = '$enddate'";
				$rpn = mysql_query($qtn, $this->_db->connection);
				$id_t_new = mysql_insert_id();
				// BUILD OLD NEW TASK ID ARRAY
				$t[$id] = $id_t_new;
			}
			// Updates Dependencies for new tasks
			$qt = "SELECT id,dependent FROM " . CO_TBL_PHASES_TASKS . " where phaseid='$id_p_new' and bin='0'";		
			$resultt = mysql_query($qt, $this->_db->connection);
			while($rowt = mysql_fetch_array($resultt)) {
				$id = $rowt["id"];
				$dep = 0;
				if($rowt["dependent"] != 0) {
					$dependent = $rowt["dependent"];
					$dep = $t[$dependent];
				}
				$qtn = "UPDATE " . CO_TBL_PHASES_TASKS . " set dependent = '$dep' WHERE id='$id'";
				$rpn = mysql_query($qtn, $this->_db->connection);
			}
		}
		if ($result) {
			return $id_new;
		}
	}


	function binProject($id) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_PROJECTS . " set bin = '1', bintime = '$now', binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	function restoreProject($id) {
		$q = "UPDATE " . CO_TBL_PROJECTS . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	function deleteProject($id) {
		global $projects;
		
		$active_modules = array();
		foreach($projects->modules as $module => $value) {
			if(CONSTANT($module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
			}
		}
		
		if(in_array("vdocs",$active_modules)) {
			$vdocsmodel = new VDocsModel();
			$q = "SELECT id FROM co_projects_vdocs where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$vid = $row["id"];
				$vdocsmodel->deleteVDoc($vid);
			}
		}
		
		if(in_array("documents",$active_modules)) {
			$documentsmodel = new DocumentsModel();
			$q = "SELECT id FROM co_projects_documents_folders where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$did = $row["id"];
				$documentsmodel->deleteDocument($did);
			}
		}
		
		if(in_array("meetings",$active_modules)) {
			$meetingsmodel = new MeetingsModel();
			$q = "SELECT id FROM co_projects_meetings where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$mid = $row["id"];
				$meetingsmodel->deleteMeeting($mid);
			}
		}
		
		if(in_array("phases",$active_modules)) {
			$phasesmodel = new PhasesModel();
			$q = "SELECT id FROM co_projects_phases where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$pid = $row["id"];
				$phasesmodel->deletePhase($pid);
			}
		}
		
		$q = "DELETE FROM co_log_sendto WHERE what='projects' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM co_projects_access WHERE pid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_PROJECTS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
		  	return true;
		}
		
	}


   function moveProject($id,$startdate,$movedays) {
		global $session, $contactsmodel;
		
		$startdate = $this->_date->formatDate($_POST['startdate']);
		
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_PROJECTS . " set startdate = '$startdate', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
			$qt = "SELECT id, startdate, enddate FROM " . CO_TBL_PHASES_TASKS . " where pid='$id'";
			$resultt = mysql_query($qt, $this->_db->connection);
			while ($rowt = mysql_fetch_array($resultt)) {
				$tid = $rowt["id"];
				$startdate = $this->_date->addDays($rowt["startdate"],$movedays);
				$enddate = $this->_date->addDays($rowt["enddate"],$movedays);
				$qtk = "UPDATE " . CO_TBL_PHASES_TASKS . " set startdate = '$startdate', enddate = '$enddate' where id='$tid'";
				$retvaltk = mysql_query($qtk, $this->_db->connection);
			}
		if ($result) {
			return true;
		}
	}


	function getProjectFolderDialog($field,$title) {
		$str = '<div class="dialog-text">';
		$q ="select id, title from " . CO_TBL_PROJECTS_FOLDERS . " where status='0' and bin = '0' ORDER BY title";
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$str .= '<a href="#" class="insertProjectFolderfromDialog" title="' . $row["title"] . '" field="'.$field.'" gid="'.$row["id"].'">' . $row["title"] . '</a>';
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
	   $q = "SELECT COUNT(id) FROM " .  CO_TBL_PHASES. " WHERE pid='$id' $sql and bin='0'";
	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function numPhasesOnTime($id) {
	   //$q = "SELECT COUNT(id) FROM " .  CO_TBL_PHASES. " WHERE pid='$id' $sql and bin='0'";
	   $q = "SELECT a.id,(SELECT MAX(enddate) FROM " . CO_TBL_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as enddate FROM " . CO_TBL_PHASES . " as a where a.pid= '$id' and a.status='2' and a.finished_date <= enddate";

	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function numPhasesTasks($id,$status = 0,$sql="") {
	   //$sql = "";
	   if ($status == 1) {
		   $sql .= " and status='1' ";
	   }
	   $q = "SELECT COUNT(id) FROM " .  CO_TBL_PHASES_TASKS. " WHERE pid='$id' $sql and bin='0'";
	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function getRest($value) {
		return round(100-$value,2);
   }


	function getChartFolder($id, $what) { 
		global $controllingmodel, $lang;
		switch($what) {
			case 'stability':
				$chart = $this->getChartFolder($id, 'timeing');
				$timeing = $chart["real"];
				
				$chart = $this->getChartFolder($id, 'tasks');
				$tasks = $chart["real"];
				
				$chart["real"] = round(($timeing+$tasks)/2,0);
				$chart["title"] = $lang["PROJECT_FOLDER_CHART_STABILITY"];
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
				
				$q = "SELECT id FROM " . CO_TBL_PROJECTS. " WHERE projectfolder = '$id' and status != '0' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$num = mysql_num_rows($result);
				$i = 1;
				while($row = mysql_fetch_assoc($result)) {
					$pid = $row["id"];
					$calc = $controllingmodel->getChart($pid,'realisation',0);
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
				$qt = "SELECT MAX(donedate) as dt,enddate FROM " . CO_TBL_PHASES_TASKS. " WHERE status='1' $id_array and bin='0'";
				$resultt = mysql_query($qt, $this->_db->connection);
				$ten = mysql_fetch_assoc($resultt);
				if($ten["dt"] <= $ten["enddate"]) {
					$chart["tendency"] = "tendency_positive.png";
				}
				
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = $lang["PROJECT_FOLDER_CHART_REALISATION"];
				$chart["img_name"] = $id . "_realisation.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
				
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
			break;
			

			case 'timeing':
				$realisation = 0;
				$id_array = "";
				
				$q = "SELECT id FROM " . CO_TBL_PROJECTS. " WHERE projectfolder = '$id' and status != '0' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$num = mysql_num_rows($result);
				$i = 1;
				while($row = mysql_fetch_assoc($result)) {
					$pid = $row["id"];
					$calc = $controllingmodel->getChart($pid,'timeing',0);
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
				$qt = "SELECT COUNT(id) FROM " . CO_TBL_PHASES_TASKS. " WHERE status='0' and startdate <= '$today' and enddate >= '$today' $id_array and bin='0'";
				$resultt = mysql_query($qt, $this->_db->connection);
				$tasks_active = mysql_result($resultt,0);
				
				$qo = "SELECT COUNT(id) FROM " . CO_TBL_PHASES_TASKS. " WHERE status='0' and enddate < '$today' $id_array and bin='0'";
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
				$chart["title"] = $lang["PROJECT_FOLDER_CHART_ADHERANCE"];
				$chart["img_name"] = $id . "_timeing.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
			
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
			break;
			
			case 'tasks':
				$realisation = 0;
				$id_array = "";
				
				$q = "SELECT id FROM " . CO_TBL_PROJECTS. " WHERE projectfolder = '$id' and status != '0' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$num = mysql_num_rows($result);
				$i = 1;
				while($row = mysql_fetch_assoc($result)) {
					$pid = $row["id"];
					$calc = $controllingmodel->getChart($pid,'tasks',0);
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
				$qt = "SELECT status,donedate,enddate FROM " . CO_TBL_PHASES_TASKS. " WHERE enddate < '$today' $id_array and bin='0' ORDER BY enddate DESC LIMIT 0,1";
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
				$chart["title"] = $lang["PROJECT_FOLDER_CHART_TASKS"];
				$chart["img_name"] = $id . "_tasks.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
			
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				
			break;
		}
		
		return $chart;
   }


   function getBin() {
		global $projects;
		
		$bin = array();
		$bin["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		$arr = array();
		$arr["bin"] = $bin;
		
		$arr["folders"] = "";
		$arr["pros"] = "";
		$arr["files"] = "";
		$arr["tasks"] = "";
		
		$active_modules = array();
		foreach($projects->modules as $module => $value) {
			if(CONSTANT($module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
			}
		}
		
		$q ="select id, title, bin, bintime, binuser from " . CO_TBL_PROJECTS_FOLDERS;
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
				
				$qp ="select id, title, bin, bintime, binuser from " . CO_TBL_PROJECTS . " where projectfolder = '$id'";
				$resultp = mysql_query($qp, $this->_db->connection);
				while ($rowp = mysql_fetch_array($resultp)) {
					$pid = $rowp["id"];
					if($rowp["bin"] == "1") { // deleted projects
					foreach($rowp as $key => $val) {
						$pro[$key] = $val;
					}
					$pro["bintime"] = $this->_date->formatDate($pro["bintime"],CO_DATETIME_FORMAT);
					$pro["binuser"] = $this->_users->getUserFullname($pro["binuser"]);
					$pros[] = new Lists($pro);
					$arr["pros"] = $pros;
					} else {
						
						
						// phases
						$qph ="select id, title, bin, bintime, binuser from " . CO_TBL_PHASES . " where pid = '$pid'";
						$resultph = mysql_query($qph, $this->_db->connection);
						while ($rowph = mysql_fetch_array($resultph)) {
							$phid = $rowph["id"];
							if($rowph["bin"] == "1") { // deleted phases
								foreach($rowph as $key => $val) {
									$phase[$key] = $val;
								}
								$phase["bintime"] = $this->_date->formatDate($phase["bintime"],CO_DATETIME_FORMAT);
								$phase["binuser"] = $this->_users->getUserFullname($phase["binuser"]);
								$phases[] = new Lists($phase);
								$arr["phases"] = $phases;
							} else {
								// tasks
								$qt ="select id, text, bin, bintime, binuser from " . CO_TBL_PHASES_TASKS . " where phaseid = '$phid'";
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
							}
						}
	
	
						// meetings
						if(in_array("meetings",$active_modules)) {
							$qm ="select id, title, bin, bintime, binuser from " . CO_TBL_MEETINGS . " where pid = '$pid'";
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
									$qmt ="select id, title, bin, bintime, binuser from " . CO_TBL_MEETINGS_TASKS . " where mid = '$mid'";
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
							$qd ="select id, title, bin, bintime, binuser from " . CO_TBL_DOCUMENTS_FOLDERS . " where pid = '$pid'";
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
									$qf ="select id, filename, bin, bintime, binuser from " . CO_TBL_DOCUMENTS . " where did = '$did'";
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
							$qv ="select id, title, bin, bintime, binuser from " . CO_TBL_VDOCS . " where pid = '$pid' and bin='1'";
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
		return $arr;
   }
   
   
   function emptyBin() {
		global $projects;
		
		$bin = array();
		$bin["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		$arr = array();
		$arr["bin"] = $bin;
		
		$arr["folders"] = "";
		$arr["pros"] = "";
		$arr["files"] = "";
		$arr["tasks"] = "";
		
		$active_modules = array();
		foreach($projects->modules as $module => $value) {
			if(CONSTANT($module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
			}
		}
		
		$q ="select id, title, bin, bintime, binuser from " . CO_TBL_PROJECTS_FOLDERS;
		$result = mysql_query($q, $this->_db->connection);
	  	while ($row = mysql_fetch_array($result)) {
			$id = $row["id"];
			if($row["bin"] == "1") { // deleted folders
				$this->deleteFolder($id);
			} else { // folder not binned
				
				$qp ="select id, title, bin, bintime, binuser from " . CO_TBL_PROJECTS . " where projectfolder = '$id'";
				$resultp = mysql_query($qp, $this->_db->connection);
				while ($rowp = mysql_fetch_array($resultp)) {
					$pid = $rowp["id"];
					if($rowp["bin"] == "1") { // deleted projects
						$this->deleteProject($pid);
					} else {
						
						// phases
						$phasesmodel = new PhasesModel();
						$qph ="select id, title, bin, bintime, binuser from " . CO_TBL_PHASES . " where pid = '$pid'";
						$resultph = mysql_query($qph, $this->_db->connection);
						while ($rowph = mysql_fetch_array($resultph)) {
							$phid = $rowph["id"];
							if($rowph["bin"] == "1") { // deleted phases
								$phasesmodel->deletePhase($phid);
								$arr["phases"] = "";
							} else {
								// tasks
								$qt ="select id, text, bin, bintime, binuser from " . CO_TBL_PHASES_TASKS . " where phaseid = '$phid'";
								$resultt = mysql_query($qt, $this->_db->connection);
								while ($rowt = mysql_fetch_array($resultt)) {
									if($rowt["bin"] == "1") { // deleted phases
										$phtid = $rowt["id"];
										$phasesmodel->deletePhaseTask($phtid);
										$arr["tasks"] = "";
									} 
								}
							}
						}


						// meetings
						if(in_array("meetings",$active_modules)) {
							$meetingsmodel = new MeetingsModel();
							$qm ="select id, title, bin, bintime, binuser from " . CO_TBL_MEETINGS . " where pid = '$pid'";
							$resultm = mysql_query($qm, $this->_db->connection);
							while ($rowm = mysql_fetch_array($resultm)) {
								$mid = $rowm["id"];
								if($rowm["bin"] == "1") { // deleted meeting
									$meetingsmodel->deleteMeeting($mid);
									$arr["meetings"] = "";
								} else {
									// meetings_tasks
									$qmt ="select id, title, bin, bintime, binuser from " . CO_TBL_MEETINGS_TASKS . " where mid = '$mid'";
									$resultmt = mysql_query($qmt, $this->_db->connection);
									while ($rowmt = mysql_fetch_array($resultmt)) {
										if($rowmt["bin"] == "1") { // deleted phases
											$mtid = $rowmt["id"];
											$meetingsmodel->deleteMeetingTask($mtid);
											$arr["meetings_tasks"] = "";
										}
									}
								}
							}
						}


						// documents_folder
						if(in_array("documents",$active_modules)) {
							$documentsmodel = new DocumentsModel();
							$qd ="select id, title, bin, bintime, binuser from " . CO_TBL_DOCUMENTS_FOLDERS . " where pid = '$pid'";
							$resultd = mysql_query($qd, $this->_db->connection);
							while ($rowd = mysql_fetch_array($resultd)) {
								$did = $rowd["id"];
								if($rowd["bin"] == "1") { // deleted meeting
									$documentsmodel->deleteDocument($did);
									$arr["documents_folders"] = "";
								} else {
									// files
									$qf ="select id, filename, bin, bintime, binuser from " . CO_TBL_DOCUMENTS . " where did = '$did'";
									$resultf = mysql_query($qf, $this->_db->connection);
									while ($rowf = mysql_fetch_array($resultf)) {
										if($rowf["bin"] == "1") { // deleted phases
											$fid = $rowf["id"];
											$documentsmodel->deleteFile($fid);
											$arr["files"] = "";
										}
									}
								}
							}
						}
	
	
						// vdocs
						if(in_array("vdocs",$active_modules)) {
							$qv ="select id, title, bin, bintime, binuser from " . CO_TBL_VDOCS . " where pid = '$pid' and bin='1'";
							$resultv = mysql_query($qv, $this->_db->connection);
							while ($rowv = mysql_fetch_array($resultv)) {
								$vid = $rowv["id"];
								$vdocsmodel = new VDocsModel();
								$vdocsmodel->deleteVDoc($vid);
								$arr["vdocs"] = "";
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
		$q = "SELECT pid FROM co_projects_access where admins REGEXP '[[:<:]]" . $id . "[[:>:]]'";
      	$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$perms[] = $row["pid"];
		}
		return $perms;
   }


   function getViewPerms($id) {
		global $session;
		$perms = array();
		$q = "SELECT pid FROM co_projects_access where guests REGEXP '[[:<:]]" . $id. "[[:>:]]'";
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


   function getProjectAccess($pid) {
		global $session;
		$access = "";
		if(in_array($pid,$this->getViewPerms($session->uid))) {
			$access = "guest";
		}
		if(in_array($pid,$this->getEditPerms($session->uid))) {
			$access = "admin";
		}
		if($session->isSysadmin()) {
			$access = "sysadmin";
		}
		return $access;
   }
   

}

$projectsmodel = new ProjectsModel(); // needed for direct calls to functions eg echo $projectsmodel ->getProjectTitle(1);
?>
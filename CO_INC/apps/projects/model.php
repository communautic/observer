<?php
//include_once(CO_PATH_BASE . "/model.php");
include_once(dirname(__FILE__)."/model/folders.php");
include_once(dirname(__FILE__)."/model/projects.php");

class ProjectsModel extends Model {

	// Get all Project Folders
   function getFolderList($sort) {
      global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("folder-sort-status");
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
				  		$sortorder = $this->getSortOrder("folder-sort-order");
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
				  		$sortorder = $this->getSortOrder("folder-sort-order");
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
	  
		$q ="select id, title from " . CO_TBL_PROJECTS_FOLDERS . " where status='0' and bin = '0' " . $order;
	
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
			$folders[] = new Folder($array);
		  
	  }
	  
	  $arr = array("folders" => $folders, "sort" => $sortcur);
	  
	  return $arr;
   }


  /**
   * get details for the project folder
   */
   function getFolderDetails($id) {
		global $session;
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
		
		$folder = new Folder($array);
		
		// get project details
		$q = "SELECT a.title,a.id,(SELECT MIN(startdate) FROM " . CO_TBL_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as startdate ,(SELECT MAX(enddate) FROM " . CO_TBL_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as enddate FROM " . CO_TBL_PROJECTS . " as a where a.projectfolder='$id' and a.bin='0'";

		//$q = "select a.title,a.id,a.access,a.status,(SELECT MIN(startdate) FROM " . CO_TBL_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as startdate,(SELECT MAX(enddate) FROM " . CO_TBL_PHASES_TASKS . " WHERE phaseid=a.id) as enddate from " . CO_TBL_PHASES . " as a where a.pid = '$id' and a.bin != '1' order by startdate";
		$result = mysql_query($q, $this->_db->connection);
	  	$projects = "";
	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$project[$key] = $val;
			}
			$project["startdate"] = $this->_date->formatDate($project["startdate"],CO_DATE_FORMAT);
			$project["enddate"] = $this->_date->formatDate($project["enddate"],CO_DATE_FORMAT);
			$projects[] = new Lists($project);
	  	}
		
		$arr = array("folder" => $folder, "projects" => $projects);
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


  /**
   * get number of projects for a project folder
   * status: 0 = all, 1 = active, 2 = abgeschlossen
   */   
   function getNumProjects($id, $status="0") {
		global $session;
		switch($status) {
			case "0":
				$q = "select id from " . CO_TBL_PROJECTS . " where projectfolder='$id' and bin != '1'";
			break;
			case "1":
				$q = "select id from " . CO_TBL_PROJECTS . " where projectfolder='$id' and status = '1' and bin != '1'";
			break;
			case "2":
				$q = "select id from " . CO_TBL_PROJECTS . " where projectfolder='$id' and status = '2' and bin != '1'";
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
	  
	  $q ="select id,title,status from " . CO_TBL_PROJECTS . " where projectfolder='$id' and bin = '0' " . $order;

	  $this->setSortStatus("project-sort-status",$sortcur,$id);
      $result = mysql_query($q, $this->_db->connection);
	  $projects = "";
	  while ($row = mysql_fetch_array($result)) {
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		// status
		$itemstatus = "";
		if($array["status"] == 2) {
			$itemstatus = " module-item-active";
		}
		$array["itemstatus"] = $itemstatus;
		
		$projects[] = new Lists($array);
	  }
	  $arr = array("projects" => $projects, "sort" => $sortcur);
	  return $arr;
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
		
		// dates
		$array["startdate"] = $this->_date->formatDate($array["startdate"],CO_DATE_FORMAT);
		$array["enddate"] = $this->_date->formatDate($array["enddate"],CO_DATE_FORMAT);
		$array["ordered_on"] = $this->_date->formatDate($array["ordered_on"],CO_DATE_FORMAT);
		$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
		
		// other functions
		$array["projectfolder"] = $this->getProjectFolderDetails($array["projectfolder"],"projectfolder");
		$array["management"] = $contactsmodel->getUserList($array['management'],'management');
		$array["management_ct"] = empty($array["management_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['management_ct'];
		$array["team"] = $contactsmodel->getUserList($array['team'],'team');
		$array["team_ct"] = empty($array["team_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['team_ct'];
		$array["ordered_by"] = $contactsmodel->getUserList($array['ordered_by'],'ordered_by');
		//$array["documents"] = $this->getRelatedDocuments('0:'.$id);
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
		
		// get user perms
		$array["edit"] = "1";
		
		$project = new Project($array);
		
		// get phase details
		$q = "select a.title,a.id,a.access,a.status,(SELECT MIN(startdate) FROM " . CO_TBL_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as startdate,(SELECT MAX(enddate) FROM " . CO_TBL_PHASES_TASKS . " WHERE phaseid=a.id) as enddate from " . CO_TBL_PHASES . " as a where a.pid = '$id' and a.bin != '1' order by startdate";
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
		$qn = "select a.id,(SELECT MIN(startdate) FROM " . CO_TBL_PHASES_TASKS . " WHERE phaseid=a.id) as startdate from " . CO_TBL_PHASES . " as a where a.pid = '$id' and a.bin != '1' order by startdate";
		$resultn = mysql_query($qn, $this->_db->connection);
		$i = 1;
		while ($rown = mysql_fetch_array($resultn)) {
			$num[$rown["id"]] = $i;
			$i++;
		}
		$arr = array("project" => $project, "phases" => $phases, "num" => $num);
		return $arr;
   }


   function getDates($id) {
		global $session, $contactsmodel;
		$q = "SELECT a.*,(SELECT MAX(enddate) FROM " . CO_TBL_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as enddate FROM " . CO_TBL_PROJECTS . " as a where id = '$id'";
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

		$project = new Project($array);
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
		// project
		$q = "INSERT INTO " . CO_TBL_PROJECTS . " (projectfolder,title,startdate,management,team,protocol,status,planned_date,emailed_to,created_date,created_user,edited_date,edited_user) SELECT projectfolder,CONCAT(title,' ".$lang["GLOBAL_DUPLICAT"]."'),startdate,management,team,protocol,status,planned_date,emailed_to,created_date,created_user,edited_date,edited_user FROM " . CO_TBL_PROJECTS . " where id='$id'";
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


	function getChart($id, $what) { 
		switch($what) {
			case 'stability':
				$chart = $this->getChart($id, 'realisation');
				$realisation = $chart["real"];
				
				$chart = $this->getChart($id, 'tasksontime');
				$tasksontime = $chart["real"];
				
				$chart = $this->getChart($id, 'timeing');
				$timeing = $chart["real"];
				
				$chart["real"] = round(($realisation+$tasksontime+$timeing)/3,0);
				$chart["title"] = "Projektstabilit&auml;t aktuell";
				$chart["img_name"] = $id . "_stability.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?chs=150x90&cht=gm&chd=t:' . $chart["real"];
				
				$chart["tendency"] = "tendency_negative.png";
				if($chart["real"] >= 50) {
					$chart["tendency"] = "tendency_positive.png";
				}
				
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				
			break;
			case 'realisation':
				$phases = 0;
				$phases_done = 0;
				$phases_tasks = 0;
				$phases_tasks_done = 0;
				$q = "SELECT id FROM " . CO_TBL_PROJECTS. " WHERE projectfolder = '$id'";
				$result = mysql_query($q, $this->_db->connection);
				while($row = mysql_fetch_assoc($result)) {
					$pid = $row["id"];
					$phases += $this->numPhases($pid);
					$phases_done += $this->numPhases($pid,2);
					$phases_tasks += $this->numPhasesTasks($pid);
					$phases_tasks_done += $this->numPhasesTasks($pid,1);
				}
				if($phases == 0 || $phases_tasks == 0) {
					$chart["real"] = 0;
				} else {
					$chart["real"] = round(((100/$phases)*$phases_done + (100/$phases_tasks)*$phases_tasks_done)/2,2);
				}
				
				$chart["tendency"] = "tendency_negative.png";
				if(isset($pid)) {
				$qt = "SELECT MAX(donedate) as dt,enddate FROM " . CO_TBL_PHASES_TASKS. " WHERE status='1' and pid='$pid'";
				$resultt = mysql_query($qt, $this->_db->connection);
				$ten = mysql_fetch_assoc($resultt);
				
				if($ten["dt"] <= $ten["enddate"]) {
					$chart["tendency"] = "tendency_positive.png";
				}
				}
				
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = "Realisierungsgrad";
				$chart["img_name"] = $id . "_realisierungsgrad.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
				
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
			break;
			
			case 'timeing':
				//$phases = 0;
				$phases_done = 0;
				$phases_done_ontime = 0;
				$tasks_done = 0;
				$tasks_done_ontime = 0;
				$q = "SELECT id FROM " . CO_TBL_PROJECTS. " WHERE projectfolder = '$id'";
				$result = mysql_query($q, $this->_db->connection);
				while($row = mysql_fetch_assoc($result)) {
					$pid = $row["id"];
					//$phases += $this->numPhases($pid);
					//$phases_done += $this->numPhases($pid,2);
					//$phases_done_ontime += $this->numPhases($pid,2," and finished_date <= enddate ");
					$tasks_done += $this->numPhasesTasks($pid,1);
					$tasks_done_ontime += $this->numPhasesTasks($pid,1," and donedate <= enddate ");
				}
				if($tasks_done == 0) {
					$chart["real"] = 0;
				} else {
					$chart["real"] = round((100/$tasks_done)*$tasks_done_ontime,2);
				}
				$chart["tendency"] = "tendency_negative.png";
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = "Termintreue";
				$chart["img_name"] = $id . "_timeing.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
			
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
			break;
			
			case 'tasks':
				$tasks = 0;
				$tasks_done = 0;
				
				$q = "SELECT id FROM " . CO_TBL_PROJECTS. " WHERE projectfolder = '$id'";
				$result = mysql_query($q, $this->_db->connection);
				while($row = mysql_fetch_assoc($result)) {
					$pid = $row["id"];
					$tasks += $this->numPhasesTasks($pid);
					$tasks_done += $this->numPhasesTasks($pid,1);
				}
				if($tasks == 0) {
					$chart["real"] = 0;
				} else {
					$chart["real"] = round((100/$tasks)*$tasks_done,2);
				}
				$chart["tendency"] = "tendency_negative.png";
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = "Aktivit&auml;t erreicht";
				$chart["img_name"] = $id . "tasks.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
			
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				
			break;
			
			case 'tasksontime':
				$tasks = 0;
				$tasks_done = 0;
				
				$q = "SELECT id FROM " . CO_TBL_PROJECTS. " WHERE projectfolder = '$id'";
				$result = mysql_query($q, $this->_db->connection);
				while($row = mysql_fetch_assoc($result)) {
					$pid = $row["id"];
					$tasks += $this->numPhasesTasks($pid);
					$tasks_done += $this->numPhasesTasks($pid,1," and donedate <= enddate ");
				}
				if($tasks == 0) {
					$chart["real"] = 0;
				} else {
					$chart["real"] = round((100/$tasks)*$tasks_done,2);
				}
				$chart["tendency"] = "tendency_negative.png";
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = "Arbeitspakete in Plan";
				$chart["img_name"] = $id . "tasksontime.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
			break;
		}
		
		return $chart;
   }
	
}

$projectsmodel = new ProjectsModel(); // needed for direct calls to functions eg echo $projectsmodel ->getProjectTitle(1);
?>
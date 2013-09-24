<?php
class ProjectsModel extends Model {
	
	// Get all Project Folders
   function getFolderList($sort) {
      global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("projects-folder-sort-status");
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
				  		$sortorder = $this->getSortOrder("projects-folder-sort-order");
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
				  		$sortorder = $this->getSortOrder("projects-folder-sort-order");
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
			$q ="select a.id, a.title from " . CO_TBL_PROJECTS_FOLDERS . " as a where a.status='0' and a.bin = '0' and (SELECT count(*) FROM co_projects_access as b, co_projects as c WHERE (b.admins REGEXP '[[:<:]]" . $session->uid . "[[:>:]]' or b.guests REGEXP '[[:<:]]" . $session->uid . "[[:>:]]') and c.folder=a.id and b.pid=c.id) > 0 " . $order;
		} else {
			$q ="select a.id, a.title from " . CO_TBL_PROJECTS_FOLDERS . " as a where a.status='0' and a.bin = '0' " . $order;
		}
		
	  $this->setSortStatus("projects-folder-sort-status",$sortcur);
      $result = mysql_query($q, $this->_db->connection);
	  $folders = "";
	  while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
				if($key == "id") {
					$array["numProjects"] = $this->getNumProjects($val);
					// wenn nicht sysadmin dann schau um admins
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
		global $session, $contactsmodel, $projectsControllingModel, $lang;
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
		$array["stoppedprojects"] = $this->getNumProjects($id, $status="3");
		
		$array["today"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		
		
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
		
		 $sortstatus = $this->getSortStatus("projects-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("projects-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by a.title";
						  } else {
							$order = "order by field(a.id,$sortorder)";
						  }
				  break;	
			  }
		  }
		
		
		$q = "SELECT a.title,a.id,a.management,a.status, (SELECT MIN(startdate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as startdate ,(SELECT MAX(enddate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as enddate FROM " . CO_TBL_PROJECTS . " as a where a.folder='$id' and a.bin='0'" . $access . " " . $order;

		$result = mysql_query($q, $this->_db->connection);
	  	$projects = "";
	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$project[$key] = $val;
			}
			$project["startdate"] = $this->_date->formatDate($project["startdate"],CO_DATE_FORMAT);
			$project["enddate"] = $this->_date->formatDate($project["enddate"],CO_DATE_FORMAT);
			$project["realisation"] = $projectsControllingModel->getChart($project["id"], "realisation", 0);
			$project["management"] = $contactsmodel->getUserListPlain($project['management']);
			$project["perm"] = $this->getProjectAccess($project["id"]);
			
			switch($project["status"]) {
				case "0":
					$project["status_text"] = $lang["GLOBAL_STATUS_PLANNED"];
				break;
				case "1":
					$project["status_text"] = $lang["GLOBAL_STATUS_INPROGRESS"];
				break;
				case "2":
					$project["status_text"] = $lang["GLOBAL_STATUS_FINISHED"];
				break;
				case "3":
					$project["status_text"] = $lang["GLOBAL_STATUS_STOPPED"];
				break;
			}
			
			$projects[] = new Lists($project);
	  	}
		
		$access = "guest";
		  if($session->isSysadmin()) {
			  $access = "sysadmin";
		  }
		
		$arr = array("folder" => $folder, "projects" => $projects, "access" => $access);
		return $arr;
   }


   function getFolderDetailsMultiView($id, $view, $width=17) {
		global $session, $contactsmodel, $projectsControllingModel;
		$now = new DateTime("now");
		$today = $now->format('Y-m-d');
		
		if($width == 0) {
		  $zoom = $this->getUserSetting("projects-multiview-chart-zoom");
		  if(!$zoom) {
			$width = 17;
		  } else {
			$width = $zoom;
		  }
		} else {
			$width = $width;
		}
		$this->setUserSetting("projects-multiview-chart-zoom",$width);
		
		// settings apart from width
		$space_between_phases = 2;
		$height_of_tasks = 10;
		
		$array["bg_image"] = CO_FILES . "/img/barchart_bg_".$width.".png";
		$array["bg_image_shift"] = 0;
		$array["td_width"] = $width;
		
		// zoom
		$array["zoom_xsmall"] = "zoom-xsmall";
		$array["zoom_small"] = "zoom-small";
		$array["zoom_medium"] = "zoom-medium";
		$array["zoom_large"] = "zoom-large";
		$array["zoom_xlarge"] = "zoom-xlarge";
		
		switch($width) {
			case 5:
				$array["zoom_xsmall"] = "zoom-xsmall-active";
			break;
			case 11:
				$array["zoom_small"] = "zoom-small-active";
			break;
			case 17:
				$array["zoom_medium"] = "zoom-medium-active";
			break;
			case 23:
				$array["zoom_large"] = "zoom-large-active";
			break;
			case 29:
				$array["zoom_xlarge"] = "zoom-xlarge-active";
			break;
		}
		
		$q = "SELECT * FROM " . CO_TBL_PROJECTS_FOLDERS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_assoc($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}	
		
		$array["canedit"] = true;
		$array["access"] = "sysadmin";
 		if(!$session->isSysadmin()) {
			$array["canedit"] = false;
			$array["access"] = "guest";
		}

		// get project details
		$access="";
		if(!$session->isSysadmin()) {
			$access = " and a.id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
	  	}
		
		$start = array();
		$q = "SELECT startdate as kickoff, (SELECT MIN(startdate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as startdate ,(SELECT MAX(enddate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as enddate FROM " . CO_TBL_PROJECTS . " as a where a.folder='$id' and a.bin='0'" . $access . " ORDER BY startdate ASC";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			while ($row = mysql_fetch_array($result)) {
				if($row['startdate'] == '') {
					$start[] = $row['kickoff'];
				} else {
					$start[] = $row['startdate'];
				}
			}
		
			$array["startdate"] = min($start);
		} else {
			
			return false;
		}
		
		switch($view) {
			case 'Timeline':
				$order = "startdate ASC";
			break;
			case 'Management':
				$order = "name ASC";
			break;
			case 'Status':
				$order = "status ASC";
			break;
		}
				
		$q = "SELECT a.title,a.id,a.management,a.status,startdate as kickoff, (SELECT CONCAT(c.lastname,' ', SUBSTRING(c.firstname,1,1),'.') FROM co_users as c WHERE a.management = c.id)  as name, (SELECT MIN(startdate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as startdate ,(SELECT MAX(enddate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as enddate FROM " . CO_TBL_PROJECTS . " as a where a.folder='$id' and a.bin='0'" . $access . " ORDER BY " . $order;
		$result = mysql_query($q, $this->_db->connection);
	  	$projects = "";
		
		$end = array();
		$css_top = 11;
		$numProjects = mysql_num_rows($result);

	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$project[$key] = $val;
			}
			$project["kickoff_only"] = false;
			if($project["enddate"] == '') {
				$project["enddate"] = $project["kickoff"];
			}
			$end[] = $project["enddate"];
			if($project["startdate"] == '') {
				$project["startdate"] = $project["kickoff"];
				$project["kickoff_only"] = true;
				$project["kickoff_space"] = round($width/2)-8;
			}
			$pid = $project["id"];
			$project["days"] = $this->_date->dateDiff($project["startdate"],$project["enddate"])+1;
			$project_start = $this->_date->dateDiff($array["startdate"],$project["startdate"]);
			$project["css_left"] = $project_start * $width;
			
			$project["startdate"] = $this->_date->formatDate($project["startdate"],CO_DATE_FORMAT);
			$project["enddate"] = $this->_date->formatDate($project["enddate"],CO_DATE_FORMAT);
			$project["management"] = $contactsmodel->getUserListPlain($project['management']);
			$project["realisation"] = $projectsControllingModel->getChart($project["id"], "realisation", 0);
			$project["perm"] = $this->getProjectAccess($project["id"]);
			$project["css_top"] = $css_top;
			$project["css_width"] = ($project["days"]) * $width;
			
			switch($project["status"]) {
				case "0":
					$project["status"] = "barchart_color_planned";
				break;
				case "1":
					$project["status"] = "barchart_color_inprogress";
				break;
				case "2":
					$project["status"] = "barchart_color_finished";
				break;
				case "3":
					$project["status"] = "barchart_color_not_finished";
				break;
			}
			
			// tasks loop
			
			$qt = "select * from " . CO_TBL_PROJECTS_PHASES_TASKS . " where pid = '$pid' and bin='0' order by startdate";
			$resultt = mysql_query($qt, $this->_db->connection);
			while ($rowt = mysql_fetch_object($resultt)) {
				switch($rowt->status) {
					case "0":
						/*if($row->status == 0) {
							$tstatus = "barchart_color_planned";
							// abbruch
							if($project["status"] == "barchart_color_not_finished") {
								$tstatus = "barchart_color_not_finished";
							}
						} else if ($row->status == 1 && $today < $rowt->startdate) {
							$tstatus = "barchart_color_planned";
							// abbruch
							if($project["status"] == "barchart_color_not_finished") {
								$tstatus = "barchart_color_not_finished";
							}
						} else if ($row->status == 1 && $today <= $rowt->enddate) {
							$tstatus = "barchart_color_inprogress";
							// abbruch
							if($project["status"] == "barchart_color_not_finished") {
								$tstatus = "barchart_color_not_finished";
							}
						} else */
						if ($project["status"] == "barchart_color_inprogress" && $today > $rowt->enddate) {
							$project["status"] = "barchart_color_overdue";
							
						}
					break;
					/*case "1":
						$tstatus = "barchart_color_finished";
						if($rowt->donedate > $rowt->enddate) {
							$tstatus = "barchart_color_finished_but_overdue";
						}
					break;*/
				}
			}
			
			
			
			$projects[] = new Lists($project);
			$css_top =  $css_top+38;
	  	}
		$wday = $this->_date->formatDate($array["startdate"],"w");
		if($wday != 1) {
			$array["bg_image_shift"] = -($wday-1)*$width;
		}
		$array["days"] = $this->_date->dateDiff($array["startdate"],max($end));
		$array["css_width"] = ($array["days"]+1) * $width;
		$array["css_height"] = $numProjects*38; // pixel add at bottom
		//$project["css_height"] += $space_between_phases;
		
		$folder = new Lists($array);
		
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
		$q = "SELECT id FROM " . CO_TBL_PROJECTS . " where folder = '$id'";
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
   function getNumProjects($id, $status="") {
		global $session;
		
		$access = "";
		 if(!$session->isSysadmin()) {
			$access = " and id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
		  }
		
		if($status == "") {
			$q = "select id from " . CO_TBL_PROJECTS . " where folder='$id' " . $access . " and bin != '1'";
		} else {
			$q = "select id from " . CO_TBL_PROJECTS . " where folder='$id' " . $access . " and status = '$status' and bin != '1'";
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
   
   
	function getProjectTitleLinkFromIDs($array,$target,$item = 0){
		$total = sizeof($array);
		$data = '';
		if($total == 0) { 
			return $data; 
		}
		$arr = array();
		$i = 0;
		foreach ($array as &$value) {
			$q = "SELECT id,folder,title FROM " . CO_TBL_PROJECTS . " where id = '$value' and bin='0'";
			$result = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result) > 0) {
				while($row = mysql_fetch_assoc($result)) {
					$arr[$i]["id"] = $row["id"];
					$arr[$i]["access"] = $this->getProjectAccess($row["id"]);
					$arr[$i]["title"] = $row["title"];
					$arr[$i]["folder"] = $row["folder"];
					$i++;
				}
			}
		}
		$arr_total = sizeof($arr);
		$i = 1;
		foreach ($arr as $key => &$value) {
			if($value["access"] == "") {
				$data .= $value["title"];
			} else {
				$data .= '<a class="externalLoadThreeLevels" rel="' . $target. ','.$value["folder"].','.$value["id"].',' . $item . ',projects">' . $value["title"] . '</a>';
			}
			if($i < $arr_total) {
				$data .= '<br />';
			}
			$data .= '';	
			$i++;
		}
		return $data;
   }



	function getProjectTitleFromMeetingIDs($array,$target, $link = 0){
		$total = sizeof($array);
		$data = '';
		if($total == 0) { 
			return $data; 
		}
		$arr = array();
		$i = 0;
		foreach ($array as &$value) {
			$qm = "SELECT pid,created_date FROM " . CO_TBL_PROJECTS_MEETINGS . " where id = '$value' and bin='0'";
			$resultm = mysql_query($qm, $this->_db->connection);
			if(mysql_num_rows($resultm) > 0) {
				$rowm = mysql_fetch_row($resultm);
				$pid = $rowm[0];
				$date = $this->_date->formatDate($rowm[1],CO_DATETIME_FORMAT);
				$q = "SELECT id,folder,title FROM " . CO_TBL_PROJECTS . " where id = '$pid' and bin='0'";
				$result = mysql_query($q, $this->_db->connection);
				if(mysql_num_rows($result) > 0) {
					while($row = mysql_fetch_assoc($result)) {
						$arr[$i]["id"] = $row["id"];
						$arr[$i]["item"] = $value;
						$arr[$i]["access"] = $this->getProjectAccess($row["id"]);
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
				$data .= '<a class="externalLoadThreeLevels" rel="' . $target. ','.$value["folder"].','.$value["id"].',' . $value["item"] . ',projects">' . $value["title"] . '</a>';
			}
			if($i < $arr_total) {
				$data .= '<br />';
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
		  $sortstatus = $this->getSortStatus("projects-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("projects-sort-order",$id);
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
				  		$sortorder = $this->getSortOrder("projects-sort-order",$id);
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
	  $q ="select id,title,status,checked_out,checked_out_user from " . CO_TBL_PROJECTS . " where folder='$id' and bin = '0' " . $access . $order;

	  $this->setSortStatus("projects-sort-status",$sortcur,$id);
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
		if($array["status"] == 3) {
			$itemstatus = " module-item-active-stopped";
		}
		$array["itemstatus"] = $itemstatus;
		
		$checked_out_status = "";
		if($array["access"] != "guest" && $array["checked_out"] == 1 && $array["checked_out_user"] != $session->uid) {
			if($session->checkUserActive($array["checked_out_user"])) {
				$checked_out_status = "icon-checked-out-active";
			} else {
				$this->checkinProjectOverride($id);
			}
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
	
	function checkinProjectOverride($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_PROJECTS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}

	function getProjectSettings($id) {
		$q = "SELECT setting_costs,setting_currency FROM " . CO_TBL_PROJECTS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		/*foreach($row as $key => $val) {
			$array[$key] = $val;
		}*/
		return $row;
	}

   function getProjectDetails($id, $option = "") {
		global $session, $contactsmodel, $lang;
		$q = "SELECT a.*,(SELECT MAX(enddate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as enddate FROM " . CO_TBL_PROJECTS . " as a where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		/*foreach($this->getProjectSettings($id) as $key => $val) {
			$array[$key] = $val;
		}*/
		
		// perms
		$array["access"] = $this->getProjectAccess($id);
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
			// check if this user is admin in some other project
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
					$array["canedit"] = $this->checkoutProject($id);
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
		$array["folder_id"] = $array["folder"];
		$array["folder"] = $this->getProjectFolderDetails($array["folder"],"folder");
		$array["management_print"] = $contactsmodel->getUserListPlain($array['management']);
		$array["management"] = $contactsmodel->getUserList($array['management'],'projectsmanagement', "", $array["canedit"]);
		$array["management_ct"] = empty($array["management_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['management_ct'];
		$array["team_print"] = $contactsmodel->getUserListPlain($array['team']);
		if($option = 'prepareSendTo') {
			$array["sendtoTeam"] = $contactsmodel->checkUserListEmail($array["team"],'projectsteam', "", $array["canedit"]);
			$array["sendtoTeamNoEmail"] = $contactsmodel->checkUserListEmail($array["team"],'projectsteam', "", $array["canedit"], 0);
			$array["sendtoError"] = false;
		}
		$array["team"] = $contactsmodel->getUserList($array['team'],'projectsteam', "", $array["canedit"]);
		$array["team_ct"] = empty($array["team_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['team_ct'];
		$array["ordered_by_print"] = $contactsmodel->getUserListPlain($array['ordered_by']);
		$array["ordered_by"] = $contactsmodel->getUserList($array['ordered_by'],'projectsordered_by', "", $array["canedit"]);
		$array["ordered_by_ct"] = empty($array["ordered_by_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['ordered_by_ct'];
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		$array["current_user"] = $session->uid;
		
		$array["status_planned_active"] = "";
		$array["status_inprogress_active"] = "";
		$array["status_finished_active"] = "";
		$array["status_stopped_active"] = "";
		switch($array["status"]) {
			case "0":
				$array["status_text"] = $lang["GLOBAL_STATUS_PLANNED"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_PLANNED_TIME"];
				$array["status_planned_active"] = " active";
				$array["status_date"] = $this->_date->formatDate($array["planned_date"],CO_DATE_FORMAT);
			break;
			case "1":
				$array["status_text"] = $lang["GLOBAL_STATUS_INPROGRESS"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_INPROGRESS_TIME"];
				$array["status_inprogress_active"] = " active";
				$array["status_date"] = $this->_date->formatDate($array["inprogress_date"],CO_DATE_FORMAT);
			break;
			case "2":
				$array["status_text"] = $lang["GLOBAL_STATUS_FINISHED"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_FINISHED_TIME"];
				$array["status_finished_active"] = " active";
				$array["status_date"] = $this->_date->formatDate($array["finished_date"],CO_DATE_FORMAT);
			break;
			case "3":
				$array["status_text"] = $lang["GLOBAL_STATUS_STOPPED"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_STOPPED_TIME"];
				$array["status_stopped_active"] = " active";
				$array["status_date"] = $this->_date->formatDate($array["stopped_date"],CO_DATE_FORMAT);
			break;
		}
		
		// checkpoint
		$array["checkpoint"] = 0;
		$array["checkpoint_date"] = "";
		$q = "SELECT date FROM " . CO_TBL_USERS_CHECKPOINTS . " where uid='$session->uid' and app = 'projects' and module = 'projects' and app_id = '$id' LIMIT 1";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			while ($row = mysql_fetch_assoc($result)) {
			$array["checkpoint"] = 1;
			$array["checkpoint_date"] = $this->_date->formatDate($row['date'],CO_DATE_FORMAT);
			}
		}
		
		// get projectlink infos
		$array["projectlink"] = 0;
		$array["projectlink_list"] = "";
		$array["projectlink_access"] = false;
		$q = "SELECT a.id,a.pid FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as a, " . CO_TBL_PROJECTS . " as b where a.project_link = '$id' and a.pid=b.id and a.bin='0' and b.bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			$array["projectlink"] = 1;
			while ($row = mysql_fetch_assoc($result)) {
			$projectlink[] = $row['pid'];
			
			}
			$array["projectlink_list"] = $this->getProjectTitleLinkFromIDs($projectlink,'projects');
		}
		
		
		
		$sql=" ";
		if($array["access"] == "guest" || $array["access"] == "guestadmin") {
			$sql = " and a.access = '1' ";
		}
		
		// get phase details
		$sortstatus = $this->getSortStatus("projects-phases-sort-status",$id);
		if(!$sortstatus) {
			$order = "order by startdate";
		} else {
			switch($sortstatus) {
				case "1":
					$order = "order by startdate";
				break;
				case "2":
					$order = "order by startdate DESC";
				break;
				case "3":
					$sortorder = $this->getSortOrder("projects-phases-sort-order",$id);
					if(!$sortorder) {
						$order = "order by startdate";
					} else {
						$order = "order by field(id,$sortorder)";
					}
				break;	
			}
		}
		$array["costs_plan_total"] = 0;
		$array["costs_real_total"] = 0;
		$q = "select a.title,a.id,a.access,a.status,(SELECT MIN(startdate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as startdate,(SELECT MAX(enddate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as c WHERE c.phaseid=a.id and c.bin='0') as enddate from " . CO_TBL_PROJECTS_PHASES . " as a where a.pid = '$id' and a.bin != '1' " . $sql . $order;
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
					$phase["status_text"] = $lang["GLOBAL_STATUS_PLANNED"];
				break;
				case "1":
					$phase["status_text"] = $lang["GLOBAL_STATUS_INPROGRESS"];
				break;
				case "2":
					$phase["status_text"] = $lang["GLOBAL_STATUS_FINISHED"];
				break;
			}
			
			$qs = "SELECT COUNT(id) FROM " .  CO_TBL_PROJECTS_PHASES_TASKS. " WHERE phaseid='$phaseid' and bin='0'";
		   	$results = mysql_query($qs, $this->_db->connection);
		   	$allTasks = mysql_result($results,0);
			
			$qd = "SELECT COUNT(id) FROM " .  CO_TBL_PROJECTS_PHASES_TASKS. " WHERE phaseid='$phaseid' and status = '1' and bin='0'";
		   	$resultd = mysql_query($qd, $this->_db->connection);
		   	$doneTasks = mysql_result($resultd,0);
			
			if($allTasks == 0) {
				$phase["realisation"] = 0;
			} else {
				$phase["realisation"] = round((100/$allTasks)*$doneTasks,2);
			}
			
			if($array["setting_costs"] == 1) {
				// costs
				$qc = "SELECT * FROM " .  CO_TBL_PROJECTS_PHASES_TASKS. " WHERE phaseid='$phaseid' and bin='0'";
				$resultc = mysql_query($qc, $this->_db->connection);
				while($costs = mysql_fetch_array($resultc)) {
					$costs["costs_plan"] = $costs["costs_employees"]+$costs["costs_materials"]+$costs["costs_external"]+$costs["costs_other"];
					$array["costs_plan_total"] += $costs["costs_plan"];
					$costs["costs_real"] = $costs["costs_employees_real"]+$costs["costs_materials_real"]+$costs["costs_external_real"]+$costs["costs_other_real"];
					$array["costs_real_total"] += $costs["costs_real"];
				}
			}
			
			$phases[] = new Lists($phase);
	  	}
		
		$array["costs_plan_total"] = number_format($array["costs_plan_total"],0,',','.');
		$array["costs_real_total"] = number_format($array["costs_real_total"],0,',','.');
				
		$project = new Lists($array);
		// generate phase numbering
		$num = "";
		$qn = "select a.id,(SELECT MIN(startdate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " WHERE phaseid=a.id and bin='0') as startdate from " . CO_TBL_PROJECTS_PHASES . " as a where a.pid = '$id' and a.bin != '1' " . $sql . " order by startdate";
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
		$q = "SELECT a.startdate,(SELECT MAX(enddate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as enddate FROM " . CO_TBL_PROJECTS . " as a where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		$startdate_check = $array["startdate"];
		$enddate_check = $array["enddate"];
		// check if there is a project link
		$ql = "SELECT a.id,a.pid,a.phaseid,a.startdate,a.enddate FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as a, " . CO_TBL_PROJECTS . " as b where a.project_link = '$id' and a.pid=b.id and b.bin='0' and a.bin='0'";
		$resultl = mysql_query($ql, $this->_db->connection);
		if(mysql_num_rows($resultl) > 0) {
			while ($rowl = mysql_fetch_assoc($resultl)) {
				$task_id = $rowl['id'];
				$pid = $rowl['pid'];
				$phid = $rowl['phaseid'];
				if($startdate_check != $rowl['startdate'] && $enddate_check != $rowl['enddate']) {
					$perm = 2;
				} else if ($startdate_check != $rowl['startdate']) {
					$perm = 3;
				} else if ($enddate_check != $rowl['enddate']) {
					$perm = 4;
				} else {
					$perm = 0;
				}
				if($perm != 0) {
					// update task
					$qu = "UPDATE " . CO_TBL_PROJECTS_PHASES_TASKS . " SET startdate = '$startdate_check', enddate = '$enddate_check' WHERE id='$task_id'";
					$resultu = mysql_query($qu, $this->_db->connection);
						// select all admins of this project as we
						$management = $this->getProjectField($pid,'management');
						$q = "SELECT admins FROM " . CO_TBL_PROJECTS_ACCESS . " where pid='$pid'";
						$result = mysql_query($q, $this->_db->connection);
						$admins = "";
						if(mysql_num_rows($result) > 0) {
							$admins = mysql_result($result,0);
						}
						$users = $management;
						if($users != "" && $admins != "") {
							$users .= ',';
						}
						$users .= $admins;
						$users = array_unique(explode(",", $users));
						foreach ($users as &$user) {
							$qz = "SELECT * FROM " . CO_TBL_PROJECTS_DESKTOP_PROJECTLINKS . " where pid='$id' and relid = '$pid' and phid = '$phid' and uid='$user' and perm ='$perm'";
							$resultz = mysql_query($qz, $this->_db->connection);
							if(mysql_num_rows($resultz) < 1) {
								$qz = "INSERT INTO " . CO_TBL_PROJECTS_DESKTOP_PROJECTLINKS . " set pid='$id', relid = '$pid', phid = '$phid', uid = '$user', perm ='$perm'";
								$resultz = mysql_query($qz, $this->_db->connection);
							}
						}
				}
			
			}
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
   function setProjectDetails($id,$title,$startdate,$startdate_orig,$ordered_by,$ordered_by_ct,$management,$management_ct,$team,$team_ct,$protocol,$folder) {
		global $session, $contactsmodel;
		
		$startdate = $this->_date->formatDate($startdate);
		$startdate_orig = $this->_date->formatDate($startdate_orig);
		if($startdate != $startdate_orig) {
			$ql = "SELECT id FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " where project_link = '$id' and bin='0'";
			$resultl = mysql_query($ql, $this->_db->connection);
			if(mysql_num_rows($resultl) > 0) {
				while ($rowl = mysql_fetch_assoc($resultl)) {
					$task_id = $rowl['id'];
					$qu = "UPDATE " . CO_TBL_PROJECTS_PHASES_TASKS . " SET startdate = '$startdate' WHERE id='$task_id'";
					$resultu = mysql_query($qu, $this->_db->connection);
				}
			}
		}

		// user lists
		$ordered_by = $contactsmodel->sortUserIDsByName($ordered_by);
		$management = $contactsmodel->sortUserIDsByName($management);
		$team = $contactsmodel->sortUserIDsByName($team);

		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_PROJECTS . " set title = '$title', folder = '$folder', startdate = '$startdate', ordered_by = '$ordered_by', ordered_by_ct = '$ordered_by_ct', management = '$management', management_ct = '$management_ct', team='$team', team_ct = '$team_ct', protocol = '$protocol', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
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
				$sql = "inprogress_date";
			break;
			case "2":
				$sql = "finished_date";
				$this->setAllPhasesFinished($id,$date);
			break;
			case "3":
				$sql = "stopped_date";
			break;
		}
		$q = "UPDATE " . CO_TBL_PROJECTS . " set status = '$status', $sql = '$date', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}


	function setAllPhasesFinished($id,$status_date) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_PROJECTS_PHASES . " set status = '2', finished_date = '$status_date', edited_user = '$session->uid', edited_date = '$now' WHERE pid = '$id' and status != '2'";
		$result = mysql_query($q, $this->_db->connection);
	}


	function newProject($id) {
		global $session, $contactsmodel, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		$title = $lang["PROJECT_NEW"];
		
		$q = "INSERT INTO " . CO_TBL_PROJECTS . " set folder = '$id', title = '$title', startdate = '$now', enddate = '$now', status = '0', planned_date = '$now', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			$id = mysql_insert_id();
			// if admin insert him to access
			if(!$session->isSysadmin()) {
				$projectsAccessModel = new ProjectsAccessModel();
				$projectsAccessModel->setDetails($id,$session->uid,"");
			}
			
			//$projectsPhasesModel = new ProjectsPhasesModel();
			//$projectsPhasesModel->createNew($id,1);
			return $id;
		}
	}
	
	
	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		// project
		$q = "INSERT INTO " . CO_TBL_PROJECTS . " (folder,title,setting_costs,setting_currency,startdate,ordered_by,management,team,protocol,status,planned_date,emailed_to,created_date,created_user,edited_date,edited_user) SELECT folder,CONCAT(title,' ".$lang["GLOBAL_DUPLICAT"]."'),setting_costs,setting_currency,startdate,ordered_by,management,team,protocol,'0','$now',emailed_to,'$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_PROJECTS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		
		if(!$session->isSysadmin()) {
				$projectsAccessModel = new ProjectsAccessModel();
				$projectsAccessModel->setDetails($id_new,$session->uid,"");
			}
		
		// phases
		$q = "SELECT id,title,protocol,team,management FROM " . CO_TBL_PROJECTS_PHASES . " WHERE pid = '$id' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$phaseid = $row["id"];
			$title = mysql_real_escape_string($row["title"]);
			$protocol = mysql_real_escape_string($row["protocol"]);
			$team = $row["team"];
			$management = $row["management"];
			
			$qp = "INSERT INTO " . CO_TBL_PROJECTS_PHASES . " set pid='$id_new',title='$title',protocol='$protocol',team='$team',management='$management',created_date='$now',created_user='$session->uid',edited_date='$now',edited_user='$session->uid'";
			$rp = mysql_query($qp, $this->_db->connection);
			$id_p_new = mysql_insert_id();
			// tasks
			$qt = "SELECT id,dependent,cat,text,protocol,startdate,enddate,costs_employees,costs_materials,costs_external,costs_other FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " where phaseid='$phaseid' and bin='0' ORDER BY id ASC";		
			$resultt = mysql_query($qt, $this->_db->connection);
			while($rowt = mysql_fetch_array($resultt)) {
				$id = $rowt["id"];
				$cat = $rowt["cat"];
				$text = mysql_real_escape_string($rowt["text"]);
				$protocol = mysql_real_escape_string($rowt["protocol"]);
				$startdate = $rowt["startdate"];
				$enddate = $rowt["enddate"];
				$costs_employees = $rowt["costs_employees"];
				$costs_materials = $rowt["costs_materials"];
				$costs_external = $rowt["costs_external"];
				$costs_other = $rowt["costs_other"];
				$dependent = $rowt["dependent"];
				$qtn = "INSERT INTO " . CO_TBL_PROJECTS_PHASES_TASKS . " set pid = '$id_new', phaseid = '$id_p_new', dependent = '$dependent', cat = '$cat',status = '0',text = '$text',protocol = '$protocol', startdate = '$startdate',enddate = '$enddate', costs_employees ='$costs_employees', costs_materials ='$costs_materials', costs_external ='$costs_external', costs_other ='$costs_other'";
				$rpn = mysql_query($qtn, $this->_db->connection);
				$id_t_new = mysql_insert_id();
				// BUILD OLD NEW TASK ID ARRAY
				$t[$id] = $id_t_new;
			}
			
		}
		// Updates Dependencies for new tasks
			$qt = "SELECT id,dependent FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " where pid='$id_new' and bin='0' ORDER BY id ASC";		
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
				$qtn = "UPDATE " . CO_TBL_PROJECTS_PHASES_TASKS . " set dependent = '$dep' WHERE id='$id'";
				$rpn = mysql_query($qtn, $this->_db->connection);
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
			if(CONSTANT('projects_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
			}
		}
		
		if(in_array("vdocs",$active_modules)) {
			$projectsVDocsmodel = new ProjectsVDocsModel();
			$q = "SELECT id FROM co_projects_vdocs where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$vid = $row["id"];
				$projectsVDocsmodel->deleteVDoc($vid);
			}
		}
		
		if(in_array("phonecalls",$active_modules)) {
			$projectsPhonecallsModel = new ProjectsPhonecallsModel();
			$q = "SELECT id FROM co_projects_phonecalls where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$pcid = $row["id"];
				$projectsPhonecallsModel->deletePhonecall($pcid);
			}
		}
		
		if(in_array("documents",$active_modules)) {
			$projectsDocumentsModel = new ProjectsDocumentsModel();
			$q = "SELECT id FROM co_projects_documents_folders where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$did = $row["id"];
				$projectsDocumentsModel->deleteDocument($did);
			}
		}
		
		if(in_array("meetings",$active_modules)) {
			$projectsMeetingsModel = new ProjectsMeetingsModel();
			$q = "SELECT id FROM co_projects_meetings where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$mid = $row["id"];
				$projectsMeetingsModel->deleteMeeting($mid);
			}
		}
		
		if(in_array("phases",$active_modules)) {
			$projectsPhasesModel = new ProjectsPhasesModel();
			$q = "SELECT id FROM co_projects_phases where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$pid = $row["id"];
				$projectsPhasesModel->deletePhase($pid);
			}
		}
		
		// projectlinks
		$q = "DELETE FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " WHERE project_link ='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$q = "DELETE FROM " . CO_TBL_PROJECTS_DESKTOP_PROJECTLINKS . " WHERE pid ='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM co_log_sendto WHERE what='projects' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM co_projects_access WHERE pid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM co_projects_desktop WHERE pid='$id'";
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
		$start = $startdate;
		$end = array();
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_PROJECTS . " set startdate = '$startdate', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
			$qt = "SELECT id, startdate, enddate FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " where pid='$id' and cat !='2'";
			$resultt = mysql_query($qt, $this->_db->connection);
			while ($rowt = mysql_fetch_array($resultt)) {
				$tid = $rowt["id"];
				$startdate = $this->_date->addDays($rowt["startdate"],$movedays);
				$enddate = $this->_date->addDays($rowt["enddate"],$movedays);
				$end[] = $enddate;
				$qtk = "UPDATE " . CO_TBL_PROJECTS_PHASES_TASKS . " set startdate = '$startdate', enddate = '$enddate' where id='$tid'";
				$retvaltk = mysql_query($qtk, $this->_db->connection);
			}
		if ($result) {
			$this->checkProjectlink($id,$start,max($end));
			return true;
		}
	}
	
	function checkProjectlink($id,$startdate,$enddate) {
		//$ql = "SELECT a.id,a.pid,a.phaseid,a.startdate,a.enddate,b.startdate as startdate_check, b.enddate as enddate_check FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as a, " . CO_TBL_PROJECTS . " as b where a.project_link = '$id' and a.pid=b.id and b.bin='0' and a.bin='0'";
		$ql = "SELECT id,pid,phaseid,startdate,enddate FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " where project_link = '$id' and bin='0'";
		$resultl = mysql_query($ql, $this->_db->connection);
		if(mysql_num_rows($resultl) > 0) {
			while ($rowl = mysql_fetch_assoc($resultl)) {
				/*$startdate_check = $rowl['startdate_check'];
				$enddate_check = $rowl['enddate_check'];*/
				$task_id = $rowl['id'];
				$pid = $rowl['pid'];
				$phid = $rowl['phaseid'];
				$perm = 2;
				$qu = "UPDATE " . CO_TBL_PROJECTS_PHASES_TASKS . " SET startdate = '$startdate', enddate = '$enddate' WHERE id='$task_id'";
				$resultu = mysql_query($qu, $this->_db->connection);
				// select all admins of this project as we
				$management = $this->getProjectField($pid,'management');
				$q = "SELECT admins FROM " . CO_TBL_PROJECTS_ACCESS . " where pid='$pid'";
				$result = mysql_query($q, $this->_db->connection);
				$admins = "";
				if(mysql_num_rows($result) > 0) {
					$admins = mysql_result($result,0);
				}
				$users = $management;
				if($users != "" && $admins != "") {
					$users .= ',';
				}
				$users .= $admins;
				$users = array_unique(explode(",", $users));
				foreach ($users as &$user) {
					$qz = "SELECT * FROM " . CO_TBL_PROJECTS_DESKTOP_PROJECTLINKS . " where pid='$id' and relid = '$pid' and phid = '$phid' and uid='$user' and perm ='$perm'";
					$resultz = mysql_query($qz, $this->_db->connection);
					if(mysql_num_rows($resultz) < 1) {
						$qz = "INSERT INTO " . CO_TBL_PROJECTS_DESKTOP_PROJECTLINKS . " set pid='$id', relid = '$pid', phid = '$phid', uid = '$user', perm ='$perm'";
						$resultz = mysql_query($qz, $this->_db->connection);
					}
				}
			}
		}
	}
	

	function getProjectFolderDialog($field,$title) {
		global $session;
		$str = '<div class="dialog-text">';
		//$q ="select id, title from " . CO_TBL_PROJECTS_FOLDERS . " where status='0' and bin = '0' ORDER BY title";
		if(!$session->isSysadmin()) {
			$q ="select a.id, a.title from " . CO_TBL_PROJECTS_FOLDERS . " as a where a.status='0' and a.bin = '0' and (SELECT count(*) FROM co_projects_access as b, co_projects as c WHERE (b.admins REGEXP '[[:<:]]" . $session->uid . "[[:>:]]' or b.guests REGEXP '[[:<:]]" . $session->uid . "[[:>:]]') and c.folder=a.id and b.pid=c.id) > 0 ORDER BY title";
		} else {
			$q ="select id, title from " . CO_TBL_PROJECTS_FOLDERS . " where status='0' and bin = '0' ORDER BY title";
		}
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
	   $q = "SELECT COUNT(id) FROM " .  CO_TBL_PROJECTS_PHASES. " WHERE pid='$id' $sql and bin='0'";
	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function numPhasesOnTime($id) {
	   //$q = "SELECT COUNT(id) FROM " .  CO_TBL_PROJECTS_PHASES. " WHERE pid='$id' $sql and bin='0'";
	   $q = "SELECT a.id,(SELECT MAX(enddate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as enddate FROM " . CO_TBL_PROJECTS_PHASES . " as a where a.pid= '$id' and a.status='2' and a.finished_date <= enddate";

	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function numPhasesTasks($id,$status = 0,$sql="") {
	   //$sql = "";
	   if ($status == 1) {
		   $sql .= " and status='1' ";
	   }
	   $q = "SELECT COUNT(id) FROM " .  CO_TBL_PROJECTS_PHASES_TASKS. " WHERE pid='$id' $sql and bin='0'";
	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function getRest($value) {
		return round(100-$value,2);
   }


	function getProjectCosts($id,$option='') {
		$costs["costs_plan"] = 0;
		$costs["costs_employees_plan"] = 0;
		$costs["costs_materials_plan"] = 0;
		$costs["costs_external_plan"] = 0;
		$costs["costs_other_plan"] = 0;
		$costs["costs_real"] = 0;
		$costs["costs_employees_real"] = 0;
		$costs["costs_materials_real"] = 0;
		$costs["costs_external_real"] = 0;
		$costs["costs_other_real"] = 0;
		$q = "select id from " . CO_TBL_PROJECTS_PHASES . " where pid = '$id' and bin != '1' ";
		$result = mysql_query($q, $this->_db->connection);
	  	$phases = "";
	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$phase[$key] = $val;
			}
			$phaseid = $phase["id"];
			foreach($this->getProjectSettings($id) as $key => $val) {
				$costs[$key] = $val;
			}
			$sql = '';
			if($costs["setting_costs"] == 1) {
				if($option == 'finishedtasks') {
					$sql = "and status='1'";
				}
				// costs
				$qc = "SELECT * FROM " .  CO_TBL_PROJECTS_PHASES_TASKS. " WHERE phaseid='$phaseid' $sql and bin='0'";
				$resultc = mysql_query($qc, $this->_db->connection);
				while($row = mysql_fetch_array($resultc)) {
					$costs["costs_plan"] += $row["costs_employees"]+$row["costs_materials"]+$row["costs_external"]+$row["costs_other"];
					$costs["costs_employees_plan"] += $row["costs_employees"];
					$costs["costs_materials_plan"] += $row["costs_materials"];
					$costs["costs_external_plan"] += $row["costs_external"];
					$costs["costs_other_plan"] += $row["costs_other"];
					$costs["costs_real"] += $row["costs_employees_real"]+$row["costs_materials_real"]+$row["costs_external_real"]+$row["costs_other_real"];
					$costs["costs_employees_real"] += $row["costs_employees_real"];
					$costs["costs_materials_real"] += $row["costs_materials_real"];
					$costs["costs_external_real"] += $row["costs_external_real"];
					$costs["costs_other_real"] += $row["costs_other_real"];
				}
			}
	  	}
		return $costs;
	}

	function getChartFolder($id, $what) { 
		global $projectsControllingModel, $lang;
		switch($what) {
			case 'stability':
				$chart = $this->getChartFolder($id, 'timeing');
				$timeing = $chart["real"];
				
				$chart = $this->getChartFolder($id, 'tasks');
				$tasks = $chart["real"];
				if($tasks == 0) {
						$chart["real"] = round($timeing);
				} else {
					$chart["real"] = round(($timeing+$tasks)/2,0);
				}
				$chart["title"] = $lang["PROJECT_FOLDER_CHART_STABILITY"];
				$chart["img_name"] = "project_" . $id . "_stability.png";
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
				
				$q = "SELECT id FROM " . CO_TBL_PROJECTS. " WHERE folder = '$id' and status != '0' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$num = mysql_num_rows($result);
				$i = 1;
				while($row = mysql_fetch_assoc($result)) {
					$pid = $row["id"];
					$calc = $projectsControllingModel->getChart($pid,'realisation',0);
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
				$qt = "SELECT MAX(donedate) as dt,enddate FROM " . CO_TBL_PROJECTS_PHASES_TASKS. " WHERE status='1' $id_array and bin='0'";
				$resultt = mysql_query($qt, $this->_db->connection);
				$ten = mysql_fetch_assoc($resultt);
				if($ten["dt"] <= $ten["enddate"]) {
					$chart["tendency"] = "tendency_positive.png";
				}
				
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = $lang["PROJECT_FOLDER_CHART_REALISATION"];
				$chart["img_name"] = "project_" . $id . "_realisation.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
				
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
			break;
			

			case 'timeing':
				$realisation = 0;
				$id_array = "";
				
				$q = "SELECT id FROM " . CO_TBL_PROJECTS. " WHERE folder = '$id' and status != '0' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$num = mysql_num_rows($result);
				$i = 1;
				while($row = mysql_fetch_assoc($result)) {
					$pid = $row["id"];
					$calc = $projectsControllingModel->getChart($pid,'timeing',0);
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
				$qt = "SELECT COUNT(id) FROM " . CO_TBL_PROJECTS_PHASES_TASKS. " WHERE status='0' and startdate <= '$today' and enddate >= '$today' $id_array and bin='0'";
				$resultt = mysql_query($qt, $this->_db->connection);
				$tasks_active = mysql_result($resultt,0);
				
				$qo = "SELECT COUNT(id) FROM " . CO_TBL_PROJECTS_PHASES_TASKS. " WHERE status='0' and enddate < '$today' $id_array and bin='0'";
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
				$chart["img_name"] = "project_" . $id . "_timeing.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
			
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
			break;
			
			case 'tasks':
				$realisation = 0;
				$id_array = "";
				
				$q = "SELECT id FROM " . CO_TBL_PROJECTS. " WHERE folder = '$id' and status != '0' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$num = mysql_num_rows($result);
				$i = 1;
				while($row = mysql_fetch_assoc($result)) {
					$pid = $row["id"];
					$calc = $projectsControllingModel->getChart($pid,'tasks',0);
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
				$qt = "SELECT status,donedate,enddate FROM " . CO_TBL_PROJECTS_PHASES_TASKS. " WHERE enddate < '$today' $id_array and bin='0' ORDER BY enddate DESC LIMIT 0,1";
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
				$chart["img_name"] = "project_" . $id . "_tasks.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
			
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				
			break;
			case 'status':

				// all
				$q = "SELECT id FROM " . CO_TBL_PROJECTS. " WHERE folder = '$id' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$all = mysql_num_rows($result);
				
				// planned
				$q = "SELECT id FROM " . CO_TBL_PROJECTS. " WHERE folder = '$id' and status = '0' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$planned = mysql_num_rows($result);
				$chart["planned"] = 0;
				if($planned != 0) {
					$chart["planned"] = round((100/$all)*$planned,0);
				}
				
				// inprogress
				$q = "SELECT id FROM " . CO_TBL_PROJECTS. " WHERE folder = '$id' and status = '1' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$inprogress = mysql_num_rows($result);
				$chart["inprogress"] = 0;
				if($inprogress != 0) {
					$chart["inprogress"] = round((100/$all)*$inprogress,0);
				}
				// finished
				$q = "SELECT id FROM " . CO_TBL_PROJECTS. " WHERE folder = '$id' and status = '2' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$finished = mysql_num_rows($result);
				$chart["finished"] = 0;
				if($finished != 0) {
					$chart["finished"] = round((100/$all)*$finished,0);
				}
				
				// stopped
				$q = "SELECT id FROM " . CO_TBL_PROJECTS. " WHERE folder = '$id' and status = '3' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$stopped = mysql_num_rows($result);
				$chart["stopped"] = 0;
				if($stopped != 0) {
					$chart["stopped"] = round((100/$all)*$stopped,0);
				}				

				$chart["title"] = $lang["PROJECT_FOLDER_CHART_STATUS"];
				$chart["img_name"] = 'projects_' . $id . "_status.png";
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
			if(CONSTANT('projects_'.$module.'_bin') == 1) {
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
				
				$qp ="select id, title, bin, bintime, binuser from " . CO_TBL_PROJECTS . " where folder = '$id'";
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
						/*$module = "phases";
						$name = ucfirst($module);
							$function = "get" . $name . "Bin";
							${$module} = new $name("$module");*/
							//print_r(${$module}->$function($pid));
							
							//$arr["phases"] = ${$module}->$function($pid);
							//print_r($mods);
							//print_r($arr);//$arr[] = $res;
							//$arr["phases"] = $res["phases"];
							//print_r($res);
						/*foreach($active_modules as $module) {
							$name = ucfirst($module);
							$function = "get" . $name . "Bin";
							${$module} = new $name("$module");
							echo ${$module}->$function($pid);
							
						}*/
						
						
						// phases
						$qph ="select id, title, bin, bintime, binuser from " . CO_TBL_PROJECTS_PHASES . " where pid = '$pid'";
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
								$qt ="select id, text, bin, bintime, binuser from " . CO_TBL_PROJECTS_PHASES_TASKS . " where phaseid = '$phid'";
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
							$qm ="select id, title, bin, bintime, binuser from " . CO_TBL_PROJECTS_MEETINGS . " where pid = '$pid'";
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
									$qmt ="select id, title, bin, bintime, binuser from " . CO_TBL_PROJECTS_MEETINGS_TASKS . " where mid = '$mid'";
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
						
						
						// analyses
						if(in_array("analyses",$active_modules)) {
							$qm ="select id, title, bin, bintime, binuser from " . CO_TBL_PROJECTS_ANALYSES . " where pid = '$pid'";
							$resultm = mysql_query($qm, $this->_db->connection);
							while ($rowm = mysql_fetch_array($resultm)) {
								$mid = $rowm["id"];
								if($rowm["bin"] == "1") { // deleted analyse
									foreach($rowm as $key => $val) {
										$analyse[$key] = $val;
									}
									$analyse["bintime"] = $this->_date->formatDate($analyse["bintime"],CO_DATETIME_FORMAT);
									$analyse["binuser"] = $this->_users->getUserFullname($analyse["binuser"]);
									$analyses[] = new Lists($analyse);
									$arr["analyses"] = $analyses;
								} else {
									// analyses_tasks
									$qmt ="select id, title, bin, bintime, binuser from " . CO_TBL_PROJECTS_ANALYSES_TASKS . " where mid = '$mid'";
									$resultmt = mysql_query($qmt, $this->_db->connection);
									while ($rowmt = mysql_fetch_array($resultmt)) {
										if($rowmt["bin"] == "1") { // deleted phases
											foreach($rowmt as $key => $val) {
												$analyses_task[$key] = $val;
											}
											$analyses_task["bintime"] = $this->_date->formatDate($analyses_task["bintime"],CO_DATETIME_FORMAT);
											$analyses_task["binuser"] = $this->_users->getUserFullname($analyses_task["binuser"]);
											$analyses_tasks[] = new Lists($analyses_task);
											$arr["analyses_tasks"] = $analyses_tasks;
										}
									}
								}
							}
						}


						// phonecalls
						if(in_array("phonecalls",$active_modules)) {
							$qpc ="select id, title, bin, bintime, binuser from " . CO_TBL_PROJECTS_PHONECALLS . " where pid = '$pid'";
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
							$qd ="select id, title, bin, bintime, binuser from " . CO_TBL_PROJECTS_DOCUMENTS_FOLDERS . " where pid = '$pid'";
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
									$qf ="select id, filename, bin, bintime, binuser from " . CO_TBL_PROJECTS_DOCUMENTS . " where did = '$did'";
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
							$qv ="select id, title, bin, bintime, binuser from " . CO_TBL_PROJECTS_VDOCS . " where pid = '$pid' and bin='1'";
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
			if(CONSTANT('projects_'.$module.'_bin') == 1) {
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
				
				$qp ="select id, title, bin, bintime, binuser from " . CO_TBL_PROJECTS . " where folder = '$id'";
				$resultp = mysql_query($qp, $this->_db->connection);
				while ($rowp = mysql_fetch_array($resultp)) {
					$pid = $rowp["id"];
					if($rowp["bin"] == "1") { // deleted projects
						$this->deleteProject($pid);
					} else {
						
						// phases
						$projectsPhasesModel = new ProjectsPhasesModel();
						$qph ="select id, title, bin, bintime, binuser from " . CO_TBL_PROJECTS_PHASES . " where pid = '$pid'";
						$resultph = mysql_query($qph, $this->_db->connection);
						while ($rowph = mysql_fetch_array($resultph)) {
							$phid = $rowph["id"];
							if($rowph["bin"] == "1") { // deleted phases
								$projectsPhasesModel->deletePhase($phid);
								$arr["phases"] = "";
							} else {
								// tasks
								$qt ="select id, text, bin, bintime, binuser from " . CO_TBL_PROJECTS_PHASES_TASKS . " where phaseid = '$phid'";
								$resultt = mysql_query($qt, $this->_db->connection);
								while ($rowt = mysql_fetch_array($resultt)) {
									if($rowt["bin"] == "1") { // deleted phases
										$phtid = $rowt["id"];
										$projectsPhasesModel->deletePhaseTask($phtid);
										$arr["tasks"] = "";
									} 
								}
							}
						}


						// meetings
						if(in_array("meetings",$active_modules)) {
							$projectsMeetingsModel = new ProjectsMeetingsModel();
							$qm ="select id, title, bin, bintime, binuser from " . CO_TBL_PROJECTS_MEETINGS . " where pid = '$pid'";
							$resultm = mysql_query($qm, $this->_db->connection);
							while ($rowm = mysql_fetch_array($resultm)) {
								$mid = $rowm["id"];
								if($rowm["bin"] == "1") { // deleted meeting
									$projectsMeetingsModel->deleteMeeting($mid);
									$arr["meetings"] = "";
								} else {
									// meetings_tasks
									$qmt ="select id, title, bin, bintime, binuser from " . CO_TBL_PROJECTS_MEETINGS_TASKS . " where mid = '$mid'";
									$resultmt = mysql_query($qmt, $this->_db->connection);
									while ($rowmt = mysql_fetch_array($resultmt)) {
										if($rowmt["bin"] == "1") { // deleted phases
											$mtid = $rowmt["id"];
											$projectsMeetingsModel->deleteMeetingTask($mtid);
											$arr["meetings_tasks"] = "";
										}
									}
								}
							}
						}
						
						
						// phonecalls
						if(in_array("phonecalls",$active_modules)) {
							$projectsPhoncallsModel = new ProjectsPhonecallsModel();
							$qc ="select id, title, bin, bintime, binuser from " . CO_TBL_PROJECTS_PHONECALLS . " where pid = '$pid'";
							$resultc = mysql_query($qc, $this->_db->connection);
							while ($rowc = mysql_fetch_array($resultc)) {
								$cid = $rowc["id"];
								if($rowc["bin"] == "1") {
									$projectsPhoncallsModel->deletePhonecall($cid);
									$arr["phonecalls"] = "";
								}
							}
						}


						// documents_folder
						if(in_array("documents",$active_modules)) {
							$projectsDocumentsModel = new ProjectsDocumentsModel();
							$qd ="select id, title, bin, bintime, binuser from " . CO_TBL_PROJECTS_DOCUMENTS_FOLDERS . " where pid = '$pid'";
							$resultd = mysql_query($qd, $this->_db->connection);
							while ($rowd = mysql_fetch_array($resultd)) {
								$did = $rowd["id"];
								if($rowd["bin"] == "1") { // deleted meeting
									$projectsDocumentsModel->deleteDocument($did);
									$arr["documents_folders"] = "";
								} else {
									// files
									$qf ="select id, filename, bin, bintime, binuser from " . CO_TBL_PROJECTS_DOCUMENTS . " where did = '$did'";
									$resultf = mysql_query($qf, $this->_db->connection);
									while ($rowf = mysql_fetch_array($resultf)) {
										if($rowf["bin"] == "1") { // deleted phases
											$fid = $rowf["id"];
											$projectsDocumentsModel->deleteFile($fid);
											$arr["files"] = "";
										}
									}
								}
							}
						}
	
	
						// vdocs
						if(in_array("vdocs",$active_modules)) {
							$projectsVDocsModel = new ProjectsVDocsModel();
							$qv ="select id, title, bin, bintime, binuser from " . CO_TBL_PROJECTS_VDOCS . " where pid = '$pid'";
							$resultv = mysql_query($qv, $this->_db->connection);
							while ($rowv = mysql_fetch_array($resultv)) {
								$vid = $rowv["id"];
								if($rowv["bin"] == "1") {
									$projectsVDocsModel->deleteVDoc($vid);
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
		$q = "SELECT a.pid FROM co_projects_access as a, co_projects as b  WHERE a.pid=b.id and b.bin='0' and a.admins REGEXP '[[:<:]]" . $id . "[[:>:]]' ORDER by b.title ASC";
      	$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$perms[] = $row["pid"];
		}
		return $perms;
   }


   function getViewPerms($id) {
		global $session;
		$perms = array();
		$q = "SELECT a.pid FROM co_projects_access as a, co_projects as b WHERE a.pid=b.id and b.bin='0' and a.guests REGEXP '[[:<:]]" . $id. "[[:>:]]' ORDER by b.title ASC";
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
		/*if($this->isOwnerPerms($pid,$session->uid)) {
			$access = "owner";
		}*/
		if($session->isSysadmin()) {
			$access = "sysadmin";
		}
		return $access;
   }
   
   
   /*function isOwnerPerms($id,$uid) {
	   	$q = "SELECT id FROM co_projects where id = '$id' and created_user ='$uid'";
      	$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			return true;
		} else {
			return false;
		}
   }*/
   
   /*function isProjectOwner($uid) {
	   	$q = "SELECT id FROM co_projects where created_user = '$uid'";
      	$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			return true;
		} else {
			return false;
		}
   }*/
   
   
   function existUserProjectsWidgets() {
		global $session;
		$q = "select count(*) as num from " . CO_TBL_PROJECTS_DESKTOP_SETTINGS . " where uid='$session->uid'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_assoc($result);
		if($row["num"] < 1) {
			return false;
		} else {
			return true;
		}
	}
	
	
	function getUserProjectsWidgets() {
		global $session;
		$q = "select * from " . CO_TBL_PROJECTS_DESKTOP_SETTINGS . " where uid='$session->uid'";
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
			// AP/MS deren Phase "in Planung" oder "in Arbeit" ist UND das Projekt "in Arbeit" ist
			// AP: AP Verantwortliche der Admin/Sysadmin ist
			// MS: Admin/Sysadmin der Projektleiter ist
			$q ="select c.folder,a.pid,a.phaseid,a.cat,a.text,c.title as projectitle from " . CO_TBL_PROJECTS_PHASES_TASKS . " as a,  " . CO_TBL_PROJECTS_PHASES . " as b,  " . CO_TBL_PROJECTS . " as c where a.phaseid = b.id and a.pid = c.id and (b.status='0' or b.status='1') and a.status='0' and c.status='1' and a.cat != '2' and a.bin = '0' and b.bin = '0' and c.bin = '0' and a.enddate = '$tomorrow'" . $access . " and ((a.cat = '1' and c.management REGEXP '[[:<:]]" . $session->uid . "[[:>:]]') or (a.cat = '0' and a.team REGEXP '[[:<:]]" . $session->uid . "[[:>:]]'))";
			$result = mysql_query($q, $this->_db->connection);
			$reminders = "";
			while ($row = mysql_fetch_array($result)) {
				foreach($row as $key => $val) {
					$array[$key] = $val;
				}
				$string .= $array["folder"] . "," . $array["pid"] . "," . $array["phaseid"] . ",";
				$reminders[] = new Lists($array);
			}
		}

		// Kick off
		// Sysadmin ist projektleiter oder teammitglied
		// Admin ist projektleiter oder teammitglied
		$kickoffs = "";
		$array = "";
		if($skip == 0) {
			$q ="select c.folder,c.id as pid,c.title from " . CO_TBL_PROJECTS . " as c where bin = '0' and startdate = '$tomorrow'" . $access . " and (c.management REGEXP '[[:<:]]" . $session->uid . "[[:>:]]' or c.team REGEXP '[[:<:]]" . $session->uid . "[[:>:]]')";
			$result = mysql_query($q, $this->_db->connection);
			while ($row = mysql_fetch_array($result)) {
				foreach($row as $key => $val) {
					$array[$key] = $val;
				}
				$string .= $array["folder"] . "," . $array["pid"] . ",";
				$kickoffs[] = new Lists($array);
			}
		}


		$alerts = "";
		$array = "";
		if($skip == 0) {
			// AP/MS deren Phase "in Planung" oder "in Arbeit" ist UND das Projekt "in Arbeit" ist
			// AP: Admin/Sysadmin der AP Verantwortung hat
			// MS: Admin/Sysadmin der Projektleiter ist
			$q ="select c.folder,a.pid,a.phaseid,a.cat,a.text,c.title as projectitle from " . CO_TBL_PROJECTS_PHASES_TASKS . " as a,  " . CO_TBL_PROJECTS_PHASES . " as b,  " . CO_TBL_PROJECTS . " as c where a.phaseid = b.id and a.pid = c.id and (b.status='0' or b.status='1') and a.status='0' and c.status='1' and a.cat != '2' and a.bin = '0' and b.bin = '0' and c.bin = '0' and a.enddate < '$today'" . $access . " and ((a.cat = '1' and c.management REGEXP '[[:<:]]" . $session->uid . "[[:>:]]') or (a.cat = '0' and a.team REGEXP '[[:<:]]" . $session->uid . "[[:>:]]'))";
			$result = mysql_query($q, $this->_db->connection);
			while ($row = mysql_fetch_array($result)) {
				foreach($row as $key => $val) {
					$array[$key] = $val;
				}
				$string .= $array["folder"] . "," . $array["pid"] . "," . $array["phaseid"] . ",";
				$alerts[] = new Lists($array);
			}
		}


		// project notices for this user
		$q ="select a.id as pid,a.folder,a.title as projectitle,b.perm from " . CO_TBL_PROJECTS . " as a,  " . CO_TBL_PROJECTS_DESKTOP . " as b where a.id = b.pid and a.bin = '0' and b.uid = '$session->uid' and b.status = '0'";
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
		
		// projectlinks alerts
		$q ="select a.id as pid,a.folder,a.title as projectitle,b.id as noticeid, b.perm,b.phid,b.relid from " . CO_TBL_PROJECTS . " as a,  " . CO_TBL_PROJECTS_DESKTOP_PROJECTLINKS . " as b, " . CO_TBL_PROJECTS_PHASES . " as c WHERE a.id = b.pid and a.bin = '0' and b.phid = c.id and c.bin = '0' and b.uid = '$session->uid' and b.status = '0'";
		$result = mysql_query($q, $this->_db->connection);
		$projectlinks = "";
		$array = "";
		while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			$relid = $array["relid"];
			$phid = $array["phid"];
			$qr = "SELECT a.folder, a.title FROM " . CO_TBL_PROJECTS . " as a, " . CO_TBL_PROJECTS_PHASES . " as b  WHERE a.id = '$relid' and b.id = '$phid'";
			$resultr = mysql_query($qr, $this->_db->connection);
			if(mysql_num_rows($resultr) > 0) {
				$pl = mysql_fetch_object($resultr);
				$array["relfolder"] = $pl->folder;
				$array["reltitle"] = $pl->title;
	
				$string .= $array["folder"] . "," . $array["pid"] . ",";
				$projectlinks[] = new Lists($array);
			} else {
				// delete notices as project was deleted
				$nid = $array["noticeid"];
				$qn = "DELETE FROM " . CO_TBL_PROJECTS_DESKTOP_PROJECTLINKS . " WHERE id='$nid'";
				$resultn = mysql_query($qn, $this->_db->connection);
			}
		}

		if(!$this->existUserProjectsWidgets()) {
			$q = "insert into " . CO_TBL_PROJECTS_DESKTOP_SETTINGS . " set uid='$session->uid', value='$string'";
			$result = mysql_query($q, $this->_db->connection);
			$widgetaction = "open";
		} else {
			$row = $this->getUserProjectsWidgets();
			$id = $row["id"];
			if($string == $row["value"]) {
				$widgetaction = "";
			} else {
				$widgetaction = "open";
			}
			$q = "UPDATE " . CO_TBL_PROJECTS_DESKTOP_SETTINGS . " set value='$string' WHERE id = '$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		
		$arr = array("reminders" => $reminders, "kickoffs" => $kickoffs, "alerts" => $alerts, "notices" => $notices, "projectlinks" => $projectlinks, "widgetaction" => $widgetaction);
		return $arr;
   }

   
	function markNoticeRead($pid) {
		global $session, $date;
		$q ="UPDATE " . CO_TBL_PROJECTS_DESKTOP . " SET status = '1' WHERE uid = '$session->uid' and pid = '$pid'";
		$result = mysql_query($q, $this->_db->connection);
		return true;
	}
	
	function markNoticeDELETE($id) {
		global $session, $date;
		$q ="DELETE FROM " . CO_TBL_PROJECTS_DESKTOP_PROJECTLINKS . " WHERE  id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		return true;
	}
	
	
	function getNavModulesNumItems($id) {
		global $projects;
		$active_modules = array();
		foreach($projects->modules as $module => $value) {
			$active_modules[] = $module;
		}
		
		if(in_array("meetings",$active_modules)) {
			$projectsMeetingsModel = new ProjectsMeetingsModel();
			$data["projects_meetings_items"] = $projectsMeetingsModel->getNavNumItems($id);
		}
		if(in_array("phonecalls",$active_modules)) {
			$projectsPhonecallsModel = new ProjectsPhonecallsModel();
			$data["projects_phonecalls_items"] = $projectsPhonecallsModel->getNavNumItems($id);
		}
		if(in_array("documents",$active_modules)) {
			$projectsDocumentsModel = new ProjectsDocumentsModel();
			$data["projects_documents_items"] = $projectsDocumentsModel->getNavNumItems($id);
		}
		if(in_array("vdocs",$active_modules)) {
			$projectsVDocsModel = new ProjectsVDocsModel();
			$data["projects_vdocs_items"] = $projectsVDocsModel->getNavNumItems($id);
		}
		return $data;
	}


	function newCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "INSERT INTO " . CO_TBL_USERS_CHECKPOINTS . " SET uid = '$session->uid', date = '$date', app = 'projects', module = 'projects', app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

 	function updateCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "UPDATE " . CO_TBL_USERS_CHECKPOINTS . " SET date = '$date' WHERE uid = '$session->uid' and app = 'projects' and module = 'projects' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

 	function deleteCheckpoint($id){
		$q = "DELETE FROM " . CO_TBL_USERS_CHECKPOINTS . " WHERE uid = '$session->uid' and app = 'projects' and module = 'projects' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }


    function getCheckpointDetails($app,$module,$id){
		global $lang, $session, $projects;
		$row = "";
		if($app =='projects' && $module == 'projects') {
			$q = "SELECT title,folder FROM " . CO_TBL_PROJECTS . " WHERE id='$id' and bin='0'";
			$result = mysql_query($q, $this->_db->connection);
			$row = mysql_fetch_array($result);
			if(mysql_num_rows($result) > 0) {
				$row['checkpoint_app_name'] = $lang["PROJECT_TITLE"];
				$row['app_id_app'] = '0';
			}
			return $row;
		} else {
			$active_modules = array();
			foreach($projects->modules as $m => $v) {
					$active_modules[] = $m;
			}
			/*if($module == 'phases' && in_array("phases",$active_modules)) {
				include_once("modules/".$module."/config.php");
				include_once("modules/".$module."/lang/" . $session->userlang . ".php");
				include_once("modules/".$module."/model.php");
				$projectsPhasesModel = new ProjectsPhasesModel();
				$row = $projectsPhasesModel->getCheckpointDetails($id);
				return $row;
			}*/
			if($module == 'meetings' && in_array("meetings",$active_modules)) {
				include_once("modules/".$module."/config.php");
				include_once("modules/".$module."/lang/" . $session->userlang . ".php");
				include_once("modules/".$module."/model.php");
				$projectsMeetingsModel = new ProjectsMeetingsModel();
				$row = $projectsMeetingsModel->getCheckpointDetails($id);
				return $row;
			}
		}
   }


	function getGlobalSearch($term){
		global $system, $session, $projects;
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
		foreach($projects->modules as $m => $v) {
			$active_modules[] = $m;
		}
		
		// get folders
		/*if(!$session->isSysadmin()) {
			$q ="select a.id, a.title from " . CO_TBL_PROJECTS_FOLDERS . " as a where a.status='0' and a.bin = '0' and (SELECT count(*) FROM co_projects_access as b, co_projects as c WHERE (b.admins REGEXP '[[:<:]]" . $session->uid . "[[:>:]]' or b.guests REGEXP '[[:<:]]" . $session->uid . "[[:>:]]') and c.folder=a.id and b.pid=c.id) > 0 and title like '%$term%' ORDER BY title";
		} else {
			$q ="select a.id, a.title from " . CO_TBL_PROJECTS_FOLDERS . " as a where a.status='0' and a.bin = '0' and title like '%$term%' ORDER BY title";
		}
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			 $rows['value'] = $row['title'];
			 $rows['id'] = 'folders,' .$row['id']. ',0,0,projects';
			 $r[] = $rows;
		}*/
		
		// let's get all projects
		
		//$q = "SELECT id,folder,title FROM " . CO_TBL_PROJECTS . " WHERE bin='0'" . $access ."ORDER BY title";
		//$q = "SELECT id,folder,CONVERT(title USING latin1) as title FROM " . CO_TBL_PROJECTS . " WHERE title COLLATE utf8_bin like '%$term%') and  bin='0'" . $access ."ORDER BY title";
		$q = "SELECT id, folder, CONVERT(title USING latin1) as title FROM " . CO_TBL_PROJECTS . " WHERE title like '%$term%' and  bin='0'" . $access ."ORDER BY title";
		$result = mysql_query($q, $this->_db->connection);
		//$num=mysql_affected_rows();
		while($row = mysql_fetch_array($result)) {
			 $rows['value'] = htmlspecialchars_decode($row['title']);
			 $rows['id'] = 'projects,' .$row['folder']. ',' . $row['id'] . ',0,projects';
			 $r[] = $rows;
		}
		// loop through projects
		$q = "SELECT id, folder FROM " . CO_TBL_PROJECTS . " WHERE bin='0'" . $access ."ORDER BY title";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$pid = $row['id'];
			$folder = $row['folder'];
			$sql = "";
			$perm = $this->getProjectAccess($pid);
			if($perm == 'guest') {
				$sql = "and access = '1'";
			}
			
			// Phases
			$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_PROJECTS_PHASES . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
			$resultp = mysql_query($qp, $this->_db->connection);
			while($rowp = mysql_fetch_array($resultp)) {
				$rows['value'] = htmlspecialchars_decode($rowp['title']);
			 	$rows['id'] = 'phases,' .$folder. ',' . $pid . ',' .$rowp['id'].',projects';
			 	$r[] = $rows;
			}
			// Arbeitspakete
			// Phases
			$qp = "SELECT b.id,CONVERT(a.text USING latin1) as title FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as a, " . CO_TBL_PROJECTS_PHASES . " as b WHERE b.pid = '$pid' and a.phaseid = b.id and a.bin = '0' and b.bin = '0' $sql and a.text like '%$term%' ORDER BY a.text";
			$resultp = mysql_query($qp, $this->_db->connection);
			while($rowp = mysql_fetch_array($resultp)) {
				$rows['value'] = htmlspecialchars_decode($rowp['title']);
			 	$rows['id'] = 'phases,' .$folder. ',' . $pid . ',' .$rowp['id'].',projects';
			 	$r[] = $rows;
			}
			// Meetings
			if(in_array("meetings",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_PROJECTS_MEETINGS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'meetings,' .$folder. ',' . $pid . ',' .$rowp['id'].',projects';
					$r[] = $rows;
				}
				// Meeting Tasks
				$qp = "SELECT b.id,CONVERT(a.title USING latin1) as title FROM " . CO_TBL_PROJECTS_MEETINGS_TASKS . " as a, " . CO_TBL_PROJECTS_MEETINGS . " as b WHERE b.pid = '$pid' and a.mid = b.id and a.bin = '0' and b.bin = '0' $sql and a.title like '%$term%' ORDER BY a.title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'meetings,' .$folder. ',' . $pid . ',' .$rowp['id'].',projects';
					$r[] = $rows;
				}
			}
			// Phonecalls
			if(in_array("phonecalls",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_PROJECTS_PHONECALLS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'phonecalls,' .$folder. ',' . $pid . ',' .$rowp['id'].',projects';
					$r[] = $rows;
				}
			}
			// Doc Folders
			if(in_array("documents",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_PROJECTS_DOCUMENTS_FOLDERS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'documents,' .$folder. ',' . $pid . ',' .$rowp['id'].',projects';
					$r[] = $rows;
				}
				// Documents
				$qp = "SELECT b.id,CONVERT(a.filename USING latin1) as title FROM " . CO_TBL_PROJECTS_DOCUMENTS . " as a, " . CO_TBL_PROJECTS_DOCUMENTS_FOLDERS . " as b WHERE b.pid = '$pid' and a.did = b.id and a.bin = '0' and b.bin = '0' and a.filename like '%$term%' ORDER BY a.filename";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'documents,' .$folder. ',' . $pid . ',' .$rowp['id'].',projects';
					$r[] = $rows;
				}
			}
			// vDocs
			if(in_array("vdocs",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_PROJECTS_VDOCS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'vdocs,' .$folder. ',' . $pid . ',' .$rowp['id'].',projects';
					$r[] = $rows;
				}
			}
		}
		return json_encode($r);
	}


	function getProjectsSearch($term,$exclude){
		global $system, $session;
		$num=0;
		$access=" ";
		if(!$session->isSysadmin()) {
			$access = " and a.id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
	  	}
		
		$q = "SELECT a.id,a.title as label, (SELECT MIN(startdate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as startdate ,(SELECT MAX(enddate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as enddate FROM " . CO_TBL_PROJECTS . " as a WHERE a.id != '$exclude' and a.title like '%$term%' and  a.bin='0'" . $access ."ORDER BY a.title";
		
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
	
	
	function getProjectArray($string){
		$string = explode(",", $string);
		$total = sizeof($string);
		$items = '';
		
		if($total == 0) { 
			return $items; 
		}
		
		// check if user is available and build array
		$items_arr = "";
		foreach ($string as &$value) {
			$q = "SELECT id, title FROM ".CO_TBL_PROJECTS." where id = '$value' and bin='0'";
			$result = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result) > 0) {
				while($row = mysql_fetch_assoc($result)) {
					$items_arr[] = array("id" => $row["id"], "title" => $row["title"]);		
				}
			}
		}

		return $items_arr;
}
	
	function getLast10Projects() {
		global $session;
		$projects = $this->getProjectArray($this->getUserSetting("last-used-projects"));
	  return $projects;
	}
	
	
	function saveLastUsedProjects($id) {
		global $session;
		$string = $id . "," .$this->getUserSetting("last-used-projects");
		$string = rtrim($string, ",");
		$ids_arr = explode(",", $string);
		$res = array_unique($ids_arr);
		foreach ($res as $key => $value) {
			$ids_rtn[] = $value;
		}
		array_splice($ids_rtn, 7);
		$str = implode(",", $ids_rtn);
		
		$this->setUserSetting("last-used-projects",$str);
	  return true;
	}
	
	
	function toggleCosts($id,$status) {
		$q = "UPDATE " . CO_TBL_PROJECTS . " set setting_costs='$status' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	function toggleCurrency($id,$cur) {
		$q = "UPDATE " . CO_TBL_PROJECTS . " set setting_currency='$cur' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}

}

$projectsmodel = new ProjectsModel(); // needed for direct calls to functions eg echo $projectsmodel ->getProjectTitle(1);
?>
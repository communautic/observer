<?php

class TrainingsModel extends Model {
	// Get all Training Folders
   function getFolderList($sort) {
      global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("trainings-folder-sort-status");
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
				  		$sortorder = $this->getSortOrder("trainings-folder-sort-order");
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
				  		$sortorder = $this->getSortOrder("trainings-folder-sort-order");
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
			$q ="select a.id, a.title from " . CO_TBL_TRAININGS_FOLDERS . " as a where a.status='0' and a.bin = '0' and (SELECT count(*) FROM co_trainings_access as b, co_trainings as c WHERE (b.admins REGEXP '[[:<:]]" . $session->uid . "[[:>:]]' or b.guests REGEXP '[[:<:]]" . $session->uid . "[[:>:]]') and c.folder=a.id and b.pid=c.id) > 0 " . $order;
		} else {
			$q ="select a.id, a.title from " . CO_TBL_TRAININGS_FOLDERS . " as a where a.status='0' and a.bin = '0' " . $order;
		}
		
	  $this->setSortStatus("trainings-folder-sort-status",$sortcur);
      $result = mysql_query($q, $this->_db->connection);
	  $folders = "";
	  while ($row = mysql_fetch_array($result)) {
		foreach($row as $key => $val) {
			$array[$key] = $val;
			if($key == "id") {
			$array["numTrainings"] = $this->getNumTrainings($val);
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
   * get details for the training folder
   */
   function getFolderDetails($id) {
		global $session, $contactsmodel, $trainingsControllingModel, $lang;
		$q = "SELECT * FROM " . CO_TBL_TRAININGS_FOLDERS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_assoc($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		$array["alltrainings"] = $this->getNumTrainings($id);
		$array["plannedtrainings"] = $this->getNumTrainings($id, $status="0");
		$array["activetrainings"] = $this->getNumTrainings($id, $status="1");
		$array["inactivetrainings"] = $this->getNumTrainings($id, $status="2");
		$array["stoppedtrainings"] = $this->getNumTrainings($id, $status="3");
		
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
		
		// get training details
		$access="";
		if(!$session->isSysadmin()) {
			$access = " and id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
	  	}
		
		 $sortstatus = $this->getSortStatus("trainings-sort-status",$id);
		if(!$sortstatus) {
		  	$order = "order by date1";
		  } else {
			  switch($sortstatus) {
				  case "1":
				  		$order = "order by date1";
				  break;
				  case "2":
				  		$order = "order by date1 DESC";
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("trainings-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by date1";
						  } else {
							$order = "order by field(id,$sortorder)";
						  }
				  break;	
			  }
		  }
		
		
		$q = "SELECT * FROM " . CO_TBL_TRAININGS . " where folder='$id' and bin='0'" . $access . " " . $order;

		$result = mysql_query($q, $this->_db->connection);
	  	$trainings = "";
	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$training[$key] = $val;
			}
			$training["team"] = $contactsmodel->getUserListPlain($training['team']);
			$training["perm"] = $this->getTrainingAccess($training["id"]);
			
			$training["dates_display"] = "";
			switch($training["training"]) {
				case '1': // Vortrag
					$training["date1"] = $this->_date->formatDate($training["date1"],CO_DATE_FORMAT);
					$training["dates_display"] = $training["date1"];
				break;
				case '2': // Vortrag & Coaching
					$training["date1"] = $this->_date->formatDate($training["date1"],CO_DATE_FORMAT);
					$training["date2"] = $this->_date->formatDate($training["date2"],CO_DATE_FORMAT);
					$training["dates_display"] = $training["date1"] . ' - ' . $training["date2"];
				break;
				case '3': // e-training
					$training["date1"] = $this->_date->formatDate($training["date1"],CO_DATE_FORMAT);
					$training["date3"] = $this->_date->formatDate($training["date3"],CO_DATE_FORMAT);
					$training["dates_display"] = $training["date1"] . ' - ' . $training["date3"];
				break;
				case '4': // e-training & Coaching
					$training["date1"] = $this->_date->formatDate($training["date1"],CO_DATE_FORMAT);
					$training["date2"] = $this->_date->formatDate($training["date2"],CO_DATE_FORMAT);
					$training["dates_display"] = $training["date1"] . ' - ' . $training["date2"];
				break;
				case '5': // einzelcoaching
					$training["date1"] = $this->_date->formatDate($training["date1"],CO_DATE_FORMAT);
					$training["dates_display"] = $training["date1"];
				break;
				case '6': // workshop
					$training["date1"] = $this->_date->formatDate($training["date1"],CO_DATE_FORMAT);
					$training["dates_display"] = $training["date1"];
				break;
				case '7': // veranstaltungsreihe
					$training["date1"] = $this->_date->formatDate($training["date1"],CO_DATE_FORMAT);
					$training["date2"] = $this->_date->formatDate($training["date2"],CO_DATE_FORMAT);
					$training["dates_display"] = $training["date1"] . ' - ' . $training["date2"];
				break;
			}
			
		switch($training["status"]) {
			case "0":
				$training["status_text"] = $lang["GLOBAL_STATUS_PLANNED"];
				$training["status_text_time"] = $lang["GLOBAL_STATUS_PLANNED_TIME"];
				$training["status_date"] = $this->_date->formatDate($training["planned_date"],CO_DATE_FORMAT);
			break;
			case "1":
				$training["status_text"] = $lang["GLOBAL_STATUS_INACTION"];
				$training["status_text_time"] = $lang["GLOBAL_STATUS_INACTION_TIME"];
				$training["status_date"] = $this->_date->formatDate($training["inprogress_date"],CO_DATE_FORMAT);
			break;
			case "2":
				$training["status_text"] = $lang["GLOBAL_STATUS_FINISHED2"];
				$training["status_text_time"] = $lang["GLOBAL_STATUS_FINISHED2_TIME"];
				$training["status_date"] = $this->_date->formatDate($training["finished_date"],CO_DATE_FORMAT);
			break;
			case "3":
				$training["status_text"] = $lang["GLOBAL_STATUS_STOPPED"];
				$training["status_text_time"] = $lang["GLOBAL_STATUS_STOPPED_TIME"];
				$training["status_date"] = $this->_date->formatDate($training["stopped_date"],CO_DATE_FORMAT);
			break;
		}
			
			$trainings[] = new Lists($training);
	  	}
		
		$access = "guest";
		  if($session->isSysadmin()) {
			  $access = "sysadmin";
		  }
		
		$arr = array("folder" => $folder, "trainings" => $trainings, "access" => $access);
		return $arr;
   }


function getFolderDetailsMultiView($id, $view, $width=17) {
		global $session, $contactsmodel, $trainingsControllingModel;
		$now = new DateTime("now");
		$today = $now->format('Y-m-d');
		
		if($width == 0) {
		  $zoom = $this->getUserSetting("trainings-multiview-chart-zoom");
		  if(!$zoom) {
			$width = 17;
		  } else {
			$width = $zoom;
		  }
		} else {
			$width = $width;
		}
		$this->setUserSetting("trainings-multiview-chart-zoom",$width);
		
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
		
		$q = "SELECT * FROM " . CO_TBL_TRAININGS_FOLDERS . " where id = '$id'";
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

		// get training details
		$access="";
		if(!$session->isSysadmin()) {
			$access = " and a.id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
	  	}
		
		$start = array();
		$q = "SELECT MIN(date1) as startdate,GREATEST(date1,date2,date3) as enddate FROM " . CO_TBL_TRAININGS . " as a where a.folder='$id' and a.bin='0'" . $access . " ORDER BY startdate ASC";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			while ($row = mysql_fetch_array($result)) {
				/*if($row['startdate'] == '') {
					$start[] = $row['kickoff'];
				} else {*/
					$start[] = $row['startdate'];
				//}
			}
		
			$array["startdate"] = min($start);
		} else {
			return false;
		}
		
		switch($view) {
			case 'Timeline':
				$order = "date1 ASC";
			break;
			case 'Management':
				$order = "name ASC";
			break;
			case 'Status':
				$order = "status ASC";
			break;
		}
				
		$q = "SELECT a.title,a.id,a.team,a.status,a.date1,a.date2,a.date3,a.training, (SELECT CONCAT(c.lastname,' ', SUBSTRING(c.firstname,1,1),'.') FROM co_users as c WHERE a.team = c.id) as name FROM " . CO_TBL_TRAININGS . " as a where a.folder='$id' and a.bin='0'" . $access . " ORDER BY " . $order;
		$result = mysql_query($q, $this->_db->connection);
	  	$trainings = "";
		
		$end = array();
		$css_top = 11;
		$numTrainings = mysql_num_rows($result);

	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$training[$key] = $val;
			}
			/*$training["kickoff_only"] = false;
			if($training["enddate"] == '') {
				$training["enddate"] = $training["kickoff"];
			}
			$end[] = $training["enddate"];
			if($training["startdate"] == '') {
				$training["startdate"] = $training["kickoff"];
				$training["kickoff_only"] = true;
				$training["kickoff_space"] = round($width/2)-8;
			}*/
			
			switch($training["training"]) {
				case '1': // Vortrag
					$training["startdate"] = $training["date1"];
					$training["enddate"] = $training["date1"];
					$end[] = $training["enddate"];
					$training["date1"] = $this->_date->formatDate($training["date1"],CO_DATE_FORMAT);
					$training["dates_display"] = $training["date1"];
				break;
				case '2': // Vortrag & Coaching
					$training["startdate"] = $training["date1"];
					$training["enddate"] = $training["date2"];
					$end[] = $training["enddate"];
					$training["date1"] = $this->_date->formatDate($training["date1"],CO_DATE_FORMAT);
					$training["date2"] = $this->_date->formatDate($training["date2"],CO_DATE_FORMAT);
					$training["dates_display"] = $training["date1"] . ' - ' . $training["date2"];
				break;
				case '3': // e-training
					$training["startdate"] = $training["date1"];
					$training["enddate"] = $training["date3"];
					$end[] = $training["enddate"];
					$training["date1"] = $this->_date->formatDate($training["date1"],CO_DATE_FORMAT);
					$training["date3"] = $this->_date->formatDate($training["date3"],CO_DATE_FORMAT);
					$training["dates_display"] = $training["date1"] . ' - ' . $training["date3"];
				break;
				case '4': // e-training & Coaching
					$training["startdate"] = $training["date1"];
					$training["enddate"] = $training["date2"];
					$end[] = $training["enddate"];
					$training["date1"] = $this->_date->formatDate($training["date1"],CO_DATE_FORMAT);
					$training["date2"] = $this->_date->formatDate($training["date2"],CO_DATE_FORMAT);
					$training["dates_display"] = $training["date1"] . ' - ' . $training["date2"];
				break;
				case '5': // einzelcoaching
					$training["startdate"] = $training["date1"];
					$training["enddate"] = $training["date1"];
					$end[] = $training["enddate"];
					$training["date1"] = $this->_date->formatDate($training["date1"],CO_DATE_FORMAT);
					$training["dates_display"] = $training["date1"];
				break;
				case '6': // workshop
					$training["startdate"] = $training["date1"];
					$training["enddate"] = $training["date1"];
					$end[] = $training["enddate"];
					$training["date1"] = $this->_date->formatDate($training["date1"],CO_DATE_FORMAT);
					$training["dates_display"] = $training["date1"];
				break;
				case '7': // workshop
					$training["startdate"] = $training["date1"];
					$training["enddate"] = $training["date2"];
					$end[] = $training["enddate"];
					$training["date1"] = $this->_date->formatDate($training["date1"],CO_DATE_FORMAT);
					$training["date2"] = $this->_date->formatDate($training["date2"],CO_DATE_FORMAT);
					$training["dates_display"] = $training["date1"] . ' - ' . $training["date2"];
				break;
				//case '7': // veranstaltungsreihe
					//$training["dates_display"] = $training["text1"];
				//break;
			}
			
			$pid = $training["id"];
			$training["days"] = $this->_date->dateDiff($training["startdate"],$training["enddate"])+1;
			$training_start = $this->_date->dateDiff($array["startdate"],$training["startdate"]);
			$training["css_left"] = $training_start * $width;
			
			$training["startdate"] = $this->_date->formatDate($training["startdate"],CO_DATE_FORMAT);
			$training["enddate"] = $this->_date->formatDate($training["enddate"],CO_DATE_FORMAT);
			$training["management"] = $contactsmodel->getUserListPlain($training['team']);
			//$training["realisation"] = $trainingsControllingModel->getChart($training["id"], "realisation", 0);
			$training["perm"] = $this->getTrainingAccess($training["id"]);
			$training["css_top"] = $css_top;
			$training["css_width"] = ($training["days"]) * $width;
			
			switch($training["status"]) {
				case "0":
					$training["status"] = "barchart_color_planned";
				break;
				case "1":
					$training["status"] = "barchart_color_inprogress";
				break;
				case "2":
					$training["status"] = "barchart_color_finished";
				break;
				case "3":
					$training["status"] = "barchart_color_not_finished";
				break;
			}
			
			// tasks loop			
			
			
			$trainings[] = new Lists($training);
			$css_top =  $css_top+38;
	  	}

		$array["days"] = $this->_date->dateDiff($array["startdate"],max($end));
		$array["css_width"] = ($array["days"]+1) * $width;
		$array["css_height"] = $numTrainings*38; // pixel add at bottom
		//$training["css_height"] += $space_between_phases;
		
		$folder = new Lists($array);
		
		$access = "guest";
		  if($session->isSysadmin()) {
			  $access = "sysadmin";
		  }
		
		$arr = array("folder" => $folder, "trainings" => $trainings, "access" => $access);
		return $arr;
   }

   /**
   * get details for the training folder
   */
   function setFolderDetails($id,$title,$trainingstatus) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_TRAININGS_FOLDERS . " set title = '$title', status = '$trainingstatus', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }


   /**
   * create new training folder
   */
	function newFolder() {
		global $session, $lang;
		$now = gmdate("Y-m-d H:i:s");
		$title = $lang["TRAINING_FOLDER_NEW"];
		
		$q = "INSERT INTO " . CO_TBL_TRAININGS_FOLDERS . " set title = '$title', status = '0', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	$id = mysql_insert_id();
			return $id;
		}
	}


   /**
   * delete training folder
   */
   function binFolder($id) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_TRAININGS_FOLDERS . " set bin = '1', bintime = '$now', binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   
   function restoreFolder($id) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_TRAININGS_FOLDERS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deleteFolder($id) {
		$q = "SELECT id FROM " . CO_TBL_TRAININGS . " where folder = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$pid = $row["id"];
			$this->deleteTraining($pid);
		}
		
		$q = "DELETE FROM " . CO_TBL_TRAININGS_FOLDERS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


  /**
   * get number of trainings for a training folder
   * status: 0 = all, 1 = active, 2 = abgeschlossen
   */   
   function getNumTrainings($id, $status="") {
		global $session;
		
		$access = "";
		 if(!$session->isSysadmin()) {
			$access = " and id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
		  }
		
		if($status == "") {
			$q = "select id from " . CO_TBL_TRAININGS . " where folder='$id' " . $access . " and bin != '1'";
		} else {
			$q = "select id from " . CO_TBL_TRAININGS . " where folder='$id' " . $access . " and status = '$status' and bin != '1'";
		}
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_num_rows($result);
		return $row;
	}


	function getTrainingTitle($id){
		global $session;
		$q = "SELECT title FROM " . CO_TBL_TRAININGS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		return $title;
   }


   	function getTrainingTitleFromIDs($array){
		//$string = explode(",", $string);
		$total = sizeof($array);
		$data = '';
		
		if($total == 0) { 
			return $data; 
		}
		
		// check if training is available and build array
		$arr = array();
		foreach ($array as &$value) {
			$q = "SELECT id,title FROM " . CO_TBL_TRAININGS . " where id = '$value' and bin='0'";
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


	function getTrainingTitleLinkFromIDs($array,$target){
		$total = sizeof($array);
		$data = '';
		if($total == 0) { 
			return $data; 
		}
		$arr = array();
		$i = 0;
		foreach ($array as &$value) {
			$q = "SELECT id,folder,title FROM " . CO_TBL_TRAININGS . " where id = '$value' and bin='0'";
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
			$data .= '<a class="externalLoadThreeLevels" rel="' . $target. ','.$value["folder"].','.$value["id"].',1,trainings">' . $value["title"] . '</a>';
			if($i < $arr_total) {
				$data .= '<br />';
			}
			$data .= '';	
			$i++;
		}
		return $data;
   }


function getTrainingTitleFromMeetingIDs($array,$target, $link = 0){
		$total = sizeof($array);
		$data = '';
		if($total == 0) { 
			return $data; 
		}
		$arr = array();
		$i = 0;
		foreach ($array as &$value) {
			$qm = "SELECT pid,created_date FROM " . CO_TBL_TRAININGS_MEETINGS . " where id = '$value' and bin='0'";
			$resultm = mysql_query($qm, $this->_db->connection);
			if(mysql_num_rows($resultm) > 0) {
				$rowm = mysql_fetch_row($resultm);
				$pid = $rowm[0];
				$date = $this->_date->formatDate($rowm[1],CO_DATETIME_FORMAT);
				$q = "SELECT id,folder,title FROM " . CO_TBL_TRAININGS . " where id = '$pid' and bin='0'";
				$result = mysql_query($q, $this->_db->connection);
				if(mysql_num_rows($result) > 0) {
					while($row = mysql_fetch_assoc($result)) {
						$arr[$i]["id"] = $row["id"];
						$arr[$i]["item"] = $value;
						$arr[$i]["access"] = $this->getTrainingAccess($row["id"]);
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
				$data .= '<a class="externalLoadThreeLevels" rel="' . $target. ','.$value["folder"].','.$value["id"].',' . $value["item"] . ',trainings">' . $value["title"] . '</a>';
			}
			if($i < $arr_total) {
				$data .= '<br />';
			}
			$data .= '';	
			$i++;
		}
		return $data;
   }

   	function getTrainingField($id,$field){
		global $session;
		$q = "SELECT $field FROM " . CO_TBL_TRAININGS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		return $title;
   }


  /**
   * get the list of trainings for a training folder
   */ 
   function getTrainingList($id,$sort) {
      global $session;
	  
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("trainings-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("trainings-sort-order",$id);
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
				  		$sortorder = $this->getSortOrder("trainings-sort-order",$id);
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
	  $q ="select id,title,status,checked_out,checked_out_user from " . CO_TBL_TRAININGS . " where folder='$id' and bin = '0' " . $access . $order;

	  $this->setSortStatus("trainings-sort-status",$sortcur,$id);
      $result = mysql_query($q, $this->_db->connection);
	  $trainings = "";
	  while ($row = mysql_fetch_array($result)) {
		foreach($row as $key => $val) {
			$array[$key] = $val;
			if($key == "id") {
				if($this->getTrainingAccess($val) == "guest") {
					$array["access"] = "guest";
					$array["iconguest"] = ' icon-guest-active"';
					$array["checked_out_status"] = "";
				} else {
					$array["iconguest"] = '';
					$array["access"] = "";
				}
			}
			
		}
		
		//$array["date1"] = $this->_date->formatDate($array["date1"],CO_DATE_FORMAT);
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
				$this->checkinTrainingOverride($id);
			}
		}
		$array["checked_out_status"] = $checked_out_status;
		
		$trainings[] = new Lists($array);
	  }
	  $arr = array("trainings" => $trainings, "sort" => $sortcur);
	  return $arr;
   }
	
	
	function checkoutTraining($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_TRAININGS . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function checkinTraining($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_TRAININGS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_TRAININGS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}
	
	function checkinTrainingOverride($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_TRAININGS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	

   function getTrainingDetails($id,$option = "") {
		global $session, $contactsmodel, $lang;
		$q = "SELECT * FROM " . CO_TBL_TRAININGS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		// perms
		$array["access"] = $this->getTrainingAccess($id);
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
			// check if this user is admin in some other training
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
					$array["canedit"] = $this->checkoutTraining($id);
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
					$array["checked_out_user_phone1"] = $contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
					$array["checked_out_user_email"] = $contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");
				}
			} else {
				$array["canedit"] = $this->checkoutTraining($id);
			}
		} // EOF perms
		
		// dates
		
		/*$today = date("Y-m-d");
		if($today < $array["startdate"]) {
			$today = $array["startdate"];
		}*/
		
		
		$array["registration_end"] = $this->_date->formatDate($array["registration_end"],CO_DATE_FORMAT);
		$array["date1"] = $this->_date->formatDate($array["date1"],CO_DATE_FORMAT);
		$array["date2"] = $this->_date->formatDate($array["date2"],CO_DATE_FORMAT);
		$array["date3"] = $this->_date->formatDate($array["date3"],CO_DATE_FORMAT);
		
		$array["time1"] = $this->_date->formatDate($array["time1"],CO_TIME_FORMAT);
		$array["time2"] = $this->_date->formatDate($array["time2"],CO_TIME_FORMAT);
		$array["time3"] = $this->_date->formatDate($array["time3"],CO_TIME_FORMAT);
		$array["time4"] = $this->_date->formatDate($array["time4"],CO_TIME_FORMAT);
		
		$array["place1"] = $contactsmodel->getPlaceList($array['place1'],'place1', $array["canedit"]);
		$array["place1_ct"] = empty($array["place1_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['place1_ct'];
		$array["place2"] = $contactsmodel->getPlaceList($array['place2'],'place2', $array["canedit"]);
		$array["place2_ct"] = empty($array["place2_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['place2_ct'];

		$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
		
		// other functions
		$array["folder_id"] = $array["folder"];
		$array["folder"] = $this->getTrainingFolderDetails($array["folder"],"folder");
		$array["management_print"] = $contactsmodel->getUserListPlain($array['management']);
		$array["management"] = $contactsmodel->getUserList($array['management'],'trainingsmanagement', "", $array["canedit"]);
		$array["management_ct"] = empty($array["management_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['management_ct'];
		$array["team_print"] = $contactsmodel->getUserListPlain($array['team']);
		if($option = 'prepareSendTo') {
			$array["sendtoTeam"] = $contactsmodel->checkUserListEmail($array["team"],'trainings', "", $array["canedit"]);
			$array["sendtoTeamNoEmail"] = $contactsmodel->checkUserListEmail($array["team"],'trainings', "", $array["canedit"], 0);
			$array["sendtoError"] = false;
		}
		$array["team"] = $contactsmodel->getUserList($array['team'],'trainingsteam', "", $array["canedit"]);
		$array["team_ct"] = empty($array["team_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['team_ct'];
		$array["training_id"] = $array["training"];
		$array["training"] = $this->getTrainingIdDetails($array["training"],"trainingstraining");
		
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		$array["current_user"] = $session->uid;
		
		$array["status_planned_active"] = "";
		$array["status_inprogress_active"] = "";
		$array["status_finished_active"] = "";
		$array["status_stopped_active"] = "";
		$array["member_status_default_css"] = "";
		switch($array["status"]) {
			case "0":
				$array["status_text"] = $lang["GLOBAL_STATUS_PLANNED"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_PLANNED_TIME"];
				$array["status_planned_active"] = " active";
				$array["status_date"] = $this->_date->formatDate($array["planned_date"],CO_DATE_FORMAT);
				//$array["enddate"] = $this->_date->formatDate($today,CO_DATE_FORMAT);
			break;
			case "1":
				$array["status_text"] = $lang["GLOBAL_STATUS_INACTION"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_INACTION_TIME"];
				$array["status_inprogress_active"] = " active";
				$array["status_date"] = $this->_date->formatDate($array["inprogress_date"],CO_DATE_FORMAT);
				//$array["enddate"] = $this->_date->formatDate($today,CO_DATE_FORMAT);
			break;
			case "2":
				$array["status_text"] = $lang["GLOBAL_STATUS_FINISHED2"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_FINISHED2_TIME"];
				$array["status_finished_active"] = " active";
				$array["status_date"] = $this->_date->formatDate($array["finished_date"],CO_DATE_FORMAT);
				//$array["enddate"] = $array["status_date"];
				$array["member_status_default_css"] = "incomplete";
			break;
			case "3":
				$array["status_text"] = $lang["GLOBAL_STATUS_STOPPED"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_STOPPED_TIME"];
				$array["status_stopped_active"] = " active";
				$array["status_date"] = $this->_date->formatDate($array["stopped_date"],CO_DATE_FORMAT);
				//$array["enddate"] = $array["status_date"];
				$array["member_status_default_css"] = "incomplete";
			break;
		}
		
		// checkpoint
		$array["checkpoint"] = 0;
		$array["checkpoint_date"] = "";
		$array["checkpoint_note"] = "";
		$q = "SELECT date,note FROM " . CO_TBL_USERS_CHECKPOINTS . " where uid='$session->uid' and app = 'trainings' and module = 'trainings' and app_id = '$id' LIMIT 1";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			while ($row = mysql_fetch_assoc($result)) {
			$array["checkpoint"] = 1;
			$array["checkpoint_date"] = $this->_date->formatDate($row['date'],CO_DATE_FORMAT);
			$array["checkpoint_note"] = $row['note'];
			}
		}
		
		
		
		/*$sql="";
		if($array["access"] == "guest") {
			$sql = " and a.access = '1' ";
		}*/
		
		// get the members
		$member = array();
		$qt = "SELECT a.*,CONCAT(b.lastname,', ',b.firstname) as name FROM " . CO_TBL_TRAININGS_MEMBERS . " as a, co_users as b where a.cid=b.id and a.pid = '$id' and a.bin='0' and b.bin='0' ORDER BY name";
		$resultt = mysql_query($qt, $this->_db->connection);
		$array["num_members"] = mysql_num_rows($resultt);
		$training = new Lists($array);
		while($rowt = mysql_fetch_array($resultt)) {
			foreach($rowt as $key => $val) {
				$members[$key] = $val;
			}
			$members['invitation_class'] = '';
			if($members['invitation'] == 1) {
				$members['invitation_class'] = 'active';
			}
			$members['registration_class'] = '';
			if($members['registration'] == 1) {
				$members['registration_class'] = 'active';
			}
			if($members['registration'] == 2) {
				$members['registration_class'] = 'deactive';
			}
			$members['tookpart_class'] = '';
			if($members['tookpart'] == 1) {
				$members['tookpart_class'] = 'active';
			}
			if($members['tookpart'] == 2) {
				$members['tookpart_class'] = 'deactive';
			}
			$members['feedback_class'] = '';
			if($members['feedback'] == 1) {
				$members['feedback_class'] = 'active';
				if(empty($members['feedback_q1']) || empty($members['feedback_q2']) || empty($members['feedback_q3']) || empty($members['feedback_q4']) || empty($members['feedback_q5'])) {
					$members['feedback_class'] = 'deactive';
				}
			}
			
			
			// get member logs
			$mid = $members['id'];
			$member_log = array();
			$members['logs'] = array();
			$ql = "SELECT * FROM " . CO_TBL_TRAININGS_MEMBERS_LOG . " WHERE mid='$mid' ORDER by date DESC";
			$resultl = mysql_query($ql, $this->_db->connection);
			while($rowl = mysql_fetch_array($resultl)) {
				foreach($rowl as $k => $v) {
					$member_log[$k] = $v;
				}
				$member_log['date'] = $this->_date->formatDate($member_log['date'],CO_DATETIME_FORMAT);
				$member_log['who'] = $contactsmodel->getUserListPlain($member_log['who']);
				
				
				$members['logs'][] = new Lists($member_log);
			}
			
			
			$member[] = new Lists($members);
		}
		
		$sendto = $this->getSendtoDetails("trainings",$id);
		
		$arr = array("training" => $training, "members" => $member, "sendto" => $sendto, "access" => $array["access"]);
		return $arr;
   }


   // Create training folder title
	function getTrainingFolderDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			$q = "SELECT id, title from " . CO_TBL_TRAININGS_FOLDERS . " where id = '$value'";
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
   
   
   	function getTrainingIdDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			$q = "SELECT id, name from " . CO_TBL_TRAININGS_DIALOG . " where id = '$value'";
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
   
   
   	/*function getTrainingMoreIdDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			$q = "SELECT id, name from " . CO_TBL_TRAININGS_DIALOG_TRAININGS_MORE . " where id = '$value'";
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
   }*/
   
   
	/*function getTrainingCatDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			$q = "SELECT id, name from " . CO_TBL_TRAININGS_DIALOG_CATS . " where id = '$value'";
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
   
   
	function getTrainingCatMoreDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			$q = "SELECT id, name from " . CO_TBL_TRAININGS_DIALOG_CATS_MORE . " where id = '$value'";
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
   }*/


   /**
   * get details for the training folder
   */
   function setTrainingDetails($id,$title,$folder,$management,$management_ct,$company,$team,$team_ct,$trainer_details,$training,$registration_end,$protocol,$protocol1,$protocol2,$protocol3,$protocol4,$date1,$date2,$date3,$time1,$time2,$time3,$time4,$place1,$place1_ct,$place2,$place2_ct,$text1,$text2,$text3) {
		global $session, $contactsmodel;
		$sql = "";
		if($time1 != '') { 
			$time1 = $this->_date->formatDateGMT($date1 . " " . $time1);
			$sql .= " time1 = '" . $time1 . "',";
		}
		if($time2 != '') { 
			$time2 = $this->_date->formatDateGMT($date1 . " " . $time2);
			$sql .= " time2 = '" . $time2 . "',";
		}
		if($time3 != '') { 
			$time3 = $this->_date->formatDateGMT($date2 . " " . $time3);
			$sql .= " time3 = '" . $time3 . "',";
		}
		if($time4 != '') { 
			$time4 = $this->_date->formatDateGMT($date2 . " " . $time4);
			$sql .= " time4 = '" . $time4 . "',";
		}
		if($date1 != '') { 
			$date1 = $this->_date->formatDate($_POST['date1']);
			$sql .= " date1 = '" . $date1 . "',";
		}
		if($date2 != '') { 
			$date2 = $this->_date->formatDate($_POST['date2']);
			$sql .= " date2 = '" . $date2 . "',";
		}
		if($date3 != '') { 
			$date3 = $this->_date->formatDate($_POST['date3']);
			$sql .= " date3 = '" . $date3 . "',";
		}
		if($registration_end != '') { 
			$registration_end = $this->_date->formatDate($_POST['registration_end']);
			$sql .= " registration_end = '" . $registration_end . "',";
		}
		
		// user lists
		$management = $contactsmodel->sortUserIDsByName($management);
		$team = $contactsmodel->sortUserIDsByName($team);

		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_TRAININGS . " set title = '$title', folder = '$folder', management = '$management', management_ct = '$management_ct', company='$company', team='$team', team_ct = '$team_ct' , trainer_details ='$trainer_details', training = '$training', protocol='$protocol', protocol1='$protocol1', protocol2='$protocol2', protocol3='$protocol3', protocol4='$protocol4',$sql place1 = '$place1', place1_ct = '$place1_ct', place2 = '$place2', place2_ct = '$place2_ct', text1 = '$text1', text2 = '$text2', text3 = '$text3', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
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
		
		$q = "UPDATE " . CO_TBL_TRAININGS . " set status = '$status', $sql = '$date', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}


	function newTraining($id) {
		global $session, $contactsmodel, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		$time_s = date("Y-m-d") . ' 08:00:00';
		$time_e = date("Y-m-d") . ' 17:00:00';
		$title = $lang["TRAINING_NEW"];
		
		$q = "INSERT INTO " . CO_TBL_TRAININGS . " set folder = '$id', title = '$title', date1 = '$now', date2 = '$now', date3 = '$now', time1 = '$time_s', time2 = '$time_e', time3 = '$time_s', time4 = '$time_e', management = '$session->uid', status = '0', planned_date = '$now', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			$id = mysql_insert_id();
			// if admin insert him to access
			if(!$session->isSysadmin()) {
				$trainingsAccessModel = new TrainingsAccessModel();
				$trainingsAccessModel->setDetails($id,$session->uid,"");
			}
			return $id;
		}
	}
	
	
	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		// training
		$q = "INSERT INTO " . CO_TBL_TRAININGS . " (folder,title,management,company,team,training,registration_end,protocol,date1,date2,date3,time1,time2,time3,time4,place1,place1_ct,place2,place2_ct,text1,text2,text3,planned_date,created_date,created_user,edited_date,edited_user) SELECT folder,CONCAT(title,' ".$lang["GLOBAL_DUPLICAT"]."'),management,company,team,training,registration_end,protocol,date1,date2,date3,time1,time2,time3,time4,place1,place1_ct,place2,place2_ct,text1,text2,text3,'$now','$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_TRAININGS . " where id='$id'";

		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		
		if(!$session->isSysadmin()) {
			$trainingsAccessModel = new TrainingsAccessModel();
			$trainingsAccessModel->setDetails($id_new,$session->uid,"");
		}
			
		// members
		$q = "SELECT id FROM " . CO_TBL_TRAININGS_MEMBERS . " WHERE pid = '$id' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$mid = $row["id"];
		
			$qg = "INSERT INTO " . CO_TBL_TRAININGS_MEMBERS . " (pid,cid) SELECT '$id_new',cid FROM " . CO_TBL_TRAININGS_MEMBERS . " where id='$mid'";
			$resultg = mysql_query($qg, $this->_db->connection);
			$gridid_new = mysql_insert_id();
		}
		
		if ($result) {
			return $id_new;
		}
	}


	function binTraining($id) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_TRAININGS . " set bin = '1', bintime = '$now', binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	function restoreTraining($id) {
		$q = "UPDATE " . CO_TBL_TRAININGS . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	function restoreMember($id) {
		$q = "UPDATE " . CO_TBL_TRAININGS_MEMBERS . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	function deleteMember($id) {
		// delete member log
		$qm = "DELETE FROM co_trainings_members_log WHERE mid='$id'";
		$resultm = mysql_query($qm, $this->_db->connection);
		// delete members
		$q = "DELETE FROM co_trainings_members WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
		  	return true;
		}
	}
	
	function deleteTraining($id) {
		global $trainings;
		
		$active_modules = array();
		foreach($trainings->modules as $module => $value) {
			if(CONSTANT('trainings_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
			}
		}
		// delete member log
		$q = "SELECT id FROM co_trainings_members where pid = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$mid = $row["id"];
			$qm = "DELETE FROM co_trainings_members_log WHERE mid='$mid'";
			$resultm = mysql_query($qm, $this->_db->connection);
		}
		// delete members
		$q = "DELETE FROM co_trainings_members WHERE pid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if(in_array("grids",$active_modules)) {
			$trainingsGridsModel = new TrainingsGridsModel();
			$q = "SELECT id FROM co_trainings_grids where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$mid = $row["id"];
				$trainingsGridsModel->deleteGrid($mid);
			}
		}

		if(in_array("forums",$active_modules)) {
			$trainingsForumsModel = new TrainingsForumsModel();
			$q = "SELECT id FROM co_trainings_forums where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$pid = $row["id"];
				$trainingsForumsModel->deleteForum($pid);
			}
		}
		
		
		if(in_array("meetings",$active_modules)) {
			$trainingsMeetingsModel = new TrainingsMeetingsModel();
			$q = "SELECT id FROM co_trainings_meetings where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$mid = $row["id"];
				$trainingsMeetingsModel->deleteMeeting($mid);
			}
		}

		if(in_array("phonecalls",$active_modules)) {
			$trainingsPhonecallsModel = new TrainingsPhonecallsModel();
			$q = "SELECT id FROM co_trainings_phonecalls where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$pcid = $row["id"];
				$trainingsPhonecallsModel->deletePhonecall($pcid);
			}
		}

		if(in_array("documents",$active_modules)) {
			$trainingsDocumentsModel = new TrainingsDocumentsModel();
			$q = "SELECT id FROM co_trainings_documents_folders where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$did = $row["id"];
				$trainingsDocumentsModel->deleteDocument($did);
			}
		}

		if(in_array("vdocs",$active_modules)) {
			$trainingsVDocsmodel = new TrainingsVDocsModel();
			$q = "SELECT id FROM co_trainings_vdocs where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$vid = $row["id"];
				$trainingsVDocsmodel->deleteVDoc($vid);
			}
		}


		$q = "DELETE FROM co_log_sendto WHERE what='trainings' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_USERS_CHECKPOINTS . " WHERE app = 'trainings' and module = 'trainings' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM co_trainings_access WHERE pid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_TRAININGS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
		  	return true;
		}
		
	}


   function moveTraining($id,$startdate,$movedays) {
		global $session, $contactsmodel;
		
		$startdate = $this->_date->formatDate($_POST['startdate']);
		
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_TRAININGS . " set startdate = '$startdate', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
			$qt = "SELECT id, startdate, enddate FROM " . CO_TBL_TRAININGS_PHASES_TASKS . " where pid='$id'";
			$resultt = mysql_query($qt, $this->_db->connection);
			while ($rowt = mysql_fetch_array($resultt)) {
				$tid = $rowt["id"];
				$startdate = $this->_date->addDays($rowt["startdate"],$movedays);
				$enddate = $this->_date->addDays($rowt["enddate"],$movedays);
				$qtk = "UPDATE " . CO_TBL_TRAININGS_PHASES_TASKS . " set startdate = '$startdate', enddate = '$enddate' where id='$tid'";
				$retvaltk = mysql_query($qtk, $this->_db->connection);
			}
		if ($result) {
			return true;
		}
	}


	function getTrainingFolderDialog($field,$title) {
		global $session;
		$str = '<div class="dialog-text">';
		//$q ="select id, title from " . CO_TBL_TRAININGS_FOLDERS . " where status='0' and bin = '0' ORDER BY title";
		if(!$session->isSysadmin()) {
			$q ="select a.id, a.title from " . CO_TBL_TRAININGS_FOLDERS . " as a where a.status='0' and a.bin = '0' and (SELECT count(*) FROM co_trainings_access as b, co_trainings as c WHERE (b.admins REGEXP '[[:<:]]" . $session->uid . "[[:>:]]' or b.guests REGEXP '[[:<:]]" . $session->uid . "[[:>:]]') and c.folder=a.id and b.pid=c.id) > 0 ORDER BY title";
		} else {
			$q ="select id, title from " . CO_TBL_TRAININGS_FOLDERS . " where status='0' and bin = '0' ORDER BY title";
		}
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$str .= '<a href="#" class="insertTrainingFolderfromDialog" title="' . $row["title"] . '" field="'.$field.'" gid="'.$row["id"].'">' . $row["title"] . '</a>';
		}
		$str .= '</div>';	
		return $str;
	 }


	function getTrainingDialog($field,$title) {
		global $session;
		$str = '<div class="dialog-text">';
		$q ="select id, name from " . CO_TBL_TRAININGS_DIALOG . " ORDER BY name ASC";
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$str .= '<a href="#" class="insertFromDialog" title="' . $row["name"] . '" field="'.$field.'" gid="'.$row["id"].'">' . $row["name"] . '</a>';
		}
		$str .= '</div>';	
		return $str;
	 }

	function getTrainingMoreDialog($field,$title) {
		global $session;
		$str = '<div class="dialog-text">';
		$q ="select id, name from " . CO_TBL_TRAININGS_DIALOG_TRAININGS_MORE . " ORDER BY name ASC";
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$str .= '<a href="#" class="insertFromDialog" title="' . $row["name"] . '" field="'.$field.'" gid="'.$row["id"].'">' . $row["name"] . '</a>';
		}
		$str .= '</div>';	
		return $str;
	 }
	 
	 
	function getTrainingCatDialog($field,$title) {
		global $session;
		$str = '<div class="dialog-text">';
		$q ="select id, name from " . CO_TBL_TRAININGS_DIALOG_CATS . " ORDER BY name ASC";
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$str .= '<a href="#" class="insertFromDialog" title="' . $row["name"] . '" field="'.$field.'" gid="'.$row["id"].'">' . $row["name"] . '</a>';
		}
		$str .= '</div>';	
		return $str;
	 }
	 
	function getTrainingCatMoreDialog($field,$title) {
		global $session;
		$str = '<div class="dialog-text">';
		$q ="select id, name from " . CO_TBL_TRAININGS_DIALOG_CATS_MORE . " ORDER BY name ASC";
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
	   $q = "SELECT COUNT(id) FROM " .  CO_TBL_TRAININGS_PHASES. " WHERE pid='$id' $sql and bin='0'";
	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function numPhasesOnTime($id) {
	   //$q = "SELECT COUNT(id) FROM " .  CO_TBL_TRAININGS_PHASES. " WHERE pid='$id' $sql and bin='0'";
	   $q = "SELECT a.id,(SELECT MAX(enddate) FROM " . CO_TBL_TRAININGS_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as enddate FROM " . CO_TBL_TRAININGS_PHASES . " as a where a.pid= '$id' and a.status='2' and a.finished_date <= enddate";

	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function numPhasesTasks($id,$status = 0,$sql="") {
	   //$sql = "";
	   if ($status == 1) {
		   $sql .= " and status='1' ";
	   }
	   $q = "SELECT COUNT(id) FROM " .  CO_TBL_TRAININGS_PHASES_TASKS. " WHERE pid='$id' $sql and bin='0'";
	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function getRest($value) {
		return round(100-$value,2);
   }


	function getChartFolder($id, $what) { 
		global $trainingsControllingModel, $lang;
		switch($what) {
			case 'stability':
				$chart = $this->getChartFolder($id, 'timeing');
				$timeing = $chart["real"];
				/*$chart = $this->getChartFolder($id, 'tasks');
				$tasks = $chart["real"];*/
				// all
				$q = "SELECT id FROM " . CO_TBL_TRAININGS. " WHERE folder = '$id' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$all = mysql_num_rows($result);
				
				// stopped
				$cancelled = 0;
				$q = "SELECT id FROM " . CO_TBL_TRAININGS. " WHERE folder = '$id' and status = '3' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$stopped = mysql_num_rows($result);
				if($all != 0) {
					$cancelled = round((100/$all)*$stopped,0);
				}				
				
				$chart["real"] = round(($timeing+$cancelled)/2,0);
				$chart["title"] = $lang["TRAINING_FOLDER_CHART_STABILITY"];
				$chart["img_name"] = "training_" . $id . "_stability.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?chs=150x90&cht=gm&chd=t:' . $chart["real"];
				
				$chart["tendency"] = "pixel.gif";
				//$chart["tendency"] = "tendency_negative.png";
				/*if($chart["real"] >= 50) {
					$chart["tendency"] = "tendency_positive.png";
				}*/
				
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				
			break;
			case 'realisation':
				//$num = 0;
				
				$q = "SELECT id FROM " . CO_TBL_TRAININGS. " WHERE folder = '$id' and status = '2' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$done = mysql_num_rows($result);
				
				$q = "SELECT id FROM " . CO_TBL_TRAININGS. " WHERE folder = '$id' and status != '2' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$notdone = mysql_num_rows($result);
				
				$num = $done + $notdone;
				//$num = $total/100*$done;
				
				if($num == 0) {
					$chart["real"] = 0;
				} else {
					$chart["real"] = round((100/$num)*$done,0);
				}
				$chart["tendency"] = "pixel.gif";
				//$qt = "SELECT MAX(donedate) as dt,enddate FROM " . CO_TBL_PROJECTS_PHASES_TASKS. " WHERE status='1' $id_array and bin='0'";
				//$resultt = mysql_query($qt, $this->_db->connection);
				/*$ten = mysql_fetch_assoc($resultt);
				if($ten["dt"] <= $ten["enddate"]) {
					$chart["tendency"] = "tendency_positive.png";
				}*/
				
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = $lang["TRAINING_FOLDER_CHART_REALISATION"];
				$chart["img_name"] = "training_" . $id . "_realisation.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
				
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
			break;
			

			case 'timeing':
				$q = "SELECT training,date1,date2,date3,finished_date FROM " . CO_TBL_TRAININGS. " WHERE folder = '$id' and status = '2' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$num = mysql_num_rows($result);
				$intime = 0;
				$delay = 0;
				while($row = mysql_fetch_assoc($result)) {
					switch($row["training"]) {
						case '1': // Vortrag
							if($row["date1"] >= $row["finished_date"]) {
								$intime++;
							} else {
								$delay++;
							}
						break;
						case '2': // Vortrag & Coaching
							if($row["date2"] >= $row["finished_date"]) {
								$intime++;
							} else {
								$delay++;
							}
						break;
						case '3': // e-training
							if($row["date3"] >= $row["finished_date"]) {
								$intime++;
							} else {
								$delay++;
							}
						break;
						case '4': // e-training & Coaching
							if($row["date2"] >= $row["finished_date"]) {
								$intime++;
							} else {
								$delay++;
							}
						break;
						case '5': // einzelcoaching
							if($row["date1"] >= $row["finished_date"]) {
								$intime++;
							} else {
								$delay++;
							}
						break;
						case '6': // workshop
							if($row["date1"] >= $row["finished_date"]) {
								$intime++;
							} else {
								$delay++;
							}
						break;
						case '7': // veranstaltungsreihe
							if($row["date2"] >= $row["finished_date"]) {
								$intime++;
							} else {
								$delay++;
							}
						break;
					}
				}
					
				if($num == 0) {
					$chart["real"] = 0;
				} else {
					$chart["real"] = round((100/$num)*$intime,0);
				}
				
				$today = date("Y-m-d");
				
				$chart["tendency"] = "pixel.gif";
				/*$qt = "SELECT COUNT(id) FROM " . CO_TBL_PROJECTS_PHASES_TASKS. " WHERE status='0' and startdate <= '$today' and enddate >= '$today' $id_array and bin='0'";
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
				}*/
				
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = $lang["TRAINING_FOLDER_CHART_ADHERANCE"];
				$chart["img_name"] = "training_" . $id . "_timeing.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
			
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
			break;
			
			case 'feedbacks':
				
				$q = "SELECT a.* FROM " . CO_TBL_TRAININGS_MEMBERS . " as a, " . CO_TBL_TRAININGS . " as b where b.folder = '$id' and a.pid=b.id and a.tookpart='1' and b.bin='0' and a.bin='0'";
				$result = mysql_query($q, $this->_db->connection);
				if(mysql_num_rows($result) < 1) {
					$members = 1;
				} else {
					$members = mysql_num_rows($result);
				}
				$total_result = 0;
				while ($row = mysql_fetch_array($result)) {
					if(!empty($row["feedback_q1"])) { $total_result += $row["feedback_q1"]; }
					if(!empty($row["feedback_q2"])) { $total_result += $row["feedback_q2"]; }
					if(!empty($row["feedback_q3"])) { $total_result += $row["feedback_q3"]; }
					if(!empty($row["feedback_q4"])) { $total_result += $row["feedback_q4"]; }
					if(!empty($row["feedback_q5"])) { $total_result += $row["feedback_q5"]; }
				}
				$chart["real"] = round((100/25*$total_result)/$members,0);
				
				/*if($num == 0) {
					$chart["real"] = 0;
				} else {
					$chart["real"] = round(($realisation)/$num,0);
				}*/
				
				$today = date("Y-m-d");
				
				//$chart["tendency"] = "tendency_positive.png";
				$chart["tendency"] = "pixel.gif";
				/*$qt = "SELECT status,donedate,enddate FROM " . CO_TBL_PROJECTS_PHASES_TASKS. " WHERE enddate < '$today' $id_array and bin='0' ORDER BY enddate DESC LIMIT 0,1";
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
				}*/
				
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = $lang["TRAINING_FOLDER_CHART_FEEDBACKS"];
				$chart["img_name"] = "training_" . $id . "_feedbacks.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
			
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				
			break;
			case 'status':

				// all
				$q = "SELECT id FROM " . CO_TBL_TRAININGS. " WHERE folder = '$id' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$all = mysql_num_rows($result);
				
				// planned
				$q = "SELECT id FROM " . CO_TBL_TRAININGS. " WHERE folder = '$id' and status = '0' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$planned = mysql_num_rows($result);
				$chart["planned"] = 0;
				if($planned != 0) {
					$chart["planned"] = round((100/$all)*$planned,0);
				}
				
				// inprogress
				$q = "SELECT id FROM " . CO_TBL_TRAININGS. " WHERE folder = '$id' and status = '1' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$inprogress = mysql_num_rows($result);
				$chart["inprogress"] = 0;
				if($inprogress != 0) {
					$chart["inprogress"] = round((100/$all)*$inprogress,0);
				}
				// finished
				$q = "SELECT id FROM " . CO_TBL_TRAININGS. " WHERE folder = '$id' and status = '2' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$finished = mysql_num_rows($result);
				$chart["finished"] = 0;
				if($finished != 0) {
					$chart["finished"] = round((100/$all)*$finished,0);
				}
				
				// stopped
				$q = "SELECT id FROM " . CO_TBL_TRAININGS. " WHERE folder = '$id' and status = '3' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$stopped = mysql_num_rows($result);
				$chart["stopped"] = 0;
				if($stopped != 0) {
					$chart["stopped"] = round((100/$all)*$stopped,0);
				}				

				$chart["title"] = $lang["PROJECT_FOLDER_CHART_STATUS"];
				$chart["img_name"] = 'trainings_' . $id . "_status.png";
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
		global $trainings;
		
		$bin = array();
		$bin["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		$arr = array();
		$arr["bin"] = $bin;
		
		$arr["folders"] = "";
		$arr["pros"] = "";
		$arr["files"] = "";
		$arr["tasks"] = "";
		$arr["members"] = "";
		
		$active_modules = array();
		foreach($trainings->modules as $module => $value) {
			if(CONSTANT('trainings_'.$module.'_bin') == 1) {
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
		
		$q ="select id, title, bin, bintime, binuser from " . CO_TBL_TRAININGS_FOLDERS;
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
				
				$qp ="select id, title, bin, bintime, binuser from " . CO_TBL_TRAININGS . " where folder = '$id'";
				$resultp = mysql_query($qp, $this->_db->connection);
				while ($rowp = mysql_fetch_array($resultp)) {
					$pid = $rowp["id"];
					if($rowp["bin"] == "1") { // deleted trainings
					foreach($rowp as $key => $val) {
						$pro[$key] = $val;
					}
					$pro["bintime"] = $this->_date->formatDate($pro["bintime"],CO_DATETIME_FORMAT);
					$pro["binuser"] = $this->_users->getUserFullname($pro["binuser"]);
					$pros[] = new Lists($pro);
					$arr["pros"] = $pros;
					} else {

						// members
						$qpc = "SELECT a.*,CONCAT(b.lastname,', ',b.firstname) as name FROM " . CO_TBL_TRAININGS_MEMBERS . " as a, co_users as b where a.cid=b.id and a.pid = '$pid'";
							$resultpc = mysql_query($qpc, $this->_db->connection);
							while ($rowpc = mysql_fetch_array($resultpc)) {
								if($rowpc["bin"] == "1") {
								$idp = $rowpc["id"];
									foreach($rowpc as $key => $val) {
										$member[$key] = $val;
									}
									$member["bintime"] = $this->_date->formatDate($member["bintime"],CO_DATETIME_FORMAT);
									$member["binuser"] = $this->_users->getUserFullname($member["binuser"]);
									$members[] = new Lists($member);
									$arr["members"] = $members;
								}
							}
						
						
						// grids
						if(in_array("grids",$active_modules)) {
							$qf ="select id, title, bin, bintime, binuser from " . CO_TBL_TRAININGS_GRIDS . " where pid = '$pid'";
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
									
									$qc ="select id, bin, bintime, binuser from " . CO_TBL_TRAININGS_GRIDS_COLUMNS . " where pid = '$fid'";
									$resultc = mysql_query($qc, $this->_db->connection);
									while ($rowc = mysql_fetch_array($resultc)) {
										$cid = $rowc["id"];
										if($rowc["bin"] == "1") { // deleted phases
											foreach($rowc as $key => $val) {
												$grids_col[$key] = $val;
											}
											
											$items = '';
											$qn = "SELECT title FROM " . CO_TBL_TRAININGS_GRIDS_NOTES . " where cid = '$cid' and bin='0' ORDER BY sort";
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
											$qt ="select id, title, bin, bintime, binuser from " . CO_TBL_TRAININGS_GRIDS_NOTES . " WHERE cid = '$cid' ORDER BY sort";
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
							$q ="select id, title, bin, bintime, binuser from " . CO_TBL_TRAININGS_FORUMS . " where pid = '$pid'";
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
									$qmt ="select id, text, bin, bintime, binuser from " . CO_TBL_TRAININGS_FORUMS_POSTS . " where pid = '$id'";
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
							$qm ="select id, title, bin, bintime, binuser from " . CO_TBL_TRAININGS_MEETINGS . " where pid = '$pid'";
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
									$qmt ="select id, title, bin, bintime, binuser from " . CO_TBL_TRAININGS_MEETINGS_TASKS . " where mid = '$mid'";
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
							$qpc ="select id, title, bin, bintime, binuser from " . CO_TBL_TRAININGS_PHONECALLS . " where pid = '$pid'";
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
							$qd ="select id, title, bin, bintime, binuser from " . CO_TBL_TRAININGS_DOCUMENTS_FOLDERS . " where pid = '$pid'";
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
									$qf ="select id, filename, bin, bintime, binuser from " . CO_TBL_TRAININGS_DOCUMENTS . " where did = '$did'";
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
							$qv ="select id, title, bin, bintime, binuser from " . CO_TBL_TRAININGS_VDOCS . " where pid = '$pid' and bin='1'";
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
		global $trainings;
		
		$bin = array();
		$bin["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		$arr = array();
		$arr["bin"] = $bin;
		
		$arr["folders"] = "";
		$arr["pros"] = "";
		$arr["files"] = "";
		$arr["tasks"] = "";
		$arr["members"] = "";
		
		$active_modules = array();
		foreach($trainings->modules as $module => $value) {
			if(CONSTANT('trainings_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
				$arr[$module . "_cols"] = "";
			}
		}
		
		$q ="select id, title, bin, bintime, binuser from " . CO_TBL_TRAININGS_FOLDERS;
		$result = mysql_query($q, $this->_db->connection);
	  	while ($row = mysql_fetch_array($result)) {
			$id = $row["id"];
			if($row["bin"] == "1") { // deleted folders
				$this->deleteFolder($id);
			} else { // folder not binned
				
				$qp ="select id, title, bin, bintime, binuser from " . CO_TBL_TRAININGS . " where folder = '$id'";
				$resultp = mysql_query($qp, $this->_db->connection);
				while ($rowp = mysql_fetch_array($resultp)) {
					$pid = $rowp["id"];
					if($rowp["bin"] == "1") { // deleted trainings
						$this->deleteTraining($pid);
					} else {
						
						
						// members
						$qpc = "SELECT id, bin, bintime, binuser FROM " . CO_TBL_TRAININGS_MEMBERS . " where pid = '$pid'";
							$resultpc = mysql_query($qpc, $this->_db->connection);
							while ($rowpc = mysql_fetch_array($resultpc)) {
								if($rowpc["bin"] == "1") {
									$idp = $rowpc["id"];
									$this->deleteMember($idp);
									$arr["members"] = "";
								}
							}
							

						// grids
					if(in_array("grids",$active_modules)) {
						$trainingsGridsModel = new TrainingsGridsModel();
						$qf ="select id, title, bin, bintime, binuser from " . CO_TBL_TRAININGS_GRIDS . " where pid = '$pid'";
						$resultf = mysql_query($qf, $this->_db->connection);
						while ($rowf = mysql_fetch_array($resultf)) {
							$fid = $rowf["id"];
							if($rowf["bin"] == "1") { // deleted phases
								$trainingsGridsModel->deleteGrid($fid);
								$arr["grids"] = "";
							} else {
								// columns
								
								$qc ="select id,bin from " . CO_TBL_TRAININGS_GRIDS_COLUMNS . " where pid = '$fid'";
								$resultc = mysql_query($qc, $this->_db->connection);
								while ($rowc = mysql_fetch_array($resultc)) {
									$cid = $rowc["id"];
									if($rowc["bin"] == "1") { // deleted phases
										$trainingsGridsModel->deleteGridColumn($cid);
										$arr["grids_cols"] = "";
									} else {
										// notes
										$qt ="select id,bin from " . CO_TBL_TRAININGS_GRIDS_NOTES . " where cid = '$cid'";
										$resultt = mysql_query($qt, $this->_db->connection);
										while ($rowt = mysql_fetch_array($resultt)) {
											if($rowt["bin"] == "1") { // deleted phases
												$tid = $rowt["id"];
												$trainingsGridsModel->deleteGridTask($tid);
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
							$trainingsForumsModel = new TrainingsForumsModel();
							$q ="select id, title, bin, bintime, binuser from " . CO_TBL_TRAININGS_FORUMS . " where pid = '$pid'";
							$result = mysql_query($q, $this->_db->connection);
							while ($row = mysql_fetch_array($result)) {
								$id = $row["id"];
								if($row["bin"] == "1") { // deleted forum
									$trainingsForumsModel->deleteForum($id);
									$arr["forums"] = "";
								} else {
									// forums_tasks
									$qmt ="select id, text, bin, bintime, binuser from " . CO_TBL_TRAININGS_FORUMS_POSTS . " where pid = '$id'";
									$resultmt = mysql_query($qmt, $this->_db->connection);
									while ($rowmt = mysql_fetch_array($resultmt)) {
										if($rowmt["bin"] == "1") { // deleted phases
											$mtid = $rowmt["id"];
											$trainingsForumsModel->deleteItem($mtid);
											$arr["forums_tasks"] = "";
										}
									}
								}
							}
						}


						// meetings
						if(in_array("meetings",$active_modules)) {
							$trainingsMeetingsModel = new TrainingsMeetingsModel();
							$qm ="select id, title, bin, bintime, binuser from " . CO_TBL_TRAININGS_MEETINGS . " where pid = '$pid'";
							$resultm = mysql_query($qm, $this->_db->connection);
							while ($rowm = mysql_fetch_array($resultm)) {
								$mid = $rowm["id"];
								if($rowm["bin"] == "1") { // deleted meeting
									$trainingsMeetingsModel->deleteMeeting($mid);
									$arr["meetings"] = "";
								} else {
									// meetings_tasks
									$qmt ="select id, title, bin, bintime, binuser from " . CO_TBL_TRAININGS_MEETINGS_TASKS . " where mid = '$mid'";
									$resultmt = mysql_query($qmt, $this->_db->connection);
									while ($rowmt = mysql_fetch_array($resultmt)) {
										if($rowmt["bin"] == "1") { // deleted phases
											$mtid = $rowmt["id"];
											$trainingsMeetingsModel->deleteMeetingTask($mtid);
											$arr["meetings_tasks"] = "";
										}
									}
								}
							}
						}
						
						
						// phonecalls
						if(in_array("phonecalls",$active_modules)) {
							$trainingsPhoncallsModel = new TrainingsPhonecallsModel();
							$qc ="select id, title, bin, bintime, binuser from " . CO_TBL_TRAININGS_PHONECALLS . " where pid = '$pid'";
							$resultc = mysql_query($qc, $this->_db->connection);
							while ($rowc = mysql_fetch_array($resultc)) {
								$cid = $rowc["id"];
								if($rowc["bin"] == "1") {
									$trainingsPhoncallsModel->deletePhonecall($cid);
									$arr["phonecalls"] = "";
								}
							}
						}


						// documents_folder
						if(in_array("documents",$active_modules)) {
							$trainingsDocumentsModel = new TrainingsDocumentsModel();
							$qd ="select id, title, bin, bintime, binuser from " . CO_TBL_TRAININGS_DOCUMENTS_FOLDERS . " where pid = '$pid'";
							$resultd = mysql_query($qd, $this->_db->connection);
							while ($rowd = mysql_fetch_array($resultd)) {
								$did = $rowd["id"];
								if($rowd["bin"] == "1") { // deleted meeting
									$trainingsDocumentsModel->deleteDocument($did);
									$arr["documents_folders"] = "";
								} else {
									// files
									$qf ="select id, filename, bin, bintime, binuser from " . CO_TBL_TRAININGS_DOCUMENTS . " where did = '$did'";
									$resultf = mysql_query($qf, $this->_db->connection);
									while ($rowf = mysql_fetch_array($resultf)) {
										if($rowf["bin"] == "1") { // deleted phases
											$fid = $rowf["id"];
											$trainingsDocumentsModel->deleteFile($fid);
											$arr["files"] = "";
										}
									}
								}
							}
						}
	
	
						// vdocs
						if(in_array("vdocs",$active_modules)) {
							$qv ="select id, title, bin, bintime, binuser from " . CO_TBL_TRAININGS_VDOCS . " where pid = '$pid'";
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
		$q = "SELECT a.pid FROM co_trainings_access as a, co_trainings as b WHERE a.pid=b.id and b.bin='0' and a.admins REGEXP '[[:<:]]" . $id . "[[:>:]]' ORDER by b.title ASC";
      	$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$perms[] = $row["pid"];
		}
		return $perms;
   }


   function getViewPerms($id) {
		global $session;
		$perms = array();
		$q = "SELECT a.pid FROM co_trainings_access as a, co_trainings as b WHERE a.pid=b.id and b.bin='0' and a.guests REGEXP '[[:<:]]" . $id. "[[:>:]]' ORDER by b.title ASC";
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


   function getTrainingAccess($pid) {
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
  
  
  
 function existUserTrainingsWidgets() {
		global $session;
		$q = "select count(*) as num from " . CO_TBL_TRAININGS_DESKTOP_SETTINGS . " where uid='$session->uid'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_assoc($result);
		if($row["num"] < 1) {
			return false;
		} else {
			return true;
		}
	}
	
	
	function getUserTrainingsWidgets() {
		global $session;
		$q = "select * from " . CO_TBL_TRAININGS_DESKTOP_SETTINGS . " where uid='$session->uid'";
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

		// Kick off = Admins / Sysadmins die auch Projektleiter sind
		$kickoffs = "";
		$array = "";
		if($skip == 0) {
			$q ="select c.folder,c.id as pid,c.title from " . CO_TBL_TRAININGS . " as c where bin = '0' and registration_end = '$tomorrow'" . $access . " and c.management REGEXP '[[:<:]]" . $session->uid . "[[:>:]]'";
			$result = mysql_query($q, $this->_db->connection);
			while ($row = mysql_fetch_array($result)) {
				foreach($row as $key => $val) {
					$array[$key] = $val;
				}
				$string .= $array["folder"] . "," . $array["pid"] . ",";
				$kickoffs[] = new Lists($array);
			}
		}
		
		
		// Kick off = Admins / Sysadmins die auch Projektleiter sind
		$starts = "";
		$array = "";
		if($skip == 0) {
			$q ="select c.folder,c.id as pid,c.title from " . CO_TBL_TRAININGS . " as c where bin = '0' and date1 = '$tomorrow'" . $access . " and c.management REGEXP '[[:<:]]" . $session->uid . "[[:>:]]'";
			$result = mysql_query($q, $this->_db->connection);
			while ($row = mysql_fetch_array($result)) {
				foreach($row as $key => $val) {
					$array[$key] = $val;
				}
				$string .= $array["folder"] . "," . $array["pid"] . ",";
				$starts[] = new Lists($array);
			}
		}


		if(!$this->existUserTrainingsWidgets()) {
			$q = "insert into " . CO_TBL_TRAININGS_DESKTOP_SETTINGS . " set uid='$session->uid', value='$string'";
			$result = mysql_query($q, $this->_db->connection);
			$widgetaction = "open";
		} else {
			$row = $this->getUserTrainingsWidgets();
			$id = $row["id"];
			if($string == $row["value"]) {
				$widgetaction = "";
			} else {
				$widgetaction = "open";
			}
			$q = "UPDATE " . CO_TBL_TRAININGS_DESKTOP_SETTINGS . " set value='$string' WHERE id = '$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		
		$arr = array("kickoffs" => $kickoffs, "starts" => $starts, "widgetaction" => $widgetaction);
		return $arr;
   }
   
   function setContactAccessDetails($id, $cid, $username, $password) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$pwd = md5($password);
		
		$q = "INSERT INTO " . CO_TBL_TRAININGS_ORDERS_ACCESS . "  set uid = '$id', cid = '$cid', username = '$username', password = '$pwd', access_user = '$session->uid', access_date = '$now', access_status=''";
		
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	
	function removeAccess($id,$cid) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "DELETE FROM " . CO_TBL_TRAININGS_ORDERS_ACCESS . " where uid='$id' and cid = '$cid'";
		
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
  
  
 	function getNavModulesNumItems($id) {
		global $trainings;
		$active_modules = array();
		foreach($trainings->modules as $module => $value) {
			$active_modules[] = $module;
		}
		if(in_array("grids",$active_modules)) {
			$trainingsGridsModel = new TrainingsGridsModel();
			$data["trainings_grids_items"] = $trainingsGridsModel->getNavNumItems($id);
		}
		if(in_array("forums",$active_modules)) {
			$trainingsForumsModel = new TrainingsForumsModel();
			$data["trainings_forums_items"] = $trainingsForumsModel->getNavNumItems($id);
		}
		if(in_array("feedbacks",$active_modules)) {
			$trainingsFeedbacksModel = new TrainingsFeedbacksModel();
			$data["trainings_feedbacks_items"] = $trainingsFeedbacksModel->getNavNumItems($id);
		}
		if(in_array("meetings",$active_modules)) {
			$trainingsMeetingsModel = new TrainingsMeetingsModel();
			$data["trainings_meetings_items"] = $trainingsMeetingsModel->getNavNumItems($id);
		}
		if(in_array("phonecalls",$active_modules)) {
			$trainingsPhonecallsModel = new TrainingsPhonecallsModel();
			$data["trainings_phonecalls_items"] = $trainingsPhonecallsModel->getNavNumItems($id);
		}
		if(in_array("documents",$active_modules)) {
			$trainingsDocumentsModel = new TrainingsDocumentsModel();
			$data["trainings_documents_items"] = $trainingsDocumentsModel->getNavNumItems($id);
		}
		if(in_array("vdocs",$active_modules)) {
			$trainingsVDocsModel = new TrainingsVDocsModel();
			$data["trainings_vdocs_items"] = $trainingsVDocsModel->getNavNumItems($id);
		}
		return $data;
	}


	function newCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "INSERT INTO " . CO_TBL_USERS_CHECKPOINTS . " SET uid = '$session->uid', date = '$date', app = 'trainings', module = 'trainings', app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

 	function updateCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "UPDATE " . CO_TBL_USERS_CHECKPOINTS . " SET date = '$date', status='0' WHERE uid = '$session->uid' and app = 'trainings' and module = 'trainings' and app_id='$id'";
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
		$q = "UPDATE " . CO_TBL_USERS_CHECKPOINTS . " SET note = '$text' WHERE uid = '$session->uid' and app = 'trainings' and module = 'trainings' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

    function getCheckpointDetails($app,$module,$id){
		global $lang, $session, $trainings;
		$row = "";
		if($app =='trainings' && $module == 'trainings') {
			$q = "SELECT title,folder FROM " . CO_TBL_TRAININGS . " WHERE id='$id' and bin='0'";
			$result = mysql_query($q, $this->_db->connection);
			$row = mysql_fetch_array($result);
			if(mysql_num_rows($result) > 0) {
				$row['checkpoint_app_name'] = $lang["TRAINING_TITLE"];
				$row['app_id_app'] = '0';
			}
			return $row;
		} else {
			$active_modules = array();
			foreach($trainings->modules as $m => $v) {
					$active_modules[] = $m;
			}
			if($module == 'meetings' && in_array("meetings",$active_modules)) {
				include_once("modules/".$module."/config.php");
				include_once("modules/".$module."/lang/" . $session->userlang . ".php");
				include_once("modules/".$module."/model.php");
				$trainingsMeetingsModel = new TrainingsMeetingsModel();
				$row = $trainingsMeetingsModel->getCheckpointDetails($id);
				return $row;
			}
		}
   }


	function getGlobalSearch($term){
		global $system, $session, $trainings;
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
		foreach($trainings->modules as $m => $v) {
			$active_modules[] = $m;
		}
		
		$q = "SELECT id, folder, CONVERT(title USING latin1) as title FROM " . CO_TBL_TRAININGS . " WHERE title like '%$term%' and  bin='0'" . $access ."ORDER BY title";
		$result = mysql_query($q, $this->_db->connection);
		//$num=mysql_affected_rows();
		while($row = mysql_fetch_array($result)) {
			 $rows['value'] = htmlspecialchars_decode($row['title']);
			 $rows['id'] = 'trainings,' .$row['folder']. ',' . $row['id'] . ',0,trainings';
			 $r[] = $rows;
		}
		// loop through forums
		$q = "SELECT id, folder FROM " . CO_TBL_TRAININGS . " WHERE bin='0'" . $access ."ORDER BY title";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$pid = $row['id'];
			$folder = $row['folder'];
			$sql = "";
			$perm = $this->getTrainingAccess($pid);
			if($perm == 'guest') {
				$sql = "and access = '1'";
			}
			// Grids
			$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_TRAININGS_GRIDS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
			$resultp = mysql_query($qp, $this->_db->connection);
			while($rowp = mysql_fetch_array($resultp)) {
				$rows['value'] = htmlspecialchars_decode($rowp['title']);
			 	$rows['id'] = 'grids,' .$folder. ',' . $pid . ',' .$rowp['id'].',trainings';
			 	$r[] = $rows;
			}
			// Forums
			$qp = "SELECT id,CONVERT(title USING latin1) as title, CONVERT(protocol USING latin1) as protocol FROM " . CO_TBL_TRAININGS_FORUMS . " WHERE pid = '$pid' and bin = '0' $sql and (title like '%$term%' || protocol like '%$term%') ORDER BY title";
			$resultp = mysql_query($qp, $this->_db->connection);
			while($rowp = mysql_fetch_array($resultp)) {
				$rows['value'] = htmlspecialchars_decode($rowp['title']);
			 	$rows['id'] = 'forums,' .$folder. ',' . $pid . ',' .$rowp['id'].',trainings';
			 	$r[] = $rows;
			}
			// Meetings
			if(in_array("meetings",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_TRAININGS_MEETINGS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'meetings,' .$folder. ',' . $pid . ',' .$rowp['id'].',trainings';
					$r[] = $rows;
				}
				// Meeting Tasks
				$qp = "SELECT b.id,CONVERT(a.title USING latin1) as title FROM " . CO_TBL_TRAININGS_MEETINGS_TASKS . " as a, " . CO_TBL_TRAININGS_MEETINGS . " as b WHERE b.pid = '$pid' and a.mid = b.id and a.bin = '0' and b.bin = '0' $sql and a.title like '%$term%' ORDER BY a.title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'meetings,' .$folder. ',' . $pid . ',' .$rowp['id'].',trainings';
					$r[] = $rows;
				}
			}
			// Phonecalls
			if(in_array("phonecalls",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_TRAININGS_PHONECALLS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'phonecalls,' .$folder. ',' . $pid . ',' .$rowp['id'].',trainings';
					$r[] = $rows;
				}
			}
			// Doc Folders
			if(in_array("documents",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_TRAININGS_DOCUMENTS_FOLDERS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'documents,' .$folder. ',' . $pid . ',' .$rowp['id'].',trainings';
					$r[] = $rows;
				}
				// Documents
				$qp = "SELECT b.id,CONVERT(a.filename USING latin1) as title FROM " . CO_TBL_TRAININGS_DOCUMENTS . " as a, " . CO_TBL_TRAININGS_DOCUMENTS_FOLDERS . " as b WHERE b.pid = '$pid' and a.did = b.id and a.bin = '0' and b.bin = '0' $sql and a.filename like '%$term%' ORDER BY a.filename";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'documents,' .$folder. ',' . $pid . ',' .$rowp['id'].',trainings';
					$r[] = $rows;
				}
			}
			// vDocs
			if(in_array("vdocs",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_TRAININGS_VDOCS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'vdocs,' .$folder. ',' . $pid . ',' .$rowp['id'].',trainings';
					$r[] = $rows;
				}
			}
			
		}
		return json_encode($r);
	}


	function getTrainingsSearch($term,$exclude){
		global $system, $session;
		$num=0;
		$access=" ";
		if(!$session->isSysadmin()) {
			$access = " and a.id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
	  	}
		
		$q = "SELECT a.id,a.title as label FROM " . CO_TBL_TRAININGS . " as a WHERE a.id != '$exclude' and a.title like '%$term%' and  a.bin='0'" . $access ."ORDER BY a.title";
		
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

	
	function getTrainingArray($string){
		$string = explode(",", $string);
		$total = sizeof($string);
		$items = '';
		
		if($total == 0) { 
			return $items; 
		}
		
		// check if user is available and build array
		$items_arr = "";
		foreach ($string as &$value) {
			$q = "SELECT id, title FROM ".CO_TBL_TRAININGS." where id = '$value' and bin='0'";
			$result = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result) > 0) {
				while($row = mysql_fetch_assoc($result)) {
					$items_arr[] = array("id" => $row["id"], "title" => $row["title"]);		
				}
			}
		}

		return $items_arr;
}
	
	function getLast10Trainings() {
		global $session;
		$trainings = $this->getTrainingArray($this->getUserSetting("last-used-trainings"));
	  return $trainings;
	}
	
	
	function saveLastUsedTrainings($id) {
		global $session;
		$string = $id . "," .$this->getUserSetting("last-used-trainings");
		$string = rtrim($string, ",");
		$ids_arr = explode(",", $string);
		$res = array_unique($ids_arr);
		foreach ($res as $key => $value) {
			$ids_rtn[] = $value;
		}
		array_splice($ids_rtn, 7);
		$str = implode(",", $ids_rtn);
		
		$this->setUserSetting("last-used-trainings",$str);
	  return true;
	}


	function addMember($pid,$cid) {
		$members = '';
		$error = false;
		$error_data = '';
		$newid = '';
		$status = '';
		// check if member exists
		$q = "SELECT * FROM " . CO_TBL_TRAININGS_MEMBERS . " WHERE pid='$pid' and cid='$cid' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			$status = false;
		} else {
			$qu = "SELECT CONCAT(lastname,', ',firstname) as name,email FROM co_users where id='$cid'";
			$resultu = mysql_query($qu, $this->_db->connection);
			$row = mysql_fetch_array($resultu);
				foreach($row as $key => $val) {
					$array[$key] = $val;
				}
				if($array['email'] == "") {
					$error = true;
					$error_data = $array['name'];
					$status = false;
				} else {
					$status = true;
					$q = "INSERT INTO " . CO_TBL_TRAININGS_MEMBERS . " set pid='$pid', cid='$cid'";
					$result = mysql_query($q, $this->_db->connection);
					$newid = mysql_insert_id();
				}
				$array['id'] = $newid;
				$array['invitation_class'] = '';
				$array['registration_class'] = '';
				$array['takepart_class'] = '';
				$array['feedback_class'] = '';
				$members = new Lists($array);
			}
		$arr = array("error" => $error, "error_data" => $error_data, "status" => $status, "members" => $members);
		return $arr;
	}

function getGroupIDs($cid) {
		$q = "SELECT members FROM co_contacts_groups WHERE id='$cid'";
		$result = mysql_query($q, $this->_db->connection);
		$members = mysql_result($result,0);
		return $members;
	}

	function storeKey($id,$key,$what) {
		$q = "UPDATE " . CO_TBL_TRAININGS_MEMBERS . " set accesskey = '$key', $what='1' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		return true;
	}
	
	
	function manualInvitation($id) {
		$q = "UPDATE " . CO_TBL_TRAININGS_MEMBERS . " set invitation='1' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		return true;
	}
	

	function resetInvitation($id) {
		$q = "UPDATE " . CO_TBL_TRAININGS_MEMBERS . " set invitation='0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		return true;
	}
	
	function manualRegistration($id) {
		$q = "UPDATE " . CO_TBL_TRAININGS_MEMBERS . " set registration='1' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		return true;
	}
	
	function removeRegistration($id) {
		$q = "UPDATE " . CO_TBL_TRAININGS_MEMBERS . " set registration='2' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		return true;
	}
	
	function resetRegistration($id) {
		$q = "UPDATE " . CO_TBL_TRAININGS_MEMBERS . " set registration='0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		return true;
	}

	function manualTookpart($id) {
		$q = "UPDATE " . CO_TBL_TRAININGS_MEMBERS . " set tookpart='1' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		return true;
	}
	
	function manualTookNotpart($id) {
		$q = "UPDATE " . CO_TBL_TRAININGS_MEMBERS . " set tookpart='2' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		return true;
	}
	
	function resetTookpart($id) {
		$q = "UPDATE " . CO_TBL_TRAININGS_MEMBERS . " set tookpart='0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		return true;
	}
	
	function editFeedback($id) {
		$q = "UPDATE " . CO_TBL_TRAININGS_MEMBERS . " set feedback='1' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		return true;
	}
	
	function resetFeedback($id) {
		$q = "UPDATE " . CO_TBL_TRAININGS_MEMBERS . " set feedback='0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		return true;
	}
	
	function getMemberDetails($id) {
		$members = '';

		$qu = "SELECT a.cid,a.pid,c.email,c.lastname,c.firstname,b.title FROM " . CO_TBL_TRAININGS_MEMBERS . " as a, " . CO_TBL_TRAININGS . " as b,co_users as c WHERE a.id='$id' and a.cid = c.id and a.pid=b.id";
		$resultu = mysql_query($qu, $this->_db->connection);
		$row = mysql_fetch_array($resultu);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		$member = new Lists($array);
		return $member;
	}
	
	function acceptInvitation($id) {
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_TRAININGS_MEMBERS . " set accesskey='', registration='1' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function declineInvitation($id) {
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_TRAININGS_MEMBERS . " set accesskey='', registration='2' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function saveFeedback($id,$uid,$q1,$q2,$q3,$q4,$q5,$feedback_text) {
   		$q = "UPDATE " . CO_TBL_TRAININGS_MEMBERS . " set accesskey='', feedback_q1='$q1', feedback_q2='$q2', feedback_q3='$q3', feedback_q4='$q4', feedback_q5='$q5', feedback_text='$feedback_text' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }

	function writeMemberLog($id,$action,$who) {
		$now = gmdate("Y-m-d H:i:s");
		$q = "INSERT INTO " . CO_TBL_TRAININGS_MEMBERS_LOG . " set mid='$id', date='$now', action='$action', who='$who'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
	
	function binMember($id) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_TRAININGS_MEMBERS . " set bin = '1', bintime = '$now', binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }



}

$trainingsmodel = new TrainingsModel(); // needed for direct calls to functions eg echo $trainingsmodel ->getTrainingTitle(1);
?>
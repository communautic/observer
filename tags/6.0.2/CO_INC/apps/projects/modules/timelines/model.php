<?php

class TimelinesModel extends ProjectsModel {
	
	public function __construct() {  
		parent::__construct();
		$this->_contactsmodel = new ContactsModel();
	}


	function getList($id,$sort) {
		global $session;
		if($sort == 0) {
		  $sortstatus = $this->getSortStatus("timeline-sort-status",$id);
		  if(!$sortstatus) {
				$order = "order by id";
				$sortcur = '1';
		  } else {
			  switch($sortstatus) {
				  case "1":
				  		$order = "order by id";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by id DESC";
							$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("timeline-sort-order",$id);
				  		if(!$sortorder) {
								$order = "order by id";
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
				  		$order = "order by id";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by id DESC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("timeline-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by id";
								$sortcur = '1';
						  } else {
								$order = "order by field(id,$sortorder)";
								$sortcur = '3';
						  }
				  break;	
			  }
	  }
	  
		$q = "select id,title from " . CO_TBL_TIMELINE . " " . $order;

		$this->setSortStatus("timeline-sort-status",$sortcur,$id);
		$result = mysql_query($q, $this->_db->connection);
		$timelines = "";
		while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			$timelines[] = new Lists($array);
		}
		
		$arr = array("timelines" => $timelines, "sort" => $sortcur);
		return $arr;
	}


	function getDetails($pid) {
		global $session, $contactsmodel;
		$now = new DateTime("now");
		$today = $now->format('Y-m-d');
		$project = array();
		$project["phases"] = array();
		// get project details
		//$q = "select title,startdate,enddate,management,team,status from " . CO_TBL_PROJECTS . " where id = '$pid'";
		$q = "SELECT a.title,a.startdate,a.management,a.team,a.status, (SELECT MAX(enddate) FROM " . CO_TBL_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as enddate FROM " . CO_TBL_PROJECTS . " as a where a.id = '$pid'";
		$result = mysql_query($q, $this->_db->connection);
	  	while ($row = mysql_fetch_object($result)) {
			$project["id"] = $pid;
			$project["title"] = $row->title;
			$project["startdate"] = $this->_date->formatDate($row->startdate,CO_DATE_FORMAT);
			$project["enddate"] = $this->_date->formatDate($row->enddate,CO_DATE_FORMAT);
			$project["management"] = $contactsmodel->getUserList($row->management,'management');
			$project["team"] = $contactsmodel->getUserList($row->team,'team');
			$project["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
			switch($row->status) {
				case "0":
					$project["status"] = "barchart_color_planned";
				break;
				case "1":
					$project["status"] = "barchart_color_inprogress";
				break;
				case "2":
					$project["status"] = "barchart_color_finished";
				break;
			}
		}
		// get phase details
		$q = "SELECT a.title,a.id,a.status,(SELECT MIN(startdate) FROM " . CO_TBL_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin = '0') as startdate,(SELECT MAX(enddate) FROM " . CO_TBL_PHASES_TASKS . " as c WHERE c.phaseid=a.id and c.bin = '0') as enddate FROM " . CO_TBL_PHASES . " as a WHERE pid = '$pid' and bin = '0' ORDER BY startdate";
		$result = mysql_query($q, $this->_db->connection);
	  	while ($row = mysql_fetch_object($result)) {
			// phase status
			switch($row->status) {
				case "0":
					$status = "barchart_color_planned";
				break;
				case "1":
					$status = "barchart_color_inprogress";
				break;
				case "2":
					$status = "barchart_color_finished";
				break;
			}
			// add tasks to phases array
			$tasks = array();
			$phase_id = $row->id;
			$qt = "select * from " . CO_TBL_PHASES_TASKS . " where phaseid = '$phase_id' and bin='0' order by startdate";
			$resultt = mysql_query($qt, $this->_db->connection);
			while ($rowt = mysql_fetch_object($resultt)) {
				// task status
				switch($rowt->status) {
					case "0":
						if($row->status == 0) {
							$tstatus = "barchart_color_planned";
						} else if ($row->status == 1 && $today <= $rowt->startdate) {
							$tstatus = "barchart_color_planned";
						} else if ($row->status == 1 && $today <= $rowt->enddate) {
							$tstatus = "barchart_color_inprogress";

						} else {
							$tstatus = "barchart_color_not_finished";
						}
					break;
					case "1":
						$tstatus = "barchart_color_finished";
						if($rowt->donedate > $rowt->enddate) {
							$tstatus = "barchart_color_overdue";
						}
					break;
				}
				
				$tasks[] = array(
					"id" => $rowt->id,
					"text" => $rowt->text,
					"startdate" => $this->_date->formatDate($rowt->startdate,CO_DATE_FORMAT),
					"enddate" => $this->_date->formatDate($rowt->enddate,CO_DATE_FORMAT),
					"status" => $tstatus,
					"cat" => $rowt->cat
				);
			}
			
			$project['phases'][] = array(
				"id" => $row->id,
				"title" => $row->title,
				"startdate" => $this->_date->formatDate($row->startdate,CO_DATE_FORMAT),
				"enddate" => $this->_date->formatDate($row->enddate,CO_DATE_FORMAT),
				"status" => $status,
				"tasks" => $tasks
			);
		}
	  return $project;
	}


	function getBarchartDetails($pid, $width=23) {
		global $session, $contactsmodel;
		
		// settings apart from width
		$space_between_phases = 2;
		$height_of_tasks = 10;
		$space_between_tasks = 8;
		
		$project = array();
		$project["phases"] = array();
		$project["tasks"] = array();
		$project["bg_image"] = CO_FILES . "/img/barchart_bg_".$width.".png";
		$project["bg_image_shift"] = 0;
		$project["td_width"] = $width;
		// get project details
		//$q = "select title,startdate,enddate,management,team,status from " . CO_TBL_PROJECTS . " where id = '$pid'";
		$q = "SELECT a.title,a.startdate,a.management,a.team,a.status, (SELECT MAX(enddate) FROM " . CO_TBL_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as enddate FROM " . CO_TBL_PROJECTS . " as a where a.id = '$pid'";

		$result = mysql_query($q, $this->_db->connection);
	  	while ($row = mysql_fetch_object($result)) {
			$project["title"] = $row->title;
			$project["startdate"] = $row->startdate;
			$project["enddate"] = $row->enddate;
			$project["startdate_view"] = $this->_date->formatDate($row->startdate,CO_DATE_FORMAT);
			$project["enddate_view"] = $this->_date->formatDate($row->enddate,CO_DATE_FORMAT);
			$project["management"] = $contactsmodel->getUserList($row->management,'management');
			$project["team"] = $contactsmodel->getUserList($row->team,'team');
			$project["days"] = $this->_date->dateDiff($row->startdate,$row->enddate);
			$project["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
			$project["css_width"] = ($project["days"]+1) * $width;
			$project["css_height"] = 41; // pixel add at bottom
			$wday = $this->_date->formatDate($row->startdate,"w");
			if($wday != 1) {
				$project["bg_image_shift"] = -($wday-1)*$width;
			}
			switch($row->status) {
				case "0":
					$project["status"] = "barchart_color_planned";
				break;
				case "1":
					$project["status"] = "barchart_color_inprogress";
				break;
				case "2":
					$project["status"] = "barchart_color_finished";
				break;
			}
		}
		// get phase details
		//$q = "select title,id,startdate,enddate,status,dependency from " . CO_TBL_PHASES . " where pid = '$pid' and bin = '0' order by startdate";
		$q = "SELECT a.title,a.id,a.status,a.dependency,a.finished_date, (SELECT MIN(startdate) FROM " . CO_TBL_PHASES_TASKS . "  as b WHERE b.phaseid=a.id and b.bin='0') as startdate,(SELECT MAX(enddate) FROM " . CO_TBL_PHASES_TASKS . " as c WHERE c.phaseid=a.id and c.bin='0') as enddate FROM " . CO_TBL_PHASES . " as a WHERE pid = '$pid' and bin = '0' ORDER BY startdate";
		$result = mysql_query($q, $this->_db->connection);
		$phase_top = 21;
		$phase_top_next = 0;
		$now = new DateTime("now");
		$today = $now->format('Y-m-d');
		$p = 0;
	  	while ($row = mysql_fetch_object($result)) {
			$phase_ids[] = $row->id;
			$project["css_height"] += $space_between_phases;
			$phase_top += $space_between_phases + $phase_top_next;
			$phase_days = $this->_date->dateDiff($row->startdate,$row->enddate);
			$phase_width = ($phase_days+1) * $width;
			$phase_start = $this->_date->dateDiff($project["startdate"],$row->startdate);
			$phase_left = $phase_start * $width;
			// phase status
			switch($row->status) {
				case "0":
					$status = "barchart_color_planned";
				break;
				case "1":
					$status = "barchart_color_inprogress";
				break;
				case "2":
					$status = "barchart_color_finished";
				break;
			}
			// add tasks to phases array
			$tasks = array();
			$phase_id = $row->id;
			$qt = "select * from " . CO_TBL_PHASES_TASKS . " where phaseid = '$phase_id' and bin='0' order by startdate";
			$resultt = mysql_query($qt, $this->_db->connection);
			$num_tasks = mysql_num_rows($resultt);
			if( $num_tasks > 1 ) {
				$project["css_height"] += ($num_tasks*$height_of_tasks)+($num_tasks*$space_between_tasks)+16;
				$phase_height = ($num_tasks*$height_of_tasks)+($num_tasks*$space_between_tasks)+16;
				$phase_top_next = ($num_tasks*$height_of_tasks)+($num_tasks*$space_between_tasks)+16;
			} else {
				$project["css_height"] += 34;
				$phase_height = 34;
				$phase_top_next = ($num_tasks*$height_of_tasks)+24;
			}
			$task_top = 3;
			$t = 0;
			while ($rowt = mysql_fetch_object($resultt)) {
				$task_top += 18;
				$task_days = $this->_date->dateDiff($rowt->startdate,$rowt->enddate);
				$task_width = ($task_days+1) * $width;
				$task_start = $this->_date->dateDiff($row->startdate,$rowt->startdate);
				$task_left = $task_start * $width;
				$overdue = array();
				// task status
				switch($rowt->status) {
					case "0":
						if($row->status == 0) {
							$tstatus = "barchart_color_planned";
						} else if ($row->status == 1 && $today <= $rowt->startdate) {
							$tstatus = "barchart_color_planned";
						} else if ($row->status == 1 && $today <= $rowt->enddate) {
							$tstatus = "barchart_color_inprogress";

						} else {
							$tstatus = "barchart_color_not_finished";
						}
					break;
					case "1":
						$tstatus = "barchart_color_finished";
						// overdue
						if($rowt->donedate > $rowt->enddate) {
							$overdue["days"] = $this->_date->dateDiff($rowt->enddate,$rowt->donedate);
							$overdue["width"] = $overdue["days"] * $width;
							$overdue["left"] = $task_left + $task_width;
							
							if($rowt->donedate > $project["enddate"]) {
								$project["enddate"] = $rowt->donedate;
								$project["days"] = $this->_date->dateDiff($project["startdate"],$project["enddate"]);
								$project["css_width"] = ($project["days"]+1) * $width;
							}
						}
					break;
				}
				
				
			// dependend task
			$dependent = $rowt->dependent;
			$dep = "";
			$dep_key = "";
			if($dependent != "") {
				foreach ($project['tasks'] as $key => $value) {
            		$exists = 0;
					if ($project['tasks'][$key]["id"] == $dependent) {
						$exists = 1;
					} else {
						$exists = 0;
					}
					if ($exists) { 
						$dep = $key; 
						$dep_key = $project['tasks'][$key]["dep_key"];
					}
        		}
			}
			
			$days = $task_days+1;
			if($rowt->cat == 1) {
				$days = $task_days;
			}
				
				$tasks[] = array(
					"id" => $rowt->id,
					"text" => $rowt->text,
					"startdate" => $this->_date->formatDate($rowt->startdate,CO_DATE_FORMAT),
					"enddate" => $this->_date->formatDate($rowt->enddate,CO_DATE_FORMAT),
					"days" => $days,
					"status" => $tstatus,
					"cat" => $rowt->cat,
					"dep" => $dep,
					"dep_key" => $dep_key,
					"css_top" => $task_top,
					"css_width" => $task_width,
					"css_left" => $task_left,
					"overdue" => $overdue,
				);
				
				$project['tasks'][] = array(
					"id" => $rowt->id,
					"text" => $rowt->text,
					"startdate" => $this->_date->formatDate($rowt->startdate,CO_DATE_FORMAT),
					"enddate" => $this->_date->formatDate($rowt->enddate,CO_DATE_FORMAT),
					"days" => $days,
					"status" => $tstatus,
					"cat" => $rowt->cat,
					"dep" => $dep,
					"dep_key" => $p,
					"css_top" => $task_top,
					"css_width" => $task_width,
					"css_left" => $task_left
			);
			}
			// dependend phase
			/*$dependency = $row->dependency;
			$dep = "";
			if($dependency != "") {
				foreach ($project['phases'] as $key => $value) {
            		$exists = 0;
					if ($project['phases'][$key]["id"] == $dependency) {
						$exists = 1;
					} else {
						$exists = 0;
					}
					if ($exists) $dep = $key;
        		}
			}*/
			
			$phase_overdue = array();
			// phase overdue?
			if($row->status == 2 && $row->finished_date > $row->enddate) {
				$phase_overdue["days"] = $this->_date->dateDiff($row->enddate,$row->finished_date);
			    $phase_overdue["width"] = $phase_overdue["days"] * $width;
				$phase_overdue["left"] = $phase_left + $phase_width;
				
				if($row->finished_date > $project["enddate"]) {
					$project["enddate"] = $row->finished_date;
					$project["days"] = $this->_date->dateDiff($project["startdate"],$project["enddate"]);
					$project["css_width"] = ($project["days"]+1) * $width;
				}
			}
			
			
			$project['phases'][] = array(
				"id" => $row->id,
				"title" => $row->title,
				"startdate" => $this->_date->formatDate($row->startdate,CO_DATE_FORMAT),
				"enddate" => $this->_date->formatDate($row->enddate,CO_DATE_FORMAT),
				"days" => $phase_days+1,
				"status" => $status,
				"tasks" => $tasks,
				"css_height" => $phase_height,
				"css_top" => $phase_top,
				"css_width" => $phase_width,
				"css_left" => $phase_left,
				"overdue" => $phase_overdue
				//"dep" => $dep
			);
			$p++;
		}
	  return $project;
	}


	function barchartCalendar($date,$i) {
		$day = array();
		$day["month"] = "";
		$day["week"] = "";
		$day["color"] = "#000";
		$day["number"] = $this->_date->formatDate($date,"d");
		if($day["number"] == "01" || ($i == 0 && $day["number"] > 01 && $day["number"] < 28)) {
			$day["month"] = $this->_date->formatDate($date,"M y");
		}
		$day["wday"] = $this->_date->formatDate($date,"w");
		if($day["wday"] == 1) {
			$day["week"] = $this->_date->formatDate($date,"W");
		}
		if($day["wday"] == 0 || $day["wday"] == 6) {
			$day["color"] = "#fff";
		}

		return $day;
	}


	// first try with json result - maybe we need it again ???
	function psp($pid) {
		$project = array();
		$project["phases"] = array();
		// get project details
		$q = "select title from co_projects where id = '$pid'";
		$result = mysql_query($q, $this->_db->connection);
	  	while ($row = mysql_fetch_object($result)) {
		$project["title"] = $row->title;
		}
		
		// get phase details
		$q = "select title,id,startdate,enddate from co_projects_phases where pid = '$pid' and bin = '0'";
		$result = mysql_query($q, $this->_db->connection);
	  	while ($row = mysql_fetch_object($result)) {
			// add tasks to phases array
			$tasks = array();
			$phase_id = $row->id;
			$qt = "select * from co_projects_phases_tasks where phaseid = '$phase_id'";
			$resultt = mysql_query($qt, $this->_db->connection);
			while ($rowt = mysql_fetch_object($resultt)) {
				$tasks[] = array(
					"id" => $rowt->id,
					"text" => $rowt->text
				);
			}
			
			$project['phases'][] = array(
				"id" => $row->id,
				"title" => $row->title,
				"tasks" => $tasks
			);
		}
		 
		 $html[] = "me text";
		 
		$arr = array("html" => $html, "project" => $project);
	  return $arr;
	 }
}
?>
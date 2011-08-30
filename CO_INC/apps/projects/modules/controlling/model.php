<?php

class ProjectsControllingModel extends ProjectsModel {
	
	public function __construct() {  
		parent::__construct();
		$this->_contactsmodel = new ContactsModel();
	}
	
	function getList($id,$sort) {
		global $session, $lang;

			$array["id"] = 0;
			$array["controlling_date"] = $this->_date->formatDate("now",CO_DATE_FORMAT);
			$array["title"] = $lang["PROJECT_CONTROLLING_STATUS"];
			$array["itemstatus"] = "";
			
			$controlling[] = new Lists($array);
		
	  $arr = array("controlling" => $controlling, "sort" => 0);
	  return $arr;
	}
	
	
	function getDetails($pid) {
		global $session;
		
		$array["id"] = $pid;
		$array["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		
		$array["allphases"] = $this->getNumPhases($pid, "all");
		$array["plannedphases"] = $this->getNumPhases($pid, "0");
		$array["inprogressphases"] = $this->getNumPhases($pid, "1");
		$array["finishedphases"] = $this->getNumPhases($pid, "2");
		
		
		$controlling = new Lists($array);
		return $controlling;
   }
   
   	function getNumPhases($id,$status, $sql="") {
		switch($status) {
			case "all":
				$sql .= "";
			break;
			case "0":
				$sql .= " and status='0'";
			break;
			case "1":
				$sql .= " and status='1'";
			break;
			case "2":
				$sql .= " and status='2'";
			break;
			
		}
		
	   $q = "SELECT COUNT(id) FROM " .  CO_TBL_PROJECTS_PHASES. " WHERE pid='$id' $sql and bin='0'";
	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function getNumTasks($id,$status = 0,$sql="") {
	   //$sql = "";
	   if ($status == 1) {
		   $sql .= " and status='1' ";
	   }
	   $q = "SELECT COUNT(id) FROM " .  CO_TBL_PROJECTS_PHASES_TASKS. " WHERE pid='$id' $sql and bin='0'";
	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   
	function getNumMeetings($id,$status = 0,$sql="") {
	   //$sql = "";
	   if ($status == 1) {
		   $sql .= " and status='1' ";
	   }
	   $q = "SELECT COUNT(id) FROM " .  CO_TBL_PROJECTS_MEETINGS. " WHERE pid='$id' $sql and bin='0'";
	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   
   // Daily Cron
   function getDailyStatistic() {
		global $session;
		// select all projects that are active ie startdate is < today and endfdate > today or status != 2
		$today = date("Y-m-d");
		//$str = "";
		$q = "SELECT a.id,a.status,(SELECT MIN(startdate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as startdate ,(SELECT MAX(enddate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as enddate FROM " . CO_TBL_PROJECTS . " as a where a.bin='0'";

		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			if($row["startdate"] < $today && $row["status"] != '2') {
				//$str .= $row["id"] . " : ";
				$id = $row["id"];
				$chart = $this->getChart($id, "stability", $image = 0);
				$res = $chart["real"];
				//$str .= $chart["real"];
						$qs = "INSERT INTO " . CO_TBL_PROJECTS_STATISICS . " set pid = '$id', result = '$res'";
						$results = mysql_query($qs, $this->_db->connection);
				
				
			}
		}
		
		//return $str;
	}

   
   
   function getChart($id, $what, $image = 1) { 
		global $lang;
		switch($what) {
			case 'stability':
				$chart = $this->getChart($id, 'timeing');
				$timeing = $chart["real"];
				
				$chart = $this->getChart($id, 'tasks');
				$tasks = $chart["real"];
				
				$chart["real"] = round(($timeing+$tasks)/2,0);
				$chart["title"] = $lang["PROJECT_CONTROLLING_STABILITY"];
				$chart["img_name"] = "p_" . $id . "_stability.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?chs=150x90&cht=gm&chd=t:' . $chart["real"];
				
				$chart["tendency"] = "tendency_negative.png";
				if($chart["real"] >= 50) {
					$chart["tendency"] = "tendency_positive.png";
				}
				
				if($image == 1) {
					$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				}
				
			break;
			case 'realisation':
				$tasks = $this->getNumTasks($id);
				$tasks_done = $this->getNumTasks($id,1);
				
				if($tasks == 0) {
					$chart["real"] = 0;
				} else {
					$chart["real"] = round((100/$tasks)*$tasks_done,2);
				}
				
				$chart["tendency"] = "tendency_negative.png";
				$qt = "SELECT MAX(donedate) as dt,enddate FROM " . CO_TBL_PROJECTS_PHASES_TASKS. " WHERE status='1' and pid='$id' and bin='0'";
				$resultt = mysql_query($qt, $this->_db->connection);
				$ten = mysql_fetch_assoc($resultt);
				if($ten["dt"] <= $ten["enddate"]) {
					$chart["tendency"] = "tendency_positive.png";
				}
				
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = $lang["PROJECT_CONTROLLING_REALISATION"];
				$chart["img_name"] = "p_" . $id . "_realisation.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
				
				if($image == 1) {
					$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				}
				
			break;
			case 'timeing':
				$today = date("Y-m-d");
				
				$tasks_done = $this->getNumTasks($id,""," and enddate < '$today'");
				$tasks_done_ontime = $this->getNumTasks($id,1," and donedate <= enddate and enddate < '$today'");
				
				$meetings_done = $this->getNumMeetings($id,""," and item_date < '$today'");
				$meetings_done_ontime = $this->getNumMeetings($id,1," and item_date < '$today'");
				
				$divider = 2; // wenn zb keine Besprech dann devider = 1
				
				if($tasks_done == 0) {
					$task_time = 0;
					$divider = 1;
				} else {
					$task_time = (100/$tasks_done)*$tasks_done_ontime;
				}
				
				if($meetings_done == 0) {
					$meeting_time = 0;
					$divider = 1;
				} else {
					$meeting_time = (100/$meetings_done)*$meetings_done_ontime;
				}
				
				$chart["real"] = round(($task_time + $meeting_time) / $divider,2);
				
				$chart["tendency"] = "tendency_positive.png";
				$qt = "SELECT COUNT(id) FROM " . CO_TBL_PROJECTS_PHASES_TASKS. " WHERE status='0' and startdate < '$today' and enddate >= '$today' and pid='$id' and bin='0'";
				$resultt = mysql_query($qt, $this->_db->connection);
				$tasks_active = mysql_result($resultt,0);
				
				$qo = "SELECT COUNT(id) FROM " . CO_TBL_PROJECTS_PHASES_TASKS. " WHERE status='0' and enddate < '$today' and pid='$id' and bin='0'";
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
				$chart["title"] = $lang["PROJECT_CONTROLLING_ADHERANCE"];
				$chart["img_name"] = "p_" . $id . "_timeing.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
				
				if($image == 1) {
					$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				}
				
			break;
			case 'tasks':
				$today = date("Y-m-d");
				
				$tasks_done = $this->getNumTasks($id,""," and enddate < '$today'");
				$tasks_done_ontime = $this->getNumTasks($id,1," and donedate <= enddate and enddate < '$today'");
				
				if($tasks_done == 0) {
					$chart["real"] = 0;
				} else {
					$chart["real"] = round((100/$tasks_done)*$tasks_done_ontime,2);
				}
				
				$chart["tendency"] = "tendency_positive.png";
				$qt = "SELECT status,donedate,enddate FROM " . CO_TBL_PROJECTS_PHASES_TASKS. " WHERE enddate < '$today' and pid='$id' and bin='0' ORDER BY enddate DESC LIMIT 0,1";
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
				$chart["title"] = $lang["PROJECT_CONTROLLING_TASKS"];
				$chart["img_name"] = "p_" . $id . "_tasks.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';

				if($image == 1) {
					$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				}
			break;
			case 'status':

				// all
				$q = "SELECT id FROM " . CO_TBL_PROJECTS_PHASES. " WHERE pid = '$id' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$all = mysql_num_rows($result);
				
				// planned
				$q = "SELECT id FROM " . CO_TBL_PROJECTS_PHASES. " WHERE pid = '$id' and status = '0' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$planned = mysql_num_rows($result);
				$chart["planned"] = 0;
				if($planned != 0) {
					$chart["planned"] = round((100/$all)*$planned,0);
				}
				
				// inprogress
				$q = "SELECT id FROM " . CO_TBL_PROJECTS_PHASES. " WHERE pid = '$id' and status = '1' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$inprogress = mysql_num_rows($result);
				$chart["inprogress"] = 0;
				if($inprogress != 0) {
					$chart["inprogress"] = round((100/$all)*$inprogress,0);
				}
				// finished
				$q = "SELECT id FROM " . CO_TBL_PROJECTS_PHASES. " WHERE pid = '$id' and status = '2' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$finished = mysql_num_rows($result);
				$chart["finished"] = 0;
				if($finished != 0) {
					$chart["finished"] = round((100/$all)*$finished,0);
				}			

				$chart["title"] = $lang["PROJECT_FOLDER_CHART_STATUS"];
				$chart["img_name"] = 'projects_controlling_' . $id . "_status.png";
				if($all == 0) {
					$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:0,100&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
				} else {
					$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["planned"]. ',' .$chart["inprogress"] . ',' .$chart["finished"] . '&chs=150x90&chco=4BA0C8|FFD20A|82AA0B&chf=bg,s,FFFFFF';
				}
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
			break;
		}
		
		return $chart;
   }


}

$projectsControllingModel = new ProjectsControllingModel();
?>
<?php

class TrainingsControllingModel extends TrainingsModel {
	
	public function __construct() {  
		parent::__construct();
		$this->_contactsmodel = new ContactsModel();
	}
	
	function getList($id,$sort) {
		global $session, $lang;

			$array["id"] = 0;
			$array["controlling_date"] = $this->_date->formatDate("now",CO_DATE_FORMAT);
			$array["title"] = $lang["TRAINING_CONTROLLING_STATUS"];
			$array["itemstatus"] = "";
			
			$controlling[] = new Lists($array);
		
	  $arr = array("controlling" => $controlling, "sort" => 0);
	  return $arr;
	}
	
	
	function getDetails($pid) {
		global $session;
		
		$array["id"] = $pid;
		$array["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		
		$array["invitations"] = $this->getNumMembers($pid, "invitations");
		$array["registrations"] = $this->getNumMembers($pid, "registrations");
		$array["tookparts"] = $this->getNumMembers($pid, "tookparts");
		
		
		$q = "SELECT id FROM " . CO_TBL_TRAININGS_MEMBERS . " where invitation='1' and pid = '$pid' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		$invitations = mysql_num_rows($result);
		
		$q = "SELECT id FROM " . CO_TBL_TRAININGS_MEMBERS . " where registration='1' and pid = '$pid' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		$registrations = mysql_num_rows($result);
		
		if($invitations == 0) {
			$array['total_regs'] = 0;
		} else {
			$array['total_regs'] = round(100/$invitations*$registrations,0);
		}
		
		$q = "SELECT id FROM " . CO_TBL_TRAININGS_MEMBERS . " where tookpart='1' and pid = '$pid' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		$attendees = mysql_num_rows($result);
		
		if($invitations == 0) {
			$array['total_attendees'] = 0;
		} else {
			$array['total_attendees'] = round(100/$invitations*$attendees,0);
		}
		
		
		$q = "SELECT * FROM " . CO_TBL_TRAININGS_MEMBERS . " where tookpart='1' and pid = '$pid' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			$members = 1;
		} else {
			$members = mysql_num_rows($result);
		}
		$total_result = 0;
		$feedback_q1 = 0;
		$feedback_q2 = 0;
		$feedback_q3 = 0;
		$feedback_q4 = 0;
		$feedback_q5 = 0;
		while ($row = mysql_fetch_array($result)) {
			//$row = mysql_fetch_array($result);
			foreach($row as $key => $val) {
				$array[$key] = $val;
			}
		
			
			$array["q1_result"] = 0;
			$array["q2_result"] = 0;
			$array["q3_result"] = 0;
			$array["q4_result"] = 0;
			$array["q5_result"] = 0;
			if(!empty($array["feedback_q1"])) { $feedback_q1 += $array["feedback_q1"]; $total_result += $array["feedback_q1"]; }
			if(!empty($array["feedback_q2"])) { $feedback_q2 += $array["feedback_q2"]; $total_result += $array["feedback_q2"]; }
			if(!empty($array["feedback_q3"])) { $feedback_q3 += $array["feedback_q3"]; $total_result += $array["feedback_q3"]; }
			if(!empty($array["feedback_q4"])) { $feedback_q4 += $array["feedback_q4"]; $total_result += $array["feedback_q4"]; }
			if(!empty($array["feedback_q5"])) { $feedback_q5 += $array["feedback_q5"]; $total_result += $array["feedback_q5"]; }

		}
		$array["pid"] = $pid;
		$array["q1_result"] = round($feedback_q1*20/$members,0);
		$array["q2_result"] = round($feedback_q2*20/$members,0);
		$array["q3_result"] = round($feedback_q3*20/$members,0);
		$array["q4_result"] = round($feedback_q4*20/$members,0);
		$array["q5_result"] = round($feedback_q5*20/$members,0);
		$array["total_result"] = round((100/25*$total_result)/$members,0);
		$array["today"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		
		
		$q = "SELECT status FROM " . CO_TBL_TRAININGS . " where id = '$pid'";
		$result = mysql_query($q, $this->_db->connection);
		$status = mysql_result($result,0);
		switch($status) {
			case "0":
				$status_percent = 0;
			break;
			case "1":
				$status_percent = 50;
			break;
			case "2":
				$status_percent = 100;
			break;
			case "3":
				$status_percent = 0;
			break;
		}
		
		$array["stability"] = round(($array["total_result"]+$array['total_attendees']+$status_percent)/3,0);
		
		$controlling = new Lists($array);
		return $controlling;
   }
   
   	function getNumMembers($id,$status, $sql="") {
		switch($status) {
			case "invitations":
				$sql .= " and invitation = '1'";
			break;
			case "registrations":
				$sql .= " and registration = '1'";
			break;
			case "tookparts":
				$sql .= " and tookpart = '1'";
			break;
			
		}
		
	   $q = "SELECT COUNT(id) FROM " .  CO_TBL_TRAININGS_MEMBERS. " WHERE pid='$id' $sql and bin='0'";
	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function getNumTasks($id,$status = 0,$sql="") {
	   //$sql = "";
	   if ($status == 1) {
		   $sql .= " and status='1' ";
	   }
	   $q = "SELECT COUNT(id) FROM " .  CO_TBL_TRAININGS_PHASES_TASKS. " WHERE pid='$id' $sql and bin='0'";
	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   
	function getNumMeetings($id,$status = 0,$sql="") {
	   //$sql = "";
	   if ($status == 1) {
		   $sql .= " and status='1' ";
	   }
	   $q = "SELECT COUNT(id) FROM " .  CO_TBL_TRAININGS_MEETINGS. " WHERE pid='$id' $sql and bin='0'";
	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   
   // Daily Cron
   function getDailyStatistic() {
		global $session;
		// select all trainings that are active ie startdate is < today and endfdate > today or status != 2
		$today = date("Y-m-d");
		//$str = "";
		$q = "SELECT a.id,a.status,(SELECT MIN(startdate) FROM " . CO_TBL_TRAININGS_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as startdate ,(SELECT MAX(enddate) FROM " . CO_TBL_TRAININGS_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as enddate FROM " . CO_TBL_TRAININGS . " as a where a.bin='0'";

		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			if($row["startdate"] < $today && $row["status"] != '2') {
				//$str .= $row["id"] . " : ";
				$id = $row["id"];
				$chart = $this->getChart($id, "stability", $image = 0);
				$res = $chart["real"];
				//$str .= $chart["real"];
						$qs = "INSERT INTO " . CO_TBL_TRAININGS_STATISICS . " set pid = '$id', result = '$res'";
						$results = mysql_query($qs, $this->_db->connection);
				
				
			}
		}
		
		//return $str;
	}

   
   
   function getChart($id, $what, $value, $image = 1) { 
		global $lang;
		switch($what) {
			case 'stability':
				$chart["real"] = $value;
				$chart["title"] = $lang["TRAINING_FOLDER_CHART_STABILITY"];
				$chart["img_name"] = "project_" . $id . "_stability.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?chs=150x90&cht=gm&chd=t:' . $chart["real"];
				
				$chart["tendency"] = "pixel.gif";
				//$chart["tendency"] = "tendency_negative.png";
				/*if($chart["real"] >= 50) {
					$chart["tendency"] = "tendency_positive.png";
				}*/
				
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				
			break;
			case 'feedbacks':
				$chart["real"] = $value;
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = $lang["TRAINING_CONTROLLING_CHART_FEEDBACKS"];
				$chart["img_name"] = "t_controlling_" . $id . "_feedbacks.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
				
				$chart["tendency"] = "pixel.gif";
				
				if($image == 1) {
					$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				}
				
			break;
			case 'registrations':
				$chart["real"] = $value;
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = $lang["TRAINING_CONTROLLING_CHART_REGISTRATIONS"];
				$chart["img_name"] = "t_controlling_" . $id . "_registrations.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
				
				$chart["tendency"] = "pixel.gif";
				
				if($image == 1) {
					$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				}
				
			break;
			case 'attendees':
				$chart["real"] = $value;
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = $lang["TRAINING_CONTROLLING_CHART_ATTENDEES"];
				$chart["img_name"] = "t_controlling_" . $id . "_registrations.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
				
				$chart["tendency"] = "pixel.gif";
				
				if($image == 1) {
					$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				}
				
			break;
		}
		
		return $chart;
   }


}

$trainingsControllingModel = new TrainingsControllingModel();
?>
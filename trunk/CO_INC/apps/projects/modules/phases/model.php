<?php

class PhasesModel extends ProjectsModel {
	
	public function __construct() {  
		parent::__construct();
		$this->_contactsmodel = new ContactsModel();
		
	}
	
	function getList($id,$sort) {
		global $session;
		if($sort == 0) {
			$sortstatus = $this->getSortStatus("phase-sort-status",$id);
			if(!$sortstatus) {
				$order = "order by startdate";
				$sortcur = '1';
			} else {
				switch($sortstatus) {
					case "1":
				  		$order = "order by startdate";
						$sortcur = '1';
				  	break;
				  	case "2":
				  		$order = "order by startdate DESC";
						$sortcur = '2';
				  	break;
				  	case "3":
				  		$sortorder = $this->getSortOrder("phase-sort-order",$id);
				  		if(!$sortorder) {
							$order = "order by startdate";
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
				  		$order = "order by startdate";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by startdate DESC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("phase-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by startdate";
								$sortcur = '1';
						  } else {
								$order = "order by field(id,$sortorder)";
								$sortcur = '3';
						  }
				  break;	
			  }
		}
	  
		//$q = "select title,id,access,status,startdate,enddate from " . CO_TBL_PHASES . " where pid = '$id' and bin != '1' " . $order;
		
		$q = "select a.title,a.id,a.access,a.status,(SELECT MIN(startdate) FROM " . CO_TBL_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as startdate from " . CO_TBL_PHASES . " as a where a.pid = '$id' and a.bin != '1' " . $order;
		
	  	$this->setSortStatus("phase-sort-status",$sortcur,$id);
		$result = mysql_query($q, $this->_db->connection);
	  	$phases = "";
		
	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			
			// access
			$accessstatus = "";
			if($array["access"] == 1) {
				$accessstatus = " module-access-active";
			}
			$array["accessstatus"] = $accessstatus;
			// status
			$itemstatus = "";
			if($array["status"] == 2) {
				$itemstatus = " module-item-active";
			}
			$array["itemstatus"] = $itemstatus;
			
			$phases[] = new Lists($array);
		}
		
		// generate phase numbering
		$num = "";
		
		$qn = "select a.id,(SELECT MIN(startdate) FROM " . CO_TBL_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as startdate from " . CO_TBL_PHASES . " as a where a.pid = '$id' and a.bin != '1' order by startdate";
		$resultn = mysql_query($qn, $this->_db->connection);
		$i = 1;
		while ($rown = mysql_fetch_array($resultn)) {
			$num[$rown["id"]] = $i;
			$i++;
		}
		
		$arr = array("phases" => $phases, "sort" => $sortcur, "num" => $num);
		return $arr;
	}
	
	
	// Get phase list from ids for Tooltips
	function getPhaseDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			$q = "SELECT id,title from " . CO_TBL_PHASES . " where id = '$value'";
			$result_user = mysql_query($q, $this->_db->connection);
			while($row_user = mysql_fetch_assoc($result_user)) {
				$users .= '<span class="groupmember tooltip-advanced" uid="' . $row_user["id"] . '">' . $row_user["title"] . '</span><div style="display:none"><a href="delete" class="markfordeletionNEW" uid="' . $row_user["id"] . '" field="' . $field . '">X</a><br /></div>';
				if($i < $users_total) {
					$users .= ', ';
				}
			}
			$i++;
		}
		return $users;
	}


	function getPhaseTitle($id){
		$q = "SELECT title from " . CO_TBL_PHASES . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		return $title;
	}


	function getDependency($id){
		$q = "SELECT title FROM " . CO_TBL_PHASES . " where dependency = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		return mysql_num_rows($result);
	}


	function getDetails($id,$num) {
		global $session, $lang;
		
		$this->_documents = new DocumentsModel();
		
		$q = "SELECT a.*,(SELECT MIN(startdate) FROM " . CO_TBL_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as startdate,(SELECT MAX(enddate) FROM " . CO_TBL_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as enddate, (SELECT startdate FROM " . CO_TBL_PROJECTS . " WHERE id=a.pid) as kickoff FROM " . CO_TBL_PHASES . " as a where a.id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
		
		// dates
		$array["today"] = $this->_date->formatDate("now",CO_DATE_FORMAT);
		$array["startdate"] = $this->_date->formatDate($array["startdate"],CO_DATE_FORMAT);
		$array["enddate"] = $this->_date->formatDate($array["enddate"],CO_DATE_FORMAT);
		$array["dependency_startdate"] = $this->_date->formatDate($row['dependency_startdate'],CO_DATE_FORMAT);
		$array["dependency_enddate"] = $this->_date->formatDate($row['dependency_enddate'],CO_DATE_FORMAT);
		$array["planned_date"] = $this->_date->formatDate($array["planned_date"],CO_DATE_FORMAT);
		$array["inprogress_date"] = $this->_date->formatDate($array["inprogress_date"],CO_DATE_FORMAT);
		$array["finished_date"] = $this->_date->formatDate($array["finished_date"],CO_DATE_FORMAT);
		$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
		
		// other functions
		$array["dependency"] = $this->getPhaseDetails($row['dependency'],'dependency');
		$array["dependency_exists"] = $this->getDependency($id);
		$array["projecttitle"] = $this->getProjectTitle($array['pid']);
		$array["management"] = $this->_contactsmodel->getUserListPlain($this->getProjectField($array['pid'], 'management'));
		//$array["management_ct"] = empty($array["management_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['management_ct'];
		$array["team"] = $this->_contactsmodel->getUserList($array['team'],'team');
		$array["team_ct"] = empty($array["team_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['team_ct'];
		$array["documents"] = $this->_documents->getDocListFromIDs($array["documents"],'documents');
		
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		$array["current_user"] = $session->uid;
		$array["num"] = $num;
		
		switch($array["access"]) {
			case "0":
				$array["access_text"] = $lang["GLOBAL_ACCESS_INTERNAL"];
				$array["access_footer"] = "";
			break;
			case "1":
				$array["access_text"] = $lang["GLOBAL_ACCESS_PUBLIC"];
				$array["access_user"] = $this->_users->getUserFullname($array["access_user"]);
				$array["access_date"] = $this->_date->formatDate($array["access_date"],CO_DATETIME_FORMAT);
				$array["access_footer"] = $lang["GLOBAL_ACCESS_FOOTER"] . " " . $array["access_user"] . ", " .$array["access_date"];
			break;
		}
		
		// status
		switch($array["status"]) {
			case "0":
				$array["status_text"] = $lang["PROJECT_STATUS_PLANNED"];
				$array["status_date"] = $array["planned_date"];
			break;
			case "1":
				$array["status_text"] = $lang["PROJECT_STATUS_INPROGRESS"];
				$array["status_date"] = $array["inprogress_date"];
			break;
			case "2":
				$array["status_text"] = $lang["PROJECT_STATUS_FINISHED"];
				$array["status_date"] = $array["finished_date"];
			break;
		}
		
		// get user perms
		$array["edit"] = "1";
		
		$phase = new Lists($array);
		
		// get the tasks
		$task = array();
		$qt = "SELECT * FROM " . CO_TBL_PHASES_TASKS . " where phaseid = '$id' and bin='0' ORDER BY startdate,status";
		$resultt = mysql_query($qt, $this->_db->connection);
		while($rowt = mysql_fetch_array($resultt)) {
			foreach($rowt as $key => $val) {
				$tasks[$key] = $val;
				
			}
				
			$tasks["startdate"] = $this->_date->formatDate($tasks["startdate"],CO_DATE_FORMAT);
			$tasks["enddate"] = $this->_date->formatDate($tasks["enddate"],CO_DATE_FORMAT);
			$tasks["donedate"] = $this->_date->formatDate($tasks["donedate"],CO_DATE_FORMAT);
				
			$tasks["dependent_title"] = "";
			if($tasks["dependent"] > 0) {
				$dep = $tasks["dependent"];
				$qta = "SELECT text FROM " . CO_TBL_PHASES_TASKS . " where id='$dep' and bin='0'";
				$rqta = mysql_query($qta, $this->_db->connection);
				if(mysql_num_rows($rqta) == 0) {
					$tasks["dependent_title"] = "";
					$tasks["dependent"] = 0;
				} else {
					$tasks["dependent_title"] = mysql_result($rqta,0);
				}
			}
			
			$task[] = new Lists($tasks);
		}
		$arr = array("phase" => $phase, "task" => $task);
		return $arr;
	}


	function setDetails($id,$title,$team,$team_ct,$protocol,$documents,$phase_access,$phase_access_orig,$phase_status,$phase_status_date,$task_startdate,$task_enddate,$task_donedate,$task_id,$task_text,$task,$task_cat,$task_dependent) {
		global $session, $system;

		$phase_status_date = $this->_date->formatDate($phase_status_date);
		
		// user lists
		$team = $this->_contactsmodel->sortUserIDsByName($team);
		
		switch($phase_status) {
			case "0":
				$sql = "planned_date";
			break;
			case "1":
				$sql = "inprogress_date";
			break;
			case "2":
				$sql = "finished_date";
			break;
		}
		
		$now = gmdate("Y-m-d H:i:s");
		
		if($phase_access == $phase_access_orig) {
			$accesssql = "";
		} else {
			$phase_access_date = "";
			if($phase_access == 1) {
				$phase_access_date = $now;
			}
			$accesssql = "access='$phase_access', access_date='$phase_access_date', access_user = '$session->uid',";
		}
		
		$q = "UPDATE " . CO_TBL_PHASES . " set title = '$title', team='$team', team_ct = '$team_ct', protocol = '$protocol', documents='$documents', $accesssql status = '$phase_status', $sql = '$phase_status_date', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		
		// do tasks
		$task_size = sizeof($task_id);
		foreach ($task_id as $key => $value) {
			if (is_array($task)) {
				if (in_array($task_id[$key], $task) == true) {
					$checked_items[$key] = '1';
				} else {
					$checked_items[$key] = '0';
				}
			} else {
				$checked_items[$key] = '0';
			}
			$start = $this->_date->formatDate($task_startdate[$key]);
			$end = $this->_date->formatDate($task_enddate[$key]);
			$donedate = $this->_date->formatDate($task_donedate[$key]);
			$datearray[]= $start;
			if($task_enddate[$key] != "") {
				$datearray[]= $end;
			}
				
				if($task_cat[$key] == 1) {
					$end = $start;
				}

				$q = "UPDATE " . CO_TBL_PHASES_TASKS . " set status = '$checked_items[$key]', donedate='$donedate', dependent = '$task_dependent[$key]', text = '$task_text[$key]', startdate = '$start', enddate = '$end' WHERE id='$task_id[$key]'";
				$result = mysql_query($q, $this->_db->connection);
		}
		
		if (!in_array('0', $checked_items)) {
    		//all tasks done
			
		}
		
		$startdate =  $this->_date->formatDate(min($datearray),CO_DATE_FORMAT);
		$enddate =  $this->_date->formatDate(max($datearray),CO_DATE_FORMAT);
		
		if ($result) {
			$arr = array("id" => $id, "startdate" => $startdate, "enddate" => $enddate, "status" => "2");
			return $arr;
		}
	}


	function createNew($pid,$num) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$title = $lang["PHASE_NEW"];
		
		// get some presets from project
		$q = "SELECT startdate, management, team FROM " . CO_TBL_PROJECTS . " where id = '$pid'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_assoc($result);
		
		$management = $row["management"];
		$team = $row["team"];
		$startdate = $row["startdate"];
		
		// add phase
		$q = "INSERT INTO " . CO_TBL_PHASES . " set title = '$title', pid='$pid', management = '$management', team='$team', access='0', status = '0', planned_date = '$now', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		
		// calculate dates to use for first task
		// 
		$q = "SELECT MAX(enddate) FROM " . CO_TBL_PHASES_TASKS . " WHERE pid='$pid' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_result($result,0) != "") {
			$date = mysql_result($result,0);
			$startdate = $this->_date->addDays($date,"1");
			//$enddate = $this->_date->addDays($date,"1");
			$enddate = $startdate;
		} else {
			$startdate = $this->_date->addDays($startdate,"1");
			//$enddate = $this->_date->addDays($startdate,"1");
			$enddate = $startdate;
		}
		
		$text = $lang["PHASE_TASK_NEW"];
		
		// add first task 1 week starting from last phase or kick off plus 1 day
		$q = "INSERT INTO " . CO_TBL_PHASES_TASKS . " set pid='$pid', phaseid='$id', status = '0', text = 'Aktivität 1', startdate = '$startdate', enddate = '$enddate'";
			$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return $id;
		}
	}


	function createDuplicate($id) {
		global $session, $lang;
		// phase
		$q = "INSERT INTO " . CO_TBL_PHASES . " (pid,title,team,management) SELECT pid,CONCAT(title,' ".$lang["GLOBAL_DUPLICAT"]."'),team,management FROM " . CO_TBL_PHASES . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		// tasks
		//$qt = "INSERT INTO " . CO_TBL_PHASES_TASKS . " (pid,phaseid,cat,status,text,startdate,enddate) SELECT pid,$id_new,cat,'0',text,startdate,enddate FROM " . CO_TBL_PHASES_TASKS . " where phaseid='$id' and bin='0'";
		//$resultt = mysql_query($qt, $this->_db->connection);
		// tasks
		$qt = "SELECT id,pid,dependent,cat,text,startdate,enddate FROM " . CO_TBL_PHASES_TASKS . " where phaseid='$id' and bin='0' ORDER BY startdate,status";		
		$resultt = mysql_query($qt, $this->_db->connection);
		while($rowt = mysql_fetch_array($resultt)) {
			$id = $rowt["id"];
			$pid = $rowt["pid"];
			$cat = $rowt["cat"];
			$text = $rowt["text"];
			$startdate = $rowt["startdate"];
			$enddate = $rowt["enddate"];
			$dependent = $rowt["dependent"];
			$qtn = "INSERT INTO " . CO_TBL_PHASES_TASKS . " set pid = '$pid', phaseid = '$id_new', dependent = '$dependent', cat = '$cat', status = '0', text = '$text', startdate = '$startdate', enddate = '$enddate'";
			$rpn = mysql_query($qtn, $this->_db->connection);
			$id_t_new = mysql_insert_id();
			// BUILD OLD NEW TASK ID ARRAY
			$t[$id] = $id_t_new;
		}
		// Updates Dependencies for new tasks
		$qt = "SELECT id,dependent FROM " . CO_TBL_PHASES_TASKS . " where phaseid='$id_new' and bin='0'";		
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
		
		
		
		if ($result) {
			return $id_new;
		}
	}

	function phaseTest() {
		echo("success");
	}
	

   function binPhase($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PHASES . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "UPDATE " . CO_TBL_PHASES_TASKS . " set bin = '1' where phaseid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
		  	return true;
		}
	}
   
   
	function toggleIntern($id,$status) {
		global $session;
		$q = "UPDATE " . CO_TBL_PHASES . " set intern = '$status' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}


	function addTask($pid,$phid,$date,$cat) {
		global $session, $lang;
		$date = $this->_date->addDays($date,1);
		
		switch($cat) {
			case "1": 
				$text = $lang["PHASE_MILESTONE_NEW"];
			break;
			default:
				$text = $lang["PHASE_TASK_NEW"];
		}
		
		$q = "INSERT INTO " . CO_TBL_PHASES_TASKS . " set pid='$pid', phaseid='$phid', status = '0', text = '$text', startdate = '$date', enddate = '$date', cat = '$cat'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		
		$task = array();
		$q = "SELECT * FROM " . CO_TBL_PHASES_TASKS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$tasks[$key] = $val;
			}
			
			$tasks["startdate"] = $this->_date->formatDate($tasks["startdate"],CO_DATE_FORMAT);
			$tasks["enddate"] = $this->_date->formatDate($tasks["enddate"],CO_DATE_FORMAT);
			$tasks["today"] = $this->_date->formatDate("now",CO_DATE_FORMAT);
				
			$tasks["dependent_title"] = "";
			$task[] = new Lists($tasks);
		}
		return $task;
	}


    // dialog for selecting dependent tasks
	function getTasksDialog($id,$field) {
		$q = "SELECT pid,startdate FROM " . CO_TBL_PHASES_TASKS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_assoc($result);
		$pid = $row["pid"];
		$startdate = $row["startdate"];
	 
		$str = '<div class="dialog-text">';
	 	$str .= '<a href="#" class="insertTaskfromDialog" title="" field="' . $field . '" gid="">keine Abhängigkeit</a>';

		
		$q ="select id,text from " . CO_TBL_PHASES_TASKS . " where pid = '$pid' and startdate <= '$startdate' and id != '$id' and bin = '0' ORDER BY startdate";
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$str .= '<a href="#" class="insertTaskfromDialog" title="' . $row["text"] . '" field="' . $field . '" gid="'.$row["id"].'">' . $row["text"] . '</a>';
		}
		$str .= '</div>';	
		return $str;
	}
   

	function deleteTask($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PHASES_TASKS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if($result) {
			return true;
		}
	}

}
?>
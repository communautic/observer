<?php

class ProjectsPhasesModel extends ProjectsModel {
	
	public function __construct() {  
		parent::__construct();
		$this->_contactsmodel = new ContactsModel();
		
	}
	
	function getList($id,$sort) {
		global $session;
		if($sort == 0) {
			$sortstatus = $this->getSortStatus("projects-phases-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("projects-phases-sort-order",$id);
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
				  		$sortorder = $this->getSortOrder("projects-phases-sort-order",$id);
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
	  
		$perm = $this->getProjectAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and a.access = '1' ";
		}
		
		$q = "select a.title,a.id,a.access,a.status,a.checked_out,a.checked_out_user,(SELECT MIN(startdate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as startdate from " . CO_TBL_PROJECTS_PHASES . " as a where a.pid = '$id' and a.bin != '1' " . $sql . $order;
		
	  	$this->setSortStatus("projects-phases-sort-status",$sortcur,$id);
		$result = mysql_query($q, $this->_db->connection);
	  	$phases = "";
		
	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			
			// access
			$accessstatus = "";
			if($perm !=  "guest") {
				if($array["access"] == 1) {
					$accessstatus = " module-access-active";
				}
			}
			$array["accessstatus"] = $accessstatus;
			// status
			$itemstatus = "";
			if($array["status"] == 2) {
				$itemstatus = " module-item-active";
			}
			$array["itemstatus"] = $itemstatus;
			
			$checked_out_status = "";
			if($perm !=  "guest" && $array["checked_out"] == 1 && $array["checked_out_user"] != $session->uid) {
				//$checked_out_status = "icon-checked-out-active";
				if($session->checkUserActive($array["checked_out_user"])) {
					$checked_out_status = "icon-checked-out-active";
				} else {
					$this->checkinPhaseOverride($id);
				}
			}
			$array["checked_out_status"] = $checked_out_status;
			
			$phases[] = new Lists($array);
		}
		
		// generate phase numbering
		$num = "";
		
		$qn = "select a.id,(SELECT MIN(startdate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as startdate from " . CO_TBL_PROJECTS_PHASES . " as a where a.pid = '$id' and a.bin != '1'" . $sql . " order by startdate";
		$resultn = mysql_query($qn, $this->_db->connection);
		$i = 1;
		while ($rown = mysql_fetch_array($resultn)) {
			$num[$rown["id"]] = $i;
			$i++;
		}
		
		$arr = array("phases" => $phases, "sort" => $sortcur, "num" => $num, "perm" => $perm);
		return $arr;
	}
	
	function checkoutPhase($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_PROJECTS_PHASES . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function checkinPhase($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_PROJECTS_PHASES . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_PROJECTS_PHASES . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}
	
	
	function checkinPhaseOverride($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PROJECTS_PHASES . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	
	
	// Get phase list from ids for Tooltips
	function getPhaseDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			$q = "SELECT id,title from " . CO_TBL_PROJECTS_PHASES . " where id = '$value'";
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
		$q = "SELECT title from " . CO_TBL_PROJECTS_PHASES . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		return $title;
	}
	

	function getDependency($id){
		$q = "SELECT title FROM " . CO_TBL_PROJECTS_PHASES . " where dependency = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		return mysql_num_rows($result);
	}


	function getDetails($id,$num, $option = "") {
		global $session, $lang;
		
		$this->_documents = new ProjectsDocumentsModel();
		
		$q = "SELECT a.*,(SELECT MIN(startdate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as startdate,(SELECT MAX(enddate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as enddate, (SELECT startdate FROM " . CO_TBL_PROJECTS . " WHERE id=a.pid) as kickoff FROM " . CO_TBL_PROJECTS_PHASES . " as a where a.id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
		
		foreach($this->getProjectSettings($array["pid"]) as $key => $val) {
			$array[$key] = $val;
		}
		
		$array["perms"] = $this->getProjectAccess($array["pid"]);
		$array["canedit"] = false;
		$array["showCheckout"] = false;		
		$array["checked_out_user_text"] = $this->_contactsmodel->getUserListPlain($array['checked_out_user']);
		
		if($array["perms"] == "sysadmin" || $array["perms"] == "admin") {
			//if($array["checked_out"] == 1 && $session->checkUserActive($array["checked_out_user"])) {
			if($array["checked_out"] == 1) {
				if($array["checked_out_user"] == $session->uid) {
					$array["canedit"] = true;
				} else if(!$session->checkUserActive($array["checked_out_user"])) {
					$array["canedit"] = $this->checkoutPhase($id);
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
					$array["checked_out_user_phone1"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
					$array["checked_out_user_email"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");

				}
			} else {
				$array["canedit"] = $this->checkoutPhase($id);
			}
		}
		
		// dates
		$array["today"] = $this->_date->formatDate("now",CO_DATE_FORMAT);
		$array["startdate"] = $this->_date->formatDate($array["startdate"],CO_DATE_FORMAT);
		$array["kickoff"] = $this->_date->formatDate($array["kickoff"],CO_DATE_FORMAT);
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
		$array["team_print"] = $this->_contactsmodel->getUserListPlain($array["team"]);
		if($option = 'prepareSendTo') {
			$array["sendtoTeam"] = $this->_contactsmodel->checkUserListEmail($array["team"],'projectsteam', "", $array["canedit"]);
			$array["sendtoTeamNoEmail"] = $this->_contactsmodel->checkUserListEmail($array["team"],'projectsteam', "", $array["canedit"], 0);
			$array["sendtoError"] = false;
		}
		$array["team"] = $this->_contactsmodel->getUserList($array['team'],'projectsteam', "", $array["canedit"]);
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
		$array["status_planned_active"] = "";
		$array["status_inprogress_active"] = "";
		$array["status_finished_active"] = "";
		switch($array["status"]) {
			case "0":
				$array["status_text"] = $lang["GLOBAL_STATUS_PLANNED"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_PLANNED_TIME"];
				$array["status_planned_active"] = " active";
				$array["status_date"] = $array["planned_date"];
			break;
			case "1":
				$array["status_text"] = $lang["GLOBAL_STATUS_INPROGRESS"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_INPROGRESS_TIME"];
				$array["status_inprogress_active"] = " active";
				$array["status_date"] = $array["inprogress_date"];
			break;
			case "2":
				$array["status_text"] = $lang["GLOBAL_STATUS_FINISHED"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_FINISHED_TIME"];
				$array["status_finished_active"] = " active";
				$array["status_date"] = $array["finished_date"];
			break;
		}

		// checkpoint
		$array["checkpoint"] = 0;
		$array["checkpoint_date"] = "";
		$q = "SELECT date FROM " . CO_TBL_USERS_CHECKPOINTS . " where uid='$session->uid' and app = 'projects' and module = 'phases' and app_id = '$id' LIMIT 1";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			while ($row = mysql_fetch_assoc($result)) {
			$array["checkpoint"] = 1;
			$array["checkpoint_date"] = $this->_date->formatDate($row['date'],CO_DATE_FORMAT);
			}
		}
		
		$array["costs_plan_total"] = 0;
		$array["costs_real_total"] = 0;
		// get the tasks
		$task = array();
		$qt = "SELECT * FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " where phaseid = '$id' and bin='0' ORDER BY startdate";
		$resultt = mysql_query($qt, $this->_db->connection);
		while($rowt = mysql_fetch_array($resultt)) {
			$tasks["costs_plan"] = 0;
			$tasks["costs_employees"] = 0;
			$tasks["costs_materials"] = 0;
			$tasks["costs_external"] = 0;
			$tasks["costs_other"] = 0;
			$tasks["costs_real"] = 0;
			$tasks["costs_employees_real"] = 0;
			$tasks["costs_materials_real"] = 0;
			$tasks["costs_external_real"] = 0;
			$tasks["costs_other_real"] = 0;
			foreach($rowt as $key => $val) {
				$tasks[$key] = $val;
			}
			$tasks["startdate"] = $this->_date->formatDate($tasks["startdate"],CO_DATE_FORMAT);
			$tasks["enddate"] = $this->_date->formatDate($tasks["enddate"],CO_DATE_FORMAT);
			$tasks["donedate"] = $this->_date->formatDate($tasks["donedate"],CO_DATE_FORMAT);
			$tasks["team"] = $this->_contactsmodel->getUserList($tasks['team'],'task_team_'.$tasks["id"], "", $array["canedit"]);
			$tasks["team_ct"] = empty($tasks["team_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $tasks['team_ct'];
			if($array['setting_costs'] == 1) {
				$tasks["costs_plan"] = $tasks["costs_employees"]+$tasks["costs_materials"]+$tasks["costs_external"]+$tasks["costs_other"];
				$array["costs_plan_total"] += $tasks["costs_plan"];
				$tasks["costs_real"] = $tasks["costs_employees_real"]+$tasks["costs_materials_real"]+$tasks["costs_external_real"]+$tasks["costs_other_real"];
				$array["costs_real_total"] += $tasks["costs_real"];
				$tasks["costs_plan"] = number_format($tasks["costs_plan"],0,',','.');
				$tasks["costs_real"] = number_format($tasks["costs_real"],0,',','.');
			}
			
			$tasks["dependent_title"] = "";
			if($tasks["dependent"] > 0) {
				$dep = $tasks["dependent"];
				$qta = "SELECT text FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " where id='$dep' and bin='0'";
				$rqta = mysql_query($qta, $this->_db->connection);
				if(mysql_num_rows($rqta) == 0) {
					$tasks["dependent_title"] = "";
					$tasks["dependent"] = 0;
				} else {
					$tasks["dependent_title"] = mysql_result($rqta,0);
				}
			}
			
			if($tasks["cat"] == 2) {
				$link_id = $tasks["project_link"];
				// make sure project is available = not bin and not deleted
				$q = "SELECT * FROM " . CO_TBL_PROJECTS . " WHERE id='$link_id' and bin='0'";
				$result = mysql_query($q, $this->_db->connection);
				if(mysql_num_rows($result) > 0) {
					$p = mysql_fetch_object($result);
					$tasks["text"] = $p->title;
					$tasks["link"] = 'projects,'.$p->folder.','.$p->id.',0,projects';
					$tasks["team"] = $this->_contactsmodel->getUserListPlain($p->management);
					switch($p->status) {
						case "0":
							$tasks["status_text"] = $lang["GLOBAL_STATUS_PLANNED"];
							$tasks["status_text_time"] = $lang["GLOBAL_STATUS_PLANNED_TIME"];
							$tasks["status_date"] = $this->_date->formatDate($p->planned_date,CO_DATE_FORMAT);
						break;
						case "1":
							$tasks["status_text"] = $lang["GLOBAL_STATUS_INPROGRESS"];
							$tasks["status_text_time"] = $lang["GLOBAL_STATUS_INPROGRESS_TIME"];
							$tasks["status_date"] = $this->_date->formatDate($p->inprogress_date,CO_DATE_FORMAT);
						break;
						case "2":
							$tasks["status_text"] = $lang["GLOBAL_STATUS_FINISHED"];
							$tasks["status_text_time"] = $lang["GLOBAL_STATUS_FINISHED_TIME"];
							$tasks["status_date"] = $this->_date->formatDate($p->finished_date,CO_DATE_FORMAT);
						break;
						case "3":
							$tasks["status_text"] = $lang["GLOBAL_STATUS_STOPPED"];
							$tasks["status_text_time"] = $lang["GLOBAL_STATUS_STOPPED_TIME"];
							$tasks["status_date"] = $this->_date->formatDate($p->finished_date,CO_DATE_FORMAT);
						break;
					}
					$task[] = new Lists($tasks);
				} 
			} else {
				$task[] = new Lists($tasks);
			}
		}
		if($array['setting_costs'] == 1) {
			$array["costs_plan_total"] = number_format($array["costs_plan_total"],0,',','.');
			$array["costs_real_total"] = number_format($array["costs_real_total"],0,',','.');
		}
		$phase = new Lists($array);
		
		$sendto = $this->getSendtoDetails("projects_phases",$id);
		
		$arr = array("phase" => $phase, "task" => $task, "sendto" => $sendto, "access" => $array["perms"]);
		return $arr;
	}


	function setDetails($id,$title,$team,$team_ct,$protocol,$documents,$phase_access,$phase_access_orig,$task_startdate,$task_enddate,$task_donedate,$task_id,$task_text,$task_protocol,$task,$task_cat,$task_dependent,$task_team,$task_team_ct) {
		global $session, $system;
		
		// user lists
		$team = $this->_contactsmodel->sortUserIDsByName($team);
		
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
		
		$q = "UPDATE " . CO_TBL_PROJECTS_PHASES . " set title = '$title', team='$team', team_ct = '$team_ct', protocol = '$protocol', documents='$documents', $accesssql edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		
		// do tasks
		$task_size = sizeof($task_id);
		$tasks_checked_size = sizeof($task);
		$phasestatus = $this->getStatus($id);
		$changePhaseStatus = 0; // 1 = st to planned 2 = set to complete
		// if only one see if phase is in progress or not
		if($phasestatus != 1 && $tasks_checked_size == 1) {
			$changePhaseStatus = 1;
		}
		if($phasestatus != 2 && $tasks_checked_size == $task_size) {
			$changePhaseStatus = 2;
		}
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
			if(isset($task_team[$key])) {
				$task_team_i = $this->_contactsmodel->sortUserIDsByName($task_team[$key]);
			} else {
				$task_team_i = "";
			}
			
			if(isset($task_team_ct[$key])) {
				$task_team_ct_i = $task_team_ct[$key];
			} else {
				$task_team_ct_i = "";
			}
			$donedate = $this->_date->formatDate($task_donedate[$key]);
			$datearray[]= $start;
			if($task_enddate[$key] != "") {
				$datearray[]= $end;
			}
			if($task_cat[$key] == 1) {
				$end = $start;
			}

			$q = "UPDATE " . CO_TBL_PROJECTS_PHASES_TASKS . " set status = '$checked_items[$key]', donedate='$donedate', dependent = '$task_dependent[$key]', text = '$task_text[$key]', protocol = '$task_protocol[$key]', startdate = '$start', enddate = '$end', team = '$task_team_i', team_ct = '$task_team_ct_i' WHERE id='$task_id[$key]'";
			$result = mysql_query($q, $this->_db->connection);
		}
		
		if (!in_array('0', $checked_items)) {
    		//all tasks done
		}
		
		$startdate =  $this->_date->formatDate(min($datearray),CO_DATE_FORMAT);
		$enddate =  $this->_date->formatDate(max($datearray),CO_DATE_FORMAT);
		
		if ($result) {
			$arr = array("id" => $id, "startdate" => $startdate, "enddate" => $enddate, "status" => "2", "changePhaseStatus" => $changePhaseStatus);
			return $arr;
		}
	}
	
	
	function getStatus($id) {
		$q = "SELECT status FROM " . CO_TBL_PROJECTS_PHASES . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		return mysql_result($result,0);
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
			break;
		}
		$q = "UPDATE " . CO_TBL_PROJECTS_PHASES . " set status = '$status', $sql = '$date', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	
	
	function updateStatusProject($id) {
		$q = "SELECT a.status FROM " . CO_TBL_PROJECTS . " as a, " . CO_TBL_PROJECTS_PHASES . " as b WHERE b.id = '$id' and b.pid = a.id";
		$result = mysql_query($q, $this->_db->connection);
		$status = mysql_result($result,0);
		if($status != 1) {
			return true;
		} else {
			return false;
		}
	}
	
	function checkProjectFinished($id) {
		$q = "SELECT a.status,a.id FROM " . CO_TBL_PROJECTS . " as a, " . CO_TBL_PROJECTS_PHASES . " as b WHERE b.id = '$id' and b.pid = a.id";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_row($result);
		$projectstatus = $row[0];
		$pid = $row[1];
		
		$q = "SELECT status from " . CO_TBL_PROJECTS_PHASES . " WHERE pid = '$pid' and status !='2' and bin = '0';";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			return false;
		} else {
			if($projectstatus != 2) {
				return true;
			} else {
				return false;
			}
		}
	}


	function updateCosts($id, $type, $costs_employees, $costs_materials, $costs_external, $costs_other) {
		switch($type) {
			case "costsplan":
				$q = "UPDATE " . CO_TBL_PROJECTS_PHASES_TASKS . " set costs_employees = '$costs_employees', costs_materials = '$costs_materials', costs_external = '$costs_external', costs_other = '$costs_other' where id='$id'";
			break;
			case "costsreal":
				$q = "UPDATE " . CO_TBL_PROJECTS_PHASES_TASKS . " set costs_employees_real = '$costs_employees', costs_materials_real = '$costs_materials', costs_external_real = '$costs_external', costs_other_real = '$costs_other' where id='$id'";
			break;
		}
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}


	function createNew($pid,$num) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$title = $lang["PROJECT_PHASE_NEW"];
		
		// get some presets from project
		$q = "SELECT startdate, management, team FROM " . CO_TBL_PROJECTS . " where id = '$pid'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_assoc($result);
		
		$management = $row["management"];
		$team = $row["team"];
		$startdate = $row["startdate"];
		
		// add phase
		$q = "INSERT INTO " . CO_TBL_PROJECTS_PHASES . " set title = '$title', pid='$pid', management = '$management', team='$team', access='0', status = '0', planned_date = '$now', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		
		// calculate dates to use for first task
		// 
		$q = "SELECT MAX(enddate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " WHERE pid='$pid' and bin='0'";
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
		
		$text = $lang["PROJECT_PHASE_TASK_NEW"];
		
		// add first task 1 week starting from last phase or kick off plus 1 day
		$q = "INSERT INTO " . CO_TBL_PROJECTS_PHASES_TASKS . " set pid='$pid', phaseid='$id', status = '0', text = '" . $lang["PROJECT_PHASE_TASK_NEW"] . "', startdate = '$startdate', enddate = '$enddate'";
			$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return $id;
		}
	}


	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		// phase
		$q = "INSERT INTO " . CO_TBL_PROJECTS_PHASES . " (pid,title,protocol,team,management,created_date,created_user,edited_date,edited_user) SELECT pid,CONCAT(title,' ".$lang["GLOBAL_DUPLICAT"]."'),protocol,team,management,'$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_PROJECTS_PHASES . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		// tasks
		$qt = "SELECT id,pid,dependent,cat,text,protocol,startdate,enddate,costs_employees,costs_materials,costs_external,costs_other FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " where phaseid='$id' and bin='0' ORDER BY startdate";		
		$resultt = mysql_query($qt, $this->_db->connection);
		while($rowt = mysql_fetch_array($resultt)) {
			$id = $rowt["id"];
			$pid = $rowt["pid"];
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
			$qtn = "INSERT INTO " . CO_TBL_PROJECTS_PHASES_TASKS . " set pid = '$pid', phaseid = '$id_new', dependent = '$dependent', cat = '$cat', status = '0', text = '$text', protocol = '$protocol', startdate = '$startdate', enddate = '$enddate', costs_employees ='$costs_employees', costs_materials ='$costs_materials', costs_external ='$costs_external', costs_other ='$costs_other'";
			$rpn = mysql_query($qtn, $this->_db->connection);
			$id_t_new = mysql_insert_id();
			// BUILD OLD NEW TASK ID ARRAY
			$t[$id] = $id_t_new;
		}
		// Updates Dependencies for new tasks
		$qt = "SELECT id,dependent FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " where phaseid='$id_new' and bin='0'";		
		$resultt = mysql_query($qt, $this->_db->connection);
		while($rowt = mysql_fetch_array($resultt)) {
			$id = $rowt["id"];
			$dep = 0;
			if($rowt["dependent"] != 0) {
				$dependent = $rowt["dependent"];
				$dep = $t[$dependent];
			}
			$qtn = "UPDATE " . CO_TBL_PROJECTS_PHASES_TASKS . " set dependent = '$dep' WHERE id='$id'";
			$rpn = mysql_query($qtn, $this->_db->connection);
		}
		if ($result) {
			return $id_new;
		}
	}
	

   function binPhase($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PROJECTS_PHASES . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "UPDATE " . CO_TBL_PROJECTS_PHASES_TASKS . " set bin = '1' where phaseid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
		  	return true;
		}
	}
	
	function restorePhase($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PROJECTS_PHASES . " set bin = '0', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "UPDATE " . CO_TBL_PROJECTS_PHASES_TASKS . " set bin = '0' where phaseid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
		  	return true;
		}
	}
	
	
	function deletePhase($id) {
		global $session;
		
		$q = "DELETE FROM co_log_sendto WHERE what='projects_phases' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " where phaseid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_PROJECTS_PHASES . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
		  	return true;
		}
	}
   
   
	function toggleIntern($id,$status) {
		global $session;
		$q = "UPDATE " . CO_TBL_PROJECTS_PHASES . " set intern = '$status' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	
	function getPhaseField($id,$field) {
		$q = "SELECT $field FROM " . CO_TBL_PROJECTS_PHASES . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		return mysql_result($result,0);
	}


	function getTaskDependencyExists($id){
		$q = "SELECT id FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " where dependent = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			return true;
		} else {
			return false;
		}
	}
	

	function moveTaskEnd($id,$days){
		$q = "SELECT enddate FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$enddate = $this->_date->addDays($row["enddate"],$days);
			$qt = "UPDATE " . CO_TBL_PROJECTS_PHASES_TASKS . " set enddate = '$enddate' where id='$id'";
			$res = mysql_query($qt, $this->_db->connection);
		}
		//return true;
		return $this->moveDependendTasks($id,$days);
	}

	function checkDependency($id,$date){
		$date = $this->_date->formatDate($date,"Y-m-d");
		// check if moved behind startdate of a dependent task
		$q = "SELECT id, startdate FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " where dependent='$id'";
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$tid = $row["id"];
			if($row["startdate"] < $date) {
				$qt = "UPDATE " . CO_TBL_PROJECTS_PHASES_TASKS . " set dependent = '0' where id='$tid'";
				$res = mysql_query($qt, $this->_db->connection);
			}
		}
		
		// check if moved before startdate of a dependent task
		$q = "SELECT dependent FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$depends_id = mysql_result($result,0);
		
		if($depends_id > 0) {
			$q = "SELECT startdate FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " where id='$depends_id'";
			$result = mysql_query($q, $this->_db->connection);
			$depends_start = mysql_result($result,0);
			
			if($date < $depends_start) {
				$qt = "UPDATE " . CO_TBL_PROJECTS_PHASES_TASKS . " set dependent = '0' where id='$id'";
				$res = mysql_query($qt, $this->_db->connection);
			}
		}
		
		return true;
	}

	function moveDependendTasks($id,$days){
		$q = "SELECT id, startdate, enddate FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " where dependent='$id'";
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$tid = $row["id"];
			$startdate = $this->_date->addDays($row["startdate"],$days);
			$enddate = $this->_date->addDays($row["enddate"],$days);
			$qt = "UPDATE " . CO_TBL_PROJECTS_PHASES_TASKS . " set startdate = '$startdate', enddate = '$enddate' where id='$tid'";
			$res = mysql_query($qt, $this->_db->connection);
			$this->moveDependendTasks($tid,$days);
		}
		return true;
	}


	function addTask($pid,$phid,$date,$cat) {
		global $session, $lang;
		$date = $this->_date->addDays($date,1);
		
		switch($cat) {
			case "1": 
				$text = $lang["PROJECT_PHASE_MILESTONE_NEW"];
				//$team = "";
			break;
			default:
				$text = $lang["PROJECT_PHASE_TASK_NEW"];
				//$team = $this->getPhaseField($phid,'team');
		}
		
		$q = "INSERT INTO " . CO_TBL_PROJECTS_PHASES_TASKS . " set pid='$pid', phaseid='$phid', status = '0', text = '$text', startdate = '$date', enddate = '$date', cat = '$cat'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		
		$task = array();
		foreach($this->getProjectSettings($pid) as $key => $val) {
				$tasks[$key] = $val;
			}
			
		$q = "SELECT * FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$tasks[$key] = $val;
			}
			
			$tasks["startdate"] = $this->_date->formatDate($tasks["startdate"],CO_DATE_FORMAT);
			$tasks["enddate"] = $this->_date->formatDate($tasks["enddate"],CO_DATE_FORMAT);
			$tasks["today"] = $this->_date->formatDate("now",CO_DATE_FORMAT);
			$tasks["dependent_title"] = "";
			$tasks["team"] = $this->_contactsmodel->getUserList($tasks['team'],'team');
			$tasks["costs_plan"] = 0;
			$tasks["costs_real"] = 0;

			$task[] = new Lists($tasks);
		}
		return $task;
	}


	function addProjectLink($id,$pid,$phid) {
		global $session, $lang;
		
		$q = "SELECT a.*,(SELECT MAX(enddate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as enddate FROM " . CO_TBL_PROJECTS . " as a where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$p = mysql_fetch_object($result);

		$title = $p->title;
		$folder = $p->folder;
		$startdb = $p->startdate;
		$startdate = $this->_date->formatDate($p->startdate,CO_DATE_FORMAT);
		$enddb = $p->enddate;
		$enddate = $this->_date->formatDate($p->enddate,CO_DATE_FORMAT);
		
		
		$masterstartdate = $this->getProjectField($pid,'startdate');
		if($masterstartdate > $startdb) {
			$q = "UPDATE " . CO_TBL_PROJECTS . " set startdate = '$startdb' WHERE id='$pid'";
			$result = mysql_query($q, $this->_db->connection);
		}
		
		$q = "INSERT INTO " . CO_TBL_PROJECTS_PHASES_TASKS . " set pid='$pid', phaseid='$phid',project_link='$id', status = '0', text = '$title', startdate = '$startdb', enddate = '$enddb', cat = '2'";
		$result = mysql_query($q, $this->_db->connection);
		$nid = mysql_insert_id();
			
		$tasks["id"] = $nid;
		$tasks["pid"] = $pid;
		$tasks["phaseid"] = $phid;
		$tasks["startdate"] = $startdate;
		$tasks["enddate"] = $enddate;
		$tasks["text"] = $title;
		$tasks["team"] = $this->_contactsmodel->getUserListPlain($p->management);
		$tasks["link"] = 'projects,'.$folder.','.$id.',0,projects';
		switch($p->status) {
			case "0":
				$tasks["status_text"] = $lang["GLOBAL_STATUS_PLANNED"];
				$tasks["status_text_time"] = $lang["GLOBAL_STATUS_PLANNED_TIME"];
				$tasks["status_date"] = $this->_date->formatDate($p->planned_date,CO_DATE_FORMAT);
			break;
			case "1":
				$tasks["status_text"] = $lang["GLOBAL_STATUS_INPROGRESS"];
				$tasks["status_text_time"] = $lang["GLOBAL_STATUS_INPROGRESS_TIME"];
				$tasks["status_date"] = $this->_date->formatDate($p->inprogress_date,CO_DATE_FORMAT);
			break;
			case "2":
				$tasks["status_text"] = $lang["GLOBAL_STATUS_FINISHED"];
				$tasks["status_text_time"] = $lang["GLOBAL_STATUS_FINISHED_TIME"];
				$tasks["status_date"] = $this->_date->formatDate($p->finished_date,CO_DATE_FORMAT);
			break;
			case "3":
				$tasks["status_text"] = $lang["GLOBAL_STATUS_STOPPED"];
				$tasks["status_text_time"] = $lang["GLOBAL_STATUS_STOPPED_TIME"];
				$tasks["status_date"] = $this->_date->formatDate($p->finished_date,CO_DATE_FORMAT);
			break;
		}
		$task[] = new Lists($tasks);
		
		// write user notices
		$management = $this->getProjectField($id,'management');
		$q = "SELECT admins FROM co_projects_access where pid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$admins = "";
		if(mysql_num_rows($result) > 0) {
			$admins = mysql_result($result,0);
		}
		$users = $management;
		/*if($users != "" && $admins != "") {
			$users .= ',';
		}*/
		//$users .= $admins;
		$users = array_unique(array_filter(explode(",", $users)));
		$users = array_diff($users, array($session->uid));
		foreach ($users as &$user) {
				$qz = "SELECT * FROM " . CO_TBL_PROJECTS_DESKTOP_PROJECTLINKS . " where pid='$id' and relid = '$pid' and phid = '$phid' and uid='$user' and perm ='5'";
				$resultz = mysql_query($qz, $this->_db->connection);
				if(mysql_num_rows($resultz) < 1) {
					$qz = "INSERT INTO " . CO_TBL_PROJECTS_DESKTOP_PROJECTLINKS . " set pid='$id', relid = '$pid', phid = '$phid', uid = '$user', perm ='5'";
					$resultz = mysql_query($qz, $this->_db->connection);
				}
		}
			
		return $task;
	}


    // dialog for selecting dependent tasks
	function getTasksDialog($id,$field) {
		global $lang;
		$q = "SELECT pid,startdate FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_assoc($result);
		$pid = $row["pid"];
		$startdate = $row["startdate"];
	 
		//$str = '<div class="contact-dialog-header"><a href="#" mod="projects_phases" class="insertItem" title="" field="' . $field . '" did="">' . $lang["GLOBAL_DELETE"] . '</a></div>';
		$str = '<div class="dialog-text">';
	 	//$str .= '<a href="#" mod="projects_phases" class="insertItem" title="" field="' . $field . '" did="">' . $lang["PROJECT_PHASE_TASK_DEPENDENT_NO"] . '</a>';

		
		$q ="select id,text from " . CO_TBL_PROJECTS_PHASES_TASKS . " where pid = '$pid' and startdate <= '$startdate' and id != '$id' and bin = '0' ORDER BY startdate";
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$str .= '<a href="#" mod="projects_phases" class="insertItem" title="' . $row["text"] . '" field="' . $field . '" did="'.$row["id"].'">' . $row["text"] . '</a>';
		}
		$str .= '</div>';	
		return $str;
	}

	
	function getTaskContext($id,$field) {
		
		$q = "SELECT id, text, startdate, enddate FROM ".CO_TBL_PROJECTS_PHASES_TASKS." where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		$array["startdate"] = $this->_date->formatDate($array["startdate"],CO_DATE_FORMAT);
		$array["enddate"] = $this->_date->formatDate($array["enddate"],CO_DATE_FORMAT);
		$array["field"] = $field;
		
		$context = new Lists($array); 
	  	return $context;
	}
   

	function deleteTask($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PROJECTS_PHASES_TASKS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		// check if there is a projectlink
		$q = "SELECT pid,phaseid,project_link FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			$row = mysql_fetch_object($result);
			$relid = $row->pid;
			$phid = $row->phaseid;
			$pid = $row->project_link;
			$q = "DELETE FROM " . CO_TBL_PROJECTS_DESKTOP_PROJECTLINKS . " WHERE pid='$pid' and relid='$relid' and phid='$phid'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if($result) {
			return true;
		}
	}

	function restorePhaseTask($id) {
		$q = "UPDATE " . CO_TBL_PROJECTS_PHASES_TASKS . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if($result) {
			return true;
		}
	}

	function deletePhaseTask($id) {
		global $session;
		$q = "DELETE FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if($result) {
			return true;
		}
	}
	
	function getPhasesBin($id) {
		global $session, $lang;
		$phases = "";
		$tasks = "";
		$qph ="select id, title, bin, bintime, binuser from " . CO_TBL_PROJECTS_PHASES . " where pid = '$id'";
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
								//$arr["phases"] = $phases;
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
										//$arr["tasks"] = $tasks;
									} 
								}
							}
						}
						
						$arr = array("phases" => $phases, "tasks" => $tasks);
						/*$arr["phases"] = $phases;
						$arr["tasks"] = $tasks;*/
		return $arr;
	}


	function newCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "INSERT INTO " . CO_TBL_USERS_CHECKPOINTS . " SET uid = '$session->uid', date = '$date', app = 'projects', module = 'phases', app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

 	function updateCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "UPDATE " . CO_TBL_USERS_CHECKPOINTS . " SET date = '$date', status='0' WHERE uid = '$session->uid' and app = 'projects' and module = 'phases' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

 	function deleteCheckpoint($id){
		global $session;
		$q = "DELETE FROM " . CO_TBL_USERS_CHECKPOINTS . " WHERE uid = '$session->uid'and app = 'projects' and module = 'phases' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }


    function getCheckpointDetails($id){
		global $lang;
		$row = "";
		$q = "SELECT a.pid,a.title,b.folder FROM " . CO_TBL_PROJECTS_PHASES . " as a, " . CO_TBL_PROJECTS . " as b WHERE a.pid = b.id and a.id='$id' and a.bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		if(mysql_num_rows($result) > 0) {
			$row['checkpoint_app_name'] = $lang["PROJECT_PHASE_TITLE"];
			$row['app_id'] = $row['pid'];
			$row['app_id_app'] = $id;
		}
		return $row;
   }
   
   
   	function getListArchive($id,$sort) {
		global $session;
		//if($sort == 0) {
				$order = "order by startdate";
				$sortcur = '1';
		
	  
		$perm = $this->getProjectAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and a.access = '1' ";
		}
		
		$q = "select a.title,a.id,a.access,a.status,a.checked_out,a.checked_out_user,(SELECT MIN(startdate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as startdate from " . CO_TBL_PROJECTS_PHASES . " as a where a.pid = '$id' and a.bin != '1' " . $sql . $order;
		
	  	//$this->setSortStatus("projects-phases-sort-status",$sortcur,$id);
		$result = mysql_query($q, $this->_db->connection);
	  	$phases = "";
		
	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			
			// access
			$accessstatus = "";
			if($perm !=  "guest") {
				if($array["access"] == 1) {
					$accessstatus = " module-access-active";
				}
			}
			$array["accessstatus"] = $accessstatus;
			// status
			$itemstatus = "";
			if($array["status"] == 2) {
				$itemstatus = " module-item-active";
			}
			$array["itemstatus"] = $itemstatus;
			
			$checked_out_status = "";
			/*if($perm !=  "guest" && $array["checked_out"] == 1 && $array["checked_out_user"] != $session->uid) {
				//$checked_out_status = "icon-checked-out-active";
				if($session->checkUserActive($array["checked_out_user"])) {
					$checked_out_status = "icon-checked-out-active";
				} else {
					$this->checkinPhaseOverride($id);
				}
			}*/
			$array["checked_out_status"] = $checked_out_status;
			
			$phases[] = new Lists($array);
		}
		
		// generate phase numbering
		$num = "";
		
		$qn = "select a.id,(SELECT MIN(startdate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as startdate from " . CO_TBL_PROJECTS_PHASES . " as a where a.pid = '$id' and a.bin != '1'" . $sql . " order by startdate";
		$resultn = mysql_query($qn, $this->_db->connection);
		$i = 1;
		while ($rown = mysql_fetch_array($resultn)) {
			$num[$rown["id"]] = $i;
			$i++;
		}
		
		$arr = array("phases" => $phases, "sort" => $sortcur, "num" => $num, "perm" => $perm);
		return $arr;
	}
   
   
   function getDetailsArchive($id,$num, $option = "") {
		global $session, $lang;
		
		$this->_documents = new ProjectsDocumentsModel();
		
		$q = "SELECT a.*,(SELECT MIN(startdate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as startdate,(SELECT MAX(enddate) FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as enddate, (SELECT startdate FROM " . CO_TBL_PROJECTS . " WHERE id=a.pid) as kickoff FROM " . CO_TBL_PROJECTS_PHASES . " as a where a.id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
		
		foreach($this->getProjectSettings($array["pid"]) as $key => $val) {
			$array[$key] = $val;
		}
		
		$array["perms"] = $this->getProjectAccess($array["pid"]);
		$array["canedit"] = false;
		$array["showCheckout"] = false;		
		$array["checked_out_user_text"] = $this->_contactsmodel->getUserListPlain($array['checked_out_user']);
		
		/*if($array["perms"] == "sysadmin" || $array["perms"] == "admin") {
			//if($array["checked_out"] == 1 && $session->checkUserActive($array["checked_out_user"])) {
			if($array["checked_out"] == 1) {
				if($array["checked_out_user"] == $session->uid) {
					$array["canedit"] = true;
				} else if(!$session->checkUserActive($array["checked_out_user"])) {
					$array["canedit"] = $this->checkoutPhase($id);
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
					$array["checked_out_user_phone1"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
					$array["checked_out_user_email"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");

				}
			} else {
				$array["canedit"] = $this->checkoutPhase($id);
			}
		}*/
		
		// dates
		$array["today"] = $this->_date->formatDate("now",CO_DATE_FORMAT);
		$array["startdate"] = $this->_date->formatDate($array["startdate"],CO_DATE_FORMAT);
		$array["kickoff"] = $this->_date->formatDate($array["kickoff"],CO_DATE_FORMAT);
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
		$array["team_print"] = $this->_contactsmodel->getUserListPlain($array["team"]);
		if($option = 'prepareSendTo') {
			$array["sendtoTeam"] = $this->_contactsmodel->checkUserListEmail($array["team"],'projectsteam', "", $array["canedit"]);
			$array["sendtoTeamNoEmail"] = $this->_contactsmodel->checkUserListEmail($array["team"],'projectsteam', "", $array["canedit"], 0);
			$array["sendtoError"] = false;
		}
		$array["team"] = $this->_contactsmodel->getUserList($array['team'],'projectsteam', "", $array["canedit"]);
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
		$array["status_planned_active"] = "";
		$array["status_inprogress_active"] = "";
		$array["status_finished_active"] = "";
		switch($array["status"]) {
			case "0":
				$array["status_text"] = $lang["GLOBAL_STATUS_PLANNED"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_PLANNED_TIME"];
				$array["status_planned_active"] = " active";
				$array["status_date"] = $array["planned_date"];
			break;
			case "1":
				$array["status_text"] = $lang["GLOBAL_STATUS_INPROGRESS"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_INPROGRESS_TIME"];
				$array["status_inprogress_active"] = " active";
				$array["status_date"] = $array["inprogress_date"];
			break;
			case "2":
				$array["status_text"] = $lang["GLOBAL_STATUS_FINISHED"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_FINISHED_TIME"];
				$array["status_finished_active"] = " active";
				$array["status_date"] = $array["finished_date"];
			break;
		}

		// checkpoint
		$array["checkpoint"] = 0;
		$array["checkpoint_date"] = "";
		$q = "SELECT date FROM " . CO_TBL_USERS_CHECKPOINTS . " where uid='$session->uid' and app = 'projects' and module = 'phases' and app_id = '$id' LIMIT 1";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			while ($row = mysql_fetch_assoc($result)) {
			$array["checkpoint"] = 1;
			$array["checkpoint_date"] = $this->_date->formatDate($row['date'],CO_DATE_FORMAT);
			}
		}
		
		$array["costs_plan_total"] = 0;
		$array["costs_real_total"] = 0;
		// get the tasks
		$task = array();
		$qt = "SELECT * FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " where phaseid = '$id' and bin='0' ORDER BY startdate";
		$resultt = mysql_query($qt, $this->_db->connection);
		while($rowt = mysql_fetch_array($resultt)) {
			$tasks["costs_plan"] = 0;
			$tasks["costs_employees"] = 0;
			$tasks["costs_materials"] = 0;
			$tasks["costs_external"] = 0;
			$tasks["costs_other"] = 0;
			$tasks["costs_real"] = 0;
			$tasks["costs_employees_real"] = 0;
			$tasks["costs_materials_real"] = 0;
			$tasks["costs_external_real"] = 0;
			$tasks["costs_other_real"] = 0;
			foreach($rowt as $key => $val) {
				$tasks[$key] = $val;
			}
			$tasks["startdate"] = $this->_date->formatDate($tasks["startdate"],CO_DATE_FORMAT);
			$tasks["enddate"] = $this->_date->formatDate($tasks["enddate"],CO_DATE_FORMAT);
			$tasks["donedate"] = $this->_date->formatDate($tasks["donedate"],CO_DATE_FORMAT);
			$tasks["team"] = $this->_contactsmodel->getUserList($tasks['team'],'task_team_'.$tasks["id"], "", $array["canedit"]);
			$tasks["team_ct"] = empty($tasks["team_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $tasks['team_ct'];
			if($array['setting_costs'] == 1) {
				$tasks["costs_plan"] = $tasks["costs_employees"]+$tasks["costs_materials"]+$tasks["costs_external"]+$tasks["costs_other"];
				$array["costs_plan_total"] += $tasks["costs_plan"];
				$tasks["costs_real"] = $tasks["costs_employees_real"]+$tasks["costs_materials_real"]+$tasks["costs_external_real"]+$tasks["costs_other_real"];
				$array["costs_real_total"] += $tasks["costs_real"];
				$tasks["costs_plan"] = number_format($tasks["costs_plan"],0,',','.');
				$tasks["costs_real"] = number_format($tasks["costs_real"],0,',','.');
			}
			
			$tasks["dependent_title"] = "";
			if($tasks["dependent"] > 0) {
				$dep = $tasks["dependent"];
				$qta = "SELECT text FROM " . CO_TBL_PROJECTS_PHASES_TASKS . " where id='$dep' and bin='0'";
				$rqta = mysql_query($qta, $this->_db->connection);
				if(mysql_num_rows($rqta) == 0) {
					$tasks["dependent_title"] = "";
					$tasks["dependent"] = 0;
				} else {
					$tasks["dependent_title"] = mysql_result($rqta,0);
				}
			}
			
			if($tasks["cat"] == 2) {
				$link_id = $tasks["project_link"];
				// make sure project is available = not bin and not deleted
				$q = "SELECT * FROM " . CO_TBL_PROJECTS . " WHERE id='$link_id' and bin='0'";
				$result = mysql_query($q, $this->_db->connection);
				if(mysql_num_rows($result) > 0) {
					$p = mysql_fetch_object($result);
					$tasks["text"] = $p->title;
					$tasks["link"] = 'projects,'.$p->folder.','.$p->id.',0,projects';
					$tasks["team"] = $this->_contactsmodel->getUserListPlain($p->management);
					switch($p->status) {
						case "0":
							$tasks["status_text"] = $lang["GLOBAL_STATUS_PLANNED"];
							$tasks["status_text_time"] = $lang["GLOBAL_STATUS_PLANNED_TIME"];
							$tasks["status_date"] = $this->_date->formatDate($p->planned_date,CO_DATE_FORMAT);
						break;
						case "1":
							$tasks["status_text"] = $lang["GLOBAL_STATUS_INPROGRESS"];
							$tasks["status_text_time"] = $lang["GLOBAL_STATUS_INPROGRESS_TIME"];
							$tasks["status_date"] = $this->_date->formatDate($p->inprogress_date,CO_DATE_FORMAT);
						break;
						case "2":
							$tasks["status_text"] = $lang["GLOBAL_STATUS_FINISHED"];
							$tasks["status_text_time"] = $lang["GLOBAL_STATUS_FINISHED_TIME"];
							$tasks["status_date"] = $this->_date->formatDate($p->finished_date,CO_DATE_FORMAT);
						break;
						case "3":
							$tasks["status_text"] = $lang["GLOBAL_STATUS_STOPPED"];
							$tasks["status_text_time"] = $lang["GLOBAL_STATUS_STOPPED_TIME"];
							$tasks["status_date"] = $this->_date->formatDate($p->finished_date,CO_DATE_FORMAT);
						break;
					}
					$task[] = new Lists($tasks);
				} 
			} else {
				$task[] = new Lists($tasks);
			}
		}
		if($array['setting_costs'] == 1) {
			$array["costs_plan_total"] = number_format($array["costs_plan_total"],0,',','.');
			$array["costs_real_total"] = number_format($array["costs_real_total"],0,',','.');
		}
		$phase = new Lists($array);
		
		$sendto = $this->getSendtoDetails("projects_phases",$id);
		
		$arr = array("phase" => $phase, "task" => $task, "sendto" => $sendto, "access" => $array["perms"]);
		return $arr;
	}


}

$projectsPhasesModel = new ProjectsPhasesModel();
?>
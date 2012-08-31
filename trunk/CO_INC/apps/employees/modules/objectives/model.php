<?php

class EmployeesObjectivesModel extends EmployeesModel {
	
	public function __construct() {  
     	parent::__construct();
		//$this->_phases = new EmployeesPhasesModel();
		$this->_contactsmodel = new ContactsModel();
	}


	function getList($id,$sort) {
		global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("employees-objectives-sort-status",$id);
		  if(!$sortstatus) {
				$order = "order by item_date DESC";
				$sortcur = '1';
		  } else {
			  switch($sortstatus) {
				  case "1":
				  		$order = "order by item_date DESC";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by item_date ASC";
							$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("employees-objectives-sort-order",$id);
				  		if(!$sortorder) {
								$order = "order by item_date DESC";
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
				  		$order = "order by item_date DESC";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by item_date ASC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("employees-objectives-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by item_date DESC";
								$sortcur = '1';
						  } else {
								$order = "order by field(id,$sortorder)";
								$sortcur = '3';
						  }
				  break;	
			  }
		}
	  
	  
		$perm = $this->getEmployeeAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		
		$q = "select id,title,item_date,access,status,checked_out,checked_out_user from " . CO_TBL_EMPLOYEES_OBJECTIVES . " where pid = '$id' and bin != '1' " . $sql . $order;
		$this->setSortStatus("employees-objectives-sort-status",$sortcur,$id);
		$result = mysql_query($q, $this->_db->connection);
		$items = mysql_num_rows($result);
		
		$objectives = "";
		while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			
			// dates
			$array["item_date"] = $this->_date->formatDate($array["item_date"],CO_DATE_FORMAT);
			
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
			if($array["status"] == 1) {
				$itemstatus = " module-item-active";
			}
			if($array["status"] == 2) {
				$itemstatus = " module-item-active-stopped";
			}
			$array["itemstatus"] = $itemstatus;
			
			$checked_out_status = "";
			if($perm !=  "guest" && $array["checked_out"] == 1 && $array["checked_out_user"] != $session->uid) {
				if($session->checkUserActive($array["checked_out_user"])) {
					$checked_out_status = "icon-checked-out-active";
				} else {
					$this->checkinObjectiveOverride($id);
				}
			}
			$array["checked_out_status"] = $checked_out_status;
			
			
			$objectives[] = new Lists($array);
	  }
		
	  $arr = array("objectives" => $objectives, "items" => $items, "sort" => $sortcur, "perm" => $perm);
	  return $arr;
	}


	function getNavNumItems($id) {
		$perm = $this->getEmployeeAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		$q = "select count(*) as items from " . CO_TBL_EMPLOYEES_OBJECTIVES . " where pid = '$id' and bin != '1' " . $sql;
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		$items = $row['items'];
		return $items;
	}
	

	function checkoutObjective($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_EMPLOYEES_OBJECTIVES . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function checkinObjective($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_EMPLOYEES_OBJECTIVES . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_EMPLOYEES_OBJECTIVES . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}
	
	function checkinObjectiveOverride($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_EMPLOYEES_OBJECTIVES . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	

	function getDetails($id, $option = "") {
		global $session, $lang;
		
		$this->_documents = new EmployeesDocumentsModel();
		
		$q = "SELECT * FROM " . CO_TBL_EMPLOYEES_OBJECTIVES . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			
			
			
		$array["perms"] = $this->getEmployeeAccess($array["pid"]);
		$array["canedit"] = false;
		$array["showCheckout"] = false;
		$array["checked_out_user_text"] = $this->_contactsmodel->getUserListPlain($array['checked_out_user']);

		if($array["perms"] == "sysadmin" || $array["perms"] == "admin") {
			//if($array["checked_out"] == 1 && $session->checkUserActive($array["checked_out_user"])) {
			if($array["checked_out"] == 1) {
				if($array["checked_out_user"] == $session->uid) {
					$array["canedit"] = true;
				} else if(!$session->checkUserActive($array["checked_out_user"])) {
					$array["canedit"] = $this->checkoutObjective($id);
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
		$array["checked_out_user_phone1"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
		$array["checked_out_user_email"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");

				}
			} else {
				$array["canedit"] = $this->checkoutObjective($id);
			}
		}
		
		// dates
		$array["item_date"] = $this->_date->formatDate($array["item_date"],CO_DATE_FORMAT);
		
		// time
		$array["today"] = $this->_date->formatDate("now",CO_DATE_FORMAT);
		$array["start"] = $this->_date->formatDate($array["start"],CO_TIME_FORMAT);
		$array["end"] = $this->_date->formatDate($array["end"],CO_TIME_FORMAT);
		$array["location"] = $this->_contactsmodel->getPlaceList($array['location'],'location', $array["canedit"]);
		$array["location_ct"] = empty($array["location_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['location_ct'];

		/*$array["relates_to_text"] = "";
		if($array['relates_to'] != "") {
			$array["relates_to_text"] = $this->_phases->getPhaseTitle($array['relates_to']);
		}*/
		
		$array["participants_print"] = $this->_contactsmodel->getUserListPlain($array["participants"]);
		if($option = 'prepareSendTo') {
			$array["sendtoTeam"] = $this->_contactsmodel->checkUserListEmail($array["participants"],'employeesparticipants', "", $array["canedit"]);
			$array["sendtoTeamNoEmail"] = $this->_contactsmodel->checkUserListEmail($array["participants"],'employeesparticipants', "", $array["canedit"], 0);
			$array["sendtoError"] = false;
		}
		$array["participants"] = $this->_contactsmodel->getUserList($array['participants'],'employeesparticipants', "", $array["canedit"]);
		$array["participants_ct"] = empty($array["participants_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['participants_ct'];
		$array["management_print"] = $this->_contactsmodel->getUserListPlain($array["management"]);
		$array["management"] = $this->_contactsmodel->getUserList($array['management'],'employeesmanagement', "", $array["canedit"]);
		$array["management_ct"] = empty($array["management_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['management_ct'];
		//$array["documents"] = $this->_documents->getDocListFromIDs($array['documents'],'documents');
		
		$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		$array["current_user"] = $session->uid;
		
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
		$array["status_planned_active"] = "";
		$array["status_finished_active"] = "";
		$array["status_stopped_active"] = "";
		$array["status_posponed_active"] = "";
		$array["status_date"] = $this->_date->formatDate($array["status_date"],CO_DATE_FORMAT);
		switch($array["status"]) {
			case "0":
				$array["status_text"] = $lang["GLOBAL_STATUS_PLANNED"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_PLANNED_TIME"];
				$array["status_planned_active"] = " active";
			break;
			case "1":
				$array["status_date"] = "";
				$array["status_text"] = $lang["GLOBAL_STATUS_COMPLETED"];
				$array["status_text_time"] = "";
				$array["status_finished_active"] = " active";
			break;
			case "2":
				$array["status_text"] = $lang["GLOBAL_STATUS_CANCELLED"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_CANCELLED_TIME"];
				$array["status_stopped_active"] = " active";
				break;
			case "3":
				$array["status_text"] = $lang["GLOBAL_STATUS_POSPONED"];
				$array["status_text_time"] = $lang["GLOBAL_STATUS_POSPONED_TIME"];
				$array["status_posponed_active"] = " active";
			break;
		}
		
		// Tab 1 questios
		$array["tab1q1_selected"] = $array["tab1q1"];
		$array["tab1q2_selected"] = $array["tab1q2"];
		$array["tab1q3_selected"] = $array["tab1q3"];
		$array["tab1q4_selected"] = $array["tab1q4"];
		$array["tab1q5_selected"] = $array["tab1q5"];
		$tab1result = 0;
		if(!empty($array["tab1q1"])) { $tab1result += $array["tab1q1"]; }
		if(!empty($array["tab1q2"])) { $tab1result += $array["tab1q2"]; }
		if(!empty($array["tab1q3"])) { $tab1result += $array["tab1q3"]; }
		if(!empty($array["tab1q4"])) { $tab1result += $array["tab1q4"]; }
		if(!empty($array["tab1q5"])) { $tab1result += $array["tab1q5"]; }
		$array["tab1result"] = round(100/50* $tab1result,0);
		
		// Tab 2 questios
		$array["tab2q1_selected"] = $array["tab2q1"];
		$array["tab2q2_selected"] = $array["tab2q2"];
		$array["tab2q3_selected"] = $array["tab2q3"];
		$array["tab2q4_selected"] = $array["tab2q4"];
		$array["tab2q5_selected"] = $array["tab2q5"];
		$array["tab2q6_selected"] = $array["tab2q6"];
		$array["tab2q7_selected"] = $array["tab2q7"];
		$array["tab2q8_selected"] = $array["tab2q8"];
		$array["tab2q9_selected"] = $array["tab2q9"];
		$array["tab2q10_selected"] = $array["tab2q10"];
		$tab2result = 0;
		if(!empty($array["tab2q1"])) { $tab2result += $array["tab2q1"]; }
		if(!empty($array["tab2q2"])) { $tab2result += $array["tab2q2"]; }
		if(!empty($array["tab2q3"])) { $tab2result += $array["tab2q3"]; }
		if(!empty($array["tab2q4"])) { $tab2result += $array["tab2q4"]; }
		if(!empty($array["tab2q5"])) { $tab2result += $array["tab2q5"]; }
		if(!empty($array["tab2q6"])) { $tab2result += $array["tab2q6"]; }
		if(!empty($array["tab2q7"])) { $tab2result += $array["tab2q7"]; }
		if(!empty($array["tab2q8"])) { $tab2result += $array["tab2q8"]; }
		if(!empty($array["tab2q9"])) { $tab2result += $array["tab2q9"]; }
		if(!empty($array["tab2q10"])) { $tab2result += $array["tab2q10"]; }
		$array["tab2result"] = $tab2result;
		
		// checkpoint
		/*$array["checkpoint"] = 0;
		$array["checkpoint_date"] = "";
		$array["checkpoint_note"] = "";
		$q = "SELECT date,note FROM " . CO_TBL_USERS_CHECKPOINTS . " where uid='$session->uid' and app = 'employees' and module = 'objectives' and app_id = '$id' LIMIT 1";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			while ($row = mysql_fetch_assoc($result)) {
			$array["checkpoint"] = 1;
			$array["checkpoint_date"] = $this->_date->formatDate($row['date'],CO_DATE_FORMAT);
			$array["checkpoint_note"] = $row['note'];
			}
		}*/
		
		// get the tasks
		$task = array();
		$q = "SELECT * FROM " . CO_TBL_EMPLOYEES_OBJECTIVES_TASKS . " where mid = '$id' and bin='0' ORDER BY sort";
		$result = mysql_query($q, $this->_db->connection);
		$res = 0;
		$num = mysql_num_rows($result)*10;
		while($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$tasks[$key] = $val;
			}
			if(!empty($tasks['answer'])) { $res += $tasks['answer']; }
			
			$task[] = new Lists($tasks);
		}
		
		$array["tab3result"] = round(100/$num* $res,0);
		
		$sendto = $this->getSendtoDetails("employees_objectives",$id);

		$objective = new Lists($array);
		$arr = array("objective" => $objective, "task" => $task, "sendto" => $sendto, "access" => $array["perms"]);
		return $arr;
   }


   function setDetails($pid,$id,$title,$objectivedate,$start,$end,$location,$location_ct,$participants,$participants_ct,$management,$management_ct,$tab1q1_text,$tab1q2_text,$tab1q3_text,$tab1q4_text,$tab1q5_text,$tab2q1_text,$tab2q2_text,$tab2q3_text,$tab2q4_text,$tab2q5_text,$tab2q6_text,$tab2q7_text,$tab2q8_text,$tab2q9_text,$tab2q10_text,$task_id,$task_title,$task_text,$task,$objective_access,$objective_access_orig) {
		global $session, $lang;
		
		$start = $this->_date->formatDateGMT($objectivedate . " " . $start);
		$end = $this->_date->formatDateGMT( $objectivedate . " " . $end);
		$objectivedate = $this->_date->formatDate($objectivedate);
		$participants = $this->_contactsmodel->sortUserIDsByName($participants);
		$management = $this->_contactsmodel->sortUserIDsByName($management);

		$now = gmdate("Y-m-d H:i:s");
		
		if($objective_access == $objective_access_orig) {
			$accesssql = "";
		} else {
			$objective_access_date = "";
			if($objective_access == 1) {
				$objective_access_date = $now;
			}
			$accesssql = "access='$objective_access', access_date='$objective_access_date', access_user = '$session->uid',";
		}
		
		$q = "UPDATE " . CO_TBL_EMPLOYEES_OBJECTIVES . " set title = '$title', item_date = '$objectivedate', start = '$start', end = '$end', location = '$location', location_ct = '$location_ct', participants='$participants', participants_ct='$participants_ct', management='$management', management_ct='$management_ct', tab1q1_text = '$tab1q1_text', tab1q2_text = '$tab1q2_text', tab1q3_text = '$tab1q3_text', tab1q4_text = '$tab1q4_text', tab1q5_text = '$tab1q5_text', tab2q1_text = '$tab2q1_text', tab2q2_text = '$tab2q2_text', tab2q3_text = '$tab2q3_text', tab2q4_text = '$tab2q4_text', tab2q5_text = '$tab2q5_text', tab2q6_text = '$tab2q6_text', tab2q7_text = '$tab2q7_text', tab2q8_text = '$tab2q8_text', tab2q9_text = '$tab2q9_text', tab2q10_text = '$tab2q10_text', access='$objective_access', $accesssql edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		// do existing tasks
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
			$q = "UPDATE " . CO_TBL_EMPLOYEES_OBJECTIVES_TASKS . " set status = '$checked_items[$key]', title = '$task_title[$key]', text = '$task_text[$key]' WHERE id='$task_id[$key]'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return $id;
		}
   }


   function updateStatus($id,$date,$status) {
		global $session, $lang;
		
		$date = $this->_date->formatDate($date);
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "SELECT title FROM " . CO_TBL_EMPLOYEES_OBJECTIVES . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		
		$title_change = $title;
		if($status == 3) {
			$title_change = $title . " " . $lang["EMPLOYEE_OBJECTIVE_POSPONED"];
		}
		
		$q = "UPDATE " . CO_TBL_EMPLOYEES_OBJECTIVES . " set title = '$title_change', status = '$status', status_date = '$date', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			$arr = array("id" => $id, "what" => "edit");
		}
		
		// posponed
		if($status == 3) {
			$this->checkinObjective($id);
			$q = "INSERT INTO " . CO_TBL_EMPLOYEES_OBJECTIVES . " (pid,title,item_date,start,end,location,location_ct,length,management,management_ct,participants,participants_ct,status,status_date,created_date,created_user,edited_date,edited_user) SELECT pid,'$title','$date',start,end,location,location_ct,length,management,management_ct,participants,participants_ct,0,'$now','$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_EMPLOYEES_OBJECTIVES . " where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
			if ($result) {
				$nid = mysql_insert_id();
				// do tasks
				$qt = "INSERT INTO " . CO_TBL_EMPLOYEES_OBJECTIVES_TASKS . " (mid,status,title,text,sort) SELECT '$nid',status,title,text,sort FROM " . CO_TBL_EMPLOYEES_OBJECTIVES_TASKS . " where mid='$id'";
				$resultt = mysql_query($qt, $this->_db->connection);
				$arr = array("id" => $nid, "what" => "reload");
			}
		}
		return $arr;
	}


   function createNew($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		$time = gmdate("Y-m-d H");
		
		$q = "INSERT INTO " . CO_TBL_EMPLOYEES_OBJECTIVES . " set title = '" . $lang["EMPLOYEE_OBJECTIVE_NEW"] . "', item_date='$now', start='$time', end='$time', pid = '$id', participants = '$session->uid', management = '$session->uid', status = '0', status_date = '$now', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		
		//$task = $this->addTask($id,0,0);
		
		if ($result) {
			return $id;
		}
   }
   

   	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");

		// objective
		$q = "INSERT INTO " . CO_TBL_EMPLOYEES_OBJECTIVES . " (pid,title,item_date,start,end,location,location_ct,length,management,management_ct,participants,participants_ct,status_date,created_date,created_user,edited_date,edited_user,tab1q1,tab1q2,tab1q3,tab1q4,tab1q5,tab2q1,tab2q2,tab2q3,tab2q4,tab2q5,tab2q6,tab2q7,tab2q8,tab2q9,tab2q10,tab1q1_text,tab1q2_text,tab1q3_text,tab1q4_text,tab1q5_text,tab2q1_text,tab2q2_text,tab2q3_text,tab2q4_text,tab2q5_text,tab2q6_text,tab2q7_text,tab2q8_text,tab2q9_text,tab2q10_text) SELECT pid,CONCAT(title,' " . $lang["GLOBAL_DUPLICAT"] . "'),'$now',start,end,location,location_ct,length,management,management_ct,participants,participants_ct,'$now','$now','$session->uid','$now','$session->uid',tab1q1,tab1q2,tab1q3,tab1q4,tab1q5,tab2q1,tab2q2,tab2q3,tab2q4,tab2q5,tab2q6,tab2q7,tab2q8,tab2q9,tab2q10,tab1q1_text,tab1q2_text,tab1q3_text,tab1q4_text,tab1q5_text,tab2q1_text,tab2q2_text,tab2q3_text,tab2q4_text,tab2q5_text,tab2q6_text,tab2q7_text,tab2q8_text,tab2q9_text,tab2q10_text FROM " . CO_TBL_EMPLOYEES_OBJECTIVES . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		// tasks
		$qt = "INSERT INTO " . CO_TBL_EMPLOYEES_OBJECTIVES_TASKS . " (mid,title,text,answer,sort) SELECT $id_new,title,text,answer,sort FROM " . CO_TBL_EMPLOYEES_OBJECTIVES_TASKS . " where mid='$id' and bin='0'";
		$resultt = mysql_query($qt, $this->_db->connection);
		if ($result) {
			return $id_new;
		}
	}


   function binObjective($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_EMPLOYEES_OBJECTIVES . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function restoreObjective($id) {
		$q = "UPDATE " . CO_TBL_EMPLOYEES_OBJECTIVES . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deleteObjective($id) {
		$q = "SELECT id FROM " . CO_TBL_EMPLOYEES_OBJECTIVES_TASKS . " WHERE mid = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$tid = $row["id"];
			$this->deleteObjectiveTask($tid);
		}
		
		$q = "DELETE FROM co_log_sendto WHERE what='employees_objectives' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_USERS_CHECKPOINTS . " WHERE app = 'employees' and module = 'objectives' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_EMPLOYEES_OBJECTIVES . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function toggleIntern($id,$status) {
		global $session;
		$q = "UPDATE " . CO_TBL_EMPLOYEES_OBJECTIVES . " set intern = '$status' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function addTask($mid,$num,$sort) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "INSERT INTO " . CO_TBL_EMPLOYEES_OBJECTIVES_TASKS . " set mid='$mid', status = '0', title = '" . $lang["EMPLOYEE_OBJECTIVE_TASK_NEW"] . "',  sort='$sort'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		
		$task = array();
		$q = "SELECT * FROM " . CO_TBL_EMPLOYEES_OBJECTIVES_TASKS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$tasks[$key] = $val;
			}
			$tasks["today"] = $this->_date->formatDate("now",CO_DATE_FORMAT);
			$task[] = new Lists($tasks);
		}
		
		  	return $task;
   }


   function deleteTask($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_EMPLOYEES_OBJECTIVES_TASKS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }
   
   function restoreObjectiveTask($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_EMPLOYEES_OBJECTIVES_TASKS . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }
   
   function deleteObjectiveTask($id) {
		global $session;
		$q = "DELETE FROM " . CO_TBL_EMPLOYEES_OBJECTIVES_TASKS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }

	function newCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "INSERT INTO " . CO_TBL_USERS_CHECKPOINTS . " SET uid = '$session->uid', date = '$date', app = 'employees', module = 'objectives', app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

 	function updateCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "UPDATE " . CO_TBL_USERS_CHECKPOINTS . " SET date = '$date' WHERE uid = '$session->uid' and app = 'employees' and module = 'objectives' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

 	function deleteCheckpoint($id){
		global $session;
		$q = "DELETE FROM " . CO_TBL_USERS_CHECKPOINTS . " WHERE uid = '$session->uid'and app = 'employees' and module = 'objectives' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

	function updateCheckpointText($id,$text){
		global $session;
		$q = "UPDATE " . CO_TBL_USERS_CHECKPOINTS . " SET note = '$text' WHERE uid = '$session->uid' and app = 'employees' and module = 'objectives' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

    function getCheckpointDetails($id){
		global $lang;
		$row = "";
		$q = "SELECT a.pid,a.title,b.folder FROM " . CO_TBL_EMPLOYEES_OBJECTIVES . " as a, " . CO_TBL_EMPLOYEES . " as b WHERE a.pid = b.id and a.id='$id' and a.bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		if(mysql_num_rows($result) > 0) {
			$row['checkpoint_app_name'] = $lang["EMPLOYEE_OBJECTIVE_TITLE"];
			$row['app_id'] = $row['pid'];
			$row['app_id_app'] = $id;
		}
		return $row;
   }
   
   
    function updateQuestion($id,$field,$val){
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_EMPLOYEES_OBJECTIVES . " set $field = '$val', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		return true;
   }
   
   function updateTaskQuestion($id,$val){
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_EMPLOYEES_OBJECTIVES_TASKS . " set answer = '$val' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$q = "SELECT mid FROM " . CO_TBL_EMPLOYEES_OBJECTIVES_TASKS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_result($result,0);
		$q = "UPDATE " . CO_TBL_EMPLOYEES_OBJECTIVES . " set edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		return true;
   }

}
?>
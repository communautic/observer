<?php

class PatientsMeetingsModel extends PatientsModel {
	
	public function __construct() {  
     	parent::__construct();
		//$this->_phases = new PatientsPhasesModel();
		$this->_contactsmodel = new ContactsModel();
	}


	function getList($id,$sort) {
		global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("patients-meetings-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("patients-meetings-sort-order",$id);
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
				  		$sortorder = $this->getSortOrder("patients-meetings-sort-order",$id);
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
	  
	  
		$perm = $this->getPatientAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		
		$q = "select id,title,item_date,access,status,checked_out,checked_out_user from " . CO_TBL_PATIENTS_MEETINGS . " where pid = '$id' and bin != '1' " . $sql . $order;
		$this->setSortStatus("patients-meetings-sort-status",$sortcur,$id);
		$result = mysql_query($q, $this->_db->connection);
		$items = mysql_num_rows($result);
		
		$meetings = "";
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
					$this->checkinMeetingOverride($id);
				}
			}
			$array["checked_out_status"] = $checked_out_status;
			
			
			$meetings[] = new Lists($array);
	  }
		
	  $arr = array("meetings" => $meetings, "items" => $items, "sort" => $sortcur, "perm" => $perm);
	  return $arr;
	}


	function getNavNumItems($id) {
		$perm = $this->getPatientAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		$q = "select count(*) as items from " . CO_TBL_PATIENTS_MEETINGS . " where pid = '$id' and bin != '1' " . $sql;
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		$items = $row['items'];
		return $items;
	}
	

	function checkoutMeeting($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_PATIENTS_MEETINGS . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function checkinMeeting($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_PATIENTS_MEETINGS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_PATIENTS_MEETINGS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}
	
	function checkinMeetingOverride($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PATIENTS_MEETINGS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	

	function getDetails($id, $option = "") {
		global $session, $lang;
		
		$this->_documents = new PatientsDocumentsModel();
		
		$q = "SELECT * FROM " . CO_TBL_PATIENTS_MEETINGS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			
			
			
		$array["perms"] = $this->getPatientAccess($array["pid"]);
		$array["canedit"] = false;
		$array["showCheckout"] = false;
		$array["checked_out_user_text"] = $this->_contactsmodel->getUserListPlain($array['checked_out_user']);

		if($array["perms"] == "sysadmin" || $array["perms"] == "admin") {
			//if($array["checked_out"] == 1 && $session->checkUserActive($array["checked_out_user"])) {
			if($array["checked_out"] == 1) {
				if($array["checked_out_user"] == $session->uid) {
					$array["canedit"] = true;
				} else if(!$session->checkUserActive($array["checked_out_user"])) {
					$array["canedit"] = $this->checkoutMeeting($id);
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
		$array["checked_out_user_phone1"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
		$array["checked_out_user_email"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");

				}
			} else {
				$array["canedit"] = $this->checkoutMeeting($id);
			}
		}
		
		// dates
		$array["item_date"] = $this->_date->formatDate($array["item_date"],CO_DATE_FORMAT);
		
		// time
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
			$array["sendtoTeam"] = $this->_contactsmodel->checkUserListEmail($array["participants"],'patientsparticipants', "", $array["canedit"]);
			$array["sendtoTeamNoEmail"] = $this->_contactsmodel->checkUserListEmail($array["participants"],'patientsparticipants', "", $array["canedit"], 0);
			$array["sendtoError"] = false;
		}
		$array["participants"] = $this->_contactsmodel->getUserList($array['participants'],'patientsparticipants', "", $array["canedit"]);
		$array["participants_ct"] = empty($array["participants_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['participants_ct'];
		$array["management_print"] = $this->_contactsmodel->getUserListPlain($array["management"]);
		$array["management"] = $this->_contactsmodel->getUserList($array['management'],'patientsmanagement', "", $array["canedit"]);
		$array["management_ct"] = empty($array["management_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['management_ct'];
		$array["documents"] = $this->_documents->getDocListFromIDs($array['documents'],'documents');
		
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
		
		// checkpoint
		$array["checkpoint"] = 0;
		$array["checkpoint_date"] = "";
		$array["checkpoint_note"] = "";
		$q = "SELECT date,note FROM " . CO_TBL_USERS_CHECKPOINTS . " where uid='$session->uid' and app = 'patients' and module = 'meetings' and app_id = '$id' LIMIT 1";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			while ($row = mysql_fetch_assoc($result)) {
			$array["checkpoint"] = 1;
			$array["checkpoint_date"] = $this->_date->formatDate($row['date'],CO_DATE_FORMAT);
			$array["checkpoint_note"] = $row['note'];
			}
		}
		
		// get the tasks
		$task = array();
		$q = "SELECT * FROM " . CO_TBL_PATIENTS_MEETINGS_TASKS . " where mid = '$id' and bin='0' ORDER BY sort";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
		foreach($row as $key => $val) {
				$tasks[$key] = $val;
			}
			$task[] = new Lists($tasks);
		}
		
		$sendto = $this->getSendtoDetails("patients_meetings",$id);

		$meeting = new Lists($array);
		$arr = array("meeting" => $meeting, "task" => $task, "sendto" => $sendto, "access" => $array["perms"]);
		return $arr;
   }


   function setDetails($pid,$id,$title,$meetingdate,$start,$end,$location,$location_ct,$participants,$participants_ct,$management,$management_ct,$task_id,$task_title,$task_text,$task,$task_sort,$documents,$meeting_access,$meeting_access_orig) {
		global $session, $lang;
		
		$start = $this->_date->formatDateGMT($meetingdate . " " . $start);
		$end = $this->_date->formatDateGMT( $meetingdate . " " . $end);
		$meetingdate = $this->_date->formatDate($meetingdate);
		$participants = $this->_contactsmodel->sortUserIDsByName($participants);
		$management = $this->_contactsmodel->sortUserIDsByName($management);

		$now = gmdate("Y-m-d H:i:s");
		
		if($meeting_access == $meeting_access_orig) {
			$accesssql = "";
		} else {
			$meeting_access_date = "";
			if($meeting_access == 1) {
				$meeting_access_date = $now;
			}
			$accesssql = "access='$meeting_access', access_date='$meeting_access_date', access_user = '$session->uid',";
		}
		
		$q = "UPDATE " . CO_TBL_PATIENTS_MEETINGS . " set title = '$title', item_date = '$meetingdate', start = '$start', end = '$end', location = '$location', location_ct = '$location_ct', participants='$participants', participants_ct='$participants_ct', management='$management', management_ct='$management_ct', documents = '$documents', access='$meeting_access', $accesssql edited_user = '$session->uid', edited_date = '$now' where id='$id'";
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
			$q = "UPDATE " . CO_TBL_PATIENTS_MEETINGS_TASKS . " set status = '$checked_items[$key]', title = '$task_title[$key]', text = '$task_text[$key]', sort = '$task_sort[$key]' WHERE id='$task_id[$key]'";
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
		
		$q = "SELECT title FROM " . CO_TBL_PATIENTS_MEETINGS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		
		$title_change = $title;
		if($status == 3) {
			$title_change = $title . " " . $lang["PATIENT_MEETING_POSPONED"];
		}
		
		$q = "UPDATE " . CO_TBL_PATIENTS_MEETINGS . " set title = '$title_change', status = '$status', status_date = '$date', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			$arr = array("id" => $id, "what" => "edit");
		}
		
		// posponed
		if($status == 3) {
			$this->checkinMeeting($id);
			$q = "INSERT INTO " . CO_TBL_PATIENTS_MEETINGS . " (pid,title,item_date,start,end,location,location_ct,length,management,management_ct,participants,participants_ct,status,status_date,created_date,created_user,edited_date,edited_user) SELECT pid,'$title','$date',start,end,location,location_ct,length,management,management_ct,participants,participants_ct,0,'$now','$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_PATIENTS_MEETINGS . " where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
			if ($result) {
				$nid = mysql_insert_id();
				// do tasks
				$qt = "INSERT INTO " . CO_TBL_PATIENTS_MEETINGS_TASKS . " (mid,status,title,text,sort) SELECT '$nid',status,title,text,sort FROM " . CO_TBL_PATIENTS_MEETINGS_TASKS . " where mid='$id'";
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
		
		$q = "INSERT INTO " . CO_TBL_PATIENTS_MEETINGS . " set title = '" . $lang["PATIENT_MEETING_NEW"] . "', item_date='$now', start='$time', end='$time', pid = '$id', participants = '$session->uid', management = '$session->uid', status = '0', status_date = '$now', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		
		$task = $this->addTask($id,0,0);
		
		if ($result) {
			return $id;
		}
   }
   

   	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		// meeting
		$q = "INSERT INTO " . CO_TBL_PATIENTS_MEETINGS . " (pid,title,item_date,start,end,location,location_ct,length,management,management_ct,participants,participants_ct,status_date,created_date,created_user,edited_date,edited_user) SELECT pid,CONCAT(title,' " . $lang["GLOBAL_DUPLICAT"] . "'),item_date,start,end,location,location_ct,length,management,management_ct,participants,participants_ct,'$now','$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_PATIENTS_MEETINGS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		// tasks
		$qt = "INSERT INTO " . CO_TBL_PATIENTS_MEETINGS_TASKS . " (mid,status,title,text,sort) SELECT $id_new,'0',title,text,sort FROM " . CO_TBL_PATIENTS_MEETINGS_TASKS . " where mid='$id' and bin='0'";
		$resultt = mysql_query($qt, $this->_db->connection);
		if ($result) {
			return $id_new;
		}
	}


   function binMeeting($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PATIENTS_MEETINGS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function restoreMeeting($id) {
		$q = "UPDATE " . CO_TBL_PATIENTS_MEETINGS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deleteMeeting($id) {
		$q = "SELECT id FROM " . CO_TBL_PATIENTS_MEETINGS_TASKS . " WHERE mid = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$tid = $row["id"];
			$this->deleteMeetingTask($tid);
		}
		
		$q = "DELETE FROM co_log_sendto WHERE what='patients_meetings' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_USERS_CHECKPOINTS . " WHERE app = 'patients' and module = 'meetings' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_PATIENTS_MEETINGS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function toggleIntern($id,$status) {
		global $session;
		$q = "UPDATE " . CO_TBL_PATIENTS_MEETINGS . " set intern = '$status' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function addTask($mid,$num,$sort) {
		global $session, $lang;
		
		$q = "INSERT INTO " . CO_TBL_PATIENTS_MEETINGS_TASKS . " set mid='$mid', status = '0', title = '" . $lang["PATIENT_MEETING_TASK_NEW"] . "', sort='$sort'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		
		$task = array();
		$q = "SELECT * FROM " . CO_TBL_PATIENTS_MEETINGS_TASKS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$tasks[$key] = $val;
			}
			$task[] = new Lists($tasks);
		}
		
		  	return $task;
   }


   function deleteTask($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PATIENTS_MEETINGS_TASKS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }
   
   function restoreMeetingTask($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PATIENTS_MEETINGS_TASKS . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }
   
   function deleteMeetingTask($id) {
		global $session;
		$q = "DELETE FROM " . CO_TBL_PATIENTS_MEETINGS_TASKS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }

	function newCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "INSERT INTO " . CO_TBL_USERS_CHECKPOINTS . " SET uid = '$session->uid', date = '$date', app = 'patients', module = 'meetings', app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

 	function updateCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "UPDATE " . CO_TBL_USERS_CHECKPOINTS . " SET date = '$date' WHERE uid = '$session->uid' and app = 'patients' and module = 'meetings' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

 	function deleteCheckpoint($id){
		global $session;
		$q = "DELETE FROM " . CO_TBL_USERS_CHECKPOINTS . " WHERE uid = '$session->uid'and app = 'patients' and module = 'meetings' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

	function updateCheckpointText($id,$text){
		global $session;
		$q = "UPDATE " . CO_TBL_USERS_CHECKPOINTS . " SET note = '$text' WHERE uid = '$session->uid' and app = 'patients' and module = 'meetings' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

    function getCheckpointDetails($id){
		global $lang;
		$row = "";
		$q = "SELECT a.pid,a.title,b.folder FROM " . CO_TBL_PATIENTS_MEETINGS . " as a, " . CO_TBL_PATIENTS . " as b WHERE a.pid = b.id and a.id='$id' and a.bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		if(mysql_num_rows($result) > 0) {
			$row['checkpoint_app_name'] = $lang["PATIENT_MEETING_TITLE"];
			$row['app_id'] = $row['pid'];
			$row['app_id_app'] = $id;
		}
		return $row;
   }


}
?>
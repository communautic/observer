<?php

class MeetingsModel extends ProjectsModel {
	
	public function __construct() {  
     	parent::__construct();
		$this->_phases = new PhasesModel();
		$this->_contactsmodel = new ContactsModel();
	}


	function getList($id,$sort) {
		global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("meeting-sort-status",$id);
		  if(!$sortstatus) {
				$order = "order by meeting_date DESC";
				$sortcur = '1';
		  } else {
			  switch($sortstatus) {
				  case "1":
				  		$order = "order by meeting_date DESC";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by meeting_date ASC";
							$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("meeting-sort-order",$id);
				  		if(!$sortorder) {
								$order = "order by meeting_date DESC";
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
				  		$order = "order by meeting_date DESC";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by meeting_date ASC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("meeting-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by meeting_date DESC";
								$sortcur = '1';
						  } else {
								$order = "order by field(id,$sortorder)";
								$sortcur = '3';
						  }
				  break;	
			  }
	  }
	  
		//$q = "select title,id,intern,startdate,enddate from " . CO_TBL_PHASES . " where pid = '$id' and bin != '1' " . $order;
		$q = "select id,title,meeting_date,access,status from " . CO_TBL_MEETINGS . " where pid = '$id' and bin != '1' " . $order;

	  $this->setSortStatus("meeting-sort-status",$sortcur,$id);
		$result = mysql_query($q, $this->_db->connection);
	  $meetings = "";
	  while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			
			// dates
			$array["meeting_date"] = $this->_date->formatDate($array["meeting_date"],CO_DATE_FORMAT);
			
			// access
			$accessstatus = "";
			if($array["access"] == 1) {
				$accessstatus = " module-access-active";
			}
			$array["accessstatus"] = $accessstatus;
			// status
			$itemstatus = "";
			if($array["status"] == 1) {
				$itemstatus = " module-item-active";
			}
			$array["itemstatus"] = $itemstatus;
			
			$meetings[] = new Lists($array);
	  }
		
	  $arr = array("meetings" => $meetings, "sort" => $sortcur);
	  return $arr;
	}

	
	// Get meeting list from ids for Tooltips
	function getMeetingDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			$q = "SELECT id,title from " . CO_TBL_MEETINGS . " where id = '$value'";
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


	/*function getDependency($id){
		$q = "SELECT title FROM " . CO_TBL_PHASES . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		return mysql_num_rows($result);
	}*/


	function getDetails($id) {
		global $session, $lang;
		
		$this->_documents = new DocumentsModel();
		
		$q = "SELECT * FROM " . CO_TBL_MEETINGS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
		
		// dates
		$array["meeting_date"] = $this->_date->formatDate($array["meeting_date"],CO_DATE_FORMAT);
		
		// time
		$array["start"] = $this->_date->formatDate($array["start"],CO_TIME_FORMAT);
		$array["end"] = $this->_date->formatDate($array["end"],CO_TIME_FORMAT);
		$array["location"] = $this->_contactsmodel->getPlaceList($array['location'],'location');
		$array["location_ct"] = empty($array["location_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['location_ct'];

		$array["relates_to_text"] = "";
		if($array['relates_to'] != "") {
			$array["relates_to_text"] = $this->_phases->getPhaseTitle($array['relates_to']);
		}

		$array["participants"] = $this->_contactsmodel->getUserList($array['participants'],'participants');
		$array["participants_ct"] = empty($array["participants_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['participants_ct'];
		$array["management"] = $this->_contactsmodel->getUserList($array['management'],'management');
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
		
		switch($array["status"]) {
			case "0":
				$array["status_text"] = $lang["MEETING_STATUS_PLANNED"];
				$array["status_date"] = '';
			break;
			case "1":
				$array["status_text"] = $lang["MEETING_STATUS_ON_SCHEDULE"];
				$array["status_date"] = '';
			break;
			case "2":
				$array["status_text"] = $lang["MEETING_STATUS_CANCELLED"];
				$array["status_date"] = '';
				break;
			case "3":
				$array["status_text"] = $lang["MEETING_STATUS_POSPONED"];
				$array["status_date"] = $this->_date->formatDate($array["status_date"],CO_DATE_FORMAT);
			break;
		}
		
		// get user perms
		$array["edit"] = "1";
		
		// get the tasks
		$task = array();
		$q = "SELECT * FROM " . CO_TBL_MEETINGS_TASKS . " where mid = '$id' and bin='0' ORDER BY sort";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
		foreach($row as $key => $val) {
				$tasks[$key] = $val;
			}
			$task[] = new Lists($tasks);
		}
		
		$meeting = new Lists($array);
		$arr = array("meeting" => $meeting, "task" => $task);
		return $arr;
   }


   function setDetails($pid,$id,$title,$meetingdate,$start,$end,$location,$location_ct,$participants,$participants_ct,$management,$management_ct,$task_id,$task_title,$task_text,$task,$task_sort,$documents,$meeting_access,$meeting_access_orig,$meeting_status,$meeting_status_date) {
		global $session, $lang;
		
		$start = $this->_date->formatDateGMT($meetingdate . " " . $start);
		$end = $this->_date->formatDateGMT( $meetingdate . " " . $end);
		$meetingdate = $this->_date->formatDate($meetingdate);
		$participants = $this->_contactsmodel->sortUserIDsByName($participants);
		$management = $this->_contactsmodel->sortUserIDsByName($management);
		$meeting_status_date = $this->_date->formatDateGMT($meeting_status_date);

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
		
		$q = "UPDATE " . CO_TBL_MEETINGS . " set title = '$title', meeting_date = '$meetingdate', start = '$start', end = '$end', location = '$location', location_ct = '$location_ct', participants='$participants', participants_ct='$participants_ct', management='$management', management_ct='$management_ct', documents = '$documents', access='$meeting_access', $accesssql status = '$meeting_status', status_date = '$meeting_status_date', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
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
			$q = "UPDATE " . CO_TBL_MEETINGS_TASKS . " set status = '$checked_items[$key]', title = '$task_title[$key]', text = '$task_text[$key]', sort = '$task_sort[$key]' WHERE id='$task_id[$key]'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
		$arr = array("id" => $id, "what" => "edit");
		}
		// posponed
		if($meeting_status == 3) {
			$q = "INSERT INTO " . CO_TBL_MEETINGS . " set pid='$pid', title = '$title " . $lang["MEETING_POSPONED"] . "', meeting_date = '$meeting_status_date', start = '$start', end = '$end', location = '$location', location_ct = '$location_ct', participants='$participants', participants_ct='$participants_ct', management='$management', management_ct='$management_ct', documents = '$documents', access='$meeting_access', $accesssql status = '0', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
			$result = mysql_query($q, $this->_db->connection);
			if ($result) {
				$nid = mysql_insert_id();
				
				// do tasks
				$qt = "INSERT INTO " . CO_TBL_MEETINGS_TASKS . " (mid,status,title,text,sort) SELECT '$nid',status,title,text,sort FROM " . CO_TBL_MEETINGS_TASKS . " where mid='$id'";
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
		
		$q = "INSERT INTO " . CO_TBL_MEETINGS . " set title = '" . $lang["MEETING_NEW"] . "', meeting_date='$now', start='$time', end='$time', pid = '$id', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		
		$task = $this->addTask($id,0,0);
		
		if ($result) {
			return $id;
		}
   }
   

   	function createDuplicate($id) {
		global $session, $lang;
		// meeting
		$q = "INSERT INTO " . CO_TBL_MEETINGS . " (pid,title,meeting_date,start,end,location,location_ct,length,management,management_ct,participants,participants_ct) SELECT pid,CONCAT(title,' " . $lang["GLOBAL_DUPLICAT"] . "'),meeting_date,start,end,location,location_ct,length,management,management_ct,participants,participants_ct FROM " . CO_TBL_MEETINGS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		// tasks
		$qt = "INSERT INTO " . CO_TBL_MEETINGS_TASKS . " (mid,status,title,text,sort) SELECT $id_new,'0',title,text,sort FROM " . CO_TBL_MEETINGS_TASKS . " where mid='$id' and bin='0'";
		$resultt = mysql_query($qt, $this->_db->connection);
		if ($result) {
			return $id_new;
		}
	}


   function binMeeting($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_MEETINGS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function restoreMeeting($id) {
		$q = "UPDATE " . CO_TBL_MEETINGS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deleteMeeting($id) {
		$q = "SELECT id FROM " . CO_TBL_MEETINGS_TASKS . " WHERE mid = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$tid = $row["id"];
			$this->deleteMeetingTask($tid);
		}
		
		$q = "DELETE FROM " . CO_TBL_MEETINGS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function toggleIntern($id,$status) {
		global $session;
		$q = "UPDATE " . CO_TBL_MEETINGS . " set intern = '$status' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function addTask($mid,$num,$sort) {
		global $session, $lang;
		
		$q = "INSERT INTO " . CO_TBL_MEETINGS_TASKS . " set mid='$mid', status = '0', title = '" . $lang["MEETING_TASK_NEW"] . "', sort='$sort'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		
		$task = array();
		$q = "SELECT * FROM " . CO_TBL_MEETINGS_TASKS . " where id = '$id'";
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
		$q = "UPDATE " . CO_TBL_MEETINGS_TASKS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }
   
   function restoreMeetingTask($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_MEETINGS_TASKS . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }
   
   function deleteMeetingTask($id) {
		global $session;
		$q = "DELETE FROM " . CO_TBL_MEETINGS_TASKS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }

}
?>
<?php

class BrainstormsRostersModel extends BrainstormsModel {
	
	public function __construct() {  
     	parent::__construct();
		//$this->_phases = new BrainstormsPhasesModel();
		$this->_contactsmodel = new ContactsModel();
	}


	function getList($id,$sort) {
		global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("brainstorms-rosters-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("brainstorms-rosters-sort-order",$id);
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
				  		$sortorder = $this->getSortOrder("brainstorms-rosters-sort-order",$id);
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
	  
	  
		$perm = $this->getBrainstormAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		
		$q = "select id,title,access,checked_out,checked_out_user from " . CO_TBL_BRAINSTORMS_ROSTERS . " where pid = '$id' and bin != '1' " . $sql . $order;
		$this->setSortStatus("brainstorms-rosters-sort-status",$sortcur,$id);
		$result = mysql_query($q, $this->_db->connection);
		$items = mysql_num_rows($result);
		
		$rosters = "";
		while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
					
			$checked_out_status = "";
			if($perm !=  "guest" && $array["checked_out"] == 1 && $array["checked_out_user"] != $session->uid) {
				if($session->checkUserActive($array["checked_out_user"])) {
					$checked_out_status = "icon-checked-out-active";
				} else {
					$this->checkinRosterOverride($id);
				}
			}
			
			// access
			$accessstatus = "";
			if($perm !=  "guest") {
				if($array["access"] == 1) {
					$accessstatus = " module-access-active";
				}
			}
			$array["accessstatus"] = $accessstatus;
			
			$array["checked_out_status"] = $checked_out_status;
			
			
			$rosters[] = new Lists($array);
	  }
		
	  $arr = array("rosters" => $rosters, "items" => $items, "sort" => $sortcur, "perm" => $perm);
	  return $arr;
	}
	
	function checkoutRoster($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_ROSTERS . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function getNavNumItems($id) {
		$perm = $this->getBrainstormAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		$q = "select count(*) as items from " . CO_TBL_BRAINSTORMS_ROSTERS . " where pid = '$id' and bin != '1' " . $sql;
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		$items = $row['items'];
		/*if($items == 0) {
			$items = "";
		}*/
		return $items;
	}
	
	function checkinRoster($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_BRAINSTORMS_ROSTERS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_BRAINSTORMS_ROSTERS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}
	
	function checkinRosterOverride($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_ROSTERS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	

	function getDetails($id) {
		global $session, $lang;
		
		$q = "SELECT * FROM " . CO_TBL_BRAINSTORMS_ROSTERS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			
		
			
		$array["perms"] = $this->getBrainstormAccess($array["pid"]);
		$array["canedit"] = false;
		$array["showCheckout"] = false;
		$array["checked_out_user_text"] = $this->_contactsmodel->getUserListPlain($array['checked_out_user']);

		if($array["perms"] == "sysadmin" || $array["perms"] == "admin") {
			//if($array["checked_out"] == 1 && $session->checkUserActive($array["checked_out_user"])) {
			if($array["checked_out"] == 1) {
				if($array["checked_out_user"] == $session->uid) {
					$array["canedit"] = true;
				} else if(!$session->checkUserActive($array["checked_out_user"])) {
					$array["canedit"] = $this->checkoutRoster($id);
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
		$array["checked_out_user_phone1"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
		$array["checked_out_user_email"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");

				}
			} else {
				$array["canedit"] = $this->checkoutRoster($id);
			}
		}
				
		$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		$array["current_user"] = $session->uid;
		$array["today"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		
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
		
		// build cols and notes
		$cols = array();
		$num_notes = array();
		$q = "SELECT * FROM " . CO_TBL_BRAINSTORMS_ROSTERS_COLUMNS . " where pid = '$id' and bin='0' ORDER BY sort";
		$result = mysql_query($q, $this->_db->connection);
		
		
		
		while($row = mysql_fetch_object($result)) {
			$colID = $row->id;
			$qn = "SELECT * FROM " . CO_TBL_BRAINSTORMS_ROSTERS_NOTES . " where cid = '$colID' and bin='0' ORDER BY sort";
			$resultn = mysql_query($qn, $this->_db->connection);
			$num_notes[] = mysql_num_rows($resultn);
			$items = array();
			while($rown = mysql_fetch_object($resultn)) {
				$items[] = array(
					"note_id" => $rown->id,
					"title" => $rown->title,
					"text" => $rown->text,
					"ms" => $rown->ms
				);
			}
			$cols[]= array(
				"id" => $colID,
				"notes" => $items
			);
		}
		
		$colheight=  max($num_notes)*30+57;
		if($colheight < 357) {
			$colheight = 357;
		}
		
		// build the console
		$console_items = array();
		$pid = $array["pid"];
		$qc = "SELECT * FROM " . CO_TBL_BRAINSTORMS_NOTES . " where pid = '$pid' and bin='0' ORDER BY title ASC";
		$resultc = mysql_query($qc, $this->_db->connection);
		while($rowc = mysql_fetch_object($resultc)) {
				$console_items[] = array(
				"id" => $rowc->id,
				"title" => $rowc->title
			);
		}
		
		$sendto = $this->getSendtoDetails("brainstorms_rosters",$id);
		
		$array["roster_width"] = sizeof($cols)*150;
		
		$roster = new Lists($array);
		
		// get created projects
		$ql = "SELECT * FROM co_brainstorms_rosters_log where rid = '$id' ORDER BY created_date DESC";
		$resultl = mysql_query($ql, $this->_db->connection);
		
		$projectsmodel = new ProjectsModel();
		
		$projects = array();
		while($rowl = mysql_fetch_array($resultl)) {
			$projects[]= array(
				"fid" => $projectsmodel->getProjectFolderDetails($rowl['fid'],'title'),
				"pid" => $rowl['pid'],
				"created_date" => $this->_date->formatDate($rowl["created_date"],CO_DATETIME_FORMAT),
				"created_user" => $this->_users->getUserFullname($rowl["created_user"])
			);
		}
		
		$arr = array("roster" => $roster, "cols" => $cols, "colheight" => $colheight, "console_items" => $console_items, "sendto" => $sendto, "access" => $array["perms"], "projects" => $projects);
		return $arr;
   }


   function setDetails($pid,$id,$title,$roster_access,$roster_access_orig) {
		global $session, $lang;

		$now = gmdate("Y-m-d H:i:s");
		
		if($roster_access == $roster_access_orig) {
			$accesssql = "";
		} else {
			$roster_access_date = "";
			if($roster_access == 1) {
				$roster_access_date = $now;
			}
			$accesssql = "access='$roster_access', access_date='$roster_access_date', access_user = '$session->uid',";
		}
		
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_ROSTERS . " set title = '$title', $accesssql edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);

		if ($result) {
		$arr = array("id" => $id, "what" => "edit");
		}

		return $arr;
   }


   function saveRosterColumns($cols) {
		foreach($cols as $key => $val) {
			$q = "UPDATE " . CO_TBL_BRAINSTORMS_ROSTERS_COLUMNS . " set sort = '$key' WHERE id='$val'";
			$result = mysql_query($q, $this->_db->connection);
		}
		return "true";
   }


   function newRosterColumn($id,$sort) {
		$q = "INSERT INTO " . CO_TBL_BRAINSTORMS_ROSTERS_COLUMNS . " set pid = '$id',sort = '$sort'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		if ($result) {
			return $id;
		}
   }
   
   function binRosterColumn($id) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_ROSTERS_COLUMNS . " set bin = '1', bintime = '$now', binuser= '$session->uid' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return "true";
		}
   }

   function saveRosterItems($col,$items) {
		$it = "";
		foreach($items as $key => $id) {
			$q = "UPDATE " . CO_TBL_BRAINSTORMS_ROSTERS_NOTES . " set cid = '$col', sort = '$key' WHERE id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		return "true";
   }
   
   
   function getRosterNote($id) {
	   global $session, $contactsmodel, $lang;
	   
		$q = "SELECT * FROM " . CO_TBL_BRAINSTORMS_ROSTERS_NOTES . " where id='$id'";		
		$result = mysql_query($q, $this->_db->connection);
		
		while($row = mysql_fetch_array($result)) {
			$n["id"] = $row["id"];
			$n["title"] = $row["title"];
			$n["text"] = nl2br($row["text"]);
			
			$n["ms"] = $row["ms"];
						// dates
			$n["created_date"] = $this->_date->formatDate($row["created_date"],CO_DATETIME_FORMAT);
			$n["edited_date"] = $this->_date->formatDate($row["edited_date"],CO_DATETIME_FORMAT);
			
			// other functions
			$n["created_user"] = $this->_users->getUserFullname($row["created_user"]);
			$n["edited_user"] = $this->_users->getUserFullname($row["edited_user"]);
		}

		$note = new Lists($n);

		return $note;
	}   

   
   function saveRosterNewNote($pid,$id) {
		global $session, $contactsmodel, $lang;
		$now = gmdate("Y-m-d H:i:s");
		$q = "SELECT title,text FROM " . CO_TBL_BRAINSTORMS_NOTES . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_row($result);
		$title = mysql_real_escape_string($row[0]);
		$text = mysql_real_escape_string($row[1]);
		
		$q = "INSERT INTO " . CO_TBL_BRAINSTORMS_ROSTERS_NOTES . " set pid = '$pid', title = '$title', text = '$text', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";		
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			$id = mysql_insert_id();
			return $id;
		}
	}	


   function saveRosterNewManualNote($pid) {
		global $session, $lang;
		$now = gmdate("Y-m-d H:i:s");
		$q = "INSERT INTO " . CO_TBL_BRAINSTORMS_ROSTERS_NOTES . " set pid = '$pid', title='" . $lang["BRAINSTORM_ROSTER_ITEM_NEW"]. "', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";		
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			$id = mysql_insert_id();
			return $id;
		}
	}

   function saveRosterNote($id,$title,$text) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_ROSTERS_NOTES . " set title = '$title', text = '$text', edited_user = '$session->uid', edited_date = '$now' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}

	}
	
	
	  function toggleMilestone($id,$ms) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_ROSTERS_NOTES . " set ms = '$ms', edited_user = '$session->uid', edited_date = '$now' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}

	}

	function createNew($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		$time = gmdate("Y-m-d H");
		
		$q = "INSERT INTO " . CO_TBL_BRAINSTORMS_ROSTERS . " set title = '" . $lang["BRAINSTORM_ROSTER_NEW"] . "', pid = '$id', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		
		//$task = $this->addTask($id,0,0);
		$this->newRosterColumn($id,0);
		$this->newRosterColumn($id,1);
		$this->newRosterColumn($id,2);
		$this->newRosterColumn($id,3);
		$this->newRosterColumn($id,4);
		
		if ($result) {
			return $id;
		}
	}
   

	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		// roster
		$q = "INSERT INTO " . CO_TBL_BRAINSTORMS_ROSTERS . " (pid,title,created_date,created_user,edited_date,edited_user) SELECT pid,CONCAT(title,' " . $lang["GLOBAL_DUPLICAT"] . "'),'$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_BRAINSTORMS_ROSTERS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		// cols
		
		$q = "SELECT * FROM " . CO_TBL_BRAINSTORMS_ROSTERS_COLUMNS . " WHERE pid = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$colID = $row["id"];
			$sort = $row['sort'];
			$qc = "INSERT INTO " . CO_TBL_BRAINSTORMS_ROSTERS_COLUMNS . " set pid = '$id_new', sort='$sort'";
			$resultc = mysql_query($qc, $this->_db->connection);
			$colID_new = mysql_insert_id();
			
			$qn = "SELECT * FROM " . CO_TBL_BRAINSTORMS_ROSTERS_NOTES . " where cid = '$colID' and bin='0' ORDER BY sort";
			$resultn = mysql_query($qn, $this->_db->connection);
			$num_notes[] = mysql_num_rows($resultn);
			$items = array();
			while($rown = mysql_fetch_array($resultn)) {
				$note_id = $rown["id"];
				$title = mysql_real_escape_string($rown["title"]);
				$text = mysql_real_escape_string($rown["text"]);
				$ms = $rown["ms"];
				$qnn = "INSERT INTO " . CO_TBL_BRAINSTORMS_ROSTERS_NOTES . " set cid='$colID_new', title = '$title', text = '$text', ms = '$ms',created_date='$now',created_user='$session->uid',edited_date='$now',edited_user='$session->uid'";
				$resultnn = mysql_query($qnn, $this->_db->connection);
			}
			/*$col_notes = '';
			$sort = $row['sort'];
			// notes
			$notes = explode(",",$row["items"]);
			foreach($notes as $note) {
				$qn = "SELECT * FROM " . CO_TBL_BRAINSTORMS_ROSTERS_NOTES . " where id = '$note' and bin='0'";
				$resultn = mysql_query($qn, $this->_db->connection);
					while($rown = mysql_fetch_array($resultn)) {
						$note_id = $rown["id"];
						$title = $rown["title"];
						$text = $rown["text"];
						$ms = $rown["ms"];
						$qnn = "INSERT INTO " . CO_TBL_BRAINSTORMS_ROSTERS_NOTES . " set title = '$title', text = '$text', ms = '$ms'";
						$resultnn = mysql_query($qnn, $this->_db->connection);
						$col_notes .= mysql_insert_id() . ',';
				}
			}
			$col_notes = rtrim($col_notes, ",");
			*/
			
			
		}
		if ($result) {
			return $id_new;
		}
	}


   function binRoster($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_ROSTERS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function restoreRoster($id) {
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_ROSTERS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deleteRoster($id) {
		$q = "DELETE FROM " . CO_TBL_BRAINSTORMS_ROSTERS_NOTES . " WHERE pid = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_BRAINSTORMS_ROSTERS_COLUMNS . " WHERE pid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		/*$q = "DELETE FROM co_log_sendto WHERE what='rosters' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);*/
		
		$q = "DELETE FROM " . CO_TBL_BRAINSTORMS_ROSTERS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   
   function restoreRosterColumn($id) {
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_ROSTERS_COLUMNS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deleteRosterColumn($id) {
		
		$q = "DELETE FROM " . CO_TBL_BRAINSTORMS_ROSTERS_NOTES . " WHERE cid = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		/*$q = "DELETE FROM co_log_sendto WHERE what='rosters' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);*/
		
		$q = "DELETE FROM " . CO_TBL_BRAINSTORMS_ROSTERS_COLUMNS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function toggleIntern($id,$status) {
		global $session;
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_ROSTERS . " set intern = '$status' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function addTask($mid,$num,$sort) {
		global $session, $lang;
		
		$q = "INSERT INTO " . CO_TBL_BRAINSTORMS_ROSTERS_TASKS . " set mid='$mid', status = '0', title = '" . $lang["BRAINSTORM_ROSTER_TASK_NEW"] . "', sort='$sort'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		
		$task = array();
		$q = "SELECT * FROM " . CO_TBL_BRAINSTORMS_ROSTERS_TASKS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$tasks[$key] = $val;
			}
			$task[] = new Lists($tasks);
		}
		
		  	return $task;
   }


   function binItem($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_ROSTERS_NOTES . " set bin = '1', bintime = NOW(), binuser= '$session->uid' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }
   
   function restoreRosterTask($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_ROSTERS_NOTES . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }
   
   function deleteRosterTask($id) {
		global $session;
		$q = "DELETE FROM " . CO_TBL_BRAINSTORMS_ROSTERS_NOTES . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }
   
   function convertToProject($id,$kickoff,$folder,$protocol) {
		global $session, $contactsmodel, $lang;
		
		// get roster details
		$arr = $this->getDetails($id);
		//		$arr = array("roster" => $roster, "cols" => $cols, "colheight" => $colheight, "console_items" => $console_items, "sendto" => $sendto, "access" => $array["perms"]);
		$roster = $arr["roster"];
		$cols = $arr["cols"];
		
		$now = gmdate("Y-m-d H:i:s");
		$title = mysql_real_escape_string($roster->title);
		// create project
		$q = "INSERT INTO " . CO_TBL_PROJECTS . " set folder = '$folder', title = '$title', protocol = '$protocol', startdate = '$kickoff', enddate = '$kickoff', status = '0', planned_date = '$now', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		//if ($result) {
			$pid = mysql_insert_id();
			// if admin insert him to access
			if(!$session->isSysadmin()) {
				$projectsAccessModel = new ProjectsAccessModel();
				$projectsAccessModel->setDetails($id,$session->uid,"");
			}
		//}
		
		// loop through cols
		$datecalc = $kickoff;
		$dependent = 0;
		foreach($cols as $key => &$value){ 
			$i = 0;
			$num_notes = sizeof($cols[$key]["notes"]);
			foreach($cols[$key]["notes"] as $tkey => &$tvalue){ 
				if($i == 0) {
					// add phase
					$phasetitle = mysql_real_escape_string($cols[$key]["notes"][$tkey]['title']);
					$phasetext = mysql_real_escape_string($cols[$key]["notes"][$tkey]['text']);
					$q = "INSERT INTO " . CO_TBL_PROJECTS_PHASES . " set title = '$phasetitle', pid='$pid', protocol='$phasetext', access='0', status = '0', planned_date = '$now', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
					$result = mysql_query($q, $this->_db->connection);
					$phaseid = mysql_insert_id();
					
					if($num_notes == 1) {
						// create ap with same name
						$tasktitle = $phasetitle;
						$taskprotocol = $phasetext;
						$cat = 0;
						$startdate = $this->_date->addDays($datecalc,"1");
						$enddate = $this->_date->addDays($datecalc,"7");
						$datecalc = $enddate;					
						$q = "INSERT INTO " . CO_TBL_PROJECTS_PHASES_TASKS . " set pid='$pid', phaseid='$phaseid', cat='$cat', dependent = '$dependent', status = '0', text = '$tasktitle', protocol = '$taskprotocol', startdate = '$startdate', enddate = '$enddate'";
						$result = mysql_query($q, $this->_db->connection);
						$dependent = mysql_insert_id();
					}
					
				} else {
					// create ap/milestone
					$tasktitle = mysql_real_escape_string($cols[$key]["notes"][$tkey]['title']);
					$taskprotocol = mysql_real_escape_string($cols[$key]["notes"][$tkey]['text']);
					if($cols[$key]["notes"][$tkey]['ms'] == "1") {
						$cat = 1;
						$startdate = $this->_date->addDays($datecalc,"1");
						$enddate = $this->_date->addDays($datecalc,"1");
					} else {
						$cat = 0;
						$startdate = $this->_date->addDays($datecalc,"1");
						$enddate = $this->_date->addDays($datecalc,"7");
					}
					$datecalc = $enddate;					
					$q = "INSERT INTO " . CO_TBL_PROJECTS_PHASES_TASKS . " set pid='$pid', phaseid='$phaseid', cat='$cat', dependent = '$dependent', status = '0', text = '$tasktitle', protocol = '$taskprotocol', startdate = '$startdate', enddate = '$enddate'";
					$result = mysql_query($q, $this->_db->connection);
					$dependent = mysql_insert_id();
				}
				$i++;
			}
		}
		
		$q = "INSERT INTO co_brainstorms_rosters_log set rid = '$id', pid = '$pid', fid = '$folder', created_user = '$session->uid', created_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		
		$projectsmodel = new ProjectsModel();		
		$return["fid"] = $projectsmodel->getProjectFolderDetails($folder,'title');
		$return["pid"] = $pid;
		$return["created_user"] = $this->_users->getUserFullname($session->uid);
		$return["created_date"] = $this->_date->formatDate($now,CO_DATETIME_FORMAT);
		
		return $return;
		
   }
   

}
?>
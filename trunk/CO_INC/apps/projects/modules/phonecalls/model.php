<?php

class PhonecallsModel extends ProjectsModel {
	
	public function __construct() {  
		parent::__construct();
		$this->_phases = new PhasesModel();
		$this->_contactsmodel = new ContactsModel();
	}
	
	function getList($id,$sort) {
	global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("phonecall-sort-status",$id);
		  if(!$sortstatus) {
				$order = "order by phonecall_date DESC";
				$sortcur = '1';
		  } else {
			  switch($sortstatus) {
				  case "1":
				  		$order = "order by phonecall_date DESC";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by phonecall_date ASC";
							$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("phonecall-sort-order",$id);
				  		if(!$sortorder) {
								$order = "order by phonecall_date DESC";
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
				  		$order = "order by phonecall_date DESC";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by phonecall_date ASC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("phonecall-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by phonecall_date DESC";
								$sortcur = '1';
						  } else {
								$order = "order by field(id,$sortorder)";
								$sortcur = '3';
						  }
				  break;	
			  }
	  }
	  
		$q = "select id,title,phonecall_date,intern from " . CO_TBL_PHONECALLS . " where pid = '$id' and bin != '1' " . $order;

	  $this->setSortStatus("phonecall-sort-status",$sortcur,$id);
		$result = mysql_query($q, $this->_db->connection);
	  $phonecalls = "";
	  while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			
			// dates
			$array["phonecall_date"] = $this->_date->formatDate($array["phonecall_date"],CO_DATE_FORMAT);
			
			// intern
			$itemstatus = "";
			if($array["intern"] == 1) {
				$itemstatus = " module-item-active";
			}
			$array["itemstatus"] = $itemstatus;
			
			$phonecalls[] = new Lists($array);
	  }
		
	  $arr = array("phonecalls" => $phonecalls, "sort" => $sortcur);
	  return $arr;
	}

	
	
	// Get phonecall list from ids for Tooltips
	function getPhonecallDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			$q = "SELECT id,title from " . CO_TBL_PHONECALLS . " where id = '$value'";
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
   
   function getDependency($id){
		$q = "SELECT title FROM " . CO_TBL_PHASES . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		return mysql_num_rows($result);
   }
   
	function getDetails($id) {
		global $session;
		$q = "SELECT * FROM " . CO_TBL_PHONECALLS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
		
		// dates
		$array["phonecall_date"] = $this->_date->formatDate($array["phonecall_date"],CO_DATE_FORMAT);
		
		//$array["posponed_date"] = $this->_date->formatDate($array["posponed_date"],CO_DATE_FORMAT);
		
		// time
		$array["start"] = $this->_date->formatDate($array["start"],CO_TIME_FORMAT);
		$array["end"] = $this->_date->formatDate($array["end"],CO_TIME_FORMAT);
		
		/*$array["relates_to_text"] = "";
		if($array['relates_to'] != "") {
			$array["relates_to_text"] = $this->_phases->getPhaseTitle($array['relates_to']);
		}*/
		
		//$array["related_to"] = $this->_phases->getDocumentDetails($row['related_to'],'related_to');
		//$array["dependency_exists"] = $this->getDependency($id);
		//$array["projecttitle"] = $this->getProjectTitle($array['pid']);
		//$array["participants"] = $this->_contactsmodel->getUserList($array['participants'],'participants');
		//$array["coordinator"] = $this->_contactsmodel->getUserList($array['coordinator'],'coordinator');
		//$array["documents"] = $this->getRelatedDocuments('0:'.$id);
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		$array["current_user"] = $session->uid;
		
		// get user perms
		$array["edit"] = "1";
		
		$phonecalls = new Lists($array);
		
		//$arr = array("phonecall" => $phonecall, "task" => $task);
	  
		return $phonecalls;
   }
   
   function setDetails($id,$title,$phonecalldate,$task_idnew,$task_textnew,$task_new,$task_id,$task_text,$task) {
		global $session;
		
		$phonecalldate = $this->_date->formatDate($phonecalldate);
		
		$q = "UPDATE " . CO_TBL_PHONECALLS . " set title = '$title', phonecall_date = '$phonecalldate', edited_user = '$session->uid', edited_date = NOW() where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		// do existing tasks
		$task_size = sizeof($task_id);
		for ($i = 0; $i < $task_size; $i++) {
			if (is_array($task)) {
				if (in_array($task_id[$i], $task) == true) {
					$checked_items[$i] = '1';
				} else {
					$checked_items[$i] = '0';
				}
			} else {
				$checked_items[$i] = '0';
			}
		}

		for ($i = 0; $i < $task_size; $i++) {
			if ($task_text[$i] != "") {
			$q = "UPDATE " . CO_TBL_PHONECALLS_TASKS . " set status = '$checked_items[$i]', text = '$task_text[$i]' WHERE id='$task_id[$i]'";
			$result = mysql_query($q, $this->_db->connection);
			} else {
				$q = "DELETE FROM " . CO_TBL_PHONECALLS_TASKS . " WHERE id='$task_id[$i]'";
				$result = mysql_query($q, $this->_db->connection);
			}
		}
		
		// do new tasks
		$task_size_new = sizeof($task_idnew);
		for ($i = 0; $i < $task_size_new; $i++) {
			if (is_array($task_new)) {
				if (in_array($task_idnew[$i], $task_new) == true) {
					$checked_items_new[$i] = '1';
				} else {
					$checked_items_new[$i] = '0';
				}
			} else {
				$checked_items_new[$i] = '0';
			}
		}

		for ($i = 0; $i < $task_size_new; $i++) {
			if ($task_textnew[$i] != "") {
				$q = "INSERT INTO " . CO_TBL_PHONECALLS_TASKS . " set phaseid='$id', status = '$checked_items_new[$i]', text = '$task_textnew[$i]'";
				$result = mysql_query($q, $this->_db->connection);
			}
		}
		
		if ($result) {
			return $id;
		}
   }
   
   function getNew($id) {
		// get user perms
		$array["pid"] = $id;
		$array["phonecall_date"] = $this->_date->formatDate(date("Y-m-d"),CO_DATE_FORMAT);
		
		$phonecall = new Lists($array);
		return $phonecall;
   }
   
   function createNew($id,$title,$phonecall_date) {
		global $session;
		
		$phonecall_date = $this->_date->formatDateGMT("2010-09-15 12:15:00");
		
		$q = "INSERT INTO " . CO_TBL_PHONECALLS . " set title = '$title', phonecall_date='$phonecall_date', pid = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	$id = mysql_insert_id();
			return $id;
		}
   }
   
   function binPhonecall($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PHONECALLS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function toggleIntern($id,$status) {
		global $session;
		$q = "UPDATE " . CO_TBL_PHONECALLS . " set intern = '$status' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }

}
?>
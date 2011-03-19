<?php

class AccessModel extends ProjectsModel {
	
	public function __construct() {  
		parent::__construct();
		$this->_contactsmodel = new ContactsModel();
	}
	
	
	function getList($id,$sort) {
		global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("access-sort-status",$id);
		  if(!$sortstatus) {
				$order = "order by a.id";
				$sortcur = '1';
		  } else {
			  switch($sortstatus) {
				  case "1":
				  		$order = "order by a.id";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by a.id DESC";
							$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("access-sort-order",$id);
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
				  		$order = "order by a.id";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by a.id DESC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("access-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by a.id";
								$sortcur = '1';
						  } else {
								$order = "order by field(id,$sortorder)";
								$sortcur = '3';
						  }
				  break;	
			  }
	  }
	  
		//$q = "select id,title,intern,document_date from " . CO_TBL_DOCUMENTS . " where pid = '$id' and bin != '1' " . $order;
		$q = "select a.id,a.firstname,a.lastname from " . CO_TBL_USERS . " as a, " . CO_TBL_ACCESS . " as b where b.pid ='$id' and a.id=b.uid and a.invisible = '0' and a.bin = '0' " . $order;

	  $this->setSortStatus("access-sort-status",$sortcur,$id);
		$result = mysql_query($q, $this->_db->connection);
	  $access = "";
	  while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			
			// dates
			//$array["document_date"] = $this->_date->formatDate($array["document_date"],CO_DATE_FORMAT);
			
			// intern
			/*$itemstatus = "";
			if($array["intern"] == 1) {
				$itemstatus = " module-item-active";
			}
			$array["itemstatus"] = $itemstatus;*/
			
			$access[] = new Lists($array);
	  }
		
	  $arr = array("access" => $access, "sort" => $sortcur);
	  return $arr;
	}
	
	
	// Get access list from ids for Tooltips
	function getAccessDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			$q = "SELECT id,title from " . CO_TBL_ACCESS . " where id = '$value'";
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
		$q = "SELECT title FROM " . CO_TBL_ACCESS . " where dependency = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		return mysql_num_rows($result);
   }
   
	function getDetails($id,$pid) {
		global $session, $contactsmodel;
		$q = "SELECT a.firstname,a.lastname,b.* FROM " . CO_TBL_USERS . " as a, " . CO_TBL_ACCESS . " as b where b.uid = '$id' and b.pid='$pid' and a.id=b.uid ";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			
		$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		
		$access = new Lists($array);
	  
		return $access;
   }
   
   function setDetails($id,$title,$startdate,$enddate,$management,$team,$protocol,$projectstatus,$planned_date,$inprogress_date,$finished_date,$task_startdatenew,$task_enddatenew,$task_idnew,$task_textnew,$task_new,$task_startdate,$task_enddate,$task_id,$task_text,$task) {
		global $session;
		
		$startdate = $this->_date->formatDate($startdate);
		$enddate = $this->_date->formatDate($enddate);
		$planned_date = $this->_date->formatDate($planned_date);
		$inprogress_date = $this->_date->formatDate($inprogress_date);
		$finished_date = $this->_date->formatDate($finished_date);
		
		// user lists
		$management = $this->_contactsmodel->sortUserIDsByName($management);
		$team = $this->_contactsmodel->sortUserIDsByName($team);
		
		$q = "UPDATE " . CO_TBL_ACCESS . " set title = '$title', startdate = '$startdate', enddate = '$enddate', management = '$management', team='$team', protocol = '$protocol', projectstatus = '$projectstatus', planned_date = '$planned_date', inprogress_date = '$inprogress_date', finished_date = '$finished_date', edited_user = '$session->uid', edited_date = NOW() where id='$id'";
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
			$start = $this->_date->formatDate($task_startdate[$i]);
			$end = $this->_date->formatDate($task_startdate[$i]);
			
			$q = "UPDATE " . CO_TBL_ACCESS_TASKS . " set status = '$checked_items[$i]', text = '$task_text[$i]', startdate = '$start', enddate = '$end' WHERE id='$task_id[$i]'";
			$result = mysql_query($q, $this->_db->connection);
			} else {
				$q = "DELETE FROM " . CO_TBL_ACCESS_TASKS . " WHERE id='$task_id[$i]'";
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
			$start = $this->_date->formatDate($task_startdatenew[$i]);
			$end = $this->_date->formatDate($task_startdatenew[$i]);
			
			$q = "INSERT INTO " . CO_TBL_ACCESS_TASKS . " set accessid='$id', status = '$checked_items_new[$i]', text = '$task_textnew[$i]', startdate = '$start', enddate = '$end'";
			$result = mysql_query($q, $this->_db->connection);
			}
		}
		
		if ($result) {
			return $id;
		}
   }
   
	 
   function getNew($id) {
		global $session, $contactsmodel;
		$array["pid"] = $id;

		$q = "SELECT * FROM " . CO_TBL_PROJECTS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
		
		// dates
		$array["startdate"] = $this->_date->formatDate($array["startdate"],CO_DATE_FORMAT);
		$array["enddate"] = $this->_date->formatDate($array["enddate"],CO_DATE_FORMAT);
		
		// other functions
		$array["management"] = $contactsmodel->getUserList($array['management'],'management');
		$array["team"] = $contactsmodel->getUserList($array['team'],'team');
		
		$access = new Lists($array);
		return $access;
   }
   
   function createNew($id,$title,$startdate,$enddate,$management,$team,$protocol,$projectstatus,$planned_date,$inprogress_date,$finished_date,$task_startdatenew,$task_enddatenew,$task_idnew,$task_textnew,$task_new) {
		global $session;
		$q = "INSERT INTO " . CO_TBL_ACCESS . " set title = '$title', pid='$id', startdate = '$startdate', enddate = '$enddate', management = '$management', team='$team', protocol = '$protocol', projectstatus = '$projectstatus', planned_date = '$planned_date', inprogress_date = '$inprogress_date', finished_date = '$finished_date', created_user = '$session->uid', created_date = NOW(), edited_user = '$session->uid', edited_date = NOW()";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		
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
			$start = $this->_date->formatDate($task_startdatenew[$i]);
			$end = $this->_date->formatDate($task_startdatenew[$i]);
			
			$q = "INSERT INTO " . CO_TBL_ACCESS_TASKS . " set accessid='$id', status = '$checked_items_new[$i]', text = '$task_textnew[$i]', startdate = '$start', enddate = '$end'";
			$result = mysql_query($q, $this->_db->connection);
			}
		}
		
		
		if ($result) {
		  	
			return $id;
		}
   }
	 
	 function createDuplicate($id) {
			global $session;
			$q = "INSERT INTO " . CO_TBL_ACCESS . " (pid,title,team,management,startdate,enddate) SELECT pid,CONCAT(title,' Duplicat'),team,management,startdate,enddate FROM " . CO_TBL_ACCESS . " where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
			$id_new = mysql_insert_id();
			
			// duplicate access tasks
			$qt = "INSERT INTO " . CO_TBL_ACCESS_TASKS . " (accessid,status,text,startdate,enddate) SELECT $id_new,status,text,startdate,enddate FROM " . CO_TBL_ACCESS_TASKS . " where accessid='$id'";
			$resultt = mysql_query($qt, $this->_db->connection);
			
			if ($result) {
					return $id_new;
			}
	 }
   
   function binAccess($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_ACCESS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }

}
?>
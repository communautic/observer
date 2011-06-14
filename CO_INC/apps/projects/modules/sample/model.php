<?php

class SampleModel extends ProjectsModel {
	
	public function __construct() {  
     parent::__construct();
		$this->_phases = new PhasesModel();
		$this->_contactsmodel = new ContactsModel();
	}
	
	function getList($id,$sort) {
	global $session;

			// dates
			$array["id"] = 0;
			$array["sample_date"] = $this->_date->formatDate("now",CO_DATE_FORMAT);
			$array["title"] = "Sample";
			$array["itemstatus"] = "";
			
			$samples[] = new Lists($array);
		
	  $arr = array("samples" => $samples, "sort" => 0);
	  return $arr;
	}

	
	
	// Get sample list from ids for Tooltips
	function getSampleDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			$q = "SELECT id,title from " . CO_TBL_SAMPLE . " where id = '$value'";
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
		$q = "SELECT title FROM " . CO_TBL_PROJECTS_PHASES . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		return mysql_num_rows($result);
   }
   
	function getDetails($id) {
		global $session;
		$q = "SELECT * FROM " . CO_TBL_SAMPLE . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
		
		// dates
		$array["sample_date"] = $this->_date->formatDate($array["sample_date"],CO_DATE_FORMAT);
		
		$array["posponed_date"] = $this->_date->formatDate($array["posponed_date"],CO_DATE_FORMAT);
		
		// time
		$array["start"] = $this->_date->formatDate($array["sample_date"],CO_TIME_FORMAT);
		$array["end"] = $this->_date->formatDate($array["sample_date"],CO_TIME_FORMAT);
		
		//$array["related_to"] = $this->_phases->getDocumentDetails($row['related_to'],'related_to');
		//$array["dependency_exists"] = $this->getDependency($id);
		//$array["projecttitle"] = $this->getProjectTitle($array['pid']);
		$array["participants"] = $this->_contactsmodel->getUserList($array['participants'],'participants');
		$array["coordinator"] = $this->_contactsmodel->getUserList($array['coordinator'],'coordinator');
		//$array["documents"] = $this->getRelatedDocuments('0:'.$id);
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		$array["current_user"] = $session->uid;
		
		// get user perms
		$array["edit"] = "1";
		
		$sample = new Lists($array);
		
		// get the tasks
		$task = array();
		$q = "SELECT * FROM " . CO_TBL_SAMPLE_TASKS . " where phaseid = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
		foreach($row as $key => $val) {
				$tasks[$key] = $val;
			}
		
		$task[] = new Lists($tasks);
		}
		
		$arr = array("sample" => $sample, "task" => $task);
	  
		return $arr;
   }
   
   function setDetails($id,$title,$sampledate,$task_idnew,$task_textnew,$task_new,$task_id,$task_text,$task) {
		global $session;
		
		$sampledate = $this->_date->formatDate($sampledate);
		
		$q = "UPDATE " . CO_TBL_SAMPLE . " set title = '$title', sample_date = '$sampledate', edited_user = '$session->uid', edited_date = NOW() where id='$id'";
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
			$q = "UPDATE " . CO_TBL_SAMPLE_TASKS . " set status = '$checked_items[$i]', text = '$task_text[$i]' WHERE id='$task_id[$i]'";
			$result = mysql_query($q, $this->_db->connection);
			} else {
				$q = "DELETE FROM " . CO_TBL_SAMPLE_TASKS . " WHERE id='$task_id[$i]'";
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
				$q = "INSERT INTO " . CO_TBL_SAMPLE_TASKS . " set phaseid='$id', status = '$checked_items_new[$i]', text = '$task_textnew[$i]'";
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
		$array["sample_date"] = $this->_date->formatDate(date("Y-m-d"),CO_DATE_FORMAT);
		
		$sample = new Lists($array);
		return $sample;
   }
   
   function createNew($id,$title,$sample_date) {
		global $session;
		
		$sample_date = $this->_date->formatDateGMT("2010-09-15 12:15:00");
		
		$q = "INSERT INTO " . CO_TBL_SAMPLE . " set title = '$title', sample_date='$sample_date', pid = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	$id = mysql_insert_id();
			return $id;
		}
   }
   
   function binSample($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_SAMPLE . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function toggleIntern($id,$status) {
		global $session;
		$q = "UPDATE " . CO_TBL_SAMPLE . " set intern = '$status' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }

}
?>
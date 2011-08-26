<?php

class VDocsModel extends ProjectsModel {
	
	public function __construct() {  
     	parent::__construct();
		$this->_phases = new ProjectsPhasesModel();
		$this->_contactsmodel = new ContactsModel();
	}


	function getList($id,$sort) {
		global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("vdoc-sort-status",$id);
		  if(!$sortstatus) {
				$order = "order by edited_date DESC";
				$sortcur = '1';
		  } else {
			  switch($sortstatus) {
				  case "1":
				  		$order = "order by edited_date DESC";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by edited_date ASC";
							$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("vdoc-sort-order",$id);
				  		if(!$sortorder) {
								$order = "order by edited_date DESC";
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
				  		$order = "order by edited_date DESC";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by edited_date ASC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("vdoc-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by edited_date DESC";
								$sortcur = '1';
						  } else {
								$order = "order by field(id,$sortorder)";
								$sortcur = '3';
						  }
				  break;	
			  }
	  }
	  
		//$q = "select title,id,intern,startdate,enddate from " . CO_TBL_PROJECTS_PHASES . " where pid = '$id' and bin != '1' " . $order;
		$q = "select id,title,access from " . CO_TBL_PROJECTS_VDOCS . " where pid = '$id' and bin != '1' " . $order;

	  $this->setSortStatus("vdoc-sort-status",$sortcur,$id);
	  $result = mysql_query($q, $this->_db->connection);
	  $vdocs = "";
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
			
			$vdocs[] = new Lists($array);
	  }
		
	  $arr = array("vdocs" => $vdocs, "sort" => $sortcur);
	  return $arr;
	}

	
	// Get vdoc list from ids for Tooltips
	function getVDocDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			$q = "SELECT id,title from " . CO_TBL_PROJECTS_VDOCS . " where id = '$value'";
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
		$q = "SELECT title FROM " . CO_TBL_PROJECTS_PHASES . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		return mysql_num_rows($result);
	}*/


	function getDetails($id) {
		global $session, $lang;
		
		//$this->_documents = new DocumentsModel();
		
		$q = "SELECT * FROM " . CO_TBL_PROJECTS_VDOCS . " where id = '$id'";
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
		
		
		// get user perms
		$array["edit"] = "1";
		
		$sendto = $this->getSendtoDetails("projects_vdocs",$id);
		
		$vdoc = new Lists($array);
		$arr = array("vdoc" => $vdoc, "sendto" => $sendto);
		return $arr;
   }


   function setDetails($pid,$id,$title,$content,$vdoc_access,$vdoc_access_orig) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		if($vdoc_access == $vdoc_access_orig) {
			$accesssql = "";
		} else {
			$vdoc_access_date = "";
			if($vdoc_access == 1) {
				$vdoc_access_date = $now;
			}
			$accesssql = "access='$vdoc_access', access_date='$vdoc_access_date', access_user = '$session->uid',";
		}
		
		$q = "UPDATE " . CO_TBL_PROJECTS_VDOCS . " set title = '$title', content = '$content', access='$vdoc_access', $accesssql edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		
		if ($result) {
		$arr = array("id" => $id, "what" => "edit");
		}
		return $arr;
   }


   function createNew($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		$time = gmdate("Y-m-d H");
		
		$q = "INSERT INTO " . CO_TBL_PROJECTS_VDOCS . " set title = '" . $lang["PROJECT_VDOC_NEW"] . "', date='$now', start='$time', end='$time', pid = '$id', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		
		if ($result) {
			return $id;
		}
   }
   

   	function createDuplicate($id) {
		global $session, $lang;
		// vdoc
		$q = "INSERT INTO " . CO_TBL_PROJECTS_VDOCS . " (pid,title,date,start,end,location,location_ct,length,management,management_ct,participants,participants_ct) SELECT pid,CONCAT(title,' " . $lang["GLOBAL_DUPLICAT"] . "'),date,start,end,location,location_ct,length,management,management_ct,participants,participants_ct FROM " . CO_TBL_PROJECTS_VDOCS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		if ($result) {
			return $id_new;
		}
	}


   function binVDoc($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PROJECTS_VDOCS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function restoreVDoc($id) {
		$q = "UPDATE " . CO_TBL_PROJECTS_VDOCS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deleteVDoc($id) {
		
		$q = "DELETE FROM co_log_sendto WHERE what='vdocs' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_PROJECTS_VDOCS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function toggleIntern($id,$status) {
		global $session;
		$q = "UPDATE " . CO_TBL_PROJECTS_VDOCS . " set intern = '$status' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   //$vdocsmodel = new VDocsModel();

}
?>
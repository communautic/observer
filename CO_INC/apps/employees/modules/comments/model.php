<?php

class EmployeesCommentsModel extends EmployeesModel {
	
	public function __construct() {  
     	parent::__construct();
		$this->_contactsmodel = new ContactsModel();
	}


	function getList($id,$sort) {
		global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("employees-comments-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("employees-comments-sort-order",$id);
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
				  		$sortorder = $this->getSortOrder("employees-comments-sort-order",$id);
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
		
		$q = "select id,title,item_date,access,status,checked_out,checked_out_user from " . CO_TBL_EMPLOYEES_COMMENTS . " where pid = '$id' and bin != '1' " . $sql . $order;
		$this->setSortStatus("employees-comments-sort-status",$sortcur,$id);
		$result = mysql_query($q, $this->_db->connection);
		$items = mysql_num_rows($result);
		
		$comments = "";
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
			$array["itemstatus"] = $itemstatus;
			
			$checked_out_status = "";
			if($perm !=  "guest" && $array["checked_out"] == 1 && $array["checked_out_user"] != $session->uid) {
				if($session->checkUserActive($array["checked_out_user"])) {
					$checked_out_status = "icon-checked-out-active";
				} else {
					$this->checkinCommentOverride($id);
				}
			}
			$array["checked_out_status"] = $checked_out_status;
			
			$comments[] = new Lists($array);
	  }
		
	  $arr = array("comments" => $comments, "items" => $items, "sort" => $sortcur, "perm" => $perm);
	  return $arr;
	}

	function getNavNumItems($id) {
		$perm = $this->getEmployeeAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		$q = "select count(*) as items from " . CO_TBL_EMPLOYEES_COMMENTS . " where pid = '$id' and bin != '1' " . $sql;
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		$items = $row['items'];
		return $items;
	}

	function checkoutComment($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_EMPLOYEES_COMMENTS . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function checkinComment($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_EMPLOYEES_COMMENTS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_EMPLOYEES_COMMENTS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}


	function checkinCommentOverride($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_EMPLOYEES_COMMENTS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	

	function getDetails($id, $option = "") {
		global $session, $lang;
		
		$this->_documents = new EmployeesDocumentsModel();
		
		$q = "SELECT * FROM " . CO_TBL_EMPLOYEES_COMMENTS . " where id = '$id'";
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
					$array["canedit"] = $this->checkoutComment($id);
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
					$array["checked_out_user_phone1"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
					$array["checked_out_user_email"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");
				}
			} else {
				$array["canedit"] = $this->checkoutComment($id);
			}
		}
		
		// dates
		$array["item_date"] = $this->_date->formatDate($array["item_date"],CO_DATE_FORMAT);
		
		// time
		$array["start"] = $this->_date->formatDate($array["start"],CO_TIME_FORMAT);
		$array["end"] = $this->_date->formatDate($array["end"],CO_TIME_FORMAT);

		$array["management_print"] = $this->_contactsmodel->getUserListPlain($array["management"]);
		if($option = 'prepareSendTo') {
			$array["sendtoTeam"] = $this->_contactsmodel->checkUserListEmail($array["management"],'employeesmanagement', "", $array["canedit"]);
			$array["sendtoTeamNoEmail"] = $this->_contactsmodel->checkUserListEmail($array["management"],'employeesmanagement', "", $array["canedit"], 0);
			$array["sendtoError"] = false;
		}
		$array["management"] = $this->_contactsmodel->getUserList($array['management'],'employeesmanagement', "", $array["canedit"]);
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
				$array["status_text"] = $lang["EMPLOYEE_COMMENT_STATUS_OUTGOING"];
				$array["status_date"] = '';
			break;
			case "1":
				$array["status_text"] = $lang["EMPLOYEE_COMMENT_STATUS_ON_INCOMING"];
				$array["status_date"] = '';
			break;
		}
		
		$sendto = $this->getSendtoDetails("employees_comments",$id);

		$comment = new Lists($array);
		$arr = array("comment" => $comment, "sendto" => $sendto, "access" => $array["perms"]);
		return $arr;
   }


   function setDetails($pid,$id,$title,$commentdate,$protocol,$management,$management_ct,$documents,$comment_access,$comment_access_orig) {
		global $session, $lang;
		
		$commentdate = $this->_date->formatDate($commentdate);
		$management = $this->_contactsmodel->sortUserIDsByName($management);

		$now = gmdate("Y-m-d H:i:s");
		
		if($comment_access == $comment_access_orig) {
			$accesssql = "";
		} else {
			$comment_access_date = "";
			if($comment_access == 1) {
				$comment_access_date = $now;
			}
			$accesssql = "access='$comment_access', access_date='$comment_access_date', access_user = '$session->uid',";
		}

		$q = "UPDATE " . CO_TBL_EMPLOYEES_COMMENTS . " set title = '$title', item_date = '$commentdate', protocol = '$protocol', management='$management', management_ct='$management_ct', documents = '$documents', access='$comment_access', $accesssql edited_user = '$session->uid', edited_date = '$now' where id='$id'";
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
		
		$q = "INSERT INTO " . CO_TBL_EMPLOYEES_COMMENTS . " set title = '" . $lang["EMPLOYEE_COMMENT_NEW"] . "', item_date='$now', pid = '$id', status = '1', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
				
		if ($result) {
			return $id;
		}
   }
   

   	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		// comment
		$q = "INSERT INTO " . CO_TBL_EMPLOYEES_COMMENTS . " (pid,title,item_date,start,end,protocol,management,management_ct,status,created_date,created_user,edited_date,edited_user) SELECT pid,CONCAT(title,' " . $lang["GLOBAL_DUPLICAT"] . "'),item_date,start,end,protocol,management,management_ct,status,'$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_EMPLOYEES_COMMENTS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		if ($result) {
			return $id_new;
		}
	}


   function binComment($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_EMPLOYEES_COMMENTS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function restoreComment($id) {
		$q = "UPDATE " . CO_TBL_EMPLOYEES_COMMENTS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deleteComment($id) {
		
		$q = "DELETE FROM co_log_sendto WHERE what='employees_comments' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_EMPLOYEES_COMMENTS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function toggleIntern($id,$status) {
		global $session;
		$q = "UPDATE " . CO_TBL_EMPLOYEES_COMMENTS . " set intern = '$status' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }

}
?>
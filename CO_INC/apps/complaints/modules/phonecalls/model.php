<?php

class ComplaintsPhonecallsModel extends ComplaintsModel {
	
	public function __construct() {  
     	parent::__construct();
		$this->_contactsmodel = new ContactsModel();
	}


	function getList($id,$sort) {
		global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("complaints-phonecalls-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("complaints-phonecalls-sort-order",$id);
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
				  		$sortorder = $this->getSortOrder("complaints-phonecalls-sort-order",$id);
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
	  
	  
		$perm = $this->getComplaintAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		
		$q = "select id,title,item_date,access,status,checked_out,checked_out_user from " . CO_TBL_COMPLAINTS_PHONECALLS . " where pid = '$id' and bin != '1' " . $sql . $order;
		$this->setSortStatus("complaints-phonecalls-sort-status",$sortcur,$id);
		$result = mysql_query($q, $this->_db->connection);
		$items = mysql_num_rows($result);
		
		$phonecalls = "";
		while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			
			// dates
			$array["item_date"] = $this->_date->formatDate($array["item_date"],CO_DATE_FORMAT);
			
			// access
			$accessstatus = "";
			if($array["access"] == 1) {
				$accessstatus = " module-access-active";
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
					$this->checkinPhonecallOverride($id);
				}
			}
			$array["checked_out_status"] = $checked_out_status;
			
			$phonecalls[] = new Lists($array);
	  }
		
	  $arr = array("phonecalls" => $phonecalls, "items" => $items, "sort" => $sortcur, "perm" => $perm);
	  return $arr;
	}

	function getNavNumItems($id) {
		$perm = $this->getComplaintAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		$q = "select count(*) as items from " . CO_TBL_COMPLAINTS_PHONECALLS . " where pid = '$id' and bin != '1' " . $sql;
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		$items = $row['items'];
		return $items;
	}

	function checkoutPhonecall($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_COMPLAINTS_PHONECALLS . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function checkinPhonecall($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_COMPLAINTS_PHONECALLS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_COMPLAINTS_PHONECALLS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}


	function checkinPhonecallOverride($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_COMPLAINTS_PHONECALLS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	

	function getDetails($id, $option = "") {
		global $session, $lang;
		
		$this->_documents = new ComplaintsDocumentsModel();
		
		$q = "SELECT * FROM " . CO_TBL_COMPLAINTS_PHONECALLS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
			
		$array["perms"] = $this->getComplaintAccess($array["pid"]);
		$array["canedit"] = false;
		$array["showCheckout"] = false;
		$array["checked_out_user_text"] = $this->_contactsmodel->getUserListPlain($array['checked_out_user']);

		if($array["perms"] == "sysadmin" || $array["perms"] == "admin") {
			//if($array["checked_out"] == 1 && $session->checkUserActive($array["checked_out_user"])) {
			if($array["checked_out"] == 1) {
				if($array["checked_out_user"] == $session->uid) {
					$array["canedit"] = true;
				} else if(!$session->checkUserActive($array["checked_out_user"])) {
					$array["canedit"] = $this->checkoutPhonecall($id);
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
					$array["checked_out_user_phone1"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
					$array["checked_out_user_email"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");
				}
			} else {
				$array["canedit"] = $this->checkoutPhonecall($id);
			}
		}
		
		// dates
		$array["item_date"] = $this->_date->formatDate($array["item_date"],CO_DATE_FORMAT);
		
		// time
		$array["start"] = $this->_date->formatDate($array["start"],CO_TIME_FORMAT);
		$array["end"] = $this->_date->formatDate($array["end"],CO_TIME_FORMAT);

		$array["management_print"] = $this->_contactsmodel->getUserListPlain($array["management"]);
		if($option = 'prepareSendTo') {
			$array["sendtoTeam"] = $this->_contactsmodel->checkUserListEmail($array["management"],'complaintsmanagement', "", $array["canedit"]);
			$array["sendtoTeamNoEmail"] = $this->_contactsmodel->checkUserListEmail($array["management"],'complaintsmanagement', "", $array["canedit"], 0);
			$array["sendtoError"] = false;
		}
		$array["management"] = $this->_contactsmodel->getUserList($array['management'],'complaintsmanagement', "", $array["canedit"]);
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
				$array["status_text"] = $lang["COMPLAINT_PHONECALL_STATUS_OUTGOING"];
				$array["status_date"] = '';
			break;
			case "1":
				$array["status_text"] = $lang["COMPLAINT_PHONECALL_STATUS_ON_INCOMING"];
				$array["status_date"] = '';
			break;
		}
		
		$sendto = $this->getSendtoDetails("complaints_phonecalls",$id);

		$phonecall = new Lists($array);
		$arr = array("phonecall" => $phonecall, "sendto" => $sendto, "access" => $array["perms"]);
		return $arr;
   }


   function setDetails($pid,$id,$title,$phonecalldate,$start,$end,$protocol,$management,$management_ct,$documents,$phonecall_access,$phonecall_access_orig,$phonecall_status,$phonecall_status_date) {
		global $session, $lang;
		
		$start = $this->_date->formatDateGMT($phonecalldate . " " . $start);
		$end = $this->_date->formatDateGMT( $phonecalldate . " " . $end);
		$phonecalldate = $this->_date->formatDate($phonecalldate);
		$management = $this->_contactsmodel->sortUserIDsByName($management);
		$phonecall_status_date = $this->_date->formatDateGMT($phonecall_status_date);

		$now = gmdate("Y-m-d H:i:s");
		
		if($phonecall_access == $phonecall_access_orig) {
			$accesssql = "";
		} else {
			$phonecall_access_date = "";
			if($phonecall_access == 1) {
				$phonecall_access_date = $now;
			}
			$accesssql = "access='$phonecall_access', access_date='$phonecall_access_date', access_user = '$session->uid',";
		}

		$q = "UPDATE " . CO_TBL_COMPLAINTS_PHONECALLS . " set title = '$title', item_date = '$phonecalldate', start = '$start', end = '$end', protocol = '$protocol', management='$management', management_ct='$management_ct', documents = '$documents', access='$phonecall_access', $accesssql status = '$phonecall_status', status_date = '$phonecall_status_date', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
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
		
		$q = "INSERT INTO " . CO_TBL_COMPLAINTS_PHONECALLS . " set title = '" . $lang["COMPLAINT_PHONECALL_NEW"] . "', item_date='$now', start='$time', end='$time', pid = '$id', status = '1', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
				
		if ($result) {
			return $id;
		}
   }
   

   	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		// phonecall
		$q = "INSERT INTO " . CO_TBL_COMPLAINTS_PHONECALLS . " (pid,title,item_date,start,end,protocol,management,management_ct,status,created_date,created_user,edited_date,edited_user) SELECT pid,CONCAT(title,' " . $lang["GLOBAL_DUPLICAT"] . "'),item_date,start,end,protocol,management,management_ct,status,'$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_COMPLAINTS_PHONECALLS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		if ($result) {
			return $id_new;
		}
	}


   function binPhonecall($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_COMPLAINTS_PHONECALLS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function restorePhonecall($id) {
		$q = "UPDATE " . CO_TBL_COMPLAINTS_PHONECALLS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deletePhonecall($id) {
		
		$q = "DELETE FROM co_log_sendto WHERE what='complaints_phonecalls' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_COMPLAINTS_PHONECALLS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function toggleIntern($id,$status) {
		global $session;
		$q = "UPDATE " . CO_TBL_COMPLAINTS_PHONECALLS . " set intern = '$status' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }

}
?>
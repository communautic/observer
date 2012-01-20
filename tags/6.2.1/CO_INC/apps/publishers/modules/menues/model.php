<?php

class PublishersMenuesModel extends PublishersModel {
	
	public function __construct() {  
     	parent::__construct();
		$this->_contactsmodel = new ContactsModel();
	}


	function getList($sort) {
		global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("publishers-menues-sort-status");
		  if(!$sortstatus) {
				$order = "order by item_date_from DESC";
				$sortcur = '1';
		  } else {
			  switch($sortstatus) {
				  case "1":
				  		$order = "order by item_date_from DESC";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by item_date_from ASC";
							$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("publishers-menues-sort-order");
				  		if(!$sortorder) {
								$order = "order by item_date_from DESC";
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
				  		$order = "order by item_date_from DESC";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by item_date_from ASC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("publishers-menues-sort-order");
				  		if(!$sortorder) {
						  	$order = "order by item_date_from DESC";
								$sortcur = '1';
						  } else {
								$order = "order by field(id,$sortorder)";
								$sortcur = '3';
						  }
				  break;	
			  }
		}
	  
	  
		$perm = $this->getPublisherAccess();
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		
		$q = "select id,title,item_date_from,item_date_to,access,status from " . CO_TBL_PUBLISHERS_MENUES . " where bin != '1' " . $sql . $order;

		$this->setSortStatus("publishers-menues-sort-status",$sortcur);
		$result = mysql_query($q, $this->_db->connection);
		$menues = "";
		while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			
			// dates
			$array["item_date_from"] = $this->_date->formatDate($array["item_date_from"],CO_DATE_FORMAT);
			$array["item_date_to"] = $this->_date->formatDate($array["item_date_to"],CO_DATE_FORMAT);
			
			// access
			$accessstatus = "";
			if($array["access"] == 1) {
				$accessstatus = " module-access-active";
			}
			$array["accessstatus"] = $accessstatus;
			// status
			$itemstatus = "";
			if($array["status"] == 2) {
				$itemstatus = " module-item-active";
			}
			$array["itemstatus"] = $itemstatus;
			
			$checked_out_status = "";
			/*if($perm !=  "guest" && $array["checked_out"] == 1 && $array["checked_out_user"] != $session->uid) {
				if($session->checkUserActive($array["checked_out_user"])) {
					$checked_out_status = "icon-checked-out-active";
				} else {
					$mid = $array["id"];
					$this->checkinMenueOverride($mid);
				}
			}*/
			$array["checked_out_status"] = $checked_out_status;
			
			$menues[] = new Lists($array);
	  }
		
	  $arr = array("menues" => $menues, "sort" => $sortcur, "perm" => $perm);
	  return $arr;
	}


	function checkoutMenue($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_PUBLISHERS_MENUES . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function checkinMenue($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_PUBLISHERS_MENUES . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_PUBLISHERS_MENUES . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}


	function checkinMenueOverride($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PUBLISHERS_MENUES . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	

	function getDetails($id) {
		global $session, $lang;
		
		$q = "SELECT * FROM " . CO_TBL_PUBLISHERS_MENUES . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
			
		$array["perms"] = $this->getPublisherAccess($array["id"]);
		$array["canedit"] = false;
		$array["showCheckout"] = false;

		if($array["perms"] == "sysadmin" || $array["perms"] == "admin") {

				$array["canedit"] = true;

		}
		
		// dates
		$array["item_date_from"] = $this->_date->formatDate($array["item_date_from"],CO_DATE_FORMAT);
		$array["item_date_to"] = $this->_date->formatDate($array["item_date_to"],CO_DATE_FORMAT);

		$array["management"] = $this->_contactsmodel->getUserList($array['management'],'publishersmanagement', "", $array["canedit"]);
		$array["management_ct"] = empty($array["management_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['management_ct'];
		
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
		
		$array["status_date"] = $this->_date->formatDate($array["status_date"],CO_DATE_FORMAT);
		
		switch($array["status"]) {
			case "0":
				$array["status_text"] = $lang["PUBLISHER_MENUE_STATUS_PLANNED"];
			break;
			case "1":
				$array["status_text"] = $lang["PUBLISHER_MENUE_STATUS_PUBLISHED"];
			break;
			case "2":
				$array["status_text"] = $lang["PUBLISHER_MENUE_STATUS_ARCHIVED"];
			break;
		}
		
		$sendto = $this->getSendtoDetails("publishers_menues",$id);

		$menue = new Lists($array);
		$arr = array("menue" => $menue, "sendto" => $sendto, "access" => $array["perms"]);
		return $arr;
   }


   function setDetails($id,$title,$date_from,$date_to,$protocol,$management,$management_ct,$menue_access,$menue_access_orig,$menue_status,$menue_status_date) {
		global $session, $lang;

		$date_from = $this->_date->formatDate($date_from);
		$date_to = $this->_date->formatDate($date_to);
		$management = $this->_contactsmodel->sortUserIDsByName($management);
		$menue_status_date = $this->_date->formatDateGMT($menue_status_date);

		$now = gmdate("Y-m-d H:i:s");
		
		if($menue_access == $menue_access_orig) {
			$accesssql = "";
		} else {
			$menue_access_date = "";
			if($menue_access == 1) {
				$menue_access_date = $now;
			}
			$accesssql = "access='$menue_access', access_date='$menue_access_date', access_user = '$session->uid',";
		}

		$q = "UPDATE " . CO_TBL_PUBLISHERS_MENUES . " set title = '$title', item_date_from = '$date_from', item_date_to = '$date_to', protocol = '$protocol', management='$management', management_ct='$management_ct', access='$menue_access', $accesssql status = '$menue_status', status_date = '$menue_status_date', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
		$arr = array("id" => $id, "what" => "edit");
		}

		return $arr;
   }


   function createNew() {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		$time = gmdate("Y-m-d H");
		
		$q = "INSERT INTO " . CO_TBL_PUBLISHERS_MENUES . " set title = '" . $lang["PUBLISHER_MENUE_NEW"] . "', item_date_from='$now', item_date_to='$time', status = '0', status_date='$now', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
				
		if ($result) {
			return $id;
		}
   }
   

   	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		// menue
		$q = "INSERT INTO " . CO_TBL_PUBLISHERS_MENUES . " (title,item_date_from,item_date_to,protocol,management,management_ct,status,status_date,mon_1,mon_2,mon_3,mon_4,mon_5,mon_6,tue_1,tue_2,tue_3,tue_4,tue_5,tue_6,wed_1,wed_2,wed_3,wed_4,wed_5,wed_6,thu_1,thu_2,thu_3,thu_4,thu_5,thu_6,fri_1,fri_2,fri_3,fri_4,fri_5,fri_6,created_date,created_user,edited_date,edited_user) SELECT CONCAT(title,' " . $lang["GLOBAL_DUPLICAT"] . "'),item_date_from,item_date_to,protocol,management,management_ct,'0','$now',mon_1,mon_2,mon_3,mon_4,mon_5,mon_6,tue_1,tue_2,tue_3,tue_4,tue_5,tue_6,wed_1,wed_2,wed_3,wed_4,wed_5,wed_6,thu_1,thu_2,thu_3,thu_4,thu_5,thu_6,fri_1,fri_2,fri_3,fri_4,fri_5,fri_6,'$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_PUBLISHERS_MENUES . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		if ($result) {
			return $id_new;
		}
	}


   function binMenue($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PUBLISHERS_MENUES . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function restoreMenue($id) {
		$q = "UPDATE " . CO_TBL_PUBLISHERS_MENUES . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deleteMenue($id) {
		
		$q = "DELETE FROM co_log_sendto WHERE what='publishers_menues' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_PUBLISHERS_MENUES . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
      function saveItem($id,$what,$text) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_PUBLISHERS_MENUES . " set $what = '$text', edited_user = '$session->uid', edited_date = '$now' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}

	}


   function toggleIntern($id,$status) {
		global $session;
		$q = "UPDATE " . CO_TBL_PUBLISHERS_MENUES . " set intern = '$status' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   
   function archiveOthers($id) {
	    $now = gmdate("Y-m-d");
		$q = "UPDATE " . CO_TBL_PUBLISHERS_MENUES . " set status='2', status_date='$now' WHERE status='1' and id!='$id' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	
	
	// dialog for selecting dependent tasks
	function getMenuesDialog($field) {
		global $lang;
	
		$str = '<div class="dialog-text">';
		$q = "SELECT id,title FROM " . CO_TBL_PUBLISHERS_MENUES . " where status!='0' and bin='0' order by item_date_from DESC ";
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$str .= '<a href="#" mod="clients_folder" class="insertItem" title="' . $row["title"] . '" field="' . $field . '" did="'.$row["id"].'" append="0">' . $row["title"] . '</a>';
		}
		$str .= '</div>';	
		return $str;
	}

}
?>
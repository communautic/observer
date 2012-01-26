<?php
//include_once(CO_PATH_BASE . "/model.php");
//include_once(dirname(__FILE__)."/model/folders.php");
//include_once(dirname(__FILE__)."/model/clients.php");

class ClientsModel extends Model {
	
	// Get all Client Folders
   function getFolderList($sort) {
      global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("clients-folder-sort-status");
		  if(!$sortstatus) {
		  	$order = "order by a.title";
			$sortcur = '1';
		  } else {
			  switch($sortstatus) {
				  case "1":
				  		$order = "order by a.title";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by a.title DESC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("clients-folder-sort-order");
				  		if(!$sortorder) {
						  	$order = "order by a.title";
							$sortcur = '1';
						  } else {
							$order = "order by field(a.id,$sortorder)";
							$sortcur = '3';
						  }
				  break;
			  }
		  }
	  } else {
		  switch($sort) {
				  case "1":
				  		$order = "order by a.title";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by a.title DESC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("clients-folder-sort-order");
				  		if(!$sortorder) {
						  	$order = "order by a.title";
							$sortcur = '1';
						  } else {
							$order = "order by field(a.id,$sortorder)";
							$sortcur = '3';
						  }
				  break;	
			  }
	  }
	  
		if(!$session->isSysadmin()) {
			$q ="select a.id, a.title from " . CO_TBL_CLIENTS_FOLDERS . " as a where a.status='0' and a.bin = '0' and (SELECT count(*) FROM co_clients_access as b, co_clients as c WHERE (b.admins REGEXP '[[:<:]]" . $session->uid . "[[:>:]]' or b.guests REGEXP '[[:<:]]" . $session->uid . "[[:>:]]') and c.folder=a.id and b.pid=c.id) > 0 " . $order;
		} else {
			$q ="select a.id, a.title from " . CO_TBL_CLIENTS_FOLDERS . " as a where a.status='0' and a.bin = '0' " . $order;
		}
		
	  $this->setSortStatus("clients-folder-sort-status",$sortcur);
      $result = mysql_query($q, $this->_db->connection);
	  $folders = "";
	  while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
				if($key == "id") {
				$array["numClients"] = $this->getNumClients($val);
				}
			}
			$folders[] = new Lists($array);
		  
	  }
	  
	  $perm = "guest";
	  if($session->isSysadmin()) {
		  $perm = "sysadmin";
	  }
	  
	  $arr = array("folders" => $folders, "sort" => $sortcur, "access" => $perm);
	  
	  return $arr;
   }


  /**
   * get details for the client folder
   */
   function getFolderDetails($id) {
		global $session, $contactsmodel, $clientsControllingModel, $lang;
		$q = "SELECT * FROM " . CO_TBL_CLIENTS_FOLDERS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_assoc($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		$array["allclients"] = $this->getNumClients($id);
		$array["plannedclients"] = $this->getNumClients($id, $status="0");
		$array["activeclients"] = $this->getNumClients($id, $status="1");
		$array["inactiveclients"] = $this->getNumClients($id, $status="2");
		$array["stoppedclients"] = $this->getNumClients($id, $status="3");
		
		/*$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);*/
		$array["today"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		
		
		$array["canedit"] = true;
		$array["access"] = "sysadmin";
 		if(!$session->isSysadmin()) {
			$array["canedit"] = false;
			$array["access"] = "guest";
		}
		
		$folder = new Lists($array);
		
		// get client details
		$access="";
		if(!$session->isSysadmin()) {
			$access = " and id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
	  	}
		
		 $sortstatus = $this->getSortStatus("clients-sort-status",$id);
		if(!$sortstatus) {
		  	$order = "order by title";
		  } else {
			  switch($sortstatus) {
				  case "1":
				  		$order = "order by title";
				  break;
				  case "2":
				  		$order = "order by title DESC";
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("clients-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by title";
						  } else {
							$order = "order by field(id,$sortorder)";
						  }
				  break;	
			  }
		  }
		
		
		$q = "SELECT title,id,management,status FROM " . CO_TBL_CLIENTS . " where folder='$id' and bin='0'" . $access . " " . $order;

		$result = mysql_query($q, $this->_db->connection);
	  	$clients = "";
	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$client[$key] = $val;
			}
			$client["management"] = $contactsmodel->getUserListPlain($client['management']);
			$client["perm"] = $this->getClientAccess($client["id"]);
			
			switch($client["status"]) {
				case "0":
					$client["status_text"] = $lang["CLIENT_STATUS_PLANNED_TEXT"];
				break;
				case "1":
					$client["status_text"] = $lang["CLIENT_STATUS_INPROGRESS_TEXT"];
				break;
				case "2":
					$client["status_text"] = $lang["CLIENT_STATUS_FINISHED_TEXT"];
				break;
				case "3":
					$client["status_text"] = $lang["CLIENT_STATUS_STOPPED_TEXT"];
				break;
			}
			
			$clients[] = new Lists($client);
	  	}
		
		$access = "guest";
		  if($session->isSysadmin()) {
			  $access = "sysadmin";
		  }
		
		$arr = array("folder" => $folder, "clients" => $clients, "access" => $access);
		return $arr;
   }


   /**
   * get details for the client folder
   */
   function setFolderDetails($id,$title,$clientstatus) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_CLIENTS_FOLDERS . " set title = '$title', status = '$clientstatus', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }


   /**
   * create new client folder
   */
	function newFolder() {
		global $session, $lang;
		$now = gmdate("Y-m-d H:i:s");
		$title = $lang["CLIENT_FOLDER_NEW"];
		
		$q = "INSERT INTO " . CO_TBL_CLIENTS_FOLDERS . " set title = '$title', status = '0', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	$id = mysql_insert_id();
			return $id;
		}
	}


   /**
   * delete client folder
   */
   function binFolder($id) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_CLIENTS_FOLDERS . " set bin = '1', bintime = '$now', binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   
   function restoreFolder($id) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_CLIENTS_FOLDERS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deleteFolder($id) {
		$q = "SELECT id FROM " . CO_TBL_CLIENTS . " where folder = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$pid = $row["id"];
			$this->deleteClient($pid);
		}
		
		$q = "DELETE FROM " . CO_TBL_CLIENTS_FOLDERS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


  /**
   * get number of clients for a client folder
   * status: 0 = all, 1 = active, 2 = abgeschlossen
   */   
   function getNumClients($id, $status="") {
		global $session;
		
		$access = "";
		 if(!$session->isSysadmin()) {
			$access = " and id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
		  }
		
		if($status == "") {
			$q = "select id from " . CO_TBL_CLIENTS . " where folder='$id' " . $access . " and bin != '1'";
		} else {
			$q = "select id from " . CO_TBL_CLIENTS . " where folder='$id' " . $access . " and status = '$status' and bin != '1'";
		}
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_num_rows($result);
		return $row;
	}


	function getClientTitle($id){
		global $session;
		$q = "SELECT title FROM " . CO_TBL_CLIENTS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		return $title;
   }


   	function getClientTitleFromIDs($array){
		//$string = explode(",", $string);
		$total = sizeof($array);
		$data = '';
		
		if($total == 0) { 
			return $data; 
		}
		
		// check if client is available and build array
		$arr = array();
		foreach ($array as &$value) {
			$q = "SELECT id,title FROM " . CO_TBL_CLIENTS . " where id = '$value' and bin='0'";
			//$q = "SELECT id, firstname, lastname FROM ".CO_TBL_USERS." where id = '$value' and bin='0'";
			$result = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result) > 0) {
				while($row = mysql_fetch_assoc($result)) {
					$arr[$row["id"]] = $row["title"];		
				}
			}
		}
		$arr_total = sizeof($arr);
		
		// build string
		$i = 1;
		foreach ($arr as $key => &$value) {
			$data .= $value;
			if($i < $arr_total) {
				$data .= ', ';
			}
			$data .= '';	
			$i++;
		}
		return $data;
   }


   	function getClientField($id,$field){
		global $session;
		$q = "SELECT $field FROM " . CO_TBL_CLIENTS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		return $title;
   }


  /**
   * get the list of clients for a client folder
   */ 
   function getClientList($id,$sort) {
      global $session;
	  
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("clients-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("clients-sort-order",$id);
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
				  		$sortorder = $this->getSortOrder("clients-sort-order",$id);
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
	  
	  $access = "";
	  if(!$session->isSysadmin()) {
		$access = " and id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
	  }
	  $q ="select id,title,status,checked_out,checked_out_user from " . CO_TBL_CLIENTS . " where folder='$id' and bin = '0' " . $access . $order;

	  $this->setSortStatus("clients-sort-status",$sortcur,$id);
      $result = mysql_query($q, $this->_db->connection);
	  $clients = "";
	  while ($row = mysql_fetch_array($result)) {
		foreach($row as $key => $val) {
			$array[$key] = $val;
			if($key == "id") {
				if($this->getClientAccess($val) == "guest") {
					$array["access"] = "guest";
					$array["iconguest"] = ' icon-guest-active"';
					$array["checked_out_status"] = "";
				} else {
					$array["iconguest"] = '';
					$array["access"] = "";
				}
			}
			
		}
		
		// status
		$itemstatus = "";
		if($array["status"] == 2) {
			$itemstatus = " module-item-active";
		}
		if($array["status"] == 3) {
			$itemstatus = " module-item-active-stopped";
		}
		$array["itemstatus"] = $itemstatus;
		
		$checked_out_status = "";
		if($array["access"] != "guest" && $array["checked_out"] == 1 && $array["checked_out_user"] != $session->uid) {
			if($session->checkUserActive($array["checked_out_user"])) {
				$checked_out_status = "icon-checked-out-active";
			} else {
				$this->checkinClientOverride($id);
			}
		}
		$array["checked_out_status"] = $checked_out_status;
		
		$clients[] = new Lists($array);
	  }
	  $arr = array("clients" => $clients, "sort" => $sortcur);
	  return $arr;
   }
	
	
	function checkoutClient($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_CLIENTS . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function checkinClient($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_CLIENTS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_CLIENTS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}
	
	function checkinClientOverride($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_CLIENTS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	

   function getClientDetails($id) {
		global $session, $contactsmodel, $lang;
		$q = "SELECT * FROM " . CO_TBL_CLIENTS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		// perms
		$array["access"] = $this->getClientAccess($id);
		//$canEdit = $this->getEditPerms($session->uid);
	  	/*if(!empty($canEdit)) {
				$array["access"] = "admin";
		}*/
		/*if($array["access"] == "admin") {
			// check if owner
			if($this->isOwnerPerms($id,$session->uid)) {
				$array["access"] = "owner";
			}
		}*/
		if($array["access"] == "guest") {
			// check if this user is admin in some other client
			$canEdit = $this->getEditPerms($session->uid);
			if(!empty($canEdit)) {
					$array["access"] = "guestadmin";
			}
		}
		$array["canedit"] = false;
		$array["showCheckout"] = false;
		$array["checked_out_user_text"] = $contactsmodel->getUserListPlain($array['checked_out_user']);

		if($array["access"] == "sysadmin" || $array["access"] == "admin") {
			//if($array["checked_out"] == 1 && $session->checkUserActive($array["checked_out_user"])) {
			if($array["checked_out"] == 1) {
				if($array["checked_out_user"] == $session->uid) {
					$array["canedit"] = true;
				} else if(!$session->checkUserActive($array["checked_out_user"])) {
					$array["canedit"] = $this->checkoutClient($id);
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
					$array["checked_out_user_phone1"] = $contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
					$array["checked_out_user_email"] = $contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");
				}
			} else {
				$array["canedit"] = $this->checkoutClient($id);
			}
		} // EOF perms
		
		// dates
		$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
		
		// other functions
		$array["folder"] = $this->getClientFolderDetails($array["folder"],"folder");
		$array["management_print"] = $contactsmodel->getUserListPlain($array['management']);
		$array["management"] = $contactsmodel->getUserList($array['management'],'clientsmanagement', "", $array["canedit"]);
		$array["management_ct"] = empty($array["management_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['management_ct'];
		
		$array["address"] = $contactsmodel->getPlaceList($array['address'],'clientsaddress', $array["canedit"]);
		$array["address_ct"] = empty($array["address_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['address_ct'];
		$array["billingaddress"] = $contactsmodel->getPlaceList($array['billingaddress'],'clientsbillingaddress', $array["canedit"]);
		$array["billingaddress_ct"] = empty($array["billingaddress_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['billingaddress_ct'];
		
		// loop through team and build order access_array 
		$users = explode(",", $array["team"]);
		$user = "";
		$orders_access = "";
		if($array["team"] != "") {
			foreach ($users as &$userid) {
				$q = "SELECT * FROM " . CO_TBL_CLIENTS_ORDERS_ACCESS . " where uid = '$userid' and cid='$id'";
				$result = mysql_query($q, $this->_db->connection);
				if(mysql_num_rows($result) < 1) {
					$user["id"] = $userid;
					$user["access_text"] = '';
					$user["access_name"] = $this->_users->getUserFullname($userid);
					$user["access_company"] = $contactsmodel->getContactFieldFromID($user["id"],'company');
					$user["access_phone"] = $contactsmodel->getContactFieldFromID($user["id"],'phone1');
					$user["access_email"] = $contactsmodel->getContactFieldFromID($user["id"],'email');
					$user["access_address"] = $contactsmodel->getContactFieldFromID($user["id"],'address_line1');
					$user["access_status"] = 1;
				} else {
				$row = mysql_fetch_array($result);
				foreach($row as $key => $val) {
					
						$user[$key] = $val;
					}
					$user["id"] = $userid;
					$user["access_date"] = $this->_date->formatDate($user["access_date"],CO_DATE_FORMAT);
					$user["access_user"] = $this->_users->getUserFullname($user["access_user"]);
					$user["access_text"] = sprintf($lang['CLIENTS_ACCESS_ACTIVE'], $user["access_date"], $user["access_user"]);
					$user["access_name"] = $this->_users->getUserFullname($user["uid"]);
					$user["access_company"] = $contactsmodel->getContactFieldFromID($user["uid"],'company');
					$user["access_phone"] = $contactsmodel->getContactFieldFromID($user["uid"],'phone1');
					$user["access_email"] = $contactsmodel->getContactFieldFromID($user["uid"],'email');
					$user["access_address"] = $contactsmodel->getContactFieldFromID($user["uid"],'address_line1');
					$user["access_status"] = 0;
				}
				$orders_access[] = new Lists($user); 
			}
		}
		$array["team_print"] = $contactsmodel->getUserListPlain($array['team']);
		$array["team"] = $contactsmodel->getUserList($array['team'],'clientsteam', "", $array["canedit"]);
		$array["team_ct"] = empty($array["team_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['team_ct'];
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		$array["current_user"] = $session->uid;
		
		
		switch($array["contract"]) {
			case "0":
				$array["contract_text"] = "";
			break;
			case "1":
				$array["contract_text"] = $lang["CLIENT_CONTRACT_ONE"];
			break;
			case "2":
				$array["contract_text"] = $lang["CLIENT_CONTRACT_TWO"];
			break;
			case "3":
				$array["contract_text"] = $lang["CLIENT_CONTRACT_THREE"];
			break;
			case "4":
				$array["contract_text"] = $lang["CLIENT_CONTRACT_FOUR"];
			break;
			case "5":
				$array["contract_text"] = $lang["CLIENT_CONTRACT_FIVE"];
			break;
			case "6":
				$array["contract_text"] = $lang["CLIENT_CONTRACT_SIX"];
			break;
			case "7":
				$array["contract_text"] = $lang["CLIENT_CONTRACT_SEVEN"];
			break;
			case "8":
				$array["contract_text"] = $lang["CLIENT_CONTRACT_EIGHT"];
			break;
		}
		
		/*switch($array["status"]) {
			case "0":
				$array["status_text"] = $lang["CLIENT_STATUS_PLANNED"];
				$array["status_date"] = $this->_date->formatDate($array["planned_date"],CO_DATE_FORMAT);
			break;
			case "1":
				$array["status_text"] = $lang["CLIENT_STATUS_INPROGRESS"];
				$array["status_date"] = $this->_date->formatDate($array["inprogress_date"],CO_DATE_FORMAT);
			break;
			case "2":
				$array["status_text"] = $lang["CLIENT_STATUS_FINISHED"];
				$array["status_date"] = $this->_date->formatDate($array["finished_date"],CO_DATE_FORMAT);
			break;
			case "3":
				$array["status_text"] = $lang["CLIENT_STATUS_STOPPED"];
				$array["status_date"] = $this->_date->formatDate($array["stopped_date"],CO_DATE_FORMAT);
			break;
		}*/
		
		
		
		$client = new Lists($array);
		
		$sql="";
		if($array["access"] == "guest") {
			$sql = " and a.access = '1' ";
		}
				
		$sendto = $this->getSendtoDetails("clients",$id);
		
		$arr = array("client" => $client, "orders_access" => $orders_access, "sendto" => $sendto, "access" => $array["access"]);
		return $arr;
   }


   // Create client folder title
	function getClientFolderDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			$q = "SELECT id, title from " . CO_TBL_CLIENTS_FOLDERS . " where id = '$value'";
			$result_user = mysql_query($q, $this->_db->connection);
			while($row_user = mysql_fetch_assoc($result_user)) {
				$users .= '<span class="listmember" uid="' . $row_user["id"] . '">' . $row_user["title"] . '</span>';
				if($i < $users_total) {
					$users .= ', ';
				}
			}
			$i++;
		}
		return $users;
   }


   /**
   * get details for the client folder
   */
   function setClientDetails($id,$title,$management,$management_ct,$team,$team_ct,$address,$address_ct,$billingaddress,$billingaddress_ct,$protocol,$folder,$contract) {
		global $session, $contactsmodel;
		
		// user lists
		$management = $contactsmodel->sortUserIDsByName($management);
		$team = $contactsmodel->sortUserIDsByName($team);
		
		/*switch($status) {
			case "0":
				$sql = "planned_date";
			break;
			case "1":
				$sql = "inprogress_date";
			break;
			case "2":
				$sql = "finished_date";
				$this->setAllPhasesFinished($id,$status_date);
			break;
			case "3":
				$sql = "stopped_date";
			break;
		}*/

		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_CLIENTS . " set title = '$title', folder = '$folder', management = '$management', management_ct = '$management_ct', team='$team', team_ct = '$team_ct', address='$address', address_ct = '$address_ct', billingaddress = '$billingaddress', billingaddress_ct = '$billingaddress_ct', protocol = '$protocol', contract = '$contract', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}


	function newClient($id) {
		global $session, $contactsmodel, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		$title = $lang["CLIENT_NEW"];
		
		$q = "INSERT INTO " . CO_TBL_CLIENTS . " set folder = '$id', title = '$title', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			$id = mysql_insert_id();
			// if admin insert him to access
			if(!$session->isSysadmin()) {
				$clientsAccessModel = new ClientsAccessModel();
				$clientsAccessModel->setDetails($id,$session->uid,"");
			}
			return $id;
		}
	}
	
	
	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		// client
		$q = "INSERT INTO " . CO_TBL_CLIENTS . " (folder,title,management,team,address,billingaddress,protocol,contract,created_date,created_user,edited_date,edited_user) SELECT folder,CONCAT(title,' ".$lang["GLOBAL_DUPLICAT"]."'),management,team,address,billingaddress,protocol,contract,'$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_CLIENTS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		
		if(!$session->isSysadmin()) {
				$clientsAccessModel = new ClientsAccessModel();
				$clientsAccessModel->setDetails($id_new,$session->uid,"");
			}
		if ($result) {
			return $id_new;
		}
	}


	function binClient($id) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_CLIENTS . " set bin = '1', bintime = '$now', binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	function restoreClient($id) {
		$q = "UPDATE " . CO_TBL_CLIENTS . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	function deleteClient($id) {
		global $clients;
		
		$active_modules = array();
		foreach($clients->modules as $module => $value) {
			if(CONSTANT('clients_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
			}
		}
		
		if(in_array("vdocs",$active_modules)) {
			$vdocsmodel = new VDocsModel();
			$q = "SELECT id FROM co_clients_vdocs where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$vid = $row["id"];
				$vdocsmodel->deleteVDoc($vid);
			}
		}
		
		if(in_array("phonecalls",$active_modules)) {
			$clientsPhonecallsModel = new ClientsPhonecallsModel();
			$q = "SELECT id FROM co_clients_phonecalls where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$pcid = $row["id"];
				$clientsPhonecallsModel->deletePhonecall($pcid);
			}
		}
		
		if(in_array("documents",$active_modules)) {
			$clientsDocumentsModel = new ClientsDocumentsModel();
			$q = "SELECT id FROM co_clients_documents_folders where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$did = $row["id"];
				$clientsDocumentsModel->deleteDocument($did);
			}
		}
		
		if(in_array("meetings",$active_modules)) {
			$clientsMeetingsModel = new ClientsMeetingsModel();
			$q = "SELECT id FROM co_clients_meetings where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$mid = $row["id"];
				$clientsMeetingsModel->deleteMeeting($mid);
			}
		}
		
		if(in_array("phases",$active_modules)) {
			$clientsPhasesModel = new ClientsPhasesModel();
			$q = "SELECT id FROM co_clients_phases where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$pid = $row["id"];
				$clientsPhasesModel->deletePhase($pid);
			}
		}
		
		$q = "DELETE FROM co_log_sendto WHERE what='clients' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM co_clients_access WHERE pid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_CLIENTS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
		  	return true;
		}
		
	}


   function moveClient($id,$startdate,$movedays) {
		global $session, $contactsmodel;
		
		$startdate = $this->_date->formatDate($_POST['startdate']);
		
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_CLIENTS . " set startdate = '$startdate', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
			$qt = "SELECT id, startdate, enddate FROM " . CO_TBL_CLIENTS_PHASES_TASKS . " where pid='$id'";
			$resultt = mysql_query($qt, $this->_db->connection);
			while ($rowt = mysql_fetch_array($resultt)) {
				$tid = $rowt["id"];
				$startdate = $this->_date->addDays($rowt["startdate"],$movedays);
				$enddate = $this->_date->addDays($rowt["enddate"],$movedays);
				$qtk = "UPDATE " . CO_TBL_CLIENTS_PHASES_TASKS . " set startdate = '$startdate', enddate = '$enddate' where id='$tid'";
				$retvaltk = mysql_query($qtk, $this->_db->connection);
			}
		if ($result) {
			return true;
		}
	}


	function getClientFolderDialog($field,$title) {
		global $session;
		$str = '<div class="dialog-text">';
		//$q ="select id, title from " . CO_TBL_CLIENTS_FOLDERS . " where status='0' and bin = '0' ORDER BY title";
		if(!$session->isSysadmin()) {
			$q ="select a.id, a.title from " . CO_TBL_CLIENTS_FOLDERS . " as a where a.status='0' and a.bin = '0' and (SELECT count(*) FROM co_clients_access as b, co_clients as c WHERE (b.admins REGEXP '[[:<:]]" . $session->uid . "[[:>:]]' or b.guests REGEXP '[[:<:]]" . $session->uid . "[[:>:]]') and c.folder=a.id and b.pid=c.id) > 0 ORDER BY title";
		} else {
			$q ="select id, title from " . CO_TBL_CLIENTS_FOLDERS . " where status='0' and bin = '0' ORDER BY title";
		}
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$str .= '<a href="#" class="insertClientFolderfromDialog" title="' . $row["title"] . '" field="'.$field.'" gid="'.$row["id"].'">' . $row["title"] . '</a>';
		}
		$str .= '</div>';	
		return $str;
	 }



	// STATISTIKEN
   
   
	function numPhases($id,$status = 0, $sql="") {
	   //$sql = "";
	   if ($status == 2) {
		   $sql .= "and status='2'";
	   }
	   $q = "SELECT COUNT(id) FROM " .  CO_TBL_CLIENTS_PHASES. " WHERE pid='$id' $sql and bin='0'";
	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function numPhasesOnTime($id) {
	   //$q = "SELECT COUNT(id) FROM " .  CO_TBL_CLIENTS_PHASES. " WHERE pid='$id' $sql and bin='0'";
	   $q = "SELECT a.id,(SELECT MAX(enddate) FROM " . CO_TBL_CLIENTS_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as enddate FROM " . CO_TBL_CLIENTS_PHASES . " as a where a.pid= '$id' and a.status='2' and a.finished_date <= enddate";

	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function numPhasesTasks($id,$status = 0,$sql="") {
	   //$sql = "";
	   if ($status == 1) {
		   $sql .= " and status='1' ";
	   }
	   $q = "SELECT COUNT(id) FROM " .  CO_TBL_CLIENTS_PHASES_TASKS. " WHERE pid='$id' $sql and bin='0'";
	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function getRest($value) {
		return round(100-$value,2);
   }


	function getChartFolder($id, $what) { 
		global $clientsControllingModel, $lang;
		switch($what) {
			case 'stability':
				$chart = $this->getChartFolder($id, 'timeing');
				$timeing = $chart["real"];
				
				$chart = $this->getChartFolder($id, 'tasks');
				$tasks = $chart["real"];
				
				$chart["real"] = round(($timeing+$tasks)/2,0);
				$chart["title"] = $lang["CLIENT_FOLDER_CHART_STABILITY"];
				$chart["img_name"] = $id . "_stability.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?chs=150x90&cht=gm&chd=t:' . $chart["real"];
				
				$chart["tendency"] = "tendency_negative.png";
				if($chart["real"] >= 50) {
					$chart["tendency"] = "tendency_positive.png";
				}
				
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				
			break;
			case 'realisation':
				$realisation = 0;
				$id_array = "";
				
				$q = "SELECT id FROM " . CO_TBL_CLIENTS. " WHERE folder = '$id' and status != '0' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$num = mysql_num_rows($result);
				$i = 1;
				while($row = mysql_fetch_assoc($result)) {
					$pid = $row["id"];
					$calc = $clientsControllingModel->getChart($pid,'realisation',0);
					$realisation += $calc["real"];

					if($i == 1) {
						$id_array .= " and (pid='".$pid."'";
					} else {
						$id_array .= " or pid='".$pid."'";
					}
					if($i == $num) {
						$id_array .= ")";
					}
					//$id_array .= " and pid='".$pid."'";
					$i++;
				}
				if($num == 0) {
					$chart["real"] = 0;
				} else {
					$chart["real"] = round(($realisation)/$num,0);
				}
				$chart["tendency"] = "tendency_negative.png";
				$qt = "SELECT MAX(donedate) as dt,enddate FROM " . CO_TBL_CLIENTS_PHASES_TASKS. " WHERE status='1' $id_array and bin='0'";
				$resultt = mysql_query($qt, $this->_db->connection);
				$ten = mysql_fetch_assoc($resultt);
				if($ten["dt"] <= $ten["enddate"]) {
					$chart["tendency"] = "tendency_positive.png";
				}
				
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = $lang["CLIENT_FOLDER_CHART_REALISATION"];
				$chart["img_name"] = $id . "_realisation.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
				
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
			break;
			

			case 'timeing':
				$realisation = 0;
				$id_array = "";
				
				$q = "SELECT id FROM " . CO_TBL_CLIENTS. " WHERE folder = '$id' and status != '0' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$num = mysql_num_rows($result);
				$i = 1;
				while($row = mysql_fetch_assoc($result)) {
					$pid = $row["id"];
					$calc = $clientsControllingModel->getChart($pid,'timeing',0);
					$realisation += $calc["real"];

					if($i == 1) {
						$id_array .= " and (pid='".$pid."'";
					} else {
						$id_array .= " or pid='".$pid."'";
					}
					if($i == $num) {
						$id_array .= ")";
					}
					//$id_array .= " and pid='".$pid."'";
					$i++;
				}
					
				if($num == 0) {
					$chart["real"] = 0;
				} else {
					$chart["real"] = round(($realisation)/$num,0);
				}
				
				$today = date("Y-m-d");
				
				$chart["tendency"] = "tendency_positive.png";
				$qt = "SELECT COUNT(id) FROM " . CO_TBL_CLIENTS_PHASES_TASKS. " WHERE status='0' and startdate <= '$today' and enddate >= '$today' $id_array and bin='0'";
				$resultt = mysql_query($qt, $this->_db->connection);
				$tasks_active = mysql_result($resultt,0);
				
				$qo = "SELECT COUNT(id) FROM " . CO_TBL_CLIENTS_PHASES_TASKS. " WHERE status='0' and enddate < '$today' $id_array and bin='0'";
				$resulto = mysql_query($qo, $this->_db->connection);
				$tasks_overdue = mysql_result($resulto,0);
				if($tasks_active + $tasks_overdue == 0) {
					$tendency = 0;
				} else {
					$tendency = round((100/($tasks_active + $tasks_overdue)) * $tasks_overdue,2);
				}
				
				if($tendency > 10) {
					$chart["tendency"] = "tendency_negative.png";
				}
				
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = $lang["CLIENT_FOLDER_CHART_ADHERANCE"];
				$chart["img_name"] = $id . "_timeing.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
			
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
			break;
			
			case 'tasks':
				$realisation = 0;
				$id_array = "";
				
				$q = "SELECT id FROM " . CO_TBL_CLIENTS. " WHERE folder = '$id' and status != '0' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$num = mysql_num_rows($result);
				$i = 1;
				while($row = mysql_fetch_assoc($result)) {
					$pid = $row["id"];
					$calc = $clientsControllingModel->getChart($pid,'tasks',0);
					$realisation += $calc["real"];

					if($i == 1) {
						$id_array .= " and (pid='".$pid."'";
					} else {
						$id_array .= " or pid='".$pid."'";
					}
					if($i == $num) {
						$id_array .= ")";
					}
					$i++;
				}
				if($num == 0) {
					$chart["real"] = 0;
				} else {
					$chart["real"] = round(($realisation)/$num,0);
				}
				
				$today = date("Y-m-d");
				
				$chart["tendency"] = "tendency_positive.png";
				$qt = "SELECT status,donedate,enddate FROM " . CO_TBL_CLIENTS_PHASES_TASKS. " WHERE enddate < '$today' $id_array and bin='0' ORDER BY enddate DESC LIMIT 0,1";
				$resultt = mysql_query($qt, $this->_db->connection);
				$rowt = mysql_fetch_assoc($resultt);
				if(mysql_num_rows($resultt) != 0) {
					$status = $rowt["status"];
					$enddate = $rowt["enddate"];
					$donedate = $rowt["donedate"];
					if($status == "1" && $donedate > $enddate) {
						$chart["tendency"] = "tendency_negative.png";
					}
					if($status == "0") {
						$chart["tendency"] = "tendency_negative.png";
					}
				}
				
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = $lang["CLIENT_FOLDER_CHART_TASKS"];
				$chart["img_name"] = $id . "_tasks.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
			
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				
			break;
			case 'status':

				// all
				$q = "SELECT id FROM " . CO_TBL_CLIENTS. " WHERE folder = '$id' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$all = mysql_num_rows($result);
				
				// planned
				$q = "SELECT id FROM " . CO_TBL_CLIENTS. " WHERE folder = '$id' and status = '0' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$planned = mysql_num_rows($result);
				$chart["planned"] = 0;
				if($planned != 0) {
					$chart["planned"] = round((100/$all)*$planned,0);
				}
				
				// inprogress
				$q = "SELECT id FROM " . CO_TBL_CLIENTS. " WHERE folder = '$id' and status = '1' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$inprogress = mysql_num_rows($result);
				$chart["inprogress"] = 0;
				if($inprogress != 0) {
					$chart["inprogress"] = round((100/$all)*$inprogress,0);
				}
				// finished
				$q = "SELECT id FROM " . CO_TBL_CLIENTS. " WHERE folder = '$id' and status = '2' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$finished = mysql_num_rows($result);
				$chart["finished"] = 0;
				if($finished != 0) {
					$chart["finished"] = round((100/$all)*$finished,0);
				}
				
				// stopped
				$q = "SELECT id FROM " . CO_TBL_CLIENTS. " WHERE folder = '$id' and status = '3' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$stopped = mysql_num_rows($result);
				$chart["stopped"] = 0;
				if($stopped != 0) {
					$chart["stopped"] = round((100/$all)*$stopped,0);
				}				

				$chart["title"] = $lang["CLIENT_FOLDER_CHART_STATUS"];
				$chart["img_name"] = 'clients_' . $id . "_status.png";
				if($all == 0) {
					$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:0,100&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
				} else {
					$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["planned"]. ',' .$chart["inprogress"] . ',' .$chart["finished"] . ',' .$chart["stopped"] . '&chs=150x90&chco=4BA0C8|FFD20A|82AA0B|7F7F7F&chf=bg,s,FFFFFF';
				}
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
			break;
		}
		
		return $chart;
   }


   function getBin() {
		global $clients;
		
		$bin = array();
		$bin["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		$arr = array();
		$arr["bin"] = $bin;
		
		$arr["folders"] = "";
		$arr["pros"] = "";
		$arr["files"] = "";
		$arr["tasks"] = "";
		
		$active_modules = array();
		foreach($clients->modules as $module => $value) {
			if(CONSTANT('clients_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
			}
		}
		
		//foreach($active_modules as $module) {
							//$name = strtoupper($module);
							//$mod = new $name . "Model()";
							//include("modules/meetings/controller.php");
							//${$name} = new $name("$module");
							
						//}
		
		$q ="select id, title, bin, bintime, binuser from " . CO_TBL_CLIENTS_FOLDERS;
		$result = mysql_query($q, $this->_db->connection);
	  	while ($row = mysql_fetch_array($result)) {
			$id = $row["id"];
			if($row["bin"] == "1") { // deleted folders
				foreach($row as $key => $val) {
					$folder[$key] = $val;
				}
				$folder["bintime"] = $this->_date->formatDate($folder["bintime"],CO_DATETIME_FORMAT);
				$folder["binuser"] = $this->_users->getUserFullname($folder["binuser"]);
				$folders[] = new Lists($folder);
				$arr["folders"] = $folders;
			} else { // folder not binned
				
				$qp ="select id, title, bin, bintime, binuser from " . CO_TBL_CLIENTS . " where folder = '$id'";
				$resultp = mysql_query($qp, $this->_db->connection);
				while ($rowp = mysql_fetch_array($resultp)) {
					$pid = $rowp["id"];
					if($rowp["bin"] == "1") { // deleted clients
					foreach($rowp as $key => $val) {
						$pro[$key] = $val;
					}
					$pro["bintime"] = $this->_date->formatDate($pro["bintime"],CO_DATETIME_FORMAT);
					$pro["binuser"] = $this->_users->getUserFullname($pro["binuser"]);
					$pros[] = new Lists($pro);
					$arr["pros"] = $pros;
					} else {

						
						
						// orders
						if(in_array("orders",$active_modules)) {
							$qph ="select id, title, bin, bintime, binuser from " . CO_TBL_CLIENTS_ORDERS . " where pid = '$pid' and bin='1'";
							$resultph = mysql_query($qph, $this->_db->connection);
							while ($rowph = mysql_fetch_array($resultph)) {
								foreach($rowph as $key => $val) {
									$order[$key] = $val;
								}
								$order["bintime"] = $this->_date->formatDate($order["bintime"],CO_DATETIME_FORMAT);
								$order["binuser"] = $this->_users->getUserFullname($order["binuser"]);
								$orders[] = new Lists($order);
								$arr["orders"] = $orders;
							}
						}
	
	
						// meetings
						if(in_array("meetings",$active_modules)) {
							$qm ="select id, title, bin, bintime, binuser from " . CO_TBL_CLIENTS_MEETINGS . " where pid = '$pid'";
							$resultm = mysql_query($qm, $this->_db->connection);
							while ($rowm = mysql_fetch_array($resultm)) {
								$mid = $rowm["id"];
								if($rowm["bin"] == "1") { // deleted meeting
									foreach($rowm as $key => $val) {
										$meeting[$key] = $val;
									}
									$meeting["bintime"] = $this->_date->formatDate($meeting["bintime"],CO_DATETIME_FORMAT);
									$meeting["binuser"] = $this->_users->getUserFullname($meeting["binuser"]);
									$meetings[] = new Lists($meeting);
									$arr["meetings"] = $meetings;
								} else {
									// meetings_tasks
									$qmt ="select id, title, bin, bintime, binuser from " . CO_TBL_CLIENTS_MEETINGS_TASKS . " where mid = '$mid'";
									$resultmt = mysql_query($qmt, $this->_db->connection);
									while ($rowmt = mysql_fetch_array($resultmt)) {
										if($rowmt["bin"] == "1") { // deleted phases
											foreach($rowmt as $key => $val) {
												$meetings_task[$key] = $val;
											}
											$meetings_task["bintime"] = $this->_date->formatDate($meetings_task["bintime"],CO_DATETIME_FORMAT);
											$meetings_task["binuser"] = $this->_users->getUserFullname($meetings_task["binuser"]);
											$meetings_tasks[] = new Lists($meetings_task);
											$arr["meetings_tasks"] = $meetings_tasks;
										}
									}
								}
							}
						}
						

						// phonecalls
						if(in_array("phonecalls",$active_modules)) {
							$qpc ="select id, title, bin, bintime, binuser from " . CO_TBL_CLIENTS_PHONECALLS . " where pid = '$pid'";
							$resultpc = mysql_query($qpc, $this->_db->connection);
							while ($rowpc = mysql_fetch_array($resultpc)) {
								if($rowpc["bin"] == "1") {
								$idp = $rowpc["id"];
									foreach($rowpc as $key => $val) {
										$phonecall[$key] = $val;
									}
									$phonecall["bintime"] = $this->_date->formatDate($phonecall["bintime"],CO_DATETIME_FORMAT);
									$phonecall["binuser"] = $this->_users->getUserFullname($phonecall["binuser"]);
									$phonecalls[] = new Lists($phonecall);
									$arr["phonecalls"] = $phonecalls;
								}
							}
						}
						
						// documents_folder
						if(in_array("documents",$active_modules)) {
							$qd ="select id, title, bin, bintime, binuser from " . CO_TBL_CLIENTS_DOCUMENTS_FOLDERS . " where pid = '$pid'";
							$resultd = mysql_query($qd, $this->_db->connection);
							while ($rowd = mysql_fetch_array($resultd)) {
								$did = $rowd["id"];
								if($rowd["bin"] == "1") { // deleted meeting
									foreach($rowd as $key => $val) {
										$documents_folder[$key] = $val;
									}
									$documents_folder["bintime"] = $this->_date->formatDate($documents_folder["bintime"],CO_DATETIME_FORMAT);
									$documents_folder["binuser"] = $this->_users->getUserFullname($documents_folder["binuser"]);
									$documents_folders[] = new Lists($documents_folder);
									$arr["documents_folders"] = $documents_folders;
								} else {
									// files
									$qf ="select id, filename, bin, bintime, binuser from " . CO_TBL_CLIENTS_DOCUMENTS . " where did = '$did'";
									$resultf = mysql_query($qf, $this->_db->connection);
									while ($rowf = mysql_fetch_array($resultf)) {
										if($rowf["bin"] == "1") { // deleted phases
											foreach($rowf as $key => $val) {
												$file[$key] = $val;
											}
											$file["bintime"] = $this->_date->formatDate($file["bintime"],CO_DATETIME_FORMAT);
											$file["binuser"] = $this->_users->getUserFullname($file["binuser"]);
											$files[] = new Lists($file);
											$arr["files"] = $files;
										}
									}
								}
							}
						}
	
	
						// vdocs
						if(in_array("vdocs",$active_modules)) {
							$qv ="select id, title, bin, bintime, binuser from " . CO_TBL_CLIENTS_VDOCS . " where pid = '$pid' and bin='1'";
							$resultv = mysql_query($qv, $this->_db->connection);
							while ($rowv = mysql_fetch_array($resultv)) {
								$vid = $rowv["id"];
									foreach($rowv as $key => $val) {
										$vdoc[$key] = $val;
									}
									$vdoc["bintime"] = $this->_date->formatDate($vdoc["bintime"],CO_DATETIME_FORMAT);
									$vdoc["binuser"] = $this->_users->getUserFullname($vdoc["binuser"]);
									$vdocs[] = new Lists($vdoc);
									$arr["vdocs"] = $vdocs;
							}
						}
					}
				}
			}
	  	}
		
		//print_r($arr);
		//$mod = new Lists($mods);

		return $arr;
   }
   
   
   function emptyBin() {
		global $clients;
		
		$bin = array();
		$bin["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		$arr = array();
		$arr["bin"] = $bin;
		
		$arr["folders"] = "";
		$arr["pros"] = "";
		$arr["files"] = "";
		$arr["tasks"] = "";
		
		$active_modules = array();
		foreach($clients->modules as $module => $value) {
			if(CONSTANT('clients_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
			}
		}
		
		$q ="select id, title, bin, bintime, binuser from " . CO_TBL_CLIENTS_FOLDERS;
		$result = mysql_query($q, $this->_db->connection);
	  	while ($row = mysql_fetch_array($result)) {
			$id = $row["id"];
			if($row["bin"] == "1") { // deleted folders
				$this->deleteFolder($id);
			} else { // folder not binned
				
				$qp ="select id, title, bin, bintime, binuser from " . CO_TBL_CLIENTS . " where folder = '$id'";
				$resultp = mysql_query($qp, $this->_db->connection);
				while ($rowp = mysql_fetch_array($resultp)) {
					$pid = $rowp["id"];
					if($rowp["bin"] == "1") { // deleted clients
						$this->deleteClient($pid);
					} else {

						// orders
						if(in_array("orders",$active_modules)) {
							$clientsOrdersModel = new ClientsOrdersModel();
							$qph ="select id from " . CO_TBL_CLIENTS_ORDERS . " where pid = '$pid' and bin='1'";
							$resultph = mysql_query($qph, $this->_db->connection);
							while ($rowph = mysql_fetch_array($resultph)) {
								$phid = $rowph["id"];
								$clientsOrdersModel->deleteOrder($phid);
								$arr["orders"] = "";
							}
						}


						// meetings
						if(in_array("meetings",$active_modules)) {
							$clientsMeetingsModel = new ClientsMeetingsModel();
							$qm ="select id, title, bin, bintime, binuser from " . CO_TBL_CLIENTS_MEETINGS . " where pid = '$pid'";
							$resultm = mysql_query($qm, $this->_db->connection);
							while ($rowm = mysql_fetch_array($resultm)) {
								$mid = $rowm["id"];
								if($rowm["bin"] == "1") { // deleted meeting
									$clientsMeetingsModel->deleteMeeting($mid);
									$arr["meetings"] = "";
								} else {
									// meetings_tasks
									$qmt ="select id, title, bin, bintime, binuser from " . CO_TBL_CLIENTS_MEETINGS_TASKS . " where mid = '$mid'";
									$resultmt = mysql_query($qmt, $this->_db->connection);
									while ($rowmt = mysql_fetch_array($resultmt)) {
										if($rowmt["bin"] == "1") { // deleted phases
											$mtid = $rowmt["id"];
											$clientsMeetingsModel->deleteMeetingTask($mtid);
											$arr["meetings_tasks"] = "";
										}
									}
								}
							}
						}
						
						
						// phonecalls
						if(in_array("phonecalls",$active_modules)) {
							$clientsPhoncallsModel = new ClientsPhonecallsModel();
							$qc ="select id, title, bin, bintime, binuser from " . CO_TBL_CLIENTS_PHONECALLS . " where pid = '$pid'";
							$resultc = mysql_query($qc, $this->_db->connection);
							while ($rowc = mysql_fetch_array($resultc)) {
								$cid = $rowc["id"];
								if($rowc["bin"] == "1") {
									$clientsPhoncallsModel->deletePhonecall($cid);
									$arr["phonecalls"] = "";
								}
							}
						}


						// documents_folder
						if(in_array("documents",$active_modules)) {
							$clientsDocumentsModel = new ClientsDocumentsModel();
							$qd ="select id, title, bin, bintime, binuser from " . CO_TBL_CLIENTS_DOCUMENTS_FOLDERS . " where pid = '$pid'";
							$resultd = mysql_query($qd, $this->_db->connection);
							while ($rowd = mysql_fetch_array($resultd)) {
								$did = $rowd["id"];
								if($rowd["bin"] == "1") { // deleted meeting
									$clientsDocumentsModel->deleteDocument($did);
									$arr["documents_folders"] = "";
								} else {
									// files
									$qf ="select id, filename, bin, bintime, binuser from " . CO_TBL_CLIENTS_DOCUMENTS . " where did = '$did'";
									$resultf = mysql_query($qf, $this->_db->connection);
									while ($rowf = mysql_fetch_array($resultf)) {
										if($rowf["bin"] == "1") { // deleted phases
											$fid = $rowf["id"];
											$clientsDocumentsModel->deleteFile($fid);
											$arr["files"] = "";
										}
									}
								}
							}
						}
	
	
						// vdocs
						if(in_array("vdocs",$active_modules)) {
							$qv ="select id, title, bin, bintime, binuser from " . CO_TBL_CLIENTS_VDOCS . " where pid = '$pid'";
							$resultv = mysql_query($qv, $this->_db->connection);
							while ($rowv = mysql_fetch_array($resultv)) {
								$vid = $rowv["id"];
								if($rowv["bin"] == "1") {
								$vdocsmodel = new VDocsModel();
								$vdocsmodel->deleteVDoc($vid);
								$arr["vdocs"] = "";
								}
							}
						}


					}
				}
			}
	  	}
		return $arr;
   }


	// User Access
	function getEditPerms($id) {
		global $session;
		$perms = array();
		$q = "SELECT pid FROM co_clients_access where admins REGEXP '[[:<:]]" . $id . "[[:>:]]'";
      	$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$perms[] = $row["pid"];
		}
		return $perms;
   }


   function getViewPerms($id) {
		global $session;
		$perms = array();
		$q = "SELECT pid FROM co_clients_access where guests REGEXP '[[:<:]]" . $id. "[[:>:]]'";
      	$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$perms[] = $row["pid"];
		}
		return $perms;
   }


   function canAccess($id) {
	   global $session;
	   return array_merge($this->getViewPerms($id),$this->getEditPerms($id));
   }


   function getClientAccess($pid) {
		global $session;
		$access = "";
		if(in_array($pid,$this->getViewPerms($session->uid))) {
			$access = "guest";
		}
		if(in_array($pid,$this->getEditPerms($session->uid))) {
			$access = "admin";
		}
		/*if($this->isOwnerPerms($pid,$session->uid)) {
			$access = "owner";
		}*/
		if($session->isSysadmin()) {
			$access = "sysadmin";
		}
		return $access;
   }
   
   
   /*function isOwnerPerms($id,$uid) {
	   	$q = "SELECT id FROM co_clients where id = '$id' and created_user ='$uid'";
      	$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			return true;
		} else {
			return false;
		}
   }*/
   
   /*function isClientOwner($uid) {
	   	$q = "SELECT id FROM co_clients where created_user = '$uid'";
      	$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			return true;
		} else {
			return false;
		}
   }*/
   
   
   function setContactAccessDetails($id, $cid, $username, $password) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$pwd = md5($password);
		
		$q = "INSERT INTO " . CO_TBL_CLIENTS_ORDERS_ACCESS . "  set uid = '$id', cid = '$cid', username = '$username', password = '$pwd', access_user = '$session->uid', access_date = '$now', access_status=''";
		
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	
	function removeAccess($id,$cid) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "DELETE FROM " . CO_TBL_CLIENTS_ORDERS_ACCESS . " where uid='$id' and cid = '$cid'";
		
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
  
  
 	function getNavModulesNumItems($id) {
		global $clients;
		$active_modules = array();
		foreach($clients->modules as $module => $value) {
			$active_modules[] = $module;
		}
		if(in_array("orders",$active_modules)) {
			$clientsOrdersModel = new ClientsOrdersModel();
			$data["clients_orders_items"] = $clientsOrdersModel->getNavNumItems($id);
		}		
		if(in_array("meetings",$active_modules)) {
			$clientsMeetingsModel = new ClientsMeetingsModel();
			$data["clients_meetings_items"] = $clientsMeetingsModel->getNavNumItems($id);
		}
		if(in_array("phonecalls",$active_modules)) {
			$clientsPhonecallsModel = new ClientsPhonecallsModel();
			$data["clients_phonecalls_items"] = $clientsPhonecallsModel->getNavNumItems($id);
		}
		if(in_array("documents",$active_modules)) {
			$clientsDocumentsModel = new ClientsDocumentsModel();
			$data["clients_documents_items"] = $clientsDocumentsModel->getNavNumItems($id);
		}
		return $data;
	}
 
 

}

$clientsmodel = new ClientsModel(); // needed for direct calls to functions eg echo $clientsmodel ->getClientTitle(1);
?>
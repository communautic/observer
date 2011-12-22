<?php

class ClientsOrdersModel extends ClientsModel {
	
	public function __construct() {  
     	parent::__construct();
		$this->_contactsmodel = new ContactsModel();
	}


	function getList($id,$sort) {
		global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("clients-orders-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("clients-orders-sort-order",$id);
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
				  		$sortorder = $this->getSortOrder("clients-orders-sort-order",$id);
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
	  
	  
		$perm = $this->getClientAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		
		$q = "select id,title,item_date,access,status,checked_out,checked_out_user from " . CO_TBL_CLIENTS_ORDERS . " where pid = '$id' and bin != '1' " . $sql . $order;

		$this->setSortStatus("clients-orders-sort-status",$sortcur,$id);
		$result = mysql_query($q, $this->_db->connection);
		$orders = "";
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
			if($array["status"] == 1) {
				$itemstatus = " module-item-active";
			}
			$array["itemstatus"] = $itemstatus;
			
			$checked_out_status = "";
			if($perm !=  "guest" && $array["checked_out"] == 1 && $array["checked_out_user"] != $session->uid) {
				if($session->checkUserActive($array["checked_out_user"])) {
					$checked_out_status = "icon-checked-out-active";
				} else {
					$this->checkinOrderOverride($id);
				}
			}
			$array["checked_out_status"] = $checked_out_status;
			
			$orders[] = new Lists($array);
	  }
		
	  $arr = array("orders" => $orders, "sort" => $sortcur, "perm" => $perm);
	  return $arr;
	}


	function checkoutOrder($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_CLIENTS_ORDERS . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function checkinOrder($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_CLIENTS_ORDERS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_CLIENTS_ORDERS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}


	function checkinOrderOverride($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_CLIENTS_ORDERS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	

	function getDetails($id) {
		global $session, $lang;
		
		$this->_documents = new ClientsDocumentsModel();
		
		$q = "SELECT * FROM " . CO_TBL_CLIENTS_ORDERS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		$array["perms"] = $this->getClientAccess($array["pid"]);
		$array["canedit"] = false;
		$array["showCheckout"] = false;
		$array["checked_out_user_text"] = $this->_contactsmodel->getUserListPlain($array['checked_out_user']);

		if($array["perms"] == "sysadmin" || $array["perms"] == "admin") {
			//if($array["checked_out"] == 1 && $session->checkUserActive($array["checked_out_user"])) {
			if($array["checked_out"] == 1) {
				if($array["checked_out_user"] == $session->uid) {
					$array["canedit"] = true;
				} else if(!$session->checkUserActive($array["checked_out_user"])) {
					$array["canedit"] = $this->checkoutOrder($id);
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
					$array["checked_out_user_phone1"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
					$array["checked_out_user_email"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");
				}
			} else {
				$array["canedit"] = $this->checkoutOrder($id);
			}
		}
		
		// dates
		$array["item_date"] = $this->_date->formatDate($array["item_date"],CO_DATE_FORMAT);
		
		// time

		$array["management"] = $this->_contactsmodel->getUserList($array['management'],'clientsmanagement', "", $array["canedit"]);
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
				$array["status_text"] = $lang["CLIENT_ORDER_STATUS_OPEN"];
				$array["status_date"] = '';
			break;
			case "1":
				$array["status_text"] = $lang["CLIENT_ORDER_STATUS_DONE"];
				$array["status_date"] = '';
			break;
		}
		
		$sendto = $this->getSendtoDetails("clients_orders",$id);
		
		
		$array["total_mon"] = $array["mon"] + $array["mon_2"] + $array["mon_3"];
		$array["total_tue"] = $array["tue"] + $array["tue_2"] + $array["tue_3"];
		$array["total_wed"] = $array["wed"] + $array["wed_2"] + $array["wed_3"];
		$array["total_thu"] = $array["thu"] + $array["thu_2"] + $array["thu_3"];
		$array["total_fri"] = $array["fri"] + $array["fri_2"] + $array["fri_3"];
		
		$array["total"] = $array["total_mon"] + $array["total_tue"] + $array["total_wed"] + $array["total_thu"] + $array["total_fri"];
		
		
		// get client contract
		$cid = $array["pid"];
		$q = "SELECT contract FROM co_clients where id = '$cid'";
		$result = mysql_query($q, $this->_db->connection);
		$array["contract"] = mysql_result($result,0);
		
		switch($array["contract"]) {
			case "0":
				$array["contract_text"] = "";
				$array["contract_rows"] = 0;
			break;
			case "1":
				$array["contract_text"] = $lang["CLIENT_CONTRACT_ONE"];
				$array["contract_rows"] = 1;
			break;
			case "2":
				$array["contract_text"] = $lang["CLIENT_CONTRACT_TWO"];
				$array["contract_rows"] = 1;
			break;
			case "3":
				$array["contract_text"] = $lang["CLIENT_CONTRACT_THREE"];
				$array["contract_rows"] = 1;
			break;
			case "4":
				$array["contract_text"] = $lang["CLIENT_CONTRACT_FOUR"];
				$array["contract_rows"] = 1;
			break;
			case "5":
				$array["contract_text"] = $lang["CLIENT_CONTRACT_FIVE"];
				$array["contract_rows"] = 2;
			break;
			case "6":
				$array["contract_text"] = $lang["CLIENT_CONTRACT_SIX"];
				$array["contract_rows"] = 2;
			break;
			case "7":
				$array["contract_text"] = $lang["CLIENT_CONTRACT_SEVEN"];
				$array["contract_rows"] = 3;
			break;
			case "8":
				$array["contract_text"] = $lang["CLIENT_CONTRACT_EIGHT"];
				$array["contract_rows"] = 3;
			break;
		}
		
		$order = new Lists($array);
		
		// order details
		$oid = $array["oid"];
		$q = "SELECT * FROM co_publishers_menues where id = '$oid'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$o[$key] = $val;
		}
		
		$order_details = new Lists($o);
		
		$arr = array("order" => $order, "order_details" => $order_details, "sendto" => $sendto, "access" => $array["perms"]);
		return $arr;
   }


   function setDetails($id,$title,$protocol,$documents,$order_access,$order_access_orig,$order_status,$order_status_date) {
		global $session, $lang;
		
		//$order_status_date = $this->_date->formatDateGMT($order_status_date);

		$now = gmdate("Y-m-d H:i:s");
		
		if($order_access == $order_access_orig) {
			$accesssql = "";
		} else {
			$order_access_date = "";
			if($order_access == 1) {
				$order_access_date = $now;
			}
			$accesssql = "access='$order_access', access_date='$order_access_date', access_user = '$session->uid',";
		}

		$q = "UPDATE " . CO_TBL_CLIENTS_ORDERS . " set title = '$title', protocol = '$protocol', documents = '$documents', access='$order_access', $accesssql status = '$order_status', status_date = '$order_status_date', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
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
		
		$q = "INSERT INTO " . CO_TBL_CLIENTS_ORDERS . " set title = '" . $lang["CLIENT_ORDER_NEW"] . "', item_date='$now', start='$time', end='$time', pid = '$id', status = '1', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
				
		if ($result) {
			return $id;
		}
   }
   

   	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		// order
		$q = "INSERT INTO " . CO_TBL_CLIENTS_ORDERS . " (pid,title,item_date,start,end,protocol,management,management_ct,status,created_date,created_user,edited_date,edited_user) SELECT pid,CONCAT(title,' " . $lang["GLOBAL_DUPLICAT"] . "'),item_date,start,end,protocol,management,management_ct,status,'$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_CLIENTS_ORDERS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		if ($result) {
			return $id_new;
		}
	}


   function binOrder($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_CLIENTS_ORDERS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function restoreOrder($id) {
		$q = "UPDATE " . CO_TBL_CLIENTS_ORDERS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deleteOrder($id) {
		
		$q = "DELETE FROM co_log_sendto WHERE what='clients_orders' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_CLIENTS_ORDERS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function toggleIntern($id,$status) {
		global $session;
		$q = "UPDATE " . CO_TBL_CLIENTS_ORDERS . " set intern = '$status' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   
   function createExcel($folderid,$menueid) {
	    global $session;
		
		// get startdatum of Menue
		$q ="select item_date_from from co_publishers_menues WHERE id='$menueid'";
      	$result = mysql_query($q, $this->_db->connection);
		$date = mysql_result($result, 0);
		$date = $this->_date->formatDate($date,CO_DATE_FORMAT);
		
		$q ="select id as clientid,title as clientname, contract from " . CO_TBL_CLIENTS . " WHERE folder='$folderid' and bin = '0' ORDER BY title";
      	$result = mysql_query($q, $this->_db->connection);
	  	$clients = "";
		while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			$id = $array["clientid"];
			// get order
			$qo ="select a.* from " . CO_TBL_CLIENTS_ORDERS . " as a WHERE a.pid='$id' and a.oid='$menueid' and a.bin = '0'";
			$resulto = mysql_query($qo, $this->_db->connection);
			if(mysql_num_rows($resulto) < 1) {
				// try to get the latest order
				$qold ="select a.* from " . CO_TBL_CLIENTS_ORDERS . " as a WHERE a.pid='$id' and a.bin = '0' ORDER BY id DESC LIMIT 0,1";
				$resultold = mysql_query($qold, $this->_db->connection);
				if(mysql_num_rows($resultold) < 1) {
					$array["line_1"] = 0;
				} else {
					$array["line_1"] = 3;
					while ($rowold = mysql_fetch_array($resultold)) {
						foreach($rowold as $keyold => $valold) {
							$array[$keyold] = $valold;
						}
					}
					
				}
				
				
			} else {
				$array["line_1"] = 1;
				while ($rowo = mysql_fetch_array($resulto)) {
					foreach($rowo as $keyo => $valo) {
						$array[$keyo] = $valo;
					}
				}
			}
		
		$clients[] = new Lists($array);
	  }
	  $arr = array("clients" => $clients, "date"=> $date);
	   return $arr;
   }

}
?>
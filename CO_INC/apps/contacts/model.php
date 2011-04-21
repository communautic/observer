<?php

//include_once(dirname(__FILE__)."/model/groups.php");
//include_once(dirname(__FILE__)."/model/contacts.php");
//include_once(dirname(__FILE__)."/model/lists.php");

class ContactsModel extends Model {

	// Get all Contact Groups
   function getGroupList($sort) {
      global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("group-sort-status");
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
				  		$sortorder = $this->getSortOrder("group-sort-order");
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
				  		$sortorder = $this->getSortOrder("group-sort-order");
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
	  
	  $q = "select id, title, members from " . CO_CONTACTS_TBL_GROUPS . " where bin = '0' " . $order;
	  
	  $this->setSortStatus("group-sort-status",$sortcur);
      $result = mysql_query($q, $this->_db->connection);
	  $groups = "";
	  while ($row = mysql_fetch_array($result)) {
		foreach($row as $key => $val) {
				$array[$key] = $val;
				if($key == "members") {
				$array["numContacts"] = $this->getNumContacts($val);
				}
			}
			$groups[] = new Lists($array); 
	  }
	  
	  $arr = array("groups" => $groups, "sort" => $sortcur);
	  return $arr;
   }


  /**
   * get details for the contact group
   */
   function getGroupDetails($id) {
		global $session;
		$q = "SELECT * FROM " . CO_CONTACTS_TBL_GROUPS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_assoc($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		// dates
		$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
	
		$array["allcontacts"] = $this->getNumContacts($array["members"]);
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		$array["membersID"] = $array["members"];
		$array["members"] = $this->getUserList($array['members'],'members');

		$group = new Lists($array);
		return $group;
   }
   
 
   /**
   * get details for the contact group
   */
   function setGroupDetails($id,$title,$members) {
		global $session;
		$members = $this->sortUserIDsByName($members);
		$q = "UPDATE " . CO_CONTACTS_TBL_GROUPS . " set title = '$title', members = '$members' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }
   
   /**
   * create new contact group
   */
   function newGroup() {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "INSERT INTO " . CO_CONTACTS_TBL_GROUPS . " set title = 'Neue Gruppe', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	$id = mysql_insert_id();
			return $id;
		}
   }
   
   
   function duplicateGroup($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "INSERT INTO " . CO_CONTACTS_TBL_GROUPS . " (title, members, edited_user, edited_date, created_user, created_date) SELECT CONCAT(title, ' ".$lang["GLOBAL_DUPLICAT"]."'),members, $session->uid as edited_user, '$now' as edited_date, $session->uid as created_user, '$now' as created_date FROM " . CO_CONTACTS_TBL_GROUPS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		
		if ($result) {
			return $id_new;
		}
	}
   
   /**
   * delete contact group
   */
   function binGroup($id) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_CONTACTS_TBL_GROUPS . " set bin = '1', bintime = '$now', binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }

   function restoreGroup($id) {
		$q = "UPDATE " . CO_CONTACTS_TBL_GROUPS . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   
    function deleteGroup($id) {
		$q = "DELETE FROM " . CO_CONTACTS_TBL_GROUPS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }

  /**
   * get number of contacts for a contact group
   * status: 0 = all, 1 = active, 2 = abgeschlossen
   */  
   
   function getNumAllContacts() {
		global $session;

		$q = "select count(*) from " . CO_TBL_USERS . " WHERE bin !='1'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_result($result,0);
		return $row;
   }
   
	 // comma separated list - returns number
	 
   function getNumContacts($string) {
		global $session;

		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = 0;
		
		if($users_total == 0) { 
			return $users; 
		}
		
		// check if user is available and build array
		$i = 0;
		foreach ($users_string as &$value) {
			$q = "SELECT id FROM ".CO_TBL_USERS." where id = '$value' and bin='0'";
			$result_user = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result_user) > 0) {
				$i++;
			}
		}
		return $i; 
   }
   
   
   	 function getContactTitle($id){
		global $session;
		$q = "SELECT title FROM " . CO_TBL_PROJECTS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		return $title;
   }
   
   function getContactFieldFromID($id,$field){
		global $session;
		$q = "SELECT " . $field . " FROM " . CO_TBL_USERS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$string = mysql_result($result,0);
		return $string;
   }
   
  /**
   * get the list of contacts for a contact group
   */ 
   
   function getContactList($sort) {
      global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("contact-sort-status");
		  if(!$sortstatus) {
		  	$order = "order by lastname ASC";
			$sortcur = '1';
		  } else {
			  switch($sortstatus) {
				  case "1":
				  		$order = "order by lastname ASC";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by lastname DESC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("contact-sort-order");
				  		if(!$sortorder) {
						  	$order = "order by lastname ASC";
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
				  		$order = "order by lastname ASC";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by lastname DESC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("contact-sort-order");
				  		if(!$sortorder) {
						  	$order = "order by lastname ASC";
							$sortcur = '1';
						  } else {
							$order = "order by field(id,$sortorder)";
							$sortcur = '3';
						  }
				  break;
			  }
	  }
	  
	  $q = "select id,firstname,lastname from " . CO_TBL_USERS . " where invisible = '0' and bin = '0' " . $order;

	  $this->setSortStatus("contact-sort-status",$sortcur);
      $result = mysql_query($q, $this->_db->connection);
	  $contacts = "";
	  while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			$contacts[] = new Lists($array);
		  
	  }
	  
	  $arr = array("contacts" => $contacts, "sort" => $sortcur);
	  
	  return $arr;
   }
   
   
   function getContactDetails($id) {
		global $session;
		$q = "SELECT * FROM " . CO_TBL_USERS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
		
		// dates
		$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
		
		// other functions
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		$array["groups"] = $this->getGroupsByUser($id);
		
		$contact = new Lists($array);
		return $contact;
   }
	 
	 function getGroupsByUser($id) {
		 	global $session;
			$groups = '';
			$q = "SELECT * FROM " . CO_CONTACTS_TBL_GROUPS . " where bin='0' and members REGEXP '[[:<:]]".$id."[[:>:]]'";
			$result = mysql_query($q, $this->_db->connection);
			$rows = mysql_num_rows($result);
			$i = 1;
			while($row = mysql_fetch_array($result)) {
				//$groups .= '<a href="#" class="loadGroup" rel="'.$row["id"].'">'.$row["title"].'</a>';
				$groups .= $row["title"];
				if($i < $rows) {
					$groups .= ", ";
				}
				$i++;
			}
			return $groups;
	 }
   
   // Create contact group title
	function getContactGroupDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			$q = "SELECT id, title from " . CO_CONTACTS_TBL_GROUPS . " where id = '$value'";
			$result_user = mysql_query($q, $this->_db->connection);
			while($row_user = mysql_fetch_assoc($result_user)) {
				$users .= '<span class="groupmember" uid="' . $row_user["id"] . '">' . $row_user["title"] . '</span>';
				if($i < $users_total) {
					$users .= ', ';
				}
			}
			$i++;
		}
		return $users;
   }
	
	function getRelatedDocuments($id){
		$string = "";
		$q = "SELECT title from " . PO_TBL_DOCUMENTS . " where related_to = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$num = mysql_num_rows($result);
		$i = 1;
		while($row = mysql_fetch_array($result)) {
			$string .= '<a class="groupmember tooltip-advanced" uid="0:' . $id . '">' . $row["title"] . '</a>';
			if($i < $num) {
				$string .= ', ';
			}
			$i++;
		}
		return $string;
   }
   
   
   /**
   * get details for the contact group
   */
   function setContactDetails($id, $lastname, $firstname, $title, $company, $position, $email, $phone1, $phone2, $fax, $address_line1, $address_line2, $address_town, $address_postcode, $address_country, $lang,$timezone) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_USERS . " set lastname = '$lastname', firstname = '$firstname', title = '$title', company = '$company', position = '$position', email = '$email', phone1 = '$phone1', phone2 = '$phone2', fax = '$fax', address_line1 = '$address_line1', address_line2 = '$address_line2', address_town = '$address_town', address_postcode = '$address_postcode', address_country = '$address_country', lang = '$lang', timezone = '$timezone', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }
   
   
   function newContact() {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "INSERT INTO " . CO_TBL_USERS . " set lastname = 'Neuer Kontakt', lang = '" . CO_DEFAULT_LANGUAGE . "', timezone = '" . CO_DEFAULT_TIMEZONE . "', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	$id = mysql_insert_id();
			return $id;
		}
   }
   
   	function duplicateContact($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "INSERT INTO " . CO_TBL_USERS . " (lastname, firstname, title, company, position, email, phone1, phone2, fax, address_line1, address_line2, address_town, address_postcode, address_country, lang, timezone, edited_user, edited_date, created_user, created_date) SELECT CONCAT('".$lang["GLOBAL_DUPLICAT"]." ',lastname),firstname, title, company, position, email, phone1, phone2, fax, address_line1, address_line2, address_town, address_postcode, address_country, lang, timezone, $session->uid as edited_user, '$now' as edited_date, $session->uid as created_user, '$now' as created_date FROM " . CO_TBL_USERS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		
		if ($result) {
			return $id_new;
		}
	}
   
	function binContact($id) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_USERS . " set bin = '1', bintime = '$now', binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}

	function restoreContact($id) {
		$q = "UPDATE " . CO_TBL_USERS . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	function deleteContact($id) {
		$q = "DELETE FROM " . CO_TBL_USER_SETTINGS . " WHERE uid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_USERS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
   function getContactsDialog($request,$field,$append,$title,$sql) {
		global $session;
		
		$groups = "";
		$array["field"] = $field;
		$q = "select id, title from " . CO_CONTACTS_TBL_GROUPS . " where bin = '0' order by title";
		$result = mysql_query($q, $this->_db->connection);
	  	while ($row = mysql_fetch_array($result)) {
		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			$groups[] = new Lists($array); 
	  }

	  return $groups;
	}
	
	
	function sortUserIDsByName($string) {
		$ids_arr = explode(",", $string);
		$ids_total = sizeof($ids_arr);
		$ids = '';
		
		if($ids_total == 0) { 
			return $ids; 
		}
		
		$users_arr = array();
		foreach ($ids_arr as &$value) {
			$q = "SELECT id, firstname, lastname FROM ".CO_TBL_USERS." where id = '$value'";
			$result_user = mysql_query($q, $this->_db->connection);
			while($row_user = mysql_fetch_assoc($result_user)) {
				$users_arr[$row_user["id"]] = $row_user["lastname"] . " " . $row_user["firstname"];
			}
		}
		array_unique($users_arr);
		asort($users_arr);
		$ids_rtn = array();
		foreach ($users_arr as $key => $value) {
			$ids_rtn[] = $key;
		}
		
		$ids_string = implode(",", $ids_rtn);
		
		return $ids_string;
		
	}
	
	/*function getUserFieldFromIDs($string, $field) {
		$ids_arr = explode(",", $string);
		$ids_total = sizeof($ids_arr);
		$emails = array();
		foreach ($ids_arr as &$value) {
			$q = "SELECT " . $field . " FROM ".CO_TBL_USERS." where id = '$value'";
			$result = mysql_query($q, $this->_db->connection);
			$row = mysql_fetch_assoc($result);
			$emails[] = $row["email"];
		}
		return $emails;
	}*/
	
	
	function getUserList($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		
		if($users_total == 0) { 
			return $users; 
		}
		
		// check if user is available and build array
		$users_arr = array();
		foreach ($users_string as &$value) {
			$q = "SELECT id, firstname, lastname FROM ".CO_TBL_USERS." where id = '$value' and bin='0'";
			$result_user = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result_user) > 0) {
				while($row_user = mysql_fetch_assoc($result_user)) {
					$users_arr[$row_user["id"]] = $row_user["lastname"] . ' ' . $row_user["firstname"];		
				}
			}
		}
		$users_arr_total = sizeof($users_arr);
		
		// build string
		$i = 1;
		foreach ($users_arr as $key => &$value) {
			$users .= '<span class="listmember-outer"><a class="listmember" uid="' . $key . '" field="' . $field . '">' . $value;		
			if($i < $users_arr_total) {
				$users .= ', ';
			}
			$users .= '</a></span>';	
			$i++;
		}
		return $users;
}




function getUserListPlain($string){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		
		if($users_total == 0) { 
			return $users; 
		}
		
		// check if user is available and build array
		$users_arr = array();
		foreach ($users_string as &$value) {
			$q = "SELECT id, firstname, lastname FROM ".CO_TBL_USERS." where id = '$value'";
			$result_user = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result_user) > 0) {
				while($row_user = mysql_fetch_assoc($result_user)) {
					$users_arr[$row_user["id"]] = $row_user["lastname"] . ' ' . $row_user["firstname"];		
				}
			}
		}
		$users_arr_total = sizeof($users_arr);
		
		// build string
		$i = 1;
		foreach ($users_arr as $key => &$value) {
			$users .= $value;		
			if($i < $users_arr_total) {
				$users .= ', ';
			}
			$users .= '';	
			$i++;
		}
		return $users;
}


	function getPlaceList($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		
		if($users_total == 0) { 
			return $users; 
		}
		
		// check if user is available and build array
		$users_arr = array();
		foreach ($users_string as &$value) {
			$q = "SELECT id, address_line1, address_postcode, address_town FROM ".CO_TBL_USERS." where id = '$value'";
			$result_user = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result_user) > 0) {
				while($row_user = mysql_fetch_assoc($result_user)) {
					$users_arr[$row_user["id"]] = $row_user["address_line1"] . ", " . $row_user["address_postcode"] . " " . $row_user["address_town"];		
				}
			}
		}
		$users_arr_total = sizeof($users_arr);
		
		// build string
		$i = 1;
		foreach ($users_arr as $key => &$value) {
			$users .= '<span class="listmember-outer"><a class="listmember" uid="' . $key . '" field="' . $field . '">' . $value;		
			if($i < $users_arr_total) {
				$users .= ', ';
			}
			$users .= '</a></span>';	
			$i++;
		}
		return $users;
}

   
	 
	 
	 function getUsersInGroupDialog($id,$field){
		$users = '';
		$q = "SELECT members FROM ".CO_CONTACTS_TBL_GROUPS." WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$members = mysql_result($result,0);
		$members = $this->getUserList($members,$field);
		return $members;
   }
   
   
   function getUserContext($id,$field){
		$q = "SELECT id, firstname, lastname, company, position,phone1,phone2,fax,address_line1, address_town, address_postcode,email FROM ".CO_TBL_USERS." where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		$array["field"] = $field;
		
		$context = new Lists($array); 
	  	return $context;
   }
	 
	function getContactsSearch($term){
			global $system;
			$num=0;
			$q = "SELECT id, CONCAT(lastname,' ',firstname) as label from " . CO_TBL_USERS . " where (lastname like '%$term%' or firstname like '%$term%') and bin ='0' and invisible = '0'";
			$result = mysql_query($q, $this->_db->connection);
			$num=mysql_affected_rows();
			$rows = array();
			while($r = mysql_fetch_assoc($result)) {
				 $rows[] = $r;
			}
			return $system->json_encode($rows);
   }
	 
	 function getPlacesSearch($term){
			global $system;
			$num=0;
			$q = "SELECT id, CONCAT(lastname, ' ',firstname,', ',address_line1, ', ', address_postcode, ' ', address_town) as label from " . CO_TBL_USERS . " where (lastname like '%$term%' or firstname like '%$term%') and bin ='0' and invisible = '0'";
			$result = mysql_query($q, $this->_db->connection);
			$num=mysql_affected_rows();
			$rows = array();
			while($r = mysql_fetch_assoc($result)) {
				 $rows[] = $r;
			}
			return $system->json_encode($rows);
   }
   
   
   
      function getBin() {
	   	
		$bin = array();
		$bin["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
	  	
		$groups = "";
		$q ="select id, title, bin, bintime, binuser from " . CO_CONTACTS_TBL_GROUPS . " WHERE bin='1'";
		$result = mysql_query($q, $this->_db->connection);
	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$group[$key] = $val;
			}
			$group["bintime"] = $this->_date->formatDate($group["bintime"],CO_DATETIME_FORMAT);
			$group["binuser"] = $this->_users->getUserFullname($group["binuser"]);
			$groups[] = new Lists($group);
	  	}
		
		$contacts = "";
		$q ="select id, firstname, lastname, bin, bintime, binuser from " . CO_TBL_USERS . " WHERE bin='1'";
		$result = mysql_query($q, $this->_db->connection);
	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$contact[$key] = $val;
			}
			$contact["bintime"] = $this->_date->formatDate($contact["bintime"],CO_DATETIME_FORMAT);
			$contact["binuser"] = $this->_users->getUserFullname($contact["binuser"]);
			$contacts[] = new Lists($contact);
	  	}
		
		$arr = array("bin" => $bin, "groups" => $groups, "contacts" => $contacts);
		return $arr;
   }
  
  
   function emptyBin() {
	   	
		$bin = array();
		$bin["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
	  	
		$groups = "";
		$q ="select id, title, bin, bintime, binuser from " . CO_CONTACTS_TBL_GROUPS . " WHERE bin='1'";
		$result = mysql_query($q, $this->_db->connection);
	  	while ($row = mysql_fetch_array($result)) {
			$id = $row["id"];
			$this->deleteGroup($id);
	  	}
		
		$contacts = "";
		$q ="select id, firstname, lastname, bin, bintime, binuser from " . CO_TBL_USERS . " WHERE bin='1'";
		$result = mysql_query($q, $this->_db->connection);
	  	while ($row = mysql_fetch_array($result)) {
			$id = $row["id"];
			$this->deleteContact($id);
	  	}
		
		$arr = array("bin" => $bin, "groups" => $groups, "contacts" => $contacts);
		return $arr;
   }
   
	
}

$contactsmodel = new ContactsModel();
?>
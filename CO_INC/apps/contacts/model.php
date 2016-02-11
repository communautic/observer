<?php

//include_once(dirname(__FILE__)."/model/groups.php");
//include_once(dirname(__FILE__)."/model/contacts.php");
//include_once(dirname(__FILE__)."/model/lists.php");

class ContactsModel extends Model {

	// Get all Contact Groups
   function getGroupList($sort) {
      global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("contacts-group-sort-status");
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
				  		$sortorder = $this->getSortOrder("contacts-group-sort-order");
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
				  		$sortorder = $this->getSortOrder("contacts-group-sort-order");
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
	  
	  $this->setSortStatus("contacts-group-sort-status",$sortcur);
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


	function setGroupDetails($id,$title,$members,$notes) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$members = $this->sortUserIDsByName($members);
		$q = "UPDATE " . CO_CONTACTS_TBL_GROUPS . " set title = '$title', notes = '$notes', members = '$members', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}


	function newGroup() {
		global $session, $lang;
		$now = gmdate("Y-m-d H:i:s");
		$q = "INSERT INTO " . CO_CONTACTS_TBL_GROUPS . " set title = '" . $lang["CONTACTS_GROUPS_NEW"] . "', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
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


	function getNumAllContacts() {
		global $session;

		$q = "select count(*) from " . CO_TBL_USERS . " WHERE bin !='1'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_result($result,0);
		return $row;
	}


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


	function getContactFieldFromID($id,$field){
		global $session;
		$q = "SELECT " . $field . " FROM " . CO_TBL_USERS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$string = mysql_result($result,0);
		return $string;
	}


	function getContactList($sort) {
      global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("contacts-contact-sort-status");
		  if(!$sortstatus) {
		  	$order = "order by lastname ASC, firstname ASC";
			$sortcur = '1';
		  } else {
			  switch($sortstatus) {
				  case "1":
				  		$order = "order by lastname ASC, firstname ASC";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by lastname DESC, firstname DESC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("contacts-contact-sort-order");
				  		if(!$sortorder) {
						  	$order = "order by lastname ASC, firstname ASC";
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
				  		$order = "order by lastname ASC, firstname ASC";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by lastname DESC, firstname DESC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("contacts-contact-sort-order");
				  		if(!$sortorder) {
						  	$order = "order by lastname ASC, firstname ASC";
							$sortcur = '1';
						  } else {
							$order = "order by field(id,$sortorder)";
							$sortcur = '3';
						  }
				  break;
			  }
	  }
	  
	  $q = "select id,firstname,lastname from " . CO_TBL_USERS . " where invisible = '0' and bin = '0' " . $order;

	  $this->setSortStatus("contacts-contact-sort-status",$sortcur);
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
   
   
	function getContactDetails($id,$applications="") {
		global $session, $lang;
		$q = "SELECT * FROM " . CO_TBL_USERS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
		
		/*if($array["avatar"] == "") {
			$array["avatar"] = CO_FILES . "/img/avatar.jpg";
		} else {
			$array["avatar"] = CO_PATH_URL . "/data/avatars/" . $array["avatar"];
		}*/
		
		$array["avatar"] = $this->_users->getAvatar($id);
	
		// dates
		$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
		$array["access_date"] = $this->_date->formatDate($array["access_date"],CO_DATE_FORMAT);
		$array["sysadmin_date"] = $this->_date->formatDate($array["sysadmin_date"],CO_DATE_FORMAT);
		
		// other functions
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		$array["access_user"] = $this->_users->getUserFullname($array["access_user"]);
		$array["sysadmin_user"] = $this->_users->getUserFullname($array["sysadmin_user"]);
		$array["groups"] = $this->getGroupsByUser($id);
		
		$array["access"] = $lang['CONTACTS_ACCESSCODES_NO'];
		$array["admin"] = "";
		$array["guest"] = "";
		$array["option_sysadmin"] = 0;
		$array["sysadmin"] = $lang['CONTACTS_SYSADMIN_NORIGHTS'];
		$array["applications"] = "";
		
		// calendar
		$array["showCalendarTab"] = false;
		if($applications != "") {
			foreach($applications as $app => $display) {
				if($app == 'calendar') {
					$array["showCalendarTab"] = true;
				}
			}
		}
		if($array["showCalendarTab"]) {
		$array["calendar_status"] = $lang['CONTACTS_CALENDAR_DEACTIVE'];
		$array['outlook_caldavurl'] = '';
		$array['ios_caldavurl'] = '';
		$array['caldavurl'] = '';
		$array['caldavurl_shared'] = '';
		$array['all_outlook_caldavurl'] = '';
		$array['all_caldavurl'] = '';
		if($array["calendar"] == 1) {
			$array["calendar_status"] = $lang['CONTACTS_CALENDAR_ACTIVE'];
			$url = explode('.',$_SERVER['HTTP_HOST']);
			//$cal_uri = strtolower($array['firstname'].$array['lastname']);
			$cal_uri = $session->strToSafeURL(strtolower($array['firstname'].$array['lastname']));
			$replace = array("'","."," ", "&quot;");
			$cal_uri = str_replace($replace, "", $cal_uri);
			$caldavurl = $url[0] . '.sync.' . $url[1] . '.' .$url[2];
			$array['outlook_caldavurl'] = 'https://' . $caldavurl . '/remote.php/caldav/calendars/' . $array["username"] . '/' . $cal_uri . '?export';
			$array['ios_caldavurl'] = $caldavurl . '/remote.php/caldav/principals/' . $array["username"];
			$array['caldavurl'] = 'https://' . $caldavurl . '/remote.php/caldav/calendars/' . $array["username"] . '/' . $cal_uri;
			$array['caldavurl_shared'] = 'https://' . $caldavurl . '/remote.php/caldav/calendars/USERNAME/' . $cal_uri . '_shared_by_' . $array["username"];
			
			$array['all_outlook_caldavurl'] = 'https://' . $caldavurl . '/remote.php/caldav/calendars/' . $array["username"] . '/' . $lang['CONTACTS_CALENDAR_ALL_URL'] . '_shared_by_sysadmin?export';
			$array['all_caldavurl'] = 'https://' . $caldavurl . '/remote.php/caldav/calendars/' . $array["username"] . '/' . $lang['CONTACTS_CALENDAR_ALL_URL'] . '_shared_by_sysadmin';
		}
		}
		
		if(!empty($array["username"])) {
			$array["access"] = sprintf($lang['CONTACTS_ACCESS_ACTIVE'], $array["access_date"], $array["access_user"]);
			/*$class = "ProjectsModel";
			$projectsmodel = new $class();
			$array["admin"] = $projectsmodel->getProjectTitleFromIDs($projectsmodel->getEditPerms($id));
			$array["guest"] = $projectsmodel->getProjectTitleFromIDs($projectsmodel->getViewPerms($id));*/
			$i = 0;
			if($applications != "" && $session->isSysadmin()) {
				foreach($applications as $app => $display) {
					//if($app == 'projects' || ) {
					$cap = ucfirst($app);
					$cont = new $cap($app);
					if($cont->contactsDisplay) {
						$cap_singular = substr($cap,0,-1);
						$target = 'access';
						$func = 'get'.$cap_singular.'TitleLinkFromIDs';
						$ids = $cont->model->getEditPerms($id);
						if(!empty($ids)) {
						$array["applications"][$i]["app"] = $app;
						$array["applications"][$i]["name"] = $lang[$app . "_name"] . " (" . $lang["GLOBAL_ADMIN_SHORT"] . ".)";
						$array["applications"][$i]["list"] = $cont->model->$func($ids,$target,1);
						$array["applications"][$i]["num"] = sizeof($ids);
						$i++;
						}
						$ids = $cont->model->getViewPerms($id);
						if(!empty($ids)) {
						$array["applications"][$i]["app"] = $app;
						$array["applications"][$i]["name"] = $lang[$app . "_name"] . " (" . $lang["GLOBAL_GUEST_SHORT"] . ".)";
						$array["applications"][$i]["list"] = $cont->model->$func($ids,$target,1);
						$array["applications"][$i]["num"] = sizeof($ids);
						$i++;
						}
					//}
					}
				}
			}
			
			
			$array["access_status"] = 0;
			$array["option_sysadmin"] = 1;
		} else {
			if($array["access_status"] == 1) {
				$array["access"] = sprintf($lang['CONTACTS_ACCESS_REMOVE'], $array["access_date"], $array["access_user"]);
			} else {
				$array["access_status"] = 1;
			}
		}
		
		if($array["userlevel"] == '0' && $array["sysadmin_status"] == '1') {
			$array["sysadmin"] = sprintf($lang['CONTACTS_SYSADMIN_REMOVE'], $array["sysadmin_date"], $array["sysadmin_user"]);
			$array["sysadmin_status"] = '1';
		} else {
			$array["sysadmin_status"] = '1';
		}
		
		if($array["userlevel"] == '1') {
			$array["admin"] = "";
			$array["guest"] = "";
			$array["sysadmin"] = sprintf($lang['CONTACTS_SYSADMIN_ACTIVE'], $array["sysadmin_date"], $array["sysadmin_user"]);
			$array["sysadmin_status"] = '0';
		}
		
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


	/*function getRelatedDocuments($id){
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
   }*/


	function setContactDetails($id, $lastname, $firstname, $title, $title2, $company, $position, $email, $email_alt, $phone1, $phone2, $fax, $address_line1, $address_line2, $address_town, $address_postcode, $address_country, $lang,$timezone,$bank_name,$sort_code,$account_number,$bic,$iban,$vat_no,$company_no,$company_reg_loc,$notes) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		// check for calendar
		$calendar = $this->_db->checkCalendar($id);
		if($calendar) { // update display name
			$q = "SELECT uid FROM oc_users WHERE couid='$id'";
			$result = mysql_query($q, $this->_db->connection);
			$calendar_userid = mysql_result($result,0);
			$displayname = $lastname . ' ' . $firstname;
			$uri = $session->strToSafeURL(strtolower($firstname.$lastname));
			$replace = array("'","."," ", "&quot;");
			$uri = str_replace($replace, "", $uri);
			$q = "UPDATE oc_clndr_calendars set displayname = '$displayname', uri='$uri' WHERE userid='$calendar_userid'";
			$result = mysql_query($q, $this->_db->connection);
			// check for share
			$q = "SELECT * FROM oc_share WHERE uid_owner='$calendar_userid'";
			$result = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result) > 0) {
				$q = "UPDATE oc_share set item_target='$displayname' WHERE uid_owner='$calendar_userid'";
				$result = mysql_query($q, $this->_db->connection);
			}
		}
		
		$q = "UPDATE " . CO_TBL_USERS . " set lastname = '$lastname', firstname = '$firstname', title = '$title', title2 = '$title2', company = '$company', position = '$position', email = '$email', email_alt = '$email_alt', phone1 = '$phone1', phone2 = '$phone2', fax = '$fax', address_line1 = '$address_line1', address_line2 = '$address_line2', address_town = '$address_town', address_postcode = '$address_postcode', address_country = '$address_country', lang = '$lang', timezone = '$timezone', notes='$notes', bank_name='$bank_name', sort_code='$sort_code', account_number='$account_number', bic='$bic', iban='$iban', vat_no ='$vat_no', company_no='$company_no', company_reg_loc='$company_reg_loc', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	
	function setContactAccessDetails($id, $username, $password) {
		global $session;
		// check for calendar
		$calendar = $this->_db->checkCalendar($id);
		if($calendar) { // update display name
			$q = "SELECT uid FROM oc_users WHERE couid='$id'";
			$result = mysql_query($q, $this->_db->connection);
			$calendar_userid = mysql_result($result,0);

			$q = "UPDATE oc_clndr_calendars set userid = '$username' WHERE userid='$calendar_userid'";
			$result = mysql_query($q, $this->_db->connection);
			
			$q = "UPDATE oc_users set uid = '$username' WHERE couid='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		
		
		$now = gmdate("Y-m-d H:i:s");
		
		$pwd = md5($password);
		
		$q = "UPDATE " . CO_TBL_USERS . "  set username = '$username', password = '$pwd', access_user = '$session->uid', access_date = '$now', access_status='' where id='$id'";
		
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	
	function removeAccess($id) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_USERS . "  set username = '', password = '', pwd_pick = '0', access_status = '1', access_user = '$session->uid', access_date = '$now' where id='$id'";
		
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	
	function setSysadmin($id) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_USERS . "  set userlevel = '1', sysadmin_user = '$session->uid', sysadmin_date = '$now' where id='$id'";
		
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	
	function removeSysadmin($id) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_USERS . "  set userlevel = '', sysadmin_status = '1', sysadmin_user = '$session->uid', sysadmin_date = '$now' where id='$id'";
		
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
   
   
	function newContact() {
		global $session,$lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "INSERT INTO " . CO_TBL_USERS . " set lastname = '" . $lang["CONTACTS_CONTACTS_NEW"] . "', lang = '" . CO_DEFAULT_LANGUAGE . "', timezone = '" . CO_DEFAULT_TIMEZONE . "', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	$id = mysql_insert_id();
			return $id;
		}
	}
	
	function newContactFromCalendar($lastname,$firstname,$phone,$email) {
		global $session,$lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "INSERT INTO " . CO_TBL_USERS . " set lastname = '$lastname', firstname = '$firstname', phone1 = '$phone', email = '$email', lang = '" . CO_DEFAULT_LANGUAGE . "', timezone = '" . CO_DEFAULT_TIMEZONE . "', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	$id = mysql_insert_id();
			return $id;
		}
	}


   	function duplicateContact($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "INSERT INTO " . CO_TBL_USERS . " (lastname, firstname, title, title2, company, position, email, email_alt, phone1, phone2, fax, address_line1, address_line2, address_town, address_postcode, address_country, lang, timezone, edited_user, edited_date, created_user, created_date) SELECT CONCAT('".$lang["GLOBAL_DUPLICAT"]." ',lastname),firstname, title, title2, company, position, email, email_alt, phone1, phone2, fax, address_line1, address_line2, address_town, address_postcode, address_country, lang, timezone, $session->uid as edited_user, '$now' as edited_date, $session->uid as created_user, '$now' as created_date FROM " . CO_TBL_USERS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		
		if ($result) {
			return $id_new;
		}
	}


	function binContact($id) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		// check for calendar
		$calendar = $this->_db->checkCalendar($id);
		if($calendar) { // update display name
			$this->removeCalendar($id);
		}
		
		$q = "UPDATE " . CO_TBL_USERS . " set bin = '1', bintime = '$now', binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}


	function restoreContact($id) {
		
		// check for calendar
		$calendar = $this->_db->checkCalendar($id);
		if($calendar) { // update display name
			$this->setCalendar($id);
		}
		
		$q = "UPDATE " . CO_TBL_USERS . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	function deleteContact($id) {
		
		// check for calendar
		$calendar = $this->_db->checkCalendar($id);
		if($calendar) { // update display name
			$this->deleteCalendar($id);
		}
		
		$q = "DELETE FROM " . CO_TBL_USER_SETTINGS . " WHERE uid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "SELECT avatar FROM " . CO_CONTACTS_TBL_AVATARS . " WHERE uid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$avatar = $row["avatar"];
			@unlink(CO_PATH_BASE.'/data/avatars/' . $avatar);
		}
		
		$q = "DELETE FROM " . CO_CONTACTS_TBL_AVATARS . " WHERE uid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_USERS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	
	function getUserFullname($id){
		$q = "SELECT id, firstname, lastname FROM ".CO_TBL_USERS." where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_assoc($result);
		$user = $row["lastname"] . ' ' . $row["firstname"];
		return $user;
	}
	
	function getUserFullnameShortFirstname($id){
		$q = "SELECT id, firstname, lastname FROM ".CO_TBL_USERS." where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_assoc($result);
		mb_internal_encoding("UTF-8");
		$user = $row["lastname"] . ' ' . mb_substr($row["firstname"], 0, 1) . '.';
		return $user;
	}
	
   /*function getContactsDialog($request,$field,$append,$title,$sql) {
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
	}*/
	
	function getLast10Contacts() {
		global $session;
		$contacts = $this->getUserArray($this->getUserSetting("last-used-contacts"));
	  return $contacts;
	}
	
	function saveLastUsedContacts($id) {
		global $session;
		$string = $id . "," .$this->getUserSetting("last-used-contacts");
		$string = rtrim($string, ",");
		$ids_arr = explode(",", $string);
		$res = array_unique($ids_arr);
		foreach ($res as $key => $value) {
			$ids_rtn[] = $value;
		}
		array_splice($ids_rtn, 7);
		$str = implode(",", $ids_rtn);
		
		$this->setUserSetting("last-used-contacts",$str);
	  return true;
	}
	
	function getLast10Groups() {
		global $session;
		$groups = $this->getGroupsArray($this->getUserSetting("last-used-groups"));
		return $groups;
	}
	
	function saveLastUsedGroups($id) {
		global $session;
		$string = $id . "," .$this->getUserSetting("last-used-groups");
		$string = rtrim($string, ",");
		$ids_arr = explode(",", $string);
		$res = array_unique($ids_arr);
		foreach ($res as $key => $value) {
			$ids_rtn[] = $value;
		}
		array_splice($ids_rtn, 7);
		$str = implode(",", $ids_rtn);
		
		$this->setUserSetting("last-used-groups",$str);
		return true;
	}
	
	function getLast10Places() {
		global $session;
		//$places = $this->getUserArray($this->getUserSetting("last-used-places"));
		$last = $this->getUserSetting("last-used-places");
		$places_string = explode(",", $last);
		$places_total = sizeof($places_string);
		$places = '';
		if($places_total == 0) { 
			return $places; 
		}
		// check if user is available and build array
		$places_arr = "";
		foreach ($places_string as &$value) {
			$q = "SELECT id, firstname, lastname, address_line1, address_postcode, address_town FROM ".CO_TBL_USERS." where id = '$value' and bin='0'";
			$result_user = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result_user) > 0) {
				while($row_user = mysql_fetch_assoc($result_user)) {
					$places_arr[] = array("id" => $row_user["id"], "name" => $row_user["lastname"] . ' ' . $row_user["firstname"], "address" => $row_user["address_line1"] . ', ' . $row_user["address_postcode"] . ' ' . $row_user["address_town"]);		
				}
			}
		}
	  return $places_arr;
	}
	
	function saveLastUsedPlaces($id) {
		global $session;
		$string = $id . "," .$this->getUserSetting("last-used-places");
		$string = rtrim($string, ",");
		$ids_arr = explode(",", $string);
		$res = array_unique($ids_arr);
		foreach ($res as $key => $value) {
			$ids_rtn[] = $value;
		}
		array_splice($ids_rtn, 7);
		$str = implode(",", $ids_rtn);
		
		$this->setUserSetting("last-used-places",$str);
	  return true;
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
	
	function getUserArray($string){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		
		if($users_total == 0) { 
			return $users; 
		}
		
		// check if user is available and build array
		$users_arr = "";
		foreach ($users_string as &$value) {
			$q = "SELECT id, firstname, lastname FROM ".CO_TBL_USERS." where id = '$value' and bin='0'";
			$result_user = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result_user) > 0) {
				while($row_user = mysql_fetch_assoc($result_user)) {
					$users_arr[] = array("id" => $row_user["id"], "name" => $row_user["lastname"] . ' ' . $row_user["firstname"]);		
				}
			}
		}

		return $users_arr;
}


	function getGroupsArray($string){
		$string = explode(",", $string);
		$total = sizeof($string);
		$arr = '';
		if($total == 0) { 
			return $arr; 
		}
		// check if group is available and build array
		foreach ($string as &$value) {
			$q = "SELECT id, title FROM ".CO_CONTACTS_TBL_GROUPS." where id = '$value' and members != '' and bin='0'";
			$result = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result) > 0) {
				while($row = mysql_fetch_assoc($result)) {
					$arr[] = array("id" => $row["id"], "title" => $row["title"]);		
				}
			}
		}
		return $arr;
	}
	
	
	function getUserList($string, $field, $sql="", $canedit = true){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		
		if($users_total == 0) { 
			return $users; 
		}
		
		// check if user is available and build array
		$users_arr = array();
		foreach ($users_string as &$value) {
			$q = "SELECT id, firstname, lastname FROM ".CO_TBL_USERS." where id = '$value' $sql and bin='0'";
			$result_user = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result_user) > 0) {
				while($row_user = mysql_fetch_assoc($result_user)) {
					$users_arr[$row_user["id"]] = $row_user["lastname"] . ' ' . $row_user["firstname"];		
				}
			}
		}
		$users_arr_total = sizeof($users_arr);
		
		// build string
		
		if($canedit) {
			$edit = ' edit="1"';
		} else {
			$edit = ' edit="0"';
		}
		$i = 1;
		foreach ($users_arr as $key => &$value) {
			$users .= '<span class="listmember-outer"><a class="listmember" uid="' . $key . '" field="' . $field . '" ' . $edit . '>' . $value;		
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
	
	function getUserListPlainDate($string){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		
		if($users_total == 0) { 
			return $users; 
		}
		
		// check if user is available and build array
		$users_arr = array();
		foreach ($users_string as &$value) {
			$value = explode(";", $value);
			$user = $value[0];
			$date = $this->_date->formatDate($value[1],CO_DATETIME_FORMAT);
			$q = "SELECT id, firstname, lastname FROM ".CO_TBL_USERS." where id = '$user'";
			$result_user = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result_user) > 0) {
				while($row_user = mysql_fetch_assoc($result_user)) {
					$users_arr[$row_user["id"]] = $row_user["lastname"] . ' ' . $row_user["firstname"] . ' '.$date;	
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


	function checkUserListEmail($string, $field, $sql="", $canedit = true, $withEmail = 1){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { 
			return $users; 
		}
		// check for users without an email address
		$users_arr = array();
		foreach ($users_string as &$value) {
			$q = "SELECT id, firstname, lastname, email FROM ".CO_TBL_USERS." where id = '$value' $sql and bin='0'";
			$result_user = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result_user) > 0) {
				while($row_user = mysql_fetch_assoc($result_user)) {
					if($withEmail == 1) {
					if($row_user["email"] != "") {
						$users_arr[$row_user["id"]] = $row_user["lastname"] . ' ' . $row_user["firstname"];	
					}
					} else {
					if($row_user["email"] == "") {
						$users_arr[$row_user["id"]] = $row_user["lastname"] . ' ' . $row_user["firstname"];	
					}
					}
				}
			}
		}
		$users_arr_total = sizeof($users_arr);
		
		// build string
		
		if($withEmail == 1) {
			if($canedit) {
			$edit = ' edit="1"';
		} else {
			$edit = ' edit="0"';
		}
		$i = 1;
		foreach ($users_arr as $key => &$value) {
			$users .= '<span class="listmember-outer"><a class="listmember" uid="' . $key . '" field="' . $field . '" ' . $edit . '>' . $value;		
			if($i < $users_arr_total) {
				$users .= ', ';
			}
			$users .= '</a></span>';	
			$i++;
		}
		} else {
		
		$i = 1;
		foreach ($users_arr as $key => &$value) {
			$users .= $value;		
			if($i < $users_arr_total) {
				$users .= ', ';
			}
			$i++;
		}
		}
		return $users;
	}

	function getPlaceList($string,$field,$canedit = true){
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
		if($canedit) {
			$edit = ' edit="1"';
		} else {
			$edit = ' edit="0"';
		}
		
		$i = 1;
		foreach ($users_arr as $key => &$value) {
			$users .= '<span class="listmember-outer"><a class="listmember" uid="' . $key . '" field="' . $field . '" ' . $edit . '>' . $value;		
			if($i < $users_arr_total) {
				$users .= ', ';
			}
			$users .= '</a></span>';	
			$i++;
		}
		return $users;
	}
	
	
	function getPlaceListPlain($string,$field,$canedit = true){
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
		if($canedit) {
			$edit = ' edit="1"';
		} else {
			$edit = ' edit="0"';
		}
		
		$i = 1;
		foreach ($users_arr as $key => &$value) {
			$users .= $value;			
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


	function getGroupsSearch($term){
		global $system;
		$num=0;
		$q = "SELECT id, title as label from " . CO_CONTACTS_TBL_GROUPS . " where title like '%$term%' and members != '' and bin ='0'";
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
		$q = "SELECT id, CONCAT(lastname, ' ',firstname,', ',address_line1, ', ', address_postcode, ' ', address_town) as label from " . CO_TBL_USERS . " where (lastname like '%$term%' or firstname like '%$term%' or address_line1 like '%$term%' or address_postcode like '%$term%' or address_town like '%$term%') and bin ='0' and invisible = '0'";
		$result = mysql_query($q, $this->_db->connection);
		$num=mysql_affected_rows();
		$rows = array();
		while($r = mysql_fetch_assoc($result)) {
			 $rows[] = $r;
		}
		return $system->json_encode($rows);
	}
	
	
	function binItem($id) {
		global $session;
		$q = "UPDATE " . CO_CONTACTS_TBL_AVATARS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' WHERE uid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if($result) {
			return true;
		}
	}
	
   function deleteItem($id) {
		global $session;#
		
		$q = "SELECT avatar FROM " . CO_CONTACTS_TBL_AVATARS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$avatar = $row["avatar"];
			@unlink(CO_PATH_BASE.'/data/avatars/' . $avatar);
		}
		
		$q = "DELETE FROM " . CO_CONTACTS_TBL_AVATARS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }
  
  
   function restoreItem($id) {
		global $session;
		
		$q = "SELECT uid FROM " . CO_CONTACTS_TBL_AVATARS . " WHERE id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$uid = mysql_result($result,0);
		
		// check for other active item and set to bin if found
		$q = "SELECT uid,id FROM " . CO_CONTACTS_TBL_AVATARS . " WHERE uid='$uid' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) >0) {
			$row = mysql_fetch_row($result);
			$aid = $row[1];
			$q = "UPDATE " . CO_CONTACTS_TBL_AVATARS . " SET bin='1' WHERE id='$aid'";
			$result = mysql_query($q, $this->_db->connection);
		}
		
		$q = "UPDATE " . CO_CONTACTS_TBL_AVATARS . " SET bin='0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
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
		
		$avatars = "";
		$q ="select a.id, a.avatar, b.firstname, b.lastname, a.bin, a.bintime, a.binuser from " . CO_CONTACTS_TBL_AVATARS . " as a, " . CO_TBL_USERS . " as b WHERE a.uid = b.id and a.bin='1' and b.bin !='1'";
		$result = mysql_query($q, $this->_db->connection);
	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$avatar[$key] = $val;
			}
			$avatar["bintime"] = $this->_date->formatDate($avatar["bintime"],CO_DATETIME_FORMAT);
			$avatar["binuser"] = $this->_users->getUserFullname($avatar["binuser"]);
			$avatars[] = new Lists($avatar);
	  	}
		
		$arr = array("bin" => $bin, "groups" => $groups, "contacts" => $contacts, "avatars" => $avatars);
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
		
		
		$avatars = "";
		$q ="select a.id, a.avatar, b.firstname, b.lastname, a.bin, a.bintime, a.binuser from " . CO_CONTACTS_TBL_AVATARS . " as a, " . CO_TBL_USERS . " as b WHERE a.uid = b.id and a.bin='1' and b.bin !='1'";
		$result = mysql_query($q, $this->_db->connection);
	  	while ($row = mysql_fetch_array($result)) {
			$id = $row["id"];
			$this->deleteItem($id);
	  	}
		
		$arr = array("bin" => $bin, "groups" => $groups, "contacts" => $contacts, "avatars" => $avatars);
		return $arr;
	}


	function getGlobalSearch($term){
		global $system;
		
		$rows = array();
		$r = array();
		
		$q = "SELECT id, CONCAT(lastname,' ',firstname) as label from " . CO_TBL_USERS . " where (lastname like '%$term%' or firstname like '%$term%' or company like '%$term%') and bin ='0' and invisible = '0' ORDER BY lastname, firstname ASC";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_assoc($result)) {
			 $rows['value'] = htmlspecialchars_decode($row['label']);
			 $rows['id'] = 'contact,' .$row['id'];
			 $r[] = $rows;
		}
		$q = "SELECT id, title as label from " . CO_CONTACTS_TBL_GROUPS . " where title like '%$term%' and members != '' and bin ='0'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_assoc($result)) {
			 $rows['value'] = htmlspecialchars_decode($row['label']);
			 $rows['id'] = 'group,' .$row['id'];
			 $r[] = $rows;
		}
		return json_encode($r);
	}
	
	function setCalendar($id) {
		// update userfield
		$q = "UPDATE co_users SET calendar='1' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		// check if a calendar exists for this user
		//$q = "SELECT * FROM oc_users WHERE couid='$id'";
		//$result = mysql_query($q, $this->_db->connection);
		$calendar = $this->_db->checkCalendar($id);
		if($calendar) {
			// reactivate
			$q = "SELECT * FROM co_users WHERE id='$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$username = $row['username'];
				$name = $row['lastname'] . ' ' . $row['firstname'];
				$uri = strtolower($row['firstname'].$row['lastname']);
			}
			// get calid
			$q = "SELECT id FROM oc_clndr_calendars WHERE userid = '$username'";
			$result = mysql_query($q, $this->_db->connection);
			$calid = mysql_result($result,0);
			// share calendar
			$q = "INSERT INTO oc_share SET share_type='1', share_with='coUsers', uid_owner='$username', item_type='calendar', item_source='$calid', item_target='$name', permissions='1'";
			$result = mysql_query($q, $this->_db->connection);
		} else {
			$q = "SELECT * FROM co_users WHERE id='$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$username = $row['username'];
				$password = $row['password'];
				$name = $row['lastname'] . ' ' . $row['firstname'];
				$uri = strtolower($row['firstname'].$row['lastname']);
			}
			
			// create OC user
			$q = "INSERT INTO oc_users SET uid='$username', couid='$id', password='$password'";
			$result = mysql_query($q, $this->_db->connection);
			
			// add to coUsers group
			$q = "INSERT INTO oc_group_user SET gid='coUsers', uid='$username'";
			$result = mysql_query($q, $this->_db->connection);
			
			// create calendar
			$q = "INSERT INTO oc_clndr_calendars SET userid='$username', displayname='$name', uri='$uri', active='1', calendarcolor='#E1F0AF', components='VEVENT,VTODO,VJOURNAL'";
			$result = mysql_query($q, $this->_db->connection);
			$calid = mysql_insert_id();
			
			// share calendar
			$q = "INSERT INTO oc_share SET share_type='1', share_with='coUsers', uid_owner='$username', item_type='calendar', item_source='$calid', item_target='$name', permissions='1'";
			$result = mysql_query($q, $this->_db->connection);
		} 

	}

	
	function removeCalendar($id) {
		// update userfield
		$q = "UPDATE co_users SET calendar='0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "SELECT * FROM co_users WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$username = $row['username'];
			}
			
		$q = "DELETE FROM oc_share WHERE uid_owner='$username'";
		$result = mysql_query($q, $this->_db->connection);
		
		// remove davcal user
		// remove calendar
		// remove calendar objects
		// remove share
	}
	
	
	function deleteCalendar($id) {
		$q = "SELECT uid FROM oc_users WHERE couid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$uid = mysql_result($result,0);
		
		$q = "SELECT id FROM oc_clndr_calendars WHERE userid='$uid'";
		$result = mysql_query($q, $this->_db->connection);
		$calid = mysql_result($result,0);
		
		
		// delete share
		$q = "DELETE FROM oc_share WHERE item_type='calendar' and item_source='$calid'";
		$result = mysql_query($q, $this->_db->connection);
		
		// delete events
		$q = "DELETE FROM oc_clndr_objects WHERE calendarid='$calid'";
		$result = mysql_query($q, $this->_db->connection);
		
		// delete calendar
		$q = "DELETE FROM oc_clndr_calendars WHERE id='$calid'";
		$result = mysql_query($q, $this->_db->connection);
		
		// delete from group
		$q = "DELETE FROM oc_group_user WHERE uid='$uid'";
		$result = mysql_query($q, $this->_db->connection);
		
		// delete user
		$q = "DELETE FROM oc_users WHERE couid='$id'";
		$result = mysql_query($q, $this->_db->connection);
	}

	
}

$contactsmodel = new ContactsModel();
?>
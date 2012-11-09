<?php
class BrainstormsModel extends Model {
	
	// Get all Brainstorm Folders
   function getFolderList($sort) {
      global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("brainstorms-folder-sort-status");
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
				  		$sortorder = $this->getSortOrder("brainstorms-folder-sort-order");
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
				  		$sortorder = $this->getSortOrder("brainstorms-folder-sort-order");
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
			$q ="select a.id, a.title from " . CO_TBL_BRAINSTORMS_FOLDERS . " as a where a.status='0' and a.bin = '0' and (SELECT count(*) FROM co_brainstorms_access as b, co_brainstorms as c WHERE (b.admins REGEXP '[[:<:]]" . $session->uid . "[[:>:]]' or b.guests REGEXP '[[:<:]]" . $session->uid . "[[:>:]]') and c.folder=a.id and b.pid=c.id) > 0 " . $order;
		} else {
			$q ="select a.id, a.title from " . CO_TBL_BRAINSTORMS_FOLDERS . " as a where a.status='0' and a.bin = '0' " . $order;
		}
		
	  $this->setSortStatus("brainstorms-folder-sort-status",$sortcur);
      $result = mysql_query($q, $this->_db->connection);
	  $folders = "";
	  while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
				if($key == "id") {
				$array["numBrainstorms"] = $this->getNumBrainstorms($val);
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
   * get details for the brainstorm folder
   */
   function getFolderDetails($id) {
		global $session, $contactsmodel, $brainstormsControllingModel;
		$q = "SELECT * FROM " . CO_TBL_BRAINSTORMS_FOLDERS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_assoc($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		/*$array["allbrainstorms"] = $this->getNumBrainstorms($id);
		$array["plannedbrainstorms"] = $this->getNumBrainstorms($id, $status="0");
		$array["activebrainstorms"] = $this->getNumBrainstorms($id, $status="1");
		$array["inactivebrainstorms"] = $this->getNumBrainstorms($id, $status="2");*/
		
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
		
		// get brainstorm details
		$access="";
		if(!$session->isSysadmin()) {
			$access = " and id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
	  	}
		
		 $sortstatus = $this->getSortStatus("brainstorms-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("brainstorms-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by title";
						  } else {
							$order = "order by field(id,$sortorder)";
						  }
				  break;	
			  }
		  }
		
		
		$q = "SELECT title, id, created_date, created_user FROM " . CO_TBL_BRAINSTORMS . " where folder='$id' and bin='0'" . $access . " " . $order;

		$result = mysql_query($q, $this->_db->connection);
	  	$brainstorms = "";
	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$brainstorm[$key] = $val;
			}
			
			$brainstorm["created_date"] = $this->_date->formatDate($brainstorm["created_date"],CO_DATE_FORMAT);
			$brainstorm["created_user"] = $this->_users->getUserFullname($brainstorm["created_user"]);
			$brainstorm["perm"] = $this->getBrainstormAccess($brainstorm["id"]);
			$brainstorms[] = new Lists($brainstorm);
	  	}
		
		
		$access = "guest";
		  if($session->isSysadmin()) {
			  $access = "sysadmin";
		  }
		
		$arr = array("folder" => $folder, "brainstorms" => $brainstorms, "access" => $access);
		return $arr;
   }


   /**
   * get details for the brainstorm folder
   */
   function setFolderDetails($id,$title,$brainstormstatus) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_FOLDERS . " set title = '$title', status = '$brainstormstatus', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }


   /**
   * create new brainstorm folder
   */
	function newFolder() {
		global $session, $lang;
		$now = gmdate("Y-m-d H:i:s");
		$title = $lang["BRAINSTORM_FOLDER_NEW"];
		
		$q = "INSERT INTO " . CO_TBL_BRAINSTORMS_FOLDERS . " set title = '$title', status = '0', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	$id = mysql_insert_id();
			return $id;
		}
	}


   /**
   * delete brainstorm folder
   */
   function binFolder($id) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_FOLDERS . " set bin = '1', bintime = '$now', binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   
   function restoreFolder($id) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_FOLDERS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deleteFolder($id) {
		$q = "SELECT id FROM " . CO_TBL_BRAINSTORMS . " where folder = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$pid = $row["id"];
			$this->deleteBrainstorm($pid);
		}
		
		$q = "DELETE FROM " . CO_TBL_BRAINSTORMS_FOLDERS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


  /**
   * get number of brainstorms for a brainstorm folder
   * status: 0 = all, 1 = active, 2 = abgeschlossen
   */   
   function getNumBrainstorms($id) {
		global $session;
		
		$access = "";
		 if(!$session->isSysadmin()) {
			$access = " and id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
		  }
		
		$q = "select id from " . CO_TBL_BRAINSTORMS . " where folder='$id' " . $access . " and bin != '1'";

		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_num_rows($result);
		return $row;
	}


	function getBrainstormTitle($id){
		global $session;
		$q = "SELECT title FROM " . CO_TBL_BRAINSTORMS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		return $title;
   }


   	function getBrainstormTitleFromIDs($array){
		//$string = explode(",", $string);
		$total = sizeof($array);
		$data = '';
		
		if($total == 0) { 
			return $data; 
		}
		
		// check if brainstorm is available and build array
		$arr = array();
		foreach ($array as &$value) {
			$q = "SELECT id,title FROM " . CO_TBL_BRAINSTORMS . " where id = '$value' and bin='0'";
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
   
   
	function getBrainstormTitleLinkFromIDs($array,$target){
		$total = sizeof($array);
		$data = '';
		if($total == 0) { 
			return $data; 
		}
		$arr = array();
		$i = 0;
		foreach ($array as &$value) {
			$q = "SELECT id,folder,title FROM " . CO_TBL_BRAINSTORMS . " where id = '$value' and bin='0'";
			$result = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result) > 0) {
				while($row = mysql_fetch_assoc($result)) {
					$arr[$i]["id"] = $row["id"];
					$arr[$i]["title"] = $row["title"];
					$arr[$i]["folder"] = $row["folder"];
					$i++;
				}
			}
		}
		$arr_total = sizeof($arr);
		$i = 1;
		foreach ($arr as $key => &$value) {
			$data .= '<a class="externalLoadThreeLevels" rel="' . $target. ','.$value["folder"].','.$value["id"].',1,brainstorms">' . $value["title"] . '</a>';
			if($i < $arr_total) {
				$data .= '<br />';
			}
			$data .= '';	
			$i++;
		}
		return $data;
   }



   	function getBrainstormField($id,$field){
		global $session;
		$q = "SELECT $field FROM " . CO_TBL_BRAINSTORMS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		return $title;
   }


  /**
   * get the list of brainstorms for a brainstorm folder
   */ 
   function getBrainstormList($id,$sort) {
      global $session;
	  
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("brainstorms-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("brainstorms-sort-order",$id);
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
				  		$sortorder = $this->getSortOrder("brainstorms-sort-order",$id);
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
	  $q ="select id,title,checked_out,checked_out_user from " . CO_TBL_BRAINSTORMS . " where folder='$id' and bin = '0' " . $access . $order;

	  $this->setSortStatus("brainstorms-sort-status",$sortcur,$id);
      $result = mysql_query($q, $this->_db->connection);
	  $brainstorms = "";
	  while ($row = mysql_fetch_array($result)) {
		foreach($row as $key => $val) {
			$array[$key] = $val;
			if($key == "id") {
				if($this->getBrainstormAccess($val) == "guest") {
					$array["access"] = "guest";
					$array["iconguest"] = ' icon-guest-active"';
					$array["checked_out_status"] = "";
				} else {
					$array["iconguest"] = '';
					$array["access"] = "";
				}
			}
			
		}
		
		$checked_out_status = "";
		if($array["access"] != "guest" && $array["checked_out"] == 1 && $array["checked_out_user"] != $session->uid) {
			if($session->checkUserActive($array["checked_out_user"])) {
				$checked_out_status = "icon-checked-out-active";
			} else {
				$this->checkinBrainstormOverride($id);
			}
		}
		$array["checked_out_status"] = $checked_out_status;
		
		$brainstorms[] = new Lists($array);
	  }
	  $arr = array("brainstorms" => $brainstorms, "sort" => $sortcur);
	  return $arr;
   }
	
	
	function checkoutBrainstorm($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_BRAINSTORMS . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function checkinBrainstorm($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_BRAINSTORMS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_BRAINSTORMS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}
	
	function checkinBrainstormOverride($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_BRAINSTORMS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	

   function getBrainstormDetails($id) {
		global $session, $contactsmodel, $lang;
		$q = "SELECT * FROM " . CO_TBL_BRAINSTORMS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		// perms
		$array["access"] = $this->getBrainstormAccess($id);

		if($array["access"] == "guest") {
			// check if this user is admin in some other brainstorm
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
					$array["canedit"] = $this->checkoutBrainstorm($id);
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
					$array["checked_out_user_phone1"] = $contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
					$array["checked_out_user_email"] = $contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");
				}
			} else {
				$array["canedit"] = $this->checkoutBrainstorm($id);
			}
		} // EOF perms
		
		// dates
		$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
		$array["today"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		
		// other functions
		$array["folder"] = $this->getBrainstormFolderDetails($array["folder"],"folder");
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		$array["current_user"] = $session->uid;
		
		$brainstorm = new Lists($array);
		
		$sql="";
		if($array["access"] == "guest") {
			$sql = " and a.access = '1' ";
		}
		$now = gmdate("Y-m-d H:i:s");
		// Notes
		$q = "select * from " . CO_TBL_BRAINSTORMS_NOTES . " where pid = '$id' and bin = '0'";
		
		$result = mysql_query($q, $this->_db->connection);
	  	$notes = "";
	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$note[$key] = $val;
			}
			
			$days = $this->_date->dateDiff($note['edited_date'],$now);
			switch($days) {
				case 0:
					$note["days"] = $lang["GLOBAL_TODAY"];
				break;
				case 1:
					$note["days"] = $lang["GLOBAL_YESTERDAY"];
				break;
				default:
				$note["days"] = sprintf($lang["GLOBAL_DAYS_AGO"], $days);
			}
			
			$note["date"] = $this->_date->formatDate($note['edited_date'],CO_DATETIME_FORMAT);
			
			// dates
			$note["created_date"] = $this->_date->formatDate($note["created_date"],CO_DATETIME_FORMAT);
			$note["edited_date"] = $this->_date->formatDate($note["edited_date"],CO_DATETIME_FORMAT);
			
			// other functions
			$note["created_user"] = $this->_users->getUserFullname($note["created_user"]);
			$note["edited_user"] = $this->_users->getUserFullname($note["edited_user"]);
			
			$notes[] = new Lists($note);
	  	}
		
		$arr = array("brainstorm" => $brainstorm, "notes" => $notes, "access" => $array["access"]);
		return $arr;
   }
   
   
   function getBrainstormPrintDetails($id) {
		global $session, $contactsmodel, $lang;
		$q = "SELECT * FROM " . CO_TBL_BRAINSTORMS . " where id = '$id'";
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
		$array["folder"] = $this->getBrainstormFolderDetails($array["folder"],"folder");
		
		
		// Notes
		$q = "select * from " . CO_TBL_BRAINSTORMS_NOTES . " where pid = '$id' and bin = '0'";
		
		$result = mysql_query($q, $this->_db->connection);
	  	$notes = array();
	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$note[$key] = $val;
			}
			$coord = explode('x',$note["xyz"]);
				$note['x'] = $coord[0];
				$note['y'] = $coord[1];
				$note['z'] = $coord[2];

					//list($width,$height) = explode('x',$val);
			$coord = explode('x',$note["wh"]);
					$note['w'] = $coord[0];
					$note['h'] = $coord[1];
					$height[] = $note['y']+$note['h'];
					$width[] = $note['x']+$note['w'];

			$notes[] = new Lists($note);
	  	}
		
		$array["css_height"] = max($height);
		$array["css_width"] = max($width);
		
		//$brainstorm = new Lists($array);
		
		$arr = array("brainstorm" => $array, "notes" => $notes);
		return $arr;
   }



   function getDates($id) {
		global $session, $contactsmodel;
		$q = "SELECT a.startdate,(SELECT MAX(enddate) FROM " . CO_TBL_BRAINSTORMS_PHASES_TASKS . " as b WHERE b.pid=a.id and b.bin = '0') as enddate FROM " . CO_TBL_BRAINSTORMS . " as a where id = '$id'";
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

		$brainstorm = new Lists($array);
		return $brainstorm;
	}


   // Create brainstorm folder title
	function getBrainstormFolderDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			$q = "SELECT id, title from " . CO_TBL_BRAINSTORMS_FOLDERS . " where id = '$value'";
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
   * get details for the brainstorm folder
   */
   function setBrainstormDetails($id,$title,$folder) {
		global $session, $contactsmodel;

		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_BRAINSTORMS . " set title = '$title', folder = '$folder', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}


	function newBrainstorm($id) {
		global $session, $contactsmodel, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		$title = $lang["BRAINSTORM_NEW"];
		
		$q = "INSERT INTO " . CO_TBL_BRAINSTORMS . " set folder = '$id', title = '$title', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			$id = mysql_insert_id();
			// if admin insert him to access
			if(!$session->isSysadmin()) {
				$brainstormsAccessModel = new BrainstormsAccessModel();
				$brainstormsAccessModel->setDetails($id,$session->uid,"");
			}
			return $id;
		}
	}
	
	
	function newBrainstormNote($id,$z) {
		global $session, $contactsmodel, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		$title = $lang["BRAINSTORM_NEW"];
		
		$q = "INSERT INTO " . CO_TBL_BRAINSTORMS_NOTES . " set pid = '$id', title = '" . $lang['BRAINSTORM_NOTE_NEW'] . "', xyz = '15x50x" . $z . "', wh = '200x200', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			$id = mysql_insert_id();
			return $id;
		}
	}


	function saveBrainstormNote($id,$title,$text) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_NOTES . " set title = '$title', text = '$text', edited_user = '$session->uid', edited_date = '$now' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	
	/*function binBrainstormNote($id) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_NOTES . " set bin = '1', bintime = '$now', binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }*/
  
  
	function deleteBrainstormNote($id) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		$q = "DELETE FROM " . CO_TBL_BRAINSTORMS_NOTES . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
    function restoreItem($id) {
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_NOTES . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
  
   	function deleteItem($id) {
		$q = "DELETE FROM " . CO_TBL_BRAINSTORMS_NOTES . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
	
	function updateNotePosition($id,$x,$y,$z) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_NOTES . " set xyz='".$x."x".$y."x".$z."' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}


	function updateNoteSize($id,$w,$h) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_NOTES . " set wh='".$w."x".$h."' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}


	/*function setBrainstormNoteToggle($id,$t) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_NOTES . " set toggle='$t' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}*/
	
	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		// brainstorm
		$q = "INSERT INTO " . CO_TBL_BRAINSTORMS . " (folder,title,created_date,created_user,edited_date,edited_user) SELECT folder,CONCAT(title,' ".$lang["GLOBAL_DUPLICAT"]."'),'$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_BRAINSTORMS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		
		if(!$session->isSysadmin()) {
			$brainstormsAccessModel = new BrainstormsAccessModel();
			$brainstormsAccessModel->setDetails($id_new,$session->uid,"");
		}
		// notes
		$q = "SELECT id,title,text,xyz,wh,toggle FROM " . CO_TBL_BRAINSTORMS_NOTES . " WHERE pid = '$id' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$noteid = $row["id"];
			$title = mysql_real_escape_string($row["title"]);
			$text = mysql_real_escape_string($row["text"]);
			$xyz = $row["xyz"];
			$wh = $row["wh"];
			$toggle = $row["toggle"];
			
			$qp = "INSERT INTO " . CO_TBL_BRAINSTORMS_NOTES . " set pid='$id_new',title='$title',text='$text',xyz='$xyz',wh='$wh',toggle='$toggle',created_date='$now',created_user='$session->uid',edited_date='$now',edited_user='$session->uid'";
			$rp = mysql_query($qp, $this->_db->connection);
			$id_p_new = mysql_insert_id();
		}		
		if ($result) {
			return $id_new;
		}
	}


	function binBrainstorm($id) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_BRAINSTORMS . " set bin = '1', bintime = '$now', binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	function restoreBrainstorm($id) {
		$q = "UPDATE " . CO_TBL_BRAINSTORMS . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	function deleteBrainstorm($id) {
		global $brainstorms;
		
		$active_modules = array();
		foreach($brainstorms->modules as $module => $value) {
			if(CONSTANT('brainstorms_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
			}
		}
		
		
		if(in_array("documents",$active_modules)) {
			$brainstormsDocumentsModel = new BrainstormsDocumentsModel();
			$q = "SELECT id FROM co_brainstorms_documents_folders where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$did = $row["id"];
				$brainstormsDocumentsModel->deleteDocument($did);
			}
		}
		
		if(in_array("meetings",$active_modules)) {
			$brainstormsMeetingsModel = new BrainstormsMeetingsModel();
			$q = "SELECT id FROM co_brainstorms_meetings where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$mid = $row["id"];
				$brainstormsMeetingsModel->deleteMeeting($mid);
			}
		}
		
		if(in_array("rosters",$active_modules)) {
			$brainstormsRostersModel = new BrainstormsRostersModel();
			$q = "SELECT id FROM co_brainstorms_rosters where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$mid = $row["id"];
				$brainstormsRostersModel->deleteRoster($mid);
			}
		}
		
		if(in_array("grids",$active_modules)) {
			$brainstormsGridsModel = new BrainstormsGridsModel();
			$q = "SELECT id FROM co_brainstorms_grids where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$mid = $row["id"];
				$brainstormsGridsModel->deleteGrid($mid);
			}
		}
		
		
		if(in_array("vdocs",$active_modules)) {
			$brainstormsVDocsmodel = new BrainstormsVDocsModel();
			$q = "SELECT id FROM co_brainstorms_vdocs where pid = '$id'";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				$vid = $row["id"];
				$brainstormsVDocsmodel->deleteVDoc($vid);
			}
		}
		
		
		$q = "DELETE FROM co_log_sendto WHERE what='brainstorms' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM co_brainstorms_access WHERE pid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM co_brainstorms_desktop WHERE pid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_BRAINSTORMS_NOTES . " WHERE pid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_BRAINSTORMS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
		  	return true;
		}
		
	}


   function moveBrainstorm($id,$startdate,$movedays) {
		global $session, $contactsmodel;
		
		$startdate = $this->_date->formatDate($_POST['startdate']);
		
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_BRAINSTORMS . " set startdate = '$startdate', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
			$qt = "SELECT id, startdate, enddate FROM " . CO_TBL_BRAINSTORMS_PHASES_TASKS . " where pid='$id'";
			$resultt = mysql_query($qt, $this->_db->connection);
			while ($rowt = mysql_fetch_array($resultt)) {
				$tid = $rowt["id"];
				$startdate = $this->_date->addDays($rowt["startdate"],$movedays);
				$enddate = $this->_date->addDays($rowt["enddate"],$movedays);
				$qtk = "UPDATE " . CO_TBL_BRAINSTORMS_PHASES_TASKS . " set startdate = '$startdate', enddate = '$enddate' where id='$tid'";
				$retvaltk = mysql_query($qtk, $this->_db->connection);
			}
		if ($result) {
			return true;
		}
	}


	function getBrainstormFolderDialog($field,$title) {
		global $session;
		$str = '<div class="dialog-text">';
		//$q ="select id, title from " . CO_TBL_BRAINSTORMS_FOLDERS . " where status='0' and bin = '0' ORDER BY title";
		if(!$session->isSysadmin()) {
			$q ="select a.id, a.title from " . CO_TBL_BRAINSTORMS_FOLDERS . " as a where a.status='0' and a.bin = '0' and (SELECT count(*) FROM co_brainstorms_access as b, co_brainstorms as c WHERE (b.admins REGEXP '[[:<:]]" . $session->uid . "[[:>:]]' or b.guests REGEXP '[[:<:]]" . $session->uid . "[[:>:]]') and c.folder=a.id and b.pid=c.id) > 0 ORDER BY title";
		} else {
			$q ="select id, title from " . CO_TBL_BRAINSTORMS_FOLDERS . " where status='0' and bin = '0' ORDER BY title";
		}
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$str .= '<a href="#" class="insertBrainstormFolderfromDialog" title="' . $row["title"] . '" field="'.$field.'" gid="'.$row["id"].'">' . $row["title"] . '</a>';
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
	   $q = "SELECT COUNT(id) FROM " .  CO_TBL_BRAINSTORMS_PHASES. " WHERE pid='$id' $sql and bin='0'";
	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function numPhasesOnTime($id) {
	   //$q = "SELECT COUNT(id) FROM " .  CO_TBL_BRAINSTORMS_PHASES. " WHERE pid='$id' $sql and bin='0'";
	   $q = "SELECT a.id,(SELECT MAX(enddate) FROM " . CO_TBL_BRAINSTORMS_PHASES_TASKS . " as b WHERE b.phaseid=a.id and b.bin='0') as enddate FROM " . CO_TBL_BRAINSTORMS_PHASES . " as a where a.pid= '$id' and a.status='2' and a.finished_date <= enddate";

	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function numPhasesTasks($id,$status = 0,$sql="") {
	   //$sql = "";
	   if ($status == 1) {
		   $sql .= " and status='1' ";
	   }
	   $q = "SELECT COUNT(id) FROM " .  CO_TBL_BRAINSTORMS_PHASES_TASKS. " WHERE pid='$id' $sql and bin='0'";
	   $result = mysql_query($q, $this->_db->connection);
	   $count = mysql_result($result,0);
	   return $count;
   }
   
   function getRest($value) {
		return round(100-$value,2);
   }


	function getChartFolder($id, $what) { 
		global $brainstormsControllingModel, $lang;
		switch($what) {
			case 'stability':
				$chart = $this->getChartFolder($id, 'timeing');
				$timeing = $chart["real"];
				
				$chart = $this->getChartFolder($id, 'tasks');
				$tasks = $chart["real"];
				
				$chart["real"] = round(($timeing+$tasks)/2,0);
				$chart["title"] = $lang["BRAINSTORM_FOLDER_CHART_STABILITY"];
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
				
				$q = "SELECT id FROM " . CO_TBL_BRAINSTORMS. " WHERE folder = '$id' and status != '0' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$num = mysql_num_rows($result);
				$i = 1;
				while($row = mysql_fetch_assoc($result)) {
					$pid = $row["id"];
					$calc = $brainstormsControllingModel->getChart($pid,'realisation',0);
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
				$qt = "SELECT MAX(donedate) as dt,enddate FROM " . CO_TBL_BRAINSTORMS_PHASES_TASKS. " WHERE status='1' $id_array and bin='0'";
				$resultt = mysql_query($qt, $this->_db->connection);
				$ten = mysql_fetch_assoc($resultt);
				if($ten["dt"] <= $ten["enddate"]) {
					$chart["tendency"] = "tendency_positive.png";
				}
				
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = $lang["BRAINSTORM_FOLDER_CHART_REALISATION"];
				$chart["img_name"] = $id . "_realisation.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
				
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
			break;
			

			case 'timeing':
				$realisation = 0;
				$id_array = "";
				
				$q = "SELECT id FROM " . CO_TBL_BRAINSTORMS. " WHERE folder = '$id' and status != '0' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$num = mysql_num_rows($result);
				$i = 1;
				while($row = mysql_fetch_assoc($result)) {
					$pid = $row["id"];
					$calc = $brainstormsControllingModel->getChart($pid,'timeing',0);
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
				$qt = "SELECT COUNT(id) FROM " . CO_TBL_BRAINSTORMS_PHASES_TASKS. " WHERE status='0' and startdate <= '$today' and enddate >= '$today' $id_array and bin='0'";
				$resultt = mysql_query($qt, $this->_db->connection);
				$tasks_active = mysql_result($resultt,0);
				
				$qo = "SELECT COUNT(id) FROM " . CO_TBL_BRAINSTORMS_PHASES_TASKS. " WHERE status='0' and enddate < '$today' $id_array and bin='0'";
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
				$chart["title"] = $lang["BRAINSTORM_FOLDER_CHART_ADHERANCE"];
				$chart["img_name"] = $id . "_timeing.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
			
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
			break;
			
			case 'tasks':
				$realisation = 0;
				$id_array = "";
				
				$q = "SELECT id FROM " . CO_TBL_BRAINSTORMS. " WHERE folder = '$id' and status != '0' and bin = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$num = mysql_num_rows($result);
				$i = 1;
				while($row = mysql_fetch_assoc($result)) {
					$pid = $row["id"];
					$calc = $brainstormsControllingModel->getChart($pid,'tasks',0);
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
				$qt = "SELECT status,donedate,enddate FROM " . CO_TBL_BRAINSTORMS_PHASES_TASKS. " WHERE enddate < '$today' $id_array and bin='0' ORDER BY enddate DESC LIMIT 0,1";
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
				$chart["title"] = $lang["BRAINSTORM_FOLDER_CHART_TASKS"];
				$chart["img_name"] = $id . "_tasks.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
			
				$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				
			break;
		}
		
		return $chart;
   }


   function getBin() {
		global $brainstorms;
		
		$bin = array();
		$bin["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		$arr = array();
		$arr["bin"] = $bin;
		
		$arr["folders"] = "";
		$arr["pros"] = "";
		$arr["brainstorms_tasks"] = "";
		$arr["files"] = "";
		$arr["tasks"] = "";
		
		$active_modules = array();
		foreach($brainstorms->modules as $module => $value) {
			if(CONSTANT('brainstorms_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
				$arr[$module . "_cols"] = "";
			}
		}
				
		$q ="select id, title, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS_FOLDERS;
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
				
				$qp ="select id, title, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS . " where folder = '$id'";
				$resultp = mysql_query($qp, $this->_db->connection);
				while ($rowp = mysql_fetch_array($resultp)) {
					$pid = $rowp["id"];
					if($rowp["bin"] == "1") { // deleted brainstorms
						foreach($rowp as $key => $val) {
							$pro[$key] = $val;
						}
						$pro["bintime"] = $this->_date->formatDate($pro["bintime"],CO_DATETIME_FORMAT);
						$pro["binuser"] = $this->_users->getUserFullname($pro["binuser"]);
						$pros[] = new Lists($pro);
						$arr["pros"] = $pros;
					} else {
						
						// brainstorm notes
						// remove in future .. in there for compatibility as notes get immediatly deleted
						$qt ="select id, title, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS_NOTES . " WHERE pid = '$pid'";
						$resultt = mysql_query($qt, $this->_db->connection);
						while ($rowt = mysql_fetch_array($resultt)) {
							if($rowt["bin"] == "1") { // deleted phases
								foreach($rowt as $key => $val) {
									$brainstorms_task[$key] = $val;
								}
								$brainstorms_task["bintime"] = $this->_date->formatDate($brainstorms_task["bintime"],CO_DATETIME_FORMAT);
								$brainstorms_task["binuser"] = $this->_users->getUserFullname($brainstorms_task["binuser"]);
								$brainstorms_tasks[] = new Lists($brainstorms_task);
								$arr["brainstorms_tasks"] = $brainstorms_tasks;
							} 
						}
					
						// rosters
						if(in_array("rosters",$active_modules)) {
							$qf ="select id, title, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS_ROSTERS . " where pid = '$pid'";
							$resultf = mysql_query($qf, $this->_db->connection);
							while ($rowf = mysql_fetch_array($resultf)) {
								$fid = $rowf["id"];
								if($rowf["bin"] == "1") { // deleted phases
									foreach($rowf as $key => $val) {
										$forum[$key] = $val;
									}
									$forum["bintime"] = $this->_date->formatDate($forum["bintime"],CO_DATETIME_FORMAT);
									$forum["binuser"] = $this->_users->getUserFullname($forum["binuser"]);
									$forums[] = new Lists($forum);
									$arr["rosters"] = $forums;
								} else {
									// columns
									
									$qc ="select id, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS_ROSTERS_COLUMNS . " where pid = '$fid'";
									$resultc = mysql_query($qc, $this->_db->connection);
									while ($rowc = mysql_fetch_array($resultc)) {
										$cid = $rowc["id"];
										if($rowc["bin"] == "1") { // deleted phases
											foreach($rowc as $key => $val) {
												$rosters_col[$key] = $val;
											}
											
											$items = '';
											$qn = "SELECT title FROM " . CO_TBL_BRAINSTORMS_ROSTERS_NOTES . " where cid = '$cid' and bin='0' ORDER BY sort";
											$resultn = mysql_query($qn, $this->_db->connection);
											while($rown = mysql_fetch_object($resultn)) {
												$items .= $rown->title . ', ';
													//$items_used[] = $rown->id;
											}
											$rosters_col["items"] = rtrim($items,", ");
											
											
											$rosters_col["bintime"] = $this->_date->formatDate($rosters_col["bintime"],CO_DATETIME_FORMAT);
											$rosters_col["binuser"] = $this->_users->getUserFullname($rosters_col["binuser"]);
											$rosters_cols[] = new Lists($rosters_col);
											$arr["rosters_cols"] = $rosters_cols;
										} else {
											// notes
											$qt ="select id, title, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS_ROSTERS_NOTES . " WHERE cid = '$cid' ORDER BY sort";
											$resultt = mysql_query($qt, $this->_db->connection);
											while ($rowt = mysql_fetch_array($resultt)) {
												if($rowt["bin"] == "1") { // deleted phases
													foreach($rowt as $key => $val) {
														$rosters_task[$key] = $val;
													}
													$rosters_task["bintime"] = $this->_date->formatDate($rosters_task["bintime"],CO_DATETIME_FORMAT);
													$rosters_task["binuser"] = $this->_users->getUserFullname($rosters_task["binuser"]);
													$rosters_tasks[] = new Lists($rosters_task);
													$arr["rosters_tasks"] = $rosters_tasks;
												} 
											}
										}
									}
								}
							}
						}
						
						
						// grids
						if(in_array("grids",$active_modules)) {
							$qf ="select id, title, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS_GRIDS . " where pid = '$pid'";
							$resultf = mysql_query($qf, $this->_db->connection);
							while ($rowf = mysql_fetch_array($resultf)) {
								$fid = $rowf["id"];
								if($rowf["bin"] == "1") { // deleted phases
									foreach($rowf as $key => $val) {
										$forum[$key] = $val;
									}
									$forum["bintime"] = $this->_date->formatDate($forum["bintime"],CO_DATETIME_FORMAT);
									$forum["binuser"] = $this->_users->getUserFullname($forum["binuser"]);
									$forums[] = new Lists($forum);
									$arr["grids"] = $forums;
								} else {
									// columns
									
									$qc ="select id, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS_GRIDS_COLUMNS . " where pid = '$fid'";
									$resultc = mysql_query($qc, $this->_db->connection);
									while ($rowc = mysql_fetch_array($resultc)) {
										$cid = $rowc["id"];
										if($rowc["bin"] == "1") { // deleted phases
											foreach($rowc as $key => $val) {
												$grids_col[$key] = $val;
											}
											
											$items = '';
											$qn = "SELECT title FROM " . CO_TBL_BRAINSTORMS_GRIDS_NOTES . " where cid = '$cid' and bin='0' ORDER BY sort";
											$resultn = mysql_query($qn, $this->_db->connection);
											while($rown = mysql_fetch_object($resultn)) {
												$items .= $rown->title . ', ';
													//$items_used[] = $rown->id;
											}
											$grids_col["items"] = rtrim($items,", ");
											
											
											$grids_col["bintime"] = $this->_date->formatDate($grids_col["bintime"],CO_DATETIME_FORMAT);
											$grids_col["binuser"] = $this->_users->getUserFullname($grids_col["binuser"]);
											$grids_cols[] = new Lists($grids_col);
											$arr["grids_cols"] = $grids_cols;
										} else {
											// notes
											$qt ="select id, title, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS_GRIDS_NOTES . " WHERE cid = '$cid' ORDER BY sort";
											$resultt = mysql_query($qt, $this->_db->connection);
											while ($rowt = mysql_fetch_array($resultt)) {
												if($rowt["bin"] == "1") { // deleted phases
													foreach($rowt as $key => $val) {
														$grids_task[$key] = $val;
													}
													$grids_task["bintime"] = $this->_date->formatDate($grids_task["bintime"],CO_DATETIME_FORMAT);
													$grids_task["binuser"] = $this->_users->getUserFullname($grids_task["binuser"]);
													$grids_tasks[] = new Lists($grids_task);
													$arr["grids_tasks"] = $grids_tasks;
												} 
											}
										}
									}
								}
							}
						}		
	
	
						// meetings
						if(in_array("meetings",$active_modules)) {
							$qm ="select id, title, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS_MEETINGS . " where pid = '$pid'";
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
									$qmt ="select id, title, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS_MEETINGS_TASKS . " where mid = '$mid'";
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
							
	
						// documents_folder
						if(in_array("documents",$active_modules)) {
							$qd ="select id, title, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS_DOCUMENTS_FOLDERS . " where pid = '$pid'";
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
									$qf ="select id, filename, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS_DOCUMENTS . " where did = '$did'";
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
							$qv ="select id, title, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS_VDOCS . " where pid = '$pid' and bin='1'";
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
		global $brainstorms;
		
		$bin = array();
		$bin["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		$arr = array();
		$arr["bin"] = $bin;
		
		$arr["folders"] = "";
		$arr["pros"] = "";
		$arr["brainstorms_tasks"] = "";
		$arr["files"] = "";
		$arr["tasks"] = "";
		
		$active_modules = array();
		foreach($brainstorms->modules as $module => $value) {
			if(CONSTANT('brainstorms_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
				$arr[$module . "_cols"] = "";
			}
		}
		
		$q ="select id, title, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS_FOLDERS;
		$result = mysql_query($q, $this->_db->connection);
	  	while ($row = mysql_fetch_array($result)) {
			$id = $row["id"];
			if($row["bin"] == "1") { // deleted folders
				$this->deleteFolder($id);
			} else { // folder not binned
				
				$qp ="select id, title, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS . " where folder = '$id'";
				$resultp = mysql_query($qp, $this->_db->connection);
				while ($rowp = mysql_fetch_array($resultp)) {
					$pid = $rowp["id"];
					if($rowp["bin"] == "1") { // deleted brainstorms
						$this->deleteBrainstorm($pid);
					} else {
					
					
					// brainstorm notes
					// remove in future .. in there for compatibility as notes get immediatly deleted
					$qt ="select id, title, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS_NOTES . " WHERE pid = '$pid'";
					$resultt = mysql_query($qt, $this->_db->connection);
					while ($rowt = mysql_fetch_array($resultt)) {
						$tid = $rowt["id"];
						if($rowt["bin"] == "1") { // deleted phases
							$this->deleteItem($tid);
							$arr["brainstorms_tasks"] = "";
						} 
					}
					
					
					// rosters
					if(in_array("rosters",$active_modules)) {
						$brainstormsRostersModel = new BrainstormsRostersModel();
						$qf ="select id, title, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS_ROSTERS . " where pid = '$pid'";
						$resultf = mysql_query($qf, $this->_db->connection);
						while ($rowf = mysql_fetch_array($resultf)) {
							$fid = $rowf["id"];
							if($rowf["bin"] == "1") { // deleted phases
								$brainstormsRostersModel->deleteRoster($fid);
								$arr["rosters"] = "";
							} else {
								// columns
								
								$qc ="select id,bin from " . CO_TBL_BRAINSTORMS_ROSTERS_COLUMNS . " where pid = '$fid'";
								$resultc = mysql_query($qc, $this->_db->connection);
								while ($rowc = mysql_fetch_array($resultc)) {
									$cid = $rowc["id"];
									if($rowc["bin"] == "1") { // deleted phases
										$brainstormsRostersModel->deleteRosterColumn($cid);
										$arr["rosters_cols"] = "";
									} else {
										// notes
										$qt ="select id,bin from " . CO_TBL_BRAINSTORMS_ROSTERS_NOTES . " where cid = '$cid'";
										$resultt = mysql_query($qt, $this->_db->connection);
										while ($rowt = mysql_fetch_array($resultt)) {
											if($rowt["bin"] == "1") { // deleted phases
												$tid = $rowt["id"];
												$brainstormsRostersModel->deleteRosterTask($tid);
												$arr["rosters_tasks"] = "";
											} 
										}
									}
								}
							}
						}
					}
						
					// grids
					if(in_array("grids",$active_modules)) {
						$brainstormsGridsModel = new BrainstormsGridsModel();
						$qf ="select id, title, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS_GRIDS . " where pid = '$pid'";
						$resultf = mysql_query($qf, $this->_db->connection);
						while ($rowf = mysql_fetch_array($resultf)) {
							$fid = $rowf["id"];
							if($rowf["bin"] == "1") { // deleted phases
								$brainstormsGridsModel->deleteGrid($fid);
								$arr["grids"] = "";
							} else {
								// columns
								
								$qc ="select id,bin from " . CO_TBL_BRAINSTORMS_GRIDS_COLUMNS . " where pid = '$fid'";
								$resultc = mysql_query($qc, $this->_db->connection);
								while ($rowc = mysql_fetch_array($resultc)) {
									$cid = $rowc["id"];
									if($rowc["bin"] == "1") { // deleted phases
										$brainstormsGridsModel->deleteGridColumn($cid);
										$arr["grids_cols"] = "";
									} else {
										// notes
										$qt ="select id,bin from " . CO_TBL_BRAINSTORMS_GRIDS_NOTES . " where cid = '$cid'";
										$resultt = mysql_query($qt, $this->_db->connection);
										while ($rowt = mysql_fetch_array($resultt)) {
											if($rowt["bin"] == "1") { // deleted phases
												$tid = $rowt["id"];
												$brainstormsGridsModel->deleteGridTask($tid);
												$arr["grids_tasks"] = "";
											} 
										}
									}
								}
							}
						}
					}

						// meetings
						if(in_array("meetings",$active_modules)) {
							$brainstormsMeetingsModel = new BrainstormsMeetingsModel();
							$qm ="select id, title, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS_MEETINGS . " where pid = '$pid'";
							$resultm = mysql_query($qm, $this->_db->connection);
							while ($rowm = mysql_fetch_array($resultm)) {
								$mid = $rowm["id"];
								if($rowm["bin"] == "1") { // deleted meeting
									$brainstormsMeetingsModel->deleteMeeting($mid);
									$arr["meetings"] = "";
								} else {
									// meetings_tasks
									$qmt ="select id, title, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS_MEETINGS_TASKS . " where mid = '$mid'";
									$resultmt = mysql_query($qmt, $this->_db->connection);
									while ($rowmt = mysql_fetch_array($resultmt)) {
										if($rowmt["bin"] == "1") { // deleted phases
											$mtid = $rowmt["id"];
											$brainstormsMeetingsModel->deleteMeetingTask($mtid);
											$arr["meetings_tasks"] = "";
										}
									}
								}
							}
						}


						// documents_folder
						if(in_array("documents",$active_modules)) {
							$brainstormsDocumentsModel = new BrainstormsDocumentsModel();
							$qd ="select id, title, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS_DOCUMENTS_FOLDERS . " where pid = '$pid'";
							$resultd = mysql_query($qd, $this->_db->connection);
							while ($rowd = mysql_fetch_array($resultd)) {
								$did = $rowd["id"];
								if($rowd["bin"] == "1") { // deleted meeting
									$brainstormsDocumentsModel->deleteDocument($did);
									$arr["documents_folders"] = "";
								} else {
									// files
									$qf ="select id, filename, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS_DOCUMENTS . " where did = '$did'";
									$resultf = mysql_query($qf, $this->_db->connection);
									while ($rowf = mysql_fetch_array($resultf)) {
										if($rowf["bin"] == "1") { // deleted phases
											$fid = $rowf["id"];
											$brainstormsDocumentsModel->deleteFile($fid);
											$arr["files"] = "";
										}
									}
								}
							}
						}
	
	
						// vdocs
						if(in_array("vdocs",$active_modules)) {
							$brainstormsVDocsModel = new BrainstormsVDocsModel();
							$qv ="select id, title, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS_VDOCS . " where pid = '$pid'";
							$resultv = mysql_query($qv, $this->_db->connection);
							while ($rowv = mysql_fetch_array($resultv)) {
								$vid = $rowv["id"];
								if($rowv["bin"] == "1") {
									$brainstormsVDocsModel->deleteVDoc($vid);
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
		$q = "SELECT a.pid FROM co_brainstorms_access as a, co_brainstorms as b WHERE a.pid=b.id and b.bin='0' and a.admins REGEXP '[[:<:]]" . $id . "[[:>:]]' ORDER by b.title ASC";
      	$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$perms[] = $row["pid"];
		}
		return $perms;
   }


   function getViewPerms($id) {
		global $session;
		$perms = array();
		$q = "SELECT a.pid FROM co_brainstorms_access as a, co_brainstorms as b WHERE a.pid=b.id and b.bin='0' and a.guests REGEXP '[[:<:]]" . $id. "[[:>:]]' ORDER by b.title ASC";
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


   function getBrainstormAccess($pid) {
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
	   	$q = "SELECT id FROM co_brainstorms where id = '$id' and created_user ='$uid'";
      	$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			return true;
		} else {
			return false;
		}
   }*/
   
   /*function isBrainstormOwner($uid) {
	   	$q = "SELECT id FROM co_brainstorms where created_user = '$uid'";
      	$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			return true;
		} else {
			return false;
		}
   }*/
   
   
     function existUserBrainstormsWidgets() {
		global $session;
		$q = "select count(*) as num from " . CO_TBL_BRAINSTORMS_DESKTOP_SETTINGS . " where uid='$session->uid'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_assoc($result);
		if($row["num"] < 1) {
			return false;
		} else {
			return true;
		}
	}
	
	
	function getUserBrainstormsWidgets() {
		global $session;
		$q = "select * from " . CO_TBL_BRAINSTORMS_DESKTOP_SETTINGS . " where uid='$session->uid'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_assoc($result);
		return $row;
	}


   function getWidgetAlerts() {
		global $session, $date;
	  	
		$now = new DateTime("now");
		$today = $date->formatDate("now","Y-m-d");
		$tomorrow = $date->addDays($today, 1);
		$string = "";
		
		// brainstorms notices for this user
		$q ="select a.id as pid,a.folder,a.title as brainstormtitle,b.perm from " . CO_TBL_BRAINSTORMS . " as a,  " . CO_TBL_BRAINSTORMS_DESKTOP . " as b where a.id = b.pid and a.bin = '0' and b.uid = '$session->uid' and b.status = '0'";
		$result = mysql_query($q, $this->_db->connection);
		$notices = "";
		$array = "";
		while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			$string .= $array["folder"] . "," . $array["pid"] . ",";
			$notices[] = new Lists($array);
		}
		

		if(!$this->existUserBrainstormsWidgets()) {
			$q = "insert into " . CO_TBL_BRAINSTORMS_DESKTOP_SETTINGS . " set uid='$session->uid', value='$string'";
			$result = mysql_query($q, $this->_db->connection);
			$widgetaction = "open";
		} else {
			$row = $this->getUserBrainstormsWidgets();
			$id = $row["id"];
			if($string == $row["value"]) {
				$widgetaction = "";
			} else {
				$widgetaction = "open";
			}
			$q = "UPDATE " . CO_TBL_BRAINSTORMS_DESKTOP_SETTINGS . " set value='$string' WHERE id = '$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		
		$arr = array("notices" => $notices, "widgetaction" => $widgetaction);
		return $arr;
   }

   
	function markNoticeRead($pid) {
		global $session, $date;
		
		$q ="UPDATE " . CO_TBL_BRAINSTORMS_DESKTOP . " SET status = '1' WHERE uid = '$session->uid' and pid = '$pid'";
		$result = mysql_query($q, $this->_db->connection);
		return true;

	}

  
	function getNavModulesNumItems($id) {
		global $brainstorms;
		$active_modules = array();
		foreach($brainstorms->modules as $module => $value) {
			$active_modules[] = $module;
		}
		if(in_array("rosters",$active_modules)) {
			$brainstormsRostersModel = new BrainstormsRostersModel();
			$data["brainstorms_rosters_items"] = $brainstormsRostersModel->getNavNumItems($id);
		}
		if(in_array("grids",$active_modules)) {
			$brainstormsGridsModel = new BrainstormsGridsModel();
			$data["brainstorms_grids_items"] = $brainstormsGridsModel->getNavNumItems($id);
		}
		if(in_array("meetings",$active_modules)) {
			$brainstormsMeetingsModel = new BrainstormsMeetingsModel();
			$data["brainstorms_meetings_items"] = $brainstormsMeetingsModel->getNavNumItems($id);
		}
		if(in_array("documents",$active_modules)) {
			$brainstormsDocumentsModel = new BrainstormsDocumentsModel();
			$data["brainstorms_documents_items"] = $brainstormsDocumentsModel->getNavNumItems($id);
		}
		if(in_array("vdocs",$active_modules)) {
			$brainstormsVDocsModel = new BrainstormsVDocsModel();
			$data["brainstorms_vdocs_items"] = $brainstormsVDocsModel->getNavNumItems($id);
		}
		return $data;
	}


    function getCheckpointDetails($app,$module,$id){
		global $lang, $session, $brainstorms;
		$row = "";
		if($app =='brainstorms' && $module == 'brainstorms') {
			$q = "SELECT title,folder FROM " . CO_TBL_BRAINSTORMS . " WHERE id='$id' and bin='0'";
			$result = mysql_query($q, $this->_db->connection);
			$row = mysql_fetch_array($result);
			if(mysql_num_rows($result) > 0) {
				$row['checkpoint_app_name'] = $lang["BRAINSTORM_TITLE"];
				$row['app_id_app'] = '0';
			}
			return $row;
		} else {
			$active_modules = array();
			foreach($brainstorms->modules as $m => $v) {
					$active_modules[] = $m;
			}
			if($module == 'meetings' && in_array("meetings",$active_modules)) {
				include_once("modules/".$module."/config.php");
				include_once("modules/".$module."/lang/" . $session->userlang . ".php");
				include_once("modules/".$module."/model.php");
				$brainstormsMeetingsModel = new BrainstormsMeetingsModel();
				$row = $brainstormsMeetingsModel->getCheckpointDetails($id);
				return $row;
			}
		}
   }
   
   
	function getGlobalSearch($term){
		global $system, $session, $brainstorms;
		$num=0;
		//$term = utf8_decode($term);
		$access=" ";
		if(!$session->isSysadmin()) {
			$access = " and id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
	  	}
		$rows = array();
		$r = array();
		
		// get all active modules
		$active_modules = array();
		foreach($brainstorms->modules as $m => $v) {
			$active_modules[] = $m;
		}
		

		$q = "SELECT id, folder, CONVERT(title USING latin1) as title FROM " . CO_TBL_BRAINSTORMS . " WHERE title like '%$term%' and  bin='0'" . $access ."ORDER BY title";
		$result = mysql_query($q, $this->_db->connection);
		//$num=mysql_affected_rows();
		while($row = mysql_fetch_array($result)) {
			 $rows['value'] = htmlspecialchars_decode($row['title']);
			 $rows['id'] = 'brainstorms,' .$row['folder']. ',' . $row['id'] . ',0,brainstorms';
			 $r[] = $rows;
		}
		
		// loop through projects
		$q = "SELECT id, folder FROM " . CO_TBL_BRAINSTORMS . " WHERE bin='0'" . $access ."ORDER BY title";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$pid = $row['id'];
			$folder = $row['folder'];
			$sql = "";
			$perm = $this->getBrainstormAccess($pid);
			if($perm == 'guest') {
				$sql = "and access = '1'";
			}
			// Notes
			$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_BRAINSTORMS_NOTES . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
			$resultp = mysql_query($qp, $this->_db->connection);
			while($rowp = mysql_fetch_array($resultp)) {
				$rows['value'] = htmlspecialchars_decode($rowp['title']);
			 	$rows['id'] = 'brainstorms,' .$folder. ',' . $pid . ',0,brainstorms';
			 	$r[] = $rows;
			}
			// Grids
			$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_BRAINSTORMS_GRIDS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
			$resultp = mysql_query($qp, $this->_db->connection);
			while($rowp = mysql_fetch_array($resultp)) {
				$rows['value'] = htmlspecialchars_decode($rowp['title']);
			 	$rows['id'] = 'grids,' .$folder. ',' . $pid . ',' .$rowp['id'].',brainstorms';
			 	$r[] = $rows;
			}
			// Meetings
			if(in_array("meetings",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_BRAINSTORMS_MEETINGS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'meetings,' .$folder. ',' . $pid . ',' .$rowp['id'].',brainstorms';
					$r[] = $rows;
				}
				// Meeting Tasks
				$qp = "SELECT b.id,CONVERT(a.title USING latin1) as title FROM " . CO_TBL_BRAINSTORMS_MEETINGS_TASKS . " as a, " . CO_TBL_BRAINSTORMS_MEETINGS . " as b WHERE b.pid = '$pid' and a.mid = b.id and a.bin = '0' and b.bin = '0' $sql and a.title like '%$term%' ORDER BY a.title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'meetings,' .$folder. ',' . $pid . ',' .$rowp['id'].',brainstorms';
					$r[] = $rows;
				}
			}
			// Doc Folders
			if(in_array("documents",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_BRAINSTORMS_DOCUMENTS_FOLDERS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'documents,' .$folder. ',' . $pid . ',' .$rowp['id'].',brainstorms';
					$r[] = $rows;
				}
				// Documents
				$qp = "SELECT b.id,CONVERT(a.filename USING latin1) as title FROM " . CO_TBL_BRAINSTORMS_DOCUMENTS . " as a, " . CO_TBL_BRAINSTORMS_DOCUMENTS_FOLDERS . " as b WHERE b.pid = '$pid' and a.did = b.id and a.bin = '0' and b.bin = '0' $sql and a.filename like '%$term%' ORDER BY a.filename";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'documents,' .$folder. ',' . $pid . ',' .$rowp['id'].',brainstorms';
					$r[] = $rows;
				}
			}
			// vDocs
			if(in_array("vdocs",$active_modules)) {
				$qp = "SELECT id,CONVERT(title USING latin1) as title FROM " . CO_TBL_BRAINSTORMS_VDOCS . " WHERE pid = '$pid' and bin = '0' $sql and title like '%$term%' ORDER BY title";
				$resultp = mysql_query($qp, $this->_db->connection);
				while($rowp = mysql_fetch_array($resultp)) {
					$rows['value'] = htmlspecialchars_decode($rowp['title']);
					$rows['id'] = 'vdocs,' .$folder. ',' . $pid . ',' .$rowp['id'].',brainstorms';
					$r[] = $rows;
				}
			}
		}
		return json_encode($r);
	}
	
}

$brainstormsmodel = new BrainstormsModel(); // needed for direct calls to functions eg echo $brainstormsmodel ->getBrainstormTitle(1);
?>
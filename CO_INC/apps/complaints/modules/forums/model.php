<?php

class ComplaintsForumsModel extends ComplaintsModel {
	
	public function __construct() {  
     	parent::__construct();
		//$this->_phases = new ComplaintsPhasesModel();
		$this->_contactsmodel = new ContactsModel();
	}


	function getList($id,$sort) {
		global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("complaints-forums-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("complaints-forums-sort-order",$id);
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
				  		$sortorder = $this->getSortOrder("complaints-forums-sort-order",$id);
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
	  
	  
		$perm = $this->getComplaintAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		
		$q = "select id,title,access,status from " . CO_TBL_COMPLAINTS_FORUMS . " where pid = '$id' and bin != '1' " . $sql . $order;
		$this->setSortStatus("complaints-forums-sort-status",$sortcur,$id);
		$result = mysql_query($q, $this->_db->connection);
		$items = mysql_num_rows($result);
		
		$forums = "";
		while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			
			// dates
			//$array["item_date"] = $this->_date->formatDate($array["item_date"],CO_DATE_FORMAT);
			
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
			if($array["status"] == 3) {
				$itemstatus = " module-item-active-stopped";
			}
			$array["itemstatus"] = $itemstatus;
			
			/*$checked_out_status = "";
			if($perm !=  "guest" && $array["checked_out"] == 1 && $array["checked_out_user"] != $session->uid) {
				if($session->checkUserActive($array["checked_out_user"])) {
					$checked_out_status = "icon-checked-out-active";
				} else {
					$this->checkinForumOverride($id);
				}
			}
			$array["checked_out_status"] = $checked_out_status;*/
			
			
			$forums[] = new Lists($array);
	  }
		
	  $arr = array("forums" => $forums, "items" => $items, "sort" => $sortcur, "perm" => $perm);
	  return $arr;
	}
	
	
	function getNavNumItems($id) {
		$perm = $this->getComplaintAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		$q = "select count(*) as items from " . CO_TBL_COMPLAINTS_FORUMS . " where pid = '$id' and bin != '1' " . $sql;
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		$items = $row['items'];
		/*if($items == 0) {
			$items = "";
		}*/
		return $items;
	}
	
	
	function checkoutForum($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_COMPLAINTS_FORUMS . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function checkinForum($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_COMPLAINTS_FORUMS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_COMPLAINTS_FORUMS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}
	
	function checkinForumOverride($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_COMPLAINTS_FORUMS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	

	function getDetails($id) {
		global $session, $lang;
		
		$this->_documents = new ComplaintsDocumentsModel();
		
		$q = "SELECT * FROM " . CO_TBL_COMPLAINTS_FORUMS . " where id = '$id'";
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
		//$array["checked_out_user_text"] = $this->_contactsmodel->getUserListPlain($array['checked_out_user']);

		if($array["perms"] == "sysadmin" || $array["perms"] == "admin") {
			$array["canedit"] = true;
			/*if($array["checked_out"] == 1) {
				if($array["checked_out_user"] == $session->uid) {
					$array["canedit"] = true;
				} else if(!$session->checkUserActive($array["checked_out_user"])) {
					$array["canedit"] = $this->checkoutForum($id);
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
		$array["checked_out_user_phone1"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
		$array["checked_out_user_email"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");

				}
			} else {
				$array["canedit"] = $this->checkoutForum($id);
			}*/
		}
		
		// dates
		$array["today"] = $this->_date->formatDate("now",CO_DATE_FORMAT);
		$array["planned_date"] = $this->_date->formatDate($array["planned_date"],CO_DATE_FORMAT);
		$array["inprogress_date"] = $this->_date->formatDate($array["inprogress_date"],CO_DATE_FORMAT);
		$array["finished_date"] = $this->_date->formatDate($array["finished_date"],CO_DATE_FORMAT);
		$array["stopped_date"] = $this->_date->formatDate($array["stopped_date"],CO_DATE_FORMAT);

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
		
		// status
		$array["startdate"] = "";
		$array["enddate"] = "";
		switch($array["status"]) {
			case "0":
				$array["status_text"] = $lang["FORUM_STATUS_PLANNED"];
				$array["status_date"] = $array["planned_date"];
				$array["startdate"] = $array["planned_date"];
			break;
			case "1":
				$array["status_text"] = $lang["FORUM_STATUS_INPROGRESS"];
				$array["status_date"] = $array["inprogress_date"];
				$array["startdate"] = $array["inprogress_date"];
			break;
			case "2":
				$array["status_text"] = $lang["FORUM_STATUS_FINISHED"];
				$array["status_date"] = $array["finished_date"];
				$array["startdate"] = $array["inprogress_date"];
				$array["enddate"] = $array["finished_date"];
			break;
			case "3":
				$array["status_text"] = $lang["FORUM_STATUS_STOPPED"];
				$array["status_date"] = $array["stopped_date"];
				$array["startdate"] = $array["inprogress_date"];
				$array["enddate"] = $array["stopped_date"];
			break;
		}
		$forum = new Lists($array);
		
		$post= array();
		$answer= array();

			$qt = "SELECT * FROM " . CO_TBL_COMPLAINTS_FORUMS_POSTS . " where pid = '$id' and bin='0' ORDER BY id";
			$resultt = mysql_query($qt, $this->_db->connection);
			$num = 1;
			while($rowt = mysql_fetch_array($resultt)) {
				foreach($rowt as $key => $val) {
					$posts[$key] = $val;
					if ($key == "id") {
						$postid = $val;
					}
				}
				
				$posts["avatar"] = $this->_users->getAvatar($posts["user"]);
				$posts["user"] = $this->_users->getUserFullname($posts["user"]);
				
				$posts["datetime"] = $this->_date->formatDate($posts["datetime"],CO_DATETIME_FORMAT);
				$posts["children"] = array();
				
				if($posts["status"] == 1) {
					$answer[] = new Lists($posts);
				}
				$posts["num"] = $num;
				$post[$postid] = new Lists($posts);
				
				$num++;
			}
			foreach ($post as $p) {
				if($p->replyid != 0) {
					if(array_key_exists($p->replyid,$post)) {
						$post[$p->replyid]->children[] = $post[$p->id];
					} else {
						$p->replyid =0;
					}
				}
			}
			
			$post = array_filter($post, create_function('$p', 'return !$p->replyid;'));

		
		$arr = array("forum" => $forum, "posts" => $post, "answers" => $answer, "access" => $array["perms"]);
		return $arr;
   }


   function setDetails($id,$title,$protocol,$forum_access,$forum_access_orig,$forum_status,$forum_status_date) {
		global $session, $lang;
		
		//$forum_status_date = $this->_date->formatDateGMT($forum_status_date);
		$status_date = $this->_date->formatDate($forum_status_date);
		
		switch($forum_status) {
			case "0":
				$sql = "planned_date";
			break;
			case "1":
				$sql = "inprogress_date";
			break;
			case "2":
				$sql = "finished_date";
			break;
			case "3":
				$sql = "stopped_date";
			break;
		}

		$now = gmdate("Y-m-d H:i:s");
		
		if($forum_access == $forum_access_orig) {
			$accesssql = "";
		} else {
			$forum_access_date = "";
			if($forum_access == 1) {
				$forum_access_date = $now;
			}
			$accesssql = "access='$forum_access', access_date='$forum_access_date', access_user = '$session->uid',";
		}
		
		$q = "UPDATE " . CO_TBL_COMPLAINTS_FORUMS . " set title = '$title', protocol = '$protocol', access='$forum_access', $accesssql status = '$forum_status', $sql = '$status_date', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
		$arr = array("id" => $id, "what" => "edit");
		}
		return $arr;
   }


   function createNew($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		//$q = "INSERT INTO " . CO_TBL_COMPLAINTS_FORUMS . " set title = '" . $lang["COMPLAINT_FORUM_NEW"] . "', item_date='$now', start='$time', end='$time', pid = '$id', participants = '$session->uid', management = '$session->uid', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		
		$q = "INSERT INTO " . CO_TBL_COMPLAINTS_FORUMS . " set pid = '$id', title = '" . $lang["COMPLAINT_FORUM_NEW"] . "', status = '0', planned_date = '$now', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		
		//$task = $this->addTask($id,0,0);
		
		if ($result) {
			return $id;
		}
   }
   

   	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		// forum
		$q = "INSERT INTO " . CO_TBL_COMPLAINTS_FORUMS . " (pid,title,item_date,start,end,location,location_ct,length,management,management_ct,participants,participants_ct,created_date,created_user,edited_date,edited_user) SELECT pid,CONCAT(title,' " . $lang["GLOBAL_DUPLICAT"] . "'),item_date,start,end,location,location_ct,length,management,management_ct,participants,participants_ct,'$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_COMPLAINTS_FORUMS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		// tasks
		$qt = "INSERT INTO " . CO_TBL_COMPLAINTS_FORUMS_TASKS . " (mid,status,title,text,sort) SELECT $id_new,'0',title,text,sort FROM " . CO_TBL_COMPLAINTS_FORUMS_TASKS . " where mid='$id' and bin='0'";
		$resultt = mysql_query($qt, $this->_db->connection);
		if ($result) {
			return $id_new;
		}
	}


   function binForum($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_COMPLAINTS_FORUMS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function restoreForum($id) {
		$q = "UPDATE " . CO_TBL_COMPLAINTS_FORUMS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deleteForum($id) {
		$q = "SELECT id FROM " . CO_TBL_COMPLAINTS_FORUMS_TASKS . " WHERE mid = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$tid = $row["id"];
			$this->deleteForumTask($tid);
		}
		
		$q = "DELETE FROM co_log_sendto WHERE what='complaints_forums' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_COMPLAINTS_FORUMS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


	function addItem($id,$text,$replyid,$num) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "INSERT INTO " . CO_TBL_COMPLAINTS_FORUMS_POSTS . " set pid='$id', replyid='$replyid', user ='$session->uid', status = '0', text = '$text', datetime = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		$iid = mysql_insert_id();

		$task["id"] = $iid;
		$task["num"] = $num;
		$task["user"] = $this->_users->getUserFullname($session->uid);
		$task["avatar"] = $this->_users->getAvatar($session->uid);
		$task["datetime"] = $this->_date->formatDate($now,CO_DATETIME_FORMAT);
		$task["text"] = stripslashes($text);
		$tasks = new Lists($task);
	
		//$this->writeNewPostsWidgetAlert($id);
		
		return $tasks;

	}

	function setItemStatus($id,$status) {
		$q = "UPDATE " . CO_TBL_COMPLAINTS_FORUMS_POSTS . " set status = '$status' WHERE id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
	}


	function binItem($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_COMPLAINTS_FORUMS_POSTS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if($result) {
			return true;
		}
	}

}
?>
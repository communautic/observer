<?php

class BrainstormsForumsModel extends BrainstormsModel {
	
	public function __construct() {  
		parent::__construct();
		$this->_contactsmodel = new ContactsModel();
		
	}
	
	function getList($id,$sort) {
		global $session;
		if($sort == 0) {
			$sortstatus = $this->getSortStatus("forum-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("forum-sort-order",$id);
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
				  		$sortorder = $this->getSortOrder("forum-sort-order",$id);
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
	  
		$perm = $this->getBrainstormAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and a.access = '1' ";
		}
		
		$q = "select a.title,a.id,a.access,a.status from " . CO_TBL_BRAINSTORMS_FORUMS . " as a where a.pid = '$id' and a.bin != '1' " . $sql . $order;
		
	  	$this->setSortStatus("forum-sort-status",$sortcur,$id);
		$result = mysql_query($q, $this->_db->connection);
	  	$forums = "";
		
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
			// status
			$itemstatus = "";
			if($array["status"] == 2) {
				$itemstatus = " module-item-active";
			}
			$array["itemstatus"] = $itemstatus;
			
			$forums[] = new Lists($array);
		}
		
		$arr = array("forums" => $forums, "sort" => $sortcur, "perm" => $perm);
		return $arr;
	}
	
	function checkoutForum($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_FORUMS . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	// Get forum list from ids for Tooltips
	function getForumDetails($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			$q = "SELECT id,title from " . CO_TBL_BRAINSTORMS_FORUMS . " where id = '$value'";
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


	function getForumTitle($id){
		$q = "SELECT title from " . CO_TBL_BRAINSTORMS_FORUMS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		return $title;
	}
	

	function getDependency($id){
		$q = "SELECT title FROM " . CO_TBL_BRAINSTORMS_FORUMS . " where dependency = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		return mysql_num_rows($result);
	}


	function getDetails($id,$view) {
		global $session, $lang;
		
		$this->_documents = new BrainstormsDocumentsModel();
		
		$q = "SELECT * FROM " . CO_TBL_BRAINSTORMS_FORUMS . " where id = '$id'";

		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
		
		$array["perms"] = $this->getBrainstormAccess($array["pid"]);
		$array["canedit"] = false;
		if($array["perms"] == "sysadmin" || $array["perms"] == "admin") {
			$array["canedit"] = true;
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
		
		$array["documents"] = $this->_documents->getDocListFromIDs($array['documents'],'documents');
		
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
				$array["status_text"] = $lang["BRAINSTORM_FORUM_STATUS_PLANNED"];
				$array["status_date"] = $array["planned_date"];
			break;
			case "1":
				$array["status_text"] = $lang["BRAINSTORM_FORUM_STATUS_INPROGRESS"];
				$array["status_date"] = $array["inprogress_date"];
				$array["startdate"] = $array["inprogress_date"];
			break;
			case "2":
				$array["status_text"] = $lang["BRAINSTORM_FORUM_STATUS_FINISHED"];
				$array["status_date"] = $array["finished_date"];
				$array["startdate"] = $array["inprogress_date"];
				$array["enddate"] = $array["finished_date"];
			break;
			case "3":
				$array["status_text"] = $lang["BRAINSTORM_FORUM_STATUS_STOPPED"];
				$array["status_date"] = $array["stopped_date"];
				$array["startdate"] = $array["inprogress_date"];
			break;
		}
		
		$perms = $this->getBrainstormAccess($array["pid"]);
		$array["canedit"] = false;
		if($perms == "sysadmin" || $perms == "admin") {
			$array["canedit"] = true;
		}
		
		$forum = new Lists($array);
		
		// get the posts
		$post= array();
		$answer= array();
		/*
		LINEAR
		if($view == 0) {
			$qt = "SELECT * FROM " . CO_TBL_BRAINSTORMS_FORUMS_POSTS . " where pid = '$id' and bin='0' ORDER BY id";
			$resultt = mysql_query($qt, $this->_db->connection);
			$num = 1;
			while($rowt = mysql_fetch_array($resultt)) {
				foreach($rowt as $key => $val) {
					$posts[$key] = $val;
					
				}
				
				$posts["user"] = $this->_users->getUserFullname($posts["user"]);
				$posts["datetime"] = $this->_date->formatDate($posts["datetime"],CO_DATETIME_FORMAT);
				
				if($posts["status"] == 1) {
					$answer[] = new Lists($posts);
				}
				
				$posts["num"] = $num;
				
				$post[] = new Lists($posts);
				
				$num++;
			}
		} */
			$qt = "SELECT * FROM " . CO_TBL_BRAINSTORMS_FORUMS_POSTS . " where pid = '$id' and bin='0' ORDER BY id";
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
					$post[$p->replyid]->children[] = $post[$p->id];
				}
			}
			
			$post = array_filter($post, create_function('$p', 'return !$p->replyid;'));

		//$sendto = $this->getSendtoDetails("brainstorms_forums",$id);
		
		$arr = array("forum" => $forum, "posts" => $post, "answers" => $answer, "access" => $array["perms"]);
		return $arr;
	}


	function setDetails($id,$title,$protocol,$documents,$forum_access,$forum_access_orig,$forum_status,$forum_status_date) {
		global $session, $system;

		$forum_status_date = $this->_date->formatDate($forum_status_date);
				
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
		$accesssql = "";
		if($forum_access == $forum_access_orig) {
			$accesssql = "";
		} else {
			$forum_access_date = "";
			if($forum_access == 1) {
				$forum_access_date = $now;
			}
			$accesssql = "access='$forum_access', access_date='$forum_access_date', access_user = '$session->uid',";
		}
		
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_FORUMS . " set title = '$title', protocol = '$protocol', documents = '$documents', $accesssql status = '$forum_status', $sql = '$forum_status_date', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
				
		if ($result) {
			$arr = array("id" => $id, "status" => "2");
			return $arr;
		}
	}


	function createNew($pid) {
		global $session, $lang;
		$now = gmdate("Y-m-d H:i:s");
		$title = $lang["BRAINSTORM_FORUM_NEW"];
		$q = "INSERT INTO " . CO_TBL_BRAINSTORMS_FORUMS . " set title = '$title', pid='$pid', access='0', status = '0', planned_date = '$now', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		if ($result) {
			return $id;
		}
	}


	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		// forum
		$q = "INSERT INTO " . CO_TBL_BRAINSTORMS_FORUMS . " (pid,title,protocol,created_date,created_user,edited_date,edited_user) SELECT pid,CONCAT(title,' ".$lang["GLOBAL_DUPLICAT"]."'),protocol,'$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_BRAINSTORMS_FORUMS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		// tasks
		$qt = "SELECT id,replyid,user,datetime,text,status FROM " . CO_TBL_BRAINSTORMS_FORUMS_POSTS . " where pid='$id' and bin='0' ORDER BY id";		
		$resultt = mysql_query($qt, $this->_db->connection);
		while($rowt = mysql_fetch_array($resultt)) {
			$id = $rowt["id"];
			$replyid = $rowt["replyid"];
			$user = $rowt["user"];
			$datetime = $rowt["datetime"];
			$text = mysql_real_escape_string($rowt["text"]);
			$status = $rowt["status"];
			$qtn = "INSERT INTO " . CO_TBL_BRAINSTORMS_FORUMS_POSTS . " set pid = '$id_new', replyid = '$replyid', user = '$user', datetime = '$datetime', text = '$text', status = '$status'";
			$rpn = mysql_query($qtn, $this->_db->connection);
			$id_t_new = mysql_insert_id();
			// BUILD OLD NEW TASK ID ARRAY
			$t[$id] = $id_t_new;
		}
		// Updates Dependencies for new tasks
		$qt = "SELECT id,replyid FROM " . CO_TBL_BRAINSTORMS_FORUMS_POSTS . " where pid='$id_new' and bin='0'";		
		$resultt = mysql_query($qt, $this->_db->connection);
		while($rowt = mysql_fetch_array($resultt)) {
			$id = $rowt["id"];
			$dep = 0;
			if($rowt["replyid"] != 0) {
				$dependent = $rowt["replyid"];
				$dep = $t[$dependent];
			}
			$qtn = "UPDATE " . CO_TBL_BRAINSTORMS_FORUMS_POSTS . " set replyid = '$dep' WHERE id='$id'";
			$rpn = mysql_query($qtn, $this->_db->connection);
		}
	
		if ($result) {
			return $id_new;
		}
	}
	

   function binForum($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_FORUMS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_FORUMS_POSTS . " set bin = '1' where pid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
		  	return true;
		}
	}
	
	function restoreForum($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_FORUMS . " set bin = '0', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_FORUMS_POSTS . " set bin = '0' where phaseid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
		  	return true;
		}
	}
	
	
	function deleteForum($id) {
		global $session;
		
		$q = "DELETE FROM co_log_sendto WHERE what='brainstorms_forums' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_BRAINSTORMS_FORUMS_POSTS . " where phaseid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_BRAINSTORMS_FORUMS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
		  	return true;
		}
	}
   
   
	function toggleIntern($id,$status) {
		global $session;
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_FORUMS . " set intern = '$status' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
	}
	
	
	function getForumField($id,$field) {
		$q = "SELECT $field FROM " . CO_TBL_BRAINSTORMS_FORUMS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		return mysql_result($result,0);
	}


	function getTaskDependencyExists($id){
		$q = "SELECT id FROM " . CO_TBL_BRAINSTORMS_FORUMS_POSTS . " where dependent = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function moveDependendTasks($id,$days){
		$q = "SELECT id, startdate, enddate FROM " . CO_TBL_BRAINSTORMS_FORUMS_POSTS . " where dependent='$id'";
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$tid = $row["id"];
			$startdate = $this->_date->addDays($row["startdate"],$days);
			$enddate = $this->_date->addDays($row["enddate"],$days);
			$qt = "UPDATE " . CO_TBL_BRAINSTORMS_FORUMS_POSTS . " set startdate = '$startdate', enddate = '$enddate' where id='$tid'";
			$res = mysql_query($qt, $this->_db->connection);
			$this->moveDependendTasks($tid,$days);
		}
		return $res;
	}


	function addItem($id,$text,$replyid,$num) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "INSERT INTO " . CO_TBL_BRAINSTORMS_FORUMS_POSTS . " set pid='$id', replyid='$replyid', user ='$session->uid', status = '0', text = '$text', datetime = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		$iid = mysql_insert_id();
		
		
		$task["id"] = $iid;
		$task["num"] = $num;
		$task["user"] = $this->_users->getUserFullname($session->uid);
		$task["avatar"] = $this->_users->getAvatar($session->uid);
		$task["datetime"] = $this->_date->formatDate($now,CO_DATETIME_FORMAT);
		$task["text"] = stripslashes($text);
		$tasks = new Lists($task);

		return $tasks;

	}
	
	
	function setItemStatus($id,$status) {
		
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_FORUMS_POSTS . " set status = '$status' WHERE id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}

		

	}


    // dialog for selecting dependent tasks
	function getTasksDialog($id,$field) {
		global $lang;
		$q = "SELECT pid,startdate FROM " . CO_TBL_BRAINSTORMS_FORUMS_POSTS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_assoc($result);
		$pid = $row["pid"];
		$startdate = $row["startdate"];
	 
		$str = '<div class="dialog-text">';
	 	$str .= '<a href="#" mod="brainstorms_forums" class="insertItem" title="" field="' . $field . '" did="">' . $lang["BRAINSTORM_FORUM_TASK_DEPENDENT_NO"] . '</a>';

		
		$q ="select id,text from " . CO_TBL_BRAINSTORMS_FORUMS_POSTS . " where pid = '$pid' and startdate <= '$startdate' and id != '$id' and bin = '0' ORDER BY startdate";
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$str .= '<a href="#" mod="brainstorms_forums" class="insertItem" title="' . $row["text"] . '" field="' . $field . '" did="'.$row["id"].'">' . $row["text"] . '</a>';
		}
		$str .= '</div>';	
		return $str;
	}
   

	function binItem($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_FORUMS_POSTS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if($result) {
			return true;
		}
	}

	function restoreForumTask($id) {
		$q = "UPDATE " . CO_TBL_BRAINSTORMS_FORUMS_POSTS . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if($result) {
			return true;
		}
	}

	function deleteForumTask($id) {
		global $session;
		$q = "DELETE FROM " . CO_TBL_BRAINSTORMS_FORUMS_POSTS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if($result) {
			return true;
		}
	}
	
	function getForumsBin($id) {
		global $session, $lang;
		$forums = "";
		$tasks = "";
		$qph ="select id, title, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS_FORUMS . " where pid = '$id'";
						$resultph = mysql_query($qph, $this->_db->connection);
						while ($rowph = mysql_fetch_array($resultph)) {
							$phid = $rowph["id"];
							if($rowph["bin"] == "1") { // deleted forums
								foreach($rowph as $key => $val) {
									$forum[$key] = $val;
								}
								$forum["bintime"] = $this->_date->formatDate($forum["bintime"],CO_DATETIME_FORMAT);
								$forum["binuser"] = $this->_users->getUserFullname($forum["binuser"]);
								$forums[] = new Lists($forum);
								//$arr["forums"] = $forums;
							} else {
								// tasks
								$qt ="select id, text, bin, bintime, binuser from " . CO_TBL_BRAINSTORMS_FORUMS_POSTS . " where phaseid = '$phid'";
								$resultt = mysql_query($qt, $this->_db->connection);
								while ($rowt = mysql_fetch_array($resultt)) {
									if($rowt["bin"] == "1") { // deleted forums
										foreach($rowt as $key => $val) {
											$task[$key] = $val;
										}
										$task["bintime"] = $this->_date->formatDate($task["bintime"],CO_DATETIME_FORMAT);
										$task["binuser"] = $this->_users->getUserFullname($task["binuser"]);
										$tasks[] = new Lists($task);
										//$arr["tasks"] = $tasks;
									} 
								}
							}
						}
						
						$arr = array("forums" => $forums, "tasks" => $tasks);
						/*$arr["forums"] = $forums;
						$arr["tasks"] = $tasks;*/
		return $arr;
	}
	
function test() {
		echo "dxasddas";	
	}

}

$brainstormsForumsModel = new BrainstormsForumsModel();
?>
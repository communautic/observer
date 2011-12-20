<?php

class ForumsAccessModel extends ForumsModel {
	
	public function __construct() {  
		parent::__construct();
		$this->_contactsmodel = new ContactsModel();
	}
	
	
	function getList($id,$sort) {
		global $session, $lang;

			$array["id"] = 0;
			//$array["controlling_date"] = $this->_date->formatDate("now",CO_DATE_FORMAT);
			$array["title"] = $lang["FORUM_ACCESSRIGHTS"];
			$array["itemstatus"] = "";
			
			$access[] = new Lists($array);
		
	  $arr = array("access" => $access, "sort" => 0);
	  return $arr;
	}


	function getDetails($id) {
		global $session, $contactsmodel;

		// guest
		$q = "SELECT * FROM " . CO_TBL_FORUMS_ACCESS . " where pid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			$array["pid"] = $id;
			$array["admins"] = "";
			$array["guests"] = "";
			$array["created_date"] = "";
			$array["edited_date"] = "";
			$array["created_user"] = "";
			$array["edited_user"] = "";
		} else {
			$row = mysql_fetch_array($result);
			foreach($row as $key => $val) {
					$array[$key] = $val;
				}
			
			$array["admins"] = $this->_contactsmodel->getUserList($array['admins'],'forumsadmins',"and userlevel != '1' and username != ''");
			$array["guests"] = $this->_contactsmodel->getUserList($array['guests'],'forumsguests',"and userlevel != '1' and username != ''");
			
			/*$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
			$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
			$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
			$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);*/
		}
		
		$array["today"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		
		$access = new Lists($array);
	  
		return $access;
   }

	function writeWidgetReminder($pid,$string,$perm = 0) {
		if($string != "") {
			$users = explode(",",$string);
		} else {
			$users = array();
		}
	   
		// select all users that have reminders for this project
		$qall = "SELECT uid FROM " . CO_TBL_FORUMS_DESKTOP . " where pid='$pid' and perm ='$perm'";
		$resultall = mysql_query($qall, $this->_db->connection);
		$all = array();
		while($rowall = mysql_fetch_array($resultall)) {
			$all[] = $rowall['uid'];
		}

		foreach($users as $user) {
			if(in_array($user,$all)) {
				$key = array_search($user, $all);
				unset($all[$key]);
			} else {
				$q = "SELECT * FROM " . CO_TBL_FORUMS_DESKTOP . " where pid='$pid' and uid='$user' and perm ='$perm'";
				$result = mysql_query($q, $this->_db->connection);
				if(mysql_num_rows($result) < 1) {
					$q = "INSERT INTO " . CO_TBL_FORUMS_DESKTOP . " set pid='$pid', uid = '$user', perm ='$perm'";
					$result = mysql_query($q, $this->_db->connection);
				}
			}
		}
		// last delete obsolte
	   foreach($all as $u) {
		   $q = "DELETE FROM " . CO_TBL_FORUMS_DESKTOP . " WHERE uid = '$u' and pid = '$pid'";
		   $result = mysql_query($q, $this->_db->connection);
	   }
   }


   function setDetails($pid,$admins,$guests) {
		global $session;
		
		$admins = $this->_contactsmodel->sortUserIDsByName($admins);
		$guests = $this->_contactsmodel->sortUserIDsByName($guests);
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "SELECT * FROM " . CO_TBL_FORUMS_ACCESS . " where pid='$pid'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			$q = "INSERT INTO " . CO_TBL_FORUMS_ACCESS . " set pid = '$pid', admins = '$admins', guests = '$guests', edited_user = '$session->uid', edited_date = '$now', created_user = '$session->uid', created_date = '$now'";
		} else {
			$q = "UPDATE " . CO_TBL_FORUMS_ACCESS . " set admins = '$admins', guests = '$guests', edited_user = '$session->uid', edited_date = '$now' where pid='$pid'";
		}
		$result = mysql_query($q, $this->_db->connection);
		
		$this->writeWidgetReminder($pid,$admins);
		$this->writeWidgetReminder($pid,$guests,1);
		
		if ($result) {
			return $pid;
		}
   }


}
?>
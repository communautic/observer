<?php

class PublishersAccessModel extends PublishersModel {
	
	public function __construct() {  
		parent::__construct();
		$this->_contactsmodel = new ContactsModel();
	}
	
	
	function getList($sort) {
		global $session, $lang;

			$array["id"] = 0;
			//$array["controlling_date"] = $this->_date->formatDate("now",CO_DATE_FORMAT);
			$array["title"] = $lang["PUBLISHER_ACCESSRIGHTS"];
			$array["itemstatus"] = "";
			
			$access[] = new Lists($array);
		
	  $arr = array("access" => $access, "sort" => 0);
	  return $arr;
	}


	function getDetails() {
		global $session, $contactsmodel;

		// guest
		$q = "SELECT * FROM " . CO_TBL_PUBLISHERS_ACCESS;
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
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
			
			$array["admins"] = $this->_contactsmodel->getUserList($array['admins'],'publishersadmins',"and userlevel != '1' and username != ''");
			$array["guests"] = $this->_contactsmodel->getUserList($array['guests'],'publishersguests',"and userlevel != '1' and username != ''");
			
			/*$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
			$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
			$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
			$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);*/
		}
		
		$array["today"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		
		$access = new Lists($array);
	  
		return $access;
   }


   function setDetails($admins,$guests) {
		global $session;
		
		$admins = $this->_contactsmodel->sortUserIDsByName($admins);
		$guests = $this->_contactsmodel->sortUserIDsByName($guests);
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "SELECT id FROM " . CO_TBL_PUBLISHERS_ACCESS;
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			$q = "INSERT INTO " . CO_TBL_PUBLISHERS_ACCESS . " set admins = '$admins', guests = '$guests', edited_user = '$session->uid', edited_date = '$now', created_user = '$session->uid', created_date = '$now'";
		} else {
			$id = mysql_result($result,0);
			$q = "UPDATE " . CO_TBL_PUBLISHERS_ACCESS . " set admins = '$admins', guests = '$guests', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		}
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return "true";
		}
   }


}
?>
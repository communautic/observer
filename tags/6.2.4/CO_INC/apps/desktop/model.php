<?php
class DesktopModel extends Model {

	
	function getColumnWidgets($id) {
		global $session;
		$widgets = explode(",",$this->getSortStatus("desktop-widgets",$id));
		return $widgets;
	}


	function updateColum($col,$widgets) {
		global $session;
		$widgets = str_replace("Widget","",implode(",",$widgets));
		if(!$this->existUserSetting('desktop-widgets',$col)) {
			$q = "insert into " . CO_TBL_USER_SETTINGS . " set uid='$session->uid', object='desktop-widgets', item='$col', value='$widgets'";
			$result = mysql_query($q, $this->_db->connection);
			return true;
		} else {
			$q = "update " . CO_TBL_USER_SETTINGS . " set value='$widgets' where object='desktop-widgets' and item='$col' and uid='$session->uid'";
			$result = mysql_query($q, $this->_db->connection);
			return true;
		}
	}


	function setWidgetStatus($object,$status) {
		$object = 'desktop-widget-' . $object;
		return $this->setUserSetting($object,$status);
	}
	
	
	function getPostIts() {
		global $session,$lang, $contactsmodel;
		
		$now = gmdate("Y-m-d H:i:s");
		
		// Notes
		$q = "select * from " . CO_TBL_DESKTOP_POSTITS . " where uid = '$session->uid'";
		
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
			
			$note["sendto"] = $contactsmodel->getUserListPlain($note['sendto']);
			$note["sendfrom"] = $contactsmodel->getUserListPlain($note['sendfrom']);
			
			
			$notes[] = new Lists($note);
	  	}
		
		$arr = array("notes" => $notes);
		return $arr;
	}
	
	
	function newPostit($z,$x) {
		global $session,$lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "INSERT INTO " . CO_TBL_DESKTOP_POSTITS . " set uid = '$session->uid', xyz = '" . $x . "x100x" . $z . "', wh = '300x300', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	

	function updatePostitPosition($id,$x,$y,$z) {
		global $session;
		$q = "UPDATE " . CO_TBL_DESKTOP_POSTITS . " set xyz='".$x."x".$y."x".$z."' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	

	function updatePostitSize($id,$w,$h) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_DESKTOP_POSTITS . " set wh='".$w."x".$h."' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}


	function savePostit($id,$text) {
		global $session;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_DESKTOP_POSTITS . " set text = '$text', edited_user = '$session->uid', edited_date = '$now' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$date = $this->_date->formatDate($now,CO_DATETIME_FORMAT);
		if ($result) {
			return $date;
		}
	}
	
	
	function forwardPostit($id,$users) {
		global $session, $contactsmodel;

		$now = gmdate("Y-m-d H:i:s");
		
		$q = "SELECT * FROM " . CO_TBL_DESKTOP_POSTITS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$text = $row['text'];
			//$xyz = $row['xyz'];
			$wh = $row['wh'];
			$edited_user = $row['edited_user'];
			$sendto = $row['sendto'];
		}
		
		$users = rtrim($users,',');
		if($users == "") {
			return true;
		}
		$users = $contactsmodel->sortUserIDsByName($users);
		$users_arr = explode(",",$users);
		
		foreach($users_arr as $user) {
			$q = "INSERT INTO " . CO_TBL_DESKTOP_POSTITS . " set text = '$text', uid = '$user', xyz = '15x70x1000', wh = '$wh', sendfrom ='$session->uid', created_user = '$edited_user', created_date = '$now', edited_user = '$edited_user', edited_date = '$now'";
			$result = mysql_query($q, $this->_db->connection);
		}
		
		if($sendto == "") {
			$sendto = $users;
		} else {
			$sendto = $sendto . ',' . $users;
		}
		
		// Update original
		$q = "UPDATE " . CO_TBL_DESKTOP_POSTITS . " set sendto='$sendto' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function deletePostit($id) {
		$q = "DELETE FROM " . CO_TBL_DESKTOP_POSTITS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }

}
?>
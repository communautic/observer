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
		global $session;
		// Notes
		$q = "select * from " . CO_TBL_DESKTOP_POSTITS . " where uid = '$session->uid'";
		
		$result = mysql_query($q, $this->_db->connection);
	  	$notes = "";
	  	while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$note[$key] = $val;
			}
			
			$notes[] = new Lists($note);
	  	}
		
		$arr = array("notes" => $notes);
		return $arr;
	}
	
	
	function newPostit($z) {
		global $session;
		
		$q = "INSERT INTO " . CO_TBL_DESKTOP_POSTITS . " set uid = '$session->uid', xyz = '15x30x" . $z . "', wh = '200x200'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			$id = mysql_insert_id();
		}
		$note["xyz"] = '15x30x' . $z;
		$note["wh"] = '200x200';
		$note["id"] = $id;
		$note["text"] = "";
		$notes[] = new Lists($note);
		$arr = array("notes" => $notes);
		return $arr;
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
		$q = "UPDATE " . CO_TBL_DESKTOP_POSTITS . " set wh='".$w."x".$h."' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}


	function savePostit($id,$text) {
		$q = "UPDATE " . CO_TBL_DESKTOP_POSTITS . " set text = '$text' WHERE id='$id'";
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
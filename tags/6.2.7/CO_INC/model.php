<?php
include_once(dirname(__FILE__)."/model/lists.php");

class Model extends MySQLDB {
	
	public $_db;
	
	public function __construct()  {  
		$this->_db = new MySQLDB();
		$this->_users = new Users();
		$this->_date = new DateTimeCus();
  } 
	
	function getModules($app) {
		$q = "select value from co_config where name='$app'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_result($result,0);
		//$modules = array('phases','meetings','phonerecords','notes','documents','images','schedules','access');
		//$modules = array('phases','meetings');
		return $row;
	}
	
	
	function existUserSetting($object,$item=0) {
		global $session;
		$q = "select count(*) as num from " . CO_TBL_USER_SETTINGS . " where object='$object' and item='$item' and uid='$session->uid'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_assoc($result);
		if($row["num"] < 1) {
			return false;
		} else {
			return true;
		}
	}
	
	
	function getSortStatus($object,$item=0) {
		global $session;
		if(!$this->existUserSetting($object,$item)) {
			return false;
		} else {
			$q = "select value from " . CO_TBL_USER_SETTINGS . " where object='$object' and item='$item' and uid='$session->uid'";
			$result = mysql_query($q, $this->_db->connection);
			$row = mysql_result($result,0);
			if($row == "") {
				return false;
			} else {
				return $row;
			}
		}
	}
	
	
	function setSortStatus($object,$status,$item=0) {
		global $session;
		if(!$this->existUserSetting($object,$item)) {
			$q = "insert into " . CO_TBL_USER_SETTINGS . " set uid='$session->uid', object='$object', item='$item', value='$status'";
			$result = mysql_query($q, $this->_db->connection);
			return true;
		} else {
			$q = "update " . CO_TBL_USER_SETTINGS . " set value='$status' where object='$object' and item='$item' and uid='$session->uid'";
			$result = mysql_query($q, $this->_db->connection);
			return true;
		}
	}
	
	
	function getSortOrder($object,$item=0) {
		global $session;
		if(!$this->existUserSetting($object,$item)) {
			return false;
		} else {
			$q = "select value from " . CO_TBL_USER_SETTINGS . " where object='$object' and item='$item' and uid='$session->uid'";
			$result = mysql_query($q, $this->_db->connection);
			$row = mysql_result($result,0);
			if($row == "") {
				return false;
			} else {
				return $row;
			}
		}
	}
	
	function setSortOrder($object,$items,$item=0) {
		global $session;
		$object_status = $object."-status";
		$object_order = $object."-order";
		$string = "";
		foreach ($items as $i => $id) :
			$string .= "$id,";
		endforeach;
		
		$string = rtrim($string, ",");
		
		$this->setSortStatus($object_status,"3",$item);
		
		if(!$this->existUserSetting($object_order,$item)) {
			$q = "insert into " . CO_TBL_USER_SETTINGS . " set uid='$session->uid', object='$object_order', item='$item', value='$string'";
			$result = mysql_query($q, $this->_db->connection);
			return true;
		} else {
			$q = "update " . CO_TBL_USER_SETTINGS . " set value='$string' where object='$object_order' and item='$item' and uid='$session->uid'";
			$result = mysql_query($q, $this->_db->connection);
			return true;
		}
	}
	
	function getUserSetting($object) {
		global $session;
		if(!$this->existUserSetting($object)) {
			return false;
		} else {
			$q = "select value from " . CO_TBL_USER_SETTINGS . " where object='$object' and uid='$session->uid'";
			$result = mysql_query($q, $this->_db->connection);
			$row = mysql_result($result,0);
			if($row == "") {
				return false;
			} else {
				return $row;
			}
		}
	}
	
	function setUserSetting($object,$string) {
		global $session;
		
		if(!$this->existUserSetting($object)) {
			$q = "insert into " . CO_TBL_USER_SETTINGS . " set uid='$session->uid', object='$object', value='$string'";
			$result = mysql_query($q, $this->_db->connection);
			return true;
		} else {
			$q = "update " . CO_TBL_USER_SETTINGS . " set value='$string' where object='$object' and uid='$session->uid'";
			$result = mysql_query($q, $this->_db->connection);
			return true;
		}
	}
	
	
	function getConfigField($field) {
		global $session;
		$q = "select value from co_config where name='$field'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_result($result,0);
		return $row;
	}


	/*function getPrintFooter() {
		global $session;
		$q = "select value from co_config where name='printfooter'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_result($result,0);
		return $row;
	}*/
	
	
	public static function saveImage($chart_url,$path,$file_name){
		if(!file_exists($path.$file_name) || (md5_file($path.$file_name) != md5_file($chart_url))) {
			file_put_contents($path.$file_name,file_get_contents($chart_url));
		}
		return $file_name;
	}
	
	/*public function getChart() {
		$local_image_path = CO_PATH_BASE . '/data/charts/';
		$image_name = 'some_chart_image.png';
		$chart_url = 'http://chart.apis.google.com/chart?chf=bg,s,3F3F3F&chxs=0,FFFFFF,11.5&chxt=x&chs=321x170&cht=p3&chco=FF9900|3399CC|E0E0E0&chd=s:jfh&chdlp=b&chma=20,20,15';
		$image = self::saveImage($chart_url ,$local_image_path,$image_name);
	}*/
	
	
	function writeActionLog() {
		$q = "INSERT INTO co_log set app='projects'";
		$result = mysql_query($q, $this->_db->connection);
	}
	
	
	function writeSendtoLog($what,$whatid,$who,$subject,$body) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		$q = "INSERT INTO co_log_sendto SET date='$now', what='$what', whatid='$whatid', who='$who', sender='$session->uid', subject='$subject', body='$body'";
		$result = mysql_query($q, $this->_db->connection);
	}
	
	
	function getSendtoDetails($what,$id) {
		global $contactsmodel;
	// Select sendto
		$sendto = array();
		$q = "SELECT * FROM co_log_sendto where what='$what' and whatid = '$id' ORDER BY date DESC";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
		foreach($row as $key => $val) {
				if($key == "who") {
					$sendtos[$key] = $contactsmodel->getUserListPlain($val);
				}
				else if($key == "date") {
					$sendtos[$key] = $this->_date->formatDate($val,CO_DATETIME_FORMAT);
				} else {
					$sendtos[$key] = $val;
				}
				
			}
			$sendto[] = new Lists($sendtos);
		}
		return $sendto;
	}
	
	
	function barchartCalendar($date,$i) {
		$day = array();
		$day["month"] = "";
		$day["week"] = "";
		$day["color"] = "#000";
		$day["number"] = $this->_date->formatDate($date,"d");
		if($day["number"] == "01" || ($i == 0 && $day["number"] > 01 && $day["number"] < 28)) {
			//$day["month"] = $this->_date->formatDate($date,"M y");
			$day["month"] = utf8_encode(strftime("%b %y",strtotime($date)));
		}
		$day["wday"] = $this->_date->formatDate($date,"w");
		if($day["wday"] == 1) {
			$day["week"] = $this->_date->formatDate($date,"W");
		}
		if($day["wday"] == 0 || $day["wday"] == 6) {
			$day["color"] = "#fff";
		}

		return $day;
	}

}

$model = new Model();
?>
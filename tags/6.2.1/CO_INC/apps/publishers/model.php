<?php
//include_once(CO_PATH_BASE . "/model.php");
//include_once(dirname(__FILE__)."/model/folders.php");
//include_once(dirname(__FILE__)."/model/publishers.php");

class PublishersModel extends Model {
	

   function getBin() {
		global $publishers;
		
		$bin = array();
		$bin["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		$arr = array();
		$arr["bin"] = $bin;
		
		$active_modules = array();
		foreach($publishers->modules as $module => $value) {
			if(CONSTANT('publishers_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
			}
		}
		
		// menues
		if(in_array("menues",$active_modules)) {
			$qpc ="select id, title, bin, bintime, binuser from " . CO_TBL_PUBLISHERS_MENUES . " where bin = '1'";
			$resultpc = mysql_query($qpc, $this->_db->connection);
			while ($rowpc = mysql_fetch_array($resultpc)) {
				$idp = $rowpc["id"];
					foreach($rowpc as $key => $val) {
						$menue[$key] = $val;
					}
					$menue["bintime"] = $this->_date->formatDate($menue["bintime"],CO_DATETIME_FORMAT);
					$menue["binuser"] = $this->_users->getUserFullname($menue["binuser"]);
					$menues[] = new Lists($menue);
					$arr["menues"] = $menues;
			}
		}

		return $arr;
   }
   
   
   function emptyBin() {
		global $publishers;
		
		$bin = array();
		$bin["datetime"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		$arr = array();
		$arr["bin"] = $bin;
		
		$active_modules = array();
		foreach($publishers->modules as $module => $value) {
			if(CONSTANT('publishers_'.$module.'_bin') == 1) {
				$active_modules[] = $module;
				$arr[$module] = "";
				$arr[$module . "_tasks"] = "";
				$arr[$module . "_folders"] = "";
			}
		}
		
		// menues
		if(in_array("menues",$active_modules)) {
			$publishersMenuesModel = new PublishersMenuesModel();
			$q ="select id from " . CO_TBL_PUBLISHERS_MENUES . " where bin = '1'";
			$result = mysql_query($q, $this->_db->connection);
			while ($row = mysql_fetch_array($result)) {
				$id = $row["id"];
				$publishersMenuesModel->deleteMenue($id);
				$arr["menues"] = "";
			}
		}

		return $arr;
   }


	// User Access
	function getEditPerms($id) {
		global $session;
		$perms = array();
		$q = "SELECT * FROM co_publishers_access where admins REGEXP '[[:<:]]" . $id . "[[:>:]]'";
      	$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$perms[] = true;
		}
		return $perms;
   }


   function getViewPerms($id) {
		global $session;
		$perms = array();
		$q = "SELECT * FROM co_publishers_access where guests REGEXP '[[:<:]]" . $id. "[[:>:]]'";
      	$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$perms[] = true;
		}
		return $perms;
   }


   function canAccess($id) {
	   global $session;
	   return array_merge($this->getViewPerms($id),$this->getEditPerms($id));
   }


   function getPublisherAccess() {
		global $session;
		$access = "";
		if($this->getViewPerms($session->uid)) {
			$access = "guest";
		}
		if($this->getEditPerms($session->uid)) {
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
   

}

$publishersmodel = new PublishersModel(); // needed for direct calls to functions eg echo $publishersmodel ->getPublisherTitle(1);
?>
<?php

class PatientsVDocsModel extends PatientsModel {
	
	public function __construct() {  
     	parent::__construct();
		//$this->_phases = new PatientsPhasesModel();
		$this->_contactsmodel = new ContactsModel();
	}


	function getList($id,$sort) {
		global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("patients-vdocs-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("patients-vdocs-sort-order",$id);
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
				  		$sortorder = $this->getSortOrder("patients-vdocs-sort-order",$id);
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
	  
	  
	  $perm = $this->getPatientAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		
		//$q = "select title,id,intern,startdate,enddate from " . CO_TBL_PATIENTS_PHASES . " where pid = '$id' and bin != '1' " . $order;
		$q = "select id,title,access,checked_out,checked_out_user from " . CO_TBL_PATIENTS_VDOCS . " where pid = '$id' and bin != '1' " . $sql . $order;
	  $this->setSortStatus("patients-vdocs-sort-status",$sortcur,$id);
	  $result = mysql_query($q, $this->_db->connection);
	  $items = mysql_num_rows($result);
	  
	  $vdocs = "";
	  while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			
			
			// access
			$accessstatus = "";
			if($perm !=  "guest") {
				if($array["access"] == 1) {
					$accessstatus = " module-access-active";
				}
			}
			$array["accessstatus"] = $accessstatus;
			
			$checked_out_status = "";
			if($perm !=  "guest" && $array["checked_out"] == 1 && $array["checked_out_user"] != $session->uid) {
				if($session->checkUserActive($array["checked_out_user"])) {
					$checked_out_status = "icon-checked-out-active";
				} else {
					$this->checkinVDocsOverride($id);
				}
			}
			$array["checked_out_status"] = $checked_out_status;
			
			$vdocs[] = new Lists($array);
	  }
		
	  $arr = array("vdocs" => $vdocs, "items" => $items, "sort" => $sortcur, "perm" => $perm);
	  return $arr;
	}


	function getNavNumItems($id) {
		$perm = $this->getPatientAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		$q = "select count(*) as items from " . CO_TBL_PATIENTS_VDOCS . " where pid = '$id' and bin != '1' " . $sql;
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		$items = $row['items'];
		return $items;
	}
	

	function checkoutVDocs($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_PATIENTS_VDOCS . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function checkinVDocs($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_PATIENTS_VDOCS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_PATIENTS_VDOCS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}


	function checkinVDocsOverride($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PATIENTS_VDOCS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}


	function getDetails($id) {
		global $session, $lang;
		
		//$this->_documents = new DocumentsModel();
		
		$q = "SELECT * FROM " . CO_TBL_PATIENTS_VDOCS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			
		$array["perms"] = $this->getPatientAccess($array["pid"]);
		$array["canedit"] = false;
		$array["showCheckout"] = false;
		$array["checked_out_user_text"] = $this->_contactsmodel->getUserListPlain($array['checked_out_user']);

		if($array["perms"] == "sysadmin" || $array["perms"] == "admin") {
			//if($array["checked_out"] == 1 && $session->checkUserActive($array["checked_out_user"])) {
			if($array["checked_out"] == 1) {
				if($array["checked_out_user"] == $session->uid) {
					$array["canedit"] = true;
				} else if(!$session->checkUserActive($array["checked_out_user"])) {
					$array["canedit"] = $this->checkoutVDocs($id);
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
		$array["checked_out_user_phone1"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
		$array["checked_out_user_email"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");

				}
			} else {
				$array["canedit"] = $this->checkoutVDocs($id);
			}
		}

		
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
		
		
		// get user perms
		//$array["edit"] = "1";
		
		$sendto = $this->getSendtoDetails("patients_vdocs",$id);
		
		$vdoc = new Lists($array);
		$arr = array("vdoc" => $vdoc, "sendto" => $sendto, "access" => $array["perms"]);
		return $arr;
   }


   function setDetails($pid,$id,$title,$content,$vdoc_access,$vdoc_access_orig) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		if($vdoc_access == $vdoc_access_orig) {
			$accesssql = "";
		} else {
			$vdoc_access_date = "";
			if($vdoc_access == 1) {
				$vdoc_access_date = $now;
			}
			$accesssql = "access='$vdoc_access', access_date='$vdoc_access_date', access_user = '$session->uid',";
		}
		
		$q = "UPDATE " . CO_TBL_PATIENTS_VDOCS . " set title = '$title', content = '$content', access='$vdoc_access', $accesssql edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		
		if ($result) {
		$arr = array("id" => $id, "what" => "edit");
		}
		return $arr;
   }


   function createNew($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		$time = gmdate("Y-m-d H");
		
		$q = "INSERT INTO " . CO_TBL_PATIENTS_VDOCS . " set title = '" . $lang["PATIENT_VDOC_NEW"] . "', pid = '$id', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		
		if ($result) {
			return $id;
		}
   }
   

   	function createDuplicate($id) {
		global $session, $lang;
		// vdoc
		$q = "INSERT INTO " . CO_TBL_PATIENTS_VDOCS . " (pid,title,content) SELECT pid,CONCAT(title,' " . $lang["GLOBAL_DUPLICAT"] . "'),content FROM " . CO_TBL_PATIENTS_VDOCS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		if ($result) {
			return $id_new;
		}
	}


   function binVDoc($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PATIENTS_VDOCS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function restoreVDoc($id) {
		$q = "UPDATE " . CO_TBL_PATIENTS_VDOCS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deleteVDoc($id) {
		
		$q = "DELETE FROM co_log_sendto WHERE what='patients_vdocs' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_PATIENTS_VDOCS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function toggleIntern($id,$status) {
		global $session;
		$q = "UPDATE " . CO_TBL_PATIENTS_VDOCS . " set intern = '$status' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   //$vdocsmodel = new VDocsModel();

}
?>
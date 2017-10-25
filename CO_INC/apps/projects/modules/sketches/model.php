<?php

class ProjectsSketchesModel extends ProjectsModel {
	
	public function __construct() {  
     	parent::__construct();
		//$this->_phases = new ProjectsPhasesModel();
		$this->_contactsmodel = new ContactsModel();
	}


	function getList($id,$sort) {
		global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("projects-sketches-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("projects-sketches-sort-order",$id);
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
				  		$sortorder = $this->getSortOrder("projects-sketches-sort-order",$id);
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
	  
	  
		$perm = $this->getProjectAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		
		$q = "select id,title,access,checked_out,checked_out_user from " . CO_TBL_PROJECTS_SKETCHES . " where pid = '$id' and bin != '1' " . $sql . $order;
		//echo $q;
		$this->setSortStatus("projects-sketches-sort-status",$sortcur,$id);
		$result = mysql_query($q, $this->_db->connection);
		$items = mysql_num_rows($result);
		
		$sketches = "";
		while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			
			// dates
			//$array["item_date"] = $this->_date->formatDate($array["item_date"],CO_DATE_FORMAT);
			
			// access
			$accessstatus = "";
			if($perm !=  "guest") {
				if($array["access"] == 1) {
					$accessstatus = " module-access-active";
				}
			}
			$array["accessstatus"] = $accessstatus;
			// status
			/*$itemstatus = "";
			if($array["status"] == 2) {
				$itemstatus = " module-item-active";
			}
			if($array["status"] == 3) {
				$itemstatus = " module-item-active-stopped";
			}
			$array["itemstatus"] = $itemstatus;
			*/
			$checked_out_status = "";
			if($perm !=  "guest" && $array["checked_out"] == 1 && $array["checked_out_user"] != $session->uid) {
				if($session->checkUserActive($array["checked_out_user"])) {
					$checked_out_status = "icon-checked-out-active";
				} else {
					$this->checkinSketchOverride($id);
				}
			}
			$array["checked_out_status"] = $checked_out_status;
			
			
			$sketches[] = new Lists($array);
	  }
		
	  $arr = array("sketches" => $sketches, "items" => $items, "sort" => $sortcur, "perm" => $perm);
	  return $arr;
	}


	function getNavNumItems($id) {
		$perm = $this->getProjectAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		$q = "select count(*) as items from " . CO_TBL_PROJECTS_SKETCHES . " where pid = '$id' and bin != '1' " . $sql;
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		$items = $row['items'];
		return $items;
	}
	

	function checkoutSketch($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_PROJECTS_SKETCHES . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function checkinSketch($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_PROJECTS_SKETCHES . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_PROJECTS_SKETCHES . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}
	
	function checkinSketchOverride($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PROJECTS_SKETCHES . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	

	function getDetails($id, $option = "") {
		global $session, $lang;
		
		$this->_documents = new ProjectsDocumentsModel();
		
		$q = "SELECT a.* FROM " . CO_TBL_PROJECTS_SKETCHES . "  as a where a.id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
				$array[$key] = $val;
			}	
			
		$array["perms"] = $this->getProjectAccess($array["pid"]);
		$array["canedit"] = false;
		$array["showCheckout"] = false;
		$array["checked_out_user_text"] = $this->_contactsmodel->getUserListPlain($array['checked_out_user']);

		if($array["perms"] == "sysadmin" || $array["perms"] == "admin") {
			//if($array["checked_out"] == 1 && $session->checkUserActive($array["checked_out_user"])) {
			if($array["checked_out"] == 1) {
				if($array["checked_out_user"] == $session->uid) {
					$array["canedit"] = true;
				} else if(!$session->checkUserActive($array["checked_out_user"])) {
					$array["canedit"] = $this->checkoutSketch($id);
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
		$array["checked_out_user_phone1"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
		$array["checked_out_user_email"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");

				}
			} else {
				$array["canedit"] = $this->checkoutSketch($id);
			}
		}
		
		// dates
		//$array["item_date"] = $this->_date->formatDate($array["item_date"],CO_DATE_FORMAT);
		//$array["sketch_start"] = $this->_date->formatDate($array["sketch_start"],CO_DATE_FORMAT);
		//$array["sketch_end"] = $this->_date->formatDate($array["sketch_end"],CO_DATE_FORMAT);
		
		
		// time
		$array["today"] = $this->_date->formatDate("now",CO_DATE_FORMAT);
		
		$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		$array["current_user"] = $session->uid;
		
		
		/*$array["doctor_print"] = $this->_contactsmodel->getUserListPlain($array["doctor"]);
		$array["doctor"] = $this->_contactsmodel->getUserList($array['doctor'],'projectsdoctor', "", $array["canedit"]);
		$array["doctor_ct"] = empty($array["doctor_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['doctor_ct'];*/
		
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
		
		// get the diagnoses
		$diagnose = array();
		$q = "SELECT * FROM " . CO_TBL_PROJECTS_SKETCHES_DIAGNOSES . " where mid = '$id' and bin='0' ORDER BY sort";
		$result = mysql_query($q, $this->_db->connection);
		$array["diagnoses"] = mysql_num_rows($result);
		while($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$diagnoses[$key] = $val;
			}
			
			//$diagnoses['canvas'] = base64_encode($diagnoses['canvas']);
			//$diagnoses['canvas'] = str_replace('+',' ',$diagnoses['canvas']);
			$coord = explode('x',$diagnoses["xy"]);
			$diagnoses['x'] = $coord[0];
			$diagnoses['y'] = $coord[1];
			
			$diagnose[] = new Lists($diagnoses);
		}
		
		$sendto = $this->getSendtoDetails("projects_sketches",$id);

		$sketch = new Lists($array);
		$arr = array("sketch" => $sketch, "diagnose" => $diagnose, "sendto" => $sendto, "access" => $array["perms"]);
		return $arr;
   }
   
   
   
   function getSketchProjectID($id) {
		global $session, $lang;
	    $q = "SELECT a.cid FROM " . CO_TBL_PROJECTS . " as a, " . CO_TBL_PROJECTS_SKETCHES . " as b WHERE b.id='$id' and b.pid = a.id";
	    $result = mysql_query($q, $this->_db->connection);
		//$task[] = new Lists($tasks);
		return mysql_result($result,0);
   }


   function setDetails($pid,$id,$title,$canvasList_id,$canvasList_text,$sketch_access,$sketch_access_orig) {
		global $session, $lang;
		
		//$sketchdate = $this->_date->formatDate($sketchdate);
		//$sketchdate =  = $this->_date->formatDateGMT($sketchdate . " " . $time);

		$now = gmdate("Y-m-d H:i:s");
		
		if($sketch_access == $sketch_access_orig) {
			$accesssql = "";
		} else {
			$sketch_access_date = "";
			if($sketch_access == 1) {
				$sketch_access_date = $now;
			}
			$accesssql = "access='$sketch_access', access_date='$sketch_access_date', access_user = '$session->uid',";
		}
		
		$q = "UPDATE " . CO_TBL_PROJECTS_SKETCHES . " set title = '$title', access='$sketch_access', $accesssql edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		// do existing diagnoses
		$canvasList_size = sizeof($canvasList_id);
		foreach ($canvasList_id as $key => $value) {
			$q = "UPDATE " . CO_TBL_PROJECTS_SKETCHES_DIAGNOSES . " set text = '$canvasList_text[$key]' WHERE id='$canvasList_id[$key]'";
			$result = mysql_query($q, $this->_db->connection);
		}
		
		if ($result) {
			//return $id;
			$arr = array("id" => $id);
			return $arr;
		}
   }
   
   function getStatus($id) {
		$q = "SELECT status FROM " . CO_TBL_PROJECTS_SKETCHES . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		return mysql_result($result,0);
	}


   function updateStatus($id,$date,$status) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		if($date == '') {
				$date = $now;
		} else {
			$date = $this->_date->formatDate($date);
		}
		$payment_reminder = $this->_date->addDays($date, CO_INVOICE_REMINDER_DAYS);
		
		$q = "UPDATE " . CO_TBL_PROJECTS_SKETCHES . " set status = '$status', status_date = '$date', invoice_date = '$date', payment_reminder='$payment_reminder', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	
	function updateStatusProject($id) {
		$q = "SELECT a.status FROM " . CO_TBL_PROJECTS . " as a, " . CO_TBL_PROJECTS_SKETCHES . " as b WHERE b.id = '$id' and b.pid = a.id";
		$result = mysql_query($q, $this->_db->connection);
		$status = mysql_result($result,0);
		if($status != 1) {
			return true;
		} else {
			return false;
		}
	}
	
	function checkProjectFinished($id) {
		$q = "SELECT a.status,a.id FROM " . CO_TBL_PROJECTS . " as a, " . CO_TBL_PROJECTS_SKETCHES . " as b WHERE b.id = '$id' and b.pid = a.id";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_row($result);
		$projectstatus = $row[0];
		$pid = $row[1];
		
		$q = "SELECT status from " . CO_TBL_PROJECTS_SKETCHES . " WHERE pid = '$pid' and status !='2' and bin = '0';";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			return false;
		} else {
			if($projectstatus != 2) {
				return true;
			} else {
				return false;
			}
		}
	}


   

   
   


   function createNew($id,$type,$image) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		$time = gmdate("Y-m-d H");

		$q = "INSERT INTO " . CO_TBL_PROJECTS_SKETCHES . " set title = '" . $lang["PROJECT_SKETCH_NEW"] . "', pid = '$id', type='$type', type_image='$image', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		
		//$task = $this->addTask($id,0,0);
		$this->addDiagnose($id,1);
		
		if ($result) {
			return $id;
		}
   }
   

   	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");

		// sketch
		$q = "INSERT INTO " . CO_TBL_PROJECTS_SKETCHES . " (pid,title,type,type_image,created_date,created_user,edited_date,edited_user) SELECT pid,CONCAT(title,' " . $lang["GLOBAL_DUPLICAT"] . "'),type,type_image,'$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_PROJECTS_SKETCHES . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		// diagnose
		$qd = "INSERT INTO " . CO_TBL_PROJECTS_SKETCHES_DIAGNOSES . " (mid,text,canvas,xy,sort) SELECT $id_new,text,canvas,xy,sort FROM " . CO_TBL_PROJECTS_SKETCHES_DIAGNOSES . " where mid='$id' and bin='0'";
		$resultd = mysql_query($qd, $this->_db->connection);
		if ($result) {
			return $id_new;
		}
	}


   function binSketch($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PROJECTS_SKETCHES . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
		  	return true;
		}
   }
   
   function restoreSketch($id) {
		$q = "UPDATE " . CO_TBL_PROJECTS_SKETCHES . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);

		if ($result) {
		  	return true;
		}
   }
   
   function deleteSketch($id) {
		$q = "SELECT id FROM " . CO_TBL_PROJECTS_SKETCHES_DIAGNOSES . " WHERE mid = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$tid = $row["id"];
			$this->deleteSketchDiagnose($tid);
		}
		
		$q = "DELETE FROM co_log_sendto WHERE what='projects_sketches' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_USERS_CHECKPOINTS . " WHERE app = 'projects' and module = 'sketches' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "SELECT type_image FROM " . CO_TBL_PROJECTS_SKETCHES . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$bg = $row["type_image"];
			@unlink(CO_PATH_BASE.'/data/sketches/' . $bg);
		}
		
		$q = "DELETE FROM " . CO_TBL_PROJECTS_SKETCHES . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function toggleIntern($id,$status) {
		global $session;
		$q = "UPDATE " . CO_TBL_PROJECTS_SKETCHES . " set intern = '$status' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }

	function newCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "INSERT INTO " . CO_TBL_USERS_CHECKPOINTS . " SET uid = '$session->uid', date = '$date', app = 'projects', module = 'sketches', app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

 	function updateCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "UPDATE " . CO_TBL_USERS_CHECKPOINTS . " SET date = '$date', status='0' WHERE uid = '$session->uid' and app = 'projects' and module = 'sketches' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

 	function deleteCheckpoint($id){
		global $session;
		$q = "DELETE FROM " . CO_TBL_USERS_CHECKPOINTS . " WHERE uid = '$session->uid'and app = 'projects' and module = 'sketches' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

	function updateCheckpointText($id,$text){
		global $session;
		$q = "UPDATE " . CO_TBL_USERS_CHECKPOINTS . " SET note = '$text' WHERE uid = '$session->uid' and app = 'projects' and module = 'sketches' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

    function getCheckpointDetails($id){
		global $lang;
		$row = "";
		$q = "SELECT a.pid,a.title,b.folder FROM " . CO_TBL_PROJECTS_SKETCHES . " as a, " . CO_TBL_PROJECTS . " as b WHERE a.pid = b.id and a.id='$id' and a.bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		if(mysql_num_rows($result) > 0) {
			$row['checkpoint_app_name'] = $lang["PROJECT_SKETCH_TITLE"];
			$row['app_id'] = $row['pid'];
			$row['app_id_app'] = $id;
		}
		return $row;
   }
   
   function updatePosition($id,$x,$y){
		global $session;
		$q = "UPDATE " . CO_TBL_PROJECTS_SKETCHES_DIAGNOSES . " SET xy = '".$x."x".$y."' WHERE id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }
 
 
  function addDiagnose($mid,$num) {
		global $session, $lang;
		
		$q = "SELECT numofDrawings FROM " . CO_TBL_PROJECTS_SKETCHES . " WHERE  id='$mid'";
		$result = mysql_query($q, $this->_db->connection);
		$numofDrawings = mysql_result($result,0);
		
		
		$now = gmdate("Y-m-d H:i:s");
		$y = $num*30;
		$q = "INSERT INTO " . CO_TBL_PROJECTS_SKETCHES_DIAGNOSES . " set mid='$mid', xy='30x$y', sort='$num', color='$numofDrawings'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		$colorreturn = $numofDrawings;
		$numofDrawings++;
		$q = "UPDATE " . CO_TBL_PROJECTS_SKETCHES . " set numofDrawings='$numofDrawings' WHERE id='$mid'";
		$result = mysql_query($q, $this->_db->connection);
		
		$arr = array("id" => $id, "numofDrawings" => $colorreturn);
		return $arr;
		
		//return $id;
   }
   
  function binDiagnose($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_PROJECTS_SKETCHES_DIAGNOSES . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);	
		return true;
   }


   function deleteSketchDiagnose($id) {
		global $session;
		$q = "DELETE FROM " . CO_TBL_PROJECTS_SKETCHES_DIAGNOSES . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }
   
   
    function restoreSketchDiagnose($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PROJECTS_SKETCHES_DIAGNOSES . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }
   
   function saveDrawing($id,$img) {
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		
		$img = str_replace(' ','+',$img);
		//$img = base64_decode($img);
		$q = "UPDATE " . CO_TBL_PROJECTS_SKETCHES_DIAGNOSES . " set canvas='$img' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);	
		return true;
   }
   
   	
	 
	
	
	
	
	
	
	
	
	function getLast10Sketches() {
		global $session;
		//$sketches = $this->getUserArray($this->getUserSetting("last-used-sketches"));
		$sketches = $this->getSketchesArray($this->getUserSetting("last-used-sketches"));
	  return $sketches;
	}
	
	function saveLastUsedSketches($id) {
		global $session;
		$string = $id . "," .$this->getUserSetting("last-used-sketches");
		$string = rtrim($string, ",");
		$ids_arr = explode(",", $string);
		$res = array_unique($ids_arr);
		foreach ($res as $key => $value) {
			$ids_rtn[] = $value;
		}
		array_splice($ids_rtn, 7);
		$str = implode(",", $ids_rtn);
		
		$this->setUserSetting("last-used-sketches",$str);
	  return true;
	}
	
	
}
?>
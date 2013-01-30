<?php

class PatientsTreatmentsModel extends PatientsModel {
	
	public function __construct() {  
     	parent::__construct();
		//$this->_phases = new PatientsPhasesModel();
		$this->_contactsmodel = new ContactsModel();
	}


	function getList($id,$sort) {
		global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("patients-treatments-sort-status",$id);
		  if(!$sortstatus) {
				$order = "order by item_date DESC";
				$sortcur = '1';
		  } else {
			  switch($sortstatus) {
				  case "1":
				  		$order = "order by item_date DESC";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by item_date ASC";
							$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("patients-treatments-sort-order",$id);
				  		if(!$sortorder) {
								$order = "order by item_date DESC";
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
				  		$order = "order by item_date DESC";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by item_date ASC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("patients-treatments-sort-order",$id);
				  		if(!$sortorder) {
						  	$order = "order by item_date DESC";
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
		
		$q = "select id,title,item_date,access,status,checked_out,checked_out_user from " . CO_TBL_PATIENTS_TREATMENTS . " where pid = '$id' and bin != '1' " . $sql . $order;
		$this->setSortStatus("patients-treatments-sort-status",$sortcur,$id);
		$result = mysql_query($q, $this->_db->connection);
		$items = mysql_num_rows($result);
		
		$treatments = "";
		while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			
			// dates
			$array["item_date"] = $this->_date->formatDate($array["item_date"],CO_DATE_FORMAT);
			
			// access
			$accessstatus = "";
			if($perm !=  "guest") {
				if($array["access"] == 1) {
					$accessstatus = " module-access-active";
				}
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
			
			$checked_out_status = "";
			if($perm !=  "guest" && $array["checked_out"] == 1 && $array["checked_out_user"] != $session->uid) {
				if($session->checkUserActive($array["checked_out_user"])) {
					$checked_out_status = "icon-checked-out-active";
				} else {
					$this->checkinTreatmentOverride($id);
				}
			}
			$array["checked_out_status"] = $checked_out_status;
			
			
			$treatments[] = new Lists($array);
	  }
		
	  $arr = array("treatments" => $treatments, "items" => $items, "sort" => $sortcur, "perm" => $perm);
	  return $arr;
	}


	function getNavNumItems($id) {
		$perm = $this->getPatientAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		$q = "select count(*) as items from " . CO_TBL_PATIENTS_TREATMENTS . " where pid = '$id' and bin != '1' " . $sql;
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		$items = $row['items'];
		return $items;
	}
	

	function checkoutTreatment($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}
	
	
	function checkinTreatment($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_PATIENTS_TREATMENTS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}
	
	function checkinTreatmentOverride($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	

	function getDetails($id, $option = "") {
		global $session, $lang;
		
		$this->_documents = new PatientsDocumentsModel();
		
		$q = "SELECT a.*,(SELECT MIN(item_date) FROM " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " as b WHERE b.mid=a.id and b.bin='0') as treatment_start,(SELECT MAX(item_date) FROM " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " as b WHERE b.mid=a.id and b.bin='0') as treatment_end FROM " . CO_TBL_PATIENTS_TREATMENTS . "  as a where a.id = '$id'";
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
					$array["canedit"] = $this->checkoutTreatment($id);
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
		$array["checked_out_user_phone1"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
		$array["checked_out_user_email"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");

				}
			} else {
				$array["canedit"] = $this->checkoutTreatment($id);
			}
		}
		
		// dates
		$array["item_date"] = $this->_date->formatDate($array["item_date"],CO_DATE_FORMAT);
		$array["treatment_start"] = $this->_date->formatDate($array["treatment_start"],CO_DATE_FORMAT);
		$array["treatment_end"] = $this->_date->formatDate($array["treatment_end"],CO_DATE_FORMAT);
		
		
		// time
		$array["today"] = $this->_date->formatDate("now",CO_DATE_FORMAT);
		
		$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);
		$array["current_user"] = $session->uid;
		
		
		$array["doctor_print"] = $this->_contactsmodel->getUserListPlain($array["doctor"]);
		$array["doctor"] = $this->_contactsmodel->getUserList($array['doctor'],'patientsdoctor', "", $array["canedit"]);
		$array["doctor_ct"] = empty($array["doctor_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['doctor_ct'];
		
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
		$array["status_planned_active"] = "";
		$array["status_inprogress_active"] = "";
		$array["status_finished_active"] = "";
		$array["status_stopped_active"] = "";
		//$array["status_date"] = $this->_date->formatDate($array["status_date"],CO_DATE_FORMAT);
		$array["status_date"] = "";
		$array["status_text_time"] = "";
		switch($array["status"]) {
			case "0":
				$array["status_text"] = $lang["PATIENT_TREATMENT_STATUS_PLANNED"];
				$array["status_planned_active"] = " active";
			break;
			case "1":
				$array["status_text"] = $lang["PATIENT_TREATMENT_STATUS_INPROGRESS"];
				$array["status_inprogress_active"] = " active";
			break;
			case "2":
				$array["status_text"] = $lang["PATIENT_TREATMENT_STATUS_FINISHED"];
				$array["status_finished_active"] = " active";
				break;
			case "3":
				$array["status_text"] = $lang["PATIENT_TREATMENT_STATUS_STOPPED"];
				$array["status_stopped_active"] = " active";
			break;
		}
		
		
		
		// checkpoint
		/*$array["checkpoint"] = 0;
		$array["checkpoint_date"] = "";
		$array["checkpoint_note"] = "";
		$q = "SELECT date,note FROM " . CO_TBL_USERS_CHECKPOINTS . " where uid='$session->uid' and app = 'patients' and module = 'treatments' and app_id = '$id' LIMIT 1";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			while ($row = mysql_fetch_assoc($result)) {
			$array["checkpoint"] = 1;
			$array["checkpoint_date"] = $this->_date->formatDate($row['date'],CO_DATE_FORMAT);
			$array["checkpoint_note"] = $row['note'];
			}
		}*/
		
		// get the tasks
		$task = array();
		$q = "SELECT * FROM " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " where mid = '$id' and bin='0' ORDER BY sort";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$tasks[$key] = $val;
			}
			$tasks["time"] = $this->_date->formatDate($tasks["item_date"],CO_TIME_FORMAT);
			$tasks["item_date"] = $this->_date->formatDate($tasks["item_date"],CO_DATE_FORMAT);
			$tasks["team"] = $this->_contactsmodel->getUserList($tasks['team'],'task_team_'.$tasks["id"], "", $array["canedit"]);
			$tasks["team_ct"] = empty($tasks["team_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $tasks['team_ct'];
			if($tasks["type"] == 0) {
				$tasks["min"] = "";
				$tasks["type"] = "";
			} else {
				
				$tasks["min"] = $this->getTreatmentTypeMin($tasks["type"]);
				$tasks["type"] = $this->getTreatmentTypeName($tasks["type"],'treatmenttype');
				//$tasks["min"] = "";
			}
			$tasks["place"] = $this->_contactsmodel->getPlaceList($tasks['place'],'place', $array["canedit"]);
			
			$task[] = new Lists($tasks);
		}
		
		
		// get the diagnoses
		$diagnose = array();
		$q = "SELECT * FROM " . CO_TBL_PATIENTS_TREATMENTS_DIAGNOSES . " where mid = '$id' and bin='0' ORDER BY sort";
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
		
		$sendto = $this->getSendtoDetails("patients_treatments",$id);

		$treatment = new Lists($array);
		$arr = array("treatment" => $treatment, "diagnose" => $diagnose, "task" => $task, "sendto" => $sendto, "access" => $array["perms"]);
		return $arr;
   }


   function setDetails($pid,$id,$title,$treatmentdate,$protocol,$protocol2,$protocol3,$doctor,$doctor_ct,$task_id,$task_title,$task_date,$task_time,$task_text,$task,$task_team,$task_team_ct,$task_treatmenttype,$task_place,$canvasList_id,$canvasList_text,$treatment_access,$treatment_access_orig) {
		global $session, $lang;
		
		$treatmentdate = $this->_date->formatDate($treatmentdate);
		//$treatmentdate =  = $this->_date->formatDateGMT($treatmentdate . " " . $time);

		$now = gmdate("Y-m-d H:i:s");
		
		if($treatment_access == $treatment_access_orig) {
			$accesssql = "";
		} else {
			$treatment_access_date = "";
			if($treatment_access == 1) {
				$treatment_access_date = $now;
			}
			$accesssql = "access='$treatment_access', access_date='$treatment_access_date', access_user = '$session->uid',";
		}
		
		$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS . " set title = '$title', item_date = '$treatmentdate', protocol='$protocol', protocol2='$protocol2', protocol3='$protocol3', doctor='$doctor', doctor_ct='$doctor_ct', access='$treatment_access', $accesssql edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		// do existing diagnoses
		$canvasList_size = sizeof($canvasList_id);
		foreach ($canvasList_id as $key => $value) {
			$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS_DIAGNOSES . " set text = '$canvasList_text[$key]' WHERE id='$canvasList_id[$key]'";
			$result = mysql_query($q, $this->_db->connection);
		}
		
		
		// do existing tasks
		$task_size = sizeof($task_id);
		foreach ($task_id as $key => $value) {
			if (is_array($task)) {
				if (in_array($task_id[$key], $task) == true) {
					$checked_items[$key] = '1';
				} else {
					$checked_items[$key] = '0';
				}
			} else {
				$checked_items[$key] = '0';
			}
			//echo $task_date[$key]. " " . $task_time[$key];
			$item_date = $this->_date->formatDateGMT($task_date[$key]. " " . $task_time[$key]);

			//$$this->_date->formatDateGMT($treatmentdate . " " . $time);
			if(isset($task_team[$key])) {
				$task_team_i = $this->_contactsmodel->sortUserIDsByName($task_team[$key]);
			} else {
				$task_team_i = "";
			}
			
			if(isset($task_team_ct[$key])) {
				$task_team_ct_i = $task_team_ct[$key];
			} else {
				$task_team_ct_i = "";
			}
			
			
			
			
			$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " set status = '$checked_items[$key]', title = '$task_title[$key]', text = '$task_text[$key]', team = '$task_team_i', team_ct = '$task_team_ct_i', item_date = '$item_date', type='$task_treatmenttype[$key]', place='$task_place[$key]' WHERE id='$task_id[$key]'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return $id;
		}
   }


   function updateStatus($id,$date,$status) {
		global $session, $lang;
		
		$date = $this->_date->formatDate($date);
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "SELECT title FROM " . CO_TBL_PATIENTS_TREATMENTS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		
		$title_change = $title;
		
		$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS . " set title = '$title_change', status = '$status', status_date = '$date', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			$arr = array("id" => $id, "what" => "edit");
		}
		
		// posponed
		/*if($status == 3) {
			$this->checkinTreatment($id);
			$q = "INSERT INTO " . CO_TBL_PATIENTS_TREATMENTS . " (pid,title,item_date,start,end,location,location_ct,length,management,management_ct,participants,participants_ct,status,status_date,created_date,created_user,edited_date,edited_user) SELECT pid,'$title','$date',start,end,location,location_ct,length,management,management_ct,participants,participants_ct,0,'$now','$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_PATIENTS_TREATMENTS . " where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
			if ($result) {
				$nid = mysql_insert_id();
				// do tasks
				$qt = "INSERT INTO " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " (mid,status,title,text,sort) SELECT '$nid',status,title,text,sort FROM " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " where mid='$id'";
				$resultt = mysql_query($qt, $this->_db->connection);
				$arr = array("id" => $nid, "what" => "reload");
			}
		}*/
		return $arr;
	}

function getTreatmentTypeName($string,$field){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			/*if($field == "treatmenttype") {
				$q = "SELECT id, positionstext, name from " . CO_TBL_PATIENTS_TREATMENTS_DIALOG . " where id = '$value'";
				$result_user = mysql_query($q, $this->_db->connection);
				while($row_user = mysql_fetch_assoc($result_user)) {
					$users .= '<span class="listmember-outer"><a class="listmemberTreatmentType" uid="' . $row_user["id"] . '">' . $row_user["positionstext"] . ' ' . $row_user["name"] . '</a></div>';
					if($i < $users_total) {
						$users .= ', ';
					}
				}
			} else {*/
				$q = "SELECT id, positionstext, name from " . CO_TBL_PATIENTS_TREATMENTS_DIALOG . " where id = '$value'";
				$result_user = mysql_query($q, $this->_db->connection);
				while($row_user = mysql_fetch_assoc($result_user)) {
					$users .= '<span class="listmember" uid="' . $row_user["id"] . '">' . $row_user["positionstext"] . ' ' . $row_user["name"] . '</span>';
					if($i < $users_total) {
						$users .= ', ';
					}
				}
			//}
			$i++;
			
		}
		return $users;
   }
   
function getTreatmentTypeMin($string){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
				$q = "SELECT id, minutes from " . CO_TBL_PATIENTS_TREATMENTS_DIALOG . " where id = '$value'";
				$result_user = mysql_query($q, $this->_db->connection);
				while($row_user = mysql_fetch_assoc($result_user)) {
					$users .= $row_user["minutes"];
					if($i < $users_total) {
						$users .= ', ';
					}
				}
			//}
			$i++;
			
		}
		return $users;
   }


   function createNew($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		$time = gmdate("Y-m-d H");
		
		$q = "INSERT INTO " . CO_TBL_PATIENTS_TREATMENTS . " set title = '" . $lang["PATIENT_TREATMENT_NEW"] . "', item_date='$now', pid = '$id', status = '0', status_date = '$now', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
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

		// treatment
		$q = "INSERT INTO " . CO_TBL_PATIENTS_TREATMENTS . " (pid,title,item_date,doctor,doctor_ct,protocol,protocol2,protocol3,status_date,created_date,created_user,edited_date,edited_user) SELECT pid,CONCAT(title,' " . $lang["GLOBAL_DUPLICAT"] . "'),'$now',doctor,doctor_ct,protocol,protocol2,protocol3,'$now','$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_PATIENTS_TREATMENTS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		// tasks
		$qt = "INSERT INTO " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " (mid,title,type,team,team_ct,place,place_ct,item_date,text,sort) SELECT $id_new,title,type,team,team_ct,place,place_ct,'$now',text,sort FROM " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " where mid='$id' and bin='0'";
		$resultt = mysql_query($qt, $this->_db->connection);
		// diagnose
		$qd = "INSERT INTO " . CO_TBL_PATIENTS_TREATMENTS_DIAGNOSES . " (mid,text,canvas,xy,sort) SELECT $id_new,text,canvas,xy,sort FROM " . CO_TBL_PATIENTS_TREATMENTS_DIAGNOSES . " where mid='$id' and bin='0'";
		$resultd = mysql_query($qd, $this->_db->connection);
		if ($result) {
			return $id_new;
		}
	}


   function binTreatment($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function restoreTreatment($id) {
		$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deleteTreatment($id) {
		$q = "SELECT id FROM " . CO_TBL_PATIENTS_TREATMENTS_DIAGNOSES . " WHERE mid = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$tid = $row["id"];
			$this->deleteTreatmentDiagnose($tid);
		}
		
		$q = "SELECT id FROM " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " WHERE mid = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$tid = $row["id"];
			$this->deleteTreatmentTask($tid);
		}
		
		$q = "DELETE FROM co_log_sendto WHERE what='patients_treatments' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_USERS_CHECKPOINTS . " WHERE app = 'patients' and module = 'treatments' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_PATIENTS_TREATMENTS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function toggleIntern($id,$status) {
		global $session;
		$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS . " set intern = '$status' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function addTask($mid,$num,$sort) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:00");
		
		$q = "INSERT INTO " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " set mid='$mid', item_date='$now', status = '0', title = '" . $lang["PATIENT_TREATMENT_TASK_NEW"] . "',  team='$session->uid', sort='$sort'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		
		$task = array();
		$q = "SELECT * FROM " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$tasks[$key] = $val;
			}
			
			$tasks["time"] = $this->_date->formatDate($tasks["item_date"],CO_TIME_FORMAT);
			$tasks["item_date"] = $this->_date->formatDate($tasks["item_date"],CO_DATE_FORMAT);
			$tasks["team"] = $this->_contactsmodel->getUserList($tasks['team'],'task_team_'.$tasks["id"], "", 1);
			$tasks["team_ct"] = "";
			$tasks["min"] = "";
			$tasks["type"] = "";

			$tasks["place"] = "";
			
			$tasks["today"] = $this->_date->formatDate("now",CO_DATE_FORMAT);
			$task[] = new Lists($tasks);
		}
		
		  	return $task;
   }


   function deleteTask($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }
   
   function restoreTreatmentTask($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }
   
   function deleteTreatmentTask($id) {
		global $session;
		$q = "DELETE FROM " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }

	function newCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "INSERT INTO " . CO_TBL_USERS_CHECKPOINTS . " SET uid = '$session->uid', date = '$date', app = 'patients', module = 'treatments', app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

 	function updateCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "UPDATE " . CO_TBL_USERS_CHECKPOINTS . " SET date = '$date', status='0' WHERE uid = '$session->uid' and app = 'patients' and module = 'treatments' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

 	function deleteCheckpoint($id){
		global $session;
		$q = "DELETE FROM " . CO_TBL_USERS_CHECKPOINTS . " WHERE uid = '$session->uid'and app = 'patients' and module = 'treatments' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

	function updateCheckpointText($id,$text){
		global $session;
		$q = "UPDATE " . CO_TBL_USERS_CHECKPOINTS . " SET note = '$text' WHERE uid = '$session->uid' and app = 'patients' and module = 'treatments' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

    function getCheckpointDetails($id){
		global $lang;
		$row = "";
		$q = "SELECT a.pid,a.title,b.folder FROM " . CO_TBL_PATIENTS_TREATMENTS . " as a, " . CO_TBL_PATIENTS . " as b WHERE a.pid = b.id and a.id='$id' and a.bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		if(mysql_num_rows($result) > 0) {
			$row['checkpoint_app_name'] = $lang["PATIENT_TREATMENT_TITLE"];
			$row['app_id'] = $row['pid'];
			$row['app_id_app'] = $id;
		}
		return $row;
   }
   
   function updatePosition($id,$x,$y){
		global $session;
		$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS_DIAGNOSES . " SET xy = '".$x."x".$y."' WHERE id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }
 
 
  function addDiagnose($mid,$num) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		$y = $num*30;
		$q = "INSERT INTO " . CO_TBL_PATIENTS_TREATMENTS_DIAGNOSES . " set mid='$mid', xy='30x$y', sort='$num'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();		
		return $id;
   }
   
  function binDiagnose($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS_DIAGNOSES . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);	
		return true;
   }


   function deleteTreatmentDiagnose($id) {
		global $session;
		$q = "DELETE FROM " . CO_TBL_PATIENTS_TREATMENTS_DIAGNOSES . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }
   
   
    function restoreTreatmentDiagnose($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS_DIAGNOSES . " set bin = '0' WHERE id='$id'";
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
		$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS_DIAGNOSES . " set canvas='$img' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);	
		return true;
   }
   
   	function getTreatmentsTypeDialog($field) {
		global $session;
		$str = '<div class="dialog-text">';
		$q ="select id, positionstext, name from " . CO_TBL_PATIENTS_TREATMENTS_DIALOG . " ORDER BY positionstext ASC";
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$str .= '<a href="#" class="insertFromDialog" min="90" title="' . $row["positionstext"] . " " . $row["name"] . '" field="'.$field.'" gid="'.$row["id"].'">' . $row["positionstext"] . " " . $row["name"] . '</a>';
		}
		$str .= '</div>';	
		return $str;
	 }

}
?>
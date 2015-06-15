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
			
		$patientid = $array["pid"];
		
		$q = "SELECT b.id as patient_id, b.lastname,b.firstname,b.title as ctitle,b.title2,b.position,b.phone1,b.email,b.address_line1,b.address_line2,b.address_town,b.address_postcode FROM " . CO_TBL_PATIENTS . " as a, co_users as b where a.cid=b.id and a.id = '$patientid'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}	
		$array['patient'] = $array['lastname'] . ' ' . $array['firstname'];
			
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
		
		$array["method"] = $this->getTreamentIdDetails($array["method"]);
		
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
		$array["checkpoint"] = 0;
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
		}
		
		// get the tasks
		$array['totalcosts'] = 0;
		$array['sessioncount'] = array();
		$task = array();
		
		// get all tasks not in bin
		if(CO_PHYSIO_COMBAT) {
			$q = "SELECT id FROM " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " where mid = '$id' and bin='0' ORDER BY item_date ASC";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				// check for calendar entry
				$eventid = $row['id'];
				$q_event = "SELECT id FROM oc_clndr_objects WHERE eventid = '$eventid'";
				$result_event = mysql_query($q_event, $this->_db->connection);
				
				// calendar exists
				if(mysql_num_rows($result_event) > 0) {
					$q_task = "SELECT a.id,a.mid,a.status,a.type,a.text,a.item_date, b.eventlocation,b.eventlocationuid,b.startdate,b.enddate, b.id as eventid, c.id as calendarid, c.displayname, d.couid FROM " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " as a, oc_clndr_objects as b, oc_clndr_calendars as c, oc_users as d WHERE a.id = '$eventid' and b.calendarid = c.id and c.userid=d.uid and a.bin='0' and b.eventid = '$eventid'";
					$result_task = mysql_query($q_task, $this->_db->connection);
					while($row_task = mysql_fetch_array($result_task)) {
						foreach($row_task as $key => $val) {
							$tasks[$key] = $val;
						}
						//$tasks["time"] = $this->_date->formatDate($tasks["item_date"],CO_TIME_FORMAT);
						//$tasks["item_date"] = $this->_date->formatDate($tasks["item_date"],CO_DATE_FORMAT);
						$tasks["calendarlink"] = true;
						$tasks['linkyear'] = $this->_date->formatDate($tasks["startdate"],'Y');
						$tasks['linkmonth'] = $this->_date->formatDate($tasks["startdate"],'n')-1;
						$tasks['linkday'] = $this->_date->formatDate($tasks["startdate"],'d');
						//$tasks["time"] = $this->_date->formatDate($tasks["startdate"],CO_TIME_FORMAT);
						$tasks["time"] = new DateTime($tasks["startdate"]);
						$tasks["time"] = $tasks["time"]->format('H:i');
						$tasks["startdate"] = $this->_date->formatDate($tasks["startdate"],CO_DATE_FORMAT);

						if($tasks['calendarid'] == 2) {
							$tasks['displayname'] = $lang["CALENDAR_OFFICE_CALENDAR"];
						}
						//$date = new DateTime($array['startdate']);
						//$array['startdate'] = $date->format('d.m.Y');
						//$array['starttime'] = $date->format('H:i');
						//$array['linkyear'] = $date->format('Y');
						//$array['linkmonth'] = $date->format('n')-1;
						//$array['linkday'] = $date->format('d');
						if($tasks["eventlocation"] != 0) {
							$tasks["location"] = $this->getTreatmentLocation($tasks["eventlocation"]);
						}
						if($tasks["eventlocationuid"] != 0) {
							$tasks["location"] = $this->_contactsmodel->getPlaceListPlain($tasks["eventlocationuid"],'location', false);
						}
						$tasks["item_date"] = $this->_date->formatDate($tasks["item_date"],CO_DATE_FORMAT);
						//$tasks["item_invoice_date"] = $this->_date->formatDate($tasks["item_date"],CO_DATE_FORMAT);
						//$tasks["team"] = $this->_contactsmodel->getUserList($tasks['team'],'treatments_task_team_'.$tasks["id"], "", $array["canedit"]);
						//$tasks["team_ct"] = empty($tasks["team_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $tasks['team_ct'];
						if($tasks["type"] == '') {
							$tasks["min"] = 0;
							$tasks["costs"] = 0;
							$tasks["type"] = '';
							$array['sessions'] = array();
						} else {
							
							$tasks["min"] = $this->getTreatmentTypeMin($tasks["type"]);
							$tasks["costs"] = $this->getTreatmentTypeCosts($tasks["type"]);
							$array['sessions'] = explode(',',$tasks['type']);
							
							$tasks["type"] = $this->getTreatmentList($tasks['type'],'task_treatmenttype_'.$tasks["id"], "", $array["canedit"]);
						}
						//$tasks["place"] = $this->_contactsmodel->getPlaceList($tasks['place'],'place', $array["canedit"]);
	
					}
					if($tasks["status"] == 1) {
						$array['sessioncount'] = array_merge($array['sessioncount'],$array['sessions']);
					}
					
					$array['totalcosts'] += $tasks["costs"];
					$task[] = new Lists($tasks);
					
				} else {
					$q_task = "SELECT * FROM " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " where id='$eventid'";
					$result_task = mysql_query($q_task, $this->_db->connection);
					while($row_task = mysql_fetch_array($result_task)) {
						foreach($row_task as $key => $val) {
							$tasks[$key] = $val;
						}
						$tasks["time"] = $this->_date->formatDate($tasks["item_date"],CO_TIME_FORMAT);
						$tasks["item_date"] = $this->_date->formatDate($tasks["item_date"],CO_DATE_FORMAT);
						$tasks["startdate"] = $tasks["item_date"];
						$tasks['displayname'] = $this->_contactsmodel->getUserListPlain($tasks['team'],'treatments_task_team_'.$tasks["id"], "", $array["canedit"]);
						//$tasks["team"] = $this->_contactsmodel->getUserList($tasks['team'],'treatments_task_team_'.$tasks["id"], "", $array["canedit"]);
						//$tasks["team_ct"] = empty($tasks["team_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $tasks['team_ct'];
						if($tasks["type"] == '') {
							$tasks["min"] = 0;
							$tasks["costs"] = 0;
							$tasks["type"] = '';
							$array['sessions'] = array();
						} else {
							
							$tasks["min"] = $this->getTreatmentTypeMin($tasks["type"]);
							$tasks["costs"] = $this->getTreatmentTypeCosts($tasks["type"]);
							$array['sessions'] = explode(',',$tasks['type']);
							
							$tasks["type"] = $this->getTreatmentList($tasks['type'],'task_treatmenttype_'.$tasks["id"], "", $array["canedit"]);
						}
						$tasks["calendarlink"] = false;
						$tasks["location"] = $this->_contactsmodel->getPlaceList($tasks['place'],'place', $array["canedit"]);
						$tasks['linkyear'] = 0;
						$tasks['linkmonth'] = 0;
						$tasks['linkday'] = 0;
						//$tasks["time"] = $this->_date->formatDate($tasks["item_date"],CO_TIME_FORMAT);
						//$tasks["startdate"] = $this->_date->formatDate($tasks["item_date"],CO_DATE_FORMAT);
						
					}
					if($tasks["status"] == 1) {
						$array['sessioncount'] = array_merge($array['sessioncount'],$array['sessions']);
					}
					$array['totalcosts'] += $tasks["costs"];
						$task[] = new Lists($tasks);
				}
				
			}
		} // CO_PHYSIO_COMBAT END

		else {
			// get all calendar tasks
			$q = "SELECT a.id,a.mid,a.status,a.type,a.text,a.item_date, b.eventlocation,b.eventlocationuid,b.startdate,b.enddate, b.id as eventid, c.id as calendarid, c.displayname, d.couid FROM " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " as a, oc_clndr_objects as b, oc_clndr_calendars as c, oc_users as d where a.mid = '$id' and b.calendarid = c.id and c.userid=d.uid and a.bin='0' and b.eventid = a.id ORDER BY b.startdate ASC";
			$result = mysql_query($q, $this->_db->connection);
			while($row = mysql_fetch_array($result)) {
				foreach($row as $key => $val) {
					$tasks[$key] = $val;
				}
				//$tasks["time"] = $this->_date->formatDate($tasks["item_date"],CO_TIME_FORMAT);
				//$tasks["item_date"] = $this->_date->formatDate($tasks["item_date"],CO_DATE_FORMAT);
				$tasks["calendarlink"] = true;
				$tasks['linkyear'] = $this->_date->formatDate($tasks["startdate"],'Y');
				$tasks['linkmonth'] = $this->_date->formatDate($tasks["startdate"],'n')-1;
				$tasks['linkday'] = $this->_date->formatDate($tasks["startdate"],'d');
				//$tasks["time"] = $this->_date->formatDate($tasks["startdate"],CO_TIME_FORMAT);
				$tasks["time"] = new DateTime($tasks["startdate"]);
				$tasks["time"] = $tasks["time"]->format('H:i');
				$tasks["startdate"] = $this->_date->formatDate($tasks["startdate"],CO_DATE_FORMAT);
				
				if($tasks['calendarid'] == 2) {
					$tasks['displayname'] = $lang["CALENDAR_OFFICE_CALENDAR"];
				}
				//$date = new DateTime($array['startdate']);
				//$array['startdate'] = $date->format('d.m.Y');
				//$array['starttime'] = $date->format('H:i');
				//$array['linkyear'] = $date->format('Y');
				//$array['linkmonth'] = $date->format('n')-1;
				//$array['linkday'] = $date->format('d');
				if($tasks["eventlocation"] != 0) {
					$tasks["location"] = $this->getTreatmentLocation($tasks["eventlocation"]);
				}
				if($tasks["eventlocationuid"] != 0) {
					$tasks["location"] = $this->_contactsmodel->getPlaceListPlain($tasks["eventlocationuid"],'location', false);
				}
				$tasks["item_date"] = $this->_date->formatDate($tasks["item_date"],CO_DATE_FORMAT);
				//$tasks["item_invoice_date"] = $this->_date->formatDate($tasks["item_date"],CO_DATE_FORMAT);
				//$tasks["team"] = $this->_contactsmodel->getUserList($tasks['team'],'treatments_task_team_'.$tasks["id"], "", $array["canedit"]);
				//$tasks["team_ct"] = empty($tasks["team_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $tasks['team_ct'];
				if($tasks["type"] == '') {
					$tasks["min"] = 0;
					$tasks["costs"] = 0;
					$tasks["type"] = '';
					$array['sessions'] = array();
				} else {
					
					$tasks["min"] = $this->getTreatmentTypeMin($tasks["type"]);
					$tasks["costs"] = $this->getTreatmentTypeCosts($tasks["type"]);
					$array['sessions'] = explode(',',$tasks['type']);
					
					$tasks["type"] = $this->getTreatmentList($tasks['type'],'task_treatmenttype_'.$tasks["id"], "", $array["canedit"]);
				}
				//$tasks["place"] = $this->_contactsmodel->getPlaceList($tasks['place'],'place', $array["canedit"]);
				//$array['sessioncount'] = [10];
				if($tasks["status"] == 1) {
					$array['sessioncount'] = array_merge($array['sessioncount'],$array['sessions']);
				}
				
				$array['totalcosts'] += $tasks["costs"];
				$task[] = new Lists($tasks);
			}
		}
		
		$array['sessionvals'] = array_count_values($array['sessioncount']);
		$array['sessionvalstext'] = '';
		$j = sizeof($array['sessionvals']);
		$i = 1;
		foreach($array['sessionvals'] as $num => $count) {
			$array['sessionvalstext'] .= $count . ' x ' . $this->getTreatmentSessionTitleSingle($num);
			if($i < $j) { 
				$array['sessionvalstext'] .= ', ';
			}
			$i++;
		}
		
		/*
		OLD tasks
		$array['totalcosts'] = 0;
		$task = array();
		$q = "SELECT * FROM " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " where mid = '$id' and bin='0' ORDER BY item_date ASC";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$tasks[$key] = $val;
			}
			$tasks["time"] = $this->_date->formatDate($tasks["item_date"],CO_TIME_FORMAT);
			$tasks["item_date"] = $this->_date->formatDate($tasks["item_date"],CO_DATE_FORMAT);
			$tasks["team"] = $this->_contactsmodel->getUserList($tasks['team'],'treatments_task_team_'.$tasks["id"], "", $array["canedit"]);
			$tasks["team_ct"] = empty($tasks["team_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $tasks['team_ct'];
			if($tasks["type"] == '') {
				$tasks["min"] = 0;
				$tasks["costs"] = 0;
				$tasks["type"] = '';
			} else {
				
				$tasks["min"] = $this->getTreatmentTypeMin($tasks["type"]);
				$tasks["costs"] = $this->getTreatmentTypeCosts($tasks["type"]);
				$tasks["type"] = $this->getTreatmentList($tasks['type'],'task_treatmenttype_'.$tasks["id"], "", $array["canedit"]);
			}
			$tasks["place"] = $this->_contactsmodel->getPlaceList($tasks['place'],'place', $array["canedit"]);
			$array['totalcosts'] += $tasks["costs"];
			$task[] = new Lists($tasks);
		}*/
		
		if($array['discount'] != 0) {
			$array['totalcosts'] = $array['totalcosts']-(($array['totalcosts']/100)*$array['discount']);
		}
		if($array['vat'] != 0) {
			$array['totalcosts'] = $array['totalcosts']+(($array['totalcosts']/100)*$array['vat']);
		}
		$array['totalcosts'] = number_format($array['totalcosts'],2,',','.');
		
		// get the diagnoses
		/*$diagnose = array();
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
		}*/
		
		$sendto = $this->getSendtoDetails("patients_treatments",$id);

		$treatment = new Lists($array);
		$arr = array("treatment" => $treatment, "task" => $task, "sendto" => $sendto, "access" => $array["perms"]);
		return $arr;
   }
   
   function getTreatmentEvent($id, $shortfirst = 0) {
		global $session, $lang;
	   $tasks = array();
	   $q = "SELECT a.title,c.id,c.folder,d.title as foldertitle,b.mid,c.cid  FROM " . CO_TBL_PATIENTS_TREATMENTS . " as a, " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " as b, " . CO_TBL_PATIENTS . " as c, " . CO_TBL_PATIENTS_FOLDERS . " as d WHERE b.id='$id' and b.mid = a.id and a.pid=c.id and c.folder = d.id";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
		while($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$tasks[$key] = $val;
			}
			if($shortfirst == 1) {
				$tasks['patient'] = $this->_contactsmodel->getUserFullnameShortFirstname($tasks['cid']);
			} else {
				$tasks['patient'] = $this->_contactsmodel->getUserFullname($tasks['cid']);
			}
		}
		}
		
		//$task[] = new Lists($tasks);
		return $tasks;
   }
   
   function getTreatmentPatientID($id) {
		global $session, $lang;
	    $q = "SELECT a.cid FROM " . CO_TBL_PATIENTS . " as a, " . CO_TBL_PATIENTS_TREATMENTS . " as b WHERE b.id='$id' and b.pid = a.id";
	    $result = mysql_query($q, $this->_db->connection);
		//$task[] = new Lists($tasks);
		return mysql_result($result,0);
   }
   
   function getTreatmentLocation($id) {
		global $session, $lang;
	    $q = "SELECT name FROM " . CO_TBL_PATIENTS_TREATMENTS_LOCATIONS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$name = mysql_result($result,0);
		return $name;
   }
   
   function getTreatmentLocations() {
		global $session, $lang;
	    $locations = array();
		$q = "SELECT * FROM " . CO_TBL_PATIENTS_TREATMENTS_LOCATIONS;
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			//foreach($row as $key => $val) {
				$locations[$row['id']] = $row['name'];
			//}
		}
		return $locations;
   }
   
   
   function getTreamentIdDetails($string){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
			//if($field == "patientsmethod") {
				$q = "SELECT id, name from " . CO_TBL_PATIENTS_TREATMENTS_METHODS . " where id = '$value'";
				$result_user = mysql_query($q, $this->_db->connection);
				while($row_user = mysql_fetch_assoc($result_user)) {
					$users .= '<span class="listmember-outer"><span class="listmember" uid="' . $row_user["id"] . '">' . $row_user["name"] . '</span></div>';
					if($i < $users_total) {
						$users .= ', ';
					}
				}
			/*} else {
				$q = "SELECT id, name from " . CO_TBL_PATIENTS_DIALOG_PATIENTS . " where id = '$value'";
				$result_user = mysql_query($q, $this->_db->connection);
				while($row_user = mysql_fetch_assoc($result_user)) {
					$users .= '<span class="listmember" uid="' . $row_user["id"] . '">' . $row_user["name"] . '</span>';
					if($i < $users_total) {
						$users .= ', ';
					}
				}
			}*/
			$i++;
			
		}
		return $users;
   }


   function setDetails($pid,$id,$title,$treatmentdate,$protocol,$method,$protocol2,$protocol3,$discount,$vat,$doctor,$doctor_ct,$task_id,$task_date,$task_text,$task,$task_treatmenttype,$canvasList_id,$canvasList_text,$treatment_access,$treatment_access_orig) {
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
		
		$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS . " set title = '$title', item_date = '$treatmentdate', protocol='$protocol', method='$method', protocol2='$protocol2', protocol3='$protocol3', discount='$discount', vat='$vat', doctor='$doctor', doctor_ct='$doctor_ct', access='$treatment_access', $accesssql edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		// do existing diagnoses
		$canvasList_size = sizeof($canvasList_id);
		foreach ($canvasList_id as $key => $value) {
			$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS_DIAGNOSES . " set text = '$canvasList_text[$key]' WHERE id='$canvasList_id[$key]'";
			$result = mysql_query($q, $this->_db->connection);
		}
		
		
		// do existing tasks
		$task_size = sizeof($task_id);
		$tasks_checked_size = sizeof($task);
		$treatstatus = $this->getStatus($id);
		$changeTreatmentStatus = 0; // 1 = st to planned 2 = set to complete
		// if only one see if phase is in progress or not
		if($task_size > 0) {
			if($treatstatus != 1 && $tasks_checked_size == 1) {
				$changeTreatmentStatus = 1;
			}
			if($treatstatus != 2 && $tasks_checked_size == $task_size) {
				$changeTreatmentStatus = 2;
			}
		}
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
			$item_date = $this->_date->formatDate($task_date[$key]);

			//$$this->_date->formatDateGMT($treatmentdate . " " . $time);
			/*if(isset($treatments_task_team[$key])) {
				$treatments_task_team_i = $this->_contactsmodel->sortUserIDsByName($treatments_task_team[$key]);
			} else {
				$treatments_task_team_i = "";
			}*/
			
			/*if(isset($treatments_task_team_ct[$key])) {
				$treatments_task_team_ct_i = $treatments_task_team_ct[$key];
			} else {
				$treatments_task_team_ct_i = "";
			}*/
			$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " set status = '$checked_items[$key]', item_date = '$item_date', text = '$task_text[$key]', type='$task_treatmenttype[$key]' WHERE id='$task_id[$key]'";
			$result = mysql_query($q, $this->_db->connection);
		}
		
		$detailsFix = $this->getDetails($id);
		$updatestatus = $detailsFix['treatment'];
		if ($result) {
			//return $id;
			$arr = array("id" => $id, "changeTreatmentStatus" => $changeTreatmentStatus, "updatestatus"=>$updatestatus);
			return $arr;
		}
   }
   
   function getStatus($id) {
		$q = "SELECT status FROM " . CO_TBL_PATIENTS_TREATMENTS . " WHERE id='$id'";
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
		
		$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS . " set status = '$status', status_date = '$date', invoice_date = '$date', payment_reminder='$payment_reminder', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}
	
	function updateStatusPatient($id) {
		$q = "SELECT a.status FROM " . CO_TBL_PATIENTS . " as a, " . CO_TBL_PATIENTS_TREATMENTS . " as b WHERE b.id = '$id' and b.pid = a.id";
		$result = mysql_query($q, $this->_db->connection);
		$status = mysql_result($result,0);
		if($status != 1) {
			return true;
		} else {
			return false;
		}
	}
	
	function checkPatientFinished($id) {
		$q = "SELECT a.status,a.id FROM " . CO_TBL_PATIENTS . " as a, " . CO_TBL_PATIENTS_TREATMENTS . " as b WHERE b.id = '$id' and b.pid = a.id";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_row($result);
		$patientstatus = $row[0];
		$pid = $row[1];
		
		$q = "SELECT status from " . CO_TBL_PATIENTS_TREATMENTS . " WHERE pid = '$pid' and status !='2' and bin = '0';";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			return false;
		} else {
			if($patientstatus != 2) {
				return true;
			} else {
				return false;
			}
		}
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
		//$users_string = array_unique($users_string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
				$q = "SELECT id, minutes from " . CO_TBL_PATIENTS_TREATMENTS_DIALOG . " where id = '$value'";
				$result_user = mysql_query($q, $this->_db->connection);
				while($row_user = mysql_fetch_assoc($result_user)) {
					$users += $row_user["minutes"];
					/*if($i < $users_total) {
						$users .= ', ';
					}*/
				}
			//}
			$i++;
			
		}
		return $users;
   }
   
   function getTreatmentTypeCosts($string){
		$users_string = explode(",", $string);
		//$users_string = array_unique($users_string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { return $users; }
		$i = 1;
		foreach ($users_string as &$value) {
				$q = "SELECT id, costs from " . CO_TBL_PATIENTS_TREATMENTS_DIALOG . " where id = '$value'";
				$result_user = mysql_query($q, $this->_db->connection);
				while($row_user = mysql_fetch_assoc($result_user)) {
					$users += $row_user["costs"];
					/*if($i < $users_total) {
						$users .= ', ';
					}*/
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
   
   
   function createNewFromCalendar($patient_id, $treatment_title) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		$time = gmdate("Y-m-d H");
		
		$q = "INSERT INTO " . CO_TBL_PATIENTS_TREATMENTS . " set title = '$treatment_title', item_date='$now', pid = '$patient_id', status = '0', status_date = '$now', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
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
		//$qt = "INSERT INTO " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " (mid,type,team,team_ct,place,place_ct,item_date,text,sort) SELECT $id_new,type,team,team_ct,place,place_ct,'$now',text,sort FROM " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " where mid='$id' and bin='0'";
		//$resultt = mysql_query($qt, $this->_db->connection);
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
		
		$q = "SELECT id FROM " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " WHERE mid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$tid = $row['id'];
			$this->deleteTask($tid);
		}
		
		if ($result) {
		  	return true;
		}
   }
   
   function restoreTreatment($id) {
		$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "SELECT id FROM " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " WHERE mid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$tid = $row['id'];
			$this->restoreTreatmentTask($tid);
		}
		
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


   function addTask($pid,$mid,$num,$sort) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:00");
		
		$who = $this->getPatientField($pid,'management');
		
		$q = "INSERT INTO " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " set mid='$mid', item_date='$now', status = '0',  team='$who', sort='$sort'";
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
			$tasks["team"] = $this->_contactsmodel->getUserList($tasks['team'],'treatments_task_team_'.$tasks["id"], "", 1);
			$tasks["team_ct"] = "";
			$tasks["min"] = 0;
			$tasks["costs"] = 0;
			$tasks["type"] = "";

			$tasks["place"] = "";
			
			$tasks["today"] = $this->_date->formatDate("now",CO_DATE_FORMAT);
			$task[] = new Lists($tasks);
		}
		
		  	return $task;
   }
	
	
	function deleteTaskOnly($id) {
		global $session;

		$q = "DELETE FROM " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }

   function deleteTask($id) {
		global $session;
		
		// copy calendar object to bin tbl
		$q = "SELECT * FROM oc_clndr_objects WHERE eventid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$eventtype = $row['eventtype'];
			$eventlocation = $row['eventlocation'];
			$eventlocationuid = $row['eventlocationuid'];
			$calendarid = $row['calendarid'];
			$objecttype = $row['objecttype'];
			$startdate = $row['startdate'];
			$enddate = $row['enddate'];
			$repeating =  $row['repeating'];
			$summary = $row['summary'];
			$calendardata = $row['calendardata'];
			$uri = $row['uri'];
			$lastmodified = $row['lastmodified'];
		}
		if(mysql_num_rows($result) > 0) {
		// insert to cal bin
		$q = "INSERT INTO oc_clndr_objects_bin SET eventtype = '$eventtype', eventid = '$id', eventlocation = '$eventlocation', eventlocationuid = '$eventlocationuid', calendarid = '$calendarid', objecttype = '$objecttype', startdate = '$startdate', enddate = '$enddate', repeating =  '$repeating', summary = '$summary', calendardata = '$calendardata', uri = '$uri', lastmodified = '$lastmodified'";
		$result = mysql_query($q, $this->_db->connection);
		}
		// now delete cal item
		$q = "DELETE FROM oc_clndr_objects WHERE eventid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }
   
   function restoreTreatmentTask($id) {
		global $session;
		
		// copy calendar object to bin tbl
		$q = "SELECT * FROM oc_clndr_objects_bin WHERE eventid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$eventtype = $row['eventtype'];
			$eventlocation = $row['eventlocation'];
			$eventlocationuid = $row['eventlocationuid'];
			$calendarid = $row['calendarid'];
			$objecttype = $row['objecttype'];
			$startdate = $row['startdate'];
			$enddate = $row['enddate'];
			$repeating =  $row['repeating'];
			$summary = $row['summary'];
			$calendardata = $row['calendardata'];
			$uri = $row['uri'];
			$lastmodified = $row['lastmodified'];
		}
		// insert to cal bin
		$q = "INSERT INTO oc_clndr_objects SET eventtype = '$eventtype', eventid = '$id', eventlocation = '$eventlocation', eventlocationuid = '$eventlocationuid', calendarid = '$calendarid', objecttype = '$objecttype', startdate = '$startdate', enddate = '$enddate', repeating =  '$repeating', summary = '$summary', calendardata = '$calendardata', uri = '$uri', lastmodified = '$lastmodified'";
		$result = mysql_query($q, $this->_db->connection);
		
		// now delete cal item
		$q = "DELETE FROM oc_clndr_objects_bin WHERE eventid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }
   
   function deleteTreatmentTask($id) {
		global $session;
		// delete cal item
		$q = "DELETE FROM oc_clndr_objects WHERE eventid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$q = "DELETE FROM oc_clndr_objects_bin WHERE eventid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
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
	 
	 
	function getTreatmentsSearch($term){
		global $system, $session;
		$num=0;
		$access=" ";
		if(!$session->isSysadmin()) {
			$access = " and a.id IN (" . implode(',', $this->canAccess($session->uid)) . ") ";
	  	}
		$q ="select CONCAT(id,',',costs,',',minutes) as id, CONCAT(positionstext, ' ',shortname, ' (',minutes,')') as label from " . CO_TBL_PATIENTS_TREATMENTS_DIALOG . " where (positionstext like '%$term%' or shortname like '%$term%') and active = '1'";
		
		$result = mysql_query($q, $this->_db->connection);
		$num=mysql_affected_rows();
		$rows = array();
		while($r = mysql_fetch_assoc($result)) {
			 $rows[] = $r;
		}
		return json_encode($rows);
	}
	
	
	
	function getTreatmentList($string, $field, $sql="", $canedit){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { 
			return $users; 
		}
		// check if user is available and build array
		$users_arr = array();
		foreach ($users_string as &$value) {
			$q = "SELECT id, positionstext, shortname, minutes, costs FROM ".CO_TBL_PATIENTS_TREATMENTS_DIALOG." where id = '$value' $sql";
			$result_user = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result_user) > 0) {
				while($row_user = mysql_fetch_assoc($result_user)) {
					$users_arr[] = ' uid="' . $row_user["id"] . '" minutes="'.$row_user["minutes"].'" costs="'.$row_user["costs"].'">' .$row_user["positionstext"] . ' ' . $row_user["shortname"] . ' (' . $row_user["minutes"] . ')';		
				}
			}
		}
		$users_arr_total = sizeof($users_arr);
		
		// build string
		if($canedit) {
			$edit = ' edit="1"';
		} else {
			$edit = ' edit="0"';
		}
		$i = 1;
		foreach ($users_arr as $key => &$value) {
			$users .= '<span class="listmember-outer"><a href="patients_treatments" class="showItemContext" field="' . $field . '" ' . $edit . $value;		
			if($i < $users_arr_total) {
				$users .= ', ';
			}
			$users .= '</a></span>';	
			$i++;
		}
		return $users;
	}
	
	function getTreatmentSessionTitleSingle($string){
		$q = "SELECT positionstext, shortname, minutes FROM ".CO_TBL_PATIENTS_TREATMENTS_DIALOG." where id = '$string'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_assoc($result)) {
			//$name = $row["positionstext"] . ' ' . $row["shortname"] . ' (' . $row["minutes"] . ')';
			$name = $row["positionstext"];
				}
		return $name;
	}
	
	function getTreatmentArrayInvoice($string, $field, $sql="", $canedit = true){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { 
			return $users; 
		}
		// check if user is available and build array
		$users_arr = array();
		foreach ($users_string as &$value) {
			$q = "SELECT id, positionstext, shortname, minutes, costs FROM ".CO_TBL_PATIENTS_TREATMENTS_DIALOG." where id = '$value' $sql";
			$result_user = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result_user) > 0) {
				while($row_user = mysql_fetch_assoc($result_user)) {
					$users_arr[] = array( 'positionstext' => $row_user['positionstext'], 'shortname' => $row_user['shortname'], 'minutes' => $row_user['minutes'], 'costs' => $row_user['costs']);	
				}
			}
		}
		return $users_arr;
	}
	
	function getLast10Treatments() {
		global $session;
		//$treatments = $this->getUserArray($this->getUserSetting("last-used-treatments"));
		$treatments = $this->getTreatmentsArray($this->getUserSetting("last-used-treatments"));
	  return $treatments;
	}
	
	function saveLastUsedTreatments($id) {
		global $session;
		$string = $id . "," .$this->getUserSetting("last-used-treatments");
		$string = rtrim($string, ",");
		$ids_arr = explode(",", $string);
		$res = array_unique($ids_arr);
		foreach ($res as $key => $value) {
			$ids_rtn[] = $value;
		}
		array_splice($ids_rtn, 7);
		$str = implode(",", $ids_rtn);
		
		$this->setUserSetting("last-used-treatments",$str);
	  return true;
	}
	
	function getTreatmentsArray($string){
		$users_string = explode(",", $string);
		$users_total = sizeof($users_string);
		$users = '';
		if($users_total == 0) { 
			return $users; 
		}
		// check if user is available and build array
		$users_arr = "";
		foreach ($users_string as &$value) {
			$q = "SELECT id, positionstext, shortname, minutes, costs FROM ".CO_TBL_PATIENTS_TREATMENTS_DIALOG." where id = '$value' and active='1'";
			$result_user = mysql_query($q, $this->_db->connection);
			if(mysql_num_rows($result_user) > 0) {
				while($row_user = mysql_fetch_assoc($result_user)) {
					$users_arr[] = array("id" => $row_user["id"], "shortname" => $row_user["positionstext"] . ' ' . $row_user["shortname"] . ' (' . $row_user["minutes"] . ')', "costs" => $row_user["costs"], "minutes" => $row_user["minutes"]);		
				}
			}
		}
		return $users_arr;
	}
	
	function getTreatmentsMethodDialog($field) {
		global $session;
		$str = '<div class="dialog-text">';
		$q ="select id, name from " . CO_TBL_PATIENTS_TREATMENTS_METHODS . " ORDER BY name ASC";
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$str .= '<a href="#" class="insertFromDialog" title="' . $row["name"] . '" field="'.$field.'" gid="'.$row["id"].'">' . $row["name"] . '</a>';
		}
		$str .= '</div>';	
		return $str;
	 }

	
	/*function getTaskContext($id,$field){
		$q = "SELECT id FROM " . CO_TBL_PATIENTS_TREATMENTS_DIALOG . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		$array["field"] = $field;
		
		$document = new Lists($array); 
		
		$doc = array();
		$qt = "SELECT * FROM " . CO_TBL_PATIENTS_DOCUMENTS . " where did = '$id' and bin='0' ORDER BY created_date DESC";
		$resultt = mysql_query($qt, $this->_db->connection);
		while($rowt = mysql_fetch_array($resultt)) {
			foreach($rowt as $key => $val) {
				$docs[$key] = $val;
			}

			$docs["filesize"] = $this->formatBytes($docs["filesize"]);
			$doc[] = new Lists($docs);
		}
		
		$arr = array("document" => $document, "doc" => $doc);
		return $arr;
	}*/
	
	function getTreatmentInfoForCalendar($id) {
		global $session, $lang;
		
		$q = "SELECT id,pid,title FROM " . CO_TBL_PATIENTS_TREATMENTS . " WHERE id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		
		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			
		$patientid = $array["pid"];
		
		$q = "SELECT c.title as foldertitle, b.id as patient_id, b.lastname,b.firstname FROM " . CO_TBL_PATIENTS . " as a, co_users as b, " . CO_TBL_PATIENTS_FOLDERS . " as c where a.cid=b.id and a.folder=c.id and a.id = '$patientid'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}	
		$array['patient'] = $array['lastname'] . ' ' . $array['firstname'];

		$treatment = new Lists($array);
		$arr = array("treatment" => $treatment);
		return $arr;
   }

}
?>
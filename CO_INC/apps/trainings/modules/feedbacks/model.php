<?php

class TrainingsFeedbacksModel extends TrainingsModel {
	
	public function __construct() {  
     	parent::__construct();
		//$this->_phases = new TrainingsPhasesModel();
		$this->_contactsmodel = new ContactsModel();
	}


	function getList($id,$sort) {
		global $session;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("trainings-feedbacks-sort-status",$id);
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
				  		$sortorder = $this->getSortOrder("trainings-feedbacks-sort-order",$id);
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
				  		$sortorder = $this->getSortOrder("trainings-feedbacks-sort-order",$id);
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
	  
	  
		$perm = $this->getTrainingAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		
		//$q = "select id,title,item_date,access,status,checked_out,checked_out_user from " . CO_TBL_TRAININGS . " where pid = '$id' and bin != '1' " . $sql . $order;
		$q = "SELECT a.*,CONCAT(b.lastname,', ',b.firstname) as title FROM " . CO_TBL_TRAININGS_MEMBERS . " as a, co_users as b where a.tookpart='1' and a.cid=b.id and a.pid = '$id' and a.bin='0' and b.bin='0' ORDER BY title ASC";
		$this->setSortStatus("trainings-feedbacks-sort-status",$sortcur,$id);
		$result = mysql_query($q, $this->_db->connection);
		$items = mysql_num_rows($result);
		
		$feedbacks = "";
		
		//$array['id'] = 0;
		//$array['title'] = 'Gesamtstatistik';
		//$feedbacks[] = new Lists($array);
		
		while ($row = mysql_fetch_array($result)) {

		foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			
			// dates
			//$array["item_date"] = $this->_date->formatDate($array["item_date"],CO_DATE_FORMAT);
			
			// access
			//$accessstatus = "";
			/*if($perm !=  "guest") {
				if($array["access"] == 1) {
					$accessstatus = " module-access-active";
				}
			}*/
			//$array["accessstatus"] = $accessstatus;
			// status
			/*$itemstatus = "";
			if($array["status"] == 1) {
				$itemstatus = " module-item-active";
			}
			if($array["status"] == 2) {
				$itemstatus = " module-item-active-stopped";
			}
			$array["itemstatus"] = $itemstatus;*/
			
			/*$checked_out_status = "";
			if($perm !=  "guest" && $array["checked_out"] == 1 && $array["checked_out_user"] != $session->uid) {
				if($session->checkUserActive($array["checked_out_user"])) {
					$checked_out_status = "icon-checked-out-active";
				} else {
					$this->checkinFeedbackOverride($id);
				}
			}
			$array["checked_out_status"] = $checked_out_status;
			
			*/
			$feedbacks[] = new Lists($array);
	  }
		
	  $arr = array("feedbacks" => $feedbacks, "items" => $items, "sort" => $sortcur, "perm" => $perm);
	  return $arr;
	}


	function getNavNumItems($id) {
		$perm = $this->getTrainingAccess($id);
		$sql ="";
		if( $perm ==  "guest") {
			$sql = " and access = '1' ";
		}
		$q = "select count(*) as items from " . CO_TBL_TRAININGS_MEMBERS . " where pid = '$id' and tookpart='1' and bin != '1' " . $sql;
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		$items = $row['items'];
		return $items;
	}
	

	/*function checkoutFeedback($id) {
		global $session;
		
		$q = "UPDATE " . CO_TBL_TRAININGS_FEEDBACKS . " set checked_out = '1', checked_out_user = '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return true;
		}
	}*/
	
	
	/*function checkinFeedback($id) {
		global $session;
		
		$q = "SELECT checked_out_user FROM " . CO_TBL_TRAININGS_FEEDBACKS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$user = mysql_result($result,0);

		if($user == $session->uid) {
			$q = "UPDATE " . CO_TBL_TRAININGS_FEEDBACKS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		if ($result) {
			return true;
		}
	}*/
	
	/*function checkinFeedbackOverride($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_TRAININGS_FEEDBACKS . " set checked_out = '0', checked_out_user = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
	}*/
	

	function getDetails($id, $option = "") {
		global $session, $lang;		

		$q = "SELECT a.*,CONCAT(b.lastname,', ',b.firstname) as title FROM " . CO_TBL_TRAININGS_MEMBERS . " as a, co_users as b where a.cid=b.id and a.id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return false;
		}
		$row = mysql_fetch_array($result);
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		
		$array["q1_selected"] = $array["feedback_q1"];
		$array["q2_selected"] = $array["feedback_q2"];
		$array["q3_selected"] = $array["feedback_q3"];
		$array["q4_selected"] = $array["feedback_q4"];
		$array["q5_selected"] = $array["feedback_q5"];
		$total_result = 0;
		$array["q1_result"] = 0;
		$array["q2_result"] = 0;
		$array["q3_result"] = 0;
		$array["q4_result"] = 0;
		$array["q5_result"] = 0;
		if(!empty($array["feedback_q1"])) { $array["q1_result"] = $array["feedback_q1"]*20; $total_result += $array["feedback_q1"]; }
		if(!empty($array["feedback_q2"])) { $array["q2_result"] = $array["feedback_q2"]*20; $total_result += $array["feedback_q2"]; }
		if(!empty($array["feedback_q3"])) { $array["q3_result"] = $array["feedback_q3"]*20; $total_result += $array["feedback_q3"]; }
		if(!empty($array["feedback_q4"])) { $array["q4_result"] = $array["feedback_q4"]*20; $total_result += $array["feedback_q4"]; }
		if(!empty($array["feedback_q5"])) { $array["q5_result"] = $array["feedback_q5"]*20; $total_result += $array["feedback_q5"]; }
		
		$array["total_result"] = round(100/25* $total_result,0);

		$array["perms"] = $this->getTrainingAccess($array["pid"]);
		/*$array["canedit"] = false;
		$array["showCheckout"] = false;
		$array["checked_out_user_text"] = $this->_contactsmodel->getUserListPlain($array['checked_out_user']);

		if($array["perms"] == "sysadmin" || $array["perms"] == "admin") {
			//if($array["checked_out"] == 1 && $session->checkUserActive($array["checked_out_user"])) {
			if($array["checked_out"] == 1) {
				if($array["checked_out_user"] == $session->uid) {
					$array["canedit"] = true;
				} else if(!$session->checkUserActive($array["checked_out_user"])) {
					$array["canedit"] = $this->checkoutFeedback($id);
					$array["canedit"] = true;
				} else {
					$array["canedit"] = false;
					$array["showCheckout"] = true;
		$array["checked_out_user_phone1"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"phone1");
		$array["checked_out_user_email"] = $this->_contactsmodel->getContactFieldFromID($array['checked_out_user'],"email");

				}
			} else {
				$array["canedit"] = $this->checkoutFeedback($id);
			}
		}*/
		
		// dates
		//$array["item_date"] = $this->_date->formatDate($array["item_date"],CO_DATE_FORMAT);
		
		// time
		/*$array["today"] = $this->_date->formatDate("now",CO_DATE_FORMAT);
		$array["start"] = $this->_date->formatDate($array["start"],CO_TIME_FORMAT);
		$array["end"] = $this->_date->formatDate($array["end"],CO_TIME_FORMAT);
		$array["location"] = $this->_contactsmodel->getPlaceList($array['location'],'location', $array["canedit"]);
		$array["location_ct"] = empty($array["location_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['location_ct'];
		$array["cat_name"] = $this->getFeedbackCatIdDetails($array["cat"]);*/
		
		/*$array["participants_print"] = $this->_contactsmodel->getUserListPlain($array["participants"]);
		if($option = 'prepareSendTo') {
			$array["sendtoTeam"] = $this->_contactsmodel->checkUserListEmail($array["participants"],'trainingsparticipants', "", $array["canedit"]);
			$array["sendtoTeamNoEmail"] = $this->_contactsmodel->checkUserListEmail($array["participants"],'trainingsparticipants', "", $array["canedit"], 0);
			$array["sendtoError"] = false;
		}
		$array["participants"] = $this->_contactsmodel->getUserList($array['participants'],'trainingsparticipants', "", $array["canedit"]);
		$array["participants_ct"] = empty($array["participants_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['participants_ct'];
		$array["management_print"] = $this->_contactsmodel->getUserListPlain($array["management"]);
		$array["management"] = $this->_contactsmodel->getUserList($array['management'],'trainingsmanagement', "", $array["canedit"]);
		$array["management_ct"] = empty($array["management_ct"]) ? "" : $lang["TEXT_NOTE"] . " " . $array['management_ct'];
		//$array["documents"] = $this->_documents->getDocListFromIDs($array['documents'],'documents');
		
		$array["created_date"] = $this->_date->formatDate($array["created_date"],CO_DATETIME_FORMAT);
		$array["edited_date"] = $this->_date->formatDate($array["edited_date"],CO_DATETIME_FORMAT);
		$array["created_user"] = $this->_users->getUserFullname($array["created_user"]);
		$array["edited_user"] = $this->_users->getUserFullname($array["edited_user"]);*/
		$array["current_user"] = $session->uid;
		$array["today"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		/*switch($array["access"]) {
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
		}*/

		$feedback = new Lists($array);
		
		$arr = array("feedback" => $feedback, "access" => $array["perms"]);
		return $arr;
   }



function getDetailsTotals($id) {
		global $session, $lang;		

		//$q = "SELECT a.*,CONCAT(b.lastname,', ',b.firstname) as title FROM " . CO_TBL_TRAININGS_MEMBERS . " as a, co_users as b where a.cid=b.id and a.id='$id'";
		$q = "SELECT id FROM " . CO_TBL_TRAININGS_MEMBERS . " where invitation='1' and pid = '$id' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		$invitations = mysql_num_rows($result);
		
		$q = "SELECT id FROM " . CO_TBL_TRAININGS_MEMBERS . " where registration='1' and pid = '$id' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		$registrations = mysql_num_rows($result);
		
		if($invitations == 0) {
			$array['total_regs'] = 0;
		} else {
			$array['total_regs'] = 100/$invitations*$registrations;
		}
		
		$q = "SELECT id FROM " . CO_TBL_TRAININGS_MEMBERS . " where tookpart='1' and pid = '$id' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		$attendees = mysql_num_rows($result);
		
		if($invitations == 0) {
			$array['total_attendees'] = 0;
		} else {
			$array['total_attendees'] = 100/$invitations*$attendees;
		}
		
		$q = "SELECT * FROM " . CO_TBL_TRAININGS_MEMBERS . " where tookpart='1' and pid = '$id' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			$members = 1;
		} else {
			$members = mysql_num_rows($result);
		}
		$total_result = 0;
		$feedback_q1 = 0;
		$feedback_q2 = 0;
		$feedback_q3 = 0;
		$feedback_q4 = 0;
		$feedback_q5 = 0;
		while ($row = mysql_fetch_array($result)) {
			//$row = mysql_fetch_array($result);
			foreach($row as $key => $val) {
				$array[$key] = $val;
			}
		
			
			$array["q1_result"] = 0;
			$array["q2_result"] = 0;
			$array["q3_result"] = 0;
			$array["q4_result"] = 0;
			$array["q5_result"] = 0;
			if(!empty($array["feedback_q1"])) { $feedback_q1 += $array["feedback_q1"]; $total_result += $array["feedback_q1"]; }
			if(!empty($array["feedback_q2"])) { $feedback_q2 += $array["feedback_q2"]; $total_result += $array["feedback_q2"]; }
			if(!empty($array["feedback_q3"])) { $feedback_q3 += $array["feedback_q3"]; $total_result += $array["feedback_q3"]; }
			if(!empty($array["feedback_q4"])) { $feedback_q4 += $array["feedback_q4"]; $total_result += $array["feedback_q4"]; }
			if(!empty($array["feedback_q5"])) { $feedback_q5 += $array["feedback_q5"]; $total_result += $array["feedback_q5"]; }

		}
		$array["pid"] = $id;
		$array["q1_result"] = round($feedback_q1*20/$members,0);
		$array["q2_result"] = round($feedback_q2*20/$members,0);
		$array["q3_result"] = round($feedback_q3*20/$members,0);
		$array["q4_result"] = round($feedback_q4*20/$members,0);
		$array["q5_result"] = round($feedback_q5*20/$members,0);
		$array["total_result"] = round((100/25*$total_result)/$members,0);
		$array["today"] = $this->_date->formatDate("now",CO_DATETIME_FORMAT);
		
		$array["perms"] = $this->getTrainingAccess($id);

		$array["current_user"] = $session->uid;

		$feedback = new Lists($array);
		
		$arr = array("feedback" => $feedback, "access" => $array["perms"]);
		return $arr;
   }


   function setDetails($pid,$id,$protocol) {
		global $session, $lang;

		$now = gmdate("Y-m-d H:i:s");
		
		$q = "UPDATE " . CO_TBL_TRAININGS_MEMBERS . " set feedback_text='$protocol' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			return $id;
		}
   }


   function updateStatus($id,$date,$status) {
		global $session, $lang;
		
		$date = $this->_date->formatDate($date);
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "SELECT title FROM " . CO_TBL_TRAININGS_FEEDBACKS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$title = mysql_result($result,0);
		
		$title_change = $title;
		if($status == 3) {
			$title_change = $title . " " . $lang["TRAINING_FEEDBACK_POSPONED"];
		}
		
		$q = "UPDATE " . CO_TBL_TRAININGS_FEEDBACKS . " set title = '$title_change', status = '$status', status_date = '$date', edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		if ($result) {
			$arr = array("id" => $id, "what" => "edit");
		}
		
		// posponed
		if($status == 3) {
			$this->checkinFeedback($id);
			$q = "INSERT INTO " . CO_TBL_TRAININGS_FEEDBACKS . " (pid,title,item_date,start,end,location,location_ct,length,management,management_ct,participants,participants_ct,status,status_date,created_date,created_user,edited_date,edited_user) SELECT pid,'$title','$date',start,end,location,location_ct,length,management,management_ct,participants,participants_ct,0,'$now','$now','$session->uid','$now','$session->uid' FROM " . CO_TBL_TRAININGS_FEEDBACKS . " where id='$id'";
			$result = mysql_query($q, $this->_db->connection);
			if ($result) {
				$nid = mysql_insert_id();
				// do tasks
				$qt = "INSERT INTO " . CO_TBL_TRAININGS_FEEDBACKS_TASKS . " (mid,status,title,text,sort) SELECT '$nid',status,title,text,sort FROM " . CO_TBL_TRAININGS_FEEDBACKS_TASKS . " where mid='$id'";
				$resultt = mysql_query($qt, $this->_db->connection);
				$arr = array("id" => $nid, "what" => "reload");
			}
		}
		return $arr;
	}


   function createNew($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		$time = gmdate("Y-m-d H");
		
		$q = "INSERT INTO " . CO_TBL_TRAININGS_FEEDBACKS . " set title = '" . $lang["TRAINING_FEEDBACK_NEW"] . "', item_date='$now', start='$time', end='$time', pid = '$id', participants = '$session->uid', management = '$session->uid', status = '0', status_date = '$now', created_user = '$session->uid', created_date = '$now', edited_user = '$session->uid', edited_date = '$now'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		
		//$task = $this->addTask($id,0,0);
		
		if ($result) {
			return $id;
		}
   }
   

   	function createDuplicate($id) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");

		// feedback
		$q = "INSERT INTO " . CO_TBL_TRAININGS_FEEDBACKS . " (pid,title,item_date,start,end,location,location_ct,length,management,management_ct,protocol,protocol2,participants,participants_ct,status_date,created_date,created_user,edited_date,edited_user,tab1q1,tab1q2,tab1q3,tab1q4,tab1q5,tab2q1,tab2q2,tab2q3,tab2q4,tab2q5,tab2q6,tab2q7,tab2q8,tab2q9,tab2q10,tab1q1_text,tab1q2_text,tab1q3_text,tab1q4_text,tab1q5_text,tab2q1_text,tab2q2_text,tab2q3_text,tab2q4_text,tab2q5_text,tab2q6_text,tab2q7_text,tab2q8_text,tab2q9_text,tab2q10_text) SELECT pid,CONCAT(title,' " . $lang["GLOBAL_DUPLICAT"] . "'),'$now',start,end,location,location_ct,length,management,management_ct,protocol,protocol2,participants,participants_ct,'$now','$now','$session->uid','$now','$session->uid',tab1q1,tab1q2,tab1q3,tab1q4,tab1q5,tab2q1,tab2q2,tab2q3,tab2q4,tab2q5,tab2q6,tab2q7,tab2q8,tab2q9,tab2q10,tab1q1_text,tab1q2_text,tab1q3_text,tab1q4_text,tab1q5_text,tab2q1_text,tab2q2_text,tab2q3_text,tab2q4_text,tab2q5_text,tab2q6_text,tab2q7_text,tab2q8_text,tab2q9_text,tab2q10_text FROM " . CO_TBL_TRAININGS_FEEDBACKS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id_new = mysql_insert_id();
		// tasks
		$qt = "INSERT INTO " . CO_TBL_TRAININGS_FEEDBACKS_TASKS . " (mid,title,text,answer,sort) SELECT $id_new,title,text,answer,sort FROM " . CO_TBL_TRAININGS_FEEDBACKS_TASKS . " where mid='$id' and bin='0'";
		$resultt = mysql_query($qt, $this->_db->connection);
		if ($result) {
			return $id_new;
		}
	}


   function binFeedback($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_TRAININGS_FEEDBACKS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function restoreFeedback($id) {
		$q = "UPDATE " . CO_TBL_TRAININGS_FEEDBACKS . " set bin = '0' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }
   
   function deleteFeedback($id) {
		$q = "SELECT id FROM " . CO_TBL_TRAININGS_FEEDBACKS_TASKS . " WHERE mid = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$tid = $row["id"];
			$this->deleteFeedbackTask($tid);
		}
		
		$q = "DELETE FROM co_log_sendto WHERE what='trainings_feedbacks' and whatid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_USERS_CHECKPOINTS . " WHERE app = 'trainings' and module = 'feedbacks' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q = "DELETE FROM " . CO_TBL_TRAININGS_FEEDBACKS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function toggleIntern($id,$status) {
		global $session;
		$q = "UPDATE " . CO_TBL_TRAININGS_FEEDBACKS . " set intern = '$status' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	return true;
		}
   }


   function addTask($mid,$num,$sort) {
		global $session, $lang;
		
		$now = gmdate("Y-m-d H:i:s");
		
		$q = "INSERT INTO " . CO_TBL_TRAININGS_FEEDBACKS_TASKS . " set mid='$mid', status = '0', title = '" . $lang["TRAINING_FEEDBACK_TASK_NEW"] . "',  sort='$sort'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_insert_id();
		
		$task = array();
		$q = "SELECT * FROM " . CO_TBL_TRAININGS_FEEDBACKS_TASKS . " where id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$tasks[$key] = $val;
			}
			$tasks["today"] = $this->_date->formatDate("now",CO_DATE_FORMAT);
			$task[] = new Lists($tasks);
		}
		
		  	return $task;
   }


   function deleteTask($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_TRAININGS_FEEDBACKS_TASKS . " set bin = '1', bintime = NOW(), binuser= '$session->uid' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }
   
   function restoreFeedbackTask($id) {
		global $session;
		$q = "UPDATE " . CO_TBL_TRAININGS_FEEDBACKS_TASKS . " set bin = '0' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }
   
   function deleteFeedbackTask($id) {
		global $session;
		$q = "DELETE FROM " . CO_TBL_TRAININGS_FEEDBACKS_TASKS . " WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if($result) {
			return true;
		}
   }


	function getFeedbackCatDialog($field) {
		global $session;
		$str = '<div class="dialog-text">';
		$q ="select id, name from " . CO_TBL_TRAININGS_FEEDBACKS_DIALOG . " ORDER BY name ASC";
		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			$str .= '<a href="#" class="insertFromDialog" title="' . $row["name"] . '" field="'.$field.'" gid="'.$row["id"].'">' . $row["name"] . '</a>';
		}
		$str .= '</div>';	
		return $str;
	 }
	 
	 function getFeedbackCatIdDetails($id) {
		 $q ="select name from " . CO_TBL_TRAININGS_FEEDBACKS_DIALOG . " WHERE id='$id'";
		 $result = mysql_query($q, $this->_db->connection);
		 $name = mysql_result($result,0);
		 return $name;
	 }
	 
	 
	 function changeCat($id,$cat) {
		$q ="UPDATE " . CO_TBL_TRAININGS_FEEDBACKS . " SET cat='$cat' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return $cat;
		}
	 }

	function newCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "INSERT INTO " . CO_TBL_USERS_CHECKPOINTS . " SET uid = '$session->uid', date = '$date', app = 'trainings', module = 'feedbacks', app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

 	function updateCheckpoint($id,$date){
		global $session;
		$date = $this->_date->formatDate($date);
		$q = "UPDATE " . CO_TBL_USERS_CHECKPOINTS . " SET date = '$date', status='0' WHERE uid = '$session->uid' and app = 'trainings' and module = 'feedbacks' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

 	function deleteCheckpoint($id){
		global $session;
		$q = "DELETE FROM " . CO_TBL_USERS_CHECKPOINTS . " WHERE uid = '$session->uid'and app = 'trainings' and module = 'feedbacks' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

	function updateCheckpointText($id,$text){
		global $session;
		$q = "UPDATE " . CO_TBL_USERS_CHECKPOINTS . " SET note = '$text' WHERE uid = '$session->uid' and app = 'trainings' and module = 'feedbacks' and app_id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
   }

    function getCheckpointDetails($id){
		global $lang;
		$row = "";
		$q = "SELECT a.pid,a.title,b.folder FROM " . CO_TBL_TRAININGS_FEEDBACKS . " as a, " . CO_TBL_TRAININGS . " as b WHERE a.pid = b.id and a.id='$id' and a.bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_array($result);
		if(mysql_num_rows($result) > 0) {
			$row['checkpoint_app_name'] = $lang["TRAINING_FEEDBACK_TITLE"];
			$row['app_id'] = $row['pid'];
			$row['app_id_app'] = $id;
		}
		return $row;
   }
   
   
    function updateQuestion($id,$field,$val){
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_TRAININGS_MEMBERS . " set $field = '$val' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		return true;
   }
   
   function updateTaskQuestion($id,$val){
		global $session;
		$now = gmdate("Y-m-d H:i:s");
		$q = "UPDATE " . CO_TBL_TRAININGS_FEEDBACKS_TASKS . " set answer = '$val' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$q = "SELECT mid FROM " . CO_TBL_TRAININGS_FEEDBACKS_TASKS . " where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$id = mysql_result($result,0);
		$q = "UPDATE " . CO_TBL_TRAININGS_FEEDBACKS . " set edited_user = '$session->uid', edited_date = '$now' where id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		return true;
   }


   function getChart($id, $what, $value, $image = 1) { 
		global $lang;
		switch($what) {
			case 'feedbacks':
				$chart["real"] = $value;
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = $lang["TRAINING_FOLDER_CHART_FEEDBACKS"];
				$chart["img_name"] = "t_feedbacks_" . $id . "_feedbacks.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
				
				$chart["tendency"] = "pixel.gif";
				
				if($image == 1) {
					$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				}
				
			break;
			case 'registrations':
				$chart["real"] = $value;
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = $lang["TRAINING_FEEDBACK_CHART_REGISTRATIONS"];
				$chart["img_name"] = "t_feedbacks_" . $id . "_registrations.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
				
				$chart["tendency"] = "pixel.gif";
				
				if($image == 1) {
					$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				}
				
			break;
			case 'attendees':
				$chart["real"] = $value;
				$chart["rest"] = $this->getRest($chart["real"]);
				$chart["title"] = $lang["TRAINING_FEEDBACK_CHART_ATTENDEES"];
				$chart["img_name"] = "t_feedbacks_" . $id . "_registrations.png";
				$chart["url"] = 'https://chart.googleapis.com/chart?cht=p3&chd=t:' . $chart["real"]. ',' .$chart["rest"] . '&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF';
				
				$chart["tendency"] = "pixel.gif";
				
				if($image == 1) {
					$image = self::saveImage($chart["url"],CO_PATH_BASE . '/data/charts/',$chart["img_name"]);
				}
				
			break;
		}
		
		return $chart;
   }

   

}
?>
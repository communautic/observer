<?php
class CalendarModel extends Model {

	// Get all Calendars
   function getFolderList($sort, $showGroupCalendar = 0) {
      global $session,$lang;
	  if($sort == 0) {
		  $sortstatus = $this->getSortStatus("calendar-sort-status");
		  if(!$sortstatus) {
		  	$order = "order by a.lastname ASC, a.firstname ASC";
			$sortcur = '1';
		  } else {
			  switch($sortstatus) {
				  case "1":
				  		$order = "order by a.lastname ASC, a.firstname ASC";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by a.lastname DESC, a.firstname DESC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("calendar-sort-order");
				  		if(!$sortorder) {
						  	$order = "order by a.lastname ASC, a.firstname ASC";
							$sortcur = '1';
						  } else {
							$order = "order by field(a.id,$sortorder)";
							$sortcur = '3';
						  }
				  break;
			  }
		  }
	  } else {
		  switch($sort) {
				  case "1":
				  		$order = "order by a.lastname ASC, a.firstname ASC";
						$sortcur = '1';
				  break;
				  case "2":
				  		$order = "order by a.lastname DESC, a.firstname DESC";
						$sortcur = '2';
				  break;
				  case "3":
				  		$sortorder = $this->getSortOrder("calendar-sort-order");
				  		if(!$sortorder) {
						  	$order = "order by a.lastname ASC, a.firstname ASC";
							$sortcur = '1';
						  } else {
							$order = "order by field(a.id,$sortorder)";
							$sortcur = '3';
						  }
				  break;	
			  }
	  }
	  
		/*if(!$session->isSysadmin()) {
			//$q ="select a.id, a.title from " . CO_TBL_PROJECTS_FOLDERS . " as a where a.status='0' and a.bin = '0' and (SELECT count(*) FROM co_projects_access as b, co_projects as c WHERE (b.admins REGEXP '[[:<:]]" . $session->uid . "[[:>:]]' or b.guests REGEXP '[[:<:]]" . $session->uid . "[[:>:]]') and c.folder=a.id and b.pid=c.id) > 0 " . $order;
			$q = "select id,firstname,lastname from co_users as a, oc_clndr_calendars asb where a.calendar = '1' and a.invisible = '0' and a.bin = '0' " . $order;
		} else {
			$q = "SELECT a.id, a.firstname, a.lastname, a.username, b.id as calendarid, b.active as calactive, b.calendarcolor FROM co_users as a, oc_clndr_calendars as b WHERE (a.username = b.userid or a.calendar_uid = b.userid) and a.calendar = '1' and a.invisible = '0' and a.bin = '0' " . $order;
		}*/
		$q = "SELECT a.id, a.firstname, a.lastname, a.username, b.id as calendarid, b.active as calactive, b.calendarcolor FROM co_users as a, oc_clndr_calendars as b WHERE a.username = b.userid and a.calendar = '1' and a.invisible = '0' and a.bin = '0' " . $order;
		
	  $this->setSortStatus("calendar-sort-status",$sortcur);
      $result = mysql_query($q, $this->_db->connection);
	  $folders = "";
	  $eventSources = "";
	  while ($row = mysql_fetch_array($result)) {
		foreach($row as $key => $val) {
			$array[$key] = $val;
		}
		if($array['calactive'] == 1) {
			$eventSources[] = array(
								'url' => '/?path=apps/calendar&request=getrequestedEvents&calendar_id=' . $array['calendarid'],
								'backgroundColor' => $array['calendarcolor'],
								"borderColor" => $array['calendarcolor'],
								"textColor" => "#000000",
								"cache" => true					
							  );
		}
		
		$folders[] = new Lists($array);
		
	  }
	  
	  if($showGroupCalendar == 1) { // Gruppencalender
			$qg = "SELECT id as calendarid, displayname as lastname, '' as firstname FROM oc_clndr_calendars WHERE id='2'";
			$resultg = mysql_query($qg, $this->_db->connection);
			while ($rowg = mysql_fetch_array($resultg)) {
			foreach($rowg as $key => $val) {
				$array[$key] = $val;
			}
			$array['lastname'] = $lang["CALENDAR_OFFICE_CALENDAR"];
			$folders[] = new Lists($array);
			}
			
		}
			
			
		
	  
	  $arr = array("folders" => $folders, "eventSources" => $eventSources, "sort" => $sortcur);
	  
	  return $arr;
   }
   
   
   function printCalendar($id, $start, $end, $option) {
		global $session;
		$start = self::getUTCforMDB($start);
		$end = self::getUTCforMDB($end);
		$sql = '';
		switch($option) {
			case 1:
				$sql = "and eventtype='1'";
			break;
			case 2:
				$sql = "and eventtype='0'";
			break;
		}
		
		$calendarobjects = array();
		$q ="SELECT * FROM oc_clndr_objects WHERE (calendarid = '$id' || calendarid = '2') AND objecttype = 'VEVENT' AND ((startdate >= '$start' AND enddate <= '$end' AND repeating = '0') OR (enddate >= '$start' AND startdate <= '$end' AND repeating = 0) OR (startdate <= '$end' AND repeating = '1') ) $sql ORDER BY startdate ASC";
		$result = mysql_query($q, $this->_db->connection);
		/* CO Array
		while($row = mysql_fetch_array($result))  {
			foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			$events['id'] = $array['id'];
			$events['title'] = $array['summary'];
			$events['description'] = '';
			$events['lastmodified'] = $array['lastmodified'];
			$events['allDay'] = true;
			$events['start'] = $array['startdate'];
			$events['end'] = $array['enddate'];
			$calendarobjects[] = new Lists($events);
		}*/
		// OC way		
		while($row = mysql_fetch_array($result))  {
			$calendarobjects[] = $row;
		}
		
		return $calendarobjects;
	}

	function getCalendarName($id) {
	 
	 $q = "SELECT CONCAT(a.lastname,' ',a.firstname) FROM co_users as a, oc_clndr_calendars as b WHERE b.id='$id' and a.username = b.userid";
      $result = mysql_query($q, $this->_db->connection);
	  return mysql_result($result,0);				
	}

	/**
	 * @brief Returns all objects of a calendar between $start and $end
	 * @param integer $id
	 * @param DateTime $start
	 * @param DateTime $end
	 * @return array
	 *
	 * The objects are associative arrays. You'll find the original vObject
	 * in ['calendardata']
	 */
	function allInPeriod($id, $start, $end) {
		global $session;
		/*$start = DateTime::createFromFormat('U', $start);
		$start = $start->format('Y-m-d');
		$end = DateTime::createFromFormat('U', $end);
		$end = $end->format('Y-m-d');*/
		
		//require_once('/home/dev/public_html/sync/3rdparty/Sabre/VObject/Property/DateTime.php');
		$start = self::getUTCforMDB($start);
		$end = self::getUTCforMDB($end);
		
		$calendarobjects = array();
		$q ="SELECT * FROM oc_clndr_objects WHERE calendarid = '$id' AND objecttype = 'VEVENT' AND ((startdate >= '$start' AND enddate <= '$end' AND repeating = '0') OR (enddate >= '$start' AND startdate <= '$end' AND repeating = 0) OR (startdate <= '$end' AND repeating = '1') )";
		$result = mysql_query($q, $this->_db->connection);
		/* CO Array
		while($row = mysql_fetch_array($result))  {
			foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			$events['id'] = $array['id'];
			$events['title'] = $array['summary'];
			$events['description'] = '';
			$events['lastmodified'] = $array['lastmodified'];
			$events['allDay'] = true;
			$events['start'] = $array['startdate'];
			$events['end'] = $array['enddate'];
			$calendarobjects[] = new Lists($events);
		}*/
		// OC way		
		while($row = mysql_fetch_array($result))  {
			$calendarobjects[] = $row;
		}

		return $calendarobjects;
	}
	
	
	/**
	 * @brief Returns an object
	 * @param integer $id
	 * @return associative array
	 */
	function find($id) {
		$q ="SELECT * FROM oc_clndr_objects WHERE  id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		return mysql_fetch_array($result);
	}
	
		/**
	 * @brief checks if an event is already cached in a specific period
	 * @param (int) id - id of the event
	 * @param (DateTime) $from - start for period in UTC
	 * @param (DateTime) $until - end for period in UTC
	 * @return (bool)
	 */
	function is_cached_inperiod($id, $start, $end) {
		if(count($this->get_inperiod($id, $start, $end)) != 0) {
			return true;
		}else{
			return false;
		}

	}
	
	/**
	 * @brief returns the cache of an event in a specific peroid
	 * @param (int) $id - id of the event
	 * @param (DateTime) $from - start for period in UTC
	 * @param (DateTime) $until - end for period in UTC
	 * @return (array)
	 */
	function get_inperiod($id, $from, $until) {
		$from = $this->getUTCforMDB($from);
		$until = $this->getUTCforMDB($until);
		
		$q ="SELECT * FROM oc_clndr_repeat WHERE eventid = '$id' AND ((startdate >= '$from' AND startdate <= '$until') OR (enddate >= '$from' AND `enddate` <= '$until'))";
		$result = mysql_query($q, $this->_db->connection);
		$return = array();
		while($row = mysql_fetch_array($result))  {
			$return[] = $row;
		}
		return $return;
	}
	
	function getUTCforMDB($datetime) {
		return date('Y-m-d H:i', $datetime);
		//$start = DateTime::createFromFormat('U', $start);
		//$start = $start->format('Y-m-d');
	}
	
	
	/**
	 * @brief Gets the data of one calendar
	 * @param integer $id
	 * @return associative array
	 */
	function findCalendar($id) {
		/*$stmt = OCP\DB::prepare( 'SELECT * FROM `*PREFIX*clndr_calendars` WHERE `id` = ?' );
		$result = $stmt->execute(array($id));
		$row = $result->fetchRow();*/
		/*if($row['userid'] != OCP\USER::getUser() && !OC_Group::inGroup(OCP\User::getUser(), 'admin')) {
			$sharedCalendar = OCP\Share::getItemSharedWithBySource('calendar', $id);
			if (!$sharedCalendar || !($sharedCalendar['permissions'] & OCP\PERMISSION_READ)) {
				return $row; // I have to return the row so e.g. OC_Calendar_Object::getowner() works.
			}
			$row['permissions'] = $sharedCalendar['permissions'];
		} else {
			$row['permissions'] = OCP\PERMISSION_ALL;
		}*/
		
		$q ="SELECT * FROM oc_clndr_calendars WHERE id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		/*while($row = mysql_fetch_array($result))  {
			$return = $row;
		}*/
		return $row = mysql_fetch_array($result);
	}


	function toggleView($id, $active) {
		$q ="UPDATE oc_clndr_calendars SET active='$active' WHERE id = '$id'";
		$result = mysql_query($q, $this->_db->connection);
	}

	function newEvent($id,$type,$startdate,$enddate,$repeating,$summary,$data,$uri,$time,$eventtype,$treatmentid,$treatmentlocation,$eventlocationuid) {
		// `calendarid`,`objecttype`,`startdate`,`enddate`,`repeating`,`summary`,`calendardata`,`uri`,`lastmodified
		//$now = gmdate("Y-m-d H:00");
		$tid = 0;
		if($treatmentid != 0) {
			$q = "INSERT INTO " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " set mid='$treatmentid', item_date='$startdate', status = '0'";
			$result = mysql_query($q, $this->_db->connection);
			$tid = mysql_insert_id();
		}
		
		$q ="INSERT INTO oc_clndr_objects SET calendarid='$id', objecttype='$type', startdate='$startdate', enddate='$enddate', repeating='$repeating', summary='$summary', calendardata='$data',uri='$uri', lastmodified='$time', eventtype='$eventtype', eventid='$tid', eventlocation='$treatmentlocation', eventlocationuid='$eventlocationuid'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
		  	$id = mysql_insert_id();
			return $id;
		}
	}
	
	function editEvent($id,$type,$startdate,$enddate,$repeating,$summary,$data,$time,$eventtype,$treatmentid,$oldtreatmentid,$treatmentlocation,$eventlocationuid) {
		//$now = gmdate("Y-m-d H:00");
		if($eventtype == 1) { //is treatment
			if($treatmentid == $oldtreatmentid) {
				$taskid = $this->getTreatmentTaskEvent($id);
				$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " SET item_date='$startdate' WHERE id='$taskid'";
				$result = mysql_query($q, $this->_db->connection);
			} else {
				if($oldtreatmentid != 0) {
					$taskid = $this->getTreatmentTaskEvent($id);
					//$taskid = $this->getTreatmentTaskEvent($id);
					// move old task to bin
					//$treatmentsModel = new PatientsTreatmentsModel();
					//$treatmentsModel->deleteTaskOnly($taskid);
					$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " SET mid='$treatmentid', item_date='$startdate' WHERE id='$taskid'";
				$result = mysql_query($q, $this->_db->connection);
				} else {
					$now = gmdate("Y-m-d H:00");
					$q = "INSERT INTO " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " set mid='$treatmentid', item_date='$startdate', status = '0'";
					$result = mysql_query($q, $this->_db->connection);
					$taskid = mysql_insert_id();
				}
			}
			$q ="UPDATE oc_clndr_objects SET eventtype='$eventtype', eventid='$taskid', eventlocation='$treatmentlocation', eventlocationuid='$eventlocationuid', objecttype='$type', startdate='$startdate', enddate='$enddate', repeating='$repeating', summary='$summary', calendardata='$data', lastmodified='$time' WHERE id='$id'";
			$result = mysql_query($q, $this->_db->connection);
			return true;
		} else {
			// check if it was a treatment
			$taskid = $this->getTreatmentTaskEvent($id);
			if($taskid != 0) {
				$treatmentsModel = new PatientsTreatmentsModel();
				$treatmentsModel->deleteTaskOnly($taskid);
			}
			// just update event
			$q ="UPDATE oc_clndr_objects SET eventtype='0', eventid='0', eventlocation='$treatmentlocation', eventlocationuid='$eventlocationuid', objecttype='$type', startdate='$startdate', enddate='$enddate', repeating='$repeating', summary='$summary', calendardata='$data', lastmodified='$time' WHERE id='$id'";
			$result = mysql_query($q, $this->_db->connection);
			return true;
		}
	}


	function isRoomBusy($location,$startdate,$enddate,$id) {
		$q ="SELECT * FROM oc_clndr_objects WHERE eventlocation='$location' and eventlocation!='0' and ((startdate<='$startdate' and enddate>'$startdate') or (startdate<'$enddate' and enddate>='$enddate') or (startdate>'$startdate' and enddate<'$enddate')) and id !='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function getTreatmentEventType($id) {
		$q = "SELECT eventtype FROM oc_clndr_objects WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$treatmentid = mysql_result($result,0);
		return $treatmentid;
	}
	
	function getTreatmentTaskEvent($id) {
		$q = "SELECT eventid FROM oc_clndr_objects WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$treatmentid = mysql_result($result,0);
		return $treatmentid;
	}
	
	function getTreatmentLocationEvent($id) {
		$q = "SELECT eventlocation FROM oc_clndr_objects WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$treatmentloc = mysql_result($result,0);
		return $treatmentloc;
	}
	
	function getTreatmentLocationUidEvent($id) {
		$q = "SELECT eventlocationuid FROM oc_clndr_objects WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$treatmentloc = mysql_result($result,0);
		return $treatmentloc;
	}
	
	function getTreatmentEvent($id) {
		$q = "SELECT a.mid FROM co_patients_treatments_tasks as a,oc_clndr_objects as b WHERE b.id='$id' and b.eventid = a.id";
		$result = mysql_query($q, $this->_db->connection);
		if(mysql_num_rows($result) < 1) {
			return 0;
		} else {
			$treatmentid = mysql_result($result,0);
			return $treatmentid;
		}
	}
	
	
	function deleteEvent($id) {
		
		// delete all notices if exist
		$q ="DELETE FROM " . CO_TBL_CALENDAR_DESKTOP . " WHERE pid='$id'";
		$result = mysql_query($q, $this->_db->connection);
		
		$q ="SELECT eventtype,eventid FROM oc_clndr_objects WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_row($result);
		if($row[0] == 1) {
			$taskid = $row[1];
			$treatmentsModel = new PatientsTreatmentsModel();
			$treatmentsModel->deleteTask($taskid);
		} else {
			$q ="DELETE FROM oc_clndr_objects WHERE id='$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		//if ($result) {
			return true;
		//}
	}
	
	function getUIDFromCalendar($cal) {
		$q = "SELECT a.couid FROM oc_users as a, oc_clndr_calendars as b WHERE a.uid = b.userid and b.id='$cal'";
		$result = mysql_query($q, $this->_db->connection);
		return mysql_result($result,0);
	}
	
	
	
	/**
	 * @brief Updates ctag for calendar
	 * @param integer $id
	 * @return boolean
	 */
	function touchCalendar($id) {
		//$stmt = OCP\DB::prepare( 'UPDATE `*PREFIX*clndr_calendars` SET `ctag` = `ctag` + 1 WHERE `id` = ?' );
		//$stmt->execute(array($id));
		$q ="UPDATE oc_clndr_calendars SET ctag=ctag+1 WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		return true;
	}
	
	function moveToCalendar($id, $calendarid) {
		$q ="UPDATE oc_clndr_objects SET calendarid='$calendarid' WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		return true;
	}
	
	function getEventTypesDialog($field,$title,$option) {
		global $session,$lang;
		$str = '<div class="dialog-text">';
		//$q ="select id, title from " . CO_TBL_PROJECTS_FOLDERS . " where status='0' and bin = '0' ORDER BY title";
		if($option == 'all') {
			foreach($lang["EVENTTYPE"] as $key => $value) {
				$str .= '<a href="#" class="insertEventTypeFromDialog" title="' . $value . '" field="'.$field.'" gid="'.$key.'">' . $value . '</a>';
			}
		} else {
			foreach($lang["EVENTTYPE"] as $key => $value) {
				if($key == 1 || $key == 0) {
				$str .= '<a href="#" class="insertEventTypeFromDialog" title="' . $value . '" field="'.$field.'" gid="'.$key.'">' . $value . '</a>';
				}
			}
		}
		$str .= '</div>';	
		return $str;
	 }
	 
	function getBusyLocations($from,$fromtime,$totime) {
		
		$locations = array();
		$startdate = new DateTime($from . " " . $fromtime);
		$startdate = $startdate->format('Y-m-d H:i:s');
		$enddate = new DateTime($from . " " . $totime);
		$enddate = $enddate->format('Y-m-d H:i:s');
		$q ="SELECT eventlocation FROM oc_clndr_objects WHERE ((startdate<='$startdate' and enddate>'$startdate') or (startdate<'$enddate' and enddate>='$enddate') or (startdate>'$startdate' and enddate<'$enddate'))";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$locations[] = $row['eventlocation'];
		}
		return $locations;
	}
	
	function newWidgetItem($uid,$id,$description) {
		global $session;
		$q = "INSERT INTO " . CO_TBL_CALENDAR_DESKTOP . " set pid='$id', uid = '$uid', note = '$description'";
		$result = mysql_query($q, $this->_db->connection);
   }

	
	
	/*function newWidgetItems($id) {
		global $session;
		$users = "";
		// select all admins, guests for this forum
		$q = "SELECT admins,guests FROM co_forums_access where pid='$pid'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			if($row['admins'] != "") {
				$users .= $row['admins'] . ',';
			}
			if($row['guests'] != "") {
				$users .= $row['guests'] . ',';
			}
		}
		
		// select all posters to this forum
		$q = "SELECT user FROM " . CO_TBL_FORUMS_POSTS . " where pid='$pid' and bin='0'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
				$users .= $row['user'] . ',';
		}
		
		$q = "SELECT created_user FROM " . CO_TBL_FORUMS . " where id='$pid'";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			if($row['created_user'] != "") {
				$users .= $row['created_user'] . ',';
			}
		}
		$users = rtrim($users, ",");
		if($users != "") {
			$users = array_unique(explode(",",$users));
		} else {
			$users = array();
		}
		foreach($users as $user) {
			if($user != $session->uid) {
				$q = "INSERT INTO " . CO_TBL_FORUMS_DESKTOP . " set pid='$pid', uid = '$user', newpost='1'";
				$result = mysql_query($q, $this->_db->connection);
			}
		}
		
   }*/

	
	
	function existUserCalendarWidgets() {
		global $session;
		$q = "select count(*) as num from " . CO_TBL_CALENDAR_DESKTOP_SETTINGS . " where uid='$session->uid'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_assoc($result);
		if($row["num"] < 1) {
			return false;
		} else {
			return true;
		}
	}


	function getUserCalendarWidgets() {
		global $session;
		$q = "select * from " . CO_TBL_CALENDAR_DESKTOP_SETTINGS . " where uid='$session->uid'";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_assoc($result);
		return $row;
	}


	function getWidgetAlerts() {
		global $session, $date;
	  	
		$now = new DateTime("now");
		$today = $date->formatDate("now","Y-m-d");
		$tomorrow = $date->addDays($today, 1);
		$string = "";
		
		// notices for this user
		//$q ="select a.id as pid,a.folder,a.title as brainstormtitle,b.perm from " . CO_TBL_FORUMS . " as a,  " . CO_TBL_FORUMS_DESKTOP . " as b where a.id = b.pid and a.bin = '0' and b.uid = '$session->uid' and b.status = '0' and newpost!='1'";
		$q ="select a.id as pid, a.startdate, a.summary FROM oc_clndr_objects as a,  " . CO_TBL_CALENDAR_DESKTOP . " as b where a.id = b.pid and b.uid = '$session->uid'";
		$result = mysql_query($q, $this->_db->connection);
		$notices = "";
		$array = "";
		while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			$string .= $array["pid"] . ",";
			$notices[] = new Lists($array);
		}
		
		// reminders = neue posts für initiator und admins
		//$q ="select c.folder,c.id as pid,c.title as title from  " . CO_TBL_FORUMS . " as c where c.status='1' and c.bin = '0' " . $access;
		$reminders = "";
		//$q ="select a.id as pid,a.folder,a.title as forumtitle from " . CO_TBL_FORUMS . " as a,  " . CO_TBL_FORUMS_DESKTOP . " as b where a.id = b.pid and b.newpost = '1' and a.bin = '0' and b.uid = '$session->uid' GROUP BY pid ORDER BY b.id DESC";
		$q ="select a.id as pid, b.id as folderid, b.uid, a.startdate, a.summary, b.pid as eventID, b.note FROM oc_clndr_objects as a,  " . CO_TBL_CALENDAR_DESKTOP . " as b where a.id = b.pid and b.uid = '$session->uid'";

		$result = mysql_query($q, $this->_db->connection);
		while ($row = mysql_fetch_array($result)) {
			foreach($row as $key => $val) {
				$array[$key] = $val;
			}
			$date = new DateTime($array['startdate']);
			$array['startdate'] = $date->format('d.m.Y');
			$array['starttime'] = $date->format('H:i');
			$array['linkyear'] = $date->format('Y');
			$array['linkmonth'] = $date->format('n')-1;
			$array['linkday'] = $date->format('d');
			$string .= $array["folderid"] . "," . $array["pid"] . ",";
			$reminders[] = new Lists($array);
		}
		

		if(!$this->existUserCalendarWidgets()) {
			$q = "insert into " . CO_TBL_CALENDAR_DESKTOP_SETTINGS . " set uid='$session->uid', value='$string'";
			$result = mysql_query($q, $this->_db->connection);
			$widgetaction = "open";
		} else {
			$row = $this->getUserCalendarWidgets();
			$id = $row["id"];
			if($string == $row["value"]) {
				$widgetaction = "";
			} else {
				$widgetaction = "open";
			}
			$q = "UPDATE " . CO_TBL_CALENDAR_DESKTOP_SETTINGS . " set value='$string' WHERE id = '$id'";
			$result = mysql_query($q, $this->_db->connection);
		}
		
		$arr = array("reminders" => $reminders, "widgetaction" => $widgetaction);
		return $arr;
   }

   
	function markRead($id) {
		global $session;
		$q ="DELETE FROM " . CO_TBL_CALENDAR_DESKTOP . " WHERE uid = '$session->uid' and pid = '$id'";
		$result = mysql_query($q, $this->_db->connection);
		return true;
	}
	
	
	function saveLastUsedTreatments($id) {
		global $session;
		$string = $id . "," .$this->getUserSetting("last-used-caltreatments");
		$string = rtrim($string, ",");
		$ids_arr = explode(",", $string);
		$res = array_unique($ids_arr);
		foreach ($res as $key => $value) {
			$ids_rtn[] = $value;
		}
		array_splice($ids_rtn, 7);
		$str = implode(",", $ids_rtn);
		$this->setUserSetting("last-used-caltreatments",$str);
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
	
}

$calendarmodel = new CalendarModel();


?>
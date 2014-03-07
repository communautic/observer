<?php
class CalendarModel extends Model {

	// Get all Calendars
   function getFolderList($sort, $showGroupCalendar = 0) {
      global $session;
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
		$q = "SELECT a.id, a.firstname, a.lastname, a.username, b.id as calendarid, b.active as calactive, b.calendarcolor FROM co_users as a, oc_clndr_calendars as b WHERE (a.username = b.userid or a.calendar_uid = b.userid) and a.calendar = '1' and a.invisible = '0' and a.bin = '0' " . $order;
		
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
								"borderColor" => "#888",
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
			$folders[] = new Lists($array);
			}
			
		}
			
			
		
	  
	  $arr = array("folders" => $folders, "eventSources" => $eventSources, "sort" => $sortcur);
	  
	  return $arr;
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
		$start = DateTime::createFromFormat('U', $start);
		$start = $start->format('Y-m-d');
		$end = DateTime::createFromFormat('U', $end);
		$end = $end->format('Y-m-d');
		
		//require_once('/home/dev/public_html/sync/3rdparty/Sabre/VObject/Property/DateTime.php');
		
		
		$calendarobjects = array();
		$q ="SELECT * FROM oc_clndr_objects WHERE calendarid = '$id' AND objecttype = 'VEVENT' AND ((startdate >= '$start' AND enddate <= '$end' AND repeating = '0') OR (enddate >= '$end' AND startdate <= '$start' AND repeating = 0) OR (startdate <= '$end' AND repeating = '1') )";
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
		$now = gmdate("Y-m-d H:00");
		$tid = 0;
		if($treatmentid != 0) {
			$q = "INSERT INTO " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " set mid='$treatmentid', item_date='$now', status = '0'";
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
		$now = gmdate("Y-m-d H:00");
		if($eventtype == 1) { //is treatment
			if($treatmentid == $oldtreatmentid) {
				$taskid = $this->getTreatmentTaskEvent($id);
				$q = "UPDATE " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " SET item_date='$startdate' WHERE id='$taskid'";
				$result = mysql_query($q, $this->_db->connection);
			} else {
				if($oldtreatmentid != 0) {
					$taskid = $this->getTreatmentTaskEvent($id);
					// move old task to bin
					$treatmentsModel = new PatientsTreatmentsModel();
					$treatmentsModel->deleteTask($taskid);
				}
				$q = "INSERT INTO " . CO_TBL_PATIENTS_TREATMENTS_TASKS . " set mid='$treatmentid', item_date='$startdate', status = '0'";
				$result = mysql_query($q, $this->_db->connection);
				$taskid = mysql_insert_id();
			}
			$q ="UPDATE oc_clndr_objects SET eventtype='$eventtype', eventid='$taskid', eventlocation='$treatmentlocation', eventlocationuid='$eventlocationuid', objecttype='$type', startdate='$startdate', enddate='$enddate', repeating='$repeating', summary='$summary', calendardata='$data', lastmodified='$time' WHERE id='$id'";
			$result = mysql_query($q, $this->_db->connection);
			return true;
		} else {
			// check if it was a treatment
			$taskid = $this->getTreatmentTaskEvent($id);
			if($taskid != 0) {
				$treatmentsModel = new PatientsTreatmentsModel();
				$treatmentsModel->deleteTask($taskid);
			}
			// just update event
			$q ="UPDATE oc_clndr_objects SET eventtype='0', eventid='0', eventlocation='$treatmentlocation', eventlocationuid='$eventlocationuid', objecttype='$type', startdate='$startdate', enddate='$enddate', repeating='$repeating', summary='$summary', calendardata='$data', lastmodified='$time' WHERE id='$id'";
			$result = mysql_query($q, $this->_db->connection);
			return true;
		}
	}


	function isRoomBusy($location,$startdate,$enddate,$id) {
		$q ="SELECT * FROM oc_clndr_objects WHERE eventlocation='$location' and eventlocation!='0' and ((startdate<='$startdate' and enddate>'$startdate') or (startdate<'$enddate' and enddate>='$enddate') or (startdate>'$startdate' and enddate<'$enddate')) and id!='$id'";
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
		// if treatment bin task!!!!
		$q ="DELETE FROM oc_clndr_objects WHERE id='$id'";
		$result = mysql_query($q, $this->_db->connection);
		if ($result) {
			return true;
		}
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
	
	function getEventTypesDialog($field,$title) {
		global $session,$lang;
		$str = '<div class="dialog-text">';
		//$q ="select id, title from " . CO_TBL_PROJECTS_FOLDERS . " where status='0' and bin = '0' ORDER BY title";
		foreach($lang["EVENTTYPE"] as $key => $value) {
			$str .= '<a href="#" class="insertEventTypeFromDialog" title="' . $value . '" field="'.$field.'" gid="'.$key.'">' . $value . '</a>';
		}
		$str .= '</div>';	
		return $str;
	 }
	 
	function getBusyLocations($from,$fromtime,$totime) {
		
		$locations = array();
		$startdate = $this->_date->formatDateGMT($from . " " . $fromtime);
		$enddate = $this->_date->formatDateGMT( $from . " " . $totime);
		$q ="SELECT eventlocation FROM oc_clndr_objects WHERE ((startdate<='$startdate' and enddate>'$startdate') or (startdate<'$enddate' and enddate>='$enddate') or (startdate>'$startdate' and enddate<'$enddate'))";
		$result = mysql_query($q, $this->_db->connection);
		while($row = mysql_fetch_array($result)) {
			$locations[] = $row['eventlocation'];
		}
		return $locations;
	}
	
}

$calendarmodel = new CalendarModel();


?>
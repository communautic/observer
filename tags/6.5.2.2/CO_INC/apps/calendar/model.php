<?php
class CalendarModel extends Model {

	// Get all Calendars
   function getFolderList($sort) {
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
	  
		if(!$session->isSysadmin()) {
			//$q ="select a.id, a.title from " . CO_TBL_PROJECTS_FOLDERS . " as a where a.status='0' and a.bin = '0' and (SELECT count(*) FROM co_projects_access as b, co_projects as c WHERE (b.admins REGEXP '[[:<:]]" . $session->uid . "[[:>:]]' or b.guests REGEXP '[[:<:]]" . $session->uid . "[[:>:]]') and c.folder=a.id and b.pid=c.id) > 0 " . $order;
			$q = "select id,firstname,lastname from co_users as a, oc_clndr_calendars as.b where calendar = '1' and invisible = '0' and bin = '0' " . $order;
		} else {
			$q = "SELECT a.id, a.firstname, a.lastname, a.username, b.id as calendarid, b.active as calactive, b.calendarcolor FROM co_users as a, oc_clndr_calendars as b WHERE (a.username = b.userid or a.calendar_uid = b.userid) and a.calendar = '1' and a.invisible = '0' and a.bin = '0' " . $order;
		}
		
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

	
	
	
}

$calendarmodel = new CalendarModel();


?>
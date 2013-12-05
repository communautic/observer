<?php
class CalendarModel extends Model {


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


	
	
	
}

$calendarmodel = new CalendarModel();


?>
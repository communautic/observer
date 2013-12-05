<?php

class Calendar extends Controller {
	// get all available apps
	function __construct($name) {
			$this->application = $name;
			$this->form_url = "apps/$name/";
			$this->model = new CalendarModel();
			$this->modules = array();
			$this->num_modules = 0;
			$this->binDisplay = false;
			$this->archiveDisplay = false;
			$this->contactsDisplay = false; // list access status on contact page
	}


	function getrequestedEvents($calendarid, $start, $end) {
		$events = array();
		if($calendarid == 'shared_events') {
			$singleevents = OCP\Share::getItemsSharedWith('event', OC_Share_Backend_Event::FORMAT_EVENT);
			foreach($singleevents as $singleevent) {
				$singleevent['summary'] .= ' (' . self::$l10n->t('by') .  ' ' . OC_Calendar_Object::getowner($singleevent['id']) . ')';
				$events[] =  $singleevent;
			}
		}else{
			if (is_numeric($calendarid)) {
				/*$calendar = self::getCalendar($calendarid);
				OCP\Response::enableCaching(0);
				OCP\Response::setETagHeader($calendar['ctag']);*/
				//$events = OC_Calendar_Object::allInPeriod($calendarid, $start, $end, $calendar['userid'] !== OCP\User::getUser());
				$events = $this->model->allInPeriod($calendarid, $start, $end);
			} else {
				OCP\Util::emitHook('OC_Calendar', 'getEvents', array('calendar_id' => $calendarid, 'events' => &$events));
			}
		}
		//return json_encode($events);
		
		/* OC way*/
		$output = array();
		foreach($events as $event) {
			$result = $this->generateEventOutput($event, $start, $end);
			if (is_array($result)) {
				$output = array_merge($output, $result);
			}
		}
		return json_encode($output);
		
		
	}
	
	
	/**
	 * @brief generates the output for an event which will be readable for our js
	 * @param (mixed) $event - event object / array
	 * @param (int) $start - DateTime object of start
	 * @param (int) $end - DateTime object of end
	 * @return (array) $output - readable output
	 */
	function generateEventOutput(array $event, $start, $end) {
		global $session;
		require_once('/home/dev/public_html/sync/3rdparty/Sabre/VObject/Node.php');
		require_once('/home/dev/public_html/sync/3rdparty/Sabre/VObject/ElementList.php');
		require_once('/home/dev/public_html/sync/3rdparty/Sabre/VObject/Component.php');
		require_once('/home/dev/public_html/sync/3rdparty/Sabre/VObject/Component/VCalendar.php');
		require_once('/home/dev/public_html/sync/3rdparty/Sabre/VObject/Component/VEvent.php');
		require_once('/home/dev/public_html/sync/3rdparty/Sabre/VObject/Property.php');
		require_once('/home/dev/public_html/sync/3rdparty/Sabre/VObject/TimeZoneUtil.php');
		require_once('/home/dev/public_html/sync/3rdparty/Sabre/VObject/Property/DateTime.php');
		require_once('/home/dev/public_html/sync/3rdparty/Sabre/VObject/Parameter.php');
		require_once('/home/dev/public_html/sync/3rdparty/Sabre/VObject/Reader.php');
		require_once('/home/dev/public_html/sync/lib/private/vobject.php');
		require_once('/home/dev/public_html/sync/apps/calendar/lib/calendar.php');
		require_once('/home/dev/public_html/sync/apps/calendar/lib/object.php');
		
		
		if(!isset($event['calendardata']) && !isset($event['vevent'])) {
			return false;
		}
		if(!isset($event['calendardata']) && isset($event['vevent'])) {
			$event['calendardata'] = "BEGIN:VCALENDAR\nVERSION:2.0\nPRODID:ownCloud's Internal iCal System\n"
				. $event['vevent']->serialize() .  "END:VCALENDAR";
		}
		try{
			$object = OC_VObject::parse($event['calendardata']);
			if(!$object) {
				\OCP\Util::writeLog('calendar', __METHOD__.' Error parsing event: '.print_r($event, true), \OCP\Util::DEBUG);
				return array();
			}
	
			$output = array();
	
			if($object->name === 'VEVENT') {
				$vevent = $object;
			} elseif(isset($object->VEVENT)) {
				$vevent = $object->VEVENT;
			} else {
				\OCP\Util::writeLog('calendar', __METHOD__.' Object contains not event: '.print_r($event, true), \OCP\Util::DEBUG);
				return $output;
			}
			$id = $event['id'];
			/*if(OC_Calendar_Object::getowner($id) !== OCP\USER::getUser()) {
				// do not show events with private or unknown access class
				if (isset($vevent->CLASS)
					&& ($vevent->CLASS->value === 'PRIVATE'
					|| $vevent->CLASS->value === ''))
				{
					return $output;
				}
				$object = OC_Calendar_Object::cleanByAccessClass($id, $object);
			}*/
			$allday = ($vevent->DTSTART->getDateType() == Sabre\VObject\Property\DateTime::DATE)?true:false;
			$last_modified = @$vevent->__get('LAST-MODIFIED');
			$lastmodified = ($last_modified)?$last_modified->getDateTime()->format('U'):0;
			$staticoutput = array('id'=>(int)$event['id'],
							'title' => (!is_null($vevent->SUMMARY) && $vevent->SUMMARY->value != '')? strtr($vevent->SUMMARY->value, array('\,' => ',', '\;' => ';')) : self::$l10n->t('unnamed'),
							'description' => isset($vevent->DESCRIPTION)?strtr($vevent->DESCRIPTION->value, array('\,' => ',', '\;' => ';')):'',
							'lastmodified'=>$lastmodified,
							'allDay'=>$allday);
			
			if($this->isrepeating($id) && $this->model->is_cached_inperiod($event['id'], $start, $end)) {
				$cachedinperiod = $this->model->get_inperiod($id, $start, $end);
				foreach($cachedinperiod as $cachedevent) {
					$dynamicoutput = array();
					if($allday) {
						$start_dt = new DateTime($cachedevent['startdate'], new DateTimeZone('UTC'));
						$end_dt = new DateTime($cachedevent['enddate'], new DateTimeZone('UTC'));
						$dynamicoutput['start'] = $start_dt->format('Y-m-d');
						$dynamicoutput['end'] = $end_dt->format('Y-m-d');
					}else{
						$start_dt = new DateTime($cachedevent['startdate'], new DateTimeZone('UTC'));
						$end_dt = new DateTime($cachedevent['enddate'], new DateTimeZone('UTC'));
						$start_dt->setTimezone(new DateTimeZone($session->timezone));
						$end_dt->setTimezone(new DateTimeZone($session->timezone));
						$dynamicoutput['start'] = $start_dt->format('Y-m-d H:i:s');
						$dynamicoutput['end'] = $end_dt->format('Y-m-d H:i:s');
					}
					$output[] = array_merge($staticoutput, $dynamicoutput);
				}
			}else{
				/*if(OC_Calendar_Object::isrepeating($id) || $event['repeating'] == 1) {
					if($event['repeating'] == 1) {
					$object->expand($start, $end);
				}*/
				foreach($object->getComponents() as $singleevent) {
					if(!($singleevent instanceof Sabre\VObject\Component\VEvent)) {
						continue;
					}
					//$dynamicoutput = OC_Calendar_Object::generateStartEndDate($singleevent->DTSTART, OC_Calendar_Object::getDTEndFromVEvent($singleevent), $allday, self::$tz);
					$dynamicoutput = OC_Calendar_Object::generateStartEndDate($singleevent->DTSTART, OC_Calendar_Object::getDTEndFromVEvent($singleevent), $allday, $session->timezone);
					$output[] = array_merge($staticoutput, $dynamicoutput);
				}
			}
			return $output;
		}catch(Exception $e) {
			$uid = 'unknown';
			if(isset($event['uri'])){
				$uid = $event['uri'];
			}
			\OCP\Util::writeLog('calendar', 'Event (' . $uid . ') contains invalid data!',\OCP\Util::WARN);
		}
	}
	
	
	/**
	 * @brief checks if an object is repeating
	 * @param integer $id
	 * @return boolean
	 * Original OC_Calendar_Object::isrepeating($id)
	 */
	function isrepeating($id) {
		$event = $this->model->find($id);
		return ($event['repeating'] == 1)?true:false;
	}
	
	/**
	 * @brief checks if an event is already cached in a specific period
	 * @param (int) id - id of the event
	 * @param (DateTime) $from - start for period in UTC
	 * @param (DateTime) $until - end for period in UTC
	 * @return (bool)
	 */
	function is_cached_inperiod($id, $start, $end) {
		if(count(self::get_inperiod($id, $start, $end)) != 0) {
			return true;
		}else{
			return false;
		}

	}
	

}
$calendar = new Calendar("calendar");
?>
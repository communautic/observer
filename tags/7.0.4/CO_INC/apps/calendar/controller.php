<?php

/**
* Event types:
* Freier Termin = 0
* Treatment = 1
**/

class Calendar extends Controller {
	//static $calendarcolors_used = array();
	
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
			$this->calendarcolors = array('red','yellow','blue','grey');
			
	}
	
	function getFolderList($sort) {
		global $system, $lang;
		$arr = $this->model->getFolderList($sort);
		$folders = $arr["folders"];
		$data["eventSources"] = $arr["eventSources"];
		ob_start();
			include('view/folders_list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		return json_encode($data);
	}
	
	function getSettingsList($sort) {
		global $system, $lang;
		$arr = $this->model->getFolderList($sort);
		$folders = $arr["folders"];
		ob_start();
			include('view/settings_list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		return json_encode($data);
	}
	
	function getPrintOptions() {
		global $lang;
			ob_start();
				include 'view/print_options.php';
				$html = ob_get_contents();
			ob_end_clean();
			return $html;
	}
	
	function printCalendar($id, $start, $end, $option, $t) {
		global $session,$lang;
		$title = "";
		$html = "";
		$calendarName = $this->model->getCalendarName($id);
		$events = $this->model->printCalendar($id, $start, $end, $option);
		$output = array();
		foreach($events as $event) {
			$result = $this->generateEventOutput($event, $start, $end, $id);
			if (is_array($result)) {
				//$result['patientfullname'] = "test";
				$output = array_merge($output, $result);
			}
		}
		//print_r($output);
		//if($arr = $this->model->printCalendar($id, $start, $end)) {
			//$events = $arr["events"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = 'Kalender';
		//}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["CALENDAR_PRINT"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}
	
	function printCalendars($calids, $start, $end, $option, $t) {
		global $session,$lang;
		$title = "";
		$html = "";
		
		switch($option) {
			case 1:
				$title = 'Behandlungen';
			break;
			case 2:
				$title = 'Ereignisse';
			break;
			case 3:
				$title = 'Alle Termine';
			break;
		}
		
		$output = array();
		$calids = explode(',', $calids);
		foreach($calids as $id) {
			//$calendarName = $this->model->getCalendarName($id);
			$events = $this->model->printCalendar($id, $start, $end, $option);
			foreach($events as $event) {
				$result = $this->generateEventOutput($event, $start, $end, $id);
				if (is_array($result)) {
					//$result['patientfullname'] = "test";
					$output = array_merge($output, $result);
				}
			}
		}
		//print_r($output);
		//if($arr = $this->model->printCalendar($id, $start, $end)) {
			//$events = $arr["events"];
			ob_start();
				include 'view/print_multi.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = 'Kalender';
		//}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["CALENDAR_PRINT"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
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
			$result = $this->generateEventOutput($event, $start, $end, $calendarid);
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
	function generateEventOutput(array $event, $start, $end, $calendarid) {
		global $session, $lang;
		
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
			// title
			$event['treat'] = 0;
			$event['patientid'] = 0;
			$event['folderid'] = 0;
			$event['status'] = 0;
			$eventclass = '';
			$eventaccess = 1;
			if($event['eventtype'] == 1) {
				$treatmentsModel = new PatientsTreatmentsModel();
				$treatmentevent = $treatmentsModel->getTreatmentEvent($event['eventid'],1);
				//$title = $treatmentevent['patient'] . ', ' . $treatmentevent['title'];
				if(isset($treatmentevent['id']) && $treatmentevent['id'] > 0) {
					$title = $treatmentevent['patient'];
					if($event['eventlocation'] != 0) {
						$title .= '<br /> <span style="font-weight: normal; line-height: 19px;">' . $treatmentsModel->getTreatmentLocation($event['eventlocation']) . '</span>';
					}
					if($event['eventlocationuid'] != 0) {
						$title .=  '<br /> <span style="font-weight: normal; line-height: 19px;">' . $lang['CALENDAR_EVENT_HOUSE_CALL'] . '</span>';
						$eventclass = 'fc-event-treatment-housecall';
					}
					$event['treat'] = $treatmentevent['mid'];
					$event['status'] = $treatmentevent['status'];
					$event['patientid'] = $treatmentevent['id'];
					/*$contactsModel = new ContactsModel();
					$event['patientfullname'] = $contactsModel->getUserFullname($treatmentevent['id']);*/
					$event['folderid'] = $treatmentevent['folder'];
					
					// check here if I am admin for this patient
					if (!$session->isSysadmin()) {
						if(!in_array($event['patientid'],$treatmentsModel->getEditPerms($session->uid))) {
							$eventaccess = 0;
						}
					} 
					
				} else {
					$event['eventtype'] = 0;
					$title = (!is_null($vevent->SUMMARY) && $vevent->SUMMARY->value != '')? strtr($vevent->SUMMARY->value, array('\,' => ',', '\;' => ';')) : 'no title';
				if($event['eventlocation'] != 0) {
					$treatmentsModel = new PatientsTreatmentsModel();
					$title .= '<br /> <span style="font-weight: normal; line-height: 19px;">' . $treatmentsModel->getTreatmentLocation($event['eventlocation']) . '</span>';
				}
				}
			} else {
				//$regularEventDisplay  = ' style="display: block"';
				//$treatmentEventDisplay = ' style="display: none"';
				//$title = (!is_null($vevent->SUMMARY) && $vevent->SUMMARY->value != '')? strtr($vevent->SUMMARY->value, array('\,' => ',', '\;' => ';')) : self::$l10n->t('unnamed');
				$title = (!is_null($vevent->SUMMARY) && $vevent->SUMMARY->value != '')? strtr($vevent->SUMMARY->value, array('\,' => ',', '\;' => ';')) : 'no title';
				if($event['eventlocation'] != 0) {
					$treatmentsModel = new PatientsTreatmentsModel();
					$title .= '<br /> <span style="font-weight: normal; line-height: 19px;">' . $treatmentsModel->getTreatmentLocation($event['eventlocation']) . '</span>';
				}
			}
			if($allday) {
				$tooltip_time = '';
			} else {
				$tooltip_start = new DateTime($event['startdate']);
				$tooltip_start = $tooltip_start->format('H:i');
				$tooltip_end = new DateTime($event['enddate']);
				$tooltip_end = $tooltip_end->format('H:i');
				$tooltip_time = $tooltip_start. ' - '.$tooltip_end. '<br />';
			}
			$tooltip = $tooltip_time . $title;
			
			$staticoutput = array('id'=>(int)$event['id'],
							//'title' => (!is_null($vevent->SUMMARY) && $vevent->SUMMARY->value != '')? strtr($vevent->SUMMARY->value, array('\,' => ',', '\;' => ';')) : self::$l10n->t('unnamed'),
							'title' => $title,
							'description' => isset($vevent->DESCRIPTION)?strtr($vevent->DESCRIPTION->value, array('\,' => ',', '\;' => ';')):'',
							'lastmodified'=>$lastmodified,
							'allDay'=>$allday,
							'eventtype'=>$event['eventtype'],
							'treatment'=>$event['eventid'],
							'treatmentid'=>$event['treat'],
							'treatmentstatus'=>$event['status'],
							'patientid'=>$event['patientid'],
							'folderid'=>$event['folderid'],
							'tooltip' => $tooltip,
							'calendarid'=>$calendarid,
							'eventclass'=>$eventclass,
							'eventaccess'=>$eventaccess
							);
			
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
	 * @brief returns informations about a calendar
	 * @param int $id - id of the calendar
	 * @param bool $security - check access rights or not
	 * @param bool $shared - check if the user got access via sharing
	 * @return mixed - bool / array
	 */
	function getCalendar($id, $security = false, $shared = false) {
		if(! is_numeric($id)) {
			return false;
		}

		//$calendar = OC_Calendar_Calendar::find($id);
		$calendar = $this->model->findCalendar($id);
		// FIXME: Correct arguments to just check for permissions
		/*if($security === true && $shared === false) {
			if(OCP\User::getUser() === $calendar['userid']){
				return $calendar;
			}else{
				return false;
			}
		}
		if($security === true && $shared === true) {
			if(OCP\Share::getItemSharedWithBySource('calendar', $id)) {
				return $calendar;
			}
		}*/
		return $calendar;
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
	
	
	
	// OC: setCalendarActive
	function toggleView($calendarid, $active, $numberofcals, $col) {
		//$this->model->toggleView($calendarid, $active); original OC call
		//$calendarcolors = array('red','yellow','blue','grey');
		/*$this->calendarcolors_used[] = $numberofcals; 
		print_r($this->calendarcolors_used);*/
		
		$calendar = $this->getCalendar($calendarid, true);
		/*$colordiff = array_diff($this->calendarcolors, $this->calendarcolors_used);
		$i = mt_rand(0, 3);
		$this->calendarcolors_used[] = $this->calendarcolors[$i];
		$c = array_values($this->calendarcolors_used);
		if(!empty($c)) {
			$calendar['calendarcolor'] =  $c[0];
		}*/
		/*echo $calendarcolors_used+$numberofcals;
		//$index = $this->calendarcolors_used;
		$calendar['calendarcolor'] = $this->calendarcolors[$calendarcolors_used];
		echo $active;
		echo $calendarcolors_used+1;
		if($active == "1") {
			$calendarcolors_used = $calendarcolors_used+1;
			//echo $this->calendarcolors_used;
		} else {
			$calendarcolors_used = $calendarcolors_used-1;
			//echo $this->calendarcolors_used;
		}*/
		$globalColor0 = '#6EAAFF';
		$globalColor1 = '#FF7878';
		$globalColor2 = '#8CD264';
		$globalColor3 = '#FFD41D';
		$globalColor4 = '#D2B4FF';
		$globalColor5 = '#FF9E1F';
		$globalColor6 = '#64CCC9';
		$globalColor7 = '#FF83FF';
		$globalColor8 = '#9999FF';
		$globalColor9 = '#BCBCBC';
		
		$calendar['calendarcolor'] = ${$col};
		return json_encode(array(
			'active' => $active,
			'eventSource' => $this->getEventSourceInfo($calendar)
		));
	}
	function showSingleCalendar($calendarid) {
		$calendar = $this->getCalendar($calendarid, true);
		return json_encode(array(
			'active' => 1,
			'eventSource' => $this->getEventSourceInfo($calendar)
		));
	}
	
	/**
	 * @brief generates the Event Source Info for our JS
	 * @param array $calendar calendar data
	 * @return array
	 */
	function getEventSourceInfo($calendar) {
		return array(
			'url' => '/?path=apps/calendar&request=getrequestedEvents&calendar_id='.$calendar['id'],
			'backgroundColor' => $calendar['calendarcolor'],
			'borderColor' => $calendar['calendarcolor'],
			//'textColor' => $this->generateTextColor($calendar['calendarcolor']),
			'textColor' => '#000',
			'cache' => false,
		);
	}
	
	/*
	 * @brief generates the text color for the calendar
	 * @param string $calendarcolor rgb calendar color code in hex format (with or without the leading #)
	 * (this function doesn't pay attention on the alpha value of rgba color codes)
	 * @return boolean
	 */
	/*function generateTextColor($calendarcolor) {
		if(substr_count($calendarcolor, '#') == 1) {
			$calendarcolor = substr($calendarcolor,1);
		}
		$red = hexdec(substr($calendarcolor,0,2));
		$green = hexdec(substr($calendarcolor,2,2));
		$blue = hexdec(substr($calendarcolor,4,2));
		//recommendation by W3C
		$computation = ((($red * 299) + ($green * 587) + ($blue * 114)) / 1000);
		return ($computation > 130)?'#000000':'#FAFAFA';
	}*/
	
	
	function newEventForm($start, $end, $allday, $calendarid, $formtype) {
		global $session,$system, $lang;
		
		$start = $_POST['start'];
		$end = $_POST['end'];
		$allday = $_POST['allday'];
		
		if (!$end) {
			//$duration = OCP\Config::getUserValue( OCP\USER::getUser(), 'calendar', 'duration', '60');
			$end = $start + (60 * 60);
		}
		$start = new DateTime('@'.$start);
		$end = new DateTime('@'.$end);
		//$timezone = OC_Calendar_App::getTimezone();
		$timezone = $session->timezone;
		$start->setTimezone(new DateTimeZone($timezone));
		$end->setTimezone(new DateTimeZone($timezone));
		
		$startdate = $start->format('d.m.Y');
		$starttime = $start->format('H:i');
		$enddate = $end->format('d.m.Y');
		$endtime = $end->format('H:i');
		//$tmpl->assign('allday', $allday);
		
		$arr = $this->model->getFolderList(0,1);
		$calendars = $arr["folders"];
		switch($formtype) {
			case 0; // sitzung
				$regularEventDisplay = ' style="display: none"';
				$treatmentEventDisplay = ' style="display: block"';
				$contactEventDisplay = ' style="display: none"';
				$newContactEventDisplay = ' style="display: none"';
				$newPatientEventDisplay = ' style="display: none"';
				$eventtype = 1;
			break;
			case 1; // event
				$regularEventDisplay = ' style="display: block"';
				$treatmentEventDisplay = ' style="display: none"';
				$contactEventDisplay = ' style="display: none"';
				$newContactEventDisplay = ' style="display: none"';
				$newPatientEventDisplay = ' style="display: none"';
				$eventtype = 0;
			break;
			case 2; // neuanlage
				$regularEventDisplay = ' style="display: none"';
				$treatmentEventDisplay = ' style="display: none"';
				$contactEventDisplay = ' style="display: block"';
				$newContactEventDisplay = ' style="display: none"';
				$newPatientEventDisplay = ' style="display: none"';
				$eventtype = 1;
			break;
			case 3; // patientenakt
				$regularEventDisplay = ' style="display: none"';
				$treatmentEventDisplay = ' style="display: none"';
				$contactEventDisplay = ' style="display: none"';
				$newContactEventDisplay = ' style="display: block"';
				$newPatientEventDisplay = ' style="display: none"';
				$eventtype = 1;
			break;
			case 4; // behandlung
				$regularEventDisplay = ' style="display: none"';
				$treatmentEventDisplay = ' style="display: none"';
				$contactEventDisplay = ' style="display: none"';
				$newContactEventDisplay = ' style="display: none"';
				$newPatientEventDisplay = ' style="display: block"';
				$eventtype = 1;
			break;
		}
		
		/*if($formtype == 0) {
			$regularEventDisplay = ' style="display: none"';
			$treatmentEventDisplay = ' style="display: block"';
			$contactEventDisplay = ' style="display: none"';
			$eventtype = 1;
		} else if($formtype == 1){
			$regularEventDisplay = ' style="display: block"';
			$treatmentEventDisplay = ' style="display: none"';
			$eventtype = 0;
		}*/
		
		ob_start();
			include('view/new.php');
			$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	function newEvent($cal, $post) {
		global $system, $lang;
		
		$eventtype = $post['eventtype'];
		$cal = $post['calendar'];
		$t_id = $post['treatmentid'];
		$t_loc = $post['treatmentlocationid'];
		$t_locuid = $post['treatmentlocationuid'];
		//$post['description'] = str_replace("\r\n", '\n', $system->checkMagicQuotes($post['description']));
		
		
		
		$errarr = $this->validateRequest($post);
		if($errarr) {
			$data["status"] = 'error';
			foreach($errarr as $key => $value) {
				$data[$key] = $value;
			}
		} else {
			
			// title
			$title = $post['title'];
				if($eventtype == 1) {
					$treatmentsModel = new PatientsTreatmentsModel();
					$pid = $treatmentsModel->getTreatmentPatientID($t_id);
					$contactsModel = new ContactsModel();
					$title = $contactsModel->getUserFullnameShortFirstname($pid);
					if($t_loc != 0) {
						$title .= ', ' . $post['location'];
					}
					if($t_locuid != 0) {
						$title .=  ', ' . $lang['CALENDAR_EVENT_HOUSE_CALL'];
					}
				}
				if($eventtype == 2) {
					
					$lastname = $post['lastname'];
					$firstname = $post['firstname'];
					$phone = $post['phone'];
					$email = $post['email'];
					// new contact
					$contactsModel = new ContactsModel();
					$contact_id = $contactsModel->newContactFromCalendar($lastname,$firstname,$phone,$email);
					$title = $contactsModel->getUserFullnameShortFirstname($contact_id);
					if($t_loc != 0) {
						$title .= ', ' . $post['location'];
					}
					if($t_locuid != 0) {
						$title .=  ', ' . $lang['CALENDAR_EVENT_HOUSE_CALL'];
					}
					// add contact as patient
					$management_id = $this->model->getUIDFromCalendar($post['calendar']);
					$folder_id = $post['folderid'];
					$patientsModel = new PatientsModel();
					$pid = $patientsModel->newPatientFromCalendar($folder_id,$contact_id,$management_id);
					
					// then create the treatment
					$treatmentsModel = new PatientsTreatmentsModel();
					$treatment_title = $post['treatmenttitle'];
					$t_id = $treatmentsModel->createNewFromCalendar($pid, $treatment_title);
					$eventtype = 1;
				}
				if($eventtype == 3) {
					$contact_id = $post['contactid'];
					$contactsModel = new ContactsModel();
					$title = $contactsModel->getUserFullnameShortFirstname($contact_id);
					if($t_loc != 0) {
						$title .= ', ' . $post['location'];
					}
					if($t_locuid != 0) {
						$title .=  ', ' . $lang['CALENDAR_EVENT_HOUSE_CALL'];
					}
					// add contact as patient
					$management_id = $this->model->getUIDFromCalendar($post['calendar']);
					$folder_id = $post['folderid'];
					$patientsModel = new PatientsModel();
					$pid = $patientsModel->newPatientFromCalendar($folder_id,$contact_id,$management_id);
					
					// then create the treatment
					$treatmentsModel = new PatientsTreatmentsModel();
					$treatment_title = $post['treatmenttitle'];
					$t_id = $treatmentsModel->createNewFromCalendar($pid, $treatment_title);
					$eventtype = 1;
				}
				if($eventtype == 4) {
					/*$pid = $post['patientid'];
					$contactsModel = new ContactsModel();
					$title = $contactsModel->getUserFullnameShortFirstname($pid);
					if($t_loc != 0) {
						$title .= ', ' . $post['location'];
					}
					if($t_locuid != 0) {
						$title .=  ', ' . $lang['CALENDAR_EVENT_HOUSE_CALL'];
					}
					// add contact as patient
					$management_id = $this->model->getUIDFromCalendar($post['calendar']);
					$folder_id = $post['folderid'];
					//$patientsModel = new PatientsModel();
					//$pid = $patientsModel->newPatientFromCalendar($folder_id,$contact_id,$management_id);
					
					// then create the treatment
					$treatmentsModel = new PatientsTreatmentsModel();
					$treatment_title = $post['treatmenttitle'];
					$t_id = $treatmentsModel->createNewFromCalendar($pid, $treatment_title);
					$eventtype = 1;*/
					/*$contact_id = $post['patientid'];
					$contactsModel = new ContactsModel();
					$title = $contactsModel->getUserFullnameShortFirstname($contact_id);
					if($t_loc != 0) {
						$title .= ', ' . $post['location'];
					}
					if($t_locuid != 0) {
						$title .=  ', ' . $lang['CALENDAR_EVENT_HOUSE_CALL'];
					}
					// add contact as patient
					$management_id = $this->model->getUIDFromCalendar($post['calendar']);
					$folder_id = $post['folderid'];
					$patientsModel = new PatientsModel();
					$pid = $patientsModel->newPatientFromCalendar($folder_id,$contact_id,$management_id);
					
					// then create the treatment
					$treatmentsModel = new PatientsTreatmentsModel();
					$treatment_title = $post['treatmenttitle'];
					$t_id = $treatmentsModel->createNewFromCalendar($pid, $treatment_title);
					$eventtype = 1;*/
					$pid = $post['patientid'];
					
					$folder_id = $post['folderid'];
					$patientsModel = new PatientsModel();
					//$contact_id = $patientsModel->getUserFullnameShortFirstname($pid);
					$title = $patientsModel->getUserFullnameShortFirstname($pid);
					//echo $title;
					//$pid = $patientsModel->newPatientFromCalendar($folder_id,$contact_id,$management_id);
					if($patientsModel->patientExistsInFolder($pid,$folder_id)) {
						//create treatment
						//$contactsModel = new ContactsModel();
						//$title = $contactsModel->getUserFullnameShortFirstname($contact_id);
						if($t_loc != 0) {
							$title .= ', ' . $post['location'];
						}
						if($t_locuid != 0) {
							$title .=  ', ' . $lang['CALENDAR_EVENT_HOUSE_CALL'];
						}
						// then create the treatment
						$treatmentsModel = new PatientsTreatmentsModel();
						$treatment_title = $post['treatmenttitle'];
						$t_id = $treatmentsModel->createNewFromCalendar($pid, $treatment_title);
					} else {
						// duplicate patient to folder
						$management_id = $this->model->getUIDFromCalendar($post['calendar']);
						$pid = $patientsModel->createDuplicatePatientFromCalendar($pid,$folder_id,$management_id);
						if($t_loc != 0) {
							$title .= ', ' . $post['location'];
						}
						if($t_locuid != 0) {
							$title .=  ', ' . $lang['CALENDAR_EVENT_HOUSE_CALL'];
						}
						// then create the treatment
						$treatmentsModel = new PatientsTreatmentsModel();
						$treatment_title = $post['treatmenttitle'];
						$t_id = $treatmentsModel->createNewFromCalendar($pid, $treatment_title);
						
					}
					
					
					// then create the treatment
					//$treatmentsModel = new PatientsTreatmentsModel();
					//$treatment_title = $post['treatmenttitle'];
					//$t_id = $treatmentsModel->createNewFromCalendar($pid, $treatment_title);
					
					/*$contactsModel = new ContactsModel();
					$title = $contactsModel->getUserFullnameShortFirstname($contact_id);
					if($t_loc != 0) {
						$title .= ', ' . $post['location'];
					}
					if($t_locuid != 0) {
						$title .=  ', ' . $lang['CALENDAR_EVENT_HOUSE_CALL'];
					}
					// add contact as patient
					$management_id = $this->model->getUIDFromCalendar($post['calendar']);
					$folder_id = $post['folderid'];
					$patientsModel = new PatientsModel();
					$pid = $patientsModel->newPatientFromCalendar($folder_id,$contact_id,$management_id);
					
					*/
					$eventtype = 1;
				}
			$post['title'] = $title;
			//print_r($post);
			
			$vcalendar = $this->createVCalendarFromRequest($post);
			$res = $this->add($cal, $vcalendar->serialize(), $eventtype, $t_id, $t_loc, $t_locuid);
			if($post['desktop'] == 1) {
				if($cal == 2) {
					$arr = $this->model->getFolderList(0);
					$folders = $arr["folders"];
					foreach($folders as $folder) {
						//echo $folder->id . ' ';
						$this->model->newWidgetItem($folder->id,$res);
					}
				} else {
					$uid = $this->model->getUIDFromCalendar($cal);
					$this->model->newWidgetItem($uid,$res);
				}
			}
			$data["status"] = 'success';
		}
		return json_encode($data);
	}
	
	function editEventForm($id) {
		global $session,$system, $lang;

		$data = $this->getEventObject($id, false, false);
		$eventid = $id;
		$calendarid = $data['calendarid'];
		
		$object = OC_VObject::parse($data['calendardata']);
		$vevent = $object->VEVENT;		
		$dtstart = $vevent->DTSTART;
		$dtend = OC_Calendar_Object::getDTEndFromVEvent($vevent);
		switch($dtstart->getDateType()) {
			case Sabre\VObject\Property\DateTime::UTC:
				$timezone = new DateTimeZone(OC_Calendar_App::getTimezone());
				$newDT    = $dtstart->getDateTime();
				$newDT->setTimezone($timezone);
				$dtstart->setDateTime($newDT);
				$newDT    = $dtend->getDateTime();
				$newDT->setTimezone($timezone);
				$dtend->setDateTime($newDT);
			case Sabre\VObject\Property\DateTime::LOCALTZ:
			case Sabre\VObject\Property\DateTime::LOCAL:
				$startdate = $dtstart->getDateTime()->format('d.m.Y');
				$starttime = $dtstart->getDateTime()->format('H:i');
				$enddate = $dtend->getDateTime()->format('d.m.Y');
				$endtime = $dtend->getDateTime()->format('H:i');
				$allday = false;
				break;
			case Sabre\VObject\Property\DateTime::DATE:
				$startdate = $dtstart->getDateTime()->format('d.m.Y');
				$starttime = '00:00';
				$dtend->getDateTime()->modify('-1 day');
				$enddate = $dtend->getDateTime()->format('d.m.Y');
				$endtime = '00:00';
				$allday = true;
				break;
		}
		$summary = strtr($vevent->getAsString('SUMMARY'), array('\,' => ',', '\;' => ';'));
		// check for Treatment
		$treatmentid = 0;
		$treatstatus = 0;
		$treatmenttitle = '';
		$treatmentlocationid = 0;
		$treatmentlocation = '';
		$treatmentpatient = '';
		$treatmentfolder = '';
		$treatid = 0;
		$regularEventDisplay = ' style="display: block"';
		$treatmentEventDisplay = ' style="display: none"';
		$eventtype = $data['eventtype'];
		$treatmentsModel = new PatientsTreatmentsModel();
		$eventlocation = $data['eventlocation'];
		$eventlocationuid = $data['eventlocationuid'];
		$location = strtr($vevent->getAsString('LOCATION'), array('\,' => ',', '\;' => ';'));
		if($eventlocation != 0) {
			$location = $treatmentsModel->getTreatmentLocation($eventlocation);
		}
		if($eventlocationuid != 0) {
			$contactsModel = new ContactsModel();
			$location = $contactsModel->getPlaceListPlain($eventlocationuid,'calendarTreatmentLocation', false);
		}
		if($data['eventtype'] == 1) {
			//$eventtype = 'Behandlung';
			$regularEventDisplay  = ' style="display: none"';
			$treatmentEventDisplay = ' style="display: block"';
			$treatmentid = $data['eventid'];
			
			$treatmentevent = $treatmentsModel->getTreatmentEvent($treatmentid);
			$treatid = $treatmentevent['mid'];
			$treatstatus = $treatmentevent['status'];
			$treatmentpatient = '<span class="listmember" uid="' .  $treatid . '">' . $treatmentevent['patient'] . '</span>';
			$treatmentfolder = $treatmentevent['foldertitle'];
			$treatmenttitle = $treatmentevent['title'];
			if($eventlocation == 0) {
				//$location = '';
				$summary_noroom = explode(',', $summary);
				$summary = $summary_noroom[0];
			}
		}
		
		
		$categories = $vevent->getAsString('CATEGORIES');
		$description = strtr($vevent->getAsString('DESCRIPTION'), array('\,' => ',', '\;' => ';'));
		$last_modified = $vevent->__get('LAST-MODIFIED');
		if ($last_modified) {
			$lastmodified = $last_modified->getDateTime()->format('U');
		}else{
			$lastmodified = 0;
		}
		$arr = $this->model->getFolderList(0,1);
		$calendars = $arr["folders"];
		ob_start();
			include('view/edit.php');
			$html = ob_get_contents();
		ob_end_clean();
		return $html;
		
	}
	
	
	function editEvent($post) {
		global $system, $lang;
		
		$eventtype = $post['eventtype'];
		$id = $post['EventId'];
		$cal = $post['calendar'];
		$t_id = $post['treatmentid'];
		$t_id_old = $this->model->getTreatmentEvent($id);
		$t_loc = $post['treatmentlocationid'];
		$t_locuid = $post['treatmentlocationuid'];
		//$post['description'] = str_replace("\r\n", '\n', $post['description']);
		//$post['description'] = str_replace("\n", '\n', $post['description']);
		
		
		
		$errarr = $this->validateRequest($post);
		if($errarr) {
			$data["status"] = 'error';
			foreach($errarr as $key => $value) {
				$data[$key] = $value;
			}
		} else {
			
			// title
			$title = $post['title'];
				if($eventtype == 1) {
					$treatmentsModel = new PatientsTreatmentsModel();
					$pid = $treatmentsModel->getTreatmentPatientID($t_id);
					$contactsModel = new ContactsModel();
					$title = $contactsModel->getUserFullnameShortFirstname($pid);
					if($t_loc != 0) {
						$title .= ', ' . $post['location'];
					}
					if($t_locuid != 0) {
						$title .=  ', ' . $lang['CALENDAR_EVENT_HOUSE_CALL'];
					}
				}
			$post['title'] = $title;
			
			$data = $this->getEventObject($id, false, false);
			$vcalendar = OC_VObject::parse($data['calendardata']);
			self::updateVCalendarFromRequest($post, $vcalendar);
			
			$edit = $this->edit($id, $vcalendar->serialize(), $eventtype, $t_id, $t_id_old, $t_loc, $t_locuid);
			//echo $data['status'];
			if($edit['status'] == 'error') {
				$data["status"] = 'error';
			} else {
				if($post['desktop'] == 1) {
					if($cal == 2) {
						$arr = $this->model->getFolderList(0);
						$folders = $arr["folders"];
						foreach($folders as $folder) {
							$this->model->newWidgetItem($folder->id,$id,$post['description']);
						}
					} else {
						$uid = $this->model->getUIDFromCalendar($cal);
						$this->model->newWidgetItem($uid,$id,$post['description']);
					}
				}
				
				if($edit['status'] == 'busy') {
					$data["status"] = 'busy';
				} else {
					if ($data['calendarid'] != $cal) {
						$this->model->moveToCalendar($id, $cal);
					}
					$data["status"] = 'success';
				}
			}
		}
		return json_encode($data);
	}
	
	
	/**
	 * @brief returns informations about an event
	 * @param int $id - id of the event
	 * @param bool $security - check access rights or not
	 * @param bool $shared - check if the user got access via sharing
	 * @return mixed - bool / array
	 */
	function getEventObject($id, $security = true, $shared = false) {
		$event = $this->model->find($id);
		if($shared === true || $security === true) {
			$permissions = self::getPermissions($id, self::EVENT);
			OCP\Util::writeLog('contacts', __METHOD__.' id: '.$id.', permissions: '.$permissions, OCP\Util::DEBUG);
			if(self::getPermissions($id, self::EVENT)) {
				return $event;
			}
		} else {
			return $event;
		}
		return false;
	}

	
	/**
	 * @brief creates an VCalendar Object from the request data
	 * @param array $request
	 * @return object created $vcalendar
	 */	public static function createVCalendarFromRequest($request) {
		
		$vcalendar = new OC_VObject('VCALENDAR');
		$vcalendar->add('PRODID', 'ownCloud Calendar');
		$vcalendar->add('VERSION', '2.0');

		$vevent = new OC_VObject('VEVENT');
		$vcalendar->add($vevent);

		$vevent->setDateTime('CREATED', 'now', Sabre\VObject\Property\DateTime::UTC);

		$vevent->setUID();
		return self::updateVCalendarFromRequest($request, $vcalendar);
	}
	
	/**
	 * @brief updates an VCalendar Object from the request data
	 * @param array $request
	 * @param object $vcalendar
	 * @return object updated $vcalendar
	 */
	public static function updateVCalendarFromRequest($request, $vcalendar) {
		global $session;
		
		//$accessclass = $request["accessclass"];
		$title = $request["title"];
		$location = $request["location"];
		//$categories = $request["categories"];
		$allday = $request["allday"];
		$from = $request["from"];
		$to  = $request["to"];
		if ($allday == 0) {
			$fromtime = $request['fromtime'];
			$totime = $request['totime'];
		}
		$vevent = $vcalendar->VEVENT;
		$description = $request["description"];
		//$repeat = $request["repeat"];
		$repeat = 'doesnotrepeat';
		if($repeat != 'doesnotrepeat') {
			$rrule = '';
			$interval = $request['interval'];
			$end = $request['end'];
			$byoccurrences = $request['byoccurrences'];
			switch($repeat) {
				case 'daily':
					$rrule .= 'FREQ=DAILY';
					break;
				case 'weekly':
					$rrule .= 'FREQ=WEEKLY';
					if(array_key_exists('weeklyoptions', $request)) {
						$byday = '';
						$daystrings = array_flip(self::getWeeklyOptions(OC_Calendar_App::$l10n));
						foreach($request['weeklyoptions'] as $days) {
							if($byday == '') {
								$byday .= $daystrings[$days];
							}else{
								$byday .= ',' .$daystrings[$days];
							}
						}
						$rrule .= ';BYDAY=' . $byday;
					}
					break;
				case 'weekday':
					$rrule .= 'FREQ=WEEKLY';
					$rrule .= ';BYDAY=MO,TU,WE,TH,FR';
					break;
				case 'biweekly':
					$rrule .= 'FREQ=WEEKLY';
					$interval = $interval * 2;
					break;
				case 'monthly':
					$rrule .= 'FREQ=MONTHLY';
					if($request['advanced_month_select'] == 'monthday') {
						break;
					}elseif($request['advanced_month_select'] == 'weekday') {
						if($request['weekofmonthoptions'] == 'auto') {
							list($_day, $_month, $_year) = explode('-', $from);
							$weekofmonth = floor($_day/7);
						}else{
							$weekofmonth = $request['weekofmonthoptions'];
						}
						$days = array_flip(self::getWeeklyOptions(OC_Calendar_App::$l10n));
						$byday = '';
						foreach($request['weeklyoptions'] as $day) {
							if($byday == '') {
								$byday .= $weekofmonth . $days[$day];
							}else{
								$byday .= ',' . $weekofmonth . $days[$day];
							}
						}
						if($byday == '') {
							$byday = 'MO,TU,WE,TH,FR,SA,SU';
						}
						$rrule .= ';BYDAY=' . $byday;
					}
					break;
				case 'yearly':
					$rrule .= 'FREQ=YEARLY';
					if($request['advanced_year_select'] == 'bydate') {

					}elseif($request['advanced_year_select'] == 'byyearday') {
						list($_day, $_month, $_year) = explode('-', $from);
						$byyearday = date('z', mktime(0,0,0, $_month, $_day, $_year)) + 1;
						if(array_key_exists('byyearday', $request)) {
							foreach($request['byyearday'] as $yearday) {
								$byyearday .= ',' . $yearday;
							}
						}
						$rrule .= ';BYYEARDAY=' . $byyearday;
					}elseif($request['advanced_year_select'] == 'byweekno') {
						list($_day, $_month, $_year) = explode('-', $from);
						$rrule .= ';BYDAY=' . strtoupper(substr(date('l', mktime(0,0,0, $_month, $_day, $_year)), 0, 2));
						$byweekno = '';
						foreach($request['byweekno'] as $weekno) {
							if($byweekno == '') {
								$byweekno = $weekno;
							}else{
								$byweekno .= ',' . $weekno;
							}
						}
						$rrule .= ';BYWEEKNO=' . $byweekno;
					}elseif($request['advanced_year_select'] == 'bydaymonth') {
						if(array_key_exists('weeklyoptions', $request)) {
							$days = array_flip(self::getWeeklyOptions(OC_Calendar_App::$l10n));
							$byday = '';
							foreach($request['weeklyoptions'] as $day) {
								if($byday == '') {
								      $byday .= $days[$day];
								}else{
								      $byday .= ',' . $days[$day];
								}
							}
							$rrule .= ';BYDAY=' . $byday;
						}
						if(array_key_exists('bymonth', $request)) {
							$monthes = array_flip(self::getByMonthOptions(OC_Calendar_App::$l10n));
							$bymonth = '';
							foreach($request['bymonth'] as $month) {
								if($bymonth == '') {
								      $bymonth .= $monthes[$month];
								}else{
								      $bymonth .= ',' . $monthes[$month];
								}
							}
							$rrule .= ';BYMONTH=' . $bymonth;

						}
						if(array_key_exists('bymonthday', $request)) {
							$bymonthday = '';
							foreach($request['bymonthday'] as $monthday) {
								if($bymonthday == '') {
								      $bymonthday .= $monthday;
								}else{
								      $bymonthday .= ',' . $monthday;
								}
							}
							$rrule .= ';BYMONTHDAY=' . $bymonthday;

						}
					}
					break;
				default:
					break;
			}
			if($interval != '') {
				$rrule .= ';INTERVAL=' . $interval;
			}
			if($end == 'count') {
				$rrule .= ';COUNT=' . $byoccurrences;
			}
			if($end == 'date') {
				list($bydate_day, $bydate_month, $bydate_year) = explode('-', $request['bydate']);
				$rrule .= ';UNTIL=' . $bydate_year . $bydate_month . $bydate_day;
			}
			$vevent->setString('RRULE', $rrule);
			$repeat = "true";
		}else{
			$repeat = "false";
		}


		$vevent->setDateTime('LAST-MODIFIED', 'now', Sabre\VObject\Property\DateTime::UTC);
		$vevent->setDateTime('DTSTAMP', 'now', Sabre\VObject\Property\DateTime::UTC);
		$vevent->setString('SUMMARY', $title);

		if($allday == 1) {
			$start = new DateTime($from);
			$end = new DateTime($to.' +1 day');
			$vevent->setDateTime('DTSTART', $start, Sabre\VObject\Property\DateTime::DATE);
			$vevent->setDateTime('DTEND', $end, Sabre\VObject\Property\DateTime::DATE);
		}else{
			//$timezone = OC_Calendar_App::getTimezone();
			$timezone = $session->timezone;
			$timezone = new DateTimeZone($timezone);
			$start = new DateTime($from.' '.$fromtime, $timezone);
			$end = new DateTime($to.' '.$totime, $timezone);
			$vevent->setDateTime('DTSTART', $start, Sabre\VObject\Property\DateTime::LOCALTZ);
			$vevent->setDateTime('DTEND', $end, Sabre\VObject\Property\DateTime::LOCALTZ);
		}
		unset($vevent->DURATION);

		//$vevent->setString('CLASS', $accessclass);
		$vevent->setString('LOCATION', $location);
		$vevent->setString('DESCRIPTION', $description);
		//$vevent->setString('CATEGORIES', $categories);

		/*if($repeat == "true") {
			$vevent->RRULE = $repeat;
		}*/

		return $vcalendar;
	}
	
	
	/**
	 * @brief Adds an object
	 * @param integer $id Calendar id
	 * @param string $data  object
	 * @return insertid
	 */
	function add($id,$data, $eventtype, $eventid='0', $eventlocation='0', $eventlocationuid='0') {
		global $system;
		$object = OC_VObject::parse($data);
		list($type,$startdate,$enddate,$summary,$repeating,$uid) = $this->extractData($object);
		if(is_null($uid)) {
			$object->setUID();
			$data = $object->serialize();
		}
		$uri = 'owncloud-'.md5($data.rand().time()).'.ics';
		$object_id = $this->model->newEvent($id,$type,$startdate,$enddate,$repeating,$system->checkMagicQuotesTinyMCE($summary),$system->checkMagicQuotesTinyMCE($data),$uri,time(),$eventtype,$eventid,$eventlocation, $eventlocationuid);
		$this->model->touchCalendar($id);
		return $object_id;
	}
	
	
	/**
	 * @brief edits an object
	 * @param integer $id id of object
	 * @param string $data  object
	 * @return boolean
	 */
	function edit($id, $data, $eventtype, $eventid='0', $oldeventid='0', $eventlocation='0', $eventlocationuid='0') {
		global $system;
		$oldobject = $this->model->find($id);
		$calid = $oldobject['calendarid'];
		$calendar = $this->model->findCalendar($calid);
		$oldvobject = OC_VObject::parse($oldobject['calendardata']);
		$object = OC_VObject::parse($data);
		
		list($type,$startdate,$enddate,$summary,$repeating,$uid) = self::extractData($object);
		
		$errarr['status'] = '';
		if($eventlocation != 0) {
			if($this->model->isRoomBusy($eventlocation,$startdate,$enddate,$id)) {
				$eventlocation = 0;
				$errarr['status'] = 'busy';
			}
		}
		
		$stmt = $this->model->editEvent($id,$type,$startdate,$enddate,$repeating,$system->checkMagicQuotesTinyMCE($summary),$system->checkMagicQuotesTinyMCE($data),time(),$eventtype,$eventid,$oldeventid,$eventlocation, $eventlocationuid);
		if(!$stmt) {
			$errarr['status'] = 'error';
		} else {
			$this->model->touchCalendar($oldobject['calendarid']);
			if(!$errarr['status'] == 'busy') {
				$errarr['status'] = 'success';
			}
		}
		return $errarr;
	}
	

	/**
	 * @brief Extracts data from a vObject-Object
	 * @param Sabre_VObject $object
	 * @return array
	 *
	 * [type, start, end, summary, repeating, uid]
	 */
	function extractData($object) {
		$return = array('',null,null,'',0,null);

		// Child to use
		$children = 0;
		$use = null;
		foreach($object->children as $property) {
			if($property->name == 'VEVENT') {
				$children++;
				$thisone = true;

				foreach($property->children as &$element) {
					if($element->name == 'RECURRENCE-ID') {
						$thisone = false;
					}
				} unset($element);

				if($thisone) {
					$use = $property;
				}
			}
			elseif($property->name == 'VTODO' || $property->name == 'VJOURNAL') {
				$return[0] = $property->name;
				foreach($property->children as &$element) {
					if($element->name == 'SUMMARY') {
						$return[3] = $element->value;
					}
					elseif($element->name == 'UID') {
						$return[5] = $element->value;
					}
				};

				// Only one VTODO or VJOURNAL per object
				// (only one UID per object but a UID is required by a VTODO =>
				//    one VTODO per object)
				break;
			}
		}

		// find the data
		if(!is_null($use)) {
			$return[0] = $use->name;
			foreach($use->children as $property) {
				if($property->name == 'DTSTART') {
					//$return[1] = $this->getUTCforMDB($property->getDateTime());
					$return[1] = $property->getDateTime()->format('Y-m-d H:i');
				}
				elseif($property->name == 'DTEND') {
					//$return[2] = $this->getUTCforMDB($property->getDateTime());
					$return[2] = $property->getDateTime()->format('Y-m-d H:i');
				}
				elseif($property->name == 'SUMMARY') {
					$return[3] = $property->value;
				}
				elseif($property->name == 'RRULE') {
					$return[4] = 1;
				}
				elseif($property->name == 'UID') {
					$return[5] = $property->value;
				}
			}
		}

		// More than one child means reoccuring!
		if($children > 1) {
			$return[4] = 1;
		}
		return $return;
	}
	
	
	/**
	 * @brief DateTime to UTC string
	 * @param DateTime $datetime The date to convert
	 * @returns date as YYYY-MM-DD hh:mm
	 *
	 * This function creates a date string that can be used by MDB2.
	 * Furthermore it converts the time to UTC.
	 */
	function getUTCforMDB($datetime) {
		return date('Y-m-d H:i', $datetime->format('U'));
	}
	
	/**
	 * @brief checks if an event was edited and dies if it was
	 * @param (object) $vevent - vevent object of the event
	 * @param (int) $lastmodified - time of last modification as unix timestamp
	 * @return (bool)
	 */
	function isNotModified($vevent, $lastmodified) {
		$last_modified = $vevent->__get('LAST-MODIFIED');
		/*if($last_modified && $lastmodified != $last_modified->getDateTime()->format('U')) {
			OCP\JSON::error(array('modified'=>true));
			exit;
		}*/
		return true;
	}
	
	
	function deleteEvent($id) {
		//global $system, $lang;
		/*$treatmentid = $this->model->getTreatmentTaskEvent($id);
		if($treatmentid != 0) {
			$treatmentsModel = new PatientsTreatmentsModel();
			$treatmentevent = $treatmentsModel->deleteTreatmentTask($treatmentid);
		}*/
		$this->model->deleteEvent($id);
		
		//deleteTreatmentTask
		
		
		$data["status"] = 'success';
		return json_encode($data);
	}


	function moveEvent($post) {
		$id = $post['id'];
		$eventtype = $this->model->getTreatmentEventType($id);
		$t_id = $this->model->getTreatmentTaskEvent($id);
		$t_loc = $this->model->getTreatmentLocationEvent($id);
		$t_locuid = $this->model->getTreatmentLocationUidEvent($id);

		$vcalendar = $this->getVCalendar($id, false, false);
		$vevent = $vcalendar->VEVENT;
		
		$allday = $post['allDay'];
		$delta = new DateInterval('P0D');
		$delta->d = $post['dayDelta'];
		$delta->i = $post['minuteDelta'];
		$this->isNotModified($vevent, $post['lastmodified']);
		
		$dtstart = $vevent->DTSTART;
		$dtend = $this->getDTEndFromVEvent($vevent);
		$start_type = $dtstart->getDateType();
		$end_type = $dtend->getDateType();
		if ($allday && $start_type != Sabre\VObject\Property\DateTime::DATE) {
			$start_type = $end_type = Sabre\VObject\Property\DateTime::DATE;
			$dtend->setDateTime($dtend->getDateTime()->modify('+1 day'), $end_type);
		}
		if (!$allday && $start_type == Sabre\VObject\Property\DateTime::DATE) {
			$start_type = $end_type = Sabre\VObject\Property\DateTime::LOCALTZ;
		}
		$dtstart->setDateTime($dtstart->getDateTime()->add($delta), $start_type);
		$dtend->setDateTime($dtend->getDateTime()->add($delta), $end_type);
		unset($vevent->DURATION);
		
		$vevent->setDateTime('LAST-MODIFIED', 'now', Sabre\VObject\Property\DateTime::UTC);
		$vevent->setDateTime('DTSTAMP', 'now', Sabre\VObject\Property\DateTime::UTC);

		$edit = $this->edit($id, $vcalendar->serialize(), $eventtype, $t_id, $t_id, $t_loc, $t_locuid);
		/*if(!$edit) {
			$ret["status"] = 'error';
		} else {
			$lastmodified = $vevent->__get('LAST-MODIFIED')->getDateTime();
			$ret["status"] = 'success';
			$ret["lastmodified"] = (int)$lastmodified->format('U');
		}*/
		if($edit['status'] == 'error') {
				$data["status"] = 'error';
			} else {
				if($edit['status'] == 'busy') {
					$data["status"] = 'busy';
				} else {
					$lastmodified = $vevent->__get('LAST-MODIFIED')->getDateTime();
					//$ret["status"] = 'success';
					$data["lastmodified"] = (int)$lastmodified->format('U');
					$data["status"] = 'success';
				}
			}
		return json_encode($data);
	}
	
	function resizeEvent($post) {
		$id = $post['id'];
		$eventtype = $this->model->getTreatmentEventType($id);
		$t_id = $this->model->getTreatmentTaskEvent($id);
		$t_loc = $this->model->getTreatmentLocationEvent($id);
		$t_locuid = $this->model->getTreatmentLocationUidEvent($id);
		
		$vcalendar = $this->getVCalendar($id, false, false);
		$vevent = $vcalendar->VEVENT;
		
		$delta = new DateInterval('P0D');
		$delta->d = $post['dayDelta'];
		$delta->i = $post['minuteDelta'];
		$this->isNotModified($vevent, $post['lastmodified']);
		
		$dtend = $this->getDTEndFromVEvent($vevent);
		$end_type = $dtend->getDateType();
		$dtend->setDateTime($dtend->getDateTime()->add($delta), $end_type);
		unset($vevent->DURATION);
		
		$vevent->setDateTime('LAST-MODIFIED', 'now', Sabre\VObject\Property\DateTime::UTC);
		$vevent->setDateTime('DTSTAMP', 'now', Sabre\VObject\Property\DateTime::UTC);

		$edit = $this->edit($id, $vcalendar->serialize(), $eventtype, $t_id, $t_id, $t_loc, $t_locuid);
		/*if(!$edit) {
			$ret["status"] = 'error';
		} else {
			$lastmodified = $vevent->__get('LAST-MODIFIED')->getDateTime();
			$ret["status"] = 'success';
			$ret["lastmodified"] = (int)$lastmodified->format('U');
		}
		return json_encode($ret);*/
		if($edit['status'] == 'error') {
				$data["status"] = 'error';
			} else {
				if($edit['status'] == 'busy') {
					$data["status"] = 'busy';
				} else {
					$lastmodified = $vevent->__get('LAST-MODIFIED')->getDateTime();
					//$ret["status"] = 'success';
					$data["lastmodified"] = (int)$lastmodified->format('U');
					$data["status"] = 'success';
				}
			}
		return json_encode($data);
	}
	
	/**
	 * @brief returns the DTEND of an $vevent object
	 * @param object $vevent vevent object
	 * @return object
	 */
	function getDTEndFromVEvent($vevent) {
		if ($vevent->DTEND) {
			$dtend = $vevent->DTEND;
		}else{
			$dtend = clone $vevent->DTSTART;
			// clone creates a shallow copy, also clone DateTime
			$dtend->setDateTime(clone $dtend->getDateTime(), $dtend->getDateType());
			if ($vevent->DURATION) {
				$duration = strval($vevent->DURATION);
				$invert = 0;
				if ($duration[0] == '-') {
					$duration = substr($duration, 1);
					$invert = 1;
				}
				if ($duration[0] == '+') {
					$duration = substr($duration, 1);
				}
				$interval = new DateInterval($duration);
				$interval->invert = $invert;
				$dtend->getDateTime()->add($interval);
			}
		}
		return $dtend;
	}
	
	/**
	 * @brief returns the parsed calendar data
	 * @param int $id - id of the event
	 * @param bool $security - check access rights or not
	 * @return mixed - bool / object
	 */
	function getVCalendar($id, $security = true, $shared = false) {
		
		$event_object = $this->getEventObject($id, $security, $shared);
		if($event_object === false) {
			return false;
		}
		$vobject = OC_VObject::parse($event_object['calendardata']);
		if(is_null($vobject)) {
			return false;
		}
		return $vobject;
	}
	
	function getEventTypesDialog($field,$title,$option) {
		$retval = $this->model->getEventTypesDialog($field,$title,$option);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	function getTreatmentsLocationsDialog($field,$title,$from,$fromtime,$totime,$eventtype) {
		global $lang;
		$treatmentsModel = new PatientsTreatmentsModel();
		$locations = $treatmentsModel->getTreatmentLocations();
		$busy = $this->model->getBusyLocations($from,$fromtime,$totime);
		$str = '<div class="dialog-text">';
		foreach($locations as $key => $value) {
			if(!in_array($key,$busy)) {
			$str .= '<a href="#" class="insertLocationFromDialog" title="' . $value . '" field="'.$field.'" gid="'.$key.'">' . $value . '</a>';
			}
		}
		$str .= '</div>';
		//return $str;
		include_once dirname(__FILE__).'/view/dialog_locations.php';
	}
	
	function getCalendarsDialog($field,$title) {
		$str = '<div class="dialog-text">';
		$arr = $this->model->getFolderList(0,1);
		$calendars = $arr["folders"];
		foreach($calendars as $calendar) {
			$str .= '<a href="#" class="insertCalendarFromDialog" title="'.$calendar->lastname . " " . $calendar->firstname.'" field="'.$field.'" gid="'.$calendar->calendarid.'">'.$calendar->lastname . " " . $calendar->firstname.'</a>';
		}
		$str .= '</div>';
		return $str;
	}
	
	
	
	/**
	 * @brief validates a request
	 * @param array $request
	 * @return mixed (array / boolean)
	 */
	public static function validateRequest($request) {
		$errnum = 0;
		//$errarr = array('title'=>'false', 'cal'=>'false', 'from'=>'false', 'fromtime'=>'false', 'to'=>'false', 'totime'=>'false', 'endbeforestart'=>'false');
		
		$errarr = array('treatment'=>'false','treatmentlocation'=>'false','title'=>'false','lastname'=>'false','firstname'=>'false','folder'=>'false','treatmenttitle'=>'false','contactid'=>'false','patientid'=>'false');
		if($request['eventtype'] == 0 && $request['title'] == '') {
			$errarr['title'] = 'true';
			$errnum++;
		}
		if($request['eventtype'] == 1 && $request['treatmentid'] == 0) {
			$errarr['treatment'] = 'true';
			$errnum++;
		}
		if($request['eventtype'] == 1 && $request['treatmentlocationid'] == 0 && $request['treatmentlocationuid'] == 0) {
			$errarr['treatmentlocation'] = 'true';
			$errnum++;
		}
		if($request['eventtype'] == 2 && $request['lastname'] == '') {
			$errarr['lastname'] = 'true';
			$errnum++;
		}
		if($request['eventtype'] == 2 && $request['firstname'] == '') {
			$errarr['firstname'] = 'true';
			$errnum++;
		}
		if($request['eventtype'] == 3 && $request['contactid'] == 0) {
			$errarr['contactid'] = 'true';
			$errnum++;
		}
		if($request['eventtype'] == 4 && $request['patientid'] == 0) {
			$errarr['patientid'] = 'true';
			$errnum++;
		}
		if(($request['eventtype'] == 2 || $request['eventtype'] == 3 || $request['eventtype'] == 4) && $request['folderid'] == 0) {
			$errarr['folder'] = 'true';
			$errnum++;
		}
		if(($request['eventtype'] == 2 || $request['eventtype'] == 3 || $request['eventtype'] == 4) && $request['treatmenttitle'] == '') {
			$errarr['treatmenttitle'] = 'true';
			$errnum++;
		}
		if(($request['eventtype'] == 2 || $request['eventtype'] == 3 || $request['eventtype'] == 4) && $request['treatmentlocationid'] == 0 && $request['treatmentlocationuid'] == 0) {
			$errarr['treatmentlocation'] = 'true';
			$errnum++;
		}

		/*$fromday = substr($request['from'], 0, 2);
		$frommonth = substr($request['from'], 3, 2);
		$fromyear = substr($request['from'], 6, 4);
		if(!checkdate($frommonth, $fromday, $fromyear)) {
			$errarr['from'] = 'true';
			$errnum++;
		}
		$allday = isset($request['allday']);
		if(!$allday && self::checkTime(urldecode($request['fromtime']))) {
			$errarr['fromtime'] = 'true';
			$errnum++;
		}

		$today = substr($request['to'], 0, 2);
		$tomonth = substr($request['to'], 3, 2);
		$toyear = substr($request['to'], 6, 4);
		if(!checkdate($tomonth, $today, $toyear)) {
			$errarr['to'] = 'true';
			$errnum++;
		}*/
		
		/*if($request['repeat'] != 'doesnotrepeat') {
			if(is_nan($request['interval']) && $request['interval'] != '') {
				$errarr['interval'] = 'true';
				$errnum++;
			}
			if(array_key_exists('repeat', $request) && !array_key_exists($request['repeat'], self::getRepeatOptions(OC_Calendar_App::$l10n))) {
				$errarr['repeat'] = 'true';
				$errnum++;
			}
			if(array_key_exists('advanced_month_select', $request) && !array_key_exists($request['advanced_month_select'], self::getMonthOptions(OC_Calendar_App::$l10n))) {
				$errarr['advanced_month_select'] = 'true';
				$errnum++;
			}
			if(array_key_exists('advanced_year_select', $request) && !array_key_exists($request['advanced_year_select'], self::getYearOptions(OC_Calendar_App::$l10n))) {
				$errarr['advanced_year_select'] = 'true';
				$errnum++;
			}
			if(array_key_exists('weekofmonthoptions', $request) && !array_key_exists($request['weekofmonthoptions'], self::getWeekofMonth(OC_Calendar_App::$l10n))) {
				$errarr['weekofmonthoptions'] = 'true';
				$errnum++;
			}
			if($request['end'] != 'never') {
				if(!array_key_exists($request['end'], self::getEndOptions(OC_Calendar_App::$l10n))) {
					$errarr['end'] = 'true';
					$errnum++;
				}
				if($request['end'] == 'count' && is_nan($request['byoccurrences'])) {
					$errarr['byoccurrences'] = 'true';
					$errnum++;
				}
				if($request['end'] == 'date') {
					list($bydate_day, $bydate_month, $bydate_year) = explode('-', $request['bydate']);
					if(!checkdate($bydate_month, $bydate_day, $bydate_year)) {
						$errarr['bydate'] = 'true';
						$errnum++;
					}
				}
			}
			if(array_key_exists('weeklyoptions', $request)) {
				foreach($request['weeklyoptions'] as $option) {
					if(!in_array($option, self::getWeeklyOptions(OC_Calendar_App::$l10n))) {
						$errarr['weeklyoptions'] = 'true';
						$errnum++;
					}
				}
			}
			if(array_key_exists('byyearday', $request)) {
				foreach($request['byyearday'] as $option) {
					if(!array_key_exists($option, self::getByYearDayOptions())) {
						$errarr['byyearday'] = 'true';
						$errnum++;
					}
				}
			}
			if(array_key_exists('weekofmonthoptions', $request)) {
				if(is_nan((double)$request['weekofmonthoptions'])) {
					$errarr['weekofmonthoptions'] = 'true';
					$errnum++;
				}
			}
			if(array_key_exists('bymonth', $request)) {
				foreach($request['bymonth'] as $option) {
					if(!in_array($option, self::getByMonthOptions(OC_Calendar_App::$l10n))) {
						$errarr['bymonth'] = 'true';
						$errnum++;
					}
				}
			}
			if(array_key_exists('byweekno', $request)) {
				foreach($request['byweekno'] as $option) {
					if(!array_key_exists($option, self::getByWeekNoOptions())) {
						$errarr['byweekno'] = 'true';
						$errnum++;
					}
				}
			}
			if(array_key_exists('bymonthday', $request)) {
				foreach($request['bymonthday'] as $option) {
					if(!array_key_exists($option, self::getByMonthDayOptions())) {
						$errarr['bymonthday'] = 'true';
						$errnum++;
					}
				}
			}
		}*/
		/*if(!$allday && self::checkTime(urldecode($request['totime']))) {
			$errarr['totime'] = 'true';
			$errnum++;
		}
		if($today < $fromday && $frommonth == $tomonth && $fromyear == $toyear) {
			$errarr['endbeforestart'] = 'true';
			$errnum++;
		}
		if($today == $fromday && $frommonth > $tomonth && $fromyear == $toyear) {
			$errarr['endbeforestart'] = 'true';
			$errnum++;
		}
		if($today == $fromday && $frommonth == $tomonth && $fromyear > $toyear) {
			$errarr['endbeforestart'] = 'true';
			$errnum++;
		}
		if(!$allday && $fromday == $today && $frommonth == $tomonth && $fromyear == $toyear) {
			list($tohours, $tominutes) = explode(':', $request['totime']);
			list($fromhours, $fromminutes) = explode(':', $request['fromtime']);
			if($tohours < $fromhours) {
				$errarr['endbeforestart'] = 'true';
				$errnum++;
			}
			if($tohours == $fromhours && $tominutes < $fromminutes) {
				$errarr['endbeforestart'] = 'true';
				$errnum++;
			}
		}*/
		if ($errnum)
		{
			return $errarr;
		}
		return false;
	}
	
	function getWidgetAlerts() {
		global $lang, $system;
		if($arr = $this->model->getWidgetAlerts()) {
			$reminders = $arr["reminders"];
			ob_start();
			include 'view/widget.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			$data["widgetaction"] = $arr["widgetaction"];
			return json_encode($data);
		} else {
			ob_start();
			include CO_INC .'/view/default.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			return json_encode($data);
		}
	}
	
	function markRead($id) {
		global $lang, $system;
		$retval = $this->model->markRead($id);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}

	
	function getHelp() {
		global $lang;
		$data["file"] = $lang["CALENDAR_HELP"];
		$this->openHelpPDF($data);
	}
	
	function saveLastUsedTreatments($id) {
		$retval = $this->model->saveLastUsedTreatments($id);
		if($retval){
		   return "true";
		} else{
		   return "error";
		}
	}
	

}
$calendar = new Calendar("calendar");
?>
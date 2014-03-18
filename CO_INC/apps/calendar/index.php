<?php
include_once(CO_INC . "/classes/ajax_header.inc");
include_once(CO_INC . "/model.php");
include_once(CO_INC . "/controller.php");

foreach($controller->applications as $app => $display) {
	include_once(CO_INC . "/apps/".$app."/config.php");
	include_once(CO_INC . "/apps/".$app."/lang/" . $session->userlang . ".php");
	include_once(CO_INC . "/apps/".$app."/model.php");
	include_once(CO_INC . "/apps/".$app."/controller.php");
}

/*foreach($calendar->modules as $module  => $value) {
	include_once("modules/".$module."/config.php");
	include_once("modules/".$module."/lang/" . $session->userlang . ".php");
	include_once("modules/".$module."/model.php");
	include_once("modules/".$module."/controller.php");
}*/

// Treatments
include_once(CO_INC . "/apps/patients/modules/treatments/config.php");
include_once(CO_INC . "/apps/patients/modules/treatments/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/patients/modules/treatments/model.php");
include_once(CO_INC . "/apps/patients/modules/treatments/controller.php");
$patientsTreatments = new PatientsTreatments("treatments");


// OC Libraries
require_once(CO_INC_PATH . '/sync/3rdparty/Sabre/VObject/Node.php');
require_once(CO_INC_PATH . '/sync/3rdparty/Sabre/VObject/ElementList.php');
require_once(CO_INC_PATH . '/sync/3rdparty/Sabre/VObject/Component.php');
require_once(CO_INC_PATH . '/sync/3rdparty/Sabre/VObject/Component/VAlarm.php');
require_once(CO_INC_PATH . '/sync/3rdparty/Sabre/VObject/Component/VCalendar.php');
require_once(CO_INC_PATH . '/sync/3rdparty/Sabre/VObject/Component/VEvent.php');
require_once(CO_INC_PATH . '/sync/3rdparty/Sabre/VObject/Property.php');
require_once(CO_INC_PATH . '/sync/3rdparty/Sabre/VObject/TimeZoneUtil.php');
require_once(CO_INC_PATH . '/sync/3rdparty/Sabre/VObject/Property/DateTime.php');
require_once(CO_INC_PATH . '/sync/3rdparty/Sabre/VObject/Parameter.php');
require_once(CO_INC_PATH . '/sync/3rdparty/Sabre/VObject/ParseException.php');
require_once(CO_INC_PATH . '/sync/3rdparty/Sabre/VObject/Reader.php');
require_once(CO_INC_PATH . '/sync/lib/private/vobject.php');
require_once(CO_INC_PATH . '/sync/apps/calendar/lib/calendar.php');
require_once(CO_INC_PATH . '/sync/apps/calendar/lib/object.php');
// OC error classes
/*
require_once(CO_INC_PATH . '/sync/lib/private/backgroundjob.php');
require_once(CO_INC_PATH . '/sync/lib/private/backgroundjob/job.php');
require_once(CO_INC_PATH . '/sync/lib/private/backgroundjob/joblist.php');
require_once(CO_INC_PATH . '/sync/lib/private/log/owncloud.php');
require_once(CO_INC_PATH . '/sync/lib/private/log/rotate.php');
require_once(CO_INC_PATH . '/sync/lib/private/legacy/log.php');
*/




if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getFolderList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($calendar->getFolderList($sort));
		break;
		case 'setSortOrder':
			echo($calendar->setSortOrder("calendar-sort",$_GET['folderItem']));
		break;
		case 'getrequestedEvents':
			echo($calendar->getrequestedEvents($_GET["calendar_id"], $_GET["start"], $_GET["end"]));
		break;
		case 'toggleView':
			echo($calendar->toggleView($_GET["calendarid"], $_GET["active"]));
		break;
		case 'showSingleCalendar':
			echo($calendar->showSingleCalendar($_GET["calendarid"]));
		break;
		case 'getEventTypesDialog':
			echo($calendar->getEventTypesDialog($_GET['field'],$_GET['title']));
		break;
		case 'getTreatmentsLocationsDialog':
			echo($calendar->getTreatmentsLocationsDialog($_GET['field'],$_GET['title'],$_GET['from'],$_GET['fromtime'],$_GET['totime'],$_GET['eventtype']));
		break;
		case 'getCalendarsDialog':
			echo($calendar->getCalendarsDialog($_GET['field'],$_GET['title']));
		break;
		case 'getWidgetAlerts':
			echo($calendar->getWidgetAlerts());
		break;
		case 'markRead':
			echo($calendar->markRead($_GET['id']));
		break;
		case 'getHelp':
			echo($calendar->getHelp());
		break;
		case 'saveLastUsedTreatments':
			echo($calendar->saveLastUsedTreatments($_GET['id']));
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setFolderDetails':
			echo($projects->setFolderDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['projectstatus']));
		break;
		case 'newEventForm':
			echo($calendar->newEventForm($_POST["start"], $_POST["end"], $_POST["allday"], $_POST["calendar"]));
		break;
		case 'newEvent':
			echo($calendar->newEvent($_POST["calendar"], $_POST));
		break;
		case 'editEventForm':
			echo($calendar->editEventForm($_POST["id"]));
		break;
		case 'editEvent':
			echo($calendar->editEvent($_POST));
		break;
		case 'deleteEvent':
			echo($calendar->deleteEvent($_POST["id"]));
		break;
		case 'moveEvent':
			echo $calendar->moveEvent($_POST);
		break;
		case 'resizeEvent':
			echo $calendar->resizeEvent($_POST);
		break;
	}
}
?>
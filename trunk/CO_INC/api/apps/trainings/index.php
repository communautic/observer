<?php
// api url http://dev.companyobserver.com/?path=api/apps/publishers/menues&request=printDetails&id=1

include_once("config.php");
include(CO_INC . "/classes/session.php");
/*include(CO_INC . "/classes/database.php");
include(CO_INC . "/classes/users.php");
include(CO_INC . "/classes/system.php");
include(CO_INC . "/classes/date.php");*/

include_once(CO_INC . "/model.php");
include_once(CO_INC . "/controller.php");

foreach($controller->applications as $app => $display) {
	include_once(CO_INC . "/apps/".$app."/config.php");
	include_once(CO_INC . "/apps/".$app."/lang/" . CO_DEFAULT_LANGUAGE . ".php");
	include_once(CO_INC . "/apps/".$app."/model.php");
	include_once(CO_INC . "/apps/".$app."/controller.php");
}


include_once(CO_INC . "/apps/trainings/config.php");
include_once(CO_INC . "/apps/trainings/lang/" . CO_DEFAULT_LANGUAGE . ".php");
include_once(CO_INC . "/apps/trainings/model.php");
include_once(CO_INC . "/apps/trainings/controller.php");

if(!isset($_REQUEST['key']) || $_REQUEST['key'] == "") {
		die('Sorry, no key specified');
	}
$key = $_REQUEST['key'];

// is key valid
$q = "SELECT * FROM " . CO_TBL_TRAININGS_MEMBERS . " WHERE accesskey='$key' and bin='0'";
$result = mysql_query($q);
if(mysql_num_rows($result) < 1 ) {
	die('No valid access key');
}


if (!empty($_GET['request'])) {
	switch($_GET['request']) {
		case 'invitation':
			include('view/invitation.php');
		break;
	}
}
if (!empty($_POST['request'])) {
	switch($_POST['request']) {
		case 'acceptinvitation':
			$trainings->acceptInvitation($_POST['id']);
		break;
	}
}
?>
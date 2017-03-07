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
include_once(CO_INC . "/apps/trainings/modules/feedbacks/lang/" . CO_DEFAULT_LANGUAGE . ".php");

if(!isset($_REQUEST['key']) || $_REQUEST['key'] == "") {
	die('Sorry, no key specified');
}
$key = $_REQUEST['key'];
// is key valid
$q = "SELECT * FROM " . CO_TBL_TRAININGS_MEMBERS . " WHERE accesskey='$key' and bin='0'";
$result = mysql_query($q);
if(mysql_num_rows($result) < 1 ) {
	include('view/top.php');
	echo('Dieser Vorgang ist nicht gestattet. Bitte kontaktieren Sie Ihren Administrator');
	include('view/bottom.php');
	die();
}
while($row = mysql_fetch_array($result)) {
	$memberid = $row['id'];
	$userid = $row['cid'];
}

if (!empty($_GET['request'])) {
	switch($_GET['request']) {
		case 'accept':
			if($trainings->acceptInvitation($memberid,$userid)) {
				// send email
			}
			$training = $trainings->prepareTrainingdata($memberid);
			$response = $lang['TRAINING_INVITATION_RESPONSE_ACCEPT'];
			include('view/top.php');
			include('view/invitation.php');
			include('view/bottom.php');
		break;
		case 'decline':
			if($trainings->declineInvitation($memberid,$userid)) {
				// send email
			}
			$training = $trainings->prepareTrainingdata($memberid);
			$response = $lang['TRAINING_INVITATION_RESPONSE_DECLINE'];
			include('view/top.php');
			include('view/invitation.php');
			include('view/bottom.php');
		break;
		case 'feedback':
			$training = $trainings->prepareTrainingdata($memberid);
			include('view/top.php');
			include('view/feedback.php');
			include('view/bottom.php');
		break;
	}
}
if (!empty($_POST['request'])) {
	switch($_POST['request']) {
		case 'feedback_response':
			$q1 = $_POST['q1'];
			$q2 = $_POST['q2'];
			$q3 = $_POST['q3'];
			$q4 = $_POST['q4'];
			$q5 = $_POST['q5'];
			$feedback_text = $system->checkMagicQuotes($_POST['feedback_text']);
			$trainings->saveFeedback($memberid,$userid,$q1,$q2,$q3,$q4,$q5,$feedback_text);
			$training = $trainings->prepareTrainingdata($memberid);
			$total = $q1 + $q2 + $q3 + $q4 + $q5;
	   		$result= round((100/25)*$total);
			include('view/top.php');
			include('view/feedback_response.php');
			include('view/bottom.php');
		break;
	}
}
?>


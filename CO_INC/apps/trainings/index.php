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

foreach($trainings->modules as $module  => $value) {
	include_once("modules/".$module."/config.php");
	include_once("modules/".$module."/lang/" . $session->userlang . ".php");
	include_once("modules/".$module."/model.php");
	include_once("modules/".$module."/controller.php");
}

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getFolderList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($trainings->getFolderList($sort));
		break;
		case 'getFolderDetails':
			echo($trainings->getFolderDetails($_GET['id']));
		break;
		case 'getFolderDetailsList':
			echo($trainings->getFolderDetailsList($_GET['id']));
		break;
		case 'getFolderDetailsMultiView':
			$zoom = 0;
			if(!empty($_GET['zoom'])) {
				$zoom = $_GET['zoom'];
			}
			$view = "Timeline";
			if(!empty($_GET['view'])) {
				$view = $_GET['view'];
			}
			echo($trainings->getFolderDetailsMultiView($_GET['id'],$view,$zoom));
		break;
		case 'getFolderDetailsStatus':
			echo($trainings->getFolderDetailsStatus($_GET['id']));
		break;
		case 'setFolderOrder':
			echo($trainings->setSortOrder("trainings-folder-sort",$_GET['folderItem']));
		break;
		case 'getFolderNew':
			echo($trainings->getFolderNew());
		break;
		case 'newFolder':
			echo($trainings->newFolder());
		break;
		case 'printFolderDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($trainings->printFolderDetails($_GET['id'],$t));
		break;
		case 'printFolderDetailsList':
			echo($trainings->printFolderDetailsList($_GET['id']));
		break;
		case 'printFolderDetailsMultiView':
			$view = "Timeline";
			if(!empty($_GET['view'])) {
				$view = $_GET['view'];
			}
			echo($trainings->printFolderDetailsMultiView($_GET['id'],$view));
		break;
		case 'printFolderDetailsStatus':
			echo($trainings->printFolderDetailsList($_GET['id']));
		break;
		case 'binFolder':
			echo($trainings->binFolder($_GET['id']));
		break;
		case 'restoreFolder':
			echo($trainings->restoreFolder($_GET['id']));
		break;
		case 'deleteFolder':
			echo($trainings->deleteFolder($_GET['id']));
		break;
		case 'getTrainingList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($trainings->getTrainingList($_GET['id'],$sort));
		break;
		case 'setTrainingOrder':
			echo($trainings->setSortOrder("trainings-sort",$_GET['trainingItem'],$_GET['id']));
		break;
		case 'getTrainingDetails':
			echo($trainings->getTrainingDetails($_GET['id']));
		break;
		case 'printTrainingDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($trainings->printTrainingDetails($_GET['id'],$t));
		break;
		case 'printMemberList':
			echo($trainings->printMemberList($_GET['id']));
		break;
		case 'printTrainingHandbook':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($trainings->printTrainingHandbook($_GET['id'],$t));
		break;
		case 'checkinTraining':
			echo($trainings->checkinTraining($_GET['id']));
		break;
		case 'getTrainingSend':
			echo($trainings->getTrainingSend($_GET['id']));
		break;
		case 'getFolderSend':
			echo($trainings->getFolderSend($_GET['id']));
		break;
		case 'getSendFolderDetailsList':
			echo($trainings->getSendFolderDetailsList($_GET['id']));
		break;
		case 'getSendFolderDetailsMultiView':
			$view = "Timeline";
			if(!empty($_GET['view'])) {
				$view = $_GET['view'];
			}
			echo($trainings->getSendFolderDetailsMultiView($_GET['id'],$view));
		break;
		case 'getSendFolderDetailsStatus':
			echo($trainings->getSendFolderDetailsList($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($trainings->getSendtoDetails("trainings",$_GET['id']));
		break;
		case 'newTraining':
			echo($trainings->newTraining($_GET['id']));
		break;
		case 'createDuplicate':
			echo($trainings->createDuplicate($_GET['id']));
		break;
		case 'binTraining':
			echo($trainings->binTraining($_GET['id']));
		break;
		case 'restoreTraining':
			echo($trainings->restoreTraining($_GET['id']));
		break;
		case 'deleteTraining':
			echo($trainings->deleteTraining($_GET['id']));
		break;
		case 'restoreMember':
			echo($trainings->restoreMember($_GET['id']));
		break;
		case 'deleteMember':
			echo($trainings->deleteMember($_GET['id']));
		break;
		case 'addMember':
			echo($trainings->addMember($_GET['pid'],$_GET['cid']));
		break;
		case 'getGroupIDs':
			echo($trainings->getGroupIDs($_GET['cid']));
		break;
		case 'sendInvitation':
			echo($trainings->sendInvitation($_GET['id']));
		break;
		case 'manualInvitation':
			echo($trainings->manualInvitation($_GET['id']));
		break;
		case 'resetInvitation':
			echo($trainings->resetInvitation($_GET['id']));
		break;
		case 'manualRegistration':
			echo($trainings->manualRegistration($_GET['id']));
		break;
		case 'removeRegistration':
			echo($trainings->removeRegistration($_GET['id']));
		break;
		case 'resetRegistration':
			echo($trainings->resetRegistration($_GET['id']));
		break;
		case 'manualTookpart':
			echo($trainings->manualTookpart($_GET['id']));
		break;
		case 'manualTookNotpart':
			echo($trainings->manualTookNotpart($_GET['id']));
		break;
		case 'resetTookpart':
			echo($trainings->resetTookpart($_GET['id']));
		break;
		case 'editFeedback':
			echo($trainings->editFeedback($_GET['id']));
		break;
		case 'sendFeedback':
			echo($trainings->sendFeedback($_GET['id']));
		break;
		case 'resetFeedback':
			echo($trainings->resetFeedback($_GET['id']));
		break;
		case 'binMember':
			echo($trainings->binMember($_GET['id']));
		break;
		// get Groups for Dialogs
		case 'getContactsDialog':
			echo($contacts->getContactsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		case 'getContactsDialogPlace':
			echo($contacts->getContactsDialogPlace($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		// get Pfolder Dialog
		case 'getTrainingFolderDialog':
			echo($trainings->getTrainingFolderDialog($_GET['field'],$_GET['title']));
		break;
		case 'getTrainingStatusDialog':
			echo($trainings->getTrainingStatusDialog());
		break;
		case 'getTrainingDialog':
			echo($trainings->getTrainingDialog($_GET['field'],$_GET['title']));
		break;
		case 'getAccessDialog':
			echo($trainings->getAccessDialog());
		break;
		case 'getTrainingsFoldersHelp':
			echo($trainings->getTrainingsFoldersHelp());
		break;
		case 'getTrainingsHelp':
			echo($trainings->getTrainingsHelp());
		break;
		case 'getBin':
			echo($trainings->getBin());
		break;
		case 'getWidgetAlerts':
			echo($trainings->getWidgetAlerts());
		break;
		case 'emptyBin':
			echo($trainings->emptyBin());
		break;
		case 'getNavModulesNumItems':
			echo($trainings->getNavModulesNumItems($_GET['id']));
		break;
		case 'newCheckpoint':
			echo($trainings->newCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'updateCheckpoint':
			echo($trainings->updateCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'deleteCheckpoint':
			echo($trainings->deleteCheckpoint($_GET['id']));
		break;
		case 'updateStatus':
			echo($trainings->updateStatus($_GET['id'],$_GET['date'],$_GET['status']));
		break;
		case 'getTrainingsSearch':
			echo($trainings->getTrainingsSearch($_GET['term'],$_GET['exclude']));
		break;
		case 'saveLastUsedTrainings':
			echo($trainings->saveLastUsedTrainings($_GET['id']));
		break;
		case 'getGlobalSearch':
			echo($trainings->getGlobalSearch($system->checkMagicQuotesTinyMCE($_GET['term'])));
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setFolderDetails':
			echo($trainings->setFolderDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['trainingstatus']));
		break;
		case 'setTrainingDetails':
			if(!isset($_POST['registration_end'])) { $_POST['registration_end'] = ''; }
			if(!isset($_POST['date1'])) { $_POST['date1'] = ''; }
			if(!isset($_POST['date2'])) { $_POST['date2'] = $_POST['date1']; }
			if(!isset($_POST['date3'])) { $_POST['date3'] = $_POST['date1']; }
			if(!isset($_POST['time1'])) { $_POST['time1'] = ''; }
			if(!isset($_POST['time2'])) { $_POST['time2'] = $_POST['time1']; }
			if(!isset($_POST['time3'])) { $_POST['time3'] = $_POST['time1']; }
			if(!isset($_POST['time4'])) { $_POST['time4'] = $_POST['time1']; }
			
			if(!isset($_POST['place1'])) { $_POST['place1'] = ''; }
			if(!isset($_POST['place1_ct'])) { $_POST['place1_ct'] = ''; }
			if(!isset($_POST['place2'])) { $_POST['place2'] = ''; }
			if(!isset($_POST['place2_ct'])) { $_POST['place2_ct'] = ''; }
			
			if(!isset($_POST['text1'])) { $_POST['text1'] = ''; }
			if(!isset($_POST['text2'])) { $_POST['text2'] = ''; }
			if(!isset($_POST['text3'])) { $_POST['text3'] = ''; }
			if(!isset($_POST['protocol'])) { $_POST['protocol'] = ''; }
			
			echo($trainings->setTrainingDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['folder'], $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']), $system->checkMagicQuotes($_POST['company']), $_POST['team'], $system->checkMagicQuotes($_POST['team_ct']), $_POST['training'], $_POST['training_id_orig'], $_POST['registration_end'], $system->checkMagicQuotes($_POST['protocol']), $_POST['date1'], $_POST['date2'], $_POST['date3'], $_POST['time1'], $_POST['time2'], $_POST['time3'], $_POST['time4'], $_POST['place1'], $system->checkMagicQuotes($_POST['place1_ct']), $_POST['place2'], $system->checkMagicQuotes($_POST['place2_ct']), $system->checkMagicQuotes($_POST['text1']), $system->checkMagicQuotes($_POST['text2']), $system->checkMagicQuotes($_POST['text3'])));
		break;
		case 'moveTraining':
			echo($trainings->moveTraining($_POST['id'], $_POST['startdate'], $_POST['movedays']));
		break;
		case 'sendTrainingDetails':
			echo($trainings->sendTrainingDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'sendFolderDetails':
			echo($trainings->sendFolderDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'sendFolderDetailsList':
			echo($trainings->sendFolderDetailsList($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'sendFolderDetailsMultiView':
			echo($trainings->sendFolderDetailsMultiView($_POST['variable'], $_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'updateCheckpointText':
			echo($trainings->updateCheckpointText($_POST['id'],$system->checkMagicQuotes($_POST['text'])));
		break;
	}
}
?>
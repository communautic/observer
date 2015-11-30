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

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getFolderList':
			foreach($controller->applications as $app => $display) {
				if(${$app}->archiveDisplay) {
					if($session->isSysadmin()) {
					echo('<li id="folderItem_"><span rel="' . $app . '" class="module-click"><span class="text">' . ${$app.'_name'} . '</span></span></li>'); 
					} else {
						if(!empty(${$app}->canAccess)) {
							echo('<li id="folderItem_"><span rel="' . $app . '" class="module-click"><span class="text">' . ${$app.'_name'} . '</span></span></li>'); 
				}
					}
				}
			}
		break;
		case 'archiveMeta':
			//echo($archives->archives($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql'],$_GET['module'],$_GET['id']));
			echo($archives->archivesMeta($_GET['module'],$_GET['id']));
		break;
		case 'getArchivesFoldersHelp':
			echo($archives->getArchivesFoldersHelp());
		break;
		case 'getArchivesHelp':
			echo($archives->getArchivesHelp());
		break;
		case 'getBin':
			$datetime = $archivesmodel->_date->formatDate("now",CO_DATETIME_FORMAT);
			ob_start();
			include 'view/bin.php';
			$header = ob_get_contents();
			ob_end_clean();
			ob_start();
			include 'view/bin_footer.php';
			$footer = ob_get_contents();
			ob_end_clean();
			$html = '';
			foreach($controller->applications as $app => $display) {
				if(${$app}->archiveDisplay) {
					//if($session->isSysadmin()) {
					$html .= ${$app}->getBinArchive(); 
					/*} else {
						if(!empty(${$app}->canAccess)) {
							echo('<li id="folderItem_"><span rel="' . $app . '" class="module-click"><span class="text">' . ${$app.'_name'} . '</span></span></li>'); 
				}
					}*/
				}
			}
			echo $header.$html.$footer;
		break;
		case 'emptyBin':
			//echo($archives->emptyBin());
			foreach($controller->applications as $app => $display) {
				if(${$app}->archiveDisplay) {
					//if($session->isSysadmin()) {
					foreach(${$app}->modules as $module  => $value) {
						include_once(CO_INC . "/apps/".$app."/modules/".$module."/config.php");
						include_once(CO_INC . "/apps/".$app."/modules/".$module."/lang/" . $session->userlang . ".php");
						include_once(CO_INC . "/apps/".$app."/modules/".$module."/model.php");
						include_once(CO_INC . "/apps/".$app."/modules/".$module."/controller.php");
					}
					${$app}->emptyBinArchive(); 
					/*} else {
						if(!empty(${$app}->canAccess)) {
							echo('<li id="folderItem_"><span rel="' . $app . '" class="module-click"><span class="text">' . ${$app.'_name'} . '</span></span></li>'); 
				}
					}*/
				}
			}
			$datetime = $archivesmodel->_date->formatDate("now",CO_DATETIME_FORMAT);
			ob_start();
			include 'view/bin.php';
			$header = ob_get_contents();
			ob_end_clean();
			ob_start();
			include 'view/bin_footer.php';
			$footer = ob_get_contents();
			ob_end_clean();
			$html = '';
			foreach($controller->applications as $app => $display) {
				if(${$app}->archiveDisplay) {
					//if($session->isSysadmin()) {
					$html .= ${$app}->getBinArchive(); 
					/*} else {
						if(!empty(${$app}->canAccess)) {
							echo('<li id="folderItem_"><span rel="' . $app . '" class="module-click"><span class="text">' . ${$app.'_name'} . '</span></span></li>'); 
				}
					}*/
				}
			}
			echo $header.$html.$footer;
			
		break;
		/*case 'getFolderDetails':
			echo($archives->getFolderDetails($_GET['id']));
		break;
		case 'getFolderDetailsList':
			echo($archives->getFolderDetailsList($_GET['id']));
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
			echo($archives->getFolderDetailsMultiView($_GET['id'],$view,$zoom));
		break;
		case 'getFolderDetailsStatus':
			echo($archives->getFolderDetailsStatus($_GET['id']));
		break;
		case 'setFolderOrder':
			echo($archives->setSortOrder("archives-folder-sort",$_GET['folderItem']));
		break;
		case 'getFolderNew':
			echo($archives->getFolderNew());
		break;
		case 'newFolder':
			echo($archives->newFolder());
		break;
		case 'printFolderDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($archives->printFolderDetails($_GET['id'],$t));
		break;
		case 'printFolderDetailsList':
			echo($archives->printFolderDetailsList($_GET['id']));
		break;
		case 'printFolderDetailsMultiView':
			$view = "Timeline";
			if(!empty($_GET['view'])) {
				$view = $_GET['view'];
			}
			echo($archives->printFolderDetailsMultiView($_GET['id'],$view));
		break;
		case 'printFolderDetailsStatus':
			echo($archives->printFolderDetailsList($_GET['id']));
		break;
		case 'binFolder':
			echo($archives->binFolder($_GET['id']));
		break;
		case 'restoreFolder':
			echo($archives->restoreFolder($_GET['id']));
		break;
		case 'deleteFolder':
			echo($archives->deleteFolder($_GET['id']));
		break;
		case 'getArchiveList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($archives->getArchiveList($_GET['id'],$sort));
		break;
		case 'setArchiveOrder':
			echo($archives->setSortOrder("archives-sort",$_GET['archiveItem'],$_GET['id']));
		break;
		case 'getArchiveDetails':
			echo($archives->getArchiveDetails($_GET['id']));
		break;
		case 'getDates':
			echo($archives->getDates($_GET['id']));
		break;
		case 'printArchiveDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($archives->printArchiveDetails($_GET['id'],$t));
		break;
		case 'printArchiveHandbook':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($archives->printArchiveHandbook($_GET['id'],$t));
		break;
		case 'checkinArchive':
			echo($archives->checkinArchive($_GET['id']));
		break;
		case 'getArchiveSend':
			echo($archives->getArchiveSend($_GET['id']));
		break;
		case 'getFolderSend':
			echo($archives->getFolderSend($_GET['id']));
		break;
		case 'getSendFolderDetailsList':
			echo($archives->getSendFolderDetailsList($_GET['id']));
		break;
		case 'getSendFolderDetailsMultiView':
			$view = "Timeline";
			if(!empty($_GET['view'])) {
				$view = $_GET['view'];
			}
			echo($archives->getSendFolderDetailsMultiView($_GET['id'],$view));
		break;
		case 'getSendFolderDetailsStatus':
			echo($archives->getSendFolderDetailsList($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($archives->getSendtoDetails("archives",$_GET['id']));
		break;
		case 'newArchive':
			echo($archives->newArchive($_GET['id']));
		break;
		case 'createDuplicate':
			echo($archives->createDuplicate($_GET['id']));
		break;
		case 'binArchive':
			echo($archives->binArchive($_GET['id']));
		break;
		case 'restoreArchive':
			echo($archives->restoreArchive($_GET['id']));
		break;
		case 'deleteArchive':
			echo($archives->deleteArchive($_GET['id']));
		break;
		// get Groups for Dialogs
		case 'getContactsDialog':
			echo($contacts->getContactsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		case 'getContactsDialogPlace':
			echo($contacts->getContactsDialogPlace($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		// get Pfolder Dialog
		case 'getArchiveFolderDialog':
			echo($archives->getArchiveFolderDialog($_GET['field'],$_GET['title']));
		break;
		case 'getArchiveStatusDialog':
			echo($archives->getArchiveStatusDialog());
		break;
		case 'getAccessDialog':
			echo($archives->getAccessDialog());
		break;
		case 'getBin':
			echo($archives->getBin());
		break;
		case 'emptyBin':
			echo($archives->emptyBin());
		break;
		case 'getWidgetAlerts':
			echo($archives->getWidgetAlerts());
		break;
		case 'markNoticeRead':
			echo($archives->markNoticeRead($_GET['pid']));
		break;
		case 'markNoticeDelete':
			echo($archives->markNoticeDelete($_GET['id']));
		break;
		case 'getNavModulesNumItems':
			echo($archives->getNavModulesNumItems($_GET['id']));
		break;
		case 'newCheckpoint':
			echo($archives->newCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'updateCheckpoint':
			echo($archives->updateCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'deleteCheckpoint':
			echo($archives->deleteCheckpoint($_GET['id']));
		break;
		case 'updateStatus':
			echo($archives->updateStatus($_GET['id'],$_GET['date'],$_GET['status']));
		break;
		case 'getArchivesSearch':
			echo($archives->getArchivesSearch($_GET['term'],$_GET['exclude']));
		break;
		case 'saveLastUsedArchives':
			echo($archives->saveLastUsedArchives($_GET['id']));
		break;
		case 'getGlobalSearch':
			echo($archives->getGlobalSearch($system->checkMagicQuotesTinyMCE($_GET['term'])));
		break;
		case 'toggleCosts':
			echo($archives->toggleCosts($_GET['id'],$_GET['statusnew']));
		break;
		case 'toggleCurrency':
			echo($archives->toggleCurrency($_GET['id'],$_GET['cur']));
		break;*/
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		/*case 'setFolderDetails':
			echo($archives->setFolderDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['archivestatus']));
		break;
		case 'setArchiveDetails':
			echo($archives->setArchiveDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['startdate'], $_POST['movearchive_start'], $_POST['ordered_by'], $system->checkMagicQuotes($_POST['ordered_by_ct']), $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']), $_POST['team'], $system->checkMagicQuotes($_POST['team_ct']), $system->checkMagicQuotes($_POST['protocol']), $_POST['folder']));
		break;
		case 'moveArchive':
			echo($archives->moveArchive($_POST['id'], $_POST['startdate'], $_POST['movedays']));
		break;
		case 'sendArchiveDetails':
			echo($archives->sendArchiveDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'sendFolderDetails':
			echo($archives->sendFolderDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'sendFolderDetailsList':
			echo($archives->sendFolderDetailsList($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'sendFolderDetailsMultiView':
			echo($archives->sendFolderDetailsMultiView($_POST['variable'], $_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;*/
	}
}
?>
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

// GET requests
if (!empty($_GET['request'])) {
	
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			//echo($bin->getList($sort));
			foreach($controller->applications as $app => $display) {
							if(${$app}->binDisplay) {
							echo('<li id="folderItem_"><a href="#" rel="" class="module-click"><span class="text">' . ${$app.'_name'} . '</span></a></li>');
							}
				}
		break;
		case 'getFolderDetails':
			echo($projects->getFolderDetails($_GET['id']));
		break;
		case 'setFolderOrder':
			echo($projects->setSortOrder("folder-sort",$_GET['folderItem']));
		break;
		case 'getFolderNew':
			echo($projects->getFolderNew());
		break;
		case 'newFolder':
			echo($projects->newFolder());
		break;
		case 'printFolderDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($projects->printFolderDetails($_GET['id'],$t));
		break;
		case 'binFolder':
			echo($projects->binFolder($_GET['id']));
		break;
	}
}

?>
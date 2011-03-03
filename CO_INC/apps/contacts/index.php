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
		case 'getGroupList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($contacts->getGroupList($sort));
		break;
		case 'getGroupDetails':
			echo($contacts->getGroupDetails($_GET['id']));
		break;
		case 'setGroupOrder':
			echo($contacts->setSortOrder("group-sort",$_GET['groupItem']));
		break;
		/*case 'getGroupNew':
			echo($contacts->getGroupNew());
		break;*/
		case 'newGroup':
			echo($contacts->newGroup());
		break;
		case 'binGroup':
			echo($contacts->binGroup($_GET['id']));
		break;
		case 'getContactList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($contacts->getContactList($_GET['id'],$sort));
		break;
		case 'setContactOrder':
			echo($contacts->setSortOrder("contact-sort",$_GET['contactItem'],$_GET['id']));
		break;
		case 'getContactDetails':
			echo($contacts->getContactDetails($_GET['id']));
		break;
		/*case 'getContactNew':
			echo($contacts->getContactNew($_GET['id']));
		break;*/
		case 'newContact':
			echo($contacts->newContact());
		break;
		case 'binContact':
			echo($contacts->binContact($_GET['id']));
		break;
		// get Users within Group for Dialog insert
		case 'getUsersInGroupDialog':
			echo($contacts->getUsersInGroupDialog($_GET['id'],$_GET['field']));
		break;
		// User context menu for lists
		case 'getUserContext':
			echo($contacts->getUserContext($_GET['id'],$_GET['field']));
		break;
		case 'getCustomTextContext':
			echo('<div class="context"><a href="delete" class="delete-ct">Entfernen</a><br /></div>');
		break;
		case 'getContactsDialog':
			echo($contacts->getContactsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		case 'getContactsSearch':
			echo($contacts->getContactsSearch($_GET['term']));
		break;
		case 'getPlacesSearch':
			echo($contacts->getPlacesSearch($_GET['term']));
		break;
		case 'getBin':
			echo(" Groups / contacts Bin");
		break;
	}
	
}

// POST requests
if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setGroupDetails':
			echo($contacts->setGroupDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['members']));
		break;
		/*case 'newGroup':
			echo($contacts->newGroup($system->checkMagicQuotes($_POST['title'])));
		break;*/
		case 'setContactDetails':
			echo($contacts->setContactDetails($_POST['id'], $system->checkMagicQuotes($_POST['lastname']), $system->checkMagicQuotes($_POST['firstname']), $system->checkMagicQuotes($_POST['title']), $system->checkMagicQuotes($_POST['company']), $system->checkMagicQuotes($_POST['position']), $system->checkMagicQuotes($_POST['email']), $system->checkMagicQuotes($_POST['phone1']), $system->checkMagicQuotes($_POST['phone2']), $system->checkMagicQuotes($_POST['fax']), $system->checkMagicQuotes($_POST['address_line1']), $system->checkMagicQuotes($_POST['address_line2']), $system->checkMagicQuotes($_POST['address_town']), $system->checkMagicQuotes($_POST['address_postcode']), $system->checkMagicQuotes($_POST['address_country']), $_POST['lang'] ));
		break;
		/*case 'newContact':
			echo($contacts->newContact($system->checkMagicQuotes($_POST['lastname']), $system->checkMagicQuotes($_POST['firstname']), $system->checkMagicQuotes($_POST['title']), $system->checkMagicQuotes($_POST['position']), $system->checkMagicQuotes($_POST['address']), $system->checkMagicQuotes($_POST['email']), $system->checkMagicQuotes($_POST['phone1']), $system->checkMagicQuotes($_POST['phone2']), $system->checkMagicQuotes($_POST['fax']), $_POST['lang']));
		break;*/
	}
}

?>
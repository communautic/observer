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
		case 'getGroupMemberDetails':
			echo($contacts->getGroupMemberDetails($_GET['id']));
		break;
		case 'printGroupDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($contacts->printGroupDetails($_GET['id'],$t));
		break;
		case 'getGroupSend':
			echo($contacts->getGroupSend($_GET['id']));
		break;
		case 'getGroupSendVcard':
			echo($contacts->getGroupSendVcard($_GET['id']));
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
		case 'duplicateGroup':
			echo($contacts->duplicateGroup($_GET['id']));
		break;
		case 'binGroup':
			echo($contacts->binGroup($_GET['id']));
		break;
		case 'restoreGroup':
			echo($contacts->restoreGroup($_GET['id']));
		break;
		case 'deleteGroup':
			echo($contacts->deleteGroup($_GET['id']));
		break;
		case 'getContactList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($contacts->getContactList($sort));
		break;
		case 'setContactOrder':
			echo($contacts->setSortOrder("contact-sort",$_GET['contactItem']));
		break;
		case 'getContactDetails':
			echo($contacts->getContactDetails($_GET['id']));
		break;
		case 'getContactDetailsArray':
			echo($contacts->getContactDetailsArray($_GET['id']));
		break;
		case 'getContactField':
			echo($contacts->getContactField($_GET['id'],$_GET['field']));
		break;
		case 'printContactDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($contacts->printContactDetails($_GET['id'],$t));
		break;
		case 'getContactSend':
			echo($contacts->getContactSend($_GET['id']));
		break;
		case 'getContactSendVcard':
			echo($contacts->getContactSendVcard($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($contacts->getSendtoDetails("contacts",$_GET['id']));
		break;
		case 'newContact':
			echo($contacts->newContact());
		break;
		case 'duplicateContact':
			echo($contacts->duplicateContact($_GET['id']));
		break;
		case 'binContact':
			echo($contacts->binContact($_GET['id']));
		break;
		case 'restoreContact':
			echo($contacts->restoreContact($_GET['id']));
		break;
		case 'deleteContact':
			echo($contacts->deleteContact($_GET['id']));
		break;
		case 'generateAccess':
			echo($contacts->generateAccess($_GET['id']));
		break;
		case 'removeAccess':
			echo($contacts->removeAccess($_GET['id']));
		break;
		case 'setSysadmin':
			echo($contacts->setSysadmin($_GET['id']));
		break;
		case 'removeSysadmin':
			echo($contacts->removeSysadmin($_GET['id']));
		break;
		// get Users within Group for Dialog insert
		case 'getUsersInGroupDialog':
			echo($contacts->getUsersInGroupDialog($_GET['id'],$_GET['field']));
		break;
		// User context menu for lists
		case 'getUserContext':
			echo($contacts->getUserContext($_GET['id'],$_GET['field'],$_GET['edit']));
		break;
		case 'getCustomTextContext':
			echo('<div class="context"><a href="delete" class="delete-ct">' . $lang["GLOBAL_REMOVE"] . '</a><br /></div>');
		break;
		case 'getLanguageDialog':
			echo($contacts->getLanguageDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		case 'getTimezoneDialog':
			echo($contacts->getTimezoneDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		case 'getAccessDialog':
			echo($contacts->getAccessDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		case 'getSysadminDialog':
			echo($contacts->getSysadminDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		case 'getContactsDialog':
			echo($contacts->getContactsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		case 'getContactsSearch':
			echo($contacts->getContactsSearch($_GET['term']));
		break;
		case 'getGroupsSearch':
			echo($contacts->getGroupsSearch($_GET['term']));
		break;
		case 'getPlacesSearch':
			echo($contacts->getPlacesSearch($_GET['term']));
		break;
		case 'saveLastUsedContacts':
			echo($contacts->saveLastUsedContacts($_GET['id']));
		break;
		case 'saveLastUsedGroups':
			echo($contacts->saveLastUsedGroups($_GET['id']));
		break;
		case 'getBin':
			echo($contacts->getBin());
		break;
		case 'emptyBin':
			echo($contacts->emptyBin());
		break;
	}
	
}

// POST requests
if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setGroupDetails':
			echo($contacts->setGroupDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['members']));
		break;
		case 'setContactDetails':
			echo($contacts->setContactDetails($_POST['id'], $system->checkMagicQuotes($_POST['lastname']), $system->checkMagicQuotes($_POST['firstname']), $system->checkMagicQuotes($_POST['title']), $system->checkMagicQuotes($_POST['company']), $system->checkMagicQuotes($_POST['position']), $system->checkMagicQuotes($_POST['email']), $system->checkMagicQuotes($_POST['phone1']), $system->checkMagicQuotes($_POST['phone2']), $system->checkMagicQuotes($_POST['fax']), $system->checkMagicQuotes($_POST['address_line1']), $system->checkMagicQuotes($_POST['address_line2']), $system->checkMagicQuotes($_POST['address_town']), $system->checkMagicQuotes($_POST['address_postcode']), $system->checkMagicQuotes($_POST['address_country']), $_POST['lang'], $_POST['timezone']));
		break;
		case 'sendContactDetails':
			echo($contacts->sendContactDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'sendGroupDetails':
			echo($contacts->sendGroupDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'sendContactDetailsVcard':
			echo($contacts->sendContactDetailsVCard($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'sendGroupDetailsVcard':
			echo($contacts->sendGroupDetailsVCard($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>
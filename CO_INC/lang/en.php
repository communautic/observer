<?php
switch(CO_PRODUCT_VARIANT) {
	case 0:
		$lang["APPLICATION_NAME"] = "company observer 6.4.1";
		$lang["APPLICATION_NAME_ALT"] = "company.observer";
		$lang["APPLICATION_LOGO"] = "company_observer.png";
		$lang["APPLICATION_LOGO_LOGIN"] = "company_observer_login.png";
		$GLOBALS["APPLICATION_LOGO_PRINT"] = "poweredby_company_observer.png";
	break;
	case 1:
		$lang["APPLICATION_NAME"] = "physio observer 6.4.1";
		$lang["APPLICATION_NAME_ALT"] = "physio.observer";
		$lang["APPLICATION_LOGO"] = "physio_observer.png";
		$lang["APPLICATION_LOGO_LOGIN"] = "physio_observer_login.png";
		$GLOBALS["APPLICATION_LOGO_PRINT"] = "poweredby_physio_observer.png";
	break;
}

setlocale(LC_TIME, "en_EN");

/* LOGIN PAGE */
$lang["LOGIN_USERNAME"] = "Username";
$lang["LOGIN_PASSWORD"] = "Password";
$lang["LOGIN_PASSWORD_REPEAT"] = "repeat Passwort";
$lang["LOGIN_SET_LOGIN"] = 'As a first step please enter your new username in the provided field below (6 chars min, case-sensitive). Next, enter your new password (6 chars min, including special chars). Confirm your new password and finish the sign-up procedure by clicking "confirm".';
$lang["LOGIN_REMEMBER"] = "Remember me";
$lang["LOGIN_REQUIREMENTS"] = "Browser requirements";
$lang["LOGIN_REQUIREMENTS_DETAILS"] = "Chrome, Internet Explorer 8+, Firefox 2+, Safari3+";
$lang["LOGIN_LOGIN"] = "login";
$lang["LOGIN_CONFIRM"] = "confirm";
$lang["LOGIN_COPYRIGHT"] = '<a href="http://www.communautic.com" target="_blank">All rights reserved communautic Ltd | www.communautic.com</a>';
$lang["LOGIN_LOGIN_FAILED"] = "Incorrect login details. Please try again.";
$lang["LOGIN_LOGOUT"] = "Logout";
$lang["LOGIN_HELP"] = 'manual_login.pdf';
$lang["LOGIN_TERMS"] = 'Software License Agreement';
$lang["LOGIN_TERMS_FILE"] = 'CO_PO_EULA_2013.pdf';

/* APPS ACTION LINKS */
$lang["ACTION_CLOSE"] = "hide";
$lang["ACTION_NEW"] = "new";
$lang["ACTION_IMPORT"] = "import";
$lang["ACTION_PRINT"] = "print";
$lang["ACTION_SENDTO"] = "send to";
$lang["ACTION_DUPLICATE"] = "duplicate";
$lang["ACTION_REFRESH"] = "refresh";
$lang["ACTION_EXPORT"] = "export";
$lang["ACTION_HELP"] = "help";
$lang["ACTION_DELETE"] = "delete";

$lang["TEXT_NOTE"] = "Note:";
	
$lang["CREATED_BY_ON"]		= 	'created:';
$lang["EDITED_BY_ON"] 		= 	'edited:';
$lang["CREATED_BY_ON"]		= 	'created:';
$lang["SENDTO_BY_ON"] 		= 	'forwarded to:';
$lang["SENDFROM_BY_ON"] 	= 	'forwarded by:';
$lang["DELETED_BY_ON"] 		= 	'deleted';
$lang["INTERNAL_CHANGED"] 	= 	'released:';

$lang["GLOBAL_USER"] = 'User:';
$lang["GLOBAL_ADMIN"] = 'Administrator';
$lang["GLOBAL_ADMIN_SHORT"] = 'Admin';
$lang["GLOBAL_ADMINS"] = 'Administrators';
$lang["GLOBAL_GUEST"] = 'Guest';
$lang["GLOBAL_GUEST_SHORT"] = 'Guest';
$lang["GLOBAL_GUESTS"] = 'Guests';
$lang["GLOBAL_OWNER"] = 'Owner';

$lang["GLOBAL_SAVE"] = 'Save';
$lang["GLOBAL_DELETE"] = 'Delete';
$lang["GLOBAL_RESET"] = 'Reset';
$lang["GLOBAL_CONFIRM"] = 'Confirm';
$lang["GLOBAL_SENDEMAIL"] = 'Send';

$lang["GLOBAL_STATUS"] 		= 	'Status';
// Status definitions
$lang["GLOBAL_STATUS_PLANNED"] = 'planned';
$lang["GLOBAL_STATUS_PLANNED_TIME"] = 'on';
$lang["GLOBAL_STATUS_INPROGRESS"] = 'started';
$lang["GLOBAL_STATUS_INPROGRESS_TIME"] = 'on';
$lang["GLOBAL_STATUS_FINISHED"] = 'completed';
$lang["GLOBAL_STATUS_FINISHED_TIME"] = 'on';
$lang["GLOBAL_STATUS_STOPPED"] = 'stopped';
$lang["GLOBAL_STATUS_STOPPED_TIME"] = 'on';
// timelines
$lang["GLOBAL_STATUS_NOT_FINISHED"] = "incomplete";
$lang["GLOBAL_STATUS_OVERDUE"] = "delayed";
$lang["GLOBAL_STATUS_OVERDUE_POPUP"] = "day/s delayed";
// meetings
$lang["GLOBAL_STATUS_COMPLETED"] = 'completed';
$lang["GLOBAL_STATUS_COMPLETED_TIME"] = 'on';
$lang["GLOBAL_STATUS_CANCELLED"] = 'cancelled';
$lang["GLOBAL_STATUS_CANCELLED_TIME"] = 'on';
$lang["GLOBAL_STATUS_POSPONED"] = 'postponed';
$lang["GLOBAL_STATUS_POSPONED_TIME"] = 'to';
// forums
$lang["GLOBAL_STATUS_DISCUSSION"] = 'in discussion';
$lang["GLOBAL_STATUS_DISCUSSION_TIME"] = 'on';
// complaints
$lang["GLOBAL_STATUS_ENTERED"] = 'documented';
$lang["GLOBAL_STATUS_ENTERED_TIME"] = 'on';
// webnews
$lang["GLOBAL_STATUS_PUBLISHED"] = 'published';
$lang["GLOBAL_STATUS_PUBLISHED_TIME"] = 'on';
$lang["GLOBAL_STATUS_ARCHIVED"] = 'archived';
$lang["GLOBAL_STATUS_ARCHIVED_TIME"] = 'since';
// employees
$lang["GLOBAL_STATUS_TRIAL"] = 'in Probe';
$lang["GLOBAL_STATUS_TRIAL_TIME"] = 'seit';
$lang["GLOBAL_STATUS_ACTIVE"] = 'aktiv';
$lang["GLOBAL_STATUS_ACTIVE_TIME"] = 'seit';
$lang["GLOBAL_STATUS_MATERNITYLEAVE"] = 'karenziert';
$lang["GLOBAL_STATUS_MATERNITYLEAVE_TIME"] = 'seit';
$lang["GLOBAL_STATUS_LEAVE"] = 'ausgeschieden';
$lang["GLOBAL_STATUS_LEAVE_TIME"] = 'am';
// trainings
$lang["GLOBAL_STATUS_INACTION"] = 'in Ausführung';
$lang["GLOBAL_STATUS_INACTION_TIME"] = 'seit';
$lang["GLOBAL_STATUS_FINISHED2"] = 'abgehalten';
$lang["GLOBAL_STATUS_FINISHED2_TIME"] = 'seit';

$lang["GLOBAL_DURATION"] 	= 	'Timeline';
$lang["GLOBAL_EMAILED_TO"] 	= 	'Send';
$lang["GLOBAL_DUPLICAT"] 	= 	'Duplicate';

$lang["GLOBAL_ACCESS"] = 'Access';
$lang["GLOBAL_ACCESS_INTERNAL"] = 'internal';
$lang["GLOBAL_ACCESS_PUBLIC"] = 'external';
$lang["GLOBAL_ACCESS_FOOTER"] = 'access:';
$lang["GLOBAL_FOOTER_STATUS"] = 'Status';

$lang["GLOBAL_TO"] = 'To';
$lang["GLOBAL_CC"] = 'CC';
$lang["GLOBAL_BCC"] = 'BCC';
$lang["GLOBAL_SUBJECT"] = 'Subject';
$lang["GLOBAL_MESSAGE"] = 'Message';
$lang["GLOBAL_SEND"] = 'Send';
$lang["GLOBAL_EXPORT"] = 'Export';

$lang["GLOBAL_CHECKPOINT"] = 'Checkpoint';

$lang["GLOBAL_DAYS"] = 'days';
$lang["GLOBAL_TODAY"] = 'Today';
$lang["GLOBAL_YESTERDAY"] = 'Yesterday';
$lang["GLOBAL_DAYS_AGO"] = '%1$s days ago';

// email footer
$lang["GLOBAL_EMAIL_FOOTER"] = 	'<p style="font-face: Arial, Verdana; font-size:small; color: #999999;">_____powered by '.$lang["APPLICATION_NAME_ALT"].'</p>' .
								'<p style="font-face: Arial, Verdana; font-size:x-small; color: #999999;">The information contained in this email and any attachments may be legally privileged and confidential. If you are not an intended recipient, you are hereby notified that any dissemination, distribution, or copying of this e-mail is strictly prohibited. If you have received this e-mail in error, please notify the sender and permanently delete the e-mail and any attachments immediately. You should not retain, copy or use this e-mail or any attachments for any purpose, nor disclose all or any part of the contents to any other person.</p>';

// PDF print Globals
$GLOBALS['SECTION'] = "";
$GLOBALS['PAGE'] = "Page"; 
$GLOBALS['OF'] = "of"; 
?>
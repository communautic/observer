<?php
$contacts_name = "Contacts";

$lang['CONTACTS_GROUPS'] = 'Groups';
$lang['CONTACTS_CONTACT'] = 'Contact';
$lang['CONTACTS_CONTACTS'] = 'Contacts';

$lang["CONTACTS_CONTACTS_NEW"] = 'New Contact';
$lang["CONTACTS_CONTACTS_ACTION_NEW"] = 'new Contact';
$lang["CONTACTS_GROUPS_NEW"] = 'new Group';
$lang["CONTACTS_GROUPS_ACTION_NEW"] = 'new Group';

$lang['CONTACTS_GROUP_TITLE'] = 'Group';
$lang['CONTACTS_SINGLE_CONTACTS'] = 'Contacts';
$lang['CONTACTS_SYSTEM_GROUP'] = 'All Contacts';
define('CONTACTS_ADD_CONTACT_TO_GROUP', 'integrate contacts');
define('CONTACTS_ADD_GROUP_TO_GROUP', 'integrate group');
$lang['CONTACTS_GROUP_MEMBERS'] = 'Members';
$lang['CONTACTS_GROUP_MEMBERS_LIST'] = 'all Members';

$lang['CONTACTS_LASTNAME'] = 'Surname';
$lang['CONTACTS_FIRSTNAME'] = 'First Name';
$lang['CONTACTS_CONTACT_TITLE'] = 'Title';
$lang['CONTACTS_CONTACT_TITLE2'] = 'Title Alt';
$lang['CONTACTS_COMPANY'] = 'Company';
$lang['CONTACTS_POSITION'] = 'Position';
$lang['CONTACTS_EMAIL'] = 'E-mail (Standard)';
$lang['CONTACTS_EMAIL_ALT'] = 'E-mail (alternativ)';
$lang['CONTACTS_TEL'] = 'Phone 1';
$lang['CONTACTS_TEL2'] = 'Phone 2';
$lang['CONTACTS_FAX'] = 'Fax';

$lang["CONTACT_TAB_ADDRESS"] = "Address";
$lang["CONTACT_TAB_ACCESS"] = "Access";
$lang["CONTACT_TAB_CALENDAR"] = "Calendar";


$lang['CONTACTS_ADDRESS'] = 'Address';
$lang['CONTACTS_ADDRESS_LINE1'] = 'Street 1';
$lang['CONTACTS_ADDRESS_LINE2'] = 'Street 2';
$lang['CONTACTS_TOWN'] = 'Town';
$lang['CONTACTS_POSTCODE'] = 'Postal code';
$lang['CONTACTS_COUNTRY'] = 'Country';

$lang['CONTACTS_BANK_NAME'] = 'Bank';
$lang['CONTACTS_BANK_SORT_CODE'] = 'Sort code';
$lang['CONTACTS_BANK_ACCOUNT_NBR'] = 'Account no';
$lang['CONTACTS_BANK_ACCOUNT_BIC'] = 'BIC';
$lang['CONTACTS_BANK_ACCOUNT_IBAN'] = 'IBAN';

$lang['CONTACTS_LANGUAGE'] = 'Language';
$lang['CONTACTS_TIMEZONE'] = 'Timezone';

$lang['CONTACTS_GROUPMEMBERSHIP'] = 'Group membership';

$lang['CONTACTS_ACCESSCODES'] = 'Access Codes';
$lang['CONTACTS_ACCESSCODES_NO'] = 'no Access Codes';
$lang['CONTACTS_ACCESSCODES_SEND'] = 'send Access Codes';
$lang['CONTACTS_ACCESSCODES_REMOVE'] = 'remove Access Codes';
$lang['CONTACTS_ACCESS_ACTIVE'] = 'sent on %s by %s';
$lang['CONTACTS_ACCESS_REMOVE'] = 'removed on %s by %s';
$lang['CONTACTS_SYSADMIN_NORIGHTS'] = 'no Rights';
$lang['CONTACTS_SYSADMIN_ACTIVE'] = 'given on %s by %s';
$lang['CONTACTS_SYSADMIN_REMOVE'] = 'removed on %s by %s';
$lang['CONTACTS_SYSADMIN_GIVE_RIGHT'] = 'give Rights';
$lang['CONTACTS_SYSADMIN_REMOVE_RIGHT'] = 'remove Rights';

$lang['CONTACTS_CALENDAR_NO_ACCESS'] = 'This contact does not have any access yet. <br />Please follow these steps: <br />1. Grant access to the user (Tab Access), <br />2. Refresh the module <br />3. Activate the calendar';
$lang['CONTACTS_CALENDAR_GIVE_RIGHT'] = 'activate';
$lang['CONTACTS_CALENDAR_REMOVE_RIGHT'] = 'deactivate';
$lang['CONTACTS_CALENDAR_ACTIVE'] = 'active';
$lang['CONTACTS_CALENDAR_DEACTIVE'] = 'deactive';
$lang['CONTACTS_CALENDAR_OTHERS'] = 'Other / Caldav';
$lang['CONTACTS_CALENDAR_ALL_URL'] = 'officecalendar';

$lang['CONTACTS_CUSTOM'] = 'Note';

$lang['CONTACTS_AVATARS'] = 'Contacts / Images';

// Access codes Email
$lang['ACCESS_CODES_EMAIL_SUBJECT'] = $lang["APPLICATION_NAME_CAPS"].© Access Codes';
$lang['ACCESS_CODES_EMAIL'] =	'<p style="font-face: Arial, Verdana; font-size: small">Below are your access codes for the first login to the online management system ' . $lang["APPLICATION_NAME_CAPS"] . ' ©:</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small">Website: <a href="%1$s">%1$s</a></p>' .
    							'<p style="font-face: Arial, Verdana; font-size: small">Username: %2$s<br />' .
    							'Password: %3$s</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small;">Please login with the provided details. Hereafter, you will be asked to pick your personal access codes. With these new codes you will then gain access to the system in the future (under the same Website address provided above).</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small;">Thank you!</p>';


$lang["CONTACTS_HELP"] = 'manual_contacts_contacts.pdf';
$lang["PCONTACTS_GROUPS_HELP"] = 'manual_contacts_groups.pdf';

$lang["PRINT_GROUP"] = 'group.png';
$lang["PRINT_CONTACT"] = 'contact.png';
?>
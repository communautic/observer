<div id="contacts-action-new" style="display: none"><?php echo $lang["CONTACTS_CONTACTS_ACTION_NEW"];?></div>
<?php
if(is_array($contacts)) {
foreach ($contacts as $contact) {
	echo('<li id="contactItem_'.$contact->id.'"><span rel="'.$contact->id.'" class="module-click"><span class="text">'.$contact->lastname . " " . $contact->firstname.'</span></span></li>');
}
} else {
	echo('<li></li>');
}
?>
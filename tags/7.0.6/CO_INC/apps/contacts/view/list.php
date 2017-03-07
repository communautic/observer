<?php
if(is_array($contacts)) {
foreach ($contacts as $contact) {
	if($contact->lastname == "" && $contact->firstname == "") {
		$contact->lastname = $lang["CONTACTS_CONTACTS_NEW"];
	}
	echo('<li id="contactItem_'.$contact->id.'"><span rel="'.$contact->id.'" class="module-click"><span class="text">'.$contact->lastname . " " . $contact->firstname.'</span>&nbsp;</span></li>');
}
} else {
	echo('<li></li>');
}
?>
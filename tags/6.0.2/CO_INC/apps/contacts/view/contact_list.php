<?php
if(is_array($contacts)) {
foreach ($contacts as $contact) {
	echo('<li id="contactItem_'.$contact->id.'"><a href="#" rel="'.$contact->id.'" class="module-click"><span class="text">'.$contact->lastname . " " . $contact->firstname.'</span></a></li>');
}
} else {
	echo('<li>Es sind noch keine Daten vorhanden</li>');
}
?>
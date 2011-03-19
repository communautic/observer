<?php
if(is_array($meetings)) {
foreach ($meetings as $meeting) {
	echo('<li id="meetingItem_'.$meeting->id.'"><a href="#" rel="'.$meeting->id.'" class="module-click"><span class="module-access-status'.$meeting->accessstatus.'"></span><span class="text">' . $meeting->meeting_date . ' - ' .$meeting->title.'</span><span class="module-item-status'.$meeting->itemstatus.'"></span></a></li>');
}
} else {
	echo('<li></li>');
}
?>
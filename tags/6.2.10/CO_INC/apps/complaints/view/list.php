<?php
if(is_array($complaints)) {
	foreach ($complaints as $complaint) {
		echo('<li id="complaintItem_'.$complaint->id.'"><span rel="'.$complaint->id.'" class="module-click"><span class="text">'.$complaint->title.'</span><span class="module-item-status'.$complaint->itemstatus.'">&nbsp;</span><span class="icon-guest'.$complaint->iconguest.'"></span><span class="icon-checked-out '.$complaint->checked_out_status.'"></span></span></li>');
	}
} else {
	echo('<li></li>');
}
?>
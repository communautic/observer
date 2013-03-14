<?php
if(is_array($trainings)) {
	foreach ($trainings as $training) {
		echo('<li id="trainingItem_'.$training->id.'"><span rel="'.$training->id.'" class="module-click"><span class="text">' .$training->title.'</span><span class="module-item-status'.$training->itemstatus.'">&nbsp;</span><span class="icon-guest'.$training->iconguest.'"></span><span class="icon-checked-out '.$training->checked_out_status.'"></span></span></li>');
	}
} else {
	echo('<li></li>');
}
?>
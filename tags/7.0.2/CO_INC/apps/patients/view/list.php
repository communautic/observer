<?php
if(is_array($patients)) {
	foreach ($patients as $patient) {
		echo('<li id="patientItem_'.$patient->id.'"><span rel="'.$patient->id.'" class="module-click"><span class="text">'.$patient->title.'</span><span class="module-item-status'.$patient->itemstatus.'">&nbsp;</span><span class="icon-guest'.$patient->iconguest.'"></span><span class="icon-checked-out '.$patient->checked_out_status.'"></span></span></li>');
	}
} else {
	echo('<li></li>');
}
?>
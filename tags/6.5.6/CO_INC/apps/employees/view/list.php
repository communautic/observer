<?php
if(is_array($employees)) {
	foreach ($employees as $employee) {
		echo('<li id="employeeItem_'.$employee->id.'"><span rel="'.$employee->id.'" class="module-click"><span class="text">'.$employee->title.'</span><span class="module-item-status'.$employee->itemstatus.'">&nbsp;</span><span class="icon-guest'.$employee->iconguest.'"></span><span class="icon-checked-out '.$employee->checked_out_status.'"></span></span></li>');
	}
} else {
	echo('<li></li>');
}
?>
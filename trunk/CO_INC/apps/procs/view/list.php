<?php
if(is_array($procs)) {
	foreach ($procs as $proc) {
		echo('<li id="procItem_'.$proc->id.'"><span rel="'.$proc->id.'" class="module-click"><span class="text">'.$proc->title.'</span><span class="icon-guest'.$proc->iconguest.'"></span><span class="icon-checked-out '.$proc->checked_out_status.'"></span></span></li>');
	}
} else {
	echo('<li></li>');
}
?>
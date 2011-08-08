<div id="projects_phases-action-new" style="display: none"><?php echo $lang["PROJECT_PHASE_ACTION_NEW"];?></div>
<?php
if(is_array($phases)) {
	$i = 1;
	foreach ($phases as $phase) {
		echo('<li id="phaseItem_'.$phase->id.'"><span rel="'.$phase->id.'" class="module-click"><span class="module-access-status'.$phase->accessstatus.'"></span><span class="phase_num">' . $num[$phase->id] . '</span>. <span class="text">' .$phase->title.'</span><span class="module-item-status'.$phase->itemstatus.'"></span><span class="icon-checked-out '.$phase->checked_out_status.'"></span></span></li>');
	$i++;
	}
} else {
	echo('<li></li>');
} ?>
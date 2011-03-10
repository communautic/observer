<?php
if(is_array($phases)) {
	$i = 1;
	foreach ($phases as $phase) {
		echo('<li id="phaseItem_'.$phase->id.'"><a href="#" rel="'.$phase->id.'" class="module-click"><span class="module-access-status'.$phase->accessstatus.'"></span><span class="phase_num">' . $num[$phase->id] . '</span>. <span class="text">' .$phase->title.'</span><span class="module-item-status'.$phase->itemstatus.'"></span></a></li>');
	$i++;
	}
} else {
	echo('<li></li>');
} ?>
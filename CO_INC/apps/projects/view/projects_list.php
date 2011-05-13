<?php
if(is_array($projects)) {
	foreach ($projects as $project) {
		echo('<li id="projectItem_'.$project->id.'"><span rel="'.$project->id.'" class="module-click"><span class="text">'.$project->title.'</span><span class="module-item-status'.$project->itemstatus.'"></span><span class="icon-guest'.$project->iconguest.'"></span></span></li>');
	}
} else {
	echo('<li></li>');
}
?>
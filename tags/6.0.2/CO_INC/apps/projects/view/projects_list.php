<?php
if(is_array($projects)) {
	foreach ($projects as $project) {
		echo('<li id="projectItem_'.$project->id.'"><a href="#" rel="'.$project->id.'" class="module-click"><span class="text">'.$project->title.'</span><span class="module-item-status'.$project->itemstatus.'"></span></a></li>');
	}
} else {
	echo('<li></li>');
}
?>
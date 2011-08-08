<div id="projects-action-new" style="display: none"><?php echo $lang["PROJECT_ACTION_NEW"];?></div>
<?php
if(is_array($projects)) {
	foreach ($projects as $project) {
		echo('<li id="projectItem_'.$project->id.'"><span rel="'.$project->id.'" class="module-click"><span class="text">'.$project->title.'</span><span class="module-item-status'.$project->itemstatus.'">&nbsp;</span><span class="icon-guest'.$project->iconguest.'"></span><span class="icon-checked-out '.$project->checked_out_status.'"></span></span></li>');
	}
} else {
	echo('<li></li>');
}
?>
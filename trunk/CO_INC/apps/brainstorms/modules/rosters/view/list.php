<div id="brainstorms_rosters-action-new" style="display: none"><?php echo $lang["BRAINSTORM_ROSTER_ACTION_NEW"];?></div>
<?php
if(is_array($rosters)) {
foreach ($rosters as $roster) {
	echo('<li id="rosterItem_'.$roster->id.'"><span rel="'.$roster->id.'" class="module-click"><span class="text">' .$roster->title.'</span><span class="icon-checked-out '.$roster->checked_out_status.'"></span></span></li>');
}
} else {
	echo('<li></li>');
}
?>
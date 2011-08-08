<div id="projects_phonecalls-action-new" style="display: none"><?php echo $lang["PROJECT_PHONECALL_ACTION_NEW"];?></div>
<?php
if(is_array($phonecalls)) {
foreach ($phonecalls as $phonecall) {
	echo('<li id="phonecallItem_'.$phonecall->id.'"><span rel="'.$phonecall->id.'" class="module-click"><span class="module-access-status'.$phonecall->accessstatus.'"></span><span class="text">' . $phonecall->item_date . ' - ' .$phonecall->title.'</span><span class="module-item-status'.$phonecall->itemstatus.'"></span><span class="icon-checked-out '.$phonecall->checked_out_status.'"></span></span></li>');
}
} else {
	echo('<li></li>');
}
?>
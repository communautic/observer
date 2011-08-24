<div id="brainstorms_forums-action-new" style="display: none"><?php echo $lang["BRAINSTORM_FORUM_ACTION_NEW"];?></div>
<?php
if(is_array($forums)) {
	$i = 1;
	foreach ($forums as $forum) {
		echo('<li id="forumItem_'.$forum->id.'"><span rel="'.$forum->id.'" class="module-click"><span class="module-access-status'.$forum->accessstatus.'"></span><span class="text">' .$forum->title.'</span><span class="module-item-status'.$forum->itemstatus.'"></span><span class="icon-checked-out '.$forum->checked_out_status.'"></span></span></li>');
	$i++;
	}
} else {
	echo('<li></li>');
} ?>
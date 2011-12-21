<?php
if(is_array($forums)) {
	foreach ($forums as $forum) {
		echo('<li id="forumItem_'.$forum->id.'"><span rel="'.$forum->id.'" class="module-click"><span class="text">'.$forum->title.'</span><span class="module-item-status'.$forum->itemstatus.'">&nbsp;</span><span class="icon-guest'.$forum->iconguest.'"></span></span></li>');
	}
} else {
	echo('<li></li>');
}
?>
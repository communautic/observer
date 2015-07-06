<?php
if(is_array($forums)) {
foreach ($forums as $forum) {
	echo('<li id="forumItem_'.$forum->id.'"><span rel="'.$forum->id.'" class="module-click"><span class="module-access-status'.$forum->accessstatus.'"></span><span class="text">' .$forum->title.'</span><span class="module-item-status'.$forum->itemstatus.'"></span></span></li>');
}
} else {
	echo('<li></li>');
}
?>
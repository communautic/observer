<?php
if(is_array($comments)) {
foreach ($comments as $comment) {
	echo('<li id="commentItem_'.$comment->id.'"><span rel="'.$comment->id.'" class="module-click"><span class="module-access-status'.$comment->accessstatus.'"></span><span class="text">' . $comment->item_date . ' - ' .$comment->title.'</span><span class="module-item-status'.$comment->itemstatus.'"></span><span class="icon-checked-out '.$comment->checked_out_status.'"></span></span></li>');
}
} else {
	echo('<li></li>');
}
?>
<?php
if(is_array($menues)) {
foreach ($menues as $menue) {
	echo('<li id="menueItem_'.$menue->id.'"><span rel="'.$menue->id.'" class="module-click"><span class="module-access-status'.$menue->accessstatus.'"></span><span class="text">' .$menue->title.'</span><span class="module-item-status'.$menue->itemstatus.'"></span><span class="icon-checked-out '.$menue->checked_out_status.'"></span></span></li>');
}
} else {
	echo('<li></li>');
}
?>
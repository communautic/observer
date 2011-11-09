<?php
if(is_array($publishers)) {
	foreach ($publishers as $publisher) {
		echo('<li id="publisherItem_'.$publisher->id.'"><span rel="'.$publisher->id.'" class="module-click"><span class="text">'.$publisher->title.'</span><span class="module-item-status'.$publisher->itemstatus.'">&nbsp;</span><span class="icon-guest'.$publisher->iconguest.'"></span><span class="icon-checked-out '.$publisher->checked_out_status.'"></span></span></li>');
	}
} else {
	echo('<li></li>');
}
?>
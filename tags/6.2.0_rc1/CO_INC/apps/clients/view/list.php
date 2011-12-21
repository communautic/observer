<?php
if(is_array($clients)) {
	foreach ($clients as $client) {
		echo('<li id="clientItem_'.$client->id.'"><span rel="'.$client->id.'" class="module-click"><span class="text">'.$client->title.'</span><span class="module-item-status'.$client->itemstatus.'">&nbsp;</span><span class="icon-guest'.$client->iconguest.'"></span><span class="icon-checked-out '.$client->checked_out_status.'"></span></span></li>');
	}
} else {
	echo('<li></li>');
}
?>
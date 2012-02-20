<?php
if(is_array($productions)) {
	foreach ($productions as $production) {
		echo('<li id="productionItem_'.$production->id.'"><span rel="'.$production->id.'" class="module-click"><span class="text">'.$production->title.'</span><span class="module-item-status'.$production->itemstatus.'">&nbsp;</span><span class="icon-guest'.$production->iconguest.'"></span><span class="icon-checked-out '.$production->checked_out_status.'"></span></span></li>');
	}
} else {
	echo('<li></li>');
}
?>
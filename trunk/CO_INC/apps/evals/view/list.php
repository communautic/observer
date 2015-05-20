<?php
if(is_array($evals)) {
	foreach ($evals as $eval) {
		echo('<li id="evalItem_'.$eval->id.'"><span rel="'.$eval->id.'" class="module-click"><span class="text">'.$eval->title.'</span><span class="module-item-status'.$eval->itemstatus.'">&nbsp;</span><span class="icon-guest'.$eval->iconguest.'"></span><span class="icon-checked-out '.$eval->checked_out_status.'"></span></span></li>');
	}
} else {
	echo('<li></li>');
}
?>
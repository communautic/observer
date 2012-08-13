<?php
if(is_array($objectives)) {
foreach ($objectives as $objective) {
	echo('<li id="objectiveItem_'.$objective->id.'"><span rel="'.$objective->id.'" class="module-click"><span class="module-access-status'.$objective->accessstatus.'"></span><span class="text">' . $objective->item_date . ' - ' .$objective->title.'</span><span class="module-item-status'.$objective->itemstatus.'"></span><span class="icon-checked-out '.$objective->checked_out_status.'"></span></span></li>');
}
} else {
	echo('<li></li>');
}
?>
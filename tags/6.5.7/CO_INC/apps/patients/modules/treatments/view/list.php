<?php
if(is_array($treatments)) {
foreach ($treatments as $treatment) {
	echo('<li id="treatmentItem_'.$treatment->id.'"><span rel="'.$treatment->id.'" class="module-click"><span class="module-access-status'.$treatment->accessstatus.'"></span><span class="text">' . $treatment->item_date . ' - ' .$treatment->title.'</span><span class="module-item-status'.$treatment->itemstatus.'"></span><span class="icon-checked-out '.$treatment->checked_out_status.'"></span></span></li>');
}
} else {
	echo('<li></li>');
}
?>
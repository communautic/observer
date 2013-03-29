<?php
if(is_array($drawings)) {
foreach ($drawings as $drawing) {
	echo('<li id="drawingItem_'.$drawing->id.'"><span rel="'.$drawing->id.'" class="module-click"><span class="module-access-status'.$drawing->accessstatus.'"></span><span class="text">' . $drawing->title.'</span><span class="module-item-status'.$drawing->itemstatus.'"></span><span class="icon-checked-out '.$drawing->checked_out_status.'"></span></span></li>');
}
} else {
	echo('<li></li>');
}
?>
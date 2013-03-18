<?php
if(is_array($reports)) {
foreach ($reports as $report) {
	echo('<li id="reportItem_'.$report->id.'"><span rel="'.$report->id.'" class="module-click"><span class="module-access-status'.$report->accessstatus.'"></span><span class="text">' . $report->item_date . ' - ' .$report->title.'</span><span class="module-item-status'.$report->itemstatus.'"></span><span class="icon-checked-out '.$report->checked_out_status.'"></span></span></li>');
}
} else {
	echo('<li></li>');
}
?>
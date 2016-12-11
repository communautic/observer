<?php
if(is_array($services)) {
foreach ($services as $service) {
	echo('<li id="serviceItem_'.$service->id.'"><span rel="'.$service->id.'" class="module-click"><span class="module-access-status'.$service->accessstatus.'"></span><span class="text">' .$service->title.'</span><span class="module-item-status'.$service->itemstatus.'"></span><span class="icon-checked-out '.$service->checked_out_status.'"></span></span></li>');
}
} else {
	echo('<li></li>');
}
?>
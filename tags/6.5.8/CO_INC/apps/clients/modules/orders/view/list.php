<?php
if(is_array($orders)) {
foreach ($orders as $order) {
	echo('<li id="orderItem_'.$order->id.'"><span rel="'.$order->id.'" class="module-click"><span class="module-access-status'.$order->accessstatus.'"></span><span class="text">' .$order->title.'</span><span class="module-item-status'.$order->itemstatus.'"></span><span class="icon-checked-out '.$order->checked_out_status.'"></span></span></li>');
}
} else {
	echo('<li></li>');
}
?>
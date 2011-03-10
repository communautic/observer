<?php
if(is_array($controlling)) {
foreach ($controlling as $controlling) {
	echo('<li><span class="module-item-status'.$controlling->itemstatus.'"></span><a href="#" rel="'.$controlling->id.'" class="module-click"><span class="text">' .$controlling->title.'</span></a></li>');
}
} else {
	echo('<li></li>');
}
?>
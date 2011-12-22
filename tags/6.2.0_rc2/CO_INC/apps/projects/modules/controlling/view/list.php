<?php
if(is_array($controlling)) {
foreach ($controlling as $controlling) {
	echo('<li><span rel="'.$controlling->id.'" class="module-click"><span class="text">' .$controlling->title.'</span></span></li>');
}
} else {
	echo('<li></li>');
}
?>
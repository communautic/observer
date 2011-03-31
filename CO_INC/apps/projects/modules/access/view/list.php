<?php
if(is_array($access)) {
	$i = 1;
foreach ($access as $access) {
	echo('<li><span class="module-item-status"></span><span rel="'.$access->id.'" class="module-click"><span class="text">' . $access->lastname . ' ' . $access->firstname . '</span></span></li>');
	$i++;
}
} else {
	echo('<li></li>');
}
?>

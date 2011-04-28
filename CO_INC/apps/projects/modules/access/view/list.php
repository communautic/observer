<?php
if(is_array($access)) {
foreach ($access as $access) {
	echo('<li><span rel="'.$access->id.'" class="module-click"><span class="text">' .$access->title.'</span></span></li>');
}
} else {
	echo('<li></li>');
}
?>
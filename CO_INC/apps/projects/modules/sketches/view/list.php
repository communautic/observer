<?php
if(is_array($sketches)) {
foreach ($sketches as $sketch) {
	echo('<li id="sketchItem_'.$sketch->id.'"><span rel="'.$sketch->id.'" class="module-click"><span class="module-access-status'.$sketch->accessstatus.'"></span><span class="text">' . $sketch->title.'</span><span class="icon-checked-out '.$sketch->checked_out_status.'"></span></span></li>');
}
} else {
	echo('<li></li>');
}
?>
<?php
if(is_array($timelines)) {
foreach ($timelines as $timeline) {	
	echo('<li id="timelineItem_'.$timeline->id.'"><span rel="'.$timeline->id.'" class="module-click"><span class="text">' .constant($timeline->title).'</span></span></li>');
}
} else {
	echo('<li></li>');
}
?>

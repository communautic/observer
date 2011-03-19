<?php
if(is_array($timelines)) {
	//$i = 1;
foreach ($timelines as $timeline) {
	//echo('<li><span class="module-item-status"></span><a href="#" rel="'.$timeline->id.'" class="module-click"><span class="text">' .constant($timeline->title).'</span></a></li>');
	
	echo('<li id="timelineItem_'.$timeline->id.'"><a href="#" rel="'.$timeline->id.'" class="module-click"><span class="text">' .constant($timeline->title).'</span></a></li>');

	//$i++;
}
} else {
	echo('<li></li>');
}
?>

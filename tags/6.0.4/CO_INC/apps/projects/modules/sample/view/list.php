<?php
if(is_array($samples)) {
foreach ($samples as $sample) {
	echo('<li><span class="module-item-status'.$sample->itemstatus.'"></span><a href="#" rel="'.$sample->id.'" class="module-click"><span class="text">' . $sample->sample_date . ' - ' .$sample->title.'</span></a></li>');
}
} else {
	echo('<li></li>');
}
?>
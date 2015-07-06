<?php
if(is_array($feedbacks)) {
foreach ($feedbacks as $feedback) {
	echo('<li id="feedbackItem_'.$feedback->id.'"><span rel="'.$feedback->id.'" class="module-click"><span class="text">' .$feedback->title.'</span></span></li>');
}
} else {
	echo('<li></li>');
}
?>
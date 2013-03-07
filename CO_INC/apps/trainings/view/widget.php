<?php
$message = 1;
if(is_array($kickoffs)) {
	$message = 0;
	foreach ($kickoffs as $kickoff) { ?>
    	<div class="widgetItemOuter trainingsLink" rel="trainings,<?php echo $kickoff->folder . ',' . $kickoff->pid . ',0';?>"><div class="widgetItemTitle"><div class="widgetIconReminder"></div><?php echo $lang["TRAINING_WIDGET_TITLE_KICKOFF"] ;?></div><div class="widgetItemContent">
			<?php echo sprintf($lang["TRAINING_WIDGET_REMINDER_KICKOFF"], $kickoff->title); ?> 
            </div></div>
    <?php
	}
}

if(is_array($starts)) {
	$message = 0;
	foreach ($starts as $start) { ?>
    	<div class="widgetItemOuter trainingsLink" rel="trainings,<?php echo $start->folder . ',' . $start->pid . ',0';?>"><div class="widgetItemTitle"><div class="widgetIconReminder"></div><?php echo $lang["TRAINING_WIDGET_TITLE_START"] ;?></div><div class="widgetItemContent">
			<?php echo sprintf($lang["TRAINING_WIDGET_REMINDER_START"], $start->title); ?> 
            </div></div>
    <?php
	}
}

if($message == 1) {
	echo $lang["TRAINING_WIDGET_NO_ACTIVITY"];
}
?>
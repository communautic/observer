<?php
$message = 1;
if(is_array($reminders)) {
	$message = 0;
	foreach ($reminders as $reminder) { ?>
		<div><div class="widgetItemOuter Read calendarLinkRead" rel="<?php echo $reminder->uid . ',' . $reminder->linkyear . ',' . $reminder->linkmonth . ',' . $reminder->linkday . ',' . $reminder->eventID;?>"><div class="widgetItemTitle"><div class="widgetIconReminder"></div>
    <?php
		echo $lang["CALENDAR_WIDGET_NEW_EVENT_TITLE"] . '</div><div class="widgetItemContent">';
		//echo sprintf($lang["CALENDAR_WIDGET_NEW_EVENT"], $reminder->forumtitle);
		echo sprintf($lang["CALENDAR_WIDGET_NEW_EVENT"], $reminder->startdate, $reminder->starttime, $reminder->summary);
		echo '<br><em>' . $reminder->note . '</em>';
		?>
    	</div></div>
        <div class="widgetItemRead"><span class="calendarInlineRead text11 yellow co-link" rel="<?php echo $reminder->pid;?>"><?php echo $lang["WIDGET_REMOVE_NOTICE"];?></span></div></div>
    <?php
	}
}

if($message == 1) {
	echo $lang["CALENDAR_WIDGET_NO_ACTIVITY"];
}
?>
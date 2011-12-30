<?php
$message = 1;

if(is_array($reminders)) {
	$message = 0;
	foreach ($reminders as $reminder) { ?>
		<div class="widgetItemOuter forumsLinkNewPostRead" rel="forums,<?php echo $reminder->folder . ',' . $reminder->pid . ',0';?>"><div class="widgetItemTitle"><div class="widgetIconReminder"></div>
    <?php
		echo $lang["FORUM_WIDGET_NEW_POST"] . '</div><div class="widgetItemContent">';
		echo sprintf($lang["FROUM_WIDGET_REMINDER_NEW_POST"], $reminder->forumtitle);
		?>
    	</div></div>
    <?php
	}
}


if(is_array($notices)) {
	$message = 0;
	foreach ($notices as $notice) { ?>
		<div class="widgetItemOuter forumsLinkMarkRead" rel="forums,<?php echo $notice->folder . ',' . $notice->pid . ',0';?>"><div class="widgetItemTitle"><div class="widgetIconNotice"></div>
    <?php
		if($notice->perm == 0) {
			echo $lang["BRAINSTORM_WIDGET_TITLE_BRAINSTORM"] . '</div><div class="widgetItemContent">';
			echo sprintf($lang["BRAINSTORM_WIDGET_INVITATION_ADMIN"], $notice->brainstormtitle);
		} else {
			echo $lang["BRAINSTORM_WIDGET_TITLE_BRAINSTORM"] . '</div><div class="widgetItemContent">';
			echo sprintf($lang["BRAINSTORM_WIDGET_INVITATION_GUEST"], $notice->brainstormtitle);
		} ?>
    	</div></div>
    <?php
	}
}

if($message == 1) {
	echo $lang["FORUM_WIDGET_NO_ACTIVITY"];
}
?>
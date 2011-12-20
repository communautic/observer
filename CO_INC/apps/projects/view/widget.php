<?php
$message = 1;
if(is_array($reminders)) {
	$message = 0;
	foreach ($reminders as $reminder) { ?>
		<div class="widgetItemOuter projectsLink" rel="phases,<?php echo $reminder->folder . ',' . $reminder->pid . ',' . $reminder->phaseid;?>"><div class="widgetItemTitle"><div class="widgetIconReminder"></div>
    <?php
		if($reminder->cat == 0) {
			echo $lang["PROJECT_WIDGET_TITLE_TASK"] . '</div><div class="widgetItemContent">';
			echo sprintf($lang["PROJECT_WIDGET_REMINDER_TASK"], $reminder->text, $reminder->projectitle);
		} else {
			echo $lang["PROJECT_WIDGET_TITLE_MILESTONE"] . '</div><div class="widgetItemContent">';
			echo sprintf($lang["PROJECT_WIDGET_REMINDER_MILESTONE"], $reminder->text, $reminder->projectitle);
		}
		?>
    	</div></div>
    <?php
	}
}

if(is_array($kickoffs)) {
	$message = 0;
	foreach ($kickoffs as $kickoff) { ?>
    	<div class="widgetItemOuter projectsLink" rel="projects,<?php echo $kickoff->folder . ',' . $kickoff->pid . ',0';?>"><div class="widgetItemTitle"><div class="widgetIconKickoff"></div><?php echo $lang["PROJECT_WIDGET_TITLE_KICKOFF"] ;?></div><div class="widgetItemContent">
			<?php echo sprintf($lang["PROJECT_WIDGET_REMINDER_KICKOFF"], $kickoff->title); ?> 
            </div></div>
    <?php
	}
}

if(is_array($alerts)) {
	$message = 0;
	foreach ($alerts as $alert) { ?>
		<div class="widgetItemOuter projectsLink" rel="phases,<?php echo $alert->folder . ',' . $alert->pid . ',' . $alert->phaseid;?>"><div class="widgetItemTitle"><div class="widgetIconAlert"></div>
    <?php
		if($alert->cat == 0) {
			echo $lang["PROJECT_WIDGET_TITLE_TASK"] . '</div><div class="widgetItemContent">';
			echo sprintf($lang["PROJECT_WIDGET_ALERT_TASK"], $alert->text, $alert->projectitle);
		} else {
			echo $lang["PROJECT_WIDGET_TITLE_MILESTONE"] . '</div><div class="widgetItemContent">';
			echo sprintf($lang["PROJECT_WIDGET_ALERT_MILESTONE"], $alert->text, $alert->projectitle);
		} ?>
    	</div></div>
    <?php
	}
}

if(is_array($notices)) {
	$message = 0;
	foreach ($notices as $notice) { ?>
		<div class="widgetItemOuter projectsLinkMarkRead" rel="projects,<?php echo $notice->folder . ',' . $notice->pid . ',0';?>"><div class="widgetItemTitle"><div class="widgetIconNotice"></div>
    <?php
		if($notice->perm == 0) {
			echo $lang["PROJECT_WIDGET_TITLE_PROJECT"] . '</div><div class="widgetItemContent">';
			echo sprintf($lang["PROJECT_WIDGET_INVITATION_ADMIN"], $notice->projectitle);
		} else {
			echo $lang["PROJECT_WIDGET_TITLE_PROJECT"] . '</div><div class="widgetItemContent">';
			echo sprintf($lang["PROJECT_WIDGET_INVITATION_GUEST"], $notice->projectitle);
		} ?>
    	</div></div>
    <?php
	}
} 


if($message == 1) {
	echo('Keine aktuellen Benachrichtigungen');
}
?>
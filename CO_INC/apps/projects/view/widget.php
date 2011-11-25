<?php
$message = 1;
if(is_array($reminders)) {
	echo 'Benachrichtigungen:<br />';
	$message = 0;
	foreach ($reminders as $reminder) {
		if($reminder->cat == 0) {
			echo sprintf($lang["PROJECT_WIDGET_REMINDER_TASK"], $reminder->text, $reminder->projectitle );
		} else {
			echo sprintf($lang["PROJECT_WIDGET_REMINDER_MILESTONE"], $reminder->text, $reminder->projectitle);
		}
	}
}

if(is_array($kickoffs)) {
	$message = 0;
	echo 'Kickoff:<br />';
	foreach ($kickoffs as $kickoff) {
			echo sprintf($lang["PROJECT_WIDGET_REMINDER_KICKOFF"], $kickoff->title );
	}
} 

if(is_array($alerts)) {
	$message = 0;
	echo 'Warnungen:<br />';
	foreach ($alerts as $alert) {
		if($alert->cat == 0) {
			echo sprintf($lang["PROJECT_WIDGET_ALERT_TASK"], $alert->text, $alert->projectitle, $alert->folder, $alert->pid, $alert->phaseid);
		} else {
			echo sprintf($lang["PROJECT_WIDGET_ALERT_MILESTONE"], $alert->text, $alert->projectitle, $alert->folder, $alert->pid, $alert->phaseid);
		}
	}
} 

if($message == 1) {
	echo('Keine aktuellen Benachrichtigungen');
}
?>
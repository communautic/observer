<?php
$message = 1;

if(is_array($alerts)) {
	$message = 0;
	foreach ($alerts as $alert) { ?>
		<div class="widgetItemOuter patientsLink" rel="invoices,<?php echo $alert->folder . ',' . $alert->pid . ',' . $alert->id;?>"><div class="widgetItemTitle"><div class="widgetIconAlert"></div>
    <?php
			echo $lang["PATIENT_WIDGET_TITLE"] . '</div><div class="widgetItemContent">';
			echo sprintf($lang["PATIENT_WIDGET_ALERT"], $alert->text, $alert->title);
		?>
    	</div></div>
    <?php
	}
}


if(is_array($waitinglist)) {
	$message = 0;
	foreach ($waitinglist as $wait) { ?>
		<div class="widgetItemOuter patientsLink" rel="patients,<?php echo $wait->folder . ',' . $wait->pid . ',0';?>"><div class="widgetItemTitle"><div class="widgetIconAlert"></div>
    <?php
			echo $lang["PATIENT_WIDGET_TITLE_WAITINGLIST"] . '</div><div class="widgetItemContent">';
			echo sprintf($lang["PATIENT_WIDGET_REMINDER_WAITINGLIST"], $wait->title);
		?>
    	</div></div>
    <?php
	}
}

if(is_array($reminders)) {
	$message = 0;
	foreach ($reminders as $reminder) { ?>
		<div class="widgetItemOuter patientsLink" rel="invoices,<?php echo $reminder->folder . ',' . $reminder->pid . ',' . $reminder->id;?>"><div class="widgetItemTitle"><div class="widgetIconReminder"></div>
    <?php
			echo $lang["PATIENT_WIDGET_TITLE_INVOICE"] . '</div><div class="widgetItemContent">';
			echo sprintf($lang["PATIENT_WIDGET_REMINDER_INVOICE"], $reminder->text, $reminder->title);
		?>
    	</div></div>
    <?php
	}
}



if($message == 1) {
	echo $lang["PATIENT_WIDGET_NO_ACTIVITY"];
}
?>
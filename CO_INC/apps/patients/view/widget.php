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

if($message == 1) {
	echo $lang["PATIENT_WIDGET_NO_ACTIVITY"];
}
?>
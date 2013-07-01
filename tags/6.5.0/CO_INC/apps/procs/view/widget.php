<?php
$message = 1;

if(is_array($notices)) {
	$message = 0;
	foreach ($notices as $notice) { ?>
		<div class="widgetItemOuter procsLinkMarkRead" rel="procs,<?php echo $notice->folder . ',' . $notice->pid . ',0';?>"><div class="widgetItemTitle"><div class="widgetIconNotice"></div>
    <?php
		if($notice->perm == 0) {
			echo $lang["PROC_WIDGET_TITLE_PROC"] . '</div><div class="widgetItemContent">';
			echo sprintf($lang["PROC_WIDGET_INVITATION_ADMIN"], $notice->proctitle);
		} else {
			echo $lang["PROC_WIDGET_TITLE_PROC"] . '</div><div class="widgetItemContent">';
			echo sprintf($lang["PROC_WIDGET_INVITATION_GUEST"], $notice->proctitle);
		} ?>
    	</div></div>
    <?php
	}
}

if($message == 1) {
	echo $lang["PROC_WIDGET_NO_ACTIVITY"];
}
?>
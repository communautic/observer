<?php
$message = 1;

if(is_array($notices)) {
	$message = 0;
	foreach ($notices as $notice) { ?>
		<div class="widgetItemOuter brainstormsLinkMarkRead" rel="brainstorms,<?php echo $notice->folder . ',' . $notice->pid . ',0';?>"><div class="widgetItemTitle"><div class="widgetIconNotice"></div>
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
	echo('Keine aktuellen Benachrichtigungen');
}
?>
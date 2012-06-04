<?php
$message = 1;

if(is_array($checkpoints)) {
	$message = 0;
	foreach ($checkpoints as $checkpoint) { ?>
		<div class="widgetItemOuter checkpointMarkRead" rel="<?php echo $checkpoint->app;?>,<?php echo $checkpoint->folder . ',' . $checkpoint->app_id . ',' . $checkpoint->app_id_app . ',' . $checkpoint->module;?>"><div class="widgetItemTitle"><div class="widgetIconAlert"></div>
    <?php
			echo $checkpoint->checkpoint_app_name . '</div><div class="widgetItemContent">';
			//echo sprintf($lang["PROJECT_WIDGET_INVITATION_ADMIN"], 'Checkpoint Title');
			echo $checkpoint->days . ' - ' . $lang["WIDGET_TEXT_CHECKPOINTS"] . '"' . $checkpoint->title . '"';
		 ?>
    	</div></div>
    <?php
	}
} 


if($message == 1) {
	echo $lang["CHECKPOINTS_WIDGET_NO_ACTIVITY"];
}
?>
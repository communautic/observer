<?php
$message = 1;

if(is_array($checkpoints)) {
	$message = 0;
	foreach ($checkpoints as $checkpoint) { ?>
		<div><div class="widgetItemOuter Read checkpointMarkRead" rel="<?php echo $checkpoint->app;?>,<?php echo $checkpoint->folder . ',' . $checkpoint->app_id . ',' . $checkpoint->app_id_app . ',' . $checkpoint->module;?>"><div class="widgetItemTitle"><div class="widgetIconAlert"></div>
    <?php
			echo $checkpoint->checkpoint_app_name . '</div><div class="widgetItemContent">';
			//echo sprintf($lang["PROJECT_WIDGET_INVITATION_ADMIN"], 'Checkpoint Title');
			echo $checkpoint->days . ': "' . $checkpoint->title . '"';
			echo "<br /><em>" . nl2br($checkpoint->note) . "</em>";
		 ?>
    	</div></div>
        <div class="widgetItemRead"><span class="checkpointInlineMarkRead text11 yellow co-link" rel="<?php echo $checkpoint->app;?>,<?php echo $checkpoint->folder . ',' . $checkpoint->app_id . ',' . $checkpoint->app_id_app . ',' . $checkpoint->module;?>"><?php echo $lang["WIDGET_REMOVE_NOTICE"];?></span></div></div>
    <?php
	}
} 


if($message == 1) {
	echo $lang["CHECKPOINTS_WIDGET_NO_ACTIVITY"];
}
?>
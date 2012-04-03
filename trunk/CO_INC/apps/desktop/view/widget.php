<?php
if(is_array($widgets)) {
	foreach ($widgets as $widget) {
        if(in_array($widget,$userapps) || $widget == 'checkpoints') { 
		?>
        <li class="widget" id="item_<?php echo $widget;?>Widget">
        	<div class="widget-head"><a class="collapse<?php if(${$widget.'_status'} == '1') { echo ' closed'; } ?>" href="#" rel="<?php echo $widget;?>">COLLAPSE</a><h3><?php echo $lang["WIDGET_TITLE_" . strtoupper($widget)];?></h3></div>
        	<div class="widget-content" id="<?php echo $widget;?>WidgetContent"<?php if(${$widget.'_status'} == '1') { echo ' style="display:none;"'; } ?>></div>
        </li>
        <?php } 
	}
}
?>
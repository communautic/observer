<?php
if(is_array($widgets)) {
	foreach ($widgets as $widget) {
        if(in_array($widget,$userapps) || $widget == 'checkpoints' || $widget == 'agenda') { 
		?>
        <li class="widget" id="item_<?php echo $widget;?>Widget">
        	<div class="widget-head"><a class="collapse<?php if(${$widget.'_status'} == '1') { echo ' closed'; } ?>" href="#" rel="<?php echo $widget;?>">COLLAPSE</a><h3><?php echo $lang["WIDGET_TITLE_" . strtoupper($widget)];?></h3></div>
        	<div class="widget-content" id="<?php echo $widget;?>WidgetContent"<?php if(${$widget.'_status'} == '1') { echo ' style="display:none;"'; } ?>><?php if($widget == 'agenda') { ?><div id="agendaHead" class="widgetItemTitle" style="padding: 10px 0px 0 10px"><div id="agendaTime"></div><div id="agendaDay"></div></div><div id="agendaWidget" rel="<?php echo $agenda_calendarid;?>"></div><?php } ?></div>
            
        </li>
        <?php } 
	}
}
?>
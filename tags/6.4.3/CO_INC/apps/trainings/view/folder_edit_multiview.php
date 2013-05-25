
<div style="position: absolute; width: 100%; height: 30px; overflow: hidden">
    <div id="trainingsFoldersSubTabs" class="contentSubTabs" style="position: absolute;">
	<ul>
		<li><span class="left<?php if($view == 'Timeline') { echo ' active';}?>" rel="Timeline">Zeitraum</span></li>
		<li><span class="<?php if($view == 'Management') { echo ' active';}?>" rel="Management">TrainerIn</span></li>
        <li><span class="right<?php if($view == 'Status') { echo ' active';}?>" rel="Status">Status</span></li>
	</ul>
</div>
   <div style="position: absolute; left: 225px; top: 2px;">
<table border="0" cellspacing="0" cellpadding="0" class="timeline-legend">
    <tr>
        <td class="barchart_color_planned"><span><?php echo $lang["GLOBAL_STATUS_PLANNED"];?></span></td>
        <td width="10"></td>
        <td class="barchart_color_inprogress"><span><?php echo $lang["GLOBAL_STATUS_INACTION"];?></span></td>
         <td width="10"></td>
        <td class="barchart_color_finished"><span><?php echo $lang["GLOBAL_STATUS_FINISHED2"];?></span></td>
         <td width="10"></td>
        <td class="barchart_color_not_finished"><span><?php echo $lang["GLOBAL_STATUS_CANCELLED"];?></span></td>
    </tr>
</table></div>
</div>
<div style="position: absolute; top: 77px; bottom: 0; left: 0; right: 0px; overflow: hidden; ">
<div id="leftBlind" style="z-index: 8; position: absolute; top: 0px; width: 225px; height: 37px; background-color:#FFF; ">
<div id="barchart-zoom">
    <p><span class="loadBarchartZoom <?php echo($folder->zoom_xsmall);?>" rel="5"></span>
        <span class="loadBarchartZoom <?php echo($folder->zoom_small);?>" rel="11"></span>
        <span class="loadBarchartZoom <?php echo($folder->zoom_medium);?>" rel="17"></span>
        <span class="loadBarchartZoom <?php echo($folder->zoom_large);?>" rel="23"></span>
        <span class="loadBarchartZoom <?php echo($folder->zoom_xlarge);?>" rel="29"></span>
    </p>
</div>
</div>
<div class="scroll-pane" id="barchartScroll">
<div  class="barchart-outer" style="position: relative; font-size: 11px; width: <?php echo($folder->css_width+225);?>px; height:<?php echo($folder->css_height+58);?>px">
    <div id="barchart-container-left" style="position: absolute; z-index: 7; width: 220px; padding-top: 37px; background-color:#FFF; height:<?php echo($folder->css_height+20);?>px">
        <div style="position: relative; padding-left: 10px; height: 16px; margin: 0 10px 2px 0;"><?php echo $lang['TRAINING_TIMELINE_ACTION'];?>
            <div style="text-align: center; position: absolute; width: 45px; padding: 1px 5px 0 0; top: 0; right: 0; height: 16px;"><?php echo $lang['TRAINING_TIMELINE_TIME'];?></div>
        </div>
        <?php 
		foreach($trainings as $training){ ?>
		<div style="position: relative; height: 36px; margin: 0 10px 2px 0;">
        	<div style="position: absolute; padding-left: 10px; height: 16px; width: 150px; overflow: hidden; line-height: 16px; background-color: #e5e5e5;"><a class="but-scroll-to" t="<?php echo $training->css_top;?>" l="<?php echo $training->css_left;?>"><?php echo($training->title);?></a></div>
            <div style="text-align: right; position: absolute; width: 38px; padding: 0 10px 0 0; top: 0; right: 0; height: 16px; background-color: #e5e5e5;"><?php echo($training->days);?></div>
            
            <div style="position: absolute; top: 19px; padding-left: 10px; height: 16px; width: 100px; overflow: hidden; line-height: 16px; font-size: 9px; color: #666;"><a class="but-scroll-to" t="<?php echo $training->css_top;?>" l="<?php echo $training->css_left;?>"><?php echo($training->startdate);?>-<?php echo($training->enddate);?></a></div>
            <div style="text-align: right; position: absolute; top: 19px; width: 88px; padding: 1px 10px 0 0; right: 0; height: 16px; border-left: 2px solid #fff; font-size: 9px; color: #666;"><?php echo($training->name);?></div>
        </div>
      <?php 
	 } ?>
    </div>

    <div id="barchart-container-right" style="margin-left: 225px; width: <?php echo($folder->css_width);?>px;">
        <div id="barchart-container" style="position: relative; padding-top: 50px;">
            <div id="barchartTimeline" style="height: 13px; padding-top: 37px; position: absolute; z-index: 5; top: 0; background-color:#FFF">
                <?php
	$day = $folder->startdate;
	$today = $date->formatDate("now","Y-m-d");
	//loop through all days and generate date row
	if($folder->days < 20) {
		//$training["days"] = 20;
	}
	for ($i = 0; $i <= $folder->days; $i++) {
		$yo = $this->model->barchartCalendar($day,$i);
		$week = "";
		$month = "";
		$now = "";
		$bg = "#b2b2b2";
		if($yo["week"] != "") {
			$week = '<div style="position: absolute; top: -15px; width: 45px; color: #000; text-align: left;">KW ' . $yo["week"] . '</div>';
		}
		if($yo["month"] != "") {
			$month = '<div style="position: absolute; top: -30px; width: 45px; color: #000; text-align: left;">' . $yo["month"] . '</div>';
		}
		if($day == $today) {
			$bg = "#a0a0a0";
			$yo["color"] = "#ffd20a";
			$now = '<div id="todayBar" style="position: absolute; top: 13px; width: ' . $folder->td_width . 'px; height: ' . ($folder->css_height+8) . 'px; background-color: #e5e5e5; z-index: 1;"></div>';
		}
		if($folder->td_width < 17) {
			$yo["number"] = "";
		}
		?>
                <div id="d<?php echo($i);?>" style="position: relative; background-color: <?php echo($bg);?>; width: <?php echo($folder->td_width);?>px; height: 13px; float: left; font-size: 10px; color: <?php echo($yo["color"]);?>; text-align:center"><?php echo $now . $month . $week . $yo["number"];?></div>
                <?php
		$day = $date->addDays($day,1);
	}
	?>
            </div>
            <!-- drawing area outer -->
            <div style="position: relative; background-image:url(<?php echo($folder->bg_image);?>); background-position: <?php echo($folder->bg_image_shift);?>px 0px; width: <?php echo($folder->css_width);?>px; height:<?php echo($folder->css_height+8);?>px;">

                <!-- training loop -->
                <?php foreach($trainings as $training){  ?>
                <div class="coTooltip loadTraining <?php echo($training->status);?>" rel="<?php echo($training->id);?>" style="z-index: 5; position: absolute; top: <?php echo($training->css_top);?>px; left: <?php echo($training->css_left);?>px; height: 20px; width: <?php echo($training->css_width);?>px;"><span style="display: block; padding: 2px 0 0 5px;"><?php //echo($training->realisation["real"]);?></span>
                <div class="coTooltipHtml" style="display: none">
					<?php echo $training->title;?><br />
                    <?php echo $training->dates_display;?>
					
				</div>
                </div>
                <?php 
				} ?>
            </div>
        </div>
    </div>
</div>
</div>
</div>
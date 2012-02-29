<div class="table-title-outer">
<table border="0" cellspacing="0" cellpadding="0" class="table-title grey">
  <tr>
    <td class="tcell-left text11"><span class="content-nav-title"><?php echo $lang["PRODUCTION_TIMELINE_PRODUCTION_PLAN"];?></span></td>
    <td>
    <table border="0" cellspacing="0" cellpadding="0" class="timeline-legend">
    <tr>
        <td class="barchart_color_planned"><span><?php echo $lang["PRODUCTION_TIMELINE_STATUS_PLANED"];?></span></td>
        <td width="15"></td>
        <td class="barchart_color_inprogress"><span><?php echo $lang["PRODUCTION_TIMELINE_STATUS_INPROGRESS"];?></span></td>
         <td width="15"></td>
        <td class="barchart_color_finished"><span><?php echo $lang["PRODUCTION_TIMELINE_STATUS_FINISHED"];?></span></td>
         <td width="15"></td>
        <td class="barchart_color_not_finished"><span><?php echo $lang["PRODUCTION_TIMELINE_STATUS_NOT_FINISHED"];?></span></td>
         <td width="15"></td>
        <td class="barchart_color_overdue"><span><?php echo $lang["PRODUCTION_TIMELINE_STATUS_OVERDUE"];?></span></td>
    </tr>
</table></td>
  </tr>
</table>
</div>
<div class="ui-layout-content">
<div id="leftBlind" style="z-index: 6; position: absolute; top: 0; width: 225px; height: 37px; background-color:#FFF; ">
<div id="barchart-zoom">
<span class="loadBarchartZoom <?php echo($production["zoom-xsmall"]);?>" rel="5"></span>
<span class="loadBarchartZoom <?php echo($production["zoom-small"]);?>" rel="11"></span>
<span class="loadBarchartZoom <?php echo($production["zoom-medium"]);?>" rel="17"></span>
<span class="loadBarchartZoom <?php echo($production["zoom-large"]);?>" rel="23"></span>
<span class="loadBarchartZoom <?php echo($production["zoom-xlarge"]);?>" rel="29"></span>
</div>
<!--<div id="slider" style="margin-left: 10px; width: 120px;"></div>-->

</div>
<div class="scroll-pane" id="barchartScroll">
<div  class="barchart-outer" style="position: relative; font-size: 11px; width: <?php echo($production["css_width"]+225);?>px; height:<?php echo($production["css_height"]+50);?>px">
	
    <div id="barchart-container-left" style="position: absolute; z-index: 5; width: 225px; padding-top: 37px; background-color:#FFF; height:<?php echo($production["css_height"]-5+16);?>px">
	<div style="position: relative; padding-left: 10px; height: 16px; margin: 0 15px 2px 0;"><?php echo $lang['PRODUCTION_TIMELINE_ACTION'];?>
    <div style="text-align: center; position: absolute; width: 45px; padding: 1px 5px 0 0; top: 0; right: 0; height: 16px;"><?php echo $lang['PRODUCTION_TIMELINE_TIME'];?></div></div>

	<div style="position: relative; padding-left: 10px; height: 16px; margin: 0 15px 2px 0; background-color:#e5e5e5"><a class="but-scroll-to" t="0" l="0"><?php echo $lang['PRODUCTION_KICKOFF'];?></a>
    <div style="text-align: right; position: absolute; width: 38px; padding: 1px 10px 0 0; top: 0; right: 0; height: 16px; border-left: 2px solid #fff;">1</div></div>

<?php 
$i = 1;
foreach($production["phases"] as $key => &$value){ ?>
<div style="position: relative; padding-left: 10px; height: 16px; margin: 0 15px 2px 0; background-color: #b2b2b2;"><div style="position: absolute; height: 16px; width: 145px; overflow: hidden; line-height: 16px;"><a class="but-scroll-to" t="<?php echo($production["phases"][$key]["css_top"]);?>" l="<?php echo($production["phases"][$key]["css_left"]);?>"><?php echo($i . ". " . $production["phases"][$key]["title"]);?></a></div><div style="text-align: right; position: absolute; width: 38px; padding: 1px 10px 0 0; top: 0; right: 0; height: 16px; border-left: 2px solid #fff;"><?php echo($production["phases"][$key]["days"]);?></div></div>
      
      <?php foreach($production["phases"][$key]["tasks"] as $tkey => &$tvalue){ ?>
      
      <div style="position: relative; padding: 0 50px 0 25px; height: 16px; margin: 0 15px 2px 0; background-color:#e5e5e5">
	  	<div style="height: 16px; overflow: hidden; line-height: 16px;"><a class="but-scroll-to" t="<?php echo($production["phases"][$key]["css_top"]+$production["phases"][$key]["tasks"][$tkey]["css_top"]);?>" l="<?php echo($production["phases"][$key]["css_left"]+$production["phases"][$key]["tasks"][$tkey]["css_left"]);?>"><?php echo($production["phases"][$key]["tasks"][$tkey]["text"]);?></a></div>
        <div style="text-align: right; position: absolute; width: 38px; padding: 1px 10px 0 0; top: 0; right: 0; height: 16px; border-left: 2px solid #fff;"><?php echo($production["phases"][$key]["tasks"][$tkey]["days"]);?></div>
      </div>

     <?php } 
	 $i++;
	 } ?>
</div>
<div id="barchart-container-right" style="margin-left: 225px; width: <?php echo($production["css_width"]);?>px;">
    
    
    <div id="barchart-container" style="position: relative; padding-top: 50px;">
        
        <div id="barchartTimeline" style="height: 13px; padding-top: 37px; position: absolute; z-index: 4; top: 0; background-color:#FFF">
	<?php
	$day = $production["startdate"];
	$today = $date->formatDate("now","Y-m-d");
	//loop through all days and generate date row
	if($production["days"] < 20) {
		//$production["days"] = 20;
	}
	for ($i = 0; $i <= $production["days"]; $i++) {
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
			$now = '<div id="todayBar" style="position: absolute; top: 13px; width: ' . $production["td_width"] . 'px; height: ' . $production["css_height"] . 'px; background-color: #e5e5e5; z-index: 1;"></div>';
		}
		if($production["td_width"] < 17) {
			$yo["number"] = "";
		}
		?>
        <div id="d<?php echo($i);?>" style="position: relative; background-color: <?php echo($bg);?>; width: <?php echo($production["td_width"]);?>px; height: 13px; float: left; font-size: 10px; color: <?php echo($yo["color"]);?>; text-align:center"><?php echo $now . $month . $week . $yo["number"];?></div>
        <?php
		$day = $date->addDays($day,1);
	}
	?>
</div>
    <!-- drawing area outer -->
    <div style="position: relative; background-image:url(<?php echo($production["bg_image"]);?>); background-position: <?php echo($production["bg_image_shift"]);?>px 0px; width: <?php echo($production["css_width"]);?>px; height:<?php echo($production["css_height"]);?>px;">
			<!-- kick off -->
            <div class="coTooltip loadProduction" rel="<?php echo($pid);?>" style="z-index: 2; background-color: #B2B2B2; position: absolute; top: 8px; left: 0; height: 10px; width: <?php echo($production["td_width"]);?>px;">
            	<div class="coTooltipHtml" style="display: none">
					Kick off<br />
					<?php echo($production["startdate_view"]);?>
				</div>
            </div>

            <!-- phase loop -->
			<?php 
			$i = 1;
			foreach($production["phases"] as $key => &$value){ ?>
            <!-- outer phase container for opacyti bg -->
            	<div class="coTooltip barchart-phase-bg loadProductionsPhase <?php echo($production["phases"][$key]["status"]);?>" rel="<?php echo($production["phases"][$key]["id"]);?>" style="z-index: 1; position: absolute; top: <?php echo($production["phases"][$key]["css_top"]);?>px; left: <?php echo($production["phases"][$key]["css_left"]);?>px; height: <?php echo($production["phases"][$key]["css_height"]);?>px; width: <?php echo($production["phases"][$key]["css_width"]);?>px;">
                
                <!-- phase tooltip -->
				<div class="coTooltipHtml" style="display: none">
					<?php echo($i . ". " . $production["phases"][$key]["title"]);?><br />
                    <?php echo($production["phases"][$key]["startdate"]);?> - <?php echo($production["phases"][$key]["enddate"]);?>
                
                </div>
                </div>
            
            <!-- phase -->
			<div class="" style="position: absolute; top: <?php echo($production["phases"][$key]["css_top"]);?>px; left: <?php echo($production["phases"][$key]["css_left"]);?>px; height: <?php echo($production["phases"][$key]["css_height"]);?>px; width: <?php echo($production["phases"][$key]["css_width"]);?>px;">
         
            	<?php foreach($production["phases"][$key]["tasks"] as $tkey => &$tvalue){ 
				// task
				if($production["phases"][$key]["tasks"][$tkey]["cat"] == 0) {
				?>
                <!-- task -->
                <div id="task_<?php echo($production["phases"][$key]["tasks"][$tkey]["id"]);?>" class="coTooltip loadProductionsPhase <?php echo($production["phases"][$key]["tasks"][$tkey]["status"]);?>" rel="<?php echo($production["phases"][$key]["id"]);?>" style="z-index: 2; position: absolute; top: <?php echo($production["phases"][$key]["tasks"][$tkey]["css_top"]);?>px; left: <?php echo($production["phases"][$key]["tasks"][$tkey]["css_left"]);?>px; height: 10px; width: <?php echo($production["phases"][$key]["tasks"][$tkey]["css_width"]);?>px;">
                	<!-- task tooltip -->
            		<div class="coTooltipHtml" style="display: none">
						<?php echo($production["phases"][$key]["tasks"][$tkey]["text"]);?><br />
                        <?php echo($production["phases"][$key]["tasks"][$tkey]["startdate"]);?> - <?php echo($production["phases"][$key]["tasks"][$tkey]["enddate"]);?>
					</div>
                </div>
                <!-- task dependency -->
				<?php 
				if(is_int($production["phases"][$key]["tasks"][$tkey]["dep"])){ 
					$dep_key = $production["phases"][$key]["tasks"][$tkey]["dep"];
					$dep_phase_key = $production["phases"][$key]["tasks"][$tkey]["dep_key"];
					if($key != $dep_phase_key) {
						$dep_top = -$production["phases"][$dep_phase_key]["css_height"]-2+$production["tasks"][$dep_key]["css_top"];
						$dep_height = $production["phases"][$dep_phase_key]["tasks"][$tkey]["css_top"] - $dep_top -4;
						if($key-1 != $dep_phase_key) {
							for($i=$dep_phase_key+1; $i < $key; $i++) {
								$dep_height += $production["phases"][$i]["css_height"]+2;
								$dep_top -= $production["phases"][$i]["css_height"]+2;
							}
						}
						$dep_left = $production["phases"][$dep_phase_key]["css_left"]+$production["tasks"][$dep_key]["css_left"]+$production["tasks"][$dep_key]["css_width"]-$production["phases"][$key]["css_left"];
						$dep_width = ($production["phases"][$key]["css_left"] + $production["phases"][$key]["tasks"][$tkey]["css_left"]) - ($production["phases"][$dep_phase_key]["css_left"]+$production["tasks"][$dep_key]["css_left"]+$production["tasks"][$dep_key]["css_width"]);
					} else {
						$dep_top = $production["tasks"][$dep_key]["css_top"];
						$dep_height = $production["phases"][$dep_phase_key]["tasks"][$tkey]["css_top"] - $dep_top -6;
						$dep_left = $production["tasks"][$dep_key]["css_left"]+$production["tasks"][$dep_key]["css_width"];
						$dep_width = $production["phases"][$key]["tasks"][$tkey]["css_left"]-$production["tasks"][$dep_key]["css_width"]-$production["tasks"][$dep_key]["css_left"];
					}
				?>
                <div class="barchart-dependency" style="z-index: 2; position: absolute; top: <?php echo($dep_top);?>px; left: <?php echo($dep_left);?>px; height: <?php echo($dep_height);?>px; width: <?php echo($dep_width);?>px;"><div class="barchart-arrow"></div></div>
            	<?php } ?>
            	<!-- task dependency -->
                <?php if(!empty($production["phases"][$key]["tasks"][$tkey]["overdue"])){ ?>
                <div class="barchart_color_overdue coTooltip" style="z-index: 2; position: absolute; top: <?php echo($production["phases"][$key]["tasks"][$tkey]["css_top"]);?>px; left: <?php echo($production["phases"][$key]["tasks"][$tkey]["overdue"]["left"]);?>px; height: 10px; width: <?php echo($production["phases"][$key]["tasks"][$tkey]["overdue"]["width"]);?>px;" title="<?php echo($production["phases"][$key]["tasks"][$tkey]["overdue"]["days"]);?>">
                <div class="coTooltipHtml" style="display: none">
						<?php echo($production["phases"][$key]["tasks"][$tkey]["text"]);?><br />
                        <?php echo($production["phases"][$key]["tasks"][$tkey]["startdate"]);?> - <?php echo($production["phases"][$key]["tasks"][$tkey]["enddate"]);?><br />
						<?php echo($production["phases"][$key]["tasks"][$tkey]["overdue"]["days"] . " " . $lang["PRODUCTION_TIMELINE_STATUS_OVERDUE_POPUP"]);?>
                    </div>
                </div>
                <?php } ?>
                
                <?php } else { ?>
                <!-- milestone -->
                <div id="task_<?php echo($production["phases"][$key]["tasks"][$tkey]["id"]);?>" class="coTooltip loadProductionsPhase" rel="<?php echo($production["phases"][$key]["id"]);?>" style="z-index: 3; position: absolute; top: <?php echo($production["phases"][$key]["tasks"][$tkey]["css_top"]);?>px; left: <?php echo($production["phases"][$key]["tasks"][$tkey]["css_left"]+ $production["td_width"] - 5);?>px; height: 10px; width: <?php echo($production["phases"][$key]["tasks"][$tkey]["css_width"]);?>px;"><span class="icon-milestone"></span>
                	<!-- task tooltip -->
            		<div class="coTooltipHtml" style="display: none">
						<?php echo($production["phases"][$key]["tasks"][$tkey]["text"]);?><br />
                        <?php echo($production["phases"][$key]["tasks"][$tkey]["startdate"]);?> - <?php echo($production["phases"][$key]["tasks"][$tkey]["enddate"]);?><br />
					</div>
                </div>
                <!-- milestone dependency -->
				<?php 
				if(is_int($production["phases"][$key]["tasks"][$tkey]["dep"])){ 
					$dep_key = $production["phases"][$key]["tasks"][$tkey]["dep"];
					$dep_phase_key = $production["phases"][$key]["tasks"][$tkey]["dep_key"];
					if($key != $dep_phase_key) {
						$dep_top = -$production["phases"][$dep_phase_key]["css_height"]-2+$production["tasks"][$dep_key]["css_top"];
						$dep_height = $production["phases"][$dep_phase_key]["tasks"][$tkey]["css_top"] - $dep_top -6;
						if($key-1 != $dep_phase_key) {
							for($i=$dep_phase_key+1; $i < $key; $i++) {
								$dep_height += $production["phases"][$i]["css_height"]+2;
								$dep_top -= $production["phases"][$i]["css_height"]+2;
							}
						}
						$dep_left = $production["phases"][$dep_phase_key]["css_left"]+$production["tasks"][$dep_key]["css_left"]+$production["tasks"][$dep_key]["css_width"]-$production["phases"][$key]["css_left"];
						$dep_width = ($production["phases"][$key]["css_left"] + $production["phases"][$key]["tasks"][$tkey]["css_left"]) +$production["td_width"] - ($production["phases"][$dep_phase_key]["css_left"]+$production["tasks"][$dep_key]["css_left"]+$production["tasks"][$dep_key]["css_width"]);
						
					} else {
						$dep_top = $production["tasks"][$dep_key]["css_top"];
						$dep_height = $production["phases"][$dep_phase_key]["tasks"][$tkey]["css_top"] - $dep_top -6;
						$dep_left = $production["tasks"][$dep_key]["css_left"]+$production["tasks"][$dep_key]["css_width"];
						$dep_width = $production["phases"][$key]["tasks"][$tkey]["css_left"]-$production["tasks"][$dep_key]["css_width"]-$production["tasks"][$dep_key]["css_left"]+$production["td_width"];		
					}
				?>
                <div class="barchart-dependency" style="z-index: 2; position: absolute; top: <?php echo($dep_top);?>px; left: <?php echo($dep_left);?>px; height: <?php echo($dep_height);?>px; width: <?php echo($dep_width);?>px;"><div class="barchart-arrow"></div></div>
            	<?php } ?>
            	<!-- milestonedependency -->
                <?php } ?>
                
            	<?php } ?>
            </div>
			<?php if(!empty($production["phases"][$key]["overdue"])){ ?>
			<div class="barchart_color_overdue barchart-phase-bg coTooltip" style="position: absolute; top: <?php echo($production["phases"][$key]["css_top"]);?>px; left: <?php echo($production["phases"][$key]["overdue"]["left"]);?>px; height: <?php echo($production["phases"][$key]["css_height"]);?>px; width: <?php echo($production["phases"][$key]["overdue"]["width"]);?>px;" title="<?php echo($production["phases"][$key]["overdue"]["days"]);?>">
            <div class="coTooltipHtml" style="display: none">
					<?php echo($i . ". " . $production["phases"][$key]["title"]);?><br />
                    <?php echo($production["phases"][$key]["startdate"]);?> - <?php echo($production["phases"][$key]["enddate"]);?><br />
					<?php echo($production["phases"][$key]["overdue"]["days"] . " " . $lang["PRODUCTION_TIMELINE_STATUS_OVERDUE_POPUP"]);?>
                
                </div>
            
            </div>
            <?php } 
			$i++;
			 } ?>
  </div>
</div>
</div>
</div>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo($lang["GLOBAL_FOOTER_STATUS"] . " " . $production["datetime"]);?></td>
    <td class="middle"></td>
    <td class="right"></td>
  </tr>
</table>
</div>
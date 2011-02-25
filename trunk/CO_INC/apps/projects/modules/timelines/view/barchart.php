<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-title grey">
  <tr>
    <td class="tcell-left text11"><span class="content-nav">Balkenplan</span></td>
    <td>
    <table border="0" cellspacing="0" cellpadding="0" class="timeline-legend">
    <tr>
        <td class="barchart_color_planned"><span><?php echo TIMELINE_STATUS_PLANED;?></span></td>
        <td width="15"></td>
        <td class="barchart_color_inprogress"><span><?php echo TIMELINE_STATUS_INPROGRESS;?></span></td>
         <td width="15"></td>
        <td class="barchart_color_finished"><span><?php echo TIMELINE_STATUS_FINISHED;?></span></td>
         <td width="15"></td>
        <td class="barchart_color_not_finished"><span><?php echo TIMELINE_STATUS_NOT_FINISHED;?></span></td>
         <td width="15"></td>
        <td class="barchart_color_overdue"><span><?php echo TIMELINE_STATUS_OVERDUE;?></span></td>
    </tr>
</table></td>
  </tr>
</table>
</div>
<div class="ui-layout-content barchart-scroll">

<div  class="barchart-outer" style="font-size: 11px; width: <?php echo($project["css_width"]+225);?>px; height:<?php echo($project["css_height"]+50);?>px">
  	<div id="barchart-container-left" style="position: absolute; z-index: 4; width: 225px; padding-top: 55px; background-color:#FFF; height:<?php echo($project["css_height"]-5);?>px">

<div style="position: relative; padding-left: 10px; height: 16px; margin: 0 15px 2px 0; background-color:#e5e5e5"><a href="#" class="but-scroll-to">Kick off</a>
    <div style="text-align: right; position: absolute; width: 38px; padding: 1px 10px 0 0; top: 0; right: 0; height: 16px; border-left: 2px solid #fff;">1</div></div>

<?php 
$i = 1;
foreach($project["phases"] as $key => &$value){ ?>
<div style="position: relative; padding-left: 10px; height: 16px; margin: 0 15px 2px 0; background-color:#e5e5e5"><div style="position: absolute; height: 16px; width: 145px; overflow: hidden"><a href="#" class="but-scroll-to" t="<?php echo($project["phases"][$key]["css_top"]);?>" l="<?php echo($project["phases"][$key]["css_left"]);?>"><?php echo($i . ". " . $project["phases"][$key]["title"]);?></a></div><div style="text-align: right; position: absolute; width: 38px; padding: 1px 10px 0 0; top: 0; right: 0; height: 16px; border-left: 2px solid #fff;"><?php echo($project["phases"][$key]["days"]);?></div></div>
      
      <?php foreach($project["phases"][$key]["tasks"] as $tkey => &$tvalue){ ?>
      
      <div style="position: relative; padding: 0 50px 0 25px; height: 16px; margin: 0 15px 2px 0; background-color:#e5e5e5">
	  	<a href="#" class="but-scroll-to" t="<?php echo($project["phases"][$key]["css_top"]);?>" l="<?php echo($project["phases"][$key]["css_left"]);?>"><?php echo($project["phases"][$key]["tasks"][$tkey]["text"]);?></a><div style="text-align: right; position: absolute; width: 38px; padding: 1px 10px 0 0; top: 0; right: 0; height: 16px; border-left: 2px solid #fff;"><?php echo($project["phases"][$key]["tasks"][$tkey]["days"]);?></div>
      </div>

     <?php } 
	 $i++;
	 } ?>
</div>
<div id="barchart-container-right" style="margin-left: 225px; width: <?php echo($project["css_width"]);?>px;">
    
    
    <div id="barchart-container">
        
        <div style="height: 13px; padding-top: 37px;">
	<?php
	$day = $project["startdate"];
	$today = $date->formatDate("now","Y-m-d");
	//loop through all days and generate date row
	if($project["days"] < 20) {
		//$project["days"] = 20;
	}
	for ($i = 0; $i <= $project["days"]; $i++) {
		$yo = $this->model->barchartCalendar($day,$i);
		$week = "";
		$month = "";
		$now = "";
		$bg = "#b2b2b2";
		if($yo["week"] != "") {
			$week = '<div style="position: absolute; top: -20px; width: 45px; color: #000;">KW ' . $yo["week"] . '</div>';
		}
		if($yo["month"] != "") {
			$month = '<div style="position: absolute; top: -40px; width: 45px; color: #000;">' . $yo["month"] . '</div>';
		}
		if($day == $today) {
			$bg = "#a0a0a0";
			$yo["color"] = "#ffd20a";
			$now = '<div style="position: absolute; top: 13px; width: 23px; height: ' . $project["css_height"] . 'px; background-color: #e5e5e5; z-index: 1;"></div>';
		}
		?>
        <div id="d<?php echo($i);?>" style="position: relative; background-color: <?php echo($bg);?>; width: <?php echo($project["td_width"]);?>px; height: 13px; float: left; font-size: 10px; color: <?php echo($yo["color"]);?>; text-align:center"><?php echo $now . $month . $week . $yo["number"];?></div>
        <?php
		$day = $date->addDays($day,1);
	}
	?>
</div>
    <!-- drawing area outer -->
    <div style="position: relative; background-image:url(<?php echo($project["bg_image"]);?>); background-position: <?php echo($project["bg_image_shift"]);?>px 0px; width: <?php echo($project["css_width"]);?>px; height:<?php echo($project["css_height"]);?>px;">
			<!-- kick off -->
            <div class="coTooltip" style="z-index: 2; background-color: #B2B2B2; position: absolute; top: 8px; left: 1px; height: 10px; width: 22px;">
            	<div class="coTooltipHtml" style="display: none">
					Kick off<br />
					<?php echo($project["startdate_view"]);?>
				</div>
            </div>

            <!-- phase loop -->
			<?php 
			$i = 1;
			foreach($project["phases"] as $key => &$value){ ?>
            <!-- outer phase container for opacyti bg -->
            	<div class="coTooltip barchart-phase-bg loadPhase <?php echo($project["phases"][$key]["status"]);?>" rel="<?php echo($project["phases"][$key]["id"]);?>" style="z-index: 1; position: absolute; top: <?php echo($project["phases"][$key]["css_top"]);?>px; left: <?php echo($project["phases"][$key]["css_left"]);?>px; height: <?php echo($project["phases"][$key]["css_height"]);?>px; width: <?php echo($project["phases"][$key]["css_width"]);?>px;">
                
                <!-- phase tooltip -->
				<div class="coTooltipHtml" style="display: none">
					<?php echo($i . ". " . $project["phases"][$key]["title"]);?><br />
                    <?php echo($project["phases"][$key]["startdate"]);?> - <?php echo($project["phases"][$key]["enddate"]);?>
                
                </div>
                </div>
            
            <!-- phase -->
			<div class="" style="position: absolute; top: <?php echo($project["phases"][$key]["css_top"]);?>px; left: <?php echo($project["phases"][$key]["css_left"]);?>px; height: <?php echo($project["phases"][$key]["css_height"]);?>px; width: <?php echo($project["phases"][$key]["css_width"]);?>px;">
         
            	<?php foreach($project["phases"][$key]["tasks"] as $tkey => &$tvalue){ 
				// task
				if($project["phases"][$key]["tasks"][$tkey]["cat"] == 0) {
				?>
                <!-- task -->
                <div id="task_<?php echo($project["phases"][$key]["tasks"][$tkey]["id"]);?>" class="coTooltip loadPhase <?php echo($project["phases"][$key]["tasks"][$tkey]["status"]);?>" rel="<?php echo($project["phases"][$key]["id"]);?>" style="z-index: 2; position: absolute; top: <?php echo($project["phases"][$key]["tasks"][$tkey]["css_top"]);?>px; left: <?php echo($project["phases"][$key]["tasks"][$tkey]["css_left"]);?>px; height: 10px; width: <?php echo($project["phases"][$key]["tasks"][$tkey]["css_width"]);?>px;">
                	<!-- task tooltip -->
            		<div class="coTooltipHtml" style="display: none">
						<?php echo($project["phases"][$key]["tasks"][$tkey]["text"]);?><br />
                        <?php echo($project["phases"][$key]["tasks"][$tkey]["startdate"]);?> - <?php echo($project["phases"][$key]["tasks"][$tkey]["enddate"]);?>
					</div>
                </div>
                <!-- task dependency -->
				<?php 
				if(is_int($project["phases"][$key]["tasks"][$tkey]["dep"])){ 
				$dep_key = $project["phases"][$key]["tasks"][$tkey]["dep"];
				$dep_phase_key = $project["phases"][$key]["tasks"][$tkey]["dep_key"];
				if($key != $dep_phase_key) {
					$dep_top = -2;
					$dep_height = $project["phases"][$dep_phase_key]["tasks"][$tkey]["css_top"] - $dep_top -4;
					$dep_left = $project["phases"][$dep_phase_key]["tasks"][$dep_key]["css_left"]+$project["phases"][$dep_phase_key]["tasks"][$dep_key]["css_width"]-$project["phases"][$key]["css_left"]+$project["phases"][$dep_phase_key]["css_left"];
					$dep_width = $project["phases"][$key]["tasks"][$tkey]["css_left"] + $project["tasks"][$dep_key]["css_width"]-$project["tasks"][$dep_key]["css_left"];
				} else {
					$dep_top = $project["tasks"][$dep_key]["css_top"];
					$dep_height = $project["phases"][$dep_phase_key]["tasks"][$tkey]["css_top"] - $dep_top -6;
					$dep_left = $project["tasks"][$dep_key]["css_left"]+$project["tasks"][$dep_key]["css_width"];
					$dep_width = $project["phases"][$key]["tasks"][$tkey]["css_left"]-$project["tasks"][$dep_key]["css_width"]-$project["tasks"][$dep_key]["css_left"];
				}
				?>
                <div class="barchart-dependency" style="z-index: 2; position: absolute; top: <?php echo($dep_top);?>px; left: <?php echo($dep_left);?>px; height: <?php echo($dep_height);?>px; width: <?php echo($dep_width);?>px;"><div class="barchart-arrow"></div></div>
            	<?php } ?>
            	<!-- task dependency -->
                <?php if(!empty($project["phases"][$key]["tasks"][$tkey]["overdue"])){ ?>
                <div class="barchart_color_overdue coTooltip" style="z-index: 2; position: absolute; top: <?php echo($project["phases"][$key]["tasks"][$tkey]["css_top"]);?>px; left: <?php echo($project["phases"][$key]["tasks"][$tkey]["overdue"]["left"]);?>px; height: 10px; width: <?php echo($project["phases"][$key]["tasks"][$tkey]["overdue"]["width"]);?>px;" title="<?php echo($project["phases"][$key]["tasks"][$tkey]["overdue"]["days"]);?>">
                <div class="coTooltipHtml" style="display: none">
						<?php echo($project["phases"][$key]["tasks"][$tkey]["text"]);?><br />
                        <?php echo($project["phases"][$key]["tasks"][$tkey]["startdate"]);?> - <?php echo($project["phases"][$key]["tasks"][$tkey]["enddate"]);?><br />
						<?php echo($project["phases"][$key]["tasks"][$tkey]["overdue"]["days"] . " " . TIMELINE_STATUS_OVERDUE_POPUP);?>
                    </div>
                </div>
                <?php } ?>
                
                <?php } else { ?>
                <!-- milestone -->
                <div id="task_<?php echo($project["phases"][$key]["tasks"][$tkey]["id"]);?>" class="coTooltip loadPhase" rel="<?php echo($project["phases"][$key]["id"]);?>" style="z-index: 3; position: absolute; top: <?php echo($project["phases"][$key]["tasks"][$tkey]["css_top"]);?>px; left: <?php echo($project["phases"][$key]["tasks"][$tkey]["css_left"]+18);?>px; height: 10px; width: <?php echo($project["phases"][$key]["tasks"][$tkey]["css_width"]);?>px;"><span class="icon-milestone"></span>
                	<!-- task tooltip -->
            		<div class="coTooltipHtml" style="display: none">
						<?php echo($project["phases"][$key]["tasks"][$tkey]["text"]);?><br />
                        <?php echo($project["phases"][$key]["tasks"][$tkey]["startdate"]);?> - <?php echo($project["phases"][$key]["tasks"][$tkey]["enddate"]);?><br />
					</div>
                </div>
                <!-- milestone dependency -->
				<?php 
				if(is_int($project["phases"][$key]["tasks"][$tkey]["dep"])){ 
				$dep_key = $project["phases"][$key]["tasks"][$tkey]["dep"];
				$dep_phase_key = $project["phases"][$key]["tasks"][$tkey]["dep_key"];
				$dep_top = $project["tasks"][$dep_key]["css_top"];
				$dep_height = $project["phases"][$dep_phase_key]["tasks"][$tkey]["css_top"] - $dep_top -6;
				$dep_left = $project["tasks"][$dep_key]["css_left"]+$project["tasks"][$dep_key]["css_width"];
				$dep_width = $project["phases"][$key]["tasks"][$tkey]["css_left"]- $project["tasks"][$dep_key]["css_left"] -$project["tasks"][$dep_key]["css_width"] +23;

				//$dep_top = $project["phases"][$key]["tasks"][$dep_key]["css_top"];
				$dep_height = $project["phases"][$key]["tasks"][$tkey]["css_top"] - $dep_top -6;
				//$dep_left = $project["phases"][$key]["tasks"][$dep_key]["css_left"]+$project["phases"][$key]["tasks"][$dep_key]["css_width"];
				//$dep_width = $project["phases"][$key]["tasks"][$dep_key]["css_left"] - ($project["phases"][$key]["tasks"][$tkey]["css_left"]+$project["phases"][$key]["tasks"][$tkey]["css_width"]);
				//echo($dep_width);
				//$dep_width = $project["phases"][$dep_phase_key]["tasks"][$dep_key]["css_left"] - ($project["phases"][$key]["tasks"][$tkey]["css_left"]+$project["phases"][$key]["tasks"][$tkey]["css_width"]);

				?>
                <div class="barchart-dependency" style="z-index: 2; position: absolute; top: <?php echo($dep_top);?>px; left: <?php echo($dep_left);?>px; height: <?php echo($dep_height);?>px; width: <?php echo($dep_width);?>px;"><div class="barchart-arrow"></div></div>
            	<?php } ?>
            	<!-- milestonedependency -->
                <?php } ?>
                
            	<?php } ?>
            </div>
			<?php if(!empty($project["phases"][$key]["overdue"])){ ?>
			<div class="barchart_color_overdue barchart-phase-bg coTooltip" style="position: absolute; top: <?php echo($project["phases"][$key]["css_top"]);?>px; left: <?php echo($project["phases"][$key]["overdue"]["left"]);?>px; height: <?php echo($project["phases"][$key]["css_height"]);?>px; width: <?php echo($project["phases"][$key]["overdue"]["width"]);?>px;" title="<?php echo($project["phases"][$key]["overdue"]["days"]);?>">
            <div class="coTooltipHtml" style="display: none">
					<?php echo($i . ". " . $project["phases"][$key]["title"]);?><br />
                    <?php echo($project["phases"][$key]["startdate"]);?> - <?php echo($project["phases"][$key]["enddate"]);?><br />
					<?php echo($project["phases"][$key]["overdue"]["days"] . " " . TIMELINE_STATUS_OVERDUE_POPUP);?>
                
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
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo($lang["GLOBAL_FOOTER_STATUS"] . " " . $project["datetime"]);?></td>
    <td class="middle"></td>
    <td class="right"></td>
  </tr>
</table>
</div>
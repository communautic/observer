<?php
$top = 100;
$left = 235;
?>

<div style="position: absolute; width: <?php echo($production["page_width"]-24);?>px; top: <?php echo $top-100; ?>px; left: 0px; height: 19px;  background-color: #e5e5e5; vertical-align: top; padding: 3px 0 0 24px;"><?php echo $production["folder"];?></div>
<div style="position: absolute; width: <?php echo($production["page_width"]);?>px; top: <?php echo $top-100; ?>px; left: 0px; height: 22px;  vertical-align: top; padding: 3px 0 0 0; text-align:center"><?php echo $production["title"];?></div>
<div style="position: absolute; width: <?php echo($production["page_width"]-24);?>px; top: <?php echo $top-100; ?>px; left: 0px; height: 22px;  vertical-align: top; padding: 3px 24px 0 0; text-align:right"><?php echo $date->formatDate("now","d.m.Y");;?></div>


<div style="position: absolute; width: 163px; top: <?php echo $top; ?>px; left: 0px; padding: 1px 0 0 24px; height: 15px; vertical-align: top; font-size: 10px; line-height: 16px;"><?php echo $lang['PRODUCTION_TIMELINE_ACTION'];?></div>
<div style="position: absolute; width: 28px; top: <?php echo $top; ?>px; left: 189px; text-align: right;  padding: 1px 10px 0 0;  height: 15px;  vertical-align: top; font-size: 10px; line-height: 16px;"><?php echo $lang['PRODUCTION_TIMELINE_TIME'];?></div>

<div style="position: absolute; width: 163px; top: <?php echo $top+16; ?>px; left: 0px; padding: 1px 0 0 24px; height: 15px; background-color: #e5e5e5; vertical-align: top; font-size: 12px; line-height: 16px;"><?php echo $lang['PRODUCTION_KICKOFF'];?></div>
<div style="position: absolute; width: 28px; top: <?php echo $top+16; ?>px; left: 189px; text-align: right;  padding: 1px 10px 0 0;  height: 15px;  background-color: #e5e5e5; vertical-align: top; font-size: 12px; line-height: 16px;">1</div>
<?php 
$i = 1;
$ltop = $top+34;
// left
foreach($production["phases"] as $key => &$value){ ?>
<div style="position: absolute; width: 177px; top: <?php echo $ltop; ?>px; left: 0px; padding: 1px 0 0 10px; height: 15px; background-color: #b2b2b2; vertical-align: top; font-size: 12px; line-height: 16px; "><?php echo($i . ". " . $production["phases"][$key]["title"]);?></div>

<div style="position: absolute; width: 28px; top: <?php echo $ltop; ?>px; left: 189px; text-align: right;  padding: 1px 10px 0 0;  height: 15px; background-color: #b2b2b2; vertical-align: top; font-size: 12px; line-height: 16px;"><?php echo($production["phases"][$key]["days"]);?></div>
      
      <?php 
	  foreach($production["phases"][$key]["tasks"] as $tkey => &$tvalue){ 
	  $ltop += 18;
	  ?>
      
<div style="position: absolute; width: 163px; top: <?php echo $ltop; ?>px; left: 0px; padding: 1px 0 0 24px; height: 15px; background-color:#e5e5e5; vertical-align: top; font-size: 12px; line-height: 16px;"><?php echo($production["phases"][$key]["tasks"][$tkey]["text"]);?></div>
<div style="position: absolute; width: 28px; top: <?php echo $ltop; ?>px; left: 189px; text-align: right;  padding: 1px 10px 0 0;  height: 15px; background-color: #e5e5e5; vertical-align: top; font-size: 12px; line-height: 16px;"><?php echo($production["phases"][$key]["tasks"][$tkey]["days"]);?></div>

     <?php 
	 
	 } 
	 $ltop += 18;
	 $i++;
	 } ?>

<?php
	$day = $production["startdate"];
	$today = $date->formatDate("now","Y-m-d");
	//loop through all days and generate date row
	if($production["days"] < 20) {
		//$production["days"] = 20;
	}
	$dleft = $left;
	for ($i = 0; $i <= $production["days"]; $i++) {
		$yo = $this->model->barchartCalendar($day,$i);
		$week = "";
		$month = "";
		$now = "";
		$bg = "#b2b2b2";
		if($yo["week"] != "") { ?>
			<div style="position: absolute; top: <?php echo $top-30;?>px; left: <?php echo $dleft;?>px; width: 45px; color: #000; font-size: 10px;">KW <?php echo $yo["week"];?></div>
		<?php }
		if($yo["month"] != "") { ?>
			<div style="position: absolute; top: <?php echo $top-50;?>px; left: <?php echo $dleft;?>px; width: 45px; color: #000; font-size: 10px;"><?php echo  $yo["month"];?></div>
		<?php } ?>
        <div style="position: absolute; top: <?php echo $top; ?>px; left: <?php echo $dleft; ?>px; background-color: <?php echo($bg);?>; width: <?php echo($production["td_width"]);?>px; height: 13px; font-size: 10px; color: <?php echo($yo["color"]);?>; text-align:center; vertical-align: top;"><?php echo $now . $month . $yo["number"];?></div>
        <?php
		$day = $date->addDays($day,1);
		$dleft += $production["td_width"];
	}
	?>


<?php
$top = $top-7;
//$left = 225;
?>
<!-- drawing area outer -->
<div style="position: absolute; top: <?php echo($top+18);?>px; left: <?php echo($left);?>px; background-image:url(<?php echo($production["bg_image"]);?>); background-position: <?php echo($production["bg_image_shift"]);?>px 0px; width: <?php echo($production["css_width"]);?>px; height:<?php echo($production["css_height"]);?>px;"></div>
	<!-- kick off -->
	<div style="z-index: 2; background-color: #B2B2B2; position: absolute; top: <?php echo($top+18+8);?>px; left: <?php echo($left);?>px; height: 10px; width: <?php echo($production["td_width"]);?>px; font-size: 11px;"></div>

            <!-- phase loop -->
			<?php 
			$i = 1;
			foreach($production["phases"] as $key => &$value){ 
			$ptop[$key] = $top + 18 + $production["phases"][$key]["css_top"];
			$pleft[$key] = $left + $production["phases"][$key]["css_left"];
			?>
            <!-- outer phase container for opacyti bg -->
            <div class="<?php echo($production["phases"][$key]["status"]);?>" style="opacity: 0.3; z-index: 1; position: absolute; top: <?php echo($ptop[$key]);?>px; left: <?php echo($pleft[$key]);?>px; height: <?php echo($production["phases"][$key]["css_height"]);?>px; width: <?php echo($production["phases"][$key]["css_width"]);?>px;"></div>
            <div style="position: absolute; z-index: 2;top: <?php echo($ptop[$key]+2);?>px; overflow: hidden; left: <?php echo($pleft[$key]+2);?>px; height: 13px;  vertical-align: top; font-size: 10px; "><?php echo($i . ". " . $production["phases"][$key]["title"] . " " . $production["phases"][$key]["startdate"]);?></div>
<!-- phase -->
			
         
<?php foreach($production["phases"][$key]["tasks"] as $tkey => &$tvalue){ 
				// task
				if($production["phases"][$key]["tasks"][$tkey]["cat"] == 0) {
				?>
                <!-- task -->
                <div class="<?php echo($production["phases"][$key]["tasks"][$tkey]["status"]);?>" style="z-index: 2; position: absolute; top: <?php echo($ptop[$key]+$production["phases"][$key]["tasks"][$tkey]["css_top"]);?>px; left: <?php echo($pleft[$key]+$production["phases"][$key]["tasks"][$tkey]["css_left"]);?>px; height: 10px; width: <?php echo($production["phases"][$key]["tasks"][$tkey]["css_width"]);?>px;"></div>
                <!-- task dependency -->
				<?php 
				if(is_int($production["phases"][$key]["tasks"][$tkey]["dep"])){ 
					$dep_key = $production["phases"][$key]["tasks"][$tkey]["dep"];
					$dep_phase_key = $production["phases"][$key]["tasks"][$tkey]["dep_key"];
					if($key != $dep_phase_key) {
						$dep_top = $ptop[$dep_phase_key]+$production["tasks"][$dep_key]["css_top"];
						$dep_height = $ptop[$key]+$production["phases"][$dep_phase_key]["tasks"][$tkey]["css_top"] - $dep_top -6;
						$dep_left = $pleft[$key]+$production["phases"][$dep_phase_key]["css_left"]+$production["tasks"][$dep_key]["css_left"]+$production["tasks"][$dep_key]["css_width"]-$production["phases"][$key]["css_left"];
						$dep_width = ($production["phases"][$key]["css_left"] + $production["phases"][$key]["tasks"][$tkey]["css_left"]) - ($production["phases"][$dep_phase_key]["css_left"]+$production["tasks"][$dep_key]["css_left"]+$production["tasks"][$dep_key]["css_width"]);
						$dep_arrow_top = $dep_top + $dep_height;
						$dep_arrow_left = $dep_left + $dep_width - 6;
					} else {
						$dep_top = $ptop[$key]+$production["tasks"][$dep_key]["css_top"];
						$dep_height = $production["phases"][$dep_phase_key]["tasks"][$tkey]["css_top"] - $production["tasks"][$dep_key]["css_top"] -6;
						$dep_left = $pleft[$key]+$production["tasks"][$dep_key]["css_left"]+$production["tasks"][$dep_key]["css_width"];
						$dep_width = $production["phases"][$key]["tasks"][$tkey]["css_left"]-$production["tasks"][$dep_key]["css_width"]-$production["tasks"][$dep_key]["css_left"];
						$dep_arrow_top = $dep_top + $dep_height;
						$dep_arrow_left = $dep_left + $dep_width - 6;
					}
					//$ttop[$tkey] = $dep_top;
				?>
                <div class="barchart-dependency" style="z-index: 2; position: absolute; top: <?php echo($dep_top);?>px; left: <?php echo($dep_left);?>px; height: <?php echo($dep_height);?>px; width: <?php echo($dep_width);?>px;"></div>
            	<div class="barchart-arrow" style="z-index: 3; position: absolute; top: <?php echo($dep_arrow_top);?>px; left: <?php echo($dep_arrow_left);?>px;"><img src="<?php echo(CO_FILES);?>/img/gantt_arrow.png" width="13" height="6" /></div>
				<?php } ?>
            	<!-- task dependency -->
                <?php if(!empty($production["phases"][$key]["tasks"][$tkey]["overdue"])){ ?>
                <div class="barchart_color_overdue coTooltip" style="z-index: 2; position: absolute; top: <?php echo($ptop[$key]+$production["phases"][$key]["tasks"][$tkey]["css_top"]);?>px; left: <?php echo($pleft[$key]+$production["phases"][$key]["tasks"][$tkey]["css_left"]+$production["phases"][$key]["tasks"][$tkey]["overdue"]["left"]);?>px; height: 10px; width: <?php echo($production["phases"][$key]["tasks"][$tkey]["overdue"]["width"]);?>px;" title="<?php echo($production["phases"][$key]["tasks"][$tkey]["overdue"]["days"]);?>"></div>
                <?php } ?>
                
                <?php } else { ?>
                <!-- milestone -->
                <div id="task_<?php echo($production["phases"][$key]["tasks"][$tkey]["id"]);?>" style="z-index: 3; position: absolute; top: <?php echo($ptop[$key]+$production["phases"][$key]["tasks"][$tkey]["css_top"]);?>px; left: <?php echo($pleft[$key]+$production["phases"][$key]["tasks"][$tkey]["css_left"]+ $production["td_width"] - 5);?>px; height: 10px; width: <?php echo($production["phases"][$key]["tasks"][$tkey]["css_width"]);?>px;"><img src="<?php echo(CO_FILES);?>/img/print/gantt_milestone.png" width="12" height="12" /></div>
                <div style="position: absolute; top: <?php echo($ptop[$key]+$production["phases"][$key]["tasks"][$tkey]["css_top"]-2);?>px; left: <?php echo($pleft[$key]+$production["phases"][$key]["tasks"][$tkey]["css_left"]+ $production["td_width"]+9);?>px; height: 15px;  vertical-align: top; font-size: 10px; "><?php echo($production["phases"][$key]["tasks"][$tkey]["text"] . " " . $production["phases"][$key]["tasks"][$tkey]["startdate"]);?></div>
                <!-- milestone dependency -->
				<?php 
				if(is_int($production["phases"][$key]["tasks"][$tkey]["dep"])){ 
					$dep_key = $production["phases"][$key]["tasks"][$tkey]["dep"];
					$dep_phase_key = $production["phases"][$key]["tasks"][$tkey]["dep_key"];
					if($key != $dep_phase_key) {
						$dep_top = $ptop[$dep_phase_key]+$production["tasks"][$dep_key]["css_top"];
						$dep_height = $ptop[$key]+$production["phases"][$dep_phase_key]["tasks"][$tkey]["css_top"] - $dep_top -6;
						$dep_left = $pleft[$key]+$production["phases"][$dep_phase_key]["css_left"]+$production["tasks"][$dep_key]["css_left"]+$production["tasks"][$dep_key]["css_width"]-$production["phases"][$key]["css_left"];
						$dep_width = ($production["phases"][$key]["css_left"] + $production["phases"][$key]["tasks"][$tkey]["css_left"]) - ($production["phases"][$dep_phase_key]["css_left"]+$production["tasks"][$dep_key]["css_left"]+$production["tasks"][$dep_key]["css_width"])+17;
						$dep_arrow_top = $dep_top + $dep_height;
						$dep_arrow_left = $dep_left + $dep_width - 6;
					} else {
						$dep_top = $ptop[$key] + $production["tasks"][$dep_key]["css_top"];
						$dep_height = $production["phases"][$dep_phase_key]["tasks"][$tkey]["css_top"]  - $production["tasks"][$dep_key]["css_top"] -6;
						$dep_left = $pleft[$key] + $production["tasks"][$dep_key]["css_left"]+$production["tasks"][$dep_key]["css_width"];
						$dep_width = $production["phases"][$key]["tasks"][$tkey]["css_left"]-$production["tasks"][$dep_key]["css_width"]-$production["tasks"][$dep_key]["css_left"]+$production["td_width"];		
						$dep_arrow_top = $dep_top + $dep_height;
						$dep_arrow_left = $dep_left + $dep_width - 6;
					}
				?>
                <div class="barchart-dependency" style="z-index: 2; position: absolute; top: <?php echo($dep_top);?>px; left: <?php echo($dep_left);?>px; height: <?php echo($dep_height);?>px; width: <?php echo($dep_width);?>px;"></div>
            	<div class="barchart-arrow" style="z-index: 3; position: absolute; top: <?php echo($dep_arrow_top);?>px; left: <?php echo($dep_arrow_left);?>px;"><img src="<?php echo(CO_FILES);?>/img/gantt_arrow.png" width="13" height="6" /></div>
				<?php } ?>
            	<!-- milestonedependency -->
                <?php } ?>
                
            	<?php } ?>
            
			<?php if(!empty($production["phases"][$key]["overdue"])){ ?>
			<div class="barchart_color_overdue barchart-phase-bg coTooltip" style="position: absolute; top: <?php echo($ptop[$key]);?>px; left: <?php echo($pleft[$key]+$production["phases"][$key]["css_width"]);?>px; height: <?php echo($production["phases"][$key]["css_height"]);?>px; width: <?php echo($production["phases"][$key]["overdue"]["width"]);?>px;" title="<?php echo($production["phases"][$key]["overdue"]["days"]);?>"></div>
            <?php } 
			$i++;
			 } ?>
<div style="position: absolute; width: <?php echo($production["page_width"]-24);?>px; top: <?php echo $production["css_height"]+150;?>px; left: 0px; height: 19px;  background-color: #e5e5e5; vertical-align: top; padding: 3px 0 0 24px;"><?php echo $lang["PRODUCTION_TIMELINE_PRODUCTION_PLAN"];?></div>

<div style="position: absolute; width: <?php echo($production["page_width"]-$left);?>px; top: <?php echo $production["css_height"]+148;?>px; left: <?php echo($left-18);?>px; height: 19px; text-align:center;"><table border="0" cellspacing="0" cellpadding="0" class="timeline-legend">
    <tr>
        <td><span><img src="<?php echo(CO_FILES);?>/img/print/gantt_milestone.png" width="12" height="12" /> Meilenstein</span></td>
        <td width="15"></td>
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
</table></div>
<div style="position: absolute; width: <?php echo($production["css_width"]+$left);?>px; top: <?php echo $production["css_height"]+180;?>px; left: 0px; height: 19px; vertical-align: top; padding: 3px 0 0 24px;"><img src="<?php echo(CO_FILES);?>/img/print/poweredbyco.png" width="135" height="9" /></div>
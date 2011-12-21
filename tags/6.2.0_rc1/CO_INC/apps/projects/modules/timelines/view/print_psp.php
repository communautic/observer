<?php
$top = 50;
$left = 150;
?>
<div style="position: absolute; width: <?php echo($project["page_width"]-24);?>px; top: <?php echo $top-$top; ?>px; left: 0px; height: 19px;  background-color: #e5e5e5; vertical-align: top; padding: 3px 0 0 24px;"><?php echo $project["folder"];?></div>
<div style="position: absolute; width: <?php echo($project["page_width"]);?>px; top: <?php echo $top-$top; ?>px; left: 0px; height: 22px;  vertical-align: top; padding: 3px 0 0 0; text-align:center"><?php echo $project["title"];?></div>
<div style="position: absolute; width: <?php echo($project["page_width"]-24);?>px; top: <?php echo $top-$top; ?>px; left: 0px; height: 22px;  vertical-align: top; padding: 3px 24px 0 0; text-align:right"><?php echo $date->formatDate("now","d.m.Y");;?></div>


<div style="position: absolute; width: <?php echo($project["page_width"]);?>px; top: <?php echo $top;?>px; left: 0px; padding-left: 24px; height: 58px; color: #666666; vertical-align: top; font-size: 10px;"><?php echo $lang["PROJECT_TITLE"];?></div>
<?php
$bg = $project["status"];
if($bg == "barchart_color_planned") {
	$bg = "psp_barchart_color_planned";
}
?>
<div style="position: absolute; z-index: 1; width: 170px; top: <?php echo $top;?>px; left: <?php echo($left);?>px; border: 1px solid #000; width: 150px; height: 56px; font-size: 11px; font-weight: bold; text-align:center; vertical-align: top;" class="<?php echo($bg);?>"><?php echo($project["title"]);?></div>
<div style="position: absolute; top: <?php echo $top+56;?>px; left: <?php echo($left+75);?>px; height: 24px; width: 1px; background-color: #000;"></div>

<?php 
$numPhases = sizeof($project["phases"]);
if($numPhases > 0) { 
$width = $numPhases * 170;
$ptop = $top+56+24;
?>
<div style="position: absolute; width: <?php echo($project["page_width"]);?>px; top: <?php echo $ptop;?>px; left: 0px; padding-left: 24px; height: 58px; color: #666666; background-color: #E5E5E5; vertical-align: top; font-size: 10px;"><?php echo $lang["PROJECT_PHASES"];?></div>
 <div style="position: absolute; width: <?php echo($project["page_width"]);?>px; top: <?php echo $ptop+80;?>px; left: 0px; padding-left: 24px; height: 58px; color: #666666; vertical-align: top; font-size: 10px;"><?php echo $lang["PROJECT_PHASE_TASK_MILESTONE"];?></div>   
	<?php
    
	//echo('<div style="width: ' . $width . 'px">');
	$pleft = $left;
	$countPhases = 1;
	foreach($project["phases"] as $key => &$value){ 
		$leftline = ' class="td_border_left"';
		if($countPhases == $numPhases) {
			$leftline='';
		}
		$numTasks = sizeof($project["phases"][$key]["tasks"]);
		$taskline='class="td_border_top_right"';
		if($numTasks == 0) {
			$taskline='';
		}
		
		//$datescolor = "";
			$bg = $project["phases"][$key]["status"];
			if($bg == "barchart_color_planned") {
				$bg = "psp_barchart_color_planned";
			}
			$datescolor = $bg;
			if($project["phases"][$key]["status"] == "barchart_color_overdue") {
				$datescolor = "barchart_color_overdue";
				$bg = "barchart_color_finished";
			}
	?>
        <div style="position: absolute; z-index: 1; top: <?php echo $ptop;?>px; left: <?php echo($pleft);?>px; border: 1px solid #000; width: 150px; height: 42px; font-size: 11px; font-weight: bold; text-align:center; vertical-align: top; overflow: hidden;" class="<?php echo($bg);?>"><?php echo($countPhases . ". " .$project["phases"][$key]["title"]);?></div>
        <div class="<?php echo($datescolor);?>" style="z-index: 3; position: absolute; top: <?php echo $ptop+44;?>px; left: <?php echo($pleft);?>px; width: 74px; height: 13px; font-size: 11px; font-weight: bold; text-align:center; border-left: 1px solid #000000; border-bottom: 1px solid #000000; vertical-align: top;"><?php echo($project["phases"][$key]["startdate"]);?></div>
        <div class="<?php echo($datescolor);?>" style="z-index: 2; position: absolute; top: <?php echo $ptop+44;?>px; left: <?php echo($pleft+75);?>px; width: 75px; height: 13px; font-size: 11px; font-weight: bold; text-align:center; border-left: 1px solid #000; border-bottom: 1px solid #000; border-right: 1px solid #000; vertical-align: top;"><?php echo($project["phases"][$key]["enddate"]);?></div>
			<div style="position: absolute; top: <?php echo $ptop+29;?>px; left: <?php echo($pleft-10);?>px; height: 1px; width: 10px; background-color: #000;"></div>
            <?php if($countPhases > 1) { ?>
				<div style="position: absolute; top: <?php echo $ptop-10;?>px; left: <?php echo $pleft-94;?>px; height: 9px; width: 170px; border-top: 1px solid #000; border-right: 1px solid #000;"></div>
			<?php } ?>
			
			<?php
				$ttop = $ptop+56+24;
				foreach($project["phases"][$key]["tasks"] as $tkey => &$tvalue){ 
					$bg = $project["phases"][$key]["tasks"][$tkey]["status"];
					if($bg == "barchart_color_planned") {
				$bg = "psp_barchart_color_planned";
			}
					$datescolor = $bg;
					if($project["phases"][$key]["tasks"][$tkey]["status"] == "barchart_color_overdue") {
						$datescolor = "barchart_color_overdue";
						//$bg = "barchart_color_finished";
					}
					if($project["phases"][$key]["tasks"][$tkey]["status"] == "barchart_color_finished_but_overdue") {
						$datescolor = "barchart_color_overdue";
						$bg = "barchart_color_finished";
					}
				?>
			<div style="position: absolute; z-index: 1; top: <?php echo $ttop;?>px; left: <?php echo($pleft);?>px; border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; width: 150px; height: 28px; font-size: 11px; font-weight: bold; text-align:center; vertical-align: top; overflow: hidden;" class="<?php echo($bg);?>"><?php echo($project["phases"][$key]["tasks"][$tkey]["text"]);?></div>
			<div style="position: absolute; z-index: 2; top: <?php echo $ttop+29;?>px; left: <?php echo($pleft);?>px; border-bottom: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000; width: 150px; height: 14px; font-size: 11px; font-weight: bold; text-align:center; vertical-align: top; overflow: hidden;" class="<?php echo($bg);?>"><?php echo($project["phases"][$key]["tasks"][$tkey]["team"]);?></div>
            <?php if($project["phases"][$key]["tasks"][$tkey]["cat"] == 0) { ?>
				<div class="<?php echo($datescolor);?>" style="z-index: 3; position: absolute; top: <?php echo $ttop+44;?>px; left: <?php echo($pleft);?>px; width: 74px; height: 13px; font-size: 11px; font-weight: bold; text-align:center; border-left: 1px solid #000000; border-bottom: 1px solid #000000; vertical-align: top;"><?php echo($project["phases"][$key]["tasks"][$tkey]["startdate"]);?></div>
                <div style="z-index: 2; position: absolute; top: <?php echo $ttop+44;?>px; left: <?php echo($pleft+75);?>px; width: 75px; height: 13px; font-size: 11px; font-weight: bold; text-align:center; border-left: 1px solid #000; border-bottom: 1px solid #000; border-right: 1px solid #000; vertical-align: top;" class="<?php echo($datescolor);?>"><?php echo($project["phases"][$key]["tasks"][$tkey]["enddate"]);?></div>
			<?php } else { ?>
				<div class="<?php echo($datescolor);?>" style="z-index: 3; position: absolute; top: <?php echo $ttop+44;?>px; left: <?php echo($pleft);?>px; width: 74px; height: 13px; border-left: 1px solid #000000; border-bottom: 1px solid #000000; vertical-align: top;"><img src="<?php echo(CO_FILES);?>/img/print/gantt_milestone.png" width="12" height="12" style= "margin: 0px 0 0 2px" /></div>
                <div style="z-index: 2; position: absolute; top: <?php echo $ttop+44;?>px; left: <?php echo($pleft+75);?>px; width: 75px; height: 13px; font-size: 11px; font-weight: bold; text-align:center; border-left: 1px solid #000; border-bottom: 1px solid #000; border-right: 1px solid #000; vertical-align: top;" class="<?php echo($datescolor);?>"><?php echo($project["phases"][$key]["tasks"][$tkey]["enddate"]);?></div>
			<?php }?>
        
        <div style="position: absolute; top: <?php echo $ttop-50;?>px; left: <?php echo($pleft-10);?>px; height: 79px; width: 9px; border-bottom: 1px solid #000; border-left: 1px solid #000;"></div>
		<?php 
		$ttop += 56+24;
		} ?>
        

    <?php 
	$pleft += 170;
    $countPhases++;
    }
}
?>


<div style="position: absolute; width: <?php echo($project["page_width"]-24);?>px; top: <?php echo $project["css_height"]+150;?>px; left: 0px; height: 19px;  background-color: #e5e5e5; vertical-align: top; padding: 3px 0 0 24px;"><?php echo $lang["PROJECT_TIMELINE_PROJECT_STRUCTURE"];?></div>

<div style="position: absolute; width: <?php echo($project["page_width"]-235);?>px; top: <?php echo $project["css_height"]+148;?>px; left: <?php echo($left+50);?>px; height: 19px; text-align:center;"><table border="0" cellspacing="0" cellpadding="0" class="timeline-legend">
    <tr>
        <td><span><img src="<?php echo(CO_FILES);?>/img/print/gantt_milestone.png" width="12" height="12" /> Meilenstein</span></td>
        <td width="15"></td>
        <td class="psp_barchart_color_planned"><span><?php echo $lang["PROJECT_TIMELINE_STATUS_PLANED"];?></span></td>
        <td width="15"></td>
        <td class="barchart_color_inprogress"><span><?php echo $lang["PROJECT_TIMELINE_STATUS_INPROGRESS"];?></span></td>
         <td width="15"></td>
        <td class="barchart_color_finished"><span><?php echo $lang["PROJECT_TIMELINE_STATUS_FINISHED"];?></span></td>
         <td width="15"></td>
        <td class="barchart_color_not_finished"><span><?php echo $lang["PROJECT_TIMELINE_STATUS_NOT_FINISHED"];?></span></td>
         <td width="15"></td>
        <td class="barchart_color_overdue"><span><?php echo $lang["PROJECT_TIMELINE_STATUS_OVERDUE"];?></span></td>
    </tr>
</table></div>
<div style="position: absolute; width: <?php echo($project["css_width"]+$left);?>px; top: <?php echo $project["css_height"]+180;?>px; left: 0px; height: 19px; vertical-align: top; padding: 3px 0 0 24px;"><img src="<?php echo(CO_FILES);?>/img/print/poweredbyco.png" width="135" height="9" /></div>
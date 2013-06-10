<?php
$top = 50;
$left = 150;
?>
<div style="position: absolute; width: <?php echo($project["page_width"]-24);?>px; top: <?php echo $top-$top; ?>px; left: 0px; height: 19px;  background-color: #e5e5e5; vertical-align: top; padding: 3px 0 0 24px;"><?php echo $project["folder"];?></div>
<div style="position: absolute; width: <?php echo($project["page_width"]);?>px; top: <?php echo $top-$top; ?>px; left: 0px; height: 22px;  vertical-align: top; padding: 3px 0 0 0; text-align:center"><?php echo $project["title"];?></div>
<div style="position: absolute; width: <?php echo($project["page_width"]-24);?>px; top: <?php echo $top-$top; ?>px; left: 0px; height: 22px;  vertical-align: top; padding: 3px 24px 0 0; text-align:right"><?php echo $date->formatDate("now","d.m.Y");;?></div>


<div style="position: absolute; width: <?php echo($project["page_width"]);?>px; top: <?php echo $top+7;?>px; left: 0px; padding-left: 24px; height: 58px; color: #666666; vertical-align: top; font-size: 10px;"><?php echo $lang["PROJECT_TITLE"];?></div>
<?php
$bg = $project["status"];
if($bg == "barchart_color_planned") {
	$bg = "psp_barchart_color_planned";
}
?>
<div style="position: absolute; z-index: 1; top: <?php echo $top;?>px; left: <?php echo($left);?>px; border: 1px solid #666; width: 178px; height: 71px; font-size: 11px; font-weight: bold; text-align:center; vertical-align: top;"></div>
<div style="position: absolute; z-index: 2; top: <?php echo $top+2;?>px; left: <?php echo($left+2);?>px; width: 159px; height: 32px; font-size: 11px; font-weight: bold; padding: 3px 9px 0 9px; overflow: hidden;" class="<?php echo($bg);?>"><?php echo($project["title"]);?></div><div style="position: absolute; z-index: 3; top: <?php echo $top+36;?>px; left: <?php echo($left+2);?>px; width: 177px;" class="<?php echo($bg);?>_line"></div>
<div style="position: absolute; z-index: 2; top: <?php echo $top+38;?>px; left: <?php echo($left+2);?>px; width: 159px; height: 14px; font-size: 11px; vertical-align: top; padding: 3px 9px 0 9px; overflow: hidden;" class="<?php echo($bg);?>_light"><?php echo($project["management"]);?></div>
<div class="<?php echo($bg);?>_light" style="z-index: 3; position: absolute; top: <?php echo $top+55;?>px; left: <?php echo($left+2);?>px; width: 79px; height: 11px; font-size: 11px; vertical-align: top; padding: 1px 0 4px 9px;"><?php echo($project["startdate"]);?></div>
        <div class="<?php echo($bg);?>_light" style="z-index: 2; position: absolute; top: <?php echo $top+55;?>px; left: <?php echo($left+90);?>px; width: 80px; height: 11px; font-size: 11px; vertical-align: top; padding: 1px 9px 4px 0; text-align: right;"><?php echo($project["enddate"]);?></div>
<div style="position: absolute; top: <?php echo $top+73;?>px; left: <?php echo($left);?>px; height: 9px; width: 89px; border-left: 1px solid #666666; border-bottom: 1px solid #666666;"></div><div style="position: absolute; top: <?php echo $top+82;?>px; left: <?php echo($left+89);?>px; height: 11px; width: 1px; border-right: 1px solid #666666;"></div>

<?php 
$numPhases = sizeof($project["phases"]);
if($numPhases > 0) { 
$width = $numPhases * 190;
$ptop = $top+93;
?>
<div style="position: absolute; width: <?php echo($project["page_width"]);?>px; top: <?php echo $ptop;?>px; left: 0px; padding-left: 24px; padding-top: 6px; height: 67px; color: #666666; background-color: #E5E5E5; vertical-align: top; font-size: 10px;"><?php echo $lang["PROJECT_PHASES"];?></div>
 <div style="position: absolute; width: <?php echo($project["page_width"]);?>px; top: <?php echo $ptop+94;?>px; left: 0px; padding-left: 24px; height: 58px; color: #666666; vertical-align: top; font-size: 10px;"><?php echo $lang["PROJECT_PHASE_TASK_MILESTONE"];?></div>   
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
        <div style="position: absolute; z-index: 1; top: <?php echo $ptop;?>px; left: <?php echo($pleft);?>px; border: 1px solid #666; width: 178px; height: 71px; font-size: 11px; font-weight: bold; text-align:center; vertical-align: top; background-color: #fff;"></div>
        <div style="position: absolute; z-index: 2; top: <?php echo $ptop+2;?>px; left: <?php echo($pleft+2);?>px; width: 159px; height: 32px; font-size: 11px; font-weight: bold; padding: 3px 9px 0 9px; overflow: hidden;" class="<?php echo($bg);?>"><?php echo($countPhases . ". " .$project["phases"][$key]["title"]);?></div><div style="position: absolute; z-index: 3; top: <?php echo $ptop+36;?>px; left: <?php echo($pleft+2);?>px; width: 177px;" class="<?php echo($bg);?>_line"></div>
        <div style="position: absolute; z-index: 2; top: <?php echo $ptop+38;?>px; left: <?php echo($pleft+2);?>px; width: 159px; height: 14px; font-size: 11px; vertical-align: top; padding: 3px 9px 0 9px; overflow: hidden;" class="<?php echo($bg);?>_light"></div>
        <div class="<?php echo($datescolor);?>_light" style="z-index: 3; position: absolute; top: <?php echo $ptop+55;?>px; left: <?php echo($pleft+2);?>px; width: 79px; height: 11px; font-size: 11px; vertical-align: top; padding: 1px 0 4px 9px;"><?php echo($project["phases"][$key]["startdate"]);?></div>
        <div class="<?php echo($datescolor);?>_light" style="z-index: 2; position: absolute; top: <?php echo $ptop+55;?>px; left: <?php echo($pleft+90);?>px; width: 80px; height: 11px; font-size: 11px; vertical-align: top; padding: 1px 9px 4px 0; text-align: right;"><?php echo($project["phases"][$key]["enddate"]);?></div>
            <?php if($countPhases > 1) { ?>
				<div style="position: absolute; top: <?php echo $ptop-11;?>px; left: <?php echo $pleft-100;?>px; height: 10px; width: 190px; border-top: 1px solid #666; border-right: 1px solid #666;"></div>
			<?php } ?>
			
			<?php
				$ttop = $ptop+88;
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
			<div style="position: absolute; z-index: 1; top: <?php echo $ttop;?>px; left: <?php echo($pleft+10);?>px; border: 1px solid #666; width: 168px; height: 71px;"></div>
            <div style="position: absolute; z-index: 2; top: <?php echo $ttop+2;?>px; left: <?php echo($pleft+12);?>px; width: 149px; height: 31px; font-size: 11px; font-weight: bold; padding: 3px 9px 0 9px; overflow: hidden;" class="<?php echo($bg);?>"><?php echo($project["phases"][$key]["tasks"][$tkey]["text"]);?></div><div style="position: absolute; z-index: 3; top: <?php echo $ttop+36;?>px; left: <?php echo($pleft+12);?>px; width: 167px;" class="<?php echo($bg);?>_line"></div>
			<div style="position: absolute; z-index: 2; top: <?php echo $ttop+38;?>px; left: <?php echo($pleft+12);?>px; width: 149px; height: 14px; font-size: 11px; vertical-align: top; padding: 3px 9px 0 9px; overflow: hidden;" class="<?php echo($datescolor);?>_light"><?php echo($project["phases"][$key]["tasks"][$tkey]["team"]);?></div>
            
            <?php if($project["phases"][$key]["tasks"][$tkey]["cat"] == 0 || $project["phases"][$key]["tasks"][$tkey]["cat"] == 2) { ?>
            <?php if ($project["phases"][$key]["tasks"][$tkey]["cat"] == 2) { ?>
            <div class="<?php echo($datescolor);?>_light" style="z-index: 4; position: absolute; top: <?php echo $ttop+55;?>px; left: <?php echo($pleft+12);?>px; width: 30px; height: 16px; font-size: 11px; font-weight: bold; text-align:center;  vertical-align: top;"><img src="<?php echo(CO_FILES);?>/img/print/projectlink_white.png" width="19" height="8" style="margin: 3px 0 0 9px" /></div>
            <div class="<?php echo($datescolor);?>_light" style="z-index: 3; position: absolute; top: <?php echo $ttop+55;?>px; left: <?php echo($pleft+40);?>px; width: 64px; height: 11px; font-size: 11px; vertical-align: top; padding: 1px 0 4px 9px;"><?php echo($project["phases"][$key]["tasks"][$tkey]["startdate"]);?></div>
                <div style="z-index: 2; position: absolute; top: <?php echo $ttop+55;?>px; left: <?php echo($pleft+95);?>px; width: 75px; height: 11px; font-size: 11px; vertical-align: top; padding: 1px 9px 4px 0; text-align: right;" class="<?php echo($datescolor);?>_light"><?php echo($project["phases"][$key]["tasks"][$tkey]["enddate"]);?></div>
			<?php } else { // AP ?>
				<div class="<?php echo($datescolor);?>_light" style="z-index: 3; position: absolute; top: <?php echo $ttop+55;?>px; left: <?php echo($pleft+12);?>px; width: 74px; height: 11px; font-size: 11px; vertical-align: top; padding: 1px 0 4px 9px;"><?php echo($project["phases"][$key]["tasks"][$tkey]["startdate"]);?></div>
                <div style="z-index: 2; position: absolute; top: <?php echo $ttop+55;?>px; left: <?php echo($pleft+95);?>px; width: 75px; height: 11px; font-size: 11px; vertical-align: top; padding: 1px 9px 4px 0; text-align: right;" class="<?php echo($datescolor);?>_light"><?php echo($project["phases"][$key]["tasks"][$tkey]["enddate"]);?></div>
                <?php } ?>
			<?php } else { // MS ?>
				<div class="<?php echo($datescolor);?>_light" style="z-index: 3; position: absolute; top: <?php echo $ttop+51;?>px; left: <?php echo($pleft+12);?>px; width: 74px; height: 16px; vertical-align: top; padding: 0 0 4px 9px;"><img src="<?php echo(CO_FILES);?>/img/print/milestone_large.png" width="16" height="16" /></div>
                <div style="z-index: 2; position: absolute; top: <?php echo $ttop+55;?>px; left: <?php echo($pleft+95);?>px; width: 75px; height: 11px; font-size: 11px; vertical-align: top; padding: 1px 9px 4px 0; text-align: right;" class="<?php echo($datescolor);?>_light"><?php echo($project["phases"][$key]["tasks"][$tkey]["enddate"]);?></div>
			<?php }?>
        
        <div style="position: absolute; top: <?php echo $ttop-51;?>px; left: <?php echo($pleft);?>px; height: 88px; width: 9px; border-bottom: 1px solid #666; border-left: 1px solid #666;"></div>
		<?php 
		$ttop += 88;
		}
	$pleft += 190;
    $countPhases++;
    }
}
?>


<div style="position: absolute; width: <?php echo($project["page_width"]-24);?>px; top: <?php echo $project["css_height"]+150;?>px; left: 0px; height: 19px;  background-color: #e5e5e5; vertical-align: top; padding: 3px 0 0 24px;"><?php echo $lang["PROJECT_TIMELINE_PROJECT_STRUCTURE"];?></div>

<div style="position: absolute; width: <?php echo($project["page_width"]-235);?>px; top: <?php echo $project["css_height"]+148;?>px; left: <?php echo($left+50);?>px; height: 19px; text-align:center;"><table border="0" cellspacing="0" cellpadding="0" class="timeline-legend">
    <tr>
        <td><span><img src="<?php echo(CO_FILES);?>/img/print/gantt_milestone.png" width="12" height="12" /> Meilenstein</span></td>
        <td width="15"></td>
        <td class="psp_barchart_color_planned"><span><?php echo $lang["GLOBAL_STATUS_PLANNED"];?></span></td>
        <td width="15"></td>
        <td class="barchart_color_inprogress"><span><?php echo $lang["GLOBAL_STATUS_INPROGRESS"];?></span></td>
         <td width="15"></td>
        <td class="barchart_color_finished"><span><?php echo $lang["GLOBAL_STATUS_FINISHED"];?></span></td>
         <td width="15"></td>
        <td class="barchart_color_not_finished"><span><?php echo $lang["GLOBAL_STATUS_NOT_FINISHED"];?></span></td>
         <td width="15"></td>
        <td class="barchart_color_overdue"><span><?php echo $lang["GLOBAL_STATUS_OVERDUE"];?></span></td>
    </tr>
</table></div>
<div style="position: absolute; width: <?php echo($project["css_width"]+$left);?>px; top: <?php echo $project["css_height"]+180;?>px; left: 0px; height: 19px; vertical-align: top; padding: 3px 0 0 24px;"><img src="<?php echo(CO_FILES);?>/img/print/<?php echo $GLOBALS["APPLICATION_LOGO_PRINT"];?>" width="135" height="9" /></div>
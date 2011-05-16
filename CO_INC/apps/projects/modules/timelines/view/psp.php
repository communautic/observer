<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-title grey">
  <tr>
    <td class="tcell-left text11"><span class="content-nav-title"><?php echo TIMELINE_PROJECT_STRUCTURE;?></span></td>
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
<div class="ui-layout-content">
<div class="scroll-pane">
<table border="0" cellpadding="0" cellspacing="0" class="table-content no-margin">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PROJECT_TITLE"];?></td>
		<td class="tcell-right">
			<div class="psp-item <?php echo($project["status"]);?> loadProject" rel="<?php echo($project["id"]);?>"><div style="height: 42px; overflow: hidden"><?php echo($project["title"]);?></div>
				<div class="psp-item-startdate"><?php echo($project["startdate"]);?></div><div class="psp-item-enddate"><?php echo($project["enddate"]);?></div>
                <div class="psp-connector-project-vert"></div>
			</div>
		</td>
	</tr>
</table>
<?php 
$numPhases = sizeof($project["phases"]);
if($numPhases > 0) { 
$width = $numPhases * 170;
?>
<div class="text11 tbl-inactive" style="position: absolute; padding-left: 15px; height: 58px; color: #666666;" ><?php echo $lang["PROJECT_PHASES"];?></div>
	<div style="width: <?php echo($width+150);?>px">
    <div style="width: 150px; float: left;">
      <div style="height: 58px; margin-bottom: 18px;"></div>
      <div class="text11" style="padding-left: 15px; color: #666666;"><?php echo $lang["PHASE_TASK_MILESTONE"];?></div>
    </div>
	<?php
    
	//echo('<div style="width: ' . $width . 'px">');
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
	?>
    <div style="width: 170px; float: left;">
        <div class="psp-item <?php echo($project["phases"][$key]["status"]);?> loadPhase" rel="<?php echo($project["phases"][$key]["id"]);?>">
			<div class="psp-connector-phase-vert"></div>
            <?php if($countPhases > 1) { echo '<div class="psp-connector-phase-hori"></div>'; } ?>
			<div style="height: 42px; overflow: hidden"><?php echo($countPhases . ". " .$project["phases"][$key]["title"]);?></div>
            <div class="psp-item-startdate"><?php echo($project["phases"][$key]["startdate"]);?></div><div class="psp-item-enddate"><?php echo($project["phases"][$key]["enddate"]);?></div>
        </div>
			<?php
		foreach($project["phases"][$key]["tasks"] as $tkey => &$tvalue){ ?>
			<div class="psp-item <?php echo($project["phases"][$key]["tasks"][$tkey]["status"]);?> loadPhase" rel="<?php echo($project["phases"][$key]["id"]);?>">
			<div class="psp-connector-vert"></div>
			<div style="height: 28px; overflow: hidden"><?php echo($project["phases"][$key]["tasks"][$tkey]["text"]);?></div>
			<div style="height: 14px; overflow: hidden"><?php echo($project["phases"][$key]["tasks"][$tkey]["team"]);?></div>
            <?php if($project["phases"][$key]["tasks"][$tkey]["cat"] == 0) { ?>
				<div class="psp-item-startdate"><?php echo($project["phases"][$key]["tasks"][$tkey]["startdate"]);?></div><div class="psp-item-enddate"><?php echo($project["phases"][$key]["tasks"][$tkey]["enddate"]);?></div>
			<?php } else { ?>
				<div class="psp-item-startdate"><span class="icon-milestone"></span></div><div class="psp-item-enddate"><?php echo($project["phases"][$key]["tasks"][$tkey]["enddate"]);?></div>
			<?php }?>
        </div>
		<?php } ?>
</div>
    <?php 
    $countPhases++;
    }
}
?>
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
<style>
.psp-item { position: relative; margin-bottom: 20px; border: 1px solid #000; width: 150px; height: 56px; font-size: 11px; font-weight: bold; text-align:center}
.psp-item-startdate { position: absolute; left: 0; bottom: 0; width: 75px; height: 13px; border-top: 1px solid #000;}
.psp-item-enddate { position: absolute; right: 0; bottom: 0; width: 74px; height: 13px; border-top: 1px solid #000; border-left: 1px solid #000;}
.psp-connector-project-vert { position: absolute; top: 56px; left: 75px; height: 24px; width: 1px; background-color: #000; }
.psp-connector-phase-hori { position: absolute; top: -10px; left: -94px; height: 9px; width: 170px; border-top: 1px solid #000; border-right: 1px solid #000; }
.psp-connector-phase-vert { position: absolute; top: 28px; left: -10px; height: 1px; width: 9px; background-color: #000; }
.psp-connector-vert { position: absolute; top: -50px; left: -10px; height: 78px; width: 9px; border-bottom: 1px solid #000; border-left: 1px solid #000; }

</style>
<table border="0" cellpadding="0" cellspacing="0" class="table-content no-margin">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PROJECT_TITLE"];?></td>
		<td class="tcell-right">
			<div class="psp-item <?php echo($project["status"]);?> loadProject" rel="<?php echo($project["id"]);?>"><?php echo($project["title"]);?><br />
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

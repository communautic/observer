<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["PROJECT_TIMELINE_DATES_LIST"];?></td>
        <td>&nbsp;</td>
	</tr>
</table>
<table width="100%" class="standard">
    <tr>
		<td class="tcell-left"><?php echo $lang["PROJECT_TITLE"];?></td>
		<td><?php echo($project["title"]);?></td>
	</tr>
    <tr>
		<td class="tcell-left">&nbsp;</td>
		<td class="grey smalltext"><?php echo($project["startdate"]);?> - <?php echo($project["enddate"]);?></td>
	</tr>
</table>
&nbsp;
<?php 
$numPhases = sizeof($project["phases"]);
if($numPhases > 0) {
	$countPhases = 1;
	foreach($project["phases"] as $key => &$value){ 
		$numTasks = sizeof($project["phases"][$key]["tasks"]);
	?>
    
    <table width="100%" class="standard-grey">
        <tr>
            <td class="tcell-left"><?php echo $lang["PROJECT_PHASE_TITLE"];?></td>
            <td><?php echo($countPhases . ". " . $project["phases"][$key]["title"]);?></td>
        </tr>
    </table>
    <table width="100%" class="standard-grey">
        <tr>
            <td class="tcell-left">&nbsp;</td>
            <td class="smalltext grey"><?php echo($project["phases"][$key]["startdate"]);?> - <?php echo($project["phases"][$key]["enddate"]);?></td>
        </tr>
    </table>
	<?php
		foreach($project["phases"][$key]["tasks"] as $tkey => &$tvalue){ 
			if($project["phases"][$key]["tasks"][$tkey]["cat"] == 0 || $project["phases"][$key]["tasks"][$tkey]["cat"] == 2) {
				$projectlink = "";
		?>
		<table width="100%" class="fourCols">
            <tr>
                <td class="fourCols-one">&nbsp;</td>
                <td class="fourCols-two-three-combined"><?php if ($project["phases"][$key]["tasks"][$tkey]["cat"] == 2) {
					$projectlink = "Projektlink: ";
					?><img src="<?php echo(CO_FILES);?>/img/print/projectlink.png" width="19" height="8" style="margin: 3px 0 0 2px" /><?php } ?>&nbsp;</td>
                <td class="fourCols-four"><?php echo($projectlink . $project["phases"][$key]["tasks"][$tkey]["text"]);?></td>
            </tr>
            <tr>
                <td class="fourCols-one">&nbsp;</td>
                <td class="fourCols-two-three-combined">&nbsp;</td>
                <td class="fourCols-four grey smalltext"><?php echo($project["phases"][$key]["tasks"][$tkey]["startdate"]);?> - <?php echo($project["phases"][$key]["tasks"][$tkey]["enddate"]);?></td>
            </tr>
        </table>
        &nbsp;
<?php } else { ?>
		<table width="100%" class="fourCols">
            <tr>
                <td class="fourCols-one">&nbsp;</td>
                <td class="fourCols-two">&nbsp;</td>
                <td class="fourCols-three"><img src="<?php echo(CO_FILES);?>/img/print/milestone.png" width="12" height="12" style="margin: 2px 0 0 3px" /></td>
                <td class="fourCols-four"><?php echo($project["phases"][$key]["tasks"][$tkey]["text"]);?></td>
            </tr>
            <tr>
                <td class="fourCols-one">&nbsp;</td>
                <td class="fourCols-two">&nbsp;</td>
                <td class="fourCols-three">&nbsp;</td>
                <td class="fourCols-four grey smalltext"><?php echo($project["phases"][$key]["tasks"][$tkey]["startdate"]);?> - <?php echo($project["phases"][$key]["tasks"][$tkey]["enddate"]);?></td>
            </tr>
        </table>
        &nbsp;
    <?php } 
	 } 
    $countPhases++;
    }
}
?>
<div style="page-break-after:always;">&nbsp;</div>
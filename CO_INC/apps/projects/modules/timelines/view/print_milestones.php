<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
        <td class="tcell-left"><?php echo TIMELINE_DATES_LIST;?></td>
        <td>&nbsp;</td>
	</tr>
</table>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
    <tr>
		<td class="tcell-left"><?php echo $lang["PROJECT_TITLE"];?></td>
		<td><?php echo($project["title"]);?></td>
	</tr>
    <tr>
		<td class="tcell-left">&nbsp;</td>
		<td><?php echo($project["startdate"]);?> - <?php echo($project["enddate"]);?></td>
	</tr>
</table>
<?php 
$numPhases = sizeof($project["phases"]);
if($numPhases > 0) {
	$countPhases = 1;
	foreach($project["phases"] as $key => &$value){ 
		$numTasks = sizeof($project["phases"][$key]["tasks"]);
	?>
    
    <!--<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["PHASE_TITLE"];?></td>
        <td><?php echo($countPhases . ". " . $project["phases"][$key]["title"]);?><br />
        <?php echo($project["phases"][$key]["startdate"]);?> - <?php echo($project["phases"][$key]["enddate"]);?></td>
	</tr>
</table>-->
	<?php
		foreach($project["phases"][$key]["tasks"] as $tkey => &$tvalue){ 
			if($project["phases"][$key]["tasks"][$tkey]["cat"] == 1) {
		?>
		<!--<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
            <tr>
                <td class="tcell-left">&nbsp;</td>
                <td width="15">&nbsp;</td>
                <td width="15">&nbsp;</td>
                <td><?php echo($project["phases"][$key]["tasks"][$tkey]["text"]);?></td>
            </tr>
            <tr>
                <td class="tcell-left">&nbsp;</td>
                <td width="15">&nbsp;</td>
                <td width="15">&nbsp;</td>
                <td><?php echo($project["phases"][$key]["tasks"][$tkey]["startdate"]);?> - <?php echo($project["phases"][$key]["tasks"][$tkey]["enddate"]);?></td>
            </tr>
            <tr>
                 <td class="tcell-left">&nbsp;</td>
                 <td width="15">&nbsp;</td>
                <td width="15">&nbsp;</td>
                <td><div class="line">&nbsp;</div></td>
            </tr>
        </table>-->
<?php // } else { ?>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
            <tr>
                <td class="tcell-left">&nbsp;</td>
                <td width="18"><img src="<?php echo(CO_FILES);?>/img/milestone.png" width="18" height="18" /></td>
                <td><?php echo($project["phases"][$key]["tasks"][$tkey]["text"]);?></td>
            </tr>
            <tr>
                <td class="tcell-left">&nbsp;</td>
                <td width="15">&nbsp;</td>
                <td><?php echo($project["phases"][$key]["tasks"][$tkey]["startdate"]);?> - <?php echo($project["phases"][$key]["tasks"][$tkey]["enddate"]);?></td>
            </tr>
            <tr>
                 <td class="tcell-left">&nbsp;</td>
                <td width="15">&nbsp;</td>
                <td><div class="line">&nbsp;</div></td>
            </tr>
        </table>
    <?php } 
	 } 
    $countPhases++;
    }
}
?>
<div style="page-break-after:always;">&nbsp;</div>
<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["PRODUCTION_TIMELINE_DATES_MILESTONES"];?></td>
        <td>&nbsp;</td>
	</tr>
</table>
<table width="100%" class="standard">
    <tr>
		<td class="tcell-left"><?php echo $lang["PRODUCTION_TITLE"];?></td>
		<td><?php echo($production["title"]);?></td>
	</tr>
</table>
<table width="100%" class="standard">
    <tr>
		<td class="tcell-left">&nbsp;</td>
		<td class="grey smalltext"><?php echo($production["startdate"]);?> - <?php echo($production["enddate"]);?></td>
	</tr>
</table>
&nbsp;
<?php 
$numPhases = sizeof($production["phases"]);
if($numPhases > 0) {
	$countPhases = 1;
	foreach($production["phases"] as $key => &$value){ 
		$numTasks = sizeof($production["phases"][$key]["tasks"]);
	?>
	<?php
		foreach($production["phases"][$key]["tasks"] as $tkey => &$tvalue){ 
			if($production["phases"][$key]["tasks"][$tkey]["cat"] == 1) {
		?>
        
        <table width="100%" class="fourCols">
            <tr>
                <td class="fourCols-one">&nbsp;</td>
                <td class="fourCols-two">&nbsp;</td>
                <td class="fourCols-three greybg"><img src="<?php echo(CO_FILES);?>/img/print/milestone.png" width="12" height="12" style="margin: 2px 0 0 3px" /></td>
                <td class="fourCols-four greybg"><?php echo($production["phases"][$key]["tasks"][$tkey]["text"]);?></td>
            </tr>
            <tr>
                <td class="fourCols-one">&nbsp;</td>
                <td class="fourCols-two">&nbsp;</td>
                <td class="fourCols-three">&nbsp;</td>
                <td class="fourCols-four grey smalltext"><?php echo($production["phases"][$key]["tasks"][$tkey]["startdate"]);?> - <?php echo($production["phases"][$key]["tasks"][$tkey]["enddate"]);?></td>
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
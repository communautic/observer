<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["BRAINSTORM_GRID_TITLE"];?></td>
        <td><strong><?php echo($grid->title);?></strong></td>
	</tr>
</table>
<?php 
$numCols = sizeof($cols);
if($numCols > 0) {
	$countCols = 1;
	foreach($cols as $key => &$value){ 
		//$numTasks = sizeof($project["phases"][$key]["tasks"]);
	?>
	<?php
	$i = 0;
		foreach($cols[$key]["notes"] as $tkey => &$tvalue){ 
		
		if($i == 0) { ?>
			<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["BRAINSTORM_PHASE_TITLE"];?></td>
        <td><?php echo($countCols . ". " . $cols[$key]["notes"][$tkey]['title']);?></td>
	</tr>
</table>
		<?php } else {
		
			if($cols[$key]["notes"][$tkey]['ms'] == 0) {
		?>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
            <tr>
                <td class="tcell-left">&nbsp;</td>
                <td width="15">&nbsp;</td>
                <td width="15">&nbsp;</td>
                <td><?php echo($cols[$key]["notes"][$tkey]['title']);?></td>
            </tr>
            <tr>
                 <td class="tcell-left">&nbsp;</td>
                 <td width="15">&nbsp;</td>
                <td width="15">&nbsp;</td>
                <td><div class="line">&nbsp;</div></td>
            </tr>
        </table>
<?php } else { ?>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
            <tr>
                <td class="tcell-left">&nbsp;</td>
                <td width="15">&nbsp;</td>
                <td width="15"><img src="<?php echo(CO_FILES);?>/img/milestone.png" width="18" height="18" /></td>
                <td><?php echo($cols[$key]["notes"][$tkey]['title']);?></td>
            </tr>
            <tr>
                 <td class="tcell-left">&nbsp;</td>
                <td width="15">&nbsp;</td>
                <td width="15">&nbsp;</td>
                <td><div class="line">&nbsp;</div></td>
            </tr>
        </table>
    <?php } 
		}
		$i++;
	 } 
    $countCols++;
    }
}
?>
<div style="page-break-after:always;">&nbsp;</div>
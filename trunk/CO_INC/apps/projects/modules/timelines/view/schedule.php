<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="content-nav">Terminliste</span></td>
    <td></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11">Projekt</td>
		<td class="tcell-right bold"><a href="#" class="loadProject" rel="<?php echo($project["id"]);?>"><?php echo($project["title"]);?></a></td>
    </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"></td>
		<td class="tcell-right"><?php echo($project["startdate"]);?> - <?php echo($project["enddate"]);?></td>
    </tr>
</table>
<div class="content-spacer"></div>
<?php 
$numPhases = sizeof($project["phases"]);
if($numPhases > 0) {
	$countPhases = 1;
	foreach($project["phases"] as $key => &$value){ 
		$numTasks = sizeof($project["phases"][$key]["tasks"]);
		/*$taskline='class="td_border_top_right"';
		if($numTasks == 0) {
			$taskline='';
		}*/
	?>

<table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive">
	<tr>
	  <td class="tcell-left-inactive text11">Phase</td>
        <td class="tcell-right"><a href="#" class="loadPhase bold" rel="<?php echo($project["phases"][$key]["id"]);?>"><?php echo($countPhases . " " . $project["phases"][$key]["title"]);?></a><br />
        <span class="text11 content-date">Dauer</span><span class="text11"><?php echo($project["phases"][$key]["startdate"]);?> - <?php echo($project["phases"][$key]["enddate"]);?></span><br />
        </td>
	</tr>
</table>
            <?php
			//$taskcount = 1;
		foreach($project["phases"][$key]["tasks"] as $tkey => &$tvalue){ 
			if($project["phases"][$key]["tasks"][$tkey]["cat"] == 0) {
		?>
            
            <table border="0" cellspacing="0" cellpadding="0" class="table-content">
                <tr>
                  <td class="tcell-left-inactive text11"></td>
                   <td width="20"></td>
                  <td width="20"></td>
                    <td class="tcell-right"><?php echo($project["phases"][$key]["tasks"][$tkey]["text"]);?><br />
                    <span class="text11 content-date">Dauer</span><span class="text11"><?php echo($project["phases"][$key]["tasks"][$tkey]["startdate"]);?> - <?php echo($project["phases"][$key]["tasks"][$tkey]["enddate"]);?></span>
                    </td>
                </tr>
            </table>
			<?php } else { ?>
            <table border="0" cellspacing="0" cellpadding="0" class="table-content">
                <tr>
                  <td class="tcell-left-inactive text11"></td>
                   <td width="20"></td>
                  <td width="20"><span class="icon-milestone"></span></td>
                    <td class="tcell-right"><?php echo($project["phases"][$key]["tasks"][$tkey]["text"]);?><br />
                    <span class="text11 content-date">Zeitpunkt</span><span class="text11"><?php echo($project["phases"][$key]["tasks"][$tkey]["startdate"]);?></span>
                    </td>
                </tr>
            </table>
            <?php } 
				//if($taskcount < $numTasks) {
					echo('<div class="content-line-grey"></div>');
				//}
			//$taskcount++;
			
			?>
		<?php } ?>
    <?php 
    $countPhases++;
    }
}
?>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left">Stand <?php echo($project["datetime"]);?></td>
    <td class="middle"></td>
    <td class="right"></td>
  </tr>
</table>
</div>
<div class="table-title-outer">
<table border="0" cellspacing="0" cellpadding="0" class="table-title grey">
  <tr>
    <td class="tcell-left text11"><span class="content-nav-title"><?php echo $lang["PRODUCTION_TIMELINE_DATES_LIST"];?></span></td>
    <td></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<table border="0" cellpadding="0" cellspacing="0" class="table-content loadProduction" rel="<?php echo($production["id"]);?>">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PRODUCTION_TITLE"];?></td>
		<td class="tcell-right bold"><span class="co-link"><?php echo($production["title"]);?></span></td>
    </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content loadProduction" rel="<?php echo($production["id"]);?>">
	<tr>
		<td class="tcell-left-inactive text11"></td>
		<td class="tcell-right"><?php echo($production["startdate"]);?> - <?php echo($production["enddate"]);?></td>
    </tr>
</table>
<div class="content-spacer"></div>
<?php 
$numPhases = sizeof($production["phases"]);
if($numPhases > 0) {
	$countPhases = 1;
	foreach($production["phases"] as $key => &$value){ 
		$numTasks = sizeof($production["phases"][$key]["tasks"]);
	?>

<table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive loadProductionsPhase" rel="<?php echo($production["phases"][$key]["id"]);?>">
	<tr>
	  <td class="tcell-left-inactive text11"><?php echo $lang["PRODUCTION_PHASE_TITLE"];?></td>
        <td class="tcell-right"><span class="co-link bold"><?php echo($countPhases . ". " . $production["phases"][$key]["title"]);?></span><br />
        <span class="text11 content-date"><?php echo $lang["GLOBAL_DURATION"];?></span><span class="text11"><?php echo($production["phases"][$key]["startdate"]);?> - <?php echo($production["phases"][$key]["enddate"]);?></span><br />
        </td>
	</tr>
</table>
            <?php
			//$taskcount = 1;
		foreach($production["phases"][$key]["tasks"] as $tkey => &$tvalue){ 
			if($production["phases"][$key]["tasks"][$tkey]["cat"] == 0) {
		?>
            
            <table border="0" cellspacing="0" cellpadding="0" class="table-content loadProductionsPhase" rel="<?php echo($production["phases"][$key]["id"]);?>">
                <tr>
                  <td class="tcell-left-inactive text11"></td>
                   <td width="20"></td>
                  <td width="20"></td>
                    <td class="tcell-right"><?php echo($production["phases"][$key]["tasks"][$tkey]["text"]);?><br />
                    <span class="text11 content-date"><?php echo $lang["GLOBAL_DURATION"];?></span><span class="text11"><?php echo($production["phases"][$key]["tasks"][$tkey]["startdate"]);?> - <?php echo($production["phases"][$key]["tasks"][$tkey]["enddate"]);?></span>
                    </td>
                </tr>
            </table>
			<?php } else { ?>
            <table border="0" cellspacing="0" cellpadding="0" class="table-content loadProductionsPhase" rel="<?php echo($production["phases"][$key]["id"]);?>">
                <tr>
                  <td class="tcell-left-inactive text11"></td>
                   <td width="20"></td>
                  <td width="20"><span class="icon-milestone"></span></td>
                    <td class="tcell-right"><?php echo($production["phases"][$key]["tasks"][$tkey]["text"]);?><br />
                    <span class="text11 content-date"><?php echo $lang["PRODUCTION_PHASE_MILESTONE_DATE"];?></span><span class="text11"><?php echo($production["phases"][$key]["tasks"][$tkey]["startdate"]);?></span>
                    </td>
                </tr>
            </table>
            <?php } 

					echo('<div class="content-line-grey"></div>');
			
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
    <td class="left"><?php echo($lang["GLOBAL_FOOTER_STATUS"] . " " . $production["datetime"]);?></td>
    <td class="middle"></td>
    <td class="right"></td>
  </tr>
</table>
</div>
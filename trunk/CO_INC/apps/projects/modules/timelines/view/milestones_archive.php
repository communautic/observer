<div class="table-title-outer">
<table border="0" cellspacing="0" cellpadding="0" class="table-title grey">
  <tr>
    <td class="tcell-left text11"><span class="content-nav-title"><?php echo $lang["PROJECT_TIMELINE_DATES_MILESTONES"];?></span></td>
    <td></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<table border="0" cellpadding="0" cellspacing="0" class="table-content" rel="<?php echo($project["id"]);?>">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PROJECT_TITLE"];?></td>
		<td class="tcell-right bold"><span><?php echo($project["title"]);?></span></td>
    </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content" rel="<?php echo($project["id"]);?>">
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
		foreach($project["phases"][$key]["tasks"] as $tkey => &$tvalue){ 
			if($project["phases"][$key]["tasks"][$tkey]["cat"] == 1) {
		?>
            
            <table border="0" cellspacing="0" cellpadding="0" class="table-content" rel="<?php echo($project["phases"][$key]["id"]);?>">
                <tr>
                  <td class="tcell-left-inactive text11"></td>
                  <td width="20"><span class="icon-milestone"></span></td>
                    <td class="tcell-right"><?php echo($project["phases"][$key]["tasks"][$tkey]["text"]);?><br />
                    <span class="text11 content-date"><?php echo $lang["PROJECT_PHASE_MILESTONE_DATE"];?></span><span class="text11"><?php echo($project["phases"][$key]["tasks"][$tkey]["startdate"]);?></span>
                    </td>
                </tr>
            </table>
            <?php 
			
			echo('<div class="content-line-grey"></div>');
			
			} 

					
			
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
    <td class="left"><?php echo($lang["GLOBAL_FOOTER_STATUS"] . " " . $project["datetime"]);?></td>
    <td class="middle"></td>
    <td class="right"></td>
  </tr>
</table>
</div>
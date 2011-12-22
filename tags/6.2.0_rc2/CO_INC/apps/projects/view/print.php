<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["PROJECT_TITLE"];?></td>
        <td><strong><?php echo($project->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["GLOBAL_DURATION"];?></td>
		<td><?php echo($project->startdate)?> - <?php echo($project->enddate)?></td>
    </tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['PROJECT_KICKOFF'];?></td>
		<td><?php echo($project->startdate)?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PROJECT_FOLDER"];?></td>
        <td><?php echo($project->folder);?></td>
	</tr>
</table>
&nbsp;
<?php if(!empty($project->ordered_by_print) || !empty($project->ordered_by_ct)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PROJECT_CLIENT"];?></td>
		<td><?php echo($project->ordered_by_print);?><br /><?php echo($project->ordered_by_ct);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($project->management_print) || !empty($project->management_ct)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PROJECT_MANAGEMENT"];?></td>
		<td><?php echo($project->management_print);?><br /><?php echo($project->management_ct);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($project->team_print) || !empty($project->team_ct)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PROJECT_TEAM"];?></td>
		<td><?php echo($project->team_print);?><br /><?php echo($project->team_ct);?></td>
	</tr>
</table>
<?php } ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($project->status_text);?> <?php echo($project->status_date)?></td>
	</tr>
</table>
<?php if(!empty($project->protocol)) { ?>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["PROJECT_DESCRIPTION"];?></td>
        <td><?php echo(nl2br($project->protocol));?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<?php
if(is_array($phases)) {
	$i = 1;
	foreach ($phases as $phase) { ?>
    <table width="100%" class="fourCols">
	<tr>
		<td class="fourCols-one"><?php if($i == 1) { echo $lang["PROJECT_PHASES"]; }?>&nbsp;</td>
		<td class="fourCols-two">&nbsp;</td>
        <td class="fourCols-three greybg">&nbsp;</td>
        <td class="fourCols-four greybg"><?php echo($num[$phase->id] . " " . $phase->title);?></td>
	</tr>
    <tr>
		<td class="fourCols-one">&nbsp;</td>
		<td class="fourCols-two">&nbsp;</td>
        <td class="fourCols-three">&nbsp;</td>
        <td class="grey smalltext fourCols-paddingTop"><?php echo $lang["GLOBAL_DURATION"];?> <?php echo($phase->startdate . " - " . $phase->enddate);?>&nbsp;</td>
	</tr>
        <tr>
		<td class="fourCols-one">&nbsp;</td>
		<td class="fourCols-two">&nbsp;</td>
        <td class="fourCols-three">&nbsp;</td>
        <td class="grey smalltext"><?php if($project->access != "guest") { ?><?php echo $lang["PROJECT_FOLDER_CHART_REALISATION"];?> <?php echo($phase->realisation);?>%<?php } ?><br />&nbsp;</td>
	</tr>
</table>
    <?php 
	$i++;
	}
}
?>
<div style="page-break-after:always;">&nbsp;</div>
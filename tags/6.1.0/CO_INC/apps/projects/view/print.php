<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["PROJECT_TITLE"];?></td>
        <td><strong><?php echo($project->title);?></strong></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["GLOBAL_DURATION"];?></td>
		<td><?php echo($project->startdate)?> - <?php echo($project->enddate)?></td>
    </tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang['PROJECT_KICKOFF'];?></td>
		<td><?php echo($project->startdate)?></td>
	</tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["PROJECT_FOLDER"];?></td>
        <td><?php echo($project->folder);?></td>
	</tr>
</table>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
	<?php if(!empty($project->ordered_by) || !empty($project->ordered_by_ct)) { ?>
    <tr>
		<td class="tcell-left"><?php echo $lang["PROJECT_CLIENT"];?></td>
		<td><?php echo($project->ordered_by);?><br /><?php echo($project->ordered_by_ct);?></td>
	</tr>
    <?php } ?>
	<?php if(!empty($project->management) || !empty($project->management_ct)) { ?>
    <tr>
		<td class="tcell-left"><?php echo $lang["PROJECT_MANAGEMENT"];?></td>
		<td><?php echo($project->management);?><br /><?php echo($project->management_ct);?></td>
	</tr>
    <?php } ?>
    <?php if(!empty($project->team) || !empty($project->team_ct)) { ?>
	<tr>
		<td class="tcell-left"><?php echo $lang["PROJECT_TEAM"];?></td>
		<td><?php echo($project->team);?><br /><?php echo($project->team_ct);?></td>
	</tr>
    <?php } ?>
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($project->status_text);?> <?php echo($project->status_date)?></td>
	</tr>
</table>
<?php if(!empty($project->protocol)) { ?>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey" style="padding: 10pt 10pt 10pt 15pt;">
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
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
	<tr>
		<td class="tcell-left">
        <?php if($i == 1) { echo $lang["PROJECT_PHASES"]; }?>&nbsp;
        </td>
		<td class="greybg"><?php echo($num[$phase->id] . " " . $phase->title);?></td>
	</tr>
    <tr>
		<td class="tcell-left">&nbsp;</td>
		<td class="grey smalltext"><?php echo $lang["GLOBAL_DURATION"];?> <?php echo($phase->startdate . " - " . $phase->enddate);?>
        <br />&nbsp;
</td>
	</tr>
</table>
    <?php 
	$i++;
	}
}
?>
<div style="page-break-after:always;">&nbsp;</div>
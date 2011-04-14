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
        <td><?php echo($project->projectfolder);?></td>
	</tr>
</table>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PROJECT_CLIENT"];?></td>
		<td><?php echo($project->ordered_by);?><br /><?php echo($project->ordered_by_ct);?></td>
	</tr>
	<tr>
		<td class="tcell-left"><?php echo $lang["PROJECT_MANAGEMENT"];?></td>
		<td><?php echo($project->management);?><br /><?php echo($project->management_ct);?></td>
	</tr>
	<tr>
		<td class="tcell-left"><?php echo $lang["PROJECT_TEAM"];?></td>
		<td><?php echo($project->team);?><br /><?php echo($project->team_ct);?></td>
	</tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($project->status_text);?> <?php echo($project->status_date)?></td>
	</tr>
</table>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey" style="padding: 10pt 10pt 10pt 10pt;">
	<tr>
        <td class="tcell-left top"><?php echo $lang["PROJECT_DESCRIPTION"];?></td>
        <td><?php echo($project->protocol);?></td>
	</tr>
</table>
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
		<td><?php echo($num[$phase->id] . " " . $phase->title);?></td>
	</tr>
    <tr>
		<td class="tcell-left">&nbsp;</td>
		<td><?php echo $lang["GLOBAL_DURATION"];?> <?php echo($phase->startdate . " - " . $phase->enddate);?>
        <div class="line">&nbsp;</div>
        </td>
	</tr>
</table>
    <?php 
	$i++;
	}
}
?>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
    <tr>
		<td class="tcell-left top grey"><?php echo$lang["GLOBAL_EMAILED_TO"];?></td>
		<td><?php 
			foreach($sendto as $value) { 
			echo '<div class="grey">' . $value->who . ', ' . $value->date . '</div>';
		 } ?></td>
	</tr>
</table>
<div style="page-break-after:always;">&nbsp;</div>
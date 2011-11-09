<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["CLIENT_TITLE"];?></td>
        <td><strong><?php echo($client->title);?></strong></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["GLOBAL_DURATION"];?></td>
		<td><?php echo($client->startdate)?> - <?php echo($client->enddate)?></td>
    </tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang['CLIENT_KICKOFF'];?></td>
		<td><?php echo($client->startdate)?></td>
	</tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["CLIENT_FOLDER"];?></td>
        <td><?php echo($client->folder);?></td>
	</tr>
</table>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
	<?php if(!empty($client->ordered_by) || !empty($client->ordered_by_ct)) { ?>
    <tr>
		<td class="tcell-left"><?php echo $lang["CLIENT_CLIENT"];?></td>
		<td><?php echo($client->ordered_by);?><br /><?php echo($client->ordered_by_ct);?></td>
	</tr>
    <?php } ?>
	<?php if(!empty($client->management) || !empty($client->management_ct)) { ?>
    <tr>
		<td class="tcell-left"><?php echo $lang["CLIENT_MANAGEMENT"];?></td>
		<td><?php echo($client->management);?><br /><?php echo($client->management_ct);?></td>
	</tr>
    <?php } ?>
    <?php if(!empty($client->team) || !empty($client->team_ct)) { ?>
	<tr>
		<td class="tcell-left"><?php echo $lang["CLIENT_TEAM"];?></td>
		<td><?php echo($client->team);?><br /><?php echo($client->team_ct);?></td>
	</tr>
    <?php } ?>
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($client->status_text);?> <?php echo($client->status_date)?></td>
	</tr>
</table>
<?php if(!empty($client->protocol)) { ?>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey" style="padding: 10pt 10pt 10pt 15pt;">
	<tr>
        <td class="tcell-left top"><?php echo $lang["CLIENT_DESCRIPTION"];?></td>
        <td><?php echo(nl2br($client->protocol));?></td>
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
        <?php if($i == 1) { echo $lang["CLIENT_PHASES"]; }?>&nbsp;
        </td>
		<td class="greybg"><?php echo($num[$phase->id] . " " . $phase->title);?></td>
	</tr>
    <tr>
		<td class="tcell-left">&nbsp;</td>
		<td class="grey smalltext"><?php echo $lang["GLOBAL_DURATION"];?> <?php echo($phase->startdate . " - " . $phase->enddate);?>&nbsp;
</td>
	</tr>
        <tr>
		<td class="tcell-left">&nbsp;</td>
		<td class="grey smalltext"><?php if($client->access != "guest") { ?><?php echo $lang["CLIENT_FOLDER_CHART_REALISATION"];?> <?php echo($phase->realisation);?>%<?php } ?>
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
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["PUBLISHER_TITLE"];?></td>
        <td><strong><?php echo($publisher->title);?></strong></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["GLOBAL_DURATION"];?></td>
		<td><?php echo($publisher->startdate)?> - <?php echo($publisher->enddate)?></td>
    </tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang['PUBLISHER_KICKOFF'];?></td>
		<td><?php echo($publisher->startdate)?></td>
	</tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["PUBLISHER_FOLDER"];?></td>
        <td><?php echo($publisher->folder);?></td>
	</tr>
</table>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
	<?php if(!empty($publisher->ordered_by) || !empty($publisher->ordered_by_ct)) { ?>
    <tr>
		<td class="tcell-left"><?php echo $lang["PUBLISHER_CLIENT"];?></td>
		<td><?php echo($publisher->ordered_by);?><br /><?php echo($publisher->ordered_by_ct);?></td>
	</tr>
    <?php } ?>
	<?php if(!empty($publisher->management) || !empty($publisher->management_ct)) { ?>
    <tr>
		<td class="tcell-left"><?php echo $lang["PUBLISHER_MANAGEMENT"];?></td>
		<td><?php echo($publisher->management);?><br /><?php echo($publisher->management_ct);?></td>
	</tr>
    <?php } ?>
    <?php if(!empty($publisher->team) || !empty($publisher->team_ct)) { ?>
	<tr>
		<td class="tcell-left"><?php echo $lang["PUBLISHER_TEAM"];?></td>
		<td><?php echo($publisher->team);?><br /><?php echo($publisher->team_ct);?></td>
	</tr>
    <?php } ?>
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($publisher->status_text);?> <?php echo($publisher->status_date)?></td>
	</tr>
</table>
<?php if(!empty($publisher->protocol)) { ?>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey" style="padding: 10pt 10pt 10pt 15pt;">
	<tr>
        <td class="tcell-left top"><?php echo $lang["PUBLISHER_DESCRIPTION"];?></td>
        <td><?php echo(nl2br($publisher->protocol));?></td>
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
        <?php if($i == 1) { echo $lang["PUBLISHER_PHASES"]; }?>&nbsp;
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
		<td class="grey smalltext"><?php if($publisher->access != "guest") { ?><?php echo $lang["PUBLISHER_FOLDER_CHART_REALISATION"];?> <?php echo($phase->realisation);?>%<?php } ?>
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
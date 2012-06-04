<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["PRODUCTION_TITLE"];?></td>
        <td><strong><?php echo($production->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["GLOBAL_DURATION"];?></td>
		<td><?php echo($production->startdate)?> - <?php echo($production->enddate)?></td>
    </tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['PRODUCTION_KICKOFF'];?></td>
		<td><?php echo($production->startdate)?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PRODUCTION_FOLDER"];?></td>
        <td><?php echo($production->folder);?></td>
	</tr>
</table>
&nbsp;
<?php if(!empty($production->ordered_by_print) || !empty($production->ordered_by_ct)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PRODUCTION_CLIENT"];?></td>
		<td><?php echo($production->ordered_by_print);?><br /><?php echo($production->ordered_by_ct);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($production->management_print) || !empty($production->management_ct)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PRODUCTION_MANAGEMENT"];?></td>
		<td><?php echo($production->management_print);?><br /><?php echo($production->management_ct);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($production->team_print) || !empty($production->team_ct)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PRODUCTION_TEAM"];?></td>
		<td><?php echo($production->team_print);?><br /><?php echo($production->team_ct);?></td>
	</tr>
</table>
<?php } ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($production->status_text);?> <?php echo($production->status_date)?></td>
	</tr>
</table>
<?php if(!empty($production->protocol)) { ?>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["PRODUCTION_DESCRIPTION"];?></td>
        <td><?php echo(nl2br($production->protocol));?></td>
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
		<td class="fourCols-one"><?php if($i == 1) { echo $lang["PRODUCTION_PHASES"]; }?>&nbsp;</td>
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
        <td class="grey smalltext"><?php if($production->access != "guest") { ?><?php echo $lang["PRODUCTION_FOLDER_CHART_REALISATION"];?> <?php echo($phase->realisation);?>%<?php } ?><br />&nbsp;</td>
	</tr>
</table>
    <?php 
	$i++;
	}
}
?>
<div style="page-break-after:always;">&nbsp;</div>
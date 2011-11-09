<table width="100%" class="title grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["CLIENT_MEETING_TITLE"];?></td>
        <td><strong><?php echo($meeting->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard-grey">
	<tr>
		<td class="tcell-left"><?php echo $lang["CLIENT_MEETING_DATE"];?></td>
		<td><?php echo($meeting->item_date)?></td>
    </tr>
</table>
<table width="100%" class="standard-grey">
	<tr>
	  <td class="tcell-left"><?php echo $lang["CLIENT_MEETING_TIME_START"];?></td>
        <td><?php echo($meeting->start);?></td>
	</tr>
</table>
<table width="100%" class="standard-grey">
	<tr>
	  <td class="tcell-left"><?php echo $lang["CLIENT_MEETING_TIME_END"];?></td>
        <td><?php echo($meeting->end);?></td>
	</tr>
</table>
<table width="100%" class="standard-grey">
    <tr>
	  <td class="tcell-left"><?php echo $lang["CLIENT_MEETING_PLACE"];?></td>
        <td><?php echo($meeting->location);?></td>
	</tr>
</table>
<?php if(!empty($meeting->participants_print) || !empty($meeting->participants_ct)) { ?>
<table width="100%" class="standard-grey">
	<tr>
		<td class="tcell-left"><?php echo $lang["CLIENT_MEETING_ATTENDEES"];?></td>
		<td><?php echo($meeting->participants)?></td>
    </tr>
</table>
<?php } ?>
<?php if(!empty($meeting->management_print) || !empty($meeting->management_ct)) { ?>
<table width="100%" class="standard-grey">
	<tr>
	  <td class="tcell-left"><?php echo $lang["CLIENT_MEETING_MANAGEMENT"];?></td>
        <td><?php echo($meeting->management);?></td>
	</tr>
</table>
<?php } ?>
<table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($meeting->status_text);?> <?php echo($meeting->status_date)?></td>
	</tr>
</table>
&nbsp;
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["CLIENT_MEETING_GOALS"];?></td>
		<td>&nbsp;</td>
    </tr>
</table>
<?php
$i = 1;
foreach($task as $value) { 
	$img = '&nbsp;';
	if($value->status == 1) {
		$img = '<img src="' . CO_FILES . '/img/print/done.png" width="12" height="12" vspace="2" hspace="4" /> ';
	}
     ?>
    <table width="100%" class="fourCols-grey">
        <tr>
            <td class="fourCols-three greybg"><?php echo $img;?></td>
            <td class="fourCols-four greybg"><strong><?php echo($value->title);?></strong></td>
        </tr>
     </table>
      <?php echo(nl2br($value->text));?>
    <br />&nbsp;
	<?php 
	$i++;
	}
?>
<div style="page-break-after:always;">&nbsp;</div>
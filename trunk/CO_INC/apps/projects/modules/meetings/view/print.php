<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["MEETING_TITLE"];?></td>
        <td><strong><?php echo($meeting->title);?></strong></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
		<td class="tcell-left"><?php echo $lang["MEETING_DATE"];?></td>
		<td><?php echo($meeting->meeting_date)?></td>
    </tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["MEETING_TIME_START"];?></td>
        <td><?php echo($meeting->start);?></td>
	</tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["MEETING_TIME_END"];?></td>
        <td><?php echo($meeting->end);?></td>
	</tr>
    <tr>
	  <td class="tcell-left"><?php echo $lang["MEETING_PLACE"];?></td>
        <td><?php echo($meeting->location);?></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
		<td class="tcell-left"><?php echo $lang["MEETING_ATTENDEES"];?></td>
		<td><?php echo($meeting->participants)?></td>
    </tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["MEETING_MANAGEMENT"];?></td>
        <td><?php echo($meeting->management);?></td>
	</tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($meeting->status_text);?> <?php echo($meeting->status_date)?></td>
	</tr>
</table>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["MEETING_GOALS"];?></td>
		<td>&nbsp;</td>
    </tr>
</table>
<?php
$i = 1;
foreach($task as $value) { 
	$img = '&nbsp;';
	if($value->status == 1) {
		$img = '<img src="' . CO_FILES . '/img/print/done_grey.png" width="15" height="15" vspace="4" /> ';
	}
     ?>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="greyList">
        <tr>
            <td class="short"><?php echo $img;?></td>
            <td><strong><?php echo($value->title);?></strong></td>
        </tr>
     </table>
     &nbsp;<br />
      <?php echo(nl2br($value->text));?>
    <br />&nbsp;
    <br />&nbsp;
	<?php 
	$i++;
	}
?>
<div style="page-break-after:always;">&nbsp;</div>
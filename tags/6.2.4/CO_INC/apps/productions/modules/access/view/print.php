<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["PRODUCTION_MEETING_TITLE"];?></td>
        <td><strong><?php echo($meeting->title);?></strong></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PRODUCTION_MEETING_DATE"];?></td>
		<td><?php echo($meeting->meeting_date)?></td>
    </tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["PRODUCTION_MEETING_TIME_START"];?></td>
        <td><?php echo($meeting->start);?></td>
	</tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["PRODUCTION_MEETING_TIME_END"];?></td>
        <td><?php echo($meeting->end);?></td>
	</tr>
    <tr>
	  <td class="tcell-left"><?php echo $lang["PRODUCTION_MEETING_PLACE"];?></td>
        <td><?php echo($meeting->location);?></td>
	</tr>
</table>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PRODUCTION_MEETING_ATTENDEES"];?></td>
		<td><?php echo($meeting->participants)?></td>
    </tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["PRODUCTION_MEETING_MANAGEMENT"];?></td>
        <td><?php echo($meeting->management);?></td>
	</tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($meeting->status_text);?> <?php echo($meeting->status_date)?></td>
	</tr>
</table>
&nbsp;
<?php
$i = 1;
foreach($task as $value) { 
	$img = '&nbsp;';
	if($value->status == 1) {
		$img = '<img src="' . CO_FILES . '/img/print/done.png" width="18" height="18" vspace="2" /> ';
	}
     ?>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
        <tr>
            <td class="tcell-left-short"><?php if($i == 1) { echo $lang["PRODUCTION_MEETING_GOALS"]; }?>&nbsp;</td>
            <td class="short"><?php echo $img;?></td>
            <td class="greybg"><?php echo($value->title);?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo(nl2br($value->text));?>
            </td>
        </tr>
		<tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>
    
	<?php 
	$i++;
	}
?>
<div style="page-break-after:always;">&nbsp;</div>
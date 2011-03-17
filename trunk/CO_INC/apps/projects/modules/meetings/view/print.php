<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["MEETING_TITLE"];?></td>
        <td><strong><?php echo($meeting->title);?></strong></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
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
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["MEETING_ATTENDEES"];?></td>
		<td><?php echo($meeting->participants)?></td>
    </tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["MEETING_MANAGEMENT"];?></td>
        <td><?php echo($meeting->management);?></td>
	</tr>
</table>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
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
            <td class="tcell-left-short"><?php if($i == 1) { echo $lang["MEETING_GOALS"]; }?>&nbsp;</td>
            <td class="short"><?php echo $img;?></td>
            <td><?php echo($value->title);?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo($value->text);?>
            </td>
        </tr>
		<tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div class="line">&nbsp;</div></td>
        </tr>
    </table>
    
	<?php 
	$i++;
	}
?>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["DOCUMENT_DOCUMENTS"];?></td>
        <td><?php echo($meeting->documents)?></td>
	</tr>
    <tr>
		<td class="tcell-left"><?php echo $lang["GLOBAL_ACCESS"];?></td>
		<td><?php echo($meeting->access_text)?></td>
	</tr>
    <tr>
		<td class="tcell-left"><?php echo$lang["GLOBAL_EMAILED_TO"];?></td>
		<td><?php echo($meeting->emailed_to)?></td>
	</tr>
</table>
<div style="page-break-after:always;">&nbsp;</div>
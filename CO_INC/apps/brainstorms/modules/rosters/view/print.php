<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["BRAINSTORM_ROSTER_TITLE"];?></td>
        <td><strong><?php echo($roster->title);?></strong></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
		<td class="tcell-left"><?php echo $lang["BRAINSTORM_ROSTER_DATE"];?></td>
		<td><?php echo($roster->item_date)?></td>
    </tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["BRAINSTORM_ROSTER_TIME_START"];?></td>
        <td><?php echo($roster->start);?></td>
	</tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["BRAINSTORM_ROSTER_TIME_END"];?></td>
        <td><?php echo($roster->end);?></td>
	</tr>
    <tr>
	  <td class="tcell-left"><?php echo $lang["BRAINSTORM_ROSTER_PLACE"];?></td>
        <td><?php echo($roster->location);?></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
		<td class="tcell-left"><?php echo $lang["BRAINSTORM_ROSTER_ATTENDEES"];?></td>
		<td><?php echo($roster->participants)?></td>
    </tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["BRAINSTORM_ROSTER_MANAGEMENT"];?></td>
        <td><?php echo($roster->management);?></td>
	</tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($roster->status_text);?> <?php echo($roster->status_date)?></td>
	</tr>
</table>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["BRAINSTORM_ROSTER_GOALS"];?></td>
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
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["PROJECT_PHONECALL_TITLE"];?></td>
        <td><strong><?php echo($phonecall->title);?></strong></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
		<td class="tcell-left"><?php echo $lang["PROJECT_PHONECALL_DATE"];?></td>
		<td><?php echo($phonecall->item_date)?></td>
    </tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["PROJECT_PHONECALL_TIME_START"];?></td>
        <td><?php echo($phonecall->start);?></td>
	</tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["PROJECT_PHONECALL_TIME_END"];?></td>
        <td><?php echo($phonecall->end);?></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PROJECT_PHONECALL_MANAGEMENT"];?></td>
        <td><?php echo($phonecall->management);?></td>
	</tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($phonecall->status_text);?> <?php echo($phonecall->status_date)?></td>
	</tr>
</table>
&nbsp;
<?php if(!empty($phonecall->protocol)) { ?>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey" style="padding: 10pt 10pt 10pt 15pt;">
	<tr>
        <td class="tcell-left top"><?php echo $lang["PROJECT_PHONECALL_GOALS"];?></td>
        <td><?php echo(nl2br($phonecall->protocol));?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<div style="page-break-after:always;">&nbsp;</div>
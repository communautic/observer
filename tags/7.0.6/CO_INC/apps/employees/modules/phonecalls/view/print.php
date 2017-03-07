<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["EMPLOYEE_PHONECALL_TITLE"];?></td>
        <td><strong><?php echo($phonecall->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_PHONECALL_DATE"];?></td>
		<td><?php echo($phonecall->item_date)?></td>
    </tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["EMPLOYEE_PHONECALL_TIME_START"];?></td>
        <td><?php echo($phonecall->start);?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["EMPLOYEE_PHONECALL_TIME_END"];?></td>
        <td><?php echo($phonecall->end);?></td>
	</tr>
</table>
<?php if(!empty($phonecall->management_print) || !empty($phonecall->management_ct)) { ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["EMPLOYEE_PHONECALL_MANAGEMENT"];?></td>
        <td><?php echo($phonecall->management);?><br /><?php echo($phonecall->management_ct);?></td>
	</tr>
</table>
<?php } ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["EMPLOYEE_PHONECALL_TYPE"];?></td>
        <td><?php echo($phonecall->status_text);?> <?php echo($phonecall->status_date)?></td>
	</tr>
</table>
&nbsp;
<?php if(!empty($phonecall->protocol)) { ?>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["EMPLOYEE_PHONECALL_GOALS"];?></td>
        <td><?php echo(nl2br($phonecall->protocol));?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<div style="page-break-after:always;">&nbsp;</div>
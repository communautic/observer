<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["EMPLOYEE_TITLE"];?></td>
        <td><strong><?php echo($employee->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["GLOBAL_DURATION"];?></td>
		<td><?php echo($employee->startdate)?> - <?php echo($employee->enddate)?></td>
    </tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['EMPLOYEE_KICKOFF'];?></td>
		<td><?php echo($employee->startdate)?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["EMPLOYEE_FOLDER"];?></td>
        <td><?php echo($employee->folder);?></td>
	</tr>
</table>
&nbsp;
<?php if(!empty($employee->ordered_by_print) || !empty($employee->ordered_by_ct)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_CLIENT"];?></td>
		<td><?php echo($employee->ordered_by_print);?><br /><?php echo($employee->ordered_by_ct);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($employee->management_print) || !empty($employee->management_ct)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_MANAGEMENT"];?></td>
		<td><?php echo($employee->management_print);?><br /><?php echo($employee->management_ct);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($employee->team_print) || !empty($employee->team_ct)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_TEAM"];?></td>
		<td><?php echo($employee->team_print);?><br /><?php echo($employee->team_ct);?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<?php if(!empty($employee->employee)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_EMPLOYEECAT"];?></td>
		<td><?php echo($employee->employee);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($employee->employee_more)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_EMPLOYEECATMORE"];?></td>
		<td><?php echo($employee->employee_more);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($employee->employee_cat)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_CAT"];?></td>
		<td><?php echo($employee->employee_cat);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($employee->employee_cat_more)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_CAT_MORE"];?></td>
		<td><?php echo($employee->employee_cat_more);?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<?php if(!empty($employee->product)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_PRODUCT_NUMBER"];?></td>
		<td><?php echo($employee->product);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($employee->product_desc)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_PRODUCT"];?></td>
		<td><?php echo($employee->product_desc);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($employee->charge)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_CHARGE"];?></td>
		<td><?php echo($employee->charge);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($employee->number)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_NUMBER"];?></td>
		<td><?php echo($employee->number);?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($employee->status_text);?> <?php echo($employee->status_text_time);?> <?php echo($employee->status_date)?></td>
	</tr>
</table>
<?php if(!empty($employee->protocol)) { ?>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["EMPLOYEE_DESCRIPTION"];?></td>
        <td><?php echo(nl2br($employee->protocol));?></td>
	</tr>
</table>
<?php } ?>
<div style="page-break-after:always;">&nbsp;</div>
<table width="100%" class="title grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["EMPLOYEE_OBJECTIVE_TITLE"];?></td>
        <td><strong><?php echo($objective->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard-grey">
	<tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_OBJECTIVE_DATE"];?></td>
		<td><?php echo($objective->item_date)?></td>
    </tr>
</table>
<table width="100%" class="standard-grey">
	<tr>
	  <td class="tcell-left"><?php echo $lang["EMPLOYEE_OBJECTIVE_TIME_START"];?></td>
        <td><?php echo($objective->start);?></td>
	</tr>
</table>
<table width="100%" class="standard-grey">
	<tr>
	  <td class="tcell-left"><?php echo $lang["EMPLOYEE_OBJECTIVE_TIME_END"];?></td>
        <td><?php echo($objective->end);?></td>
	</tr>
</table>
<table width="100%" class="standard-grey">
    <tr>
	  <td class="tcell-left"><?php echo $lang["EMPLOYEE_OBJECTIVE_PLACE"];?></td>
        <td><?php echo($objective->location);?></td>
	</tr>
</table>
<?php if(!empty($objective->participants_print) || !empty($objective->participants_ct)) { ?>
<table width="100%" class="standard-grey">
	<tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_OBJECTIVE_ATTENDEES"];?></td>
		<td><?php echo($objective->participants_print)?><br /><?php echo($objective->participants_ct);?></td>
    </tr>
</table>
<?php } ?>
<?php if(!empty($objective->management_print) || !empty($objective->management_ct)) { ?>
<table width="100%" class="standard-grey">
	<tr>
	  <td class="tcell-left"><?php echo $lang["EMPLOYEE_OBJECTIVE_MANAGEMENT"];?></td>
        <td><?php echo($objective->management_print);?><br /><?php echo($objective->management_ct);?></td>
	</tr>
</table>
<?php } ?>
<table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($objective->status_text);?> <?php echo($objective->status_text_time);?> <?php echo($objective->status_date)?></td>
	</tr>
</table>
&nbsp;
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_OBJECTIVE_GOALS"];?></td>
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
            <td class="fourCols-three-15 greybg"><?php echo $img;?></td>
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
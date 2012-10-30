<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["PATIENT_REPORT_TITLE"];?></td>
        <td><strong><?php echo($report->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_REPORT_DATE"];?></td>
		<td><?php echo($report->item_date)?></td>
    </tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PATIENT_REPORT_TIME_START"];?></td>
        <td><?php echo($report->start);?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PATIENT_REPORT_TIME_END"];?></td>
        <td><?php echo($report->end);?></td>
	</tr>
</table>
<?php if(!empty($report->management_print) || !empty($report->management_ct)) { ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PATIENT_REPORT_MANAGEMENT"];?></td>
        <td><?php echo($report->management);?><br /><?php echo($report->management_ct);?></td>
	</tr>
</table>
<?php } ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PATIENT_REPORT_TYPE"];?></td>
        <td><?php echo($report->status_text);?> <?php echo($report->status_date)?></td>
	</tr>
</table>
&nbsp;
<?php if(!empty($report->protocol)) { ?>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["PATIENT_REPORT_GOALS"];?></td>
        <td><?php echo(nl2br($report->protocol));?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<div style="page-break-after:always;">&nbsp;</div>
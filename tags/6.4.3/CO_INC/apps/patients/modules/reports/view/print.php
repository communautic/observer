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
	  <td class="tcell-left">Patient</td>
        <td><?php echo($report->treatment_patient)?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PATIENT_REPORT_DOCTOR_DIAGNOSE"];?></td>
        <td><?php echo($report->treatment_diagnose)?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PATIENT_REPORT_TREATMENT_DATE"];?></td>
        <td><?php echo($report->treatment_date)?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PATIENT_REPORT_MANAGEMENT"];?></td>
        <td><?php echo($report->treatment_management)?></td>
	</tr>
</table>
&nbsp;
&nbsp;
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PATIENT_REPORT_DOCTOR"];?></td>
        <td><?php echo($report->treatment_doctor)?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PATIENT_REPORT_PROTOCOL2"];?></td>
        <td><?php echo(nl2br($report->treatment_treats))?></td>
	</tr>
</table>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["PATIENT_REPORT_TEXTFIELD1"];?></td>
        <td><?php echo(nl2br($report->protocol));?></td>
	</tr>
</table>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["PATIENT_REPORT_TEXTFIELD2"];?></td>
        <td><?php echo(nl2br($report->protocol2));?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PATIENT_REPORT_FEEDBACK"];?></td>
        <td><?php echo(nl2br($report->feedback))?></td>
	</tr>
</table>
<div style="page-break-after:always;">&nbsp;</div>
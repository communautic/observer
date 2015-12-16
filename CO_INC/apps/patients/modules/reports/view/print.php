<style>
table.standard { margin: 2pt 0 0 -15pt; }
</style>
<table width="100%" class="standard" style="margin-top: 20px;">
	<tr>
		<td class="grey" style="text-align: right;"><p class="smalltext" style="line-height: 15px;"><?php echo($report->m_title)?> <?php echo($report->m_firstname)?> <?php echo($report->m_lastname)?></p>
        <p class="smalltext" style="line-height: 15px;">Fon <?php echo($report->m_phone)?></p>
        <?php if($report->m_fax != "") { ?><p class="smalltext" style="line-height: 15px;">Fax <?php echo($report->m_fax)?></p><?php } ?>
        <p class="smalltext" style="line-height: 15px;"><?php echo($report->m_email)?></p>
        <p class="smalltext" style="line-height: 10px;">&nbsp;</p>
        <p class="smalltext" style="line-height: 15px;"></p>
        <p style="line-height: 25px;"><strong>&nbsp;</strong></p>
        <p style="line-height: 15px;"></p>
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="50%"><?php echo($report->r_title)?> <?php echo($report->r_title2)?> <?php echo($report->r_lastname);?> <?php echo($report->r_firstname);?></td>
        <td width="20%"><span class="smalltext">&nbsp;</span></td>
        <td width="30%" style="text-align: right;" class="smalltext"><?php echo($report->m_address_town)?>, <?php echo $report->item_date;?></td>
    </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="50%"><?php echo($report->r_address_line1)?></td>
        <td width="20%"><span class="smalltext">&nbsp;</span></td>
        <td width="30%" style="text-align: right;"><span><&nbsp;</span></td>
    </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="50%"><?php echo($report->r_address_postcode)?> <?php echo($report->r_address_town)?></td>
        <td width="20%"><span class="smalltext">&nbsp;</span></td>
        <td width="30%" style="text-align: right;">&nbsp;</td>
    </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p style="font-size: 25pt;"><?php echo($report->title)?></p>
<p>&nbsp;</p>
<?php if(CO_PRODUCT_VARIANT == 2) { ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PATIENT_CODE"];?></td>
        <td><?php echo($report->code)?></td>
	</tr>
</table>
<?php } ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left">Patient/in</td>
        <td><?php echo($report->treatment_patient)?></td>
	</tr>
</table>
<?php if(!empty($report->number)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_INSURANCE_NUMBER"];?></td>
		<td><?php echo($report->number)?> </td>
    </tr>
</table>
<?php } ?>
&nbsp;
<?php if(!empty($report->insurer)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_INSURER"];?></td>
		<td><?php echo($report->insurer);?><br /><?php echo($report->insurer_ct);?></td>
    </tr>
</table>
<?php } ?>
<?php if(!empty($report->number_insurer)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_INSURANCE_INSURER_NUMBER"];?></td>
		<td><?php echo($report->number_insurer);?><br /><?php echo($report->insurer_ct);?></td>
    </tr>
</table>
&nbsp;
<?php } ?>

<?php if(!empty($report->treatment_diagnose)) { ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><strong><?php echo $lang["PATIENT_REPORT_DOCTOR_DIAGNOSE"];?></strong></td>
        <td><strong><?php echo $report->treatment_diagnose;?></strong></td>
	</tr>
</table>
<?php } ?>
<?php if(CO_PRODUCT_VARIANT == 2) { ?>
<?php if(!empty($report->treatment_method)) { ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PATIENT_REPORT_TREATMENT_METHOD"];?></td>
        <td><?php echo $report->treatment_method;?></td>
	</tr>
</table>
<?php } ?>
<?php } ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PATIENT_REPORT_TREATMENT_DATE"];?></td>
        <td><?php echo $report->treatment_date; ?></td>
	</tr>
</table>
&nbsp;
<?php if(CO_PRODUCT_VARIANT == 1) { ?>
&nbsp;
<?php if(!empty($report->treatment_doctor)) { ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PATIENT_REPORT_DOCTOR"];?></td>
        <td><?php echo $report->treatment_doctor;?><?php echo($report->treatment_doctor_ct); ?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($report->treatment_treats)) { ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php if(CO_PRODUCT_VARIANT == 1) { echo $lang["PATIENT_TREATMENT_PRESCRIPTION_PHYSIO"]; } else { echo $lang["PATIENT_TREATMENT_PRESCRIPTION_THERAPY"]; }?></td>
        <td><?php echo nl2br($report->treatment_treats);?></td>
	</tr>
</table>
<?php } ?>
<?php } ?>
<p>&nbsp;</p>
<p><?php echo(nl2br($report->protocol));?></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p style="line-height: 20px;"><?php echo $lang["PATIENT_REPORT_PRINT_GREETING"];?></p>
<p><?php echo($report->m_title)?> <?php echo($report->m_firstname)?> <?php echo($report->m_lastname)?></p>
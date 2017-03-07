<table width="100%" class="standard" style="margin-top: 20px;">
	<tr>
		<td class="grey" style="text-align: right;"><p class="smalltext" style="line-height: 15px;"><?php echo($invoice->m_title)?> <?php echo($invoice->m_firstname)?> <?php echo($invoice->m_lastname)?></p>
        <p class="smalltext" style="line-height: 15px;">Fon <?php echo($invoice->m_phone)?></p>
        <?php if($invoice->m_fax != "") { ?><p class="smalltext" style="line-height: 15px;">Fax <?php echo($invoice->m_fax)?></p><?php } ?>
        <p class="smalltext" style="line-height: 15px;"><?php echo($invoice->m_email)?></p>
        <?php if($invoice->m_email_alt != "") { ?><p class="smalltext" style="line-height: 15px;"><?php echo($invoice->m_email_alt)?></p><?php } ?>
        <p class="smalltext" style="line-height: 10px;">&nbsp;</p>
        <p class="smalltext" style="line-height: 15px;"></p>
        <p style="line-height: 25px;"><strong>&nbsp;</strong></p>
        <p style="line-height: 15px;"></p>
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="50%"><?php echo($invoice->insurance_name)?></td>
        <td width="20%"><span>Rechnungsdatum</span></td>
        <td width="30%"style="text-align: right;"><?php echo $invoice->invoice_date;?></td>
    </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="50%"><?php echo($invoice->insurance_address_line_1)?></td>
        <td width="20%"><span><?php echo $lang["PATIENT_INVOICE_NUMBER"];?></span></td>
        <td width="30%" style="text-align: right;"><span><?php echo($invoice->invoice_number);?></span></td>
    </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="50%"><?php echo($invoice->insurance_address_line_2)?></td>
        <td width="20%"><span>Leistungszeitraum</span></td>
        <td width="30%" style="text-align: right;"><?php echo($invoice->treatment_start);?> - <?php echo($invoice->treatment_end);?></td>
    </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p style="font-size: 25pt;">Anweisung<br />
  des Kostenzuschusses / - ersatzes an:
</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php if($patient->code != "") { ?>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="25%" class="smalltext"><?php if(CO_PRODUCT_VARIANT == 1) { echo $lang["PATIENT_CODE_PO"]; }?><?php if(CO_PRODUCT_VARIANT == 2) { echo $lang["PATIENT_CODE_TO"]; }?></td>
        <td width="75%"><?php echo $patient->code;?></td>
    </tr>
</table>
<p>&nbsp;</p>
<?php } ?>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="25%" class="smalltext">Patient/in</td>
        <td width="75%"><?php echo($invoice->patient)?></td>
    </tr>
</table>
<?php if($invoice->number != "") { ?>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="25%" class="smalltext"><?php echo $lang["PATIENT_INSURANCE_NUMBER"];?></td>
        <td width="75%"><?php echo($invoice->number)?></td>
    </tr>
</table>
<p>&nbsp;</p>
<?php } ?>
<?php if($invoice->number_insurer != "") { ?>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="25%" class="smalltext"><?php echo $lang["PATIENT_INSURER"];?></td>
        <td width="75%"><?php echo($invoice->insurer);?></td>
    </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="25%" class="smalltext"><?php echo $lang["PATIENT_INSURANCE_INSURER_NUMBER"];?></td>
        <td width="75%"><?php echo($invoice->number_insurer)?></td>
    </tr>
</table>
<p>&nbsp;</p>
<?php } ?>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="25%" class="smalltext">Adresse</td>
        <td width="75%"><?php echo($invoice->patient_address)?></td>
    </tr>
</table>
<p>&nbsp;</p>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="25%" class="smalltext">Bank</td>
        <td width="75%"><?php echo($invoice->bank_name)?></td>
    </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="25%" class="smalltext">BLZ</td>
        <td width="75%"><?php echo($invoice->sort_code)?></td>
    </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="25%" class="smalltext">Konto</td>
        <td width="75%"><?php echo($invoice->account_number)?></td>
    </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="25%" class="smalltext">IBAN</td>
        <td width="75%"><?php echo($invoice->iban)?></td>
    </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="25%" class="smalltext">BIC</td>
        <td width="75%"><?php echo($invoice->bic)?></td>
    </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="25%" class="smalltext">Unterschrift Patient/in</td>
        <td width="75%">................................................</td>
    </tr>
</table>
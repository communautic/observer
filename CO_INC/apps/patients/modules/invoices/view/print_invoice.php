<table width="100%" class="standard">
	<tr>
		<td style="text-align: right;"><p class="tinytext"><?php echo($invoice->m_title)?> <?php echo($invoice->m_firstname)?> <?php echo($invoice->m_lastname)?></p>
        <p class="tinytext">Fon <?php echo($invoice->m_phone)?></p>
        <?php if($invoice->m_fax != "") { ?><p class="tinytext">Fax <?php echo($invoice->m_fax)?></p><?php } ?>
        <p class="tinytext"><?php echo($invoice->m_email)?></p>
        <?php if($invoice->m_email_alt != "") { ?><p class="tinytext"><?php echo($invoice->m_email_alt)?></p><?php } ?>
        <p class="tinytext">&nbsp;</p>
        <p class="tinytext">&nbsp;</p>
        <p class="tinytext">&nbsp;</p>
        <p class="tinytext">&nbsp;</p>
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;"class="standard">
    <tr>
        <td width="53%">
						<span style="padding:0; line-height: 19px;"><?php echo($invoice->ctitle)?> <?php echo($invoice->title2)?> <?php echo($invoice->lastname);?> <?php echo($invoice->firstname);?></span><br />
            <span style="padding:0; line-height: 19px;"><?php echo($invoice->address_line1)?></span><br />
            <span style="padding:0; line-height: 19px;"><?php echo($invoice->address_postcode)?> <?php echo($invoice->address_town)?></span>
            </td>
        <td width="17%">
        	<?php if($invoice->invoice_type == 1) { ?><span style="line-height: 19px;">&nbsp;</span><br /><?php } ?>
          <span style="line-height: 19px;">Rechnungsdatum</span><br />
          <span style="line-height: 19px;"><?php echo $lang["PATIENT_INVOICE_NUMBER"];?></span>
          <?php if($invoice->invoice_type == 0) { ?><span style="line-height: 19px;">Leistungszeitraum</span><?php } ?>
         </td>
        <td width="30%"style="text-align: right;">
        <?php if($invoice->invoice_type == 1) { ?><span style="line-height: 19px;">&nbsp;</span><br /><?php } ?>
				<span style="line-height: 19px;"><?php echo $invoice->invoice_date;?></span><br />
        <span style="line-height: 19px;"><?php echo($invoice->invoice_number);?></span><br />
        <?php if($invoice->invoice_type == 0) { ?><span style="line-height: 19px;"><?php echo($invoice->treatment_start);?> - <?php echo($invoice->treatment_end);?></span><?php } ?>
        </td>
    </tr>
</table>
<p class="tinytext">&nbsp;</p>
<p class="tinytext">&nbsp;</p>
<p style="font-size: 25pt;">Rechnung <?php if($invoice->status_invoice == 3) { ?><span style="color: #ff3300;"><?php echo '(Storno)';?></span><?php } ?></p>
<?php if($invoice->invoice_type == 0) { ?>
<p>&nbsp;</p>
<?php if($patient->code != "") { ?>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="20%" class="tinytext" style="line-height: 10px;"><?php if(CO_PRODUCT_VARIANT == 1) { echo $lang["PATIENT_CODE_PO"]; }?><?php if(CO_PRODUCT_VARIANT == 2) { echo $lang["PATIENT_CODE_TO"]; }?></td>
        <td width="80%" class="tinytext" style="line-height: 10px;"><?php echo $patient->code;?></td>
    </tr>
</table>
<?php } ?>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="20%" class="tinytext" style="line-height: 10px;">Patient/in</td>
        <td width="80%" class="tinytext" style="line-height: 10px;"><?php echo($invoice->patient)?></td>
    </tr>
</table>
<?php if($invoice->number != "") { ?>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="20%" class="tinytext" style="line-height: 10px;"><?php echo $lang["PATIENT_INSURANCE_NUMBER"];?></td>
        <td width="80%" class="tinytext" style="line-height: 10px;"><?php echo($invoice->number)?></td>
    </tr>
</table>
<?php } ?>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="20%" class="tinytext" style="line-height: 10px;">Adresse</td>
        <td width="80%" class="tinytext" style="line-height: 10px;"><?php echo($invoice->patient_address)?></td>
    </tr>
</table>
<?php if($invoice->number_insurer != "") { ?>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="20%" class="tinytext" style="line-height: 10px;"><?php echo $lang["PATIENT_INSURER"];?></td>
        <td width="80%" class="tinytext" style="line-height: 10px;"><?php echo($invoice->insurer);?></td>
    </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="20%" class="tinytext" style="line-height: 10px;"><?php echo $lang["PATIENT_INSURANCE_INSURER_NUMBER"];?></td>
        <td width="80%" class="tinytext" style="line-height: 10px;"><?php echo($invoice->number_insurer)?></td>
    </tr>
</table>
<?php } ?>
<?php if($invoice->protocol != "") { ?>
<p>&nbsp;</p>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="20%" class="tinytext" style="line-height: 10px;"><?php echo $lang["PATIENT_TREATMENT_DOCTOR_DIAGNOSE"];?></td>
        <td width="80%" class="tinytext" style="line-height: 10px;"><?php echo($invoice->protocol)?></td>
    </tr>
</table>
<?php } ?>
<?php if(CO_PRODUCT_VARIANT == 2) { ?>
<?php if($invoice->method != "") { ?>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="20%" class="tinytext" style="line-height: 10px;"><?php echo $lang["PATIENT_TREATMENT_METHOD"];?></td>
        <td width="80%" class="tinytext" style="line-height: 10px;"><?php echo($invoice->method)?></td>
    </tr>
</table>
<?php } ?>
<?php } ?>
<?php } ?>
<p>&nbsp;</p>

<table width="100%" class="standard" style="border:1px solid #ccc;">

<?php if($invoice->invoice_type == 0) { ?>
<?php 
	$i = 1;
	foreach($task as $value) { 
		$checked = '';
		if($value->status == 1 && is_array($value->type)) { ?>
      <tr>
        <td width="20%" style="border-bottom:1px solid #ccc; padding:5px 1px 0;" class="tinytext"><span style="margin-left: 7px;"><?php echo $i;?>. <?php echo $lang["PATIENT_TREATMENT_GOALS_SINGUAL"];?></span></td>
        <td width="30%" style="border-bottom:1px solid #ccc; padding:5px 0 1px 0;" class="tinytext">(<?php echo $value->item_date;?>)</td>
        <td width="10%" style="border-bottom:1px solid #ccc; padding:5px 0 1px 0;" class="tinytext"><?php foreach($value->type as $t) { echo '<span>' . $t['positionstext'] . ' ' . $t['shortname'] . '</span><br />'; } ?></td>
        <td width="20%" style="border-bottom:1px solid #ccc; padding:5px 7px 1px 0; text-align: right;" class="tinytext"><?php foreach($value->type as $t) { echo $t['minutes'] . 'min.<br />'; }?></td>
        <td width="20%" style="padding:5px 7px 1px 0; text-align: right; border-left: 1px solid #ccc; border-bottom: 1px solid #ccc;" class="tinytext"><?php foreach($value->type as $t) { echo CO_DEFAULT_CURRENCY . ' ' . $t['costs'] . '<br />'; } ?> </td>
    </tr>
   
<?php }
		$i++;
	 } ?>
<?php } ?>

<?php if($invoice->invoice_type == 1) { ?>
	<?php 
	$i = 1;
	foreach($task as $value) { 
		$checked = '';
		if($value->status == 1) { ?>
      <tr>
        <td width="20%" style="border-bottom:1px solid #ccc; padding:5px 1px 0;" class="tinytext"><span style="margin-left: 7px;"><?php echo $i;?>. Inhalt</span></td>
        <td width="10%" style="border-bottom:1px solid #ccc; padding:5px 0 1px 0;" class="tinytext"><?php echo $value->menge;?>x</td>
        <td width="30%" style="border-bottom:1px solid #ccc; padding:5px 0 1px 0;" class="tinytext"><?php echo $value->title;?></td>
        <td width="20%" style="border-bottom:1px solid #ccc; padding:5px 7px 1px 0; text-align: right;" class="tinytext"> à <?php echo CO_DEFAULT_CURRENCY . ' ' . $value->preis;?></td>
        <td width="20%" style="padding:5px 7px 1px 0; text-align: right; border-left: 1px solid #ccc; border-bottom: 1px solid #ccc;" class="tinytext"><?php echo CO_DEFAULT_CURRENCY . ' ' . $value->taskcosts . '<br />'; ?> 
        </td>
    </tr>
   
<?php }
		$i++;
	 } ?>
   <?php } ?>
   
   
   
   
   </table>
   
	 <?php if($invoice->discount > 0) { ?>
   <table width="100%" class="standard" style="margin-top: 0;">
              <tr>
                <td width="20%" style="padding:5px 0 1px 0;" class="tinytext">&nbsp;</td>
                <td width="30%" style="padding:5px 0 1px 0;" class="tinytext">&nbsp;</td>
                <td width="10%" style="padding:5px 0 1px 0;" class="tinytext">&nbsp;</td>
				<td width="20%" style="text-align: right; padding:5px 7px 1px 0;" class="tinytext">-<?php echo $invoice->discount;?>% <?php echo $lang["PATIENT_TREATMENT_DISCOUNT_SHORT"];?></td>
				<td width="20%" style="text-align: right; padding:5px 7px 1px 0;" class="tinytext">-<?php echo CO_DEFAULT_CURRENCY . ' ' . $invoice->discount_costs;?></td>
</tr>
</table>
	 <?php }?>
     <?php if($invoice->vat > 0) { ?>
     <table width="100%" class="standard" style="margin-top: 0;">
              <tr>
                <td width="20%" style="padding:5px 0 1px 0;" class="tinytext">&nbsp;</td>
                <td width="30%" style="padding:5px 0 1px 0;" class="tinytext">&nbsp;</td>
                <td width="10%" style="padding:5px 0 1px 0;" class="tinytext">&nbsp;</td>
				<td width="20%" style="text-align: right; padding:5px 7px 1px 0;" class="tinytext"><?php echo $invoice->vat;?>% <?php echo $lang["PATIENT_TREATMENT_VAT_SHORT"];?></td>
				<td width="20%" style="text-align: right; padding:5px 7px 1px 0;" class="tinytext"><?php echo CO_DEFAULT_CURRENCY . ' ' . $invoice->vat_costs;?></td>
</tr>
</table>
	 <?php }?>
   <table width="100%" class="standard" style="border:1px solid #ccc; margin-top: 3px;">
      <tr style="background: #e5e5e5;">
				<td width="20%" style="padding:5px 0 1px 0;" class="tinytext">&nbsp;</td>
				<td width="30%" style="padding:5px 0 1px 0;" class="tinytext">&nbsp;</td>
				<td width="10%" style="padding:5px 0 1px 0;" class="tinytext">&nbsp;</td>
				<td width="20%" style="text-align: right; padding:5px 7px 2px 0;"><b>Gesamtbetrag</b></td>
				<td width="20%" style="text-align: right; padding:5px 7px 1px 0;"><b><?php echo CO_DEFAULT_CURRENCY;?> <?php echo $invoice->totalcosts;?></b></td>
      </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php if($invoice->payment_type != 'Barzahlung') { ?>
	<?php if(CO_PRODUCT_VARIANT == 2) { ?>
    	<p><?php echo $lang["PATIENT_INVOICE_REQUEST_PAYMENT"];?></p>
    <?php } else { ?>
    	<p><?php echo $lang["PATIENT_INVOICE_TEXT_LINE2"];?></p>
        <p>&nbsp;</p>
        <p><?php echo $lang["PATIENT_INVOICE_TEXT_LINE3"];?></p>
    <?php } ?>
<?php } else { ?>
<p><?php echo $lang["PATIENT_INVOICE_PAYMENT_CASH"];?></p>
	<?php if(CO_PRODUCT_VARIANT == 1) { ?>
        <p>&nbsp;</p>
        <p><?php echo $lang["PATIENT_INVOICE_TEXT_LINE3"];?></p>
    <?php } ?>
<?php } ?>
<p>&nbsp;</p>
<span><?php echo nl2br($invoice->protocol_invoice);?></span>
<p>&nbsp;</p>
<p><?php echo $lang["PATIENT_INVOICE_TEXT_LINE4"];?></p>
<p class="tinytext">&nbsp;</p>
<p class="tinytext">&nbsp;</p>
<p class="tinytext">&nbsp;</p>
<p class="tinytext">&nbsp;</p>
<p class="tinytext">&nbsp;</p>
<p class="tinytext">&nbsp;</p>
<p style="line-height: 18px;"><?php echo($invoice->m_title)?> <?php echo($invoice->m_firstname)?> <?php echo($invoice->m_lastname)?><br />
<span class="tinytext"><?php echo($invoice->m_position)?></span>
</p>

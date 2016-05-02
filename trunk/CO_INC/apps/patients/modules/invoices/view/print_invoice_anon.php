<table width="100%" class="standard" style="margin-top: 20px;">
	<tr>
		<td class="grey" style="text-align: right;"><p class="smalltext" style="line-height: 15px;"><?php echo($invoice->m_title)?> <?php echo($invoice->m_firstname)?> <?php echo($invoice->m_lastname)?></p>
        <p class="smalltext" style="line-height: 15px;">Fon <?php echo($invoice->m_phone)?></p>
        <?php if($invoice->m_fax != "") { ?><p class="smalltext" style="line-height: 15px;">Fax <?php echo($invoice->m_fax)?></p><?php } ?>
        <p class="smalltext" style="line-height: 15px;"><?php echo($invoice->m_email)?></p>
        <?php if($invoice->m_email_alt != "") { ?><p class="smalltext" style="line-height: 15px;"><?php echo($invoice->m_email_alt)?></p><?php } ?>
        <p class="smalltext" style="line-height: 10px;">&nbsp;</p>
        <p class="smalltext" style="line-height: 15px;"></p>
        <p style="line-height: 15px;"></p>
        <p style="line-height: 25px;"><strong>&nbsp;</strong></p>
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="50%">&nbsp;</td>
        <td width="20%"><span class="smalltext">Rechnungsdatum</span></td>
        <td width="30%"style="text-align: right;"><?php echo $invoice->invoice_date;?></td>
    </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="50%">&nbsp;</td>
        <td width="20%"><span class="smalltext"><?php echo $lang["PATIENT_INVOICE_NUMBER"];?></span></td>
        <td width="30%" style="text-align: right;"><span><?php echo($invoice->invoice_number);?></span></td>
    </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="50%">&nbsp;</td>
        <td width="20%"><span class="smalltext">Leistungszeitraum</span></td>
        <td width="30%" style="text-align: right;"><?php echo($invoice->treatment_start);?> - <?php echo($invoice->treatment_end);?></td>
    </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p style="font-size: 25pt;">Rechnung</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php if($patient->code != "") { ?>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="25%" class="smalltext"><?php if(CO_PRODUCT_VARIANT == 1) { echo $lang["PATIENT_CODE_PO"]; }?><?php if(CO_PRODUCT_VARIANT == 2) { echo $lang["PATIENT_CODE_TO"]; }?></td>
        <td width="75%"><?php echo $patient->code;?></td>
    </tr>
</table>
<?php } ?>
<?php if(CO_PRODUCT_VARIANT == 2) { ?>
<?php if($invoice->method != "") { ?>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="25%" class="smalltext"><?php echo $lang["PATIENT_TREATMENT_METHOD"];?></td>
        <td width="75%"><?php echo($invoice->method)?></td>
    </tr>
</table>
<?php } ?>
<?php } ?>
<p>&nbsp;</p>
<table width="100%" class="standard" style="border:1px solid #ccc;">
	<?php 
	$i = 1;
	foreach($task as $value) { 
		$checked = '';
		if($value->status == 1 && is_array($value->type)) { ?>
      <tr>
        <td width="20%" style="border-bottom:1px solid #ccc; padding: 6px 0 0 0;"><span style="margin-left: 7px;"><?php echo $i;?>. <?php echo $lang["PATIENT_TREATMENT_GOALS_SINGUAL"];?></span></td>
        <td style="border-bottom:1px solid #ccc; padding: 9px 0 4px 0;"><span class="smalltext" style="line-height: 20px;"> (<?php echo $value->item_date;?>)</span></td>
        <td style="border-bottom:1px solid #ccc; padding: 9px 0 4px 0;" class="smalltext"><?php foreach($value->type as $t) { echo '<span style="line-height: 15px;">' . $t['positionstext'] . ' ' . $t['shortname'] . '</span><br />'; } ?></td>
        <td style="border-bottom:1px solid #ccc; padding: 9px 0 4px 0;" class="smalltext"><?php foreach($value->type as $t) { echo '<span style="line-height: 15px;">' . $t['minutes'] . 'min.</span><br />'; }?></td>
        <td style="padding: 9px 0 4px 0; text-align: right; border-left: 1px solid #ccc; border-bottom: 1px solid #ccc;" class="smalltext"><?php foreach($value->type as $t) { echo '<span style="line-height: 15px;">' . CO_DEFAULT_CURRENCY . ' ' . $t['costs'] . ' &nbsp; &nbsp; </span><br />'; } ?> </td>
    </tr>
   
<?php }
		$i++;
	 } ?>
	 <?php if($invoice->discount > 0) { ?>
              <tr>
                <td style="border-bottom:1px solid #ccc; padding: 6px 0;"><span class="text13 bold" style="margin-left: 7px;">&nbsp;</span></td>
                <td style="border-bottom:1px solid #ccc; padding: 7px 0 4px 0;">&nbsp;</td>
                <td style="border-bottom:1px solid #ccc; padding: 7px 0 4px 0;">&nbsp;</td>
				<td style="border-bottom:1px solid #ccc; padding: 7px 0 4px 0;" class="smalltext">-<?php echo $invoice->discount;?>% <?php echo $lang["PATIENT_TREATMENT_DISCOUNT_SHORT"];?></td>
				<td style="border-bottom:1px solid #ccc; text-align: right; border-left: 1px solid #ccc; padding: 7px 2px 4px 0;" class="smalltext">-<?php echo CO_DEFAULT_CURRENCY . ' ' . $invoice->discount_costs;?> &nbsp; &nbsp; </td>
</tr>
	 <?php }?>
     <?php if($invoice->vat > 0) { ?>
              <tr>
                <td style="border-bottom:1px solid #ccc; padding: 6px 0;"><span class="text13 bold" style="margin-left: 7px;">&nbsp;</span></td>
                <td style="border-bottom:1px solid #ccc; padding: 7px 0 4px 0;">&nbsp;</td>
                <td style="border-bottom:1px solid #ccc; padding: 7px 0 4px 0;">&nbsp;</td>
				<td style="border-bottom:1px solid #ccc; padding: 7px 0 4px 0;" class="smalltext"><?php echo $invoice->vat;?>% <?php echo $lang["PATIENT_TREATMENT_VAT_SHORT"];?></td>
				<td style="border-bottom:1px solid #ccc; text-align: right; border-left: 1px solid #ccc; padding: 7px 2px 4px 0;" class="smalltext"><?php echo CO_DEFAULT_CURRENCY . ' ' . $invoice->vat_costs;?> &nbsp; &nbsp; </td>
</tr>
	 <?php }?>
      <tr style="background: #e5e5e5;">
        <td style="padding: 6px 0 4px 0;"><span class="bold" style="margin-left: 7px;"><?php echo $lang["PATIENT_INVOICE_TOTALS"];?></span></td>
        <td class="text11" style="padding: 6px 0 4px 0;">&nbsp;</td>
        <td class="text11" style="padding: 6px 0 4px 0;">&nbsp;</td>
             <td class="text11" style="padding: 6px 0 4px 0;">&nbsp;</td>
          <td class="smalltext bold" style="text-align: right; border-left: 1px solid #ccc; padding: 6px 0 4px 0;"><?php echo CO_DEFAULT_CURRENCY;?> <?php echo $invoice->totalcosts;?> &nbsp; &nbsp; </td>
      </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php if($invoice->payment_type != 'Barzahlung') { ?>
	<?php if(CO_PRODUCT_VARIANT == 2) { ?>
    	<p style="line-height: 20px;"><?php echo $lang["PATIENT_INVOICE_REQUEST_PAYMENT"];?></p>
    <?php } else { ?>
    	<p style="line-height: 20px;"><?php echo $lang["PATIENT_INVOICE_TEXT_LINE2"];?></p>
        <p>&nbsp;</p>
        <p style="line-height: 20px;"><?php echo $lang["PATIENT_INVOICE_TEXT_LINE3"];?></p>
    <?php } ?>
<?php } else { ?>
<p style="line-height: 20px;"><?php echo $lang["PATIENT_INVOICE_PAYMENT_CASH"];?></p>
	<?php if(CO_PRODUCT_VARIANT == 1) { ?>
        <p>&nbsp;</p>
        <p style="line-height: 20px;"><?php echo $lang["PATIENT_INVOICE_TEXT_LINE3"];?></p>
    <?php } ?>
<?php } ?>
<p>&nbsp;</p>
<?php echo nl2br($invoice->protocol_invoice);?>
<p>&nbsp;</p>
<p style="line-height: 20px;"><?php echo $lang["PATIENT_INVOICE_TEXT_LINE4"];?></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p style="line-height: 18px;"><?php echo($invoice->m_title)?> <?php echo($invoice->m_firstname)?> <?php echo($invoice->m_lastname)?><br />
<span class="smalltext"><?php echo($invoice->m_position)?></span>
</p>
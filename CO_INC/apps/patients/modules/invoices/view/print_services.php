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
<table width="100%" class="standard">
    <tr>
        <td><p style="line-height: 25px;"><b><?php echo $lang["PATIENT_INVOICE_SERVICES_LIST"];?></b></p>
        <p style="line-height: 25px;"><?php echo $lang["PATIENT_INVOICE_SERVICES_FOR"];?> <?php echo($invoice->patient);?></p>
        <p style="line-height: 25px;">zu Rechnungsnummer <?php echo($invoice->invoice_number);?></p></td>
        <td valign="bottom" style="text-align: right;">&nbsp;</td>
    </tr>
</table>
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
				<td width="20%" style="text-align: right; padding:5px 7px 2px 0;" class="tinytext"><b>Gesamtbetrag</b></td>
				<td width="20%" style="text-align: right; padding:5px 7px 1px 0;" class="tinytext"><b><?php echo CO_DEFAULT_CURRENCY;?> <?php echo $invoice->totalcosts;?></b></td>
      </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="100%" class="standard">
    <tr>
        <td><p style="line-height: 25px;"><?php echo $lang["PATIENT_INVOICE_SERVICES_FOR_SIG_PATIENT"];?>:</p></td>
        <td><p style="line-height: 25px;"><?php echo $lang["PATIENT_INVOICE_SERVICES_FOR_SIG_THERAPIST"];?>:</p></td>
    </tr>
</table>
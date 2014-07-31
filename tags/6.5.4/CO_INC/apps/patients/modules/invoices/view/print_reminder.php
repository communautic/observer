<table width="100%" class="standard" style="margin-top: 20px;">
	<tr>
		<td style="text-align: right;"><p class="smalltext" style="line-height: 15px;"><?php echo($invoice->m_title)?> <?php echo($invoice->m_firstname)?> <?php echo($invoice->m_lastname)?></p>
        <p class="smalltext" style="line-height: 15px;"><?php echo($invoice->m_phone)?></p>
        <p class="smalltext" style="line-height: 15px;"><?php echo($invoice->m_email)?></p>
        <p class="smalltext" style="line-height: 10px;">&nbsp;</p>
        <p class="smalltext" style="line-height: 15px;">Patient: <?php echo($invoice->patient)?></p>
        <p style="line-height: 15px;"><?php echo $lang["PATIENT_INVOICE_NUMBER"];?>: <?php echo($invoice->invoice_number);?></p>
        <p style="line-height: 25px;"><strong><?php echo strtoupper($lang["PATIENT_INVOICE_PAYMENT_REMINDER"]);?></strong></p>
	</tr>
</table>
<table width="100%" class="standard">
    <tr>
        <td><p style="line-height: 25px;"><?php echo($invoice->ctitle)?> <?php echo($invoice->title2)?> <?php echo($invoice->lastname);?> <?php echo($invoice->firstname);?></p>
        <p style="line-height: 25px;"><?php echo($invoice->address_line1)?></p>
        <p style="line-height: 25px;"><?php echo($invoice->address_postcode)?> <?php echo($invoice->address_town)?></p></td>
        <td valign="bottom" style="text-align: right;"><?php echo $invoice->payment_reminder;?></td>
    </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><?php echo $lang["PATIENT_INVOICE_TEXT_CITATION"];?> <?php echo($invoice->ctitle)?> <?php echo(ucfirst(strtolower($invoice->lastname)))?>!</p>
<p>&nbsp;</p>
<p style="line-height: 20px;"><?php echo $lang["PATIENT_INVOICE_TEXT_LINE1"];?></p>
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
<p style="line-height: 20px;"><?php echo $lang["PATIENT_INVOICE_TEXT_LINE2"];?></p>
<p>&nbsp;</p>
<p style="line-height: 20px;"><?php echo $lang["PATIENT_INVOICE_TEXT_LINE3"];?></p>
<p>&nbsp;</p>
<p style="line-height: 20px;"><?php echo $lang["PATIENT_INVOICE_TEXT_LINE4"];?></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><?php echo($invoice->m_firstname)?> <?php echo($invoice->m_lastname)?></p>
<div style="page-break-after:always;">&nbsp;</div>
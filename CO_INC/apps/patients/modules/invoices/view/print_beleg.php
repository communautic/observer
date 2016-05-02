<table width="100%" class="standard">
	<tr>
		<td><p style="line-height: 13px;"><?php echo($invoice->m_title)?> <?php echo($invoice->m_firstname)?> <?php echo($invoice->m_lastname)?></p>
        <p style="line-height: 13px;"><?php echo($invoice->m_street)?></p>
      <p style="line-height: 13px;"><?php echo($invoice->m_plz . ' ' . $invoice->m_town)?></p>
<p style="line-height: 13px;">Fon <?php echo($invoice->m_phone)?></p>
        <?php if($invoice->m_fax != "") { ?><p style="line-height: 13px;">Fax <?php echo($invoice->m_fax)?></p><?php } ?>
        <p style="line-height: 13px;"><?php echo($invoice->m_email)?></p>
        <p style="line-height: 18px;">&nbsp;</p>
	</tr>
</table>
<p style="font-size: 25pt;">Kassenbeleg</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="100%" cellpadding="0" cellspacing="0">
    <tr valign="bottom">
        <td width="50%" class="smalltext">Belegnummer</td>
        <td width="50%" class="text-lg" style="text-align: right;"><?php echo $invoice->beleg_nummer;?></td>
    </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0">
    <tr valign="bottom">
        <td width="50%">Datum / Zeit</td>
        <td width="50%" class="text-lg" style="text-align: right;"><?php echo($invoice->beleg_datum)?> <?php echo($invoice->beleg_time)?></td>
    </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td style="border-bottom:1px solid #000;">&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>

	<?php 
	$i = 1;
	foreach($task as $value) { 
		$checked = '';
		if($value->status == 1 && is_array($value->type)) { ?>
      <table width="100%" cellpadding="0" cellspacing="0">
      <tr valign="top">
        <td width="25%"><?php echo $i;?>. <?php echo $lang["PATIENT_TREATMENT_GOALS_SINGUAL"];?>&nbsp;</td>
        <td width="25%">(<?php echo $value->item_date;?>)&nbsp;</td>
        <td width="50%" class="text-lg" style="text-align: right;"><?php 
					$y = 0;
					foreach($value->type as $t) { 
						//
						if($y > 0) { 
            	echo '<br />';

						}
						//}
						echo CO_DEFAULT_CURRENCY . ' ' . $t['costs']; 
						
						$y++;
					} 
					?> </td>
  </tr></table>
<table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td><span style="line-height: 8px;">&nbsp;</span></td>
      </tr>
</table>
<?php }
		$i++;
	 } ?>
   
	 <?php if($invoice->discount > 0) { ?>
              <table width="100%" cellpadding="0" cellspacing="0">
              <tr valign="bottom">
                <td width="25%">&nbsp;</td>
								<td width="25%" style="text-align: right;">-<?php echo $invoice->discount;?>% <?php echo $lang["PATIENT_TREATMENT_DISCOUNT_SHORT"];?></td>
								<td width="50%" class="text-lg" style="text-align: right;">-<?php echo CO_DEFAULT_CURRENCY . ' ' . $invoice->discount_costs;?></td>
</tr></table>
	 <?php }?>
     <?php if($invoice->vat > 0) { ?>
              <table width="100%" cellpadding="0" cellspacing="0">
              <tr valign="bottom">
                <td width="25%">&nbsp;</td>
								<td width="25%" style="text-align: right;"><?php echo $invoice->vat;?>% <?php echo $lang["PATIENT_TREATMENT_VAT_SHORT"];?></td>
								<td width="50%" class="text-lg" style="text-align: right;"><?php echo CO_DEFAULT_CURRENCY . ' ' . $invoice->vat_costs;?></td>
</tr></table>
	 <?php }?>
   <table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td style="border-bottom:1px solid #000;">&nbsp;</td>
    </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td><span style="line-height: 15px;">&nbsp;</span></td>
      </tr>
</table>
      <table width="100%" cellpadding="0" cellspacing="0">
      <tr valign="bottom">
        <td>Gesamtbetrag</td>
        <td style="text-align: right;" class="text-lg"><?php echo CO_DEFAULT_CURRENCY;?> <?php echo $invoice->totalcosts;?></td>
      </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td style="border-bottom:1px solid #000;"><span style="line-height: 10px;">&nbsp;</span></td>
  </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 2pt;">
    <tr>
        <td style="border-top:1px solid #000;">&nbsp;</td>
    </tr>
</table>
<p>&nbsp;</p>
<p class="text-lg"><?php echo $lang["PATIENT_INVOICE_PAYMENT_CASH"];?></p>
<p>&nbsp;</p>
<p class="text-lg"><?php echo $lang["PATIENT_INVOICE_TEXT_LINE4"];?></p>
<p class="text-lg"><?php echo($invoice->m_title)?> <?php echo($invoice->m_firstname)?> <?php echo($invoice->m_lastname)?><br /><span class="smalltext"><?php echo($invoice->m_position)?></span></p>
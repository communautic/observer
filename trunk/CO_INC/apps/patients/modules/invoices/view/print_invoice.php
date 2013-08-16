<table width="100%" class="standard">
	<tr>
		<td style="text-align: right;"><p class="smalltext" style="line-height: 15px;"><?php echo($invoice->m_title)?> <?php echo($invoice->m_firstname)?> <?php echo($invoice->m_lastname)?></p>
        <p class="smalltext" style="line-height: 15px;"><?php echo($invoice->m_phone)?></p>
        <p class="smalltext" style="line-height: 15px;"><?php echo($invoice->m_email)?></p>
        <p class="smalltext" style="line-height: 10px;">&nbsp;</p>
        <p class="smalltext" style="line-height: 15px;">Rechnungsnummer: <?php echo($invoice->invoice_number);?></p>
        <p style="line-height: 25px;"><strong>&nbsp;</strong></p>
	</tr>
</table>
<table width="100%" class="standard">
    <tr>
        <td><p style="line-height: 20px;"><?php echo($invoice->ctitle)?> <?php echo($invoice->title2)?> <?php echo($invoice->patient);?></p>
        <p style="line-height: 20px;"><?php echo($invoice->address_line1)?></p>
        <p style="line-height: 20px;"><?php echo($invoice->address_postcode)?> <?php echo($invoice->address_town)?></p></td>
        <td valign="bottom" style="text-align: right;">Telfs, am <?php echo date('d.m.Y');?></td>
    </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>Sehr geehrte/r <?php echo($invoice->ctitle)?> <?php echo(ucfirst(strtolower($invoice->lastname)))?> !</p>
<p>&nbsp;</p>
<p style="line-height: 20px;">F&uuml;r die im Rahmen der Therapie erfolgten Anwendungen erlaube ich mir nachstehende Honorarnote zu legen:</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="100%" class="standard" style="border:1px solid #ccc;">
	<?php 
	$i = 1;
	foreach($task as $value) { 
		$checked = '';
		if($value->status == 1) { ?>
      <tr>
        <td width="20%" style="border-bottom:1px solid #ccc; padding: 6px 0;"><span style="margin-left: 7px;"><?php echo $i;?>. Sitzung</span></td>
        <td style="border-bottom:1px solid #ccc; padding: 8px 0;"><span class="smalltext" style="line-height: 15px;"> (<?php echo $value->item_date;?>)</span></td>
        <td style="border-bottom:1px solid #ccc; padding: 8px 0;" class="smalltext"><?php foreach($value->type as $t) { echo '<span style="line-height: 15px;">' . $t['positionstext'] . ' ' . $t['shortname'] . '</span><br />'; } ?></td>
        <td style="border-bottom:1px solid #ccc; padding: 8px 0;" class="smalltext"><?php foreach($value->type as $t) { echo '<span style="line-height: 15px;">' . $t['minutes'] . 'min.</span><br />'; }?></td>
        <td style="padding: 8px 0; text-align: right; border-left: 1px solid #ccc; border-bottom: 1px solid #ccc;" class="smalltext"><?php foreach($value->type as $t) { echo '<span style="line-height: 15px;">' . $lang['GLOBAL_CURRENCY_EURO'] . ' ' . $t['costs'] . ' &nbsp; &nbsp; </span><br />'; } ?> </td>
    </tr>
   
<?php }
		$i++;
	 } ?>
	 <?php if($invoice->discount > 0) { ?>
              <tr>
                <td style="border-bottom:1px solid #ccc; padding: 6px 0;"><span class="text13 bold" style="margin-left: 7px;">&nbsp;</span></td>
                <td style="border-bottom:1px solid #ccc; padding: 7px 0 4px 0;">&nbsp;</td>
                <td style="border-bottom:1px solid #ccc; padding: 7px 0 4px 0;">&nbsp;</td>
				<td style="border-bottom:1px solid #ccc; padding: 7px 0 4px 0;">-<?php echo $invoice->discount;?>% Rabatt</td>
				<td style="border-bottom:1px solid #ccc; text-align: right; border-left: 1px solid #ccc; padding: 7px 0 4px 0;" class="smalltext">-<?php echo $lang['GLOBAL_CURRENCY_EURO'] . ' ' . $invoice->discount_costs;?> &nbsp; &nbsp; </td>
</tr>
	 <?php }?>
      <tr style="background: #e5e5e5;">
        <td style="padding: 6px 0 4px 0;"><span class="bold" style="margin-left: 7px;">Gesamthonorar</span></td>
        <td class="text11" style="padding: 6px 0 4px 0;">&nbsp;</td>
        <td class="text11" style="padding: 6px 0 4px 0;">&nbsp;</td>
             <td class="text11" style="padding: 6px 0 4px 0;">&nbsp;</td>
          <td class="smalltext bold" style="text-align: right; border-left: 1px solid #ccc; padding: 6px 0 4px 0;"><?php echo $lang['GLOBAL_CURRENCY_EURO'];?> <?php echo $invoice->totalcosts;?> &nbsp; &nbsp; </td>
      </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p style="line-height: 20px;">Ich danke f&uuml;r Ihr Vertrauen und bitte um Anweisung des Gesamthonorars innerhalb von 10 Tagen und stehe auch weiterhin gerne zu Diensten.</p>
<p style="line-height: 20px;">&nbsp;</p>
<p style="line-height: 20px;">Zwecks tarifgem&auml;&szlig;er R&uuml;ckerstattung sollten Sie die Therapiebelege (Rechnung im Original, &Uuml;berweisungsschein und Einzahlungsbeleg) bei Ihrer Versicherung einreichen. Ich danke Ihnen f&uuml;r die prompte Erledigung und verbleibe</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>mit freundlichen Gr&uuml;&szlig;en</p>
<div style="page-break-after:always;">&nbsp;</div>
<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["PATIENT_FOLDER"];?></td>
        <td><strong><?php echo($folder->title);?></strong></td>
	</tr>
</table>
&nbsp;
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left" style="padding-top: 7px;"><span style="padding-top: 7px;">Rechnungen</span></td>
        <td><table border="0" cellspacing="0" cellpadding="0" class="timeline-legend">
        <tr>
            <td class="barchart_color_planned"><span><?php echo $lang["PATIENT_INVOICE_STATUS_PLANNED"];?></span></td>
            <td width="10"></td>
            <td class="barchart_color_inprogress"><span><?php echo $lang["PATIENT_INVOICE_STATUS_INPROGRESS"];?></span></td>
             <td width="10"></td>
            <td class="barchart_color_finished"><span><?php echo $lang["PATIENT_INVOICE_STATUS_FINISHED"];?></span></td>
            <td width="10"></td>
            <td class="barchart_color_not_finished"><span><?php echo $lang["PATIENT_INVOICE_STATUS_STORNO"];?></span></td>
        </tr>
    </table></td>
	</tr>
</table>
<p>&nbsp;</p>
<?php
if(is_array($invoices)) { ?>
<?php
	$i = 1;
	foreach ($invoices as $invoice) { 
	?>
    <table width="100%" class="fourCols-grey">
        <tr>
            <td class="greybg tinytext" style="padding-left: 15pt; width: 40px"><?php echo $i;?></td>
            <td class="<?php echo($invoice->status_invoice_class);?> tinytext" style="padding-left: 15pt; width: 224px"><?php echo($invoice->title);?></td>
            <td class="greybg tinytext" style="padding-left: 15pt; width: 224px"><?php echo($invoice->payment_type);?> <?php if($invoice->status_invoice_class == 'barchart_color_finished') { echo('am ' . $invoice->status_invoice_date); } ?></td>
            <td class="greybg tinytext" style="padding-right: 15pt; text-align: right;"><?php echo(CO_DEFAULT_CURRENCY . ' ' . $invoice->totalcosts);?></td>
        </tr>
        </table>

            <p class="tinytext grey" style="padding-left:62px; line-height: 18px;">
            	Patient: <?php echo($invoice->patient);?><br />
              Betreuung: <?php echo($invoice->management);?><?php if($invoice->totalmin !='') { echo ',';} ?> <?php echo($invoice->totalmin);?> <br />
              Rechnungsdatum: <?php echo($invoice->invoice_date);?>, Rechnungsnummer: <?php echo($invoice->invoice_number);?>
             </p>
    <?php 
	$i++;
	} ?>
  <?php
}
?>
<div style="page-break-after:always;"></div>
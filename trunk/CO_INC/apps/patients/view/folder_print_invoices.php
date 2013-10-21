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
        </tr>
    </table></td>
	</tr>
</table>
<p>&nbsp;</p>
<?php
if(is_array($invoices)) { ?>
<?php
	$i = 0;
	foreach ($invoices as $invoice) { 
	?>
    <table width="100%" class="fourCols-grey">
        <tr>
            <td class="fourCols-one greybg" style="padding-left: 15pt;">Patient</td>
            <td class="fourCols-two greybg" style="padding-left: 20pt;">&nbsp;</td>
            <td class="fourCols-three <?php echo($invoice->status_invoice_class);?>">&nbsp;</td>
            <td class="fourCols-four <?php echo($invoice->status_invoice_class);?>"><?php echo($invoice->patient);?></td>
        </tr>
        <tr>
            <td class="grey fourCols-one smalltext" style="padding-left: 15pt;">Behandlung</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext fourCols-paddingTop"><?php echo($invoice->title);?></td>
        </tr>
        <tr>
            <td class="grey fourCols-one smalltext" style="padding-left: 15pt;">Datum</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext fourCols-paddingTop"><?php echo($invoice->invoice_date);?></td>
        </tr>
        <tr>
            <td class="grey fourCols-one smalltext" style="padding-left: 15pt;">Honorar</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext fourCols-paddingTop"><?php echo(CO_DEFAULT_CURRENCY . ' ' . $invoice->totalcosts);?></td>
        </tr>
        <tr>
            <td class="grey fourCols-one smalltext" style="padding-left: 15pt;">Betreuer</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext fourCols-paddingTop"><?php echo($invoice->management);?></td>
        </tr>
    </table>
    <?php 
	$i++;
	} ?>
  <?php
}
?>
<div style="page-break-after:always;">&nbsp;</div>
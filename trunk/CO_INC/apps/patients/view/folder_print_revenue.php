	<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["PATIENT_FOLDER_TAB_REVENUE"];?></td>
        <td><span class="smalltext">Arbeitszeit/gesamt: <?php echo $calctotalmin;?></span></td>
        <td align="right"><span class="smalltext">exkl. MwStr. </span><strong><?php echo CO_DEFAULT_CURRENCY . ' ' . $calctotal;?></strong> </td>
	</tr>
</table>
<?php if(isset($folder->title)) { ?>
	<!--<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_FOLDER"];?></td>
		<td><?php echo($folder->title);?></td>
    </tr>
</table>-->
<?php } ?>
<?php if($manager != "") { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left">Betreuung</td>
		<td><?php echo $manager;?></td>
    </tr>
</table>
<?php } else { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left">Betreuung</td>
		<td>Alle</td>
    </tr>
</table>
<?php } ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left">Zeitraum</td>
		<td><?php echo $start;?> - <?php echo $end;?></td>
    </tr>
</table>
<p>&nbsp;</p>
    <?php
if(is_array($invoices)) { ?>
    <?php 
	$i = 1;
			foreach ($invoices as $invoice) {  ?>

    
    <table width="100%" class="fourCols">
        <tr>
            <td class="fourCols-one"><?php if($i == 1) { echo $lang["PATIENT_FOLDER_TAB_INVOICES"]; }?>&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three greybg">&nbsp;</td>
            <td class="fourCols-four greybg"><?php echo($invoice->title);?></td>
            <td class="fourCols-four greybg" align="right"><?php echo(CO_DEFAULT_CURRENCY . ' ' . $invoice->totalcosts);?></td>
        </tr>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext fourCols-paddingTop">
            	<span style="display:inline-block; width: 140px;">Rechnungsdatum</span><?php echo($invoice->invoice_date);?>
              </td>
        </tr>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext fourCols-paddingTop">
            	<span style="display:inline-block; width: 140px;">Rechnungsnummer</span><?php echo($invoice->invoice_number);?>
              </td>
        </tr>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext fourCols-paddingTop">
            	<span style="display:inline-block; width: 140px;">Arbeitszeit</span><?php echo($invoice->totalmin);?>
              </td>
        </tr>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext fourCols-paddingTop">
            	<span style="display:inline-block; width: 140px;">Zahlungsart</span><?php echo($invoice->payment_type);?>
              </td>
        </tr>
        <!--<tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext fourCols-paddingTop">
            	<span style="display:inline-block; width: 140px;">Patient</span><?php echo($invoice->patient);?></td>
        </tr>-->

        <?php //if($invoice->showmanagertoitem) {?>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext fourCols-paddingTop">
            <span style="display:inline-block; width: 140px;">Betreuung</span><?php  echo $invoice->management; ?>
            </td>
        </tr>
        <?php //} ?>
        </table>
        &nbsp;
    <?php 
	$i++;
	} ?>
    <?php
}
?>
<div style="page-break-after:always;">&nbsp;</div>
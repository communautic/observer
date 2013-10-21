	<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["PATIENT_FOLDER_TAB_REVENUE"];?></td>
        <td><strong><?php echo CO_DEFAULT_CURRENCY . ' ' . $calctotal;?></strong></td>
	</tr>
</table>
<?php if(isset($folder->title)) { ?>
	<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_FOLDER"];?></td>
		<td><?php echo($folder->title);?></td>
    </tr>
</table>
<?php } ?>
<?php if($manager != "") { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left">Betreuer</td>
		<td><?php echo $manager;?></td>
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
        </tr>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext fourCols-paddingTop">Rechnungsdatum <?php echo($invoice->invoice_date);?></td>
        </tr>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext fourCols-paddingTop">Patient <?php echo($invoice->patient);?></td>
        </tr>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext fourCols-paddingTop">Honorar <?php echo(CO_DEFAULT_CURRENCY . ' ' . $invoice->totalcosts);?></td>
        </tr>
                <?php if($invoice->showmanagertoitem) {?>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext fourCols-paddingTop">Betreuer <?php  echo $invoice->management; ?></td>
        </tr>
        <?php } ?>
        </table>
    <?php 
	$i++;
	} ?>
    <?php
}
?>
<div style="page-break-after:always;">&nbsp;</div>
<div style="position: absolute; width: 100%; height: 30px; overflow: hidden">
    <div id="patientsFoldersSubTabs" class="contentSubTabs" style="position: absolute;">
        <ul>
            <li><span class="left<?php if($view == 'Timeline') { echo ' active';}?>" rel="Timeline"><?php echo $lang["PATIENT_FOLDER_TAB_INVOICES_DATE"];?></span></li>
            <!--<li><span class="<?php if($view == 'Patient') { echo ' active';}?>" rel="Patient"><?php echo $lang["PATIENT_FOLDER_TAB_INVOICES_PATIENT"];?></span></li>-->
            <li><span class="<?php if($view == 'Number') { echo ' active';}?>" rel="Number"><?php echo $lang["PATIENT_FOLDER_TAB_INVOICES_NUMBER"];?></span></li>
            <li><span class="right<?php if($view == 'Status') { echo ' active';}?>" rel="Status"><?php echo $lang["PATIENT_FOLDER_TAB_INVOICES_STATUS"];?></span></li>
        </ul>
    </div>
    <div style="position: absolute; left: 225px; top: 2px;">
    <table border="0" cellspacing="0" cellpadding="0" class="timeline-legend" style="width: 522px">
        <tr>
            <td class="barchart_color_planned" width="112"><span><?php echo $lang["PATIENT_INVOICE_STATUS_PLANNED"];?></span></td>
            <td width="10"></td>
            <td class="barchart_color_inprogress" width="112"><span><?php echo $lang["PATIENT_INVOICE_STATUS_INPROGRESS"];?></span></td>
             <td width="10"></td>
            <td class="barchart_color_finished" width="112"><span><?php echo $lang["PATIENT_INVOICE_STATUS_FINISHED"];?></span></td>
            <td width="10"></td>
            <td class="barchart_color_not_finished" width="112"><span><?php echo $lang["PATIENT_INVOICE_STATUS_STORNO"];?></span></td>
        </tr>
    </table>
    </div>
</div>
<?php
if(is_array($invoices)) { ?>
<div style="position: absolute; top: 77px; bottom: 0; left: 0; right: 0px; overflow: auto;">
<table width="100%" style="font-size: 11px; border-collapse: separate">
<?php
	$i = 0;
	foreach ($invoices as $invoice) { 
	?>
    <tr >
    <td width="210" style="padding-left: 15px;" class="row<?php  echo ($i % 2);?>"><?php echo($invoice->patient);?></td>
    <td width="265" class="row<?php  echo ($i % 2);?>"><div class="loadInvoice" pid="<?php echo($invoice->pid);?>" rel="<?php echo($invoice->id);?>"><div class="co-link <?php echo($invoice->status_invoice_class);?>" style="height: 21px; overflow: hidden; padding-left: 9px;"><?php echo($invoice->title);?></div></div></td>
    <td width="65" class="row<?php  echo ($i % 2);?>" style="padding-left: 14px;"><?php echo($invoice->invoice_number);?></td>
    <td width="90" class="row<?php  echo ($i % 2);?>" style="padding-left: 14px;"><?php echo($invoice->invoice_date);?></td>
    <td width="70" class="row<?php  echo ($i % 2);?>"><?php echo($invoice->totalmin);?></td>
    <td width="70" class="row<?php  echo ($i % 2);?>"><?php echo(CO_DEFAULT_CURRENCY . ' ' . $invoice->totalcosts);?></td>
    <td width="150" class="row<?php  echo ($i % 2);?>"><?php echo($invoice->management);?></td>
    <td class="row<?php  echo ($i % 2);?>"><?php if($invoice->payment_type == 'Barzahlung') { echo($invoice->payment_type); } ?> <!--<?php if($invoice->status_invoice == 3) { echo('Storno'); } ?>--></td>
    <td></td>
    </tr>
    <?php 
	$i++;
	} ?>
   </table></div>
  <?php
}
?>

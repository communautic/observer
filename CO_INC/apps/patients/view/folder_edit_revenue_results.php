<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PATIENT_FOLDER_TAB_REVENUE"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"></td>
    </tr>
</table>
<div style="width: 100%; height: 36px; background: #e5e5e5; border-bottom: 1px solid #ccc; color: #666; font-weight: bold;">
<div style="line-height: 36px; padding-left: 150px;"><?php echo CO_DEFAULT_CURRENCY . ' ' . $calctotal;?></div>
</div>
<div class="content-spacer"></div>
<?php
if(is_array($invoices)) { ?>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PATIENT_FOLDER_TAB_INVOICES"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding">
        <?php 
			foreach ($invoices as $invoice) {  ?>
				<div class="loadInvoiceRevenue" folder="<?php echo($invoice->folder);?>" pid="<?php echo($invoice->pid);?>" rel="<?php echo($invoice->id);?>"><div class="co-link listTitle"><?php echo($invoice->title);?>, <?php echo($invoice->invoice_date);?>, <?php echo($invoice->patient);?> &nbsp; &nbsp; <?php echo(CO_DEFAULT_CURRENCY . ' ' . $invoice->totalcosts);?> &nbsp; &nbsp; <?php if($invoice->showmanagertoitem) { echo $invoice->management; } ?></div></div>
		 <?php } ?></td>
    </tr>
</table>
      <?php
}
?>
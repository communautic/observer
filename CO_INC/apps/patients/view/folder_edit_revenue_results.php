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
		<td class="tcell-right-inactive tcell-right-nopadding"></td>
    </tr>
</table>

      <?php
}
?>
<?php
if(is_array($invoices)) { ?>
<div style="position: absolute; top: 93px; bottom: 0; left: 0; right: 0px; overflow: auto;">
<table width="100%" style="font-size: 11px; border-collapse: separate">
<?php
	$i = 0;
	foreach ($invoices as $invoice) { 
	?>
    <tr >
    <td width="150" class="row<?php  echo ($i % 2);?>" nowrap>&nbsp;</td>
    <td class="row<?php  echo ($i % 2);?>" nowrap><div class="loadInvoice" pid="<?php echo($invoice->pid);?>" rel="<?php echo($invoice->id);?>"><div class="co-link" style="height: 21px; overflow: hidden;"><?php echo($invoice->title);?></div></div></td>
    <td class="row<?php  echo ($i % 2);?>" style="padding-left: 20px;" nowrap><?php echo($invoice->invoice_date);?></td>
    <td width="" class="row<?php  echo ($i % 2);?>" style="padding-left: 20px;" nowrap><?php echo($invoice->invoice_number);?></td>
    <td width="" class="row<?php  echo ($i % 2);?>" style="padding-left: 20px;" nowrap><?php echo($invoice->totalmin);?></td>
    <td width="" class="row<?php  echo ($i % 2);?>"  style="padding-left: 20px;" nowrap><?php echo(CO_DEFAULT_CURRENCY . ' ' . $invoice->totalcosts);?></td>
    <td width="" class="row<?php  echo ($i % 2);?>"  style="padding-left: 20px;" nowrap><?php echo($invoice->management);?></td>
    <td class="row<?php  echo ($i % 2);?>" style="padding-left: 20px;" nowrap><?php if($invoice->payment_type == 'Barzahlung') { echo($invoice->payment_type); } ?> <?php if($invoice->status_invoice == 3) { echo('Storno'); } ?></td>
    <td width="400" class="row<?php  echo ($i % 2);?>"></td>
    </tr>
    <?php 
	$i++;
	} ?>
   </table></div>
  <?php
}
?>

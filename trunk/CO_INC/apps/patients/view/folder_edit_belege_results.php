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
<div style="position: absolute; top: 75px; bottom: 0; left: 0; right: 0px; overflow: auto;">
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11">Zahlungen</td>
		<td class="tcell-right-inactive tcell-right-nopadding"><?php echo $zahlungen;?></td>
    </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11">Storno</td>
		<td class="tcell-right-inactive tcell-right-nopadding"><?php echo $storno;?></td>
    </tr>
</table>
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

<table width="100%" style="font-size: 11px; border-collapse: separate">

<?php
foreach ($invoices as $invoice) { 
	
	?>
	
  <?php
	$i = 0;
	foreach($invoice['item'] as $item) { ?>
    <tr>
    <td width="150" class="row<?php  echo ($i % 2);?>" nowrap>&nbsp;</td>
    <td class="row<?php  echo ($i % 2);?>" nowrap><div class="loadInvoice" pid="<?php echo($item->pid);?>" rel="<?php echo($item->id);?>"><div class="co-link" style="height: 21px; overflow: hidden;"><?php echo($item->title);?></div></div></td>
    <td class="row<?php  echo ($i % 2);?>" style="padding-left: 20px;" nowrap><?php echo($item->patient);?></td>
    <td width="" class="row<?php  echo ($i % 2);?>" style="padding-left: 20px;" nowrap><?php echo($item->beleg_nummer);?></td>
    <td width="" class="row<?php  echo ($i % 2);?>" style="padding-left: 20px;" nowrap><?php echo($item->invoice_number);?></td>
    <td width="" align="right" nowrap class="row<?php  echo ($i % 2);?>"  style="padding-left: 20px;"><?php echo(CO_DEFAULT_CURRENCY . ' ' . $item->totalcosts);?></td>
    <td class="row<?php  echo ($i % 2);?>" style="padding-left: 20px;" nowrap><?php if($item->status_invoice == 3) { echo('Storno'); } ?></td>
    <td width="400" class="row<?php  echo ($i % 2);?>"></td>
    </tr>
    <?php 
	$i++;
	} ?>
   <tr>
    <td width="150" valign="bottom" nowrap class="row<?php  echo ($i % 2);?> text13" style="padding-left: 15px;"><strong><?php echo $invoice['vat'];?>% MwSt.</strong></td>
    <td class="row<?php  echo ($i % 2);?>" nowrap></td>
    <td class="row<?php  echo ($i % 2);?>" style="padding-left: 20px;" nowrap></td>
    <td width="" class="row<?php  echo ($i % 2);?>"  style="padding-left: 20px;" nowrap></td>
    <td width="" class="row<?php  echo ($i % 2);?>"  style="padding-left: 20px;" nowrap></td>
    <td width="" align="right" nowrap class="row<?php  echo ($i % 2);?>" style="padding-left: 20px;"><?php echo(CO_DEFAULT_CURRENCY . ' ' . $invoice['netto']);?><br />
      <?php echo(CO_DEFAULT_CURRENCY . ' ' . $invoice['vat_sum']);?><br />
      <strong class="text13"><?php echo(CO_DEFAULT_CURRENCY . ' ' . $invoice['brutto']);?></strong></td>
    <td width="" class="row<?php  echo ($i % 2);?>"  style="padding-left: 20px;" nowrap>exkl.<br />
      MwSt. <?php echo $invoice['vat'];?>%<br />
      inkl.</td>
    <td width="400" class="row<?php  echo ($i % 2);?>"></td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    </tr>
	<?php }


?></table>
</div>
<?php } ?>

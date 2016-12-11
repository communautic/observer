<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PATIENT_FOLDER_TAB_REVENUE"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"></td>
    </tr>
</table>
<div style="width: 100%; height: 44px; background: #e5e5e5; border-bottom: 1px solid #ccc; color: #666; ">
<div style="line-height: 18px; padding-left: 150px;">

<table width="100%" style=" border-collapse: separate">
    <tr >
    <td width="184" valign="top" style="font-weight: bold; padding-top: 5px;">Umsatzsumme <?php echo CO_DEFAULT_CURRENCY . ' ' . $calctotal;?> <br /></td>
    <td nowrap style="font-size: 11px; padding-top: 5px;"><?php 
		if(is_array($invoices)) {
		foreach($calcvattotal as $key => $val) {
	echo CO_DEFAULT_CURRENCY . ' ' . number_format($val,2,',','.') . ' inkl. ' . $key . '% MwSt. / ';
} }?>
      <br />
      Arbeitszeit: <?php echo $calctotalmin;?></td>
    </td>
    </tr>
</table>



</div>
</div>


<?php
if(is_array($invoices)) { ?>
<div>
<table width="100%" style="font-size: 11px; border-collapse: separate">
<?php
	$i = 0;
	$vatcheck = 0;
	$totalinv = sizeof($invoices);
	foreach ($invoices as $invoice) { 

	
	if($i == 0 || $vatcheck != $invoice->vat) {
		$vatcheck_old = $vatcheck;
		$vatcheck = $invoice->vat;
		if($i != 0) {
			?>

    <tr style="line-height: 21px;">
          <td nowrap>&nbsp;</td>
          <td nowrap>&nbsp;</td>
          <td nowrap>&nbsp;</td>
          <td nowrap>&nbsp;</td>
          <td style="text-align: right; padding-right: 20px; padding-left: 20px; line-height: 22px;"><?php echo CO_DEFAULT_CURRENCY . ' ' . number_format($calcvatnetto[$vatcheck_old],2,',','.');?></td>
          <td>exkl.</td>
        </tr>
        <tr>
        <td nowrap>&nbsp;</td>
          <td nowrap>&nbsp;</td>
          <td nowrap>&nbsp;</td>
          <td nowrap>&nbsp;</td>
          <td  style="text-align: right; padding-right: 20px; padding-left: 20px; line-height: 22px;"><?php echo CO_DEFAULT_CURRENCY . ' ' . number_format($calcvattotalsum[$vatcheck_old],2,',','.');?></td>
          <td>MwSt. <?php echo $vatcheck_old;?>%</td>
        </tr>
        <tr>
        <td nowrap>&nbsp;</td>
          <td nowrap>&nbsp;</td>
          <td nowrap>&nbsp;</td>
          <td nowrap>&nbsp;</td>
          <td style="text-align: right; padding-right: 20px; padding-left: 20px; line-height: 22px; font-weight:bold;"><?php echo CO_DEFAULT_CURRENCY . ' ' . number_format($calcvattotal[$vatcheck_old],2,',','.');?></td>
          <td>inkl.</td>
        </tr>
    <?php
		}
		?>
    <tr >
    <td colspan="6">
    <div class="content-spacer"></div>
    <table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11" style="width: 160px;">Einzelergebnisse <?php echo $invoice->vat;?>% MwSt.</td>
		<td class="tcell-right-inactive tcell-right-nopadding"></td>
    </tr>
</table>
    </td>
   </tr>
    <?php
		
	}
	//echo $invoice->vat;
	?>
    <tr >
    <td width="135" class="row<?php  echo ($i % 2);?>" style="padding-left: 15px;"><?php  echo $i+1;?></td>
    <td width="169" class="row<?php  echo ($i % 2);?>" nowrap><div class="loadInvoice" pid="<?php echo($invoice->pid);?>" rel="<?php echo($invoice->id);?>"><div class="co-link" style="height: 21px; overflow: hidden;"><?php echo($invoice->title);?></div></div></td>
    <td width="70" class="row<?php  echo ($i % 2);?>" style="padding-left: 20px;" nowrap><?php echo($invoice->payment_type); ?></td>
    <td width="75" class="row<?php  echo ($i % 2);?>" style="padding-left: 20px;" nowrap><?php if($invoice->status_invoice_class == 'barchart_color_finished') { echo('am ' . $invoice->status_invoice_date); } ?></td>
    <td width="70" class="row<?php  echo ($i % 2);?>"  style="text-align: right; padding-right: 20px; padding-left: 20px;" nowrap><?php echo(CO_DEFAULT_CURRENCY . ' ' . $invoice->totalcosts);?></td>
    <td class="row<?php  echo ($i % 2);?>"></td>
    </tr>
    <?php if($invoice->showDetails) { ?>
    <tr>
    <td nowrap>&nbsp;</td>
    <td colspan="9" style="color: #666; padding: 10px 0 10px 23px;">
    <?php echo $invoice->html_patient;?>
    <?php echo $invoice->html_betreuung;?>
    <?php echo $invoice->html_invoice;?>
    </td>
    </tr>
    <?php 
		}
	$i++;
	
	
	} ?>

   

        <tr style="line-height: 21px;">
          <td nowrap>&nbsp;</td>
          <td nowrap>&nbsp;</td>
          <td nowrap>&nbsp;</td>
          <td nowrap>&nbsp;</td>
          <td style="text-align: right; padding-right: 20px; padding-left: 20px; line-height: 22px;"><?php echo CO_DEFAULT_CURRENCY . ' ' . number_format($calcvatnetto[$vatcheck],2,',','.');?></td>
          <td>exkl.</td>
        </tr>
        <tr>
        <td nowrap>&nbsp;</td>
          <td nowrap>&nbsp;</td>
          <td nowrap>&nbsp;</td>
          <td nowrap>&nbsp;</td>
          <td  style="text-align: right; padding-right: 20px; padding-left: 20px; line-height: 22px;"><?php echo CO_DEFAULT_CURRENCY . ' ' . number_format($calcvattotalsum[$vatcheck],2,',','.');?></td>
          <td>MwSt. <?php echo $vatcheck;?>%</td>
        </tr>
        <tr>
        <td nowrap>&nbsp;</td>
          <td nowrap>&nbsp;</td>
          <td nowrap>&nbsp;</td>
          <td nowrap>&nbsp;</td>
          <td style="text-align: right; padding-right: 20px; padding-left: 20px; line-height: 22px; font-weight:bold;"><?php echo CO_DEFAULT_CURRENCY . ' ' . number_format($calcvattotal[$vatcheck],2,',','.');?></td>
          <td>inkl.</td>
        </tr>

   
   
   
   </table></div>
  <?php
}
?>
<div class="content-spacer"></div>
<div style="padding-left: 125px;">
<?php if($chartGender['show']) { ?>
<div style="position: relative; float: left; width: 150px; margin: 0px 9px 0 9px; text-align: center" class="text11">
	<!--<div style="position: relative; height: 23px; background-color:#c3c3c3; padding: 3px 0 0 8px">Titel</div>
    <div style="position: absolute; right: 8px;">%</div>-->
    <div><img src="/data/charts/<?php echo($chartGender['img_name']);?>?t=<?php echo(time());?>" alt="" width="150" height="90" title=""/></div>
    <?php echo($chartGender['male']);?>% m&auml;nnlich <br /><?php echo($chartGender['female']);?>% weiblich <br /><?php echo($chartGender['notset']);?>% keine Angabe
</div>
<?php } ?>
<?php if($chartAge['show']) { ?>
<div style="position: relative; float: left; width: 150px; margin: 0px 9px 0 9px; text-align: center" class="text11">
	<!--<div style="position: relative; height: 23px; background-color:#c3c3c3; padding: 3px 0 0 8px">Titel</div>
    <div style="position: absolute; right: 8px;">%</div>-->
    <div><img src="/data/charts/<?php echo($chartAge['img_name']);?>?t=<?php echo(time());?>" alt="" width="150" height="90" title=""/></div>
    <?php echo($chartAge['ageGroup25']);?>% bis 25 <br /><?php echo($chartAge['ageGroup60']);?>% 25 bis 60 <br /><?php echo($chartAge['ageGroup60Plus']);?>% ab 61<br /><?php echo($chartAge['ageGroupNotset']);?>% keine Angabe
</div>
<?php } ?>
</div>
<div class="content-spacer" style="clear:both;"></div>
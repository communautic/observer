<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["PATIENT_FOLDER"];?></td>
        <td><strong><?php echo($folder->title);?></strong></td>
	</tr>
</table>
&nbsp;
<table width="100%" class="standard">
	<tr>
        <td class="tcell-left">Umsatzsumme <?php echo CO_DEFAULT_CURRENCY . ' ' . $calctotal;?></td>
        <td class="smalltext" style="padding-top: 3pt;"><?php 
		if(is_array($invoices)) {
		foreach($calcvattotal as $key => $val) {
	echo CO_DEFAULT_CURRENCY . ' ' . number_format($val,2,',','.') . ' inkl. ' . $key . '% MwSt. / ';
} }?></td>
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
<table width="100%">
	<tr>
		<td class="grey smalltext" style="padding-left: 59px; width: 108px;">Betreuung</td>
		<td class="grey smalltext"><?php echo $manager;?></td>
    </tr>
</table>
<?php } else { ?>
<table width="100%">
	<tr>
		<td class="grey smalltext" style="padding-left: 59px; width: 111px;">Betreuung</td>
		<td class="grey smalltext">Alle</td>
    </tr>
</table>
<?php } ?>
<table width="100%">
	<tr>
		<td class="grey smalltext" style="padding-left: 59px; width: 111px;">Zeitraum</td>
		<td class="grey smalltext"><?php echo $start;?> - <?php echo $end;?></td>
    </tr>
</table>
<?php if($show_arbeitszeit == 1) { ?>
<table width="100%">
	<tr>
		<td class="grey smalltext" style="padding-left: 59px; width: 111px;">Arbeitszeit</td>
		<td class="grey smalltext"><?php echo $calctotalmin;?></td>
    </tr>
</table>
<?php } ?>
<p>&nbsp;</p>
<?php
if(is_array($invoices)) { ?>

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
<table width="100%" class="standard smalltext">
    <tr>
    			
          <td style="text-align: right; padding-right: 20px; padding-left: 20px;">exkl.</td>
          <td style="width: 80px;text-align: right;"><?php echo CO_DEFAULT_CURRENCY . ' ' . number_format($calcvatnetto[$vatcheck_old],2,',','.');?></td>
        </tr>
        <tr>
          <td style="text-align: right; padding-right: 20px; padding-left: 20px;">MwSt. <?php echo $vatcheck_old;?>%</td>
          <td style="text-align: right;"><?php echo CO_DEFAULT_CURRENCY . ' ' . number_format($calcvattotalsum[$vatcheck_old],2,',','.');?></td>
        </tr>
        <tr>
          <td style="text-align: right; padding-right: 20px; padding-left: 20px;">inkl.</td>
          <td style="text-align: right; font-weight:bold;"><?php echo CO_DEFAULT_CURRENCY . ' ' . number_format($calcvattotal[$vatcheck_old],2,',','.');?></td>
        </tr>
        </table>
        &nbsp;
    <?php
		}
		?>
    <table width="100%" class="standard">
      <tr>
        <td class="tcell-left tinytext">Einzelergebnisse <?php echo $invoice->vat;?>% MwSt.</td>
     </tr>
		</table>
    <?php
		
	}
	//echo $invoice->vat;
	?>
  <table width="100%" class="fourCols-grey smalltext">
        <tr>
            <td class="greybg" style="padding-left: 15pt; width: 40px"><?php echo $i+1;?></td>
            <td class="greybg" style="padding-left: 15pt; width: 224px"><?php echo($invoice->title);?></td>
            <td class="greybg" style="padding-left: 15pt; width: 224px"><?php 
			if($invoice->display_legacy_payment_method) { 
				echo($invoice->payment_type); 
			} else { ?> 
      <?php 
				if($invoice->filter_barzahlung == 1 && $invoice->filter_ueberweisung == 1) {
					if($invoice->ueberweisungcosts > 0 && $invoice->barcosts > 0) {
						echo 'Barzahlung/&Uuml;berweisung';
					} else {
						if($invoice->barcosts > 0) {
							echo "Barzahlung";
						} else {
							echo "&Uuml;berweisung";
						}
					}
				} else {
					if($invoice->filter_barzahlung == 1) {
						if($invoice->ueberweisungcosts > 0) {
							echo "Barzahlung (Teilbetrag)";
						} else {
							echo "Barzahlung";
						}
					}
					if($invoice->filter_ueberweisung == 1) {
						if($invoice->barcosts > 0) {
							echo "&Uuml;berweisung (Teilbetrag)";
						} else {
							echo "&Uuml;berweisung";
						}
					}
				}
			} ?> <?php if($invoice->status_invoice_class == 'barchart_color_finished') { echo('am ' . $invoice->status_invoice_date); } ?></td>
            <td class="greybg" style="padding-right: 15pt; text-align: right;"><?php echo(CO_DEFAULT_CURRENCY . ' ' . $invoice->totalcosts);?></td>
        </tr>
        </table>
    
    <?php if($invoice->showDetails) { ?>
    <p class="tinytext grey" style="padding-left:61px; line-height: 18px;">
    <?php echo $invoice->html_patient;?>
    <?php echo $invoice->html_betreuung;?>
    <?php echo $invoice->html_invoice;?>
    </p>
    <?php 
		}
	$i++;
	
	
	} ?>

   
<table width="100%" class="standard smalltext">
        <tr>
          
          
          <td style="text-align: right; padding-right: 20px; padding-left: 20px;">exkl.</td>
          <td style="width: 80px;text-align: right;"><?php echo CO_DEFAULT_CURRENCY . ' ' . number_format($calcvatnetto[$vatcheck],2,',','.');?></td>
        </tr>
        <tr>
          <td style="text-align: right; padding-right: 20px; padding-left: 20px;">MwSt. <?php echo $vatcheck;?>%</td>
          <td style="text-align: right;"><?php echo CO_DEFAULT_CURRENCY . ' ' . number_format($calcvattotalsum[$vatcheck],2,',','.');?></td>
        </tr>
        <tr>
          <td style="text-align: right; padding-right: 20px; padding-left: 20px;">inkl.</td>
          <td style="text-align: right; font-weight:bold;"><?php echo CO_DEFAULT_CURRENCY . ' ' . number_format($calcvattotal[$vatcheck],2,',','.');?></td>
          
          
        </tr>
   </table>
   &nbsp;
   <table width="100%" class="fourCols-grey">
        <tr>
          <td class="" style="padding-left: 15pt; width: 40px;">&nbsp;</td>
   <?php if($chartGender['show']) { ?>
   <td valign="top" class="smalltext" style="width: 150px; text-align:center;">
    <img src="<?php echo(CO_PATH_BASE);?>/data/charts/<?php echo($chartGender['img_name']);?>?t=<?php echo(time());?>" alt="" width="150" height="90" title=""/> <br />
    <?php echo($chartGender['male']);?>% m&auml;nnlich <br /><?php echo($chartGender['female']);?>% weiblich <br /><?php echo($chartGender['notset']);?>% keine Angabe <br />
    </td>
<?php } ?>
<?php if($chartAge['show']) { ?>
<td valign="top" class="smalltext" style="width: 150px; text-align:center">
    <img src="<?php echo(CO_PATH_BASE);?>/data/charts/<?php echo($chartAge['img_name']);?>?t=<?php echo(time());?>" alt="" width="150" height="90" title=""/> <br />
    <?php echo($chartAge['ageGroup25']);?>% bis 25 <br /><?php echo($chartAge['ageGroup60']);?>% 25 bis 60 <br /><?php echo($chartAge['ageGroup60Plus']);?>% ab 61<br /><?php echo($chartAge['ageGroupNotset']);?>% keine Angabe
    </td>
<?php } ?>
<td></td>
   </tr>
        </table>

   
   
  <?php
}
?>
<div style="page-break-after:always;">&nbsp;</div>
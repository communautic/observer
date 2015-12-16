<table width="100%" class="title">
	<tr>
        <td class="tcell-left">Umsatzergebnis Bar</td>
        <td align="right"><strong><?php echo CO_DEFAULT_CURRENCY . ' ' . $calctotal;?></strong> </td>
	</tr>
</table>

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
		<td class="tcell-left">Kassenbeleg</td>
		<td><?php echo $start;?> - <?php echo $end;?></td>
  </tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left">Zahlungen</td>
		<td><?php echo $zahlungen;?></td>
  </tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left">Storno</td>
		<td><?php echo $storno;?></td>
  </tr>
</table>
<p>&nbsp;</p>
<?php
if(is_array($invoices)) { ?>

<?php
foreach ($invoices as $invoice) { 
	$i = 0;
	foreach($invoice['item'] as $item) { ?>
<table width="100%" class="fourCols">
        <tr>
          <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three greybg">&nbsp;</td>
            <td class="fourCols-four greybg"><?php echo($item->title);?></td>
            <td class="fourCols-four greybg" align="right"><span class="smalltext"><?php if($item->status_invoice == 3) { echo('Storno &nbsp;'); } ?> <?php echo(CO_DEFAULT_CURRENCY . ' ' . $item->totalcosts);?></span></td>
        </tr>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext fourCols-paddingTop">
            	<span style="display:inline-block; width: 140px;">Patient</span><?php echo($item->patient);?></td>
              <td></td>
        </tr>
         <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext fourCols-paddingTop">
            	<span style="display:inline-block; width: 140px;">Belegnummer</span><?php echo($item->beleg_nummer);?></td>
        </tr>
        </table>
        &nbsp;
    <?php 
	$i++;
	} ?>
   <table width="100%" class="title" style="line-height: 18px;">
	<tr>
	  <td class="tcell-left" valign="bottom"><strong class="text13"><?php echo $invoice['vat'];?>% MwSt.</strong></td>
        <td class="tcell-left smalltext"  width="210" valign="bottom">Umsatzergebnis Bar</td>
        <td class="smalltext">exkl.<br />
      MwSt. <?php echo $invoice['vat'];?>%<br />
      inkl.</td>
        <td align="right"><span class="smalltext"><?php echo(CO_DEFAULT_CURRENCY . ' ' . $invoice['netto']);?><br />
      <?php echo(CO_DEFAULT_CURRENCY . ' ' . $invoice['vat_sum']);?></span><br />
      <strong class="text13"><?php echo(CO_DEFAULT_CURRENCY . ' ' . $invoice['brutto']);?></strong></td>
	</tr>
</table>
<p>&nbsp;</p>
        <p>&nbsp;</p>
	<?php }

?>
<?php } ?>

    
<div style="page-break-after:always;">&nbsp;</div>
<table width="100%" class="title grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["PATIENT_SERVICE_TITLE"];?></td>
        <td><strong><?php echo($service->title);?></strong></td>
	</tr>
</table>

<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($service->status_text);?> <?php echo($service->status_text_time);?> <?php echo($service->status_date)?></td>
	</tr>
</table>
&nbsp;
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_SERVICE_GOALS"];?></td>
		<td>&nbsp;</td>
    </tr>
</table>
<?php
$i = 1;
foreach($task as $value) { 
	$img = '&nbsp;';
	if($value->status == 1) {
		$img = '<img src="' . CO_FILES . '/img/print/done.png" width="12" height="12" vspace="2" hspace="4" /> ';
	}
     ?>
    <table width="100%" class="fourCols-grey">
        <tr>
            <td class="fourCols-three-15 greybg"><?php echo $img;?></td>
            <td class="fourCols-four greybg"><strong><?php echo($value->title);?></strong></td>
        </tr>
     </table>
     <table width="100%" class="standard">
	<tr>
	  <td class="tcell-left">Menge</td>
        <td><?php echo(nl2br($value->menge));?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left">Preis</td>
        <td><?php echo(nl2br($value->preis));?></td>
	</tr>
</table>
      
      
    <br />&nbsp;
	<?php 
	$i++;
	}
?>
<div style="page-break-after:always;">&nbsp;</div>
<table width="100%" class="title grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["PATIENT_TREATMENT_PRINT_TITLE"];?></td>
        <td><strong><?php echo($treatment->title);?>, <?php echo($treatment->patient);?></strong></td>
	</tr>
</table>
&nbsp;
<table width="100%" class="standard">
	<tr>
        <td class="tcell-left" style="padding-top: 15px;"><?php echo $lang["PATIENT_TREATMENT_PRINT_OPTION_DATES"];?></td>
        <td>
        <table width="100%" class="standard" style="border:1px solid #ccc;">
<?php
$i = 1;
foreach($task as $value) { 
$img = '&nbsp;';
if($value->status == 1) {
		$img = '<img src="' . CO_FILES . '/img/print/done.png" width="12" height="12" vspace="2" /> ';
	}
     ?>
      <tr>
        <td style="width: 10px;">&nbsp;</td>
        <td style="width: 150px; padding: 6px 0; border-bottom:1px solid #ccc;"><?php echo $img;?> <span class="bold" style="margin-left: 7px;"><?php echo $i;?>. <?php echo $lang["PATIENT_TREATMENT_GOALS_SINGUAL"];?></span></td>
        <td class="smalltext" style="width: 80px; padding: 7px 0 4px 0; border-bottom:1px solid #ccc;"><?php echo $value->startdate;?></td>
             <td class="smalltext" style="text-align: center; border-bottom: 1px solid #ccc; padding: 7px 0 4px 0;"><?php echo $value->time;?></td>
            <td class="smalltext" style="text-align: center; border-bottom: 1px solid #ccc; padding: 7px 0 4px 0;"><?php echo $value->min;?> min.</td>
      </tr>
	<?php 
	$i++;
	}
?>
</table>
</td>
	</tr>
</table>
<div style="page-break-after:always;">&nbsp;</div>
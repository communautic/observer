<table width="100%" class="title grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["PATIENT_TREATMENT_TITLE"];?></td>
        <td><strong><?php echo($treatment->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left">Behandlungsdauer</td>
		<td>&nbsp;</td>
    </tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_TREATMENT_DATE"];?></td>
		<td><?php echo($treatment->item_date)?></td>
    </tr>
</table>
<?php if(!empty($treatment->doctor_print) || !empty($treatment->doctor_ct)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_TREATMENT_DOCTOR"];?></td>
		<td><?php echo($treatment->doctor_print)?><br /><?php echo($treatment->doctor_ct);?></td>
    </tr>
</table>
<?php } ?>
<?php if(!empty($treatment->protocol)) { ?>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["PATIENT_TREATMENT_DOCTOR_DIAGNOSE"];?></td>
        <td><?php echo(nl2br($treatment->protocol));?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($treatment->status_text);?> <?php echo($treatment->status_text_time);?> <?php echo($treatment->status_date)?></td>
	</tr>
</table>

<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left">Befundung</td>
        <td>&nbsp;</td>
	</tr>
</table>
<div style="height: 400px; width: 400px; position: relative;">
<img src="<?php echo(CO_FILES);?>/img/body.png" />
                    <?php $i = 1; 
						$j = $treatment->diagnoses;
                        foreach($diagnose as $value) { 
							$active = '';
							if($i == 1) {
								$active = ' active';
							}
							$curcol = ($i-1) % 10;
							?>
                            
                           <div style="position: absolute;"><img src="data:image/png;base64,<?php echo $value->canvas;?>" /></div>
                           <div style="position: absolute; z-index: 10<?php echo $i;?>; top: <?php echo $value->y;?>px; left: <?php echo $value->x;?>px;" class="loadCanvas circle circle<?php echo $curcol;?> <?php echo $active;?>"><div><?php echo $i;?></div></div>
                        <?php 
						$i++;
						$j--;
						} ?>

</div>
<p>&nbsp;</p>
<?php 
					$i = 1;
                        foreach($diagnose as $value) { 
						$active = '';
							if($i == 1) {
								$active = ' active';
							}
							$curcol = ($i-1) % 10; ?>
                                <table width="100%" class="standard">
	<tr>
	  <td><?php echo $value->text;?>&nbsp;</td>
        <td width="30">&nbsp;</td>
	</tr>
</table>
<?php 
							$i++;
                         } ?>
<?php if(!empty($treatment->protocol2)) { ?>
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["PATIENT_TREATMENT_PROTOCOL2"];?></td>
        <td><?php echo(nl2br($treatment->protocol2));?></td>
	</tr>
</table>
<?php } ?>
&nbsp;

<?php
$i = 1;
foreach($task as $value) { 
     ?>
    <table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td><?php echo $value->title;?></td>
        <td width="30"><?php echo $value->answer;?></td>
	</tr>
</table>
<?php echo(nl2br($value->text));?>
	<?php 
	$i++;
	}
?>
<div style="page-break-after:always;">&nbsp;</div>
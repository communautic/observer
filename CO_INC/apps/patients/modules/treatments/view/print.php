<table width="100%" class="title grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["PATIENT_TREATMENT_TITLE"];?></td>
        <td><strong><?php echo($treatment->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_TREATMENT_DURATION"];?></td>
		<td><?php echo($treatment->treatment_start);?> - <?php echo($treatment->treatment_end);?></td>
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
		<td><?php echo($treatment->doctor_print)?><?php echo($treatment->doctor_ct);?></td>
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
<?php if(!empty($treatment->method)) { ?>
&nbsp;
<table width="100%" class="standard">
	<tr>
        <td class="tcell-left top"><?php echo $lang["PATIENT_TREATMENT_METHOD"];?></td>
        <td><?php echo(nl2br($treatment->method));?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($treatment->protocol2)) { ?>
<table width="100%" class="standard">
	<tr>
        <td class="tcell-left top"><?php if(CO_PRODUCT_VARIANT == 1) { echo $lang["PATIENT_TREATMENT_PRESCRIPTION_PHYSIO"]; } else { echo $lang["PATIENT_TREATMENT_PRESCRIPTION_THERAPY"]; }?></td>
        <td><?php echo(nl2br($treatment->protocol2));?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($treatment->sessionvalstext)) { ?>
<table width="100%" class="standard">
	<tr>
        <td class="tcell-left top"><?php if(CO_PRODUCT_VARIANT == 1) { echo $lang["PATIENT_TREATMENT_ACHIEVMENT_STATUS_PHYSIO"]; } else { echo $lang["PATIENT_TREATMENT_ACHIEVMENT_STATUS_THERAPY"]; }?></td>
        <td><?php echo(nl2br($treatment->sessionvalstext));?></td>
	</tr>
</table>
<?php } ?>


<?php if(!empty($treatment->protocol3)) { ?>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["PATIENT_TREATMENT_DESCRIPTION"];?></td>
        <td><?php echo(nl2br($treatment->protocol3));?></td>
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



&nbsp;
<?php
$i = 1;
foreach($task as $value) { 
$img = '&nbsp;';
if($value->status == 1) {
		$img = '<img src="' . CO_FILES . '/img/print/done.png" width="12" height="12" vspace="2" /> ';
	}
     ?>
<table width="100%" class="fourCols">
        <tr>
            <td class="fourCols-one"><?php if($i == 1) { echo $lang["PATIENT_TREATMENT_PLAN"]; }?>&nbsp;</td>
            <td class="fourCols-two"><?php echo $img;?></td>
            <td class="fourCols-three greybg">&nbsp;</td>
            <td class="fourCols-four greybg"><?php echo $i;?>. <?php echo $lang["PATIENT_TREATMENT_GOALS_SINGUAL"];?></td>
        </tr>
        <?php if(!empty($value->type)) { ?>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext fourCols-paddingTop"><?php echo $lang["PATIENT_TREATMENT_TASKS_TYPE"];?> <?php echo strip_tags($value->type);?></td>
        </tr>
        <?php } ?>
        <?php if(!empty($value->team) || !empty($value->team_ct)) { ?>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext"><?php echo $lang["PATIENT_TREATMENT_TASKS_THERAPIST"];?> <?php echo($value->team . " " . $value->team_ct);?></td>
        </tr>
        <?php } ?>
        <?php if(!empty($value->place) || !empty($value->place_ct)) { ?>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext"><?php echo $lang["PATIENT_TREATMENT_TASKS_PLACE"];?> <?php echo($value->place . $value->place_ct);?></td>
        </tr>
         <?php } ?>
        <?php if(!empty($value->item_date)) { ?>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext"><?php echo $lang["PATIENT_TREATMENT_TASKS_DATE"];?> <?php echo($value->item_date);?></td>
        </tr>
        <?php } ?>
        <?php if(!empty($value->time)) { ?>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext"><?php echo $lang["PATIENT_TREATMENT_TASKS_TIME"];?> <?php echo($value->time);?></td>
        </tr>
        <?php } ?>
        <?php if(!empty($value->min)) { ?>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext"><?php echo $lang["PATIENT_TREATMENT_TASKS_DURATION"];?> <?php echo $value->min;?> Min</td>
        </tr>
        <?php } ?>
        <?php if(!empty($value->text)) { ?>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext"><?php echo nl2br($value->text);?></td>
        </tr>
        <?php } ?>
        
         <tr>
             <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext">&nbsp;</td>
        </tr>
    </table>
	<?php 
	$i++;
	}
?>
&nbsp;
<?php if(!empty($task_bar)) { ?>
<table width="100%" class="standard">
	<tr>
        <td class="tcell-left top">Barzahlung</td>
        <td>
        <?php 
				foreach($task_bar as $value) {
					$ttasks = explode(',',$value->task_ids);
					$ttask_string = '';
					$ttask_costs = 0;
					$ttask_vat_text = '(inkl. ' . $treatment->vat . '% MwSt.)';
					foreach($ttasks as $ttask) {
						$ttask_costs += $bar_compare_array[$ttask]['costs'];
						$ttask_string .= $bar_compare_array[$ttask]['task_num'] . '. ' . $lang["PATIENT_TREATMENT_GOALS_SINGUAL"] . ' | ';
					}
					
					if($treatment->discount != 0) {
							$ttask_costs = $ttask_costs-(($ttask_costs/100)*$treatment->discount);
						}
					if($treatment->vat != 0) {
							$ttask_costs = $ttask_costs+(($ttask_costs/100)*$treatment->vat);
						}
					$ttask_costs = number_format($ttask_costs,2,',','.');
					
					$ttask_string_full = $ttask_string . ' Rechnungsnr. ' . $treatment->invoice_carrier . '/' . $treatment->invoice_year . '/' . $treatment->invoice_no . ' | ' . CO_DEFAULT_CURRENCY . ' ' . $ttask_costs . ' ' . $ttask_vat_text;
					echo $ttask_string_full . '<br>';
					}
					

		
?>
        </td>
	</tr>
</table>
<?php } ?>
<div style="page-break-after:always;">&nbsp;</div>
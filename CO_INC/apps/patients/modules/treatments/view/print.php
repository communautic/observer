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

<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PATIENT_TREATMENT_DIAGNOSE"];?></td>
        <td>&nbsp;</td>
	</tr>
</table>
<?php if ($printcanvas == 1) { ?>
<div style="height: 400px; width: 400px; position: relative;">
<img src="<?php echo(CO_FILES);?>/img/body.png" />
<?php $i = 1; 
	$j = $treatment->diagnoses;
	foreach($diagnose as $value) { 
		$curcol = ($i-1) % 10;
		?>
	   <div style="position: absolute;"><img src="data:image/png;base64,<?php echo $value->canvas;?>" /></div>
	   <div style="position: absolute; z-index: 10<?php echo $i;?>; top: <?php echo $value->y;?>px; left: <?php echo $value->x;?>px;" class="loadCanvas circle circle<?php echo $curcol;?>"><div><?php echo $i;?></div></div>
	<?php 
	$i++;
	$j--;
} ?>
</div>
<p>&nbsp;</p>
<?php 
}
$i = 1;
	foreach($diagnose as $value) { 
	$curcol = ($i-1) % 10; ?>
    <table width="100%" class="standard">
        <tr>
        <?php if ($printcanvas == 1) { ?><td class="top" style="width: 30px;"><div class="circle circle<?php echo $curcol;?>"><div><?php echo $i;?></div></div></td><?php } ?>
          <td><?php echo $value->text;?>&nbsp;</td>
        </tr>
    </table>
<?php 
	$i++;
} ?>
<p>&nbsp;</p>
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
            <td class="fourCols-four greybg"><?php echo($value->title);?></td>
        </tr>
        <?php if(!empty($value->type)) { ?>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext fourCols-paddingTop"><?php echo $lang["PATIENT_TREATMENT_TASKS_TYPE"];?> <?php echo($value->type);?></td>
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
<div style="page-break-after:always;">&nbsp;</div>
<?php if(!empty($treatment->code)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php if(CO_PRODUCT_VARIANT == 1) { echo $lang["PATIENT_CODE_PO"]; }?><?php if(CO_PRODUCT_VARIANT == 2) { echo $lang["PATIENT_CODE_TO"]; }?></td>
		<td><?php echo($treatment->code);?></td>
	</tr>
</table>
<?php } ?>
<table width="100%" class="standard">
	<tr>
        <td class="tcell-left">Patient/in</td>
        <td><strong><?php echo($treatment->firstname);?> <?php echo($treatment->lastname);?></strong></td>
	</tr>
</table>
<?php if(!empty($treatment->dob)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_DOB"];?></td>
		<td><?php echo($treatment->dob);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($treatment->number)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_INSURANCE_NUMBER"];?></td>
		<td><?php echo($treatment->number);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($treatment->insurance)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_INSURANCE"];?></td>
		<td><?php echo($treatment->insurance);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($treatment->insurer)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_INSURER"];?></td>
		<td><?php echo($treatment->insurer);?><br /><?php echo($treatment->insurer_ct);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($treatment->number_insurer)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_INSURANCE_INSURER_NUMBER"];?></td>
		<td><?php echo($treatment->number_insurer);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($treatment->doctor_print) || !empty($treatment->doctor_ct)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_TREATMENT_DOCTOR"];?></td>
		<td><?php if(!empty($treatment->doctor_print)) { echo($treatment->doctor_print)?><br /><?php } ?><?php echo($treatment->doctor_ct);?></td>
    </tr>
</table>
<?php } ?>
&nbsp;
&nbsp;
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left">Adresse</td>
		<td><?php echo($treatment->address_line1)?>, <?php echo($treatment->address_postcode)?> <?php echo($treatment->address_town)?></td>
    </tr>
</table>
<?php if(!empty($treatment->phone1)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left">Telefon</td>
		<td><?php echo($treatment->phone1)?></td>
    </tr>
</table>
<?php } ?>
<?php if(!empty($treatment->email)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left">E-mail</td>
		<td><?php echo($treatment->email)?></td>
    </tr>
</table>
<?php } ?>
&nbsp;
&nbsp;
<?php if(!empty($treatment->familystatus)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left">Familienstand</td>
		<td><?php echo($treatment->familystatus);?></td>
    </tr>
</table>
<?php } ?>
<?php if(!empty($treatment->coo)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left">Beschäftigung</td>
		<td><?php echo($treatment->coo);?></td>
    </tr>
</table>
<?php } ?>
<?php if(!empty($treatment->company) || !empty($treatment->position)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left">Firma / Position</td>
		<td><?php if(!empty($treatment->company)) { echo($treatment->company . ' / '); }?><?php echo($treatment->position);?></td>
    </tr>
</table>
<?php } ?>
&nbsp;
&nbsp;
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left">Kosten</td>
		<td>&euro; <?php echo($treatment->totalcosts)?></td>
    </tr>
</table>
<?php if(!empty($treatment->sessionvalstext)) { ?>
<table width="100%" class="standard">
	<tr>
        <td class="tcell-left top"><?php if(CO_PRODUCT_VARIANT == 1) { echo $lang["PATIENT_TREATMENT_ACHIEVMENT_STATUS_PHYSIO"]; } else { echo $lang["PATIENT_TREATMENT_ACHIEVMENT_STATUS_THERAPY"]; }?></td>
        <td><?php echo(nl2br($treatment->sessionvalstext));?></td>
	</tr>
</table>
<?php } ?>



&nbsp;

        <table width="100%" class="standard" style="border:1px solid #ccc;">
<?php
$i = 1;
foreach($task as $value) { 
$img = '&nbsp;';
if($value->status == 1) {
		//$img = '<img src="' . CO_FILES . '/img/print/done.png" width="12" height="12" vspace="2" /> ';
	
     ?>
      <tr>
        <td style="width: 10px; border-bottom:1px solid #ccc;">&nbsp;</td>
        <td style="width: 120px; padding: 6px 0; border-bottom:1px solid #ccc;"><span class="bold" style="margin-left: 7px;"><?php echo $i;?>. <?php echo $lang["PATIENT_TREATMENT_GOALS_SINGUAL"];?></span></td>
        <td class="smalltext" style="width: 80px; padding: 7px 0 4px 0; border-bottom:1px solid #ccc;">(<?php echo $value->startdate;?>)</td>
             <td class="smalltext" style="text-align: center; border-bottom: 1px solid #ccc; padding: 7px 0 4px 0;"><?php echo strip_tags($value->type);?></td>
            <td class="smalltext" style="text-align: center; border-bottom: 1px solid #ccc; padding: 7px 0 4px 0;"><?php echo $value->min;?> min.</td>
            <?php
						$text = '';
						$text = explode('<br />', nl2br($value->text));
						$firstline = $text[0];
						$firstline = mb_substr($firstline,0,25,'UTF-8').'...';
						?>
            
            <td style="border-bottom: 1px solid #ccc; padding: 7px 0 4px 0;"><?php echo $firstline;?></td>
            
      </tr>
	<?php 
	$i++;
	}
	
	}
?>
</table>
<div style="page-break-after:always;">&nbsp;</div>
<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["PATIENT_TITLE"];?></td>
        <td><strong><?php echo($patient->title);?></strong></td>
	</tr>
</table>
<!--<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PATIENT_FOLDER"];?></td>
        <td><?php echo($patient->folder);?></td>
	</tr>
</table>-->
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_MANAGEMENT"];?></td>
		<td><?php echo($patient->management_print);?><br /><?php echo($patient->management_ct);?></td>
	</tr>
</table>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["PATIENT_CONTACT_DETAILS"];?></td>
        <td><?php echo($patient->ctitle)?> <?php echo($patient->title2)?> <?php echo($patient->title);?><br />
		<?php echo($patient->position . "<br />" . $lang["PATIENT_CONTACT_EMAIL"] . " " . $patient->email . " &nbsp; | &nbsp; " . $lang["PATIENT_CONTACT_PHONE"] . " " . $patient->phone1);?></td>
	</tr>
</table>
<?php if(!empty($patient->code)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php if(CO_PRODUCT_VARIANT == 1) { echo $lang["PATIENT_CODE_PO"]; }?><?php if(CO_PRODUCT_VARIANT == 2) { echo $lang["PATIENT_CODE_TO"]; }?></td>
		<td><?php echo($patient->code);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($patient->dob)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_DOB"];?></td>
		<td><?php echo($patient->dob);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($patient->familystatus)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_FAMILYSTATUS"];?></td>
		<td><?php echo($patient->familystatus);?></td>
    </tr>
</table>
<?php } ?>
<?php if(!empty($patient->coo)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_COO"];?></td>
		<td><?php echo($patient->coo);?></td>
	</tr>
</table>
<?php } ?>
<!--<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($patient->status_text);?> <?php echo($patient->status_text_time);?> <?php echo($patient->status_date)?></td>
	</tr>
</table>
&nbsp;-->
<?php if(!empty($patient->number)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_INSURANCE_NUMBER"];?></td>
		<td><?php echo($patient->number);?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_INSURER"];?></td>
		<td><?php echo($patient->insurer);?><br /><?php echo($patient->insurer_ct);?></td>
	</tr>
</table>
<?php if(!empty($patient->number_insurer)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_INSURANCE_INSURER_NUMBER"];?></td>
		<td><?php echo($patient->number_insurer);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($patient->insurance)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_INSURANCE"];?></td>
		<td><?php echo($patient->insurance);?></td>
	</tr>
</table>
<?php } ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_INSURANCE_ADDITIONAL"];?></td>
		<td><?php echo($patient->insurance_add);?></td>
	</tr>
</table>
<?php if(!empty($patient->protocol)) { ?>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["PATIENT_DESCRIPTION"];?></td>
        <td><?php echo(nl2br($patient->protocol));?></td>
	</tr>
</table>
<?php } ?>
<div style="page-break-after:always;">&nbsp;</div>
<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["PATIENT_TITLE"];?></td>
        <td><strong><?php echo($patient->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PATIENT_FOLDER"];?></td>
        <td><?php echo($patient->folder);?></td>
	</tr>
</table>
<?php if(!empty($patient->startdate)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_STARTDATE"];?></td>
		<td><?php echo($patient->startdate);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($patient->enddate)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_ENDDATE"];?></td>
		<td><?php echo($patient->enddate);?></td>
	</tr>
</table>
<?php } ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($patient->status_text);?> <?php echo($patient->status_text_time);?> <?php echo($patient->status_date)?></td>
	</tr>
</table>
&nbsp;
<?php if(!empty($patient->number)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_NUMBER"];?></td>
		<td><?php echo($patient->number);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($patient->kind)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_KIND"];?></td>
		<td><?php echo($patient->kind);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($patient->area)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_AREA"];?></td>
		<td><?php echo($patient->area);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($patient->department)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_DEPARTMENT"];?></td>
		<td><?php echo($patient->department);?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top">Kontaktdaten</td>
        <td><?php echo($patient->ctitle)?> <?php echo($patient->title2)?> <?php echo($patient->title);?><br />
		<?php echo($patient->position . "<br />" . $lang["PATIENT_CONTACT_EMAIL"] . " " . $patient->email . " &nbsp; | &nbsp; " . $lang["PATIENT_CONTACT_PHONE"] . " " . $patient->phone1);?></td>
	</tr>
</table>
<?php if(!empty($patient->dob)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_DOB"];?></td>
		<td><?php echo($patient->dob);?></td>
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
<?php if(!empty($patient->languages)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_LANGUAGES"];?></td>
		<td><?php echo($patient->languages);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($patient->protocol)) { ?>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["PATIENT_DESCRIPTION"];?></td>
        <td><?php echo(nl2br($patient->protocol));?></td>
	</tr>
</table>
<?php } ?>

&nbsp;
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left">Privatadresse</td>
		<td>&nbsp;</td>
	</tr>
</table>
<?php if(!empty($patient->street_private)) { ?>
<table width="100%" class="standard grey"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_PRIVATE_STREET"];?></td>
		<td><?php echo($patient->street_private);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($patient->city_private)) { ?>
<table width="100%" class="standard grey"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_PRIVATE_CITY"];?></td>
		<td><?php echo($patient->city_private);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($patient->zip_private)) { ?>
<table width="100%" class="standard grey"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_PRIVATE_ZIP"];?></td>
		<td><?php echo($patient->zip_private);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($patient->phone_private)) { ?>
<table width="100%" class="standard grey"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_PRIVATE_PHONE"];?></td>
		<td><?php echo($patient->phone_private);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($patient->email_private)) { ?>
<table width="100%" class="standard grey"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_PRIVATE_EMAIL"];?></td>
		<td><?php echo($patient->email_private);?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left">Einstiegskompetenz</td>
		<td>&nbsp;</td>
	</tr>
</table>
<?php if(!empty($patient->email_private)) { ?>
<table width="100%" class="standard grey"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_EDUCATION"];?></td>
		<td><?php echo($patient->education);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($patient->protocol2)) { ?>
<table width="100%" class="standard grey"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_EDUCATION_ADDITIONAL"];?></td>
		<td><?php echo($patient->protocol2);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($patient->protocol3)) { ?>
<table width="100%" class="standard grey"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_EXPERIENCE"];?></td>
		<td><?php echo($patient->protocol3);?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left">Leistungsstatus</td>
		<td>&nbsp;</td>
	</tr>
</table>
<table width="100%" class="standard-margin grey">
	<tr>
		<td width="33%"><?php $this->getChartPerformance($patient->id,'happiness',1);?></td>
		<td width="33%"><?php $this->getChartPerformance($patient->id,'performance',1);?></td>
		<td width="33%"><?php $this->getChartPerformance($patient->id,'goals',1);?></td>
	</tr>
</table>
<table width="100%" class="standard-margin grey">
	<tr>
        <td width="33%"><?php $this->getChartPerformance($patient->id,'totals',1);?></td>
        <td width="33%">&nbsp;</td>
		<td width="33%">&nbsp;</td>
	</tr>
</table>


<div style="page-break-after:always;">&nbsp;</div>
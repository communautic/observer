<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["EMPLOYEE_TITLE"];?></td>
        <td><strong><?php echo($employee->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["EMPLOYEE_FOLDER"];?></td>
        <td><?php echo($employee->folder);?></td>
	</tr>
</table>
<?php if(!empty($employee->startdate)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_STARTDATE"];?></td>
		<td><?php echo($employee->startdate);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($employee->enddate)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_ENDDATE"];?></td>
		<td><?php echo($employee->enddate);?></td>
	</tr>
</table>
<?php } ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($employee->status_text);?> <?php echo($employee->status_text_time);?> <?php echo($employee->status_date)?></td>
	</tr>
</table>
&nbsp;
<?php if(!empty($employee->number)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_NUMBER"];?></td>
		<td><?php echo($employee->number);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($employee->kind)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_KIND"];?></td>
		<td><?php echo($employee->kind);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($employee->area)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_AREA"];?></td>
		<td><?php echo($employee->area);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($employee->department)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_DEPARTMENT"];?></td>
		<td><?php echo($employee->department);?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top">Kontaktdaten</td>
        <td><?php echo($employee->ctitle)?> <?php echo($employee->title2)?> <?php echo($employee->title);?><br />
		<?php echo($employee->position . "<br />" . $lang["EMPLOYEE_CONTACT_EMAIL"] . " " . $employee->email . " &nbsp; | &nbsp; " . $lang["EMPLOYEE_CONTACT_PHONE"] . " " . $employee->phone1);?></td>
	</tr>
</table>
<?php if(!empty($employee->dob)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_DOB"];?></td>
		<td><?php echo($employee->dob);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($employee->coo)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_COO"];?></td>
		<td><?php echo($employee->coo);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($employee->languages)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_LANGUAGES"];?></td>
		<td><?php echo($employee->languages);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($employee->protocol)) { ?>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["EMPLOYEE_DESCRIPTION"];?></td>
        <td><?php echo(nl2br($employee->protocol));?></td>
	</tr>
</table>
<?php } ?>

&nbsp;
<table width="100%" class="standard-grey-paddingBottom"> 
   <tr>
		<td class="tcell-left">Privatadresse</td>
		<td>&nbsp;</td>
	</tr>
</table>
<?php if(!empty($employee->street_private)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_PRIVATE_STREET"];?></td>
		<td><?php echo($employee->street_private);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($employee->city_private)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_PRIVATE_CITY"];?></td>
		<td><?php echo($employee->city_private);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($employee->zip_private)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_PRIVATE_ZIP"];?></td>
		<td><?php echo($employee->zip_private);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($employee->phone_private)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_PRIVATE_PHONE"];?></td>
		<td><?php echo($employee->phone_private);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($employee->email_private)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_PRIVATE_EMAIL"];?></td>
		<td><?php echo($employee->email_private);?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<table width="100%" class="standard-grey-paddingBottom"> 
   <tr>
		<td class="tcell-left">Einstiegskompetenz</td>
		<td>&nbsp;</td>
	</tr>
</table>
<?php if(!empty($employee->education)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_EDUCATION"];?></td>
		<td><?php echo($employee->education);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($employee->protocol5)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left">&nbsp;</td>
		<td><?php echo($employee->protocol5);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($employee->protocol6)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_EXPERIENCE_EXTERNAL"];?></td>
		<td><?php echo($employee->protocol6);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($employee->protocol3)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_EXPERIENCE"];?></td>
		<td><?php echo($employee->protocol3);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($employee->protocol2)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EMPLOYEE_EDUCATION_ADDITIONAL"];?></td>
		<td><?php echo($employee->protocol2);?></td>
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
		<td width="33%"><?php $this->getChartPerformance($employee->id,'happiness',1);?></td>
		<td width="33%"><?php $this->getChartPerformance($employee->id,'performance',1);?></td>
		<td width="33%"><?php $this->getChartPerformance($employee->id,'goals',1);?></td>
	</tr>
</table>
<table width="100%" class="standard-margin grey">
	<tr>
        <td width="33%"><?php $this->getChartPerformance($employee->id,'totals',1);?></td>
        <td width="33%">&nbsp;</td>
		<td width="33%">&nbsp;</td>
	</tr>
</table>


<div style="page-break-after:always;">&nbsp;</div>
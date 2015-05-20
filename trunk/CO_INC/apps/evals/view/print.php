<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["EVAL_TITLE"];?></td>
        <td><strong><?php echo($eval->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["EVAL_FOLDER"];?></td>
        <td><?php echo($eval->folder);?></td>
	</tr>
</table>
<?php if(!empty($eval->startdate)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_STARTDATE"];?></td>
		<td><?php echo($eval->startdate);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($eval->enddate)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_ENDDATE"];?></td>
		<td><?php echo($eval->enddate);?></td>
	</tr>
</table>
<?php } ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($eval->status_text);?> <?php echo($eval->status_text_time);?> <?php echo($eval->status_date)?></td>
	</tr>
</table>
&nbsp;
<?php if(!empty($eval->number)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_NUMBER"];?></td>
		<td><?php echo($eval->number);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($eval->kind)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_KIND"];?></td>
		<td><?php echo($eval->kind);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($eval->area)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_AREA"];?></td>
		<td><?php echo($eval->area);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($eval->department)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_DEPARTMENT"];?></td>
		<td><?php echo($eval->department);?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top">Kontaktdaten</td>
        <td><?php echo($eval->ctitle)?> <?php echo($eval->title2)?> <?php echo($eval->title);?><br />
		<?php echo($eval->position . "<br />" . $lang["EVAL_CONTACT_EMAIL"] . " " . $eval->email . " &nbsp; | &nbsp; " . $lang["EVAL_CONTACT_PHONE"] . " " . $eval->phone1);?></td>
	</tr>
</table>
<?php if(!empty($eval->dob)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_DOB"];?></td>
		<td><?php echo($eval->dob);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($eval->coo)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_COO"];?></td>
		<td><?php echo($eval->coo);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($eval->languages)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_LANGUAGES"];?></td>
		<td><?php echo($eval->languages);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($eval->protocol)) { ?>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["EVAL_DESCRIPTION"];?></td>
        <td><?php echo(nl2br($eval->protocol));?></td>
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
<?php if(!empty($eval->street_private)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_PRIVATE_STREET"];?></td>
		<td><?php echo($eval->street_private);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($eval->city_private)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_PRIVATE_CITY"];?></td>
		<td><?php echo($eval->city_private);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($eval->zip_private)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_PRIVATE_ZIP"];?></td>
		<td><?php echo($eval->zip_private);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($eval->phone_private)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_PRIVATE_PHONE"];?></td>
		<td><?php echo($eval->phone_private);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($eval->email_private)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_PRIVATE_EMAIL"];?></td>
		<td><?php echo($eval->email_private);?></td>
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
<?php if(!empty($eval->education)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_EDUCATION"];?></td>
		<td><?php echo($eval->education);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($eval->protocol5)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left">&nbsp;</td>
		<td><?php echo($eval->protocol5);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($eval->protocol6)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_EXPERIENCE_EXTERNAL"];?></td>
		<td><?php echo($eval->protocol6);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($eval->protocol3)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_EXPERIENCE"];?></td>
		<td><?php echo($eval->protocol3);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($eval->protocol2)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["EVAL_EDUCATION_ADDITIONAL"];?></td>
		<td><?php echo($eval->protocol2);?></td>
	</tr>
</table>
<?php } ?>
<?php if($trainig_display) { ?>
<div class="content-spacer"></div>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left">Trainingsteilnahmen</td>
        <td><?php 
		if(!empty($trainings)) {
			foreach($trainings as $training) {
				echo($training->title . ' | ' . $training->dates_display . ' | ' . $training->total_result . '%<br />');
			}
		}
		?></td>
	</tr>
</table>
<div class="content-spacer"></div>
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
		<td width="33%"><?php $this->getChartPerformance($eval->id,'happiness',1);?></td>
		<td width="33%"><?php $this->getChartPerformance($eval->id,'performance',1);?></td>
		<td><?php $this->getChartPerformance($eval->id,'goals',1);?></td>
	</tr>
</table>
<table width="100%" class="standard-margin grey">
	<tr>
        <td width="33%"><?php $this->getChartPerformance($eval->id,'totals',1);?></td>
        <td width="33%">&nbsp;</td>
		<td width="33%">&nbsp;</td>
	</tr>
</table>
&nbsp;
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left">Leistungsarchiv</td>
		<td><?php 
		if(!empty($leistungen)) {
			$i = 0;
			foreach($leistungen as $leistung) {
				if($i != 0) {
				echo ($leistung->item_date . ', ' . $leistung->title . ' (' . $leistung->total . '%)<br />');
				}
			$i++;
			}
		}
		?></td>
	</tr>
</table>
<div style="page-break-after:always;">&nbsp;</div>
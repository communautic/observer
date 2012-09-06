<table width="100%" class="title grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["PATIENT_TREATMENT_TITLE"];?></td>
        <td><strong><?php echo($treatment->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard-grey">
	<tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_TREATMENT_DATE"];?></td>
		<td><?php echo($treatment->item_date)?></td>
    </tr>
</table>
<table width="100%" class="standard-grey">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PATIENT_TREATMENT_TIME_START"];?></td>
        <td><?php echo($treatment->start);?></td>
	</tr>
</table>
<table width="100%" class="standard-grey">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PATIENT_TREATMENT_TIME_END"];?></td>
        <td><?php echo($treatment->end);?></td>
	</tr>
</table>
<table width="100%" class="standard-grey">
    <tr>
	  <td class="tcell-left"><?php echo $lang["PATIENT_TREATMENT_PLACE"];?></td>
        <td><?php echo($treatment->location);?></td>
	</tr>
</table>
<?php if(!empty($treatment->participants_print) || !empty($treatment->participants_ct)) { ?>
<table width="100%" class="standard-grey">
	<tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_TREATMENT_ATTENDEES"];?></td>
		<td><?php echo($treatment->participants_print)?><br /><?php echo($treatment->participants_ct);?></td>
    </tr>
</table>
<?php } ?>
<?php if(!empty($treatment->management_print) || !empty($treatment->management_ct)) { ?>
<table width="100%" class="standard-grey">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PATIENT_TREATMENT_MANAGEMENT"];?></td>
        <td><?php echo($treatment->management_print);?><br /><?php echo($treatment->management_ct);?></td>
	</tr>
</table>
<?php } ?>
<table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($treatment->status_text);?> <?php echo($treatment->status_text_time);?> <?php echo($treatment->status_date)?></td>
	</tr>
</table>
&nbsp;
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left">MA-Zufriedenheit</td>
        <td>erreichte Zufriedenheit <?php echo $treatment->tab1result;?>%</td>
	</tr>
</table>
<!-- Q1 -->
<table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td><?php echo $lang["PATIENT_TREATMENT_TAB1_QUESTION_1"];?></td>
        <td width="30"><?php echo $treatment->tab1q1_selected;?></td>
	</tr>
</table>
<?php echo(nl2br(strip_tags($treatment->tab1q1_text)));?>
<!-- Q2 -->
<table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td><?php echo $lang["PATIENT_TREATMENT_TAB1_QUESTION_2"];?></td>
        <td width="30"><?php echo $treatment->tab1q2_selected;?></td>
	</tr>
</table>
<?php echo(nl2br(strip_tags($treatment->tab1q2_text)));?>
<!-- Q3 -->
<table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td><?php echo $lang["PATIENT_TREATMENT_TAB1_QUESTION_3"];?></td>
        <td width="30"><?php echo $treatment->tab1q3_selected;?></td>
	</tr>
</table>
<?php echo(nl2br(strip_tags($treatment->tab1q3_text)));?>
<!-- Q4 -->
<table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td><?php echo $lang["PATIENT_TREATMENT_TAB1_QUESTION_4"];?></td>
        <td width="30"><?php echo $treatment->tab1q4_selected;?></td>
	</tr>
</table>
<?php echo(nl2br(strip_tags($treatment->tab1q4_text)));?>
<!-- Q5 -->
<table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td><?php echo $lang["PATIENT_TREATMENT_TAB1_QUESTION_5"];?></td>
        <td width="30"><?php echo $treatment->tab1q5_selected;?></td>
	</tr>
</table>
<?php echo(nl2br(strip_tags($treatment->tab1q5_text)));?>
&nbsp;
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left">Leistungsbewertung</td>
        <td>erreichte Leistung <?php echo $treatment->tab2result;?>%</td>
	</tr>
</table>
<!-- Q1 -->
<table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td><?php echo $lang["PATIENT_TREATMENT_TAB2_QUESTION_1"];?></td>
        <td width="30"><?php echo $treatment->tab2q1_selected;?></td>
	</tr>
</table>
<?php echo(nl2br(strip_tags($treatment->tab2q1_text)));?>
<!-- Q2 -->
<table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td><?php echo $lang["PATIENT_TREATMENT_TAB2_QUESTION_2"];?></td>
        <td width="30"><?php echo $treatment->tab2q2_selected;?></td>
	</tr>
</table>
<?php echo(nl2br(strip_tags($treatment->tab2q2_text)));?>
<!-- Q3 -->
<table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td><?php echo $lang["PATIENT_TREATMENT_TAB2_QUESTION_3"];?></td>
        <td width="30"><?php echo $treatment->tab2q3_selected;?></td>
	</tr>
</table>
<?php echo(nl2br(strip_tags($treatment->tab2q3_text)));?>
<!-- Q4 -->
<table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td><?php echo $lang["PATIENT_TREATMENT_TAB2_QUESTION_4"];?></td>
        <td width="30"><?php echo $treatment->tab2q4_selected;?></td>
	</tr>
</table>
<?php echo(nl2br(strip_tags($treatment->tab2q4_text)));?>
<!-- Q5 -->
<table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td><?php echo $lang["PATIENT_TREATMENT_TAB2_QUESTION_5"];?></td>
        <td width="30"><?php echo $treatment->tab2q5_selected;?></td>
	</tr>
</table>
<?php echo(nl2br(strip_tags($treatment->tab2q5_text)));?>
<!-- Q6 -->
<table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td><?php echo $lang["PATIENT_TREATMENT_TAB2_QUESTION_6"];?></td>
        <td width="30"><?php echo $treatment->tab2q6_selected;?></td>
	</tr>
</table>
<?php echo(nl2br(strip_tags($treatment->tab2q6_text)));?>
<!-- Q7 -->
<table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td><?php echo $lang["PATIENT_TREATMENT_TAB2_QUESTION_7"];?></td>
        <td width="30"><?php echo $treatment->tab2q7_selected;?></td>
	</tr>
</table>
<?php echo(nl2br(strip_tags($treatment->tab2q7_text)));?>
<!-- Q8 -->
<table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td><?php echo $lang["PATIENT_TREATMENT_TAB2_QUESTION_8"];?></td>
        <td width="30"><?php echo $treatment->tab2q8_selected;?></td>
	</tr>
</table>
<?php echo(nl2br(strip_tags($treatment->tab2q8_text)));?>
<!-- Q9 -->
<table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td><?php echo $lang["PATIENT_TREATMENT_TAB2_QUESTION_9"];?></td>
        <td width="30"><?php echo $treatment->tab2q9_selected;?></td>
	</tr>
</table>
<?php echo(nl2br(strip_tags($treatment->tab2q9_text)));?>
<!-- Q10 -->
<table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td><?php echo $lang["PATIENT_TREATMENT_TAB2_QUESTION_10"];?></td>
        <td width="30"><?php echo $treatment->tab2q10_selected;?></td>
	</tr>
</table>
<?php echo(nl2br(strip_tags($treatment->tab2q10_text)));?>
&nbsp;
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left">Zielsetzungen</td>
        <td>erreichte Zielsetzungen <?php echo $treatment->tab3result;?>%</td>
	</tr>
</table>
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
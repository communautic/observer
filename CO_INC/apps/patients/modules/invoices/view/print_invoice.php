<table width="100%" class="title grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["PATIENT_INVOICE_TITLE"];?></td>
        <td><strong><?php echo($invoice->title);?></strong></td>
	</tr>
</table>
&nbsp;
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left">Patient</td>
		<td><?php echo($patient->title);?></td>
	</tr>
</table>
<?php if(!empty($patient->company)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_COMPANY"];?></td>
		<td><?php echo($patient->company);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($patient->team_print) || !empty($patient->team_ct)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_TEAM"];?></td>
		<td><?php echo($patient->team_print);?><br /><?php echo($patient->team_ct);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($patient->patient)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PATIENT_PATIENTCAT"];?></td>
		<td><?php echo($patient->patient);?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<?php 
switch($patient->patient_id) {
	case '1'; ?> <!-- 1 	Vortrag -->
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left">Vortrag</td>
                <td><?php echo $patient->date1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["PATIENT_TIME_START"];?></td>
                <td><?php echo $patient->time1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["PATIENT_TIME_END"];?></td>
                <td><?php echo $patient->time2;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey-paddingBottom">
            <tr>
              <td class="tcell-left"><?php echo $lang["PATIENT_PLACE"];?></td>
                <td><?php echo $patient->place1;?><?php echo $patient->place1_ct;?></td>
            </tr>
        </table>
<?php
    break;
	case '2'; ?> <!-- 2 	Vortrag & Gruppencoaching -->
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left">Vortrag</td>
                <td><?php echo $patient->date1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["PATIENT_TIME_START"];?></td>
                <td><?php echo $patient->time1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["PATIENT_TIME_END"];?></td>
                <td><?php echo $patient->time2;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["PATIENT_PLACE"];?></td>
                <td><?php echo $patient->place1;?><?php echo $patient->place1_ct;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left">Coaching</td>
                <td><?php echo $patient->date2;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["PATIENT_TIME_START"];?></td>
                <td><?php echo $patient->time3;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["PATIENT_TIME_END"];?></td>
                <td><?php echo $patient->time4;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey-paddingBottom">
            <tr>
              <td class="tcell-left"><?php echo $lang["PATIENT_PLACE"];?></td>
                <td><?php echo $patient->place2;?><?php echo $patient->place2_ct;?></td>
            </tr>
        </table>
<?php
    break;
	case '3'; ?> <!-- 3 	e-patient -->
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left">e-patient</td>
                <td>https://webbased-academy.communautic.com</td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["PATIENT_TIME_START"];?></td>
                <td><?php echo $patient->date1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey-paddingBottom">
            <tr>
              <td class="tcell-left"><?php echo $lang["PATIENT_TIME_END"];?></td>
                <td><?php echo $patient->date3;?></td>
            </tr>
        </table>
<?php
    break;
	case '4'; ?> <!-- 4 	e-patient & Praesenzcoaching -->
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left">e-patient</td>
                <td>https://webbased-academy.communautic.com</td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["PATIENT_TIME_START"];?></td>
                <td><?php echo $patient->date1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["PATIENT_TIME_END"];?></td>
                <td><?php echo $patient->date3;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left">Coaching</td>
                <td><?php echo $patient->date2;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["PATIENT_TIME_START"];?></td>
                <td><?php echo $patient->time3;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["PATIENT_TIME_END"];?></td>
                <td><?php echo $patient->time4;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey-paddingBottom">
            <tr>
              <td class="tcell-left"><?php echo $lang["PATIENT_PLACE"];?></td>
                <td><?php echo $patient->place2;?><?php echo $patient->place2_ct;?></td>
            </tr>
        </table>
<?php
    break;
	case '5'; ?> <!-- 5 Einzelcoaching -->
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left">Coaching</td>
                <td><?php echo $patient->date1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["PATIENT_TIME_START"];?></td>
                <td><?php echo $patient->time1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["PATIENT_TIME_END"];?></td>
                <td><?php echo $patient->time2;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey-paddingBottom">
            <tr>
              <td class="tcell-left"><?php echo $lang["PATIENT_PLACE"];?></td>
                <td><?php echo $patient->place1;?><?php echo $patient->place1_ct;?></td>
            </tr>
        </table>
<?php
    break;
	case '6'; ?> <!-- 5 Einzelcoaching -->
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left">Workshop</td>
                <td><?php echo $patient->date1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["PATIENT_TIME_START"];?></td>
                <td><?php echo $patient->time1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["PATIENT_TIME_END"];?></td>
                <td><?php echo $patient->time2;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey-paddingBottom">
            <tr>
              <td class="tcell-left"><?php echo $lang["PATIENT_PLACE"];?></td>
                <td><?php echo $patient->place1;?><?php echo $patient->place1_ct;?></td>
            </tr>
        </table>
<?php
    break;
	case '7'; ?> <!-- 7 Veranstaltungsreihe -->
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left">Veranstaltungsbeginn</td>
                <td><?php echo $patient->date1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left">Folgetermine</td>
                <td><?php echo $patient->text1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left">Veranstaltungsende</td>
                <td><?php echo $patient->date2;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left">Dauer</td>
                <td><?php echo $patient->text2;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey-paddingBottom">
            <tr>
              <td class="tcell-left"><?php echo $lang["PATIENT_PLACE"];?></td>
                <td><?php echo $patient->text3;?></td>
            </tr>
        </table>
<?php
    break;
} ?>
&nbsp;<br />
&nbsp;<br />
<table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td class="tcell-left">erreichte Zufriedenheit</td>
        <td><strong><?php echo $invoice->total_result;?>%</strong></td>
	</tr>
</table>
&nbsp;<br />
<table width="100%" class="standard">
    <tr>
		<td>1 &nbsp; <?php echo $lang["PATIENT_INVOICE_QUESTION_1"];?></td>
        <td width="40" style="text-align: right;"><?php echo $invoice->q1_result;?>%</td>
	</tr>
</table>
&nbsp;<br />
<table width="100%" class="standard">
    <tr>
		<td>2&nbsp; <?php echo $lang["PATIENT_INVOICE_QUESTION_2"];?></td>
        <td width="40" style="text-align: right;"><?php echo $invoice->q2_result;?>%</td>
	</tr>
</table>
&nbsp;<br />
<table width="100%" class="standard">
    <tr>
		<td>3&nbsp; <?php echo $lang["PATIENT_INVOICE_QUESTION_3"];?></td>
        <td width="40" style="text-align: right;"><?php echo $invoice->q3_result;?>%</td>
	</tr>
</table>
&nbsp;<br />
<table width="100%" class="standard">
    <tr>
		<td>4&nbsp; <?php echo $lang["PATIENT_INVOICE_QUESTION_4"];?></td>
        <td width="40" style="text-align: right;"><?php echo $invoice->q4_result;?>%</td>
	</tr>
</table>
&nbsp;<br />
<table width="100%" class="standard">
    <tr>
		<td>5&nbsp; <?php echo $lang["PATIENT_INVOICE_QUESTION_5"];?></td>
        <td width="40" style="text-align: right;"><?php echo $invoice->q5_result;?>%</td>
	</tr>
</table>
&nbsp;<br />
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["PATIENT_INVOICE_QUESTION_6"];?></td>
        <td><?php echo(nl2br($invoice->invoice_text));?></td>
	</tr>
</table>
<div style="page-break-after:always;">&nbsp;</div>
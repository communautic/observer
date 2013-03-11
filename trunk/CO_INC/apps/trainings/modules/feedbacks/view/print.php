<table width="100%" class="title grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["TRAINING_FEEDBACK_TITLE"];?></td>
        <td><strong><?php echo($feedback->title);?></strong></td>
	</tr>
</table>
&nbsp;
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left">Training</td>
		<td><?php echo($training->title);?></td>
	</tr>
</table>
<?php if(!empty($training->company)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["TRAINING_COMPANY"];?></td>
		<td><?php echo($training->company);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($training->team_print) || !empty($training->team_ct)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["TRAINING_TEAM"];?></td>
		<td><?php echo($training->team_print);?><br /><?php echo($training->team_ct);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($training->training)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["TRAINING_TRAININGCAT"];?></td>
		<td><?php echo($training->training);?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<?php 
switch($training->training_id) {
	case '1'; ?> <!-- 1 	Vortrag -->
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left">Vortrag</td>
                <td><?php echo $training->date1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_START"];?></td>
                <td><?php echo $training->time1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_END"];?></td>
                <td><?php echo $training->time2;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey-paddingBottom">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_PLACE"];?></td>
                <td><?php echo $training->place1;?><?php echo $training->place1_ct;?></td>
            </tr>
        </table>
<?php
    break;
	case '2'; ?> <!-- 2 	Vortrag & Gruppencoaching -->
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left">Vortrag</td>
                <td><?php echo $training->date1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_START"];?></td>
                <td><?php echo $training->time1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_END"];?></td>
                <td><?php echo $training->time2;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_PLACE"];?></td>
                <td><?php echo $training->place1;?><?php echo $training->place1_ct;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left">Coaching</td>
                <td><?php echo $training->date2;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_START"];?></td>
                <td><?php echo $training->time3;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_END"];?></td>
                <td><?php echo $training->time4;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey-paddingBottom">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_PLACE"];?></td>
                <td><?php echo $training->place2;?><?php echo $training->place2_ct;?></td>
            </tr>
        </table>
<?php
    break;
	case '3'; ?> <!-- 3 	e-training -->
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left">e-training</td>
                <td>https://webbased-academy.communautic.com</td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_START"];?></td>
                <td><?php echo $training->date1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey-paddingBottom">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_END"];?></td>
                <td><?php echo $training->date3;?></td>
            </tr>
        </table>
<?php
    break;
	case '4'; ?> <!-- 4 	e-training & Praesenzcoaching -->
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left">e-training</td>
                <td>https://webbased-academy.communautic.com</td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_START"];?></td>
                <td><?php echo $training->date1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_END"];?></td>
                <td><?php echo $training->date3;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left">Coaching</td>
                <td><?php echo $training->date2;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_START"];?></td>
                <td><?php echo $training->time3;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_END"];?></td>
                <td><?php echo $training->time4;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey-paddingBottom">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_PLACE"];?></td>
                <td><?php echo $training->place2;?><?php echo $training->place2_ct;?></td>
            </tr>
        </table>
<?php
    break;
	case '5'; ?> <!-- 5 Einzelcoaching -->
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left">Coaching</td>
                <td><?php echo $training->date1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_START"];?></td>
                <td><?php echo $training->time1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_END"];?></td>
                <td><?php echo $training->time2;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey-paddingBottom">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_PLACE"];?></td>
                <td><?php echo $training->place1;?><?php echo $training->place1_ct;?></td>
            </tr>
        </table>
<?php
    break;
	case '6'; ?> <!-- 5 Einzelcoaching -->
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left">Workshop</td>
                <td><?php echo $training->date1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_START"];?></td>
                <td><?php echo $training->time1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_END"];?></td>
                <td><?php echo $training->time2;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey-paddingBottom">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_PLACE"];?></td>
                <td><?php echo $training->place1;?><?php echo $training->place1_ct;?></td>
            </tr>
        </table>
<?php
    break;
	case '7'; ?> <!-- 7 Veranstaltungsreihe -->
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left">Veranstaltungsbeginn</td>
                <td><?php echo $training->date1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left">Folgetermine</td>
                <td><?php echo $training->text1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left">Veranstaltungsende</td>
                <td><?php echo $training->date2;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey">
            <tr>
              <td class="tcell-left">Dauer</td>
                <td><?php echo $training->text2;?></td>
            </tr>
        </table>
        <table width="100%" class="standard-grey-paddingBottom">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_PLACE"];?></td>
                <td><?php echo $training->text3;?></td>
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
        <td><strong><?php echo $feedback->total_result;?>%</strong></td>
	</tr>
</table>
&nbsp;<br />
<table width="100%" class="standard">
    <tr>
		<td>1 &nbsp; <?php echo $lang["TRAINING_FEEDBACK_QUESTION_1"];?></td>
        <td width="40" style="text-align: right;"><?php echo $feedback->q1_result;?>%</td>
	</tr>
</table>
&nbsp;<br />
<table width="100%" class="standard">
    <tr>
		<td>2&nbsp; <?php echo $lang["TRAINING_FEEDBACK_QUESTION_2"];?></td>
        <td width="40" style="text-align: right;"><?php echo $feedback->q2_result;?>%</td>
	</tr>
</table>
&nbsp;<br />
<table width="100%" class="standard">
    <tr>
		<td>3&nbsp; <?php echo $lang["TRAINING_FEEDBACK_QUESTION_3"];?></td>
        <td width="40" style="text-align: right;"><?php echo $feedback->q3_result;?>%</td>
	</tr>
</table>
&nbsp;<br />
<table width="100%" class="standard">
    <tr>
		<td>4&nbsp; <?php echo $lang["TRAINING_FEEDBACK_QUESTION_4"];?></td>
        <td width="40" style="text-align: right;"><?php echo $feedback->q4_result;?>%</td>
	</tr>
</table>
&nbsp;<br />
<table width="100%" class="standard">
    <tr>
		<td>5&nbsp; <?php echo $lang["TRAINING_FEEDBACK_QUESTION_5"];?></td>
        <td width="40" style="text-align: right;"><?php echo $feedback->q5_result;?>%</td>
	</tr>
</table>
&nbsp;<br />
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["TRAINING_FEEDBACK_QUESTION_6"];?></td>
        <td><?php echo(nl2br($feedback->feedback_text));?></td>
	</tr>
</table>
<div style="page-break-after:always;">&nbsp;</div>
<table width="100%" class="fourCols-grey">
    <tr>
    <td class="fourCols-three-15 greybg">&nbsp;</td>
        <td class="fourCols-four greybg" style="font-size: 14pt; padding: 2pt 0;"><strong><?php echo($training->title);?></strong></td>
    </tr>
 </table>
&nbsp;
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
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left">Vortrag</td>
                <td><?php echo $training->date1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_START"];?></td>
                <td><?php echo $training->time1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_END"];?></td>
                <td><?php echo $training->time2;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_PLACE"];?></td>
                <td><?php echo $training->place1;?><?php echo $training->place1_ct;?></td>
            </tr>
        </table>

<?php
    break;
	case '2'; ?> <!-- 2 	Vortrag & Gruppencoaching -->
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left">Vortrag</td>
                <td><?php echo $training->date1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_START"];?></td>
                <td><?php echo $training->time1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_END"];?></td>
                <td><?php echo $training->time2;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_PLACE"];?></td>
                <td><?php echo $training->place1;?><?php echo $training->place1_ct;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left">Coaching</td>
                <td><?php echo $training->date2;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_START"];?></td>
                <td><?php echo $training->time3;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_END"];?></td>
                <td><?php echo $training->time4;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_PLACE"];?></td>
                <td><?php echo $training->place2;?><?php echo $training->place2_ct;?></td>
            </tr>
        </table>
<?php
    break;
	case '3'; ?> <!-- 3 	e-training -->
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left">e-training</td>
                <td>https://webbased-academy.communautic.com</td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_START"];?></td>
                <td><?php echo $training->date1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_END"];?></td>
                <td><?php echo $training->date3;?></td>
            </tr>
        </table>
<?php
    break;
	case '4'; ?> <!-- 4 	e-training & Praesenzcoaching -->
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left">e-training</td>
                <td>https://webbased-academy.communautic.com</td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_START"];?></td>
                <td><?php echo $training->date1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_END"];?></td>
                <td><?php echo $training->date3;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left">Coaching</td>
                <td><?php echo $training->date2;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_START"];?></td>
                <td><?php echo $training->time3;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_END"];?></td>
                <td><?php echo $training->time4;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_PLACE"];?></td>
                <td><?php echo $training->place2;?><?php echo $training->place2_ct;?></td>
            </tr>
        </table>
<?php
    break;
	case '5'; ?> <!-- 5 Einzelcoaching -->
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left">Coaching</td>
                <td><?php echo $training->date1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_START"];?></td>
                <td><?php echo $training->time1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_END"];?></td>
                <td><?php echo $training->time2;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_PLACE"];?></td>
                <td><?php echo $training->place1;?><?php echo $training->place1_ct;?></td>
            </tr>
        </table>
<?php
    break;
	case '6'; ?> <!-- 5 Einzelcoaching -->
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left">Workshop</td>
                <td><?php echo $training->date1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_START"];?></td>
                <td><?php echo $training->time1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_TIME_END"];?></td>
                <td><?php echo $training->time2;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_PLACE"];?></td>
                <td><?php echo $training->place1;?><?php echo $training->place1_ct;?></td>
            </tr>
        </table>
<?php
    break;
	case '7'; ?> <!-- 7 Veranstaltungsreihe -->
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left">Veranstaltungsbeginn</td>
                <td><?php echo $training->date1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left">Folgetermine</td>
                <td><?php echo $training->text1;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left">Veranstaltungsende</td>
                <td><?php echo $training->date2;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left">Dauer</td>
                <td><?php echo $training->text2;?></td>
            </tr>
        </table>
        <table width="100%" class="standard">
            <tr>
              <td class="tcell-left"><?php echo $lang["TRAINING_PLACE"];?></td>
                <td><?php echo $training->text3;?></td>
            </tr>
        </table>
<?php
    break;
} ?>
&nbsp; <br />
<?php if(!empty($training->protocol1)) { ?>
<table width="100%" class="standard">
	<tr>
        <td class="tcell-left top"><?php echo $lang["TRAINING_DESCRIPTION_FOR"];?></td>
        <td><?php echo(nl2br($training->protocol1));?></td>
	</tr>
</table>
<?php } ?>

<?php if(!empty($training->protocol2)) { ?>
<table width="100%" class="standard">
	<tr>
        <td class="tcell-left top"><?php echo $lang["TRAINING_DESCRIPTION_GOAL"];?></td>
        <td><?php echo(nl2br($training->protocol2));?></td>
	</tr>
</table>
<?php } ?>

<?php if(!empty($training->protocol3)) { ?>
<table width="100%" class="standard">
	<tr>
        <td class="tcell-left top"><?php echo $lang["TRAINING_DESCRIPTION_DURATION"];?></td>
        <td><?php echo(nl2br($training->protocol3));?></td>
	</tr>
</table>
<?php } ?>

<?php if(!empty($training->protocol4)) { ?>
<table width="100%" class="standard">
	<tr>
        <td class="tcell-left top"><?php echo $lang["TRAINING_DESCRIPTION_NUM_MEMBERS"];?></td>
        <td><?php echo(nl2br($training->protocol4));?></td>
	</tr>
</table>
<?php } ?>
&nbsp; <br />
<table width="100%" class="standard-grey">
	<tr>
        <td class="tcell-left top"><?php echo $lang["TRAINING_DESCRIPTION"];?></td>
        <td>&nbsp;</td>
	</tr>
</table>
<table width="100%" class="standard-grey-paddingBottom">
	<tr>
        <td><?php echo(nl2br($training->protocol));?></td>
	</tr>
</table>
&nbsp; <br />
<table width="100%" class="standard">
    <tr>
      <td class="tcell-left"><?php echo $lang["TRAINING_REGISTRATION_END"];?></td>
        <td><?php echo $training->registration_end;?></td>
    </tr>
</table>
<div style="page-break-after:always;">&nbsp;</div>
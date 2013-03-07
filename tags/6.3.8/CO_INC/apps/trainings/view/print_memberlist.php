<table width="100%" class="title">
	<tr>
        <td class="tcell-left">Teilnehmerliste zu</td>
        <td><strong><?php echo($training->title);?></strong></td>
	</tr>
</table>
<?php 
switch($training->training_id) {
	case '1'; ?>
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
	case '2'; ?>
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
} ?>
&nbsp;<br />
&nbsp;
 <table width="100%" style="color:#E5E5E5;">
            <tr>
                <td style="text-align: right;" class="grey">Unterschrift</td>
            </tr>
        </table>
<?php 
foreach($member as $value) { ?>
     <table width="100%" style="margin: 0 0 0 -15pt; padding: 0pt 0pt 0pt 15pt; border-collapse: collapse;">
            <tr>
              <td style="width: 50%; padding: 6px 0 6px 0; border-bottom: 1px solid #666666;"><?php echo $value->name;?></td>
                <td>&nbsp;</td>
            </tr>
        </table>
    &nbsp;<br />
<?php } ?>

<div style="page-break-after:always;">&nbsp;</div>
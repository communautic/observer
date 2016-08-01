<!-- 5 Einzelcoaching -->
<table width="715" border="0" cellpadding="0" cellspacing="0" style="font-family: Arial; color: #666666;">
    <tr>
        <td width="236"  height="22" style="font-size: 11px;">&nbsp; &nbsp; &nbsp; Coaching</td>
        <td style="font-size: 13px;"><?php echo $training->date1;?></td>
    </tr>
    <tr>
        <td  height="22" style="font-size: 11px;">&nbsp; &nbsp; &nbsp; <?php echo $lang["TRAINING_TIME_START"];?></td>
        <td style="font-size: 13px;"><?php echo $training->time1;?></td>
    </tr>
    <tr>
        <td  height="22" style="font-size: 11px;">&nbsp; &nbsp; &nbsp; <?php echo $lang["TRAINING_TIME_END"];?></td>
        <td style="font-size: 13px;"><?php echo $training->time2;?></td>
    </tr>
    <tr>
        <td  height="22" style="font-size: 11px;">&nbsp; &nbsp; &nbsp; <?php echo $lang["TRAINING_PLACE"];?></td>
        <td style="font-size: 13px;"><?php echo $training->place1;?><?php echo $training->place1_ct;?></td>
    </tr>
</table>
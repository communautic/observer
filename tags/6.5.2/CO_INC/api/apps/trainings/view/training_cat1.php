<!-- 1 	Vortrag -->
<table width="715" border="0" cellpadding="0" cellspacing="0" class="greyText">
    <tr>
        <td width="236" height="22" class="text11">Vortrag</td>
        <td><?php echo $training->date1;?></td>
    </tr>
    <tr>
        <td height="22" class="text11"><?php echo $lang["TRAINING_TIME_START"];?></td>
        <td><?php echo $training->time1;?></td>
    </tr>
    <tr>
        <td height="22" class="text11"><?php echo $lang["TRAINING_TIME_END"];?></td>
        <td><?php echo $training->time2;?></td>
    </tr>
    <tr>
        <td height="22" class="text11"><?php echo $lang["TRAINING_PLACE"];?></td>
        <td><?php echo $training->place1;?><?php echo $training->place1_ct;?></td>
    </tr>
</table>
<p>&nbsp;</p>
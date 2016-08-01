<!-- 4 	e-training & Praesenzcoaching -->
<table width="715" border="0" cellpadding="0" cellspacing="0" class="greyText">
    <tr>
        <td width="236" height="22" class="text11">e-training</td>
        <td>https://webbased-academy.communautic.com</td>
    </tr>
    <tr>
        <td height="22" class="text11"><?php echo $lang["TRAINING_TIME_START"];?></td>
        <td><?php echo $training->date1;?></td>
    </tr>
    <tr>
        <td height="22" class="text11"><?php echo $lang["TRAINING_TIME_END"];?></td>
        <td><?php echo $training->date3;?></td>
    </tr>
</table>
<p>&nbsp;</p>
<table width="715" border="0" cellpadding="0" cellspacing="0" class="greyText">
    <tr>
        <td width="236" height="22" class="text11">Coaching</td>
        <td><?php echo($training->date2);?></td>
    </tr>
    <tr>
        <td height="22" class="text11"><?php echo $lang["TRAINING_TIME_START"];?></td>
        <td><?php echo($training->time3);?></td>
    </tr>
    <tr>
        <td height="22" class="text11"><?php echo $lang["TRAINING_TIME_END"];?></td>
        <td><?php echo($training->time4);?></td>
    </tr>
    <tr>
        <td height="22" class="text11"><?php echo $lang["TRAINING_PLACE"];?></td>
        <td><?php echo($training->place2);?><?php echo($training->place2_ct);?></td>
    </tr>
</table>
<p>&nbsp;</p>

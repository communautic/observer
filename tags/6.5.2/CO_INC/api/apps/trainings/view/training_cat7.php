<!-- 7 Veranstaltungsreihe -->
<table width="715" border="0" cellpadding="0" cellspacing="0" class="greyText">
    <tr>
        <td width="236" height="22" class="text11">Veranstaltungsbeginn</td>
        <td><?php echo($training->date1);?></td>
    </tr>
    <tr>
        <td width="236" height="22" class="text11">Folgetermine</td>
        <td><?php echo($training->text1);?></td>
    </tr>
     <tr>
        <td width="236" height="22" class="text11">Veranstaltungsende</td>
        <td><?php echo($training->date2);?></td>
    </tr>
    <tr>
        <td height="22" class="text11">Dauer</td>
        <td><?php echo($training->text2);?></td>
    </tr>
    <tr>
        <td height="22" class="text11"><?php echo $lang["TRAINING_PLACE"];?></td>
        <td><?php echo($training->text3);?></td>
    </tr>
</table>
<p>&nbsp;</p>

<!-- 7 Veranstaltungsreihe -->
<table width="715" border="0" cellpadding="0" cellspacing="0" style="font-family: Arial; color: #666666;">
    <tr>
        <td width="236"  height="22" style="font-size: 11px;">&nbsp; &nbsp; &nbsp; Veranstaltungsbeginn</td>
        <td style="font-size: 13px;"><?php echo $training->date1;?></td>
    </tr>
    <tr>
        <td width="236"  height="22" style="font-size: 11px;">&nbsp; &nbsp; &nbsp; Folgetermine</td>
        <td style="font-size: 13px;"><?php echo $training->text1;?></td>
    </tr>
    <tr>
        <td width="236"  height="22" style="font-size: 11px;">&nbsp; &nbsp; &nbsp; Veranstaltungsende</td>
        <td style="font-size: 13px;"><?php echo $training->date2;?></td>
    </tr>
    <tr>
        <td  height="22" style="font-size: 11px;">&nbsp; &nbsp; &nbsp; Dauer</td>
        <td style="font-size: 13px;"><?php echo $training->text2;?></td>
    </tr>
    <tr>
        <td  height="22" style="font-size: 11px;">&nbsp; &nbsp; &nbsp; <?php echo $lang["TRAINING_PLACE"];?></td>
        <td style="font-size: 13px;"><?php echo $training->text3;?></td>
    </tr>
</table>
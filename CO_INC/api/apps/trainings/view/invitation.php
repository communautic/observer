<table width="715" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td height="22" class="text11">Trainingsveranstaltung</td>
                    <td><b>„<?php echo $training->title;?>“</b></td>
                </tr>
            </table>
<br />
            
            
<table width="715" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="236" height="27" style="background-color: #e5e5e5;">&nbsp;</td>
                    <td  style="background-color: #e5e5e5;"><strong><?php echo $response;?></strong></td>
    </tr>
            </table>
            <br />
<table width="715" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td height="22" class="text11">Veranstaltungsdaten</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <table width="715" border="0" cellpadding="0" cellspacing="0" class="greyText">
                <tr>
                    <td height="22" class="text11">Trainingsanbieter</td>
                    <td><?php echo $training->company;?></td>
                </tr>
                <tr>
                    <td height="22" class="text11">TrainerIn</td>
                    <td><?php echo $training->team;?><?php echo $training->team_ct;?></td>
                </tr>
                <tr>
                    <td height="22" class="text11">Trainingsart</td>
                    <td><?php echo $training->training;?></td>
                </tr>
            </table><br />
<?php include('training_cat'.$training->training_id.'.php'); ?><br />
<table width="715" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="236" height="27" style="background-color: #e5e5e5;">&nbsp;</td>
        <td  style="background-color: #e5e5e5;"><strong>Vielen Dank für Ihre Rückmeldung!</strong></td>
    </tr>
</table>
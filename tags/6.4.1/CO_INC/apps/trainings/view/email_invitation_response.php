<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="color: #000; font-size: 12px; font-family: arial; margin: 0; padding: 0; background-color: #ffffff;">
<table width="715" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td style="font-size: 13px;"><br />
            <img src="<?php echo $email_header;?>" alt="Recheis Akademie" width="715" height="76" /><br />
            <br />
            <br />
            <table width="715" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial;">
                <tr>
                    <td width="236" height="22" style="font-size: 11px;">&nbsp; &nbsp; &nbsp; Trainingseranstaltung</td>
                    <td style="font-size: 13px;"><b>„<?php echo $training->title;?>“</b></td>
                </tr>
            </table>
            <br />
            <table width="715" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial; background-color: #e5e5e5;">
                <tr>
                    <td width="236" height="22" style="font-size: 11px;">&nbsp;</td>
                    <td style="font-size: 13px;"><b><?php echo $response;?></b></td>
                </tr>
            </table>
            <br />
            <table width="715" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial;">
                <tr>
                    <td width="236" height="22" style="font-size: 11px;">&nbsp; &nbsp; &nbsp; Veranstaltungsdaten</td>
                    <td style="font-size: 13px;">&nbsp;</td>
                </tr>
            </table>
            <table width="715" border="0" cellpadding="0" cellspacing="0" style="font-family: Arial; color: #666666;">
                <tr>
                    <td width="236" height="22" style="font-size: 11px;">&nbsp; &nbsp; &nbsp; Trainingsanbieter</td>
                    <td style="font-size: 13px;"><?php echo $training->company;?></td>
                </tr>
                <tr>
                    <td height="22" style="font-size: 11px;">&nbsp; &nbsp; &nbsp; TrainerIn</td>
                    <td style="font-size: 13px;"><?php echo $training->team;?><?php echo $training->team_ct;?></td>
                </tr>
                <tr>
                    <td height="22" style="font-size: 11px;">&nbsp; &nbsp; &nbsp; Trainingsart</td>
                    <td style="font-size: 13px;"><?php echo $training->training;?></td>
                </tr>
            </table>
            <?php echo $cat;?><br />
            <table width="715" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial; background-color: #e5e5e5;">
                <tr>
                    <td width="236" height="22" style="font-size: 11px;">&nbsp;</td>
                    <td style="font-size: 13px;"><b>Vielen Dank für Ihre Rückmeldung!</b></td>
                </tr>
            </table>
            <br />
            <br />
            <?php include(CO_PATH_TEMPLATES . 'trainings/email_footer.html');?>
            <br />
            <br /></td>
    </tr>
</table>
</body>
</html>
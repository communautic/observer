<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="color: #000; font-size: 12px; font-family: arial; margin: 0; padding: 0; background-color: #ffffff;">
<table width="715" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td><br /><img src="<?php echo $email_header;?>" alt="Recheis Akademie" width="715" height="76" /><br />
            <br />
            <br />
            <table width="715" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial; background-color: #e5e5e5;">
                <tr>
                    <td width="236" height="27" style="font-size: 11px;">&nbsp; &nbsp; &nbsp; Einladung zur Veranstaltung</td>
                    <td style="font-size: 13px;"><b>„<?php echo $training->title;?>“</b></td>
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
            <br />
            <table width="715" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial; background-color: #e5e5e5;">
                <tr>
                    <td width="236" height="27" style="font-size: 11px;">&nbsp; &nbsp; &nbsp; Veranstaltungsdaten</td>
                    <td style="font-size: 13px;">&nbsp;</td>
                </tr>
            </table>
            <?php echo $cat;?><br />
            <table width="715" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial; background-color: #e5e5e5;">
                <tr>
                    <td width="236" height="27" style="font-size: 11px;">&nbsp;</td>
                    <td style="font-size: 13px;"><b>Bitte bestätigen Sie Ihre Teilnahme oder Absage:</b></td>
                </tr>
            </table>
            <table width="715" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="236" height="22">&nbsp;</td>
                    <td><br />
<a href="<?php echo $email_accept_url;?>"><img src="<?php echo $email_button_accept;?>" alt="Ich nehme teil" width="130" height="26" border="0" /></a>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href="<?php echo $email_decline_url;?>"><img src="<?php echo $email_button_decline;?>" alt="Ich nehme nicht teil" width="130" height="26" border="0" /></a></td>
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
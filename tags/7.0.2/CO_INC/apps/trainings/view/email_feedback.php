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
                    <td width="236" height="27" style="font-size: 11px;">&nbsp; &nbsp; Feedback zur Veranstaltung</td>
                    <td style="font-size: 13px;"><b>„<?php echo $training->title;?>“</b></td>
                </tr>
            </table>
            <br />
            <table width="715" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial;">
                <tr>
                    <td width="236" height="22" style="font-size: 11px;">&nbsp;</td>
                    <td style="font-size: 13px;">Bitte geben Sie uns eine Rückmeldung zur Veranstaltung aus Ihrer Sicht:<br />
                        <br />
                        </td>
                </tr>
            </table>
            <table width="715" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="236" height="22" style="font-size: 11px;">&nbsp;</td>
                    <td style="font-size: 13px;">
                        <a href="<?php echo $email_feedback_url;?>"><img src="<?php echo $email_button_feedback;?>" alt="Feedback geben" width="130" height="26" border="0" /></a></td>
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
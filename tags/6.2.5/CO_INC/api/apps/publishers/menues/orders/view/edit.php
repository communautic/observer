<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang["APPLICATION_NAME"];?></title>
<link href="<?php echo CO_FILES;?>/img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<link href="<?php echo CO_FILES;?>/css/reset.css" rel="stylesheet" type="text/css" media="screen,projection" />
<link href="<?php echo CO_PATH_URL;?>/data/templates/css/orders.css" rel="stylesheet" type="text/css" media="screen,projection" />
<script src="<?php echo $protocol;?>ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo CO_FILES;?>/js/libraries/jquery.form.js"></script>
<script type="text/javascript">

$(document).ready(function() {
	
	$('#com-orderform').ajaxForm({
        success: function(data) {
			if (data == 1) {
				
				$('#com-orderform').html("Ihre Bestellung wurde erfolgreich aufgegeben. Sie können das Browser-Fenster jetzt schließen.");
			} else {
				$("#loginFailed").fadeIn();
			}
        }
    });

});
</script>
</head>
<body>
<div style="width: 880px; margin: 0 auto; ">
<div>
<div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="position: relative; background-image: url(<?php echo CO_PATH_URL;?>/data/templates/images/order_mb_header_bg.jpg);">
    <tr>
        <td width="380"><div style="color: #fff; margin-top: 70px; margin-left: 20px; height: 10px;"><?php if ($error == "") { echo($menue->item_date_from);?> bis <?php echo($menue->item_date_to); }?></div>
        <div style="margin-top: 20px; margin-left: 20px;"><?php echo $client->title;?>, <?php echo $users->getUserFullname($session->uid);?></div>
        </td>
    </tr>
</table>
<p>&nbsp;</p>
<?php 

if($error == "") {

$row1 = 0;
$row2 = 0;
$row3 = 0;
$row4 = 0;
$row5 = 0;
$row6 = 0;

switch($client->contract) {
	case 1:
		$row2 = 1;
	break;
	case 2:
		$row1 = 1;
		$row2 = 1;
	break;
	case 3:
		$row4 = 1;
	break;
	case 4:
		$row3 = 1;
		$row4 = 1;
	break;
	case 5:
		$row4 = 1;
		$row5 = 1;
	break;
	case 6:
		$row3 = 1;
		$row4 = 1;
		$row5 = 1;
	break;
	case 7:
		$row4 = 1;
		$row5 = 1;
		$row6 = 1;
	break;
	case 8:
		$row3 = 1;
		$row4 = 1;
		$row5 = 1;
		$row6 = 1;
	break;
}


?>
<form id="com-orderform" name="com_form" method="post" action="/?path=api/apps/publishers/menues/orders">
<input type="hidden" name="suborder" value="1" />
<input type="hidden" name="cid" value="<?php echo($session->cid);?>" />
<input type="hidden" name="oid" value="<?php echo($id);?>" />
<table border="0" cellspacing="0" cellpadding="0" class="menue-grid">
	<tr>
	  <th>MONTAG</th>
	  <th>DIENSTAG</th>
       <th>MITTWOCH</th>
       <th>DONNERSTAG</th>
       <th>FREITAG</th>
    </tr>
    <?php if($row1 == 1) { ?>
	<tr>
	    <td><?php echo nl2br($menue->mon_1);?></td>
	    <td><?php echo nl2br($menue->tue_1);?></td>
	    <td><?php echo nl2br($menue->wed_1);?></td>
	    <td><?php echo nl2br($menue->thu_1);?></td>
	    <td><?php echo nl2br($menue->fri_1);?></td>
	</tr>
    <?php }
	if($row2 == 1) { ?>
	<tr>
	    <td><?php echo nl2br($menue->mon_2);?><br /><input name="mon" type="text" size="3" maxlength="3" value="<?php echo($mon);?>" /></td>
	    <td><?php echo nl2br($menue->tue_2);?><br /><input name="tue" type="text" size="3" maxlength="3" value="<?php echo($tue);?>" /></td>
	    <td><?php echo nl2br($menue->wed_2);?><br /><input name="wed" type="text" size="3" maxlength="3" value="<?php echo($wed);?>" /></td>
	    <td><?php echo nl2br($menue->thu_2);?><br /><input name="thu" type="text" size="3" maxlength="3" value="<?php echo($thu);?>" /></td>
	    <td><?php echo nl2br($menue->fri_2);?><br /><input name="fri" type="text" size="3" maxlength="3" value="<?php echo($fri);?>" /></td>
	</tr>
    <?php }
	if($row3 == 1) { ?>
	<tr>
	    <td><?php echo nl2br($menue->mon_3);?></td>
	    <td><?php echo nl2br($menue->tue_3);?></td>
	    <td><?php echo nl2br($menue->wed_3);?></td>
	    <td><?php echo nl2br($menue->thu_3);?></td>
	    <td><?php echo nl2br($menue->fri_3);?></td>
	    </tr>
    <?php }
	if($row4 == 1) { ?>
	<tr>
	    <td><?php echo nl2br($menue->mon_4);?><br /><input name="mon" type="text" size="3" maxlength="3" value="<?php echo($mon);?>" /></td>
	    <td><?php echo nl2br($menue->tue_4);?><br /><input name="tue" type="text" size="3" maxlength="3" value="<?php echo($tue);?>" /></td>
	    <td><?php echo nl2br($menue->wed_4);?><br /><input name="wed" type="text" size="3" maxlength="3" value="<?php echo($wed);?>" /></td>
	    <td><?php echo nl2br($menue->thu_4);?><br /><input name="thu" type="text" size="3" maxlength="3" value="<?php echo($thu);?>" /></td>
	    <td><?php echo nl2br($menue->fri_4);?><br /><input name="fri" type="text" size="3" maxlength="3" value="<?php echo($fri);?>" /></td>
	</tr>
    <?php }
	if($row5 == 1) { ?>
	<tr>
	    <td><?php echo nl2br($menue->mon_5);?><br /><input name="mon_2" type="text" size="3" maxlength="3" value="<?php echo($mon_2);?>" /></td>
	    <td><?php echo nl2br($menue->tue_5);?><br /><input name="tue_2" type="text" size="3" maxlength="3" value="<?php echo($tue_2);?>" /></td>
	    <td><?php echo nl2br($menue->wed_5);?><br /><input name="wed_2" type="text" size="3" maxlength="3" value="<?php echo($wed_2);?>" /></td>
	    <td><?php echo nl2br($menue->thu_5);?><br /><input name="thu_2" type="text" size="3" maxlength="3" value="<?php echo($thu_2);?>" /></td>
	    <td><?php echo nl2br($menue->fri_5);?><br /><input name="fri_2" type="text" size="3" maxlength="3" value="<?php echo($fri_2);?>" /></td>
	    </tr>
	<?php }
	if($row6 == 1) { ?>
    <tr>
	    <td><?php echo nl2br($menue->mon_6);?><br /><input name="mon_3" type="text" size="3" maxlength="3" value="<?php echo($mon_3);?>" /></td>
	    <td><?php echo nl2br($menue->tue_6);?><br /><input name="tue_3" type="text" size="3" maxlength="3" value="<?php echo($tue_3);?>" /></td>
	    <td><?php echo nl2br($menue->wed_6);?><br /><input name="wed_3" type="text" size="3" maxlength="3" value="<?php echo($wed_3);?>" /></td>
	    <td><?php echo nl2br($menue->thu_6);?><br /><input name="thu_3" type="text" size="3" maxlength="3" value="<?php echo($thu_3);?>" /></td>
	    <td><?php echo nl2br($menue->fri_6);?><br /><input name="fri_3" type="text" size="3" maxlength="3" value="<?php echo($fri_3);?>" /></td>
	    </tr>
	<?php } ?>
    </table>
    <p>&nbsp;</p>
    <table border="0" cellspacing="0" cellpadding="0" class="menue-grid">
	<tr>
	    <td class="last">Anmerkung<br /><textarea name="mon_note" rows="2"></textarea></td>
	    <td class="last">Anmerkung<br /><textarea name="tue_note" rows="2"></textarea></td>
	    <td class="last">Anmerkung<br /><textarea name="wed_note" rows="2"></textarea></td>
	    <td class="last">Anmerkung<br /><textarea name="thu_note" rows="2"></textarea></td>
	    <td class="last">Anmerkung<br /><textarea name="fri_note" rows="2"></textarea></td>
    </tr>
</table>
    <p>&nbsp;</p>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>&nbsp;</td>
            <td align="right">&nbsp;<!--<span class="button"><a href="/?path=api/apps/publishers/menues/orders/login">abmelden</a></span>--><input type="submit" name="button" id="button" value="Bestellung" /></td>
        </tr>
    </table>
</form>
<?php } else {
	echo $error;
} ?>
</body>
</html>
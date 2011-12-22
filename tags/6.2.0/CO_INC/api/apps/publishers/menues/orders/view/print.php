<!DOCTYPE html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang["APPLICATION_NAME"];?></title>
<link href="<?php echo CO_FILES;?>/img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<link href="<?php echo CO_FILES;?>/css/reset.css" rel="stylesheet" type="text/css" media="screen,projection" />
<link href="<?php echo CO_PATH_URL;?>/data/templates/css/orders.css" rel="stylesheet" type="text/css" media="screen,projection" />
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
<table class="menue-grid">
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
	    <td><?php echo nl2br($menue->mon_2);?><br /><?php echo($mon);?></td>
	    <td><?php echo nl2br($menue->tue_2);?><br /><?php echo($tue);?></td>
	    <td><?php echo nl2br($menue->wed_2);?><br /><?php echo($wed);?></td>
	    <td><?php echo nl2br($menue->thu_2);?><br /><?php echo($thu);?></td>
	    <td><?php echo nl2br($menue->fri_2);?><br /><?php echo($fri);?></td>
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
	    <td><?php echo nl2br($menue->mon_4);?><br /><?php echo($mon);?></td>
	    <td><?php echo nl2br($menue->tue_4);?><br /><?php echo($tue);?></td>
	    <td><?php echo nl2br($menue->wed_4);?><br /><?php echo($wed);?></td>
	    <td><?php echo nl2br($menue->thu_4);?><br /><?php echo($thu);?></td>
	    <td><?php echo nl2br($menue->fri_4);?><br /><?php echo($fri);?></td>
	</tr>
    <?php }
	if($row5 == 1) { ?>
	<tr>
	    <td><?php echo nl2br($menue->mon_5);?><br /><?php echo($mon_2);?></td>
	    <td><?php echo nl2br($menue->tue_5);?><br /><?php echo($tue_2);?></td>
	    <td><?php echo nl2br($menue->wed_5);?><br /><?php echo($wed_2);?></td>
	    <td><?php echo nl2br($menue->thu_5);?><br /><?php echo($thu_2);?></td>
	    <td><?php echo nl2br($menue->fri_5);?><br /><?php echo($fri_2);?></td>
	    </tr>
	<?php }
	if($row6 == 1) { ?>
    <tr>
	    <td><?php echo nl2br($menue->mon_6);?><br /><?php echo($mon_3);?></td>
	    <td><?php echo nl2br($menue->tue_6);?><br /><?php echo($tue_3);?></td>
	    <td><?php echo nl2br($menue->wed_6);?><br /><?php echo($wed_3);?></td>
	    <td><?php echo nl2br($menue->thu_6);?><br /><?php echo($thu_3);?></td>
	    <td><?php echo nl2br($menue->fri_6);?><br /><?php echo($fri_3);?></td>
	    </tr>
	<?php } ?>
    </table>
    <p>&nbsp;</p>
    <table class="menue-grid">
	<tr>
	    <td class="last"><?php echo $mon_note;?></textarea></td>
	    <td class="last"><?php echo $tue_note;?></textarea></td>
	    <td class="last"><?php echo $wed_note;?></textarea></td>
	    <td class="last"><?php echo $thu_note;?></textarea></td>
	    <td class="last"><?php echo $fri_note;?></textarea></td>
    </tr>
</table>
    <p>&nbsp;</p>
</body>
</html>
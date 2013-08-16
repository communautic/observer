<?php
$top = 100;
$left = 235;
?>

<div style="position: absolute; width: <?php echo($proc["page_width"]-24);?>px; top: <?php echo $top-100; ?>px; left: 0px; height: 19px;  background-color: #e5e5e5; vertical-align: top; padding: 3px 0 0 24px;"><?php echo $proc["folder"];?></div>
<div style="position: absolute; width: <?php echo($proc["page_width"]);?>px; top: <?php echo $top-100; ?>px; left: 0px; height: 22px;  vertical-align: top; padding: 3px 0 0 0; text-align:center"><?php echo $proc["title"];?></div>
<div style="position: absolute; width: <?php echo($proc["page_width"]-24);?>px; top: <?php echo $top-100; ?>px; left: 0px; height: 22px;  vertical-align: top; padding: 3px 24px 0 0; text-align:right"><?php echo $date->formatDate("now","d.m.Y");?></div>

<?php 
$i = 1;
$ltop = $top+34;
// left
   
$top = $top-7;
//$left = 225;
?>
<!-- drawing area outer -->
<div style="position: absolute; top: <?php echo($top+18);?>px; left: <?php echo($left);?>px; width: <?php echo($proc["css_width"]);?>px; height:<?php echo($proc["css_height"]);?>px;"></div>
	<?php 
	foreach($notes as $note){ 
		if($note->toggle == 0) {
			$height = $note->h;
		} else {
			$height = 17;
		}
		$h = 90;
		$xadd = 10;
		$yadd = 27;
		$w = 140;
		$img = '/img/print/shapes/' . $note->shape . $note->color;
		if($note->shape == 3) {
			$h = 110;
			$xadd = 20;
			$yadd = 37;
			$w = 130;
		}
		if($note->shape == 5) {
			$xadd = 15;
			$w = 135;
		}
		//switch($note->shape) {
			//case 1: $bg_y = 0; break;
			//case 2: $bg_y = -110; break;
			//case 3: $bg_y = -430; $h = 110; break;
			//case 4: $bg_y = -330; break;
			//case 5: $bg_y = -220; break;
		//}
		/*switch($note->color) {
			case 1: $bg_x = 0; break;
			case 2: $bg_x = -180; break;
			case 3: $bg_x = -360; break;
			case 4: $bg_x = -540; break;
			case 5: $bg_x = -720; break;
		}*/
		if($note->shape >= 10) {
			switch($note->shape) {
			case 10: $img = '/img/print/arrows/1'; break;
			case 11: $img = '/img/print/arrows/2'; break;
			case 12: $img = '/img/print/arrows/3'; break;
			case 13: $img = '/img/print/arrows/4'; break;
			case 14: $img = '/img/print/arrows/5'; break;
			case 15: $img = '/img/print/arrows/6'; break;
			case 16: $img = '/img/print/arrows/7'; break;
			case 17: $img = '/img/print/arrows/8'; break;
			}
		}
		?>
    <div style="position:absolute; overflow:hidden; vertical-align: top; width: 166px; height: <?php echo $h;?>px; left: <?php echo $note->x;?>px; top: <?php echo $note->y+30;?>px; z-index: <?php echo $note->x;?>;"><img src="<?php echo CO_FILES . $img . '.png';?>" /></div>
        <div style="position:absolute; overflow:hidden; width: 150px; height: 60px; left: <?php echo $note->x+$xadd;?>px; top: <?php echo $note->y+$yadd;?>px; z-index: <?php echo $note->x+1;?>;"><div style="font-size: 11px; width: <?php echo $w; ?>px; height: 60px;"><table width="100%" height="60"><tr><td height="60" valign="middle" align="center"><?php echo($note->title);?></td></tr></table></div></div>
	</div>	
        
        	<?php
			 } ?>
<div style="position: absolute; width: <?php echo($proc["page_width"]-24);?>px; top: <?php echo $proc["css_height"]+150;?>px; left: 0px; height: 19px;  background-color: #e5e5e5; vertical-align: top; padding: 3px 0 0 24px;">&nbsp;</div>

<div style="position: absolute; width: <?php echo($proc["page_width"]-$left);?>px; top: <?php echo $proc["css_height"]+148;?>px; left: <?php echo($left-18);?>px; height: 19px; text-align:center;">&nbsp;</div>
<div style="position: absolute; width: <?php echo($proc["css_width"]+$left);?>px; top: <?php echo $proc["css_height"]+180;?>px; left: 0px; height: 19px; vertical-align: top; padding: 3px 0 0 24px;"><img src="<?php echo(CO_FILES);?>/img/print/<?php echo $GLOBALS["APPLICATION_LOGO_PRINT"];?>" width="135" height="9" /></div>
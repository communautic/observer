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
		/*if($note->shape == 3) {
			$h = 110;
			$xadd = 20;
			$yadd = 37;
			$w = 130;
		}
		if($note->shape == 5) {
			$xadd = 15;
			$w = 135;
		}*/
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
		
		if($note->shape >= 10 && $note->shape < 34) {
			switch($note->shape) {
			case 10: // right arrow
				$width = 40;
				$height = 0;
				if($note->width > 0) { 
					$width = $note->width;
				}
				$arrowwidth = $width-6;
				?>
                <div style="position: absolute; width: <?php echo $width;?>px; height: 1px; top: <?php echo $note->y+39;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
            	<div style="position:absolute; width: 6px; height: 10px; top: <?php echo $note->y+30+4;?>px; left: <?php echo $note->x+$arrowwidth;?>px; z-index: <?php echo $note->z;?>;"><img src="<?php echo CO_FILES.'/img/print/arrows/r.png';?>" /></div>
            <?php
			break;
			case 11: $img = '/img/print/arrows/2'; break;
			case 12:  // down arrow
				$width = 0;
				$height = 40;
				if($note->height > 0) { 
					$height = $note->height;
				}
				$arrowheight = $height-6;
				?>
                <div style="position: absolute; width: 1px; height: <?php echo $height;?>px; top: <?php echo $note->y+30;?>px; left: <?php echo $note->x+9;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
            	<div style="position:absolute; width: 10px; height: 6px; top: <?php echo $note->y+30+$arrowheight;?>px; left: <?php echo $note->x+5;?>px; z-index: <?php echo $note->z;?>;"><img src="<?php echo CO_FILES.'/img/print/arrows/d.png';?>" /></div>
        		
            <?php
			break;
			case 13: $img = '/img/print/arrows/4'; break;
			case 14: // left arrow
				$width = 40;
				$height = 0;
				if($note->width > 0) { 
					$width = $note->width;
				}
				$arrowwidth = $width-6;
				?>
                <div style="position: absolute; width: <?php echo $width;?>px; height: 1px; top: <?php echo $note->y+39;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
            	<div style="position:absolute; width: 6px; height: 10px; top: <?php echo $note->y+30+4;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>;"><img src="<?php echo CO_FILES.'/img/print/arrows/l.png';?>" /></div>
			
			<?php
			break;
			case 15: $img = '/img/print/arrows/6'; break;
			case 16: // up arrow
				$width = 0;
				$height = 40;
				if($note->height > 0) { 
					$height = $note->height;
				}
				$arrowheight = $height-6;
				?>
                <div style="position: absolute; width: 1px; height: <?php echo $height;?>px; top: <?php echo $note->y+30;?>px; left: <?php echo $note->x+9;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
            	<div style="position:absolute; width: 10px; height: 6px; top: <?php echo $note->y+30;?>px; left: <?php echo $note->x+5;?>px; z-index: <?php echo $note->z;?>;"><img src="<?php echo CO_FILES.'/img/print/arrows/u.png';?>" /></div>
			<?php
			break;
			case 17: $img = '/img/print/arrows/8'; break;
			case 18: // start line - bottom line - arrow right top
				$width = 192;
				$height = 40;
				if($note->width > 0) { 
					$width = $note->width;
				}
				if($note->height > 0) { 
					$height = $note->height;
				}
				$arrowwidth = $width-6;
				$arrowheight = $height-6;
				?>
                <div style="position: absolute; width: 1px; height: <?php echo $height;?>px; top: <?php echo $note->y+30;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                <div style="position: absolute; width: <?php echo $width-13;?>px; height: 1px; top: <?php echo $note->y+30+$height;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                <div style="position: absolute; width: 1px; height: <?php echo $height;?>px; top: <?php echo $note->y+30;?>px; left: <?php echo $note->x+$arrowwidth-8;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
            	<div style="position:absolute; width: 10px; height: 6px; top: <?php echo $note->y+30;?>px; left: <?php echo $note->x+$arrowwidth-13;?>px; z-index: <?php echo $note->z;?>;"><img src="<?php echo CO_FILES.'/img/print/arrows/u.png';?>" /></div>
                <?php
			break;
			case 19: // arrow top - bottom line - end line
				$width = 192;
				$height = 40;
				if($note->width > 0) { 
					$width = $note->width;
				}
				if($note->height > 0) { 
					$height = $note->height;
				}
				$arrowwidth = $width-18;
				$arrowheight = $height-6;
				?>
                <div style="position: absolute; width: 1px; height: <?php echo $height;?>px; top: <?php echo $note->y+30;?>px; left: <?php echo $note->x+10;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                <div style="position: absolute; width: <?php echo $width-13;?>px; height: 1px; top: <?php echo $note->y+30+$height;?>px; left: <?php echo $note->x+10;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                <div style="position: absolute; width: 1px; height: <?php echo $height;?>px; top: <?php echo $note->y+30;?>px; left: <?php echo $note->x+$arrowwidth+14;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
            	<div style="position:absolute; width: 10px; height: 6px; top: <?php echo $note->y+30;?>px; left: <?php echo $note->x+6;?>px; z-index: <?php echo $note->z;?>;"><img src="<?php echo CO_FILES.'/img/print/arrows/u.png';?>" /></div>
                <?php
			break;
			case 20: // start line - top line - arrow right bottom
				$width = 192;
				$height = 40;
				if($note->width > 0) { 
					$width = $note->width;
				}
				if($note->height > 0) { 
					$height = $note->height;
				}
				$arrowwidth = $width-6;
				$arrowheight = $height-6;
				?>
                <div style="position: absolute; width: 1px; height: <?php echo $height;?>px; top: <?php echo $note->y+30;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                <div style="position: absolute; width: <?php echo $width-13;?>px; height: 1px; top: <?php echo $note->y+30;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                <div style="position: absolute; width: 1px; height: <?php echo $height;?>px; top: <?php echo $note->y+30;?>px; left: <?php echo $note->x+$arrowwidth-8;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
            	<div style="position:absolute; width: 10px; height: 6px; top: <?php echo $note->y+30+$arrowheight;?>px; left: <?php echo $note->x+$arrowwidth-13;?>px; z-index: <?php echo $note->z;?>;"><img src="<?php echo CO_FILES.'/img/print/arrows/d.png';?>" /></div>
                <?php
			break;
			case 21: // arrow bottom - top line - end line
				$width = 192;
				$height = 40;
				if($note->width > 0) { 
					$width = $note->width;
				}
				if($note->height > 0) { 
					$height = $note->height;
				}
				$arrowwidth = $width-18;
				$arrowheight = $height-6;
				?>
                <div style="position: absolute; width: 1px; height: <?php echo $height;?>px; top: <?php echo $note->y+30;?>px; left: <?php echo $note->x+10;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                <div style="position: absolute; width: <?php echo $width-13;?>px; height: 1px; top: <?php echo $note->y+30;?>px; left: <?php echo $note->x+10;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                <div style="position: absolute; width: 1px; height: <?php echo $height;?>px; top: <?php echo $note->y+30;?>px; left: <?php echo $note->x+$arrowwidth+14;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
            	<div style="position:absolute; width: 10px; height: 6px; top: <?php echo $note->y+30+$arrowheight;?>px; left: <?php echo $note->x+6;?>px; z-index: <?php echo $note->z;?>;"><img src="<?php echo CO_FILES.'/img/print/arrows/d.png';?>" /></div>
                <?php
			break;
			case 22: // arrow top - left line - end line
				$width = 40;
				$height = 90;
				if($note->width > 0) { 
					$width = $note->width;
				}
				if($note->height > 0) { 
					$height = $note->height;
				}
				$arrowwidth = $width-6;
				$arrowheight = $height-10;
				?>
                <div style="position: absolute; width: 1px; height: <?php echo $height-10;?>px; top: <?php echo $note->y+39;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                <div style="position: absolute; width: <?php echo $width;?>px; height: 1px; top: <?php echo $note->y+39+$arrowheight;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                <div style="position: absolute; width: <?php echo $width;?>px; height: 1px; top: <?php echo $note->y+39;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
            	<div style="position:absolute; width: 6px; height: 10px; top: <?php echo $note->y+34;?>px; left: <?php echo $note->x+$arrowwidth;?>px; z-index: <?php echo $note->z;?>;"><img src="<?php echo CO_FILES.'/img/print/arrows/r.png';?>" /></div>
                <?php
			break;
			case 23: // top line - left line - right arrow
				$width = 40;
				$height = 90;
				if($note->width > 0) { 
					$width = $note->width;
				}
				if($note->height > 0) { 
					$height = $note->height;
				}
				$arrowwidth = $width-6;
				$arrowheight = $height-10;
				?>
                <div style="position: absolute; width: 1px; height: <?php echo $height-10;?>px; top: <?php echo $note->y+29;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                <div style="position: absolute; width: <?php echo $width;?>px; height: 1px; top: <?php echo $note->y+29+$arrowheight;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                <div style="position: absolute; width: <?php echo $width;?>px; height: 1px; top: <?php echo $note->y+29;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
            	<div style="position:absolute; width: 6px; height: 10px; top: <?php echo $note->y+24+$arrowheight;?>px; left: <?php echo $note->x+$arrowwidth;?>px; z-index: <?php echo $note->z;?>;"><img src="<?php echo CO_FILES.'/img/print/arrows/r.png';?>" /></div>
                <?php
			break;
			case 24: // top line - right line - arrow left
				$width = 40;
				$height = 90;
				if($note->width > 0) { 
					$width = $note->width;
				}
				if($note->height > 0) { 
					$height = $note->height;
				}
				$arrowwidth = $width-6;
				$arrowheight = $height-10;
				?>
                <div style="position: absolute; width: 1px; height: <?php echo $height-9;?>px; top: <?php echo $note->y+29;?>px; left: <?php echo $note->x+$width;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                <div style="position: absolute; width: <?php echo $width;?>px; height: 1px; top: <?php echo $note->y+29+$arrowheight;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                <div style="position: absolute; width: <?php echo $width;?>px; height: 1px; top: <?php echo $note->y+29;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
            	<div style="position:absolute; width: 6px; height: 10px; top: <?php echo $note->y+24+$arrowheight;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>;"><img src="<?php echo CO_FILES.'/img/print/arrows/l.png';?>" /></div>
                <?php
			break;
			case 25: //arrow left top line - right line - 
				$width = 40;
				$height = 90;
				if($note->width > 0) { 
					$width = $note->width;
				}
				if($note->height > 0) { 
					$height = $note->height;
				}
				$arrowwidth = $width-6;
				$arrowheight = $height-10;
				?>
                <div style="position: absolute; width: 1px; height: <?php echo $height-9;?>px; top: <?php echo $note->y+39;?>px; left: <?php echo $note->x+$width;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                <div style="position: absolute; width: <?php echo $width;?>px; height: 1px; top: <?php echo $note->y+39+$arrowheight;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                <div style="position: absolute; width: <?php echo $width;?>px; height: 1px; top: <?php echo $note->y+39;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
            	<div style="position:absolute; width: 6px; height: 10px; top: <?php echo $note->y+34;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>;"><img src="<?php echo CO_FILES.'/img/print/arrows/l.png';?>" /></div>
                <?php
			break;
			case 26: // top line - right line - arrow left
				$width = 40;
				$height = 50;
				if($note->width > 0) { 
					$width = $note->width;
				}
				if($note->height > 0) { 
					$height = $note->height;
				}
				$arrowwidth = $width-6;
				$arrowheight = $height-10;
				?>
                <div style="position: absolute; width: 1px; height: <?php echo $height-10;?>px; top: <?php echo $note->y+39;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                <!--<div style="position: absolute; width: <?php echo $width;?>px; height: 1px; top: <?php echo $note->y+39+$arrowheight;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>-->
                <div style="position: absolute; width: <?php echo $width;?>px; height: 1px; top: <?php echo $note->y+39;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
            	<div style="position:absolute; width: 6px; height: 10px; top: <?php echo $note->y+34;?>px; left: <?php echo $note->x+$arrowwidth;?>px; z-index: <?php echo $note->z;?>;"><img src="<?php echo CO_FILES.'/img/print/arrows/r.png';?>" /></div>
                <?php
                
			break;
			case 27: // top line - right line - arrow left
				$width = 40;
				$height = 50;
				if($note->width > 0) { 
					$width = $note->width;
				}
				if($note->height > 0) { 
					$height = $note->height;
				}
				$arrowwidth = $width-6;
				$arrowheight = $height-10;
				?>
                <div style="position: absolute; width: 1px; height: <?php echo $height-10;?>px; top: <?php echo $note->y+29;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                <div style="position: absolute; width: <?php echo $width;?>px; height: 1px; top: <?php echo $note->y+29+$arrowheight;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                
            	<div style="position:absolute; width: 6px; height: 10px; top: <?php echo $note->y+24+$arrowheight;?>px; left: <?php echo $note->x+$arrowwidth;?>px; z-index: <?php echo $note->z;?>;"><img src="<?php echo CO_FILES.'/img/print/arrows/r.png';?>" /></div>
                <?php
			break;
			case 28: // top line - left line - right arrow
				$width = 40;
				$height = 50;
				if($note->width > 0) { 
					$width = $note->width;
				}
				if($note->height > 0) { 
					$height = $note->height;
				}
				$arrowwidth = $width-6;
				$arrowheight = $height-10;
				?>
                <div style="position: absolute; width: 1px; height: <?php echo $height-9;?>px; top: <?php echo $note->y+29;?>px; left: <?php echo $note->x+$width;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                <div style="position: absolute; width: <?php echo $width;?>px; height: 1px; top: <?php echo $note->y+29+$arrowheight;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                <!--<div style="position: absolute; width: <?php echo $width;?>px; height: 1px; top: <?php echo $note->y+29;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>-->
            	<div style="position:absolute; width: 6px; height: 10px; top: <?php echo $note->y+24+$arrowheight;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>;"><img src="<?php echo CO_FILES.'/img/print/arrows/l.png';?>" /></div>
                <?php
			break;
			case 29: //arrow left top line - right line - 
				$width = 40;
				$height = 50;
				if($note->width > 0) { 
					$width = $note->width;
				}
				if($note->height > 0) { 
					$height = $note->height;
				}
				$arrowwidth = $width-6;
				$arrowheight = $height-10;
				?>
                <div style="position: absolute; width: 1px; height: <?php echo $height-9;?>px; top: <?php echo $note->y+39;?>px; left: <?php echo $note->x+$width;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                
                <div style="position: absolute; width: <?php echo $width;?>px; height: 1px; top: <?php echo $note->y+39;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
            	<div style="position:absolute; width: 6px; height: 10px; top: <?php echo $note->y+34;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>;"><img src="<?php echo CO_FILES.'/img/print/arrows/l.png';?>" /></div>
                <?php
			break;
			case 30: // start line - bottom line - arrow right top
				$width = 50;
				$height = 40;
				if($note->width > 0) { 
					$width = $note->width;
				}
				if($note->height > 0) { 
					$height = $note->height;
				}
				$arrowwidth = $width-6;
				$arrowheight = $height-6;
				?>

                <div style="position: absolute; width: <?php echo $width-13;?>px; height: 1px; top: <?php echo $note->y+30+$height;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                <div style="position: absolute; width: 1px; height: <?php echo $height;?>px; top: <?php echo $note->y+30;?>px; left: <?php echo $note->x+$arrowwidth-8;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
            	<div style="position:absolute; width: 10px; height: 6px; top: <?php echo $note->y+30;?>px; left: <?php echo $note->x+$arrowwidth-13;?>px; z-index: <?php echo $note->z;?>;"><img src="<?php echo CO_FILES.'/img/print/arrows/u.png';?>" /></div>
                <?php
			break;
			case 31: // arrow top - bottom line - end line
				$width = 50;
				$height = 40;
				if($note->width > 0) { 
					$width = $note->width;
				}
				if($note->height > 0) { 
					$height = $note->height;
				}
				$arrowwidth = $width-18;
				$arrowheight = $height-6;
				?>
                <div style="position: absolute; width: 1px; height: <?php echo $height;?>px; top: <?php echo $note->y+30;?>px; left: <?php echo $note->x+10;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                <div style="position: absolute; width: <?php echo $width-13;?>px; height: 1px; top: <?php echo $note->y+30+$height;?>px; left: <?php echo $note->x+10;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                
            	<div style="position:absolute; width: 10px; height: 6px; top: <?php echo $note->y+30;?>px; left: <?php echo $note->x+6;?>px; z-index: <?php echo $note->z;?>;"><img src="<?php echo CO_FILES.'/img/print/arrows/u.png';?>" /></div>
                <?php
			break;
			case 32: // start line - top line - arrow right bottom
				$width = 50;
				$height = 40;
				if($note->width > 0) { 
					$width = $note->width;
				}
				if($note->height > 0) { 
					$height = $note->height;
				}
				$arrowwidth = $width-6;
				$arrowheight = $height-6;
				?>
                
                <div style="position: absolute; width: <?php echo $width-13;?>px; height: 1px; top: <?php echo $note->y+30;?>px; left: <?php echo $note->x;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                <div style="position: absolute; width: 1px; height: <?php echo $height;?>px; top: <?php echo $note->y+30;?>px; left: <?php echo $note->x+$arrowwidth-8;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
            	<div style="position:absolute; width: 10px; height: 6px; top: <?php echo $note->y+30+$arrowheight;?>px; left: <?php echo $note->x+$arrowwidth-13;?>px; z-index: <?php echo $note->z;?>;"><img src="<?php echo CO_FILES.'/img/print/arrows/d.png';?>" /></div>
                <?php
			break;
			case 33: // arrow bottom - top line - end line
				$width = 50;
				$height = 40;
				if($note->width > 0) { 
					$width = $note->width;
				}
				if($note->height > 0) { 
					$height = $note->height;
				}
				$arrowwidth = $width-18;
				$arrowheight = $height-6;
				?>
                <div style="position: absolute; width: 1px; height: <?php echo $height;?>px; top: <?php echo $note->y+30;?>px; left: <?php echo $note->x+10;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                <div style="position: absolute; width: <?php echo $width-13;?>px; height: 1px; top: <?php echo $note->y+30;?>px; left: <?php echo $note->x+10;?>px; z-index: <?php echo $note->z;?>; background-color: #000;"></div>
                
            	<div style="position:absolute; width: 10px; height: 6px; top: <?php echo $note->y+30+$arrowheight;?>px; left: <?php echo $note->x+6;?>px; z-index: <?php echo $note->z;?>;"><img src="<?php echo CO_FILES.'/img/print/arrows/d.png';?>" /></div>
                <?php
			break;
			}
		} else if($note->shape == 34) { 
		// text shape
		?>
        <div style="position:absolute; left: <?php echo $note->x;?>px; top: <?php echo $note->y+$yadd;?>px; z-index: <?php echo $note->z;?>;"><div style="font-size: 11px; min-width: 40px; max-width: 120px; text-align: center;"><table><tr><td valign="middle" align="center" style="width: 40px; background-color: #fff; padding: 5px 7px 5px 7px"><?php echo($note->title);?></td></tr></table></div></div>
        
		<?php } else {
		// note shapes
		?>
    	<div style="position:absolute; overflow:hidden; vertical-align: top; width: 166px; height: <?php echo $h;?>px; left: <?php echo $note->x;?>px; top: <?php echo $note->y+30;?>px; z-index: <?php echo $note->z;?>;"><img src="<?php echo CO_FILES . $img . '.png';?>" /></div>
        <div style="position:absolute; overflow:hidden; width: 150px; height: 60px; left: <?php echo $note->x+$xadd;?>px; top: <?php echo $note->y+$yadd;?>px; z-index: <?php echo $note->z;?>;"><div style="font-size: 11px; width: <?php echo $w; ?>px; height: 60px;"><table width="100%" height="60"><tr><td height="60" valign="middle" align="center"><?php echo($note->title);?></td></tr></table></div></div>
        	<?php
		}
			 } ?>
<div style="position: absolute; width: <?php echo($proc["page_width"]-24);?>px; top: <?php echo $proc["css_height"]+150;?>px; left: 0px; height: 19px;  background-color: #e5e5e5; vertical-align: top; padding: 3px 0 0 24px;">&nbsp;</div>

<div style="position: absolute; width: <?php echo($proc["page_width"]-$left);?>px; top: <?php echo $proc["css_height"]+148;?>px; left: <?php echo($left-18);?>px; height: 19px; text-align:center;">&nbsp;</div>
<div style="position: absolute; width: <?php echo($proc["css_width"]+$left);?>px; top: <?php echo $proc["css_height"]+180;?>px; left: 0px; height: 19px; vertical-align: top; padding: 3px 0 0 24px;"><img src="<?php echo(CO_FILES);?>/img/print/<?php echo $GLOBALS["APPLICATION_LOGO_PRINT"];?>" width="135" height="9" /></div>
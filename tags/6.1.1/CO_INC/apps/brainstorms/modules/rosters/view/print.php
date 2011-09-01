<?php
$top = 100;
$left = 235;
?>

<div style="position: absolute; width: <?php echo($page_width-24);?>px; top: <?php echo $top-100; ?>px; left: 0px; height: 19px;  background-color: #e5e5e5; vertical-align: top; padding: 3px 0 0 24px;">&nbsp;</div>
<div style="position: absolute; width: <?php echo($page_width);?>px; top: <?php echo $top-100; ?>px; left: 0px; height: 22px;  vertical-align: top; padding: 3px 0 0 0; text-align:center"><?php echo $roster->title;?></div>
<div style="position: absolute; width: <?php echo($page_width-24);?>px; top: <?php echo $top-100; ?>px; left: 0px; height: 22px;  vertical-align: top; padding: 3px 24px 0 0; text-align:right"><?php echo $date->formatDate("now","d.m.Y");?></div>

<?php 
$i = 1;
$ltop = $top+34;
// left
   
$top = $top-7;
//$left = 225;
?>
			<?php 
			$l = 15;
			foreach($cols as $key => &$value){ 
	echo '<div style="position: absolute; top: 50px; left: ' . $l . 'px; height: ' . $colheight . 'px;  width: 150px; float: left;">';
	echo '<div>';
	$i = 0;
	foreach($cols[$key]["notes"] as $tkey => &$tvalue){ 
		$ms = '';
		if($i != 0 && $cols[$key]["notes"][$tkey]['ms'] == "1") {
			$ms = '<span class="icon-milestone"></span>';
		}
		echo '<div><span>'.$cols[$key]["notes"][$tkey]['title'].'</span>'.$ms .'</div>';
		$i++;
	}
	echo '</div></div>';
	$l+=150;
 } ?>
<div style="position: absolute; width: <?php echo($page_width-24);?>px; top: <?php echo $page_height-180;?>px; left: 0px; height: 19px;  background-color: #e5e5e5; vertical-align: top; padding: 3px 0 0 24px;">&nbsp;</div>

<div style="position: absolute; width: <?php echo($page_widt-$left);?>px; top: <?php echo $page_height-148;?>px; left: <?php echo($left-18);?>px; height: 19px; text-align:center;">&nbsp;</div>
<div style="position: absolute; width: <?php echo($page_width+$left);?>px; top: <?php echo $page_height-150;?>px; left: 0px; height: 19px; vertical-align: top; padding: 3px 0 0 24px;"><img src="<?php echo(CO_FILES);?>/img/print/poweredbyco.png" width="135" height="9" /></div>
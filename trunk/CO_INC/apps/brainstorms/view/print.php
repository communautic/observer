<?php
$top = 100;
$left = 235;
?>

<div style="position: absolute; width: <?php echo($brainstorm["page_width"]-24);?>px; top: <?php echo $top-100; ?>px; left: 0px; height: 19px;  background-color: #e5e5e5; vertical-align: top; padding: 3px 0 0 24px;"><?php echo $brainstorm["folder"];?></div>
<div style="position: absolute; width: <?php echo($brainstorm["page_width"]);?>px; top: <?php echo $top-100; ?>px; left: 0px; height: 22px;  vertical-align: top; padding: 3px 0 0 0; text-align:center"><?php echo $brainstorm["title"];?></div>
<div style="position: absolute; width: <?php echo($brainstorm["page_width"]-24);?>px; top: <?php echo $top-100; ?>px; left: 0px; height: 22px;  vertical-align: top; padding: 3px 24px 0 0; text-align:right"><?php echo $date->formatDate("now","d.m.Y");?></div>

<?php 
$i = 1;
$ltop = $top+34;
// left
   
$top = $top-7;
//$left = 225;
?>
<!-- drawing area outer -->
<div style="position: absolute; top: <?php echo($top+18);?>px; left: <?php echo($left);?>px; width: <?php echo($brainstorm["css_width"]);?>px; height:<?php echo($brainstorm["css_height"]);?>px;"></div>
			<?php 
			foreach($notes as $note){ 
			?>
    <div style="font-size: 11px; position:absolute; overflow:hidden; background-color: #FFF082; vertical-align: top; border: 1px solid #77713D; width: <?php echo $note->w;?>px; height: <?php echo $note->h;?>px; left: <?php echo $note->x;?>px; top: <?php echo $note->y;?>px; z-index: <?php echo $note->x;?>;">
        <div style="padding: 2px 9px 0 9px; color: #fff; background-color: #77713D; height: 16px; vertical-align: top; overflow: hidden; "><?php echo($note->title);?></div>
        <div style="padding: 1px 9px 0 9px;"><?php echo(nl2br($note->text));?></div>
	</div>	
        
        	<?php
			 } ?>
<div style="position: absolute; width: <?php echo($brainstorm["page_width"]-24);?>px; top: <?php echo $brainstorm["css_height"]+150;?>px; left: 0px; height: 19px;  background-color: #e5e5e5; vertical-align: top; padding: 3px 0 0 24px;">izuizu</div>

<div style="position: absolute; width: <?php echo($brainstorm["page_width"]-$left);?>px; top: <?php echo $brainstorm["css_height"]+148;?>px; left: <?php echo($left-18);?>px; height: 19px; text-align:center;">
aa</div>
<div style="position: absolute; width: <?php echo($brainstorm["css_width"]+$left);?>px; top: <?php echo $brainstorm["css_height"]+180;?>px; left: 0px; height: 19px; vertical-align: top; padding: 3px 0 0 24px;"><img src="<?php echo(CO_FILES);?>/img/print/poweredbyco.png" width="135" height="9" /></div>
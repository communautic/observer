<table width="100%" class="title grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["PATIENT_SKETCH_TITLE"];?></td>
        <td><strong><?php echo($sketch->title);?></strong></td>
	</tr>
</table>
<p>&nbsp;</p>
<?php //if ($printcanvas == 1) { ?>
<div style="height: 400px; width: 1161px; position: relative;">
<?php 
				switch($sketch->type) {
					case 0:
						$canvasDrawBG = '';
					break;
					case 1:
						if(defined('CO_PATIENT_SKETCHES_CUSTOM')) { 
							$canvasDrawBG = '<img src="' . CO_PATH_DATA . '/sketch_custom.png" style="height: 400px;" />';
						} else { 
							$canvasDrawBG = '<img src="' . CO_FILES . '/img/body.png" style="height: 400px;" />';
						}
					break;
					case 2:
						$canvasDrawBG = '<img src="' . CO_PATH_URL . '/data/sketches/' . $sketch->type_image . '" style="height: 400px;" />';
					break;
				} ?>
                <div style="position: absolute;"><?php echo $canvasDrawBG;?></div>
                <?php

    $i = 1; 
	$j = $sketch->diagnoses;
	foreach($diagnose as $value) { 
		$curcol = ($i-1) % 10;
		?>
        <?php if(!empty($value->canvas)) { ?>
	   <div style="position: absolute;"><img src="data:image/png;base64,<?php echo $value->canvas;?>" /></div>
       <?php }?>
	   <div style="position: absolute; z-index: 10<?php echo $i;?>; top: <?php echo $value->y;?>px; left: <?php echo $value->x;?>px;" class="loadCanvas circle circle<?php echo $curcol;?>"><div><?php echo $i;?></div></div>
	<?php 
	$i++;
	$j--;
} ?>
</div>
<p>&nbsp;</p>
<?php 
//}
$i = 1;
	foreach($diagnose as $value) { 
	$curcol = ($i-1) % 10; ?>
    <table width="100%" class="standard">
        <tr>
        <td class="top" style="width: 30px;"><div class="circle circle<?php echo $curcol;?>"><div><?php echo $i;?></div></div></td>
          <td><?php echo $value->text;?>&nbsp;</td>
        </tr>
    </table>
<?php 
	$i++;
} ?>
<p>&nbsp;</p>
<div style="page-break-after:always;">&nbsp;</div>
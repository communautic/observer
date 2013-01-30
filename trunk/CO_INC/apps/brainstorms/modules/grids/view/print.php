<?php
$top = 50;
$left = 150;
$varheight = 100;
?>
<div style="position: absolute; width: <?php echo($page_width-24);?>px; top: <?php echo $top-$top; ?>px; left: 0px; height: 19px;  background-color: #e5e5e5; vertical-align: top; padding: 3px 0 0 24px;"><?php echo $grid->title;?></div>
<div style="position: absolute; width: <?php echo($page_width);?>px; top: <?php echo $top-$top; ?>px; left: 0px; height: 22px;  vertical-align: top; padding: 3px 0 0 0; text-align:center"><?php //echo $grid->title;?></div>
<div style="position: absolute; width: <?php echo($page_width-24);?>px; top: <?php echo $top-$top; ?>px; left: 0px; height: 22px;  vertical-align: top; padding: 3px 24px 0 0; text-align:right"><?php echo $date->formatDate("now","d.m.Y");;?></div>

<div style="position: absolute; left: 24px; top: 30px; width: <?php echo($page_width-24);?>px;">
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["BRAINSTORM_GRID_TIME"];?></td>
		<td class="smalltext"><?php echo $grid->grid_days;?> <?php echo $lang["GLOBAL_DAYS"];?></td>
    </tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["BRAINSTORM_GRID_OWNER"];?></td>
		<td class="smalltext"><?php echo($grid->owner_print);?> <?php echo($grid->owner_ct);?></td>
    </tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["BRAINSTORM_GRID_MANAGEMENT"];?></td>
		<td class="smalltext"><?php echo($grid->management_print);?> <?php echo($grid->management_ct);?></td>
    </tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["BRAINSTORM_GRID_TEAM"];?></td>
		<td class="smalltext"><?php echo($grid->team);?> <?php echo($grid->team_ct);?></td>
    </tr>
</table>
</div>


<div style="position: absolute; width: 95px; top: <?php echo(64+$varheight);?>px; left: 0px; padding-left: 24px; height: 38px; vertical-align: top; font-size: 10px;"><?php echo $lang["BRAINSTORM_GRID_COLUMN_NEW"];?></div>
<div style="position: absolute; width: <?php echo($page_width);?>px; top: <?php echo(96+$varheight);?>px; left: 0px; padding-left: 24px; height: 46px; color: #666666; background-color: #E5E5E5; vertical-align: top; font-size: 10px;"><?php echo $lang["BRAINSTORM_GRID_TITLE_MAIN"];?></div>
<div style="position: absolute; width: 100px; top: <?php echo(146+$varheight);?>px; left: 0px; padding-left: 24px; height: 20px; color: #666666; vertical-align: top; font-size: 10px;">Teilprozesse</div>
<?php
$left = 130;
// days
$daysadd = $varheight+145+$grid->max_items*20; ?>
<div style="position: absolute; width: 100px; top: <?php echo $daysadd+5;?>px; left: 0px; padding-left: 24px; height: 20px; color: #666666; vertical-align: top; font-size: 10px;">Dauer / Tage</div>
<?php
foreach($cols as $key => &$value){ 
$top = 58;

$bg = '';
switch($cols[$key]['status']) {
	case 'planned':
		$bg = '<img src="<?php echo CO_FILES;?>/img/print/grid_planned.png" width="183" height="46" />';
	break;
	case 'progress':
		$bg = '<img src="<?php echo CO_FILES;?>/img/print/grid_progress.png" width="183" height="46" />';
	break;
	case 'finished':
		$bg = '<img src="<?php echo CO_FILES;?>/img/print/grid_finished.png" width="183" height="46" />';
	break;
	default:
		$bg = '';
}
?>
<div style="position: absolute; left: <?php echo($left);?>px; top: <?php echo(96+$varheight);?>px; width: 183px; font-size: 10px; height: 46px;"><?php echo $bg;?></div>
	<div style="position: absolute; left: <?php echo($left+20);?>px; top: <?php echo(111+$varheight);?>px; width: 183px; font-size: 12px; height: 46px; color: #000; z-index: 1;"><?php echo $cols[$key]['titletext']; ?></div>
	<?php
	$ntop = $varheight+142;
	foreach($cols[$key]["notes"] as $tkey => &$tvalue){ 
		$img = "";
		if ($cols[$key]["notes"][$tkey]['status'] == 1) {
			$img = '<img src="' . CO_FILES . '/img/print/done.png" width="10" height="10" vspace="4" hspace="4" />';
		}
	?>
<div style="position: absolute; left: <?php echo($left);?>px; top: <?php echo $ntop;?>px; height: 19px; width: 19px; border-right: 1px solid #666; border-bottom: 1px solid #666; border-left: 1px solid #666; font-size: 10px; overflow: hidden;"><?php echo $img;?></div>
		<div style="position: absolute; left: <?php echo($left+20);?>px; top: <?php echo $ntop;?>px; height: 15px; width: 156px; border-right: 1px solid #666; border-bottom: 1px solid #666; border-left: 1px solid #666; font-size: 10px; line-height: 19px; padding-top: 4px; overflow: hidden; padding-left: 5px;"><?php echo $cols[$key]["notes"][$tkey]['title'];?></div>
	<?php 
		$ntop = $ntop+20;
	} ?>
<div style="position: absolute; left: <?php echo($left);?>px; top: <?php echo $daysadd;?>px; height: 14px; width: 156px; border: 1px solid #666; background-color: #E5E5E5; font-size: 10px; line-height: 19px; padding-top: 4px; padding-left: 25px;"><?php echo $cols[$key]['coldays'];?> Tage</div>
<?php
	$left = $left+203;
	$img = "";
	if($cols[$key]['status'] == "finished" ) {
		$img = '<img src="' . CO_FILES . '/img/print/grid_stagegate_done.png" width="13" height="13" />';
	}
?>
<div style="position: absolute; left: <?php echo($left-20);?>px; top: <?php echo($varheight+$top);?>px; width: 100px; font-size: 10px; color: #666;">GATE</div>
<div style="position: absolute; left: <?php echo($left-20);?>px; top: <?php echo($varheight+$top+16);?>px; width: 100px; font-size: 10px; z-index: 1;"><?php echo $cols[$key]['stagegatetext'];?></div>
<div style="position: absolute; left: <?php echo($left-16);?>px; top: <?php echo($varheight+$top+113);?>px; width: 20px;"><?php echo $img;?></div>
    <?php
 } ?>
<div style="position: absolute; width: <?php echo($page_width-24);?>px; top: <?php echo $page_height-50;?>px; left: 0px; height: 19px;  background-color: #e5e5e5; vertical-align: top; padding: 3px 0 0 24px;"><?php echo $lang["BRAINSTORM_GRID_TITLE"];?></div>
<div style="position: absolute; width: <?php echo($page_width-235);?>px; top: <?php echo $page_height-52;?>px; left: 200px; height: 19px; text-align:center;"><table border="0" cellspacing="0" cellpadding="0" class="timeline-legend">
    <tr>
        <td class="psp_barchart_color_planned"><span><?php echo $lang["GLOBAL_STATUS_PLANNED"];?></span></td>
        <td width="15"></td>
        <td class="barchart_color_inprogress"><span><?php echo $lang["GLOBAL_STATUS_INPROGRESS"];?></span></td>
         <td width="15"></td>
        <td class="barchart_color_finished"><span><?php echo $lang["GLOBAL_STATUS_FINISHED"];?></span></td>
    </tr>
</table></div>
<div style="position: absolute; width: <?php echo($page_width+$left);?>px; top: <?php echo $page_height-20;?>px; left: 0px; height: 19px; vertical-align: top; padding: 3px 0 0 24px;"><img src="<?php echo(CO_FILES);?>/img/print/<?php echo $GLOBALS["APPLICATION_LOGO_PRINT"];?>" width="135" height="9" /></div>
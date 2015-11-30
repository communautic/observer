<?php
$top = 50;
$left = 150;
$varheight = 100;
?>
<div style="position: absolute; width: <?php echo($page_width-24);?>px; top: <?php echo $top-$top; ?>px; left: 0px; height: 19px;  background-color: #e5e5e5; vertical-align: top; padding: 3px 0 0 24px;"><?php echo $pspgrid->title;?></div>
<div style="position: absolute; width: <?php echo($page_width);?>px; top: <?php echo $top-$top; ?>px; left: 0px; height: 22px;  vertical-align: top; padding: 3px 0 0 0; text-align:center"><?php //echo $pspgrid->title;?></div>
<div style="position: absolute; width: <?php echo($page_width-24);?>px; top: <?php echo $top-$top; ?>px; left: 0px; height: 22px;  vertical-align: top; padding: 3px 24px 0 0; text-align:right"><?php echo $date->formatDate("now","d.m.Y");;?></div>

<div style="position: absolute; left: 24px; top: 30px; width: <?php echo($page_width-24);?>px;">
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PROC_PSPGRID_TIME"];?></td>
		<td class="smalltext"><?php echo $pspgrid->tdays;?> <?php echo $lang["GLOBAL_DAYS"];?></td>
    </tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PROC_PSPGRID_COSTS"];?></td>
		<td class="smalltext"><?php echo $pspgrid->setting_currency;?> <?php echo $pspgrid->tcosts;?></td>
    </tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PROC_PSPGRID_OWNER"];?></td>
		<td class="smalltext"><?php echo($pspgrid->owner_print);?> <?php echo($pspgrid->owner_ct);?></td>
    </tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PROC_PSPGRID_MANAGEMENT"];?></td>
		<td class="smalltext"><?php echo($pspgrid->management_print);?> <?php echo($pspgrid->management_ct);?></td>
    </tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PROC_PSPGRID_TEAM"];?></td>
		<td class="smalltext"><?php echo($pspgrid->team_print);?> <?php echo($pspgrid->team_ct);?></td>
    </tr>
</table>
</div>
<?php
$ptop = $top+150;
$pleft = $left;
$countPhases = 1;
?>

<div style="position: absolute; width: <?php echo($page_width);?>px; top: <?php echo($ptop);?>px; left: 0px; padding-left: 24px; padding-top: 6px; height: 67px; color: #666666; background-color: #E5E5E5; vertical-align: top; font-size: 10px;"><?php echo $lang["PROC_PSPGRID_PHASES"];?></div>
<div style="position: absolute; width: 100px; top: <?php echo $ptop+94;?>px; left: 0px; padding-left: 24px; height: 58px; color: #666666; vertical-align: top; font-size: 10px;"><?php echo $lang['PROC_PSPGRID_NOTES'];?></div>
<div style="position: absolute; top: <?php echo $ptop-11;?>px; left: <?php echo $pleft+90;?>px; height: 10px; width: 1px; background: #666;"></div>
<?php
foreach($cols as $key => &$value){ 

$bg = 'psp_barchart_color_planned';
		switch($cols[$key]['status']) {
			case 'planned':
				$bg = 'psp_barchart_color_planned';
			break;
			case 'progress':
				$bg = 'barchart_color_inprogress';
			break;
			case 'finished':
				$bg = 'barchart_color_finished';
			break;
		}
?>
    <div style="position: absolute; z-index: 1; top: <?php echo $ptop;?>px; left: <?php echo($pleft);?>px; border: 1px solid #666; width: 178px; height: 71px; font-size: 11px; font-weight: bold; text-align:center; vertical-align: top; background-color: #fff;"></div>
        <div style="position: absolute; z-index: 2; top: <?php echo $ptop+2;?>px; left: <?php echo($pleft+2);?>px; width: 159px; height: 32px; font-size: 11px; font-weight: bold; padding: 3px 9px 0 9px; overflow: hidden;" class="<?php echo($bg);?>"><?php echo($countPhases . ". " .$cols[$key]['titletext']);?></div><div style="position: absolute; z-index: 3; top: <?php echo $ptop+36;?>px; left: <?php echo($pleft+2);?>px; width: 177px;" class="<?php echo($bg);?>_line"></div>
        <div style="position: absolute; z-index: 2; top: <?php echo $ptop+38;?>px; left: <?php echo($pleft+2);?>px; width: 159px; height: 14px; font-size: 11px; vertical-align: top; padding: 3px 9px 0 9px; overflow: hidden;" class="<?php echo($bg);?>_light"></div>
        <div class="<?php echo($bg);?>_light" style="z-index: 3; position: absolute; top: <?php echo $ptop+55;?>px; left: <?php echo($pleft+2);?>px; width: 79px; height: 11px; font-size: 11px; vertical-align: top; padding: 1px 0 4px 9px;"><?php echo($cols[$key]['days'] . ' ' . $lang['PROC_PSPGRID_DAYS']);?></div>
        <div class="<?php echo($bg);?>_light" style="z-index: 2; position: absolute; top: <?php echo $ptop+55;?>px; left: <?php echo($pleft+90);?>px; width: 80px; height: 11px; font-size: 11px; vertical-align: top; padding: 1px 9px 4px 0; text-align: right;"><?php echo($pspgrid->setting_currency.' ' . $cols[$key]['costs']);?></div>
            <?php if($countPhases > 1) { ?>
				<div style="position: absolute; top: <?php echo $ptop-11;?>px; left: <?php echo $pleft-100;?>px; height: 10px; width: 190px; border-top: 1px solid #666; border-right: 1px solid #666;"></div>
			<?php } ?>
            
	<?php
	$ttop = $ptop+88;
	
	foreach($cols[$key]["notes"] as $tkey => &$tvalue){ 
		$bg = 'psp_barchart_color_planned';
		switch($cols[$key]["notes"][$tkey]['status']) {
			case '0':
				$bg = 'psp_barchart_color_planned';
			break;
			case '1':
				$bg = 'barchart_color_inprogress';
			break;
			case '2':
				$bg = 'barchart_color_finished';
			break;
		}
	?>
    <div style="position: absolute; z-index: 1; top: <?php echo $ttop;?>px; left: <?php echo($pleft+10);?>px; border: 1px solid #666; width: 168px; height: 71px;"></div>
            <div style="position: absolute; z-index: 2; top: <?php echo $ttop+2;?>px; left: <?php echo($pleft+12);?>px; width: 149px; height: 31px; font-size: 11px; font-weight: bold; padding: 3px 9px 0 9px; overflow: hidden;" class="<?php echo($bg);?>"><?php echo($cols[$key]["notes"][$tkey]['title']);?></div><div style="position: absolute; z-index: 3; top: <?php echo $ttop+36;?>px; left: <?php echo($pleft+12);?>px; width: 167px;" class="<?php echo($bg);?>_line"></div>
			
            
	<?php if($cols[$key]["notes"][$tkey]['milestone'] == 1) { // MS ?>
        <div style="position: absolute; z-index: 2; top: <?php echo $ttop+38;?>px; left: <?php echo($pleft+12);?>px; width: 149px; height: 14px; font-size: 11px; vertical-align: top; padding: 3px 9px 0 9px; overflow: hidden;" class="<?php echo($bg);?>_light">&nbsp;</div>
        <div class="<?php echo($bg);?>_light" style="z-index: 3; position: absolute; top: <?php echo $ttop+51;?>px; left: <?php echo($pleft+12);?>px; width: 74px; height: 16px; vertical-align: top; padding: 0 0 4px 9px;"><img src="<?php echo(CO_FILES);?>/img/print/milestone_large.png" width="16" height="16" /></div>
        <div style="z-index: 2; position: absolute; top: <?php echo $ttop+55;?>px; left: <?php echo($pleft+95);?>px; width: 75px; height: 11px; font-size: 11px; vertical-align: top; padding: 1px 9px 4px 0; text-align: right;" class="<?php echo($bg);?>_light">&nbsp;</div>
    <?php } else { //AP ?>
    	<div style="position: absolute; z-index: 2; top: <?php echo $ttop+38;?>px; left: <?php echo($pleft+12);?>px; width: 149px; height: 14px; font-size: 11px; vertical-align: top; padding: 3px 9px 0 9px; overflow: hidden;" class="<?php echo($bg);?>_light"><?php echo($cols[$key]["notes"][$tkey]['teamprint']);?></div>
    	<div class="<?php echo($bg);?>_light" style="z-index: 3; position: absolute; top: <?php echo $ttop+55;?>px; left: <?php echo($pleft+12);?>px; width: 74px; height: 11px; font-size: 11px; vertical-align: top; padding: 1px 0 4px 9px;"><?php echo($cols[$key]["notes"][$tkey]['days'] . ' ' . $lang['PROC_PSPGRID_DAYS']);?></div>
         <div style="z-index: 2; position: absolute; top: <?php echo $ttop+55;?>px; left: <?php echo($pleft+95);?>px; width: 75px; height: 11px; font-size: 11px; vertical-align: top; padding: 1px 9px 4px 0; text-align: right;" class="<?php echo($bg);?>_light"><?php echo($pspgrid->setting_currency.' ' . $cols[$key]["notes"][$tkey]['itemcosts']);?></div>
    <?php } ?>
    <div style="position: absolute; top: <?php echo $ttop-51;?>px; left: <?php echo($pleft);?>px; height: 88px; width: 9px; border-bottom: 1px solid #666; border-left: 1px solid #666;"></div>
	<?php 
		$ttop += 88;
	}
	$pleft += 190;
    $countPhases++;
 } ?>
<div style="position: absolute; width: <?php echo($page_width-24);?>px; top: <?php echo $page_height-50;?>px; left: 0px; height: 19px;  background-color: #e5e5e5; vertical-align: top; padding: 3px 0 0 24px;"><?php echo $lang["PROC_PSPGRID_TITLE"];?></div>
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
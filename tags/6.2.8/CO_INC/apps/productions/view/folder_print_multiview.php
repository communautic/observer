<?php
$top = 100;
$left = 235;
?>

<div style="position: absolute; width: <?php echo($folder->page_width-24);?>px; top: <?php echo $top-100; ?>px; left: 0px; height: 19px;  background-color: #e5e5e5; vertical-align: top; padding: 3px 0 0 24px;"><?php echo $folder->title;?></div>
<div style="position: absolute; width: <?php echo($folder->page_width-24);?>px; top: <?php echo $top-100; ?>px; left: 0px; height: 22px;  vertical-align: top; padding: 3px 24px 0 0; text-align:right"><?php echo $date->formatDate("now","d.m.Y");;?></div>


<div style="position: absolute; width: 163px; top: <?php echo $top; ?>px; left: 0px; padding: 1px 0 0 24px; height: 15px; vertical-align: top; font-size: 10px; line-height: 16px;"><?php echo $lang['PRODUCTION_TIMELINE_ACTION'];?></div>
<div style="position: absolute; width: 28px; top: <?php echo $top; ?>px; left: 189px; text-align: right;  padding: 1px 10px 0 0;  height: 15px;  vertical-align: top; font-size: 10px; line-height: 16px;"><?php echo $lang['PRODUCTION_TIMELINE_TIME'];?></div>

<?php 
$i = 1;
$ltop = $top+16;
// left
foreach($productions as $production){ ?>
<div style="position: absolute; width: 177px; top: <?php echo $ltop; ?>px; left: 0px; padding: 1px 0 0 10px; height: 15px; background-color: #b2b2b2; vertical-align: top; font-size: 12px; line-height: 16px; overflow: hidden;"><?php echo $production->title;?></div>

<div style="position: absolute; width: 28px; top: <?php echo $ltop; ?>px; left: 189px; text-align: right;  padding: 1px 10px 0 0;  height: 15px; background-color: #b2b2b2; vertical-align: top; font-size: 12px; line-height: 16px;"><?php echo $production->days;?></div>

<div style="position: absolute; width: 120px; top: <?php echo $ltop+18; ?>px; left: 0px; padding: 1px 0 0 10px; height: 15px; vertical-align: top; font-size: 10px; line-height: 16px; overflow: hidden;"><?php echo($production->startdate);?>-<?php echo($production->enddate);?></div>
<div style="position: absolute; width: 100px; top: <?php echo $ltop+18; ?>px; left: 120px; text-align: right;  padding: 1px 10px 0 0;  height: 15px; vertical-align: top; font-size: 10px; line-height: 16px; overflow: hidden;"><?php echo($production->name);?></div>
   
<?php
$ltop = $ltop+36;
}
	$day = $folder->startdate;
	$today = $date->formatDate("now","Y-m-d");
	//loop through all days and generate date row
	if($folder->days < 20) {
		//$folder->days"] = 20;
	}
	$dleft = $left;
	for ($i = 0; $i <= $folder->days; $i++) {
		$yo = $this->model->barchartCalendar($day,$i);
		$week = "";
		$month = "";
		$now = "";
		$bg = "#b2b2b2";
		if($yo["week"] != "") { ?>
			<div style="position: absolute; top: <?php echo $top-30;?>px; left: <?php echo $dleft;?>px; width: 45px; color: #000; font-size: 10px;">KW <?php echo $yo["week"];?></div>
		<?php }
		if($yo["month"] != "") { ?>
			<div style="position: absolute; top: <?php echo $top-50;?>px; left: <?php echo $dleft;?>px; width: 45px; color: #000; font-size: 10px;"><?php echo  $yo["month"];?></div>
		<?php } ?>
        <div style="position: absolute; top: <?php echo $top; ?>px; left: <?php echo $dleft; ?>px; background-color: <?php echo($bg);?>; width: <?php echo($folder->td_width);?>px; height: 13px; font-size: 10px; color: <?php echo($yo["color"]);?>; text-align:center; vertical-align: top;"><?php echo $now . $month . $yo["number"];?></div>
        <?php
		$day = $date->addDays($day,1);
		$dleft += $folder->td_width;
	}
	?>


<?php
$top = $top-7;
//$left = 225;
?>
<!-- drawing area outer -->
<div style="position: absolute; top: <?php echo($top+18);?>px; left: <?php echo($left);?>px; background-image:url(<?php echo($folder->bg_image);?>); background-position: <?php echo($folder->bg_image_shift);?>px 0px; width: <?php echo($folder->css_width);?>px; height:<?php echo($folder->css_height);?>px;"></div>

<!-- production loop -->
                <?php foreach($productions as $production){ 
				if($production->kickoff_only) { ?>
					<div style="z-index: 2; position: absolute; top: <?php echo($production->css_top+$top+15);?>px; left: <?php echo($production->css_left+$left+$production->kickoff_space);?>px; height: 16px; width: 16px;"><img src="<?php echo CO_FILES;?>/img/kickoff.png" width="16" height="16" alt="" /></div>
				<?php } else {
				?>
                
                <div class="<?php echo($production->status);?>" style="z-index: 2; position: absolute; top: <?php echo($production->css_top+$top+15);?>px; left: <?php echo($production->css_left+$left);?>px; height: 20px; width: <?php echo($production->css_width);?>px;"><?php echo($production->realisation["real"]);?>%</div>
                
                <?php 
				}
				} ?>

            
<div style="position: absolute; width: <?php echo($folder->page_width-24);?>px; top: <?php echo $folder->css_height+150;?>px; left: 0px; height: 19px;  background-color: #e5e5e5; vertical-align: top; padding: 3px 0 0 24px;"><?php echo $lang["PRODUCTION_TIMELINE_PRODUCTION_PLAN"];?></div>

<div style="position: absolute; width: <?php echo($folder->page_width-$left);?>px; top: <?php echo $folder->css_height+148;?>px; left: <?php echo($left-18);?>px; height: 19px; text-align:center;"><table border="0" cellspacing="0" cellpadding="0" class="timeline-legend">
    <tr>
        <td><span><img src="<?php echo CO_FILES;?>/img/kickoff.png" width="12" height="12" alt="" /> Kick Off</span></td>
        <td width="15"></td>
        <td class="barchart_color_planned"><span><?php echo $lang["PRODUCTION_TIMELINE_STATUS_PLANED"];?></span></td>
        <td width="15"></td>
        <td class="barchart_color_inprogress"><span><?php echo $lang["PRODUCTION_TIMELINE_STATUS_INPROGRESS"];?></span></td>
         <td width="15"></td>
        <td class="barchart_color_finished"><span><?php echo $lang["PRODUCTION_TIMELINE_STATUS_FINISHED"];?></span></td>
         <td width="15"></td>
        <td class="barchart_color_not_finished"><span><?php echo $lang["PRODUCTION_TIMELINE_STATUS_NOT_FINISHED"];?></span></td>
         <td width="15"></td>
        <td class="barchart_color_overdue"><span><?php echo $lang["PRODUCTION_TIMELINE_STATUS_OVERDUE"];?></span></td>
    </tr>
</table></div>
<div style="position: absolute; width: <?php echo($folder->css_width+$left);?>px; top: <?php echo $folder->css_height+180;?>px; left: 0px; height: 19px; vertical-align: top; padding: 3px 0 0 24px;"><img src="<?php echo(CO_FILES);?>/img/print/poweredbyco.png" width="135" height="9" /></div>
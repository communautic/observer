<?php
$top = 50;
$left = 150;
?>
<div style="position: absolute; width: <?php echo($page_width-24);?>px; top: <?php echo $top-$top; ?>px; left: 0px; height: 19px;  background-color: #e5e5e5; vertical-align: top; padding: 3px 0 0 24px;"><?php echo $grid->title;?></div>
<div style="position: absolute; width: <?php echo($page_width);?>px; top: <?php echo $top-$top; ?>px; left: 0px; height: 22px;  vertical-align: top; padding: 3px 0 0 0; text-align:center"><?php echo $grid->title;?></div>
<div style="position: absolute; width: <?php echo($page_width-24);?>px; top: <?php echo $top-$top; ?>px; left: 0px; height: 22px;  vertical-align: top; padding: 3px 24px 0 0; text-align:right"><?php echo $date->formatDate("now","d.m.Y");;?></div>

<?php

foreach($cols as $key => &$value){ 
	echo '<div>';
	echo '<div class="brainstorms-col-title ' . $cols[$key]['status'] . '">';
	echo '<div class="itemTitle">'.$cols[$key]['titletext'].'</div>';
	echo '</div>';

	echo '<div style="height: ' . $listheight . 'px;">';
	foreach($cols[$key]["notes"] as $tkey => &$tvalue){ 
		$checked = "";
		if ($cols[$key]["notes"][$tkey]['status'] == 1) {
			$checked = ' checked="checked"';
		}
		//echo '<div class="statusItem"><input name="" type="checkbox" value="'.$cols[$key]["notes"][$tkey]['note_id'].'" class="cbx jNiceHidden ' . $checkbox . '" ' . $checked . '/></div>';
		echo '<div class="itemTitle">'.$cols[$key]["notes"][$tkey]['title'].'</div>';
	}
	echo '<span class="newNoteItem newNote"></span>';
	echo '</div>';
	
	echo '<div class="brainstorms-col-footer-stagegate">';
		
	$stagegatestatus = "";
	if($cols[$key]['status'] == "finished" ) {
		$stagegatestatus = "active";
	}
	//echo '<div class="brainstorms-stagegate   ' . $stagegatestatus . '"></div>';

	echo '<div class="brainstorms-col-stagegate">';

			echo '<div class="itemTitle">'.$cols[$key]['stagegatetext'].'</div>';

		echo '</div>';
		//echo '<div class="brainstorms-col-footer-days">';
		//echo '<div><input class="colDays" name="" type="text" value="'.$cols[$key]['coldays'].'" size="3" maxlength="3" style="margin" /></div>';
		//echo '</div>';
		
	echo '</div>';
	
	
 } ?>

<div style="position: absolute; width: <?php echo($page_width-24);?>px; top: <?php echo $page_height-50;?>px; left: 0px; height: 19px;  background-color: #e5e5e5; vertical-align: top; padding: 3px 0 0 24px;"><?php echo $lang["BRAINSTORM_GRID_COLUMN_NEW"];?></div>
<div style="position: absolute; width: <?php echo($page_width-235);?>px; top: <?php echo $page_height-52;?>px; left: <?php echo($left+50);?>px; height: 19px; text-align:center;"><table border="0" cellspacing="0" cellpadding="0" class="timeline-legend">
    <tr>
        <td><span><img src="<?php echo(CO_FILES);?>/img/print/gantt_milestone.png" width="12" height="12" /> Meilenstein</span></td>
        <td width="15"></td>
        <td class="psp_barchart_color_planned"><span><?php echo $lang["BRAINSTORM_GRID_STATUS_PLANED"];?></span></td>
        <td width="15"></td>
        <td class="barchart_color_inprogress"><span><?php echo $lang["BRAINSTORM_GRID_STATUS_INPROGRESS"];?></span></td>
         <td width="15"></td>
        <td class="barchart_color_finished"><span><?php echo $lang["BRAINSTORM_GRID_STATUS_FINISHED"];?></span></td>
    </tr>
</table></div>
<div style="position: absolute; width: <?php echo($page_width+$left);?>px; top: <?php echo $page_height-20;?>px; left: 0px; height: 19px; vertical-align: top; padding: 3px 0 0 24px;"><img src="<?php echo(CO_FILES);?>/img/print/poweredbyco.png" width="135" height="9" /></div>
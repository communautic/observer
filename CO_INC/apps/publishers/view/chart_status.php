<div style="position: relative; float: left; width: 150px; margin: -26px 9px 0 9px">
	<div style="position: relative; height: 23px; background-color:#c3c3c3; padding: 3px 0 0 8px"><?php echo($chart["title"]);?></div>
    <div><img src="/data/charts/<?php echo($chart["img_name"]);?>?t=<?php echo(time());?>" alt="<?php echo($chart["title"]);?>" width="150" height="90" title="<?php echo($chart["title"]);?>"/></div>
</div>
<div style="position: relative; float: left; width: 150px; margin: -26px 9px 0 9px">
	<div style="position: relative; height: 23px; padding: 3px 0 0 8px"></div>
    <div style="margin-top: 5px;">
    	<table border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td style="padding: 2px 0 0 0"><span class="barchart_color_planned" style="display: block; width: 30px; height: 18px; padding: 1px 4px; text-align: right; margin-right: 3px;"><?php echo($chart["planned"]);?>%</span></td>
        <td>&nbsp;</td>
        <td><?php echo $lang["PUBLISHER_STATUS_PLANNED_TEXT"];?></td>
    </tr>
    <tr>
        <td style="padding: 2px 0 0 0"><span class="barchart_color_inprogress" style="display: block; height: 18px; padding: 0 4px; text-align: right; margin-right: 3px;"><?php echo($chart["inprogress"]);?>%</span></td>
        <td>&nbsp;</td>
        <td><?php echo $lang["PUBLISHER_STATUS_INPROGRESS_TEXT"];?></td>
    </tr>
    <tr>
        <td style="padding: 2px 0 0 0"><span class="barchart_color_finished" style="display: block; height: 18px; padding: 0 4px; text-align: right; margin-right: 3px;"><?php echo($chart["finished"]);?>%</span></td>
        <td>&nbsp;</td>
        <td><?php echo $lang["PUBLISHER_STATUS_FINISHED_TEXT"];?></td>
    </tr>
    <tr>
        <td style="padding: 2px 0 0 0"><span class="barchart_color_not_finished" style="display: block; height: 18px; padding: 0 4px; text-align: right; margin-right: 3px;"><?php echo($chart["stopped"]);?>%</span></td>
        <td>&nbsp;</td>
        <td><?php echo $lang["PUBLISHER_STATUS_STOPPED_TEXT"];?></td>
    </tr>
</table>
    </div>
</div>
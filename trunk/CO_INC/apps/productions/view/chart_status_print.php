<table width="98%" class="chart smalltext">
        <tr>
        <td class="fourCols-three greybg">&nbsp;</td><td class="greybg"><?php echo($chart["title"]);?></td><td class="greybg">&nbsp;</td>
		<td class="greybg">&nbsp;</td>
    </tr>
    <tr>
       <td class="fourCols-three">&nbsp;</td><td><img src="<?php echo(CO_PATH_BASE);?>/data/charts/<?php echo($chart["img_name"]);?>" alt="<?php echo($chart["title"]);?>" width="150" height="90" title="<?php echo($chart["title"]);?>"/></td>
      <td>
        <table class="smalltext" style="margin-top: 15pt">
    <tr>
        <td class="barchart_color_planned"><span style="padding: 1px 4px; text-align: right; margin-right: 3px;"><?php echo($chart["planned"]);?>%</span></td>
        <td>&nbsp;</td>
        <td><?php echo $lang["PRODUCTION_STATUS_PLANNED_TEXT"];?></td>
    </tr>
    <tr>
        <td class="barchart_color_inprogress"><span style="padding: 0 4px; text-align: right; margin-right: 3px;"><?php echo($chart["inprogress"]);?>%</span></td>
        <td>&nbsp;</td>
        <td><?php echo $lang["PRODUCTION_STATUS_INPROGRESS_TEXT"];?></td>
    </tr>
    <tr>
        <td class="barchart_color_finished"><span style="padding: 0 4px; text-align: right; margin-right: 3px;"><?php echo($chart["finished"]);?>%</span></td>
        <td>&nbsp;</td>
        <td><?php echo $lang["PRODUCTION_STATUS_FINISHED_TEXT"];?></td>
    </tr>
    <tr>
        <td class="barchart_color_not_finished"><span style="padding: 0 4px; text-align: right; margin-right: 3px;"><?php echo($chart["stopped"]);?>%</span></td>
        <td>&nbsp;</td>
        <td><?php echo $lang["PRODUCTION_STATUS_STOPPED_TEXT"];?></td>
    </tr>
</table></td>
    </tr>
</table>

    	
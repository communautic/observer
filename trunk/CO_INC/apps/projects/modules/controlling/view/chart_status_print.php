<table border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td rowspan="2" valign="top"><?php echo($chart["title"]);?><br />
<img src="<?php echo(CO_PATH_BASE);?>/data/charts/<?php echo($chart["img_name"]);?>" alt="<?php echo($chart["title"]);?>" width="150" height="90" title="<?php echo($chart["title"]);?>"/><br />
</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
      <td valign="top"><table border="0" cellspacing="0" cellpadding="0" class="smalltext">
        <tr>
          <td><span class="barchart_color_planned" style="padding: 1px 4px; text-align: right; margin-right: 3px;"><?php echo($chart["planned"]);?>%</span></td>
          <td>&nbsp;</td>
          <td><?php echo $lang["PROJECT_STATUS_PLANNED_TEXT"];?></td>
        </tr>
        <tr>
          <td><span class="barchart_color_inprogress" style="padding: 0 4px; text-align: right; margin-right: 3px;"><?php echo($chart["inprogress"]);?>%</span></td>
          <td>&nbsp;</td>
          <td><?php echo $lang["PROJECT_STATUS_INPROGRESS_TEXT"];?></td>
        </tr>
        <tr>
          <td><span class="barchart_color_finished" style="padding: 0 4px; text-align: right; margin-right: 3px;"><?php echo($chart["finished"]);?>%</span></td>
          <td>&nbsp;</td>
          <td><?php echo $lang["PROJECT_STATUS_FINISHED_TEXT"];?></td>
        </tr>
      </table></td>
    </tr>
</table>
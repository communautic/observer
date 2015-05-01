<div id="task_<?php echo $value->id;?>" class="phaseouter">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive projectlink" style="margin-bottom: 0px;">
  <tr>
		<td class="tcell-left-phases-tasks text11">&nbsp;</td>
    	<td class="tcell-right-nopadding">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="25" style="padding-top: 4px;"><span class="cbx">&nbsp;</span></td>
      <td width="20"><span class="icon-projectlink"></span></td>
      <td class="text11" style="padding-top: 0px;"><div class="text13 bold"><span class="co-link externalLoadThreeLevels" rel="<?php echo $value->link;?>">Projektlink: <?php echo $value->text;?></span></div></td>
      <?php if($phase->canedit) { ?><td width="25"><a class="binItem" rel="<?php echo $value->id;?>"><span class="icon-delete"></span></a></td><?php } ?>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="12"></td>
      <td class="tcell-left text11"><span><span><?php echo $lang["PROJECT_PHASE_TASK_START"];?></span></span></td>
      <td class="tcell-right"><?php echo $value->startdate;?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="tcell-left text11"><span><span><?php echo $lang["PROJECT_PHASE_TASK_END"];?></span></span></td>
      <td class="tcell-right"><?php echo $value->enddate;?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="tcell-left text11"><span><span><?php echo $lang["PROJECT_MANAGEMENT"];?></span></span></td>
      <td class="tcell-right"><div class="itemlist-field task_team_list"><?php echo($value->team);?></div></td>
    </tr>
    </table>
     <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="12">&nbsp;</td>
      <td class="tcell-left text11"><span><span><?php echo $lang["GLOBAL_STATUS"];?></span></span></td>
      <td class="tcell-right"><?php echo $value->status_text;?> <?php echo $value->status_text_time;?> <?php echo $value->status_date;?></td>
    </tr>
  </table>
  		</td>
	</tr>
</table>
</div>
<div id="task_<?php echo $value->id;?>" class="phaseouter">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive" style="margin-bottom: 0px;">
  <tr>
		<td class="tcell-left-phases-tasks text11">&nbsp;</td>
    	<td class="tcell-right-nopadding">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="20" style="padding-top: 4px;"><input name="task[<?php echo $value->id;?>]" type="checkbox" value="<?php echo $value->id;?>" class="cbx jNiceHidden <?php if(!$phase->canedit) { ?>noperm<?php } ?>" <?php echo $checked ;?> /></td>
      <td class="text11" style="padding-top: 0px;"><?php if($phase->canedit) { ?><input name="task_text[<?php echo $value->id;?>]" type="text" class="bg" value="<?php echo $value->text;?>" maxlength="100" /><?php } else { ?><div class="text13 bold" style="margin-left: 7px;"><?php echo $value->text;?></div><?php } ?><input name="task_id[<?php echo $value->id;?>]" type="hidden" value="<?php echo $value->id;?>"><input name="task_cat[<?php echo $value->id;?>]" type="hidden" value="<?php echo $value->cat;?>"></td>
      <?php if($phase->canedit) { ?><td width="30"><a class="binItem" rel="<?php echo $value->id;?>"><span class="icon-delete"></span></a></td><?php } ?>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="12"></td>
      <td class="tcell-left text11"><span class="<?php if($phase->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["PROJECT_PHASE_TASK_START"];?></span></span></td>
      <td class="tcell-right"><?php if($phase->canedit) { ?><input name="task_startdate[<?php echo $value->id;?>]" type="text" class="input-date datepicker task_start" value="<?php echo $value->startdate;?>" readonly="readonly" /><input name="task_movedate_start[<?php echo $value->id;?>]" type="hidden" value="<?php echo $value->startdate;?>" /><?php } else { ?><?php echo $value->startdate;?><?php } ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="tcell-left text11"><span class="<?php if($phase->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["PROJECT_PHASE_TASK_END"];?></span></span></td>
      <td class="tcell-right"><?php if($phase->canedit) { ?><input name="task_enddate[<?php echo $value->id;?>]" type="text" class="input-date datepicker task_end" value="<?php echo $value->enddate;?>" readonly="readonly" /><input name="task_movedate[<?php echo $value->id;?>]" type="hidden" value="<?php echo $value->enddate;?>" /><?php } else { ?><?php echo $value->enddate;?><?php } ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="tcell-left text11"><span class="<?php if($phase->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="task_team_<?php echo $value->id;?>" append="1"><span><?php echo $lang["PROJECT_PHASE_TASK_TEAM"];?></span></span></td>
      <td class="tcell-right"><div id="task_team_<?php echo $value->id;?>" class="itemlist-field task_team_list"><?php echo($value->team);?></div><div id="task_team_<?php echo $value->id;?>_ct" class="itemlist-field task_team_list_ct"><a field="task_team_<?php echo $value->id;?>_ct" class="ct-content"><?php echo($value->team_ct);?></a></div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="tcell-left text11"><span class="<?php if($phase->canedit) { ?>content-nav showDialog<?php } ?>" request="getTasksDialog" field="dependent<?php echo $value->id;?>" sql="<?php echo $value->id;?>" append="1"><span><?php echo $lang["PROJECT_PHASE_TASK_DEPENDENT"];?></span></span></td>
      <td class="tcell-right"><input id="dependent<?php echo $value->id;?>" name="task_dependent[<?php echo $value->id;?>]" type="hidden" value="<?php echo $value->dependent;?>"><span id="dependent<?php echo $value->id;?>-text"><span class="dependentTask" rel="dependent<?php echo $value->id;?>"><?php if($phase->canedit) { ?><a field="dependent<?php echo $value->id;?>" uid="<?php echo $value->id;?>" class="showItemContext" href="projects_phases"><?php } ?><?php echo $value->dependent_title;?><?php if($phase->canedit) { ?></a><?php } ?></span></span></td>
    </tr>
    </table>
     <table width="100%" border="0" cellpadding="0" cellspacing="0" id="donedate_<?php echo $value->id;?>" style="<?php echo $donedate_field;?>">
    <tr>
      <td width="12">&nbsp;</td>
      <td class="tcell-left text11"><span class="<?php if($phase->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["GLOBAL_STATUS_FINISHED"];?></span></span></td>
      <td class="tcell-right"><?php if($phase->canedit) { ?><input name="task_donedate[<?php echo $value->id;?>]" type="text" class="input-date datepicker task_donedate" value="<?php echo $donedate;?>" readonly="readonly" /><?php } else { ?><?php echo $donedate;?><?php } ?></td>
    </tr>
  </table>
  		</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($phase->canedit) { ?>selectTextarea<?php } ?>"><span>&nbsp;</span></span></td>
    <td class="tcell-right"><?php if($phase->canedit) { ?><textarea name="task_protocol[<?php echo $value->id;?>]" class="elastic"><?php echo(strip_tags($value->protocol));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($value->protocol)));?><?php } ?></td>
  </tr>
</table>
</div>
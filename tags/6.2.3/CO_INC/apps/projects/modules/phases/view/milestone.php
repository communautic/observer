<div id="task_<?php echo $value->id;?>" class="phaseouter">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive" style="margin-bottom: 0px;">
  <tr>
		<td class="tcell-left-phases-tasks text11">&nbsp;</td>
    	<td class="tcell-right">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="25" style="padding-top: 4px;"><input name="task[<?php echo $value->id;?>]" type="checkbox" value="<?php echo $value->id;?>" class="cbx jNiceHidden" <?php echo $checked ;?> /><input name="task_cat[<?php echo $value->id;?>]" type="hidden" value="<?php echo $value->cat;?>"></td>
      <td width="20"><span class="icon-milestone"></span></td>
      <td class="text11" style="padding-top: 0px;"><?php if($phase->canedit) { ?><input name="task_text[<?php echo $value->id;?>]" type="text" class="bg" value="<?php echo $value->text;?>" maxlength="100" /><?php } else { ?><div class="text13 bold" style="margin-left: 7px;"><?php echo $value->text;?></div><?php } ?><input name="task_id[<?php echo $value->id;?>]" type="hidden" value="<?php echo $value->id;?>"></td>
      <?php if($phase->canedit) { ?><td width="30"><a class="binItem" rel="<?php echo $value->id;?>"><span class="icon-delete"></span></a></td><?php } ?>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="12"></td>
      <td class="tcell-left text11"><span class="<?php if($phase->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["PROJECT_PHASE_MILESTONE_DATE"];?></span></span></td>
      <td class="tcell-right"><?php if($phase->canedit) { ?><input name="task_startdate[<?php echo $value->id;?>]" type="text" class="input-date datepicker task_start" value="<?php echo $value->startdate;?>" />
      <input name="task_enddate[<?php echo $value->id;?>]" type="hidden" value="" /><?php } else { ?><?php echo $value->startdate;?><?php } ?>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="tcell-left text11"><span class="<?php if($phase->canedit) { ?>content-nav showDialog<?php } ?>" request="getTasksDialog" field="dependent<?php echo $value->id;?>" sql="<?php echo $value->id;?>" append="1"><span><?php echo $lang["PROJECT_PHASE_TASK_DEPENDENT"];?></span></span></td>
      <td class="tcell-right"><input id="dependent<?php echo $value->id;?>" name="task_dependent[<?php echo $value->id;?>]" type="hidden" value="<?php echo $value->dependent;?>"><span id="dependent<?php echo $value->id;?>-text"><?php echo $value->dependent_title;?></span></td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" id="donedate_<?php echo $value->id;?>" style="<?php echo $donedate_field;?>">
    <tr>
      <td width="12">&nbsp;</td>
      <td class="tcell-left text11"><span class="<?php if($phase->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["PROJECT_PHASE_TASK_STATUS_FINISHED"];?></span></span></td>
      <td class="tcell-right"><?php if($phase->canedit) { ?><input name="task_donedate[<?php echo $value->id;?>]" type="text" class="input-date datepicker task_donedate" value="<?php echo $donedate;?>" /><?php } else { ?><?php echo $donedate;?><?php } ?></td>
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
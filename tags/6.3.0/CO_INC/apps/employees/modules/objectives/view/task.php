<div id="task_<?php echo $value->id;?>" class="objectiveouter">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive" style="margin-bottom: 0px;">
  <tr>
		<td class="tcell-left-phases-tasks text11">&nbsp;</td>
    	<td class="tcell-right-nopadding">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="20" style="padding-top: 4px;"><input name="task[<?php echo $value->id;?>]" type="checkbox" value="<?php echo $value->id;?>" class="cbx jNiceHidden <?php if(!$objective->canedit) { ?>noperm<?php } ?>" <?php echo $checked ;?> /></td>
      <td class="text11" style="padding-top: 0px;"><?php if($objective->canedit) { ?>
          <span class="text11" style="padding-top: 0px;"><input name="task_title[<?php echo $value->id;?>]" type="text" class="bg" value="<?php echo $value->title;?>" maxlength="100" /></span>
          <?php } else { ?><div class="text13 bold" style="margin-left: 7px;"><?php echo $value->title;?></div><?php } ?><input name="task_id[<?php echo $value->id;?>]" type="hidden" value="<?php echo $value->id;?>"><input class="task_sort" name="task_sort[<?php echo $value->id;?>]" type="hidden" value="<?php echo $value->sort;?>"></td>
      <?php if($objective->canedit) { ?><td width="30"><a class="binItem" rel="<?php echo $value->id;?>"><span class="icon-delete"></span></a></td><?php } ?>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="12"></td>
      <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["EMPLOYEE_OBJECTIVE_TASKS_START"];?></span></span></td>
      <td class="tcell-right"><?php if($objective->canedit) { ?><input name="task_startdate[<?php echo $value->id;?>]" type="text" class="input-date datepicker task_start" value="<?php echo $value->startdate;?>" readonly="readonly" /><?php } else { ?><?php echo $value->startdate;?><?php } ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["EMPLOYEE_OBJECTIVE_TASKS_END"];?></span></span></td>
      <td class="tcell-right"><?php if($objective->canedit) { ?><input name="task_enddate[<?php echo $value->id;?>]" type="text" class="input-date datepicker task_end" value="<?php echo $value->enddate;?>" readonly="readonly" /><?php } else { ?><?php echo $value->enddate;?><?php } ?></td>
    </tr>
    </table>
     <table width="100%" border="0" cellpadding="0" cellspacing="0" id="donedate_<?php echo $value->id;?>" style="<?php echo $donedate_field;?>">
    <tr>
      <td width="12">&nbsp;</td>
      <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["GLOBAL_STATUS_FINISHED"];?></span></span></td>
      <td class="tcell-right"><?php if($objective->canedit) { ?><input name="task_donedate[<?php echo $value->id;?>]" type="text" class="input-date datepicker task_donedate" value="<?php echo $donedate;?>" readonly="readonly" /><?php } else { ?><?php echo $donedate;?><?php } ?></td>
    </tr>
  </table>
  		</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>selectTextarea<?php } ?>"><span>&nbsp;</span></span></td>
    <td class="tcell-right"><?php if($objective->canedit) { ?><textarea name="task_text[<?php echo $value->id;?>]" class="elastic"><?php echo(strip_tags($value->text));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($value->text)));?><?php } ?></td>
  </tr>
</table>
</div>
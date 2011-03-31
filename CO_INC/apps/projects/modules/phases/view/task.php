<div id="task_<?php echo $value->id;?>" class="phaseouter">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
  <tr>
		<td class="tcell-left-phases-tasks text11">&nbsp;</td>
    	<td class="tcell-right">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="25" style="padding-top: 4px;"><input name="task[<?php echo $value->id;?>]" type="checkbox" value="<?php echo $value->id;?>" class="cbx jNiceHidden" <?php echo $checked ;?> /></td>
      <td class="text11" style="padding-top: 0px;"><input name="task_text[<?php echo $value->id;?>]" type="text" class="bg" value="<?php echo $value->text;?>" maxlength="100" /><input name="task_id[<?php echo $value->id;?>]" type="hidden" value="<?php echo $value->id;?>"><input name="task_cat[<?php echo $value->id;?>]" type="hidden" value="<?php echo $value->cat;?>"></td>
      <td width="30"><a class="deleteTask" rel="<?php echo $value->id;?>"><span class="icon-delete"></span></a></td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="12"></td>
      <td class="tcell-left text11"><span class="content-nav ui-datepicker-trigger-action"><span><?php echo $lang["PHASE_TASK_START"];?></span></span></td>
      <td class="tcell-right"><input name="task_startdate[<?php echo $value->id;?>]" type="text" class="input-date datepicker task_start" value="<?php echo $value->startdate;?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="tcell-left text11"><span class="content-nav ui-datepicker-trigger-action"><span><?php echo $lang["PHASE_TASK_END"];?></span></span></td>
      <td class="tcell-right"><input name="task_enddate[<?php echo $value->id;?>]" type="text" class="input-date datepicker task_end" value="<?php echo $value->enddate;?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="tcell-left text11"><span class="content-nav showDialog" request="getContactsDialog" field="task_team_<?php echo $value->id;?>" append="1"><span><?php echo $lang["PHASE_TASK_TEAM"];?></span></span></td>
      <td class="tcell-right"><div id="task_team_<?php echo $value->id;?>" class="itemlist-field task_team_list"><?php echo($value->team);?></div><div id="task_team_<?php echo $value->id;?>_ct" class="itemlist-field task_team_list_ct"><span field="task_team_<?php echo $value->id;?>_ct" class="ct-content"><?php echo($value->team_ct);?></span></div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="tcell-left text11"><span class="content-nav showDialog" request="getTasksDialog" field="dependent<?php echo $value->id;?>" sql="<?php echo $value->id;?>" append="1"><span><?php echo $lang["PHASE_TASK_DEPENDENT"];?></span></span></td>
      <td class="tcell-right"><input id="dependent<?php echo $value->id;?>" name="task_dependent[<?php echo $value->id;?>]" type="hidden" value="<?php echo $value->dependent;?>"><span id="dependent<?php echo $value->id;?>-text"><span class="dependentTask" rel="dependent<?php echo $value->id;?>"><?php echo $value->dependent_title;?></span></span></td>
    </tr>
    </table>
     <table width="100%" border="0" cellpadding="0" cellspacing="0" id="donedate_<?php echo $value->id;?>" style="<?php echo $donedate_field;?>">
    <tr>
      <td width="12">&nbsp;</td>
      <td class="tcell-left text11"><span class="content-nav ui-datepicker-trigger-action"><span><?php echo $lang["PROJECT_STATUS_FINISHED"];?></span></span></td>
      <td class="tcell-right"><input name="task_donedate[<?php echo $value->id;?>]" type="text" class="input-date datepicker task_donedate" value="<?php echo $donedate;?>" /></td>
    </tr>
  </table>
  		</td>
	</tr>
</table>
</div>
<div id="task_<?php echo $value->id;?>" class="meetingouter">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin">
  <tr>
		<td class="tcell-left-phases-tasks text11">&nbsp;</td>
    	<td class="tcell-right-nopadding">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-task">
    <tr>
    	<!--<td width="15"><div class="task-drag"></div></td>-->
     	<td width="20" style="padding-top: 4px;"><input name="task[<?php echo $value->id;?>]" type="checkbox" value="<?php echo $value->id;?>" class="cbx jNiceHidden" <?php echo $checked ;?> /></td>
      	<td class="text11" style="padding-top: 0px;"><input name="task_title[<?php echo $value->id;?>]" type="text" class="bg" value="<?php echo $value->title;?>" maxlength="100" /><input name="task_id[<?php echo $value->id;?>]" type="hidden" value="<?php echo $value->id;?>"><input class="task_sort" name="task_sort[<?php echo $value->id;?>]" type="hidden" value="<?php echo $value->sort;?>"></td>
		<td width="30"><a class="deleteTask" rel="<?php echo $value->id;?>"><span class="icon-delete"></span></a></td>

   </tr>
  </table>
  		</td>
	</tr>
</table>
  <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right"><textarea id="task_text_<?php echo $value->id;?>" name="task_text_<?php echo $value->id;?>" class="elastic"><?php echo $value->text;?></textarea></td>
    </tr>
</table>
</div>
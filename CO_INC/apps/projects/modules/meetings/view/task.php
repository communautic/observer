<div id="task_<?php echo $value->id;?>" class="meetingouter">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin">
  <tr>
		<td class="tcell-left-phases-tasks text11">&nbsp;</td>
    	<td class="tcell-right-nopadding">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-task">
    <tr>
    	<!--<td width="15"><div class="task-drag"></div></td>-->
     	<td width="20" style="padding-top: 4px;"><input name="task[<?php echo $value->id;?>]" type="checkbox" value="<?php echo $value->id;?>" class="cbx jNiceHidden <?php if(!$meeting->canedit) { ?>noperm<?php } ?>" <?php echo $checked ;?> /></td>
      	<td class="text11" style="padding-top: 0px;"><?php if($meeting->canedit) { ?><input name="task_title[<?php echo $value->id;?>]" type="text" class="bg" value="<?php echo $value->title;?>" maxlength="100" /><?php } else { ?><div class="text13 bold" style="margin-left: 7px;"><?php echo $value->title;?></div><?php } ?><input name="task_id[<?php echo $value->id;?>]" type="hidden" value="<?php echo $value->id;?>"><input class="task_sort" name="task_sort[<?php echo $value->id;?>]" type="hidden" value="<?php echo $value->sort;?>"></td>
		<?php if($meeting->canedit) { ?><td width="30"><a class="binItem" rel="<?php echo $value->id;?>"><span class="icon-delete"></span></a></td><?php } ?>

   </tr>
  </table>
  		</td>
	</tr>
</table>
  <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right"><?php if($meeting->canedit) { ?><textarea id="task_text_<?php echo $value->id;?>" name="task_text_<?php echo $value->id;?>" class="elastic"><?php echo strip_tags($value->text);?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($value->text)));?><?php } ?></td>
    </tr>
</table>
</div>
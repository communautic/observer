<div id="task_<?php echo $value->id;?>" class="serviceouter">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin">
  <tr>
		<td class="tcell-left-phases-tasks text11">&nbsp;</td>
    	<td class="tcell-right-nopadding">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-task">
    <tr>
     	<td width="20" style="padding-top: 5px;"><input name="task[<?php echo $value->id;?>]" type="checkbox" value="<?php echo $value->id;?>" class="cbx jNiceHidden <?php if(!$service->canedit || $value->bar == 1) { ?>noperm<?php } ?>" <?php echo $checked ;?> /></td>
      	<td class="text11" style="padding-top: 0px;"><input id="task_title_<?php echo $value->id;?>" name="task_title[<?php echo $value->id;?>]" type="text" class="bg bold" value="<?php echo $value->title;?>" maxlength="100" <?php if(!$service->canedit || $value->bar == 1) { ?>readonly="readonly"<?php } ?>/><input name="task_id[<?php echo $value->id;?>]" type="hidden" value="<?php echo $value->id;?>"><input class="task_sort" name="task_sort[<?php echo $value->id;?>]" type="hidden" value="<?php echo $value->sort;?>"></td>
		<td width="25"><div class="togglePost" rel="<?php echo $value->id;?>"><span class="icon-toggle-post"></span></div></td>
		<?php if($service->canedit && $value->bar == 0) { ?>
        <td width="25" class="dragHandle"><div class="task-drag"></div></td>
        <td width="25"><a class="binItem" rel="<?php echo $value->id;?>"><span class="icon-delete"></span></a></td><?php } ?>
   </tr>
  </table>
  		</td>
	</tr>
</table>
<div id="patientsservicetask_<?php echo $value->id;?>">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="selectMenge <?php if($service->canedit && $value->bar == 0) { ?>content-nav selectTextfield<?php } ?>"><span>Menge</span></span></td>
		<td class="tcell-right"><input id="task_text2_<?php echo $value->id;?>" style="padding: 1px 0 2px 0px" name="task_text2_<?php echo $value->id;?>" class="bg" value="<?php echo strip_tags($value->menge);?>" type="text" pattern="^\d+$" placeholder="1" <?php if(!$service->canedit || $value->bar == 1) { ?>readonly="readonly"<?php } ?>></td>
    </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="selectPreis <?php if($service->canedit && $value->bar == 0) { ?>content-nav selectTextfield<?php } ?>"><span>Preis (Euro)</span></span></td>
		<td class="tcell-right"><input id="task_text3_<?php echo $value->id;?>" style="padding: 1px 0 2px 0px" name="task_text3_<?php echo $value->id;?>" class="bg" value="<?php echo strip_tags($value->preis_pretty);?>" type="text" placeholder="0,00" <?php if(!$service->canedit || $value->bar == 1) { ?>readonly="readonly"<?php } ?>></td>
    </tr>
</table>
</div>
</div>
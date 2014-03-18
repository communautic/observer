<div id="task_<?php echo $value->id;?>" class="treatmenttaskouter">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive" style="margin-bottom: 0px;">
  <tr>
		<td class="tcell-left-phases-tasks text11">&nbsp;</td>
    	<td class="tcell-right-nopadding">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="20" style="padding-top: 4px;"><input name="task[<?php echo $value->id;?>]" type="checkbox" value="<?php echo $value->id;?>" class="cbx jNiceHidden <?php if(!$treatment->canedit) { ?>noperm<?php } ?>" <?php echo $checked ;?> /></td>
      <td class="text11" style="padding-top: 0px;">
          <div class="text13 bold" style="margin-left: 7px;"><?php echo $i;?>. <?php echo $lang["PATIENT_TREATMENT_GOALS_SINGUAL"];?></div><input name="task_id[<?php echo $value->id;?>]" type="hidden" value="<?php echo $value->id;?>"><input class="task_sort" name="task_sort[<?php echo $value->id;?>]" type="hidden" value=""></td><?php if($treatment->canedit) { ?><td width="25"><a class="binItem" rel="<?php echo $value->id;?>"><span class="icon-delete"></span></a></td><?php } ?>
    </tr>
  </table>

  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="12"></td>
      <td class="tcell-left text11"><span class="<?php if($treatment->canedit) { ?>content-nav showDialog<?php } ?>" request="getTreatmentsTypeDialog" field="task_treatmenttype_<?php echo $value->id;?>" append="1"><span><?php echo $lang["PATIENT_TREATMENT_TASKS_TYPE"];?></span></span></td>
      <td class="tcell-right"><div id="task_treatmenttype_<?php echo $value->id;?>" class="itemlist-field task_treatmenttype"><?php echo($value->type);?></div></td>
    </tr>
    <tr>
         <td width="12"></td>
		<td class="tcell-left-inactive text11"><span><span><?php echo $lang["PATIENT_TREATMENT_TASKS_THERAPIST"];?></span></span></td>
		<td class="tcell-right-inactive"><?php echo $value->displayname;?></td>
    </tr>
    <tr>
         <td width="12"></td>
		<td class="tcell-left-inactive text11"><span><span><?php echo $lang["PATIENT_TREATMENT_TASKS_PLACE"];?></span></span></td>
		<td class="tcell-right-inactive"><?php echo $value->location;?></td>
    </tr>
    <tr>
         <td width="12"></td>
		<td class="tcell-left-inactive text11"><span><span><?php echo $lang["PATIENT_TREATMENT_TASKS_DATE_CALENDAR"];?></span></span></td>
		<td class="tcell-right-inactive"><?php echo $value->startdate;?></td>
    </tr>
    <tr>
         <td width="12"></td>
		<td class="tcell-left-inactive text11"><span><span><?php echo $lang["PATIENT_TREATMENT_TASKS_TIME"];?></span></span></td>
		<td class="tcell-right-inactive"><?php echo $value->time;?></td>
    </tr>
    <tr>
      <td width="12"></td>
      <td class="tcell-left text11"><span class="<?php if($treatment->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["PATIENT_TREATMENT_TASKS_DATE_INVOICE"];?></span></span></td>
      <td class="tcell-right"><?php if($treatment->canedit) { ?><input name="task_date[<?php echo $value->id;?>]" type="text" class="input-date datepicker task_date" value="<?php echo $value->item_date;?>" readonly="readonly" /><?php } else { ?><?php echo $value->item_date;?><?php } ?></td>
    </tr>
    <tr>
         <td width="12"></td>
		<td class="tcell-left-inactive text11"><span><span><?php echo $lang["PATIENT_TREATMENT_TASKS_DURATION"];?></span></span></td>
		<td class="tcell-right-inactive"><span id="minutes_<?php echo $value->id;?>"><?php echo $value->min;?></span> Min</td>
    </tr>
    <tr>
         <td width="12"></td>
		<td class="tcell-left-inactive text11"><span><span><?php echo $lang["PATIENT_TREATMENT_AMOUNT"];?></span></span></td>
		<td class="tcell-right-inactive"><?php echo CO_DEFAULT_CURRENCY;?> <span id="costs_<?php echo $value->id;?>" class="currency"><?php echo number_format($value->costs,2,',','.');;?></span></td>
    </tr>
    </table>


  		</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($treatment->canedit) { ?>selectTextarea<?php } ?>"><span>&nbsp;</span></span></td>
    <td class="tcell-right"><?php if($treatment->canedit) { ?><textarea name="task_text[<?php echo $value->id;?>]" class="elastic"><?php echo(strip_tags($value->text));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($value->text)));?><?php } ?></td>
  </tr>
</table>
</div>
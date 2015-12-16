<div id="task_<?php echo $value->id;?>" class="treatmenttaskouter">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive" style="margin-bottom: 0px;">
  <tr>
		<td class="tcell-left-phases-tasks text11">&nbsp;</td>
    	<td class="tcell-right-nopadding">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="20" style="padding-top: 7px;"><input name="task[<?php echo $value->id;?>]" type="checkbox" value="<?php echo $value->id;?>" class="cbx jNiceHidden <?php if(!$treatment->canedit) { ?>noperm<?php } ?>" <?php echo $checked ;?> /></td>
      <td width="144" class="text11" style="padding-top: 2px;">
          <div class="text13 bold" style="margin-left: 7px;"><?php echo $i;?>. <?php echo $lang["PATIENT_TREATMENT_GOALS_SINGUAL"];?></div><input name="task_id[<?php echo $value->id;?>]" type="hidden" value="<?php echo $value->id;?>"><input class="task_sort" name="task_sort[<?php echo $value->id;?>]" type="hidden" value=""></td>
		  <td class="tcell-right-inactive text11"><span <?php if($value->calendarlink) {?>class="<?php if($treatment->canedit || $treatment->specialcanedit) { ?>loadCalendarEvent co-link<?php } ?>" rel="<?php echo $value->couid;?>,<?php echo $value->linkyear;?>,<?php echo $value->linkmonth;?>,<?php echo $value->linkday;?>,<?php echo $value->eventid;?>"<?php } ?>><?php echo $value->startdate;?>&nbsp; | &nbsp;<?php echo $value->time;?>&nbsp; | &nbsp;<?php echo $value->displayname;?>&nbsp; | &nbsp;<?php echo $value->location;?></span></td>
		  <?php if($treatment->canedit) { ?><td width="25"><a class="binItem" rel="<?php echo $value->id;?>"><span class="icon-delete"></span></a></td><?php } ?>
    </tr>
  </table>
   <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="12"></td>
      <td class="tcell-left text11"><span class="<?php if($treatment->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["PATIENT_TREATMENT_TASKS_DATE_INVOICE"];?></span></span></td>
      <td class="tcell-right"><?php if($treatment->canedit) { ?><input name="task_date[<?php echo $value->id;?>]" type="text" class="input-date datepicker task_date" value="<?php echo $value->item_date;?>" readonly="readonly" style="margin-left: -1px;" /><?php } else { ?><?php echo $value->item_date;?><?php } ?></td>
    </tr>
    <tr>
      <td width="12"></td>
      <td class="tcell-left text11"><span class="<?php if($treatment->canedit) { ?>content-nav showDialog<?php } ?>" request="getTreatmentsTypeDialog" field="task_treatmenttype_<?php echo $value->id;?>" append="1"><span><?php echo $lang["PATIENT_TREATMENT_TASKS_TYPE"];?></span></span></td>
      <td class="tcell-right"><div id="task_treatmenttype_<?php echo $value->id;?>" class="itemlist-field task_treatmenttype"><?php echo($value->type);?></div></td>
    </tr>
    <tr>
         <td width="12"></td>
		<td class="tcell-left-inactive text11">&nbsp;</td>
		<td class="tcell-right-inactive text11" style="padding-top: 1px;"><span id="minutes_<?php echo $value->id;?>"><?php echo $value->min;?></span> Min&nbsp; | &nbsp;<?php echo CO_DEFAULT_CURRENCY;?> <span id="costs_<?php echo $value->id;?>" class="currency"><?php echo number_format($value->costs,2,',','.');;?></span></td>
    </tr>
    </table>
<div style="height: 5px;"></div>

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
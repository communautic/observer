<!-- 2 	Vortrag & Gruppencoaching -->
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
	<tr>
		<td class="tcell-left text11" style="padding-top: 4px;"><span class="<?php if($training->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span>Vortrag</span></span></td>
		<td class="tcell-right" style="padding-top: 6px;"><input name="date1" type="text" class="input-date datepicker date1" value="<?php echo($training->date1)?>" readonly="readonly" /></td>
	</tr>
	<tr>
		<td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav showDialogTime<?php } ?>" rel="trainingstime1"><span><?php echo $lang["TRAINING_TIME_START"];?></span></span></td>
		<td class="tcell-right"><div id="trainingstime1" class="itemlist-field"><?php echo($training->time1);?></div></td>
	</tr>
	<tr>
		<td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav showDialogTime<?php } ?>" rel="trainingstime2"><span><?php echo $lang["TRAINING_TIME_END"];?></span></span></td>
		<td class="tcell-right"><div id="trainingstime2" class="itemlist-field"><?php echo($training->time2);?></div></td>
	</tr>
	<tr>
		<td class="tcell-left text11" style="padding-bottom: 4px;"><span class="<?php if($training->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialogPlace" field="trainingsplace1" append="0"><span><?php echo $lang["TRAINING_PLACE"];?></span></span></td>
		<td class="tcell-right"><div id="trainingsplace1" class="itemlist-field"><?php echo($training->place1);?></div><div id="trainingsplace1_ct" class="itemlist-field"><a field="trainingsplace1_ct" class="ct-content"><?php echo($training->place1_ct);?></a></div></td>
	</tr>
    <tr>
		<td class="tcell-left text11" style="padding-top: 10px;"><span class="<?php if($training->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span>Coaching</span></span></td>
		<td class="tcell-right" style="padding-top: 12px;"><input name="date2" type="text" class="input-date datepicker date2" value="<?php echo($training->date2)?>" readonly="readonly" /></td>
	</tr>
	<tr>
		<td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav showDialogTime<?php } ?>" rel="trainingstime3"><span><?php echo $lang["TRAINING_TIME_START"];?></span></span></td>
		<td class="tcell-right"><div id="trainingstime3" class="itemlist-field"><?php echo($training->time3);?></div></td>
	</tr>
	<tr>
		<td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav showDialogTime<?php } ?>" rel="trainingstime4"><span><?php echo $lang["TRAINING_TIME_END"];?></span></span></td>
		<td class="tcell-right"><div id="trainingstime4" class="itemlist-field"><?php echo($training->time4);?></div></td>
	</tr>
	<tr>
		<td class="tcell-left text11" style="padding-bottom: 4px;"><span class="<?php if($training->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialogPlace" field="trainingsplace2" append="0"><span><?php echo $lang["TRAINING_PLACE"];?></span></span></td>
		<td class="tcell-right"><div id="trainingsplace2" class="itemlist-field"><?php echo($training->place2);?></div><div id="trainingsplace2_ct" class="itemlist-field"><a field="trainingsplace2_ct" class="ct-content"><?php echo($training->place2_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive dark">
    <tr>
		<td class="tcell-left text11" style="padding: 4px 15px 4px 0;"><span class="<?php if($training->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["TRAINING_REGISTRATION_END"];?></span></span></td>
		<td class="tcell-right" style="padding: 6px 0 0 0;"><input name="registration_end" type="text" class="input-date datepicker date1" value="<?php echo($training->registration_end)?>" readonly="readonly" /></td>
	</tr>
</table>

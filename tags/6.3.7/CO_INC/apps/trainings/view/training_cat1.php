<!-- 1 	Vortrag -->
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
	<tr>
		<td class="tcell-left text11" style="padding-top: 4px;"><span class="<?php if($training->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span>Vortrag</span></span></td>
		<td class="tcell-right" style="padding-top: 6px;"><input name="date1" type="text" class="input-date datepicker date1" value="<?php echo($training->date1)?>" /></td>
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
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive dark">
    <tr>
		<td class="tcell-left text11" style="padding: 4px 15px 4px 0;"><span class="<?php if($training->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["TRAINING_REGISTRATION_END"];?></span></span></td>
		<td class="tcell-right" style="padding: 6px 0 0 0;"><input name="registration_end" type="text" class="input-date datepicker date1" value="<?php echo($training->registration_end)?>" /></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["TRAINING_DESCRIPTION"];?></span></span></td>
        <td class="tcell-right"><?php if($training->canedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($training->protocol));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($training->protocol)));?><?php } ?></td>
	</tr>
</table>
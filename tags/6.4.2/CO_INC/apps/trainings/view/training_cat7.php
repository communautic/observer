<!-- 7 Veranstaltungsreihe -->
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
		<tr>
		<td class="tcell-left text11" style="padding-top: 4px;"><span class="<?php if($training->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span>Veranstaltungsbeginn</span></span></td>
		<td class="tcell-right" style="padding-top: 6px;"><input name="date1" type="text" class="input-date datepicker date1" value="<?php echo($training->date1)?>" /></td>
	</tr>
        <tr>
		<td class="tcell-left-shorter text11" style="padding-top: 4px;"><span class="<?php if($training->canedit) { ?>content-nav selectTextfield<?php } ?>"><span>Folgetermine</span></span></td>
		<td class="tcell-right-nopadding" style="padding-top: 3px;"><?php if($training->canedit) { ?><input name="text1" type="text" class="bg" style="margin-left: -5px;" value="<?php echo($training->text1);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $training->text1 . '</span>'); } ?></td>
	</tr>
        <tr>
		<td class="tcell-left text11" style="padding-top: 4px;"><span class="<?php if($training->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span>Veranstaltungsende</span></span></td>
		<td class="tcell-right" style="padding-top: 6px;"><input name="date2" type="text" class="input-date datepicker date2" value="<?php echo($training->date2)?>" /></td>
	</tr>

	<tr>
		<td class="tcell-left-shorter text11" style="padding-top: 1px;"><span class="<?php if($training->canedit) { ?>content-nav selectTextfield<?php } ?>"><span>Dauer</span></span></td>
		<td class="tcell-right-nopadding"><?php if($training->canedit) { ?><input name="text2" type="text" class="bg" style="margin-left: -5px;" value="<?php echo($training->text2);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $training->text2 . '</span>'); } ?></td>
	</tr>
	<tr>
		<td class="tcell-left-shorter text11" style="padding-top: 1px; padding-bottom: 4px;"><span class="<?php if($training->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["TRAINING_PLACE"];?></span></span></td>
		<td class="tcell-right-nopadding"><?php if($training->canedit) { ?><input name="text3" type="text" class="bg" style="margin-left: -5px;" value="<?php echo($training->text3);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $training->text3 . '</span>'); } ?></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive dark">
    <tr>
		<td class="tcell-left text11" style="padding: 4px 15px 4px 0;"><span class="<?php if($training->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["TRAINING_REGISTRATION_END"];?></span></span></td>
		<td class="tcell-right" style="padding: 6px 0 0 0;"><input name="registration_end" type="text" class="input-date datepicker date1" value="<?php echo($training->registration_end)?>" /></td>
	</tr>
</table>

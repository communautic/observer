<div class="table-title-outer">

<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["TRAINING_TITLE"];?></span></span></td>
    <td class="tcell-right"><?php if($training->canedit) { ?><input name="title" type="text" class="title textarea-title" value="<?php echo($training->title);?>" maxlength="100" /><?php } else { ?><div class="textarea-title"><?php echo($training->title);?></div><?php } ?></td>
  </tr>
  <tr class="table-title-status">
    <td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_STATUS"];?></td>
    <td colspan="2"><div class="statusTabs">
    	<ul>
        	<li><span class="left<?php if($training->canedit) { ?> statusButton<?php } ?> planned<?php echo $training->status_planned_active;?>" rel="0" reltext="<?php echo $lang["GLOBAL_STATUS_PLANNED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_PLANNED"];?></span></li>
            <li><span class="<?php if($training->canedit) { ?>statusButton <?php } ?>inprogress<?php echo $training->status_inprogress_active;?>" rel="1" reltext="<?php echo $lang["GLOBAL_STATUS_INACTION_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_INACTION"];?></span></li>
            <li><span class="<?php if($training->canedit) { ?>statusButton <?php } ?>finished<?php echo $training->status_finished_active;?>" rel="2" reltext="<?php echo $lang["GLOBAL_STATUS_FINISHED2_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_FINISHED2"];?></span></li>
            <li><span class="right<?php if($training->canedit) { ?> statusButton<?php } ?> stopped<?php echo $training->status_stopped_active;?>" rel="3" reltext="<?php echo $lang["GLOBAL_STATUS_CANCELLED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_CANCELLED"];?></span></li>
            <li><div class="status-time"><?php echo($training->status_text_time)?></div><div class="status-input"><input name="phase_status_date" type="text" class="input-date statusdp" value="<?php echo($training->status_date)?>" readonly="readonly" /></div></li>
		</ul></div></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($training->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setTrainingDetails">
<input type="hidden" name="id" value="<?php echo($training->id);?>">
<?php if($training->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span>Warnung</span></span></strong></td>
		<td class="tcell-right"><strong>Dieser Inhaltsbereich wird aktuell bearbeitet von: <?php echo($training->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($training->checked_out_user_email);?>"><?php echo($training->checked_out_user_email);?></a>, <?php echo($training->checked_out_user_phone1);?></td>
    </tr>
</table>
<div class="content-spacer"></div>
<?php } ?>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav showDialog<?php } ?>" request="getTrainingFolderDialog" field="trainingsfolder" append="1"><span><?php echo $lang["TRAINING_FOLDER"];?></span></span></td>
        <td class="tcell-right"><div id="trainingsfolder" class="itemlist-field"><?php echo($training->folder);?></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="trainingsmanagement" append="1"><span><?php echo $lang["TRAINING_MANAGEMENT"];?></span></span></td>
	  <td class="tcell-right"><div id="trainingsmanagement" class="itemlist-field"><?php echo($training->management);?></div><div id="trainingsmanagement_ct" class="itemlist-field"><a field="trainingsmanagement_ct" class="ct-content"><?php echo($training->management_ct);?></a></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="trainingsordered_by" append="0"><span><?php echo $lang["TRAINING_CLIENT"];?></span></span></td>
	  <td class="tcell-right"><div id="trainingsordered_by" class="itemlist-field"><?php echo($training->ordered_by);?></div><div id="trainingsordered_by_ct" class="itemlist-field"><a field="trainingsordered_by_ct" class="ct-content"><?php echo($training->ordered_by_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="trainingsteam" append="1"><span><?php echo $lang["TRAINING_TEAM"];?></span></span></td>
    <td class="tcell-right"><div id="trainingsteam" class="itemlist-field"><?php echo($training->team);?></div><div id="trainingsteam_ct" class="itemlist-field"><a field="trainingsteam_ct" class="ct-content"><?php echo($training->team_ct);?></a></div></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav showDialog<?php } ?>" request="getTrainingDialog" field="trainingstraining" append="0"><span><?php echo $lang["TRAINING_TRAININGCAT"];?></span></span></td>
        <td class="tcell-right"><div id="trainingstraining" class="itemlist-field"><?php echo($training->training);?></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<!--
<table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-highlighted">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($training->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang['TRAINING_PRODUCT_NUMBER'];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($training->canedit) { ?><input name="product" type="text" class="bg" value="<?php echo($training->product);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $training->product . '</span>'); } ?></td>
    <td width="110"></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-highlighted">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($training->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang['TRAINING_PRODUCT'];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($training->canedit) { ?><input name="product_desc" type="text" class="bg" value="<?php echo($training->product_desc);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $training->product_desc . '</span>'); } ?></td>
    <td width="110"></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-highlighted">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($training->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang['TRAINING_CHARGE'];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($training->canedit) { ?><input name="charge" type="text" class="bg" value="<?php echo($training->charge);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $training->charge . '</span>'); } ?></td>
    <td width="110"></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-highlighted">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($training->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang['TRAINING_NUMBER'];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($training->canedit) { ?><input name="number" type="text" class="bg" value="<?php echo($training->number);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $training->number . '</span>'); } ?></td>
    <td width="110"></td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["TRAINING_DESCRIPTION"];?></span></span></td>
        <td class="tcell-right"><?php if($training->canedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($training->protocol));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($training->protocol)));?><?php } ?></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_DURATION"];?></td>
		<td class="tcell-right-inactive"><span id="trainingDurationStart"><?php echo($training->startdate)?></span> - <span id="trainingDurationEnd"><?php echo($training->enddate)?></span></td>
    </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang['TRAINING_KICKOFF'];?></span></span></td>
		<td class="tcell-right"><?php if($training->canedit) { ?><input name="startdate" type="text" class="input-date datepicker" value="<?php echo($training->startdate)?>" /><?php } else { ?><?php echo($training->startdate)?><?php } ?></td>
	</tr>-->
</table>
</form>
<?php if($training->access != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="content-nav ui-datepicker-trigger-action"><span><?php echo $lang['GLOBAL_CHECKPOINT'];?></span></span></td>
		<td class="tcell-right"><input name="checkpoint" type="text" class="input-date checkpointdp" value="<?php echo($training->checkpoint_date);?>" readonly="readonly" /><span style="display: none;"><?php echo($training->checkpoint);?></span></td>
	</tr>
</table>
<?php if($training->checkpoint == 1) { $show = 'display: block'; } else { $show = 'display: none'; }?>
<div id="trainingsCheckpoint" style="<?php echo $show;?>">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="selectTextarea"><span>&nbsp;</span></span></td>
        <td class="tcell-right"><textarea name="checkpoint_note" class="elastic-two"><?php echo(strip_tags($training->checkpoint_note));?></textarea></td>
	</tr>
</table>
</div>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="training_sendto">
        <?php 
			foreach($sendto as $value) { 
			if(!empty($value->who)) {
				echo '<div class="text11 toggleSendTo co-link">' . $value->who . ', ' . $value->date . '</div>' .
				'<div class="SendToContent">' . $lang["GLOBAL_SUBJECT"] . ': ' . $value->subject . '<br /><br />' . nl2br($value->body) . '<br></div>';
			}
		 } ?></div></td>
    </tr>
</table>
<?php } ?>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($training->edited_user.", ".$training->edited_date)?></td>
    <td class="middle"></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($training->created_user.", ".$training->created_date);?></td>
  </tr>
</table>
</div>
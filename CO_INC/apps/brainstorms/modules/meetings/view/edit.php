<div class="table-title-outer">
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($meeting->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["BRAINSTORM_MEETING_TITLE"];?></span></span></td>
    <td><input name="title" type="text" class="title textarea-title" value="<?php echo($meeting->title);?>" maxlength="100" /></td>
  </tr>
  <tr class="table-title-status">
    <td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_STATUS"];?></td>
    <td colspan="2"><div class="statusTabs">
    	<ul>
        	<li><span class="left<?php if($meeting->canedit) { ?> statusButton<?php } ?> planned<?php echo $meeting->status_planned_active;?>" rel="0" reltext="<?php echo $lang["GLOBAL_STATUS_PLANNED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_PLANNED"];?></span></li>
            <li><span class="<?php if($meeting->canedit) { ?>statusButton<?php } ?> finished<?php echo $meeting->status_finished_active;?>" rel="1" reltext="<?php echo $lang["GLOBAL_STATUS_COMPLETED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_COMPLETED"];?></span></li>
            <li><span class="<?php if($meeting->canedit) { ?>statusButton<?php } ?> stopped<?php echo $meeting->status_stopped_active;?>" rel="2" reltext="<?php echo $lang["GLOBAL_STATUS_CANCELLED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_CANCELLED"];?></span></li>
			<li><span class="right<?php if($meeting->canedit) { ?> statusButton<?php } ?> stopped<?php echo $meeting->status_posponed_active;?>" rel="3" reltext="<?php echo $lang["GLOBAL_STATUS_POSPONED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_POSPONED"];?></span></li>
            <li><div class="status-time"><?php echo($meeting->status_text_time)?></div><div class="status-input"><input name="meeting_status_date" type="text" class="input-date statusdp" value="<?php echo($meeting->status_date)?>" readonly="readonly" /></div></li>
		</ul></div></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($meeting->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($meeting->id);?>">
<input type="hidden" name="pid" value="<?php echo($meeting->pid);?>">
<?php if($meeting->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span>Warnung</span></span></strong></td>
		<td class="tcell-right"><strong>Dieser Inhaltsbereich wird aktuell bearbeitet von: <?php echo($meeting->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($meeting->checked_out_user_email);?>"><?php echo($meeting->checked_out_user_email);?></a>, <?php echo($meeting->checked_out_user_phone1);?></td>
    </tr>
</table>
<?php } ?>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($meeting->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["BRAINSTORM_MEETING_DATE"];?></span></span></td>
		<td class="tcell-right"><input name="item_date" type="text" class="input-date datepicker item_date" value="<?php echo($meeting->item_date)?>" /></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($meeting->canedit) { ?>content-nav showDialogTime<?php } ?>" rel="brainstormsmeetingstart"><span><?php echo $lang["BRAINSTORM_MEETING_TIME_START"];?></span></span></td>
		<td class="tcell-right"><div id="brainstormsmeetingstart" class="itemlist-field"><?php echo($meeting->start);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($meeting->canedit) { ?>content-nav showDialogTime<?php } ?>" rel="brainstormsmeetingend"><span><?php echo $lang["BRAINSTORM_MEETING_TIME_END"];?></span></span></td>
		<td class="tcell-right"><div id="brainstormsmeetingend" class="itemlist-field"><?php echo($meeting->end);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($meeting->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialogPlace" field="brainstormslocation" append="0"><span><?php echo $lang["BRAINSTORM_MEETING_PLACE"];?></span></span></td>
		<td class="tcell-right"><div id="brainstormslocation" class="itemlist-field"><?php echo($meeting->location);?></div><div id="brainstormslocation_ct" class="itemlist-field"><a field="brainstormslocation_ct" class="ct-content"><?php echo($meeting->location_ct);?></a></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span href="#" class="<?php if($meeting->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="brainstormsparticipants" append="1"><span><?php echo $lang["BRAINSTORM_MEETING_ATTENDEES"];?></span></span></td>
		<td class="tcell-right"><div id="brainstormsparticipants" class="itemlist-field"><?php echo($meeting->participants);?></div><div id="brainstormsparticipants_ct" class="itemlist-field"><a field="brainstormsparticipants_ct" class="ct-content"><?php echo($meeting->participants_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($meeting->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="brainstormsmanagement" append="1"><span><?php echo $lang["BRAINSTORM_MEETING_MANAGEMENT"];?></span></span></td>
		<td class="tcell-right"><div id="brainstormsmanagement" class="itemlist-field"><?php echo($meeting->management);?></div><div id="brainstormsmanagement_ct" class="itemlist-field"><a field="brainstormsmanagement_ct" class="ct-content"><?php echo($meeting->management_ct);?></a></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content addTaskTable">
	<tr>
		<td class="tcell-left text11">
        <span class="<?php if($meeting->canedit) { ?>content-nav newItem<?php } ?>"><span><?php echo $lang["BRAINSTORM_MEETING_GOALS"];?></span></span>
        </td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table><div id="brainstormsmeetingtasks">
<?php 
foreach($task as $value) { 
	$checked = '';
	if($value->status == 1) {
		$checked = ' checked="checked"';
	}
include("task.php");
 } ?>
</div>
<?php if($meeting->perms != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($meeting->canedit) { ?>content-nav showDialog<?php } ?>" request="getDocumentsDialog" field="brainstormsdocuments" append="1"><span><?php echo $lang["BRAINSTORM_DOCUMENT_DOCUMENTS"];?></span></span></td>
    <td class="tcell-right"><div id="brainstormsdocuments" class="itemlist-field"><?php echo($meeting->documents);?></div></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($meeting->canedit) { ?>content-nav showDialog<?php } ?>" request="getAccessDialog" field="brainstormsmeeting_access" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></span></td>
        <td class="tcell-right"><div id="brainstormsmeeting_access" class="itemlist-field"><div class="listmember" field="brainstormsmeeting_access" uid="<?php echo($meeting->access);?>" style="float: left"><?php echo($meeting->access_text);?></div></div><input type="hidden" name="meeting_access_orig" value="<?php echo($meeting->access);?>" /></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="content-nav ui-datepicker-trigger-action"><span><?php echo $lang['GLOBAL_CHECKPOINT'];?></span></span></td>
		<td class="tcell-right"><input name="checkpoint" type="text" class="input-date checkpointdp" value="<?php echo($meeting->checkpoint_date);?>" readonly="readonly" /><span style="display: none;"><?php echo($meeting->checkpoint);?></span></td>
	</tr>
</table>
<?php if($meeting->checkpoint == 1) { $show = 'display: block'; } else { $show = 'display: none'; }?>
<div id="brainstorms_meetingsCheckpoint" style="<?php echo $show;?>">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="content-nav selectTextarea"><span>&nbsp;</span></span></td>
        <td class="tcell-right"><textarea name="checkpoint_note" class="elastic-two"><?php echo(strip_tags($meeting->checkpoint_note));?></textarea></td>
	</tr>
</table>
</div>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="brainstormsmeeting_sendto">
        <?php 
			foreach($sendto as $value) { 
				if(!empty($value->who)) {
					echo '<div class="text11 toggleSendTo">' . $value->who . ', ' . $value->date . '</div>' .
						 '<div class="SendToContent">' . $lang["GLOBAL_SUBJECT"] . ': ' . $value->subject . '<br /><br />' . nl2br($value->body) . '<br></div>';
				}
		 } ?></div>
        </td>
    </tr>
</table>
<?php } ?>
</form>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($meeting->edited_user.", ".$meeting->edited_date)?></td>
    <td class="middle"><?php echo $meeting->access_footer;?></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($meeting->created_user.", ".$meeting->created_date);?></td>
  </tr>
</table>
</div>
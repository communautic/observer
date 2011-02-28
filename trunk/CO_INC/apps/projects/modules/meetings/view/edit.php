<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><a href="#" class="content-nav focusTitle"><span><?php echo MEETING_TITLE;?></span></a></td>
    <td><input name="title" type="text" class="title textarea-title" value="<?php echo($meeting->title);?>" maxlength="100" /></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="coform jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($meeting->id);?>">
<input type="hidden" name="pid" value="<?php echo($meeting->pid);?>">
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><a href="<?php echo MEETING_DATE;?>" class="content-nav ui-datepicker-trigger-action"><span><?php echo MEETING_DATE;?></span></a></td>
		<td class="tcell-right"><input name="meeting_date" type="text" class="input-date datepicker meeting_date" value="<?php echo($meeting->meeting_date)?>" /></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><a href="time" class="content-nav showDialogTime" rel="meetingstart" title="Zeit"><span><?php echo MEETING_TIME_START;?></span></a></td>
		<td class="tcell-right"><div id="meetingstart" class="itemlist-field"><?php echo($meeting->start);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><a href="time" class="content-nav showDialogTime" rel="meetingend" title="Zeit"><span><?php echo MEETING_TIME_END;?></span></a></td>
		<td class="tcell-right"><div id="meetingend" class="itemlist-field"><?php echo($meeting->end);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><a href="Ort" class="content-nav showDialog" request="getContactsDialogPlace" field="location" title="Ort" append="0"><span><?php echo MEETING_PLACE;?></span></a></td>
		<td class="tcell-right"><div id="location" class="itemlist-field"><?php echo($meeting->location);?></div><div id="location_ct" class="itemlist-field"><a field="location_ct" class="ct-content"><?php echo($meeting->location_ct);?></a></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><a href="#" class="content-nav showDialog" request="getContactsDialog" field="participants" append="1"><span><?php echo MEETING_ATTENDEES;?></span></a></td>
		<td class="tcell-right"><div id="participants" class="itemlist-field"><?php echo($meeting->participants);?></div><div id="participants_ct" class="itemlist-field"><a field="participants_ct" class="ct-content"><?php echo($meeting->participants_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><a href="#" class="content-nav showDialog" request="getContactsDialog" field="management" append="1"><span><?php echo MEETING_MANAGEMENT;?></span></a></td>
		<td class="tcell-right"><div id="management" class="itemlist-field"><?php echo($meeting->management);?></div><div id="management_ct" class="itemlist-field"><a field="management_ct" class="ct-content"><?php echo($meeting->management_ct);?></a></div></td>
	</tr>
</table>
<!--<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><a href="#" class="content-nav activateToolbar"><span><?php echo MEETING_DESCRIPTION;?></span></a></td>
		<td  class="tcell-right"><div class="protocol-outer"><textarea name="protocol" class="tinymce" id="protocol"><?php echo($meeting->protocol);?></textarea></div></td>
    </tr>
</table>-->
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><a href="<?php echo $lang["GLOBAL_STATUS"];?>" class="content-nav showDialog" request="getMeetingStatusDialog" field="status" title="<?php echo $lang["GLOBAL_STATUS"];?>" append="1"><span><?php echo $lang["GLOBAL_STATUS"];?></span></a></td>
        <td class="tcell-right"><div id="meeting_status" class="itemlist-field"><div class="listmember" field="meeting_status" uid="<?php echo($meeting->status);?>" style="float: left"><?php echo($meeting->status_text);?></div></div><input name="meeting_status_date" type="text" class="input-date datepicker meeting_status_date" value="<?php echo($meeting->status_date)?>" style="float: left; margin-left: 8px;" /></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content addTaskTable">
	<tr>
		<td class="tcell-left text11">
        <a href="<?php echo MEETING_GOALS_ADD;?>" class="content-nav addMeetingTask" title="<?php echo(MEETING_GOALS_ADD);?>"><span><?php echo MEETING_GOALS;?></span></a>
        </td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table><div id="meetingtasks">
<?php 
foreach($task as $value) { 
	$checked = '';
	if($value->status == 1) {
		$checked = ' checked="checked"';
	}
include("task.php");
 } ?>
</div>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><a href="#" class="content-nav showDialog" request="getDocumentsDialog" field="documents" append="1"><span><?php echo $lang["DOCUMENT_DOCUMENTS"];?></span></a></td>
    <td class="tcell-right"><div id="documents" class="itemlist-field"><?php echo($meeting->documents);?></div></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><a href="#" class="content-nav showDialog" request="getAccessDialog" field="meeting_access" title="<?php echo $lang["GLOBAL_ACCESS"];?>" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></a></td>
        <td class="tcell-right"><div id="meeting_access" class="itemlist-field"><div class="listmember" field="meeting_access" uid="<?php echo($meeting->access);?>" style="float: left"><?php echo($meeting->access_text);?></div></div><input type="hidden" name="meeting_access_orig" value="<?php echo($meeting->access);?>" /></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive"><?php echo($meeting->emailed_to);?></td>
    </tr>
</table>
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
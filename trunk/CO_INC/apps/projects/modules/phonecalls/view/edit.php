<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><a href="<?php echo MEETING_TITLE;?>" class="content-nav focusTitle"><span><?php echo PHONECALL_TITLE;?></span></a></td>
    <td><input type="text" name="title" class="title textarea-title" value="<?php echo($phonecall->title);?>" /></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scrolling-content">
<form action="<?php echo $this->form_url;?>" method="post" class="coform jNice">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($phonecall->id);?>">
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><a href="<?php echo PHONECALL_STATUS;?>" class="content-nav showDialog" request="getMeetingStatusDialog" field="status" title="<?php echo PHONECALL_STATUS;?>" append="1"><span><?php echo PHONECALL_RELATES_TO;?></span></a></td>
        <td class="tcell-right"><div id="meeting_relates_to" class="itemlist-field"><div class="listmember" field="meeting_relates_to" uid=""></div></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><a href="<?php echo PHONECALL_STATUS;?>" class="content-nav showDialog" request="getMeetingStatusDialog" field="status" title="<?php echo PHONECALL_STATUS;?>" append="1"><span>Gespr&auml;chsart</span></a></td>
        <td class="tcell-right"><div id="meeting_relates_to" class="itemlist-field"><div class="listmember" field="meeting_relates_to" uid="">Incoming</div></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><a href="<?php echo PHONECALL_DATE;?>" class="content-nav ui-datepicker-trigger-action"><span><?php echo PHONECALL_DATE;?></span></a></td>
		<td class="tcell-right"><input name="phonecall_date" type="text" class="input-date datepicker phonecall_date" value="<?php echo($phonecall->phonecall_date)?>" /></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><a href="time" class="content-nav showDialogTime" rel="phonecallstart" title="Zeit"><span><?php echo PHONECALL_TIME_START;?></span></a></td>
		<td class="tcell-right"><div id="phonecallstart" class="itemlist-field"><?php echo($phonecall->start);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><a href="time" class="content-nav showDialogTime" rel="phonecallend" title="Zeit"><span><?php echo PHONECALL_TIME_END;?></span></a></td>
		<td class="tcell-right"><div id="phonecallend" class="itemlist-field"><?php echo($phonecall->end);?></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><a href="#" class="content-nav showDialog" request="getContactsDialog" field="management" append="1"><span>Gespr&auml;chspartner</span></a></td>
		<td class="tcell-right"><div id="management" class="itemlist-field">Randolf Gunharth</div><div id="management_ct" class="itemlist-field"><a field="management_ct" class="ct-content"></a></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><a href="#" class="content-nav activateToolbar"><span><?php echo PHONECALL_DESCRIPTION;?></span></a></td>
		<td  class="tcell-right"><div class="protocol-outer"><textarea name="protocol" class="tinymce" id="protocol"><?php echo($phonecall->protocol);?></textarea></div></td>
    </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><a href="#" class="content-nav showDialog" request="getAccessDialog" field="phonecall_access" title="<?php echo $lang["GLOBAL_ACCESS"];?>" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></a></td>
        <td class="tcell-right"><div id="phonecall_access" class="itemlist-field"><div class="listmember" field="phonecall_access" uid="<?php echo($phonecall->access);?>" style="float: left">zur internen Nutzung</div></div></td>
	</tr>
</table>

<div class="content-spacer"></div>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive"></td>
    </tr>
</table>
</form>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($phonecall->edited_user.", ".$phonecall->edited_date)?></td>
    <td class="middle"></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($phonecall->created_user.", ".$phonecall->created_date);?></td>
  </tr>
</table>
</div>
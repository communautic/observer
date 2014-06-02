<div class="table-title-outer">

<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($phonecall->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["EMPLOYEE_PHONECALL_TITLE"];?></span></span></td>
    <td><input name="title" type="text" class="title textarea-title" value="<?php echo($phonecall->title);?>" maxlength="100" /></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($phonecall->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($phonecall->id);?>">
<input type="hidden" name="pid" value="<?php echo($phonecall->pid);?>">
<?php if($phonecall->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span><?php echo $lang["GLOBAL_ALERT"];?></span></span></strong></td>
		<td class="tcell-right"><strong><?php echo $lang["GLOBAL_CONTENT_EDITED_BY"];?> <?php echo($phonecall->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($phonecall->checked_out_user_email);?>"><?php echo($phonecall->checked_out_user_email);?></a>, <?php echo($phonecall->checked_out_user_phone1);?></td>
    </tr>
</table>
<?php } ?>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($phonecall->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["EMPLOYEE_PHONECALL_DATE"];?></span></span></td>
		<td class="tcell-right"><input name="item_date" type="text" class="input-date datepicker item_date" value="<?php echo($phonecall->item_date)?>" /></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($phonecall->canedit) { ?>content-nav showDialogTime<?php } ?>" rel="employeesphonecallstart"><span><?php echo $lang["EMPLOYEE_PHONECALL_TIME_START"];?></span></span></td>
		<td class="tcell-right"><div id="employeesphonecallstart" class="itemlist-field"><?php echo($phonecall->start);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($phonecall->canedit) { ?>content-nav showDialogTime<?php } ?>" rel="employeesphonecallend"><span><?php echo $lang["EMPLOYEE_PHONECALL_TIME_END"];?></span></span></td>
		<td class="tcell-right"><div id="employeesphonecallend" class="itemlist-field"><?php echo($phonecall->end);?></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($phonecall->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="employeesmanagement" append="1"><span><?php echo $lang["EMPLOYEE_PHONECALL_MANAGEMENT"];?></span></span></td>
		<td class="tcell-right"><div id="employeesmanagement" class="itemlist-field"><?php echo($phonecall->management);?></div><div id="employeesmanagement_ct" class="itemlist-field"><a field="employeesmanagement_ct" class="ct-content"><?php echo($phonecall->management_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($phonecall->canedit) { ?>content-nav showDialog<?php } ?>" request="getPhonecallStatusDialog" field="employeesstatus" append="1"><span><?php echo $lang["EMPLOYEE_PHONECALL_TYPE"];?></span></span></td>
        <td class="tcell-right"><div id="employeesphonecall_status" class="itemlist-field"><div class="listmember" field="employeesphonecall_status" uid="<?php echo($phonecall->status);?>" style="float: left"><?php echo($phonecall->status_text);?></div></div><input name="phonecall_status_date" type="text" class="input-date datepicker phonecall_status_date" value="<?php echo($phonecall->status_date)?>" style="float: left; margin-left: 8px;" /></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($phonecall->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["EMPLOYEE_PHONECALL_GOALS"];?></span></span></td>
    <td class="tcell-right"><?php if($phonecall->canedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($phonecall->protocol));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($phonecall->protocol)));?><?php } ?></td>
  </tr>
</table>
<?php if($phonecall->perms != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($phonecall->canedit) { ?>content-nav showDialog<?php } ?>" request="getDocumentsDialog" field="employeesdocuments" append="1"><span><?php echo $lang["EMPLOYEE_DOCUMENT_DOCUMENTS"];?></span></span></td>
    <td class="tcell-right"><div id="employeesdocuments" class="itemlist-field"><?php echo($phonecall->documents);?></div></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($phonecall->canedit) { ?>content-nav showDialog<?php } ?>" request="getAccessDialog" field="employeesphonecall_access" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></span></td>
        <td class="tcell-right"><div id="employeesphonecall_access" class="itemlist-field"><div class="listmember" field="employeesphonecall_access" uid="<?php echo($phonecall->access);?>" style="float: left"><?php echo($phonecall->access_text);?></div></div><input type="hidden" name="phonecall_access_orig" value="<?php echo($phonecall->access);?>" /></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="employeesphonecall_sendto">
        <?php 
			foreach($sendto as $value) { 
				if(!empty($value->who)) {
					echo '<div class="text11 toggleSendTo co-link">' . $value->who . ', ' . $value->date . '</div>' .
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
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($phonecall->edited_user.", ".$phonecall->edited_date)?></td>
    <td class="middle"><?php echo $phonecall->access_footer;?></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($phonecall->created_user.", ".$phonecall->created_date);?></td>
  </tr>
</table>
</div>
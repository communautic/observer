<div class="table-title-outer">

<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["EMPLOYEE_TITLE"];?></span></span></td>
    <td class="tcell-right"><?php if($employee->canedit) { ?><input name="title" type="hidden" class="title textarea-title" value="<?php echo($employee->title);?>" maxlength="100" /><?php } ?><div class="textarea-title"><?php echo($employee->title);?></div></td>
  </tr>
  <tr class="table-title-status">
    <td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_STATUS"];?></td>
    <td colspan="2"><div class="statusTabs">
    	<ul>
        	<li><span class="left<?php if($employee->canedit) { ?> statusButton<?php } ?> planned<?php echo $employee->status_planned_active;?>" rel="0" reltext="<?php echo $lang["GLOBAL_STATUS_TRIAL_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_TRIAL"];?></span></li>
            <li><span class="<?php if($employee->canedit) { ?>statusButton <?php } ?>inprogress<?php echo $employee->status_inprogress_active;?>" rel="1" reltext="<?php echo $lang["GLOBAL_STATUS_ACTIVE_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_ACTIVE"];?></span></li>
            <li><span class="<?php if($employee->canedit) { ?>statusButton <?php } ?>finished<?php echo $employee->status_finished_active;?>" rel="2" reltext="<?php echo $lang["GLOBAL_STATUS_MATERNITYLEAVE_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_MATERNITYLEAVE"];?></span></li>
            <li><span class="right<?php if($employee->canedit) { ?> statusButton<?php } ?> stopped<?php echo $employee->status_stopped_active;?>" rel="3" reltext="<?php echo $lang["GLOBAL_STATUS_LEAVE_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_LEAVE"];?></span></li>
            <li><div class="status-time"><?php echo($employee->status_text_time)?></div><div class="status-input"><input name="phase_status_date" type="text" class="input-date statusdp" value="<?php echo($employee->status_date)?>" readonly="readonly" /></div></li>
		</ul></div></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($employee->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setEmployeeDetails">
<input type="hidden" name="id" value="<?php echo($employee->id);?>">
<?php if($employee->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span>Warnung</span></span></strong></td>
		<td class="tcell-right"><strong>Dieser Inhaltsbereich wird aktuell bearbeitet von: <?php echo($employee->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($employee->checked_out_user_email);?>"><?php echo($employee->checked_out_user_email);?></a>, <?php echo($employee->checked_out_user_phone1);?></td>
    </tr>
</table>
<div class="content-spacer"></div>
<?php } ?>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_DURATION"];?></td>
		<td class="tcell-right-inactive"><span id="employeeDurationStart"><?php echo($employee->startdate)?></span> - <span id="employeeDurationEnd"><?php echo($employee->enddate)?></span></td>
    </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang['EMPLOYEE_KICKOFF'];?></span></span></td>
		<td class="tcell-right"><?php if($employee->canedit) { ?><input name="startdate" type="text" class="input-date datepicker" value="<?php echo($employee->startdate)?>" /><?php } else { ?><?php echo($employee->startdate)?><?php } ?></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>content-nav showDialog<?php } ?>" request="getEmployeeFolderDialog" field="employeesfolder" append="1"><span><?php echo $lang["EMPLOYEE_FOLDER"];?></span></span></td>
        <td class="tcell-right"><div id="employeesfolder" class="itemlist-field"><?php echo($employee->folder);?></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="employeesordered_by" append="0"><span><?php echo $lang["EMPLOYEE_CLIENT"];?></span></span></td>
	  <td class="tcell-right"><div id="employeesordered_by" class="itemlist-field"><?php echo($employee->ordered_by);?></div><div id="employeesordered_by_ct" class="itemlist-field"><a field="employeesordered_by_ct" class="ct-content"><?php echo($employee->ordered_by_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="employeesmanagement" append="1"><span><?php echo $lang["EMPLOYEE_MANAGEMENT"];?></span></span></td>
	  <td class="tcell-right"><div id="employeesmanagement" class="itemlist-field"><?php echo($employee->management);?></div><div id="employeesmanagement_ct" class="itemlist-field"><a field="employeesmanagement_ct" class="ct-content"><?php echo($employee->management_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="employeesteam" append="1"><span><?php echo $lang["EMPLOYEE_TEAM"];?></span></span></td>
    <td class="tcell-right"><div id="employeesteam" class="itemlist-field"><?php echo($employee->team);?></div><div id="employeesteam_ct" class="itemlist-field"><a field="employeesteam_ct" class="ct-content"><?php echo($employee->team_ct);?></a></div></td>
  </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>content-nav showDialog<?php } ?>" request="getEmployeeDialog" field="employeesemployee" append="0"><span><?php echo $lang["EMPLOYEE_EMPLOYEECAT"];?></span></span></td>
        <td class="tcell-right"><div id="employeesemployee" class="itemlist-field"><?php echo($employee->employee);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>content-nav showDialog<?php } ?>" request="getEmployeeMoreDialog" field="employeesemployeemore" append="0"><span><?php echo $lang["EMPLOYEE_EMPLOYEECATMORE"];?></span></span></td>
        <td class="tcell-right"><div id="employeesemployeemore" class="itemlist-field"><?php echo($employee->employee_more);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>content-nav showDialog<?php } ?>" request="getEmployeeCatDialog" field="employeesemployeecat" append="0"><span><?php echo $lang["EMPLOYEE_CAT"];?></span></span></td>
        <td class="tcell-right"><div id="employeesemployeecat" class="itemlist-field"><?php echo($employee->employee_cat);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>content-nav showDialog<?php } ?>" request="getEmployeeCatMoreDialog" field="employeesemployeecatmore" append="0"><span><?php echo $lang["EMPLOYEE_CAT_MORE"];?></span></span></td>
        <td class="tcell-right"><div id="employeesemployeecatmore" class="itemlist-field"><?php echo($employee->employee_cat_more);?></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-highlighted">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($employee->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang['EMPLOYEE_PRODUCT_NUMBER'];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($employee->canedit) { ?><input name="product" type="text" class="bg" value="<?php echo($employee->product);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $employee->product . '</span>'); } ?></td>
    <td width="110"></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-highlighted">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($employee->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang['EMPLOYEE_PRODUCT'];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($employee->canedit) { ?><input name="product_desc" type="text" class="bg" value="<?php echo($employee->product_desc);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $employee->product_desc . '</span>'); } ?></td>
    <td width="110"></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-highlighted">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($employee->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang['EMPLOYEE_CHARGE'];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($employee->canedit) { ?><input name="charge" type="text" class="bg" value="<?php echo($employee->charge);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $employee->charge . '</span>'); } ?></td>
    <td width="110"></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-highlighted">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($employee->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang['EMPLOYEE_NUMBER'];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($employee->canedit) { ?><input name="number" type="text" class="bg" value="<?php echo($employee->number);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $employee->number . '</span>'); } ?></td>
    <td width="110"></td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["EMPLOYEE_DESCRIPTION"];?></span></span></td>
        <td class="tcell-right"><?php if($employee->canedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($employee->protocol));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($employee->protocol)));?><?php } ?></td>
	</tr>
</table>
<div id="contactTabs" class="contentTabs">
	<ul class="contentTabsList">
		<li><span class="active" rel="EmployeesFirst">Privatadresse</span></li>
		<li><span rel="EmployeesSecond">Kosten</span></li>
        <li><span rel="EmployeesThird">Leistungsstatus</span></li>
	</ul>
    <div id="EmployeesTabsContent" class="contentTabsContent">
        <div id="EmployeesFirst">
			First
        </div>
        <div id="EmployeesSecond" style="display: none;">
			Second
		</div>
        <div id="EmployeesThird" style="display: none;">
			Third
        </div>
    </div>
</div>
</form>
<?php if($employee->access != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="content-nav ui-datepicker-trigger-action"><span><?php echo $lang['GLOBAL_CHECKPOINT'];?></span></span></td>
		<td class="tcell-right"><input name="checkpoint" type="text" class="input-date checkpointdp" value="<?php echo($employee->checkpoint_date);?>" readonly="readonly" /><span style="display: none;"><?php echo($employee->checkpoint);?></span></td>
	</tr>
</table>
<?php if($employee->checkpoint == 1) { $show = 'display: block'; } else { $show = 'display: none'; }?>
<div id="employeesCheckpoint" style="<?php echo $show;?>">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="content-nav selectTextarea"><span>&nbsp;</span></span></td>
        <td class="tcell-right"><textarea name="checkpoint_note" class="elastic-two"><?php echo(strip_tags($employee->checkpoint_note));?></textarea></td>
	</tr>
</table>
</div>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="employee_sendto">
        <?php 
			foreach($sendto as $value) { 
			if(!empty($value->who)) {
				echo '<div class="text11 toggleSendTo">' . $value->who . ', ' . $value->date . '</div>' .
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
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($employee->edited_user.", ".$employee->edited_date)?></td>
    <td class="middle"></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($employee->created_user.", ".$employee->created_date);?></td>
  </tr>
</table>
</div>
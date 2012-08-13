<div class="table-title-outer">
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["EMPLOYEE_OBJECTIVE_TITLE"];?></span></span></td>
    <td><input name="title" type="text" class="title textarea-title" value="<?php echo($objective->title);?>" maxlength="100" /></td>
  </tr>
  <tr class="table-title-status">
    <td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_STATUS"];?></td>
    <td colspan="2"><div class="statusTabs">
    	<ul>
        	<li><span class="left<?php if($objective->canedit) { ?> statusButton<?php } ?> planned<?php echo $objective->status_planned_active;?>" rel="0" reltext="<?php echo $lang["GLOBAL_STATUS_PLANNED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_PLANNED"];?></span></li>
            <li><span class="<?php if($objective->canedit) { ?>statusButton noDate<?php } ?> finished<?php echo $objective->status_finished_active;?>" rel="1" reltext=""><?php echo $lang["GLOBAL_STATUS_COMPLETED"];?></span></li>
            <li><span class="<?php if($objective->canedit) { ?>statusButton<?php } ?> stopped<?php echo $objective->status_stopped_active;?>" rel="2" reltext="<?php echo $lang["GLOBAL_STATUS_CANCELLED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_CANCELLED"];?></span></li>
			<li><span class="right<?php if($objective->canedit) { ?> statusButton<?php } ?> stopped<?php echo $objective->status_posponed_active;?>" rel="3" reltext="<?php echo $lang["GLOBAL_STATUS_POSPONED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_POSPONED"];?></span></li>
            <li><div class="status-time"><?php echo($objective->status_text_time)?></div><div class="status-input"><input name="objective_status_date" type="text" class="input-date statusdp" value="<?php echo($objective->status_date)?>" readonly="readonly" /></div></li>
		</ul></div></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($objective->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($objective->id);?>">
<input type="hidden" name="pid" value="<?php echo($objective->pid);?>">
<?php if($objective->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span>Warnung</span></span></strong></td>
		<td class="tcell-right"><strong>Dieser Inhaltsbereich wird aktuell bearbeitet von: <?php echo($objective->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($objective->checked_out_user_email);?>"><?php echo($objective->checked_out_user_email);?></a>, <?php echo($objective->checked_out_user_phone1);?></td>
    </tr>
</table>
<?php } ?>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["EMPLOYEE_OBJECTIVE_DATE"];?></span></span></td>
		<td class="tcell-right"><input name="item_date" type="text" class="input-date datepicker item_date" value="<?php echo($objective->item_date)?>" /></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>content-nav showDialogTime<?php } ?>" rel="employeesobjectivestart"><span><?php echo $lang["EMPLOYEE_OBJECTIVE_TIME_START"];?></span></span></td>
		<td class="tcell-right"><div id="employeesobjectivestart" class="itemlist-field"><?php echo($objective->start);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>content-nav showDialogTime<?php } ?>" rel="employeesobjectiveend"><span><?php echo $lang["EMPLOYEE_OBJECTIVE_TIME_END"];?></span></span></td>
		<td class="tcell-right"><div id="employeesobjectiveend" class="itemlist-field"><?php echo($objective->end);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialogPlace" field="employeeslocation" append="0"><span><?php echo $lang["EMPLOYEE_OBJECTIVE_PLACE"];?></span></span></td>
		<td class="tcell-right"><div id="employeeslocation" class="itemlist-field"><?php echo($objective->location);?></div><div id="employeeslocation_ct" class="itemlist-field"><a field="employeeslocation_ct" class="ct-content"><?php echo($objective->location_ct);?></a></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span href="#" class="<?php if($objective->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="employeesparticipants" append="1"><span><?php echo $lang["EMPLOYEE_OBJECTIVE_ATTENDEES"];?></span></span></td>
		<td class="tcell-right"><div id="employeesparticipants" class="itemlist-field"><?php echo($objective->participants);?></div><div id="employeesparticipants_ct" class="itemlist-field"><a field="employeesparticipants_ct" class="ct-content"><?php echo($objective->participants_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="employeesmanagement" append="1"><span><?php echo $lang["EMPLOYEE_OBJECTIVE_MANAGEMENT"];?></span></span></td>
		<td class="tcell-right"><div id="employeesmanagement" class="itemlist-field"><?php echo($objective->management);?></div><div id="employeesmanagement_ct" class="itemlist-field"><a field="employeesmanagement_ct" class="ct-content"><?php echo($objective->management_ct);?></a></div></td>
	</tr>
</table>
<div class="content-spacer"></div>

<div id="contactTabs" class="contentTabs">
	<ul class="contentTabsList">
		<li><span class="active" rel="EmployeesObjectivesFirst">MA-Zufriedenheit</span></li>
		<li><span rel="EmployeesObjectivesSecond">Leistungsbewertung</span></li>
        <li><span rel="EmployeesObjectivesThird">Zielsetzungen</span></li>
	</ul>
    <div id="EmployeesObjectivesTabsContent" class="contentTabsContent">
        <div id="EmployeesObjectivesFirst">
        	<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin">
                  <tr>
                        <td class="tcell-left-phases-tasks text11">&nbsp;</td>
                        <td class="tcell-right-nopadding">
                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-task">
                    <tr>
                        <td width="20" style="padding-top: 4px;">&nbsp;</td>
                        <td style="padding-top: 0px;">Sind Sie zufrieden mit Ihrem Aufgabengebiet?</td>
                        <td width="300"><input name="testradio" type="radio" value="1"  class="question" /><input name="testradio" type="radio" value="2"  class="question" /></td>
                
                   </tr>
                  </table>
                        </td>
                    </tr>
                </table>
                  <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
                    <tr>
                        <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>selectTextarea<?php } ?>"><span>&nbsp;</span></span></td>
                        <td class="tcell-right"><?php if($objective->canedit) { ?><textarea id="task_text_<?php echo $value->id;?>" name="task_text_<?php echo $value->id;?>" class="elastic"><?php echo strip_tags("text");?></textarea><?php } else { ?><?php echo(nl2br(strip_tags("text")));?><?php } ?></td>
                    </tr>
                </table>
            
        </div>
        <div id="EmployeesObjectivesSecond" style="display: none;">
                <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin">
                  <tr>
                        <td class="tcell-left-phases-tasks text11">&nbsp;</td>
                        <td class="tcell-right-nopadding">
                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-task">
                    <tr>
                        <td width="20" style="padding-top: 4px;">&nbsp;</td>
                        <td style="padding-top: 0px;">Sorgfalt</td>
                        <td width="300"><input name="testradio" type="radio" value="1"  class="question" /><input name="testradio" type="radio" value="2"  class="question" /></td>
                
                   </tr>
                  </table>
                        </td>
                    </tr>
                </table>
                  <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
                    <tr>
                        <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>selectTextarea<?php } ?>"><span>&nbsp;</span></span></td>
                        <td class="tcell-right"><?php if($objective->canedit) { ?><textarea id="task_text_<?php echo $value->id;?>" name="task_text_<?php echo $value->id;?>" class="elastic"><?php echo strip_tags("text");?></textarea><?php } else { ?><?php echo(nl2br(strip_tags("text")));?><?php } ?></td>
                    </tr>
                </table>
		</div>
        <div id="EmployeesObjectivesThird" style="display: none;">
			<table border="0" cellpadding="0" cellspacing="0" class="table-content addTaskTable">
                <tr>
                    <td class="tcell-left text11">
                    <span class="<?php if($objective->canedit) { ?>content-nav newItem<?php } ?>"><span><?php echo $lang["EMPLOYEE_OBJECTIVE_GOALS"];?></span></span>
                    </td>
                	<td class="tcell-right">&nbsp;</td>
                </tr>
            </table><div id="employeesobjectivetasks">
            <?php 
            foreach($task as $value) { 
                $checked = '';
                if($value->status == 1) {
                    $checked = ' checked="checked"';
                }
            include("task.php");
             } ?>
            </div>
        </div>
    </div>
</div>
<?php if($objective->perms != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>content-nav showDialog<?php } ?>" request="getDocumentsDialog" field="employeesdocuments" append="1"><span><?php echo $lang["EMPLOYEE_DOCUMENT_DOCUMENTS"];?></span></span></td>
    <td class="tcell-right"><div id="employeesdocuments" class="itemlist-field"><?php echo($objective->documents);?></div></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>content-nav showDialog<?php } ?>" request="getAccessDialog" field="employeesobjective_access" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></span></td>
        <td class="tcell-right"><div id="employeesobjective_access" class="itemlist-field"><div class="listmember" field="employeesobjective_access" uid="<?php echo($objective->access);?>" style="float: left"><?php echo($objective->access_text);?></div></div><input type="hidden" name="objective_access_orig" value="<?php echo($objective->access);?>" /></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="content-nav ui-datepicker-trigger-action"><span><?php echo $lang['GLOBAL_CHECKPOINT'];?></span></span></td>
		<td class="tcell-right"><input name="checkpoint" type="text" class="input-date checkpointdp" value="<?php echo($objective->checkpoint_date);?>" readonly="readonly" /><span style="display: none;"><?php echo($objective->checkpoint);?></span></td>
	</tr>
</table>
<?php if($objective->checkpoint == 1) { $show = 'display: block'; } else { $show = 'display: none'; }?>
<div id="employees_objectivesCheckpoint" style="<?php echo $show;?>">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="content-nav selectTextarea"><span>&nbsp;</span></span></td>
        <td class="tcell-right"><textarea name="checkpoint_note" class="elastic-two"><?php echo(strip_tags($objective->checkpoint_note));?></textarea></td>
	</tr>
</table>
</div>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="employeesobjective_sendto">
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
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($objective->edited_user.", ".$objective->edited_date)?></td>
    <td class="middle"><?php echo $objective->access_footer;?></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($objective->created_user.", ".$objective->created_date);?></td>
  </tr>
</table>
</div>
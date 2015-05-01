<div class="table-title-outer">

<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span><span><?php echo $lang["EMPLOYEE_TITLE"];?></span></span></td>
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
		<td class="tcell-left text11"><strong><span><span><?php echo $lang["GLOBAL_ALERT"];?></span></span></strong></td>
		<td class="tcell-right"><strong><?php echo $lang["GLOBAL_CONTENT_EDITED_BY"];?> <?php echo($employee->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($employee->checked_out_user_email);?>"><?php echo($employee->checked_out_user_email);?></a>, <?php echo($employee->checked_out_user_phone1);?></td>
    </tr>
</table>
<div class="content-spacer"></div>
<?php } ?>
<div style="position: absolute; top: 0; right: 15px; height: 120px; width: 80px; background-image:url(<?php echo($employee->avatar);?>); background-repeat: no-repeat"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>content-nav showDialog<?php } ?>" request="getEmployeeFolderDialog" field="employeesfolder" append="1"><span><?php echo $lang["EMPLOYEE_FOLDER"];?></span></span></td>
        <td class="tcell-right"><div id="employeesfolder" class="itemlist-field"><?php echo($employee->folder);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["EMPLOYEE_STARTDATE"];?></span></span></td>
		<td class="tcell-right"><?php if($employee->canedit) { ?><input name="startdate" type="text" class="input-date datepickerDelete" value="<?php echo($employee->startdate)?>" readonly="readonly" /><?php } else { ?><?php echo($employee->startdate)?><?php } ?></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["EMPLOYEE_ENDDATE"];?></span></span></td>
		<td class="tcell-right"><?php if($employee->canedit) { ?><input name="enddate" type="text" class="input-date datepickerDelete" value="<?php echo($employee->enddate)?>" readonly="readonly" /><?php } else { ?><?php echo($employee->enddate)?><?php } ?></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($employee->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["EMPLOYEE_NUMBER"];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($employee->canedit) { ?><input name="number" type="text" class="bg" value="<?php echo($employee->number);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $employee->number . '</span>'); } ?></td>
    
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>content-nav showDialog<?php } ?>" request="getEmployeeDialog" field="employeeskind" append="0" sql="kind"><span><?php echo $lang["EMPLOYEE_KIND"];?></span></span></td>
        <td class="tcell-right"><div id="employeeskind" class="itemlist-field"><?php echo($employee->kind);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>content-nav showDialog<?php } ?>" request="getEmployeeDialog" field="employeesarea" append="0" sql="area"><span><?php echo $lang["EMPLOYEE_AREA"];?></span></span></td>
        <td class="tcell-right"><div id="employeesarea" class="itemlist-field"><?php echo($employee->area);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>content-nav showDialog<?php } ?>" request="getEmployeeDialog" field="employeesdepartment" append="0" sql="department"><span><?php echo $lang["EMPLOYEE_DEPARTMENT"];?></span></span></td>
        <td class="tcell-right"><div id="employeesdepartment" class="itemlist-field"><?php echo($employee->department);?></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
    <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin<?php if($employee->canedit) { ?> loadContactExternal<?php } ?>" rel="<?php echo($employee->cid)?>" style="cursor: pointer;">
  <tr>
		<td class="tcell-left-inactive text11" style="padding-top: 2px;">Kontaktdaten</td>
    	<td class="tcell-right-inactive"><?php echo($employee->ctitle)?> <?php echo($employee->title2)?> <?php echo($employee->title);?><br />
        <span class="text11"><?php echo($employee->position . " &nbsp; | &nbsp; " . $lang["EMPLOYEE_CONTACT_EMAIL"] . " " . $employee->email . " &nbsp; | &nbsp; " . $lang["EMPLOYEE_CONTACT_PHONE"] . " " . $employee->phone1);?></span>
        </td>
        </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($employee->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["EMPLOYEE_DOB"];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($employee->canedit) { ?><input name="dob" type="text" class="bg" <?php if($employee->dob == "") {?> value="00.00.0000" onclick="this.value=''"<?php } else { ?> value="<?php echo($employee->dob);?>"<?php } ?> /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $employee->dob . '</span>'); } ?></td>
    
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($employee->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["EMPLOYEE_COO"];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($employee->canedit) { ?><input name="coo" type="text" class="bg" value="<?php echo($employee->coo);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $employee->coo . '</span>'); } ?></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>content-nav showDialog<?php } ?>" request="getEmployeeDialog" field="employeesfamily" append="0" sql="family"><span><?php echo $lang["EMPLOYEE_FAMILY_STATUS"];?></span></span></td>
        <td class="tcell-right"><div id="employeesfamily" class="itemlist-field"><?php echo($employee->family);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($employee->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["EMPLOYEE_CHILDREN"];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($employee->canedit) { ?><input name="protocol4" type="text" class="bg" value="<?php echo($employee->protocol4);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $employee->protocol4 . '</span>'); } ?></td>
  </tr>
</table>
<!--<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["EMPLOYEE_CHILDREN"];?></span></span></td>
        <td class="tcell-right"><?php if($employee->canedit) { ?><textarea name="protocol4" class="elastic"><?php echo(strip_tags($employee->protocol4));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($employee->protocol4)));?><?php } ?></td>
	</tr>
</table>-->
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($employee->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["EMPLOYEE_LANGUAGES"];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($employee->canedit) { ?><input name="languages" type="text" class="bg" value="<?php echo($employee->languages);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $employee->languages . '</span>'); } ?></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($employee->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["EMPLOYEE_FOREIGN_LANGUAGES"];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($employee->canedit) { ?><input name="languages_foreign" type="text" class="bg" value="<?php echo($employee->languages_foreign);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $employee->languages_foreign . '</span>'); } ?></td>
  </tr>
</table>

<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["EMPLOYEE_DESCRIPTION"];?></span></span></td>
        <td class="tcell-right"><?php if($employee->canedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($employee->protocol));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($employee->protocol)));?><?php } ?></td>
	</tr>
</table>


<div class="content-spacer"></div>
<div id="contactTabs" class="contentTabs grey">
	<ul class="contentTabsList">
		<li><span class="active" rel="EmployeesFirst">Privatadresse</span></li>
		<li><span rel="EmployeesSecond">Kompetenz</span></li>
        <li><span rel="EmployeesThird">Leistungsstatus</span></li>
	</ul>
    <div id="EmployeesTabsContent" class="contentTabsContent">
        <div id="EmployeesFirst">
			<table border="0" cellspacing="0" cellpadding="0" class="table-content">
              <tr>
                <td class="tcell-left-shorter text11"><span class="<?php if($employee->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["EMPLOYEE_PRIVATE_STREET"];?></span></span></td>
                <td class="tcell-right-nopadding"><?php if($employee->canedit) { ?><input name="street_private" type="text" class="bg" value="<?php echo($employee->street_private);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $employee->street_private . '</span>'); } ?></td>
                
              </tr>
            </table>
            <table border="0" cellspacing="0" cellpadding="0" class="table-content">
              <tr>
                <td class="tcell-left-shorter text11"><span class="<?php if($employee->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["EMPLOYEE_PRIVATE_CITY"];?></span></span></td>
                <td class="tcell-right-nopadding"><?php if($employee->canedit) { ?><input name="city_private" type="text" class="bg" value="<?php echo($employee->city_private);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $employee->city_private . '</span>'); } ?></td>
                
              </tr>
            </table>
            <table border="0" cellspacing="0" cellpadding="0" class="table-content">
              <tr>
                <td class="tcell-left-shorter text11"><span class="<?php if($employee->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["EMPLOYEE_PRIVATE_ZIP"];?></span></span></td>
                <td class="tcell-right-nopadding"><?php if($employee->canedit) { ?><input name="zip_private" type="text" class="bg" value="<?php echo($employee->zip_private);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $employee->zip_private . '</span>'); } ?></td>
                
              </tr>
            </table>
            <table border="0" cellspacing="0" cellpadding="0" class="table-content">
              <tr>
                <td class="tcell-left-shorter text11"><span class="<?php if($employee->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["EMPLOYEE_PRIVATE_PHONE"];?></span></span></td>
                <td class="tcell-right-nopadding"><?php if($employee->canedit) { ?><input name="phone_private" type="text" class="bg" value="<?php echo($employee->phone_private);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $employee->phone_private . '</span>'); } ?></td>
                
              </tr>
            </table>
            <table border="0" cellspacing="0" cellpadding="0" class="table-content">
              <tr>
                <td class="tcell-left-shorter text11"><span class="<?php if($employee->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["EMPLOYEE_PRIVATE_EMAIL"];?></span></span></td>
                <td class="tcell-right-nopadding"><?php if($employee->canedit) { ?><input name="email_private" type="text" class="bg" value="<?php echo($employee->email_private);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $employee->email_private . '</span>'); } ?></td>
              </tr>
            </table>
            <div class="content-spacer"></div>
        </div>
        <div id="EmployeesSecond" style="display: none;">
            <table border="0" cellspacing="0" cellpadding="0" class="table-content">
                <tr>
                  <td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>content-nav showDialog<?php } ?>" request="getEmployeeDialog" field="employeeseducation" append="0" sql="edu"><span><?php echo $lang["EMPLOYEE_EDUCATION"];?></span></span></td>
                    <td class="tcell-right"><div id="employeeseducation" class="itemlist-field"><?php echo($employee->education);?></div></td>
                </tr>
            </table>
            <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>selectTextarea<?php } ?>"><span>&nbsp;</span></span></td>
        <td class="tcell-right"><?php if($employee->canedit) { ?><textarea name="protocol5" class="elastic"><?php echo(strip_tags($employee->protocol5));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($employee->protocol5)));?><?php } ?></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["EMPLOYEE_EXPERIENCE_EXTERNAL"];?></span></span></td>
        <td class="tcell-right"><?php if($employee->canedit) { ?><textarea name="protocol6" class="elastic"><?php echo(strip_tags($employee->protocol6));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($employee->protocol6)));?><?php } ?></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["EMPLOYEE_EXPERIENCE"];?></span></span></td>
        <td class="tcell-right"><?php if($employee->canedit) { ?><textarea name="protocol3" class="elastic"><?php echo(strip_tags($employee->protocol3));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($employee->protocol3)));?><?php } ?></td>
	</tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($employee->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["EMPLOYEE_EDUCATION_ADDITIONAL"];?></span></span></td>
        <td class="tcell-right"><?php if($employee->canedit) { ?><textarea name="protocol2" class="elastic"><?php echo(strip_tags($employee->protocol2));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($employee->protocol2)));?><?php } ?></td>
	</tr>
</table>
<?php if($trainig_display) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11">Trainingsteilnahmen</td>
        <td class="tcell-right-inactive tcell-right-nopadding text11"><?php 
		if(!empty($trainings)) {
			foreach($trainings as $training) {
				echo '<div><span class="externalLoadThreeLevels co-link" rel="trainings,' . $training->folder . ',' . $training->trainingid . ',0,trainings">' . $training->title . ' &nbsp; | &nbsp; ' . $training->dates_display  . ' &nbsp; | &nbsp; ' . $lang["TRAINING_COSTS"] . ' ' . $training->costs  . ' &nbsp; | &nbsp; Feedback ' . $training->total_result . '%</span></div>';
			}
		}
		?></td>
	</tr>
</table>
<div class="content-spacer"></div>
<?php } ?>
		</div>
        <div id="EmployeesThird" style="display: none;">
			<?php $this->getChartPerformance($employee->id,'happiness');
			$this->getChartPerformance($employee->id,'performance');
			$this->getChartPerformance($employee->id,'goals');
			$this->getChartPerformance($employee->id,'totals');
			?>
            <div style="clear: both;"></div>
            <div class="content-spacer"></div>
            <table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11">Leistungsarchiv</td>
        <td class="tcell-right-inactive tcell-right-nopadding text11"><?php 
		if(!empty($leistungen)) {
			$i = 0;
			foreach($leistungen as $leistung) {
				if($i != 0) {
				echo '<div><span class="externalLoadThreeLevels co-link" rel="objectives,' . $employee->folder_id . ',' . $employee->id . ',' . $leistung->id . ',employees">' . $leistung->item_date . ', ' . $leistung->title . ' (' . $leistung->total . '%)</span></div>';
				}
			$i++;
			}
		}
		?></td>
	</tr>
</table>
<div class="content-spacer"></div>
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
		<td class="tcell-left text11"><span class="selectTextarea"><span>&nbsp;</span></span></td>
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
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($employee->edited_user.", ".$employee->edited_date)?></td>
    <td class="middle"></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($employee->created_user.", ".$employee->created_date);?></td>
  </tr>
</table>
</div>
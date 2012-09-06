<div class="table-title-outer">

<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span><span><?php echo $lang["PATIENT_TITLE"];?></span></span></td>
    <td class="tcell-right"><?php if($patient->canedit) { ?><input name="title" type="hidden" class="title textarea-title" value="<?php echo($patient->title);?>" maxlength="100" /><?php } ?><div class="textarea-title"><?php echo($patient->title);?></div></td>
  </tr>
  <tr class="table-title-status">
    <td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_STATUS"];?></td>
    <td colspan="2"><div class="statusTabs">
    	<ul>
        	<li><span class="left<?php if($patient->canedit) { ?> statusButton<?php } ?> planned<?php echo $patient->status_planned_active;?>" rel="0" reltext="<?php echo $lang["GLOBAL_STATUS_TRIAL_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_TRIAL"];?></span></li>
            <li><span class="<?php if($patient->canedit) { ?>statusButton <?php } ?>inprogress<?php echo $patient->status_inprogress_active;?>" rel="1" reltext="<?php echo $lang["GLOBAL_STATUS_ACTIVE_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_ACTIVE"];?></span></li>
            <li><span class="<?php if($patient->canedit) { ?>statusButton <?php } ?>finished<?php echo $patient->status_finished_active;?>" rel="2" reltext="<?php echo $lang["GLOBAL_STATUS_MATERNITYLEAVE_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_MATERNITYLEAVE"];?></span></li>
            <li><span class="right<?php if($patient->canedit) { ?> statusButton<?php } ?> stopped<?php echo $patient->status_stopped_active;?>" rel="3" reltext="<?php echo $lang["GLOBAL_STATUS_LEAVE_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_LEAVE"];?></span></li>
            <li><div class="status-time"><?php echo($patient->status_text_time)?></div><div class="status-input"><input name="phase_status_date" type="text" class="input-date statusdp" value="<?php echo($patient->status_date)?>" readonly="readonly" /></div></li>
		</ul></div></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($patient->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setPatientDetails">
<input type="hidden" name="id" value="<?php echo($patient->id);?>">
<?php if($patient->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span>Warnung</span></span></strong></td>
		<td class="tcell-right"><strong>Dieser Inhaltsbereich wird aktuell bearbeitet von: <?php echo($patient->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($patient->checked_out_user_email);?>"><?php echo($patient->checked_out_user_email);?></a>, <?php echo($patient->checked_out_user_phone1);?></td>
    </tr>
</table>
<div class="content-spacer"></div>
<?php } ?>
<div style="position: absolute; top: 0; right: 15px; height: 120px; width: 80px; background-image:url(<?php echo($patient->avatar);?>); background-repeat: no-repeat"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($patient->canedit) { ?>content-nav showDialog<?php } ?>" request="getPatientFolderDialog" field="patientsfolder" append="1"><span><?php echo $lang["PATIENT_FOLDER"];?></span></span></td>
        <td class="tcell-right"><div id="patientsfolder" class="itemlist-field"><?php echo($patient->folder);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($patient->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["PATIENT_STARTDATE"];?></span></span></td>
		<td class="tcell-right"><?php if($patient->canedit) { ?><input name="startdate" type="text" class="input-date datepickerDelete" value="<?php echo($patient->startdate)?>" readonly="readonly" /><?php } else { ?><?php echo($patient->startdate)?><?php } ?></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($patient->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["PATIENT_ENDDATE"];?></span></span></td>
		<td class="tcell-right"><?php if($patient->canedit) { ?><input name="enddate" type="text" class="input-date datepickerDelete" value="<?php echo($patient->enddate)?>" readonly="readonly" /><?php } else { ?><?php echo($patient->enddate)?><?php } ?></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($patient->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["PATIENT_NUMBER"];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($patient->canedit) { ?><input name="number" type="text" class="bg" value="<?php echo($patient->number);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $patient->number . '</span>'); } ?></td>
    
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($patient->canedit) { ?>content-nav showDialog<?php } ?>" request="getPatientDialog" field="patientskind" append="0" sql="kind"><span><?php echo $lang["PATIENT_KIND"];?></span></span></td>
        <td class="tcell-right"><div id="patientskind" class="itemlist-field"><?php echo($patient->kind);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($patient->canedit) { ?>content-nav showDialog<?php } ?>" request="getPatientDialog" field="patientsarea" append="0" sql="area"><span><?php echo $lang["PATIENT_AREA"];?></span></span></td>
        <td class="tcell-right"><div id="patientsarea" class="itemlist-field"><?php echo($patient->area);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($patient->canedit) { ?>content-nav showDialog<?php } ?>" request="getPatientDialog" field="patientsdepartment" append="0" sql="department"><span><?php echo $lang["PATIENT_DEPARTMENT"];?></span></span></td>
        <td class="tcell-right"><div id="patientsdepartment" class="itemlist-field"><?php echo($patient->department);?></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
    <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin loadContactExternal" rel="<?php echo($patient->cid)?>" style="cursor: pointer;">
  <tr>
		<td class="tcell-left-inactive text11" style="padding-top: 2px;">Kontaktdaten</td>
    	<td class="tcell-right-inactive"><?php echo($patient->ctitle)?> <?php echo($patient->title2)?> <?php echo($patient->title);?><br />
        <span class="text11"><?php echo($patient->position . " &nbsp; | &nbsp; " . $lang["PATIENT_CONTACT_EMAIL"] . " " . $patient->email . " &nbsp; | &nbsp; " . $lang["PATIENT_CONTACT_PHONE"] . " " . $patient->phone1);?></span>
        </td>
        </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($patient->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["PATIENT_DOB"];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($patient->canedit) { ?><input name="dob" type="text" class="bg" <?php if($patient->dob == "") {?> value="00.00.0000" onclick="this.value=''"<?php } else { ?> value="<?php echo($patient->dob);?>"<?php } ?> /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $patient->dob . '</span>'); } ?></td>
    
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($patient->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["PATIENT_COO"];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($patient->canedit) { ?><input name="coo" type="text" class="bg" value="<?php echo($patient->coo);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $patient->coo . '</span>'); } ?></td>
    
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($patient->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["PATIENT_LANGUAGES"];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($patient->canedit) { ?><input name="languages" type="text" class="bg" value="<?php echo($patient->languages);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $patient->languages . '</span>'); } ?></td>
    
  </tr>
</table>

<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($patient->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["PATIENT_DESCRIPTION"];?></span></span></td>
        <td class="tcell-right"><?php if($patient->canedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($patient->protocol));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($patient->protocol)));?><?php } ?></td>
	</tr>
</table>
</form>
<?php if($patient->access != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="content-nav ui-datepicker-trigger-action"><span><?php echo $lang['GLOBAL_CHECKPOINT'];?></span></span></td>
		<td class="tcell-right"><input name="checkpoint" type="text" class="input-date checkpointdp" value="<?php echo($patient->checkpoint_date);?>" readonly="readonly" /><span style="display: none;"><?php echo($patient->checkpoint);?></span></td>
	</tr>
</table>
<?php if($patient->checkpoint == 1) { $show = 'display: block'; } else { $show = 'display: none'; }?>
<div id="patientsCheckpoint" style="<?php echo $show;?>">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="content-nav selectTextarea"><span>&nbsp;</span></span></td>
        <td class="tcell-right"><textarea name="checkpoint_note" class="elastic-two"><?php echo(strip_tags($patient->checkpoint_note));?></textarea></td>
	</tr>
</table>
</div>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="patient_sendto">
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
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($patient->edited_user.", ".$patient->edited_date)?></td>
    <td class="middle"></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($patient->created_user.", ".$patient->created_date);?></td>
  </tr>
</table>
</div>
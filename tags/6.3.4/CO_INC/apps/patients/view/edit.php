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
        	<li><span class="left<?php if($patient->canedit) { ?> statusButton<?php } ?> planned<?php echo $patient->status_planned_active;?>" rel="0" reltext="<?php echo $lang["PATIENT_STATUS_PLANNED_TIME"];?>"><?php echo $lang["PATIENT_STATUS_PLANNED"];?></span></li>
            <li><span class="<?php if($patient->canedit) { ?>statusButton <?php } ?>finished<?php echo $patient->status_finished_active;?>" rel="1" reltext="<?php echo $lang["PATIENT_STATUS_FINISHED_TIME"];?>"><?php echo $lang["PATIENT_STATUS_FINISHED"];?></span></li>
            <li><span class="right<?php if($patient->canedit) { ?> statusButton<?php } ?> stopped<?php echo $patient->status_stopped_active;?>" rel="2" reltext="<?php echo $lang["PATIENT_STATUS_STOPPED_TIME"];?>"><?php echo $lang["PATIENT_STATUS_STOPPED"];?></span></li>
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
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($patient->canedit) { ?>content-nav showDialog<?php } ?>" request="getPatientFolderDialog" field="patientsfolder" append="1"><span><?php echo $lang["PATIENT_FOLDER"];?></span></span></td>
        <td class="tcell-right"><div id="patientsfolder" class="itemlist-field"><?php echo($patient->folder);?></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($patient->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="patientsmanagement" append="1"><span><?php echo $lang["PATIENT_MANAGEMENT"];?></span></span></td>
	  <td class="tcell-right"><div id="patientsmanagement" class="itemlist-field"><?php echo($patient->management);?></div><div id="patientsmanagement_ct" class="itemlist-field"><a field="patientsmanagement_ct" class="ct-content"><?php echo($patient->management_ct);?></a></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
    <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin loadContactExternal" rel="<?php echo($patient->cid)?>" style="cursor: pointer;">
  <tr>
		<td class="tcell-left-inactive text11" style="padding-top: 2px;"><?php echo $lang["PATIENT_CONTACT_DETAILS"];?></td>
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
	  <td class="tcell-left text11"><span class="<?php if($patient->canedit) { ?>content-nav showDialog<?php } ?>" request="getPatientDialog" field="patientsinsurance" append="0" sql="insurance"><span><?php echo $lang["PATIENT_INSURANCE"];?></span></span></td>
        <td class="tcell-right"><div id="patientsinsurance" class="itemlist-field"><?php echo($patient->insurance);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($patient->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["PATIENT_INSURANCE_NUMBER"];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($patient->canedit) { ?><input name="number" type="text" class="bg" value="<?php echo($patient->number);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $patient->number . '</span>'); } ?></td>
    
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
		<td class="tcell-left text11"><span class="selectTextarea"><span>&nbsp;</span></span></td>
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
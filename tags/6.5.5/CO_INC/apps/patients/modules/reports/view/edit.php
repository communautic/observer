<div class="table-title-outer">

<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($report->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["PATIENT_REPORT_TITLE"];?></span></span></td>
    <td><input name="title" type="text" class="title textarea-title" value="<?php echo($report->title);?>" maxlength="100" /></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($report->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" id="patients-right-report-id" name="id" value="<?php echo($report->id);?>">
<input type="hidden" name="pid" value="<?php echo($report->pid);?>">
<input type="hidden" name="tid" class="tid" value="<?php echo($report->tid);?>">
<?php if($report->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span><?php echo $lang["GLOBAL_ALERT"];?></span></span></strong></td>
		<td class="tcell-right"><strong><?php echo $lang["GLOBAL_CONTENT_EDITED_BY"];?> <?php echo($report->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($report->checked_out_user_email);?>"><?php echo($report->checked_out_user_email);?></a>, <?php echo($report->checked_out_user_phone1);?></td>
    </tr>
</table>
<?php } 

if($report->tid == 0) {
?>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($report->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["PATIENT_REPORT_DATE"];?></span></span></td>
		<td class="tcell-right"><input name="item_date" type="text" class="input-date datepicker item_date" value="<?php echo($report->item_date)?>" readonly="readonly" /></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($report->canedit) { ?>content-nav showDialog<?php } ?>" request="getReportsTreatmentsDialog" field="reportstreatment" sql="<?php echo($report->pid);?>" append="1"><span><?php echo $lang["PATIENT_REPORT_TREATMENT"];?></span></span></td>
        <td class="tcell-right"><div id="reportstreatment" class="itemlist-field"><?php //echo($report->treatment);?></div></td>
	</tr>
</table>

<?php } else { ?>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($report->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["PATIENT_REPORT_DATE"];?></span></span></td>
		<td class="tcell-right"><input name="item_date" type="text" class="input-date datepicker item_date" value="<?php echo($report->item_date)?>" readonly="readonly" /></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left-inactive text11"><?php echo $lang["PATIENT_REPORT_TREATMENT"];?></td>
        <td class="tcell-right-inactive"><div id="reportstreatment" class="itemlist-field"><?php echo($report->treatment_title);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11">Patient</td>
		<td class="tcell-right-inactive"><span id="patients_treatmentstartdate"></span><?php echo($report->treatment_patient)?><span id="patients_treatmentenddate"></span>
        </td>
    </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PATIENT_REPORT_DOCTOR_DIAGNOSE"];?></td>
		<td class="tcell-right-inactive"><span id="patients_treatmentstartdate"></span><?php echo($report->treatment_diagnose)?><span id="patients_treatmentenddate"></span>
        </td>
    </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PATIENT_REPORT_TREATMENT_DATE"];?></td>
		<td class="tcell-right-inactive"><span id="patients_treatmentstartdate"></span><?php echo($report->treatment_date)?><span id="patients_treatmentenddate"></span>
        </td>
    </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PATIENT_REPORT_MANAGEMENT"];?></td>
		<td class="tcell-right-inactive"><span id="patients_treatmentstartdate"></span><?php echo($report->treatment_management)?><span id="patients_treatmentenddate"></span>
        </td>
    </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PATIENT_REPORT_DOCTOR"];?></td>
		<td class="tcell-right-inactive"><span id="patients_treatmentstartdate"></span><?php echo($report->treatment_doctor)?><span id="patients_treatmentenddate"></span>
        </td>
    </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PATIENT_REPORT_PROTOCOL2"];?></td>
		<td class="tcell-right-inactive"><span id="patients_treatmentstartdate"></span><?php echo($report->treatment_treats)?><span id="patients_treatmentenddate"></span>
        </td>
    </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($report->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["PATIENT_REPORT_TEXTFIELD1"];?></span></span></td>
    <td class="tcell-right"><?php if($report->canedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($report->protocol));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($report->protocol)));?><?php } ?></td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($report->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["PATIENT_REPORT_TEXTFIELD2"];?></span></span></td>
    <td class="tcell-right"><?php if($report->canedit) { ?><textarea name="protocol2" class="elastic"><?php echo(strip_tags($report->protocol2));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($report->protocol2)));?><?php } ?></td>
  </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($report->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["PATIENT_REPORT_FEEDBACK"];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($report->canedit) { ?><input name="feedback" type="text" class="bg" value="<?php echo($report->feedback);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $report->feedback . '</span>'); } ?></td>
  </tr>
</table>
<?php if($report->perms != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($report->canedit) { ?>content-nav showDialog<?php } ?>" request="getDocumentsDialog" field="patientsdocuments" append="1"><span><?php echo $lang["PATIENT_DOCUMENT_DOCUMENTS"];?></span></span></td>
    <td class="tcell-right"><div id="patientsdocuments" class="itemlist-field"><?php echo($report->documents);?></div></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($report->canedit) { ?>content-nav showDialog<?php } ?>" request="getAccessDialog" field="patientsreport_access" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></span></td>
        <td class="tcell-right"><div id="patientsreport_access" class="itemlist-field"><div class="listmember" field="patientsreport_access" uid="<?php echo($report->access);?>" style="float: left"><?php echo($report->access_text);?></div></div><input type="hidden" name="report_access_orig" value="<?php echo($report->access);?>" /></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="patientsreport_sendto">
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
<?php } 
} ?>
</form>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($report->edited_user.", ".$report->edited_date)?></td>
    <td class="middle"><?php echo $report->access_footer;?></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($report->created_user.", ".$report->created_date);?></td>
  </tr>
</table>
</div>
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
<input type="hidden" name="id" value="<?php echo($report->id);?>">
<input type="hidden" name="pid" value="<?php echo($report->pid);?>">
<?php if($report->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span>Warnung</span></span></strong></td>
		<td class="tcell-right"><strong>Dieser Inhaltsbereich wird aktuell bearbeitet von: <?php echo($report->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($report->checked_out_user_email);?>"><?php echo($report->checked_out_user_email);?></a>, <?php echo($report->checked_out_user_phone1);?></td>
    </tr>
</table>
<?php } ?>

<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($report->canedit) { ?>content-nav showDialog<?php } ?>" request="getReportsTreatmentsDialog" field="reportstreatment" append="1"><span><?php echo $lang["PATIENT_REPORT_TREATMENT"];?></span></span></td>
        <td class="tcell-right"><div id="reportstreatment" class="itemlist-field"><?php //echo($report->treatment);?></div></td>
	</tr>
</table>



<!--
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($report->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["PATIENT_REPORT_DATE"];?></span></span></td>
		<td class="tcell-right"><input name="item_date" type="text" class="input-date datepicker item_date" value="<?php echo($report->item_date)?>" /></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($report->canedit) { ?>content-nav showDialogTime<?php } ?>" rel="patientsreportstart"><span><?php echo $lang["PATIENT_REPORT_TIME_START"];?></span></span></td>
		<td class="tcell-right"><div id="patientsreportstart" class="itemlist-field"><?php echo($report->start);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($report->canedit) { ?>content-nav showDialogTime<?php } ?>" rel="patientsreportend"><span><?php echo $lang["PATIENT_REPORT_TIME_END"];?></span></span></td>
		<td class="tcell-right"><div id="patientsreportend" class="itemlist-field"><?php echo($report->end);?></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($report->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="patientsmanagement" append="1"><span><?php echo $lang["PATIENT_REPORT_MANAGEMENT"];?></span></span></td>
		<td class="tcell-right"><div id="patientsmanagement" class="itemlist-field"><?php echo($report->management);?></div><div id="patientsmanagement_ct" class="itemlist-field"><a field="patientsmanagement_ct" class="ct-content"><?php echo($report->management_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($report->canedit) { ?>content-nav showDialog<?php } ?>" request="getReportStatusDialog" field="patientsstatus" append="1"><span><?php echo $lang["PATIENT_REPORT_TYPE"];?></span></span></td>
        <td class="tcell-right"><div id="patientsreport_status" class="itemlist-field"><div class="listmember" field="patientsreport_status" uid="<?php echo($report->status);?>" style="float: left"><?php echo($report->status_text);?></div></div><input name="report_status_date" type="text" class="input-date datepicker report_status_date" value="<?php echo($report->status_date)?>" style="float: left; margin-left: 8px;" /></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($report->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["PATIENT_REPORT_GOALS"];?></span></span></td>
    <td class="tcell-right"><?php if($report->canedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($report->protocol));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($report->protocol)));?><?php } ?></td>
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
					echo '<div class="text11 toggleSendTo">' . $value->who . ', ' . $value->date . '</div>' .
						 '<div class="SendToContent">' . $lang["GLOBAL_SUBJECT"] . ': ' . $value->subject . '<br /><br />' . nl2br($value->body) . '<br></div>';
				}
		 } ?></div>
        </td>
    </tr>
</table>
<?php } ?>
-->
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
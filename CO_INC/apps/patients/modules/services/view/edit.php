<div class="table-title-outer">
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($service->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["PATIENT_SERVICE_TITLE"];?></span></span></td>
    <td><input name="title" type="text" class="title textarea-title" value="<?php echo($service->title);?>" maxlength="100" /></td>
  </tr>
  <tr class="table-title-status">
    <td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_STATUS"];?></td>
    <td colspan="2"><div class="statusTabs">
    	<ul>
        	<li><span class="left<?php if($service->canedit) { ?> statusButton<?php } ?> planned<?php echo $service->status_planned_active;?>" rel="0" reltext="<?php echo $lang["GLOBAL_STATUS_INPREPARATION_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_INPREPARATION"];?></span></li>
            <li><span class="<?php if($service->canedit) { ?>statusButton noDate<?php } ?> inprogress<?php echo $service->status_inprogress_active;?>" rel="1" reltext=""><?php echo $lang["GLOBAL_STATUS_INPROGRESS"];?></span></li>
            <li><span class="<?php if($service->canedit) { ?>statusButton<?php } ?> finished<?php echo $service->status_finished_active;?>" rel="2" reltext="<?php echo $lang["GLOBAL_STATUS_FINISHED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_FINISHED"];?></span></li>
			<li><span class="right<?php if($service->canedit) { ?> statusButton<?php } ?> stopped<?php echo $service->status_stopped_active;?>" rel="3" reltext="<?php echo $lang["GLOBAL_STATUS_STOPPED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_STOPPED"];?></span></li>
            <li><div class="status-time"><?php echo($service->status_text_time)?></div><div class="status-input"><input name="service_status_date" type="text" class="input-date statusdp" value="<?php echo($service->status_date)?>" readonly="readonly" /></div></li>
		</ul></div></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($service->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($service->id);?>">
<input type="hidden" name="pid" value="<?php echo($service->pid);?>">
<?php if($service->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span><?php echo $lang["GLOBAL_ALERT"];?></span></span></strong></td>
		<td class="tcell-right"><strong><?php echo $lang["GLOBAL_CONTENT_EDITED_BY"];?> <?php echo($service->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($service->checked_out_user_email);?>"><?php echo($service->checked_out_user_email);?></a>, <?php echo($service->checked_out_user_phone1);?></td>
    </tr>
</table>
<?php } ?>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left-inactive text11"><span><span><?php echo $lang["PATIENT_SERVICE_AMOUNT"];?></span></span></td>
    <td class="tcell-right-inactive"><?php echo CO_DEFAULT_CURRENCY;?> <span id="totalcosts"><?php echo $service->totalcosts;?></span></td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($service->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["PATIENT_SERVICE_DISCOUNT"];?> (%)</span></span></td>
    <td class="tcell-right-nopadding"><?php if($service->canedit) { ?><input id="discount" name="discount" type="text" class="bg" value="<?php echo($service->discount);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $service->discount . '</span>'); } ?></td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($service->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["PATIENT_SERVICE_VAT"];?> (%)</span></span></td>
    <td class="tcell-right-nopadding"><?php if($service->canedit) { ?><input id="vat" name="vat" type="text" class="bg" value="<?php echo($service->vat);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $service->vat . '</span>'); } ?></td>
  </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content addTaskTable">
	<tr>
		<td class="tcell-left text11">
        <span class="<?php if($service->canedit) { ?>content-nav newItem<?php } ?>"><span><?php echo $lang["PATIENT_SERVICE_TASK_NEW"];?></span></span>
        </td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table><div id="patientsservicetasks" class="outerSortable">
<?php 
foreach($task as $value) { 
	$checked = '';
	if($value->status == 1) {
		$checked = ' checked="checked"';
	}
include("task.php");
 } ?>
</div>
<?php if($service->perms != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($service->canedit) { ?>content-nav showDialog<?php } ?>" request="getDocumentsDialog" field="patientsdocuments" append="1"><span><?php echo $lang["PATIENT_DOCUMENT_DOCUMENTS"];?></span></span></td>
    <td class="tcell-right"><div id="patientsdocuments" class="itemlist-field"><?php echo($service->documents);?></div></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($service->canedit) { ?>content-nav showDialog<?php } ?>" request="getAccessDialog" field="patientsservice_access" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></span></td>
        <td class="tcell-right"><div id="patientsservice_access" class="itemlist-field"><div class="listmember" field="patientsservice_access" uid="<?php echo($service->access);?>" style="float: left"><?php echo($service->access_text);?></div></div><input type="hidden" name="service_access_orig" value="<?php echo($service->access);?>" /></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="patientsservice_sendto">
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
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($service->edited_user.", ".$service->edited_date)?></td>
    <td class="middle"><?php echo $service->access_footer;?></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($service->created_user.", ".$service->created_date);?></td>
  </tr>
</table>
</div>
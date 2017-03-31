<div class="table-title-outer">
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($treatment->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["PATIENT_TREATMENT_TITLE"];?></span></span></td>
    <td><?php if($treatment->canedit) { ?><input name="title" type="text" class="title textarea-title" value="<?php echo($treatment->title);?>" maxlength="100" /><?php } else { ?><div class="textarea-title"><?php echo($treatment->title);?><input style="display: none" name="title" type="text" class="title textarea-title" value="<?php echo($treatment->title);?>" maxlength="100" /></div><?php } ?></td>
  </tr>
  <tr class="table-title-status">
    <td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_STATUS"];?></td>
    <td colspan="2"><div class="statusTabs">
    	<ul>
        	<li><span class="left<?php if($treatment->canedit) { ?> statusButton noDate<?php } ?> planned<?php echo $treatment->status_planned_active;?>" rel="0" reltext=""><?php echo $lang["PATIENT_TREATMENT_STATUS_PLANNED"];?></span></li>
            <li><span class="<?php if($treatment->canedit) { ?>statusButton noDate<?php } ?> inprogress<?php echo $treatment->status_inprogress_active;?>" rel="1" reltext=""><?php echo $lang["PATIENT_TREATMENT_STATUS_INPROGRESS"];?></span></li>
            <li><span class="<?php if($treatment->canedit) { ?>statusButton noDate<?php } ?> finished<?php echo $treatment->status_finished_active;?>" rel="2" reltext=""><?php echo $lang["PATIENT_TREATMENT_STATUS_FINISHED"];?></span></li>
            <li><span class="right<?php if($treatment->canedit) { ?> statusButton noDate<?php } ?> stopped<?php echo $treatment->status_stopped_active;?>" rel="3" reltext=""><?php echo $lang["PATIENT_TREATMENT_STATUS_STOPPED"];?></span></li>
            <li><div class="status-time"><?php echo($treatment->status_text_time)?></div><div class="status-input"><input name="phase_status_date" type="text" class="input-date statusdp" value="<?php echo($treatment->status_date)?>" readonly="readonly" /></div></li>
		</ul></div></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($treatment->canedit || $treatment->specialcanedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($treatment->id);?>">
<input type="hidden" name="pid" value="<?php echo($treatment->pid);?>">
<?php if($treatment->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span><?php echo $lang["GLOBAL_ALERT"];?></span></span></strong></td>
		<td class="tcell-right"><strong><?php echo $lang["GLOBAL_CONTENT_EDITED_BY"];?> <?php echo($treatment->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($treatment->checked_out_user_email);?>"><?php echo($treatment->checked_out_user_email);?></a>, <?php echo($treatment->checked_out_user_phone1);?></td>
    </tr>
</table>
<?php } ?>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PATIENT_TREATMENT_DURATION"];?></td>
		<td class="tcell-right-inactive"><span id="patients_treatmentstartdate"><?php echo($treatment->treatment_start);?></span> - <span id="patients_treatmentenddate"><?php echo($treatment->treatment_end);?></span>
        </td>
    </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($treatment->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["PATIENT_TREATMENT_DATE"];?></span></span></td>
		<td class="tcell-right"><input name="item_date" type="text" class="input-date datepicker item_date" value="<?php echo($treatment->item_date)?>" readonly="readonly" /></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($treatment->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="patientsdoctor" append="1"><span><?php echo $lang["PATIENT_TREATMENT_DOCTOR"];?></span></span></td>
		<td class="tcell-right"><div id="patientsdoctor" class="itemlist-field"><?php echo($treatment->doctor);?></div><div id="patientsdoctor_ct" class="itemlist-field"><?php if($treatment->canedit) { ?><a<?php } else { ?> <span <?php } ?> field="patientsdoctor_ct" class="ct-content"><?php echo($treatment->doctor_ct);?><?php if($treatment->canedit) { ?></a><?php } else { ?> </span><?php } ?></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($treatment->canedit || $treatment->specialcanedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["PATIENT_TREATMENT_DOCTOR_DIAGNOSE"];?></span></span></td>
    <td class="tcell-right"><?php if($treatment->canedit || $treatment->specialcanedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($treatment->protocol));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($treatment->protocol)));?><?php } ?></td>
  </tr>
</table>
<?php if(CO_PRODUCT_VARIANT == 1) { ?><div style="display: none"><?php } ?>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($treatment->canedit) { ?>content-nav showDialog<?php } ?>" request="getTreatmentsMethodDialog" field="patientsmethod" append="0" sql=""><span><?php echo $lang["PATIENT_TREATMENT_METHOD"];?></span></span></td>
        <td class="tcell-right"><div id="patientsmethod" class="itemlist-field"><?php echo($treatment->method);?></div></td>
	</tr>
</table>
<?php if(CO_PRODUCT_VARIANT == 1) { ?></div><?php } ?>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($treatment->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php if(CO_PRODUCT_VARIANT == 1) { echo $lang["PATIENT_TREATMENT_PRESCRIPTION_PHYSIO"]; } else { echo $lang["PATIENT_TREATMENT_PRESCRIPTION_THERAPY"]; }?></span></span></td>
    <td class="tcell-right"><?php if($treatment->canedit) { ?><textarea name="protocol2" id="protocol2" class="elastic" style="background: #fff;"><?php echo(strip_tags($treatment->protocol2));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($treatment->protocol2)));?><textarea name="protocol2" id="protocol2" class="elastic" style="display: none;"><?php echo(strip_tags($treatment->protocol2));?></textarea><?php } ?></td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left-inactive text11"><span><span><?php if(CO_PRODUCT_VARIANT == 1) { echo $lang["PATIENT_TREATMENT_ACHIEVMENT_STATUS_PHYSIO"]; } else { echo $lang["PATIENT_TREATMENT_ACHIEVMENT_STATUS_THERAPY"]; }?></span></span></td>
    <td class="tcell-right-inactive"><span id="sessioncount"><?php print_r($treatment->sessionvalstext);?></span></td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($treatment->canedit || $treatment->specialcanedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["PATIENT_TREATMENT_DESCRIPTION"];?></span></span></td>
    <td class="tcell-right"><?php if($treatment->canedit || $treatment->specialcanedit) { ?><textarea name="protocol3" class="elastic"><?php echo(strip_tags($treatment->protocol3));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($treatment->protocol3)));?><?php } ?></td>
  </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left-inactive text11"><span><span><?php echo $lang["PATIENT_TREATMENT_AMOUNT"];?></span></span></td>
    <td class="tcell-right-inactive"><?php echo CO_DEFAULT_CURRENCY;?> <span id="totalcosts"><?php echo $treatment->totalcosts;?></span></td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($treatment->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["PATIENT_TREATMENT_DISCOUNT"];?> (%)</span></span></td>
    <td class="tcell-right-nopadding"><?php if($treatment->canedit) { ?><input id="discount" name="discount" type="text" class="bg" value="<?php echo($treatment->discount);?>" /><?php } else { echo('<input id="discount" name="discount" type="text" class="bg" value="'.$treatment->discount.'" style="display: none;"/><span style="display: block; padding-left: 7px; padding-top: 4px;">' . $treatment->discount . '</span>'); } ?></td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($treatment->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["PATIENT_TREATMENT_VAT"];?> (%)</span></span></td>
    <td class="tcell-right-nopadding"><?php if($treatment->canedit) { ?><input id="vat" name="vat" type="text" class="bg" value="<?php echo($treatment->vat);?>" /><?php } else { echo('<input id="vat" name="vat" type="text" class="bg" value="'.$treatment->vat.'" style="display: none;" /><span style="display: block; padding-left: 7px; padding-top: 4px;">' . $treatment->vat . '</span>'); } ?></td>
  </tr>
</table>
<div class="content-spacer"></div>

        <table border="0" cellpadding="0" cellspacing="0" class="table-content addTaskTable">
                <tr>
                    <td class="tcell-left text11">
                    <span><span><?php echo $lang["PATIENT_TREATMENT_GOALS"];?></span></span>
                    </td>
                    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
                    <div id="patientstreatmenttasks">
						<?php 
						$i = 1;
                        foreach($task as $value) { 
							$checked = '';
							if($value->status == 1) {
								$checked = ' checked="checked"';
							}
                            include("task.php");
							$i++;
                         } ?>
                        </div>


<?php if($treatment->perms != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($treatment->canedit) { ?>content-nav showCoPopup<?php } ?> <?php if($treatment->invoice_no > CO_INVOICE_START) { echo 'activeInvoice'; }?>" request="showAllTasks"><span>Barzahlung</span></span></td>
        <td class="tcell-right" id="listBarPayments">
        <?php 
					 foreach($task_bar as $value) { 
               include("tasks_bar.php");
						} ?>
        
        </td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="content-nav showDialog" request="getAccessDialog" field="patientstreatment_access" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></span></td>
        <td class="tcell-right"><div id="patientstreatment_access" class="itemlist-field"><div class="listmember" field="patientstreatment_access" uid="<?php echo($treatment->access);?>" style="float: left"><?php echo($treatment->access_text);?></div></div><input type="hidden" name="treatment_access_orig" value="<?php echo($treatment->access);?>" /></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="content-nav ui-datepicker-trigger-action"><span><?php echo $lang['GLOBAL_CHECKPOINT'];?></span></span></td>
		<td class="tcell-right"><input name="checkpoint" type="text" class="input-date checkpointdp" value="<?php echo($treatment->checkpoint_date);?>" readonly="readonly" /><span style="display: none;"><?php echo($treatment->checkpoint);?></span></td>
	</tr>
</table>
<?php if($treatment->checkpoint == 1) { $show = 'display: block'; } else { $show = 'display: none'; }?>
<div id="patients_treatmentsCheckpoint" style="<?php echo $show;?>">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="selectTextarea"><span>&nbsp;</span></span></td>
        <td class="tcell-right"><textarea name="checkpoint_note" class="elastic-two"><?php echo(strip_tags($treatment->checkpoint_note));?></textarea></td>
	</tr>
</table>
<div style="height: 2px;"></div>
</div>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="patientstreatment_sendto">
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
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($treatment->edited_user.", ".$treatment->edited_date)?></td>
    <td class="middle"><?php echo $treatment->access_footer;?></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($treatment->created_user.", ".$treatment->created_date);?></td>
  </tr>
</table>
</div>
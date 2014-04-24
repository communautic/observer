<div class="table-title-outer">
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span><span><?php echo $lang["PATIENT_INVOICE_TITLE"];?></span></span></td>
    <td><div class="textarea-title"><?php echo($invoice->title);?></div></td>
  </tr>
  <tr class="table-title-status">
    <td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_STATUS"];?></td>
    <td colspan="2"><div class="statusTabs">
    	<ul>
        	<li><span class="left<?php if($invoice->canedit) { ?> statusButton <?php } ?> planned<?php echo $invoice->status_planned_active;?>" rel="0" reltext="<?php echo $lang["PATIENT_INVOICE_STATUS_PLANNED_TIME"];?>"><?php echo $lang["PATIENT_INVOICE_STATUS_PLANNED"];?></span></li>
            <li><span class="<?php if($invoice->canedit) { ?>statusButton <?php } ?>inprogress<?php echo $invoice->status_inprogress_active;?>" rel="1" reltext="<?php echo $lang["PATIENT_INVOICE_STATUS_INPROGRESS_TIME"];?>"><?php echo $lang["PATIENT_INVOICE_STATUS_INPROGRESS"];?></span></li>
            <li><span class="right<?php if($invoice->canedit) { ?> statusButton <?php } ?> finished<?php echo $invoice->status_finished_active;?>" rel="2" reltext="<?php echo $lang["PATIENT_INVOICE_STATUS_FINISHED_TIME"];?>"><?php echo $lang["PATIENT_INVOICE_STATUS_FINISHED"];?></span></li>
            <li><div class="status-time"><?php echo($invoice->status_text_time)?></div><div class="status-input"><input name="invoice_status_date" type="text" class="input-date statusdp" value="<?php echo($invoice->status_date)?>" readonly="readonly" /></div></li>
		</ul></div></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($invoice->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($invoice->id);?>">
<input type="hidden" name="pid" value="<?php echo($invoice->pid);?>">
<?php if($invoice->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span><?php echo $lang["GLOBAL_ALERT"];?></span></span></strong></td>
		<td class="tcell-right"><strong><?php echo $lang["GLOBAL_CONTENT_EDITED_BY"];?> <?php echo($invoice->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($invoice->checked_out_user_email);?>"><?php echo($invoice->checked_out_user_email);?></a>, <?php echo($invoice->checked_out_user_phone1);?></td>
    </tr>
</table>
<?php } ?>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PATIENT_INVOICE_DURATION"];?></td>
		<td class="tcell-right-inactive"><?php echo($invoice->treatment_start);?> - <?php echo($invoice->treatment_end);?></td>
    </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PATIENT_MANAGEMENT"];?></td>
		<td class="tcell-right-inactive"><?php echo($invoice->management);?></td>
    </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($invoice->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["PATIENT_INVOICE_DATE"];?></span></span></td>
		<td class="tcell-right"><input name="invoice_date" type="text" class="input-date datepicker invoice_date" value="<?php echo($invoice->invoice_date)?>" /></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($invoice->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["PATIENT_INVOICE_DATE_SENT"];?></span></span></td>
		<td class="tcell-right"><input name="invoice_date_sent" type="text" class="input-date datepicker invoice_date_sent" value="<?php echo($invoice->invoice_date_sent)?>" /></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang["PATIENT_INVOICE_NUMBER"];?></span></span></td>
    <td class="tcell-right-nopadding"><input name="invoice_number" type="text" class="bg" value="<?php echo($invoice->invoice_number);?>" /></td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($invoice->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="patientsinvoiceaddress" append="0" title="therapist"><span><?php echo $lang["PATIENT_INVOICE_ADDRESS"];?></span></span></td>
	  <td class="tcell-right"><div id="patientsinvoiceaddress" class="itemlist-field"><?php echo($invoice->invoiceaddress);?></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
    <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin loadContactExternal" rel="<?php echo($invoice->patient_id)?>" style="cursor: pointer;">
  <tr>
		<td class="tcell-left-inactive text11" style="padding-top: 2px;"><?php echo $lang["PATIENT_CONTACT_DETAILS"];?></td>
    	<td class="tcell-right-inactive"><?php echo($invoice->ctitle)?> <?php echo($invoice->title2)?> <?php echo($invoice->lastname);?> <?php echo($invoice->firstname);?><br />
        <span class="text11"><?php echo($invoice->position . " &nbsp; | &nbsp; " . $lang["PATIENT_CONTACT_EMAIL"] . " " . $invoice->email . " &nbsp; | &nbsp; " . $lang["PATIENT_CONTACT_PHONE"] . " " . $invoice->phone1);?></span>
        </td>
        </tr>
</table>
<div class="content-spacer"></div>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span><span style="color: #666;"><?php echo $lang["PATIENT_INVOICE_LIST"];?></span></span></td>
    <td class="tcell-right-nopadding"><div style="width: 530px; border: 1px solid #ccc; color: #666;">
	<?php 
	$i = 1;
	foreach($task as $value) { 
		$checked = '';
		if($value->status == 1  && is_array($value->type)) {
			include("task.php");
		}
		$i++;
	 } 
	?>
	 <?php if($invoice->discount > 0) { ?>
		 <div style="border-bottom: 1px solid #ccc;">
            <table width="530" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td class="text11" style="width: 215px; padding: 6px 0;">
                    <span class="text13 bold" style="margin-left: 7px;">&nbsp;</span></td>
                <td class="text11" style="width: 157px; padding: 7px 0 4px 0;">&nbsp;</td>
                     <td class="text11" style="padding: 7px 0 4px 0;">-<?php echo $invoice->discount;?>% <?php echo $lang["PATIENT_TREATMENT_DISCOUNT_SHORT"];?></td>
                    <td class="text11" style="width: 88px; text-align: right; border-left: 1px solid #ccc; padding: 7px 0 4px 0;">-<?php echo CO_DEFAULT_CURRENCY . ' ' . $invoice->discount_costs;?> &nbsp; &nbsp; </td>
              </tr>
            </table>
        </div>
	 <?php }?>
     <?php if($invoice->vat > 0) { ?>
		 <div style="border-bottom: 1px solid #ccc;">
            <table width="530" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td class="text11" style="width: 215px; padding: 6px 0;">
                    <span class="text13 bold" style="margin-left: 7px;">&nbsp;</span></td>
                <td class="text11" style="width: 157px; padding: 7px 0 4px 0;">&nbsp;</td>
                     <td class="text11" style="padding: 7px 0 4px 0;"><?php echo $invoice->vat;?>% <?php echo $lang["PATIENT_TREATMENT_VAT_SHORT"];?></td>
                    <td class="text11" style="width: 88px; text-align: right; border-left: 1px solid #ccc; padding: 7px 0 4px 0;"><?php echo CO_DEFAULT_CURRENCY . ' ' . $invoice->vat_costs;?> &nbsp; &nbsp; </td>
              </tr>
            </table>
        </div>
	 <?php }?>


<div style="background: #e5e5e5;">
	<table width="530" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td style="width: 215px; padding: 6px 0 4px 0;"><span class="bold" style="margin-left: 7px;"><?php echo $lang["PATIENT_INVOICE_TOTALS"];?></span></td>
        <td class="text11" style="width: 157px; padding: 6px 0 4px 0;">&nbsp;</td>
             <td class="text11" style="padding: 6px 0 4px 0;">&nbsp;</td>
            <td class="text11 bold" style="width: 88px; text-align: right; border-left: 1px solid #ccc; padding: 6px 0 4px 0;"><?php echo CO_DEFAULT_CURRENCY;?> <?php echo $invoice->totalcosts;?> &nbsp; &nbsp; </td>
      </tr>
    </table>
</div>

</div></td>
  </tr>
</table>
<div class="content-spacer"></div>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($invoice->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["PATIENT_INVOICE_NOTES"];?></span></span></td>
    <td class="tcell-right"><?php if($invoice->canedit) { ?><textarea name="protocol_invoice" class="elastic"><?php echo(strip_tags($invoice->protocol_invoice));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($invoice->protocol_invoice)));?><?php } ?></td>
  </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($invoice->canedit) { ?>content-nav showDialog<?php } ?>" request="getDocumentsDialog" field="patientsdocuments" append="1"><span><?php echo $lang["PATIENT_DOCUMENT_DOCUMENTS"];?></span></span></td>
    <td class="tcell-right"><div id="patientsdocuments" class="itemlist-field"><?php echo($invoice->documents);?></div></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($invoice->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["PATIENT_INVOICE_PAYMENT_REMINDER"];?></span></span></td>
		<td class="tcell-right"><input name="payment_reminder" type="text" class="input-date datepicker payment_reminder" value="<?php echo($invoice->payment_reminder)?>" /></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($invoice->canedit) { ?>content-nav selectTextarea<?php } ?>"><span>&nbsp;</span></span></td>
    <td class="tcell-right"><?php if($invoice->canedit) { ?><textarea name="protocol_payment_reminder" class="elastic"><?php echo(strip_tags($invoice->protocol_payment_reminder));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($invoice->protocol_payment_reminder)));?><?php } ?></td>
  </tr>
</table>
<?php if($invoice->perms != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="content-nav ui-datepicker-trigger-action"><span><?php echo $lang['GLOBAL_CHECKPOINT'];?></span></span></td>
		<td class="tcell-right"><input name="checkpoint" type="text" class="input-date checkpointdp" value="<?php echo($invoice->checkpoint_date);?>" readonly="readonly" /><span style="display: none;"><?php echo($invoice->checkpoint);?></span></td>
	</tr>
</table>
<?php if($invoice->checkpoint == 1) { $show = 'display: block'; } else { $show = 'display: none'; }?>
<div id="patients_invoicesCheckpoint" style="<?php echo $show;?>">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="selectTextarea"><span>&nbsp;</span></span></td>
        <td class="tcell-right"><textarea name="checkpoint_note" class="elastic-two"><?php echo(strip_tags($invoice->checkpoint_note));?></textarea></td>
	</tr>
</table>
<div style="height: 2px;"></div>
</div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="patientsinvoice_sendto">
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
    <td class="left"><?php echo($lang["GLOBAL_FOOTER_STATUS"] . " " . $invoice->today);?></td>
    <td class="middle"></td>
    <td class="right"></td>
  </tr>
</table>
</div>
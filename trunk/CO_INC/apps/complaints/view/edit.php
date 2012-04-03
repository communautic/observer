<div class="table-title-outer">

<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($complaint->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["COMPLAINT_TITLE"];?></span></span></td>
    <td class="tcell-right"><?php if($complaint->canedit) { ?><input name="title" type="text" class="title textarea-title" value="<?php echo($complaint->title);?>" maxlength="100" /><?php } else { ?><div class="textarea-title"><?php echo($complaint->title);?></div><?php } ?></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($complaint->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setComplaintDetails">
<input type="hidden" name="id" value="<?php echo($complaint->id);?>">
<?php if($complaint->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span>Warnung</span></span></strong></td>
		<td class="tcell-right"><strong>Dieser Inhaltsbereich wird aktuell bearbeitet von: <?php echo($complaint->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($complaint->checked_out_user_email);?>"><?php echo($complaint->checked_out_user_email);?></a>, <?php echo($complaint->checked_out_user_phone1);?></td>
    </tr>
</table>
<div class="content-spacer"></div>
<?php } ?>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_DURATION"];?></td>
		<td class="tcell-right-inactive"><span id="complaintDurationStart"><?php echo($complaint->startdate)?></span> - <span id="complaintDurationEnd"><?php echo($complaint->enddate)?></span></td>
    </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($complaint->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang['COMPLAINT_KICKOFF'];?></span></span></td>
		<td class="tcell-right"><?php if($complaint->canedit) { ?><input name="startdate" type="text" class="input-date datepicker" value="<?php echo($complaint->startdate)?>" /><?php } else { ?><?php echo($complaint->startdate)?><?php } ?></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($complaint->canedit) { ?>content-nav showDialog<?php } ?>" request="getComplaintFolderDialog" field="complaintsfolder" append="1"><span><?php echo $lang["COMPLAINT_FOLDER"];?></span></span></td>
        <td class="tcell-right"><div id="complaintsfolder" class="itemlist-field"><?php echo($complaint->folder);?></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($complaint->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="complaintsordered_by" append="0"><span><?php echo $lang["COMPLAINT_CLIENT"];?></span></span></td>
	  <td class="tcell-right"><div id="complaintsordered_by" class="itemlist-field"><?php echo($complaint->ordered_by);?></div><div id="complaintsordered_by_ct" class="itemlist-field"><a field="complaintsordered_by_ct" class="ct-content"><?php echo($complaint->ordered_by_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($complaint->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="complaintsmanagement" append="1"><span><?php echo $lang["COMPLAINT_MANAGEMENT"];?></span></span></td>
	  <td class="tcell-right"><div id="complaintsmanagement" class="itemlist-field"><?php echo($complaint->management);?></div><div id="complaintsmanagement_ct" class="itemlist-field"><a field="complaintsmanagement_ct" class="ct-content"><?php echo($complaint->management_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($complaint->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="complaintsteam" append="1"><span><?php echo $lang["COMPLAINT_TEAM"];?></span></span></td>
    <td class="tcell-right"><div id="complaintsteam" class="itemlist-field"><?php echo($complaint->team);?></div><div id="complaintsteam_ct" class="itemlist-field"><a field="complaintsteam_ct" class="ct-content"><?php echo($complaint->team_ct);?></a></div></td>
  </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($complaint->canedit) { ?>content-nav showDialog<?php } ?>" request="getComplaintDialog" field="complaintscomplaint" append="0"><span><?php echo $lang["COMPLAINT_COMPLAINTCAT"];?></span></span></td>
        <td class="tcell-right"><div id="complaintscomplaint" class="itemlist-field"><?php echo($complaint->complaint);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($complaint->canedit) { ?>content-nav showDialog<?php } ?>" request="getComplaintCatDialog" field="complaintscomplaintcat" append="0"><span><?php echo $lang["COMPLAINT_CAT"];?></span></span></td>
        <td class="tcell-right"><div id="complaintscomplaintcat" class="itemlist-field"><?php echo($complaint->complaint_cat);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($complaint->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang['COMPLAINT_PRODUCT_NUMBER'];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($complaint->canedit) { ?><input name="product" type="text" class="bg" value="<?php echo($complaint->product);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $complaint->product . '</span>'); } ?></td>
    <td width="110"></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($complaint->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang['COMPLAINT_PRODUCT'];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($complaint->canedit) { ?><input name="product_desc" type="text" class="bg" value="<?php echo($complaint->product_desc);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $complaint->product_desc . '</span>'); } ?></td>
    <td width="110"></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($complaint->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang['COMPLAINT_CHARGE'];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($complaint->canedit) { ?><input name="charge" type="text" class="bg" value="<?php echo($complaint->charge);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $complaint->charge . '</span>'); } ?></td>
    <td width="110"></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($complaint->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang['COMPLAINT_NUMBER'];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($complaint->canedit) { ?><input name="number" type="text" class="bg" value="<?php echo($complaint->number);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $complaint->number . '</span>'); } ?></td>
    <td width="110"></td>
  </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($complaint->canedit) { ?>content-nav showDialog<?php } ?>" request="getComplaintStatusDialog" field="complaintsstatus" append="1"><span><?php echo $lang["GLOBAL_STATUS"];?></span></span></td>
        <td class="tcell-right"><div id="complaintsstatus" class="itemlist-field"><div class="listmember" field="complaintsstatus" uid="<?php echo($complaint->status);?>" style="float: left"><?php echo($complaint->status_text);?></div></div><?php if($complaint->canedit) { ?><input name="status_date" type="text" class="input-date datepicker status_date" value="<?php echo($complaint->status_date)?>" style="float: left; margin-left: 8px;" /><?php } else { ?><div style="float: left; margin-left: 8px;"><?php echo($complaint->status_date)?><?php } ?></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($complaint->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["COMPLAINT_DESCRIPTION"];?></span></span></td>
        <td class="tcell-right"><?php if($complaint->canedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($complaint->protocol));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($complaint->protocol)));?><?php } ?></td>
	</tr>
</table>
</form>
<?php if($complaint->access != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="content-nav ui-datepicker-trigger-action"><span><?php echo $lang['GLOBAL_CHECKPOINT'];?></span></span></td>
		<td class="tcell-right"><input name="checkpoint" type="text" class="input-date checkpointdp" value="<?php echo($complaint->checkpoint_date);?>" readonly="readonly" /><span style="display: none;"><?php echo($complaint->checkpoint);?></span></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="complaint_sendto">
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
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($complaint->edited_user.", ".$complaint->edited_date)?></td>
    <td class="middle"></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($complaint->created_user.", ".$complaint->created_date);?></td>
  </tr>
</table>
</div>
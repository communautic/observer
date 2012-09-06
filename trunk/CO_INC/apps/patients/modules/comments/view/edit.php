<div class="table-title-outer">

<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($comment->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["PATIENT_COMMENT_TITLE"];?></span></span></td>
    <td><input name="title" type="text" class="title textarea-title" value="<?php echo($comment->title);?>" maxlength="100" /></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($comment->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($comment->id);?>">
<input type="hidden" name="pid" value="<?php echo($comment->pid);?>">
<?php if($comment->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span>Warnung</span></span></strong></td>
		<td class="tcell-right"><strong>Dieser Inhaltsbereich wird aktuell bearbeitet von: <?php echo($comment->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($comment->checked_out_user_email);?>"><?php echo($comment->checked_out_user_email);?></a>, <?php echo($comment->checked_out_user_phone1);?></td>
    </tr>
</table>
<?php } ?>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($comment->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["PATIENT_COMMENT_DATE"];?></span></span></td>
		<td class="tcell-right"><input name="item_date" type="text" class="input-date datepicker item_date" value="<?php echo($comment->item_date)?>" /></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($comment->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="patientsmanagement" append="1"><span><?php echo $lang["PATIENT_COMMENT_MANAGEMENT"];?></span></span></td>
		<td class="tcell-right"><div id="patientsmanagement" class="itemlist-field"><?php echo($comment->management);?></div><div id="patientsmanagement_ct" class="itemlist-field"><a field="patientsmanagement_ct" class="ct-content"><?php echo($comment->management_ct);?></a></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($comment->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["PATIENT_COMMENT_GOALS"];?></span></span></td>
    <td class="tcell-right"><?php if($comment->canedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($comment->protocol));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($comment->protocol)));?><?php } ?></td>
  </tr>
</table>
<?php if($comment->perms != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($comment->canedit) { ?>content-nav showDialog<?php } ?>" request="getDocumentsDialog" field="patientsdocuments" append="1"><span><?php echo $lang["PATIENT_DOCUMENT_DOCUMENTS"];?></span></span></td>
    <td class="tcell-right"><div id="patientsdocuments" class="itemlist-field"><?php echo($comment->documents);?></div></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($comment->canedit) { ?>content-nav showDialog<?php } ?>" request="getAccessDialog" field="patientscomment_access" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></span></td>
        <td class="tcell-right"><div id="patientscomment_access" class="itemlist-field"><div class="listmember" field="patientscomment_access" uid="<?php echo($comment->access);?>" style="float: left"><?php echo($comment->access_text);?></div></div><input type="hidden" name="comment_access_orig" value="<?php echo($comment->access);?>" /></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="patientscomment_sendto">
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
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($comment->edited_user.", ".$comment->edited_date)?></td>
    <td class="middle"><?php echo $comment->access_footer;?></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($comment->created_user.", ".$comment->created_date);?></td>
  </tr>
</table>
</div>
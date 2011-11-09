<div>
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($publisher->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["PUBLISHER_TITLE"];?></span></span></td>
    <td class="tcell-right"><?php if($publisher->canedit) { ?><input name="title" type="text" class="title textarea-title" value="<?php echo($publisher->title);?>" maxlength="100" /><?php } else { ?><div class="textarea-title"><?php echo($publisher->title);?></div><?php } ?></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($publisher->canedit) { ?>coform <?php } ?>">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setPublisherDetails">
<input type="hidden" name="id" value="<?php echo($publisher->id);?>">
<?php if($publisher->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span>Warnung</span></span></strong></td>
		<td class="tcell-right"><strong>Dieser Inhaltsbereich wird aktuell bearbeitet von: <?php echo($publisher->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($publisher->checked_out_user_email);?>"><?php echo($publisher->checked_out_user_email);?></a>, <?php echo($publisher->checked_out_user_phone1);?></td>
    </tr>
</table>
<div class="content-spacer"></div>
<?php } ?>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_DURATION"];?></td>
		<td class="tcell-right-inactive"><span id="durationStart"><?php echo($publisher->startdate)?></span> - <span id="durationEnd"><?php echo($publisher->enddate)?></span></td>
    </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($publisher->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang['PUBLISHER_KICKOFF'];?></span></span></td>
		<td class="tcell-right"><?php if($publisher->canedit) { ?><input name="startdate" type="text" class="input-date datepicker" value="<?php echo($publisher->startdate)?>" /><input name="movepublisher_start" type="hidden" value="<?php echo($publisher->startdate)?>" /><?php } else { ?><?php echo($publisher->startdate)?><?php } ?></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($publisher->canedit) { ?>content-nav showDialog<?php } ?>" request="getPublisherFolderDialog" field="publishersfolder" append="1"><span><?php echo $lang["PUBLISHER_FOLDER"];?></span></span></td>
        <td class="tcell-right"><div id="publishersfolder" class="itemlist-field"><?php echo($publisher->folder);?></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($publisher->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="publishersordered_by" append="0"><span><?php echo $lang["PUBLISHER_CLIENT"];?></span></span></td>
	  <td class="tcell-right"><div id="publishersordered_by" class="itemlist-field"><?php echo($publisher->ordered_by);?></div><div id="publishersordered_by_ct" class="itemlist-field"><a field="publishersordered_by_ct" class="ct-content"><?php echo($publisher->ordered_by_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($publisher->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="publishersmanagement" append="1"><span><?php echo $lang["PUBLISHER_MANAGEMENT"];?></span></span></td>
	  <td class="tcell-right"><div id="publishersmanagement" class="itemlist-field"><?php echo($publisher->management);?></div><div id="publishersmanagement_ct" class="itemlist-field"><a field="publishersmanagement_ct" class="ct-content"><?php echo($publisher->management_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($publisher->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="publishersteam" append="1"><span><?php echo $lang["PUBLISHER_TEAM"];?></span></span></td>
    <td class="tcell-right"><div id="publishersteam" class="itemlist-field"><?php echo($publisher->team);?></div><div id="publishersteam_ct" class="itemlist-field"><a field="publishersteam_ct" class="ct-content"><?php echo($publisher->team_ct);?></a></div></td>
  </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($publisher->canedit) { ?>content-nav showDialog<?php } ?>" request="getPublisherStatusDialog" field="publishersstatus" append="1"><span><?php echo $lang["GLOBAL_STATUS"];?></span></span></td>
        <td class="tcell-right"><div id="publishersstatus" class="itemlist-field"><div class="listmember" field="publishersstatus" uid="<?php echo($publisher->status);?>" style="float: left"><?php echo($publisher->status_text);?></div></div><?php if($publisher->canedit) { ?><input name="status_date" type="text" class="input-date datepicker status_date" value="<?php echo($publisher->status_date)?>" style="float: left; margin-left: 8px;" /><?php } else { ?><div style="float: left; margin-left: 8px;"><?php echo($publisher->status_date)?><?php } ?></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($publisher->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["PUBLISHER_DESCRIPTION"];?></span></span></td>
        <td class="tcell-right"><?php if($publisher->canedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($publisher->protocol));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($publisher->protocol)));?><?php } ?></td>
	</tr>
</table>
</form>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PUBLISHER_PHASES"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php
if(is_array($phases)) {
	$i = 1;
	foreach ($phases as $phase) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive loadPublishersPhase" rel="<?php echo($phase->id);?>">
	<tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right" colspan="3"><span class="loadPublishersPhase bold co-link" rel="<?php echo($phase->id);?>"><?php echo($num[$phase->id] . " " . $phase->title);?></span></td>
	</tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right" width="220"><span class="text11 content-date"><?php echo $lang["GLOBAL_DURATION"];?></span><span class="text11"><?php echo($phase->startdate . " - " . $phase->enddate);?></span></td>
		<td class="tcell-right" width="110"><span class="text11"><span style="display: inline; margin-right: 20px;"></span><?php echo($phase->status_text);?></span></td>
	    <td class="tcell-right"><?php if($publisher->access != "guest") { ?><span class="text11"><span style="display: inline; margin-right: 20px;"><?php echo $lang["PUBLISHER_FOLDER_CHART_REALISATION"];?></span><?php echo($phase->realisation);?>%</span><?php } ?></td>
    </tr>
</table>
    <?php 
	$i++;
	}
}
?>
<?php if($publisher->access != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="publisher_sendto">
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
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($publisher->edited_user.", ".$publisher->edited_date)?></td>
    <td class="middle"></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($publisher->created_user.", ".$publisher->created_date);?></td>
  </tr>
</table>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($phase->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["PROJECT_PHASE_TITLE"];?></span></span></td>
	<td width="20"><div class="bold"><?php echo($phase->num) ;?>.</div></td>
    <td><input name="title" type="text" class="title textarea-title" value="<?php echo($phase->title);?>" maxlength="100" /></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($phase->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($phase->id);?>">
<?php if($phase->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span>Warnung</span></span></strong></td>
		<td class="tcell-right"><strong>Dieser Inhaltsbereich wird aktuell bearbeitet von: <?php echo($phase->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($phase->checked_out_user_email);?>"><?php echo($phase->checked_out_user_email);?></a>, <?php echo($phase->checked_out_user_phone1);?></td>
    </tr>
</table>
<?php } ?>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_DURATION"];?></td>
		<td class="tcell-right-inactive"><span id="projectsphasestartdate"><?php echo($phase->startdate);?></span> - <span id="projectsphaseenddate"><?php echo($phase->enddate);?></span>
        <input name="kickoff" type="hidden" value="<?php echo($phase->kickoff);?>" />
        </td>
    </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><span><?php echo $lang["PROJECT_MANAGEMENT"];?></span></td>
		<td class="tcell-right-inactive"><?php echo($phase->management);?></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($phase->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="projectsteam" append="1"><span><?php echo $lang["PROJECT_PHASE_TEAM"];?></span></span></td>
    <td class="tcell-right"><div id="projectsteam" class="itemlist-field"><?php echo($phase->team);?></div><div id="projectsteam_ct" class="itemlist-field"><a field="projectsteam_ct" class="ct-content"><?php echo($phase->team_ct);?></a></div></td>
  </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($phase->canedit) { ?>content-nav showDialog<?php } ?>" request="getPhaseStatusDialog" field="projectsstatus" append="1"><span><?php echo $lang["GLOBAL_STATUS"];?></span></span></td>
        <td class="tcell-right"><div id="projectsphase_status" class="itemlist-field"><div class="listmember" field="projectsphase_status" uid="<?php echo($phase->status);?>" style="float: left"><?php echo($phase->status_text);?></div></div><?php if($phase->canedit) { ?><input name="phase_status_date" type="text" class="input-date datepicker phase_status_date" value="<?php echo($phase->status_date)?>" style="float: left; margin-left: 8px;" /><?php } else { ?><div style="float: left; margin-left: 8px;"><?php echo($phase->status_date)?></div><?php } ?></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($phase->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["PROJECT_DESCRIPTION"];?></span></span></td>
    <td class="tcell-right"><?php if($phase->canedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($phase->protocol));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($phase->protocol)));?><?php } ?></td>
  </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content addTaskTable">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($phase->canedit) { ?>content-nav showDialog<?php } ?>" request="getPhaseTaskDialog" field="status" append="1"><span><?php echo $lang["PROJECT_PHASE_TASK_MILESTONE"];?></span></span>
        </td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php 
foreach($task as $value) { 
	$checked = '';
	$donedate_field = 'display: none';
	$donedate = $phase->today;
	if($value->status == 1) {
		$checked = ' checked="checked"';
		$donedate_field = '';
		$donedate = $value->donedate;
	}
	
	if($value->cat == 0) {
		include("task.php");
	} else {
		include("milestone.php");
	}
 } ?>
<div id="projectsphasetasks"></div>
<?php if($phase->perms != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($phase->canedit) { ?>content-nav showDialog<?php } ?>" request="getDocumentsDialog" field="projectsdocuments" append="1"><span><?php echo $lang["PROJECT_DOCUMENT_DOCUMENTS"];?></span></span></td>
    <td class="tcell-right"><div id="projectsdocuments" class="itemlist-field"><?php echo($phase->documents);?></div></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($phase->canedit) { ?>content-nav showDialog<?php } ?>" request="getAccessDialog" field="projectsphase_access" title="<?php echo $lang["GLOBAL_ACCESS"];?>" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></span></td>
        <td class="tcell-right"><div id="projectsphase_access" class="itemlist-field"><div class="listmember" field="projectsphase_access" uid="<?php echo($phase->access);?>" style="float: left"><?php echo($phase->access_text);?></div></div><input type="hidden" name="phase_access_orig" value="<?php echo($phase->access);?>" /></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="projects_phase_sendto">
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
</form>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($phase->edited_user.", ".$phase->edited_date)?></td>
    <td class="middle"><?php echo $phase->access_footer;?></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($phase->created_user.", ".$phase->created_date);?></td>
  </tr>
</table>
</div>
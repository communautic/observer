<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><a href="#" class="content-nav focusTitle"><span><?php echo $lang["PHASE_TITLE"];?></span></a></td>
	<td width="20"><div class="bold"><?php echo($phase->num) ;?>.</div></td>
    <td><input name="title" type="text" class="title textarea-title" value="<?php echo($phase->title);?>" maxlength="100" /></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="coform jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($phase->id);?>">
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_DURATION"];?></td>
		<td class="tcell-right-inactive"><span id="phasestartdate"><?php echo($phase->startdate);?></span> - <span id="phaseenddate"><?php echo($phase->enddate);?></span>
        <!--<input name="startdate" type="hidden" value="<?php // echo($phase->startdate)?>" />-->
        <!--<input name="enddate" type="hidden" value="<?php // echo($phase->enddate)?>" />-->
        <input name="kickoff" type="hidden" value="<?php echo($phase->kickoff);?>" />
        </td>
    </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><a href="#" class="content-nav showDialog" request="getContactsDialog" field="management" append="1"><span><?php echo PHASE_MANAGEMENT;?></span></a></td>
		<td class="tcell-right"><div id="management" class="itemlist-field"><?php echo($phase->management);?></div><div id="management_ct" class="itemlist-field"><a field="management_ct" class="ct-content"><?php echo($phase->management_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><a href="#" class="content-nav showDialog" request="getContactsDialog" field="team" append="1"><span><?php echo PHASE_TEAM;?></span></a></td>
    <td class="tcell-right"><div id="team" class="itemlist-field"><?php echo($phase->team);?></div><div id="team_ct" class="itemlist-field"><a field="team_ct" class="ct-content"><?php echo($phase->team_ct);?></a></div></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><a href="<?php echo $lang["GLOBAL_STATUS"];?>" class="content-nav showDialog" request="getPhaseStatusDialog" field="status" title="<?php echo $lang["GLOBAL_STATUS"];?>" append="1"><span><?php echo $lang["GLOBAL_STATUS"];?></span></a></td>
        <td class="tcell-right"><div id="phase_status" class="itemlist-field"><div class="listmember" field="phase_status" uid="<?php echo($phase->status);?>" style="float: left"><?php echo($phase->status_text);?></div></div><input name="phase_status_date" type="text" class="input-date datepicker phase_status_date" value="<?php echo($phase->status_date)?>" style="float: left; margin-left: 8px;" /></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
  <tr>
    <td class="tcell-left text11"><a href="#" class="content-nav protocolToggle"><span><?php echo PHASE_DESCRIPTION;?></span></a></td>
    <td class="tcell-right"><div class="protocol-outer" style="position: relative;"><div id="protocol" class="tinymce" style="min-height: 26px;"><?php echo($phase->protocol);?></div></div></td>
  </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content addTaskTable">
	<tr>
		<td class="tcell-left text11">
        <a href="#" class="content-nav showDialog" request="getPhaseTaskDialog" field="status" append="1"><span><?php echo $lang["PHASE_TASK_MILESTONE"];?></span></a>
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
<div id="phasetasks"></div>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><a href="#" class="content-nav showDialog" request="getDocumentsDialog" field="documents" append="1"><span><?php echo $lang["DOCUMENT_DOCUMENTS"];?></span></a></td>
    <td class="tcell-right"><div id="documents" class="itemlist-field"><?php echo($phase->documents);?></div></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><a href="#" class="content-nav showDialog" request="getAccessDialog" field="phase_access" title="<?php echo $lang["GLOBAL_ACCESS"];?>" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></a></td>
        <td class="tcell-right"><div id="phase_access" class="itemlist-field"><div class="listmember" field="phase_access" uid="<?php echo($phase->access);?>" style="float: left"><?php echo($phase->access_text);?></div></div><input type="hidden" name="phase_access_orig" value="<?php echo($phase->access);?>" /></td>
	</tr>
</table>
</form>
<!--<div class="content-spacer"></div>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive"><?php echo($phase->emailed_to);?></td>
    </tr>
</table>-->
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
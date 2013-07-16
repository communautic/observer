<div class="table-title-outer">

<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["TRAINING_TITLE"];?></span></span></td>
    <td class="tcell-right"><?php if($training->canedit) { ?><input name="title" type="text" class="title textarea-title" value="<?php echo($training->title);?>" maxlength="100" /><?php } else { ?><div class="textarea-title"><?php echo($training->title);?></div><?php } ?></td>
  </tr>
  <tr class="table-title-status">
    <td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_STATUS"];?></td>
    <td colspan="2"><div class="statusTabs">
    	<ul>
        	<li><span class="left<?php if($training->canedit) { ?> statusButton<?php } ?> planned<?php echo $training->status_planned_active;?>" rel="0" reltext="<?php echo $lang["GLOBAL_STATUS_PLANNED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_PLANNED"];?></span></li>
            <li><span class="<?php if($training->canedit) { ?>statusButton <?php } ?>inprogress<?php echo $training->status_inprogress_active;?>" rel="1" reltext="<?php echo $lang["GLOBAL_STATUS_INACTION_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_INACTION"];?></span></li>
            <li><span class="<?php if($training->canedit) { ?>statusButton <?php } ?>finished<?php echo $training->status_finished_active;?>" rel="2" reltext="<?php echo $lang["GLOBAL_STATUS_FINISHED2_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_FINISHED2"];?></span></li>
            <li><span class="right<?php if($training->canedit) { ?> statusButton<?php } ?> stopped<?php echo $training->status_stopped_active;?>" rel="3" reltext="<?php echo $lang["GLOBAL_STATUS_CANCELLED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_CANCELLED"];?></span></li>
            <li><div class="status-time"><?php echo($training->status_text_time)?></div><div class="status-input"><input name="phase_status_date" type="text" class="input-date statusdp" value="<?php echo($training->status_date)?>" readonly="readonly" /></div></li>
		</ul></div></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($training->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setTrainingDetails">
<input type="hidden" name="id" value="<?php echo($training->id);?>">
<input id="movetraining_start" name="movetraining_start" type="hidden" value="<?php echo($training->date1);?>" />
<?php if($training->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span>Warnung</span></span></strong></td>
		<td class="tcell-right"><strong>Dieser Inhaltsbereich wird aktuell bearbeitet von: <?php echo($training->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($training->checked_out_user_email);?>"><?php echo($training->checked_out_user_email);?></a>, <?php echo($training->checked_out_user_phone1);?></td>
    </tr>
</table>
<div class="content-spacer"></div>
<?php } ?>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav showDialog<?php } ?>" request="getTrainingFolderDialog" field="trainingsfolder" append="1"><span><?php echo $lang["TRAINING_FOLDER"];?></span></span></td>
        <td class="tcell-right"><div id="trainingsfolder" class="itemlist-field"><?php echo($training->folder);?></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="trainingsmanagement" append="1"><span><?php echo $lang["TRAINING_MANAGEMENT"];?></span></span></td>
	  <td class="tcell-right"><div id="trainingsmanagement" class="itemlist-field"><?php echo($training->management);?></div><div id="trainingsmanagement_ct" class="itemlist-field"><a field="trainingsmanagement_ct" class="ct-content"><?php echo($training->management_ct);?></a></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($training->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["TRAINING_COMPANY"];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($training->canedit) { ?><input name="company" type="text" class="bg" value="<?php echo($training->company);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $training->company . '</span>'); } ?></td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="trainingsteam" append="0"><span><?php echo $lang["TRAINING_TEAM"];?></span></span></td>
	  <td class="tcell-right"><div id="trainingsteam" class="itemlist-field"><?php echo($training->team);?></div><div id="trainingsteam_ct" class="itemlist-field"><a field="trainingsteam_ct" class="ct-content"><?php echo($training->team_ct);?></a></div></td>
	</tr>
</table>
<input type="hidden" name="trainer_details" value="<?php echo(strip_tags($training->trainer_details));?>" /></td>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav showDialog<?php } ?>" request="getTrainingDialog" field="trainingstraining" append="0"><span><?php echo $lang["TRAINING_TRAININGCAT"];?></span></span></td>
        <td class="tcell-right"><div id="trainingstraining" class="itemlist-field"><?php echo($training->training);?></div><input type="hidden" name="training_id_orig" value="<?php echo($training->training_id);?>"></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["TRAINING_COSTS"];?></span></span></td>
        <td class="tcell-right-nopadding"><?php if($training->canedit) { ?><input name="costs" type="text" class="bg currency" style="margin-left: -5px;" value="<?php echo($training->costs);?>" /><?php } else { echo('' . $training->costs . '</span>'); } ?></td>
	</tr>
</table>

<?php if(!empty($training->training_id)) { 
/* Training cats 
1 	Vortrag
2 	Vortrag & Gruppencoaching
3 	e-training
4 	e-training & Praesenzcoaching
5 	Einzelcoaching
6 	Workshop
7 	Veranstaltungsreihe
*/
include('training_cat'.$training->training_id.'.php');
?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11">Teilnehmeranzahl</td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="training_num_members"><?php echo $training->num_members;?></div></td>
    </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="custom" append="1"><span><?php echo $lang["TRAINING_MEMBER"];?></span></span></td>
	  <td class="tcell-right"></td>
	</tr>
</table>
<div id="trainingsmembers">
<?php 
foreach($member as $value) { 
			include("member.php");
} ?>
</div>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["TRAINING_DESCRIPTION_FOR"];?></span></span></td>
        <td class="tcell-right"><?php if($training->canedit) { ?><textarea name="protocol1" class="elastic"><?php echo(strip_tags($training->protocol1));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($training->protocol1)));?><?php } ?></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["TRAINING_DESCRIPTION_GOAL"];?></span></span></td>
        <td class="tcell-right"><?php if($training->canedit) { ?><textarea name="protocol2" class="elastic"><?php echo(strip_tags($training->protocol2));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($training->protocol2)));?><?php } ?></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["TRAINING_DESCRIPTION_DURATION"];?></span></span></td>
        <td class="tcell-right"><?php if($training->canedit) { ?><textarea name="protocol3" class="elastic"><?php echo(strip_tags($training->protocol3));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($training->protocol3)));?><?php } ?></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["TRAINING_DESCRIPTION_NUM_MEMBERS"];?></span></span></td>
        <td class="tcell-right"><?php if($training->canedit) { ?><textarea name="protocol4" class="elastic"><?php echo(strip_tags($training->protocol4));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($training->protocol4)));?><?php } ?></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($training->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["TRAINING_DESCRIPTION"];?></span></span></td>
        <td class="tcell-right"><?php if($training->canedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($training->protocol));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($training->protocol)));?><?php } ?></td>
	</tr>
</table>
</form>
<?php if($training->access != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="content-nav ui-datepicker-trigger-action"><span><?php echo $lang['GLOBAL_CHECKPOINT'];?></span></span></td>
		<td class="tcell-right"><input name="checkpoint" type="text" class="input-date checkpointdp" value="<?php echo($training->checkpoint_date);?>" readonly="readonly" /><span style="display: none;"><?php echo($training->checkpoint);?></span></td>
	</tr>
</table>
<?php if($training->checkpoint == 1) { $show = 'display: block'; } else { $show = 'display: none'; }?>
<div id="trainingsCheckpoint" style="<?php echo $show;?>">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="selectTextarea"><span>&nbsp;</span></span></td>
        <td class="tcell-right"><textarea name="checkpoint_note" class="elastic-two"><?php echo(strip_tags($training->checkpoint_note));?></textarea></td>
	</tr>
</table>
</div>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="training_sendto">
        <?php 
			foreach($sendto as $value) { 
			if(!empty($value->who)) {
				echo '<div class="text11 toggleSendTo co-link">' . $value->who . ', ' . $value->date . '</div>' .
				'<div class="SendToContent">' . $lang["GLOBAL_SUBJECT"] . ': ' . $value->subject . '<br /><br />' . nl2br($value->body) . '<br></div>';
			}
		 } ?></div></td>
    </tr>
</table>
<?php } ?>
<?php } ?>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($training->edited_user.", ".$training->edited_date)?></td>
    <td class="middle"></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($training->created_user.", ".$training->created_date);?></td>
  </tr>
</table>
</div>
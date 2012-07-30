<div class="table-title-outer">
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($project->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["PROJECT_TITLE"];?></span></span></td>
    <td class="tcell-right"><?php if($project->canedit) { ?><input name="title" type="text" class="title textarea-title" value="<?php echo($project->title);?>" maxlength="100" /><?php } else { ?><div class="textarea-title"><?php echo($project->title);?></div><?php } ?></td>
  </tr>
  <tr class="table-title-status">
    <td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_STATUS"];?></td>
    <td colspan="2"><div class="statusTabs">
    	<ul>
        	<li><span class="left<?php if($project->canedit) { ?> statusButton<?php } ?> planned<?php echo $project->status_planned_active;?>" rel="0" reltext="<?php echo $lang["GLOBAL_STATUS_PLANNED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_PLANNED"];?></span></li>
            <li><span class="<?php if($project->canedit) { ?>statusButton <?php } ?>inprogress<?php echo $project->status_inprogress_active;?>" rel="1" reltext="<?php echo $lang["GLOBAL_STATUS_INPROGRESS_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_INPROGRESS"];?></span></li>
            <li><span class="<?php if($project->canedit) { ?>statusButton <?php } ?>finished<?php echo $project->status_finished_active;?>" rel="2" reltext="<?php echo $lang["GLOBAL_STATUS_FINISHED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_FINISHED"];?></span></li>
            <li><span class="right<?php if($project->canedit) { ?> statusButton<?php } ?> stopped<?php echo $project->status_stopped_active;?>" rel="3" reltext="<?php echo $lang["GLOBAL_STATUS_STOPPED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_STOPPED"];?></span></li>
            <li><div class="status-time"><?php echo($project->status_text_time)?></div><div class="status-input"><input name="phase_status_date" type="text" class="input-date statusdp" value="<?php echo($project->status_date)?>" readonly="readonly" /></div></li>
		</ul></div></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($project->canedit) { ?>coform <?php } ?>">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setProjectDetails">
<input type="hidden" name="id" value="<?php echo($project->id);?>">
<?php if($project->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span>Warnung</span></span></strong></td>
		<td class="tcell-right"><strong>Dieser Inhaltsbereich wird aktuell bearbeitet von: <?php echo($project->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($project->checked_out_user_email);?>"><?php echo($project->checked_out_user_email);?></a>, <?php echo($project->checked_out_user_phone1);?></td>
    </tr>
</table>
<div class="content-spacer"></div>
<?php } ?>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_DURATION"];?></td>
		<td class="tcell-right-inactive"><span id="productionDurationStart"><?php echo($project->startdate)?></span> - <span id="productionDurationEnd"><?php echo($project->enddate)?></span></td>
    </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($project->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang['PROJECT_KICKOFF'];?></span></span></td>
		<td class="tcell-right"><?php if($project->canedit) { ?><input name="startdate" type="text" class="input-date datepicker" value="<?php echo($project->startdate)?>" readonly="readonly" /><input id="moveproject_start" name="moveproject_start" type="hidden" value="<?php echo($project->startdate)?>" /><?php } else { ?><?php echo($project->startdate)?><?php } ?></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($project->canedit) { ?>content-nav showDialog<?php } ?>" request="getProjectFolderDialog" field="projectsfolder" append="1"><span><?php echo $lang["PROJECT_FOLDER"];?></span></span></td>
        <td class="tcell-right"><div id="projectsfolder" class="itemlist-field"><?php echo($project->folder);?></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($project->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="projectsordered_by" append="0"><span><?php echo $lang["PROJECT_CLIENT"];?></span></span></td>
	  <td class="tcell-right"><div id="projectsordered_by" class="itemlist-field"><?php echo($project->ordered_by);?></div><div id="projectsordered_by_ct" class="itemlist-field"><a field="projectsordered_by_ct" class="ct-content"><?php echo($project->ordered_by_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($project->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="projectsmanagement" append="1"><span><?php echo $lang["PROJECT_MANAGEMENT"];?></span></span></td>
	  <td class="tcell-right"><div id="projectsmanagement" class="itemlist-field"><?php echo($project->management);?></div><div id="projectsmanagement_ct" class="itemlist-field"><a field="projectsmanagement_ct" class="ct-content"><?php echo($project->management_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($project->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="projectsteam" append="1"><span><?php echo $lang["PROJECT_TEAM"];?></span></span></td>
    <td class="tcell-right"><div id="projectsteam" class="itemlist-field"><?php echo($project->team);?></div><div id="projectsteam_ct" class="itemlist-field"><a field="projectsteam_ct" class="ct-content"><?php echo($project->team_ct);?></a></div></td>
  </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($project->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["PROJECT_DESCRIPTION"];?></span></span></td>
        <td class="tcell-right"><?php if($project->canedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($project->protocol));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($project->protocol)));?><?php } ?></td>
	</tr>
</table>
</form>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PROJECT_PHASES"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php
if(is_array($phases)) {
	$i = 1;
	foreach ($phases as $phase) { ?>
    <div class="loadProjectsPhase listOuter"  rel="<?php echo($phase->id);?>">
    <div class="bold co-link listTitle"><?php echo($num[$phase->id] . " " . $phase->title);?></div>
     <div class="text11 listText"><div><?php echo($phase->startdate . " - " . $phase->enddate);?> &nbsp; | &nbsp; </div><div><?php echo($phase->status_text);?> &nbsp; | &nbsp; </div><?php if($project->access != "guest") { ?><div><?php echo $lang["PROJECT_FOLDER_CHART_REALISATION"];?> <?php echo($phase->realisation);?>% &nbsp; </div><?php } ?></div>
    </div>
    <?php 
	$i++;
	}
}
?>

<?php if($project->access != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="project_sendto">
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
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($project->edited_user.", ".$project->edited_date)?></td>
    <td class="middle"></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($project->created_user.", ".$project->created_date);?></td>
  </tr>
</table>
</div>
<div class="table-title-outer">
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span><span><?php echo $lang["PROJECT_TITLE"];?></span></span></td>
    <td class="tcell-right"><div class="textarea-title"><?php echo($project->title);?></div></td>
  </tr>
  <tr class="table-title-status">
    <td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_STATUS"];?></td>
    <td colspan="2"><div class="statusTabs">
    	<ul>
        	<li><span class="left planned<?php echo $project->status_planned_active;?>" rel="0" reltext="<?php echo $lang["GLOBAL_STATUS_PLANNED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_PLANNED"];?></span></li>
            <li><span class="inprogress<?php echo $project->status_inprogress_active;?>" rel="1" reltext="<?php echo $lang["GLOBAL_STATUS_INPROGRESS_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_INPROGRESS"];?></span></li>
            <li><span class="finished<?php echo $project->status_finished_active;?>" rel="2" reltext="<?php echo $lang["GLOBAL_STATUS_FINISHED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_FINISHED"];?></span></li>
            <li><span class="right stopped<?php echo $project->status_stopped_active;?>" rel="3" reltext="<?php echo $lang["GLOBAL_STATUS_STOPPED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_STOPPED"];?></span></li>
            <li><div class="status-time"><?php echo($project->status_text_time)?></div><div class="status-input"><input name="phase_status_date" type="text" class="input-date statusdp" value="<?php echo($project->status_date)?>" readonly="readonly" /></div></li>
		</ul></div></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($project->canedit) { ?>coform <?php } ?>">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setProjectDetailsArchive">
<input type="hidden" name="id" value="<?php echo($project->id);?>">
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="content-nav showDialog" request="archiveMeta" field="status" append="1"><span><?php echo $lang["GLOBAL_METATAGS"];?></span></span></td>
    <td class="tcell-right"><div id="archiveMeta" class="itemlist-field"><?php echo($project->archive_meta);?></div></td>
  </tr>
</table>
</form>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_DURATION"];?></td>
		<td class="tcell-right-inactive"><span id="projectDurationStart"><?php echo($project->startdate)?></span> - <span id="projectDurationEnd"><?php echo($project->enddate)?></span></td>
    </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span><span><?php echo $lang['PROJECT_KICKOFF'];?></span></span></td>
		<td class="tcell-right"><?php echo($project->startdate)?></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span request="getProjectFolderDialog" field="projectsfolder" append="1"><span><?php echo $lang["PROJECT_FOLDER"];?></span></span></td>
        <td class="tcell-right"><div id="projectsfolder" class="itemlist-field"><?php echo($project->folder);?></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span request="getContactsDialog" field="projectsordered_by" append="0"><span><?php echo $lang["PROJECT_CLIENT"];?></span></span></td>
	  <td class="tcell-right"><div id="projectsordered_by" class="itemlist-field"><?php echo($project->ordered_by);?></div><div id="projectsordered_by_ct" class="itemlist-field"><a field="projectsordered_by_ct" class="ct-content"><?php echo($project->ordered_by_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span request="getContactsDialog" field="projectsmanagement" append="1"><span><?php echo $lang["PROJECT_MANAGEMENT"];?></span></span></td>
	  <td class="tcell-right"><div id="projectsmanagement" class="itemlist-field"><?php echo($project->management);?></div><div id="projectsmanagement_ct" class="itemlist-field"><a field="projectsmanagement_ct" class="ct-content"><?php echo($project->management_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span request="getContactsDialog" field="projectsteam" append="1"><span><?php echo $lang["PROJECT_TEAM"];?></span></span></td>
    <td class="tcell-right"><div id="projectsteam" class="itemlist-field"><?php echo($project->team);?></div><div id="projectsteam_ct" class="itemlist-field"><a field="projectsteam_ct" class="ct-content"><?php echo($project->team_ct);?></a></div></td>
  </tr>
</table>
<div class="content-spacer"></div>
<?php if($project->setting_costs == 1) { ?>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left-inactive text11"><?php echo $lang["PROJECT_COSTS_PLAN"];?></td>
    <td class="tcell-right-inactive"><?php echo $project->setting_currency;?> <?php echo $project->costs_plan_total;?></td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left-inactive text11"><?php echo $lang["PROJECT_COSTS_REAL"];?></td>
    <td class="tcell-right-inactive"><?php echo $project->setting_currency;?> <?php echo $project->costs_real_total;?></td>
  </tr>
</table>
<div class="content-spacer"></div>
<?php } ?>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span><span><?php echo $lang["PROJECT_DESCRIPTION"];?></span></span></td>
        <td class="tcell-right"><?php echo(nl2br(strip_tags($project->protocol)));?></td>
	</tr>
</table>
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
    <div class="loadProjectsPhaseArchive listOuter"  rel="<?php echo($phase->id);?>">
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
				echo '<div class="text11 toggleSendTo co-link">' . $value->who . ', ' . $value->date . '</div>' .
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
    <td class="left"><?php echo $lang["ARCHIVED_BY_ON"];?> <?php echo($project->archive_user.", ".$project->archive_time)?></td>
    <td class="middle"></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($project->created_user.", ".$project->created_date);?></td>
  </tr>
</table>
</div>
<div id="modalDialogArchiveRevive">
<div class="modalDialogArchiveReviveHeader"><div id="modalDialogArchiveReviveClose"><span class="icon-delete-white"></span></div></div>
<div id="modalDialogArchiveReviveInner">
    <div id="modalDialogArchiveReviveInnerContent">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td valign="top">
    <div class="content-spacer" style="height: 10px;"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="text11" style="width: 136px; padding: 0 15px 2px 0px;"><span class="content-nav showDialog" request="getProjectFolderArchiveDialog" field="archiveRevivefolder" append="1"><span style="padding: 0px 0px 0px 11px;"><?php echo $lang["PROJECT_FOLDER"];?></span></span></td>
        <td class="tcell-right"><div id="archiveRevivefolder" class="itemlist-field"></div></td>
	</tr>
</table>
    <div class="coButton-outer" style="margin: 5px 0 0 11px;"><span class="content-nav commandArchiveRevive coButton">Aktivieren</span></div>
    
    </td>
  </tr>
</table>
</div></div>
</div>
<div id="modalDialogArchiveDuplicate">
<div class="modalDialogArchiveDuplicateHeader"><div id="modalDialogArchiveDuplicateClose"><span class="icon-delete-white"></span></div></div>
<div id="modalDialogArchiveDuplicateInner">
    <div id="modalDialogArchiveDuplicateInnerContent">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td valign="top">
    <div class="content-spacer" style="height: 10px;"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="text11" style="width: 136px; padding: 0 15px 2px 0px;"><span class="content-nav showDialog" request="getProjectFolderArchiveDialog" field="archiveDuplicatefolder" append="1"><span style="padding: 0px 0px 0px 11px;"><?php echo $lang["PROJECT_FOLDER"];?></span></span></td>
        <td class="tcell-right"><div id="archiveDuplicatefolder" class="itemlist-field"></div></td>
	</tr>
</table>
<div class="coButton-outer" style="margin: 5px 0 0 11px;"><span class="content-nav commandArchiveDuplicate coButton">Duplizieren</span></div>
    
    </td>
  </tr>
</table>
</div></div>
</div>
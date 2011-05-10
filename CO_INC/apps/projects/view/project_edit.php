<div>
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($project->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["PROJECT_TITLE"];?></span></span></td>
    <td class="tcell-right"><?php if($project->canedit) { ?><input name="title" type="text" class="title textarea-title" value="<?php echo($project->title);?>" maxlength="100" /><?php } else { ?><div class="textarea-title"><?php echo($project->title);?></div><?php } ?></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($project->canedit) { ?>coform <?php } ?>">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setProjectDetails">
<input type="hidden" name="id" value="<?php echo($project->id);?>">
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_DURATION"];?></td>
		<td class="tcell-right-inactive"><span id="durationStart"><?php echo($project->startdate)?></span> - <span id="durationEnd"><?php echo($project->enddate)?></span></td>
    </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($project->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang['PROJECT_KICKOFF'];?></span></span></td>
		<td class="tcell-right"><?php if($project->canedit) { ?><input name="startdate" type="text" class="input-date datepicker" value="<?php echo($project->startdate)?>" /><input name="moveproject_start" type="hidden" value="<?php echo($project->startdate)?>" /><?php } else { ?><?php echo($project->startdate)?><?php } ?></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($project->canedit) { ?>content-nav showDialog<?php } ?>" request="getProjectFolderDialog" field="projectfolder" append="1"><span><?php echo $lang["PROJECT_FOLDER"];?></span></span></td>
        <td class="tcell-right"><div id="projectfolder" class="itemlist-field"><?php echo($project->projectfolder);?></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($project->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="ordered_by" append="0"><span><?php echo $lang["PROJECT_CLIENT"];?></span></span></td>
	  <td class="tcell-right"><div id="ordered_by" class="itemlist-field"><?php echo($project->ordered_by);?></div><div id="ordered_by_ct" class="itemlist-field"><a field="ordered_by_ct" class="ct-content"><?php echo($project->ordered_by_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($project->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="management" append="1"><span><?php echo $lang["PROJECT_MANAGEMENT"];?></span></span></td>
	  <td class="tcell-right"><div id="management" class="itemlist-field"><?php echo($project->management);?></div><div id="management_ct" class="itemlist-field"><a field="management_ct" class="ct-content"><?php echo($project->management_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($project->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="team" append="1"><span><?php echo $lang["PROJECT_TEAM"];?></span></span></td>
    <td class="tcell-right"><div id="team" class="itemlist-field"><?php echo($project->team);?></div><div id="team_ct" class="itemlist-field"><a field="team_ct" class="ct-content"><?php echo($project->team_ct);?></a></div></td>
  </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($project->canedit) { ?>content-nav showDialog<?php } ?>" request="getProjectStatusDialog" field="status" append="1"><span><?php echo $lang["GLOBAL_STATUS"];?></span></span></td>
        <td class="tcell-right"><div id="status" class="itemlist-field"><div class="listmember" field="status" uid="<?php echo($project->status);?>" style="float: left"><?php echo($project->status_text);?></div></div><?php if($project->canedit) { ?><input name="status_date" type="text" class="input-date datepicker status_date" value="<?php echo($project->status_date)?>" style="float: left; margin-left: 8px;" /><?php } else { ?><div style="float: left; margin-left: 8px;"><?php echo($project->status_date)?><?php } ?></div></td>
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
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive loadPhase" rel="<?php echo($phase->id);?>">
	<tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right"><span class="loadPhase bold co-link" rel="<?php echo($phase->id);?>"><?php echo($num[$phase->id] . " " . $phase->title);?></span></td>
	</tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right">
        <span class="text11 content-date"><?php echo $lang["GLOBAL_DURATION"];?></span><span class="text11"><?php echo($phase->startdate . " - " . $phase->enddate);?></span>
</td>
	</tr>
</table>
    <?php 
	$i++;
	}
}
?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="project_sendto">
        <?php 
			foreach($sendto as $value) { 
			if(!empty($value->who)) {
				echo '<div class="text11">' . $value->who . ', ' . $value->date . '</div>';
			}
		 } ?></div></td>
    </tr>
</table>
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
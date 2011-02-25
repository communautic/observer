<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td width="140"><?php echo $lang["PROJECT_TITLE"];?></td>
    <td><?php echo($project->title);?></td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>Dauer</td>
		<td><?php echo($project->startdate)?> - <?php echo($project->enddate)?></td>
    </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
	  <td><?php echo PROJECT_KICKOFF;?></td>
		<td><?php echo($project->startdate)?></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
	  <td><?php echo PROJECT_FOLDER_RIGHT;?></td>
        <td><?php echo($project->projectfolder);?></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	  <td><?php echo PROJECT_MANAGEMENT;?></td>
	  <td><?php echo($project->management);?><br />
<?php echo($project->management_ct);?></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><a href="#" class="content-nav showDialog" request="getContactsDialog" field="team" append="1"><span><?php echo PROJECT_TEAM;?></span></a></td>
    <td><div id="team" class="itemlist-field"><?php echo($project->team);?></div><div id="team_ct" class="itemlist-field"><a field="team_ct" class="ct-content"><?php echo($project->team_ct);?></a></div></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
	  <td><a href="<?php echo $lang["GLOBAL_STATUS"];?>" class="content-nav showDialog" request="getProjectStatusDialog" field="status" title="<?php echo $lang["GLOBAL_STATUS"];?>" append="1"><span><?php echo $lang["GLOBAL_STATUS"];?></span></a></td>
        <td><div id="status" class="itemlist-field"><div class="listmember" field="status" uid="<?php echo($project->status);?>" style="float: left"><?php echo($project->status_text);?></div></div><?php echo($project->status_date)?></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td><span class="content-nav"><?php echo PROJECT_DESCRIPTION;?></span></td>
    <td><div class="protocol-outer" style="position: relative;"><div id="protocol" class="tinymce" style="min-height: 26px;"><?php echo($project->protocol);?></div></div></td>
    </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><span class="content-nav">Phasen</span></a></td>
    <td>&nbsp;</td>
    </tr>
</table>
<?php
if(is_array($phases)) {
	$i = 1;
	foreach ($phases as $phase) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive">
	<tr>
		<td>&nbsp;</td>
		<td><?php echo($num[$phase->id] . " " . $phase->title);?></td>
	</tr>
    <tr>
		<td>&nbsp;</td>
		<td>
        <span class="text11 content-date">Dauer</span><span class="text11"><?php echo($phase->startdate . " - " . $phase->enddate);?></span>
</td>
	</tr>
</table>
    <?php 
	$i++;
	}
}
?>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($project->edited_user.", ".$project->edited_date)?></td>
    <td class="middle"></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($project->created_user.", ".$project->created_date);?></td>
  </tr>
</table>
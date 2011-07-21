<div>
<div id="projects_folder-action-new" style="display: none"><?php echo $lang["PROJECT_FOLDER_ACTION_NEW"];?></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($folder->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["PROJECT_FOLDER"];?></span></span></td>
		<td><?php if($folder->canedit) { ?><input name="title" type="text" class="title textarea-title" value="<?php echo($folder->title);?>" maxlength="100" /><?php } else { ?><div class="textarea-title"><?php echo($folder->title);?></div><?php } ?></td>
	</tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<?php if($folder->access == "sysadmin") { ?>
<form action="/" method="post" name="coform" class="<?php if($folder->canedit) { ?>coform <?php } ?>">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setFolderDetails">
<input type="hidden" name="id" value="<?php echo($folder->id);?>">
<input name="projectstatus" type="hidden" value="0" />
</form>

<div style="height: 125px;" class="text11">
<div style="height: 26px;" class="tbl-inactive"></div>
<div style="position: relative; float: left; width: 150px; margin: -26px 9px 0 9px">
	<div style="height: 26px; background-color:#c3c3c3">
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px;" width="130"><?php echo $lang["PROJECT_FOLDER_PROJECTS_CREATED"];?></td>
    <td class="text11" style="padding: 3px 0 0 0"><?php echo($folder->allprojects);?></td>
  </tr>
</table>
</div>
    <div>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px" width="130"><?php echo $lang["PROJECT_FOLDER_PROJECTS_PLANNED"];?></td>
    <td class="text11" style="padding: 3px 0 0 0"><?php echo($folder->plannedprojects);?></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px" width="130"><?php echo $lang["PROJECT_FOLDER_PROJECTS_RUNNING"];?></td>
    <td class="text11" style="padding: 3px 0 0 0"><?php echo($folder->activeprojects);?></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px" width="130"><?php echo $lang["PROJECT_FOLDER_PROJECTS_FINISHED"];?></td>
    <td class="text11" style="padding: 3px 0 0 0"><?php echo $folder->inactiveprojects;?></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px" width="130"><?php echo $lang["PROJECT_FOLDER_PROJECTS_STOPPED"];?></td>
    <td class="text11" style="padding: 3px 0 0 0"><?php echo $folder->stoppedprojects;?></td>
  </tr>
</table>
    </div>
</div>
<?php  $this->getChartFolder($folder->id,'stability');?>
</div>
<div style="height: 125px;" class="text11">
<div style="height: 26px;" class="tbl-inactive"></div>
<?php  $this->getChartFolder($folder->id,'realisation');?>
<?php  $this->getChartFolder($folder->id,'timeing');?>
<?php  $this->getChartFolder($folder->id,'tasks');?>
</div>
<!--
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><a href="time" class="content-nav showDialogTime" rel="meetingstart" title="Zeit"><span><?php echo $lang["GLOBAL_STATUS"];?></span></a></td>
    <td  class="tcell-right">
      <table  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="23" valign="top"><input name="projectstatus" type="radio" value="0"<?php //echo($active);?> class="jNiceHidden" />
          </td>
          <td width="70" valign="top"><?php echo $lang["PROJECT_FOLDER_STATUS_ACTIVE"];?></td>
          <td width="23" valign="top"><input name="projectstatus" type="radio" value="1"<?php //echo($archiv);?> class="jNiceHidden" /></td>
          <td valign="top"><?php echo $lang["PROJECT_FOLDER_STATUS_ARCHIVE"];?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>-->
<div class="content-spacer"></div>
<div class="content-spacer"></div>
<?php } ?>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PROJECT_PROJECTS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php
if(is_array($projects)) {
	foreach ($projects as $project) { 
	?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive loadProject" rel="<?php echo($project->id);?>">
	<tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td colspan="3" class="tcell-right"><span class="loadProject bold co-link" rel="<?php echo($project->id);?>"><?php echo($project->title);?></span></td>
    	</tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right" width="220"><span class="text11 content-date"><?php echo $lang["GLOBAL_DURATION"];?></span><span class="text11"><?php echo($project->startdate . " - " . $project->enddate);?></span></td>
    	<td class="tcell-right" width="190"><?php if($project->perm != "guest") { ?><span class="text11"><span style="display: inline; margin-right: 20px;">Realisierungsgrad</span><?php echo($project->realisation["real"]);?>%</span><?php } ?></td>
    	<td class="tcell-right"><span class="text11"><span style="display: inline; margin-right: 20px;">Projektleitung</span><?php echo($project->management);?></span></td>
    </tr>
</table>
    <?php 
	}
}
?>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo($lang["GLOBAL_FOOTER_STATUS"] . " " . $folder->today);?></td>
    <td class="middle"></td>
    <td class="right"></td>
  </tr>
</table>
</div>
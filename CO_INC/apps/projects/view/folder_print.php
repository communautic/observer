<div>
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
	<tr>
		<td class="tcell-left text11"><span class="content-nav"><?php echo $lang["PROJECT_FOLDER"];?></span></td>
		<td><input type="text" name="title" class="title textarea-title" value="<?php echo($folder->title);?>" /></td>
	</tr>
</table>
</div>
<div class="ui-layout-content scroll-pane">

<form action="<?php echo $this->form_url;?>" method="post" name="coform" class="coform jNice">
<input type="hidden" id="poformaction" name="request" value="setFolderDetails">
<input type="hidden" name="id" value="<?php echo($folder->id);?>">
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="content-nav"><?php echo PROJECT_FOLDER_PROJECTS_CREATED;?></span></td>
    <td class="tcell-right"><?php echo($folder->allprojects);?>&nbsp;</td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="content-nav"><?php echo PROJECT_FOLDER_PROJECTS_PLANNED;?></span></td>
    <td class="tcell-right"><?php echo($folder->plannedprojects);?>&nbsp;</td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="content-nav"><?php echo PROJECT_FOLDER_PROJECTS_RUNNING;?></span></td>
    <td class="tcell-right"><?php echo($folder->activeprojects);?>&nbsp;</td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="content-nav"><?php echo PROJECT_FOLDER_PROJECTS_FINISHED;?></span></td>
    <td class="tcell-right"><?php echo $folder->inactiveprojects;?>&nbsp;</td>
  </tr>
</table>
<input name="projectstatus" type="hidden" value="0" />
<!--
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><a href="time" class="content-nav showDialogTime" rel="meetingstart" title="Zeit"><span><?php echo $lang["PROJECT_STATUS"];?></span></a></td>
    <td  class="tcell-right">
      <table  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="23" valign="top"><input name="projectstatus" type="radio" value="0"<?php //echo($active);?> class="jNiceHidden" />
          </td>
          <td width="70" valign="top"><?php echo PROJECT_FOLDER_STATUS_ACTIVE;?></td>
          <td width="23" valign="top"><input name="projectstatus" type="radio" value="1"<?php //echo($archiv);?> class="jNiceHidden" /></td>
          <td valign="top"><?php echo PROJECT_FOLDER_STATUS_ARCHIVE;?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>-->
</form>
<!--<table border="0" cellspacing="0" cellpadding="0" class="table-content">
    <tr>
    <td class="tcell-left text11"><span class="content-nav">Benutzer eingeloggt</span></td>
    <td class="tcell-right">Ebenbichler Michael, Randolf Gunharth</td>
  </tr>
</table>-->
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="tcell-left text11"><span class="content-nav"><?php  $this->getChart($folder->id,'realisation');?></span></a></td>
		<td class="tcell-left text11"><span class="content-nav"><?php  $this->getChart($folder->id,'tasks');?></span></a></td>
    	<td class="tcell-left text11"><span class="content-nav"><?php  $this->getChart($folder->id,'tasksontime');?></span></a></td>
    </tr>
</table>

<!--<img src="https://chart.googleapis.com/chart?cht=p3&chd=t:60,40&chs=150x90&chco=82aa0b&chf=bg,s,FFFFFF" alt="Teilnehmern" title="Teilnehmern"/>-->

<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="tcell-left text11"><span class="content-nav">Projekte</span></a></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php
if(is_array($projects)) {
	foreach ($projects as $project) { 
	?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive">
	<tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right"><a href="#" class="loadProject bold" rel="<?php echo($project->id);?>"><?php echo($project->title);?></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right">
        <span class="text11 content-date">Dauer</span><span class="text11"><?php echo($project->startdate . " - " . $project->enddate);?></span>
</td>
	</tr>
</table>
    <?php 
	}
}
?>
<img src="/home/dev/public_html/data/charts/some_chart_image.png" width="500" height="50" /></div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($folder->edited_user.", ".$folder->edited_date)?></td>
    <td class="middle"></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($folder->created_user.", ".$folder->created_date);?></td>
  </tr>
</table>
</div>
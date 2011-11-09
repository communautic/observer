<div>
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($folder->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["CLIENT_FOLDER"];?></span></span></td>
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
<input name="clientstatus" type="hidden" value="0" />
</form>
<!--
<div style="height: 125px;" class="text11">
<div style="height: 26px;" class="tbl-inactive"></div>
<div style="position: relative; float: left; width: 150px; margin: -26px 9px 0 9px">
	<div style="height: 26px; background-color:#c3c3c3">
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px;" width="120"><?php echo $lang["CLIENT_FOLDER_CLIENTS_CREATED"];?></td>
    <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo($folder->allclients);?></td>
  </tr>
</table>
</div>
    <div>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px" width="120"><?php echo $lang["CLIENT_FOLDER_CLIENTS_PLANNED"];?></td>
    <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo($folder->plannedclients);?></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px" width="120"><?php echo $lang["CLIENT_FOLDER_CLIENTS_RUNNING"];?></td>
    <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo($folder->activeclients);?></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px" width="120"><?php echo $lang["CLIENT_FOLDER_CLIENTS_FINISHED"];?></td>
    <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo $folder->inactiveclients;?></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px" width="120"><?php echo $lang["CLIENT_FOLDER_CLIENTS_STOPPED"];?></td>
    <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo $folder->stoppedclients;?></td>
  </tr>
</table>
    </div>
</div>

<?php  //$this->getChartFolder($folder->id,'stability');?>
<?php  //$this->getChartFolder($folder->id,'status',0,1);?>
</div>
<div style="height: 125px;" class="text11">
<div style="height: 26px;" class="tbl-inactive"></div>
<?php  //$this->getChartFolder($folder->id,'realisation');?>
<?php  //$this->getChartFolder($folder->id,'timeing');?>
<?php  //$this->getChartFolder($folder->id,'tasks');?>

</div>-->
<!--
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><a href="time" class="content-nav showDialogTime" rel="meetingstart" title="Zeit"><span><?php echo $lang["GLOBAL_STATUS"];?></span></a></td>
    <td  class="tcell-right">
      <table  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="23" valign="top"><input name="clientstatus" type="radio" value="0"<?php //echo($active);?> class="jNiceHidden" />
          </td>
          <td width="70" valign="top"><?php echo $lang["CLIENT_FOLDER_STATUS_ACTIVE"];?></td>
          <td width="23" valign="top"><input name="clientstatus" type="radio" value="1"<?php //echo($archiv);?> class="jNiceHidden" /></td>
          <td valign="top"><?php echo $lang["CLIENT_FOLDER_STATUS_ARCHIVE"];?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<div class="content-spacer"></div>
<div class="content-spacer"></div>-->
<?php } ?>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["CLIENT_CLIENTS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php
if(is_array($clients)) {
	foreach ($clients as $client) { 
	?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive loadClient" rel="<?php echo($client->id);?>">
	<tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right"><span class="loadClient bold co-link" rel="<?php echo($client->id);?>"><?php echo($client->title);?></span></td>
    	</tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right"><span class="text11"><span class="text11"><span style="display: inline; margin-right: 20px;"><?php echo $lang["CLIENT_MANAGEMENT"];?></span><?php echo($client->management);?></span></td>
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
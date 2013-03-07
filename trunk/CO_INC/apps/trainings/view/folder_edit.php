<div class="table-title-outer">

<table border="0" cellpadding="0" cellspacing="0" class="table-title">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($folder->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["TRAINING_FOLDER"];?></span></span></td>
		<td><?php if($folder->canedit) { ?><input name="title" type="text" class="title textarea-title" value="<?php echo($folder->title);?>" maxlength="100" /><?php } else { ?><div class="textarea-title"><?php echo($folder->title);?></div><?php } ?></td>
	</tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane contentTabsStyle"">
<?php if($folder->access == "sysadmin") { ?>
<form action="/" method="post" name="coform" class="<?php if($folder->canedit) { ?>coform <?php } ?>">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setFolderDetails">
<input type="hidden" name="id" value="<?php echo($folder->id);?>">
<input name="trainingstatus" type="hidden" value="0" />
</form>
<?php } ?>
<div id="trainingsFoldersTabs" class="contentTabs">
	<ul class="contentTabsList">
		<li><span class="active" rel="FolderDetailsList"><?php echo $lang["TRAINING_FOLDER_TAB_TRAININGS"];?></span></li>
		<li><span rel="FolderDetailsMultiView"><?php echo $lang["TRAINING_FOLDER_TAB_MULTIVIEW"];?></span></li>
        <?php if($folder->access == "sysadmin") { ?>
		<li><span rel="FolderDetailsStatus"><?php echo $lang["TRAINING_FOLDER_TAB_STATUS"];?></span></li>
        <?php } ?>
	</ul>
    <div id="trainingsFoldersTabsContent" class="contentTabsContent">
    <?php include('folder_edit_list.php');?>
    </div>
</div>

</div>
</div>
<div class="table-footer-outer">
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo($lang["GLOBAL_FOOTER_STATUS"] . " " . $folder->today);?></td>
    <td class="middle"></td>
    <td class="right"></td>
  </tr>
</table>
</div>
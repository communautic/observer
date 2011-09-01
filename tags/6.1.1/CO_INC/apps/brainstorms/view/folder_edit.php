<div>
<div id="brainstorms_folder-action-new" style="display: none"><?php echo $lang["BRAINSTORM_FOLDER_ACTION_NEW"];?></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($folder->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["BRAINSTORM_FOLDER"];?></span></span></td>
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
<input name="brainstormstatus" type="hidden" value="0" />
</form>
<div class="content-spacer"></div>
<?php } ?>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["BRAINSTORM_BRAINSTORMS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php
if(is_array($brainstorms)) {
	foreach ($brainstorms as $brainstorm) { 
	?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive loadBrainstorm" rel="<?php echo($brainstorm->id);?>">
	<tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td colspan="2" class="tcell-right"><span class="loadBrainstorm bold co-link" rel="<?php echo($brainstorm->id);?>"><?php echo($brainstorm->title);?></span></td>
    	</tr>
	    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right" width="180"><span class="text11"><?php echo $lang["BRAINSTORM_FOLDER_CREATED_ON"];?> <?php echo($brainstorm->created_date);?></span></td>
        <td class="tcell-right"><span class="text11"><?php echo $lang["BRAINSTORM_FOLDER_INITIATOR"];?> <?php echo($brainstorm->created_user);?></span></td>

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
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($folder->edited_user.", ".$folder->edited_date)?></td>
    <td class="middle"></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($folder->created_user.", ".$folder->created_date);?></td>
  </tr>
</table>
</div>
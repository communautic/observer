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
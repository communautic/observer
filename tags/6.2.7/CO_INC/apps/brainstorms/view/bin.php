<div class="table-title-outer">
<table border="0" cellspacing="0" cellpadding="0" class="table-title grey">
  <tr>
    <td class="tcell-left text11"><span class="content-nav"><?php echo $lang["BIN_TITLE"];?></span></td>
    <td></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">

<?php if(is_array($arr["folders"])) { ?>
    <table border="0" cellpadding="0" cellspacing="0" class="table-content">
        <tr>
            <td class="tcell-left-inactive text11"><?php echo $lang["BRAINSTORM_FOLDER"];?></td>
        <td class="tcell-right">&nbsp;</td>
        </tr>
    </table>
<?php foreach ($arr["folders"] as $folder) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="folder_<?php echo($folder->id);?>" rel="<?php echo($folder->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["BRAINSTORM_FOLDER"];?></span></td>
		<td class="tcell-right"><?php echo($folder->title);?></td>
        <td width="30"><a href="brainstorms_folder" class="binRestore" rel="<?php echo $folder->id;?>"><span class="icon-restore"></span></a></td>
        <td width="30"><a href="brainstorms_folder" class="binDelete" rel="<?php echo $folder->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($folder->binuser . ", " .$folder->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>


<?php if(is_array($arr["pros"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["BRAINSTORM_BRAINSTORMS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["pros"] as $brainstorm) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="brainstorm_<?php echo($brainstorm->id);?>" rel="<?php echo($brainstorm->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["BRAINSTORM_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($brainstorm->title);?></td>
        <td width="30"><a href="brainstorms" class="binRestore" rel="<?php echo $brainstorm->id;?>"><span class="icon-restore"></span></a></td>
        <td width="30"><a href="brainstorms" class="binDelete" rel="<?php echo $brainstorm->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($brainstorm->binuser . ", " .$brainstorm->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>

<?php if(is_array($arr["brainstorms_tasks"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang['BRAINSTORM_TITLE_NOTES_BIN'];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["brainstorms_tasks"] as $brainstorm_task) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="brainstorm_task_<?php echo($brainstorm->id);?>" rel="<?php echo($brainstorm->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang['BRAINSTORM_NOTE_BIN'];?></span></td>
		<td class="tcell-right"><?php echo($brainstorm_task->title);?></td>
        <td width="30"><a href="brainstorms" class="binRestoreItem" rel="<?php echo $brainstorm_task->id;?>"><span class="icon-restore"></span></a></td>
        <td width="30"><a href="brainstorms" class="binDeleteItem" rel="<?php echo $brainstorm_task->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($brainstorm_task->binuser . ", " .$brainstorm_task->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>

<?php
	foreach($brainstorms->modules as $module => $value) {
		if(CONSTANT('brainstorms_'.$module.'_bin') == 1) {
			include(CO_INC . "/apps/brainstorms/modules/".$module."/view/bin.php");
		}
	}
?>

</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo($lang["GLOBAL_FOOTER_STATUS"] . " " . $bin["datetime"]);?></td>
    <td class="middle"></td>
    <td class="right"></td>
  </tr>
</table>
</div>
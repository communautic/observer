<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-title grey">
  <tr>
    <td class="tcell-left text11"><span class="content-nav"><?php echo $lang["BIN_TITLE"];?></span></td>
    <td></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<?php
if(is_array($folders)) {
	foreach ($folders as $folder) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" rel="<?php echo($folder->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PROJECT_FOLDER"];?></span></td>
		<td class="tcell-right"><?php echo($folder->title);?></td>
        <td width="30"><a href="#" class="deleteDoc" rel="<?php echo $value->id;?>"><span class="icon-delete"></span></a></td>
        <td width="30"><a href="#" class="deleteDoc" rel="<?php echo $value->id;?>"><span class="icon-delete"></span></a></td>
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
<div class="content-spacer"></div>
<?php
if(is_array($projects)) {
	foreach ($projects as $project) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" rel="<?php echo($project->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PROJECT_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($project->title);?></td>
        <td width="30"><a href="#" class="deleteDoc" rel="<?php echo $value->id;?>"><span class="icon-delete"></span></a></td>
        <td width="30"><a href="#" class="deleteDoc" rel="<?php echo $value->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($project->binuser . ", " .$project->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}


/*foreach($this->modules as $module  => $value) {
	include_once(CO_INC . "/apps/projects/modules/" . $module . "/controller.php");
	if($module->binDisplay) {
		echo($module);
	}
}*/


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
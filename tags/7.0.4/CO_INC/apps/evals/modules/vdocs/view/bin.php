
<?php if(is_array($arr["vdocs"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["EVAL_VDOC_VDOCS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["vdocs"] as $vdoc) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="vdoc_<?php echo($vdoc->id);?>" rel="<?php echo($vdoc->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["EVAL_VDOC_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($vdoc->title);?></td>
        <td width="25"><a href="evals_vdocs" class="binRestore" rel="<?php echo $vdoc->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="evals_vdocs" class="binDelete" rel="<?php echo $vdoc->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($vdoc->binuser . ", " .$vdoc->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>


<?php if(is_array($arr["vdocs_tasks"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["EVAL_VDOC_GOALS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["vdocs_tasks"] as $vdoc_task) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="vdoc_task_<?php echo($vdoc_task->id);?>" rel="<?php echo($vdoc_task->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["EVAL_VDOC_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($vdoc_task->title);?></td>
        <td width="25"><a href="#" class="bin-restoreVDocTask" rel="<?php echo $vdoc_task->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="#" class="bin-deleteVDocTask" rel="<?php echo $vdoc_task->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($vdoc_task->binuser . ", " .$vdoc_task->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>
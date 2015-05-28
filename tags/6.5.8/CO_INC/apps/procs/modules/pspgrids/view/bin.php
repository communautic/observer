
<?php if(is_array($arr["pspgrids"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PROC_PSPGRIDS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["pspgrids"] as $pspgrid) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="pspgrid_<?php echo($pspgrid->id);?>" rel="<?php echo($pspgrid->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PROC_PSPGRID_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($pspgrid->title);?></td>
        <td width="25"><a href="procs_pspgrids" class="binRestore" rel="<?php echo $pspgrid->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="procs_pspgrids" class="binDelete" rel="<?php echo $pspgrid->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($pspgrid->binuser . ", " .$pspgrid->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>


<?php if(is_array($arr["pspgrids_cols"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PROC_PSPGRID_COLUMNS_BIN"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["pspgrids_cols"] as $pspgrid_col) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="pspgrid_col_<?php echo($pspgrid_col->id);?>" rel="<?php echo($pspgrid_col->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PROC_PSPGRID_NOTES"];?></span></td>
		<td class="tcell-right"><?php echo($pspgrid_col->items);?></td>
        <td width="25"><a href="procs_pspgrids" class="binRestoreColumn" rel="<?php echo $pspgrid_col->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="procs_pspgrids" class="binDeleteColumn" rel="<?php echo $pspgrid_col->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($pspgrid_col->binuser . ", " .$pspgrid_col->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>

<?php if(is_array($arr["pspgrids_tasks"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PROC_PSPGRID_NOTES_BIN"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["pspgrids_tasks"] as $pspgrid_task) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="pspgrid_task_<?php echo($pspgrid_task->id);?>" rel="<?php echo($pspgrid_task->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PROC_PSPGRID_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($pspgrid_task->title);?></td>
        <td width="25"><a href="procs_pspgrids" class="binRestoreItem" rel="<?php echo $pspgrid_task->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="procs_pspgrids" class="binDeleteItem" rel="<?php echo $pspgrid_task->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($pspgrid_task->binuser . ", " .$pspgrid_task->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>

<?php if(is_array($arr["grids"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["COMPLAINT_GRIDS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["grids"] as $grid) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="grid_<?php echo($grid->id);?>" rel="<?php echo($grid->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["COMPLAINT_GRID_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($grid->title);?></td>
        <td width="30"><a href="complaints_grids" class="binRestore" rel="<?php echo $grid->id;?>"><span class="icon-restore"></span></a></td>
        <td width="30"><a href="complaints_grids" class="binDelete" rel="<?php echo $grid->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($grid->binuser . ", " .$grid->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>


<?php if(is_array($arr["grids_cols"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["COMPLAINT_GRID_COLUMNS_BIN"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["grids_cols"] as $grid_col) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="grid_col_<?php echo($grid_col->id);?>" rel="<?php echo($grid_col->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["COMPLAINT_GRID_NOTES"];?></span></td>
		<td class="tcell-right"><?php echo($grid_col->items);?></td>
        <td width="30"><a href="complaints_grids" class="binRestoreColumn" rel="<?php echo $grid_col->id;?>"><span class="icon-restore"></span></a></td>
        <td width="30"><a href="complaints_grids" class="binDeleteColumn" rel="<?php echo $grid_col->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($grid_col->binuser . ", " .$grid_col->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>

<?php if(is_array($arr["grids_tasks"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["COMPLAINT_GRID_NOTES_BIN"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["grids_tasks"] as $grid_task) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="grid_task_<?php echo($grid_task->id);?>" rel="<?php echo($grid_task->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["COMPLAINT_GRID_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($grid_task->title);?></td>
        <td width="30"><a href="complaints_grids" class="binRestoreItem" rel="<?php echo $grid_task->id;?>"><span class="icon-restore"></span></a></td>
        <td width="30"><a href="complaints_grids" class="binDeleteItem" rel="<?php echo $grid_task->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($grid_task->binuser . ", " .$grid_task->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>
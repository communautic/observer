
<?php if(is_array($arr["drawings"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PROC_DRAWINGS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["drawings"] as $drawing) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="drawing_<?php echo($drawing->id);?>" rel="<?php echo($drawing->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PROC_DRAWING_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($drawing->title);?></td>
        <td width="25"><a href="procs_drawings" class="binRestore" rel="<?php echo $drawing->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="procs_drawings" class="binDelete" rel="<?php echo $drawing->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($drawing->binuser . ", " .$drawing->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>

<?php if(is_array($arr["drawings_diags"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PROC_DRAWING_DIAGNOSES"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["drawings_diags"] as $drawing_diag) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="drawing_diag_<?php echo($drawing_diag->id);?>" rel="<?php echo($drawing_diag->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PROC_DRAWING_DIAGNOSE"];?></span></td>
		<td class="tcell-right"><?php echo($drawing_diag->text);?></td>
        <td width="25"><a href="procs_drawings" class="binRestoreColumn" rel="<?php echo $drawing_diag->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="procs_drawings" class="binDeleteColumn" rel="<?php echo $drawing_diag->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($drawing_diag->binuser . ", " .$drawing_diag->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>

<?php if(is_array($arr["drawings_tasks"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PROC_DRAWING_GOALS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["drawings_tasks"] as $drawing_task) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="drawing_task_<?php echo($drawing_task->id);?>" rel="<?php echo($drawing_task->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PROC_DRAWING_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($drawing_task->title);?></td>
        <td width="25"><a href="procs_drawings" class="binRestoreItem" rel="<?php echo $drawing_task->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="procs_drawings" class="binDeleteItem" rel="<?php echo $drawing_task->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($drawing_task->binuser . ", " .$drawing_task->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>
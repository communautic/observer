
<?php if(is_array($arr["objectives"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["EVAL_OBJECTIVES"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["objectives"] as $objective) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="objective_<?php echo($objective->id);?>" rel="<?php echo($objective->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["EVAL_OBJECTIVE_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($objective->title);?></td>
        <td width="25"><a href="evals_objectives" class="binRestore" rel="<?php echo $objective->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="evals_objectives" class="binDelete" rel="<?php echo $objective->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($objective->binuser . ", " .$objective->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>


<?php if(is_array($arr["objectives_tasks"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["EVAL_OBJECTIVE_GOALS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["objectives_tasks"] as $objective_task) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="objective_task_<?php echo($objective_task->id);?>" rel="<?php echo($objective_task->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["EVAL_OBJECTIVE_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($objective_task->title);?></td>
        <td width="25"><a href="evals_objectives" class="binRestoreItem" rel="<?php echo $objective_task->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="evals_objectives" class="binDeleteItem" rel="<?php echo $objective_task->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($objective_task->binuser . ", " .$objective_task->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>
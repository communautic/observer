<?php if(is_array($arr["phases"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PROJECT_PHASES"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["phases"] as $phase) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="phase_<?php echo($phase->id);?>" rel="<?php echo($phase->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PHASE_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($phase->title);?></td>
        <td width="30"><a href="#" class="bin-restorePhase" rel="<?php echo $phase->id;?>"><span class="icon-restore"></span></a></td>
        <td width="30"><a href="#" class="bin-deletePhase" rel="<?php echo $phase->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($phase->binuser . ", " .$phase->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>


<?php if(is_array($arr["tasks"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PHASE_TASK_MILESTONE"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["tasks"] as $task) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="phase_task_<?php echo($task->id);?>" rel="<?php echo($task->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PHASE_TASK_MILESTONE"];?></span></td>
		<td class="tcell-right"><?php echo($task->text);?></td>
        <td width="30"><a href="#" class="bin-restorePhaseTask" rel="<?php echo $task->id;?>"><span class="icon-restore"></span></a></td>
        <td width="30"><a href="#" class="bin-deletePhaseTask" rel="<?php echo $task->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($task->binuser . ", " .$task->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>


<?php if(is_array($arr["rosters"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["BRAINSTORM_ROSTERS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["rosters"] as $roster) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="roster_<?php echo($roster->id);?>" rel="<?php echo($roster->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["BRAINSTORM_ROSTER_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($roster->title);?></td>
        <td width="30"><a href="brainstorms_rosters" class="binRestore" rel="<?php echo $roster->id;?>"><span class="icon-restore"></span></a></td>
        <td width="30"><a href="brainstorms_rosters" class="binDelete" rel="<?php echo $roster->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($roster->binuser . ", " .$roster->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>


<?php if(is_array($arr["rosters_tasks"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["BRAINSTORM_ROSTER_GOALS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["rosters_tasks"] as $roster_task) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="roster_task_<?php echo($roster_task->id);?>" rel="<?php echo($roster_task->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["BRAINSTORM_ROSTER_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($roster_task->title);?></td>
        <td width="30"><a href="brainstorms_rosters" class="binRestoreItem" rel="<?php echo $roster_task->id;?>"><span class="icon-restore"></span></a></td>
        <td width="30"><a href="brainstorms_rosters" class="binDeleteItem" rel="<?php echo $roster_task->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($roster_task->binuser . ", " .$roster_task->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>
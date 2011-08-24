<?php if(is_array($arr["forums"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["BRAINSTORM_FORUMS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["forums"] as $forum) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="forum_<?php echo($forum->id);?>" rel="<?php echo($forum->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["BRAINSTORM_FORUM_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($forum->title);?></td>
        <td width="30"><a href="brainstorms_forums" class="binRestore" rel="<?php echo $forum->id;?>"><span class="icon-restore"></span></a></td>
        <td width="30"><a href="brainstorms_forums" class="binDelete" rel="<?php echo $forum->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($forum->binuser . ", " .$forum->bintime)?></td>
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
		<td class="tcell-left-inactive text11"><?php echo $lang["BRAINSTORM_FORUM_TASK_MILESTONE"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["tasks"] as $task) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="forum_task_<?php echo($task->id);?>" rel="<?php echo($task->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["BRAINSTORM_FORUM_TASK_MILESTONE"];?></span></td>
		<td class="tcell-right"><?php echo($task->text);?></td>
        <td width="30"><a href="brainstorms_forums" class="binRestoreItem" rel="<?php echo $task->id;?>"><span class="icon-restore"></span></a></td>
        <td width="30"><a href="brainstorms_forums" class="binDeleteItem" rel="<?php echo $task->id;?>"><span class="icon-delete"></span></a></td>
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

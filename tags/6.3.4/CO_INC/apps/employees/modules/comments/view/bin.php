
<?php if(is_array($arr["comments"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["EMPLOYEE_COMMENTS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["comments"] as $comment) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="comment_<?php echo($comment->id);?>" rel="<?php echo($comment->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["EMPLOYEE_COMMENT_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($comment->title);?></td>
        <td width="30"><a href="employees_comments" class="binRestore" rel="<?php echo $comment->id;?>"><span class="icon-restore"></span></a></td>
        <td width="30"><a href="employees_comments" class="binDelete" rel="<?php echo $comment->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($comment->binuser . ", " .$comment->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>


<?php if(is_array($arr["comments_tasks"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["EMPLOYEE_COMMENT_GOALS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["comments_tasks"] as $comment_task) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="comment_task_<?php echo($comment_task->id);?>" rel="<?php echo($comment_task->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["EMPLOYEE_COMMENT_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($comment_task->title);?></td>
        <td width="30"><a href="employees_comments" class="binRestoreItem" rel="<?php echo $comment_task->id;?>"><span class="icon-restore"></span></a></td>
        <td width="30"><a href="employees_comments" class="binDeleteItem" rel="<?php echo $comment_task->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($comment_task->binuser . ", " .$comment_task->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>

<?php if(is_array($arr["feedbacks"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["TRAINING_FEEDBACKS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["feedbacks"] as $feedback) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="feedback_<?php echo($feedback->id);?>" rel="<?php echo($feedback->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["TRAINING_FEEDBACK_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($feedback->title);?></td>
        <td width="25"><a href="trainings_feedbacks" class="binRestore" rel="<?php echo $feedback->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="trainings_feedbacks" class="binDelete" rel="<?php echo $feedback->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($feedback->binuser . ", " .$feedback->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>


<?php if(is_array($arr["feedbacks_tasks"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["TRAINING_FEEDBACK_GOALS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["feedbacks_tasks"] as $feedback_task) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="feedback_task_<?php echo($feedback_task->id);?>" rel="<?php echo($feedback_task->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["TRAINING_FEEDBACK_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($feedback_task->title);?></td>
        <td width="25"><a href="trainings_feedbacks" class="binRestoreItem" rel="<?php echo $feedback_task->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="trainings_feedbacks" class="binDeleteItem" rel="<?php echo $feedback_task->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($feedback_task->binuser . ", " .$feedback_task->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>
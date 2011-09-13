
<?php if(is_array($arr["meetings"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PROJECT_MEETINGS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["meetings"] as $meeting) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="meeting_<?php echo($meeting->id);?>" rel="<?php echo($meeting->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PROJECT_MEETING_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($meeting->title);?></td>
        <td width="30"><a href="projects_meetings" class="binRestore" rel="<?php echo $meeting->id;?>"><span class="icon-restore"></span></a></td>
        <td width="30"><a href="projects_meetings" class="binDelete" rel="<?php echo $meeting->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($meeting->binuser . ", " .$meeting->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>


<?php if(is_array($arr["meetings_tasks"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PROJECT_MEETING_GOALS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["meetings_tasks"] as $meeting_task) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="meeting_task_<?php echo($meeting_task->id);?>" rel="<?php echo($meeting_task->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PROJECT_MEETING_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($meeting_task->title);?></td>
        <td width="30"><a href="projects_meetings" class="binRestoreItem" rel="<?php echo $meeting_task->id;?>"><span class="icon-restore"></span></a></td>
        <td width="30"><a href="projects_meetings" class="binDeleteItem" rel="<?php echo $meeting_task->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($meeting_task->binuser . ", " .$meeting_task->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>
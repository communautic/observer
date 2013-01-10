
<?php if(is_array($arr["phonecalls"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["COMPLAINT_PHONECALLS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["phonecalls"] as $phonecall) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="phonecall_<?php echo($phonecall->id);?>" rel="<?php echo($phonecall->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["COMPLAINT_PHONECALL_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($phonecall->title);?></td>
        <td width="25"><a href="complaints_phonecalls" class="binRestore" rel="<?php echo $phonecall->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="complaints_phonecalls" class="binDelete" rel="<?php echo $phonecall->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($phonecall->binuser . ", " .$phonecall->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>


<?php if(is_array($arr["phonecalls_tasks"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["COMPLAINT_PHONECALL_GOALS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["phonecalls_tasks"] as $phonecall_task) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="phonecall_task_<?php echo($phonecall_task->id);?>" rel="<?php echo($phonecall_task->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["COMPLAINT_PHONECALL_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($phonecall_task->title);?></td>
        <td width="25"><a href="complaints_phonecalls" class="binRestoreItem" rel="<?php echo $phonecall_task->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="complaints_phonecalls" class="binDeleteItem" rel="<?php echo $phonecall_task->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($phonecall_task->binuser . ", " .$phonecall_task->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>
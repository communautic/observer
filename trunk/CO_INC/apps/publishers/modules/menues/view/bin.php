
<?php if(is_array($arr["menues"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PUBLISHER_MENUES"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["menues"] as $menue) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="menue_<?php echo($menue->id);?>" rel="<?php echo($menue->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PUBLISHER_MENUE_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($menue->title);?></td>
        <td width="25"><a href="publishers_menues" class="binRestore" rel="<?php echo $menue->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="publishers_menues" class="binDelete" rel="<?php echo $menue->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($menue->binuser . ", " .$menue->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>


<?php if(is_array($arr["menues_tasks"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PUBLISHER_MENUE_GOALS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["menues_tasks"] as $menue_task) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="menue_task_<?php echo($menue_task->id);?>" rel="<?php echo($menue_task->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PUBLISHER_MENUE_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($menue_task->title);?></td>
        <td width="25"><a href="publishers_menues" class="binRestoreItem" rel="<?php echo $menue_task->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="publishers_menues" class="binDeleteItem" rel="<?php echo $menue_task->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($menue_task->binuser . ", " .$menue_task->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>


<?php if(is_array($arr["pros"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PROC_PROCS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["pros"] as $proc) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="proc_<?php echo($proc->id);?>" rel="<?php echo($proc->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $proc->binheading;?></span></td>
		<td class="tcell-right"><?php echo($proc->title);?></td>
        <td width="25"><a href="procs" class="binRestore" rel="<?php echo $proc->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="procs" class="binDelete" rel="<?php echo $proc->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($proc->binuser . ", " .$proc->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>


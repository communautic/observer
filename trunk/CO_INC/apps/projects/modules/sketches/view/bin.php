
<?php if(is_array($arr["sketches"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PROJECT_SKETCHES"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["sketches"] as $sketch) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="sketch_<?php echo($sketch->id);?>" rel="<?php echo($sketch->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PROJECT_SKETCH_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($sketch->title);?></td>
        <td width="25"><a href="projects_sketches" class="binRestore" rel="<?php echo $sketch->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="projects_sketches" class="binDelete" rel="<?php echo $sketch->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($sketch->binuser . ", " .$sketch->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>

<?php if(is_array($arr["sketches_diags"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PROJECT_SKETCH_DIAGNOSES"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["sketches_diags"] as $sketch_diag) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="sketch_diag_<?php echo($sketch_diag->id);?>" rel="<?php echo($sketch_diag->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PROJECT_SKETCH_DIAGNOSE"];?></span></td>
		<td class="tcell-right"><?php echo($sketch_diag->text);?></td>
        <td width="25"><a href="projects_sketches" class="binRestoreColumn" rel="<?php echo $sketch_diag->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="projects_sketches" class="binDeleteColumn" rel="<?php echo $sketch_diag->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($sketch_diag->binuser . ", " .$sketch_diag->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>
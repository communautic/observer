
<?php if(is_array($arr["treatments"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PATIENT_TREATMENTS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["treatments"] as $treatment) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="treatment_<?php echo($treatment->id);?>" rel="<?php echo($treatment->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PATIENT_TREATMENT_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($treatment->title);?></td>
        <td width="25"><a href="patients_treatments" class="binRestore" rel="<?php echo $treatment->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="patients_treatments" class="binDelete" rel="<?php echo $treatment->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($treatment->binuser . ", " .$treatment->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>

<?php if(is_array($arr["treatments_diags"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PATIENT_TREATMENT_DIAGNOSES"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["treatments_diags"] as $treatment_diag) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="treatment_diag_<?php echo($treatment_diag->id);?>" rel="<?php echo($treatment_diag->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PATIENT_TREATMENT_DIAGNOSE"];?></span></td>
		<td class="tcell-right"><?php echo($treatment_diag->text);?></td>
        <td width="25"><a href="patients_treatments" class="binRestoreColumn" rel="<?php echo $treatment_diag->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="patients_treatments" class="binDeleteColumn" rel="<?php echo $treatment_diag->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($treatment_diag->binuser . ", " .$treatment_diag->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>

<?php if(is_array($arr["treatments_tasks"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PATIENT_TREATMENT_GOALS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["treatments_tasks"] as $treatment_task) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="treatment_task_<?php echo($treatment_task->id);?>" rel="<?php echo($treatment_task->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PATIENT_TREATMENT_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($treatment_task->title);?></td>
        <td width="25"><a href="patients_treatments" class="binRestoreItem" rel="<?php echo $treatment_task->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="patients_treatments" class="binDeleteItem" rel="<?php echo $treatment_task->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($treatment_task->binuser . ", " .$treatment_task->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>
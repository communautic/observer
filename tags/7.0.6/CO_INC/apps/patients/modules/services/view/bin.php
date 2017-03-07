
<?php if(is_array($arr["services"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PATIENT_SERVICES"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["services"] as $service) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="service_<?php echo($service->id);?>" rel="<?php echo($service->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PATIENT_SERVICE_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($service->title);?></td>
        <td width="25"><a href="patients_services" class="binRestore" rel="<?php echo $service->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="patients_services" class="binDelete" rel="<?php echo $service->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($service->binuser . ", " .$service->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>


<?php if(is_array($arr["services_tasks"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PATIENT_SERVICE_GOALS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["services_tasks"] as $service_task) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="service_task_<?php echo($service_task->id);?>" rel="<?php echo($service_task->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PATIENT_SERVICE_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($service_task->title);?></td>
        <td width="25"><a href="patients_services" class="binRestoreItem" rel="<?php echo $service_task->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="patients_services" class="binDeleteItem" rel="<?php echo $service_task->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($service_task->binuser . ", " .$service_task->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>
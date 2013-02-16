
<?php if(is_array($arr["reports"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PATIENT_REPORTS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["reports"] as $report) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="report_<?php echo($report->id);?>" rel="<?php echo($report->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PATIENT_REPORT_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($report->title);?></td>
        <td width="25"><a href="patients_reports" class="binRestore" rel="<?php echo $report->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="patients_reports" class="binDelete" rel="<?php echo $report->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($report->binuser . ", " .$report->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>


<?php if(is_array($arr["reports_tasks"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PATIENT_REPORT_GOALS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["reports_tasks"] as $report_task) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="report_task_<?php echo($report_task->id);?>" rel="<?php echo($report_task->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PATIENT_REPORT_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($report_task->title);?></td>
        <td width="25"><a href="patients_reports" class="binRestoreItem" rel="<?php echo $report_task->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="patients_reports" class="binDeleteItem" rel="<?php echo $report_task->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($report_task->binuser . ", " .$report_task->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>
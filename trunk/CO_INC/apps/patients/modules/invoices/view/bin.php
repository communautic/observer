
<?php if(is_array($arr["invoices"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PATIENT_INVOICES"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["invoices"] as $invoice) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="invoice_<?php echo($invoice->id);?>" rel="<?php echo($invoice->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PATIENT_INVOICE_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($invoice->title);?></td>
        <td width="25"><a href="patients_invoices" class="binRestore" rel="<?php echo $invoice->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="patients_invoices" class="binDelete" rel="<?php echo $invoice->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($invoice->binuser . ", " .$invoice->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>


<?php if(is_array($arr["invoices_tasks"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PATIENT_INVOICE_GOALS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["invoices_tasks"] as $invoice_task) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="invoice_task_<?php echo($invoice_task->id);?>" rel="<?php echo($invoice_task->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["PATIENT_INVOICE_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($invoice_task->title);?></td>
        <td width="25"><a href="patients_invoices" class="binRestoreItem" rel="<?php echo $invoice_task->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="patients_invoices" class="binDeleteItem" rel="<?php echo $invoice_task->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($invoice_task->binuser . ", " .$invoice_task->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>
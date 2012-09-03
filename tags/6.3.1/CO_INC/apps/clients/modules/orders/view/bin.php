
<?php if(is_array($arr["orders"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["CLIENT_ORDERS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["orders"] as $order) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="order_<?php echo($order->id);?>" rel="<?php echo($order->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["CLIENT_ORDER_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($order->title);?></td>
        <td width="30"><a href="clients_orders" class="binRestore" rel="<?php echo $order->id;?>"><span class="icon-restore"></span></a></td>
        <td width="30"><a href="clients_orders" class="binDelete" rel="<?php echo $order->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($order->binuser . ", " .$order->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>


<?php if(is_array($arr["orders_tasks"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["CLIENT_ORDER_GOALS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["orders_tasks"] as $order_task) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="order_task_<?php echo($order_task->id);?>" rel="<?php echo($order_task->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["CLIENT_ORDER_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($order_task->title);?></td>
        <td width="30"><a href="clients_orders" class="binRestoreItem" rel="<?php echo $order_task->id;?>"><span class="icon-restore"></span></a></td>
        <td width="30"><a href="clients_orders" class="binDeleteItem" rel="<?php echo $order_task->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($order_task->binuser . ", " .$order_task->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>
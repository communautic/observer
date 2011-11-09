<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["CLIENT_ORDER_TITLE"];?></td>
        <td><strong><?php echo($order->title);?></strong></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
		<td class="tcell-left"><?php echo $lang["CLIENT_ORDER_DATE"];?></td>
		<td><?php echo($order->item_date)?></td>
    </tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["CLIENT_ORDER_TIME_START"];?></td>
        <td><?php echo($order->start);?></td>
	</tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["CLIENT_ORDER_TIME_END"];?></td>
        <td><?php echo($order->end);?></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
	  <td class="tcell-left"><?php echo $lang["CLIENT_ORDER_MANAGEMENT"];?></td>
        <td><?php echo($order->management);?></td>
	</tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($order->status_text);?> <?php echo($order->status_date)?></td>
	</tr>
</table>
&nbsp;
<?php if(!empty($order->protocol)) { ?>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey" style="padding: 10pt 10pt 10pt 15pt;">
	<tr>
        <td class="tcell-left top"><?php echo $lang["CLIENT_ORDER_GOALS"];?></td>
        <td><?php echo(nl2br($order->protocol));?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<div style="page-break-after:always;">&nbsp;</div>
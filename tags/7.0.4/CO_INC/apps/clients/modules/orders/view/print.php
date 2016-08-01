<table width="100%" class="title grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["CLIENT_ORDER_TITLE"];?></td>
        <td><strong><?php echo($order->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["CLIENT_ORDER_DATE"];?></td>
		<td><?php echo($order->created_date)?></td>
    </tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["CLIENT_ORDER_MANAGEMENT"];?></td>
		<td><?php echo($order->created_user);?></td>
    </tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["CLIENT_CONTRACT"];?></td>
		<td><?php echo($order->contract_text);?></td>
    </tr>
</table>
&nbsp;
<table width="100%" style="border-collapse: collapse;">
	<tr>
		<td>
        	<table width="100%" style="border-collapse: collapse;">
              <tr>
                <td class="tcell-left">&nbsp;<br />&nbsp;</td>
                <td>Montag</td>
                <td>Dienstag</td>
                <td>Mittwoch</td>
                <td>Donnerstag</td>
                <td>Freitag</td>
              </tr>
              <?php if($order->contract_rows >= 1) { ?>
              <tr>
                <td class="tcell-left">Men&uuml; I<br />&nbsp;</td>
                <td><?php echo($order->mon);?></td>
                <td><?php echo($order->tue);?></td>
                <td><?php echo($order->wed);?></td>
                <td><?php echo($order->thu);?></td>
                <td><?php echo($order->fri);?></td>
              </tr>
              <?php } ?>
              <?php if($order->contract_rows >= 2) { ?>
              <tr>
                <td class="tcell-left">Men&uuml; II<br />&nbsp;</td>
                <td><?php echo($order->mon_2);?></td>
                <td><?php echo($order->tue_2);?></td>
                <td><?php echo($order->wed_2);?></td>
                <td><?php echo($order->thu_2);?></td>
                <td><?php echo($order->fri_2);?></td>
              </tr>
              <?php } ?>
             <?php if($order->contract_rows == 3) { ?>
              <tr>
                <td class="tcell-left">Men&uuml; III<br />&nbsp;</td>
                <td><?php echo($order->mon_3);?></td>
                <td><?php echo($order->tue_3);?></td>
                <td><?php echo($order->wed_3);?></td>
                <td><?php echo($order->thu_3);?></td>
                <td><?php echo($order->fri_3);?></td>
              </tr>
              <?php } ?>
              <tr>
                <td class="tcell-left">Men&uuml;anzahl / Tag<br />&nbsp;</td>
                <td><?php echo($order->total_mon);?></td>
                <td><?php echo($order->total_tue);?></td>
                <td><?php echo($order->total_wed);?></td>
                <td><?php echo($order->total_thu);?></td>
                <td><?php echo($order->total_fri);?></td>
              </tr>
              <tr>
                <td class="tcell-left">Men&uuml; Notiz<br />&nbsp;</td>
                <td><?php echo($order->mon_note);?></td>
                <td><?php echo($order->tue_note);?></td>
                <td><?php echo($order->wed_note);?></td>
                <td><?php echo($order->thu_note);?></td>
                <td><?php echo($order->fri_note);?></td>
              </tr>
            </table>
        </td>
    </tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left">Men&uuml;anzahl / Woche</td>
		<td><?php echo($order->total);?></td>
    </tr>
</table>
&nbsp;
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left">Rechnung</td>
		<td><?php echo($order->status_text);?></td>
    </tr>
</table>
<?php if(!empty($order->protocol)) { ?>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["CLIENT_ORDER_GOALS"];?></td>
        <td><?php echo(nl2br($order->protocol));?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<div style="page-break-after:always;">&nbsp;</div>
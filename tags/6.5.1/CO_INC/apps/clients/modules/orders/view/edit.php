<div class="table-title-outer">

<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($order->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["CLIENT_ORDER_TITLE"];?></span></span></td>
    <td><input name="title" type="text" class="title textarea-title" value="<?php echo($order->title);?>" maxlength="100" /></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($order->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($order->id);?>">
<input type="hidden" name="pid" value="<?php echo($order->pid);?>">
<?php if($order->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span>Warnung</span></span></strong></td>
		<td class="tcell-right"><strong>Dieser Inhaltsbereich wird aktuell bearbeitet von: <?php echo($order->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($order->checked_out_user_email);?>"><?php echo($order->checked_out_user_email);?></a>, <?php echo($order->checked_out_user_phone1);?></td>
    </tr>
</table>
<?php } ?>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><span><span><?php echo $lang["CLIENT_ORDER_DATE"];?></span></span></td>
		<td class="tcell-right-inactive"><?php echo($order->created_date);?></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><span><span><?php echo $lang["CLIENT_ORDER_MANAGEMENT"];?></span></span></td>
		<td class="tcell-right-inactive"><?php echo($order->created_user);?></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left-inactive text11"><span><span><?php echo $lang["CLIENT_CONTRACT"];?></span></span></td>
        <td class="tcell-right-inactive"><?php echo($order->contract_text);?></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-right">
        	<table border="0" cellspacing="0" cellpadding="0" class="menutbl">
              <tr>
                <td style="border: 0; width: 120px;"></td>
                <td>Montag</td>
                <td>Dienstag</td>
                <td>Mittwoch</td>
                <td>Donnerstag</td>
                <td>Freitag</td>
              </tr>
              <?php if($order->contract_rows >= 1) { ?>
              <tr>
                <td class="text11" style="border: 0; text-align: left;">Men&uuml; I</td>
                <td><?php echo($order->mon);?></td>
                <td><?php echo($order->tue);?></td>
                <td><?php echo($order->wed);?></td>
                <td><?php echo($order->thu);?></td>
                <td><?php echo($order->fri);?></td>
              </tr>
              <?php } ?>
              <?php if($order->contract_rows >= 2) { ?>
              <tr>
                <td class="text11" style="border: 0; text-align: left;">Men&uuml; II</td>
                <td><?php echo($order->mon_2);?></td>
                <td><?php echo($order->tue_2);?></td>
                <td><?php echo($order->wed_2);?></td>
                <td><?php echo($order->thu_2);?></td>
                <td><?php echo($order->fri_2);?></td>
              </tr>
              <?php } ?>
             <?php if($order->contract_rows == 3) { ?>
              <tr>
                <td class="text11" style="border: 0; text-align: left;">Men&uuml; III</td>
                <td><?php echo($order->mon_3);?></td>
                <td><?php echo($order->tue_3);?></td>
                <td><?php echo($order->wed_3);?></td>
                <td><?php echo($order->thu_3);?></td>
                <td><?php echo($order->fri_3);?></td>
              </tr>
              <?php } ?>
              <tr>
                <td class="text11" style="border: 0; text-align: left;">Men&uuml;anzahl / Tag</td>
                <td><?php echo($order->total_mon);?></td>
                <td><?php echo($order->total_tue);?></td>
                <td><?php echo($order->total_wed);?></td>
                <td><?php echo($order->total_thu);?></td>
                <td><?php echo($order->total_fri);?></td>
              </tr>
              <tr>
                <td class="text11" style="border: 0; text-align: left;">Men&uuml; Notiz</td>
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
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left-inactive text11"><span><span>Men&uuml;anzahl / Woche</span></span></td>
    <td class="tcell-right-inactive"><?php echo($order->total);?></td>
  </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($order->canedit) { ?>content-nav showDialog<?php } ?>" request="getOrderStatusDialog" field="clientsstatus" append="1"><span>Rechnung</span></span></td>
        <td class="tcell-right"><div id="clientsorder_status" class="itemlist-field"><div class="listmember" field="clientsorder_status" uid="<?php echo($order->status);?>" style="float: left"><?php echo($order->status_text);?></div></div><input name="order_status_date" type="text" class="input-date datepicker order_status_date" value="<?php echo($order->status_date)?>" style="float: left; margin-left: 8px;" /></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($order->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["CLIENT_ORDER_GOALS"];?></span></span></td>
    <td class="tcell-right"><?php if($order->canedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($order->protocol));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($order->protocol)));?><?php } ?></td>
  </tr>
</table>
<?php if($order->perms != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($order->canedit) { ?>content-nav showDialog<?php } ?>" request="getDocumentsDialog" field="clientsdocuments" append="1"><span><?php echo $lang["CLIENT_DOCUMENT_DOCUMENTS"];?></span></span></td>
    <td class="tcell-right"><div id="clientsdocuments" class="itemlist-field"><?php echo($order->documents);?></div></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($order->canedit) { ?>content-nav showDialog<?php } ?>" request="getAccessDialog" field="clientsorder_access" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></span></td>
        <td class="tcell-right"><div id="clientsorder_access" class="itemlist-field"><div class="listmember" field="clientsorder_access" uid="<?php echo($order->access);?>" style="float: left"><?php echo($order->access_text);?></div></div><input type="hidden" name="order_access_orig" value="<?php echo($order->access);?>" /></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="clientsorder_sendto">
        <?php 
			foreach($sendto as $value) { 
				if(!empty($value->who)) {
					echo '<div class="text11 toggleSendTo co-link">' . $value->who . ', ' . $value->date . '</div>' .
						 '<div class="SendToContent">' . $lang["GLOBAL_SUBJECT"] . ': ' . $value->subject . '<br /><br />' . nl2br($value->body) . '<br></div>';
				}
		 } ?></div>
        </td>
    </tr>
</table>
<?php } ?>
</form>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($order->edited_user.", ".$order->edited_date)?></td>
    <td class="middle"><?php echo $order->access_footer;?></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($order->created_user.", ".$order->created_date);?></td>
  </tr>
</table>
</div>
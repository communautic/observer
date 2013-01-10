<div class="table-title-outer">

<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($client->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["CLIENT_TITLE"];?></span></span></td>
    <td class="tcell-right"><?php if($client->canedit) { ?><input name="title" type="text" class="title textarea-title" value="<?php echo($client->title);?>" maxlength="100" /><?php } else { ?><div class="textarea-title"><?php echo($client->title);?></div><?php } ?></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($client->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setClientDetails">
<input type="hidden" name="id" value="<?php echo($client->id);?>">
<?php if($client->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span>Warnung</span></span></strong></td>
		<td class="tcell-right"><strong>Dieser Inhaltsbereich wird aktuell bearbeitet von: <?php echo($client->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($client->checked_out_user_email);?>"><?php echo($client->checked_out_user_email);?></a>, <?php echo($client->checked_out_user_phone1);?></td>
    </tr>
</table>
<div class="content-spacer"></div>
<?php } ?>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($client->canedit) { ?>content-nav showDialog<?php } ?>" request="getClientFolderDialog" field="clientsfolder" append="1"><span><?php echo $lang["CLIENT_FOLDER"];?></span></span></td>
        <td class="tcell-right"><div id="clientsfolder" class="itemlist-field"><?php echo($client->folder);?></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($client->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="clientsmanagement" append="1"><span><?php echo $lang["CLIENT_MANAGEMENT"];?></span></span></td>
	  <td class="tcell-right"><div id="clientsmanagement" class="itemlist-field"><?php echo($client->management);?></div><div id="clientsmanagement_ct" class="itemlist-field"><a field="clientsmanagement_ct" class="ct-content"><?php echo($client->management_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($client->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="clientsteam" append="1"><span><?php echo $lang["CLIENT_TEAM"];?></span></span></td>
    <td class="tcell-right"><div id="clientsteam" class="itemlist-field"><?php echo($client->team);?></div><div id="clientsteam_ct" class="itemlist-field"><a field="clientsteam_ct" class="ct-content"><?php echo($client->team_ct);?></a></div></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($client->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialogPlace" field="clientsaddress" append="0"><span><?php echo $lang["CLIENT_ADDRESS"];?></span></span></td>
		<td class="tcell-right"><div id="clientsaddress" class="itemlist-field"><?php echo($client->address);?></div><div id="clientsaddress_ct" class="itemlist-field"><a field="clientsaddress_ct" class="ct-content"><?php echo($client->address_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($client->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialogPlace" field="clientsbillingaddress" append="0"><span><?php echo $lang["CLIENT_BILLING_ADDRESS"];?></span></span></td>
		<td class="tcell-right"><div id="clientsbillingaddress" class="itemlist-field"><?php echo($client->billingaddress);?></div><div id="clientsbillingaddress_ct" class="itemlist-field"><a field="clientsbillingaddress_ct" class="ct-content"><?php echo($client->billingaddress_ct);?></a></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($client->canedit) { ?>content-nav showDialog<?php } ?>" request="getClientContractDialog" field="clientscontract" append="0"><span><?php echo $lang["CLIENT_CONTRACT"];?></span></span></td>
        <td class="tcell-right"><div id="clientscontract" class="itemlist-field"><div class="listmember" field="clientscontract" uid="<?php echo($client->contract);?>" style="float: left"><?php echo($client->contract_text);?></div></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($client->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["CLIENT_DESCRIPTION"];?></span></span></td>
        <td class="tcell-right"><?php if($client->canedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($client->protocol));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($client->protocol)));?><?php } ?></td>
	</tr>
</table>

<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left-inactive text11">Bestellberechtigung</td>
    <td class="tcell-right text11">&nbsp;</td>
  </tr>
</table>
<?php
if(is_array($order_access)) {
	foreach ($order_access as $oa) { 
		$checked = '';
		if($oa->access_status == 0) {
			$checked = ' checked';
		}
		include('loop.php');
	}
}
?>

</form>

<?php if($client->access != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="client_sendto">
        <?php 
			foreach($sendto as $value) { 
			if(!empty($value->who)) {
				echo '<div class="text11 toggleSendTo co-link">' . $value->who . ', ' . $value->date . '</div>' .
				'<div class="SendToContent">' . $lang["GLOBAL_SUBJECT"] . ': ' . $value->subject . '<br /><br />' . nl2br($value->body) . '<br></div>';
			}
		 } ?></div></td>
    </tr>
</table>
<?php } ?>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($client->edited_user.", ".$client->edited_date)?></td>
    <td class="middle"></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($client->created_user.", ".$client->created_date);?></td>
  </tr>
</table>
</div>
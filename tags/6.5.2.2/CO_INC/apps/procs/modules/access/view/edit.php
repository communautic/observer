<div class="table-title-outer">
<table border="0" cellspacing="0" cellpadding="0" class="table-title grey">
  <tr>
    <td nowrap="nowrap" class="tcell-left text11"><span class="content-nav-title"><?php echo $lang["PROC_ACCESSRIGHTS"];?></span></td>
    <td></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="coform jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="pid" value="<?php echo($access->pid);?>">
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="content-nav showDialog" request="getContactsDialog" field="procsadmins" append="1"><span><?php echo $lang["GLOBAL_ADMINS"];?></span></span></td>
		<td class="tcell-right"><div id="procsadmins" class="itemlist-field"><?php echo($access->admins);?></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="content-nav showDialog" request="getContactsDialog" field="procsguests" append="1"><span><?php echo $lang["GLOBAL_GUESTS"];?></span></span></td>
		<td class="tcell-right"><div id="procsguests" class="itemlist-field"><?php echo($access->guests);?></div></td>
	</tr>
</table>
</form>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo($lang["GLOBAL_FOOTER_STATUS"] . " " . $access->today);?></td>
    <td class="middle">&nbsp;</td>
    <td class="right">&nbsp;</td>
  </tr>
</table>
</div>
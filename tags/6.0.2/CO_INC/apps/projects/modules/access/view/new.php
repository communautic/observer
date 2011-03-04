<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-title">
  <tr>
    <td class="tcell-left text11 bold"><?php echo ACCESS_TITLE;?></td>
	<td width="25">???</td>
    <td><input type="text" name="title" class="title textarea-title" /></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scrolling-content">
<form action="<?php echo $this->form_url;?>" method="post" class="coform jNice">
<input type="hidden" id="poformaction" name="request" value="createNew">
<input type="hidden" name="id" value="<?php echo($access->pid);?>">
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"></td>
    <td>
    <table  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25"><input name="level" type="radio" value="2" class="jNiceHidden" checked="checked" /></td>
        <td width="142"><?php echo ACCESS_LEVEL_GUEST;?></td>
        <td width="25">&nbsp;</td>
        <td width="25"><input name="level" type="radio" value="1" class="jNiceHidden" /></td>
        <td width="142"><?php echo ACCESS_LEVEL_ADMIN;?></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
        <td class="tcell-left text11"><?php echo ACCESS_NEWSCIRCLE;?></td>
        <td width="25"><input name="newscircle" type="checkbox" class="cbx jNiceHidden" /></td>
        <td class="tcell-right"></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><?php echo ACCESS_CONTACTS;?></td>
		<td width="25"><a href="Kontake" class="showDialog" request="getContactsDialog" field="contactlist" title="Kontakte" append="1"></a></td>
		<td class="tcell-right"><div id="contactlist" class="itemlist-field"></div></td>
	</tr>
</table>
</form>
</div>
</div>
<div class="content-footer"></div>
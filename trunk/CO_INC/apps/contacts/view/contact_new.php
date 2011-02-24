<div>
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
	<tr>
		<td class="tcell-left text11 bold"><?php echo CONTACTS_CONTACT_LASTNAME;?></td>
        <td width="25">&nbsp;</td>
		<td><input type="text" name="title" class="title textarea-title" /></td>
	</tr>
</table>
</div>
<div class="ui-layout-content"><div class="scrolling-content">
<form action="<?php echo $this->form_url;?>" method="post" class="coform jNice">
<input type="hidden" id="poformaction" name="request" value="newContact">
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><?php echo CONTACTS_CONTACT_FIRSTNAME;?></td>
    <td width="25">&nbsp;</td>
    <td class="tcell-right"><input name="firstname" type="text" class="title2 bg" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><?php echo CONTACTS_CONTACT_TITLE;?></td>
    <td width="25">&nbsp;</td>
    <td class="tcell-right"><input name="title" id="title" type="text" class="bg" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><?php echo CONTACTS_CONTACT_POSITION;?></td>
    <td width="25">&nbsp;</td>
    <td class="tcell-right"><textarea name="position" id="position" cols="20" rows="2" class="bg"></textarea></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><?php echo CONTACTS_CONTACT_EMAIL;?></td>
    <td width="25">&nbsp;</td>
    <td class="tcell-right"><input name="email" type="text" class="bg" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><?php echo CONTACTS_CONTACT_TEL;?></td>
    <td width="25">&nbsp;</td>
    <td class="tcell-right"><input name="phone1" id="phone1" type="text" class="bg" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><?php echo CONTACTS_CONTACT_TEL2;?></td>
    <td width="25">&nbsp;</td>
    <td class="tcell-right"><input name="phone2" id="phone2" type="text" class="bg" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><?php echo CONTACTS_CONTACT_FAX;?></td>
    <td width="25">&nbsp;</td>
    <td class="tcell-right"><input name="fax" id="fax" type="text" class="bg" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td valign="top" class="tcell-left text11"><?php echo CONTACTS_CONTACT_ADDRESS;?></td>
    <td width="25">&nbsp;</td>
    <td class="tcell-right"><textarea name="address" id="address" cols="20" rows="3" class="bg"></textarea></td>
  </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><?php echo CONTACTS_CONTACT_LANGUAGE;?></td>
		<td width="25">&nbsp;</td>
	  <td width="25"><input title="lang" name="lang" type="radio" value="en" class="jNiceHidden" checked="checked" /></td><td width="25">en</td>
      <td width="25"><input title="lang" name="lang" type="radio" value="de" class="jNiceHidden" /></td><td>de</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
    <tr>
        <td class="tcell-left text11">Timezone</td>
        <td width="25">&nbsp;</td>
        <td class="tcell-right">
        <select name="timezone">
        <option value="Europe/London">Europe/London</option>
        <option value="Europe/Vienna">Europe/Vienna</option>
        </select>

        </td>
    </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
    <tr>
        <td class="tcell-left text11">Date/Time display</td>
        <td width="25">&nbsp;</td>
        <td class="tcell-right">dd.mm.yyyy hh:mm</td>
    </tr>
</table>
</form>
</div>
</div>
<div class="content-footer"></div>
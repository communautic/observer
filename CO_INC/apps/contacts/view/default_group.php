<div>
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
	<tr>
		<td class="tcell-left text11 bold"><?php echo CONTACTS_GROUP_TITLE;?></td>
        <td width="25">&nbsp;</td>
		<td><input type="text" name="title" class="title textarea-title" value="<?php echo($group->title);?>" /></td>
	</tr>
</table>
</div>
<div class="ui-layout-content"><div class="scrolling-content">
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td valign="top" class="tcell-left text11"><?php echo CONTACTS_GROUP_TITLE;?></td>
	<td width="25" valign="top">&nbsp;</td>
    <td valign="top"><input type="text" name="title" class="title textarea-underline-bold" value="<?php echo($group->name);?>" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td valign="top" class="tcell-left text11"><?php echo CONTACTS_SINGLE_CONTACTS;?></td>
    <td width="25" valign="top">&nbsp;</td>
    <td valign="top"><?php echo($group->allcontacts);?>&nbsp;</td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
    <tr>
      <td><hr></td>
    </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td valign="top" class="tcell-left text11"><?php echo $lang["EDITED_BY_ON"];?></td>
		<td valign="top"><?php echo($contact->edited_user.", ".$contact->edited_date)?></td>
	</tr>
</table>
</div>
</div>
<div class="content-footer"></div>
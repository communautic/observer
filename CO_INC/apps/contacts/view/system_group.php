<div>
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
	<tr>
		<td class="tcell-left text11"><span class="content-nav"><?php echo $lang['CONTACTS_GROUP_TITLE'];?></span></td>
		<td><input type="text" name="title" class="title textarea-title" value="<?php echo $lang['CONTACTS_SYSTEM_GROUP'];?>" /></td>
	</tr>
</table>
</div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td valign="top" class="tcell-left text11"><span class="content-nav"><?php echo $lang['CONTACTS_SINGLE_CONTACTS'];?></span></td>
    <td valign="top"><?php echo($group->allcontacts);?>&nbsp;</td>
  </tr>
</table>
<div class="content-spacer"></div>
<!--<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td valign="top" class="tcell-left text11"><?php echo $lang["EDITED_BY_ON"];?></td>
		<td valign="top"><?php echo($group->edited_user.", ".$group->edited_date)?></td>
	</tr>
</table>-->
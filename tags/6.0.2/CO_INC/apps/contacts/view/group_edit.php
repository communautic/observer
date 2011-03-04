<div>
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
	<tr>
		<td class="tcell-left text11"><span class="content-nav"><?php echo CONTACTS_GROUP_TITLE;?></span></td>
		<td><input type="text" name="title" class="title textarea-title" value="<?php echo($group->title);?>" /></td>
	</tr>
</table>
</div>
<div class="ui-layout-content"><div class="scrolling-content">
<form action="<?php echo $this->form_url;?>" method="post" class="coform jNice">
<input type="hidden" id="poformaction" name="request" value="setGroupDetails">
<input type="hidden" name="id" value="<?php echo($group->id);?>">
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="content-nav"><?php echo CONTACTS_SINGLE_CONTACTS;?></span></td>
    <td class="tcell-right"><span id="num_contacts"><?php echo($group->allcontacts);?></span></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><a href="#" class="content-nav showDialog" request="getContactsDialog" field="members" append="1"><span><?php echo CONTACTS_GROUP_MEMBERS;?></span></a></td>
    <td class="tcell-right"><div id="members" class="itemlist-field"><?php echo($group->members);?></div>
    </td>
  </tr>
</table>
</form>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($group->edited_user.", ".$group->edited_date)?></td>
    <td class="middle"></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($group->created_user.", ".$group->created_date);?></td>
  </tr>
</table>
</div>
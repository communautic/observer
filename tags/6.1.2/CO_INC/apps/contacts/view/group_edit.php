<div>
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
	<tr>
		<td class="tcell-left text11"><span class="content-nav focusTitle"><span><?php echo $lang['CONTACTS_GROUP_TITLE'];?></span></span></td>
		<td><input type="text" name="title" class="title textarea-title" value="<?php echo($group->title);?>" /></td>
	</tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="coform jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setGroupDetails">
<input type="hidden" name="id" value="<?php echo($group->id);?>">
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-inactive text11"><?php echo $lang['CONTACTS_SINGLE_CONTACTS'];?></td>
    <td class="tcell-right-inactive"><span id="num_contacts"><?php echo($group->allcontacts);?></span></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="content-nav showDialog" request="getContactsDialog" field="members" append="1"><span><?php echo $lang['CONTACTS_GROUP_MEMBERS'];?></span></span></td>
    <td class="tcell-right"><div id="members" class="itemlist-field"><?php echo($group->members);?></div>
    </td>
  </tr>
</table>
</form>
<div class="content-spacer"></div>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang['CONTACTS_GROUP_MEMBERS_LIST'];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php
if(is_array($members)) {
	foreach ($members as $member) { 
	?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" rel="<?php echo($member["id"]);?>">
	<tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right"><span class="bold co-link loadContactFromGroups" rel="<?php echo($member["id"]);?>"><?php echo($member["name"]);?></span></td>
	</tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right">
        <span class="text11"><?php echo($member["email"] . ", " . $member["phone"]);?></span>
</td>
	</tr>
</table>
    <?php 
	}
}
?>
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
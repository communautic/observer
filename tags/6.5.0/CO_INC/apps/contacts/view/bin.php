<div class="table-title-outer">
<table border="0" cellspacing="0" cellpadding="0" class="table-title grey">
  <tr>
    <td class="tcell-left text11"><span class="content-nav"><?php echo $lang["BIN_TITLE"];?></span></td>
    <td></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">

<?php if(is_array($arr["groups"])) { ?>
    <table border="0" cellpadding="0" cellspacing="0" class="table-content">
        <tr>
            <td class="tcell-left-inactive text11"><?php echo $lang['CONTACTS_GROUPS'];?></td>
        <td class="tcell-right">&nbsp;</td>
        </tr>
    </table>
<?php foreach ($arr["groups"] as $group) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="group_<?php echo($group->id);?>" rel="<?php echo($group->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang['CONTACTS_GROUP_TITLE'];?></span></td>
		<td class="tcell-right"><?php echo($group->title);?></td>
        <td width="25"><a href="contacts_groups" class="binRestore" rel="<?php echo $group->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="contacts_groups" class="binDelete" rel="<?php echo $group->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($group->binuser . ", " .$group->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>


<?php if(is_array($arr["contacts"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang['CONTACTS_CONTACTS'];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["contacts"] as $contact) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="contact_<?php echo($contact->id);?>" rel="<?php echo($contact->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang['CONTACTS_CONTACT'];?></span></td>
		<td class="tcell-right"><?php echo($contact->lastname . " " . $contact->firstname);?></td>
        <td width="25"><a href="contacts" class="binRestore" rel="<?php echo $contact->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="contacts" class="binDelete" rel="<?php echo $contact->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($contact->binuser . ", " .$contact->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>


<?php if(is_array($arr["avatars"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang['CONTACTS_AVATARS'];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["avatars"] as $avatar) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="contact_avatar_<?php echo($avatar->id);?>" rel="<?php echo($avatar->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang['CONTACTS_CONTACT'];?></span></td>
		<td rowspan="2" width="40"><img width="30" height="45" src="<?php echo CO_PATH_URL;?>/data/avatars/<?php echo($avatar->avatar);?>"></td>
        <td class="tcell-right"><?php echo($avatar->lastname . " " . $avatar->firstname);?></td>
        <td width="25"><a href="contacts" class="binRestoreItem" rel="<?php echo $avatar->id;?>"><span class="icon-restore"></span></a></td>
        <td width="25"><a href="contacts" class="binDeleteItem" rel="<?php echo $avatar->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($avatar->binuser . ", " .$avatar->bintime)?></td>
        <td></td>
        <td></td>
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
    <td class="left"><?php echo($lang["GLOBAL_FOOTER_STATUS"] . " " . $bin["datetime"]);?></td>
    <td class="middle"></td>
    <td class="right"></td>
  </tr>
</table>
</div>
<table width="100%" class="title">
	<tr>
		<td class="tcell-left"><?php echo $lang['CONTACTS_GROUP_TITLE'];?></td>
		<td><strong><?php echo($group->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_SINGLE_CONTACTS'];?></td>
    <td><?php echo($group->allcontacts);?></td>
  </tr>
</table>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_GROUP_MEMBERS'];?></td>
    <td><?php echo($group->members);?></td>
  </tr>
</table>
&nbsp;
<?php
if(is_array($members)) {
	$i = 1;
	foreach ($members as $member) { ?>
    <table width="100%" class="standard">
	<tr>
		<td class="tcell-left">
        <?php if($i == 1) { echo $lang['CONTACTS_GROUP_MEMBERS_LIST']; }?>&nbsp;
        </td>
		<td><?php echo($member["name"]);?></td>
	</tr>
    <tr>
		<td class="tcell-left">&nbsp;</td>
		<td class="grey smalltext"><?php echo($member["email"] . " - " . $member["phone"]);?>
        <div class="line">&nbsp;</div>
        </td>
	</tr>
</table>
    <?php 
	$i++;
	}
}
?>

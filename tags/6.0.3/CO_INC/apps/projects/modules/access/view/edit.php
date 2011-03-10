<?php
$admin = '';
$guest = '';
switch($access->level) {
	case "1":
		$admin = ' checked="checked"';
	break;
	case "2":
		$guest = ' checked="checked"';
	break;
}
?>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-title">
  <tr>
    <td class="tcell-left text11 bold"><?php echo ACCESS_TITLE;?></td>
	<td width="25"></td>
    <td><?php echo($access->lastname . " " . $access->firstname);?></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scrolling-content">
<form action="<?php echo $this->form_url;?>" method="post" class="coform jNice">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($access->id);?>">
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><?php echo ACCESS_LEVEL;?></td>
    <td>
    <table  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25"><input name="level" type="radio" value="2"<?php echo($guest);?> class="jNiceHidden" /></td>
        <td width="142"><?php echo ACCESS_LEVEL_GUEST;?></td>
        <td width="25">&nbsp;</td>
        <td width="25"><input name="level" type="radio" value="1"<?php echo($admin);?> class="jNiceHidden" /></td>
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
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
        <td class="tcell-left text11">Gruppenmitglied??</td>
        <td width="25"></td>
        <td class="tcell-right"></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-footer">
	<tr>
		<td class="tcell-left text11"><?php echo $lang["CREATED_BY_ON"];?></td>
		<td class="tcell-right text11"><?php echo($access->created_user.", ".$access->created_date);?></span></td>
    </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-footer">
	<tr>
		<td class="tcell-left text11"><?php echo $lang["EDITED_BY_ON"];?></td>
		<td class="tcell-right text11"><?php echo($access->edited_user.", ".$access->edited_date)?></td>
	</tr>
</table>
</form>
</div>
</div>
<div class="content-footer"></div>
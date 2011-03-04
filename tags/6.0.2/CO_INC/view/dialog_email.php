<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><a href="Subject" class="content-nav focusTitle"><span>Subject</span></a></td>
    <td><input type="text" name="title" class="title textarea-title" value="Subject" /></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scrolling-content">
<form action="<?php echo $this->form_url;?>" method="post" class="coform jNice">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($phase->id);?>">
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><a href="#" class="content-nav showDialog" request="getContactsDialog" field="management" append="1"><span><?php echo PHASE_MANAGEMENT;?></span></a></td>
		<td class="tcell-right"><div id="management" class="itemlist-field"><?php echo($phase->management);?></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
  <tr>
    <td class="tcell-left text11"><a href="<?php echo PHASE_DESCRIPTION;?>" class="content-nav activateToolbar"><span><?php echo PHASE_DESCRIPTION;?></span></a></td>
    <td class="tcell-right"><div class="protocol-outer"><textarea name="protocol" class="tinymce" id="protocol"><?php echo($phase->protocol);?></textarea></div></td>
  </tr>
</table>
</form>
</div>
</div>
<?php
$de = '';
$en = '';
switch($contact->lang) {
	case "de":
		$de = ' checked="checked"';
	break;
	case "en":
		$en = ' checked="checked"';
	break;
}
?>
<div>
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
	<tr>
		<td class="tcell-left text11"><a href="#" class="content-nav focusTitle"><span><?php echo $lang['CONTACTS_LASTNAME'];?></span></a></td>
		<td class="tcell-right"><input type="text" name="title" class="title textarea-title" value="<?php echo($contact->lastname);?>" /></td>
	</tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="coform jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setContactDetails">
<input type="hidden" name="id" value="<?php echo($contact->id);?>">
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><a href="#" class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_FIRSTNAME'];?></span></a></td>
    <td class="tcell-right"><input name="firstname" type="text" class="title2 bg" value="<?php echo($contact->firstname);?>" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><a href="#" class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_CONTACT_TITLE'];?></span></a></td>
    <td class="tcell-right"><input name="title" id="title" type="text" class="bg" value="<?php echo($contact->title);?>" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><a href="#" class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_COMPANY'];?></span></a></td>
    <td class="tcell-right"><input name="company" id="company" type="text" class="bg" value="<?php echo($contact->company);?>" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><a href="#" class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_POSITION'];?></span></a></td>
    <td class="tcell-right"><input name="position" id="position" type="text" class="bg" value="<?php echo($contact->position);?>" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><a href="#" class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_EMAIL'];?></span></a></td>
    <td class="tcell-right"><input name="email" type="text" class="bg" value="<?php echo($contact->email);?>" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><a href="#" class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_TEL'];?></span></a></td>
    <td class="tcell-right"><input name="phone1" id="phone1" type="text" class="bg" value="<?php echo($contact->phone1);?>" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><a href="#" class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_TEL2'];?></span></a></td>
    <td class="tcell-right"><input name="phone2" id="phone2" type="text" class="bg" value="<?php echo($contact->phone2);?>" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><a href="#" class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_FAX'];?></span></a></td>
    <td class="tcell-right"><input name="fax" id="fax" type="text" class="bg" value="<?php echo($contact->fax);?>" /></td>
  </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
    <tr>
        <td class="tcell-left text11"><a href="#" class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_ADDRESS_LINE1'];?></span></a></td>
        <td class="tcell-right"><input name="address_line1" id="address_line1" type="text" class="bg" value="<?php echo($contact->address_line1);?>" /></td>
        </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><a href="#" class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_ADDRESS_LINE2'];?></span></a></td>
    <td class="tcell-right"><input name="address_line2" id="address_line2" type="text" class="bg" value="<?php echo($contact->address_line2);?>" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><a href="#" class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_TOWN'];?></span></a></td>
    <td class="tcell-right"><input name="address_town" id="address_town" type="text" class="bg" value="<?php echo($contact->address_town);?>" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><a href="#" class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_POSTCODE'];?></span></a></td>
    <td class="tcell-right"><input name="address_postcode" id="address_postcode" type="text" class="bg" value="<?php echo($contact->address_postcode);?>" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><a href="#" class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_COUNTRY'];?></span></a></td>
    <td class="tcell-right"><input name="address_country" id="address_country" type="text" class="bg" value="<?php echo($contact->address_country);?>" /></td>
  </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="content-nav"><?php echo CONTACTS_CONTACT_USERNAME;?></span></td>
	  <td class="tcell-right"><?php echo($contact->username);?></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="content-nav"><?php echo CONTACTS_CONTACT_PASSWORD;?></span></td>
	  <td class="tcell-right"><?php echo($contact->pwd);?></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="content-nav"><?php echo CONTACTS_CONTACT_GROUPMEMBERSHIP;?></span></td>
	  <td class="tcell-right"><?php echo($contact->groups);?></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="content-nav"><?php echo CONTACTS_CONTACT_LANGUAGE;?></span></td>
	  <td width="25"><input title="lang" name="lang" type="radio" value="en"<?php echo($en);?> class="jNiceHidden" /></td><td width="25">en</td>
      <td width="25"><input title="lang" name="lang" type="radio" value="de"<?php echo($de);?> class="jNiceHidden" /></td><td>de</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
    <tr>
        <td class="tcell-left text11"><span class="content-nav">Zeitzone</span></td>
        <td class="tcell-right"><?php 
				$zonelist = array('Europe/London' => 'Europe/London',
													'Europe/Vienna' => 'Europe/Vienna'
													);
				?>
        <select name="timezone">
        <?php
					foreach($zonelist as $key => $value) {
						$checked = '';
						if($contact->timezone == $key) {
							$checked = ' checked = "checked"';
						}
						echo '		<option value="' . $key . '" ' . $checked . '>' . $value . '</option>' . "\n";
					}
					?>
        </select>
        </td>
    </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
    <tr>
        <td class="tcell-left text11"><span class="content-nav">Datum/Zeitanzeige</span></td>
        <td class="tcell-right">dd.mm.yyyy hh:mm</td>
    </tr>
</table>
</form>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($contact->edited_user.", ".$contact->edited_date)?></td>
    <td class="middle"></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($contact->created_user.", ".$contact->created_date);?></td>
  </tr>
</table>
</div>
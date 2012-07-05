<div class="table-title-outer">
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
	<tr>
		<td class="tcell-left text11"><span class="content-nav focusTitle"><span><?php echo $lang['CONTACTS_LASTNAME'];?></span></span></td>
		<td class="tcell-right"><input type="text" name="title" class="title textarea-title" value="<?php echo($contact->lastname);?>" /></td>
	</tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<div id="avatarImage" width="80"  style="position: absolute; top: 0; right: 15px; height: 120px; width: 80px; background-image:url(<?php echo($contact->avatar);?>); background-repeat: no-repeat">
<div id="contacts_image_uploader" class="user-image-uploader">		
	<noscript>			
	<p>Please enable JavaScript to use file uploader.</p>
	<!-- or put a simple form for upload here -->
	</noscript>
</div>
</div>
<form action="/" method="post" class="coform jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setContactDetails">
<input type="hidden" name="id" value="<?php echo($contact->id);?>">
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_FIRSTNAME'];?></span></span></td>
    <td class="tcell-right-nopadding"><input name="firstname" type="text" class="title2 bg" value="<?php echo($contact->firstname);?>" /></td>
    <td width="110"></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_CONTACT_TITLE'];?></span></span></td>
    <td class="tcell-right-nopadding"><input name="title" id="title" type="text" class="bg" value="<?php echo($contact->title);?>" /></td>
    <td width="110"></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_COMPANY'];?></span></span></td>
    <td class="tcell-right-nopadding"><input name="company" id="company" type="text" class="bg" value="<?php echo($contact->company);?>" /></td>
    <td width="110"></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_POSITION'];?></span></span></td>
    <td class="tcell-right-nopadding"><input name="position" id="position" type="text" class="bg" value="<?php echo($contact->position);?>" /></td>
    <td width="110"></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_EMAIL'];?></span></span></td>
    <td class="tcell-right-nopadding"><input id="email" name="email" type="text" class="bg" value="<?php echo($contact->email);?>" /></td>
    <td width="110"></td>
  </tr>
</table>
<div class="content-spacer"></div>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive">
  <tr>
    <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_TEL'];?></span></span></td>
    <td class="tcell-right-nopadding"><input name="phone1" id="phone1" type="text" class="bg" value="<?php echo($contact->phone1);?>" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive">
  <tr>
    <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_TEL2'];?></span></span></td>
    <td class="tcell-right-nopadding"><input name="phone2" id="phone2" type="text" class="bg" value="<?php echo($contact->phone2);?>" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive">
  <tr>
    <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_FAX'];?></span></span></td>
    <td class="tcell-right-nopadding"><input name="fax" id="fax" type="text" class="bg" value="<?php echo($contact->fax);?>" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive">
    <tr>
        <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_ADDRESS_LINE1'];?></span></span></td>
        <td class="tcell-right-nopadding"><input name="address_line1" id="address_line1" type="text" class="bg" value="<?php echo($contact->address_line1);?>" /></td>
        </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive">
  <tr>
    <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_ADDRESS_LINE2'];?></span></span></td>
    <td class="tcell-right-nopadding"><input name="address_line2" id="address_line2" type="text" class="bg" value="<?php echo($contact->address_line2);?>" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive">
  <tr>
    <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_TOWN'];?></span></span></td>
    <td class="tcell-right-nopadding"><input name="address_town" id="address_town" type="text" class="bg" value="<?php echo($contact->address_town);?>" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive">
  <tr>
    <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_POSTCODE'];?></span></span></td>
    <td class="tcell-right-nopadding"><input name="address_postcode" id="address_postcode" type="text" class="bg" value="<?php echo($contact->address_postcode);?>" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" style="margin-bottom: 0;">
  <tr>
    <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_COUNTRY'];?></span></span></td>
    <td class="tcell-right-nopadding"><input name="address_country" id="address_country" type="text" class="bg" value="<?php echo($contact->address_country);?>" /></td>
  </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="content-nav showDialog" request="getLanguageDialog" field="lang" append="0"><span><?php echo $lang['CONTACTS_LANGUAGE'];?></span></span></td>
      <td class="tcell-right"><div id="lang" class="itemlist-field"><?php echo($contact->lang);?></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="content-nav showDialog" request="getTimezoneDialog" field="timezone" append="0"><span><?php echo $lang['CONTACTS_TIMEZONE'];?></span></span></td>
      <td class="tcell-right"><div id="timezone" class="itemlist-field"><?php echo($contact->timezone);?></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left-inactive text11"><?php echo $lang['CONTACTS_GROUPMEMBERSHIP'];?></td>
	  <td class="tcell-right-inactive"><?php echo($contact->groups);?></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($contact->id != $session->uid) { ?>content-nav showDialog<?php } ?>" id="accesslink" request="getAccessDialog" field="access" append="0" sql="<?php echo($contact->access_status);?>"><span><?php echo $lang['CONTACTS_ACCESSCODES'];?></span></span></td>
	  <td class="tcell-right"><div id="access" class="itemlist-field"><?php echo($contact->access);?></div></td>
	</tr>
</table>
<?php if(!empty($contact->admin)) { ?>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_ADMIN"];?></td>
	  <td class="tcell-right-inactive"><?php echo($contact->admin);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($contact->guest)) { ?>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_GUEST"];?></td>
	  <td class="tcell-right-inactive"><?php echo($contact->guest);?></td>
	</tr>
</table>
<?php } ?>
<?php if($contact->option_sysadmin == 1) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($session->isSysadmin() && $contact->id != $session->uid) { ?>content-nav showDialog<?php } ?>" request="getSysadminDialog" field="sysadmin" append="0" sql="<?php echo($contact->sysadmin_status);?>"><span>System Manager</span></span></td>
	  <td class="tcell-right"><div id="sysadmin" class="itemlist-field"><?php echo($contact->sysadmin);?></div></td>
	</tr>
</table>
<?php } ?>
</form>
</div>
</div>
<div class="table-footer-outer">
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($contact->edited_user.", ".$contact->edited_date)?></td>
    <td class="middle"></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($contact->created_user.", ".$contact->created_date);?></td>
  </tr>
</table>
</div>
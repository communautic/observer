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
    <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_CONTACT_TITLE2'];?></span></span></td>
    <td class="tcell-right-nopadding"><input name="title2" id="title2" type="text" class="bg" value="<?php echo($contact->title2);?>" /></td>
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
<div id="contactTabs" class="contentTabs">
	<ul class="contentTabsList">
		<li><span class="active" rel="ContactAddress"><?php echo $lang["CONTACT_TAB_ADDRESS"];?></span></li>
		<li><span rel="ContactAccess"><?php echo $lang["CONTACT_TAB_ACCESS"];?></span></li>
        <li><span rel="ContactCalendar"><?php echo $lang["CONTACT_TAB_CALENDAR"];?></span></li>
	</ul>
    <div id="ContactTabsContent" class="contentTabsContent">
    <div id="ContactAddress">
    <table border="0" cellspacing="0" cellpadding="0" class="table-content">
    <tr>
        <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_ADDRESS_LINE1'];?></span></span></td>
        <td class="tcell-right-nopadding"><input name="address_line1" id="address_line1" type="text" class="bg" value="<?php echo($contact->address_line1);?>" /></td>
        </tr>
</table>
<!--<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_ADDRESS_LINE2'];?></span></span></td>
    <td class="tcell-right-nopadding"><input name="address_line2" id="address_line2" type="text" class="bg" value="<?php echo($contact->address_line2);?>" /></td>
  </tr>
</table>-->
<input name="address_line2" id="address_line2" type="hidden" class="bg" value="" />
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_TOWN'];?></span></span></td>
    <td class="tcell-right-nopadding"><input name="address_town" id="address_town" type="text" class="bg" value="<?php echo($contact->address_town);?>" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_POSTCODE'];?></span></span></td>
    <td class="tcell-right-nopadding"><input name="address_postcode" id="address_postcode" type="text" class="bg" value="<?php echo($contact->address_postcode);?>" /></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_COUNTRY'];?></span></span></td>
    <td class="tcell-right-nopadding"><input name="address_country" id="address_country" type="text" class="bg" value="<?php echo($contact->address_country);?>" /></td>
  </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive">
  <tr>
    <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_EMAIL'];?></span></span></td>
    <td class="tcell-right-nopadding"><input id="email" name="email" type="text" class="bg" value="<?php echo($contact->email);?>" /></td>
    <td width="110"></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive">
  <tr>
    <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_EMAIL_ALT'];?></span></span></td>
    <td class="tcell-right-nopadding"><input id="email_alt" name="email_alt" type="text" class="bg" value="<?php echo($contact->email_alt);?>" /></td>
    <td width="110"></td>
  </tr>
</table>
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
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
    <tr>
        <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_BANK_NAME'];?></span></span></td>
        <td class="tcell-right-nopadding"><input name="bank_name" id="bank_name" type="text" class="bg" value="<?php echo($contact->bank_name);?>" /></td>
        </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
    <tr>
        <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_BANK_SORT_CODE'];?></span></span></td>
        <td class="tcell-right-nopadding"><input name="sort_code" id="sort_code" type="text" class="bg" value="<?php echo($contact->sort_code);?>" /></td>
        </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
    <tr>
        <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_BANK_ACCOUNT_NBR'];?></span></span></td>
        <td class="tcell-right-nopadding"><input name="account_number" id="account_number" type="text" class="bg" value="<?php echo($contact->account_number);?>" /></td>
        </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
    <tr>
        <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_BANK_ACCOUNT_BIC'];?></span></span></td>
        <td class="tcell-right-nopadding"><input name="bic" id="bic" type="text" class="bg" value="<?php echo($contact->bic);?>" /></td>
        </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
    <tr>
        <td class="tcell-left-shorter text11"><span class="content-nav selectTextfield"><span><?php echo $lang['CONTACTS_BANK_ACCOUNT_IBAN'];?></span></span></td>
        <td class="tcell-right-nopadding"><input name="iban" id="iban" type="text" class="bg" value="<?php echo($contact->iban);?>" /></td>
        </tr>
</table>
    
    </div>
    <div id="ContactAccess" style="display: none;">
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($contact->id != $session->uid) { ?>content-nav showDialog<?php } ?>" id="accesslink" request="getAccessDialog" field="access" append="0" sql="<?php echo($contact->access_status);?>"><span><?php echo $lang['CONTACTS_ACCESSCODES'];?></span></span></td>
	  <td class="tcell-right"><div id="access" class="itemlist-field"><?php echo($contact->access);?></div></td>
	</tr>
</table>
<?php 
$style = "";
if($contact->option_sysadmin != 1) { 
$style = "display: none;";
}
?>
<div id="accessSysadmin" style="<?php echo $style;?>">
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($session->isSysadmin() && $contact->id != $session->uid) { ?>content-nav showDialog<?php } ?>" id="sysadminlink" request="getSysadminDialog" field="sysadmin" append="0" sql="<?php echo($contact->sysadmin_status);?>"><span>System Manager</span></span></td>
	  <td class="tcell-right"><div id="sysadmin" class="itemlist-field"><?php echo($contact->sysadmin);?></div></td>
	</tr>
</table>
</div>

<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left-inactive text11"><?php echo $lang['CONTACTS_GROUPMEMBERSHIP'];?></td>
	  <td class="tcell-right-inactive"><?php echo($contact->groups);?></td>
	</tr>
</table>
<div class="content-spacer"></div>
<?php 
if(is_array($contact->applications)) {
foreach($contact->applications as $key => $val) { ?>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive <?php echo $val['app'];?>-colorTable">
	<tr>
	  <td class="tcell-left-inactive text11 showAccessPermissions" style="padding-top: 2px; padding-bottom: 1px; color: #000"><?php echo $val['name'];?></td>
      <td class="text11" style="width: 30px; color: #666666;"><?php echo $val['num'];?></td>
	  <td class="tcell-right-inactive text11"><div class="AccessPermissions" style="display: none;"><?php echo($val['list']);?></div></td>
	</tr>
</table>
<?php
}
}
?>
    </div>
    
    
    <div id="ContactCalendar" style="display: none;">
		<?php if($contact->access_status != 0) { ?>
        <table border="0" cellpadding="0" cellspacing="0" class="table-content">
            <tr>
              <td class="tcell-left text11"><span><span><?php echo $lang["CONTACT_TAB_CALENDAR"];?></span></span></td>
              <td class="tcell-right"><?php echo $lang['CONTACTS_CALENDAR_NO_ACCESS'];?></td>
            </tr>
        </table>
        <?php } else { ?>
        <table border="0" cellpadding="0" cellspacing="0" class="table-content">
            <tr>
              <td class="tcell-left text11"><span class="<?php if($contact->access_status == 0) { ?>content-nav showDialog<?php } ?>" id="calendarLink" request="getCalendarDialog" field="hasCalendar" append="0" sql="<?php echo($contact->calendar);?>"><span><?php echo $lang["CONTACT_TAB_CALENDAR"];?></span></span></td>
              <td class="tcell-right"><div id="hasCalendar" class="itemlist-field"><?php echo($contact->calendar_status);?></div></td>
            </tr>
        </table>
        <?php } ?>
        <div class="content-spacer"></div>
       <?php if($contact->access_status == 0) { ?>
       <table border="0" cellpadding="0" cellspacing="0" class="table-content">
            <tr>
              <td class="tcell-left text11"><span><span>Outlook/iCalendar</span></span></td>
              <td class="tcell-right"><?php echo $contact->outlook_caldavurl;?></td>
            </tr>
        </table>
        <table border="0" cellpadding="0" cellspacing="0" class="table-content">
            <tr>
              <td class="tcell-left text11"><span><span>Apple</span></span></td>
              <td class="tcell-right"><?php echo $contact->ios_caldavurl;?></td>
            </tr>
        </table>
         <table border="0" cellpadding="0" cellspacing="0" class="table-content">
            <tr>
              <td class="tcell-left text11"><span><span>Andere / Caldav</span></span></td>
              <td class="tcell-right"><?php echo $contact->caldavurl;?></td>
            </tr>
        </table>
        <!--<table border="0" cellpadding="0" cellspacing="0" class="table-content">
            <tr>
              <td class="tcell-left text11"><span><span>Shared</span></span></td>
              <td class="tcell-right"><?php echo $contact->caldavurl_shared;?></td>
            </tr>
        </table>-->
        <?php } ?>
    </div>
    
    
    </div>
</div>
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
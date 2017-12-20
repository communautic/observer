<table width="100%" class="title">
	<tr>
		<td class="tcell-left"><?php echo $lang['CONTACTS_LASTNAME'];?></td>
		<td><strong><?php echo($contact->lastname);?></strong></td>
	</tr>
</table>
<?php if(!empty($contact->firstname)) { ?>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_FIRSTNAME'];?></td>
    <td><?php echo($contact->firstname);?></td>
  </tr>
</table>
<?php } ?>
<?php if(!empty($contact->title)) { ?>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_CONTACT_TITLE'];?></td>
    <td><?php echo($contact->title);?></td>
  </tr>
</table>
<?php } ?>
<?php if(!empty($contact->title2)) { ?>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_CONTACT_TITLE2'];?></td>
    <td><?php echo($contact->title2);?></td>
  </tr>
</table>
<?php } ?>
<?php if(!empty($contact->company)) { ?>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_COMPANY'];?></td>
    <td><?php echo($contact->company);?></td>
  </tr>
</table>
<?php } ?>
<?php if(!empty($contact->position)) { ?>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_POSITION'];?></td>
    <td><?php echo($contact->position);?></td>
  </tr>
</table>
<?php } ?>
<?php if(!empty($contact->gender)) { ?>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left">Geschlecht</td>
    <td><?php echo($contact->gender);?></td>
  </tr>
</table>
<?php } ?>
<?php if(!empty($contact->email)) { ?>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_EMAIL'];?></td>
    <td><?php echo($contact->email);?></td>
  </tr>
</table>
<?php } ?>
<?php if(!empty($contact->email_alt)) { ?>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_EMAIL_ALT'];?></td>
    <td><?php echo($contact->email_alt);?></td>
  </tr>
</table>
<?php } ?>
&nbsp;
<?php if(!empty($contact->phone1)) { ?>
<table width="100%" class="standard grey">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_TEL'];?></td>
    <td><?php echo($contact->phone1);?></td>
  </tr>
</table>
<?php } ?>
<?php if(!empty($contact->phone2)) { ?>
<table width="100%" class="standard-grey">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_TEL2'];?></td>
    <td><?php echo($contact->phone2);?></td>
  </tr>
</table>
<?php } ?>
<?php if(!empty($contact->fax)) { ?>
<table width="100%" class="standard-grey">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_FAX'];?></td>
    <td><?php echo($contact->fax);?></td>
  </tr>
</table>
<?php } ?>
<?php if(!empty($contact->website)) { ?>
<table width="100%" class="standard-grey">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_WEBSITE'];?></td>
    <td><?php echo($contact->website);?></td>
  </tr>
</table>
<?php } ?>
<?php if(!empty($contact->address_line1)) { ?>
<table width="100%" class="standard-grey">
    <tr>
        <td class="tcell-left"><?php echo $lang['CONTACTS_ADDRESS_LINE1'];?></td>
        <td><?php echo($contact->address_line1);?></td>
     </tr>
</table>
<?php } ?>
<!--
<table width="100%" class="standard-grey">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_ADDRESS_LINE2'];?></td>
    <td><?php echo($contact->address_line2);?></td>
  </tr>
</table>
-->
<?php if(!empty($contact->address_town)) { ?>
<table width="100%" class="standard-grey">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_TOWN'];?></td>
    <td><?php echo($contact->address_town);?></td>
  </tr>
</table>
<?php } ?>
<?php if(!empty($contact->address_postcode)) { ?>
<table width="100%" class="standard-grey">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_POSTCODE'];?></td>
    <td><?php echo($contact->address_postcode);?></td>
  </tr>
</table>
<?php } ?>
<?php if(!empty($contact->address_country)) { ?>
<table width="100%" class="standard-grey">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_COUNTRY'];?></td>
    <td><?php echo($contact->address_country);?></td>
  </tr>
</table>
<?php } ?>
&nbsp;
<?php if(!empty($contact->bank_name)) { ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['CONTACTS_BANK_NAME'];?></td>
      <td><?php echo($contact->bank_name);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($contact->sort_code)) { ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['CONTACTS_BANK_SORT_CODE'];?></td>
      <td><?php echo($contact->sort_code);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($contact->account_number)) { ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['CONTACTS_BANK_ACCOUNT_NBR'];?></td>
      <td><?php echo($contact->account_number);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($contact->iban)) { ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['CONTACTS_BANK_ACCOUNT_IBAN'];?></td>
      <td><?php echo($contact->iban);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($contact->bic)) { ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['CONTACTS_BANK_ACCOUNT_BIC'];?></td>
      <td><?php echo($contact->bic);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($contact->vat_no)) { ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['CONTACTS_VAT_NO'];?></td>
      <td><?php echo($contact->vat_no);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($contact->company_no)) { ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['CONTACTS_COMPANY_NO'];?></td>
      <td><?php echo($contact->company_no);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($contact->company_reg_loc)) { ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['CONTACTS_LEGAL_PLACE'];?></td>
      <td><?php echo($contact->company_reg_loc);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($contact->dvr)) { ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['CONTACTS_DVR_NUMBER'];?></td>
      <td><?php echo($contact->dvr);?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<?php if(!empty($contact->lang)) { ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['CONTACTS_LANGUAGE'];?></td>
      <td><?php echo($contact->lang);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($contact->timezone)) { ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['CONTACTS_TIMEZONE'];?></td>
      <td><?php echo($contact->timezone);?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<?php if(!empty($contact->groups)) { ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left  top grey"><?php echo $lang['CONTACTS_GROUPMEMBERSHIP'];?></td>
	  <td><?php echo($contact->groups);?></td>
	</tr>
</table>
<?php } ?>
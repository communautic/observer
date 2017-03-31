<table width="100%" class="title">
	<tr>
		<td class="tcell-left"><?php echo $lang['CONTACTS_LASTNAME'];?></td>
		<td><strong><?php echo($contact->lastname);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_FIRSTNAME'];?></td>
    <td><?php echo($contact->firstname);?></td>
  </tr>
</table>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_CONTACT_TITLE'];?></td>
    <td><?php echo($contact->title);?></td>
  </tr>
</table>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_CONTACT_TITLE2'];?></td>
    <td><?php echo($contact->title2);?></td>
  </tr>
</table>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_COMPANY'];?></td>
    <td><?php echo($contact->company);?></td>
  </tr>
</table>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_POSITION'];?></td>
    <td><?php echo($contact->position);?></td>
  </tr>
</table>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_EMAIL'];?></td>
    <td><?php echo($contact->email);?></td>
  </tr>
</table>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_EMAIL_ALT'];?></td>
    <td><?php echo($contact->email_alt);?></td>
  </tr>
</table>
&nbsp;
<table width="100%" class="standard grey">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_TEL'];?></td>
    <td><?php echo($contact->phone1);?></td>
  </tr>
</table>
<table width="100%" class="standard-grey">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_TEL2'];?></td>
    <td><?php echo($contact->phone2);?></td>
  </tr>
</table>
<table width="100%" class="standard-grey">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_FAX'];?></td>
    <td><?php echo($contact->fax);?></td>
  </tr>
</table>
<table width="100%" class="standard-grey">
    <tr>
        <td class="tcell-left"><?php echo $lang['CONTACTS_ADDRESS_LINE1'];?></td>
        <td><?php echo($contact->address_line1);?></td>
     </tr>
</table>
<!--
<table width="100%" class="standard-grey">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_ADDRESS_LINE2'];?></td>
    <td><?php echo($contact->address_line2);?></td>
  </tr>
</table>
-->
<table width="100%" class="standard-grey">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_TOWN'];?></td>
    <td><?php echo($contact->address_town);?></td>
  </tr>
</table>
<table width="100%" class="standard-grey">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_POSTCODE'];?></td>
    <td><?php echo($contact->address_postcode);?></td>
  </tr>
</table>
<table width="100%" class="standard-grey">
  <tr>
    <td class="tcell-left"><?php echo $lang['CONTACTS_COUNTRY'];?></td>
    <td><?php echo($contact->address_country);?></td>
  </tr>
</table>
&nbsp;
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['CONTACTS_BANK_NAME'];?></td>
      <td><?php echo($contact->bank_name);?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['CONTACTS_BANK_SORT_CODE'];?></td>
      <td><?php echo($contact->sort_code);?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['CONTACTS_BANK_ACCOUNT_IBAN'];?></td>
      <td><?php echo($contact->iban);?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['CONTACTS_BANK_ACCOUNT_BIC'];?></td>
      <td><?php echo($contact->bic);?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['CONTACTS_VAT_NO'];?></td>
      <td><?php echo($contact->vat_no);?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['CONTACTS_COMPANY_NO'];?></td>
      <td><?php echo($contact->company_no);?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['CONTACTS_LEGAL_PLACE'];?></td>
      <td><?php echo($contact->company_reg_loc);?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['CONTACTS_DVR_NUMBER'];?></td>
      <td><?php echo($contact->dvr);?></td>
	</tr>
</table>
&nbsp;
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['CONTACTS_LANGUAGE'];?></td>
      <td><?php echo($contact->lang);?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['CONTACTS_TIMEZONE'];?></td>
      <td><?php echo($contact->timezone);?></td>
	</tr>
</table>
&nbsp;
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left  top grey"><?php echo $lang['CONTACTS_GROUPMEMBERSHIP'];?></td>
	  <td><?php echo($contact->groups);?></td>
	</tr>
</table>
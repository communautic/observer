<table width="100%" class="standard">
	<tr>
		<td style="text-align: right; line-height: 14px;"><p class="smalltext"><?php echo($invoice->m_title)?> <?php echo($invoice->m_firstname)?> <?php echo($invoice->m_lastname)?></p>
        <p class="smalltext">Fon <?php echo($invoice->m_phone)?></p>
        <?php if($invoice->m_fax != "") { ?><p class="smalltext">Fax <?php echo($invoice->m_fax)?></p><?php } ?>
        <p class="smalltext"><?php echo($invoice->m_email)?></p>
        <?php if($invoice->m_email_alt != "") { ?><p class="smalltext"><?php echo($invoice->m_email_alt)?></p><?php } ?>
	</tr>
</table>
<p style="line-height: 10px;">&nbsp;</p>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;"class="standard">
    <tr>
        <td width="53%" class="smalltext11">
						<span style="padding:0; line-height: 19px;"><?php echo($invoice->ctitle)?> <?php echo($invoice->title2)?> <?php echo($invoice->lastname);?> <?php echo($invoice->firstname);?></span><br />
            <span style="padding:0; line-height: 19px;"><?php echo($invoice->address_line1)?></span><br />
            <span style="padding:0; line-height: 19px;"><?php if($invoice->address_country != "") { echo $invoice->address_country . ' - '; } ?><?php echo($invoice->address_postcode)?> <?php echo($invoice->address_town)?></span>
            </td>
        <td width="17%" class="smalltext" valign="middle">
        	<!--<?php if($invoice->invoice_type == 1) { ?><span style="line-height: 15px;">&nbsp;</span><br /><?php } ?>-->
          <span style="line-height: 16px;">Rechnungsdatum</span><br />
          <span style="line-height: 16px;"><?php echo $lang["PATIENT_INVOICE_NUMBER"];?></span>
          <?php if($invoice->invoice_type == 0) { ?><span style="line-height: 16px;">Leistungszeitraum</span><?php } ?>
         </td>
        <td style="text-align: right;" class="smalltext" valign="middle">
        <!--<?php if($invoice->invoice_type == 1) { ?><span style="line-height: 15px;">&nbsp;</span><br /><?php } ?>-->
				<span style="line-height: 16px;"><?php echo $invoice->invoice_date;?></span><br />
        <span style="line-height: 16px;"><?php echo $invoice->invoice_addon . '/' . $invoice->invoice_year . '/' . $invoice->invoice_no;?></span><br />
        <?php if($invoice->invoice_type == 0) { ?><span style="line-height: 16px;"><?php echo($invoice->treatment_start);?> - <?php echo($invoice->treatment_end);?></span><?php } ?>
        </td>
    </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p style="line-height: 2px;">&nbsp;</p>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;"class="standard">
    <tr>
        <td width="50%">
							<p style="font-size: 24pt;">Rechnung</p>
            </td>
        <td width="50%" style="text-align: right;">
					<p style="font-size: 24pt;"><?php if($invoice->status_invoice == 3) { ?><span style="color: #ff3300;"><?php echo 'Storno';?></span><?php } ?></p>
        </td>
    </tr>
</table>
<?php if($invoice->invoice_type == 0) { ?>
<p>&nbsp;</p>
<?php if($patient->code != "") { ?>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="25%" class="smalltext" style="line-height: 10px;"><?php if(CO_PRODUCT_VARIANT == 1) { echo $lang["PATIENT_CODE_PO"]; }?><?php if(CO_PRODUCT_VARIANT == 2) { echo $lang["PATIENT_CODE_TO"]; }?></td>
        <td class="smalltext" style="line-height: 10px;"><?php echo $patient->code;?></td>
    </tr>
</table>
<?php } ?>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="25%" class="smalltext" style="line-height: 10px;">Patient/in</td>
        <td class="smalltext" style="line-height: 10px;"><?php echo($invoice->patient)?></td>
    </tr>
</table>
<?php if($invoice->number != "") { ?>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="25%" class="smalltext" style="line-height: 10px;"><?php echo $lang["PATIENT_INSURANCE_NUMBER"];?></td>
        <td class="smalltext" style="line-height: 10px;"><?php echo($invoice->number)?></td>
    </tr>
</table>
<?php } ?>
<?php if($invoice->number_insurer != "") { ?>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="25%" class="smalltext" style="line-height: 10px;"><?php echo $lang["PATIENT_INSURER"];?></td>
        <td class="smalltext" style="line-height: 10px;"><?php echo($invoice->insurer);?></td>
    </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="25%" class="smalltext" style="line-height: 10px;"><?php echo $lang["PATIENT_INSURANCE_INSURER_NUMBER"];?></td>
        <td class="smalltext" style="line-height: 10px;"><?php echo($invoice->number_insurer)?></td>
    </tr>
</table>
<?php } ?>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="25%" class="smalltext" style="line-height: 10px;">Adresse</td>
        <td class="smalltext" style="line-height: 10px;"><?php echo($invoice->patient_address)?></td>
    </tr>
</table>
<?php if($invoice->protocol != "") { ?>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="25%" class="smalltext" style="line-height: 10px;"><?php echo $lang["PATIENT_TREATMENT_DOCTOR_DIAGNOSE"];?></td>
        <td class="smalltext" style="line-height: 10px;"><?php echo($invoice->protocol)?></td>
    </tr>
</table>
<?php } ?>
<?php if(CO_PRODUCT_VARIANT == 2) { ?>
<?php if($invoice->method != "") { ?>
<table width="100%" cellpadding="0" cellspacing="0" style="padding-right: 10pt;">
    <tr>
        <td width="25%" class="smalltext" style="line-height: 10px;"><?php echo $lang["PATIENT_TREATMENT_METHOD"];?></td>
        <td class="smalltext" style="line-height: 10px;"><?php echo($invoice->method)?></td>
    </tr>
</table>
<?php } ?>
<?php } ?>
<?php } ?>
<p>&nbsp;</p>



<?php 
if($invoice->invoice_type == 0) {

	if($invoice->barzahlung == 1) { ?>
		<table width="100%" class="standard" style="border:1px solid #ccc;">
    <?php
			foreach($task as $value) { 
				$checked = '';
				if($value->status == 1  && is_array($value->type) && $value->bar == 1) { ?>
					<tr>
						<td width="25%" style="border-bottom:1px solid #ccc; padding:5px 1px 0;" class="smalltext"><span style="margin-left: 7px;"><?php echo $value->number;?>. <?php echo $lang["PATIENT_TREATMENT_GOALS_SINGUAL"];?></span></td>
						<td width="32%" style="border-bottom:1px solid #ccc; padding:5px 0 1px 0;" class="smalltext">(<?php echo $value->item_date;?>)</td>
						<td width="15%" style="border-bottom:1px solid #ccc; padding:5px 0 1px 0;" class="smalltext"><?php foreach($value->type as $t) { echo '<span>' . $t['positionstext'] . ' ' . $t['shortname'] . '</span><br />'; } ?></td>
						<td style="border-bottom:1px solid #ccc; padding:5px 7px 1px 0; text-align: right;" class="smalltext">
            <?php foreach($value->type as $t) { 
							if($t['minutes'] != 0) {
								echo $t['minutes'] . 'min.<br />'; 
							} else {
								echo '<br />'; 
							}
						}?></td>
						<td width="20%" style="padding:5px 7px 1px 0; text-align: right; border-left: 1px solid #ccc; border-bottom: 1px solid #ccc;" class="smalltext">
            <?php foreach($value->type as $t) { 
							if($t['costs'] != 0.00) {
								echo CO_DEFAULT_CURRENCY . ' ' . $t['costs'] . '<br />'; 
							} else {
								echo '<br />'; 
							}
						}?>
             </td>
				</tr>
			 
		<?php }
			} ?>
		</table>
	<?php 
	 
		if($invoice->ueberweisung != 0) { ?>
			<?php if($invoice->discount > 0) { ?>
				<table width="100%" class="standard" style="margin-top: 0;">
          <tr>
            <td width="25%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
            <td width="32%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
            <td width="23%" style="text-align: right; padding:5px 8px 1px 0;" class="smalltext">-<?php echo $invoice->discount;?>% <?php echo $lang["PATIENT_TREATMENT_DISCOUNT_SHORT"];?></td>
            <td width="20%" style="text-align: right; padding:5px 7px 1px 0;" class="smalltext">-<?php echo CO_DEFAULT_CURRENCY . ' ' . $invoice->discount_barcosts;?></td>
          </tr>
        </table>
			<?php } ?>
         
			<?php if($invoice->vat > 0) { ?>
        <table width="100%" class="standard" style="margin-top: 0;">
          <tr>
            <td width="25%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
            <td width="32%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
            <td width="23%" style="text-align: right; padding:5px 8px 1px 0;" class="smalltext"><?php echo $invoice->vat;?>% <?php echo $lang["PATIENT_TREATMENT_VAT_SHORT"];?></td>
            <td width="20%" style="text-align: right; padding:5px 7px 1px 0;" class="smalltext"><?php echo CO_DEFAULT_CURRENCY . ' ' . $invoice->vat_barcosts;?></td>
          </tr>
				</table>
			<?php }?>
      
      	<table width="100%" class="standard" style="border:1px solid #ccc; margin-top: 3px;">
          <tr style="background: #e5e5e5;">
            <td width="25%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
            <td width="32%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
            <td width="23%" style="text-align: right; padding:5px 8px 2px 0;" class="smalltext"><b>Barzahlung</b></td>
            <td width="20%" style="text-align: right; padding:5px 7px 1px 0;" class="smalltext"><b><?php echo CO_DEFAULT_CURRENCY;?> <?php echo $invoice->barcosts;?></b></td>
          </tr>
    		</table>
				<p>&nbsp;</p>
         
		<?php } ?>
	<?php }

	//Überweisungen
	if($invoice->ueberweisung == 1) { ?>
		<table width="100%" class="standard" style="border:1px solid #ccc;">
    <?php
			foreach($task as $value) { 
				$checked = '';
				if($value->status == 1  && is_array($value->type) && $value->bar == 0) { ?>
					<tr>
						<td width="25%" style="border-bottom:1px solid #ccc; padding:5px 1px 0;" class="smalltext"><span style="margin-left: 7px;"><?php echo $value->number;?>. <?php echo $lang["PATIENT_TREATMENT_GOALS_SINGUAL"];?></span></td>
						<td width="32%" style="border-bottom:1px solid #ccc; padding:5px 0 1px 0;" class="smalltext">(<?php echo $value->item_date;?>)</td>
						<td width="15%" style="border-bottom:1px solid #ccc; padding:5px 0 1px 0;" class="smalltext"><?php foreach($value->type as $t) { echo '<span>' . $t['positionstext'] . ' ' . $t['shortname'] . '</span><br />'; } ?></td>
						<td style="border-bottom:1px solid #ccc; padding:5px 7px 1px 0; text-align: right;" class="smalltext">
            <?php foreach($value->type as $t) { 
							if($t['minutes'] != 0) {
								echo $t['minutes'] . 'min.<br />'; 
							} else {
								echo '<br />'; 
							}
						}?>
            </td>
						<td width="20%" style="padding:5px 7px 1px 0; text-align: right; border-left: 1px solid #ccc; border-bottom: 1px solid #ccc;" class="smalltext">
            <?php foreach($value->type as $t) { 
							if($t['costs'] != 0.00) {
								echo CO_DEFAULT_CURRENCY . ' ' . $t['costs'] . '<br />'; 
							} else {
								echo '<br />'; 
							}
						}?>
            </td>
				</tr>
			 
		<?php }
			} ?>
		</table>
		<?php 
	 
		if($invoice->barzahlung != 0) { ?>
			<?php if($invoice->discount > 0) { ?>
				<table width="100%" class="standard" style="margin-top: 0;">
          <tr>
            <td width="25%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
            <td width="32%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
            <td width="23%" style="text-align: right; padding:5px 8px 1px 0;" class="smalltext">-<?php echo $invoice->discount;?>% <?php echo $lang["PATIENT_TREATMENT_DISCOUNT_SHORT"];?></td>
            <td width="20%" style="text-align: right; padding:5px 7px 1px 0;" class="smalltext">-<?php echo CO_DEFAULT_CURRENCY . ' ' . $invoice->discount_restcosts;?></td>
          </tr>
        </table>
			<?php } ?>
         
			<?php if($invoice->vat > 0) { ?>
        <table width="100%" class="standard" style="margin-top: 0;">
          <tr>
            <td width="25%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
            <td width="32%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
            <td width="23%" style="text-align: right; padding:5px 8px 1px 0;" class="smalltext"><?php echo $invoice->vat;?>% <?php echo $lang["PATIENT_TREATMENT_VAT_SHORT"];?></td>
            <td width="20%" style="text-align: right; padding:5px 7px 1px 0;" class="smalltext"><?php echo CO_DEFAULT_CURRENCY . ' ' . $invoice->vat_restcosts;?></td>
          </tr>
				</table>
			<?php }?>
      
      	<table width="100%" class="standard" style="border:1px solid #ccc; margin-top: 3px;">
          <tr style="background: #e5e5e5;">
            <td width="25%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
            <td width="32%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
            <td width="23%" style="text-align: right; padding:5px 8px 2px 0;" class="smalltext"><b>Überweisung<?php if($invoice->barzahlung == 1) { ?> Restbetrag<?php } ?></b></td>
            <td width="20%" style="text-align: right; padding:5px 7px 1px 0;" class="smalltext"><b><?php echo CO_DEFAULT_CURRENCY;?> <?php echo $invoice->restcosts;?></b></td>
          </tr>
    		</table>
				<p>&nbsp;</p>
		<?php } 
		}
} ?>

<?php 
if($invoice->invoice_type == 1) {

	if($invoice->barzahlung == 1) { ?>
		<table width="100%" class="standard" style="border:1px solid #ccc;">
    <?php
			foreach($task as $value) { 
				$checked = '';
				if($value->status == 1 && $value->bar == 1) { ?>
        <tr>
        <td width="20%" style="border-bottom:1px solid #ccc; padding:5px 1px 0;" class="smalltext"><span style="margin-left: 7px;"><?php echo $value->number;?>. Inhalt</span></td>
        <td width="10%" style="border-bottom:1px solid #ccc; padding:5px 0 1px 0;" class="smalltext"><?php echo $value->menge;?>x</td>
        <td width="30%" style="border-bottom:1px solid #ccc; padding:5px 0 1px 0;" class="smalltext"><?php echo $value->title;?></td>
        <td style="border-bottom:1px solid #ccc; padding:5px 7px 1px 0; text-align: right;" class="smalltext"> à <?php echo CO_DEFAULT_CURRENCY . ' ' . $value->preis;?></td>
        <td width="20%" style="padding:5px 7px 1px 0; text-align: right; border-left: 1px solid #ccc; border-bottom: 1px solid #ccc;" class="smalltext"><?php echo CO_DEFAULT_CURRENCY . ' ' . $value->taskcosts . '<br />'; ?> 
        </td>
    </tr>
    

			 
		<?php }
			} ?>
		</table>
	<?php 
	 
		if($invoice->ueberweisung != 0) { ?>
			<?php if($invoice->discount > 0) { ?>
				<table width="100%" class="standard" style="margin-top: 0;">
          <tr>
            <td width="25%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
            <td width="32%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
            <td width="23%" style="text-align: right; padding:5px 8px 1px 0;" class="smalltext">-<?php echo $invoice->discount;?>% <?php echo $lang["PATIENT_TREATMENT_DISCOUNT_SHORT"];?></td>
            <td width="20%" style="text-align: right; padding:5px 7px 1px 0;" class="smalltext">-<?php echo CO_DEFAULT_CURRENCY . ' ' . $invoice->discount_barcosts;?></td>
          </tr>
        </table>
			<?php } ?>
         
			<?php if($invoice->vat > 0) { ?>
        <table width="100%" class="standard" style="margin-top: 0;">
          <tr>
            <td width="25%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
            <td width="32%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
            <td width="23%" style="text-align: right; padding:5px 8px 1px 0;" class="smalltext"><?php echo $invoice->vat;?>% <?php echo $lang["PATIENT_TREATMENT_VAT_SHORT"];?></td>
            <td width="20%" style="text-align: right; padding:5px 7px 1px 0;" class="smalltext"><?php echo CO_DEFAULT_CURRENCY . ' ' . $invoice->vat_barcosts;?></td>
          </tr>
				</table>
			<?php }?>
      
      	<table width="100%" class="standard" style="border:1px solid #ccc; margin-top: 3px;">
          <tr style="background: #e5e5e5;">
            <td width="25%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
            <td width="32%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
            <td width="23%" style="text-align: right; padding:5px 8px 2px 0;" class="smalltext"><b>Barzahlung</b></td>
            <td width="20%" style="text-align: right; padding:5px 7px 1px 0;" class="smalltext"><b><?php echo CO_DEFAULT_CURRENCY;?> <?php echo $invoice->barcosts;?></b></td>
          </tr>
    		</table>
				<p>&nbsp;</p>
         
		<?php } ?>
	<?php }

	//Überweisungen
	if($invoice->ueberweisung == 1) { ?>
		<table width="100%" class="standard" style="border:1px solid #ccc;">
    <?php
			foreach($task as $value) { 
				$checked = '';
				if($value->status == 1 && $value->bar == 0) { ?>
					 <tr>
        <td width="20%" style="border-bottom:1px solid #ccc; padding:5px 1px 0;" class="smalltext"><span style="margin-left: 7px;"><?php echo $value->number;?>. Inhalt</span></td>
        <td width="10%" style="border-bottom:1px solid #ccc; padding:5px 0 1px 0;" class="smalltext"><?php echo $value->menge;?>x</td>
        <td width="30%" style="border-bottom:1px solid #ccc; padding:5px 0 1px 0;" class="smalltext"><?php echo $value->title;?></td>
        <td style="border-bottom:1px solid #ccc; padding:5px 7px 1px 0; text-align: right;" class="smalltext"> à <?php echo CO_DEFAULT_CURRENCY . ' ' . $value->preis;?></td>
        <td width="20%" style="padding:5px 7px 1px 0; text-align: right; border-left: 1px solid #ccc; border-bottom: 1px solid #ccc;" class="smalltext"><?php echo CO_DEFAULT_CURRENCY . ' ' . $value->taskcosts . '<br />'; ?> 
        </td>
			 
		<?php }
			} ?>
		</table>
		<?php 
	 
		if($invoice->barzahlung != 0) { ?>
			<?php if($invoice->discount > 0) { ?>
				<table width="100%" class="standard" style="margin-top: 0;">
          <tr>
            <td width="25%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
            <td width="32%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
            <td width="23%" style="text-align: right; padding:5px 8px 1px 0;" class="smalltext">-<?php echo $invoice->discount;?>% <?php echo $lang["PATIENT_TREATMENT_DISCOUNT_SHORT"];?></td>
            <td width="20%" style="text-align: right; padding:5px 7px 1px 0;" class="smalltext">-<?php echo CO_DEFAULT_CURRENCY . ' ' . $invoice->discount_restcosts;?></td>
          </tr>
        </table>
			<?php } ?>
         
			<?php if($invoice->vat > 0) { ?>
        <table width="100%" class="standard" style="margin-top: 0;">
          <tr>
            <td width="25%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
            <td width="32%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
            <td width="23%" style="text-align: right; padding:5px 8px 1px 0;" class="smalltext"><?php echo $invoice->vat;?>% <?php echo $lang["PATIENT_TREATMENT_VAT_SHORT"];?></td>
            <td width="20%" style="text-align: right; padding:5px 7px 1px 0;" class="smalltext"><?php echo CO_DEFAULT_CURRENCY . ' ' . $invoice->vat_restcosts;?></td>
          </tr>
				</table>
			<?php }?>
      
      	<table width="100%" class="standard" style="border:1px solid #ccc; margin-top: 3px;">
          <tr style="background: #e5e5e5;">
            <td width="25%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
            <td width="32%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
            <td width="23%" style="text-align: right; padding:5px 8px 2px 0;" class="smalltext"><b>Überweisung<?php if($invoice->barzahlung == 1) { ?> Restbetrag<?php } ?></b></td>
            <td width="20%" style="text-align: right; padding:5px 7px 1px 0;" class="smalltext"><b><?php echo CO_DEFAULT_CURRENCY;?> <?php echo $invoice->restcosts;?></b></td>
          </tr>
    		</table>
				<p>&nbsp;</p>
		<?php } 
		}
} ?>
   
	 <?php if($invoice->discount > 0) { ?>
   <table width="100%" class="standard" style="margin-top: 0;">
              <tr>
                <td width="25%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
                <td width="32%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
				<td width="23%" style="text-align: right; padding:5px 8px 1px 0;" class="smalltext">-<?php echo $invoice->discount;?>% <?php echo $lang["PATIENT_TREATMENT_DISCOUNT_SHORT"];?></td>
				<td width="20%" style="text-align: right; padding:5px 7px 1px 0;" class="smalltext">-<?php echo CO_DEFAULT_CURRENCY . ' ' . $invoice->discount_costs;?></td>
</tr>
</table>
	 <?php }?>
     <?php if($invoice->vat > 0) { ?>
     <table width="100%" class="standard" style="margin-top: 0;">
              <tr>
                <td width="25%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
                <td width="32%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
				<td width="23%" style="text-align: right; padding:5px 8px 1px 0;" class="smalltext"><?php echo $invoice->vat;?>% <?php echo $lang["PATIENT_TREATMENT_VAT_SHORT"];?></td>
				<td width="20%" style="text-align: right; padding:5px 7px 1px 0;" class="smalltext"><?php echo CO_DEFAULT_CURRENCY . ' ' . $invoice->vat_costs;?></td>
</tr>
</table>
	 <?php }?>
   <table width="100%" class="standard" style="border:1px solid #ccc; margin-top: 3px;">
      <tr style="background: #e5e5e5;">
				<td width="25%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
				<td width="32%" style="padding:5px 0 1px 0;" class="smalltext">&nbsp;</td>
				<td width="23%" style="text-align: right; padding:5px 8px 2px 0;" class="smalltext"><b>Gesamt</b></td>
				<td width="20%" style="text-align: right; padding:5px 7px 1px 0;" class="smalltext"><b><?php echo CO_DEFAULT_CURRENCY;?> <?php echo $invoice->totalcosts;?></b></td>
      </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php if($invoice->ueberweisung != 0) { ?>
	<?php if(CO_PRODUCT_VARIANT == 2) { ?>
    	<p class="smalltext11"><?php echo $lang["PATIENT_INVOICE_REQUEST_PAYMENT"];?></p>
    <?php } else { ?>
    	<p class="smalltext11"><?php echo $lang["PATIENT_INVOICE_TEXT_LINE2"];?></p>
        <p class="tinytext">&nbsp;</p>
        <p class="smalltext11"><?php echo $lang["PATIENT_INVOICE_TEXT_LINE3"];?></p>
    <?php } ?>
<?php } else { ?>
<p class="smalltext11"><?php echo $lang["PATIENT_INVOICE_PAYMENT_CASH"];?></p>
	<?php if(CO_PRODUCT_VARIANT == 1) { ?>
        <p class="tinytext">&nbsp;</p>
        <p class="smalltext11"><?php echo $lang["PATIENT_INVOICE_TEXT_LINE3"];?></p>
    <?php } ?>
<?php } ?>
<p class="tinytext">&nbsp;</p>
<span class="smalltext11"><?php echo nl2br($invoice->protocol_invoice);?></span>
<p class="tinytext">&nbsp;</p>
<p class="smalltext11"><?php echo $lang["PATIENT_INVOICE_TEXT_LINE4"];?></p>
<p class="smalltext">&nbsp;</p>
<p class="smalltext">&nbsp;</p>
<p class="smalltext">&nbsp;</p>
<p class="smalltext">&nbsp;</p>
<p class="smalltext">&nbsp;</p>
<p class="smalltext">&nbsp;</p>
<p  class="smalltext11" style="line-height: 18px;"><?php echo($invoice->m_title)?> <?php echo($invoice->m_firstname)?> <?php echo($invoice->m_lastname)?><br />
<span class="smalltext"><?php echo($invoice->m_position)?></span>
</p>

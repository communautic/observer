<?php
$hideTab2 = 0;
$hideTab3 = 0;
switch($field) {
	case "projectsadmins": case "projectsguests": case "procsadmins": case "procsguests": case "forumsadmins": case "forumsguests": case "complaintsadmins": case "complaintsguests": case "clientsadmins": case "clientsguests": case "publishersadmins": case "publishersguests": case "to": case "cc": case "custom":
		$hideTab3 = 1;
	break;
	case "patientsmanagement":
		if($title == 'Betreuung') {
			$hideTab2 = 1;
			$hideTab3 = 1;
		}
	break;
	case "patientsinvoicemanagement":
		if($title == 'therapist') {
			$hideTab2 = 1;
			$hideTab3 = 1;
		}
	break;
	case "patientsinvoice_carrier": case "patientsinvoiceaddress": 
			$hideTab2 = 1;
			$hideTab3 = 1;
	break;
}
if (preg_match("/postitto/i", $field)) {
   $hideTab3 = 1;
}
if (preg_match("/treatments_task_team/i", $field)) {
   $hideTab2 = 1;
   $hideTab3 = 1;
}
?>
<div id="tabs" class="tabs-bottom">
	<ul>
		<li><a href="#tabs-1"><span><?php echo $lang['CONTACTS_CONTACT'];?></span></a></li><?php if($hideTab2 == 0) { ?><li><a href="#tabs-2"><span><?php echo $lang['CONTACTS_GROUP_TITLE'];?></span></a></li><?php } ?><?php if($hideTab3 == 0) { ?><li><a href="#tabs-3"><span><?php echo $lang['CONTACTS_CUSTOM'];?></span></a></li><?php } ?>
	</ul>
	<div id="tabs-1">
		<div class="contact-dialog-header"><input class="contacts-search" field="<?php echo($field);?>" append="<?php echo($append);?>" /><div class="filter-search-outer"></div></div>
		<div class="dialog-text-2">
        <div>
        <?php
        	if(is_array($contacts)) {
				foreach ($contacts as $contact) { ?>
        			<a href="#" class="insertContactfromDialog" field="<?php echo($field);?>" append="<?php echo($append);?>" cid="<?php echo($contact["id"]);?>"><?php echo($contact["name"]);?></a>
            <?php
				}
			}
		?>
        </div>
        </div>
    </div>
	<?php if($hideTab2 == 0) { ?>
    <div id="tabs-2">
    	<div class="contact-dialog-header"><input class="groups-search" field="<?php echo($field);?>" /><div class="filter-search-outer"></div></div>
        <div class="dialog-text-2">
        <div>
		<?php
			if(is_array($groups)) {
				foreach ($groups as $group) { ?>
					<a href="#" class="insertGroupfromDialog" title="<?php echo($group["title"]);?>" field="<?php echo($field);?>" append="<?php echo($append);?>" gid="<?php echo($group["id"]);?>"><?php echo($group["title"]);?></a>
		<?php
				}
			}
		?>
		</div>
        </div>
	</div>
    <?php } ?>
	<?php if($hideTab3 == 0) { ?>
    <div id="tabs-3">
    	<div class="contact-dialog-header"><a href="#" class="append-custom-text save" field="<?php echo($field);?>" ><?php echo $lang["GLOBAL_SAVE"];?></a></div>
		<div class="dialog-text-2"><textarea id="custom-text" name="custom-text" cols="20" rows="2"></textarea></div>
    <?php } ?>
</div>
<div class="dialog-text">
<?php
$sysadmin_status = $_GET["sql"];

if($sysadmin_status == 1) {
?>
<a href="#" id="actionSysadmin"  rel="<?php echo($field);?>"><?php echo $lang['CONTACTS_SYSADMIN_GIVE_RIGHT'];?></a>
<?php } else { ?>
<a href="#" id="actionSysadminRemove"  rel="<?php echo($field);?>"><?php echo $lang['CONTACTS_SYSADMIN_REMOVE_RIGHT'];?></a>
<?php } ?>
</div>
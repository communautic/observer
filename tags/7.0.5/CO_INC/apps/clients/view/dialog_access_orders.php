<div class="dialog-text">
<?php
$access_status = $_GET["sql"];

if($access_status == 1) {
?>
<a href="#" id="actionAccessOrders"  rel="<?php echo($field);?>"><?php echo $lang['CONTACTS_ACCESSCODES_SEND'];?></a>
<?php } else { ?>
<a href="#" id="actionAccessOrdersRemove"  rel="<?php echo($field);?>"><?php echo $lang['CONTACTS_ACCESSCODES_REMOVE'];?></a>
<?php } ?>
</div>
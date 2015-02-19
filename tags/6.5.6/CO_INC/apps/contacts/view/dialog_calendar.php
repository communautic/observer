<div class="dialog-text">
<?php
$calendar_status = $_GET["sql"];

if($calendar_status == 1) {
?>
<a href="#" id="actionCalendarRemove"  rel="<?php echo($field);?>"><?php echo $lang['CONTACTS_CALENDAR_REMOVE_RIGHT'];?></a>
<?php } else { ?>
<a href="#" id="actionCalendar"  rel="<?php echo($field);?>"><?php echo $lang['CONTACTS_CALENDAR_GIVE_RIGHT'];?></a>
<?php } ?>
</div>
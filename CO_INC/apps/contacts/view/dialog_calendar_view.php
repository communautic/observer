<div class="dialog-text">
<?php
$calendar_all_status = $_GET["sql"];

if($calendar_all_status == 1) {
?>
<a href="#" id="actionCalendarViewAllRemove"  rel="<?php echo($field);?>">nicht sichtbar</a>
<?php } else { ?>
<a href="#" id="actionCalendarViewAll"  rel="<?php echo($field);?>">sichtbar</a>
<?php } ?>
</div>
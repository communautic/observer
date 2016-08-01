<div class="tabs-bottom">
<div id="tabs-cal">
<div class="contact-dialog-header"><input class="calendarpatients-search" field="<?php echo($field);?>" /><div class="filter-search-outer"></div></div>
<div class="dialog-text-4" style="overflow-y: auto;">
<div>
<?php
    if(is_array($patients)) {
        foreach ($patients as $patient) { ?>
            <a style="line-height: 19px;" href="#" class="insertCalendarPatientfromDialog" field="<?php echo($field);?>" append="<?php echo($append);?>" cid="<?php echo($patient["id"]);?>"><?php echo($patient["label"]);?></a>
    <?php
        }
    }
?>
</div>
</div>
</div>
</div>
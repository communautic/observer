<div class="tabs-bottom">
<div id="tabs-cal">
<div class="contact-dialog-header"><input class="calendartreatments-search" field="<?php echo($field);?>" /><div class="filter-search-outer"></div></div>
<div class="dialog-text-4" style="overflow-y: auto;">
<div>
<?php
    if(is_array($treatments)) {
        foreach ($treatments as $treatment) { ?>
            <a style="line-height: 19px;" href="#" class="insertCalendarTreatmentfromDialog" field="<?php echo($field);?>" append="<?php echo($append);?>" cid="<?php echo($treatment["id"]);?>"><?php echo($treatment["label"]);?></a>
    <?php
        }
    }
?>
</div>
</div>
</div>
</div>
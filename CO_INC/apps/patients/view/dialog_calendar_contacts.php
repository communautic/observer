<div class="tabs-bottom">
<div id="tabs-cal">
<div class="contact-dialog-header"><input class="calendarcontacts-search" field="<?php echo($field);?>" /><div class="filter-search-outer"></div></div>
<div class="dialog-text-4" style="overflow-y: auto;">
<div>
<?php
    if(is_array($contacts)) {
        foreach ($contacts as $contact) { ?>
            <a style="line-height: 19px;" href="#" class="insertCalendarContactfromDialog" field="<?php echo($field);?>" append="<?php echo($append);?>" cid="<?php echo($contact["id"]);?>"><?php echo($contact["name"]);?></a>
    <?php
        }
    }
?>
</div>
</div>
</div>
</div>
<div id="tabs" class="tabs-bottom">
<div id="tabs-1">
<div class="contact-dialog-header"><input class="treatments-search" field="<?php echo($field);?>" /><div class="filter-search-outer"></div></div>
<div class="dialog-text-4">
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
</div>
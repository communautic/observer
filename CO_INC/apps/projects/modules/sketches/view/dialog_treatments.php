<div id="tabs" class="tabs-bottom">
<div id="tabs-1">
<div class="contact-dialog-header"><input class="sketches-search" field="<?php echo($field);?>" /><div class="filter-search-outer"></div></div>
<div class="dialog-text-4">
<div>
<?php
    if(is_array($sketches)) {
        foreach ($sketches as $sketch) { ?>
            <a href="#" class="insertSketchfromDialog" field="<?php echo($field);?>" append="<?php echo($append);?>" cid="<?php echo($sketch["id"]);?>" costs="<?php echo($sketch["costs"]);?>" minutes="<?php echo($sketch["minutes"]);?>"><?php echo($sketch["shortname"]);?></a>
    <?php
        }
    }
?>
</div>
</div>
</div>
</div>
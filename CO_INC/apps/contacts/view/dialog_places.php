<div id="tabs" class="tabs-bottom">
	<ul>
		<li><a href="#tabs-1"><span><?php echo $lang['CONTACTS_CONTACT'];?></span></a></li><li><a href="#tabs-2"><span><?php echo $lang['CONTACTS_CUSTOM'];?></span></a></li>
	</ul>
	<div id="tabs-1"><div class="contact-dialog-header"><input class="places-search" field="<?php echo($field);?>"/><div class="filter-search-outer"></div></div>
    <div class="dialog-text-2">
    <div>
        <?php
        	if(is_array($places)) {
				foreach ($places as $place) { ?>
        			<a href="#" class="insertPlacesfromDialog" field="<?php echo($field);?>" append="<?php echo($append);?>" cid="<?php echo($place["id"]);?>"><?php echo($place["name"]);?></a><span style="display: none;"><?php echo($place["address"]);?></span>
            <?php
				}
			}
		?>
        </div>
    </div>
    </div>
	<div id="tabs-2">
		<div class="contact-dialog-header"><a href="#" class="append-custom-text save" field="<?php echo($field);?>" ><?php echo $lang["GLOBAL_SAVE"];?></a></div>
		<div class="dialog-text-2"><textarea id="custom-text" name="custom-text" cols="20" rows="2"></textarea></div>
    </div>
</div>
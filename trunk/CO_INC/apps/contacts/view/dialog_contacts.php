<div id="tabs">
	<ul>
		<li><a href="#tabs-1"><?php echo $lang['CONTACTS_CONTACT'];?></a></li>
		<li><a href="#tabs-2"><?php echo $lang['CONTACTS_GROUP_TITLE'];?></a></li>
		<li><a href="#tabs-3"><?php echo $lang['CONTACTS_CUSTOM'];?></a></li>
	</ul>
	<div id="tabs-1">
		<div class="dialog-text-2"><input class="contacts-search" title="<?php echo($field);?>"/></div><div class="filter-search-outer" style="margin-top: 10px;"></div>
		<div class="dialog-text-2">
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
	<div id="tabs-2">
    	<div class="dialog-text-2"><input class="groups-search" title="<?php echo($field);?>"/></div><div class="filter-search-outer" style="margin-top: 10px;"></div>
        <div class="dialog-text-2">
        <div>
		<?php
			if(is_array($groups)) {
				foreach ($groups as $group) { ?>
					<a href="#" class="insertGroupfromDialog" title="<?php echo($group["title"]);?>" field="<?php echo($field);?>" append="<?php echo($append);?>" gid="<?php echo($group["id"]);?>"><?php echo($group["title"]);?></a>
		<?php
				}
			}
		?>
		</div>
        </div>
	</div>
	<div id="tabs-3">
		<div class="dialog-text"><textarea id="custom-text" name="custom-text" cols="20" rows="2"></textarea>
<br />
<div class="coButton-outer"><span class="append-custom-text coButton" field="<?php echo($field);?>"><?php echo $lang["GLOBAL_SAVE"];?></span></div></div>
	</div>
</div>

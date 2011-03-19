<div id="tabs">
	<ul>
		<li><a href="#tabs-1"><?php echo $lang['CONTACTS_CONTACT'];?></a></li>
		<li><a href="#tabs-2"><?php echo $lang['CONTACTS_CUSTOM'];?></a></li>
	</ul>
	<div id="tabs-1"><div class="dialog-text">
		<input class="places-search" title="<?php echo($field);?>"/>
	</div></div>
	<div id="tabs-2">
		<div class="dialog-text"><textarea id="custom-text" name="custom-text" cols="20" rows="2"></textarea>
<br />
<a href="#" class="append-custom-text" field="<?php echo($field);?>"><?php echo $lang["GLOBAL_SAVE"];?></a>
	</div></div>
</div>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Kontakt</a></li>
		<li><a href="#tabs-2">Gruppe</a></li>
		<li><a href="#tabs-3">manuell</a></li>
	</ul>
	<div id="tabs-1">
		<div class="dialog-text"><input class="contacts-search" title="<?php echo($field);?>"/></div>
	</div>
	<div id="tabs-2"><div class="dialog-text">
		<?php
if(is_array($list)) {
foreach ($list as $item) { ?>
	<a href="#" class="insertGroupfromDialog" title="<?php echo($item->title);?>" field="<?php echo($field);?>" append="<?php echo($append);?>" gid="<?php echo($item->id);?>"><?php echo($item->title);?></a>
    <?php
}
			}
?>
	</div></div>
	<div id="tabs-3">
		<div class="dialog-text"><textarea id="custom-text" name="custom-text" cols="20" rows="2"></textarea>
<br />
<a href="#" class="append-custom-text" field="<?php echo($field);?>">Speichern</a></div>
	</div>
</div>

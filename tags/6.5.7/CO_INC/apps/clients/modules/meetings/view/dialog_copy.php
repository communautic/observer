<div id="tabs" class="tabs-bottom">
<div id="tabs-1">
<div class="contact-dialog-header"><input class="clients-search" /><div class="filter-search-outer"></div></div>
<div class="dialog-text-4">
        <div>
<?php
if(is_array($clients)) {
	foreach ($clients as $client) { ?>
		<a href="#" class="addClientLink" rel="<?php echo($client["id"]);?>"><?php echo($client["title"]);?></a>
<?php
	}
}
?>
</div>
</div>
</div>
</div>
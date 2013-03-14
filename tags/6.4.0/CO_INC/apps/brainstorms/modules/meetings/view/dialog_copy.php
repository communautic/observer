<div id="tabs" class="tabs-bottom">
<div id="tabs-1">
<div class="contact-dialog-header"><input class="brainstorms-search" /><div class="filter-search-outer"></div></div>
<div class="dialog-text-4">
        <div>
<?php
if(is_array($brainstorms)) {
	foreach ($brainstorms as $brainstorm) { ?>
		<a href="#" class="addBrainstormLink" rel="<?php echo($brainstorm["id"]);?>"><?php echo($brainstorm["title"]);?></a>
<?php
	}
}
?>
</div>
</div>
</div>
</div>
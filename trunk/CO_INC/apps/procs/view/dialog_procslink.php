<div id="tabs" class="tabs-bottom">
<div id="tabs-1">
<div class="contact-dialog-header"><input class="procs-search" /><div class="filter-search-outer"></div></div>
<div class="dialog-text-4">
        <div>
<?php
if(is_array($procs)) {
	foreach ($procs as $proc) { ?>
		<a href="#" class="addProcLink" rel="<?php echo($proc["id"]);?>"><?php echo($proc["title"]);?></a>
<?php
	}
}
?>
</div>
</div>
</div>
</div>
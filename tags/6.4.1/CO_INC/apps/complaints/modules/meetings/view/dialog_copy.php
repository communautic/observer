<div id="tabs" class="tabs-bottom">
<div id="tabs-1">
<div class="contact-dialog-header"><input class="complaints-search" /><div class="filter-search-outer"></div></div>
<div class="dialog-text-4">
        <div>
<?php
if(is_array($complaints)) {
	foreach ($complaints as $complaint) { ?>
		<a href="#" class="addComplaintLink" rel="<?php echo($complaint["id"]);?>"><?php echo($complaint["title"]);?></a>
<?php
	}
}
?>
</div>
</div>
</div>
</div>
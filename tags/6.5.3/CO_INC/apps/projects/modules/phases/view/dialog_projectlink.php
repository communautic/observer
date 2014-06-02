<div id="tabs" class="tabs-bottom">
<div id="tabs-1">
<div class="contact-dialog-header"><input class="projects-search" /><div class="filter-search-outer"></div></div>
<div class="dialog-text-4">
        <div>
<?php
if(is_array($projects)) {
	foreach ($projects as $project) { ?>
		<a href="#" class="addProjectLink" rel="<?php echo($project["id"]);?>"><?php echo($project["title"]);?></a>
<?php
	}
}
?>
</div>
</div>
</div>
</div>
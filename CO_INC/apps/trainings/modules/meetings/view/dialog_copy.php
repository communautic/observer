<div id="tabs" class="tabs-bottom">
<div id="tabs-1">
<div class="contact-dialog-header"><input class="trainings-search" /><div class="filter-search-outer"></div></div>
<div class="dialog-text-4">
        <div>
<?php
if(is_array($trainings)) {
	foreach ($trainings as $training) { ?>
		<a href="#" class="addTrainingLink" rel="<?php echo($training["id"]);?>"><?php echo($training["title"]);?></a>
<?php
	}
}
?>
</div>
</div>
</div>
</div>
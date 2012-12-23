<div id="tabs" class="tabs-bottom">
<div id="tabs-1">
<div class="contact-dialog-header"><input class="patients-search" /><div class="filter-search-outer"></div></div>
<div class="dialog-text-4">
        <div>
<?php
if(is_array($patients)) {
	foreach ($patients as $patient) { ?>
		<a href="#" class="addPatientLink" rel="<?php echo($patient["id"]);?>"><?php echo($patient["title"]);?></a>
<?php
	}
}
?>
</div>
</div>
</div>
</div>
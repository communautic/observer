<div id="tabs" class="tabs-bottom">
<div id="tabs-1">
<div class="contact-dialog-header"><input class="employees-search" /><div class="filter-search-outer"></div></div>
<div class="dialog-text-4">
        <div>
<?php
if(is_array($employees)) {
	foreach ($employees as $employee) { ?>
		<a href="#" class="addEmployeeLink" rel="<?php echo($employee["id"]);?>"><?php echo($employee["title"]);?></a>
<?php
	}
}
?>
</div>
</div>
</div>
</div>
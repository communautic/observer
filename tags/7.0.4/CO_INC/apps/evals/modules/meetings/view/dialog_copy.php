<div id="tabs" class="tabs-bottom">
<div id="tabs-1">
<div class="contact-dialog-header"><input class="evals-search" /><div class="filter-search-outer"></div></div>
<div class="dialog-text-4">
        <div>
<?php
if(is_array($evals)) {
	foreach ($evals as $eval) { ?>
		<a href="#" class="addEvalLink" rel="<?php echo($eval["id"]);?>"><?php echo($eval["title"]);?></a>
<?php
	}
}
?>
</div>
</div>
</div>
</div>
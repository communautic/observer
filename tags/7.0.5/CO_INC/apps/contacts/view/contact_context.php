<div class="context">
	<div class="contact-dialog-header">
	<?php if($edit == "undefined" || $edit == "1") { ?>
    <a href="delete" class="delete-listmember" uid="<?php echo($context->id);?>" field="<?php echo($context->field);?>"><?php echo $lang["GLOBAL_DELETE"];?></a>
	<?php } ?>
    </div>
    <div class="dialog-text-3"></div>
</div>

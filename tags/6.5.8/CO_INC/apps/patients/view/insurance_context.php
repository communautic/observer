<div class="context">
	<div class="contact-dialog-header">
	<?php if($edit == "undefined" || $edit == "1") { ?>
    <a href="delete" class="delete-listmember" uid="<?php echo($context->id);?>" field="<?php echo($context->field);?>"><?php echo $lang["GLOBAL_DELETE"];?></a>
	<?php } ?>
    </div>
    <div class="dialog-text-3">
	<p><span rel="<?php echo($context->id);?>"><?php echo($context->name);?></span></p>
    <div class="text11">
    <?php echo(nl2br($context->text));?>
    </div>
</div>
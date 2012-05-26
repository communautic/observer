<div class="context">
	<div class="contact-dialog-header">
	<?php if($edit == "undefined" || $edit == "1") { ?>
    <a href="delete" class="delete-listmember" uid="<?php echo($context->id);?>" field="<?php echo($context->field);?>"><?php echo $lang["GLOBAL_DELETE"];?></a>
	<?php } ?>
    </div>
    <div class="dialog-text-3">
	<p><?php echo($context->lastname);?> <?php echo($context->firstname);?></p>
    <div class="text11"><?php echo(nl2br($context->position));?><br />
    <?php echo(nl2br($context->company));?><br />
    <?php echo($context->phone1);?><br />
    <div style="overflow: hidden; padding: 0;"><?php echo($context->email);?></div></div>
    </div>
</div>
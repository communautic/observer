<div class="context">
	<?php if($edit == "undefined" || $edit == "1") { ?>
    <a href="delete" class="delete-listmember" uid="<?php echo($context->id);?>" field="<?php echo($context->field);?>"><?php echo $lang["GLOBAL_REMOVE"];?></a><br />
	------------------- <br /><?php } ?>
	<?php echo($context->lastname);?> <?php echo($context->firstname);?><br />
    <span class="text11"><?php echo(nl2br($context->position));?><br />
    <?php echo(nl2br($context->company));?><br />
    <?php echo($context->phone1);?><br />
    <?php echo($context->email);?><br /></span>
</div>
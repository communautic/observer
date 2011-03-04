<div class="context">
	<a href="delete" class="delete-listmember" uid="<?php echo($context->id);?>" field="<?php echo($context->field);?>">Entfernen</a><br />
    <!--Contact Details<br />
    write Email<br />-->
	------------------- <br />
	<?php echo($context->lastname);?> <?php echo($context->firstname);?><br />
    <span class="text11"><?php echo(nl2br($context->position));?><br />
    <?php echo(nl2br($context->company));?><br />
    <?php echo($context->phone1);?><br />
    <?php echo($context->email);?><br /></span>
</div>
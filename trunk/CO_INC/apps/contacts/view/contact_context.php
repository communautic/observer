<div class="context">
	<div class="contact-dialog-header">
	<?php if($edit == "undefined" || $edit == "1") { ?>
    <a href="delete" class="delete-listmember" uid="<?php echo($context->id);?>" field="<?php echo($context->field);?>"><?php echo $lang["GLOBAL_DELETE"];?></a>
	<?php } ?>
    </div>
    <div class="dialog-text-3">
	<p><span rel="<?php echo($context->id);?>" class="loadContactExternal co-link"><?php echo($context->lastname);?> <?php echo($context->firstname);?></span></p>
    <div class="text11">
    <div style="overflow: hidden; padding: 0; height: 22px;"><?php echo(nl2br($context->company));?></div>
    <div class="regular"><a href="callto:<?php echo($context->phone1);?>"><?php echo($context->phone1);?></a></div>
    <div class="regular"><a href="mailto:<?php echo($context->email);?>"><?php echo($context->email);?></a></div><br />
    <?php echo($context->address_line1);?><br />
    <?php echo($context->address_postcode);?> <?php echo($context->address_town);?><br /></div>
    </div>
</div>
<div class="context">
<div class="contact-dialog-header"><a href="projects_documents" class="removeItem" uid="<?php echo($document->id);?>" field="<?php echo($document->field);?>"><?php echo $lang["GLOBAL_DELETE"];?></a></div>
	<div class="dialog-text-3">
    <?php  foreach($doc as $value) { ?>
    <a mod="projects_documents" class="downloadDocument" rel="<?php echo $value->id;?>" title="Download"><?php echo($value->filename)?></a>
    <?php } ?>
    </div>
</div>
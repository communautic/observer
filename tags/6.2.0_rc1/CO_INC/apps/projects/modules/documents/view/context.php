<div class="context">
	<a href="projects_documents" class="removeItem" uid="<?php echo($document->id);?>" field="<?php echo($document->field);?>"><?php echo $lang["GLOBAL_REMOVE"];?></a><br />
	------------------- <br />
    <?php  foreach($doc as $value) { ?>
    <a mod="projects_documents" class="downloadDocument" rel="<?php echo $value->id;?>" title="Download"><?php echo($value->filename)?></a><br />
    <?php } ?>
    <br />
</div>
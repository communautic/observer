<div class="context">
	<a href="delete" class="delete-docitem" uid="<?php echo($document->id);?>" field="<?php echo($document->field);?>"><?php echo $lang["GLOBAL_REMOVE"];?></a><br />
	------------------- <br />
	<?php echo($document->title);?><br />
    <?php  foreach($doc as $value) { ?>
    <a href="Download" class="downloadDocument" rel="<?php echo $value->id;?>" title="Download"><?php echo($value->filename)?></a><br />
    <?php } ?>
    <br />
</div>
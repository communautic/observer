<div class="context">
<div class="contact-dialog-header"><a href="complaints_documents" class="removeItem" uid="<?php echo($document->id);?>" field="<?php echo($document->field);?>"><?php echo $lang["GLOBAL_DELETE"];?></a>v
    <?php  foreach($doc as $value) { ?>
    <a mod="complaints_documents" class="downloadDocument" rel="<?php echo $value->id;?>" title="Download"><?php echo($value->filename)?></a>
    <?php } ?>
    </div>
</div>
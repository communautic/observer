<div class="dialog-text">
<?php
if(is_array($list)) {
	foreach ($list as $item) { ?>
		<a href="#" mod="clients_documents" class="insertItem" title="<?php echo($item->title);?>" field="<?php echo($field);?>" append="<?php echo($append);?>" did="<?php echo($item->id);?>"><?php echo($item->title);?></a>
	<?php
	}
}
?>
</div>
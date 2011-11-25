<?php
if(is_array($posts)) {
	$i = 1;
	foreach ($posts as $postit) { 
		list($left,$top,$zindex) = explode('x',$postit->xyz);
		list($width,$height) = explode('x',$postit->wh);
	?>
    <div id="postit-<?php echo($postit->id);?>" class="postit postit-design" style="width: <?php echo $width;?>px; height: <?php echo $height;?>px; left: <?php echo $left;?>px; top: <?php echo $top;?>px; z-index: <?php echo $zindex;?>; font-size: 11px;">
        <div id="postit-delete-<?php echo($postit->id);?>" class="brainstormsNoteDelete" style="position: absolute; top: 1px; right: 6px; width: 15px; height: 15px; cursor: pointer;"><a rel="<?php echo($postit->id);?>" class="binItem"><span class="icon-delete"></span></a></div>
        <div id="postit-text-<?php echo($postit->id);?>" class="postit-text" style="height: <?php echo $height;?>px;"><?php echo(nl2br($postit->text));?></div>
	</div>
    <?php 
	}
}
?>

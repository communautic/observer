<?php
if(is_array($posts)) {
	$i = 1;
	foreach ($posts as $postit) { 
		list($left,$top,$zindex) = explode('x',$postit->xyz);
		list($width,$height) = explode('x',$postit->wh);
	?>
    <div id="postit-<?php echo($postit->id);?>" class="postit postit-design" style="width: <?php echo $width;?>px; height: <?php echo $height;?>px; left: <?php echo $left;?>px; top: <?php echo $top;?>px; z-index: <?php echo $zindex;?>;">
        <div class="postit-header"><span class="postit-header-left"><?php echo $postit->days;?></span><span class="postit-header-right"><?php echo $postit->date;?></span></div>
        <textarea style="height: <?php echo $height-80;?>px; border: 0;" name="postit-text-<?php echo($postit->id);?>" id="postit-text-<?php echo($postit->id);?>" class="postit-text" rel="<?php echo($postit->id);?>"><?php echo $postit->text;?></textarea>
        <div class="postit-footer">
        	<?php if($postit->display_readby) { ?><span id="postit-markread-<?php echo($postit->id);?>" class="postit-markread">
            <?php if($postit->display_readby_active) { ?><a rel="<?php echo($postit->id);?>" class="markreadItem"><?php } ?>
            	<span class="<?php echo $postit->display_readby_class; ?>"></span>
            <?php if($postit->display_readby_active) { ?></a><?php } ?>
            </span><?php } ?>
            <span id="postit-forward-<?php echo($postit->id);?>" class="postit-forward"><a rel="<?php echo($postit->id);?>" class="forwardItem"><span class="desktop-icon-forward"></span></a></span>
        	<span id="postit-delete-<?php echo($postit->id);?>" class="postit-delete"><a rel="<?php echo($postit->id);?>" class="binItem"><span class="desktop-icon-delete"></span></a></span>
        	<span id="postit-info-<?php echo($postit->id);?>" class="postit-info coTooltip"><span class="desktop-icon-info"></span><div class="coTooltipHtml" style="display: none">
				<?php echo $lang["READ_BY_ON"];?> <?php echo($postit->readby)?><br>
				<?php echo $lang["SENDTO_BY_ON"];?> <?php echo($postit->sendto)?><br>
				<?php echo $lang["SENDFROM_BY_ON"];?> <?php echo($postit->sendfrom);?><br>
				<?php echo $lang["EDITED_BY_ON"];?> <?php echo($postit->edited_user.", ".$postit->edited_date)?><br>
				<?php echo $lang["CREATED_BY_ON"];?> <?php echo($postit->created_user.", ".$postit->created_date);?>
            </div></span>
        </div>
        
        <div id="postit-window-<?php echo($postit->id);?>" style="display: none; z-index: 99999; outline: 0px none; position: absolute; width: 300px; height: auto; bottom: 0;" class="nodrag ui-dialog ui-widget ui-widget-content ui-corner-all sendtoWindow" tabindex="-1" role="dialog" aria-labelledby="ui-dialog-title-modalDialogForward">
        <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix"><span class="ui-dialog-title" id="ui-dialog-title-modalDialogForward"><?php echo $lang["GLOBAL_FORWARD"];?></span><a href="#" rel="<?php echo($postit->id);?>" class="ui-dialog-titlebar-close ui-corner-all forwardClose" role="button"><span class="ui-icon ui-icon-closethick">close</span></a></div>
        <div id="modalDialogPostitForward" style="height: 100px; overflow: auto;" class="ui-dialog-content ui-widget-content" scrolltop="0" scrollleft="0"><div class="content-spacer"></div>
<table cellspacing="0" cellpadding="0" border="0" class="table-window">
	<tbody><tr>
		<td class="tcell-left text11"><a append="1" field="postitto<?php echo($postit->id);?>" request="getContactsDialog" class="content-nav showDialog" href="#"><span><?php echo $lang["GLOBAL_TO"];?></span></a></td>
		<td class="tcell-right text13"><div class="itemlist-field" id="postitto<?php echo($postit->id);?>"></div></td>
	</tr>
</tbody></table>
<div class="content-spacer"></div>
<div class="coButton-outer"><span class="content-nav actionForwardPostit coButton" rel="<?php echo($postit->id);?>"><?php echo $lang["GLOBAL_SEND"];?></span></div>
<p>&nbsp;</p>
</div></div>
	</div>
    <?php 
	}
}
?>

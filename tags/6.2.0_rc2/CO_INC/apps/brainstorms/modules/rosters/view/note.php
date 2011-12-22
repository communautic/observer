    <div id="note" class="note" style="width: 200px; height: 200px; left: <?php echo $left;?>px; top: <?php echo $top;?>px; font-size: 11px;">
        <h3 id="note-header" class="ui-widget-header">
        <div id="note-title" class="note-title"><?php echo($note->title);?></div>
        <div id="note-info" class="brainstormsNoteInfo coTooltip" style="position: absolute; top: 0px; right: 45px; width: 15px; height: 15px; cursor: pointer;"><span class="icon-info"></span>
        	<div style="display: none" class="coTooltipHtml">
				<?php echo $lang["EDITED_BY_ON"];?> <?php echo($note->edited_user.", ".$note->edited_date)?><br>
				<?php echo $lang["CREATED_BY_ON"];?> <?php echo($note->created_user.", ".$note->created_date);?>
			</div>
        </div>
        <div id="note-delete" class="brainstormsNoteDelete" style="position: absolute; top: 1px; right: 6px; width: 15px; height: 15px; cursor: pointer;"><a class="binItem"><span class="icon-delete"></span></a></div>
        </h3>
        <div id="note-text" class="note-text" style="height: <?php echo 200-35;?>px;"><?php echo(nl2br($note->text));?></div>
	</div>
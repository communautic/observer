<div>
<div id="brainstorms-action-new" style="display: none"><?php echo $lang["BRAINSTORM_ACTION_NEW"];?></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($brainstorm->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["BRAINSTORM_TITLE"];?></span></span></td>
    <td class="tcell-right"><?php if($brainstorm->canedit) { ?><input name="title" type="text" class="title textarea-title" value="<?php echo($brainstorm->title);?>" maxlength="100" /><?php } else { ?><div class="textarea-title"><?php echo($brainstorm->title);?></div><?php } ?></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($brainstorm->canedit) { ?>coform <?php } ?>">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setBrainstormDetails">
<input type="hidden" name="id" value="<?php echo($brainstorm->id);?>">
<?php if($brainstorm->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span>Warnung</span></span></strong></td>
		<td class="tcell-right"><strong>Dieser Inhaltsbereich wird aktuell bearbeitet von: <?php echo($brainstorm->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($brainstorm->checked_out_user_email);?>"><?php echo($brainstorm->checked_out_user_email);?></a>, <?php echo($brainstorm->checked_out_user_phone1);?></td>
    </tr>
</table>
<div class="content-spacer"></div>
<?php } ?>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($brainstorm->canedit) { ?>content-nav brainstormsAddNote<?php } ?>"><span><?php echo $lang['BRAINSTORM_NOTE_ADD'];?></span></span></td>
		<td class="tcell-right"></td>
	</tr>
</table>
</form>
<div id="brainstorms-outer">
<?php
if(is_array($notes)) {
	$i = 1;
	foreach ($notes as $note) { 
		list($left,$top,$zindex) = explode('x',$note->xyz);
		list($width,$height) = explode('x',$note->wh);
		if($note->toggle == 0) {
			$realheight = $height;
			$toggle_class = "";
		} else {
			$realheight = $height;
			$height = 17;
			$toggle_class = "-active";
		}
	?>
    <div id="note-<?php echo($note->id);?>" class="<?php if($brainstorm->canedit) { ?>note<?php } ?> note-design" style="width: <?php echo $width;?>px; height: <?php echo $height;?>px; left: <?php echo $left;?>px; top: <?php echo $top;?>px; z-index: <?php echo $zindex;?>; font-size: 11px;">
        <h3 id="note-header-<?php echo($note->id);?>" class="ui-widget-header">
        <div id="note-title-<?php echo($note->id);?>" <?php if($brainstorm->canedit) { ?>class="note-title<?php } ?>"><?php echo($note->title);?></div>
        <?php if($brainstorm->canedit) { ?>
        <div id="note-info-<?php echo($note->id);?>" class="brainstormsNoteInfo coTooltip" style="position: absolute; top: 0px; right: 45px; width: 15px; height: 15px; cursor: pointer;"><span class="icon-info"></span>
        	<div style="display: none" class="coTooltipHtml">
				<?php echo $lang["EDITED_BY_ON"];?> <?php echo($note->edited_user.", ".$note->edited_date)?><br>
				<?php echo $lang["CREATED_BY_ON"];?> <?php echo($note->created_user.", ".$note->created_date);?>
			</div>
        </div>      
        <div id="note-toggle-<?php echo($note->id);?>" class="brainstormsNoteToggle" rel="<?php echo $realheight;?>" style="position: absolute; top: 2px; right: 27px; width: 15px; height: 15px; cursor: pointer;"><span class="icon-toggle<?php echo $toggle_class;?>"></span></div>
        <div id="note-delete-<?php echo($note->id);?>" class="brainstormsNoteDelete" style="position: absolute; top: 1px; right: 6px; width: 15px; height: 15px; cursor: pointer;"><a rel="<?php echo($note->id);?>" class="binItem"><span class="icon-delete"></span></a></div><?php } ?>
        </h3>
        <div id="note-text-<?php echo($note->id);?>" <?php if($brainstorm->canedit) { ?>class="note-text"<?php } ?> style="height: <?php echo $height-35;?>px;"><?php echo(nl2br($note->text));?></div>
	</div>
    <?php 
	}
}
?>
</div>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($brainstorm->edited_user.", ".$brainstorm->edited_date)?></td>
    <td class="middle"></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($brainstorm->created_user.", ".$brainstorm->created_date);?></td>
  </tr>
</table>
</div>
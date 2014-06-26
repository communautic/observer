<div class="table-title-outer">
<div id="procs-action-new" style="display: none"><?php echo $lang["PROC_ACTION_NEW"];?></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($proc->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["PROC_TITLE"];?></span></span></td>
    <td class="tcell-right"><?php if($proc->canedit) { ?><input name="title" type="text" class="title textarea-title" value="<?php echo($proc->title);?>" maxlength="100" /><?php } else { ?><div class="textarea-title"><?php echo($proc->title);?></div><?php } ?></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($proc->canedit) { ?>coform <?php } ?>">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setProcDetails">
<input type="hidden" name="id" value="<?php echo($proc->id);?>">
<?php if($proc->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span><?php echo $lang["GLOBAL_ALERT"];?></span></span></strong></td>
		<td class="tcell-right"><strong><?php echo $lang["GLOBAL_CONTENT_EDITED_BY"];?> <?php echo($proc->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($proc->checked_out_user_email);?>"><?php echo($proc->checked_out_user_email);?></a>, <?php echo($proc->checked_out_user_phone1);?></td>
    </tr>
</table>
<div class="content-spacer"></div>
<?php } ?>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($proc->canedit) { ?>content-nav showDialog<?php } ?>" request="getProcFolderDialog" field="procsfolder" append="1"><span><?php echo $lang["PROC_FOLDER"];?></span></span></td>
        <td class="tcell-right"><div id="procsfolder" class="itemlist-field"><?php echo($proc->folder);?></div></td>
	</tr>
</table>
<?php if($proc->proclink) { ?>
<table id="ProcLink" border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span><span>Prozessvorlage</span></span></td>
        <td class="tcell-right"><span rel="procs,<?php echo $proc->folder_id;?>,<?php echo $proc->id;?>,0,procs" class="co-link externalLoadThreeLevels"><?php echo($proc->title);?></span></td>
	</tr>
</table>
<?php } ?>
<?php if($proc->linktoproclink) { ?>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span><span>Prozesslink</span></span></td>
        <td class="tcell-right">
        <?php 
			foreach($proc->proclinksdetails as $key) {
				//foreach($key as $value) { 
				?>
				<span rel="procs,<?php echo $key['folder'];?>,<?php echo $key['id'];?>,0,procs" class="co-link externalLoadThreeLevels"><?php echo $key['folder_title'];?></span> 
				<?php }
			//}
		?>
        </td>
	</tr>
</table>
<?php } ?>
</form>
<?php if($proc->canedit) { ?>
<div class="controlBar"><span class="newItemOption newnote" rel="note"></span> <span class="newItemOption newarrow" rel="arrow"></span> <span class="binItems" rel="arrow"></span></div><?php } ?>
<div id="notesOuter"<?php if($proc->linktoproclink) { ?>style="top: 94px;"<?php } ?>>
<?php
if(is_array($notes)) {
	$i = 1;
	foreach ($notes as $note) { 
		@list($left,$top,$zindex) = explode('x',$note->xyz);
		if(!is_numeric($left)) { $left = 0; }
		if(!is_numeric($top)) { $top = 0; }
		if(!is_numeric($zindex)) { $zindex = 0; }
		$request = 'note';
		switch($note->shape) {
			/*case 1: $col = 'color' . $note->color; break;
			case 2: $col = 'color' . $note->color; break;
			case 3: $col = 'shape3bordercolor' . $note->color; break;
			case 4: $col = 'color' . $note->color . ' shape4bordercolor' . $note->color; break;
			case 5: $col = 'color' . $note->color . ' shape5bordercolor' . $note->color; break;
			
			case 1: $col = 'color' . $note->color; break;
			case 2: $col = 'color' . $note->color; break;
			case 3: $col = 'shape3bordercolor' . $note->color; break;
			case 4: $col = 'color' . $note->color . ' shape4bordercolor' . $note->color; break;
			case 5: $col = 'color' . $note->color . ' shape5bordercolor' . $note->color; break;*/
			
			case 10: $col = 'arrow1'; $request = 'arrow'; break;
			case 11: $note->shape = 10; $col = 'arrow2'; $request = 'arrow'; break;
			case 12: $note->shape = 10; $col = 'arrow3'; $request = 'arrow'; break;
			case 13: $note->shape = 10; $col = 'arrow4'; $request = 'arrow'; break;
			case 14: $note->shape = 10; $col = 'arrow5'; $request = 'arrow'; break;
			case 15: $note->shape = 10; $col = 'arrow6'; $request = 'arrow'; break;
			case 16: $note->shape = 10; $col = 'arrow7'; $request = 'arrow'; break;
			case 17: $note->shape = 10; $col = 'arrow8'; $request = 'arrow'; break;
			default:
				$col = 'color' . $note->color;
		}
	?>
    <div id="note-<?php echo($note->id);?>" class="<?php if($proc->canedit) { ?>note<?php } ?> shape<?php echo($note->shape);?> <?php echo $col;?><?php if($proc->canedit) { ?> showCoPopup<?php } ?>" request="<?php echo $request;?>" style="left: <?php echo $left;?>px; top: <?php echo $top;?>px; z-index: <?php echo $zindex;?>;">
        <div>
        	<span id="note-more-<?php echo($note->id);?>" class="note-readmore coTooltip" style="<?php if($note->text == "") { echo 'display: none;';}?>"><div style="display: none" class="coTooltipHtml"><?php echo nl2br($note->text);?></div></span>
            <div id="note-title-<?php echo($note->id);?>"><?php echo($note->title);?></div>
            <div id="note-text-<?php echo($note->id);?>" style="display: none;"><?php echo($note->text);?></div>
        </div>
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
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($proc->edited_user.", ".$proc->edited_date)?></td>
    <td class="middle"></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($proc->created_user.", ".$proc->created_date);?></td>
  </tr>
</table>
</div>
<div class="table-title-outer">
<div id="procs-action-new" style="display: none"><?php echo $lang["PROC_ACTION_NEW"];?></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span><span><?php echo $lang["PROC_TITLE"];?></span></span></td>
    <td class="tcell-right"><div class="textarea-title"><?php echo($proc->title);?></div></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="coform">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setProcDetails">
<input type="hidden" name="id" value="<?php echo($proc->id);?>">
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="content-nav showDialog" request="archiveMeta" field="status" append="1"><span><?php echo $lang["GLOBAL_METATAGS"];?></span></span></td>
    <td class="tcell-right"><div id="archiveMeta" class="itemlist-field"><?php echo($proc->archive_meta);?></div></td>
  </tr>
</table>
</form>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span request="getProcFolderDialog" field="procsfolder" append="1"><span><?php echo $lang["PROC_FOLDER"];?></span></span></td>
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
			$num = sizeof($proc->proclinksdetails);
			$i = 1;
			foreach($proc->proclinksdetails as $key) { ?>
				<span rel="procs,<?php echo $key['folder'];?>,<?php echo $key['id'];?>,0,procs" class="co-link externalLoadThreeLevels"><?php echo $key['folder_title'];?></span><?php 
				if($i < $num) { echo ', '; }
				$i++;
				}
		?></td>
	</tr>
</table>
<?php } ?>
<div id="notesOuter"<?php if($proc->linktoproclink) { ?>style="top: 94px;"<?php } ?>>
<div class="bg"></div>
<?php
if(is_array($notes)) {
	$i = 1;
	foreach ($notes as $note) { 
		@list($left,$top,$zindex) = explode('x',$note->xyz);
		if(!is_numeric($left)) { $left = 0; }
		if(!is_numeric($top)) { $top = 0; }
		if(!is_numeric($zindex)) { $zindex = 0; }
		$width = '';
		$height = '';
		$arrowStyle = '';
		$firstArrowStyle = '';
		$secondArrowStyle = '';
		/*if($note->width != 0) { $width = 'width: ' . $note->width . 'px; ' ; }
		if($note->height != 0) { $height = 'height: ' . $note->height . 'px; ' ; }*/
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
			
			case 10: $col = 'arrow1'; $request = 'arrow'; 
				if($note->width != 0) { 
					$width = 'width: ' . $note->width . 'px; ';
					$arrowwidth = $note->width-7;
					$arrowStyle = ' style="width: ' . $arrowwidth . 'px;"'; 
				}
			break;
			//case 11: $note->shape = 10; $col = 'arrow2'; $request = 'arrow'; break;
			case 12: $note->shape = 10; $col = 'arrow3'; $request = 'arrow'; 
				if($note->height != 0) { 
					$height = 'height: ' . $note->height . 'px; ';
					$arrowheight = $note->height-7;
					$arrowStyle = ' style="height: ' . $arrowheight . 'px;"'; 
				}
			
			break;
			//case 13: $note->shape = 10; $col = 'arrow4'; $request = 'arrow'; break;
			case 14: $note->shape = 10; $col = 'arrow5'; $request = 'arrow'; 
				if($note->width != 0) { 
					$width = 'width: ' . $note->width . 'px; ';
					$arrowwidth = $note->width-7;
					$arrowStyle = ' style="width: ' . $arrowwidth . 'px;"'; 
				}
			break;
			//case 15: $note->shape = 10; $col = 'arrow6'; $request = 'arrow'; break;
			case 16: $note->shape = 10; $col = 'arrow7'; $request = 'arrow'; 
				if($note->height != 0) { 
					$height = 'height: ' . $note->height . 'px; ';
					$arrowheight = $note->height-7;
					$arrowStyle = ' style="height: ' . $arrowheight . 'px;"'; 
				}
			break;
			//case 17: $note->shape = 10; $col = 'arrow8'; $request = 'arrow'; break;
			case 18: $note->shape = 10; $col = 'arrow9'; $request = 'arrowWin3'; 
				if($note->width != 0) { 
					$width = 'width: ' . $note->width . 'px; ';
					$arrowwidth = $note->width-12;
					$secondArrowStyle = ' style="width: ' . $arrowwidth . 'px;"'; 
				}
				if($note->height != 0) { 
					$height = 'height: ' . $note->height . 'px; ';
					$firstArrowStyle = ' style=" ' . $height . '"';
					$arrowheight = $note->height-7;
					$arrowStyle = ' style="height: ' . $arrowheight . 'px;"'; 
				}
			break;
			case 19: $note->shape = 10; $col = 'arrow10'; $request = 'arrowWin3'; 
				if($note->width != 0) { 
					$width = 'width: ' . $note->width . 'px; ';
					$arrowwidth = $note->width-12;
					$secondArrowStyle = ' style="width: ' . $arrowwidth . 'px;"'; 
				}
				if($note->height != 0) { 
					$height = 'height: ' . $note->height . 'px; ';
					$firstArrowStyle = ' style=" ' . $height . '"';
					$arrowheight = $note->height-7;
					$arrowStyle = ' style="height: ' . $arrowheight . 'px;"'; 
				}
			break;
			case 20: $note->shape = 10; $col = 'arrow11'; $request = 'arrowWin3'; 
				if($note->width != 0) { 
					$width = 'width: ' . $note->width . 'px; ';
					$arrowwidth = $note->width-12;
					$secondArrowStyle = ' style="width: ' . $arrowwidth . 'px;"'; 
				}
				if($note->height != 0) { 
					$height = 'height: ' . $note->height . 'px; ';
					$firstArrowStyle = ' style=" ' . $height . '"';
					$arrowheight = $note->height-7;
					$arrowStyle = ' style="height: ' . $arrowheight . 'px;"'; 
				}
			break;
			case 21: $note->shape = 10; $col = 'arrow12'; $request = 'arrowWin3'; 
				if($note->width != 0) { 
					$width = 'width: ' . $note->width . 'px; ';
					$arrowwidth = $note->width-12;
					$secondArrowStyle = ' style="width: ' . $arrowwidth . 'px;"'; 
				}
				if($note->height != 0) { 
					$height = 'height: ' . $note->height . 'px; ';
					$firstArrowStyle = ' style=" ' . $height . '"';
					$arrowheight = $note->height-7;
					$arrowStyle = ' style="height: ' . $arrowheight . 'px;"'; 
				}
			break;
			case 22: $note->shape = 10; $col = 'arrow13'; $request = 'arrowWin3'; 
				if($note->width != 0) { 
					$width = 'width: ' . $note->width . 'px; ';
					$firstArrowStyle = ' style=" ' . $width . '"';
					$arrowwidth = $note->width-7;
					$arrowStyle = ' style="width: ' . $arrowwidth . 'px;"'; 
				}
				if($note->height != 0) { 
					$height = 'height: ' . $note->height . 'px; ';
					$arrowheight = $note->height-10;
					$secondArrowStyle = ' style="height: ' . $arrowheight . 'px;"'; 
				}
			
			break;
			case 23: $note->shape = 10; $col = 'arrow14'; $request = 'arrowWin3'; 
				if($note->width != 0) { 
					$width = 'width: ' . $note->width . 'px; ';
					$firstArrowStyle = ' style=" ' . $width . '"';
					$arrowwidth = $note->width-7;
					$arrowStyle = ' style="width: ' . $arrowwidth . 'px;"'; 
				}
				if($note->height != 0) { 
					$height = 'height: ' . $note->height . 'px; ';
					$arrowheight = $note->height-10;
					$secondArrowStyle = ' style="height: ' . $arrowheight . 'px;"'; 
				}
			
			
			break;
			case 24: $note->shape = 10; $col = 'arrow15'; $request = 'arrowWin3'; 
				if($note->width != 0) { 
					$width = 'width: ' . $note->width . 'px; ';
					$firstArrowStyle = ' style=" ' . $width . '"';
					$arrowwidth = $note->width-7;
					$arrowStyle = ' style="width: ' . $arrowwidth . 'px;"'; 
				}
				if($note->height != 0) { 
					$height = 'height: ' . $note->height . 'px; ';
					$arrowheight = $note->height-10;
					$secondArrowStyle = ' style="height: ' . $arrowheight . 'px;"'; 
				}
			
			break;
			case 25: $note->shape = 10; $col = 'arrow16'; $request = 'arrowWin3'; 
			if($note->width != 0) { 
					$width = 'width: ' . $note->width . 'px; ';
					$firstArrowStyle = ' style=" ' . $width . '"';
					$arrowwidth = $note->width-7;
					$arrowStyle = ' style="width: ' . $arrowwidth . 'px;"'; 
				}
				if($note->height != 0) { 
					$height = 'height: ' . $note->height . 'px; ';
					$arrowheight = $note->height-10;
					$secondArrowStyle = ' style="height: ' . $arrowheight . 'px;"'; 
				}
			
			break;
			case 26: $note->shape = 10; $col = 'arrow17'; $request = 'arrowWin2'; 
				if($note->width != 0) { 
					$width = 'width: ' . $note->width . 'px; ';
					//$firstArrowStyle = ' style=" ' . $width . '"';
					$arrowwidth = $note->width-7;
					$arrowStyle = ' style="width: ' . $arrowwidth . 'px;"'; 
				}
				if($note->height != 0) { 
					$height = 'height: ' . $note->height . 'px; ';
					$arrowheight = $note->height-10;
					$secondArrowStyle = ' style="height: ' . $arrowheight . 'px;"'; 
				}
			
			break;
			case 27: $note->shape = 10; $col = 'arrow18'; $request = 'arrowWin2'; 
				if($note->width != 0) { 
					$width = 'width: ' . $note->width . 'px; ';
					//$firstArrowStyle = ' style=" ' . $width . '"';
					$arrowwidth = $note->width-7;
					$arrowStyle = ' style="width: ' . $arrowwidth . 'px;"'; 
				}
				if($note->height != 0) { 
					$height = 'height: ' . $note->height . 'px; ';
					$arrowheight = $note->height-10;
					$secondArrowStyle = ' style="height: ' . $arrowheight . 'px;"'; 
				}
			
			break;
			case 28: $note->shape = 10; $col = 'arrow19'; $request = 'arrowWin2'; 
				if($note->width != 0) { 
					$width = 'width: ' . $note->width . 'px; ';
					//$firstArrowStyle = ' style=" ' . $width . '"';
					$arrowwidth = $note->width-7;
					$arrowStyle = ' style="width: ' . $arrowwidth . 'px;"'; 
				}
				if($note->height != 0) { 
					$height = 'height: ' . $note->height . 'px; ';
					$arrowheight = $note->height-10;
					$secondArrowStyle = ' style="height: ' . $arrowheight . 'px;"'; 
				}
			
			break;
			case 29: $note->shape = 10; $col = 'arrow20'; $request = 'arrowWin2'; 
				if($note->width != 0) { 
					$width = 'width: ' . $note->width . 'px; ';
					//$firstArrowStyle = ' style=" ' . $width . '"';
					$arrowwidth = $note->width-7;
					$arrowStyle = ' style="width: ' . $arrowwidth . 'px;"'; 
				}
				if($note->height != 0) { 
					$height = 'height: ' . $note->height . 'px; ';
					$arrowheight = $note->height-10;
					$secondArrowStyle = ' style="height: ' . $arrowheight . 'px;"'; 
				}
			
			break;
			case 30: $note->shape = 10; $col = 'arrow21'; $request = 'arrowWin2'; 
				if($note->width != 0) { 
					$width = 'width: ' . $note->width . 'px; ';
					$arrowwidth = $note->width-12;
					$secondArrowStyle = ' style="width: ' . $arrowwidth . 'px;"'; 
				}
				if($note->height != 0) { 
					$height = 'height: ' . $note->height . 'px; ';
					//$firstArrowStyle = ' style=" ' . $height . '"';
					$arrowheight = $note->height-7;
					$arrowStyle = ' style="height: ' . $arrowheight . 'px;"'; 
				}
			
			break;
			case 31: $note->shape = 10; $col = 'arrow22'; $request = 'arrowWin2'; 
				if($note->width != 0) { 
					$width = 'width: ' . $note->width . 'px; ';
					$arrowwidth = $note->width-12;
					$secondArrowStyle = ' style="width: ' . $arrowwidth . 'px;"'; 
				}
				if($note->height != 0) { 
					$height = 'height: ' . $note->height . 'px; ';
					//$firstArrowStyle = ' style=" ' . $height . '"';
					$arrowheight = $note->height-7;
					$arrowStyle = ' style="height: ' . $arrowheight . 'px;"'; 
				}
			
			break;
			case 32: $note->shape = 10; $col = 'arrow23'; $request = 'arrowWin2'; 
				if($note->width != 0) { 
					$width = 'width: ' . $note->width . 'px; ';
					$arrowwidth = $note->width-12;
					$secondArrowStyle = ' style="width: ' . $arrowwidth . 'px;"'; 
				}
				if($note->height != 0) { 
					$height = 'height: ' . $note->height . 'px; ';
					//$firstArrowStyle = ' style=" ' . $height . '"';
					$arrowheight = $note->height-7;
					$arrowStyle = ' style="height: ' . $arrowheight . 'px;"'; 
				}
			
			break;
			case 33: $note->shape = 10; $col = 'arrow24'; $request = 'arrowWin2'; 
				if($note->width != 0) { 
					$width = 'width: ' . $note->width . 'px; ';
					$arrowwidth = $note->width-12;
					$secondArrowStyle = ' style="width: ' . $arrowwidth . 'px;"'; 
				}
				if($note->height != 0) { 
					$height = 'height: ' . $note->height . 'px; ';
					//$firstArrowStyle = ' style=" ' . $height . '"';
					$arrowheight = $note->height-7;
					$arrowStyle = ' style="height: ' . $arrowheight . 'px;"'; 
				}
			
			break;
			case 34: $request = 'text'; break;
			default:
				$col = 'color' . $note->color;
		}
	?>
    <div id="note-<?php echo($note->id);?>" class="shape<?php echo($note->shape);?> <?php echo $col;?>" request="<?php echo $request;?>" style="<?php echo $width.$height;?>left: <?php echo $left;?>px; top: <?php echo $top;?>px; z-index: <?php echo $zindex;?>;">
        <div class="firstArrowStyle" <?php echo $firstArrowStyle;?>></div>
        <div class="secondArrowStyle" <?php echo $secondArrowStyle;?>></div>
        <div class="arrowStyle" <?php echo $arrowStyle;?>>
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
    <td class="left"><?php echo $lang["ARCHIVED_BY_ON"];?> <?php echo($proc->archive_user.", ".$proc->archive_time)?></td>
    <td class="middle"></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($proc->created_user.", ".$proc->created_date);?></td>
  </tr>
</table>
</div>
<div id="modalDialogArchiveRevive">
<div class="modalDialogArchiveReviveHeader"><div id="modalDialogArchiveReviveClose"><span class="icon-delete-white"></span></div></div>
<div id="modalDialogArchiveReviveInner">
    <div id="modalDialogArchiveReviveInnerContent">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td valign="top">
    <div class="content-spacer" style="height: 10px;"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="text11" style="width: 136px; padding: 0 15px 2px 0px;"><span class="content-nav showDialog" request="getProcFolderArchiveDialog" field="archiveRevivefolder" append="1"><span style="padding: 0px 0px 0px 11px;"><?php echo $lang["PROC_FOLDER"];?></span></span></td>
        <td class="tcell-right"><div id="archiveRevivefolder" class="itemlist-field"></div></td>
	</tr>
</table>
    <div class="coButton-outer" style="margin: 5px 0 0 11px;"><span class="content-nav commandArchiveRevive coButton">Aktivieren</span></div>
    
    </td>
  </tr>
</table>
</div></div>
</div>
<div id="modalDialogArchiveDuplicate">
<div class="modalDialogArchiveDuplicateHeader"><div id="modalDialogArchiveDuplicateClose"><span class="icon-delete-white"></span></div></div>
<div id="modalDialogArchiveDuplicateInner">
    <div id="modalDialogArchiveDuplicateInnerContent">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td valign="top">
    <div class="content-spacer" style="height: 10px;"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="text11" style="width: 136px; padding: 0 15px 2px 0px;"><span class="content-nav showDialog" request="getProcFolderArchiveDialog" field="archiveDuplicatefolder" append="1"><span style="padding: 0px 0px 0px 11px;"><?php echo $lang["PROC_FOLDER"];?></span></span></td>
        <td class="tcell-right"><div id="archiveDuplicatefolder" class="itemlist-field"></div></td>
	</tr>
</table>
<div class="coButton-outer" style="margin: 5px 0 0 11px;"><span class="content-nav commandArchiveDuplicate coButton">Duplizieren</span></div>
    
    </td>
  </tr>
</table>
</div></div>
</div>
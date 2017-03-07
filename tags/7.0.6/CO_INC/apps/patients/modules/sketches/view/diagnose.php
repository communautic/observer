<div id="canvasList_<?php echo $value->id;?>" class="sketchouter loadCanvasList" rel="<?php echo $i;?>">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
  <tr>
    <td style="width: 31px; padding-left: 9px;"><span class="<?php if($sketch->canedit) { ?>selectTextarea<?php } ?>"><span><div class="circle circle<?php echo $curcol;?>"><div><?php echo $i;?></div></div></span></span></td>
    <td class="tcell-right <?php echo $active;?>"><?php if($sketch->canedit) { ?><textarea name="canvasList_text[<?php echo $value->id;?>]" class="elastic"><?php echo(strip_tags($value->text));?></textarea><input name="canvasList_id[<?php echo $value->id;?>]" type="hidden" value="<?php echo $value->id;?>" /><?php } else { ?><?php echo(nl2br(strip_tags($value->text)));?>&nbsp;<?php } ?></td>
    <?php if($sketch->canedit) { ?><td width="25"><a class="binDiagnose" rel="<?php echo $value->id;?>"><span class="icon-delete"></span></a></td><?php } ?>
  </tr>
</table></div>
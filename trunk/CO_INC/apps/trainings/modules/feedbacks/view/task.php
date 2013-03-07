<div id="task_<?php echo $value->id;?>" class="feedbackouter">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive" style="margin-bottom: 0px;">
  <tr>
		<td class="tcell-left-phases-tasks text11">&nbsp;</td>
    	<td class="tcell-right-nopadding">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="20" style="padding-top: 4px;">&nbsp;</td>
      <td class="text11" style="padding-top: 0px;"><?php if($feedback->canedit) { ?>
          <span class="text11" style="padding-top: 0px;"><input name="task_title[<?php echo $value->id;?>]" type="text" class="bg cbx bold" value="<?php echo $value->title;?>" maxlength="100" /></span>
          <?php } else { ?><div class="text13 bold" style="margin-left: 7px;"><?php echo $value->title;?></div><?php } ?><input name="task_id[<?php echo $value->id;?>]" type="hidden" value="<?php echo $value->id;?>"><input class="task_sort" name="task_sort[<?php echo $value->id;?>]" type="hidden" value=""></td>
      
      <td width="250"><div class="answers-outer-dynamic<?php if($feedback->canedit) { ?> active<?php } ?>">
      <?php for($i=0; $i<11; $i++) {
									$selected = '';
									if($i < 4) { $class = 'neg'; }
									if($i > 3 && $i < 7) { $class = 'med'; }
									if($i > 6 ) { $class = 'pos'; }
									if($value->answer != "" && $i == $value->answer) {
										$class .= ' active';
									}
									 echo '<span rel="' . $value->id .'" class="' . $class . '">' . $i . '</span>';
                                }
                                ?>
                              </div></td>
                                <?php if($feedback->canedit) { ?><td width="25"><a class="binItem" rel="<?php echo $value->id;?>"><span class="icon-delete"></span></a></td><?php } ?>
    </tr>
  </table>

  		</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($feedback->canedit) { ?>selectTextarea<?php } ?>"><span>&nbsp;</span></span></td>
    <td class="tcell-right"><?php if($feedback->canedit) { ?><textarea name="task_text[<?php echo $value->id;?>]" class="elastic"><?php echo(strip_tags($value->text));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($value->text)));?><?php } ?></td>
  </tr>
</table>
</div>
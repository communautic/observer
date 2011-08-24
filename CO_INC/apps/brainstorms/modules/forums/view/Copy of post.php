<div id="post_<?php echo $post->id;?>" class="forumouter">
<table border="0" cellpadding="0" cellspacing="0" class="table-content-grey text11">
	<tr>
		<td class="tcell-left-posts">#<?php echo $post->num;?></td>
    	<td class="tcell-right-nopadding">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="27" style="padding-top: 4px;"><input name="task[<?php echo $post->id;?>]" type="checkbox" value="<?php echo $post->id;?>" class="cbx jNiceHidden <?php if(!$forum->canedit) { ?>noperm<?php } ?>" <?php echo $checked ;?> /></td>
              <td class="text13 bold"><?php echo $post->user;?></td>
              <td width="140"><?php echo $post->datetime;?></td>
              <td width="30"><a class="postBrainstormsReply" title="antworten" rel="<?php echo $post->id;?>"><span class="icon-reply"></span></a></td>
              <td width="30"><a class="binItem" rel="<?php echo $post->id;?>"><span class="icon-delete"></span></a></td>
            </tr>
          </table>
  		</td>
	</tr>
</table>
<div id="postanswer_<?php echo $post->id;?>">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
  <tr>
      <td class="tcell-left-posts text11"><img src="<?php echo CO_FILES;?>/img/avatar.jpg" width="40" height="60" /></td>
      <td class="tcell-right-nopadding">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                  <td width="20">&nbsp;</td>
        
              <td class="text11"><div class="text13" style="margin-left: 7px; padding: 0 15px 15px 0;"><?php echo nl2br($post->text);?></div></td>
            </tr>
          </table>
  		</td>
	</tr>
</table>
</div>
</div>

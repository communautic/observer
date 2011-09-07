<?php if(!isset($forum->canedit)) { $forum->canedit = true; } ?>
<div id="post_<?php echo $post->id;?>" style="border-bottom: 1px solid #77713D">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive" style="margin-bottom: 0px;">
  <tr>
      <td class="tcell-left-posts text11">
      	<?php echo $post->user;?>
      	<table border="0" cellpadding="0" cellspacing="0">
      		<tr>
                <td style="width: 40px; height: 47px;"><img src="<?php echo $post->avatar;?>" width="30" /></td>
                <td style="width: 62px;"><?php echo $post->datetime;?></td>
                <td width="27" style="padding-top: 4px;">
                    <input type="checkbox" value="<?php echo $post->id;?>" class="cbx jNiceHidden <?php if(!$forum->canedit) { ?>noperm<?php } ?>" <?php echo $checked ;?> />
                    <?php if($forum->canedit) { ?><a class="postBrainstormsReply" title="antworten" rel="<?php echo $post->id;?>"><span class="icon-reply"></span></a><?php } ?>
                </td>
      		</tr>
      	</table>
      </td>
      <td class="tcell-right-nopadding">
          
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td class="text11"><div class="text13" style="margin-left: 7px; padding: 0 15px 15px 0;"><div id="postanswer_<?php echo $post->id;?>"><?php echo nl2br($post->text);?></div></div></td>
            </tr>
          </table>
  		</td>
        <td width="25"><div id="post-toggle-<?php echo($post->id);?>" class="brainstormsPostToggle" style="width: 15px; height: 15px; cursor: pointer;"><span class="icon-toggle-post"></span></div></td>
       <?php if($forum->canedit) { ?><td width="15"><a class="binItem<?php echo $postdellink;?>" rel="<?php echo $post->id;?>"><span class="<?php echo $postdelclass;?>"></span></a></td><?php } ?>
	</tr>
</table>
</div>
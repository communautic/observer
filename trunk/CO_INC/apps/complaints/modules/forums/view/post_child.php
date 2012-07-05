<?php if(!isset($perm)) { $perm = true; } ?>
<div id="complaintsForumsPost_<?php echo $child->id;?>" style="border-bottom: 1px solid #fff">
<table border="0" cellpadding="0" cellspacing="0" class="table-content grey" style="margin-bottom: 0px; border-collapse:separate;">
  <tr>
      <td class="tcell-left-posts text11">
      	<?php echo $child->user;?>
      	<table border="0" cellpadding="0" cellspacing="0">
      		<tr>
                <td style="width: 40px; height: 47px;"><img src="<?php echo $child->avatar;?>" width="30" /></td>
                <td style="width: 62px;"><?php echo $child->datetime;?></td>
                <td width="27" style="padding-top: 4px;">
                	<input name="task[<?php echo $child->id;?>]" type="checkbox" value="<?php echo $child->id;?>" class="cbx jNiceHidden <?php if(!$perm) { ?>noperm<?php } ?>" <?php echo $checked ;?> />
                    <?php if($perm) { ?><a class="openReplyWindow" title="antworten" rel="<?php echo $child->id;?>"><span class="icon-reply"></span></a><?php } ?>
                </td>
      		</tr>
      	</table>
      </td>
      <td class="tcell-right-posts">
          
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td class="text11"><div class="text13" style="margin-left: 7px; padding: 0 15px 15px 0;"><div id="complaintsForumsPostanswer_<?php echo $child->id;?>"><?php echo $child->text;?></div></div></td>
            </tr>
          </table>
          
  		</td>
       <td width="25" style="border-bottom: 1px solid #ccc;"><div class="togglePost" rel="<?php echo($child->id);?>" style="width: 15px; height: 15px; cursor: pointer;"><span class="icon-toggle-post"></span></div></td>
       <?php if($perm) { ?><td width="15" style="border-bottom: 1px solid #ccc;"><a class="binItem<?php echo $postdellink;?>" rel="<?php echo $child->id;?>"><span class="<?php echo $postdelclass;?>"></span></a></td><?php } ?>
	</tr>
</table>
</div>
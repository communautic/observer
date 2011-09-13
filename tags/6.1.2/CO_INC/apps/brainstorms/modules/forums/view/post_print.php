<table border="0" cellpadding="0" cellspacing="0" width="100%" style=" border: 0px;">
  <tr>
      <td style="font-size: 8pt; width: 190px; background-color: #B2A85B; border-bottom: 1px solid #77713D">
      	<?php echo $post->user;?>
      	<table border="0" cellpadding="0" cellspacing="0">
      		<tr>
                <td style="width: 40px; height: 47px;"><img src="<?php echo $post->avatar;?>" width="30" /></td>
                <td style="width: 50px;"><?php echo $post->datetime;?></td>
                <td width="27"><?php echo $img;?></td>
      		</tr>
      	</table>
      </td>
      <td class="greybg" style="padding: 2pt 2pt 2pt 2pt; border-bottom: 1px solid #77713D"><?php echo nl2br($post->text);?></td>
	</tr>
</table>
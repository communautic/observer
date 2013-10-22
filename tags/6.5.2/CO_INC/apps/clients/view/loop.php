<div id="task_<?php echo $oa->id;?>" class="phaseouter">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive" style="margin-bottom: 0px;">
  <tr>
		<td class="tcell-left-phases-tasks text11">&nbsp;</td>
    	<td class="tcell-right-nopadding">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="20" style="padding-top: 4px;"><input name="<?php echo $oa->id;?>" type="checkbox" value="<?php echo $oa->id;?>" class="cbx jNiceHidden <?php if(!$client->canedit) { ?>noperm<?php } ?>" <?php echo $checked ;?> /></td>
      <td class="text11" style="padding-top: 0px;"><div class="text13 bold" style="margin-left: 7px;"><?php echo($oa->access_name);?></div></td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 5px;">
    <tr>
      <td width="12"></td>
      <td class="tcell-left text11"><span><span><?php echo($oa->access_company);?></span></span></td>
      <td class="tcell-right"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="tcell-left text11"><span><span><?php echo($oa->access_address);?></span></span></td>
      <td class="tcell-right">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="tcell-left text11"><span><span><?php echo($oa->access_phone);?></span></span></td>
      <td class="tcell-right text11"><?php echo($oa->access_email);?></td>
    </tr>
    <?php if($oa->access_text != '') { ?>
        <tr id="access_tr_<?php echo $oa->id;?>">
      <td>&nbsp;</td>
      <td class="tcell-left text11" colspan="2"><span><span><?php echo($oa->access_text);?></span></span></td>
    </tr>
    <?php } ?>
    </table>
  		</td>
	</tr>
</table>
</div>
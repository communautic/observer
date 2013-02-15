<div id="member_<?php echo $value->id;?>" class="phaseouter">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive" style="margin-bottom: 0px;">
  <tr>
		<td class="tcell-left">&nbsp;</td>
    	<td class="tcell-right">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td style="padding-top: 0px;"><strong><?php echo $value->name;?></strong></td>
      <td width="25"><div class="togglePost" rel="<?php echo $value->id;?>"><span class="icon-toggle-post active"></span></div></td>
      <?php if($training->canedit) { ?><td width="25"><a class="binItem" rel="<?php echo $value->id;?>"><span class="icon-delete"></span></a></td><?php } ?>
    </tr>
  </table>
  <span class="sendInvitation co-link <?php echo $value->invitation_class;?>" rel="<?php echo $value->id;?>">Einladung</span> - <span class="co-link <?php echo $value->registration_class;?>" rel="<?php echo $value->id;?>">Anmeldung</span> - Teilnahmebest&auml;tigung - Feedback
  		</td>
	</tr>
</table>
</div>
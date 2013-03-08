<div id="member_<?php echo $value->id;?>" class="phaseouter">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive" style="margin-bottom: 0px;">
  <tr>
		<td class="tcell-left">&nbsp;</td>
    	<td class="tcell-right">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td style="padding-top: 0px;"><strong><?php echo $value->name;?></strong></td>
      <td width="25"><div id="toggler_<?php echo $value->id;?>" class="togglePost" <?php if(empty($value->logs)) { ?>style="display: none;"<?php } ?> rel="<?php echo $value->id;?>"><span class="icon-toggle-post active"></span></div></td>
      <?php if($training->canedit) { ?><td width="25"><a class="binItem" rel="<?php echo $value->id;?>"><span class="icon-delete"></span></a></td><?php } ?>
    </tr>
  </table>
  <div class="co-popupOuter">
  	<span class="showCoPopup co-link invitationLink <?php echo $training->member_status_default_css;?> <?php echo $value->invitation_class;?>" rel="<?php echo $value->id;?>">Einladung</span> 
  	<div class="co-popup-content">
        <ul>
        	<li><a href="#" class="trainingsMemberAction" rel="manualInvitation" uid="<?php echo $value->id;?>" act="">Eingeladen</a></li>
            <li><a href="#" class="trainingsMemberAction" rel="sendInvitation" uid="<?php echo $value->id;?>" act="">Versenden</a></li>
            <li><a href="#" class="trainingsMemberAction" rel="resetInvitation" uid="<?php echo $value->id;?>" act=""><?php echo $lang["GLOBAL_RESET"];?></a></li>
        </ul>
        <span class="arrow"></span>
    </div>
  </div>
  <div class="co-popupOuter">
  	<span class="showCoPopup co-link registrationLink <?php echo $training->member_status_default_css;?> <?php echo $value->registration_class;?>" rel="<?php echo $value->id;?>">Anmeldung</span> 
  	<div class="co-popup-content">
        <ul>
        	<li><a href="#" class="trainingsMemberAction" rel="manualRegistration" uid="<?php echo $value->id;?>" act="">Angemeldet</a></li>
            <li><a href="#" class="trainingsMemberAction" rel="removeRegistration" uid="<?php echo $value->id;?>" act="">Abgemeldet</a></li>
            <li><a href="#" class="trainingsMemberAction" rel="resetRegistration" uid="<?php echo $value->id;?>" act=""><?php echo $lang["GLOBAL_RESET"];?></a></li>
     	</ul>
        <span class="arrow"></span>
    </div>
  </div>
   <div class="co-popupOuter">
  	<span class="showCoPopup co-link tookpartLink <?php echo $training->member_status_default_css;?> <?php echo $value->tookpart_class;?>" rel="<?php echo $value->id;?>">Teilnahme</span> 
  	<div class="co-popup-content">
        <ul>
        	<li><a href="#" class="trainingsMemberAction" rel="manualTookpart" uid="<?php echo $value->id;?>" act="">Teilgenommen</a></li>
            <li><a href="#" class="trainingsMemberAction" rel="manualTookNotpart" uid="<?php echo $value->id;?>" act="">Nicht teilgenommen</a></li>
            <li><a href="#" class="trainingsMemberAction" rel="resetTookpart" uid="<?php echo $value->id;?>" act=""><?php echo $lang["GLOBAL_RESET"];?></a></li>
        </ul>
        <span class="arrow"></span>
    </div>
  </div>
  <div class="co-popupOuter">
  	<span class="showCoPopup co-link feedbackLink <?php echo $training->member_status_default_css;?> <?php echo $value->feedback_class;?>" rel="<?php echo $value->id;?>">Feedback</span> 
  	<div class="co-popup-content">
        <ul>
        	<li><a href="#" class="trainingsMemberAction" rel="editFeedback" uid="<?php echo $value->id;?>" act="<?php echo $training->folder_id;?>,<?php echo $training->id;?>,<?php echo $value->id;?>">Bearbeiten</a></li>
            <li><a href="#" class="trainingsMemberAction" rel="sendFeedback" uid="<?php echo $value->id;?>" act=""><?php echo $lang["GLOBAL_SENDEMAIL"];?></a></li>
            <li><a href="#" class="trainingsMemberAction" rel="resetFeedback" uid="<?php echo $value->id;?>" act=""><?php echo $lang["GLOBAL_RESET"];?></a></li>
        </ul>
        <span class="arrow"></span>
    </div>
  </div>
  		</td>
	</tr>
</table>
<div id="memberlog_<?php echo $value->id;?>" style="display: none;">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive" style="margin-bottom: 0px;">
  <tr>
		<td class="tcell-left">&nbsp;</td>
    	<td class="tcell-right-inactive">
        <div id="member_log_<?php echo $value->id;?>_content">
  <?php
  	if(!empty($value->logs)) {
	foreach($value->logs as $log) { 
			echo '<div class="text11">' . $lang['TRAINING_MEMBER_LOG_' . $log->action] . ': ' . $log->who . ', ' . $log->date . '</div>';
} }
  ?></div>
  </td></tr></table>
</div>
</div>
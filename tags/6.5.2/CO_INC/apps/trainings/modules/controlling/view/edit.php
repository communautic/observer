<div class="table-title-outer">
<table border="0" cellspacing="0" cellpadding="0" class="table-title grey">
  <tr>
    <td nowrap="nowrap" class="tcell-left text11"><span class="content-nav-title"><?php echo $lang["TRAINING_CONTROLLING_STATUS"];?></span></td>
    <td></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scrolling-content">
<div style="height: 125px;" class="text11">
<div style="height: 26px;" class="tbl-inactive"></div>
<div style="position: relative; float: left; width: 150px; margin: -26px 9px 0 9px">
	<div style="height: 26px; background-color:#c3c3c3">
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px;" width="120"><?php echo $lang["TRAINING_CONTROLLING_MEMBERS_DICIPLINE"];?></td>
    <td class="text11" style="text-align: right; padding: 3px 7px 0 0">&nbsp;</td>
  </tr>
</table>
</div>
    <div>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px" width="120">Teilnehmer</td>
    <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo($controlling->allmembers);?></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px" width="120"><?php echo $lang["TRAINING_CONTROLLING_MEMBERS_INVITATIONS"];?></td>
    <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo($controlling->invitations);?></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px" width="120"><?php echo $lang["TRAINING_CONTROLLING_MEMBERS_REGISTRATIONS"];?></td>
    <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo($controlling->registrations);?></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px" width="120"><?php echo $lang["TRAINING_CONTROLLING_MEMBERS_TOOKPARTS"];?></td>
    <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo $controlling->tookparts;?></td>
  </tr>
</table>
    </div>
</div>
<?php  $this->getChart($controlling->pid,'stability', $controlling->stability);?>
</div>

<div style="height: 125px;" class="text11">
<div style="height: 26px;" class="tbl-inactive"></div>
<?php  $this->getChart($controlling->pid,'registrations', $controlling->total_regs);?>
<?php  $this->getChart($controlling->pid,'attendees', $controlling->total_attendees);?>
<?php  $this->getChart($controlling->pid,'feedbacks', $controlling->total_result);?>
</div>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
    <tr>
		<td class="tcell-left text11" style="padding: 8px 15px 8px 0;"><span><span>&nbsp;</span></span></td>
		<td class="tcell-right" style="padding: 10px 0 0 0;"><span style="display: inline-block; width: 30px;" class="bold">1</span><?php echo $lang["TRAINING_FEEDBACK_QUESTION_1"];?></td>
         <td width="340" style="padding: 10px 0 0 0;"><span id="q1_result"><?php echo $controlling->q1_result;?></span>%</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
    <tr>
		<td class="tcell-left text11" style="padding: 8px 15px 8px 0;"><span><span>&nbsp;</span></span></td>
		<td class="tcell-right" style="padding: 10px 0 0 0;"><span style="display: inline-block; width: 30px;" class="bold">2</span><?php echo $lang["TRAINING_FEEDBACK_QUESTION_2"];?></td>
         <td width="340" style="padding: 10px 0 0 0;"><span id="q2_result"><?php echo $controlling->q2_result;?></span>%</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
    <tr>
		<td class="tcell-left text11" style="padding: 8px 15px 8px 0;"><span><span>&nbsp;</span></span></td>
		<td class="tcell-right" style="padding: 10px 0 0 0;"><span style="display: inline-block; width: 30px;" class="bold">3</span><?php echo $lang["TRAINING_FEEDBACK_QUESTION_3"];?></td>
         <td width="340" style="padding: 10px 0 0 0;"><span id="q3_result"><?php echo $controlling->q3_result;?></span>%</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
    <tr>
		<td class="tcell-left text11" style="padding: 8px 15px 8px 0;"><span><span>&nbsp;</span></span></td>
		<td class="tcell-right" style="padding: 10px 0 0 0;"><span style="display: inline-block; width: 30px;" class="bold">4</span><?php echo $lang["TRAINING_FEEDBACK_QUESTION_4"];?></td>
         <td width="340" style="padding: 10px 0 0 0;"><span id="q4_result"><?php echo $controlling->q4_result;?></span>%</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
    <tr>
		<td class="tcell-left text11" style="padding: 8px 15px 8px 0;"><span><span>&nbsp;</span></span></td>
		<td class="tcell-right" style="padding: 10px 0 0 0;"><span style="display: inline-block; width: 30px;" class="bold">5</span><?php echo $lang["TRAINING_FEEDBACK_QUESTION_5"];?></td>
         <td width="340" style="padding: 10px 0 0 0;"><span id="q5_result"><?php echo $controlling->q5_result;?></span>%</td>
	</tr>
</table>

</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo($lang["GLOBAL_FOOTER_STATUS"] . " " . $controlling->datetime);?></td>
    <td class="middle"></td>
    <td class="right"></td>
  </tr>
</table>
</div>
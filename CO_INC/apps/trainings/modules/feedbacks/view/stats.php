<div class="table-title-outer">
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span><span><?php echo $lang["TRAINING_FEEDBACK_TITLE_STATISTICS"];?></span></span></td>
    <td><div class="textarea-title"><?php // echo($feedback->title);?></div></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="coform jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($feedback->id);?>">
<input type="hidden" name="pid" value="<?php echo($feedback->pid);?>">
<div style="height: 125px;" class="text11">
<div style="height: 26px;" class="tbl-inactive"></div>
<?php  $this->getChart($feedback->pid,'registrations', $feedback->total_regs);?>
<?php  $this->getChart($feedback->pid,'attendees', $feedback->total_attendees);?>
<?php  $this->getChart($feedback->pid,'feedbacks', $feedback->total_result);?>
</div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left text11" style="padding: 8px 15px 8px 0;"><span><span>&nbsp;</span></span></td>
		<td class="tcell-right" style="padding-top: 10px;">&nbsp;</td>
            <td width="340" style="padding: 10px 0 0 0;"><strong><span id="total_result"><?php echo $feedback->total_result;?></span>%</strong> &nbsp; &nbsp; <span class="text11">Zufriedenheit</span></td>
	</tr>
	<tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
    <tr>
		<td class="tcell-left text11" style="padding: 8px 15px 8px 0;"><span><span>&nbsp;</span></span></td>
		<td class="tcell-right" style="padding: 10px 0 0 0;"><span style="display: inline-block; width: 30px;" class="bold">1</span><?php echo $lang["TRAINING_FEEDBACK_QUESTION_1"];?></td>
         <td width="340" style="padding: 10px 0 0 0;"><span id="q1_result"><?php echo $feedback->q1_result;?></span>%</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
    <tr>
		<td class="tcell-left text11" style="padding: 8px 15px 8px 0;"><span><span>&nbsp;</span></span></td>
		<td class="tcell-right" style="padding: 10px 0 0 0;"><span style="display: inline-block; width: 30px;" class="bold">2</span><?php echo $lang["TRAINING_FEEDBACK_QUESTION_2"];?></td>
         <td width="340" style="padding: 10px 0 0 0;"><span id="q2_result"><?php echo $feedback->q2_result;?></span>%</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
    <tr>
		<td class="tcell-left text11" style="padding: 8px 15px 8px 0;"><span><span>&nbsp;</span></span></td>
		<td class="tcell-right" style="padding: 10px 0 0 0;"><span style="display: inline-block; width: 30px;" class="bold">3</span><?php echo $lang["TRAINING_FEEDBACK_QUESTION_3"];?></td>
         <td width="340" style="padding: 10px 0 0 0;"><span id="q3_result"><?php echo $feedback->q3_result;?></span>%</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
    <tr>
		<td class="tcell-left text11" style="padding: 8px 15px 8px 0;"><span><span>&nbsp;</span></span></td>
		<td class="tcell-right" style="padding: 10px 0 0 0;"><span style="display: inline-block; width: 30px;" class="bold">4</span><?php echo $lang["TRAINING_FEEDBACK_QUESTION_4"];?></td>
         <td width="340" style="padding: 10px 0 0 0;"><span id="q4_result"><?php echo $feedback->q4_result;?></span>%</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
    <tr>
		<td class="tcell-left text11" style="padding: 8px 15px 8px 0;"><span><span>&nbsp;</span></span></td>
		<td class="tcell-right" style="padding: 10px 0 0 0;"><span style="display: inline-block; width: 30px;" class="bold">5</span><?php echo $lang["TRAINING_FEEDBACK_QUESTION_5"];?></td>
         <td width="340" style="padding: 10px 0 0 0;"><span id="q5_result"><?php echo $feedback->q5_result;?></span>%</td>
	</tr>
</table>
</form>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo($lang["GLOBAL_FOOTER_STATUS"] . " " . $feedback->today);?></td>
    <td class="middle"></td>
    <td class="right"></td>
  </tr>
</table>
</div>
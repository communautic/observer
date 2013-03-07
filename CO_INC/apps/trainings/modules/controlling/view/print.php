<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["TRAINING_CONTROLLING_STATUS"];?> </td>
        <td><strong><?php echo $tit;?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
        <td class="tcell-left"><?php echo $lang["TRAINING_CONTROLLING_MEMBERS_DICIPLINE"];?> </td>
        <td><strong>&nbsp;</strong></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["TRAINING_CONTROLLING_MEMBERS_INVITATIONS"];?></td>
		<td><?php echo($cont->invitations);?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["TRAINING_CONTROLLING_MEMBERS_REGISTRATIONS"];?></td>
		<td><?php echo($cont->registrations);?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["TRAINING_CONTROLLING_MEMBERS_TOOKPARTS"];?></td>
		<td><?php echo($cont->tookparts);?></td>
	</tr>
</table>
&nbsp;
<table width="100%" class="standard-margin">
	<tr>
		<td width="34%"><?php $trainingsControlling = new TrainingsControlling("controlling");
		$trainingsControlling->getChart($cont->pid,'stability', $cont->stability,1);?></td>
        <td width="66%">&nbsp;</td>
	</tr>
</table>
&nbsp;
<table width="100%" class="standard-margin">
	<tr>
		<td width="34%"><?php $trainingsControlling->getChart($cont->pid,'registrations', $cont->total_regs,1);?></td>
		<td width="33%"><?php $trainingsControlling->getChart($cont->pid,'attendees', $cont->total_attendees,1);?></td>
		<td width="33%"><?php $trainingsControlling->getChart($cont->pid,'feedbacks', $cont->total_result,1);?></td>
	</tr>
</table>
&nbsp;<br />
<table border="0" cellpadding="0" cellspacing="0">
    <tr>
		<td width="400">1 &nbsp; <?php echo $lang["TRAINING_FEEDBACK_QUESTION_1"];?></td>
        <td><?php echo $cont->q1_result;?>%</td>
	</tr>
</table>
&nbsp;<br />
<table border="0" cellpadding="0" cellspacing="0">
    <tr>
		<td width="400">2&nbsp; <?php echo $lang["TRAINING_FEEDBACK_QUESTION_2"];?></td>
        <td><?php echo $cont->q2_result;?>%</td>
	</tr>
</table>
&nbsp;<br />
<table border="0" cellpadding="0" cellspacing="0">
    <tr>
		<td width="400">3&nbsp; <?php echo $lang["TRAINING_FEEDBACK_QUESTION_3"];?></td>
        <td><?php echo $cont->q3_result;?>%</td>
	</tr>
</table>
&nbsp;<br />
<table border="0" cellpadding="0" cellspacing="0">
    <tr>
		<td width="400">4&nbsp; <?php echo $lang["TRAINING_FEEDBACK_QUESTION_4"];?></td>
        <td><?php echo $cont->q4_result;?>%</td>
	</tr>
</table>
&nbsp;<br />
<table border="0" cellpadding="0" cellspacing="0">
    <tr>
		<td width="400">5&nbsp; <?php echo $lang["TRAINING_FEEDBACK_QUESTION_5"];?></td>
        <td><?php echo $cont->q5_result;?>%</td>
	</tr>
</table>
<div style="page-break-after:always;">&nbsp;</div>
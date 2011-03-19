<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["CONTROLLING_STATUS"];?> </td>
        <td><strong><?php echo $tit;?></strong></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["CONTROLLING_PHASES_CREATED"];?></td>
		<td><?php echo($controlling->allphases);?></td>
	</tr>
	<tr>
		<td class="tcell-left"><?php echo $lang["CONTROLLING_PHASES_PLANNED"];?></td>
		<td><?php echo($controlling->plannedphases);?></td>
	</tr>
	<tr>
		<td class="tcell-left"><?php echo $lang["CONTROLLING_PHASES_RUNNING"];?></td>
		<td><?php echo($controlling->inprogressphases);?></td>
	</tr>
	<tr>
		<td class="tcell-left"><?php echo $lang["CONTROLLING_PHASES_FINISHED"];?></td>
		<td><?php echo $controlling->finishedphases;?></td>
	</tr>
</table>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
	<tr>
		<td><?php  $this->getChart($controlling->id,'stability',1);?></td>
		<td><?php  $this->getChart($controlling->id,'realisation',1);?></td>
		<td><?php  $this->getChart($controlling->id,'timeing',1);?></td>
		<td><?php  $this->getChart($controlling->id,'tasks',1);?></td>
	</tr>
</table>
<div style="page-break-after:always;">&nbsp;</div>
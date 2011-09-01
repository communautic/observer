<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["PROJECT_CONTROLLING_STATUS"];?> </td>
        <td><strong><?php echo $tit;?></strong></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PROJECT_CONTROLLING_PHASES_CREATED"];?></td>
		<td><?php echo($cont->allphases);?></td>
	</tr>
	<tr>
		<td class="tcell-left"><?php echo $lang["PROJECT_CONTROLLING_PHASES_PLANNED"];?></td>
		<td><?php echo($cont->plannedphases);?></td>
	</tr>
	<tr>
		<td class="tcell-left"><?php echo $lang["PROJECT_CONTROLLING_PHASES_RUNNING"];?></td>
		<td><?php echo($cont->inprogressphases);?></td>
	</tr>
	<tr>
		<td class="tcell-left"><?php echo $lang["PROJECT_CONTROLLING_PHASES_FINISHED"];?></td>
		<td><?php echo $cont->finishedphases;?></td>
	</tr>
</table>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
	<tr>
		<td><?php $projectsControlling = new ProjectsControlling("controlling");
		$projectsControlling->getChart($cont->id,'stability',1);?></td>
		<td><?php $projectsControlling->getChart($cont->id,'status',1,1);?></td>
        <td>&nbsp;</td>
	</tr>
</table>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
	<tr>
				<td><?php  $projectsControlling->getChart($cont->id,'realisation',1);?></td>
		<td><?php  $projectsControlling->getChart($cont->id,'timeing',1);?></td>
		<td><?php  $projectsControlling->getChart($cont->id,'tasks',1);?></td>
        <td>&nbsp;</td>
	</tr>
</table>
<div style="page-break-after:always;">&nbsp;</div>
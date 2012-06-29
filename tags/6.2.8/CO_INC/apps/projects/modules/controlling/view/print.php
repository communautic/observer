<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["PROJECT_CONTROLLING_STATUS"];?> </td>
        <td><strong><?php echo $tit;?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PROJECT_CONTROLLING_PHASES_CREATED"];?></td>
		<td><?php echo($cont->allphases);?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PROJECT_CONTROLLING_PHASES_PLANNED"];?></td>
		<td><?php echo($cont->plannedphases);?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PROJECT_CONTROLLING_PHASES_RUNNING"];?></td>
		<td><?php echo($cont->inprogressphases);?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PROJECT_CONTROLLING_PHASES_FINISHED"];?></td>
		<td><?php echo $cont->finishedphases;?></td>
	</tr>
</table>
&nbsp;
<table width="100%" class="standard-margin">
	<tr>
		<td width="34%"><?php $projectsControlling = new ProjectsControlling("controlling");
		$projectsControlling->getChart($cont->id,'stability',1);?></td>
		<td width="66%"><?php $projectsControlling->getChart($cont->id,'status',1,1);?></td>
	</tr>
</table>
&nbsp;
<table width="100%" class="standard-margin">
	<tr>
		<td width="34%"><?php $projectsControlling->getChart($cont->id,'realisation',1);?></td>
		<td width="33%"><?php $projectsControlling->getChart($cont->id,'timeing',1);?></td>
		<td width="33%"><?php $projectsControlling->getChart($cont->id,'tasks',1);?></td>
	</tr>
</table>
<div style="page-break-after:always;">&nbsp;</div>
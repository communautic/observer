<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["PROJECT_FOLDER"];?></td>
        <td><strong><?php echo($folder->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang["PROJECT_FOLDER_PROJECTS_CREATED"];?></td>
    <td><?php echo($folder->allprojects);?>&nbsp;</td>
  </tr>
</table>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang["PROJECT_FOLDER_PROJECTS_PLANNED"];?></td>
    <td><?php echo($folder->plannedprojects);?>&nbsp;</td>
  </tr>
</table>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang["PROJECT_FOLDER_PROJECTS_RUNNING"];?></td>
    <td><?php echo($folder->activeprojects);?>&nbsp;</td>
  </tr>
</table>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang["PROJECT_FOLDER_PROJECTS_FINISHED"];?></td>
    <td><?php echo $folder->inactiveprojects;?>&nbsp;</td>
  </tr>
</table>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang["PROJECT_FOLDER_PROJECTS_STOPPED"];?></td>
    <td><?php echo $folder->stoppedprojects;?>&nbsp;</td>
  </tr>
</table>
&nbsp;
<table width="100%" class="standard-margin">
	<tr>
		<td width="34%"><?php $this->getChartFolder($folder->id,'stability',1);?></td>
		<td width="66%"><?php $this->getChartFolder($folder->id,'status',1,1);?></td>
	</tr>
</table>
&nbsp;
<table width="100%" class="standard-margin">
	<tr>
		<td width="34%"><?php $this->getChartFolder($folder->id,'realisation',1);?></td>
		<td width="33%"><?php $this->getChartFolder($folder->id,'timeing',1);?></td>
		<td width="33%"><?php $this->getChartFolder($folder->id,'tasks',1);?></td>
	</tr>
</table>
&nbsp;<br />
<?php
if(is_array($projects)) {
	$i = 1;
	foreach ($projects as $project) { 
	?>
<table width="100%" class="fourCols">
	<tr>
		<td class="fourCols-one"><?php if($i == 1) { echo $lang["PROJECT_PROJECTS"]; }?>&nbsp;</td>
        <td class="fourCols-two">&nbsp;</td>
        <td class="fourCols-three greybg">&nbsp;</td>
		<td class="fourCols-four greybg"><?php echo($project->title);?></td>
	</tr>
    <tr>
		<td class="fourCols-one">&nbsp;</td>
        <td class="fourCols-two">&nbsp;</td>
        <td class="fourCols-three">&nbsp;</td>
		<td class="grey smalltext fourCols-paddingTop"><?php echo $lang["GLOBAL_DURATION"];?> <?php echo($project->startdate . " - " . $project->enddate);?><br /> 
        <?php echo $lang["PROJECT_FOLDER_CHART_REALISATION"];?> <?php echo($project->realisation["real"]);?>%<br />
        <?php echo $lang["PROJECT_MANAGEMENT"];?> <?php echo($project->management);?>
</td>
	</tr>
             <tr>
             <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext">&nbsp;</td>
        </tr>
</table>
    <?php 
	$i++;
	}
}
?>
<div style="page-break-after:always;">&nbsp;</div>
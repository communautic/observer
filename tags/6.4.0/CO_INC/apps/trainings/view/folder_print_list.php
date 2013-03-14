<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["TRAINING_FOLDER"];?></td>
        <td><strong><?php echo($folder->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang["TRAINING_FOLDER_TRAININGS_CREATED"];?></td>
    <td><?php echo($folder->alltrainings);?>&nbsp;</td>
  </tr>
</table>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang["TRAINING_FOLDER_TRAININGS_PLANNED"];?></td>
    <td><?php echo($folder->plannedtrainings);?>&nbsp;</td>
  </tr>
</table>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang["TRAINING_FOLDER_TRAININGS_RUNNING"];?></td>
    <td><?php echo($folder->activetrainings);?>&nbsp;</td>
  </tr>
</table>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang["TRAINING_FOLDER_TRAININGS_FINISHED"];?></td>
    <td><?php echo $folder->inactivetrainings;?>&nbsp;</td>
  </tr>
</table>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang["TRAINING_FOLDER_TRAININGS_STOPPED"];?></td>
    <td><?php echo $folder->stoppedtrainings;?>&nbsp;</td>
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
		<td width="33%"><?php $this->getChartFolder($folder->id,'feedbacks',1);?></td>
	</tr>
</table>
&nbsp;<br />
<?php
if(is_array($trainings)) {
	$i = 1;
	foreach ($trainings as $training) { 
	?>
<table width="100%" class="fourCols">
	<tr>
		<td class="fourCols-one"><?php if($i == 1) { echo $lang["TRAINING_TRAININGS"]; }?>&nbsp;</td>
        <td class="fourCols-two">&nbsp;</td>
        <td class="fourCols-three greybg">&nbsp;</td>
		<td class="fourCols-four greybg"><?php echo($training->title);?></td>
	</tr>
    <tr>
		<td class="fourCols-one">&nbsp;</td>
        <td class="fourCols-two">&nbsp;</td>
        <td class="fourCols-three">&nbsp;</td>
		<td class="grey smalltext fourCols-paddingTop"><?php echo $lang["GLOBAL_DURATION"];?> <?php echo($training->dates_display);?><br /> 
        <?php echo $lang["TRAINING_TEAM"];?> <?php echo($training->team);?><br />
        <?php echo($training->status_text);?>
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
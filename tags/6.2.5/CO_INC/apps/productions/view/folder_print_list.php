<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["PRODUCTION_FOLDER"];?></td>
        <td><strong><?php echo($folder->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang["PRODUCTION_FOLDER_PRODUCTIONS_CREATED"];?></td>
    <td><?php echo($folder->allproductions);?>&nbsp;</td>
  </tr>
</table>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang["PRODUCTION_FOLDER_PRODUCTIONS_PLANNED"];?></td>
    <td><?php echo($folder->plannedproductions);?>&nbsp;</td>
  </tr>
</table>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang["PRODUCTION_FOLDER_PRODUCTIONS_RUNNING"];?></td>
    <td><?php echo($folder->activeproductions);?>&nbsp;</td>
  </tr>
</table>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang["PRODUCTION_FOLDER_PRODUCTIONS_FINISHED"];?></td>
    <td><?php echo $folder->inactiveproductions;?>&nbsp;</td>
  </tr>
</table>
<table width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang["PRODUCTION_FOLDER_PRODUCTIONS_STOPPED"];?></td>
    <td><?php echo $folder->stoppedproductions;?>&nbsp;</td>
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
if(is_array($productions)) {
	$i = 1;
	foreach ($productions as $production) { 
	?>
<table width="100%" class="fourCols">
	<tr>
		<td class="fourCols-one"><?php if($i == 1) { echo $lang["PRODUCTION_PRODUCTIONS"]; }?>&nbsp;</td>
        <td class="fourCols-two">&nbsp;</td>
        <td class="fourCols-three greybg">&nbsp;</td>
		<td class="fourCols-four greybg"><?php echo($production->title);?></td>
	</tr>
    <tr>
		<td class="fourCols-one">&nbsp;</td>
        <td class="fourCols-two">&nbsp;</td>
        <td class="fourCols-three">&nbsp;</td>
		<td class="grey smalltext fourCols-paddingTop"><?php echo $lang["GLOBAL_DURATION"];?> <?php echo($production->startdate . " - " . $production->enddate);?><br /> 
        <?php echo $lang["PRODUCTION_FOLDER_CHART_REALISATION"];?> <?php echo($production->realisation["real"]);?>%<br />
        <?php echo $lang["PRODUCTION_MANAGEMENT"];?> <?php echo($production->management);?>
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
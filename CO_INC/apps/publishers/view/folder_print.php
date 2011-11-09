<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["PUBLISHER_FOLDER"];?></td>
        <td><strong><?php echo($folder->title);?></strong></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang["PUBLISHER_FOLDER_PUBLISHERS_CREATED"];?></td>
    <td><?php echo($folder->allpublishers);?>&nbsp;</td>
  </tr>
  <tr>
    <td class="tcell-left"><?php echo $lang["PUBLISHER_FOLDER_PUBLISHERS_PLANNED"];?></td>
    <td><?php echo($folder->plannedpublishers);?>&nbsp;</td>
  </tr>
  <tr>
    <td class="tcell-left"><?php echo $lang["PUBLISHER_FOLDER_PUBLISHERS_RUNNING"];?></td>
    <td><?php echo($folder->activepublishers);?>&nbsp;</td>
  </tr>
  <tr>
    <td class="tcell-left"><?php echo $lang["PUBLISHER_FOLDER_PUBLISHERS_FINISHED"];?></td>
    <td><?php echo $folder->inactivepublishers;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="tcell-left"><?php echo $lang["PUBLISHER_FOLDER_PUBLISHERS_STOPPED"];?></td>
    <td><?php echo $folder->stoppedpublishers;?>&nbsp;</td>
  </tr>
</table>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
	<tr>
		<td><?php $this->getChartFolder($folder->id,'stability',1);?></td>
		<td><?php $this->getChartFolder($folder->id,'status',1,1);?></td>
        <td>&nbsp;</td>
	</tr>
</table>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
	<tr>
		<td><?php $this->getChartFolder($folder->id,'realisation',1);?></td>
		<td><?php $this->getChartFolder($folder->id,'timeing',1);?></td>
		<td><?php $this->getChartFolder($folder->id,'tasks',1);?></td>
        <td>&nbsp;</td>
	</tr>
</table>
&nbsp;
<?php
if(is_array($publishers)) {
	$i = 1;
	foreach ($publishers as $publisher) { 
	?>
<table cellpadding="0" cellspacing="0" width="100%" class="standard">
	<tr>
		<td class="tcell-left-short"><?php if($i == 1) { echo $lang["PUBLISHER_PUBLISHERS"]; }?>&nbsp;</td>
        <td class="short greybg">&nbsp;</td>
		<td class="greybg"><?php echo($publisher->title);?></td>
	</tr>
    <tr>
		<td>&nbsp;</td> 
        <td>&nbsp;</td>
		<td class="grey smalltext"><?php echo $lang["GLOBAL_DURATION"];?> <?php echo($publisher->startdate . " - " . $publisher->enddate);?><br /> 
        <?php echo $lang["PUBLISHER_FOLDER_CHART_REALISATION"];?> <?php echo($publisher->realisation["real"]);?>%<br />
        <?php echo $lang["PUBLISHER_MANAGEMENT"];?> <?php echo($publisher->management);?>        
        <br />&nbsp;
</td>
	</tr>
</table>
    <?php 
	$i++;
	}
}
?>
<div style="page-break-after:always;">&nbsp;</div>
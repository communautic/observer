<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["CLIENT_FOLDER"];?></td>
        <td><strong><?php echo($folder->title);?></strong></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%" class="standard">
  <tr>
    <td class="tcell-left"><?php echo $lang["CLIENT_FOLDER_CLIENTS_CREATED"];?></td>
    <td><?php echo($folder->allclients);?>&nbsp;</td>
  </tr>
  <tr>
    <td class="tcell-left"><?php echo $lang["CLIENT_FOLDER_CLIENTS_PLANNED"];?></td>
    <td><?php echo($folder->plannedclients);?>&nbsp;</td>
  </tr>
  <tr>
    <td class="tcell-left"><?php echo $lang["CLIENT_FOLDER_CLIENTS_RUNNING"];?></td>
    <td><?php echo($folder->activeclients);?>&nbsp;</td>
  </tr>
  <tr>
    <td class="tcell-left"><?php echo $lang["CLIENT_FOLDER_CLIENTS_FINISHED"];?></td>
    <td><?php echo $folder->inactiveclients;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="tcell-left"><?php echo $lang["CLIENT_FOLDER_CLIENTS_STOPPED"];?></td>
    <td><?php echo $folder->stoppedclients;?>&nbsp;</td>
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
if(is_array($clients)) {
	$i = 1;
	foreach ($clients as $client) { 
	?>
<table cellpadding="0" cellspacing="0" width="100%" class="standard">
	<tr>
		<td class="tcell-left-short"><?php if($i == 1) { echo $lang["CLIENT_CLIENTS"]; }?>&nbsp;</td>
        <td class="short greybg">&nbsp;</td>
		<td class="greybg"><?php echo($client->title);?></td>
	</tr>
    <tr>
		<td>&nbsp;</td> 
        <td>&nbsp;</td>
		<td class="grey smalltext"><?php echo $lang["GLOBAL_DURATION"];?> <?php echo($client->startdate . " - " . $client->enddate);?><br /> 
        <?php echo $lang["CLIENT_FOLDER_CHART_REALISATION"];?> <?php echo($client->realisation["real"]);?>%<br />
        <?php echo $lang["CLIENT_MANAGEMENT"];?> <?php echo($client->management);?>        
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
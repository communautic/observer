<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["CLIENT_FOLDER"];?></td>
        <td><strong><?php echo($folder->title);?></strong></td>
	</tr>
</table>
&nbsp;
<?php
if(is_array($clients)) {
	$i = 1;
	foreach ($clients as $client) { 
	?>
<table width="100%" class="fourCols">
	<tr>
		<td class="fourCols-one"><?php if($i == 1) { echo $lang["CLIENT_CLIENTS"]; }?>&nbsp;</td>
        <td class="fourCols-two">&nbsp;</td>
        <td class="fourCols-three greybg">&nbsp;</td>
		<td class="fourCols-four greybg"><?php echo($client->title);?></td>
	</tr>
    <tr>
		<td class="fourCols-one">&nbsp;</td>
        <td class="fourCols-two">&nbsp;</td>
        <td class="fourCols-three">&nbsp;</td>
		<td class="grey smalltext fourCols-paddingTop"><?php echo $lang["CLIENT_MANAGEMENT"];?> <?php echo($client->management);?></td>
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
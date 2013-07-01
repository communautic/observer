<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["PROC_FOLDER"];?></td>
        <td><strong><?php echo($folder->title);?></strong></td>
	</tr>
</table>
&nbsp;
<?php
if(is_array($procs)) {
	$i = 1;
	foreach ($procs as $proc) { 
	?>
<table width="100%" class="fourCols">
	<tr>
		<td class="fourCols-one"><?php if($i == 1) { echo $lang["PROC_PROCS"]; }?>&nbsp;</td>
        <td class="fourCols-two">&nbsp;</td>
        <td class="fourCols-three greybg">&nbsp;</td>
		<td class="fourCols-four greybg"><?php echo($proc->title);?></td>
	</tr>
    <tr>
		<td class="fourCols-one">&nbsp;</td>
        <td class="fourCols-two">&nbsp;</td>
        <td class="fourCols-three">&nbsp;</td>
		<td class="grey smalltext fourCols-paddingTop"><?php echo $lang["PROC_FOLDER_CREATED_ON"];?> <?php echo($proc->created_date);?><br />
		<?php echo $lang["PROC_FOLDER_INITIATOR"];?> <?php echo($proc->created_user);?></td>
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
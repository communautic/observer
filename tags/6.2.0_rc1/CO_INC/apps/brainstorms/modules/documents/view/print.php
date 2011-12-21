<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["BRAINSTORM_DOCUMENT_TITLE"];?></td>
        <td><strong><?php echo($document->title);?></strong></td>
	</tr>
</table>
&nbsp;
<?php
$i = 1;
foreach($doc as $value) { ?>
    <table width="100%" class="fourCols">
        <tr>
            <td class="fourCols-one"><?php if($i == 1) { echo $lang["BRAINSTORM_DOCUMENT_FILES"]; }?>&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three greybg">&nbsp;</td>
            <td class="fourCols-four greybg"><?php echo $lang["BRAINSTORM_DOCUMENT_FILENAME"];?> <?php echo($value->filename);?></td>
        </tr>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext fourCols-paddingTop"><?php echo $lang["BRAINSTORM_DOCUMENT_FILESIZE"];?> <?php echo($value->filesize);?></td>
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
?>
<!--<div style="page-break-after:always;">&nbsp;</div>-->
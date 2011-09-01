<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["BRAINSTORM_DOCUMENT_TITLE"];?></td>
        <td><strong><?php echo($document->title);?></strong></td>
	</tr>
</table>
<?php
$i = 1;
foreach($doc as $value) { ?>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
        <tr>
            <td class="tcell-left">
            <?php if($i == 1) { echo $lang["BRAINSTORM_DOCUMENT_FILES"]; }?>&nbsp;
            </td>
            <td><?php echo $lang["BRAINSTORM_DOCUMENT_FILENAME"];?> <?php echo($value->filename);?></td>
        </tr>
        <tr>
            <td class="tcell-left">&nbsp;</td>
            <td><?php echo $lang["BRAINSTORM_DOCUMENT_FILESIZE"];?> <?php echo($value->filesize);?></td>
        </tr>
		<tr>
			 <td class="tcell-left">&nbsp;</td>
            <td><div class="line">&nbsp;</div></td>
        </tr>
    </table>
    
	<?php 
	$i++;
	}
?>
<!--<div style="page-break-after:always;">&nbsp;</div>-->
<?php if(is_array($arr["documents_folders"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["COMPLAINT_DOCUMENT_DOCUMENTS"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["documents_folders"] as $documents_folder) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="document_<?php echo($documents_folder->id);?>" rel="<?php echo($documents_folder->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["COMPLAINT_DOCUMENT_TITLE"];?></span></td>
		<td class="tcell-right"><?php echo($documents_folder->title);?></td>
        <td width="30"><a href="complaints_documents" class="binRestore" rel="<?php echo $documents_folder->id;?>"><span class="icon-restore"></span></a></td>
        <td width="30"><a href="complaints_documents" class="binDelete" rel="<?php echo $documents_folder->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($documents_folder->binuser . ", " .$documents_folder->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>



<?php if(is_array($arr["files"])) { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["COMPLAINT_DOCUMENT_FILENAME"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php foreach ($arr["files"] as $file) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive" id="file_<?php echo($file->id);?>" rel="<?php echo($file->id);?>">
	<tr>
		<td class="tcell-left text11"><span><?php echo $lang["COMPLAINT_DOCUMENT_FILENAME"];?></span></td>
		<td class="tcell-right"><?php echo($file->filename);?></td>
        <td width="30"><a href="complaints_documents" class="binRestoreItem" rel="<?php echo $file->id;?>"><span class="icon-restore"></span></a></td>
        <td width="30"><a href="complaints_documents" class="binDeleteItem" rel="<?php echo $file->id;?>"><span class="icon-delete"></span></a></td>
	</tr>
    <tr>
		<td class="tcell-left text11"><span><?php echo $lang["DELETED_BY_ON"];?></span></td>
		<td class="tcell-right"><?php echo($file->binuser . ", " .$file->bintime)?></td>
        <td></td>
        <td></td>
	</tr>
</table>
    <?php 
	}
}
?>

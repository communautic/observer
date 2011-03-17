<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><a href="#" class="content-nav focusTitle"><span><?php echo $lang["DOCUMENT_TITLE"];?></span></a></td>
    <td><input name="title" type="text" class="title textarea-title" value="<?php echo($document->title);?>" maxlength="100" /></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form id="coform" action="/" method="post" class="coform jNice" >
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($document->id);?>">
</form>
<div class="document-uploader">		
	<noscript>			
	<p>Please enable JavaScript to use file uploader.</p>
	<!-- or put a simple form for upload here -->
	</noscript>         
</div>
<?php  foreach($doc as $value) { ?>
<div id="doc_<?php echo $value->id;?>" class="docouter">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
  <tr>
		<td class="tcell-left text11">&nbsp;</td>
    	<td class="tcell-right">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td class="tcell-left text11"><?php echo $lang["DOCUMENT_FILENAME"];?></td>
      <td class="tcell-right"><a href="Download" class="downloadDocument" rel="<?php echo $value->id;?>" title="Download"><?php echo($value->filename)?></a></td>
 	  <td width="30"><a href="#" class="deleteDoc" rel="<?php echo $value->id;?>"><span class="icon-delete"></span></a></td>
    </tr>
    <tr>
      <td class="tcell-left text11"><?php echo $lang["DOCUMENT_FILESIZE"];?></td>
      <td class="tcell-right"><?php echo($value->filesize)?></td>
      <td></td>
    </tr>
    </table>
  		</td>
	</tr>
</table>
</div>
<?php } ?>
<div id="docs"></div>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><a href="#" class="content-nav showDialog" request="getAccessDialog" field="document_access" title="<?php echo $lang["GLOBAL_ACCESS"];?>" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></a></td>
        <td class="tcell-right"><div id="document_access" class="itemlist-field"><div class="listmember" field="document_access" uid="<?php echo($document->access);?>" style="float: left"><?php echo($document->access_text);?></div></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive"><?php echo($document->emailed_to)?></td>
    </tr>
</table>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($document->edited_user.", ".$document->edited_date)?></td>
    <td class="middle"><?php echo $document->access_footer;?></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($document->created_user.", ".$document->created_date);?></td>
  </tr>
</table>
</div>
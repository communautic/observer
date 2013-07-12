<div class="table-title-outer">
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($document->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["PROC_DOCUMENT_TITLE"];?></span></span></td>
    <td><input name="title" type="text" class="title textarea-title" value="<?php echo($document->title);?>" maxlength="100" /></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form id="coform" action="/" method="post" class="<?php if($document->canedit) { ?>coform <?php } ?>jNice" >
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($document->id);?>">
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($document->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["PROC_DOCUMENT_DESCRIPTION"];?></span></span></td>
    <td class="tcell-right"><?php if($document->canedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($document->protocol));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($document->protocol)));?><?php } ?></td>
  </tr>
</table>
<div class="content-spacer"></div>
</form>
<?php if($document->canedit) { ?>
<div id="procs_documents_uploader" class="document-uploader">		
	<noscript>			
	<p>Please enable JavaScript to use file uploader.</p>
	<!-- or put a simple form for upload here -->
	</noscript>         
</div>
<?php } ?>
<?php  foreach($doc as $value) { ?>
<div id="doc_<?php echo $value->id;?>" class="docouter">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
  <tr>
		<td class="tcell-left text11">&nbsp;</td>
    	<td class="tcell-right">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td class="tcell-left text11"><?php echo $lang["PROC_DOCUMENT_FILENAME"];?></td>
      <td class="tcell-right"><a mod="procs_documents" class="downloadDocument" rel="<?php echo $value->id;?>"><?php echo($value->filename)?></a></td>
 	  <td width="25"><?php if($document->canedit) { ?><a class="binItem" rel="<?php echo $value->id;?>"><span class="icon-delete"></span></a><?php } ?></td>
    </tr>
    <tr>
      <td class="tcell-left text11"><?php echo $lang["PROC_DOCUMENT_FILESIZE"];?></td>
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
<?php if($document->perms != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($document->canedit) { ?>content-nav showDialog<?php } ?>" request="getAccessDialog" field="procsdocument_access" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></span></td>
        <td class="tcell-right"><div id="procsdocument_access" class="itemlist-field"><div class="listmember" field="procsdocument_access" uid="<?php echo($document->access);?>" style="float: left"><?php echo($document->access_text);?></div></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="procsdocument_sendto">
        <?php 
			foreach($sendto as $value) { 
				if(!empty($value->who)) {
					echo '<div class="text11 toggleSendTo co-link">' . $value->who . ', ' . $value->date . '</div>' .
						 '<div class="SendToContent">' . $lang["GLOBAL_SUBJECT"] . ': ' . $value->subject . '<br /><br />' . nl2br($value->body) . '<br></div>';
}
		 } ?></div>
        </td>
    </tr>
</table>
<?php } ?>
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
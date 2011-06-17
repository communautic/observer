<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="content-nav focusTitle"><span><?php echo $lang["PROJECT_VDOC_TITLE"];?></span></span></td>
    <td><input name="title" type="text" class="title textarea-title" value="<?php echo($vdoc->title);?>" maxlength="100" /></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="coform jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($vdoc->id);?>">
<input type="hidden" name="pid" value="<?php echo($vdoc->pid);?>">
<div style=" margin-top: 107px;  margin-left: 15px;">
<textarea id="vdocContent" name="content" class="vdoc" style="width: 640px; height: 400px;" ><?php echo($vdoc->content);?></textarea>
</div>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="content-nav showDialog" request="getAccessDialog" field="vdoc_access" title="<?php echo $lang["GLOBAL_ACCESS"];?>" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></span></td>
        <td class="tcell-right"><div id="vdoc_access" class="itemlist-field"><div class="listmember" field="vdoc_access" uid="<?php echo($vdoc->access);?>" style="float: left"><?php echo($vdoc->access_text);?></div></div><input type="hidden" name="vdoc_access_orig" value="<?php echo($vdoc->access);?>" /></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="vdoc_sendto">
        <?php 
			foreach($sendto as $value) { 
			echo '<div class="text11">' . $value->who . ', ' . $value->date . '</div>';
		 } ?></div>
        </td>
    </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content" height="100">
	<tr>
	  <td class="tcell-left text11"></td>
</table>
</form>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($vdoc->edited_user.", ".$vdoc->edited_date)?></td>
    <td class="middle"><?php echo $vdoc->access_footer;?></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($vdoc->created_user.", ".$vdoc->created_date);?></td>
  </tr>
</table>
</div>
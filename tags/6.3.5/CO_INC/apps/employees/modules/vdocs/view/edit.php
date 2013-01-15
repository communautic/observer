<div class="table-title-outer">

<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($vdoc->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["EMPLOYEE_VDOC_TITLE"];?></span></span></td>
    <td><input name="title" type="text" class="title textarea-title" value="<?php echo($vdoc->title);?>" maxlength="100" /></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($vdoc->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($vdoc->id);?>">
<input type="hidden" name="pid" value="<?php echo($vdoc->pid);?>">
<?php if($vdoc->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span>Warnung</span></span></strong></td>
		<td class="tcell-right"><strong>Dieser Inhaltsbereich wird aktuell bearbeitet von: <?php echo($vdoc->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($vdoc->checked_out_user_email);?>"><?php echo($vdoc->checked_out_user_email);?></a>, <?php echo($vdoc->checked_out_user_phone1);?></td>
    </tr>
</table>
<?php } ?>
<?php if($vdoc->canedit) { ?>
<div style=" margin-top: 55px;  margin-left: 15px;">
<textarea id="employeesvdocContent" name="content" class="vdoc" style="width: 635px; height: 400px; visibility:hidden" ><?php echo($vdoc->content);?></textarea>
<?php } else { ?>
<div style=" margin-top: 20px;  margin-left: 15px; border: 1px solid #ccc; width: 635px;">
<?php echo($vdoc->content);?>
<?php } ?>
</div>
<?php if($vdoc->perms != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($vdoc->canedit) { ?>content-nav showDialog<?php } ?>" request="getAccessDialog" field="employeesvdoc_access" title="<?php echo $lang["GLOBAL_ACCESS"];?>" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></span></td>
        <td class="tcell-right"><div id="employeesvdoc_access" class="itemlist-field"><div class="listmember" field="employeesvdoc_access" uid="<?php echo($vdoc->access);?>" style="float: left"><?php echo($vdoc->access_text);?></div></div><input type="hidden" name="vdoc_access_orig" value="<?php echo($vdoc->access);?>" /></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="employeesvdoc_sendto">
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
<div class="table-title-outer">

<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($production->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["PRODUCTION_TITLE"];?></span></span></td>
    <td class="tcell-right"><?php if($production->canedit) { ?><input name="title" type="text" class="title textarea-title" value="<?php echo($production->title);?>" maxlength="100" /><?php } else { ?><div class="textarea-title"><?php echo($production->title);?></div><?php } ?></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($production->canedit) { ?>coform <?php } ?>">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setProductionDetails">
<input type="hidden" name="id" value="<?php echo($production->id);?>">
<?php if($production->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span>Warnung</span></span></strong></td>
		<td class="tcell-right"><strong>Dieser Inhaltsbereich wird aktuell bearbeitet von: <?php echo($production->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($production->checked_out_user_email);?>"><?php echo($production->checked_out_user_email);?></a>, <?php echo($production->checked_out_user_phone1);?></td>
    </tr>
</table>
<div class="content-spacer"></div>
<?php } ?>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_DURATION"];?></td>
		<td class="tcell-right-inactive"><span id="productionDurationStart"><?php echo($production->startdate)?></span> - <span id="productionDurationEnd"><?php echo($production->enddate)?></span></td>
    </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($production->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang['PRODUCTION_KICKOFF'];?></span></span></td>
		<td class="tcell-right"><?php if($production->canedit) { ?><input name="startdate" type="text" class="input-date datepicker" value="<?php echo($production->startdate)?>" /><input id="moveproduction_start" name="moveproduction_start" type="hidden" value="<?php echo($production->startdate)?>" /><?php } else { ?><?php echo($production->startdate)?><?php } ?></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($production->canedit) { ?>content-nav showDialog<?php } ?>" request="getProductionFolderDialog" field="productionsfolder" append="1"><span><?php echo $lang["PRODUCTION_FOLDER"];?></span></span></td>
        <td class="tcell-right"><div id="productionsfolder" class="itemlist-field"><?php echo($production->folder);?></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($production->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="productionsordered_by" append="0"><span><?php echo $lang["PRODUCTION_CLIENT"];?></span></span></td>
	  <td class="tcell-right"><div id="productionsordered_by" class="itemlist-field"><?php echo($production->ordered_by);?></div><div id="productionsordered_by_ct" class="itemlist-field"><a field="productionsordered_by_ct" class="ct-content"><?php echo($production->ordered_by_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($production->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="productionsmanagement" append="1"><span><?php echo $lang["PRODUCTION_MANAGEMENT"];?></span></span></td>
	  <td class="tcell-right"><div id="productionsmanagement" class="itemlist-field"><?php echo($production->management);?></div><div id="productionsmanagement_ct" class="itemlist-field"><a field="productionsmanagement_ct" class="ct-content"><?php echo($production->management_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($production->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="productionsteam" append="1"><span><?php echo $lang["PRODUCTION_TEAM"];?></span></span></td>
    <td class="tcell-right"><div id="productionsteam" class="itemlist-field"><?php echo($production->team);?></div><div id="productionsteam_ct" class="itemlist-field"><a field="productionsteam_ct" class="ct-content"><?php echo($production->team_ct);?></a></div></td>
  </tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($production->canedit) { ?>content-nav showDialog<?php } ?>" request="getProductionStatusDialog" field="productionsstatus" append="1"><span><?php echo $lang["GLOBAL_STATUS"];?></span></span></td>
        <td class="tcell-right"><div id="productionsstatus" class="itemlist-field"><div class="listmember" field="productionsstatus" uid="<?php echo($production->status);?>" style="float: left"><?php echo($production->status_text);?></div></div><?php if($production->canedit) { ?><input name="status_date" type="text" class="input-date datepicker status_date" value="<?php echo($production->status_date)?>" style="float: left; margin-left: 8px;" /><?php } else { ?><div style="float: left; margin-left: 8px;"><?php echo($production->status_date)?><?php } ?></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($production->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["PRODUCTION_DESCRIPTION"];?></span></span></td>
        <td class="tcell-right"><?php if($production->canedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($production->protocol));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($production->protocol)));?><?php } ?></td>
	</tr>
</table>
</form>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PRODUCTION_PHASES"];?></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
<?php
if(is_array($phases)) {
	$i = 1;
	foreach ($phases as $phase) { ?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive loadProductionsPhase" rel="<?php echo($phase->id);?>">
	<tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right" colspan="3"><span class="bold co-link"><?php echo($num[$phase->id] . " " . $phase->title);?></span></td>
	</tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right" width="220"><span class="text11 content-date"><?php echo $lang["GLOBAL_DURATION"];?></span><span class="text11"><?php echo($phase->startdate . " - " . $phase->enddate);?></span></td>
		<td class="tcell-right" width="110"><span class="text11"><span style="display: inline; margin-right: 20px;"></span><?php echo($phase->status_text);?></span></td>
	    <td class="tcell-right"><?php if($production->access != "guest") { ?><span class="text11"><span style="display: inline; margin-right: 20px;"><?php echo $lang["PRODUCTION_FOLDER_CHART_REALISATION"];?></span><?php echo($phase->realisation);?>%</span><?php } ?></td>
    </tr>
</table>
    <?php 
	$i++;
	}
}
?>
<?php if($production->access != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="production_sendto">
        <?php 
			foreach($sendto as $value) { 
			if(!empty($value->who)) {
				echo '<div class="text11 toggleSendTo">' . $value->who . ', ' . $value->date . '</div>' .
				'<div class="SendToContent">' . $lang["GLOBAL_SUBJECT"] . ': ' . $value->subject . '<br /><br />' . nl2br($value->body) . '<br></div>';
			}
		 } ?></div></td>
    </tr>
</table>
<?php } ?>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($production->edited_user.", ".$production->edited_date)?></td>
    <td class="middle"></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($production->created_user.", ".$production->created_date);?></td>
  </tr>
</table>
</div>
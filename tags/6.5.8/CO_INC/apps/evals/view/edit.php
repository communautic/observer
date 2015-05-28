<div class="table-title-outer">

<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span><span><?php echo $lang["EVAL_TITLE"];?></span></span></td>
    <td class="tcell-right"><?php if($eval->canedit) { ?><input name="title" type="hidden" class="title textarea-title" value="<?php echo($eval->title);?>" maxlength="100" /><?php } ?><div class="textarea-title"><?php echo($eval->title);?></div></td>
  </tr>
  <tr class="table-title-status">
    <td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_STATUS"];?></td>
    <td colspan="2"><div class="statusTabs">
    	<ul>
        	<li><span class="left<?php if($eval->canedit) { ?> statusButton<?php } ?> planned<?php echo $eval->status_planned_active;?>" rel="0" reltext="<?php echo $lang["GLOBAL_STATUS_INPREPARATION_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_INPREPARATION"];?></span></li>
            <li><span class="<?php if($eval->canedit) { ?>statusButton <?php } ?>inprogress<?php echo $eval->status_inprogress_active;?>" rel="1" reltext="<?php echo $lang["GLOBAL_STATUS_FIRSTEVAL_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_FIRSTEVAL"];?></span></li>
            <li><span class="<?php if($eval->canedit) { ?>statusButton <?php } ?>finished<?php echo $eval->status_finished_active;?>" rel="2" reltext="<?php echo $lang["GLOBAL_STATUS_INEVALUATION_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_INEVALUATION"];?></span></li>
            <li><span class="right<?php if($eval->canedit) { ?> statusButton<?php } ?> stopped<?php echo $eval->status_stopped_active;?>" rel="3" reltext="<?php echo $lang["GLOBAL_STATUS_FINISHED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_FINISHED"];?></span></li>
            <li><div class="status-time"><?php echo($eval->status_text_time)?></div><div class="status-input"><input name="phase_status_date" type="text" class="input-date statusdp" value="<?php echo($eval->status_date)?>" readonly="readonly" /></div></li>
		</ul></div></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($eval->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setEvalDetails">
<input type="hidden" name="id" value="<?php echo($eval->id);?>">
<?php if($eval->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span><?php echo $lang["GLOBAL_ALERT"];?></span></span></strong></td>
		<td class="tcell-right"><strong><?php echo $lang["GLOBAL_CONTENT_EDITED_BY"];?> <?php echo($eval->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($eval->checked_out_user_email);?>"><?php echo($eval->checked_out_user_email);?></a>, <?php echo($eval->checked_out_user_phone1);?></td>
    </tr>
</table>
<div class="content-spacer"></div>
<?php } ?>
<div style="position: absolute; top: 0; right: 15px; height: 120px; width: 80px; background-image:url(<?php echo($eval->avatar);?>); background-repeat: no-repeat"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($eval->canedit) { ?>content-nav showDialog<?php } ?>" request="getEvalFolderDialog" field="evalsfolder" append="1"><span><?php echo $lang["EVAL_FOLDER"];?></span></span></td>
        <td class="tcell-right"><div id="evalsfolder" class="itemlist-field"><?php echo($eval->folder);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($eval->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["EVAL_STARTDATE"];?></span></span></td>
		<td class="tcell-right"><?php if($eval->canedit) { ?><input name="startdate" type="text" class="input-date datepickerDelete" value="<?php echo($eval->startdate)?>" readonly="readonly" /><?php } else { ?><?php echo($eval->startdate)?><?php } ?></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($eval->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["EVAL_DOB"];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($eval->canedit) { ?><input name="dob" type="text" class="bg" <?php if($eval->dob == "") {?> value="00.00.0000" onclick="this.value=''"<?php } else { ?> value="<?php echo($eval->dob);?>"<?php } ?> /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $eval->dob . '</span>'); } ?></td>
    
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($eval->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["EVAL_COO"];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($eval->canedit) { ?><input name="coo" type="text" class="bg" value="<?php echo($eval->coo);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $eval->coo . '</span>'); } ?></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($eval->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["EVAL_LANGUAGES"];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($eval->canedit) { ?><input name="languages" type="text" class="bg" value="<?php echo($eval->languages);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $eval->languages . '</span>'); } ?></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($eval->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["EVAL_FOREIGN_LANGUAGES"];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($eval->canedit) { ?><input name="languages_foreign" type="text" class="bg" value="<?php echo($eval->languages_foreign);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $eval->languages_foreign . '</span>'); } ?></td>
  </tr>
</table>


<div style="display: none;">
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($eval->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["EVAL_ENDDATE"];?></span></span></td>
		<td class="tcell-right"><?php if($eval->canedit) { ?><input name="enddate" type="text" class="input-date datepickerDelete" value="<?php echo($eval->enddate)?>" readonly="readonly" /><?php } else { ?><?php echo($eval->enddate)?><?php } ?></td>
	</tr>
</table>
<div class="content-spacer"></div>

<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($eval->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["EVAL_NUMBER"];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($eval->canedit) { ?><input name="number" type="text" class="bg" value="<?php echo($eval->number);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $eval->number . '</span>'); } ?></td>
    
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($eval->canedit) { ?>content-nav showDialog<?php } ?>" request="getEvalDialog" field="evalskind" append="0" sql="kind"><span><?php echo $lang["EVAL_KIND"];?></span></span></td>
        <td class="tcell-right"><div id="evalskind" class="itemlist-field"><?php echo($eval->kind);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($eval->canedit) { ?>content-nav showDialog<?php } ?>" request="getEvalDialog" field="evalsarea" append="0" sql="area"><span><?php echo $lang["EVAL_AREA"];?></span></span></td>
        <td class="tcell-right"><div id="evalsarea" class="itemlist-field"><?php echo($eval->area);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($eval->canedit) { ?>content-nav showDialog<?php } ?>" request="getEvalDialog" field="evalsdepartment" append="0" sql="department"><span><?php echo $lang["EVAL_DEPARTMENT"];?></span></span></td>
        <td class="tcell-right"><div id="evalsdepartment" class="itemlist-field"><?php echo($eval->department);?></div></td>
	</tr>
</table>
</div>
<div class="content-spacer"></div>
    <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin<?php if($eval->canedit) { ?> loadContactExternal<?php } ?>" rel="<?php echo($eval->cid)?>" style="cursor: pointer;">
  <tr>
		<td class="tcell-left-inactive text11" style="padding-top: 2px;">Kontaktdaten</td>
    	<td class="tcell-right-inactive"><?php echo($eval->ctitle)?> <?php echo($eval->title2)?> <?php echo($eval->title);?><br />
        <span class="text11"><?php echo($eval->position . " &nbsp; | &nbsp; " . $lang["EVAL_CONTACT_EMAIL"] . " " . $eval->email . " &nbsp; | &nbsp; " . $lang["EVAL_CONTACT_PHONE"] . " " . $eval->phone1);?></span>
        </td>
        </tr>
</table>
<div class="content-spacer"></div>
<div style="display: none;">
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($eval->canedit) { ?>content-nav showDialog<?php } ?>" request="getEvalDialog" field="evalsfamily" append="0" sql="family"><span><?php echo $lang["EVAL_FAMILY_STATUS"];?></span></span></td>
        <td class="tcell-right"><div id="evalsfamily" class="itemlist-field"><?php echo($eval->family);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-shorter text11"><span class="<?php if($eval->canedit) { ?>content-nav selectTextfield<?php } ?>"><span><?php echo $lang["EVAL_CHILDREN"];?></span></span></td>
    <td class="tcell-right-nopadding"><?php if($eval->canedit) { ?><input name="protocol4" type="text" class="bg" value="<?php echo($eval->protocol4);?>" /><?php } else { echo('<span style="display: block; padding-left: 7px; padding-top: 4px;">' . $eval->protocol4 . '</span>'); } ?></td>
  </tr>
</table>
<!--<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($eval->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["EVAL_CHILDREN"];?></span></span></td>
        <td class="tcell-right"><?php if($eval->canedit) { ?><textarea name="protocol4" class="elastic"><?php echo(strip_tags($eval->protocol4));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($eval->protocol4)));?><?php } ?></td>
	</tr>
</table>-->
</div>

<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($eval->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["EVAL_DESCRIPTION"];?></span></span></td>
        <td class="tcell-right"><?php if($eval->canedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($eval->protocol));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($eval->protocol)));?><?php } ?></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
  <tr>
    <td class="tcell-left-inactive text11"><span><span>Erstanalyse</span></span></td>
    <td class="tcell-right-nopadding">&nbsp;</td>
  </tr>
</table>
<div class="content-spacer"></div>
<div class="grey">
	<?php $this->getChartPerformance($eval->id,'happiness');
        $this->getChartPerformance($eval->id,'performance');
        $this->getChartPerformance($eval->id,'legal');
        $this->getChartPerformance($eval->id,'totals');
    ?>
    <div style="clear: both;"></div>
</div>
<div class="content-spacer"></div>
<div class="grey">
	<?php $this->getChartPerformance($eval->id,'happiness');
        $this->getChartPerformance($eval->id,'performance');
        $this->getChartPerformance($eval->id,'legal');
        $this->getChartPerformance($eval->id,'totals');
    ?>
    <div style="clear: both;"></div>
</div>
<div class="content-spacer"></div> 
</form>
<?php if($eval->access != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="content-nav ui-datepicker-trigger-action"><span><?php echo $lang['GLOBAL_CHECKPOINT'];?></span></span></td>
		<td class="tcell-right"><input name="checkpoint" type="text" class="input-date checkpointdp" value="<?php echo($eval->checkpoint_date);?>" readonly="readonly" /><span style="display: none;"><?php echo($eval->checkpoint);?></span></td>
	</tr>
</table>
<?php if($eval->checkpoint == 1) { $show = 'display: block'; } else { $show = 'display: none'; }?>
<div id="evalsCheckpoint" style="<?php echo $show;?>">
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="selectTextarea"><span>&nbsp;</span></span></td>
        <td class="tcell-right"><textarea name="checkpoint_note" class="elastic-two"><?php echo(strip_tags($eval->checkpoint_note));?></textarea></td>
	</tr>
</table>
</div>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="eval_sendto">
        <?php 
			foreach($sendto as $value) { 
			if(!empty($value->who)) {
				echo '<div class="text11 toggleSendTo co-link">' . $value->who . ', ' . $value->date . '</div>' .
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
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($eval->edited_user.", ".$eval->edited_date)?></td>
    <td class="middle"></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($eval->created_user.", ".$eval->created_date);?></td>
  </tr>
</table>
</div>
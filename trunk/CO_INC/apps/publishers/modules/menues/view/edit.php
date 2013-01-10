<div class="table-title-outer">

<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($menue->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["PUBLISHER_MENUE_TITLE"];?></span></span></td>
    <td><input name="title" type="text" class="title textarea-title" value="<?php echo($menue->title);?>" maxlength="100" /></td>
  </tr>
  <tr class="table-title-status">
    <td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_STATUS"];?></td>
    <td colspan="2"><div class="statusTabs">
    	<ul>
        	<li><span class="left<?php if($menue->canedit) { ?> statusButton<?php } ?> planned<?php echo $menue->status_planned_active;?>" rel="0" reltext="<?php echo $lang["GLOBAL_STATUS_PLANNED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_PLANNED"];?></span></li>
            <li><span class="<?php if($menue->canedit) { ?>statusButton<?php } ?> inprogress<?php echo $menue->status_inprogress_active;?>" rel="1" reltext="<?php echo $lang["GLOBAL_STATUS_PUBLISHED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_PUBLISHED"];?></span></li>
            <li><span class="right<?php if($menue->canedit) { ?> statusButton<?php } ?> finished<?php echo $menue->status_finished_active;?>" rel="2" reltext="<?php echo $lang["GLOBAL_STATUS_ARCHIVED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_ARCHIVED"];?></span></li>
            <li><div class="status-time"><?php echo($menue->status_text_time)?></div><div class="status-input"><input name="phase_status_date" type="text" class="input-date statusdp" value="<?php echo($menue->status_date)?>" readonly="readonly" /></div></li>
		</ul></div></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($menue->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($menue->id);?>">
<?php if($menue->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span>Warnung</span></span></strong></td>
		<td class="tcell-right"><strong>Dieser Inhaltsbereich wird aktuell bearbeitet von: <?php echo($menue->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($menue->checked_out_user_email);?>"><?php echo($menue->checked_out_user_email);?></a>, <?php echo($menue->checked_out_user_phone1);?></td>
    </tr>
</table>
<?php } ?>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($menue->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["PUBLISHER_MENUE_DATE_FROM"];?></span></span></td>
		<td class="tcell-right"><input name="item_date_from" type="text" class="input-date datepicker item_date_from" value="<?php echo($menue->item_date_from)?>" /></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($menue->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["PUBLISHER_MENUE_DATE_TO"];?></span></span></td>
		<td class="tcell-right"><input name="item_date_to" type="text" class="input-date datepicker item_date_to" value="<?php echo($menue->item_date_to)?>" /></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($menue->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="publishersmanagement" append="1"><span><?php echo $lang["PUBLISHER_MENUE_MANAGEMENT"];?></span></span></td>
		<td class="tcell-right"><div id="publishersmanagement" class="itemlist-field"><?php echo($menue->management);?></div><div id="publishersmanagement_ct" class="itemlist-field"><a field="publishersmanagement_ct" class="ct-content"><?php echo($menue->management_ct);?></a></div></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($menue->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["PUBLISHER_MENUE_GOALS"];?></span></span></td>
    <td class="tcell-right"><?php if($menue->canedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($menue->protocol));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($menue->protocol)));?><?php } ?></td>
  </tr>
</table>
<div class="content-spacer"></div>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="menue-grid">
	<tr>
	  <th style="width: 12%" class="first">&nbsp;</th>
      <th>Montag</th>
	  <th>Dienstag</th>
       <th>Mittwoch</th>
       <th>Donnerstag</th>
       <th>Freitag</th>
    </tr>
	<tr>
	    <td style="width: 12%">Ki S.</td>
        <td id="mon_1" class="edit"><?php echo nl2br($menue->mon_1);?></td>
	    <td id="tue_1" class="edit"><?php echo nl2br($menue->tue_1);?></td>
	    <td id="wed_1" class="edit"><?php echo nl2br($menue->wed_1);?></td>
	    <td id="thu_1" class="edit"><?php echo nl2br($menue->thu_1);?></td>
	    <td id="fri_1" class="edit"><?php echo nl2br($menue->fri_1);?></td>
	</tr>
	<tr>
    	<td style="width: 12%">Ki</td>
		<td id="mon_2" class="edit"><?php echo nl2br($menue->mon_2);?></td>
        <td id="tue_2" class="edit"><?php echo nl2br($menue->tue_2);?></td>
        <td id="wed_2" class="edit"><?php echo nl2br($menue->wed_2);?></td>
        <td id="thu_2" class="edit"><?php echo nl2br($menue->thu_2);?></td>
        <td id="fri_2" class="edit"><?php echo nl2br($menue->fri_2);?></td>
	</tr>
	<tr>
    	<td style="width: 12%">Erw S.</td>
		<td id="mon_3" class="edit"><?php echo nl2br($menue->mon_3);?></td>
        <td id="tue_3" class="edit"><?php echo nl2br($menue->tue_3);?></td>
        <td id="wed_3" class="edit"><?php echo nl2br($menue->wed_3);?></td>
        <td id="thu_3" class="edit"><?php echo nl2br($menue->thu_3);?></td>
        <td id="fri_3" class="edit"><?php echo nl2br($menue->fri_3);?></td>
	</tr>
	<tr>
    	<td style="width: 12%">Erw I</td>
	    <td id="mon_4" class="edit"><?php echo nl2br($menue->mon_4);?></td>
        <td id="tue_4" class="edit"><?php echo nl2br($menue->tue_4);?></td>
        <td id="wed_4" class="edit"><?php echo nl2br($menue->wed_4);?></td>
        <td id="thu_4" class="edit"><?php echo nl2br($menue->thu_4);?></td>
        <td id="fri_4" class="edit"><?php echo nl2br($menue->fri_4);?></td>
	</tr>
	<tr>
	    <td style="width: 12%">Erw II</td>
        <td id="mon_5" class="edit"><?php echo nl2br($menue->mon_5);?></td>
        <td id="tue_5" class="edit"><?php echo nl2br($menue->tue_5);?></td>
        <td id="wed_5" class="edit"><?php echo nl2br($menue->wed_5);?></td>
        <td id="thu_5" class="edit"><?php echo nl2br($menue->thu_5);?></td>
        <td id="fri_5" class="edit"><?php echo nl2br($menue->fri_5);?></td>
	</tr>
	<tr>
    	<td style="width: 12%">Erw III</td>
	    <td id="mon_6" class="edit"><?php echo nl2br($menue->mon_6);?></td>
        <td id="tue_6" class="edit"><?php echo nl2br($menue->tue_6);?></td>
        <td id="wed_6" class="edit"><?php echo nl2br($menue->wed_6);?></td>
        <td id="thu_6" class="edit"><?php echo nl2br($menue->thu_6);?></td>
        <td id="fri_6" class="edit"><?php echo nl2br($menue->fri_6);?></td>
	</tr>
</table>
<div class="content-spacer"></div>
<?php if($menue->perms != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($menue->canedit) { ?>content-nav showDialog<?php } ?>" request="getAccessDialog" field="publishersmenue_access" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></span></td>
        <td class="tcell-right"><div id="publishersmenue_access" class="itemlist-field"><div class="listmember" field="publishersmenue_access" uid="<?php echo($menue->access);?>" style="float: left"><?php echo($menue->access_text);?></div></div><input type="hidden" name="menue_access_orig" value="<?php echo($menue->access);?>" /></td>
	</tr>
</table>
<?php } ?>
</form>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="publishersmenue_sendto">
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

</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($menue->edited_user.", ".$menue->edited_date)?></td>
    <td class="middle"><?php echo $menue->access_footer;?></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($menue->created_user.", ".$menue->created_date);?></td>
  </tr>
</table>
</div>
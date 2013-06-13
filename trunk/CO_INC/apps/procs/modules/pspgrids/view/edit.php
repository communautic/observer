<div class="table-title-outer">

<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($pspgrid->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["PROC_PSPGRID_TITLE"];?></span></span></td>
    <td><input name="title" type="text" class="title textarea-title" value="<?php echo($pspgrid->title);?>" maxlength="100" /><?php if($pspgrid->canedit) { ?><div class="appSettings"></div><div class="appSettingsPopupContent" style="display: none;">
    <div class="inner"><?php echo $lang["GLOBAL_CURRENCY"];?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td valign="middle" width="20"><?php echo $lang['GLOBAL_CURRENCY_EURO'];?></td>
        <td valign="middle" width="40"><span class="toggleCurrency coCheckbox<?php if($pspgrid->setting_currency == $lang['GLOBAL_CURRENCY_EURO']) { echo ' active';}?>" rel="<?php echo $lang['GLOBAL_CURRENCY_EURO'];?>"></span></td>
        <td valign="middle" width="20"><?php echo $lang['GLOBAL_CURRENCY_POUND'];?> </td>
        <td valign="middle" width="40"><span class="toggleCurrency coCheckbox<?php if($pspgrid->setting_currency == $lang['GLOBAL_CURRENCY_POUND']) { echo ' active';}?>" rel="<?php echo $lang['GLOBAL_CURRENCY_POUND'];?>"></span></td>
        <td valign="middle" width="20"><?php echo $lang['GLOBAL_CURRENCY_DOLLAR'];?></td>
        <td valign="middle"><span class="toggleCurrency coCheckbox<?php if($pspgrid->setting_currency == $lang['GLOBAL_CURRENCY_DOLLAR']) { echo ' active';}?>" rel="<?php echo $lang['GLOBAL_CURRENCY_DOLLAR'];?>"></span></td>
    </tr>
</table>
		  </div>
    </div><?php } ?></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($pspgrid->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($pspgrid->id);?>">
<input type="hidden" name="pid" value="<?php echo($pspgrid->pid);?>">

<?php if($pspgrid->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span>Warnung</span></span></strong></td>
		<td class="tcell-right"><strong>Dieser Inhaltsbereich wird aktuell bearbeitet von: <?php echo($pspgrid->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($pspgrid->checked_out_user_email);?>"><?php echo($pspgrid->checked_out_user_email);?></a>, <?php echo($pspgrid->checked_out_user_phone1);?></td>
    </tr>
</table>

<?php } ?>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PROC_PSPGRID_TIME"];?></td>
		<td class="tcell-right-inactive"><span id="procPspgridDays"><?php echo $pspgrid->tdays;?></span> <?php echo $lang["GLOBAL_DAYS"];?></td>
    </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PROC_PSPGRID_COSTS"];?></td>
		<td class="tcell-right-inactive"><?php echo $pspgrid->setting_currency;?> <span id="procPspgridCosts"><?php echo $pspgrid->tcosts;?></span></td>
    </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($pspgrid->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="procsowner" append="0"><span><?php echo $lang["PROC_PSPGRID_OWNER"];?></span></span></td>
	  <td class="tcell-right"><div id="procsowner" class="itemlist-field"><?php echo($pspgrid->owner);?></div><div id="procsowner_ct" class="itemlist-field"><a field="procsowner_ct" class="ct-content"><?php echo($pspgrid->owner_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($pspgrid->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="procsmanagement" append="1"><span><?php echo $lang["PROC_PSPGRID_MANAGEMENT"];?></span></span></td>
	  <td class="tcell-right"><div id="procsmanagement" class="itemlist-field"><?php echo($pspgrid->management);?></div><div id="procsmanagement_ct" class="itemlist-field"><a field="procsmanagement_ct" class="ct-content"><?php echo($pspgrid->management_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($pspgrid->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="procsteam" append="1"><span><?php echo $lang["PROC_PSPGRID_TEAM"];?></span></span></td>
    <td class="tcell-right"><div id="procsteam" class="itemlist-field"><?php echo($pspgrid->team);?></div><div id="procsteam_ct" class="itemlist-field"><a field="procsteam_ct" class="ct-content"><?php echo($pspgrid->team_ct);?></a></div></td>
  </tr>
</table>
<div class="content-spacer"></div>
<table cellspacing="0" cellpadding="0" border="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span <?php if($pspgrid->canedit) { ?>id="procs-pspgrid-add-column"<?php } ?> class="<?php if($pspgrid->canedit) { ?>content-nav<?php } ?>"><span><?php echo $lang["PROC_PSPGRID_COLUMN_NEW"];?></span></span></td>
    <td class="tcell-right">
    <table border="0" cellspacing="0" cellpadding="0" class="timeline-legend">
    <tr>
        <td class="barchart_color_planned"><span><?php echo $lang["GLOBAL_STATUS_PLANNED"];?></span></td>
        <td width="15"></td>
        <td class="barchart_color_inprogress"><span><?php echo $lang["GLOBAL_STATUS_INPROGRESS"];?></span></td>
         <td width="15"></td>
        <td class="barchart_color_finished"><span><?php echo $lang["GLOBAL_STATUS_FINISHED"];?></span></td>
    </tr>
</table>
    </td>
    </tr>
</table>
<div class="content-spacer"></div>
<?php 
$showCoPopup = '';
if($pspgrid->canedit) { 
	$showCoPopup = 'showCoPopup';
?>
	<div id="procs-console-pspgrids">
		<div class="widget-head">
        	<a class="collapse">COLLAPSE</a>
            <h3><?php echo $lang['PROC_PSPGRID_NOTES'];?></h3>
        </div>
        <div id="procs-console-pspgrids-notes">
    	<?php 
		foreach($console_items as $item){ 
		echo '<div rel="'.$item["id"].'" class="droppable '.$showCoPopup.' planned" request="note">';
		echo '<div class="itemTitle">'.$item["title"].'</div>';
		echo '<div class="light">';
		echo '<div class="itemMilestone">0</div>';
		echo '<div class="itemText">' . $item["text"] . '</div>';
		echo '<div class="itemTeamprint"></div>';
		echo '<div class="colTotals"><span class="totaldays">0</span> <span>' . $lang['PROC_PSPGRID_DAYS'] . '</span> - <span>'.$pspgrid->setting_currency.'</span> <span class="totalcosts">0</span></div>';
		echo '<div class="itemTeam"></div>';
		echo '<div class="itemCostsEmployees costs">0</div>';
		echo '<div class="itemCostsMaterials costs">0</div>';
		echo '<div class="itemCostsExternal costs">0</div>';
		echo '<div class="itemCostsOther costs">0</div>';
		echo '<div class="itemTotals"><div class="left"><span class="days"> 0</span> <span>' . $lang['PROC_PSPGRID_DAYS'] . '</span></div><div class="right"><span>'.$pspgrid->setting_currency.'</span> <span class="itemcosts">0</span></div></div>';
		echo '<div class="itemTeamct"><a class="ct-content" field="itemTeamct coPopup-team_ct"></a></div>';
		echo '<div class="itemStatus">0</div>';
		echo '</div></div>';
		 } ?>
        </div>
	</div>
<?php } ?>
<div class="content-spacer"></div>
<div style="position: absolute; top: <?php if($pspgrid->canedit) { echo '184'; } else { echo '224';} ?>px; height: 75px; width: 100%; background: #b2b2b2;"></div>
<div id="procs-pspgrid" style="width: <?php echo($pspgrid->pspgrid_width);?>px;">
<?php 
$drag = '';
$procsphase = '';
if($pspgrid->canedit) {
	$drag = 'drag';
	$procsphase = 'procs-phase';
}
foreach($cols as $key => &$value){ 
	echo '<div id="pspgridscol_'.$cols[$key]['id'].'">';
			if($pspgrid->canedit) {
		echo '<div class="dragCol dragColActive"><div class="procs-pspgrid-column-delete" id="procs-pspgrid-col-delete-'.$cols[$key]['id'].'"><span class="icon-delete"></span></div></div>';
	} else {
		echo '<div class="dragCol"></div>';
	}
		echo '<div class="procs-col-title">';
		if($cols[$key]['titletext'] != "") {
			echo '<div id="procspspgriditem_'.$cols[$key]['titleid'].'" rel="'.$cols[$key]['titleid'].'" class="droppable '.$showCoPopup.' colTitle ' . $cols[$key]['status'] . '" request="title">';
			echo '<div class="itemTitle">'.$cols[$key]['titletext'].'</div>';
			echo '<div class="light">';
			echo '<div class="itemMilestone">0</div>';
			echo '<div class="itemText">' . $cols[$key]['titletextcontent'] . '</div>';
			echo '<div class="itemTeamprint">' . $cols[$key]['titleteamprint'] . '</div>';
			echo '<div class="colTotals"><div class="left"><span class="totaldays"> ' . $cols[$key]['days'] . '</span> <span>' . $lang['PROC_PSPGRID_DAYS'] . '</span></div><div class="right"><span>'.$pspgrid->setting_currency.'</span> <span class="totalcosts">' . $cols[$key]['costs'] . '</span></div></div>';
			echo '<div class="itemTeam">' . $cols[$key]['titleteam'] . '</div>';
			echo '<div class="itemCostsEmployees costs">' . $cols[$key]['titlecosts_employees'] . '</div>';
			echo '<div class="itemCostsMaterials costs">' . $cols[$key]['titlecosts_materials'] . '</div>';
			echo '<div class="itemCostsExternal costs">' . $cols[$key]['titlecosts_external'] . '</div>';
			echo '<div class="itemCostsOther costs">' . $cols[$key]['titlecosts_other'] . '</div>';
			//echo '<div class="itemDays"><span class="days">' . $cols[$key]['titledays'] . '</span> ' . $lang['PROC_PSPGRID_DAYS'] . '</div>';
			echo '<div class="itemTotals"><div class="left"><span class="days"> ' . $cols[$key]['titledays'] . '</span> <span>' . $lang['PROC_PSPGRID_DAYS'] . '</span></div><div class="right"><span>'.$pspgrid->setting_currency.'</span> <span class="itemcosts">' . $cols[$key]['titlecosts_total'] . '</span></div></div>';
			echo '<div class="itemTeamct"><a class="ct-content" field="coPopup-team_ct">' . $cols[$key]['titleteam_ct'] . '</a></div>';
			echo '<div class="itemStatus">0</div>';
			echo '</div></div>';
		} else {
			if($pspgrid->canedit) {
			echo '<span class="newNoteItem newItemOption newNoteTitle" rel="notetitle"></span>';
			}
		}
		echo '</div><div class="pspgrids-spacer"></div>';
	// listitems
	echo '<div class="' . $procsphase . ' procs-phase-design">';
	
	$newNoteItemClass = ' empty';
	$num_notes = sizeof($cols[$key]["notes"]);
	if($num_notes > 0) {
		$newNoteItemClass = '';
	}
	foreach($cols[$key]["notes"] as $tkey => &$tvalue){ 
		$class = 'planned';
		switch($cols[$key]["notes"][$tkey]['status']) {
			case '0':
				$class = 'planned';
			break;
			case '1':
				$class = 'progress';
			break;
			case '2':
				$class = 'finished';
			break;
		}
		$milestone = '';
		$popup = 'note';
		if($cols[$key]["notes"][$tkey]['milestone'] == 1) {
			$milestone = ' ismilestone';
			$popup = 'ms';
		}
		echo '<div id="procspspgriditem_'.$cols[$key]["notes"][$tkey]['note_id'].'" rel="'.$cols[$key]["notes"][$tkey]['note_id'].'" class="droppable '.$showCoPopup.' ' . $class. '" request="' . $popup . '">';
		echo '<div class="itemTitle">'.$cols[$key]["notes"][$tkey]['title'].'</div>';
		echo '<div class="light' . $milestone . '">';
		echo '<div class="itemMilestone">' . $cols[$key]["notes"][$tkey]['milestone'] . '</div>';
		echo '<div class="itemText">' . $cols[$key]["notes"][$tkey]['text'] . '</div>';
		echo '<div class="itemTeamprint">' . $cols[$key]["notes"][$tkey]['teamprint'] . '</div>';
		echo '<div class="colTotals"><span class="totaldays">0</span> <span>' . $lang['PROC_PSPGRID_DAYS'] . '</span> - <span>'.$pspgrid->setting_currency.'</span> <span class="totalcosts">0</span></div>';
		echo '<div class="itemTeam">' . $cols[$key]["notes"][$tkey]['team'] . '</div>';
		echo '<div class="itemCostsEmployees costs">' . $cols[$key]["notes"][$tkey]['costs_employees'] . '</div>';
		echo '<div class="itemCostsMaterials costs">' . $cols[$key]["notes"][$tkey]['costs_materials'] . '</div>';
		echo '<div class="itemCostsExternal costs">' . $cols[$key]["notes"][$tkey]['costs_external'] . '</div>';
		echo '<div class="itemCostsOther costs">' . $cols[$key]["notes"][$tkey]['costs_other'] . '</div>';
		//echo '<div class="itemDays"><span class="days">' . $cols[$key]["notes"][$tkey]['days'] . '</span> ' . $lang['PROC_PSPGRID_DAYS'] . '</div>';
		echo '<div class="itemTotals"><div class="left"><span class="days"> ' . $cols[$key]["notes"][$tkey]['days'] . '</span> <span>' . $lang['PROC_PSPGRID_DAYS'] . '</span></div><div class="right"><span>'.$pspgrid->setting_currency.'</span> <span class="itemcosts">' . $cols[$key]["notes"][$tkey]['itemcosts'] . '</span></div></div>';
		echo '<div class="itemTeamct"><a class="ct-content" field="itemTeamct coPopup-team_ct">' . $cols[$key]["notes"][$tkey]['team_ct'] . '</a></div>';
		echo '<div class="itemStatus">' . $cols[$key]["notes"][$tkey]['status'] . '</div>';
		echo '</div></div>';
	}
	
	echo '</div>';
if($pspgrid->canedit) {
	echo '<span class="newNoteItem newItemOption newNote' . $newNoteItemClass . '" rel="note"></span><span class="newNoteBlind"></span>';
	}
	echo '</div>';
 } ?>
 </div>
<div class="content-spacer" style="clear: both;"></div>
<div class="content-spacer"></div>
<?php if($pspgrid->perms != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($pspgrid->canedit) { ?>content-nav showDialog<?php } ?>" request="getAccessDialog" field="procspspgrid_access" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></span></td>
        <td class="tcell-right"><div id="procspspgrid_access" class="itemlist-field"><div class="listmember" field="procspspgrid_access" uid="<?php echo($pspgrid->access);?>" style="float: left"><?php echo($pspgrid->access_text);?></div></div><input type="hidden" name="pspgrid_access_orig" value="<?php echo($pspgrid->access);?>" /></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11">Projekterstellung</td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="project_created">
        <?php 
		foreach($projects as $key => &$value) { 
				echo '<div class="text11">Projektordner: ' . $projects[$key]['fid'] . ', ' . $projects[$key]['created_user'] . ', ' . $projects[$key]['created_date'] . '</div>';
		 }
		 
			/*foreach($sendto as $value) { 
			if(!empty($value->who)) {
				echo '<div class="text11 toggleSendTo co-link">' . $value->who . ', ' . $value->date . '</div>' .
				'<div class="SendToContent">' . $lang["GLOBAL_SUBJECT"] . ': ' . $value->subject . '<br /><br />' . nl2br($value->body) . '<br></div>';
			}
		 } */?></div></td>
    </tr>
</table>
<?php } ?>
</form>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo($lang["GLOBAL_FOOTER_STATUS"] . " " . $pspgrid->today);?></td>
    <td class="middle"><?php echo $pspgrid->access_footer;?></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($pspgrid->created_user.", ".$pspgrid->created_date);?></td>
  </tr>
</table>
</div>
<div id="modalDialogProcsPspgrid">
<div class="modalDialogProcsPspgridHeader"><div id="modalDialogProcsPspgridClose"><span class="icon-delete-white"></span></div></div>
<div id="modalDialogProcsPspgridInner">
    <div id="modalDialogProcsPspgridInnerContent">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td valign="top">
    <div class="content-spacer" style="height: 10px;"></div>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="text11" style="width: 136px; padding: 0 15px 2px 0px;"><span class="content-nav ui-datepicker-trigger-action"><span style="padding: 0px 0px 0px 11px;"><?php echo $lang['PROJECT_KICKOFF'];?></span></span></td>
		<td class="tcell-right"><input name="kickoff" type="text" class="input-date datepicker" value="<?php echo(date("d.m.Y"));?>" /></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="text11" style="width: 136px; padding: 0 15px 2px 0px;"><span class="content-nav showDialog" request="getProjectFolderDialog" field="procspspgridprojectsfolder" append="1"><span style="padding: 0px 0px 0px 11px;"><?php echo $lang["PROJECT_FOLDER"];?></span></span></td>
        <td class="tcell-right"><div id="procspspgridprojectsfolder" class="itemlist-field"></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="text11" style="width: 136px; padding: 0 15px 2px 0px;"><span class="content-nav selectTextarea"><span style="padding: 0px 0px 0px 11px;"><?php echo $lang["PROJECT_DESCRIPTION"];?></span></span></td>
        <td class="tcell-right" style="padding: 2px 0 2px 0;"><textarea id="pspgridProtocol" name="protocol" class="elastic" style="background-color: #fff; max-height: 48px;"></textarea></td>
	</tr>
</table>
    <div class="coButton-outer" style="margin: 5px 0 0 11px;"><span class="content-nav actionProcsPspgridsConvert coButton">Erstellen</span></div>
    
    </td>
  </tr>
</table>
</div></div>
</div>
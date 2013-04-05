<div class="table-title-outer">

<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($grid->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["PROC_GRID_TITLE"];?></span></span></td>
    <td><input name="title" type="text" class="title textarea-title" value="<?php echo($grid->title);?>" maxlength="100" /></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($grid->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($grid->id);?>">
<input type="hidden" name="pid" value="<?php echo($grid->pid);?>">

<?php if($grid->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span>Warnung</span></span></strong></td>
		<td class="tcell-right"><strong>Dieser Inhaltsbereich wird aktuell bearbeitet von: <?php echo($grid->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($grid->checked_out_user_email);?>"><?php echo($grid->checked_out_user_email);?></a>, <?php echo($grid->checked_out_user_phone1);?></td>
    </tr>
</table>

<?php } ?>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PROC_GRID_TIME"];?></td>
		<td class="tcell-right-inactive"><span id="procGridDays"><?php echo $grid->grid_days;?></span> <?php echo $lang["GLOBAL_DAYS"];?></td>
    </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($grid->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="procsowner" append="0"><span><?php echo $lang["PROC_GRID_OWNER"];?></span></span></td>
	  <td class="tcell-right"><div id="procsowner" class="itemlist-field"><?php echo($grid->owner);?></div><div id="procsowner_ct" class="itemlist-field"><a field="procsowner_ct" class="ct-content"><?php echo($grid->owner_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($grid->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="procsmanagement" append="1"><span><?php echo $lang["PROC_GRID_MANAGEMENT"];?></span></span></td>
	  <td class="tcell-right"><div id="procsmanagement" class="itemlist-field"><?php echo($grid->management);?></div><div id="procsmanagement_ct" class="itemlist-field"><a field="procsmanagement_ct" class="ct-content"><?php echo($grid->management_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($grid->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="procsteam" append="1"><span><?php echo $lang["PROC_GRID_TEAM"];?></span></span></td>
    <td class="tcell-right"><div id="procsteam" class="itemlist-field"><?php echo($grid->team);?></div><div id="procsteam_ct" class="itemlist-field"><a field="procsteam_ct" class="ct-content"><?php echo($grid->team_ct);?></a></div></td>
  </tr>
</table>
<div class="content-spacer"></div>
<table cellspacing="0" cellpadding="0" border="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span <?php if($grid->canedit) { ?>id="procs-add-column"<?php } ?> class="<?php if($grid->canedit) { ?>content-nav<?php } ?>"><span><?php echo $lang["PROC_GRID_COLUMN_NEW"];?></span></span></td>
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
<?php if($grid->canedit) { ?>
	<div id="procs-console">
		<div class="widget-head">
        	<a class="collapse">COLLAPSE</a>
            <h3><?php echo $lang['PROC_GRID_NOTES'];?></h3>
        </div>
        <div id="procs-console-notes">
    	<?php 
		foreach($console_items as $item){ 
			echo '<div rel="' . $item["id"] . '" class="droppable showCoPopup"><div class="statusItem"></div><div class="itemTitle">' . $item["title"] . '</div><div class="itemText" style="display: none;">' . $item["text"] . '</div></div>';
		 } ?>
        </div>
	</div>
<?php } ?>
<div class="content-spacer"></div>
<div id="procs-grid-outer" style="position: relative"><div style="position: absolute; top: 28px; height: 50px; width: 100%; background: #b2b2b2;"></div>
<div id="procs-grid" style="width: <?php echo($grid->grid_width);?>px;">
<?php 
$drag = '';
$procsphase = '';
if($grid->canedit) {
	$drag = 'drag';
	$procsphase = 'procs-phase';
	$checkbox = '';
} else {
	$checkbox = 'noperm';
}
foreach($cols as $key => &$value){ 
	echo '<div id="gridscol_'.$cols[$key]['id'].'" style="height: ' . $cols[$key]['colheight'] . 'px;">';
			if($grid->canedit) {
		echo '<div class="dragCol dragColActive"><div class="procs-column-delete" id="procs-col-delete-'.$cols[$key]['id'].'"><span class="icon-delete"></span></div></div>';
	} else {
		echo '<div class="dragCol"></div>';
	}
		echo '<div class="procs-col-title ' . $cols[$key]['status'] . '">';
		if($cols[$key]['titletext'] != "") {
			echo '<div id="procsgriditem_'.$cols[$key]['titleid'].'" rel="'.$cols[$key]['titleid'].'" class="droppable showCoPopup colTitle">';
			echo '<div class="statusItem"><input name="" type="checkbox" value="'.$cols[$key]['titleid'].'" class="cbx jNiceHidden" /></div>';
			echo '<div id="procsgriditem-title-'.$cols[$key]['titleid'].'" class="itemTitle ' . $checkbox . '">'.$cols[$key]['titletext'].'</div>';
		echo '<div id="procsgriditem-text-' . $cols[$key]['titleid'] . '" style="display: none;">' . $cols[$key]['titletextcontent'] . '</div></div>';
			//echo '</div>';
		} else {
			if($grid->canedit) {
			echo '<span class="newNoteItem newItemOption newNoteTitle" rel="notetitle"></span>';
			}
		}
		echo '</div><div class="grids-spacer"></div>';
	// listitems
	echo '<div class="' . $procsphase . ' procs-phase-design" style="height: ' . $cols[$key]['listheight'] . 'px;">';
	foreach($cols[$key]["notes"] as $tkey => &$tvalue){ 
		$checked = "";
		if ($cols[$key]["notes"][$tkey]['status'] == 1) {
			$checked = ' checked="checked"';
		}
		echo '<div id="procsgriditem_'.$cols[$key]["notes"][$tkey]['note_id'].'" rel="'.$cols[$key]["notes"][$tkey]['note_id'].'" class="droppable showCoPopup">';
		echo '<div class="statusItem"><input name="" type="checkbox" value="'.$cols[$key]["notes"][$tkey]['note_id'].'" class="cbx jNiceHidden ' . $checkbox . '" ' . $checked . '/></div>';
		echo '<div id="procsgriditem-title-' . $cols[$key]["notes"][$tkey]['note_id'] . '" class="itemTitle ' . $checkbox . '">'.$cols[$key]["notes"][$tkey]['title'].'</div>';
		echo '<div id="procsgriditem-text-' . $cols[$key]["notes"][$tkey]['note_id'] . '" style="display: none;">' . $cols[$key]["notes"][$tkey]['text'] . '</div></div>';
	}
	if($grid->canedit) {
	echo '<span class="newNoteItem newItemOption newNote" rel="note"></span>';
	}
	echo '</div><div class="grids-spacer"></div>';
	echo '<div class="procs-col-footer">';
	
	echo '<div class="procs-col-footer-stagegate">';
		
	$stagegatestatus = "";
	if($cols[$key]['status'] == "finished" ) {
		$stagegatestatus = "active";
	}
	echo '<div class="procs-stagegate   ' . $stagegatestatus . '"></div>';
	echo '<div class="procs-col-stagegate">';
		if($cols[$key]['stagegatetext'] != "") {
			echo '<div id="procsgriditem_'.$cols[$key]['stagegateid'].'" rel="'.$cols[$key]['stagegateid'].'" class="droppable colStagegate showCoPopup">';
			echo '<div class="statusItem"><input name="" type="checkbox" value="'.$cols[$key]['stagegateid'].'" class="cbx jNiceHidden" /></div>';
			echo '<div  id="procsgriditem-title-' . $cols[$key]['stagegateid'] . '" class="itemTitle ' . $checkbox . '">'.$cols[$key]['stagegatetext'].'</div>';
			echo '<div id="procsgriditem-text-' . $cols[$key]['stagegateid'] . '" style="display: none;">' . $cols[$key]['stagegatecontent'] . '</div></div>';
		}  else {
			if($grid->canedit) {
			echo '<span class="newNoteItem newItemOption newNoteStagegate" rel="stagegate"></span>';
			}
		}
		echo '</div>';
		echo '</div>';
		echo '<div class="grids-spacer"></div>';
		echo '<div class="procs-col-footer-days" style=" height: 25px; background: #666; border-top: 1px solid #fff; border-left: 1px solid #fff;">';
		echo '<div></div>';
		echo '</div>';
	echo '</div>';
	echo '</div>';
 } ?>
 </div>
</div>
<div class="content-spacer" style="clear: both;"></div>
<?php if($grid->perms != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($grid->canedit) { ?>content-nav showDialog<?php } ?>" request="getAccessDialog" field="procsgrid_access" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></span></td>
        <td class="tcell-right"><div id="procsgrid_access" class="itemlist-field"><div class="listmember" field="procsgrid_access" uid="<?php echo($grid->access);?>" style="float: left"><?php echo($grid->access_text);?></div></div><input type="hidden" name="grid_access_orig" value="<?php echo($grid->access);?>" /></td>
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
    <td class="left"><?php echo($lang["GLOBAL_FOOTER_STATUS"] . " " . $grid->today);?></td>
    <td class="middle"><?php echo $grid->access_footer;?></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($grid->created_user.", ".$grid->created_date);?></td>
  </tr>
</table>
</div>
<div id="modalDialogProcsGrid">
<div class="modalDialogProcsGridHeader"><div id="modalDialogProcsGridClose"><span class="icon-delete-white"></span></div></div>
<div id="modalDialogProcsGridInner">
    <div id="modalDialogProcsGridInnerContent">
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
	  <td class="text11" style="width: 136px; padding: 0 15px 2px 0px;"><span class="content-nav showDialog" request="getProjectFolderDialog" field="procsgridprojectsfolder" append="1"><span style="padding: 0px 0px 0px 11px;"><?php echo $lang["PROJECT_FOLDER"];?></span></span></td>
        <td class="tcell-right"><div id="procsgridprojectsfolder" class="itemlist-field"></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="text11" style="width: 136px; padding: 0 15px 2px 0px;"><span class="content-nav selectTextarea"><span style="padding: 0px 0px 0px 11px;"><?php echo $lang["PROJECT_DESCRIPTION"];?></span></span></td>
        <td class="tcell-right" style="padding: 2px 0 2px 0;"><textarea id="gridProtocol" name="protocol" class="elastic" style="background-color: #fff; max-height: 48px;"></textarea></td>
	</tr>
</table>
    <div class="coButton-outer" style="margin: 5px 0 0 11px;"><span class="content-nav actionProcsGridsConvert coButton">Erstellen</span></div>
    
    </td>
  </tr>
</table>
</div></div>
</div>
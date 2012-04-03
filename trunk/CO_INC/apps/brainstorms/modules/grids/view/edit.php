<div class="table-title-outer">

<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($grid->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["BRAINSTORM_GRID_TITLE"];?></span></span></td>
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
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_DURATION"];?></td>
		<td class="tcell-right-inactive"><span id="brainstormGridDays"><?php echo $grid->grid_days;?></span> <?php echo $lang["GLOBAL_DAYS"];?></td>
    </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($grid->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="brainstormsowner" append="0"><span><?php echo $lang["BRAINSTORM_GRID_OWNER"];?></span></span></td>
	  <td class="tcell-right"><div id="brainstormsowner" class="itemlist-field"><?php echo($grid->owner);?></div><div id="brainstormsowner_ct" class="itemlist-field"><a field="brainstormsowner_ct" class="ct-content"><?php echo($grid->owner_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($grid->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="brainstormsmanagement" append="1"><span><?php echo $lang["BRAINSTORM_GRID_MANAGEMENT"];?></span></span></td>
	  <td class="tcell-right"><div id="brainstormsmanagement" class="itemlist-field"><?php echo($grid->management);?></div><div id="brainstormsmanagement_ct" class="itemlist-field"><a field="brainstormsmanagement_ct" class="ct-content"><?php echo($grid->management_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($grid->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="brainstormsteam" append="1"><span><?php echo $lang["BRAINSTORM_GRID_TEAM"];?></span></span></td>
    <td class="tcell-right"><div id="brainstormsteam" class="itemlist-field"><?php echo($grid->team);?></div><div id="brainstormsteam_ct" class="itemlist-field"><a field="brainstormsteam_ct" class="ct-content"><?php echo($grid->team_ct);?></a></div></td>
  </tr>
</table>
<div class="content-spacer"></div>
<table cellspacing="0" cellpadding="0" border="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span <?php if($grid->canedit) { ?>id="brainstorms-add-column"<?php } ?> class="<?php if($grid->canedit) { ?>content-nav<?php } ?>"><span><?php echo $lang["BRAINSTORM_GRID_COLUMN_NEW"];?></span></span></td>
    <td class="tcell-right">
    <table border="0" cellspacing="0" cellpadding="0" class="timeline-legend">
    <tr>
        <td class="barchart_color_planned"><span><?php echo $lang["BRAINSTORM_GRID_STATUS_PLANED"];?></span></td>
        <td width="15"></td>
        <td class="barchart_color_inprogress"><span><?php echo $lang["BRAINSTORM_GRID_STATUS_INPROGRESS"];?></span></td>
         <td width="15"></td>
        <td class="barchart_color_finished"><span><?php echo $lang["BRAINSTORM_GRID_STATUS_FINISHED"];?></span></td>
    </tr>
</table>
    </td>
    </tr>
</table>
<?php if($grid->canedit) { ?>
	<div id="brainstorms-console">
		<div class="widget-head">
        	<a class="collapse">COLLAPSE</a>
            <h3><?php echo $lang['BRAINSTORM_GRID_NOTES'];?></h3>
        </div>
        <div id="brainstorms-console-notes">
    	<?php 
		foreach($console_items as $item){ 
			echo '<div rel="' . $item["id"] . '" class="droppable"><div class="statusItem"></div><div class="itemTitle">' . $item["title"] . '</div><div class="dragItem"></div></div>';
		 } ?>
        </div>
	</div>
<?php } ?>
<div class="content-spacer"></div>
<div id="brainstorms-grid-outer">
<div id="brainstorms-grid" style="height: <?php echo($colheight);?>px; width: <?php echo($grid->grid_width);?>px;">

<?php 
$drag = '';
$brainstormsphase = '';
if($grid->canedit) {
	$drag = 'drag';
	$brainstormsphase = 'brainstorms-phase';
	$checkbox = '';
} else {
	$checkbox = 'noperm';
}
//print_r($cols);
foreach($cols as $key => &$value){ 
	echo '<div id="gridscol_'.$cols[$key]['id'].'" style="height: ' . $colheight . 'px;">';
	//echo '<h3 class="ui-widget-header">
			if($grid->canedit) {
		echo '<div class="dragCol dragColActive"><div class="brainstorms-column-delete" id="brainstorms-col-delete-'.$cols[$key]['id'].'"><span class="icon-delete"></span></div></div>';
	} else {
		echo '<div class="dragCol"></div>';
	}
		echo '<div class="brainstorms-col-title ' . $cols[$key]['status'] . '">';
		if($cols[$key]['titletext'] != "") {
			echo '<div id="item_'.$cols[$key]['titleid'].'" rel="'.$cols[$key]['titleid'].'" class="droppable colTitle">';
			echo '<div class="statusItem"><input name="" type="checkbox" value="'.$cols[$key]['titleid'].'" class="cbx jNiceHidden" /></div>';
			echo '<div class="itemTitle ' . $checkbox . '">'.$cols[$key]['titletext'].'</div>';
			if($grid->canedit) {
				echo '<div class="dragItem"></div>';
			}
			echo '</div>';
		} else {
			if($grid->canedit) {
			echo '<span class="newNoteItem newNoteTitle"></span>';
			}
		}
		echo '</div><div class="grids-spacer"></div>';

	echo '<div class="' . $brainstormsphase . ' brainstorms-phase-design" style="height: ' . $listheight . 'px;">';
	foreach($cols[$key]["notes"] as $tkey => &$tvalue){ 
		$checked = "";
		if ($cols[$key]["notes"][$tkey]['status'] == 1) {
			$checked = ' checked="checked"';
		}
		echo '<div id="item_'.$cols[$key]["notes"][$tkey]['note_id'].'" rel="'.$cols[$key]["notes"][$tkey]['note_id'].'" class="droppable">';
		echo '<div class="statusItem"><input name="" type="checkbox" value="'.$cols[$key]["notes"][$tkey]['note_id'].'" class="cbx jNiceHidden ' . $checkbox . '" ' . $checked . '/></div>';
		echo '<div class="itemTitle  ' . $checkbox . '">'.$cols[$key]["notes"][$tkey]['title'].'</div>';
		if($grid->canedit) {
			echo '<div class="dragItem"></div>';
		}
		echo '</div>';
	}
	if($grid->canedit) {
	echo '<span class="newNoteItem newNote"></span>';
	}
	echo '</div><div class="grids-spacer"></div>';
	echo '<div class="brainstorms-col-footer">';
	
	echo '<div class="brainstorms-col-footer-stagegate">';
		
	$stagegatestatus = "";
	if($cols[$key]['status'] == "finished" ) {
		$stagegatestatus = "active";
	}
	echo '<div class="brainstorms-stagegate   ' . $stagegatestatus . '"></div>';

	echo '<div class="brainstorms-col-stagegate">';
		if($cols[$key]['stagegatetext'] != "") {
			echo '<div id="item_'.$cols[$key]['stagegateid'].'" rel="'.$cols[$key]['stagegateid'].'" class="droppable colStagegate">';
			echo '<div class="statusItem"><input name="" type="checkbox" value="'.$cols[$key]['stagegateid'].'" class="cbx jNiceHidden" /></div>';
			echo '<div class="itemTitle ' . $checkbox . '">'.$cols[$key]['stagegatetext'].'</div>';
			if($grid->canedit) {
				echo '<div class="dragItem"></div>';
			}
			echo '</div>';
		}  else {
			if($grid->canedit) {
			echo '<span class="newNoteItem newNoteStagegate"></span>';
			}
		}

		echo '</div>';
		echo '</div>';
		echo '<div class="brainstorms-col-footer-days">';
		echo '<div><input class="colDays ' . $checkbox . '" name="" type="text" value="'.$cols[$key]['coldays'].'" size="3" maxlength="3" style="margin" /></div>';
		echo '</div>';
		
	echo '</div>';
	echo '</div>';
	
	
 } ?>

 </div>
  <div id="brainstorms-notes-outer" class="brainstorms-notes-outer">
      <div id="brainstorms-grid-note" class="note note-design" style="width: 203px; height: 150px; display: none;">
        <h3 id="note-header">
        <div id="brainstorms-grid-note-title" class="note-title note-title-design"></div>
        <div id="brainstorms-grid-note-info" class="brainstormsNoteInfo coTooltip" style="position: absolute; top: 8px; right: 28px; width: 15px; height: 15px; cursor: pointer;"><span class="icon-info"></span>
        	<div style="display: none" class="coTooltipHtml" id="brainstorms-grid-note-info-content"></div>
        </div>
        <div id="brainstorms-grid-note-save" style="position: absolute; top: 9px; right: 10px; width: 15px; height: 15px; cursor: pointer;"><a rel="" class="binItem"><span class="icon-delete"></span></a></div>
        </h3>
        <div id="brainstorms-grid-note-text" class="note-text note-text-design" style="height: 110px;"></div>
	</div>
    </div>
</div>

<div class="content-spacer" style="clear: both;"></div>
<?php if($grid->perms != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($grid->canedit) { ?>content-nav showDialog<?php } ?>" request="getAccessDialog" field="brainstormsgrid_access" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></span></td>
        <td class="tcell-right"><div id="brainstormsgrid_access" class="itemlist-field"><div class="listmember" field="brainstormsgrid_access" uid="<?php echo($grid->access);?>" style="float: left"><?php echo($grid->access_text);?></div></div><input type="hidden" name="grid_access_orig" value="<?php echo($grid->access);?>" /></td>
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
				echo '<div class="text11 toggleSendTo">' . $value->who . ', ' . $value->date . '</div>' .
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
<div id="modalDialogBrainstormsGrid" style="z-index: 200; position: absolute; bottom: 0; width: 100%; height: 170px; background-color: #e5e5e5; display: none;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td valign="top">
    <div style="height: 22px; background-color: #999;"></div>
    <div class="content-spacer"></div>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="content-nav ui-datepicker-trigger-action"><span><?php echo $lang['PROJECT_KICKOFF'];?></span></span></td>
		<td class="tcell-right"><input name="kickoff" type="text" class="input-date datepicker" value="<?php echo(date("d.m.Y"));?>" /></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="content-nav showDialog" request="getProjectFolderDialog" field="brainstormsgridprojectsfolder" append="1"><span><?php echo $lang["PROJECT_FOLDER"];?></span></span></td>
        <td class="tcell-right"><div id="brainstormsgridprojectsfolder" class="itemlist-field"></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left text11" style="padding: 4px 15px 4px 0;"><span class="content-nav selectTextarea"><span><?php echo $lang["PROJECT_DESCRIPTION"];?></span></span></td>
        <td class="tcell-right" style="padding: 6px 0 2px 0;"><textarea id="gridProtocol" name="protocol" class="elastic" style="background-color: #fff; max-height: 54px;"></textarea></td>
	</tr>
</table>
    <div class="coButton-outer" style="margin: 0 0 0 150px;"><span class="content-nav actionBrainstormsGridsConvert coButton">erstellen</span></div>
    
    </td>
  	<td width="40" valign="top"><div id="modalDialogBrainstormsGridClose" style="height: 17px; padding-top: 5px; background-color: #999; cursor: pointer;"><span class="icon-toggle-down"></span></div></td>
  </tr>
</table>


</div>
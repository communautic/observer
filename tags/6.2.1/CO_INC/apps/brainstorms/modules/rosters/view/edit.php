<div class="table-title-outer">

<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($roster->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["BRAINSTORM_ROSTER_TITLE"];?></span></span></td>
    <td><input name="title" type="text" class="title textarea-title" value="<?php echo($roster->title);?>" maxlength="100" /></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($roster->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($roster->id);?>">
<input type="hidden" name="pid" value="<?php echo($roster->pid);?>">

<?php if($roster->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span>Warnung</span></span></strong></td>
		<td class="tcell-right"><strong>Dieser Inhaltsbereich wird aktuell bearbeitet von: <?php echo($roster->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($roster->checked_out_user_email);?>"><?php echo($roster->checked_out_user_email);?></a>, <?php echo($roster->checked_out_user_phone1);?></td>
    </tr>
</table>

<?php } ?>

<table cellspacing="0" cellpadding="0" border="0" class="table-content">
	<tbody><tr>
		<td class="tcell-left text11"><span <?php if($roster->canedit) { ?>id="brainstorms-add-column"<?php } ?> class="<?php if($roster->canedit) { ?>content-nav<?php } ?>"><span><?php echo $lang["BRAINSTORM_ROSTER_COLUMN_NEW"];?></span></span></td>
    <td class="tcell-right">&nbsp;</td>
    </tr>
</tbody></table>
<div id="brainstorms-roster-outer">
<?php if($roster->canedit) { ?>
	<div id="brainstorms-console">
		<h3 class="ui-widget-header"><?php echo $lang['BRAINSTORM_ROSTER_NOTES'];?></h3>
    	<div id="brainstorms-console-notes">
    	<?php 
		foreach($console_items as $item){ 
			echo '<div rel="' . $item["id"] . '"><span>' . $item["title"] . '</span></div>';
		 } ?>
    	</div>
	</div>
<?php } ?>
<div id="brainstorms-roster" style="width: <?php echo($roster->roster_width);?>px">

<?php 
$drag = '';
$brainstormsphase = '';
if($roster->canedit) {
	$drag = 'drag';
	$brainstormsphase = 'brainstorms-phase';
}
//print_r($cols);
foreach($cols as $key => &$value){ 
	echo '<div id="brainstormscol_'.$cols[$key]['id'].'" style="height: ' . $colheight . 'px" class="' . $drag . '">';
	echo '<h3 class="ui-widget-header">';
	if($roster->canedit) {
		echo '<div class="brainstorms-column-delete" id="brainstorms-col-delete-'.$cols[$key]['id'].'"><span class="icon-delete"></span></div>';
	}
	echo '</h3>';
	echo '<div class="' . $brainstormsphase . ' brainstorms-phase-design">';
	$i = 0;
	foreach($cols[$key]["notes"] as $tkey => &$tvalue){ 
		$ms = '';
		if($i != 0 && $cols[$key]["notes"][$tkey]['ms'] == "1") {
			$ms = '<span class="icon-milestone"></span>';
		}
		echo '<div id="item_'.$cols[$key]["notes"][$tkey]['note_id'].'"><span>'.$cols[$key]["notes"][$tkey]['title'].'</span>'.$ms;
		if($roster->canedit) {
		echo '<div class="binItem-Outer"><a class="binItem" rel="'.$cols[$key]["notes"][$tkey]['note_id'].'"><span class="icon-delete"></span></a></div>';
		}
		echo '</div>';
		$i++;
	}
	echo '</div></div>';
 } ?>

 </div>
  <div id="brainstorms-notes-outer" class="brainstorms-notes-outer">
      <div id="note" class="note" style="width: 200px; height: 200px; font-size: 11px; display: none;">
        <h3 id="note-header" class="ui-widget-header">
        <div id="note-title" class="note-title"></div>
        <div id="note-info" class="brainstormsNoteInfo coTooltip" style="position: absolute; top: 0px; right: 28px; width: 15px; height: 15px; cursor: pointer;"><span class="icon-info"></span>
        	<div style="display: none" class="coTooltipHtml" id="note-info-content"></div>
        </div>
        <div id="ms-toggle" style="position: absolute; top: 2px; right: 6px; width: 15px; height: 15px; cursor: pointer;"><span id="note-milestone" class="toggleMilestone icon-milestone"></span></div>
        <!--<div id="note-save" style="position: absolute; top: 1px; right: 6px; width: 15px; height: 15px; cursor: pointer;"><a rel="" class="closeItem"><span class="icon-delete-white"></span></a></div>-->
        </h3>
        <div id="note-text" class="note-text" style="height: 165px;"></div>
	</div>
    </div>
</div>

<div class="content-spacer" style="clear: both;"></div>
<?php if($roster->perms != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($roster->canedit) { ?>content-nav showDialog<?php } ?>" request="getAccessDialog" field="brainstormsroster_access" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></span></td>
        <td class="tcell-right"><div id="brainstormsroster_access" class="itemlist-field"><div class="listmember" field="brainstormsroster_access" uid="<?php echo($roster->access);?>" style="float: left"><?php echo($roster->access_text);?></div></div><input type="hidden" name="roster_access_orig" value="<?php echo($roster->access);?>" /></td>
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
    <td class="left"><?php echo($lang["GLOBAL_FOOTER_STATUS"] . " " . $roster->today);?></td>
    <td class="middle"><?php echo $roster->access_footer;?></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($roster->created_user.", ".$roster->created_date);?></td>
  </tr>
</table>
</div>
<div id="modalDialogRoster" style="z-index: 200; position: absolute; bottom: 0; width: 100%; height: 170px; background-color: #FFF6B5; display: none;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td valign="top">
    <div style="height: 22px; background-color: #77713D;"></div>
    <div class="content-spacer"></div>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="content-nav ui-datepicker-trigger-action"><span><?php echo $lang['PROJECT_KICKOFF'];?></span></span></td>
		<td class="tcell-right"><input name="kickoff" type="text" class="input-date datepicker" value="<?php echo(date("d.m.Y"));?>" /></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="content-nav showDialog" request="getProjectFolderDialog" field="rosterprojectsfolder" append="1"><span><?php echo $lang["PROJECT_FOLDER"];?></span></span></td>
        <td class="tcell-right"><div id="rosterprojectsfolder" class="itemlist-field"></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11"><span class="content-nav selectTextarea"><span><?php echo $lang["PROJECT_DESCRIPTION"];?></span></span></td>
        <td class="tcell-right"><textarea id="rosterProtocol" name="protocol" class="elastic" style="background-color: #fff; max-height: 54px;"></textarea></td>
	</tr>
</table>
    <div class="coButton-outer" style="margin: 0 0 0 150px;"><span class="content-nav actionBrainstormsRostersConvert coButton">erstellen</span></div>
    
    </td>
  	<td width="40" valign="top"><div id="modalDialogBrainstormsRosterClose" style="height: 17px; padding-top: 5px; background-color: #77713D; cursor: pointer;"><span class="icon-toggle"></span></div></td>
  </tr>
</table>


</div>
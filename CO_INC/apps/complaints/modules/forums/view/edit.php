<div class="table-title-outer">
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($forum->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["COMPLAINT_FORUM_TITLE"];?></span></span></td>
    <td><input name="title" type="text" class="title textarea-title" value="<?php echo($forum->title);?>" maxlength="100" /></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($forum->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($forum->id);?>">
<input type="hidden" name="pid" value="<?php echo($forum->pid);?>">
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_DURATION"];?></td>
		<td class="tcell-right-inactive"><span id="complaints_forumstartdate"><?php echo($forum->startdate);?></span> - <span id="complaints_forumsenddate"><?php echo($forum->enddate);?></span>
        </td>
    </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($forum->canedit) { ?>content-nav showDialog<?php } ?>" request="getForumStatusDialog" field="complaintsstatus" append="1"><span><?php echo $lang["GLOBAL_STATUS"];?></span></span></td>
        <td class="tcell-right"><div id="complaintsforum_status" class="itemlist-field"><div class="listmember" field="complaintsforum_status" uid="<?php echo($forum->status);?>" style="float: left"><?php echo($forum->status_text);?></div></div><input name="forum_status_date" type="text" class="input-date datepicker forum_status_date" value="<?php echo($forum->status_date)?>" style="float: left; margin-left: 8px;" /></td>
	</tr>
</table>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
  <tr>
    <td class="tcell-left-100 text11"><span class="<?php if($forum->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["FORUM_QUESTION"];?></span></span></td>
      	<td width="35" style="padding-top: 3px;"><?php if($forum->canedit) { ?><a class="openReplyWindow" rel="0" title="antworten"><span class="icon-reply"></span></a><?php } ?></td>
    <td class="tcell-right"><?php if($forum->canedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($forum->protocol));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($forum->protocol)));?><?php } ?></td>
  	<td width="30">&nbsp;</td>
  </tr>
</table>
<?php 
$showAnswer = ' style="display: none"';
if(isset($answers) && !empty($answers)) { 
	$showAnswer = ' style="display: block"';
}
?>
<table id="complaintsForumsAnswerOuter" <?php echo($showAnswer);?> border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
  <tr>
    <td class="tcell-left-inactive text11"><?php echo $lang["FORUM_ANSWERS"];?></td>
    <td class="tcell-right">
	<div id="complaintsForumsAnswer"><?php
foreach($answers as $answer) { 
	echo '<div id="complaintsForumsAnswer_' . $answer->id . '">' .  nl2br($answer->text) . '</div>';
}
?></div></td>
  </tr>
</table>
<div class="content-spacer"></div>
<table cellspacing="0" cellpadding="0" border="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["FORUM_DISCUSSION"];?></td>
    </tr>
</table>
<div id="complaintsForumsPosts">
<?php 

$postspacer = 0;

function showChildren($children,$perm) {
	global $postspacer;

	foreach($children as $child) {
			$postspacer = 15;
			$checked = '';
			$postdellink = '';
			$postdelclass = 'icon-delete';
			if($child->status == 1) {
				$checked = ' checked="checked"';
			}
			echo '<div id="complaintsForumsPostouter_' . $child->id . '" style="margin-left: ' . $postspacer . 'px; overflow: hidden">';
			if(isset($child->children) && !empty($child->children)) {
				$postdellink = ' deactivated';
				$postdelclass = 'icon-delete-inactive';
			}
			include("post_child.php");
	if(isset($child->children) && !empty($child->children)) {
		showChildren($child->children,$perm);
		} else {
			$postspacer = 0;
		}
		echo '</div>';
	}
}
$p = sizeof($posts);
$i = 1;
foreach($posts as $post) { 
	$checked = '';
	$postdellink = '';
	$postdelclass = 'icon-delete';
	if($post->status == 1) {
		$checked = ' checked="checked"';
	}
	echo '<div id="complaintsForumsPostouter_' . $post->id . '" class="parent" style="overflow: hidden; border-top: 1px solid #7f7f7f">';
	if(isset($post->children) && !empty($post->children)) {
		$postdellink = ' deactivated';
				$postdelclass = 'icon-delete-inactive';
	}
	include("post.php");
	if(isset($post->children) && !empty($post->children)) {
		showChildren($post->children,$forum->canedit);
	} else {
	$postspacer = 0;
	}
	echo '</div>';
	//if($i < $p) {
	echo '<div style="height: 20px;"></div>';
	//}
	$i++;
} ?>
</div>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($forum->canedit) { ?>content-nav showDialog<?php } ?>" request="getAccessDialog" field="complaintsforum_access" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></span></td>
        <td class="tcell-right"><div id="complaintsforum_access" class="itemlist-field"><div class="listmember" field="complaintsforum_access" uid="<?php echo($forum->access);?>" style="float: left"><?php echo($forum->access_text);?></div></div><input type="hidden" name="forum_access_orig" value="<?php echo($forum->access);?>" /></td>
	</tr>
</table>
</form>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($forum->edited_user.", ".$forum->edited_date)?></td>
    <td class="middle"><?php echo $forum->access_footer;?></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($forum->created_user.", ".$forum->created_date);?></td>
  </tr>
</table>
</div>
<div id="modalDialogComplaintsForumsPost" style="border: 1px solid #6496DB; position: absolute; bottom: 0; width: 100%; height: 122px; background-color: #DCD2FF; display: none;">
<input type="hidden" class="forumsReplyID" />
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td width="136" valign="top">
    <div style="height: 22px; background-color: #999;"></div>
    <div style="height: 70px;"></div>
    <div class="coButton-outer"><span class="content-nav postReply coButton">Antworten</span></div>
    
    </td>
    <td valign="top"><textarea class="forumsReplyText" name="forumsReplyText" style="width: 100%; height: 100px; "></textarea>
    </td>
  	<td width="40" valign="top"><div class="closeReplyWindow" style="height: 17px; padding-top: 5px; background-color: #999; cursor: pointer;"><span class="icon-toggle-blue"></span></div></td>
  </tr>
</table>
</div>
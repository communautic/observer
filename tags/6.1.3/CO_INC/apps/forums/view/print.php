<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["FORUM_TITLE"];?></td>
        <td><strong><?php echo($forum->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["GLOBAL_DURATION"];?></td>
		<td><?php echo($forum->startdate)?> - <?php echo($forum->enddate)?></td>
    </tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["FORUM_FOLDER"];?></td>
        <td><?php echo($forum->folder);?></td>
	</tr>
</table>
<table width="100%" class="standard">
    <tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($forum->status_text);?> <?php echo($forum->status_date)?></td>
	</tr>
</table>
&nbsp;
<?php if(!empty($forum->protocol)) { ?>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["FORUM_QUESTION"];?></td>
        <td><?php echo(nl2br($forum->protocol));?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<?php 
$showAnswer = ' style="display: none"';
if(isset($answers) && !empty($answers)) { 
	$showAnswer = ' style="display: block"';
}
?>
<table width="100%" class="grey">
	<tr>
	  <td class="tcell-left"><?php echo $lang["FORUM_ANSWERS"];?></td>
        <td><?php
foreach($answers as $answer) { 
	echo '<div id="answer_' . $answer->id . '">' .  nl2br($answer->text) . '</div>';
}
?></td>
	</tr>
</table>
&nbsp;
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["FORUM_DISCUSSION"];?></td>
		<td>&nbsp;</td>
    </tr>
</table>
<?php 

$postspacer = 0;

function showChildren($children,$perm) {
	global $postspacer;

	foreach($children as $child) {
			$postspacer += 10;
			$img = '&nbsp;';
			if($child->status == 1) {
				$img = '<img src="' . CO_FILES . '/img/print/done.png" width="12" height="12" vspace="2" /> ';
			}
			include("post_child_print.php");
	if(isset($child->children) && !empty($child->children)) {
		showChildren($child->children,$perm);
		$postspacer += 10;
		} else {
			$postspacer = 0;
		}
	}
}
$p = sizeof($posts);
$i = 1;
foreach($posts as $post) { 
	$img = '&nbsp;';
	if($post->status == 1) {
		$img = '<img src="' . CO_FILES . '/img/print/done.png" width="12" height="12" vspace="2" /> ';
	}
	include("post_print.php");
	if(isset($post->children) && !empty($post->children)) {
		showChildren($post->children,$forum->canedit);
	} else {
	$postspacer = 0;
	}
	$i++;
} ?>
<div style="page-break-after:always;">&nbsp;</div>
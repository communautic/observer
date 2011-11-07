<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["FORUM_FOLDER"];?></td>
        <td><strong><?php echo($folder->title);?></strong></td>
	</tr>
</table>
&nbsp;
<?php
if(is_array($forums)) {
	$i = 1;
	foreach ($forums as $forum) { 
	?>
<table cellpadding="0" cellspacing="0" width="100%" class="standard">
	<tr>
		<td class="tcell-left-short"><?php if($i == 1) { echo $lang["FORUM_FORUMS"]; }?>&nbsp;</td>
        <td class="short greybg">&nbsp;</td>
		<td class="greybg"><?php echo($forum->title);?></td>
	</tr>
    <tr>
		<td>&nbsp;</td> 
        <td>&nbsp;</td>
		<td class="grey smalltext"><?php echo($forum->status_text . " " . $forum->status_date);?><br />
		<?php echo $lang["FORUM_CREATED_USER"];?> <?php echo($forum->created_user);?>
        <br />&nbsp;
</td>
	</tr>
</table>
    <?php 
	$i++;
	}
}
?>
<div style="page-break-after:always;">&nbsp;</div>
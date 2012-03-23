<table width="100%" class="title grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["COMPLAINT_FORUM_TITLE"];?></td>
        <td><strong><?php echo($forum->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard-grey">
	<tr>
		<td class="tcell-left"><?php echo $lang["COMPLAINT_FORUM_DATE"];?></td>
		<td><?php echo($forum->item_date)?></td>
    </tr>
</table>
<table width="100%" class="standard-grey">
	<tr>
	  <td class="tcell-left"><?php echo $lang["COMPLAINT_FORUM_TIME_START"];?></td>
        <td><?php echo($forum->start);?></td>
	</tr>
</table>
<table width="100%" class="standard-grey">
	<tr>
	  <td class="tcell-left"><?php echo $lang["COMPLAINT_FORUM_TIME_END"];?></td>
        <td><?php echo($forum->end);?></td>
	</tr>
</table>
<table width="100%" class="standard-grey">
    <tr>
	  <td class="tcell-left"><?php echo $lang["COMPLAINT_FORUM_PLACE"];?></td>
        <td><?php echo($forum->location);?></td>
	</tr>
</table>
<?php if(!empty($forum->participants_print) || !empty($forum->participants_ct)) { ?>
<table width="100%" class="standard-grey">
	<tr>
		<td class="tcell-left"><?php echo $lang["COMPLAINT_FORUM_ATTENDEES"];?></td>
		<td><?php echo($forum->participants_print)?><br /><?php echo($forum->participants_ct);?></td>
    </tr>
</table>
<?php } ?>
<?php if(!empty($forum->management_print) || !empty($forum->management_ct)) { ?>
<table width="100%" class="standard-grey">
	<tr>
	  <td class="tcell-left"><?php echo $lang["COMPLAINT_FORUM_MANAGEMENT"];?></td>
        <td><?php echo($forum->management_print);?><br /><?php echo($forum->management_ct);?></td>
	</tr>
</table>
<?php } ?>
<table width="100%" class="standard-grey-paddingBottom">
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($forum->status_text);?> <?php echo($forum->status_date)?></td>
	</tr>
</table>
&nbsp;
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["COMPLAINT_FORUM_GOALS"];?></td>
		<td>&nbsp;</td>
    </tr>
</table>
<?php
$i = 1;
foreach($task as $value) { 
	$img = '&nbsp;';
	if($value->status == 1) {
		$img = '<img src="' . CO_FILES . '/img/print/done.png" width="12" height="12" vspace="2" hspace="4" /> ';
	}
     ?>
    <table width="100%" class="fourCols-grey">
        <tr>
            <td class="fourCols-three greybg"><?php echo $img;?></td>
            <td class="fourCols-four greybg"><strong><?php echo($value->title);?></strong></td>
        </tr>
     </table>
      <?php echo(nl2br($value->text));?>
    <br />&nbsp;
	<?php 
	$i++;
	}
?>
<div style="page-break-after:always;">&nbsp;</div>
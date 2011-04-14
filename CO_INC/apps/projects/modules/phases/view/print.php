<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["PHASE_TITLE"];?></td>
        <td><strong><?php echo($phase->num) ;?>. <?php echo($phase->title);?></strong></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["GLOBAL_DURATION"];?></td>
		<td><?php echo($phase->startdate)?> - <?php echo($phase->enddate)?></td>
    </tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["PROJECT_MANAGEMENT"];?></td>
        <td><?php echo($phase->management);?></td>
	</tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["PHASE_TEAM"];?></td>
        <td><?php echo($phase->team);?></td>
	</tr>
</table>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($phase->status_text);?> <?php echo($phase->status_date)?></td>
	</tr>
</table>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey" style="padding: 10pt 10pt 10pt 10pt;">
	<tr>
        <td class="tcell-left top"><?php echo $lang["PROJECT_DESCRIPTION"];?></td>
        <td><?php echo($phase->protocol);?></td>
	</tr>
</table>
&nbsp;
<?php
$i = 1;
foreach($task as $value) { 
	$img = '&nbsp;';
	$donedate_field = 'display: none';
	$donedate = '';
	if($value->status == 1) {
		$img = '<img src="' . CO_FILES . '/img/print/done.png" width="18" height="18" vspace="2" /> ';
		$donedate_field = '';
		$donedate = $value->donedate;
	}
	
	if($value->cat == 0) { // task
     ?>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
        <tr>
            <td class="tcell-left-short"><?php if($i == 1) { echo $lang["PHASE_TASK_MILESTONE"]; }?>&nbsp;</td>
            <td class="short"><?php echo $img;?></td>
            <td><?php echo($value->text);?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo $lang["GLOBAL_DURATION"];?> <?php echo($value->startdate . " - " . $value->enddate);?>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo $lang["PHASE_TASK_TEAM"];?> <?php echo($value->team . " " . $value->team_ct);?>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo $lang["PHASE_TASK_DEPENDENT"];?> <?php echo($value->dependent_title);?>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo $lang["PROJECT_STATUS_FINISHED"];?> <?php echo($donedate);?>
            </td>
        </tr>
            <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div class="line">&nbsp;</div></td>
        </tr>
    </table>
    <?php } else { // milestone ?>
	    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
        <tr>
            <td class="tcell-left-short"><?php if($i == 1) { echo $lang["PHASE_TASK_MILESTONE"]; }?>&nbsp;</td>
            <td class="short"><?php echo $img;?></td>
            <td><img src="<?php echo(CO_FILES);?>/img/print/milestone.png" width="18" height="18" /> <?php echo($value->text);?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo $lang["PHASE_MILESTONE_DATE"];?> <?php echo($value->startdate);?>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo $lang["PHASE_TASK_DEPENDENT"];?> <?php echo($value->dependent_title);?>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo $lang["PROJECT_STATUS_FINISHED"];?> <?php echo($donedate);?>
            </td>
        </tr>
            <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div class="line">&nbsp;</div></td>
        </tr>
    </table>
	<?php }
	$i++;
	}
?>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["DOCUMENT_DOCUMENTS"];?></td>
        <td><?php echo($phase->documents)?></td>
	</tr>
	<tr>
		<td class="tcell-left"><?php echo $lang["GLOBAL_ACCESS"];?></td>
		<td><?php echo($phase->access_text)?></td>
	</tr>
</table>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard">
    <tr>
		<td class="tcell-left top grey"><?php echo$lang["GLOBAL_EMAILED_TO"];?></td>
		<td><?php 
			foreach($sendto as $value) { 
			echo '<div class="grey">' . $value->who . ', ' . $value->date . '</div>';
		 } ?></td>
	</tr>
</table>
<div style="page-break-after:always;">&nbsp;</div>
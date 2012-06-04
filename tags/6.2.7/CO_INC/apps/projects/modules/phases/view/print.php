<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["PROJECT_PHASE_TITLE"];?></td>
        <td><strong><?php echo($phase->num) ;?>. <?php echo($phase->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["GLOBAL_DURATION"];?></td>
		<td><?php echo($phase->startdate)?> - <?php echo($phase->enddate)?></td>
    </tr>
</table>
<?php if(!empty($phase->management)) { ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PROJECT_MANAGEMENT"];?></td>
        <td><?php echo($phase->management);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($phase->team_print) || !empty($phase->team_ct)) { ?>
<table width="100%" class="standard">
    <tr>
	  <td class="tcell-left"><?php echo $lang["PROJECT_PHASE_TEAM"];?></td>
        <td><?php echo($phase->team_print);?><br /><?php echo($phase->team_ct);?></td>
	</tr>
</table>
<?php } ?>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($phase->status_text);?> <?php echo($phase->status_date)?></td>
	</tr>
</table>
<?php if(!empty($phase->protocol)) { ?>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["PROJECT_DESCRIPTION"];?></td>
        <td><?php echo(nl2br($phase->protocol));?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<?php
$i = 1;
foreach($task as $value) { 
	$img = '&nbsp;';
	$donedate_field = 'display: none';
	$donedate = '';
	if($value->status == 1) {
		$img = '<img src="' . CO_FILES . '/img/print/done.png" width="12" height="12" vspace="2" /> ';
		$donedate_field = '';
		$donedate = $value->donedate;
	}
	
	if($value->cat == 0) { // task
     ?>
    <table width="100%" class="fourCols">
        <tr>
            <td class="fourCols-one"><?php if($i == 1) { echo $lang["PROJECT_PHASE_TASK_MILESTONE"]; }?>&nbsp;</td>
            <td class="fourCols-two"><?php echo $img;?></td>
            <td class="fourCols-three greybg">&nbsp;</td>
            <td class="fourCols-four greybg"><?php echo($value->text);?></td>
        </tr>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext fourCols-paddingTop"><?php echo $lang["GLOBAL_DURATION"];?> <?php echo($value->startdate . " - " . $value->enddate);?></td>
        </tr>
        <?php if(!empty($value->team) || !empty($value->team_ct)) { ?>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext"><?php echo $lang["PROJECT_PHASE_TASK_TEAM"];?> <?php echo($value->team . " " . $value->team_ct);?></td>
        </tr>
        <?php } ?>
        <?php if(!empty($value->dependent_title)) { ?>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext"><?php echo $lang["PROJECT_PHASE_TASK_DEPENDENT"];?> <?php echo($value->dependent_title);?></td>
        </tr>
        <?php } ?>
        <?php if(!empty($donedate)) { ?>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext"><?php echo $lang["PROJECT_STATUS_FINISHED"];?> <?php echo($donedate);?></td>
        </tr>
        <?php } ?>
        <?php if(!empty($value->protocol)) { ?>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td><?php echo(nl2br($value->protocol));?></td>
        </tr>
        <?php } ?>
        
         <tr>
             <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext">&nbsp;</td>
        </tr>
    </table>
    <?php } else { // milestone ?>
	    <table width="100%" class="fourCols">
        <tr>
            <td class="fourCols-one"><?php if($i == 1) { echo $lang["PROJECT_PHASE_TASK_MILESTONE"]; }?>&nbsp;</td>
            <td class="fourCols-two"><?php echo $img;?></td>
            <td class="fourCols-three greybg"><img src="<?php echo(CO_FILES);?>/img/print/milestone.png" width="12" height="12" style="margin: 2px 0 0 3px" /></td>
            <td class="fourCols-four greybg"><?php echo($value->text);?></td>
        </tr>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext fourCols-paddingTop"><?php echo $lang["PROJECT_PHASE_MILESTONE_DATE"];?> <?php echo($value->startdate);?></td>
        </tr>
        <?php if(!empty($value->dependent_title)) { ?>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext"><?php echo $lang["PROJECT_PHASE_TASK_DEPENDENT"];?> <?php echo($value->dependent_title);?></td>
        </tr>
        <?php } ?>
        <?php if(!empty($donedate)) { ?>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext"><?php echo $lang["PROJECT_STATUS_FINISHED"];?> <?php echo($donedate);?></td>
        </tr>
        <?php } ?>
        <?php if(!empty($value->protocol)) { ?>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td><?php echo(nl2br($value->protocol));?></td>
        </tr>
        <?php } ?>
        <tr>
            <td class="fourCols-one">&nbsp;</td>
            <td class="fourCols-two">&nbsp;</td>
            <td class="fourCols-three">&nbsp;</td>
            <td class="grey smalltext">&nbsp;</td>
        </tr>
    </table>
	<?php }
	$i++;
	}
?>
<div style="page-break-after:always;">&nbsp;</div>
<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["TRAINING_TITLE"];?></td>
        <td><strong><?php echo($training->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["GLOBAL_DURATION"];?></td>
		<td><?php echo($training->startdate)?> - <?php echo($training->enddate)?></td>
    </tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['TRAINING_KICKOFF'];?></td>
		<td><?php echo($training->startdate)?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["TRAINING_FOLDER"];?></td>
        <td><?php echo($training->folder);?></td>
	</tr>
</table>
&nbsp;
<?php if(!empty($training->ordered_by_print) || !empty($training->ordered_by_ct)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["TRAINING_CLIENT"];?></td>
		<td><?php echo($training->ordered_by_print);?><br /><?php echo($training->ordered_by_ct);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($training->management_print) || !empty($training->management_ct)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["TRAINING_MANAGEMENT"];?></td>
		<td><?php echo($training->management_print);?><br /><?php echo($training->management_ct);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($training->team_print) || !empty($training->team_ct)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["TRAINING_TEAM"];?></td>
		<td><?php echo($training->team_print);?><br /><?php echo($training->team_ct);?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<?php if(!empty($training->training)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["TRAINING_TRAININGCAT"];?></td>
		<td><?php echo($training->training);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($training->training_more)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["TRAINING_TRAININGCATMORE"];?></td>
		<td><?php echo($training->training_more);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($training->training_cat)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["TRAINING_CAT"];?></td>
		<td><?php echo($training->training_cat);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($training->training_cat_more)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["TRAINING_CAT_MORE"];?></td>
		<td><?php echo($training->training_cat_more);?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<?php if(!empty($training->product)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["TRAINING_PRODUCT_NUMBER"];?></td>
		<td><?php echo($training->product);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($training->product_desc)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["TRAINING_PRODUCT"];?></td>
		<td><?php echo($training->product_desc);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($training->charge)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["TRAINING_CHARGE"];?></td>
		<td><?php echo($training->charge);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($training->number)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["TRAINING_NUMBER"];?></td>
		<td><?php echo($training->number);?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($training->status_text);?> <?php echo($training->status_text_time);?> <?php echo($training->status_date)?></td>
	</tr>
</table>
<?php if(!empty($training->protocol)) { ?>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["TRAINING_DESCRIPTION"];?></td>
        <td><?php echo(nl2br($training->protocol));?></td>
	</tr>
</table>
<?php } ?>
<div style="page-break-after:always;">&nbsp;</div>
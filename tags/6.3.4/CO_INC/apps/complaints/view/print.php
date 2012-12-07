<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["COMPLAINT_TITLE"];?></td>
        <td><strong><?php echo($complaint->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["GLOBAL_DURATION"];?></td>
		<td><?php echo($complaint->startdate)?> - <?php echo($complaint->enddate)?></td>
    </tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang['COMPLAINT_KICKOFF'];?></td>
		<td><?php echo($complaint->startdate)?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["COMPLAINT_FOLDER"];?></td>
        <td><?php echo($complaint->folder);?></td>
	</tr>
</table>
&nbsp;
<?php if(!empty($complaint->ordered_by_print) || !empty($complaint->ordered_by_ct)) { ?>
<table width="100%" class="standard"> 
   <tr>
		<td class="tcell-left"><?php echo $lang["COMPLAINT_CLIENT"];?></td>
		<td><?php echo($complaint->ordered_by_print);?><br /><?php echo($complaint->ordered_by_ct);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($complaint->management_print) || !empty($complaint->management_ct)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["COMPLAINT_MANAGEMENT"];?></td>
		<td><?php echo($complaint->management_print);?><br /><?php echo($complaint->management_ct);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($complaint->team_print) || !empty($complaint->team_ct)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["COMPLAINT_TEAM"];?></td>
		<td><?php echo($complaint->team_print);?><br /><?php echo($complaint->team_ct);?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<?php if(!empty($complaint->complaint)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["COMPLAINT_COMPLAINTCAT"];?></td>
		<td><?php echo($complaint->complaint);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($complaint->complaint_more)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["COMPLAINT_COMPLAINTCATMORE"];?></td>
		<td><?php echo($complaint->complaint_more);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($complaint->complaint_cat)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["COMPLAINT_CAT"];?></td>
		<td><?php echo($complaint->complaint_cat);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($complaint->complaint_cat_more)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["COMPLAINT_CAT_MORE"];?></td>
		<td><?php echo($complaint->complaint_cat_more);?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<?php if(!empty($complaint->product)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["COMPLAINT_PRODUCT_NUMBER"];?></td>
		<td><?php echo($complaint->product);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($complaint->product_desc)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["COMPLAINT_PRODUCT"];?></td>
		<td><?php echo($complaint->product_desc);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($complaint->charge)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["COMPLAINT_CHARGE"];?></td>
		<td><?php echo($complaint->charge);?></td>
	</tr>
</table>
<?php } ?>
<?php if(!empty($complaint->number)) { ?>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["COMPLAINT_NUMBER"];?></td>
		<td><?php echo($complaint->number);?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<table width="100%" class="standard">
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($complaint->status_text);?> <?php echo($complaint->status_text_time);?> <?php echo($complaint->status_date)?></td>
	</tr>
</table>
<?php if(!empty($complaint->protocol)) { ?>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["COMPLAINT_DESCRIPTION"];?></td>
        <td><?php echo(nl2br($complaint->protocol));?></td>
	</tr>
</table>
<?php } ?>
<div style="page-break-after:always;">&nbsp;</div>
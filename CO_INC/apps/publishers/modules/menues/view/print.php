<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
        <td class="tcell-left"><?php echo $lang["PUBLISHER_MENUE_TITLE"];?></td>
        <td><strong><?php echo($menue->title);?></strong></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
		<td class="tcell-left"><?php echo $lang["PUBLISHER_MENUE_DATE"];?></td>
		<td><?php echo($menue->item_date)?></td>
    </tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["PUBLISHER_MENUE_TIME_START"];?></td>
        <td><?php echo($menue->start);?></td>
	</tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["PUBLISHER_MENUE_TIME_END"];?></td>
        <td><?php echo($menue->end);?></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey">
	<tr>
	  <td class="tcell-left"><?php echo $lang["PUBLISHER_MENUE_MANAGEMENT"];?></td>
        <td><?php echo($menue->management);?></td>
	</tr>
	<tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($menue->status_text);?> <?php echo($menue->status_date)?></td>
	</tr>
</table>
&nbsp;
<?php if(!empty($menue->protocol)) { ?>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="grey" style="padding: 10pt 10pt 10pt 15pt;">
	<tr>
        <td class="tcell-left top"><?php echo $lang["PUBLISHER_MENUE_GOALS"];?></td>
        <td><?php echo(nl2br($menue->protocol));?></td>
	</tr>
</table>
<?php } ?>
&nbsp;
<div style="page-break-after:always;">&nbsp;</div>
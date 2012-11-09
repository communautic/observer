<table width="100%"  class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["PUBLISHER_MENUE_TITLE"];?></td>
        <td><strong><?php echo($menue->title);?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PUBLISHER_MENUE_DATE_FROM"];?></td>
		<td><?php echo($menue->item_date_from)?></td>
    </tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PUBLISHER_MENUE_DATE_TO"];?></td>
		<td><?php echo($menue->item_date_to)?></td>
    </tr>
</table>
<?php if(!empty($menue->management) || !empty($menue->management_ct)) { ?>
&nbsp;
<table width="100%" class="standard">
    <tr>
	  <td class="tcell-left"><?php echo $lang["PUBLISHER_MENUE_MANAGEMENT"];?></td>
        <td><?php echo($menue->management);?><br /><?php echo($menue->management_ct);?></td>
	</tr>
</table>
<?php } ?>

<table width="100%" class="standard">
    <tr>
	  <td class="tcell-left"><?php echo $lang["GLOBAL_STATUS"];?></td>
        <td><?php echo($menue->status_text);?> <?php echo($menue->status_text_time);?> <?php echo($menue->status_date)?></td>
	</tr>
</table>
<?php if(!empty($menue->protocol)) { ?>
&nbsp;
<table width="100%" class="protocol">
	<tr>
        <td class="tcell-left top"><?php echo $lang["PUBLISHER_MENUE_GOALS"];?></td>
        <td><?php echo(nl2br($menue->protocol));?></td>
	</tr>
</table>
<?php } ?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="100%" cellpadding="3">
	<tr>
	  <th style="width: 10%">&nbsp;</th>
      <th>Montag</th>
	  <th>Dienstag</th>
       <th>Mittwoch</th>
       <th>Donnerstag</th>
       <th>Freitag</th>
    </tr>
	<tr>
	    <td style="width: 10%">Ki S.</td>
        <td id="mon_1" class="greybg" style="width: 15%; text-align: center"><?php echo nl2br($menue->mon_1);?></td>
	    <td id="tue_1" class="greybg" style="width: 15%; text-align: center"><?php echo nl2br($menue->tue_1);?></td>
	    <td id="wed_1" class="greybg" style="width: 15%; text-align: center"><?php echo nl2br($menue->wed_1);?></td>
	    <td id="thu_1" class="greybg" style="width: 15%; text-align: center"><?php echo nl2br($menue->thu_1);?></td>
	    <td id="fri_1" class="greybg" style="width: 15%; text-align: center"><?php echo nl2br($menue->fri_1);?></td>
	</tr>
	<tr>
    	<td style="width: 10%">Ki</td>
		<td id="mon_2" class="greybg" style="text-align: center"><?php echo nl2br($menue->mon_2);?></td>
        <td id="tue_2" class="greybg" style="text-align: center"><?php echo nl2br($menue->tue_2);?></td>
        <td id="wed_2" class="greybg" style="text-align: center"><?php echo nl2br($menue->wed_2);?></td>
        <td id="thu_2" class="greybg" style="text-align: center"><?php echo nl2br($menue->thu_2);?></td>
        <td id="fri_2" class="greybg" style="text-align: center"><?php echo nl2br($menue->fri_2);?></td>
	</tr>
	<tr>
    	<td style="width: 10%">Erw S.</td>
		<td id="mon_3" class="greybg" style="text-align: center"><?php echo nl2br($menue->mon_3);?></td>
        <td id="tue_3" class="greybg" style="text-align: center"><?php echo nl2br($menue->tue_3);?></td>
        <td id="wed_3" class="greybg" style="text-align: center"><?php echo nl2br($menue->wed_3);?></td>
        <td id="thu_3" class="greybg" style="text-align: center"><?php echo nl2br($menue->thu_3);?></td>
        <td id="fri_3" class="greybg" style="text-align: center"><?php echo nl2br($menue->fri_3);?></td>
	</tr>
	<tr>
    	<td style="width: 10%">Erw I</td>
	    <td id="mon_4" class="greybg" style="text-align: center"><?php echo nl2br($menue->mon_4);?></td>
        <td id="tue_4" class="greybg" style="text-align: center"><?php echo nl2br($menue->tue_4);?></td>
        <td id="wed_4" class="greybg" style="text-align: center"><?php echo nl2br($menue->wed_4);?></td>
        <td id="thu_4" class="greybg" style="text-align: center"><?php echo nl2br($menue->thu_4);?></td>
        <td id="fri_4" class="greybg" style="text-align: center"><?php echo nl2br($menue->fri_4);?></td>
	</tr>
	<tr>
	    <td style="width: 10%">Erw II</td>
        <td id="mon_5" class="greybg" style="text-align: center"><?php echo nl2br($menue->mon_5);?></td>
        <td id="tue_5" class="greybg" style="text-align: center"><?php echo nl2br($menue->tue_5);?></td>
        <td id="wed_5" class="greybg" style="text-align: center"><?php echo nl2br($menue->wed_5);?></td>
        <td id="thu_5" class="greybg" style="text-align: center"><?php echo nl2br($menue->thu_5);?></td>
        <td id="fri_5" class="greybg" style="text-align: center"><?php echo nl2br($menue->fri_5);?></td>
	</tr>
	<tr>
    	<td style="width: 10%">Erw III</td>
	    <td id="mon_6" class="greybg" style="text-align: center"><?php echo nl2br($menue->mon_6);?></td>
        <td id="tue_6" class="greybg" style="text-align: center"><?php echo nl2br($menue->tue_6);?></td>
        <td id="wed_6" class="greybg" style="text-align: center"><?php echo nl2br($menue->wed_6);?></td>
        <td id="thu_6" class="greybg" style="text-align: center"><?php echo nl2br($menue->thu_6);?></td>
        <td id="fri_6" class="greybg" style="text-align: center"><?php echo nl2br($menue->fri_6);?></td>
	</tr>
</table>
<div style="page-break-after:always;">&nbsp;</div>
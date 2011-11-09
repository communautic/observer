<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard" style="margin-top: 90%">
	<tr>
		<td>
			<!--<h1><?php echo $lang["CLIENT_HANDBOOK"];?></h1>-->
			<h2><?php echo($client->title);?></h2>
            &nbsp;
             &nbsp;
            <h3><?php echo $lang["GLOBAL_DURATION"];?>: <?php echo($client->startdate)?> - <?php echo($client->enddate)?></h3>
             <h3><?php echo $lang["GLOBAL_STATUS"];?>: <?php echo($client->status_text);?> <?php echo($client->status_date)?></h3> 
			</td>
	</tr>
</table>
<div style="page-break-after:always;">&nbsp;</div>
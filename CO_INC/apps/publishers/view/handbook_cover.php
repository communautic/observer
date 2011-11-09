<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard" style="margin-top: 90%">
	<tr>
		<td>
			<!--<h1><?php echo $lang["PUBLISHER_HANDBOOK"];?></h1>-->
			<h2><?php echo($publisher->title);?></h2>
            &nbsp;
             &nbsp;
            <h3><?php echo $lang["GLOBAL_DURATION"];?>: <?php echo($publisher->startdate)?> - <?php echo($publisher->enddate)?></h3>
             <h3><?php echo $lang["GLOBAL_STATUS"];?>: <?php echo($publisher->status_text);?> <?php echo($publisher->status_date)?></h3> 
			</td>
	</tr>
</table>
<div style="page-break-after:always;">&nbsp;</div>
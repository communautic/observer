<table border="0" cellpadding="0" cellspacing="0" width="100%" class="standard" style="margin-top: 55%">
	<tr>
		<td>
			<h2><?php echo($project->title);?></h2>
            &nbsp;
             &nbsp;
            <h3><?php echo $lang["GLOBAL_DURATION"];?>: <?php echo($project->startdate)?> - <?php echo($project->enddate)?></h3>
             <h3><?php echo $lang["GLOBAL_STATUS"];?>: <?php echo($project->status_text);?> <?php echo($project->status_date)?></h3> 
			</td>
	</tr>
</table>
<div style="page-break-after:always;">&nbsp;</div>
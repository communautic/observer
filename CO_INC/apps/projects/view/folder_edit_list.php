<?php
if(is_array($projects)) {
	foreach ($projects as $project) { 
	?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive loadProject" rel="<?php echo($project->id);?>">
	<tr>
    	<td class="tcell-left text11" style="white-space: nowrap;">&nbsp;</td>
		<td colspan="4" class="tcell-right"><span class="bold co-link"><?php echo($project->title);?></span></td>
    	</tr>
    <tr>
    	<td class="tcell-left text11" style="white-space: nowrap;">&nbsp;</td>
		<td class="tcell-right" width="220"><span class="text11"><?php echo($project->startdate . " - " . $project->enddate);?></span></td>
    	<td class="tcell-right" width="110"><span class="text11"><span style="display: inline; margin-right: 20px;"></span><?php echo($project->status_text);?></span></td>
        <td class="tcell-right" width="190"><?php if($project->perm != "guest") { ?><span class="text11"><span style="display: inline; margin-right: 20px;"><?php echo $lang["PROJECT_FOLDER_CHART_REALISATION"];?></span><?php echo($project->realisation["real"]);?>%</span><?php } ?></td>
    	<td class="tcell-right"><span class="text11"><span style="display: inline; margin-right: 20px;"><?php echo $lang["PROJECT_MANAGEMENT"];?></span><?php echo($project->management);?></span></td>
    </tr>
</table>
    <?php 
	}
}
?>
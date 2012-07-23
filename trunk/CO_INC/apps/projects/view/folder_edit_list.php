<?php if(is_array($projects)) {
	foreach ($projects as $project) { ?>
    <div class="loadProject listOuter"  rel="<?php echo($project->id);?>">
		<div class="bold co-link listTitle"><?php echo($project->title);?></div>
        <div class="text11 listText"><div><?php echo($project->startdate . " - " . $project->enddate);?> &nbsp; | &nbsp; </div><div><?php echo($project->status_text);?> &nbsp; | &nbsp; </div><?php if($project->perm != "guest") { ?><div><?php echo $lang["PROJECT_FOLDER_CHART_REALISATION"];?> <?php echo($project->realisation["real"]);?>% &nbsp; | &nbsp; </div><?php } ?><div><?php echo $lang["PROJECT_MANAGEMENT"];?> <?php echo($project->management);?></div></div>
        <div class="listItem"><span class="loadPSP co-link" rel="<?php echo($project->id);?>"><div class="text"> PSP</div><div class="arrow">→</div></div>
    </div>
    <?php 
	}
} ?>
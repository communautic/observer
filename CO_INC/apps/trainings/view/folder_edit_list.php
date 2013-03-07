<?php
if(is_array($trainings)) {
	foreach ($trainings as $training) { 
	?>
    <div class="loadTraining listOuter"  rel="<?php echo($training->id);?>">
    <div class="bold co-link listTitle"><?php echo($training->title);?></div>
    <div class="text11 listText"><div><?php echo($training->dates_display);?> &nbsp; | &nbsp; </div><div><?php echo $lang["TRAINING_TEAM"];?> <?php echo($training->team);?> &nbsp; | &nbsp; </div><div><?php echo($training->status_text);?></div></div>
    </div>
    <?php 
	}
}
?>
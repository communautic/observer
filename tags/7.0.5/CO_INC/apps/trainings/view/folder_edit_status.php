<div style="height: 125px;" class="text11">
<div style="height: 26px;" class="tbl-inactive"></div>
<div style="position: relative; float: left; width: 150px; margin: -26px 9px 0 9px">
	<div style="height: 26px; background-color:#c3c3c3">
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px;" width="120"><?php echo $lang["TRAINING_FOLDER_TRAININGS_CREATED"];?></td>
    <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo($folder->alltrainings);?></td>
  </tr>
</table>
</div>
    <div>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px" width="120"><?php echo $lang["TRAINING_FOLDER_TRAININGS_PLANNED"];?></td>
    <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo($folder->plannedtrainings);?></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px" width="120"><?php echo $lang["TRAINING_FOLDER_TRAININGS_RUNNING"];?></td>
    <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo($folder->activetrainings);?></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px" width="120"><?php echo $lang["TRAINING_FOLDER_TRAININGS_FINISHED"];?></td>
    <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo $folder->inactivetrainings;?></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px" width="120"><?php echo $lang["TRAINING_FOLDER_TRAININGS_STOPPED"];?></td>
    <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo $folder->stoppedtrainings;?></td>
  </tr>
</table>
    </div>
</div>
<?php  $this->getChartFolder($folder->id,'stability');?>
<?php  $this->getChartFolder($folder->id,'status',0,1);?>
</div>
<div style="height: 125px;" class="text11">
<div style="height: 26px;" class="tbl-inactive"></div>
<?php  $this->getChartFolder($folder->id,'realisation');?>
<?php  $this->getChartFolder($folder->id,'timeing');?>
<?php  $this->getChartFolder($folder->id,'feedbacks');?>

</div>
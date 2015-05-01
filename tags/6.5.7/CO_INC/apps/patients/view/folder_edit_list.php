<?php
if(is_array($patients)) {
	foreach ($patients as $patient) { 
	?>
    <div class="loadPatient listOuter"  rel="<?php echo($patient->id);?>">
    <div class="bold co-link listTitle"><?php echo($patient->title);?></div>
    <div class="text11 listText"><div><?php echo($patient->status_text . " " . $patient->status_text_time . " " . $patient->status_date);?></div></div>
    </div>
    <?php 
	}
}
?>
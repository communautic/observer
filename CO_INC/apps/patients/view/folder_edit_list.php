<?php
if(is_array($patients)) {
	foreach ($patients as $patient) { 
	?>
    <div class="loadPatient listOuter"  rel="<?php echo($patient->id);?>">
    <div class="bold co-link listTitle"><?php echo($patient->title);?></div>
    <div class="text11 listText"><div><?php if($patient->address_line1 != "") { echo $patient->address_line1.', '; } ?><?php if($patient->address_postcode != "" || $patient->address_town != "") { echo $patient->address_postcode.' '.$patient->address_town; } ?><?php if($patient->address_line1 != "" || $patient->address_postcode != "" || $patient->address_town != "") { ?>&nbsp; | &nbsp; <?php } ?><?php if($patient->email != "") { echo $patient->email.' &nbsp; | &nbsp; '; } ?><?php if($patient->phone1 != "") { echo $patient->phone1.' &nbsp; | &nbsp; '; } ?><?php echo($patient->status_text . " " . $patient->status_text_time . " " . $patient->status_date);?></div></div>
    </div>
    <?php 
	}
}
?>
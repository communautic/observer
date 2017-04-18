<div id="barbeleg-<?php echo $value->id;?>">
<?php 
	$ttasks = explode(',',$value->task_ids);
	$ttask_string = '';
	$ttask_costs = 0;
	$ttask_vat_text = '(inkl. ' . $treatment->vat . '% MwSt.)';
	foreach($ttasks as $ttask) {
		$ttask_costs += $bar_compare_array[$ttask]['costs'];
		$ttask_string .= $bar_compare_array[$ttask]['task_num'] . '. ' . $lang["PATIENT_TREATMENT_GOALS_SINGUAL"] . ' | ';
	}
	
	if($treatment->discount != 0) {
			$ttask_costs = $ttask_costs-(($ttask_costs/100)*$treatment->discount);
		}
	if($treatment->vat != 0) {
			$ttask_costs = $ttask_costs+(($ttask_costs/100)*$treatment->vat);
		}
	$ttask_costs = number_format($ttask_costs,2,',','.');
	
	$ttask_string_full = $ttask_string . ' Rechnungsnr. ' . $treatment->invoice_carrier . '/' . $treatment->invoice_year . '/' . $treatment->invoice_no . ' | ' . CO_DEFAULT_CURRENCY . ' ' . $ttask_costs . ' ' . $ttask_vat_text;
		
?>
<span class="showCoPopup co-link <?php if($treatment->canedit) { ?>showdelete<?php } ?>" rel="<?php echo $value->id;?>"><?php echo $ttask_string_full;?></span>
<div style="height: 1px; overflow: hidden">
  <textarea id="belegText-<?php echo $value->id;?>" style="border:0; margin-top: 1px;"><?php echo $ttask_string_full;?></textarea></div>
</div>
<div id="barbeleg-<?php echo $value->id;?>">
<?php 
	$ttasks = explode(',',$value->task_ids);
	$ttask_string = '';
	$ttask_costs = 0;
	$ttask_vat_text = '(inkl. ' . $service->vat . '% MwSt.)';
	foreach($ttasks as $ttask) {
		$ttask_costs += $bar_compare_array[$ttask]['costs'];
		$ttask_string .= $bar_compare_array[$ttask]['title'] . ' | ';
	}
	
	if($service->discount != 0) {
			$ttask_costs = $ttask_costs-(($ttask_costs/100)*$service->discount);
		}
	if($service->vat != 0) {
			$ttask_costs = $ttask_costs+(($ttask_costs/100)*$service->vat);
		}
	$ttask_costs = number_format($ttask_costs,2,',','.');
	
	$ttask_string_full = $ttask_string . ' Rechnungsnr. ' . $service->invoice_carrier . '/' . $service->invoice_year . '/' . $service->invoice_no . ' | ' . CO_DEFAULT_CURRENCY . ' ' . $ttask_costs . ' ' . $ttask_vat_text;
		
?>
<span class="<?php if($service->canedit) { ?>showCoPopup co-link<?php } ?>" rel="<?php echo $value->id;?>"><?php echo $ttask_string_full;?></span>
<div style="height: 1px; overflow: hidden">
  <textarea id="belegText-<?php echo $value->id;?>" style="border:0; margin-top: 1px;"><?php echo $ttask_string_full;?></textarea></div>
</div>
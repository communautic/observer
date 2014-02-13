<div style="border-bottom: 1px solid #ccc;">
	<table width="530" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td style="width: 215px; padding: 6px 0;">
            <span class="bold" style="margin-left: 7px;"><?php echo $i;?>. <?php echo $lang["PATIENT_TREATMENT_GOALS_SINGUAL"];?></span><span class="text11"> (<?php echo $value->item_date;?>)</span></td>
        <td class="text11" style="width: 157px; padding: 7px 0 4px 0;">
            <?php 
			if(is_array($value->type)) {
				foreach($value->type as $t) {
					echo '<span>' . $t['positionstext'] . ' ' . $t['shortname'] . '</span><br />';
				}
			}
			 ?></td>
             <td class="text11" style="padding: 7px 0 4px 0;">
            <?php 
			if(is_array($value->type)) {
				foreach($value->type as $t) {
					echo '<span>' . $t['minutes'] . 'min.</span><br />';
				}
			}
			 ?></td>
            <td class="text11" style="width: 88px; text-align: right; border-left: 1px solid #ccc; padding: 7px 0 4px 0;">
            <?php 
			if(is_array($value->type)) {
				foreach($value->type as $t) {
					echo '<span>' . CO_DEFAULT_CURRENCY . ' ' . $t['costs'] . ' &nbsp; &nbsp; </span><br />';
				}
			}
			 ?>
            </td>
      </tr>
    </table>
</div>
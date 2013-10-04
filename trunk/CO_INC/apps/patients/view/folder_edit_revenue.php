<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PATIENT_FOLDER_TAB_FILTER"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"></td>
    </tr>
</table>
<div class="content-spacer"></div>

<div style="position: absolute; top: 70px; width: 100%; height: 60px; background: #d2dcff; border-bottom: 1px solid #ccc;">
   <table border="0" cellspacing="0" cellpadding="0" style="margin-left: 141px;">
    <tr>
        <td width="158"><span style="color: #666; font-size: 11px; line-height: 30px; padding-left: 11px;"><?php echo $lang["PATIENT_FOLDER_TAB_THERAPIST"];?></span></td>
        <td width="158"><span style="color: #666; font-size: 11px; line-height: 30px; padding-left: 11px;"><?php echo $lang["GLOBAL_TIME_FROM"];?></span></td>
        <td width="170"><span style="color: #666; font-size: 11px; line-height: 30px; padding-left: 11px;"><?php echo $lang["GLOBAL_TIME_TO"];?></span></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><input name="who" type="text" class="inlineSearch" rel="patients" /><input name="who" type="hidden" id="calcWho" /></td>
        <td><input name="startdate" type="text" id="calcStart" value="<?php echo $start_date;?>" class="inlineDatepicker" /></td>
        <td><input name="enddate" type="text" id="calcEnd" value="<?php echo $end_date;?>" class="inlineDatepicker" /></td>
         <td><span id="calculateRevenue" class="bold"><em><span class="contentArrow"></span> <?php echo $lang["PATIENT_FOLDER_TAB_CALCULATE"];?></em></span></td>
    </tr>
</table>
</div>
<div id="revenueResult" style="position: absolute; top: 140px; bottom: 0; left: 0; right: 0px; overflow: auto;">
</div>
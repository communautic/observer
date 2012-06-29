<?php
if(is_array($productions)) {
	foreach ($productions as $production) { 
	?>
    <table border="0" cellspacing="0" cellpadding="0" class="table-content tbl-inactive loadProduction" rel="<?php echo($production->id);?>">
	<tr>
    	<td class="tcell-left text11">&nbsp;</td>
		<td colspan="4" class="tcell-right"><span class="bold co-link"><?php echo($production->title);?></span></td>
    	</tr>
    <tr>
    	<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right" width="220"><span class="text11 content-date"><?php echo $lang["GLOBAL_DURATION"];?></span><span class="text11"><?php echo($production->startdate . " - " . $production->enddate);?></span></td>
    	<td class="tcell-right" width="110"><span class="text11"><span style="display: inline; margin-right: 20px;"></span><?php echo($production->status_text);?></span></td>
        <td class="tcell-right" width="190"><?php if($production->perm != "guest") { ?><span class="text11"><span style="display: inline; margin-right: 20px;"><?php echo $lang["PRODUCTION_FOLDER_CHART_REALISATION"];?></span><?php echo($production->realisation["real"]);?>%</span><?php } ?></td>
    	<td class="tcell-right"><span class="text11"><span style="display: inline; margin-right: 20px;"><?php echo $lang["PRODUCTION_MANAGEMENT"];?></span><?php echo($production->management);?></span></td>
    </tr>
</table>
    <?php 
	}
}
?>	
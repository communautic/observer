<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["PROJECT_CONTROLLING_STATUS"];?> </td>
        <td><strong><?php echo $tit;?></strong></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PROJECT_CONTROLLING_PHASES_CREATED"];?></td>
		<td><?php echo($cont->allphases);?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PROJECT_CONTROLLING_PHASES_PLANNED"];?></td>
		<td><?php echo($cont->plannedphases);?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PROJECT_CONTROLLING_PHASES_RUNNING"];?></td>
		<td><?php echo($cont->inprogressphases);?></td>
	</tr>
</table>
<table width="100%" class="standard">
	<tr>
		<td class="tcell-left"><?php echo $lang["PROJECT_CONTROLLING_PHASES_FINISHED"];?></td>
		<td><?php echo $cont->finishedphases;?></td>
	</tr>
</table>
&nbsp;
<table width="100%" class="standard-margin">
	<tr>
		<td width="34%"><?php $projectsControlling = new ProjectsControlling("controlling");
		$projectsControlling->getChart($cont->id,'stability',1);?></td>
		<td width="66%"><?php $projectsControlling->getChart($cont->id,'status',1,1);?></td>
	</tr>
</table>
&nbsp;
<table width="100%" class="standard-margin">
	<tr>
		<td width="34%"><?php $projectsControlling->getChart($cont->id,'realisation',1);?></td>
		<td width="33%"><?php $projectsControlling->getChart($cont->id,'timeing',1);?></td>
		<td width="33%"><?php $projectsControlling->getChart($cont->id,'tasks',1);?></td>
	</tr>
</table>
<?php if($cont->setting_costs) {?>
&nbsp;
<table width="100%" class="standard-margin">
	<tr>
		<td width="34%">
        &nbsp;
        <table class="chart smalltext" width="95%">
            <tr><td class="fourCols-three greybg">&nbsp;</td><td class="greybg"><?php echo $lang["PROJECT_COSTS_PLAN"];?></td></tr>
            <tr><td class="fourCols-three">&nbsp;</td><td>
            <table width="100%">
                <tr>
                    <td align="right"><?php echo $cont->setting_currency ;?> <?php echo number_format($cont->costs_plan,0,',','.');?>&nbsp;&nbsp;</td>
                </tr>
            </table>
            &nbsp;
            <table width="100%">
                <tr>
                    <td><?php echo $lang["GLOBAL_COSTS_EMPLOYEES_SHORT"];?></td>
                    <td align="right"><?php echo $cont->setting_currency ;?> <?php echo number_format($cont->costs_employees_plan,0,',','.');?>&nbsp;&nbsp;</td>
                </tr>
            </table>
            <table width="100%">
                <tr>
                    <td><?php echo $lang["GLOBAL_COSTS_MATERIAL_SHORT"];?></td>
                    <td align="right"><?php echo $cont->setting_currency ;?> <?php echo number_format($cont->costs_materials_plan,0,',','.');?>&nbsp;&nbsp;</td>
                </tr>
            </table>
             <table width="100%">
                <tr>
                    <td><?php echo $lang["GLOBAL_COSTS_EXTERNAL_SHORT"];?></td>
                    <td align="right"><?php echo $cont->setting_currency ;?> <?php echo number_format($cont->costs_external_plan,0,',','.');?>&nbsp;&nbsp;</td>
                </tr>
            </table>
            <table width="100%">
                <tr>
                    <td><?php echo $lang["GLOBAL_COSTS_OTHER_SHORT"];?></td>
                    <td align="right"><?php echo $cont->setting_currency ;?> <?php echo number_format($cont->costs_other_plan,0,',','.');?>&nbsp;&nbsp;</td>
                </tr>
            </table>
            </td></tr>
            </table>
        </td>
		<td width="33%">
         &nbsp;
        <table class="chart smalltext" width="95%">
		    <tr>
		        <td class="fourCols-three greybg">&nbsp;</td>
		        <td class="greybg"><?php echo $lang["PROJECT_COSTS_REAL"];?></td>
		        </tr>
		    <tr>
		        <td class="fourCols-three">&nbsp;</td>
		        <td><table width="100%">
		            <tr>
		                <td align="right"><?php echo $cont->setting_currency ;?> <?php echo number_format($cont->costs_real,0,',','.');?>&nbsp;&nbsp;</td>
		                </tr>
		            </table>
                    &nbsp;
		            <table width="100%">
                <tr>
                    <td><?php echo $lang["GLOBAL_COSTS_EMPLOYEES_SHORT"];?></td>
                    <td align="right"><?php echo $cont->setting_currency ;?> <?php echo number_format($cont->costs_employees_real,0,',','.');?>&nbsp;&nbsp;</td>
                </tr>
            </table>
            <table width="100%">
                <tr>
                    <td><?php echo $lang["GLOBAL_COSTS_MATERIAL_SHORT"];?></td>
                    <td align="right"><?php echo $cont->setting_currency ;?> <?php echo number_format($cont->costs_materials_real,0,',','.');?>&nbsp;&nbsp;</td>
                </tr>
            </table>
             <table width="100%">
                <tr>
                    <td><?php echo $lang["GLOBAL_COSTS_EXTERNAL_SHORT"];?></td>
                    <td align="right"><?php echo $cont->setting_currency ;?> <?php echo number_format($cont->costs_external_real,0,',','.');?>&nbsp;&nbsp;</td>
                </tr>
            </table>
            <table width="100%">
                <tr>
                    <td><?php echo $lang["GLOBAL_COSTS_OTHER_SHORT"];?></td>
                    <td align="right"><?php echo $cont->setting_currency ;?> <?php echo number_format($cont->costs_other_real,0,',','.');?>&nbsp;&nbsp;</td>
                </tr>
            </table>
            </td>
		        </tr>
	    </table></td>
		<td width="33%">
         &nbsp;
        <table class="chart smalltext" width="95%">
		    <tr>
		        <td class="fourCols-three greybg">&nbsp;</td>
		        <td class="greybg">Abweichung Plan/Ist</td>
		        </tr>
		    <tr>
		        <td class="fourCols-three">&nbsp;</td>
		        <td><table width="100%">
		            <tr>
		                <td align="right"><?php echo $cont->setting_currency ;?> <?php echo number_format($cont->stats_calc,0,',','.');?>&nbsp;&nbsp;</td>
		                </tr>
		            </table>
                    &nbsp;
                    <table width="100%">
                <tr>
                    <td><?php echo $lang["GLOBAL_COSTS_EMPLOYEES_SHORT"];?></td>
                    <td align="right"><?php echo $cont->setting_currency ;?> <?php echo number_format($cont->stats_calc_employees,0,',','.');?>&nbsp;&nbsp;</td>
                </tr>
            </table>
            <table width="100%">
                <tr>
                    <td><?php echo $lang["GLOBAL_COSTS_MATERIAL_SHORT"];?></td>
                    <td align="right"><?php echo $cont->setting_currency ;?> <?php echo number_format($cont->stats_calc_materials,0,',','.');?>&nbsp;&nbsp;</td>
                </tr>
            </table>
             <table width="100%">
                <tr>
                    <td><?php echo $lang["GLOBAL_COSTS_EXTERNAL_SHORT"];?></td>
                    <td align="right"><?php echo $cont->setting_currency ;?> <?php echo number_format($cont->stats_calc_external,0,',','.');?>&nbsp;&nbsp;</td>
                </tr>
            </table>
            <table width="100%">
                <tr>
                    <td><?php echo $lang["GLOBAL_COSTS_OTHER_SHORT"];?></td>
                    <td align="right"><?php echo $cont->setting_currency ;?> <?php echo number_format($cont->stats_calc_other,0,',','.');?>&nbsp;&nbsp;</td>
                </tr>
            </table>
                    
                    </td>
		        </tr>
	    </table></td>
	</tr>
</table>
<?php } ?>

<div style="page-break-after:always;">&nbsp;</div>
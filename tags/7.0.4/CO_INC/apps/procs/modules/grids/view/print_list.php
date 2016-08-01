<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["PROC_GRID_TITLE"];?></td>
        <td><?php echo($grid->title);?></td>
	</tr>
</table>
<table width="100%" class="standard">
<?php if($grid->hours_total != 0) { ?>
        <tr>
			<td class="tcell-left grey smalltext"><?php echo $lang["PROC_GRID_TIME"];?></td>
			<td class="grey smalltext" style="padding-top: 3pt;"><?php echo $grid->hours_total;?> Stunden</td>
        </tr>
<?php } ?>
<?php if($grid->tcosts != 0) { ?>
        <tr>
			<td class="tcell-left grey smalltext"><?php echo $lang["PROC_GRID_COSTS"];?></td>
			<td class="grey smalltext" style="padding-top: 3pt;"><?php echo $grid->setting_currency;?> <?php echo $grid->tcosts;?></td>
        </tr>
<?php } ?>
<?php if(!empty($grid->owner) || !empty($grid->owner_ct)) { ?>
        <tr>
			<td class="tcell-left grey smalltext"><?php echo $lang["PROC_GRID_OWNER"];?></td>
			<td class="grey smalltext" style="padding-top: 3pt;"><?php echo($grid->owner);?><br /><?php echo($grid->owner_ct);?></td>
        </tr>
<?php } ?>
<?php if(!empty($grid->management) || !empty($grid->management_ct)) { ?>
        <tr>
			<td class="tcell-left grey smalltext"><?php echo $lang["PROC_GRID_MANAGEMENT"];?></td>
			<td class="grey smalltext" style="padding-top: 3pt;"><?php echo($grid->management);?><br /><?php echo($grid->management_ct);?></td>
        </tr>
<?php } ?>
<?php if(!empty($grid->team) || !empty($grid->team_ct)) { ?>
        <tr>
			<td class="tcell-left grey smalltext"><?php echo $lang["PROC_GRID_TEAM"];?></td>
			<td class="grey smalltext" style="padding-top: 3pt;"><?php echo($grid->team);?><br /><?php echo($grid->team_ct);?></td>
        </tr>
<?php } ?>
</table>
<?php 
$i = 1;
foreach($cols as $key => &$value){ ?>
	&nbsp;
	<table width="100%" class="protocol">
        <tr>
            <td class="tcell-left">Hauptprozess</td>
            <td><?php echo $i.'. ' .$cols[$key]['titletext'];?></td>
        </tr>
    </table>
    <table width="100%" class="standard">
    <?php if($cols[$key]['hours'] !=0) { ?>
        <tr>
            <td class="tcell-left">&nbsp;</td>
            <td class="grey smalltext" width="80"><?php echo $lang["GLOBAL_DURATION"];?></td>
            <td class="grey smalltext"><?php echo $cols[$key]['hours'] . ' Stunden';?></td>
        </tr>
    <?php } ?>
    <?php if($cols[$key]['costs'] !=0) { ?>
        <tr>
            <td class="tcell-left">&nbsp;</td>
            <td class="grey smalltext" width="80"><?php echo $lang['GLOBAL_COSTS'];?></td>
            <td class="grey smalltext"><?php echo $grid->setting_currency . ' ' . $cols[$key]['costs'];?></td>
        </tr>
    <?php } ?>
    <?php if(!empty($cols[$key]['titletextcontent'])) { ?>
        <tr>
            <td class="tcell-left">&nbsp;</td>
            <td class="smalltext" colspan="2" style="line-height: 16px; padding: 6pt 0 0 0;"><em><?php echo nl2br($cols[$key]['titletextcontent']);?></em></td>
        </tr>
    <?php } ?>
    </table>
    &nbsp;


<?php 

	// listitems
	$num_notes = sizeof($cols[$key]["notes"]);
	foreach($cols[$key]["notes"] as $tkey => &$tvalue){ 
		$img = "&nbsp;";
		if ($cols[$key]["notes"][$tkey]['status'] == 1) {
			$img = '<img src="' . CO_FILES . '/img/print/done.png" width="12" height="12" vspace="7" hspace="4" />';
		}
		?>
		<table width="100%" class="fourCols">
            <tr>
                <td class="fourCols-one" style="width: 82pt;">&nbsp;</td>
                <td class="fourCols-two">&nbsp;</td>
                <td class="fourCols-three"><?php echo $img;?></td>
                <td class="fourCols-four greybg" style="padding: 5pt 10pt 5pt 15pt;"><?php echo $cols[$key]["notes"][$tkey]['title'];?></td>
            </tr>
            </table>
            <table width="100%" class="fourCols">
            <?php if(!empty($cols[$key]["notes"][$tkey]['team'])) { ?>
             <tr>
                <td class="fourCols-one">&nbsp;</td>
                <td class="fourCols-two" style="width: 35pt">&nbsp;</td>
                <td class="fourCols-three grey smalltext" style="width: 80pt"><?php echo $lang["GLOBAL_RESPONSIBILITY"];?></td>
                <td class="fourCols-four grey smalltext"><?php echo $cols[$key]["notes"][$tkey]['team'];?></td>
            </tr>
            <?php } ?>
            <?php if($cols[$key]["notes"][$tkey]['hours'] !=0) { ?>
            <tr>
                <td class="fourCols-one">&nbsp;</td>
                <td class="fourCols-two" style="width: 35pt">&nbsp;</td>
                <td class="fourCols-three grey smalltext" style="width: 80pt"><?php echo $lang["GLOBAL_DURATION"];?></td>
                <td class="fourCols-four grey smalltext"><?php echo $cols[$key]["notes"][$tkey]['hours'] . ' Stunden';?></td>
            </tr>
            <?php } ?>
            <?php if($cols[$key]["notes"][$tkey]['costs_employees'] !=0) { ?>
            <tr>
                <td class="fourCols-one">&nbsp;</td>
                <td class="fourCols-two" style="width: 35pt">&nbsp;</td>
                <td class="fourCols-three grey smalltext" style="width: 80pt"><?php echo $lang['PROC_GRID_COSTS_EMPLOYEES'];?></td>
                <td class="fourCols-four grey smalltext"><?php echo $grid->setting_currency.' ' . $cols[$key]["notes"][$tkey]['costs_employees'];?></td>
            </tr>
            <?php } ?>
            <?php if($cols[$key]["notes"][$tkey]['costs_employees'] !=0) { ?>
            <tr>
                <td class="fourCols-one">&nbsp;</td>
                <td class="fourCols-two" style="width: 35pt">&nbsp;</td>
                <td class="fourCols-three grey smalltext" style="width: 80pt"><?php echo $lang['PROC_GRID_COSTS_MATERIAL'];?></td>
                <td class="fourCols-four grey smalltext"><?php echo $grid->setting_currency.' ' . $cols[$key]["notes"][$tkey]['costs_materials'];?></td>
            </tr>
            <?php } ?>
            <?php if($cols[$key]["notes"][$tkey]['costs_employees'] !=0) { ?>
            <tr>
                <td class="fourCols-one">&nbsp;</td>
                <td class="fourCols-two" style="width: 35pt">&nbsp;</td>
                <td class="fourCols-three grey smalltext" style="width: 80pt"><?php echo $lang['PROC_GRID_COSTS_EXTERNAL'];?></td>
                <td class="fourCols-four grey smalltext"><?php echo $grid->setting_currency.' ' . $cols[$key]["notes"][$tkey]['costs_external'];?></td>
            </tr>
            <?php } ?>
            <?php if($cols[$key]["notes"][$tkey]['costs_employees'] !=0) { ?>
            <tr>
                <td class="fourCols-one">&nbsp;</td>
                <td class="fourCols-two" style="width: 35pt">&nbsp;</td>
                <td class="fourCols-three grey smalltext" style="width: 80pt"><?php echo $lang['PROC_GRID_COSTS_OTHER'];?></td>
                <td class="fourCols-four grey smalltext"><?php echo $grid->setting_currency.' ' . $cols[$key]["notes"][$tkey]['costs_other'];?></td>
            </tr>
            <?php } ?>
            </table>
            <?php if(!empty($cols[$key]["notes"][$tkey]['text'])) { ?>
            <table width="100%" class="standard">
                <tr>
                <td class="tcell-left">&nbsp;</td>
                <td class="smalltext" style="line-height: 16px"><em><?php echo nl2br($cols[$key]["notes"][$tkey]['text']);?></em></td>
           		 </tr>
            </table>
            <?php } ?>
        
        &nbsp;
        <?php

	} // tasks end
	
	// stage gate
	if($cols[$key]['stagegatetext'] != "") { 
	$img = '<img src="' . CO_FILES . '/img/print/grid_stagegate.png" width="13" height="13" vspace="6" hspace="3" />';
	if($cols[$key]['status'] == "finished" ) {
		$img = '<img src="' . CO_FILES . '/img/print/grid_stagegate_done.png" width="13" height="13" vspace="6" hspace="3" />';
	}
	
		?>
        <table width="100%" class="fourCols">
            <tr>
                <td class="fourCols-one" style="width: 82pt;">&nbsp;</td>
                <td class="fourCols-two">&nbsp;</td>
                <td class="fourCols-three"><?php echo $img;?></td>
                <td class="fourCols-four greybg" style="padding: 5pt 10pt 5pt 15pt;"><?php echo $cols[$key]['stagegatetext'];?></td>
            </tr>
            </table>
       
            <?php if(!empty($cols[$key]['stagegatetextcontent'])) { ?>
            <table width="100%" class="standard">
                <tr>
                <td class="tcell-left">&nbsp;</td>
                <td class="smalltext" style="line-height: 16px"><em><?php echo nl2br($cols[$key]['stagegatetextcontent']);?></em></td>
           		 </tr>
            </table>
            <?php } ?>
        
        &nbsp;
        <?php } 
	
	echo '<br />';
	$i++;
 }  // phases end
?>
 

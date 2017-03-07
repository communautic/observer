<table width="100%" class="title">
	<tr>
        <td class="tcell-left"><?php echo $lang["PROC_PSPGRID_TITLE"];?></td>
        <td><?php echo($pspgrid->title);?></td>
	</tr>
</table>
<table width="100%" class="standard">
<?php if($pspgrid->tdays != 0) { ?>
        <tr>
			<td class="tcell-left grey smalltext"><?php echo $lang["PROC_PSPGRID_TIME"];?></td>
			<td class="grey smalltext" style="padding-top: 3pt;"><?php echo $pspgrid->tdays;?> <?php echo $lang["GLOBAL_DAYS"];?></td>
        </tr>
<?php } ?>
<?php if($pspgrid->tcosts != 0) { ?>
        <tr>
			<td class="tcell-left grey"><?php echo $lang["PROC_PSPGRID_COSTS"];?></td>
			<td class="grey smalltext" style="padding-top: 3pt;"><?php echo $pspgrid->setting_currency;?> <?php echo $pspgrid->tcosts;?></td>
        </tr>
<?php } ?>
<?php if(!empty($pspgrid->owner) || !empty($pspgrid->owner_ct)) { ?>
        <tr>
			<td class="tcell-left grey"><?php echo $lang["PROC_PSPGRID_OWNER"];?></td>
			<td class="grey smalltext" style="padding-top: 3pt;"><?php echo($pspgrid->owner);?><br /><?php echo($pspgrid->owner_ct);?></td>
        </tr>
<?php } ?>
<?php if(!empty($pspgrid->management) || !empty($pspgrid->management_ct)) { ?>
        <tr>
			<td class="tcell-left grey"><?php echo $lang["PROC_PSPGRID_MANAGEMENT"];?></td>
			<td class="grey smalltext" style="padding-top: 3pt;"><?php echo($pspgrid->management);?><br /><?php echo($pspgrid->management_ct);?></td>
        </tr>
<?php } ?>
<?php if(!empty($pspgrid->team) || !empty($pspgrid->team_ct)) { ?>
        <tr>
			<td class="tcell-left grey"><?php echo $lang["PROC_PSPGRID_TEAM"];?></td>
			<td class="grey smalltext" style="padding-top: 3pt;"><?php echo($pspgrid->team);?><br /><?php echo($pspgrid->team_ct);?></td>
        </tr>
<?php } ?>
</table>
<?php 
$i = 1;
foreach($cols as $key => &$value){ ?>
	&nbsp;
	<table width="100%" class="protocol">
        <tr>
            <td class="tcell-left">Phase</td>
            <td><?php echo $i.'. ' .$cols[$key]['titletext'];?></td>
        </tr>
    </table>
    <table width="100%" class="standard">
    <?php
			switch($cols[$key]['status']) {
				case 'planned':
					$status = $lang["GLOBAL_STATUS_PLANNED"];
				break;
				case 'progress':
					$status = $lang["GLOBAL_STATUS_INPROGRESS"];
				break;
				case 'finished':
					$status = $lang["GLOBAL_STATUS_FINISHED"];
				break;
			}
			?>
    <?php if(!empty($cols[$key]['titleteamprint'])) { ?>
        <tr>
            <td class="tcell-left">&nbsp;</td>
            <td class="grey smalltext" width="80"><?php echo $lang["GLOBAL_RESPONSIBILITY"];?></td>
            <td class="grey smalltext"><?php echo $cols[$key]['titleteamprint'];?></td>
        </tr>
    <?php } ?>
    <?php if($cols[$key]['days'] !=0) { ?>
        <tr>
            <td class="tcell-left">&nbsp;</td>
            <td class="grey smalltext" width="80"><?php echo $lang["GLOBAL_DURATION"];?></td>
            <td class="grey smalltext"><?php echo $cols[$key]['days'] . ' ' . $lang['PROC_PSPGRID_DAYS'];?> / <?php echo $status;?></td>
        </tr>
    <?php } ?>
    <?php if($cols[$key]['costs'] !=0) { ?>
        <tr>
            <td class="tcell-left">&nbsp;</td>
            <td class="grey smalltext" width="80"><?php echo $lang['GLOBAL_COSTS'];?></td>
            <td class="grey smalltext"><?php echo $pspgrid->setting_currency . ' ' . $cols[$key]['costs'];?></td>
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
		/*$class = 'planned';
		switch($cols[$key]["notes"][$tkey]['status']) {
			case '0':
				$class = 'planned';
			break;
			case '1':
				$class = 'progress';
			break;
			case '2':
				$class = 'finished';
			break;
		}*/

		if($cols[$key]["notes"][$tkey]['milestone'] == 1) { ?>
        <table width="100%" class="fourCols">
            <tr>
                <td class="fourCols-one" style="width: 82pt;">&nbsp;</td>
                <td class="fourCols-two">&nbsp;</td>
                <td class="fourCols-three"><img src="<?php echo(CO_FILES);?>/img/print/milestone.png" width="12" height="12" style="margin: 7px 0 0 3px" /></td>
                <td class="fourCols-four greybg" style="padding: 5pt 10pt 5pt 15pt;"><?php echo $cols[$key]["notes"][$tkey]['title'];?></td>
            </tr>
            </table>
            <?php
			switch($cols[$key]["notes"][$tkey]['status']) {
				case '0':
					$status = $lang["GLOBAL_STATUS_PLANNED"];
				break;
				case '1':
					$status = $lang["GLOBAL_STATUS_INPROGRESS"];
				break;
				case '2':
					$status = $lang["GLOBAL_STATUS_FINISHED"];
				break;
			}
			?>
            <table width="100%" class="fourCols">
            <tr>
                <td class="fourCols-one">&nbsp;</td>
                <td class="fourCols-two" style="width: 35pt">&nbsp;</td>
                <td class="fourCols-three grey smalltext" style="width: 80pt">Status</td>
                <td class="fourCols-four grey smalltext"><?php echo $status;?></td>
            </tr>
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
        <?php } else { ?>
		<table width="100%" class="fourCols">
            <tr>
                <td class="fourCols-one" style="width: 82pt;">&nbsp;</td>
                <td class="fourCols-two">&nbsp;</td>
                <td class="fourCols-three">&nbsp;</td>
                <td class="fourCols-four greybg" style="margin-left: 15px; padding: 5pt 10pt 5pt 15pt;"><?php echo $cols[$key]["notes"][$tkey]['title'];?></td>
            </tr>
            </table>
            <?php
			switch($cols[$key]["notes"][$tkey]['status']) {
				case '0':
					$status = $lang["GLOBAL_STATUS_PLANNED"];
				break;
				case '1':
					$status = $lang["GLOBAL_STATUS_INPROGRESS"];
				break;
				case '2':
					$status = $lang["GLOBAL_STATUS_FINISHED"];
				break;
			}
			?>
            <table width="100%" class="fourCols">
            <?php if(!empty($cols[$key]["notes"][$tkey]['teamprint'])) { ?>
             <tr>
                <td class="fourCols-one">&nbsp;</td>
                <td class="fourCols-two" style="width: 35pt">&nbsp;</td>
                <td class="fourCols-three grey smalltext" style="width: 80pt"><?php echo $lang["GLOBAL_RESPONSIBILITY"];?></td>
                <td class="fourCols-four grey smalltext"><?php echo $cols[$key]["notes"][$tkey]['teamprint'];?></td>
            </tr>
            <?php } ?>
            <?php if($cols[$key]["notes"][$tkey]['days'] !=0) { ?>
            <tr>
                <td class="fourCols-one">&nbsp;</td>
                <td class="fourCols-two" style="width: 35pt">&nbsp;</td>
                <td class="fourCols-three grey smalltext" style="width: 80pt"><?php echo $lang["GLOBAL_DURATION"];?></td>
                <td class="fourCols-four grey smalltext"><?php echo $cols[$key]["notes"][$tkey]['days'] . ' ' . $lang['PROC_PSPGRID_DAYS'];?> / <?php echo $status;?></td>
            </tr>
            <?php } ?>
            <?php if($cols[$key]["notes"][$tkey]['itemcosts'] !=0) { ?>
            <tr>
                <td class="fourCols-one">&nbsp;</td>
                <td class="fourCols-two" style="width: 35pt">&nbsp;</td>
                <td class="fourCols-three grey smalltext" style="width: 80pt"><?php echo $lang['GLOBAL_COSTS'];?></td>
                <td class="fourCols-four grey smalltext"><?php echo $pspgrid->setting_currency.' ' . $cols[$key]["notes"][$tkey]['itemcosts'];?></td>
            </tr>
            <?php } ?>
            <?php if($cols[$key]["notes"][$tkey]['costs_employees'] !=0) { ?>
            <tr>
                <td class="fourCols-one">&nbsp;</td>
                <td class="fourCols-two" style="width: 35pt">&nbsp;</td>
                <td class="fourCols-three grey smalltext" style="width: 80pt"><?php echo $lang['PROC_PSPGRID_COSTS_EMPLOYEES'];?></td>
                <td class="fourCols-four grey smalltext"><?php echo $pspgrid->setting_currency.' ' . $cols[$key]["notes"][$tkey]['costs_employees'];?></td>
            </tr>
            <?php } ?>
            <?php if($cols[$key]["notes"][$tkey]['costs_employees'] !=0) { ?>
            <tr>
                <td class="fourCols-one">&nbsp;</td>
                <td class="fourCols-two" style="width: 35pt">&nbsp;</td>
                <td class="fourCols-three grey smalltext" style="width: 80pt"><?php echo $lang['PROC_PSPGRID_COSTS_MATERIAL'];?></td>
                <td class="fourCols-four grey smalltext"><?php echo $pspgrid->setting_currency.' ' . $cols[$key]["notes"][$tkey]['costs_materials'];?></td>
            </tr>
            <?php } ?>
            <?php if($cols[$key]["notes"][$tkey]['costs_employees'] !=0) { ?>
            <tr>
                <td class="fourCols-one">&nbsp;</td>
                <td class="fourCols-two" style="width: 35pt">&nbsp;</td>
                <td class="fourCols-three grey smalltext" style="width: 80pt"><?php echo $lang['PROC_PSPGRID_COSTS_EXTERNAL'];?></td>
                <td class="fourCols-four grey smalltext"><?php echo $pspgrid->setting_currency.' ' . $cols[$key]["notes"][$tkey]['costs_external'];?></td>
            </tr>
            <?php } ?>
            <?php if($cols[$key]["notes"][$tkey]['costs_employees'] !=0) { ?>
            <tr>
                <td class="fourCols-one">&nbsp;</td>
                <td class="fourCols-two" style="width: 35pt">&nbsp;</td>
                <td class="fourCols-three grey smalltext" style="width: 80pt"><?php echo $lang['PROC_PSPGRID_COSTS_OTHER'];?></td>
                <td class="fourCols-four grey smalltext"><?php echo $pspgrid->setting_currency.' ' . $cols[$key]["notes"][$tkey]['costs_other'];?></td>
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
        }

	} // tasks end
	echo '<br />';
	$i++;
 }  // phases end
?>
 

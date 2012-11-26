<div class="table-title-outer">
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($treatment->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["PATIENT_TREATMENT_TITLE"];?></span></span></td>
    <td><input name="title" type="text" class="title textarea-title" value="<?php echo($treatment->title);?>" maxlength="100" /></td>
  </tr>
  <tr class="table-title-status">
    <td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_STATUS"];?></td>
    <td colspan="2"><div class="statusTabs">
    	<ul>
        	<li><span class="left<?php if($treatment->canedit) { ?> statusButton <?php } ?> planned<?php echo $treatment->status_planned_active;?>" rel="0" reltext="<?php echo $lang["PATIENT_TREATMENT_STATUS_PLANNED_TIME"];?>"><?php echo $lang["PATIENT_TREATMENT_STATUS_PLANNED"];?></span></li>
            <li><span class="<?php if($treatment->canedit) { ?>statusButton <?php } ?>inprogress<?php echo $treatment->status_inprogress_active;?>" rel="1" reltext="<?php echo $lang["PATIENT_TREATMENT_STATUS_INPROGRESS_TIME"];?>"><?php echo $lang["PATIENT_TREATMENT_STATUS_INPROGRESS"];?></span></li>
            <li><span class="<?php if($treatment->canedit) { ?>statusButton <?php } ?>finished<?php echo $treatment->status_finished_active;?>" rel="2" reltext="<?php echo $lang["PATIENT_TREATMENT_STATUS_FINISHED_TIME"];?>"><?php echo $lang["PATIENT_TREATMENT_STATUS_FINISHED"];?></span></li>
            <li><span class="right<?php if($treatment->canedit) { ?> statusButton<?php } ?> stopped<?php echo $treatment->status_stopped_active;?>" rel="3" reltext="<?php echo $lang["PATIENT_TREATMENT_STATUS_STOPPED_TIME"];?>"><?php echo $lang["PATIENT_TREATMENT_STATUS_STOPPED"];?></span></li>
            <li><div class="status-time"><?php echo($treatment->status_text_time)?></div><div class="status-input"><input name="phase_status_date" type="text" class="input-date statusdp" value="<?php echo($treatment->status_date)?>" readonly="readonly" /></div></li>
		</ul></div></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($treatment->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($treatment->id);?>">
<input type="hidden" name="pid" value="<?php echo($treatment->pid);?>">
<?php if($treatment->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span>Warnung</span></span></strong></td>
		<td class="tcell-right"><strong>Dieser Inhaltsbereich wird aktuell bearbeitet von: <?php echo($treatment->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($treatment->checked_out_user_email);?>"><?php echo($treatment->checked_out_user_email);?></a>, <?php echo($treatment->checked_out_user_phone1);?></td>
    </tr>
</table>
<?php } ?>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["PATIENT_TREATMENT_DURATION"];?></td>
		<td class="tcell-right-inactive"><span id="patients_treatmentstartdate"><?php echo($treatment->treatment_start);?></span> - <span id="patients_treatmentenddate"><?php echo($treatment->treatment_end);?></span>
        </td>
    </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($treatment->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["PATIENT_TREATMENT_DATE"];?></span></span></td>
		<td class="tcell-right"><input name="item_date" type="text" class="input-date datepicker item_date" value="<?php echo($treatment->item_date)?>" /></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($treatment->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="patientsdoctor" append="1"><span><?php echo $lang["PATIENT_TREATMENT_DOCTOR"];?></span></span></td>
		<td class="tcell-right"><div id="patientsdoctor" class="itemlist-field"><?php echo($treatment->doctor);?></div><div id="patientsdoctor_ct" class="itemlist-field"><a field="patientsdoctor_ct" class="ct-content"><?php echo($treatment->doctor_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($treatment->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["PATIENT_TREATMENT_DOCTOR_DIAGNOSE"];?></span></span></td>
    <td class="tcell-right"><?php if($treatment->canedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($treatment->protocol));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($treatment->protocol)));?><?php } ?></td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($treatment->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["PATIENT_TREATMENT_DESCRIPTION"];?></span></span></td>
    <td class="tcell-right"><?php if($treatment->canedit) { ?><textarea name="protocol3" class="elastic"><?php echo(strip_tags($treatment->protocol3));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($treatment->protocol3)));?><?php } ?></td>
  </tr>
</table>
<div class="content-spacer"></div>

<div id="contactTabs" class="contentTabs">
	<ul class="contentTabsList">
		<li><span class="active" rel="PatientsTreatmentsFirst"><?php echo $lang["PATIENT_TREATMENT_DIAGNOSE"];?></span></li>
		<li><span rel="PatientsTreatmentsSecond"><?php echo $lang["PATIENT_TREATMENT_PLAN"];?></span></li>
	</ul>
    <div id="PatientsTreatmentsTabsContent" class="contentTabsContent">
        <div id="PatientsTreatmentsFirst">
        <div class="canvasToolsOuter">
        <div class="canvasTools">
        	<span class="addTool"></span>
            <span class="penTool active"></span>
            <span class="erasorTool"></span>
            <span class="clearTool"></span>
            <span class="undoTool"></span>
        </div>
        </div>
        <table border="0" cellpadding="0" cellspacing="0" class="table-content">
                <tr>
                    <td style="width:401px;"><div style="position: relative; width: 400px; height: 400px; border-top: 1px solid #fff; border-right: 1px solid #ccc; background: #d3ddff;"><div class="canvasDiv">
                    <?php $i = 1; 
							$j = $treatment->diagnoses;
                        foreach($diagnose as $value) { 
							$active = '';
							if($i == 1) {
								$active = ' active';
							}
							$curcol = ($i-1) % 10;
							?>
                            <canvas class="canvasDraw" id="c<?php echo $i;?>" width="400" height="400" style="z-index: <?php echo $j;?>" rel="<?php echo $value->id;?>"></canvas>
                            <div id="dia-<?php echo $value->id;?>" style="z-index: 10<?php echo $i;?>; top: <?php echo $value->y;?>px; left: <?php echo $value->x;?>px;" class="loadCanvas circle circle<?php echo $curcol;?> <?php echo $active;?>" rel="<?php echo $i;?>"><div><?php echo $i;?></div></div>
                        <?php 
						$i++;
						$j--;
						} ?>
                    </div></div></td>
                	<td valign="top" style=""><div id="canvasDivText" style="border-left: 1px solid #fff; background: #e5e5e5; height: 401px;"><?php 
					$i = 1;
                        foreach($diagnose as $value) { 
						$active = '';
							if($i == 1) {
								$active = ' active';
							}
							$curcol = ($i-1) % 10;
                            include("diagnose.php");
							$i++;
                         } ?></div></td>
                </tr>
            </table>
			
            
        </div>
        <div id="PatientsTreatmentsSecond" style="display: none;">
			<table border="0" cellpadding="0" cellspacing="0" class="table-content addTaskTable">
                <tr>
                    <td class="tcell-left text11">
                    <span class="<?php if($treatment->canedit) { ?>content-nav newItem<?php } ?>"><span><?php echo $lang["PATIENT_TREATMENT_GOALS"];?></span></span>
                    </td>
                    <td class="tcell-right">&nbsp;</td>
    </tr>
</table>
                    <div id="patientstreatmenttasks">
						<?php 
                        foreach($task as $value) { 
							$checked = '';
							if($value->status == 1) {
								$checked = ' checked="checked"';
							}
                            include("task.php");
                         } ?>
                        </div>
            </table>
        </div>
    </div>
</div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($treatment->canedit) { ?>content-nav selectTextarea<?php } ?>"><span><?php echo $lang["PATIENT_TREATMENT_PROTOCOL2"];?></span></span></td>
    <td class="tcell-right"><?php if($treatment->canedit) { ?><textarea name="protocol2" class="elastic"><?php echo(strip_tags($treatment->protocol2));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($treatment->protocol2)));?><?php } ?></td>
  </tr>
</table>
<?php if($treatment->perms != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($treatment->canedit) { ?>content-nav showDialog<?php } ?>" request="getAccessDialog" field="patientstreatment_access" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></span></td>
        <td class="tcell-right"><div id="patientstreatment_access" class="itemlist-field"><div class="listmember" field="patientstreatment_access" uid="<?php echo($treatment->access);?>" style="float: left"><?php echo($treatment->access_text);?></div></div><input type="hidden" name="treatment_access_orig" value="<?php echo($treatment->access);?>" /></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="patientstreatment_sendto">
        <?php 
			foreach($sendto as $value) { 
				if(!empty($value->who)) {
					echo '<div class="text11 toggleSendTo">' . $value->who . ', ' . $value->date . '</div>' .
						 '<div class="SendToContent">' . $lang["GLOBAL_SUBJECT"] . ': ' . $value->subject . '<br /><br />' . nl2br($value->body) . '<br></div>';
				}
		 } ?></div>
        </td>
    </tr>
</table>
<?php } ?>
</form>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($treatment->edited_user.", ".$treatment->edited_date)?></td>
    <td class="middle"><?php echo $treatment->access_footer;?></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($treatment->created_user.", ".$treatment->created_date);?></td>
  </tr>
</table>
</div>
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
        	<li><span class="left<?php if($treatment->canedit) { ?> statusButton <?php } ?> planned<?php echo $treatment->status_planned_active;?>" rel="0" reltext="<?php echo $lang["GLOBAL_STATUS_PLANNED_TIME"];?>"><?php echo $lang["PATIENT_STATUS_PLANNED"];?></span></li>
            <li><span class="<?php if($treatment->canedit) { ?>statusButton <?php } ?>inprogress<?php echo $treatment->status_inprogress_active;?>" rel="1" reltext="<?php echo $lang["GLOBAL_STATUS_INPROGRESS_TIME"];?>"><?php echo $lang["PATIENT_STATUS_INPROGRESS"];?></span></li>
            <li><span class="<?php if($treatment->canedit) { ?>statusButton <?php } ?>finished<?php echo $treatment->status_finished_active;?>" rel="2" reltext="<?php echo $lang["GLOBAL_STATUS_FINISHED_TIME"];?>"><?php echo $lang["PATIENT_STATUS_FINISHED"];?></span></li>
            <li><span class="right<?php if($treatment->canedit) { ?> statusButton<?php } ?> stopped<?php echo $treatment->status_stopped_active;?>" rel="3" reltext="<?php echo $lang["GLOBAL_STATUS_STOPPED_TIME"];?>"><?php echo $lang["PATIENT_STATUS_STOPPED"];?></span></li>
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
		<td class="tcell-left-inactive text11">Behandlungsdauer</td>
		<td class="tcell-right-inactive"><span id="patients_treatmentstartdate"></span> - <span id="patients_treatmentenddate"></span>
        </td>
    </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11">Behandlungszeit</td>
		<td class="tcell-right-inactive"><span id="patients_treatmenttime"></span><span id="patients_treatmenttime"></span>
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
		<td class="tcell-left-inactive text11">Therapieeinheiten</td>
		<td class="tcell-right-inactive">Auswahlfenster ...</td>
    </tr>
</table>

<div class="content-spacer"></div>

<div id="contactTabs" class="contentTabs">
	<ul class="contentTabsList">
		<li><span class="active" rel="PatientsTreatmentsFirst">Befundung</span></li>
		<li><span rel="PatientsTreatmentsSecond">Behandlungsplan</span></li>
	</ul>
    <div id="PatientsTreatmentsTabsContent" class="contentTabsContent">
        <div id="PatientsTreatmentsFirst">
        <div><a href="#" class="addDiagnose">Add</a> <a href="#" class="clearActive">Clear</a> <a href="#" class="undoDraw">Undo</a> <a href="#" class="erasor">erase</a> <a href="#" class="draw">draw</a></div>
        <table border="0" cellpadding="0" cellspacing="0" class="table-content">
                <tr>
                    <td style="width:400px;"><div style="position: relative;"><div class="canvasDiv">
                    <?php $i = 1; 
							$j = $treatment->diagnoses;
                        foreach($diagnose as $value) { 
							$active = '';
							if($i == 1) {
								$active = ' active';
							}
							?>
                            <canvas class="canvasDraw" id="c<?php echo $i;?>" width="400" height="400" style="z-index: <?php echo $j;?>" rel="<?php echo $value->id;?>"></canvas>
                            <div id="dia-<?php echo $value->id;?>" style="position: absolute; width: 30px; height: 30px; z-index: 10<?php echo $i;?>; top: <?php echo $value->y;?>px; left: <?php echo $value->x;?>px;" class="loadCanvas<?php echo $active;?>" rel="<?php echo $i;?>"><?php echo $i;?></div>
                        <?php 
						$i++;
						$j--;
						} ?>
                    </div></div></td>
                	<td valign="top"><div id="canvasDivText"><?php 
					$i = 1;
                        foreach($diagnose as $value) { 
						$active = '';
							if($i == 1) {
								$active = ' active';
							}
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
                	<td class="tcell-right-inactive tcell-right-nopadding text11">
                    <div id="patientstreatmenttasks">
						<?php 
                        foreach($task as $value) { 
                            include("task.php");
                         } ?>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
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
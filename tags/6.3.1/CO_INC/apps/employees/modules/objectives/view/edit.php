<div class="table-title-outer">
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["EMPLOYEE_OBJECTIVE_TITLE"];?></span></span></td>
    <td><input name="title" type="text" class="title textarea-title" value="<?php echo($objective->title);?>" maxlength="100" /></td>
  </tr>
  <tr class="table-title-status">
    <td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_STATUS"];?></td>
    <td colspan="2"><div class="statusTabs">
    	<ul>
        	<li><span class="left<?php if($objective->canedit) { ?> statusButton<?php } ?> planned<?php echo $objective->status_planned_active;?>" rel="0" reltext="<?php echo $lang["GLOBAL_STATUS_PLANNED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_PLANNED"];?></span></li>
            <li><span class="<?php if($objective->canedit) { ?>statusButton noDate<?php } ?> finished<?php echo $objective->status_finished_active;?>" rel="1" reltext=""><?php echo $lang["GLOBAL_STATUS_COMPLETED"];?></span></li>
            <li><span class="<?php if($objective->canedit) { ?>statusButton<?php } ?> stopped<?php echo $objective->status_stopped_active;?>" rel="2" reltext="<?php echo $lang["GLOBAL_STATUS_CANCELLED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_CANCELLED"];?></span></li>
			<li><span class="right<?php if($objective->canedit) { ?> statusButton<?php } ?> stopped<?php echo $objective->status_posponed_active;?>" rel="3" reltext="<?php echo $lang["GLOBAL_STATUS_POSPONED_TIME"];?>"><?php echo $lang["GLOBAL_STATUS_POSPONED"];?></span></li>
            <li><div class="status-time"><?php echo($objective->status_text_time)?></div><div class="status-input"><input name="objective_status_date" type="text" class="input-date statusdp" value="<?php echo($objective->status_date)?>" readonly="readonly" /></div></li>
		</ul></div></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($objective->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($objective->id);?>">
<input type="hidden" name="pid" value="<?php echo($objective->pid);?>">
<?php if($objective->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span>Warnung</span></span></strong></td>
		<td class="tcell-right"><strong>Dieser Inhaltsbereich wird aktuell bearbeitet von: <?php echo($objective->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($objective->checked_out_user_email);?>"><?php echo($objective->checked_out_user_email);?></a>, <?php echo($objective->checked_out_user_phone1);?></td>
    </tr>
</table>
<?php } ?>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>content-nav ui-datepicker-trigger-action<?php } ?>"><span><?php echo $lang["EMPLOYEE_OBJECTIVE_DATE"];?></span></span></td>
		<td class="tcell-right"><input name="item_date" type="text" class="input-date datepicker item_date" value="<?php echo($objective->item_date)?>" /></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>content-nav showDialogTime<?php } ?>" rel="employeesobjectivestart"><span><?php echo $lang["EMPLOYEE_OBJECTIVE_TIME_START"];?></span></span></td>
		<td class="tcell-right"><div id="employeesobjectivestart" class="itemlist-field"><?php echo($objective->start);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>content-nav showDialogTime<?php } ?>" rel="employeesobjectiveend"><span><?php echo $lang["EMPLOYEE_OBJECTIVE_TIME_END"];?></span></span></td>
		<td class="tcell-right"><div id="employeesobjectiveend" class="itemlist-field"><?php echo($objective->end);?></div></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialogPlace" field="employeeslocation" append="0"><span><?php echo $lang["EMPLOYEE_OBJECTIVE_PLACE"];?></span></span></td>
		<td class="tcell-right"><div id="employeeslocation" class="itemlist-field"><?php echo($objective->location);?></div><div id="employeeslocation_ct" class="itemlist-field"><a field="employeeslocation_ct" class="ct-content"><?php echo($objective->location_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span href="#" class="<?php if($objective->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="employeesparticipants" append="1"><span><?php echo $lang["EMPLOYEE_OBJECTIVE_ATTENDEES"];?></span></span></td>
		<td class="tcell-right"><div id="employeesparticipants" class="itemlist-field"><?php echo($objective->participants);?></div><div id="employeesparticipants_ct" class="itemlist-field"><a field="employeesparticipants_ct" class="ct-content"><?php echo($objective->participants_ct);?></a></div></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>content-nav showDialog<?php } ?>" request="getContactsDialog" field="employeesmanagement" append="1"><span><?php echo $lang["EMPLOYEE_OBJECTIVE_MANAGEMENT"];?></span></span></td>
		<td class="tcell-right"><div id="employeesmanagement" class="itemlist-field"><?php echo($objective->management);?></div><div id="employeesmanagement_ct" class="itemlist-field"><a field="employeesmanagement_ct" class="ct-content"><?php echo($objective->management_ct);?></a></div></td>
	</tr>
</table>
<div class="content-spacer"></div>

<div id="contactTabs" class="contentTabs grey">
	<ul class="contentTabsList">
		<li><span class="active" rel="EmployeesObjectivesFirst">MA-Zufriedenheit</span></li>
		<li><span rel="EmployeesObjectivesSecond">Leistungsbewertung</span></li>
        <li><span rel="EmployeesObjectivesThird">Zielsetzungen</span></li>
	</ul>
    <div id="EmployeesObjectivesTabsContent" class="contentTabsContent">
        <div id="EmployeesObjectivesFirst">
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11">&nbsp;</td>
		<td class="tcell-right-inactive tcell-right-nopadding text11"><div style="float: right; margin-right: 36px;">erreichte Zufriedenheit <span style="font-size: 13px; display: inline-block; text-align: right; width: 68px;" class="bold"><span id="tab1result"><?php echo $objective->tab1result;?></span>%</span></div></td>
    </tr>
</table>
			<!-- Q1 -->
        	<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin">
				<tr>
					<td class="tcell-left-phases-tasks text11">&nbsp;</td>
					<td class="tcell-right-nopadding">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-task">
                        <tr>
							<td width="20" style="padding-top: 4px;">&nbsp;</td>
                            <td style="padding: 2px 0 0 7px; font-weight: bold;"><?php echo $lang["EMPLOYEE_OBJECTIVE_TAB1_QUESTION_1"];?></td>
                            <td width="300" style="text-align: right;">
                                <div class="answers-outer" rel="tab1">
                                <?php for($i=0; $i<11; $i++) {
									$selected = '';
									if($i < 4) { $class = 'neg'; }
									if($i > 3 && $i < 7) { $class = 'med'; }
									if($i > 6 ) { $class = 'pos'; }
									if($objective->tab1q1_selected != "" && $i == $objective->tab1q1_selected) {
										$class .= ' active';
									}
									 echo '<span rel="q1" class="' . $class . '">' . $i . '</span>';
                                }
                                ?></div>
                        	</td>
                       </tr>
                      </table>
					</td>
				</tr>
			</table>
            <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
                <tr>
                    <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>selectTextarea<?php } ?>"><span>&nbsp;</span></span></td>
                    <td class="tcell-right"><?php if($objective->canedit) { ?><textarea name="tab1q1_text" class="elastic"><?php echo strip_tags($objective->tab1q1_text);?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($objective->tab1q1_text)));?><?php } ?></td>
                </tr>
            </table>
            <!-- Q2 -->
            <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin">
				<tr>
					<td class="tcell-left-phases-tasks text11">&nbsp;</td>
					<td class="tcell-right-nopadding">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-task">
                        <tr>
							<td width="20" style="padding-top: 4px;">&nbsp;</td>
                            <td style="padding: 2px 0 0 7px; font-weight: bold;"><?php echo $lang["EMPLOYEE_OBJECTIVE_TAB1_QUESTION_2"];?></td>
                            <td width="300" style="text-align: right;">
                                <div class="answers-outer" rel="tab1">
                                <?php for($i=0; $i<11; $i++) {
									$selected = '';
									if($i < 4) { $class = 'neg'; }
									if($i > 3 && $i < 7) { $class = 'med'; }
									if($i > 6 ) { $class = 'pos'; }
									if($objective->tab1q2_selected != "" && $i == $objective->tab1q2_selected) {
										$class .= ' active';
									}
									 echo '<span rel="q2" class="' . $class . '">' . $i . '</span>';
                                }
                                ?></div>
                        	</td>
                       </tr>
                      </table>
					</td>
				</tr>
			</table>
            <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
                <tr>
                    <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>selectTextarea<?php } ?>"><span>&nbsp;</span></span></td>
                    <td class="tcell-right"><?php if($objective->canedit) { ?><textarea name="tab1q2_text" class="elastic"><?php echo strip_tags($objective->tab1q2_text);?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($objective->tab1q2_text)));?><?php } ?></td>
                </tr>
            </table>
            <!-- Q3 -->
            <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin">
				<tr>
					<td class="tcell-left-phases-tasks text11">&nbsp;</td>
					<td class="tcell-right-nopadding">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-task">
                        <tr>
							<td width="20" style="padding-top: 4px;">&nbsp;</td>
                            <td style="padding: 2px 0 0 7px; font-weight: bold;"><?php echo $lang["EMPLOYEE_OBJECTIVE_TAB1_QUESTION_3"];?></td>
                            <td width="300" style="text-align: right;">
                                <div class="answers-outer" rel="tab1">
                                <?php for($i=0; $i<11; $i++) {
									$selected = '';
									if($i < 4) { $class = 'neg'; }
									if($i > 3 && $i < 7) { $class = 'med'; }
									if($i > 6 ) { $class = 'pos'; }
									if($objective->tab1q3_selected != "" && $i == $objective->tab1q3_selected) {
										$class .= ' active';
									}
									 echo '<span rel="q3" class="' . $class . '">' . $i . '</span>';
                                }
                                ?></div>
                        	</td>
                       </tr>
                      </table>
					</td>
				</tr>
			</table>
            <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
                <tr>
                    <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>selectTextarea<?php } ?>"><span>&nbsp;</span></span></td>
                    <td class="tcell-right"><?php if($objective->canedit) { ?><textarea name="tab1q3_text" class="elastic"><?php echo strip_tags($objective->tab1q3_text);?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($objective->tab1q3_text)));?><?php } ?></td>
                </tr>
            </table>
            <!-- Q4 -->
            <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin">
				<tr>
					<td class="tcell-left-phases-tasks text11">&nbsp;</td>
					<td class="tcell-right-nopadding">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-task">
                        <tr>
							<td width="20" style="padding-top: 4px;">&nbsp;</td>
                            <td style="padding: 2px 0 0 7px; font-weight: bold;"><?php echo $lang["EMPLOYEE_OBJECTIVE_TAB1_QUESTION_4"];?></td>
                            <td width="300" style="text-align: right;">
                                <div class="answers-outer" rel="tab1">
                                <?php for($i=0; $i<11; $i++) {
									$selected = '';
									if($i < 4) { $class = 'neg'; }
									if($i > 3 && $i < 7) { $class = 'med'; }
									if($i > 6 ) { $class = 'pos'; }
									if($objective->tab1q4_selected != "" && $i == $objective->tab1q4_selected) {
										$class .= ' active';
									}
									 echo '<span rel="q4" class="' . $class . '">' . $i . '</span>';
                                }
                                ?></div>
                        	</td>
                       </tr>
                      </table>
					</td>
				</tr>
			</table>
            <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
                <tr>
                    <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>selectTextarea<?php } ?>"><span>&nbsp;</span></span></td>
                    <td class="tcell-right"><?php if($objective->canedit) { ?><textarea name="tab1q4_text" class="elastic"><?php echo strip_tags($objective->tab1q4_text);?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($objective->tab1q4_text)));?><?php } ?></td>
                </tr>
            </table>
            
             <!-- Q5 -->
            <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin">
				<tr>
					<td class="tcell-left-phases-tasks text11">&nbsp;</td>
					<td class="tcell-right-nopadding">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-task">
                        <tr>
							<td width="20" style="padding-top: 4px;">&nbsp;</td>
                            <td style="padding: 2px 0 0 7px; font-weight: bold;"><?php echo $lang["EMPLOYEE_OBJECTIVE_TAB1_QUESTION_5"];?></td>
                            <td width="300" style="text-align: right;">
                                <div class="answers-outer" rel="tab1">
                                <?php for($i=0; $i<11; $i++) {
									$selected = '';
									if($i < 4) { $class = 'neg'; }
									if($i > 3 && $i < 7) { $class = 'med'; }
									if($i > 6 ) { $class = 'pos'; }
									if($objective->tab1q5_selected != "" && $i == $objective->tab1q5_selected) {
										$class .= ' active';
									}
									 echo '<span rel="q5" class="' . $class . '">' . $i . '</span>';
                                }
                                ?></div>
                        	</td>
                       </tr>
                      </table>
					</td>
				</tr>
			</table>
            <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
                <tr>
                    <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>selectTextarea<?php } ?>"><span>&nbsp;</span></span></td>
                    <td class="tcell-right"><?php if($objective->canedit) { ?><textarea name="tab1q5_text" class="elastic"><?php echo strip_tags($objective->tab1q5_text);?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($objective->tab1q5_text)));?><?php } ?></td>
                </tr>
            </table>
            
        </div>
        <div id="EmployeesObjectivesSecond" style="display: none;">
            <table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11">&nbsp;</td>
		<td class="tcell-right-inactive tcell-right-nopadding text11"><div style="float: right; margin-right: 36px;">erreichte Leistung <span style="font-size: 13px; display: inline-block; text-align: right; width: 68px;" class="bold"><span id="tab2result"><?php echo $objective->tab2result;?></span>%</span></div></td>
    </tr>
</table>
            <!-- Q1 -->
        	<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin">
				<tr>
					<td class="tcell-left-phases-tasks text11">&nbsp;</td>
					<td class="tcell-right-nopadding">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-task">
                        <tr>
							<td width="20" style="padding-top: 4px;">&nbsp;</td>
                            <td style="padding: 2px 0 0 7px; font-weight: bold;"><?php echo $lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_1"];?></td>
                            <td width="300" style="text-align: right;">
                                <div class="answers-outer" rel="tab2">
                                <?php for($i=0; $i<11; $i++) {
									$selected = '';
									if($i < 4) { $class = 'neg'; }
									if($i > 3 && $i < 7) { $class = 'med'; }
									if($i > 6 ) { $class = 'pos'; }
									if($objective->tab2q1_selected != "" && $i == $objective->tab2q1_selected) {
										$class .= ' active';
									}
									 echo '<span rel="q1" class="' . $class . '">' . $i . '</span>';
                                }
                                ?></div>
                        	</td>
                       </tr>
                      </table>
					</td>
				</tr>
			</table>
            <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
                <tr>
                    <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>selectTextarea<?php } ?>"><span>&nbsp;</span></span></td>
                    <td class="tcell-right"><?php if($objective->canedit) { ?><textarea name="tab2q1_text" class="elastic"><?php echo strip_tags($objective->tab2q1_text);?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($objective->tab2q1_text)));?><?php } ?></td>
                </tr>
            </table>
            
            <!-- Q2 -->
        	<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin">
				<tr>
					<td class="tcell-left-phases-tasks text11">&nbsp;</td>
					<td class="tcell-right-nopadding">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-task">
                        <tr>
							<td width="20" style="padding-top: 4px;">&nbsp;</td>
                            <td style="padding: 2px 0 0 7px; font-weight: bold;"><?php echo $lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_2"];?></td>
                            <td width="300" style="text-align: right;">
                                <div class="answers-outer" rel="tab2">
                                <?php for($i=0; $i<11; $i++) {
									$selected = '';
									if($i < 4) { $class = 'neg'; }
									if($i > 3 && $i < 7) { $class = 'med'; }
									if($i > 6 ) { $class = 'pos'; }
									if($objective->tab2q2_selected != "" && $i == $objective->tab2q2_selected) {
										$class .= ' active';
									}
									 echo '<span rel="q2" class="' . $class . '">' . $i . '</span>';
                                }
                                ?></div>
                        	</td>
                       </tr>
                      </table>
					</td>
				</tr>
			</table>
            <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
                <tr>
                    <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>selectTextarea<?php } ?>"><span>&nbsp;</span></span></td>
                    <td class="tcell-right"><?php if($objective->canedit) { ?><textarea name="tab2q2_text" class="elastic"><?php echo strip_tags($objective->tab2q2_text);?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($objective->tab2q2_text)));?><?php } ?></td>
                </tr>
            </table>
            
            <!-- Q3 -->
        	<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin">
				<tr>
					<td class="tcell-left-phases-tasks text11">&nbsp;</td>
					<td class="tcell-right-nopadding">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-task">
                        <tr>
							<td width="20" style="padding-top: 4px;">&nbsp;</td>
                            <td style="padding: 2px 0 0 7px; font-weight: bold;"><?php echo $lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_3"];?></td>
                            <td width="300" style="text-align: right;">
                                <div class="answers-outer" rel="tab2">
                                <?php for($i=0; $i<11; $i++) {
									$selected = '';
									if($i < 4) { $class = 'neg'; }
									if($i > 3 && $i < 7) { $class = 'med'; }
									if($i > 6 ) { $class = 'pos'; }
									if($objective->tab2q3_selected != "" && $i == $objective->tab2q3_selected) {
										$class .= ' active';
									}
									 echo '<span rel="q3" class="' . $class . '">' . $i . '</span>';
                                }
                                ?></div>
                        	</td>
                       </tr>
                      </table>
					</td>
				</tr>
			</table>
            <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
                <tr>
                    <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>selectTextarea<?php } ?>"><span>&nbsp;</span></span></td>
                    <td class="tcell-right"><?php if($objective->canedit) { ?><textarea name="tab2q3_text" class="elastic"><?php echo strip_tags($objective->tab2q3_text);?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($objective->tab2q3_text)));?><?php } ?></td>
                </tr>
            </table>
            
            <!-- Q4 -->
        	<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin">
				<tr>
					<td class="tcell-left-phases-tasks text11">&nbsp;</td>
					<td class="tcell-right-nopadding">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-task">
                        <tr>
							<td width="20" style="padding-top: 4px;">&nbsp;</td>
                            <td style="padding: 2px 0 0 7px; font-weight: bold;"><?php echo $lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_4"];?></td>
                            <td width="300" style="text-align: right;">
                                <div class="answers-outer" rel="tab2">
                                <?php for($i=0; $i<11; $i++) {
									$selected = '';
									if($i < 4) { $class = 'neg'; }
									if($i > 3 && $i < 7) { $class = 'med'; }
									if($i > 6 ) { $class = 'pos'; }
									if($objective->tab2q4_selected != "" && $i == $objective->tab2q4_selected) {
										$class .= ' active';
									}
									 echo '<span rel="q4" class="' . $class . '">' . $i . '</span>';
                                }
                                ?></div>
                        	</td>
                       </tr>
                      </table>
					</td>
				</tr>
			</table>
            <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
                <tr>
                    <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>selectTextarea<?php } ?>"><span>&nbsp;</span></span></td>
                    <td class="tcell-right"><?php if($objective->canedit) { ?><textarea name="tab2q4_text" class="elastic"><?php echo strip_tags($objective->tab2q4_text);?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($objective->tab2q4_text)));?><?php } ?></td>
                </tr>
            </table>
            
            <!-- Q5 -->
        	<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin">
				<tr>
					<td class="tcell-left-phases-tasks text11">&nbsp;</td>
					<td class="tcell-right-nopadding">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-task">
                        <tr>
							<td width="20" style="padding-top: 4px;">&nbsp;</td>
                            <td style="padding: 2px 0 0 7px; font-weight: bold;"><?php echo $lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_5"];?></td>
                            <td width="300" style="text-align: right;">
                                <div class="answers-outer" rel="tab2">
                                <?php for($i=0; $i<11; $i++) {
									$selected = '';
									if($i < 4) { $class = 'neg'; }
									if($i > 3 && $i < 7) { $class = 'med'; }
									if($i > 6 ) { $class = 'pos'; }
									if($objective->tab2q5_selected != "" && $i == $objective->tab2q5_selected) {
										$class .= ' active';
									}
									 echo '<span rel="q5" class="' . $class . '">' . $i . '</span>';
                                }
                                ?></div>
                        	</td>
                       </tr>
                      </table>
					</td>
				</tr>
			</table>
            <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
                <tr>
                    <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>selectTextarea<?php } ?>"><span>&nbsp;</span></span></td>
                    <td class="tcell-right"><?php if($objective->canedit) { ?><textarea name="tab2q5_text" class="elastic"><?php echo strip_tags($objective->tab2q5_text);?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($objective->tab2q5_text)));?><?php } ?></td>
                </tr>
            </table>
            
            <!-- Q6 -->
        	<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin">
				<tr>
					<td class="tcell-left-phases-tasks text11">&nbsp;</td>
					<td class="tcell-right-nopadding">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-task">
                        <tr>
							<td width="20" style="padding-top: 4px;">&nbsp;</td>
                            <td style="padding: 2px 0 0 7px; font-weight: bold;"><?php echo $lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_6"];?></td>
                            <td width="300" style="text-align: right;">
                                <div class="answers-outer" rel="tab2">
                                <?php for($i=0; $i<11; $i++) {
									$selected = '';
									if($i < 4) { $class = 'neg'; }
									if($i > 3 && $i < 7) { $class = 'med'; }
									if($i > 6 ) { $class = 'pos'; }
									if($objective->tab2q6_selected != "" && $i == $objective->tab2q6_selected) {
										$class .= ' active';
									}
									 echo '<span rel="q6" class="' . $class . '">' . $i . '</span>';
                                }
                                ?></div>
                        	</td>
                       </tr>
                      </table>
					</td>
				</tr>
			</table>
            <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
                <tr>
                    <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>selectTextarea<?php } ?>"><span>&nbsp;</span></span></td>
                    <td class="tcell-right"><?php if($objective->canedit) { ?><textarea name="tab2q6_text" class="elastic"><?php echo strip_tags($objective->tab2q6_text);?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($objective->tab2q6_text)));?><?php } ?></td>
                </tr>
            </table>
            
            <!-- Q7 -->
        	<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin">
				<tr>
					<td class="tcell-left-phases-tasks text11">&nbsp;</td>
					<td class="tcell-right-nopadding">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-task">
                        <tr>
							<td width="20" style="padding-top: 4px;">&nbsp;</td>
                            <td style="padding: 2px 0 0 7px; font-weight: bold;"><?php echo $lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_7"];?></td>
                            <td width="300" style="text-align: right;">
                                <div class="answers-outer" rel="tab2">
                                <?php for($i=0; $i<11; $i++) {
									$selected = '';
									if($i < 4) { $class = 'neg'; }
									if($i > 3 && $i < 7) { $class = 'med'; }
									if($i > 6 ) { $class = 'pos'; }
									if($objective->tab2q7_selected != "" && $i == $objective->tab2q7_selected) {
										$class .= ' active';
									}
									 echo '<span rel="q7" class="' . $class . '">' . $i . '</span>';
                                }
                                ?></div>
                        	</td>
                       </tr>
                      </table>
					</td>
				</tr>
			</table>
            <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
                <tr>
                    <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>selectTextarea<?php } ?>"><span>&nbsp;</span></span></td>
                    <td class="tcell-right"><?php if($objective->canedit) { ?><textarea name="tab2q7_text" class="elastic"><?php echo strip_tags($objective->tab2q7_text);?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($objective->tab2q7_text)));?><?php } ?></td>
                </tr>
            </table>
            
            <!-- Q8 -->
        	<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin">
				<tr>
					<td class="tcell-left-phases-tasks text11">&nbsp;</td>
					<td class="tcell-right-nopadding">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-task">
                        <tr>
							<td width="20" style="padding-top: 4px;">&nbsp;</td>
                            <td style="padding: 2px 0 0 7px; font-weight: bold;"><?php echo $lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_8"];?></td>
                            <td width="300" style="text-align: right;">
                                <div class="answers-outer" rel="tab2">
                                <?php for($i=0; $i<11; $i++) {
									$selected = '';
									if($i < 4) { $class = 'neg'; }
									if($i > 3 && $i < 7) { $class = 'med'; }
									if($i > 6 ) { $class = 'pos'; }
									if($objective->tab2q8_selected != "" && $i == $objective->tab2q8_selected) {
										$class .= ' active';
									}
									 echo '<span rel="q8" class="' . $class . '">' . $i . '</span>';
                                }
                                ?></div>
                        	</td>
                       </tr>
                      </table>
					</td>
				</tr>
			</table>
            <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
                <tr>
                    <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>selectTextarea<?php } ?>"><span>&nbsp;</span></span></td>
                    <td class="tcell-right"><?php if($objective->canedit) { ?><textarea name="tab2q8_text" class="elastic"><?php echo strip_tags($objective->tab2q8_text);?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($objective->tab2q8_text)));?><?php } ?></td>
                </tr>
            </table>
            
            <!-- Q9 -->
        	<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin">
				<tr>
					<td class="tcell-left-phases-tasks text11">&nbsp;</td>
					<td class="tcell-right-nopadding">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-task">
                        <tr>
							<td width="20" style="padding-top: 4px;">&nbsp;</td>
                            <td style="padding: 2px 0 0 7px; font-weight: bold;"><?php echo $lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_9"];?></td>
                            <td width="300" style="text-align: right;">
                                <div class="answers-outer" rel="tab2">
                                <?php for($i=0; $i<11; $i++) {
									$selected = '';
									if($i < 4) { $class = 'neg'; }
									if($i > 3 && $i < 7) { $class = 'med'; }
									if($i > 6 ) { $class = 'pos'; }
									if($objective->tab2q9_selected != "" && $i == $objective->tab2q9_selected) {
										$class .= ' active';
									}
									 echo '<span rel="q9" class="' . $class . '">' . $i . '</span>';
                                }
                                ?></div>
                        	</td>
                       </tr>
                      </table>
					</td>
				</tr>
			</table>
            <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
                <tr>
                    <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>selectTextarea<?php } ?>"><span>&nbsp;</span></span></td>
                    <td class="tcell-right"><?php if($objective->canedit) { ?><textarea name="tab2q9_text" class="elastic"><?php echo strip_tags($objective->tab2q9_text);?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($objective->tab2q9_text)));?><?php } ?></td>
                </tr>
            </table>
            
            <!-- Q10 -->
        	<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive no-margin">
				<tr>
					<td class="tcell-left-phases-tasks text11">&nbsp;</td>
					<td class="tcell-right-nopadding">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-task">
                        <tr>
							<td width="20" style="padding-top: 4px;">&nbsp;</td>
                            <td style="padding: 2px 0 0 7px; font-weight: bold;"><?php echo $lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_10"];?></td>
                            <td width="300" style="text-align: right;">
                                <div class="answers-outer" rel="tab2">
                                <?php for($i=0; $i<11; $i++) {
									$selected = '';
									if($i < 4) { $class = 'neg'; }
									if($i > 3 && $i < 7) { $class = 'med'; }
									if($i > 6 ) { $class = 'pos'; }
									if($objective->tab2q10_selected != "" && $i == $objective->tab2q10_selected) {
										$class .= ' active';
									}
									 echo '<span rel="q10" class="' . $class . '">' . $i . '</span>';
                                }
                                ?></div>
                        	</td>
                       </tr>
                      </table>
					</td>
				</tr>
			</table>
            <table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
                <tr>
                    <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>selectTextarea<?php } ?>"><span>&nbsp;</span></span></td>
                    <td class="tcell-right"><?php if($objective->canedit) { ?><textarea name="tab2q10_text" class="elastic"><?php echo strip_tags($objective->tab2q10_text);?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($objective->tab2q10_text)));?><?php } ?></td>
                </tr>
            </table>
		</div>
        <div id="EmployeesObjectivesThird" style="display: none;">
			<table border="0" cellpadding="0" cellspacing="0" class="table-content addTaskTable">
                <tr>
                    <td class="tcell-left text11">
                    <span class="<?php if($objective->canedit) { ?>content-nav newItem<?php } ?>"><span><?php echo $lang["EMPLOYEE_OBJECTIVE_GOALS"];?></span></span>
                    </td>
                	<td class="tcell-right-inactive tcell-right-nopadding text11"><div style="float: right; margin-right: 70px;">erreichte Zielsetzungen<span style="font-size: 13px; display: inline-block; text-align: right; width: 68px;" class="bold"><span id="tab3result"><?php echo $objective->tab3result;?></span>%</span></div></td>
                </tr>
            </table><div id="employeesobjectivetasks">
            <?php 
            foreach($task as $value) { 
            	include("task.php");
             } ?>
            </div>
        </div>
    </div>
</div>
<?php if($objective->perms != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($objective->canedit) { ?>content-nav showDialog<?php } ?>" request="getAccessDialog" field="employeesobjective_access" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></span></td>
        <td class="tcell-right"><div id="employeesobjective_access" class="itemlist-field"><div class="listmember" field="employeesobjective_access" uid="<?php echo($objective->access);?>" style="float: left"><?php echo($objective->access_text);?></div></div><input type="hidden" name="objective_access_orig" value="<?php echo($objective->access);?>" /></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="employeesobjective_sendto">
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
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($objective->edited_user.", ".$objective->edited_date)?></td>
    <td class="middle"><?php echo $objective->access_footer;?></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($objective->created_user.", ".$objective->created_date);?></td>
  </tr>
</table>
</div>
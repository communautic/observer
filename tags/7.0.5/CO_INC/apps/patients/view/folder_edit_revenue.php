<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11">Berechnungsfilter</td>
		<td class="tcell-right-inactive tcell-right-nopadding"></td>
    </tr>
</table>

<div style="background: #d2dcff; border-bottom: 1px solid #ccc; padding-bottom: 10px;">
   <table border="0" cellspacing="0" cellpadding="0" style="margin-left: 141px;">
    <tr>
        <td width="158"><span style="color: #666; font-size: 11px; line-height: 30px; padding-left: 11px;">Betreuung</span></td>
        <td width="158">Patient</td>
        <td width="79"><span style="color: #666; font-size: 11px; line-height: 30px; padding-left: 11px;"><?php echo $lang["GLOBAL_TIME_FROM"];?></span></td>
        <td width="89"><span style="color: #666; font-size: 11px; line-height: 30px; padding-left: 11px;"><?php echo $lang["GLOBAL_TIME_TO"];?></span></td>
        <!--<td width="79"><span style="color: #666; font-size: 11px; line-height: 30px;">alle Ordner</span></td>-->
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><input id="calcWhoField" name="who" type="text" class="inlineSearch" rel="patients" placeholder="Alle" /><input name="who" type="hidden" id="calcWho" value="0" /></td>
        <td><input id="calcPatientField" name="patient" type="text" class="inlineSearch" rel="patients" placeholder="Alle" /><input name="patient" type="hidden" id="calcPatient" value="0" /></td>
        <td><input name="startdate" type="text" id="calcStart" value="<?php echo $start_date;?>" class="inlineDatepicker" /></td>
        <td><input name="enddate" type="text" id="calcEnd" value="<?php echo $end_date;?>" class="inlineDatepicker" /><span rel="0" id="calcFolder" class="inlineCheckbox coCheckbox inline" style="display: none;"></span></td>
        <!--<td></td>-->
         <td><span id="calculateRevenue" class="bold"><em><span class="contentArrow"></span> <?php echo $lang["PATIENT_FOLDER_TAB_CALCULATE"];?></em></span></td>
    </tr>
</table>
</div>
<div style="background: #d2dcff; border-top: 1px solid #fff; border-bottom: 1px solid #ccc; padding-top: 8px; padding-bottom: 8px;">
   <table border="0" cellspacing="0" cellpadding="0" style="margin-left: 150px;">
     <tr>
        <td width="158">
        	<table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><span class="toggleFilter coCheckbox active" rel="bezahlt"></span></td><td>bezahlt</td>
            </tr>
            <tr>
            <td><span class="toggleFilter coCheckbox active" rel="ausstaendig"></span></td><td>ausständig</td>
            </tr>
					</table>
        </td>
        <td width="158">
        	<table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><span class="toggleFilter coCheckbox active" rel="ueberweisung"></span></td><td>Überweisung</td>
            </tr>
            <tr>
              <td><span class="toggleFilter coCheckbox active" rel="barzahlung"></span></td><td>Barzahlung</td>
            </tr>
					</table>
        </td>
        <td width="158">
        	<table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><span class="toggleFilter coCheckbox active" rel="behandlung"></span></td><td>Behandlung</td>
            </tr>
            <tr>
            	<td><span class="toggleFilter coCheckbox active" rel="zusatzleistung"></span></td><td>Zusatzleistung</td>
            </tr>
					</table>
        </td>
        <td></td>
        <!--<td></td>-->
         <td></td>
    </tr>
</table>
</div>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11" style="color: #000;"><span class="co-link toggleDiv" rel="viewFilter">Zusatzauswahl</span></td>
		<td class="tcell-right-inactive tcell-right-nopadding"></td>
    </tr>
</table>
<div id="viewFilter" style="background: #d2dcff; border-bottom: 1px solid #ccc; padding-top: 8px; padding-bottom: 8px; display: none;">
   <table border="0" cellspacing="0" cellpadding="0" style="margin-left: 150px;">
			<tr>
        <td width="158">
        	<table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><span class="toggleDetails coCheckbox" rel="patient"></span></td><td>Patientenname</td>
            </tr>
            <tr>
            	<td><span class="toggleDetails coCheckbox" rel="dob"></span></td><td>Geburtsdatum</td>
            </tr>
            <tr>
            	<td><span class="toggleDetails coCheckbox" rel="alter"></span></td><td>Alter</td>
              
            </tr>
					</table>
        </td>
        <td width="158">
        	<table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><span class="toggleDetails coCheckbox" rel="betreuung"></span></td><td>Betreuung</td>
            </tr>
            <tr>
              <td><span class="toggleDetails coCheckbox" rel="dauer"></span></td><td>Dauer</td>
            </tr>
            <tr>
            	<td><span class="toggleDetails coCheckbox" rel="ort"></span></td><td>Ort</td>
              
            </tr>
					</table>
        </td>
        <td width="168">
        	<table border="0" cellspacing="0" cellpadding="0">
            <tr>
            	<td><span class="toggleDetails coCheckbox" rel="arbeitszeit"></span></td><td>Arbeitszeit</td>
            </tr>
            <tr>
            	<td><span class="toggleDetails coCheckbox" rel="rechnungsdatum"></span></td><td>Rechnungsdatum</td>
            </tr>
            <tr>
              <td><span class="toggleDetails coCheckbox" rel="rechnungsnummer"></span></td><td>Rechnungsnummer</td>
            </tr>
					</table>
        </td>
        <td>
        	<table border="0" cellspacing="0" cellpadding="0">
            <tr>
            	<td><span class="toggleDetails coCheckbox" rel="gender"></span></td><td>Geschlecht</td>       
            </tr>
            <tr>
              <td><span class="toggleDetails coCheckbox" rel="agegroup"></span></td><td>Altersgruppe</td>
            </tr>
            <tr>
              <td><span style="height: 25px; display: inline-block;">&nbsp;</span></td>
            </tr>
					</table>
        </td>
        <!--<td></td>-->
         <td></td>
    </tr>
</table>
</div>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11" style="color: #000;"><span class="co-link toggleDiv" rel="statisticFilter">Statistikauswertung</span></td>
		<td class="tcell-right-inactive tcell-right-nopadding"></td>
    </tr>
</table>
<div id="statisticFilter"  style="background: #d2dcff; border-bottom: 1px solid #ccc; padding-top: 8px; padding-bottom: 8px; display: none;">
   <table border="0" cellspacing="0" cellpadding="0" style="margin-left: 150px;">
     <tr>
        <td width="158">
        	<table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><span class="toggleStats coCheckbox"  rel="gender"></span></td><td>Geschlecht</td>
            </tr>
					</table>
        </td>
        <td width="158">
        	<table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><span class="toggleStats coCheckbox"  rel="agegroups"></span></td><td>Altersgruppe</td>
            </tr>
					</table>
        </td>
    </tr>
</table>
</div>
<div class="content-spacer"></div>
<div id="revenueResult">
</div>
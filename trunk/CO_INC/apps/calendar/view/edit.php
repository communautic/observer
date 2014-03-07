<div id="event" title="Termin">
	<form id="event_form">
    <input type="hidden" name="EventId" value="<?php echo $eventid;?>">
    <input type="hidden" id="request" name="request" value="editEvent" />
    
    <!-- Calendar -->
    <div class="fieldset2 tohide">
		<label>
        	<span append="0" field="calendarsField" request="getCalendarsDialog" class="content-nav showDialog"><span>Kalender</span></span>
		</label>
		<div class="contacts">
			<div class="itemlist-field" id="calendarsField">
            <?php
		foreach ($calendars as $calendar) {
			if($calendarid == $calendar->calendarid) {
				echo('<span class="listmember" uid="'.$calendar->calendarid.'">'.$calendar->lastname . " " . $calendar->firstname.' </span>');
			}
		}?>
            </div>
		</div>
		<div style="clear: both;"></div>
	</div>
    <input id="calendar-calendar" type="hidden" value="<?php echo $calendarid;?>" name="calendar" />

    <!-- Event Type -->
    <div class="fieldset2 tohide">
		<label>
        	<span append="1" field="calendarEventTypes" request="getEventTypesDialog" class="content-nav showDialog"><span>Terminart</span></span>
		</label>
		<div class="contacts">
            <div class="itemlist-field" id="calendarEventTypes"><span uid="<?php echo $eventtype;?>" class="listmember"><?php echo $lang["EVENTTYPE"][$eventtype];?></span></div>
		</div>
		<div style="clear: both;"></div>
	</div>
    <input id="eventtype" type="hidden" value="<?php echo $eventtype;?>" name="eventtype" />
    
    <!-- Event Title -->
    <div id="titleDisplay" class="fieldset2 tohide" <?php echo $regularEventDisplay;?>>
		<label>Titel</label>
		<div class="dates">
			<input id="event-title" type="text" size="100" value="<?php echo $summary;?>" maxlength="100" name="title" autofocus="autofocus" />
		</div>
		<div style="clear: both;"></div>
	</div>
    
    
    <!-- Treatment -->
    <div id="treatmentDisplay" class="fieldset2 tohide" <?php echo $treatmentEventDisplay;?>>
		<label>
        	<span append="0" field="calendarTreatmentTitle" request="getTreatmentsDialog" class="content-nav showDialog"><span>Behandlung</span></span>
		</label>
		<div class="contacts">
			<div class="itemlist-field" id="calendarTreatmentTitle"><?php echo $treatmenttitle;?></div>
		</div>
		<div style="clear: both;"></div>
	</div>
    <input id="event-treatment" type="hidden" value="<?php echo $treatid;?>" name="treatmentid" />

	<!-- Location -->
    <!--<div id="treatmentLocDisplay" class="fieldset2 tohide" <?php echo $treatmentEventDisplay;?>>-->
    <div class="fieldset2 tohide">
		<label>
        	<span id="EventLocDisplay" append="0" field="calendarTreatmentLocation" request="getTreatmentsLocationsDialog" class="content-nav showDialog"><span>Ort</span></span>
		</label>
		<div class="contacts">
			<div class="itemlist-field" id="calendarTreatmentLocation"><?php echo $location;?></div>
		</div>
		<div style="clear: both;"></div>
	</div>
    <input id="event-location" type="hidden" value="<?php echo $location;?>" name="location" />
    <input id="treatment-location" type="hidden" value="<?php echo $eventlocation;?>" name="treatmentlocationid" />
    <input id="treatment-locationuid" type="hidden" value="<?php echo $eventlocationuid;?>" name="treatmentlocationuid" />

    <!-- Date From -->
    <div class="fieldset2 tohide">
		<label>
        	<span class="content-nav ui-datepicker-trigger-action"><span>Datum</span></span>
		</label>
		<div class="dates"><input name="from" id="from" type="text" class="input-date datepicker item_date" value="<?php echo $startdate;?>" readonly="readonly" /></div>
		<div style="clear: both;"></div>
	</div>
    
    <!-- Date To -->
    <div id="dateToDisplay" class="fieldset2 tohide"  <?php echo $regularEventDisplay;?>>
		<label>
        	<span class="content-nav ui-datepicker-trigger-action"><span>Datum bis</span></span>
		</label>
		<div class="dates"><input name="to" id="to" type="text" class="input-date datepicker item_date" value="<?php echo $enddate;?>" readonly="readonly" /></div>
		<div style="clear: both;"></div>
	</div>
    
    <!-- Time From -->
    <div class="fieldset2 tohide">
		<label>
        	<span class="content-nav showDialogTimeCalendar" rel="fromtime"><span>von</span></span>
		</label>
		<div class="dates"><input type="time" value="<?php echo $starttime;?>" name="fromtime" id="fromtime" readonly="readonly" />
        </div>
		<div style="clear: both;"></div>
	</div>
    
    <!-- Time To -->
    <div class="fieldset2 tohide">
		<label>
        	<span class="content-nav showDialogTimeCalendar" rel="totime"><span>bis</span></span>
		</label>
		<div class="dates"><input type="time" value="<?php echo $endtime;?>" name="totime" id="totime" readonly="readonly" /></div>
		<div style="clear: both;"></div>
	</div>
	
    
    <!-- Event All-Day -->
    <div id="allDayDisplay" class="fieldset2 tohide" <?php echo $regularEventDisplay;?>>
		<label>All Day Event</label>
		<div class="dates">
			<input id="allday_checkbox" type="checkbox" name="allday" <?php if($allday) { echo 'checked="checked"';} ?>>
		</div>
		<div style="clear: both;"></div>
	</div>

    <!-- Description -->
    <div class="fieldset">
        <label>Beschreibung</label>
        <textarea id="event-description" name="description"><?php echo $description;?></textarea>
	</div>
    	
	<div class="coButton-outer"  style="float: left;"><span class="content-nav coButton" id="submitEditEvent" data-link="/?path=apps/calendar/">Speichern</span></div>
        
	<div class="coButton-outer" style="float: right;"><span class="content-nav coButton delete" id="submitDeleteEvent" data-link="/?path=apps/calendar/">L&ouml;schen</span></div>
	</form>
</div>
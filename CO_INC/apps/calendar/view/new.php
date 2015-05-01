<div id="event" title="<?php echo $lang["CALENDAR_EVENT_NEW"];?>">
	<form id="event_form">
    <input type="hidden" value="apps/calendar/" name="path" id="path">
    <input type="hidden" name="request" value="newEvent" />
    
    
    <!-- Calendar -->
    <div class="fieldset2">
		<label>
        	<span append="0" field="calendarsField" request="getCalendarsDialog" class="content-nav showDialog"><span><?php echo $lang["CALENDAR_CALENDAR"];?></span></span>
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
    <div class="fieldset2 whitebg fieldborder-bottom">
		<label>
        	<span append="1" field="calendarEventTypes" request="getEventTypesDialog" class="content-nav showDialog"><span><?php echo $lang["CALENDAR_EVENT_TYPE"];?></span></span>
		</label>
		<div class="contacts">
            <div class="itemlist-field" id="calendarEventTypes"><span uid="<?php echo $eventtype;?>" class="listmember"><?php echo $lang["EVENTTYPE"][$eventtype];?></span></div>
		</div>
		<div style="clear: both;"></div>
	</div>
    <input id="eventtype" type="hidden" value="<?php echo $eventtype;?>" name="eventtype" />
    
    <!-- Event Title -->
    <div id="titleDisplay" class="fieldset2" <?php echo $regularEventDisplay;?>>
		<label style="width: 79px;"><?php echo $lang["CALENDAR_EVENT_TITLE"];?></label>
		<div class="dates" style="width: 187px;">
			<input id="event-title" type="text" size="100" value="" maxlength="100" name="title" autofocus="autofocus" />
		</div>
		<div style="clear: both;"></div>
	</div>
    
    <!-- Treatment -->
    <div id="treatmentDisplay" class="fieldset2" <?php echo $treatmentEventDisplay;?>>
		<label>
        	<span append="0" field="calendarTreatmentTitle" request="getTreatmentsDialog" class="content-nav showDialog"><span><?php echo $lang["PATIENT_TREATMENT_TITLE"];?></span></span>
		</label>
		<div class="contacts">
			<div class="itemlist-field" id="calendarTreatmentTitle"></div>
		</div>
		<div style="clear: both;"></div>
	</div>
    <input id="event-treatment" type="hidden" value="0" name="treatmentid" />

	<!-- Location -->
    <div class="fieldset2">
		<label>
        	<span append="0" field="calendarTreatmentLocation" request="getTreatmentsLocationsDialog" class="content-nav showDialog"><span><?php echo $lang["CALENDAR_EVENT_LOCATION"];?></span></span>
		</label>
		<div class="contacts">
			<div class="itemlist-field" id="calendarTreatmentLocation"></div>
		</div>
		<div style="clear: both;"></div>
	</div>
    <input id="event-location" type="hidden" value="" name="location" />
    <input id="treatment-location" type="hidden" value="0" name="treatmentlocationid" />
    <input id="treatment-locationuid" type="hidden" value="0" name="treatmentlocationuid" />

	<!-- Date From -->
    <div class="fieldset2 whitebg">
		<label>
        	<span class="content-nav ui-datepicker-trigger-action"><span><?php echo $lang["CALENDAR_EVENT_DATE_FROM"];?></span></span>
		</label>
		<div class="dates"><input name="from" id="from" type="text" class="input-date datepicker item_date" value="<?php echo $startdate;?>" readonly="readonly" /></div>
		<div style="clear: both;"></div>
	</div>
    
    <!-- Date To -->
    <div id="dateToDisplay" class="fieldset2 whitebg"  <?php echo $regularEventDisplay;?>>
		<label>
        	<span class="content-nav ui-datepicker-trigger-action"><span><?php echo $lang["CALENDAR_EVENT_DATE_TO"];?></span></span>
		</label>
		<div class="dates"><input name="to" id="to" type="text" class="input-date datepicker item_date" value="<?php echo $enddate;?>" readonly="readonly" /></div>
		<div style="clear: both;"></div>
	</div>
    
    <!-- Time From -->
    <div class="fieldset2 whitebg">
		<label>
        	<span class="content-nav showDialogTimeCalendar" rel="fromtime"><span><?php echo $lang["CALENDAR_EVENT_TIME_FROM"];?></span></span>
		</label>
		<div class="dates"><input type="time" value="<?php echo $starttime;?>" name="fromtime" id="fromtime" readonly="readonly" />
        </div>
		<div style="clear: both;"></div>
	</div>
    
    <!-- Time To -->
    <div class="fieldset2 whitebg">
		<label>
        	<span class="content-nav showDialogTimeCalendar" rel="totime"><span><?php echo $lang["CALENDAR_EVENT_TIME_TO"];?></span></span>
		</label>
		<div class="dates"><input type="time" value="<?php echo $endtime;?>" name="totime" id="totime" readonly="readonly" /></div>
		<div style="clear: both;"></div>
	</div>
    
    <!-- Event All-Day -->
    <div id="allDayDisplay" class="fieldset2 whitebg" <?php echo $regularEventDisplay;?>>
		<label><?php echo $lang["CALENDAR_EVENT_ALL_DAY"];?></label>
		<div class="dates">
			<?php
            $allday_active = '';
            $active_val = '0';
            if($allday) { 
                $allday_active = 'active';
                $active_val = '1';
            }
            ?>
            <span rel="<?php echo $active_val; ?>" id="toggleAllDay" class="coCheckbox <?php echo $allday_active; ?>"></span>
            <input id="allday_checkbox" type="hidden" name="allday" value="<?php echo $active_val; ?>">
		</div>
		<div style="clear: both;"></div>
	</div>
    <!-- Desktop Reminder -->
    <div class="fieldset2 whitebg">
		<label><?php echo $lang["CALENDAR_EVENT_DESKTOP"];?></label>
		<div class="dates">
            <span rel="0" id="toggleDesktop" class="coCheckbox"></span>
            <input id="desktop_checkbox" type="hidden" name="desktop" value="0">
		</div>
		<div style="clear: both;"></div>
	</div>
    
    <!-- Copy Function -->
    <div class="fieldset2 whitebg fieldborder-bottom">
		<label>Kopieren</label>
		<div class="dates">
            <span rel="0" id="toggleCopy" class="coCheckbox"></span>
            <input id="copy_checkbox" type="hidden" name="copy_checkbox" value="0">
		</div>
		<div style="clear: both;"></div>
	</div>
    
    <!-- Description -->
    <div class="fieldset">
        <label><?php echo $lang["CALENDAR_EVENT_DESCRIPTION"];?></label>
        <textarea id="event-description" name="description"></textarea>
	</div>
 
    <div class="coButton-outer" style="float: left;"><span class="content-nav coButton" id="submitNewEvent" data-link="/"><?php echo $lang["GLOBAL_SAVE"];?></span></div>
	</form>
</div>
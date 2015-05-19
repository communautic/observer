<div id="calendar" class="app">
<div class="appSettingsPopup"><div class="head"><?php echo $lang["GLOBAL_SETTINGS"];?></div><div class="content"></div><div class="" style="background: #2d2d2d;"><div class="coButton-outer dark"><span class="showAllCalendars coButton dark">Alle</span></div></div></div>
<input name="calendar-current" id="calendar-current" type="hidden" value="" />
<div class="ui-layout-west">
<div class="radius-helper">
<?php include(CO_INC . "/view/logo.php"); ?>
	<div id="calendar1-outer">
    <h3 class="module-bg-active"><?php echo $lang["CALENDAR_CALENDARS"];?></h3>
    <div id="calendar1" class="module-bg-active">
    <div class="module-actions"><div class="sort-outer"><span class="sort" rel="1"></span></div></div>
    	<div class="module-inner west-ui-content">
        <div class="scrolling-content">
            <ul class="sortable"></ul>
        </div>
        </div>
	</div>
    </div>
</div>
</div>

<!-- center -->
<div class="ui-layout-center">
    <div class="center-north">
    	<div class="spinner"><img src="<?php echo CO_FILES;?>/img/waiting.gif" alt="Loading" width="16" height="16" /></div>
    	<div class="listClose"><span class="actionClose" title="<?php echo $lang["ACTION_CLOSE"];?>"></span></div>
    	<div id="app-top">
        <div id="calendar-top" class="titles">
        	<span class="top-headline"></span> &nbsp; <span class="top-subheadline"></span> &nbsp; <span class="top-subheadlineTwo"></span>
        </div>
        </div>
    </div>
	<div class="center-west">
		<ul id="calendarActions" class="ui-layout-content actionconsole">
        	<li class="listPrint"><span class="actionPrint" title="<?php echo $lang["ACTION_PRINT"];?>"></span></li>
        	<li class="listRefresh"><span class="actionRefresh" title="<?php echo $lang["ACTION_REFRESH"];?>"></span></li>
            <li class="listHelp"><span class="actionHelp" title="<?php echo $lang["ACTION_HELP"];?>"></span></li>
			<li class="listBin"><span class="actionBin" title="<?php echo $lang["ACTION_DELETE"];?>"></span></li>
		</ul>
	</div>
	<div class="center-center" id="calendar-right"></div><div id="dialog_holder"></div>
    <div class="appSettings" style="top: 76px;"></div><div class="appSettingsPopupContent" style="display: none;">
    
    </div>
    
    
</div>
</div>
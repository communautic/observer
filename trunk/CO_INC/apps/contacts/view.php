<div id="contacts" class="app">
<input name="contacts-current" id="contacts-current" type="hidden" value="" />
<div class="ui-layout-west">
<div class="radius-helper">
<?php include(CO_INC . "/view/logo.php"); ?>	
	<div id="contacts1-outer">
		<div id="contacts1">
			<div class="module-actions module-actions-modules"><div class="sort-outer"><span class="sort" rel="1"></span></div></div>
			<h3 rel="contacts"><?php echo $lang['CONTACTS_CONTACTS'];?></h3>    
            <div class="contacts1-content"><div class="scrolling-content">        
                <ul class="sortable" rel="contacts"><li></li></ul>
                </div>
            </div>
			<div class="module-actions module-actions-modules"><div class="sort-outer"><span class="sort" rel="1"></span></div></div>
			<h3 rel="groups"><?php echo $lang['CONTACTS_GROUPS'];?></h3>    
            <div class="contacts1-content"><div class="scrolling-content">        
                <ul class="sortable" rel="groups"><li></li></ul>
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
        <div id="contacts-top" class="titles">
        	<span class="top-headline"></span> &nbsp; <span class="top-subheadline"></span> &nbsp; <span class="top-subheadlineTwo"></span>
        </div>
        </div>
    </div>
    <div class="center-west">
        <ul id="contactsActions" class="ui-layout-content actionconsole">
           <li class="listNew"><span class="actionNew" title="<?php echo $lang["ACTION_NEW"];?>"></span></li>
			<li class="listPrint"><span class="actionPrint" title="<?php echo $lang["ACTION_PRINT"];?>"></span></li>
			<li class="listSend"><span class="actionSend" title="<?php echo $lang["ACTION_SENDTO"];?>"></span></li>
			<li class="listSendVcard"><span class="actionSendVcard" title="<?php echo $lang["ACTION_SENDTO"];?>"></span></li>
            <li class="listDuplicate"><span class="actionDuplicate" title="<?php echo $lang["ACTION_DUPLICATE"];?>"></span></li>
            <li class="listRefresh"><span class="actionRefresh" title="<?php echo $lang["ACTION_REFRESH"];?>"></span></li>
            <li class="listHelp"><span class="actionHelp" title="<?php echo $lang["ACTION_HELP"];?>"></span></li>
            <li class="listBin"><span class="actionBin" title="<?php echo $lang["ACTION_DELETE"];?>"></span></li>
        </ul>
    </div>
    <div class="center-center" id="contacts-right"></div>
    </div>
</div>
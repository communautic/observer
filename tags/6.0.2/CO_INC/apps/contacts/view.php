<div id="contacts" class="app">
<input name="contacts-current" id="contacts-current" type="hidden" value="" />
<div class="ui-layout-west">
<?php include(CO_INC . "/view/logo.php"); ?>	
<div id="contacts1-outer">
    <h3 class="module-bg-active"><?php echo CONTACTS_GROUPS;?></h3>
    <div id="contacts1" class="module-bg-active">
    	<div class="module-actions"><div class="sort-outer"><a href="#" class="sort" rel="1"></a></div><div class="filter-box-outer"><form action="#"><fieldset><input name="search" type="text" class="filter filter-box" value="" size="4" /></fieldset></form></div><div class="filter-search-outer"></div></div>
    	<div class="module-inner west-ui-content">
        <div class="scrolling-content">
        	<ul class="topul"><li><a href="#" rel="0" class="module-click"><span class="text"><?php echo CONTACTS_SYSTEM_GROUP;?></span></a></li></ul>
            <ul class="sortable sublist"><li></li></ul>
        </div>
        </div>
	</div>
    </div>
	<div id="contacts2-outer">
		<h3><?php echo CONTACTS_CONTACT_LIST;?></h3>
        <div id="contacts2">
        	<div class="module-actions"><div class="sort-outer"><a href="#" class="sort" rel="1"></a></div><div class="filter-box-outer"><form action="#"><fieldset><input name="search" type="text" class="filter filter-box" value="" size="4" /></fieldset></form></div><div class="filter-search-outer"></div></div>
    	<div class="module-inner west-ui-content">
            <div class="scrolling-content">
            <ul class="sortable"><li></li></ul>
            </div>
        </div>
        </div>
	</div>
</div>

    <!-- center -->
    <div class="ui-layout-center">
    <div class="center-north">
    	<div id="contacts-top">
        	<div class="top-headline"></div>
            <div class="top-subheadline"></div>
        </div>
        <div class="info-top"><img src="data/logo.jpg" border="0" /></div>
    </div>
    <div class="center-west">
        <ul id="contactsActions" class="ui-layout-content actionconsole">
            <li class="listNew"><a href="neu" class="actionNew" title="neu"></a></li>
            <li class="listPrint"><a href="drucken" class="actionPrint" title="drucken"></a></li>
            <li class="listSend"><a href="interface/delivery.php" class="actionSend" title="versenden"></a></li>
            <li class="listDuplicate"><a href="duplizieren" class="actionDuplicate" title="duplizieren"></a></li>
            <li class="listExport"><a href="export" class="actionExport" title="exportieren"></a></li>
            <li class="listImport"><a href="import" class="actionImport" title="importieren"></a></li>
            <li class="listEmpty"><a href="empty" class="actionEmpty" title="leeren"></a></li>
            <li class="listBin"><a href="löschen" class="actionBin" title="löschen"></a></li>
        </ul>
    </div>
    <div class="center-center" id="contacts-right"></div>
    </div>
</div>
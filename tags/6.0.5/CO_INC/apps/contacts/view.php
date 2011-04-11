<div id="contacts" class="app">
<input name="contacts-current" id="contacts-current" type="hidden" value="" />
<div class="ui-layout-west">
<?php include(CO_INC . "/view/logo.php"); ?>	
<div id="contacts1-outer">
    <h3 class="module-bg-active"><?php echo $lang['CONTACTS_GROUPS'];?></h3>
    <div id="contacts1" class="module-bg-active">
    	<div class="module-actions"><div class="sort-outer"><a href="#" class="sort" rel="1"></a></div><div class="filter-box-outer"><form action="#"><fieldset><input name="search" type="text" class="filter filter-box" value="" size="4" /></fieldset></form></div><div class="filter-search-outer"></div></div>
    	<div class="module-inner west-ui-content">
        <div class="scrolling-content">
        	<ul class="topul"><li><span rel="0" class="module-click"><span class="text"><?php echo $lang['CONTACTS_SYSTEM_GROUP'];?></span><span class="num" id="totalContacts">(<?php echo $contactsmodel->getNumAllContacts();?>)</span></span></li></ul>
            <ul class="sortable sublist"><li></li></ul>
        </div>
        </div>
	</div>
    </div>
	<div id="contacts2-outer">
		<h3><?php echo $lang['CONTACTS_CONTACTS'];?></h3>
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
           <li class="listNew"><span class="actionNew" title="<?php echo $lang["ACTION_NEW"];?>"></span></li>
			<li class="listPrint"><span class="actionPrint" title="<?php echo $lang["ACTION_PRINT"];?>"></span></li>
			<li class="listSend"><span class="actionSend" title="<?php echo $lang["ACTION_SENDTO"];?>"></span></li>
			<li class="listDuplicate"><span class="actionDuplicate" title="<?php echo $lang["ACTION_DUPLICATE"];?>"></span></li>
            <li class="listExport"><span class="actionExport" title="exportieren"></span></li>
            <li class="listImport"><span class="actionImport" title="importieren"></span></li>
            <li class="listEmpty"><span class="actionEmpty" title="leeren"></span></li>
            <li class="listBin"><span class="actionBin" title="<?php echo $lang["ACTION_DELETE"];?>"></span></li>
        </ul>
    </div>
    <div class="center-center" id="contacts-right"></div>
    </div>
</div>
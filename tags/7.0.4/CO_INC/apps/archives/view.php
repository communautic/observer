<div id="archives" class="app">
<div class="appSettingsPopup"><div class="head"><?php echo $lang["GLOBAL_SETTINGS"];?></div><div class="content"></div></div>
<input name="archives-current" id="archives-current" type="hidden" value="" />
<div class="ui-layout-west">
<div class="radius-helper"><img src="<?php echo CO_FILES;?>/img/border-radius-fix-bl.png" width="8" height="8" class="border-radius-fix-bl" alt=""/><img src="<?php echo CO_FILES;?>/img/border-radius-fix-br.png" width="8" height="8" class="border-radius-fix-br" alt=""/>
<?php include(CO_INC . "/view/logo.php"); ?>
	<div id="archives1-outer" class="firstLevelOuter">
    <h3 class="module-bg-active"><?php echo $lang["GLOBAL_MODULE"];?></h3>
    <div id="archives1" class="gradient module-bg-active">
    	<!--<div class="module-actions"><div class="sort-outer"><span class="sort" rel="1"></span></div></div>-->
    	<div class="module-inner west-ui-content">
        <div class="scrolling-content">
            <ul></ul>
        </div>
        </div>
	</div>
    </div>
	<div id="archives2-outer" class="secondLevelOuter">
		<h3><?php echo $lang["ARCHIVE_ARCHIVES"];?></h3>
        <div id="archives2" class="gradient">
    	<div class="module-inner west-ui-content">
            <div class="scrolling-content">
            <ul></ul>
            </div>
        </div>
        </div>
	</div>
    
    <div id="archives3-outer" class="thirdLevelOuter">
		<div id="archives3">
        	
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
        <div id="archives-top" class="titles">
        	<span class="top-headline"></span><span class="top-subheadline"></span><span class="top-subheadlineTwo"></span>
        </div>
        </div>
        <!--<div class="globalsearch">
        	<input class="globalSearch ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" rel="archives"><div class="global-search-outer"></div>
        </div>-->
    </div>
	<div class="center-west">
		<ul id="archivesActions" class="ui-layout-content actionconsole">
			<li class="listPrint"><span class="actionPrint" title="<?php echo $lang["ACTION_PRINT"];?>"></span></li>
			<li class="listSend"><span class="actionSend" title="<?php echo $lang["ACTION_SENDTO"];?>"></span></li>
            <li class="listArchiveDuplicate"><span class="actionArchiveDuplicate" title="<?php echo $lang["ACTION_ARCHIVE_DUPLICATE"];?>"></span></li>
            <li class="listRefresh"><span class="actionRefresh" title="<?php echo $lang["ACTION_REFRESH"];?>"></span></li>
            <li class="listArchiveRevive"><span class="actionArchiveRevive" title="<?php echo $lang["ACTION_ARCHIVE_REVIVE"];?>"></span></li>
            <li class="listHelp"><span class="actionHelp" title="<?php echo $lang["ACTION_HELP"];?>"></span></li>
            <li class="listBin"><span class="actionBin" title="<?php echo $lang["ACTION_DELETE"];?>"></span></li>
		</ul>
	</div>
	<div class="center-center" id="archives-right"></div>
</div>
</div>
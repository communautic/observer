<div id="publishers" class="app">
<input name="publishers-current" id="publishers-current" type="hidden" value="" />
<div class="ui-layout-west">
<div class="radius-helper"><img src="<?php echo CO_FILES;?>/img/border-radius-fix-bl.png" width="8" height="8" class="border-radius-fix-bl" alt=""/><img src="<?php echo CO_FILES;?>/img/border-radius-fix-br.png" width="8" height="8" class="border-radius-fix-br" alt=""/>
<?php include(CO_INC . "/view/logo.php"); ?>
	<div id="publishers1-outer">
		<div id="publishers1">
        	<?php foreach($publishers->modules as $module  => $value) {
					include_once("modules/".$module."/config.php");
					include_once("modules/".$module."/lang/" . $session->userlang . ".php");
					include_once("modules/".$module."/model.php");
					include_once("modules/".$module."/controller.php");
					?>
                    <div class="module-actions module-actions-modules"><?php if (${'publishers_'.$module.'_filter'} != 0) { ?><div class="sort-outer"><span class="sort" rel="1"></span></div><?php } ?></div>
					<h3 rel="<?php echo($module);?>"><?php echo(${'publishers_'.$module.'_name'});?></h3>
					<div class="publishers1-content"><div class="scrolling-content">        
                	<ul class="sortable" rel="<?php echo($module);?>"><li></li></ul>
                	</div>
            		</div>
			<?php } ?>
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
    	<div id="publishers-top" class="titles">
        	<span class="top-headline"></span><span class="top-subheadline"></span><span class="top-subheadlineTwo"></span>
        </div>
        </div>
    </div>
	<div class="center-west">
		<ul id="publishersActions" class="ui-layout-content actionconsole">
			<li class="listNew"><span class="actionNew" title="<?php echo $lang["ACTION_NEW"];?>"></span></li>
			<li class="listPrint"><span class="actionPrint" title="<?php echo $lang["ACTION_PRINT"];?>"></span></li>
			<li class="listSend"><span class="actionSend" title="<?php echo $lang["ACTION_SENDTO"];?>"></span></li>
			<li class="listDuplicate"><span class="actionDuplicate" title="<?php echo $lang["ACTION_DUPLICATE"];?>"></span></li>
            <li class="listRefresh"><span class="actionRefresh" title="<?php echo $lang["ACTION_REFRESH"];?>"></span></li>
            <li class="listBin"><span class="actionBin" title="<?php echo $lang["ACTION_DELETE"];?>"></span></li>
		</ul>
	</div>
	<div class="center-center" id="publishers-right"></div>
</div>
</div>
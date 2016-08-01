<div id="evals" class="app">
<input name="evals-current" id="evals-current" type="hidden" value="" />
<div class="ui-layout-west">
<div class="radius-helper"><img src="<?php echo CO_FILES;?>/img/border-radius-fix-bl.png" width="8" height="8" class="border-radius-fix-bl" alt=""/><img src="<?php echo CO_FILES;?>/img/border-radius-fix-br.png" width="8" height="8" class="border-radius-fix-br" alt=""/>
<?php include(CO_INC . "/view/logo.php"); ?>
	<div id="evals1-outer" class="firstLevelOuter">
    <h3 class="module-bg-active"><?php echo $lang["GLOBAL_FOLDERS"];?></h3>
    <div id="evals1" class="gradient module-bg-active">
		<div class="module-actions"><div class="sort-outer"><span class="sort" rel="1"></span></div></div>
        <div class="module-inner west-ui-content">
        <div class="scrolling-content">
            <ul class="sortable"><li></li></ul>
        </div>
        </div>
	</div>
    </div>
	<div id="evals2-outer" class="secondLevelOuter">
		<h3><?php echo $lang["EVAL_EVALS"];?></h3>
        <div id="evals2" class="gradient">
            <div class="module-actions"><div class="sort-outer"><span class="sort" rel="1"></span></div></div>
            <div class="module-inner west-ui-content">
            <div class="scrolling-content">
            <ul class="sortable"><li></li></ul>
            </div>
        </div>
        </div>
	</div>
	<div id="evals3-outer" class="thirdLevelOuter">
		<div id="evals3">
        	<?php 
				$i = 0;
				foreach($evals->modules as $module  => $value) {
					include_once("modules/".$module."/config.php");
					include_once("modules/".$module."/lang/" . $session->userlang . ".php");
					include_once("modules/".$module."/model.php");
					include_once("modules/".$module."/controller.php");
					?>
                    <div id="evals_<?php echo($module);?>" class="thirdLevel" style="top: <?php echo($i*27);?>px">
                        <div class="module-actions module-actions-modules"><?php if (${'evals_'.$module.'_filter'} != 0) { ?><div class="sort-outer"><span class="sort" rel="1"></span></div><?php } ?></div>
                        <h3 rel="<?php echo($module);?>"><?php echo(${'evals_'.$module.'_name'});?></h3>
                        <div class="numItems" id="<?php echo('evals_'.$module.'_items');?>"></div>
                        <div class="evals3-content"><div class="scrolling-content">        
                        <ul class="sortable" rel="<?php echo($module);?>"><li></li></ul>
                        </div>
                        </div>
                    </div>
			<?php 
			$i++;
			} ?>
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
    	<div id="evals-top" class="titles">
        	<span class="top-headline"></span><span class="top-subheadline"></span><span class="top-subheadlineTwo"></span>
        </div>
        </div>
        <div class="globalsearch">
        	<input class="globalSearch ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" rel="evals"><div class="global-search-outer"></div>
        </div>
    </div>
	<div class="center-west">
		<ul id="evalsActions" class="ui-layout-content actionconsole">
			<li class="listNew"><span class="actionNew" title="<?php echo $lang["ACTION_NEW"];?>"></span></li>
            <li class="listContact"><span class="actionContact" title="<?php echo $lang["ACTION_IMPORT"];?>"></span></li>
			<li class="listPrint"><span class="actionPrint" title="<?php echo $lang["ACTION_PRINT"];?>"></span></li>
			<li class="listSend"><span class="actionSend" title="<?php echo $lang["ACTION_SENDTO"];?>"></span></li>
			<li class="listDuplicate"><span class="actionDuplicate" title="<?php echo $lang["ACTION_DUPLICATE"];?>"></span></li>
            <li class="listHandbook"><span class="actionHandbook" title="<?php echo $lang["EVAL_HANDBOOK"];?>"></span></li>
            <li class="listRefresh"><span class="actionRefresh" title="<?php echo $lang["ACTION_REFRESH"];?>"></span></li>
            <li class="listHelp"><span class="actionHelp" title="<?php echo $lang["ACTION_HELP"];?>"></span></li>
            <li class="listBin"><span class="actionBin" title="<?php echo $lang["ACTION_DELETE"];?>"></span></li>
		</ul>
	</div>
	<div class="center-center" id="evals-right"></div>
</div>
<div id="modalDialogEvalsCreateExcel" title="Excel Export"></div>
</div>
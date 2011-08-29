<div id="projects" class="app">
<input name="projects-current" id="projects-current" type="hidden" value="" />
<div class="ui-layout-west">
<?php include(CO_INC . "/view/logo.php"); ?>
	<div id="projects1-outer">
    <h3 class="module-bg-active"><?php echo $lang["PROJECT_FOLDER"];?></h3>
    <div id="projects1" class="module-bg-active">
    	<div class="module-actions"><div class="sort-outer"><span class="sort" rel="1"></span></div><div class="filter-box-outer"><form action="#"><fieldset><input name="search" type="text" class="filter filter-box" value="" size="4" /></fieldset></form></div><div class="filter-search-outer"></div></div>
    	<div class="module-inner west-ui-content">
        <div class="scrolling-content">
            <ul class="sortable"><li></li></ul>
        </div>
        </div>
	</div>
    </div>
	<div id="projects2-outer">
		<h3><?php echo $lang["PROJECT_PROJECTS"];?></h3>
        <div id="projects2">
        	<div class="module-actions"><div class="sort-outer"><span class="sort" rel="1"></span></div><div class="filter-box-outer"><form action="#"><fieldset><input name="search" type="text" class="filter filter-box" value="" size="4" /></fieldset></form></div><div class="filter-search-outer"></div></div>
    	<div class="module-inner west-ui-content">
            <div class="scrolling-content">
            <ul class="sortable"><li></li></ul>
            </div>
        </div>
        </div>
	</div>
	<div id="projects3-outer">
		<div id="projects3">
        	<?php foreach($projects->modules as $module  => $value) {
					include_once("modules/".$module."/config.php");
					include_once("modules/".$module."/lang/" . $session->userlang . ".php");
					include_once("modules/".$module."/model.php");
					include_once("modules/".$module."/controller.php");
					?>
                    <div class="module-actions module-actions-modules"><?php if (${'projects_'.$module.'_filter'} != 0) { ?><div class="sort-outer"><span class="sort" rel="1"></span></div>
                    <div class="filter-box-outer"><form action="#"><fieldset><input name="search" type="text" class="filter filter-box" value="" size="4" /></fieldset></form></div><div class="filter-search-outer"></div><?php } ?></div>
					<h3 rel="<?php echo($module);?>"><?php echo(${'projects_'.$module.'_name'});?></h3>
					<div class="projects3-content"><div class="scrolling-content">        
                	<ul class="sortable" rel="<?php echo($module);?>"><li></li></ul>
                	</div>
            		</div>
			<?php } ?>
        </div>
    </div>
</div>

<!-- center -->
<div class="ui-layout-center">
    <div class="center-north">
    	<div id="projects-top">
        	<div class="top-headline"></div>
            <div class="top-subheadline"></div>
            <div class="top-subheadlineTwo"></div>
        </div>
        <div class="info-top"><img src="data/logo.jpg" border="0" /></div>
    </div>
	<div class="center-west">
		<ul id="projectsActions" class="ui-layout-content actionconsole">
			<li class="listNew"><span class="actionNew" title="<?php echo $lang["ACTION_NEW"];?>"></span></li>
			<li class="listPrint"><span class="actionPrint" title="<?php echo $lang["ACTION_PRINT"];?>"></span></li>
			<li class="listSend"><span class="actionSend" title="<?php echo $lang["ACTION_SENDTO"];?>"></span></li>
			<li class="listDuplicate"><span class="actionDuplicate" title="<?php echo $lang["ACTION_DUPLICATE"];?>"></span></li>
			<li class="listProjectHandbook"><span class="actionProjectHandbook" title="<?php echo $lang["PROJECT_HANDBOOK"];?>"></span></li>
            <li class="listRefresh"><span class="actionRefresh" title="<?php echo $lang["ACTION_REFRESH"];?>"></span></li>
            <li class="listBin"><span class="actionBin" title="<?php echo $lang["ACTION_DELETE"];?>"></span></li>
		</ul>
	</div>
	<div class="center-center" id="projects-right"></div>
</div>
</div>
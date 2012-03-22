<div id="bin" class="app">
<input name="bin-current" id="bin-current" type="hidden" value="" />
<div class="ui-layout-west">
<div class="radius-helper">
<?php include(CO_INC . "/view/logo.php"); ?>
	<div id="bin1-outer">
    <h3 class="module-bg-active"><?php echo $lang["BIN_FOLDER"];?></h3>
    <div id="bin1" class="module-bg-active">
    	<div class="module-inner west-ui-content">
        <div class="scrolling-content">
            <ul class="sortable">
            	<?php
				foreach($controller->applications as $app => $display) {
							if(${$app}->binDisplay) {
							echo('<li id="folderItem_"><span rel="' . $app . '" class="module-click"><span class="text">' . ${$app.'_name'} . '</span></span></li>');
							}
				}
				?>
            </ul>
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
        <div id="bin-top" class="titles">
        	<span class="top-headline"></span> &nbsp; <span class="top-subheadline"></span> &nbsp; <span class="top-subheadlineTwo"></span>
        </div>
        </div>
    </div>
	<div class="center-west">
		<ul id="binActions" class="ui-layout-content actionconsole">
        	<li class="listRefresh"><span class="actionRefresh" title="<?php echo $lang["ACTION_REFRESH"];?>"></span></li>
            <li class="listHelp"><span class="actionHelp" title="<?php echo $lang["ACTION_HELP"];?>"></span></li>
			<li class="listBin"><span class="actionBin" title="<?php echo $lang["ACTION_DELETE"];?>"></span></li>
		</ul>
	</div>
	<div class="center-center" id="bin-right"></div>
</div>
</div>
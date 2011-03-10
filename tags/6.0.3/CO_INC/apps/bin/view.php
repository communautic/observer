<div id="bin" class="app">
<input name="bin-current" id="bin-current" type="hidden" value="" />
<div class="ui-layout-west">
<?php include(CO_INC . "/view/logo.php"); ?>
	<div id="bin1-outer">
    <h3 class="module-bg-active"><?php echo $lang["BIN_FOLDER"];?></h3>
    <div id="bin1" class="module-bg-active">
    	<!--<div class="module-actions"><div class="sort-outer"><a href="#" class="sort" rel="1"></a></div><div class="filter-box-outer"><form action="#"><fieldset><input name="search" type="text" class="filter filter-box" value="" size="4" /></fieldset></form></div><div class="filter-search-outer"></div></div>-->
    	<div class="module-inner west-ui-content">
        <div class="scrolling-content">
            <ul class="sortable">
            	<?php
				foreach($controller->applications as $app => $display) {
							if(${$app}->binDisplay) {
							echo('<li id="folderItem_"><a href="#" rel="' . $app . '" class="module-click"><span class="text">' . ${$app.'_name'} . '</span></a></li>');
							}
				}
				?>
            </ul>
        </div>
        </div>
	</div>
    </div>
</div>

<!-- center -->
<div class="ui-layout-center">
    <div class="center-north">
    	<div id="bin-top">
        	<div class="top-headline"></div>
            <div class="top-subheadline"></div>
            <div class="top-subheadlineTwo"></div>
        </div>
        <div class="info-top"><img src="data/logo.jpg" border="0" /></div>
    </div>
	<div class="center-west">
		<ul id="binActions" class="ui-layout-content actionconsole">
			<li class="listBin"><a href="#" class="actionBin" title="<?php echo $lang["ACTION_DELETE"];?>"></a></li>
		</ul>
	</div>
	<div class="center-center" id="bin-right"></div>
</div>
</div>
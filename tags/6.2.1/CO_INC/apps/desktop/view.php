<div id="desktop" class="app">
<input name="desktop-current" id="desktop-current" type="hidden" value="desktop" />
<div class="topbar"><div class="topbar-logo"><a href="/" class="browseAway"><img src="<?php echo(CO_FILES);?>/img/co_logo.png" border="0" /></a>
    <div id="desktopSpinner" class="spinner"><img src="<?php echo CO_FILES;?>/img/waiting_dark.gif" alt="Loading" width="16" height="16" /></div>
    <div id="desktopLicense"><span class="small"><?php echo $lang["DESKTOP_LIZENSE"];?></span> <span class="large"><?php echo CO_LICENSE;?></span></div>
</div>
</div>
<div id="desktop-inner">
	<div id="desktopActions">
    	<div id="desktopActionsTrans"></div>
        <div style="position: relative">
        <div class="desktopActionOuter Left"><span id="desktopNewPostit" class="desktopAction"><div></div></span></div>
        <div class="desktopActionSpacer"></div>
        <div class="desktopActionOuter"><span id="desktopWidgetsRefresh" class="desktopAction"><div></div></span></div>
         <div class="desktopActionSpacer"></div>
        <div class="desktopActionOuter"><span id="desktopHelp" class="desktopAction actionHelp"><div></div></span></div>
        <div class="desktopActionSpacer"></div>
        <div class="desktopActionOuter Right"><span id="desktopActionsDrag" class="desktopAction actionDrag"><div></div></span></div>
        </div>
    </div>
    <div id="desktopPostIts"></div>
  	<div id="desktopcolumns" style="position: relative;">
        <ul id="column1" class="column"><?php $desktop->getColumnWidgets(1); ?></ul>
        <ul id="column2" class="column"><?php $desktop->getColumnWidgets(2); ?></ul>
        <ul id="column3" class="column"><?php $desktop->getColumnWidgets(3); ?></ul>
        <ul id="column4" class="column"><?php $desktop->getColumnWidgets(4); ?></ul>
	</div>
</div>
</div>
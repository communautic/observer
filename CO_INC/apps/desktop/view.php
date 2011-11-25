<div id="desktop" class="app" style="overflow: hidden; top: 0;">
<input name="desktop-current" id="desktop-current" type="hidden" value="desktop" />
<div class="topbar"><div class="spinner" style="display: none;"><img width="16" height="16" alt="Loading" src="<?php echo CO_FILES;?>/img/waiting.gif"></div><a href="#" id="widgetsRefresh">Refresh</a> <a href="#" class="addPostit">New Postit</a></div>
    <?php $desktop->getPostIts();?>
  <div id="desktopcolumns" style="position: relative;">
    <ul id="column1" class="column"><?php $desktop->getColumnWidgets(1); ?></ul>
    <ul id="column2" class="column"><?php $desktop->getColumnWidgets(2); ?></ul>
    <ul id="column3" class="column"><?php $desktop->getColumnWidgets(3); ?></ul>
    <ul id="column4" class="column"><?php $desktop->getColumnWidgets(4); ?></ul>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-title">
  <tr>
    <td nowrap="nowrap" class="tcell-left text11"><span class="content-nav-title"><?php echo $lang["CONTROLLING_STATUS"];?></span></td>
    <td></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scrolling-content">
<div style="height: 125px;" class="text11">
<div style="height: 26px;" class="tbl-inactive"></div>
<div style="position: relative; float: left; width: 150px; margin: -26px 9px 0 9px">
	<div style="height: 26px; background-color:#c3c3c3">
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px;" width="130"><?php echo $lang["CONTROLLING_PHASES_CREATED"];?></td>
    <td class="text11" style="padding: 3px 0 0 0"><?php echo($controlling->allphases);?></td>
  </tr>
</table>
</div>
    <div>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px" width="130"><?php echo $lang["CONTROLLING_PHASES_PLANNED"];?></td>
    <td class="text11" style="padding: 3px 0 0 0"><?php echo($controlling->plannedphases);?></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px" width="130"><?php echo $lang["CONTROLLING_PHASES_RUNNING"];?></td>
    <td class="text11" style="padding: 3px 0 0 0"><?php echo($controlling->inprogressphases);?></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px" width="130"><?php echo $lang["CONTROLLING_PHASES_FINISHED"];?></td>
    <td class="text11" style="padding: 3px 0 0 0"><?php echo $controlling->finishedphases;?></td>
  </tr>
</table>
    </div>
</div>
<?php  $this->getChart($controlling->id,'stability');?>
</div>

<div style="height: 125px;" class="text11">
<div style="height: 26px;" class="tbl-inactive"></div>
<?php  $this->getChart($controlling->id,'realisation');?>
<?php  $this->getChart($controlling->id,'timeing');?>
<?php  $this->getChart($controlling->id,'tasks');?>
</div>


</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo($lang["GLOBAL_FOOTER_STATUS"] . " " . $controlling->datetime);?></td>
    <td class="middle"></td>
    <td class="right"></td>
  </tr>
</table>
</div>
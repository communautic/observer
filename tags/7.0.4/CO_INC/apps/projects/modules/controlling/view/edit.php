<div class="table-title-outer">
<table border="0" cellspacing="0" cellpadding="0" class="table-title grey">
  <tr>
    <td nowrap="nowrap" class="tcell-left text11"><span class="content-nav-title"><?php echo $lang["PROJECT_CONTROLLING_STATUS"];?></span></td>
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
    <td class="text11" style="padding: 3px 0 0 8px;" width="120"><?php echo $lang["PROJECT_CONTROLLING_PHASES_CREATED"];?></td>
    <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo($controlling->allphases);?></td>
  </tr>
</table>
</div>
    <div>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px" width="120"><?php echo $lang["PROJECT_CONTROLLING_PHASES_PLANNED"];?></td>
    <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo($controlling->plannedphases);?></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px" width="120"><?php echo $lang["PROJECT_CONTROLLING_PHASES_RUNNING"];?></td>
    <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo($controlling->inprogressphases);?></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="text11" style="padding: 3px 0 0 8px" width="120"><?php echo $lang["PROJECT_CONTROLLING_PHASES_FINISHED"];?></td>
    <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo $controlling->finishedphases;?></td>
  </tr>
</table>
    </div>
</div>
<?php  $this->getChart($controlling->id,'stability');?>
<?php  $this->getChart($controlling->id,'status',0,1);?>
</div>

<div style="height: 125px;" class="text11">
<div style="height: 26px;" class="tbl-inactive"></div>
<?php  $this->getChart($controlling->id,'realisation');?>
<?php  $this->getChart($controlling->id,'timeing');?>
<?php  $this->getChart($controlling->id,'tasks');?>
</div>

<?php if($controlling->setting_costs) {?>
<div style="height: 125px;" class="text11">
<div style="height: 26px;" class="tbl-inactive"></div>
<!-- costs plan -->
<div style="position: relative; float: left; width: 150px; margin: -26px 9px 0 9px">
	<div style="height: 26px; background-color:#c3c3c3">
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <tr>
        <td class="text11" style="padding: 3px 0 0 8px;" width="120"><?php echo $lang["PROJECT_COSTS_PLAN"];?></td>
        <td class="text11" style="text-align: right; padding: 3px 7px 0 0">&nbsp;</td>
      </tr>
    </table>
    </div>
        <div>
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <tr>
        <td class="text11 bold" style="text-align: right; padding: 3px 7px 5px 8px;"><?php echo $controlling->setting_currency ;?> <?php echo number_format($controlling->costs_plan,0,',','.');?></td>
      </tr>
    </table>
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <tr>
        <td class="text11" style="padding: 3px 0 0 8px"><?php echo $lang["GLOBAL_COSTS_EMPLOYEES_SHORT"];?></td>
        <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo $controlling->setting_currency ;?> <?php echo number_format($controlling->costs_employees_plan,0,',','.');?></td>
      </tr>
    </table>
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <tr>
        <td class="text11" style="padding: 3px 0 0 8px"><?php echo $lang["GLOBAL_COSTS_MATERIAL_SHORT"];?></td>
        <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo $controlling->setting_currency ;?> <?php echo number_format($controlling->costs_materials_plan,0,',','.');?></td>
      </tr>
    </table>
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <tr>
        <td class="text11" style="padding: 3px 0 0 8px"><?php echo $lang["GLOBAL_COSTS_EXTERNAL_SHORT"];?></td>
        <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo $controlling->setting_currency ;?> <?php echo number_format($controlling->costs_external_plan,0,',','.');?></td>
      </tr>
    </table>
        <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <tr>
        <td class="text11" style="padding: 3px 0 0 8px"><?php echo $lang["GLOBAL_COSTS_OTHER_SHORT"];?></td>
        <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo $controlling->setting_currency ;?> <?php echo number_format($controlling->costs_other_plan,0,',','.');?></td>
      </tr>
    </table>
    </div>
</div>

<!-- costs real -->
<div style="position: relative; float: left; width: 150px; margin: -26px 9px 0 9px">
	<div style="height: 26px; background-color:#c3c3c3">
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <tr>
        <td class="text11" style="padding: 3px 0 0 8px;" width="120"><?php echo $lang["PROJECT_COSTS_REAL"];?></td>
        <td class="text11" style="text-align: right; padding: 3px 7px 0 0">&nbsp;</td>
      </tr>
    </table>
    </div>
        <div>
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <tr>
        <td class="text11 bold" style="text-align: right; padding: 3px 7px 5px 8px"><?php echo $controlling->setting_currency ;?> <?php echo number_format($controlling->costs_real,0,',','.');?></td>
      </tr>
    </table>
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <tr>
        <td class="text11" style="padding: 3px 0 0 8px"><?php echo $lang["GLOBAL_COSTS_EMPLOYEES_SHORT"];?></td>
        <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo $controlling->setting_currency ;?> <?php echo number_format($controlling->costs_employees_real,0,',','.');?></td>
      </tr>
    </table>
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <tr>
        <td class="text11" style="padding: 3px 0 0 8px"><?php echo $lang["GLOBAL_COSTS_MATERIAL_SHORT"];?></td>
        <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo $controlling->setting_currency ;?> <?php echo number_format($controlling->costs_materials_real,0,',','.');?></td>
      </tr>
    </table>
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <tr>
        <td class="text11" style="padding: 3px 0 0 8px"><?php echo $lang["GLOBAL_COSTS_EXTERNAL_SHORT"];?></td>
        <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo $controlling->setting_currency ;?> <?php echo number_format($controlling->costs_external_real,0,',','.');?></td>
      </tr>
    </table>
        <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <tr>
        <td class="text11" style="padding: 3px 0 0 8px"><?php echo $lang["GLOBAL_COSTS_OTHER_SHORT"];?></td>
        <td class="text11" style="text-align: right; padding: 3px 7px 0 0"><?php echo $controlling->setting_currency ;?> <?php echo number_format($controlling->costs_other_real,0,',','.');?></td>
      </tr>
    </table>
    </div>
</div>

<!-- costs stats -->
<div style="position: relative; float: left; width: 150px; margin: -26px 9px 0 9px">
	<div style="position: relative; height: 23px; background-color:#c3c3c3; padding: 3px 0 0 8px">Abweichung Plan/Ist<img src="<?php echo CO_FILES;?>/img/<?php echo $controlling->costs_tendency;?>" width="17" height="11" style="position:absolute; top: 8px; right: 8px;" /></div>
    <div>
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <tr>
        <td class="text11 bold <?php echo $controlling->stats_calc_class;?>" style="text-align: right; padding: 3px 7px 5px 8px;"><?php echo $controlling->setting_currency;?> <?php echo number_format($controlling->stats_calc,0,',','.');?></td>
      </tr>
    </table>
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <tr>
        <td class="text11" style="padding: 3px 0 0 8px"><?php echo $lang["GLOBAL_COSTS_EMPLOYEES_SHORT"];?></td>
        <td class="text11 <?php echo $controlling->stats_calc_employees_class;?>" style="text-align: right; padding: 3px 7px 0 0"><?php echo $controlling->setting_currency ;?> <?php echo number_format($controlling->stats_calc_employees,0,',','.');?></td>
      </tr>
    </table>
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <tr>
        <td class="text11" style="padding: 3px 0 0 8px"><?php echo $lang["GLOBAL_COSTS_MATERIAL_SHORT"];?></td>
        <td class="text11 <?php echo $controlling->stats_calc_materials_class;?>" style="text-align: right; padding: 3px 7px 0 0"><?php echo $controlling->setting_currency ;?> <?php echo number_format($controlling->stats_calc_materials,0,',','.');?></td>
      </tr>
    </table>
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <tr>
        <td class="text11" style="padding: 3px 0 0 8px"><?php echo $lang["GLOBAL_COSTS_EXTERNAL_SHORT"];?></td>
        <td class="text11 <?php echo $controlling->stats_calc_external_class;?>" style="text-align: right; padding: 3px 7px 0 0"><?php echo $controlling->setting_currency ;?> <?php echo number_format($controlling->stats_calc_external,0,',','.');?></td>
      </tr>
    </table>
        <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <tr>
        <td class="text11" style="padding: 3px 0 0 8px"><?php echo $lang["GLOBAL_COSTS_OTHER_SHORT"];?></td>
        <td class="text11 <?php echo $controlling->stats_calc_other_class;?>" style="text-align: right; padding: 3px 7px 0 0"><?php echo $controlling->setting_currency ;?> <?php echo number_format($controlling->stats_calc_other,0,',','.');?></td>
      </tr>
    </table>
    
    </div>
</div>

</div>
<?php } ?>
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
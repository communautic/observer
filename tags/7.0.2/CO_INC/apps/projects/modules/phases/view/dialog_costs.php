<div class="dialog-text">
<?php $ar = explode("-", $field); ?>
<input id="costsfield" type="hidden" value="<?php echo $ar[0];?>" />
<input id="coststaskid" type="hidden" value="<?php echo $ar[1];?>" />
<div style="height: 5px;"></div>
<div class="fieldset">
    <label><?php echo $lang['GLOBAL_COSTS_EMPLOYEES'];?></label>
    <input type="text" value="" maxlength="10" class="costs_employees currency" id="personal">
  </div>
  <div class="fieldset">
    <label><?php echo $lang['GLOBAL_COSTS_MATERIAL'];?></label>
    <input type="text" value="" maxlength="10" class="costs_materials currency">
  </div>
  <div class="fieldset">
    <label><?php echo $lang['GLOBAL_COSTS_EXTERNAL'];?></label>
    <input type="text" value="" maxlength="10" class="costs_external currency">
  </div>
  <div class="fieldset">
    <label><?php echo $lang['GLOBAL_COSTS_OTHER'];?></label>
    <input type="text" value="" maxlength="10" class="costs_other currency">
  </div>
  <div style="height: 5px;"></div>
</div>
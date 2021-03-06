<div class="head"><?php echo $lang["GLOBAL_EDIT"];?></div>
<div class="content">
  <div class="fieldset2">
    <label><?php echo $lang["GLOBAL_TITLE"];?></label>
    <input type="text" class="title" maxlength="60" value="" />
  </div>
  <div class="fieldset2 tohide">
    <label><span class="content-nav showDialog" request="getContactsDialog" field="coPopup-team" append="1"><span><?php echo $lang["GLOBAL_RESPONSIBILITY"];?></span></span></label>
    <div class="contacts">
      <div id="coPopup-team" class="itemlist-field"></div>
      <div id="coPopup-team_ct" class="itemlist-field"><a field="coPopup-team_ct" class="ct-content"></a></div>
    </div>
    <div style="clear: both;"></div>
  </div>
  <div class="fieldset2 tohide">
    <label><?php echo $lang['PROC_GRID_DURATION'];?></label>
    <input type="text" class="hours short" maxlength="3" value="" />
    <?php echo $lang['PROC_GRID_HOURS'];?></div>
  <div class="fieldset2 tohide">
    <label><?php echo $lang['PROC_GRID_COSTS_EMPLOYEES'];?></label>
    <input id="personal" type="text" class="costs_employees currency" maxlength="10" value="" />
  </div>
  <div class="fieldset2 tohide">
    <label><?php echo $lang['PROC_GRID_COSTS_MATERIAL'];?></label>
    <input type="text" class="costs_materials currency" maxlength="10" value="" />
  </div>
  <div class="fieldset2 tohide">
    <label><?php echo $lang['PROC_GRID_COSTS_EXTERNAL'];?></label>
    <input type="text" class="costs_external currency" maxlength="10" value="" />
  </div>
  <div class="fieldset2 tohide">
    <label><?php echo $lang['PROC_GRID_COSTS_OTHER'];?></label>
    <input type="text" class="costs_other currency" maxlength="10" value="" />
  </div>
  <div class="fieldset">
    <label><?php echo $lang['GLOBAL_DESCRIPTION'];?></label>
    <textarea class="text"></textarea>
  </div>
  <ul class="popupButtons">
    <li><a href="#" class="binItem alert" rel=""><?php echo $lang["GLOBAL_DELETE"];?></a></li>
  </ul>
</div>
<span class="arrow"></span>
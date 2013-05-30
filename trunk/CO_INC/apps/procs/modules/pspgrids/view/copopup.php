<div class="head"><?php echo $lang["GLOBAL_EDIT"];?></div>
<div class="content">

<div class="statusTabs tohide">
    	<ul>
        	<li><span class="left statusButton planned active coPopupStatus" rel="0"><?php echo $lang["GLOBAL_STATUS_PLANNED"];?></span></li>
            <li><span class="statusButton inprogress coPopupStatus" rel="1"><?php echo $lang["GLOBAL_STATUS_INPROGRESS"];?></span></li>
            <li><span class="right statusButton finished coPopupStatus" rel="2"><?php echo $lang["GLOBAL_STATUS_FINISHED"];?></span></li>
            <li></li>
		</ul></div>
    <div class="fieldset2 tohide" >
        <label id="msInit">Meilenstein</label>
        <div class="contacts">
            <div id="coPopupMS" class="" rel=""></div>
        </div>
        <div style="clear: both;"></div>
    </div>
    
  <div class="fieldset2">
    <label><?php echo $lang["GLOBAL_TITLE"];?></label>
    <input type="text" class="title" maxlength="40" value="" />
  </div>
  <div class="fieldset2">
    <label><span class="content-nav showDialog" request="getContactsDialog" field="coPopup-team" append="1"><span><?php echo $lang["GLOBAL_RESPONSIBILITY"];?></span></span></label>
    <div class="contacts">
      <div id="coPopup-team" class="itemlist-field"></div>
      <div id="coPopup-team_ct" class="itemlist-field"><a field="coPopup-team_ct" class="ct-content"></a></div>
    </div>
    <div style="clear: both;"></div>
  </div>
  <div class="fieldset2 tohide tohideMS">
    <label><?php echo $lang['PROC_PSPGRID_DURATION'];?></label>
    <input type="text" class="days short" maxlength="3" value="" />
    <?php echo $lang['PROC_PSPGRID_DAYS'];?></div>
  <div class="fieldset2 tohide tohideMS">
    <label><?php echo $lang['PROC_PSPGRID_COSTS_EMPLOYEES'];?></label>
    <input id="personal" type="text" class="costs_employees currency" maxlength="10" value="" />
  </div>
  <div class="fieldset2 tohide tohideMS">
    <label><?php echo $lang['PROC_PSPGRID_COSTS_MATERIAL'];?></label>
    <input type="text" class="costs_materials currency" maxlength="10" value="" />
  </div>
  <div class="fieldset2 tohide tohideMS">
    <label><?php echo $lang['PROC_PSPGRID_COSTS_EXTERNAL'];?></label>
    <input type="text" class="costs_external currency" maxlength="10" value="" />
  </div>
  <div class="fieldset2 tohide tohideMS">
    <label><?php echo $lang['PROC_PSPGRID_COSTS_OTHER'];?></label>
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
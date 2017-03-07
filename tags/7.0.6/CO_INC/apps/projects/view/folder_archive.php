<div class="table-title-outer">
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
	<tr>
		<td class="tcell-left text11"><span><span><?php echo $lang["GLOBAL_MODULE"];?></span></span></td>
		<td><?php echo $lang["PROJECT_PROJECTS"];?></td>
	</tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<div class="content-spacer"></div>
<div style="position: absolute; top: 0px; width: 100%; height: 110px; background: #c8ffff; border-bottom: 1px solid #ccc;">
   <table border="0" cellspacing="0" cellpadding="0" style="margin-left: 141px;">
       <tr>
           <td width="158"><span style="color: #666; font-size: 11px; line-height: 30px; padding-left: 11px;">Metatags</span></td>
           <!--<td width="79"><span style="color: #666; font-size: 11px; line-height: 30px;">alle Ordner</span></td>-->
           </tr>
       <tr>
           <td><input class="rounded" id="metaSearch" name="metaSearch" type="text" /></td>
           <!--<td></td>-->
           </tr>
   </table>
   <table border="0" cellspacing="0" cellpadding="0" style="margin-left: 141px;">
    <tr>
        <td width="158"><span style="color: #666; font-size: 11px; line-height: 30px; padding-left: 11px;">Titel</span></td>
        <td width="158"><span style="color: #666; font-size: 11px; line-height: 30px; padding-left: 11px;">Ordner</span></td>
        <td width="158"><span style="color: #666; font-size: 11px; line-height: 30px; padding-left: 11px;"><?php echo $lang["PROJECT_MANAGEMENT"];?></span></td>
        <td width="79"><span style="color: #666; font-size: 11px; line-height: 30px; padding-left: 11px;"><?php echo $lang["GLOBAL_TIME_FROM"];?></span></td>
        <td width="89"><span style="color: #666; font-size: 11px; line-height: 30px; padding-left: 11px;"><?php echo $lang["GLOBAL_TIME_TO"];?></span></td>
        <!--<td width="79"><span style="color: #666; font-size: 11px; line-height: 30px;">alle Ordner</span></td>-->
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><input class="rounded" id="titleSearch" name="titleSearch" type="text" /></td>
        <td><input class="rounded" id="folderSearch" name="folderSearch" type="text" /></td>
        <td><input id="archiveManagementField" name="who" type="text" class="inlineSearch" rel="projects" /><input name="who" type="hidden" id="calcWho" value="0" /></td>
        <td><input name="startdate" type="text" id="archiveStartDate" value="" class="inlineDatepicker" /></td>
        <td><input name="enddate" type="text" id="archiveEndDate" value="" class="inlineDatepicker" /><span rel="0" id="calcFolder" class="inlineCheckbox coCheckbox inline" style="display: none;"></span></td>
        <!--<td></td>-->
         <td><span id="archiveProjectsSearch" class="bold"><em><span class="contentArrow"></span> Suchen</em></span></td>
    </tr>
</table>
</div>
<div id="archiveSearchResult" style="position: absolute; top: 140px; bottom: 0; left: 0; right: 0px; overflow: auto;">

</div>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo($lang["GLOBAL_FOOTER_STATUS"] . " " . $folder->today);?></td>
    <td class="middle"></td>
    <td class="right"></td>
  </tr>
</table>
</div>
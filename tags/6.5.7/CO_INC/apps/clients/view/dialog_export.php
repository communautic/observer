<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-window">
	<tr>
		<td class="tcell-left text11"><span class="content-nav"><?php echo $lang["CLIENT_FOLDER"];?></span></td>
		<td class="tcell-right text13"><?php echo $folder->title;?></td>
	</tr>
	<tr>
		<td class="tcell-left text11"><a href="#" id="autoopenExportMenue" class="content-nav showDialog" request="getMenuesDialog" field="clientsExportMenue" append="0"><span>Men&uuml;</span></a></td>
		<td class="tcell-right text13"><div id="clientsExportMenue" class="itemlist-field"></div></td>
	</tr>
      </table>
<div class="content-spacer"></div>
    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
		<td width="80">&nbsp;</td>
		<td ><div class="coButton-outer"><span class="content-nav actionDoExport coButton"><?php echo $lang["GLOBAL_EXPORT"];?></span></div></td>
	</tr>
</table>

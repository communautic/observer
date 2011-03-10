<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-title">
  <tr>
    <td class="tcell-left text11 bold"><?php echo PHONECALL_TITLE;?></td>
	<td width="25">&nbsp;</td>
    <td><input type="text" name="title" class="title textarea-title" /></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scrolling-content">
<form action="<?php echo $this->form_url;?>" method="post" class="coform jNice">
<input type="hidden" id="poformaction" name="request" value="createNew">
<input type="hidden" name="id" value="<?php echo($phonecall->pid);?>">
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><?php echo PHONECALL_DATE;?></td>
		<td width="25">&nbsp;</td>
		<td class="tcell-right"><input name="phonecall_date" type="text" class="input-date datepicker phonecall_date" value="<?php echo($phonecall->phonecall_date)?>" /></td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
		<td class="tcell-left text11"><?php echo PHONECALL_TIME;?></td>
		<td width="25"><a href="time" class="showDialogTime" title="Zeit"></a></td>
		<td class="tcell-right"><input name="start_hour" type="text" class="input2" size="2" maxlength="2" onblur="checkTime(this.name);" />
:
  <input name="start_min" type="text" class="input2" size="2" maxlength="2" onblur="checkTime(this.name);"/>
-
<input name="end_hour" type="text" class="input2" size="2" maxlength="2" onblur="checkTime(this.name);" />
:
<input name="end_min" type="text" class="input2" size="2" maxlength="2" onblur="checkTime(this.name);" />
&nbsp;<?php echo PROTOCOL_UHR;?><?php echo PROTOCOL_DAUER;?>
<input name="length" type="text" class="input5" size="6" maxlength="5" onblur="checkTime(this.name);" /></td>
	</tr>
</table>
</form>
</div>
</div>
<div class="content-footer"></div>
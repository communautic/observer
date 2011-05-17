<div class="content-spacer"></div>
<form action="/" method="post" class="sendForm">
<input type="hidden"  name="path" value="<?php echo $form_url;?>">
<input type="hidden"  name="request" value="<?php echo $request;?>">
<input type="hidden" name="id" value="<?php echo $id;?>">
<input type="hidden" name="variable" value="<?php echo $variable;?>">
<table border="0" cellpadding="0" cellspacing="0" class="table-window">
	<tr>
		<td class="tcell-left text11"><a href="#" class="content-nav showDialog" request="getContactsDialog" field="to" append="1" offsetsubract="70"><span><?php echo $lang["GLOBAL_TO"];?></span></a></td>
		<td class="tcell-right text13"><div id="to" class="itemlist-field"><?php echo $to;?></div></td>
	</tr>
	<tr>
		<td class="tcell-left text11"><a href="#" class="content-nav showDialog" request="getContactsDialog" field="cc" append="1" offsetsubract="70"><span><?php echo $lang["GLOBAL_BCC"];?></span></a></td>
		<td class="tcell-right text13"><div id="cc" class="itemlist-field"><?php echo $cc;?></div></td>
	</tr>
     <tr>
        <td class="tcell-left text11"><span class="content-nav"><?php echo $lang["GLOBAL_SUBJECT"];?></span></td>
        <td><input type="text" id="subject" name="subject" value="<?php echo $subject;?>" /></td>
      </tr>
      </table>
<table border="0" cellpadding="0" cellspacing="0" class="table-window">
      <tr>
        <td class="tcell-left text11"><span class="content-nav"><?php echo $lang["GLOBAL_MESSAGE"];?></span></td>
      </tr>
      <tr>
        <td style="padding-left: 15px"><textarea name="body" id="sendToTextarea" rows="7"></textarea></td>
      </tr>
</table>
<div class="content-spacer"></div>
<div class="coButton-outer"><span class="content-nav actionSendForm coButton"><?php echo $lang["GLOBAL_SEND"];?></span></div>
</form>
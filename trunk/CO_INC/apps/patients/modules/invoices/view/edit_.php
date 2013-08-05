<div class="table-title-outer">
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span><span><?php echo $lang["PATIENT_INVOICE_TITLE"];?></span></span></td>
    <td><div class="textarea-title"><?php echo($invoice->title);?></div></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="coform jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($invoice->id);?>">
<input type="hidden" name="pid" value="<?php echo($invoice->pid);?>">
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left text11" style="padding: 8px 15px 8px 0;"><span><span>&nbsp;</span></span></td>
		<td class="tcell-right" style="padding-top: 10px;">&nbsp;</td>
        <td width="200" style="padding: 10px 0 0 0;"><table width="170" border="0" cellpadding="0" cellspacing="0" style="font-size: 12px;">
		    <tr>
		        <td align="center" class="text11">0</td>
		        <td align="center" class="text11">1</td>
		        <td align="center" class="text11">2</td>
		        <td align="center" class="text11">3</td>
		        <td align="center" class="text11">4</td>
		        <td align="center" class="text11">5</td>
		        </tr>
		    </table></td>
            <td width="50" style="padding: 10px 0 0 0;"><strong><span id="total_result"><?php echo $invoice->total_result;?></span>%</strong></td>
            <td width="100" style="padding: 10px 0 0 0;"><span class="text11">Zufriedenheit</span></td>
	</tr>
	<tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
    <tr>
		<td class="tcell-left text11" style="padding: 8px 15px 8px 0;"><span><span>&nbsp;</span></span></td>
		<td class="tcell-right" style="padding: 10px 0 0 0;"><span style="display: inline-block; width: 30px;" class="bold">1</span><?php echo $lang["PATIENT_INVOICE_QUESTION_1"];?></td>
        <td width="200" style="padding: 10px 0 0 0;"><div class="invoice-outer<?php if($invoice->canedit) { ?> active<?php } ?>">
        <?php for($i=0; $i<6; $i++) {
			$class = '';
			if($invoice->q1_selected != "" && $i == $invoice->q1_selected) {
				$class = 'active';
			}
			 echo '<span rel="q1" v="' . $i . '" class="' . $class . '"><div></div></span>';
		}
		?></div>
        </td>
         <td width="150" style="padding: 10px 0 0 0;"><span id="q1_result"><?php echo $invoice->q1_result;?></span>%</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
    <tr>
		<td class="tcell-left text11" style="padding: 8px 15px 8px 0;"><span><span>&nbsp;</span></span></td>
		<td class="tcell-right" style="padding: 10px 0 0 0;"><span style="display: inline-block; width: 30px;" class="bold">2</span><?php echo $lang["PATIENT_INVOICE_QUESTION_2"];?></td>
        <td width="200" style="padding: 10px 0 0 0;"><div class="invoice-outer<?php if($invoice->canedit) { ?> active<?php } ?>">
        <?php for($i=0; $i<6; $i++) {
			$class = '';
			if($invoice->q2_selected != "" && $i == $invoice->q2_selected) {
				$class = 'active';
			}
			 echo '<span rel="q2" v="' . $i . '" class="' . $class . '"><div></div></span>';
		}
		?></div>
        </td>
         <td width="150" style="padding: 10px 0 0 0;"><span id="q2_result"><?php echo $invoice->q2_result;?></span>%</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
    <tr>
		<td class="tcell-left text11" style="padding: 8px 15px 8px 0;"><span><span>&nbsp;</span></span></td>
		<td class="tcell-right" style="padding: 10px 0 0 0;"><span style="display: inline-block; width: 30px;" class="bold">3</span><?php echo $lang["PATIENT_INVOICE_QUESTION_3"];?></td>
        <td width="200" style="padding: 10px 0 0 0;"><div class="invoice-outer<?php if($invoice->canedit) { ?> active<?php } ?>">
        <?php for($i=0; $i<6; $i++) {
			$class = '';
			if($invoice->q3_selected != "" && $i == $invoice->q3_selected) {
				$class = 'active';
			}
			 echo '<span rel="q3" v="' . $i . '" class="' . $class . '"><div></div></span>';
		}
		?></div>
        </td>
         <td width="150" style="padding: 10px 0 0 0;"><span id="q3_result"><?php echo $invoice->q3_result;?></span>%</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
    <tr>
		<td class="tcell-left text11" style="padding: 8px 15px 8px 0;"><span><span>&nbsp;</span></span></td>
		<td class="tcell-right" style="padding: 10px 0 0 0;"><span style="display: inline-block; width: 30px;" class="bold">4</span><?php echo $lang["PATIENT_INVOICE_QUESTION_4"];?></td>
        <td width="200" style="padding: 10px 0 0 0;"><div class="invoice-outer<?php if($invoice->canedit) { ?> active<?php } ?>">
        <?php for($i=0; $i<6; $i++) {
			$class = '';
			if($invoice->q4_selected != "" && $i == $invoice->q4_selected) {
				$class = 'active';
			}
			 echo '<span rel="q4" v="' . $i . '" class="' . $class . '"><div></div></span>';
		}
		?></div>
        </td>
         <td width="150" style="padding: 10px 0 0 0;"><span id="q4_result"><?php echo $invoice->q4_result;?></span>%</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
    <tr>
		<td class="tcell-left text11" style="padding: 8px 15px 8px 0;"><span><span>&nbsp;</span></span></td>
		<td class="tcell-right" style="padding: 10px 0 0 0;"><span style="display: inline-block; width: 30px;" class="bold">5</span><?php echo $lang["PATIENT_INVOICE_QUESTION_5"];?></td>
        <td width="200" style="padding: 10px 0 0 0;"><div class="invoice-outer<?php if($invoice->canedit) { ?> active<?php } ?>">
        <?php for($i=0; $i<6; $i++) {
			$class = '';
			if($invoice->q5_selected != "" && $i == $invoice->q5_selected) {
				$class = 'active';
			}
			 echo '<span rel="q5" v="' . $i . '" class="' . $class . '"><div></div></span>';
		}
		?></div>
        </td>
         <td width="150" style="padding: 10px 0 0 0;"><span id="q5_result"><?php echo $invoice->q5_result;?></span>%</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
    <tr>
		<td class="tcell-left text11" style="padding: 8px 15px 8px 0;"><span><span>&nbsp;</span></span></td>
		<td class="tcell-right" style="padding: 10px 0 0 0;"><span style="display: inline-block; width: 30px;" class="bold">6</span><?php echo $lang["PATIENT_INVOICE_QUESTION_6"];?></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11" style="width: 165px;"><span class="content-nav selectTextarea"><span>&nbsp;</span></span></td>
        <td class="tcell-right"><?php if($invoice->canedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($invoice->invoice_text));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($invoice->invoice_text)));?><?php } ?>
        </td>
	</tr>
</table>
<?php if($invoice->perms != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="patientsinvoice_sendto">
        <?php 
			foreach($sendto as $value) { 
				if(!empty($value->who)) {
					echo '<div class="text11 toggleSendTo co-link">' . $value->who . ', ' . $value->date . '</div>' .
						 '<div class="SendToContent">' . $lang["GLOBAL_SUBJECT"] . ': ' . $value->subject . '<br /><br />' . nl2br($value->body) . '<br></div>';
				}
		 } ?></div>
        </td>
    </tr>
</table>
<?php } ?>
</form>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo($lang["GLOBAL_FOOTER_STATUS"] . " " . $invoice->today);?></td>
    <td class="middle"></td>
    <td class="right"></td>
  </tr>
</table>
</div>
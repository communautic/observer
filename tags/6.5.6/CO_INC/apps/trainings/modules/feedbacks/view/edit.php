<div class="table-title-outer">
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span><span><?php echo $lang["TRAINING_FEEDBACK_TITLE"];?></span></span></td>
    <td><div class="textarea-title"><?php echo($feedback->title);?></div></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="coform jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($feedback->id);?>">
<input type="hidden" name="pid" value="<?php echo($feedback->pid);?>">
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
            <td width="50" style="padding: 10px 0 0 0;"><strong><span id="total_result"><?php echo $feedback->total_result;?></span>%</strong></td>
            <td width="100" style="padding: 10px 0 0 0;"><span class="text11">Zufriedenheit</span></td>
	</tr>
	<tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
    <tr>
		<td class="tcell-left text11" style="padding: 8px 15px 8px 0;"><span><span>&nbsp;</span></span></td>
		<td class="tcell-right" style="padding: 10px 0 0 0;"><span style="display: inline-block; width: 30px;" class="bold">1</span><?php echo $lang["TRAINING_FEEDBACK_QUESTION_1"];?></td>
        <td width="200" style="padding: 10px 0 0 0;"><div class="feedback-outer<?php if($feedback->canedit) { ?> active<?php } ?>">
        <?php for($i=0; $i<6; $i++) {
			$class = '';
			if($feedback->q1_selected != "" && $i == $feedback->q1_selected) {
				$class = 'active';
			}
			 echo '<span rel="q1" v="' . $i . '" class="' . $class . '"><div></div></span>';
		}
		?></div>
        </td>
         <td width="150" style="padding: 10px 0 0 0;"><span id="q1_result"><?php echo $feedback->q1_result;?></span>%</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
    <tr>
		<td class="tcell-left text11" style="padding: 8px 15px 8px 0;"><span><span>&nbsp;</span></span></td>
		<td class="tcell-right" style="padding: 10px 0 0 0;"><span style="display: inline-block; width: 30px;" class="bold">2</span><?php echo $lang["TRAINING_FEEDBACK_QUESTION_2"];?></td>
        <td width="200" style="padding: 10px 0 0 0;"><div class="feedback-outer<?php if($feedback->canedit) { ?> active<?php } ?>">
        <?php for($i=0; $i<6; $i++) {
			$class = '';
			if($feedback->q2_selected != "" && $i == $feedback->q2_selected) {
				$class = 'active';
			}
			 echo '<span rel="q2" v="' . $i . '" class="' . $class . '"><div></div></span>';
		}
		?></div>
        </td>
         <td width="150" style="padding: 10px 0 0 0;"><span id="q2_result"><?php echo $feedback->q2_result;?></span>%</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
    <tr>
		<td class="tcell-left text11" style="padding: 8px 15px 8px 0;"><span><span>&nbsp;</span></span></td>
		<td class="tcell-right" style="padding: 10px 0 0 0;"><span style="display: inline-block; width: 30px;" class="bold">3</span><?php echo $lang["TRAINING_FEEDBACK_QUESTION_3"];?></td>
        <td width="200" style="padding: 10px 0 0 0;"><div class="feedback-outer<?php if($feedback->canedit) { ?> active<?php } ?>">
        <?php for($i=0; $i<6; $i++) {
			$class = '';
			if($feedback->q3_selected != "" && $i == $feedback->q3_selected) {
				$class = 'active';
			}
			 echo '<span rel="q3" v="' . $i . '" class="' . $class . '"><div></div></span>';
		}
		?></div>
        </td>
         <td width="150" style="padding: 10px 0 0 0;"><span id="q3_result"><?php echo $feedback->q3_result;?></span>%</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
    <tr>
		<td class="tcell-left text11" style="padding: 8px 15px 8px 0;"><span><span>&nbsp;</span></span></td>
		<td class="tcell-right" style="padding: 10px 0 0 0;"><span style="display: inline-block; width: 30px;" class="bold">4</span><?php echo $lang["TRAINING_FEEDBACK_QUESTION_4"];?></td>
        <td width="200" style="padding: 10px 0 0 0;"><div class="feedback-outer<?php if($feedback->canedit) { ?> active<?php } ?>">
        <?php for($i=0; $i<6; $i++) {
			$class = '';
			if($feedback->q4_selected != "" && $i == $feedback->q4_selected) {
				$class = 'active';
			}
			 echo '<span rel="q4" v="' . $i . '" class="' . $class . '"><div></div></span>';
		}
		?></div>
        </td>
         <td width="150" style="padding: 10px 0 0 0;"><span id="q4_result"><?php echo $feedback->q4_result;?></span>%</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
    <tr>
		<td class="tcell-left text11" style="padding: 8px 15px 8px 0;"><span><span>&nbsp;</span></span></td>
		<td class="tcell-right" style="padding: 10px 0 0 0;"><span style="display: inline-block; width: 30px;" class="bold">5</span><?php echo $lang["TRAINING_FEEDBACK_QUESTION_5"];?></td>
        <td width="200" style="padding: 10px 0 0 0;"><div class="feedback-outer<?php if($feedback->canedit) { ?> active<?php } ?>">
        <?php for($i=0; $i<6; $i++) {
			$class = '';
			if($feedback->q5_selected != "" && $i == $feedback->q5_selected) {
				$class = 'active';
			}
			 echo '<span rel="q5" v="' . $i . '" class="' . $class . '"><div></div></span>';
		}
		?></div>
        </td>
         <td width="150" style="padding: 10px 0 0 0;"><span id="q5_result"><?php echo $feedback->q5_result;?></span>%</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-inactive">
    <tr>
		<td class="tcell-left text11" style="padding: 8px 15px 8px 0;"><span><span>&nbsp;</span></span></td>
		<td class="tcell-right" style="padding: 10px 0 0 0;"><span style="display: inline-block; width: 30px;" class="bold">6</span><?php echo $lang["TRAINING_FEEDBACK_QUESTION_6"];?></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content tbl-protocol">
	<tr>
		<td class="tcell-left text11" style="width: 165px;"><span class="content-nav selectTextarea"><span>&nbsp;</span></span></td>
        <td class="tcell-right"><?php if($feedback->canedit) { ?><textarea name="protocol" class="elastic"><?php echo(strip_tags($feedback->feedback_text));?></textarea><?php } else { ?><?php echo(nl2br(strip_tags($feedback->feedback_text)));?><?php } ?>
        </td>
	</tr>
</table>
<?php if($feedback->perms != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="trainingsfeedback_sendto">
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
    <td class="left"><?php echo($lang["GLOBAL_FOOTER_STATUS"] . " " . $feedback->today);?></td>
    <td class="middle"></td>
    <td class="right"></td>
  </tr>
</table>
</div>
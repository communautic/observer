<div class="table-title-outer">
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($sketch->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["PATIENT_SKETCH_TITLE"];?></span></span></td>
    <td><input name="title" type="text" class="title textarea-title" value="<?php echo($sketch->title);?>" maxlength="100" /></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($sketch->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($sketch->id);?>">
<input type="hidden" name="pid" value="<?php echo($sketch->pid);?>">
<?php if($sketch->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span><?php echo $lang["GLOBAL_ALERT"];?></span></span></strong></td>
		<td class="tcell-right"><strong><?php echo $lang["GLOBAL_CONTENT_EDITED_BY"];?> <?php echo($sketch->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($sketch->checked_out_user_email);?>"><?php echo($sketch->checked_out_user_email);?></a>, <?php echo($sketch->checked_out_user_phone1);?></td>
    </tr>
</table>
<?php } ?>
			<div class="canvasToolsOuter" style="top: 0; position: relative; width: 100%; height: 60px; background: #fff;">
            
        <div class="canvasTools">
        	<?php if($sketch->canedit) { ?>
            <span class="addTool"></span>
            <span class="penTool active"></span>
            <span class="erasorTool"></span>
            <?php if($sketch->type == 2) { ?><span class="rotateTool"></span><?php } ?>
            <span class="clearTool"></span>
            <span class="undoTool"></span>
            <?php } ?>
        </div>
        </div>
        <?php
		switch($sketch->type) {
			case 0:
				$canvasDrawBG = '';
			break;
			case 1:
				$canvasDrawBG = 'style="background-image: url(' . CO_FILES . '/img/body.png); width: 1161px;"';
			break;
			case 2:
				$randy = md5( uniqid (rand(), 1) );
				$canvasDrawBG = 'style="background-image: url(/data/sketches/' . $sketch->type_image . '?'.$randy.'); width: 1161px;"';
				echo '<div id="imagepath" style="display: none;">' . $sketch->type_image . '</div>';
			break;
		}
		?>
        <div style="position: relative; width: 1162px; height: 402px; border-bottom: 1px solid #ccc; border-top: 1px solid #ccc; border-right: 1px solid #ccc; background-image: url('<?php echo CO_FILES; ?>/img/sketch_background.png');"><div class="canvasDivSketch" <?php echo $canvasDrawBG;?>>
                    <?php $i = 1; 
							$j = $sketch->diagnoses;
                        foreach($diagnose as $value) { 
							$active = '';
							if($i == 1) {
								$active = ' active';
							}
							//$curcol = ($i-1) % 10;
							$curcol = ($value->color) % 10;
							?>
                            <canvas <?php if($sketch->canedit) { ?>class="canvasDrawSketch"<?php } ?> id="c<?php echo $i;?>" width="1161" height="400" style="z-index: <?php echo $j;?>; position: absolute;" rel="<?php echo $value->id;?>" color="<?php echo $curcol;?>"></canvas>
                            <div id="dia-<?php echo $value->id;?>" style="z-index: 10<?php echo $i;?>; top: <?php echo $value->y;?>px; left: <?php echo $value->x;?>px;" class="loadCanvas circle circle<?php echo $curcol;?> <?php echo $active;?>" rel="<?php echo $i;?>"><div><?php echo $i;?></div></div>
                        <?php 
						$i++;
						$j--;
						} ?>
                    </div></div>
                    
                    <div id="canvasDivTextSketch" style="border-left: 1px solid #fff; background: #e5e5e5;"><?php 
					$i = 1;
                        foreach($diagnose as $value) { 
						$active = '';
							if($i == 1) {
								$active = ' active';
							}
							//$curcol = ($i-1) % 10;
							$curcol = ($value->color) % 10;
                            include("diagnose.php");
							$i++;
                         } ?></div>

<?php if($sketch->perms != "guest") { ?>
<div class="content-spacer"></div>
<table border="0" cellspacing="0" cellpadding="0" class="table-content">
	<tr>
	  <td class="tcell-left text11"><span class="<?php if($sketch->canedit) { ?>content-nav showDialog<?php } ?>" request="getAccessDialog" field="patientssketch_access" append="1"><span><?php echo $lang["GLOBAL_ACCESS"];?></span></span></td>
        <td class="tcell-right"><div id="patientssketch_access" class="itemlist-field"><div class="listmember" field="patientssketch_access" uid="<?php echo($sketch->access);?>" style="float: left"><?php echo($sketch->access_text);?></div></div><input type="hidden" name="sketch_access_orig" value="<?php echo($sketch->access);?>" /></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table-content">
	<tr>
		<td class="tcell-left-inactive text11"><?php echo $lang["GLOBAL_EMAILED_TO"];?></td>
		<td class="tcell-right-inactive tcell-right-nopadding"><div id="patientssketch_sendto">
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
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($sketch->edited_user.", ".$sketch->edited_date)?></td>
    <td class="middle"><?php echo $sketch->access_footer;?></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($sketch->created_user.", ".$sketch->created_date);?></td>
  </tr>
</table>
</div>
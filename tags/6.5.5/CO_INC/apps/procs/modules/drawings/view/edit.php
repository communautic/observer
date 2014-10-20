<div class="table-title-outer">
<table border="0" cellpadding="0" cellspacing="0" class="table-title">
  <tr>
    <td class="tcell-left text11"><span class="<?php if($drawing->canedit) { ?>content-nav focusTitle<?php } ?>"><span><?php echo $lang["PROC_DRAWING_TITLE"];?></span></span></td>
    <td><input name="title" type="text" class="title textarea-title" value="<?php echo($drawing->title);?>" maxlength="100" /></td>
  </tr>
</table>
</div>
<div class="ui-layout-content"><div class="scroll-pane">
<form action="/" method="post" class="<?php if($drawing->canedit) { ?>coform <?php } ?>jNice">
<input type="hidden" id="path" name="path" value="<?php echo $this->form_url;?>">
<input type="hidden" id="poformaction" name="request" value="setDetails">
<input type="hidden" name="id" value="<?php echo($drawing->id);?>">
<input type="hidden" name="pid" value="<?php echo($drawing->pid);?>">
<?php if($drawing->showCheckout) { ?>
<table id="checkedOut" border="0" cellpadding="0" cellspacing="0" class="table-content" style="background-color: #eb4600">
	<tr>
		<td class="tcell-left text11"><strong><span><span><?php echo $lang["GLOBAL_ALERT"];?></span></span></strong></td>
		<td class="tcell-right"><strong><?php echo $lang["GLOBAL_CONTENT_EDITED_BY"];?> <?php echo($drawing->checked_out_user_text);?></strong></td>
    </tr>
    <tr>
		<td class="tcell-left text11">&nbsp;</td>
		<td class="tcell-right white"><a href="mailto:<?php echo($drawing->checked_out_user_email);?>"><?php echo($drawing->checked_out_user_email);?></a>, <?php echo($drawing->checked_out_user_phone1);?></td>
    </tr>
</table>
<?php } ?>
        <div class="canvasToolsOuter">
        <div class="canvasTools">
        	<span class="addTool"></span>
            <span class="penTool active"></span>
            <span class="erasorTool"></span>
            <span class="clearTool"></span>
            <span class="undoTool"></span>
        </div>
        </div>
        <div class="canvasDiv">
                    <?php $i = 1; 
							$j = $drawing->diagnoses;
                        foreach($diagnose as $value) { 
							$active = '';
							if($i == 1) {
								$active = ' active';
							}
							$curcol = ($i-1) % 10;
							?>
                            <canvas class="canvasDraw" id="c<?php echo $i;?>" width="1200" height="1200" style="z-index: <?php echo $j;?>" rel="<?php echo $value->id;?>"></canvas>
                            <!--<div id="dia-<?php echo $value->id;?>" style="z-index: 10<?php echo $i;?>; top: <?php echo $value->y;?>px; left: <?php echo $value->x;?>px;" class="loadCanvas circle circle<?php echo $curcol;?> <?php echo $active;?>" rel="<?php echo $i;?>"><div><?php echo $i;?></div></div>->
                        <?php 
						$i++;
						$j--;
						} ?>
                    </div></div></td>
                	<!--<td valign="top" style=""><div id="canvasDivText" style="border-left: 1px solid #fff; background: #e5e5e5; height: 401px;"><?php 
					$i = 1;
                        foreach($diagnose as $value) { 
						$active = '';
							if($i == 1) {
								$active = ' active';
							}
							$curcol = ($i-1) % 10;
                            include("diagnose.php");
							$i++;
                         } ?></div>-->
			
            
        </div>
</form>
</div>
</div>
<div>
<table border="0" cellspacing="0" cellpadding="0" class="table-footer">
  <tr>
    <td class="left"><?php echo $lang["EDITED_BY_ON"];?> <?php echo($drawing->edited_user.", ".$drawing->edited_date)?></td>
    <td class="middle"><?php echo $drawing->access_footer;?></td>
    <td class="right"><?php echo $lang["CREATED_BY_ON"];?> <?php echo($drawing->created_user.", ".$drawing->created_date);?></td>
  </tr>
</table>
</div>
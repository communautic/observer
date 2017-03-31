<div class="head">Barzahlung</div>

<div class="BarzahlungenPopup content">
	<div class="inner" id="">
  	<table width="100%" cellspacing="0" cellpadding="0" border="0">
<?php

	$i = 1;
			foreach ($tasks as $task) {
				if($task->bar == 0) {
		echo '<tr><td valign="middle">'. $task->title. '</td><td valign="middle" width="35" align="right"><span class="toggleServiceTaskBarzahlung coCheckbox" rel="'.$task->id.'"></span></td></tr>' ;
				}
		$i++;
	}

?>
<tr><td valign="middle">&nbsp;</td><td valign="middle" width="35" align="right"><span class="toggleServiceAllTasksBarzahlung"><div class="coButton-outer dark"><span class="coButton dark">Alle</span></div></span></td></tr>
</table>


  <ul class="popupButtons">
    <li><a href="#" class="saveServiceTasksBarzahlung"><?php echo $lang["GLOBAL_SAVE"];?></a></li>
  </ul>
  </div>